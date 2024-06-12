<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
   function __construct()
   {
      parent::__construct(); 
   }
   function index()
   {
      $this->load->view('template/test');
   }
   function auth()
   {
      $this->load->view('template/testauth');
   } 

   function grpo(){
      $this->load->model('inventory/Model_inventory', 'm_inventory'); 
      $this->m_inventory->insert_trans_from_grpo("ALY/XIII/01/GR-0001/19/V/2023");
   }
}