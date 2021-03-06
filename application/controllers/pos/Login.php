<?php

class Login extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PosModel', 'model');
        $this->load->library('upload');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->view("pos/login");
    }

    public function action()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");

    
        $isLogin = $this->model->authProcess($username,$password)[0];

        if($isLogin){
            $outs = $this->model->authProcess($username,$password)[1];
            $this->session->set_userdata('outlet',$outs);
            redirect('pos/pos');
        }else{
            $this->session->set_flashdata('message', "Username atau password salah");
            redirect(base_url('pos/login'));
        }
        
    }
}
