<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Doctrine\Common\Collections\Criteria;
abstract class MY_Controller extends MX_Controller
{
    protected $em;
    protected $model;
    protected $relations = array();
    protected $actions;
    
    abstract function setListParameters();

    public function __construct()
    {
        parent::__construct();
        $this->em = $this->doctrine->em;
        
        $lang = ($this->session->userdata(AuthConstants::LANG)) ? $this->session->userdata(AuthConstants::LANG) : $this->config->config["language"];
        
        $this->lang->load('general', $lang);
        $this->lang->load('menu', $lang);
        $this->setListParameters();
        
        $this->load->library('rest', array(  
            'http_user' => $this->config->config["http_user_api"],
            'http_pass' => $this->config->config["http_pass_api"],
            'http_auth' => $this->config->config["http_auth_api"],
            'server' =>  $this->config->config["server_api"],
        ));
    }
    
    public function viewLogin($view, $data)
    {
        $model = array();
        $model["header"]    = $this->load->view("admin_header", array("login"=>true), true);
        $model["footer"]    = "";
        $model["login"]     = true;
        $model["body"]      = $this->load->view($view, $data, true);
        $model["JS"]        = $this->getJS($view, $data);

        $this->load->view("admin_layout", $model);
    }

    public function view($view, $data, array $actions = array())
    {
        $this->load->helper('directory');
        $this->loadRepository("Permissions");
        
        $class      = strtolower($this->router->class);
        $method     = strtolower($this->router->method);
        $url        = $class."/".$method;
        $permission = $this->Permissions->findOneBy(array("url"=>$url));
        
        $section = array();
        $section["content"]    = $this->load->view($view, $data, true);
        $section["title"]      = $data["title"];
        $section["actions"]    = array();
        
        $profile = $this->session->userdata(AuthConstants::PROFILE);

        if ($profile  == AuthConstants::ID_PROFILE_ADMIN){
            $body= array();
            $body["sections"]   = "<div class='row-fluid'>".$this->load->view("admin_section", $section, true)."</div>";
            $body["title_menu"] = $data["title"];
            $body["csrf"]       = $this->config->config["csrf_token_name"];
            $body["menu"]       = $this->getMenu();
            $body["actions"]    = $actions;
        }else if ($profile != AuthConstants::ID_PROFILE_ADMIN){
            $body= array();
            $body["sections"]   = "<div class='row-fluid'>".$this->load->view("admin_section", $section, true)."</div>";
            $body["title_menu"] = $data["title"];
            $body["csrf"]       = $this->config->config["csrf_token_name"];
            $body["menu"]       = $this->getMenu($profile);
            $body["actions"]    = $actions;
        }
        
        $header = array();
        $header["full_name"] = $this->session->userdata(AuthConstants::NAMES) ." ". $this->session->userdata(AuthConstants::LAST_NAMES);

        $model = array();
        if ($profile  == AuthConstants::ID_PROFILE_ADMIN){
            $model["body"]      = $this->load->view("admin_body", $body, true);
            $model["header"]    = $this->load->view("admin_header", $header, true);
            $model["footer"]    = $this->load->view("admin_footer", null, true);
            $model["JS"]        = $this->getJS($view, $data);
            $this->load->view("admin_layout", $model);
        }else if ($profile != AuthConstants::ID_PROFILE_ADMIN){
            $model["body"]      = $this->load->view("admin_body", $body, true);
            $model["header"]    = $this->load->view("admin_header", $header, true);
            $model["footer"]    = $this->load->view("admin_footer", null, true);
            $model["JS"]        = $this->getJS($view, $data);
            $this->load->view("admin_layout", $model);
        }
    }

