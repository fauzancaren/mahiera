<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_perencanaan extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }
   function load_page()
   {
   }
}
