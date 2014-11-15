<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Turns extends MY_Controller 
{
	public function index()
	{
		$actions = array();
		$actions["create_turn"] = site_url("turns/form");
		
		$data = array();
		$data["title"] = lang("Turns");
		$this->view('list', $data, $actions);
	}
	
	public function setListParameters()
	{
        $this->load->helper('action');

        $model = new Model("Turns", "t", array("id" => "id", 'name' => 'name', 'initialTime' => 'initialTime', 'endTime' => 'endTime'));
        $model->setNumerics(array("t.id"));
        $model->setTypesTime(array("initialTime", "endTime"));

        $actions = array();
        array_push($actions, new Action("turns", "form", "edit"));        
        array_push($actions, new Action("turns", "delete", "delete", false));        
        
        $this->model   = $model;
        $this->actions = $actions;
	}
    
    public function form ($identifier = 0)
    {
        $id = ($this->input->post("id") > 0) ? $this->input->post("id") : 0;
        $initialTime = $this->input->post('initialTime');
		$endTime = $this->input->post('endTime');
		$name = $this->input->post('name');
        
        if ($identifier > 0){
            $output = $this->rest->get('turns/turn/', array("id"=>$identifier));
            
            if ($output->status){
                $turn    = $output->data;
                $name = $turn->name;
                $initialTime = $turn->initial_time;
				$endTime = $turn->end_time;
                $id         = $turn->id;
            }
        }
        
        $actions = array();
        $actions["return_turn"] = site_url("turns/index");
        
        $data = array();
        $data["title"]  = lang("Turns");
        $data['name'] = $name;
        $data['initialTime'] = $initialTime;
		$data['endTime'] = $endTime;
        $data["id"] = $id;
        $this->view('form', $data, $actions);
    }
    
    public function persist ()
    {
        $data = array();
        $message = "";
        $error   = "";
        $output  = ""; 
        
        $this->form_validation->set_rules('initialTime', 'lang:initialTime', 'required');
		$this->form_validation->set_rules('endTime', 'lang:endTime', 'required');
		$this->form_validation->set_rules('name', 'lang:name', 'required');
                
        if ($this->form_validation->run($this)){
            if ($this->input->post("id") > 0){
                $output = $this->rest->post('turns/turn', $this->input->post()); 
            }else{
                $output = $this->rest->put('turns/turn', $this->input->post()); 
            }
            
            if (empty($output) == false){
                if ($output->status){
                    $message = ($this->input->post("id") > 0) ? lang('turn_edition') : lang('turn_creation');
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

    public function delete()
    {
        $data    = array();
        $message = "";
        $warning = "";
        $error   = "";
        
        $output = $this->rest->delete('turns/turn', array("id"=>$this->input->post("id")));

        if ($output->status){
            $message = lang("turn_delete");
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