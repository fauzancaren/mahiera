<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_app');
        $this->load->helper('cookie'); 
    }
    public function index()
	{ 
        $data["view"] = $this->load->view("main/home", '', TRUE);
        $this->load->view('main/template',$data);
    }
    public function layanan()
	{ 
        $data["view"] = $this->load->view("main/layanan", '', TRUE);
        $this->load->view('main/template',$data);
    }
    public function project()
	{ 
        $data["view"] = $this->load->view("main/home", '', TRUE);
        $this->load->view('main/template',$data);
    }
    public function contact()
	{ 
        $data["view"] = $this->load->view("main/contact", '', TRUE);
        $this->load->view('main/template',$data);
    }
}