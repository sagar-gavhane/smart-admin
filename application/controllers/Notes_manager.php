<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Notes_manager extends CI_Controller
    {
        public $global_data = array();

        public function __construct()
        {
            parent::__construct();

            // load notes model
            $this->load->model(array('notes_model'));

            // initilize global data
            $this->global_data['page_name'] = 'notes';
            $this->global_data['page_title'] = 'Notes Manager';
            $this->global_data['header'] = $this->load->view('template/header', $this->global_data, true);
            $this->global_data['navbar'] = $this->load->view('template/navbar', $this->global_data, true);
            $this->global_data['footer'] = $this->load->view('template/footer', null, true);
        }

        // default page of controller
        public function index()
        {
            $notes_data['notes_data'] = $this->notes_model->get_all_notes();
            $this->load->view('notes/default_view', array_merge($this->global_data, $notes_data));
        }

        // create new notes
        public function create_notes_form()
        {
            $this->load->view('notes/form/create_notes_form', array_merge($this->global_data));
        }

        // insert notes into database
        public function insert_notes()
        {
            // form validation
            $this->form_validation->set_rules('notes_title', 'notes title', 'trim|required|min_length[6]|max_length[120]');
            $this->form_validation->set_rules('notes_tags', 'notes tags', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('notes_category', 'notes category', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('notes_desc', 'notes description', 'trim|required|min_length[15]|max_length[300]');

            // run validation
            if($this->form_validation->run() == false){
              // failed to validate inputs
              $this->load->view('notes/form/create_notes_form', array_merge($this->global_data));
            }else{
              // clean inputs
              $data = array(
                'note_title' => clean_input($this->input->post('notes_title')),
                'note_tags' => strtolower(clean_input(comma_format($this->input->post('notes_tags')))),
                'note_category' => strtolower(clean_input(comma_format($this->input->post('notes_category')))),
                'note_desc' => ucfirst(strtolower(clean_input($this->input->post('notes_desc')))),
              );

              // save $data into database
              $result = $this->notes_model->insert_notes($data);
              
              // check $result for true or false
              if($result == true){
                    $status = array(
                        'feedback' => 1,
                        'feedback_msg' => 'notes_successfully_inserted'
                    );
                    $this->session->set_userdata($status);
                    redirect('notes_manager');
              }else{
                    $status = array(
                        'feedback' => 1,
                        'feedback_msg' => 'notes_insertion_failed'
                    );
                    $this->session->set_userdata($status);
                    redirect('notes_manager');
              }
            }
        }

        // update existing notes from
        public function update_notes_form($notes_id = '')
        {
            if($notes_id !== '' && is_integer(intval($notes_id))){
                $notes_data['notes_data'] = $this->notes_model->get_notes_by_id($notes_id);

                // check $notes_data contain any value
                if($notes_data['notes_data']){
                    $this->load->view('notes/form/update_notes_form', array_merge($this->global_data, $notes_data));
                }else{
                    echo 'You have selected notes is not exist in database';
                }

            }else{
                echo 'You have tried to access update notes page with passing valid notes identity';
            }
        }

        // update existing notes action
        public function update_notes($notes_id = ''){
            if($notes_id !== '' && is_integer(intval($notes_id)) && $notes_id == $this->input->post('notes_id')){
                // form validation
                $this->form_validation->set_rules('notes_id', 'notes identity', 'trim|required|integer');
                $this->form_validation->set_rules('notes_title', 'notes title', 'trim|required|min_length[6]|max_length[120]');
                $this->form_validation->set_rules('notes_tags', 'notes tags', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('notes_category', 'notes category', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('notes_desc', 'notes description', 'trim|required|min_length[15]|max_length[300]');

                // run validation
                if($this->form_validation->run() == false){
                    echo 'validation false';
                }else{
                    $notes_id = clean_input($this->input->post('notes_id'));

                    $data = array(
                        'note_title' => clean_input($this->input->post('notes_title')),
                        'note_tags' => strtolower(clean_input(comma_format($this->input->post('notes_tags')))),
                        'note_category' => strtolower(clean_input(comma_format($this->input->post('notes_category')))),
                        'note_desc' => ucfirst(strtolower(clean_input($this->input->post('notes_desc')))),
                      );

                    $result = $this->notes_model->update_notes($notes_id, $data);

                    if($result == true){
                        $status = array(
                            'feedback' => 1,
                            'feedback_msg' => 'notes_successfully_updated'
                        );
                        $this->session->set_userdata($status);                        
                        redirect('notes_manager');
                    }else{
                        $status = array(
                            'feedback' => 1,
                            'feedback_msg' => 'notes_updating_failed'
                        );
                        $this->session->set_userdata($status);
                        redirect('notes_manager');
                    }
                }
            }else{                
                echo 'You have tried to acced update notes page with passing valid notes identity';
            }
        }

    }
