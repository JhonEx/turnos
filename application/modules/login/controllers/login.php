<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MY_Controller
{
    public $public = true;
    
    public function setListParameters(){}
    
    public function index ()
    {
        $this->loadRepository("Users");
        
        $check      = false;
        $email      = "";
        $password   = "";
        $cookie     = $this->config->item("sess_cookie_name");
        
        if (isset($_COOKIE[$cookie."_cookuser"]) && isset($_COOKIE[$cookie."_cookpass"])) {
            $email      = $_COOKIE[$cookie."_cookuser"];
            $password   = $_COOKIE[$cookie."_cookpass"];
            $check      = true;
            $user       = $this->Users->getUserByEmailPassword($email, $password);
            $exist      = (empty($user) == false);
            if ($exist == false) {
                $email      = "";
                $password   = "";
                $check      = false;
            }
        }
        
        $data = array();
        $data["title"]      = "My Skeleton";
        $data["check"]      = $check;
        $data["email"]      = $email;
        $data["password"]   = $password;
        $data["error"]      = $this->session->userdata(AuthConstants::ERROR_LOGIN);
        $this->viewLogin('login', $data);
    }
    
    public function auth ()
    {
        $this->session->set_userdata(AuthConstants::ERROR_LOGIN, "");
        
        $this->loadRepository("Users");
        
        $this->session->sess_destroy();
        $this->session->sess_create();
        
        $email      = $this->input->post("email");
        $password   = $this->input->post("password");
        $user       = $this->Users->getUserByEmailPassword($email, $password);
        
        if (empty($user) == false) {
            $language = ($user->getLanguage() != "") ? $user->getLanguage() : $this->config->item('language');
            $this->session->set_userdata(AuthConstants::USER_ID,    $user->getId());
            $this->session->set_userdata(AuthConstants::EMAIL,      $user->getEmail());
            $this->session->set_userdata(AuthConstants::NAMES,      $user->getName());
            $this->session->set_userdata(AuthConstants::LAST_NAMES, $user->getLastName());
            $this->session->set_userdata(AuthConstants::ADMIN,      $user->getAdmin());
            $this->session->set_userdata(AuthConstants::PROFILE,    $user->getProfile()->getId());
            $this->session->set_userdata(AuthConstants::LANG,       $language);
            
            $user->setLastAccess(new DateTime('now'));
            $this->em->persist($user);
            $this->em->flush();
            
            $remember = ($this->input->post('remember') == 1);
            $cookie   = $this->config->item("sess_cookie_name");

            if ($remember == false) {
                setcookie($cookie."_cookuser", "", -3600, "/");
                setcookie($cookie."_cookpass", "", -3600, "/");
            }

            if ($remember) {
                setcookie($cookie."_cookuser", $email, time() + 60 * 60 * 24 * 100, "/");
                setcookie($cookie."_cookpass", $password, time() + 60 * 60 * 24 * 100, "/");
            }
            
            redirect("/home/home/");
            
            exit();
        }
        
        $this->session->set_userdata(AuthConstants::ERROR_LOGIN, lang("error_login"));
        redirect("/login/index/");
    }
    
    public function logout ()
    {
        $this->session->sess_destroy();
        redirect("/login/index/");
    }
    
    public function resetPassword()
    {
        $json = array();
        
        try {
            
            $email = trim($this->input->post("user"));
            
            $this->loadRepository("Users");
            
            $user = $this->Users->findOneByEmail($email);
            
            $json["message"] = "ko";
            
            if ($user){
                $templates = $this->config->config['templates'];
                
                $password = Soporte::generaClave();
                
                $user->setPassword(md5($password));
                $this->em->persist($user);
                $this->em->flush();
                
                $global_merge_vars = array();
                $global_merge_vars["password"] = $password;
        
                $to = array();
                
                $to[$email] = $user->getName();
    
                $this->load->library("Mandrill");
                $mandrill = new Mandrill();
                $mandrill->setKey($this->config->item('apikey_mandril'));
                $mandrill->setTemplateName($templates['reset_password']);
                $mandrill->setSubject('Nueva contraseña');
                $mandrill->setFromEmail($this->config->item('email_from'));
                $mandrill->setFromName($this->config->item('email_from_name'));
                $mandrill->setGlobalMergeVars($global_merge_vars);
                $mandrill->setMergeVars(array());
                $mandrill->setTo($to);
        
                $mandrill->sendEmail($mandrill->getJson());
                
                $json["message"] = "ok";
            }
            
            echo json_encode($json);
        } catch (Exception $exc) {
            $json["message"] = $exc->getMessage();
            echo json_encode($json);
        }
    }
    
    public function setUp()
    {
        $profile = new models\Profiles();
        $profile->setName(AuthConstants::PROFILE_ADMIN);
        $profile->setDescription("This is the super admin.");
        $this->em->persist($profile);
        
        $user = new models\Users();
        $user->setName(AuthConstants::PROFILE_ADMIN);
        $user->setLastName(AuthConstants::PROFILE_ADMIN);
        $user->setEmail("admin@admin.com");
        $user->setPassword(md5("admin"));
        $user->setAdmin(AuthConstants::ADMIN_OK);
        $user->setProfile($profile);
        $user->setLanguage($this->config->config["language"]);
        $this->em->persist($user);
        
        $this->createPermissions();
        
        $this->load->helper("setup");
        $classes = getClassesFromFile();
        $this->setFileLanguage($classes);
    }

    public function createPermissions(){
        $this->load->helper("setup");
        $classes = getClassesFromFile();
        createPermissions($classes);
    }

    public function updatePermissions(){
        $this->load->helper("setup");
        $classes = getClassesFromFile();
        updatePermissions($classes);
    }
    
    private function setFileLanguage($classes){
        $DS = DIRECTORY_SEPARATOR;
        $pathLaguage = dirname(__FILE__) . $DS . ".." .$DS . ".." . $DS . ".." .$DS ."language" . $DS;
        $directories = Soporte::leeDirectorio($pathLaguage);
        
        foreach ($directories as  $key => $value){
            $content  = "<?php\n";
            
            foreach ($classes as $aClass => $methods){
                $content .= "\$lang['".$aClass."']='".$aClass."';\n";
                
                foreach ($methods as $aMethod){
                    $content .= "\$lang['".$aClass."_".$aMethod."']='".$aClass."_".$aMethod."';\n";
                }
            }
            
            $pathLang   = $pathLaguage . $key . $DS . "menu_lang.php";
            $file    = fopen($pathLang, "w");
            fwrite($file, $content);
            fclose($file);
        }
    }
}
