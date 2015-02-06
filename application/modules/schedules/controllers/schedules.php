<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedules extends MY_Controller 
{
	public function index($userId = 0)
	{
		$actions = array();
		$actions["create_schedule"] = site_url("schedules/form");
		$actions["return_users"] = site_url("usersdata/index");
        
        if ($userId > 0){
            $this->session->set_userdata("userdata", $userId);
        }
		
		$data = array();
		$data["title"] = lang("Schedules");
		$this->view('list', $data, $actions);
	}
	
	public function consult($userId)
	{
        $this->session->set_userdata("userdata", $userId);
        
		$data = array();
		$data["title"] = lang("Schedules");
		$this->view('consult', $data, array());
	}
    
    private function getParameterListUser()
    {
        $this->load->helper('action');

        $model = new Model("Schedules", "s", array("id" => "id", 'date' => 'date'));
        $model->setNumerics(array("s.id"));
        
        $userData = new Model("UsersData", "ud", array());
        $userData->setRelation("user");
        $userData->setConditions(array("ud.id = " . $this->session->userdata("userdata")));
        
        $turn = new Model("Turns", "t", array("name" => "tname", "initialTime" => "initialTime", "endTime" => "endTime"));
        $turn->setRelation("turn");
        $turn->setTypesTime(array("initialTime", "endTime"));
        
        $relations = array();
        $relations[] = $userData;
        $relations[] = $turn;
        
        $this->model   = $model;
        $this->actions = array();
        $this->relations = $relations;
    }    
    
    public function getListUser()
    {
        $this->load->helper('permissions');
        $this->getParameterListUser();
        
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
            
            $fields = array_keys($this->model->getFields());
            
            foreach ($this->relations as $relation) {
                foreach (array_keys($relation->getFields()) as $field) {
                    $fields[] = $field;
                }
            }
            
            $typesTime = $this->model->getTypesTime();
            
            foreach ($this->relations as $relation) {
                foreach ($relation->getTypesTime() as $field) {
                    $typesTime[] = $field;
                }
            }
            
            foreach ($register as $aRegister){
                if ($aRegister instanceof DateTime){
                    $register[$cont] = $aRegister->format("Y-m-d");
                    
                    $aField = $fields[$cont];
                    
                    if (in_array($aField, $typesTime)){
                        $register[$cont] = $aRegister->format("H:i:s");
                    }
                    
                }
                $cont++;
            }
            
            $register[]  = $actions;
            $registers[] = $register;
        }

        $arrayData['aaData'] = $registers;
        echo json_encode($arrayData);
    }


	public function assign($userId)
	{
	    $this->loadRepository("Turns");
        
        $user = $this->em->find('models\UsersData', $userId);
		
		$actions = array();
		$actions["return_users"] = site_url("usersdata/index");
        
        $name = $user->getUser()->getName() . " " . $user->getUser()->getLastName();
        
		$data = array();
		$data["title"] = lang("Schedules") . " : " . $name;
		$data["user"] = $userId;
        $data["weekdays"]  = $this->config->config["weekdays"];
        $data["months"]    = $this->config->config["months"];
        $data["schedules"] = $user->getTurns();
        $data["turns"] = $this->Turns->findAll();
        
		$this->view('assign', $data, $actions);
	}
	
	public function setListParameters()
	{
        $this->load->helper('action');

        $model = new Model("Schedules", "s", array("id" => "id", 'date' => 'date'));
        $model->setNumerics(array("s.id"));
        
        $userData = new Model("UsersData", "ud");
        $userData->setRelation("user");
        $userData->setConditions(array("ud.id = " . $this->session->userdata("userdata")));
        
        $user = new Model("Users", "u", array("name" => "name"));
        $user->setRelation("user");
        $user->setModelJoin("ud");

        $turn = new Model("Turns", "t", array("name" => "tname"));
        $turn->setRelation("turn");
        
        $relations = array();
        $relations[] = $userData;
        $relations[] = $user;
        $relations[] = $turn;

        $actions = array();
        array_push($actions, new Action("schedules", "form", "edit"));        
        array_push($actions, new Action("schedules", "delete", "delete", false));        
        
        $this->model   = $model;
        $this->actions = $actions;
        $this->relations = $relations;
	}
    
    public function form ($identifier = 0)
    {
        $this->loadRepository("Turns");
        
        $id = ($this->input->post("id") > 0) ? $this->input->post("id") : 0;
        $date = $this->input->post('date');
		$turn = $this->input->post('turn');
		$user = $this->session->userdata("userdata");
        $turns = $this->Turns->findAll();
        
        if ($identifier > 0){
            $output = $this->rest->get('schedules/schedule/', array("id"=>$identifier));
   
            if ($output->status){
                $schedule    = $output->data;
                $date = $schedule->date;
				$turn = $schedule->turn->id;
                $id         = $schedule->id;
            }
        }
        
        $actions = array();
        $actions["return_schedule"] = site_url("schedules/index");
        
        $data = array();
        $data["title"]  = lang("Schedules");
        $data['date'] = $date;
		$data['turn'] = $turn;
		$data['user'] = $user;
		$data['turns'] = $turns;
        $data["id"] = $id;
        $this->view('form', $data, $actions);
    }
    
    public function persist ()
    {
        $data = array();
        $message = "";
        $error   = "";
        $output  = ""; 
        $id      = 0; 
        
        $this->form_validation->set_rules('date', 'lang:date', 'required');
		$this->form_validation->set_rules('turn', 'lang:turn', 'required');
		$this->form_validation->set_rules('user', 'lang:user', 'required');
                
        if ($this->form_validation->run($this)){
            if ($this->input->post("id") > 0){
                $output = $this->rest->post('schedules/schedule', $this->input->post()); 
            }else{
                $output = $this->rest->put('schedules/schedule', $this->input->post()); 
            }
            
            if (empty($output) == false){
                if ($output->status){
                    $message = ($this->input->post("id") > 0) ? lang('schedule_edition') : lang('schedule_creation');
                    $id = $output->id;
                }else{
                    $error = (isset($output->error)) ? $output->error : "";
                    $error = (empty($error) && isset($output->exist)) ? lang($output->exist) : ""; 
                }
            }
            
            if ($this->input->is_ajax_request() == false){
                $this->index();
            }
        }else{
            $error = validation_errors();
            if ($this->input->is_ajax_request() == false){
                $this->form();
            }
        }
        
        if ($this->input->is_ajax_request()){
            $data["message"] = $message;
            $data["error"]   = $error;
            $data["id"]   = $id;
            echo json_encode($data);
        }
    }

    public function delete()
    {
        $data    = array();
        $message = "";
        $warning = "";
        $error   = "";
        
        $output = $this->rest->delete('schedules/schedule', array("id"=>$this->input->post("id")));

        if ($output->status){
            $message = lang("schedule_delete");
        }else{
            $error = (isset($output->error)) ? $output->error : "";
            $warning = (isset($output->warning)) ? lang($output->warning) : "";
        }
        
        $data["message"] = $message;
        $data["warning"] = $warning;
        $data["error"]   = $error;
        echo json_encode($data);
    }
}