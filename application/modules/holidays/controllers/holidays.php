<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holidays extends MY_Controller 
{
	public function index()
	{
		$actions = array();
		$actions["create_holiday"] = site_url("holidays/form");
		
		$data = array();
		$data["title"] = lang("Holidays");
		$this->view('list', $data, $actions);
	}
	
	public function setListParameters()
	{
        $this->load->helper('action');

        $model = new Model("Holidays", "h", array("id" => "id", 'date' => 'date'));
        $model->setNumerics(array("h.id"));

        $actions = array();
        array_push($actions, new Action("holidays", "form", "edit"));        
        array_push($actions, new Action("holidays", "delete", "delete", false));        
        
        $this->model   = $model;
        $this->actions = $actions;
	}
    
    public function form ($identifier = 0)
    {
        $id = ($this->input->post("id") > 0) ? $this->input->post("id") : 0;
        $date = $this->input->post('date');
        
        if ($identifier > 0){
            $output = $this->rest->get('holidays/holiday/', array("id"=>$identifier));
        
            if ($output->status){
                $holiday    = $output->data;
                $date = $holiday->date;
                $id         = $holiday->id;
            }
        }
        
        $actions = array();
        $actions["return_holiday"] = site_url("holidays/index");
        
        $data = array();
        $data["title"]  = lang("Holidays");
        $data['date'] = $date;
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
                
        if ($this->form_validation->run($this)){
            if ($this->input->post("id") > 0){
                $output = $this->rest->post('holidays/holiday', $this->input->post()); 
            }else{
                $output = $this->rest->put('holidays/holiday', $this->input->post()); 
            }
            
            if (empty($output) == false){
                if ($output->status){
                    $message = ($this->input->post("id") > 0) ? lang('holiday_edition') : lang('holiday_creation');
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
        
        $output = $this->rest->delete('holidays/holiday', array("id"=>$this->input->post("id")));

        if ($output->status){
            $message = lang("holiday_delete");
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