    public function viewSections($views, array $actions = array())
    {
        $this->load->helper('directory');
        $this->loadRepository("Permissions");
        
        $class      = strtolower($this->router->class);
        $method     = strtolower($this->router->method);
        $url        = $class."/".$method;
        $permission = $this->Permissions->findOneBy(array("url"=>$url));
        
        $sections   = "";
        $js         = "";
        $titleMenu  = "";
        
        $cols = 0;
        
        foreach ($views as $view => $dataSection) {
            $span = (isset($dataSection["span"])) ? $dataSection["span"] : 12;
            $cols += $span;
            
            if ($titleMenu == "" && key_exists("title", $dataSection)){
                $titleMenu = $dataSection["title"];
            }
            
            if (isset($dataSection["actions"]) == false){
                $dataSection["actions"] = array();
            }
            
            $dataSection["csrf"]   = $this->config->config["csrf_token_name"];
            
            $section = array();
            $section["content"] = $this->load->view($view, $dataSection, true);
            $section["title"]   = $dataSection["title"];
            $section["span"]    = $span;
            $section["box"]     = true;
            
            $sections   .= $this->load->view("admin_section", $section, true);
            $js         .= $this->getJS($view, $dataSection);
            
            if ($cols % 12 == 0){
                $sections .= "</div>";
                $sections .= "<div class='row'>";
            }
            
        }
        
        $profile = $this->session->userdata(AuthConstants::PROFILE);
        
        $body= array();
        $body["sections"]   = $sections;
        $body["title"]      = $titleMenu;
        $body["csrf"]       = $this->config->config["csrf_token_name"];
        $body["actions"]    = $actions;
        
        $body["menu"]   = $this->getMenu();
        
        $header = array();
        $header["full_name"] = $this->session->userdata(AuthConstants::NAMES) ." ". $this->session->userdata(AuthConstants::LAST_NAMES);

        $model = array();
        
        
        if ($profile  == AuthConstants::ID_PROFILE_ADMIN){
            $model["body"]      = $this->load->view("admin_body", $body, true);
            $model["header"]    = $this->load->view("admin_header", $header, true);
            $model["footer"]    = $this->load->view("admin_footer", null, true);
            $model["JS"]        = $js;
            $this->load->view("admin_layout", $model);
        }else if ($profile  != AuthConstants::ID_PROFILE_ADMIN){
            $model["body"]      = $this->load->view("body", $body, true);
            $model["header"]    = $this->load->view("header", $header, true);
            $model["footer"]    = $this->load->view("footer", null, true);
            $model["JS"]        = $js;
            $this->load->view("layout", $model);
        }
    }

    public function getMenu($id = "menu")
    {
        $menuSession = false;
        $return = "";
                
        $this->loadRepository("Permissions");
        $this->loadRepository("Sections");
        
        $menu = new Menu();
        $admin = $this->session->userdata(AuthConstants::ADMIN);
        $sections = $this->Sections->findBy(array(), array('position' => 'ASC'));
        
        foreach ($sections as $aSection) {
            if ($admin == AuthConstants::ADMIN_KO){
                $idProfile = $this->session->userdata(AuthConstants::PROFILE);
                $profile = $this->em->find('models\Profiles', $idProfile);
                $allPermissions = $profile->getPermissions();
                $allPermissions->setInitialized(true);

                $criteria = Criteria::create()
                    ->where(Criteria::expr()->eq("in_menu", AuthConstants::YES))
                    ->andWhere(Criteria::expr()->eq("section", $aSection))
                    ->orderBy(array("position" => "ASC"));

                $permissions = $allPermissions->matching($criteria);
            }
            
            if ($admin == AuthConstants::ADMIN_OK){
                $permissions   = $this->Permissions->findBy(array("in_menu"=>AuthConstants::YES, "section"=>$aSection->getId()), array('position' => 'ASC'));
            }
            
            foreach ($permissions as $aPermission) {
                $menu->anyadeItem(lang($aSection->getLabel()), lang($aPermission->getLabel()), site_url($aPermission->getUrl()));
            }
        }
        
        $return = $menu->toXHTML($id);
        
        return $return;
    }

