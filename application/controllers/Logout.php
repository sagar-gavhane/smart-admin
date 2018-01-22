<?php defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Logout extends CI_Controller
    {
        public $global_data = array();

        public function __construct()
        {
            parent::__construct();
        }

        // default page of controller
        public function index()
        {
            $this->session->sess_destroy();
            redirect('login');
        }


    }