<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sector_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        // $this->user_controller = new User_controller();
        // $this->load->library(null,null,'./controllers/User_controller');
    }


    public function create_sector(){
        $section = $this->input->post('sector_name');
    }

    public function sector($id){
        $query = $this->Sector_model->get_sector($id);
        if($query){
            return $this->output
            ->set_status_header(200)
            ->set_output(json_encode($query));
        }else{
            return $this->output
            ->set_status_header(404)
            ->set_output(array('message'=>'no data'));
        }
        return $this->output
        ->set_status_header(500)
        ->set_output(array('message'=>'server'));
    }

    public function sectors()
    {
        $query = $this->Sector_model->get_sectorAll();
        if($query){
            return $this->output
            ->set_status_header(200)
            ->set_output(json_encode($query));
        }else{
            return $this->output
            ->set_status_header(404)
            ->set_output(array('message'=>'no data'));
        }
        return $this->output
        ->set_status_header(500)
        ->set_output(array('message'=>'server'));
    
    }
}