    public function getUserMenu($profile)
    {
        $return = "";
        
        $options = array();
        
        if ($profile == AuthConstants::ID_PROFILE_WORKSHOP_ADMIN){
            $reports = array();
            $reports["Reports_byservice"] = site_url("reports/byService");
            $reports["Reports_tracking"] = site_url("reports/tracking");
            
            $options["appointments"] = site_url("/appointments/");
            $options["reports"] = $reports;
            $options["workshops"] = site_url("/workshops/");
            $options["services"] = site_url("/services/");
        }

        if ($profile == AuthConstants::ID_PROFILE_ATTENDANT){
            $options["appointments"] = site_url("/appointments/");
            $options["workshops"] = site_url("/workshops/");
        }
        
        $return .= Soporte::abreTag("div", 'class="row-fluid" id="menu"');
        $allSubmenu = "";
        
        $span = 12 / count($options);
        $subspan = 0;
        foreach($options as $key => $value){
            $url = (is_array($value)) ? "#" : $value;
            $return .= Soporte::creaEnlaceTexto(lang($key), $url, "class='text-white span".$span." my-span".$span."' id='menu-".$key."'");
            
            $submenu = "";
            if (is_array($value)){
                $subspan = 12 / (count($value) + 2);
                $submenu .= Soporte::creaTag("span", "", "class='text-white span".$subspan." my-span".$subspan." hidden-phone'");
                foreach($value as $subkey => $subvalue){
                    $submenu .= Soporte::creaEnlaceTexto(lang($subkey), $subvalue, "class='text-white span".$subspan." my-span".$subspan."'");
                }
                $submenu .= Soporte::creaTag("span", "", "class='text-white span".$subspan." my-span".$subspan." hidden-phone'");
            }
            
            if (Soporte::contieneValor($submenu)){
                $return .= Soporte::abreTag("div", "class='row-fluid' style='display:none' id='submenu-phone'");
                $return .= $submenu;
                $return .= Soporte::cierraTag("div");
                $allSubmenu = $submenu;
            }
        }

        $return .= Soporte::abreTag("div", "class='row-fluid' style='display:none' id='submenu'");
        $return .= $allSubmenu;
        $return .= Soporte::cierraTag("div");
        
        $return .= Soporte::cierraTag("div");
        
        return $return;    
    } 
    
    public function loadRepository($repository){
        if (isset($this->$repository) == false){
            $this->$repository = $this->em->getRepository('models\\'.$repository);
        }
    }
    
    public function getList()
    {
        $this->load->helper('permissions');
        $getData = $this->input->get();

        $arrayData  = $this->datatable->getData($getData, $this->model, $this->relations);
        $registers  = array();

        foreach ($arrayData['aaData'] as $register) {

            $actions = "";
            
            foreach ($this->actions as $aAction){
                if (hasRights($aAction->getMethod(), $aAction->getClass())){
                    $url = $aAction->getUrl();
                    $urlStr = "#";
                    
                    if ($url){
                        $urlStr = site_url($aAction->getClass() . "/" . $aAction->getMethod()). "/" . $register[0];
                    }
                    
                    $trans      = (Soporte::cadenaVacia(lang($aAction->getLabel())) == false) ? lang($aAction->getLabel()) : lang(ucfirst($aAction->getLabel()));
                    $label      = "title='" . $trans . "'";
                    $class      = "class='action_list action_" . $aAction->getLabel() . "'";
                    $id         = "id='".$register[0]."'";
                    $parameters = $label . " " . $class . " " . $id;
                    $actions   .= Soporte::creaEnlaceTexto("", $urlStr, $parameters);
                }
            }
            
            $cont = 0;
            foreach ($register as $aRegister){
                if ($aRegister instanceof DateTime){
                    $register[$cont] = $aRegister->format("Y-m-d");
                }
                $cont++;
            }
            
            $register[]  = $actions;
            $registers[] = $register;
        }

        $arrayData['aaData'] = $registers;
        echo json_encode($arrayData);
    }
    
    protected function getJS ($view, $data)
    {
        $return = "";
        
        $DS     = DIRECTORY_SEPARATOR;
        $module = $this->router->module;
        $pathJS = APPPATH .$DS. "modules" .$DS. $module .$DS. "views" .  $DS . "js" . $DS . $view . ".php";
        
        if (file_exists($pathJS)){
            $return = $this->load->view("js/".$view, $data, true);
        }
        
        return $return;
    }
}
