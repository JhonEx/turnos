<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedules extends MY_Controller 
{
	public function index($userId = 0)
	{
		$actions = array();
		$actions["create_schedule"] = site_url("schedules/form");
        
        if ($userId > 0){
            $this->session->set_userdata("userdata", $userId);
        }
		
		$data = array();
		$data["title"] = lang("Schedules");
		$this->view('list', $data, $actions);
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