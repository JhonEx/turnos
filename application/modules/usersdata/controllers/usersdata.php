<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UsersData extends MY_Controller 
{
	public function index()
	{
		$actions = array();
		$actions["create_user"] = site_url("usersdata/form");
		
		$data = array();
		$data["title"] = lang("Users");
		$this->view('list', $data, $actions);
	}
	
	public function setListParameters()
	{
        $this->load->helper('action');
        
        $model = new Model("UsersData", "ud", array("id"=>"id", "identification"=>"identification", "telephone" => "telephone"));
        $model->setNumerics(array("ud.id"));
        
        $user = new Model("Users", "u", array("name"=>"name", "last_name"=>"last_name", "email"=>"email"));
        $user->setNumerics(array("u.id"));
        $user->setRelation("user");
        
        $profile = new Model("Profiles", "p");
        $profile->setRelation("profile");
        $profile->setModelJoin("u");
        
        $relations = array();
        array_push($relations, $user);
        array_push($relations, $profile);
        
        $actions = array();
        array_push($actions, new Action("usersdata", "form", "edit"));        
        array_push($actions, new Action("schedules", "assign", "turns"));        
        array_push($actions, new Action("usersdata", "report", "extra"));        
        array_push($actions, new Action("usersdata", "delete", "delete", false));        
        
        $this->model     = $model;
        $this->actions   = $actions;
        $this->relations = $relations;
	}
	
    public function form ($identifier = 0)
    {
        $this->loadRepository("Profiles");
        
        $id         = ($this->input->post("id") > 0) ? $this->input->post("id") : 0;
        $userId     = 0;
        $language   = $this->input->post("language");
        $name       = $this->input->post("name");
        $lastName   = $this->input->post("lastName");
        $email      = $this->input->post("email");
        $identification = $this->input->post("identification");
        $telephone  = $this->input->post("telephone");
        
        if ($identifier > 0){
            $output = $this->rest->get('usersdata/userdata/', array("id"=>$identifier));

            if ($output->status){
                $user       = $output->data;
                $userId     = $user->user->id;
                $language   = $user->user->language;
                $name       = $user->user->name;
                $lastName   = $user->user->last_name;
                $email      = $user->user->email;
                $language   = $user->user->language;
                $id         = $user->id;
                $identification = $user->identification;
                $telephone  = $user->telephone;
                
            }
        }

        $actions = array();
        $actions["return_user"] = site_url("usersdata/index");
        
        $data = array();
        $data["title"]      = lang("Users");
        $data["language"]   = $language;
        $data["name"]       = $name;
        $data["last_name"]  = $lastName;
        $data["email"]      = $email;
        $data["id"]         = $id;
        $data["identification"] = $identification;
        $data["telephone"]  = $telephone;
        $data["languages"]  = $this->config->config["languages"];
        
        $this->view('form', $data, $actions);
    }
    
    public function persist ()
    {
        $this->loadRepository("Users");
        $data = array();
        $message = "";
        $error   = "";
        $output  = ""; 
        
        $this->form_validation->set_rules('name', 'lang:name', 'required');
        $this->form_validation->set_rules('lastName', 'lang:last_name', 'required');
        $this->form_validation->set_rules('email', 'lang:email', 'required|callback_existUser['.$this->input->post("id").']');
        $this->form_validation->set_message('existUser', lang('user_exist'));
        $this->form_validation->set_rules('identification', 'lang:identification', 'required');
        $this->form_validation->set_rules('telephone', 'lang:telephone', 'required');
        
        if ($this->form_validation->run($this)){
            if ($this->input->post("id") > 0){
                $output = $this->rest->post('usersdata/userdata', $this->input->post()); 
            }else{
                $output = $this->rest->put('usersdata/userdata', $this->input->post()); 
            }
            
            if (empty($output) == false){
                if ($output->status){
                    $message = ($this->input->post("id") > 0) ? lang('user_edition') : lang('user_creation');
                }else{
                    $error = (isset($output->error)) ? $output->error : "";
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
            echo json_encode($data);
        }
    }
    
    public function existUser($email, $id)
    {
        $output = $this->rest->get('usersdata/exist_user', array("id"=>$id, "email"=>$email)); 
        return $output->exist;
    }
    
    public function delete ()
    {
        $data    = array();
        $message = "";
        $warning = "";
        $error   = "";
        
        $output = $this->rest->delete('usersdata/userdata', array("id"=>$this->input->post("id")));
        
        if ($output->status){
            $message = lang("user_delete");
        }else{
            $error = (isset($output->error)) ? $output->error : "";
            $warning = (isset($output->warning)) ? lang($output->warning) : "";
        }
        
        $data["message"] = $message;
        $data["warning"] = $warning;
        $data["error"]   = $error;
        echo json_encode($data);
    }
    
    public function report($userId)
    {
        $actions = array();
        $actions["return_user"] = site_url("usersdata/index");
        
        $user = $this->em->find('models\UsersData', $userId);
        $name = $user->getUser()->getName() . " " . $user->getUser()->getLastName();
        
        $data = array();
        $data["title"] = lang("Report") . " : " . $name;
        $data["user"] = $userId;
        
        $this->view('report', $data, $actions);      
    }
    
    public function getReport()
    {
        $return = array();    
            
        $userId = $this->input->post("user");
        $initDate = $this->input->post("init_date");
        $endDate = $this->input->post("end_date");
        
        $user = $this->em->find('models\UsersData', $userId);
        $turns = $user->getTurns();
        
        $this->loadRepository('Holidays');
        foreach ($turns as $aTurn) {
            if (strtotime($aTurn->getDate()->format("Y-m-d")) >= strtotime($initDate) && strtotime($aTurn->getDate()->format("Y-m-d")) <= strtotime($endDate)){
                $difference = $this->differenceByHour($aTurn);
                
                $row = array();
                $row["schedule"] = $aTurn->toArray();
                $row["extra"] = ($difference > 8) ? $difference - 8 : 0;
                $row["hours"] = $difference;
                $row["holiday"] = ($this->Holidays->findOneByDate($aTurn->getDate())) ? lang("yes") : lang("no");
                $return[] = $row;
            }
        }
        
        echo json_encode($return);
    }
    
    public function differenceByHour(models\Schedules $schedule)
    {
        $turn = $schedule->getTurn();
        
        $initDate = strtotime($turn->getInitialTime()->format("H:i:s"));
        $endDate = strtotime($turn->getEndTime()->format("H:i:s"));
        
        $difference = abs($initDate - $endDate) / 3600;
        
        return floor($difference);
    }
    
    public function chart()
    {
        $data = array();
        $data["title"] = lang("Chart");
        
        $this->view('chart', $data);      
    }
    
    public function getChart()
    {
        $return = array();    
            
        $initDate = $this->input->post("init_date");
        $endDate = $this->input->post("end_date");
        
        $this->loadRepository("UsersData");
        $users = $this->UsersData->findAll();
        
        foreach ($users as $aUser) {
            $hours = 0;
            
            $turns = $aUser->getTurns();
            
            foreach ($turns as $aTurn) {
                if (strtotime($aTurn->getDate()->format("Y-m-d")) >= strtotime($initDate) && strtotime($aTurn->getDate()->format("Y-m-d")) <= strtotime($endDate)){
                    $difference = $this->differenceByHour($aTurn);
                    $hours += $difference;
                }
            }
            
            $name = $aUser->getUser()->getName() . " " . $aUser->getUser()->getLastName();
            $return[] = array("name" => $name, "hours" => $hours);
        }
        
        echo json_encode($return);
    }
}