<?php defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Question_manager extends CI_Controller
    {
        public $global_data = array();

        public function __construct()
        {
            parent::__construct();
            
            // load audio model
            $this->load->model(array('question_model'));
            
            // initilize global data
            $this->global_data['page_name'] = 'question';
            $this->global_data['page_title'] = 'Question Manager';
            $this->global_data['header'] = $this->load->view('template/header', $this->global_data, true);
            $this->global_data['navbar'] = $this->load->view('template/navbar', $this->global_data, true);
            $this->global_data['footer'] = $this->load->view('template/footer', null, true);
        }

        // default page of controller
        public function index()
        {
            $questions_data['questions_data'] = $this->question_model->get_all_questions();
            $this->load->view('question/default_view', array_merge($this->global_data, $questions_data));
        }

        // create new question
        public function create_question_form()
        {
            $this->load->view('question/form/create_question_form', array_merge($this->global_data));
        }

        // insert new question into database
        public function insert_question()
        {
            // form validation            
            $this->form_validation->set_rules('question_title', 'question title', 'trim|required|min_length[6]|max_length[120]');
            $this->form_validation->set_rules('question_tags', 'question tags', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('question_category', 'question category', 'trim|required|max_length[255]');

            if (empty($_FILES['userfile']['name'])){
                $this->form_validation->set_rules('userfile', 'question attachement', 'required');
            }

            if($this->form_validation->run() == false){
                // failed to validate form. please try again.
                $this->load->view('question/form/create_question_form', array_merge($this->global_data));
            }else{
                // form successfully validation done
                // upload file on server
                $upload_config = array(
                    'upload_path' => './assets/resource/question/pdf',
                    "overwrite"=> true,
                    'encrypt_name' => true,
                    'remove_spaces' => true,
                    'allowed_types' => 'pdf',
                    'max_size' => 0,
                );

                // check upload path folder is available else create new one
                if(! is_dir($upload_config['upload_path'])){
                    mkdir($upload_config['upload_path'],0777, true);
                }

                // load library for file uploading and config.
                $this->load->library('upload', $upload_config);

                // do uploading
                if(! $this->upload->do_upload('userfile')){
                    // file uploading errors occured
                    $upload_error['upload_error'] = array('error' => $this->upload->display_errors());                   
                    $this->load->view('question/form/create_question_form', array_merge($this->global_data, $upload_error));
                }else{
                    // file upload successfull
                    // clean inputs and store into $data variable                    
                    $data = array(
                        'question_title' => clean_input($this->input->post('question_title')),
                        'question_tags' => strtolower(clean_input(comma_format($this->input->post('question_tags')))),
                        'question_category' => strtolower(clean_input(comma_format($this->input->post('question_category')))),
                        'question_file_name' => $this->upload->data('file_name'),
                        'question_file_type' => $this->upload->data('file_type'),
                        'question_file_full_path' => $this->upload->data('full_path'),
                        'question_file_ext' => $this->upload->data('file_ext'),
                        'question_file_size' => $this->upload->data('file_size'),
                        'question_views' => 0,
                        'question_published' => 1,
                    );

                    $result = $this->question_model->insert_question($data);

                    if($result){
                        $status = array(
                                'feedback' => 1,
                                'feedback_msg' => 'question_successfully_created'
                            );
                        $this->session->set_userdata($status);
                        redirect('question_manager');
                    }else{
                         $status = array(
                                'feedback' => 1,
                                'feedback_msg' => 'question_failed_created'
                            );
                        $this->session->set_userdata($status);
                        redirect('question_manager');
                    }
                }
            }
        }

        // update_question_form
        function update_question_form($question_id = ''){
            if($question_id != '' && is_numeric(intval($question_id))){
                $questions_data['questions_data'] = $this->question_model->get_question_by_id($question_id);

                if($questions_data['questions_data']){
                    $this->load->view('question/form/update_question_form', array_merge($this->global_data, $questions_data));
                }else{
                    echo 'You\'re trying to update question number '. $question_id .' which is not exist into database. Please try again';    
                }
                
                // $this->load->view('');
            }else{
                echo 'You\'re trying to update question which is not exist into database. Please try again';
            }
        }

        // update_question
        function update_question($question_id = '')
        {
            if($question_id != '' && is_numeric(intval($question_id)) && $question_id == $this->input->post('question_id')){
                // form validation            
                $this->form_validation->set_rules('question_id', 'question id', 'trim|required|integer');
                $this->form_validation->set_rules('question_title', 'question title', 'trim|required|min_length[6]|max_length[120]');
                $this->form_validation->set_rules('question_tags', 'question tags', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('question_category', 'question category', 'trim|required|max_length[255]');

                if (empty($_FILES['userfile']['name'])){
                    $this->form_validation->set_rules('userfile', 'question attachement', 'required');
                }
                

                if($this->form_validation->run() == false){
                    // failed to validate form. please try again.
                    $this->load->view('question/form/create_question_form', array_merge($this->global_data));
                }else{
                    // form successfully validation done
                    // upload file on server
                    $upload_config = array(
                        'upload_path' => './assets/resource/question/pdf',
                        "overwrite"=> true,
                        'encrypt_name' => true,
                        'remove_spaces' => true,
                        'allowed_types' => 'pdf',
                        'max_size' => 0,
                    );

                    // check upload path folder is available else create new one
                    if(! is_dir($upload_config['upload_path'])){
                        mkdir($upload_config['upload_path'],0777, true);
                    }

                    // load library for file uploading and config.
                    $this->load->library('upload', $upload_config);

                    if(! $this->upload->do_upload('userfile')){
                        // file uploading errors occured
                        $upload_error['upload_error'] = array('error' => $this->upload->display_errors());                   
                        $this->load->view('question/form/create_question_form', array_merge($this->global_data, $upload_error));
                    }else{
                        // file upload successfull
                        // clean inputs and store into $data variable       
                        $question_id = clean_input($this->input->post('question_id'));
                        
                        $data = array(
                            'question_title' => clean_input($this->input->post('question_title')),
                            'question_tags' => strtolower(clean_input(comma_format($this->input->post('question_tags')))),
                            'question_category' => strtolower(clean_input(comma_format($this->input->post('question_category')))),
                            'question_file_name' => $this->upload->data('file_name'),
                            'question_file_type' => $this->upload->data('file_type'),
                            'question_file_full_path' => $this->upload->data('full_path'),
                            'question_file_ext' => $this->upload->data('file_ext'),
                            'question_file_size' => $this->upload->data('file_size'),
                            'question_views' => 0,
                            'question_published' => 1,
                        );

                        $result = $this->question_model->update_question($question_id, $data);

                        if($result){
                            $status = array(
                                    'feedback' => 1,
                                    'feedback_msg' => 'question_successfully_updated'
                                );
                            $this->session->set_userdata($status);
                            redirect('question_manager');
                        }else{
                            $status = array(
                                    'feedback' => 1,
                                    'feedback_msg' => 'question_failed_update'
                                );
                            $this->session->set_userdata($status);
                            redirect('question_manager');
                        }
                    }
                }


            }else{
                echo 'You\'re trying to update invalid question. Please try again';
            }
        }

        public function delete_question_form($questionID)
        {
            $data['question_data'] = $this->question_model->get_question_by_id($questionID);
            $this->load->view('question/delete_question_view', array_merge($this->global_data, $data));
        }

        public function delete_question_process()
        {
            // form validation
            $this->form_validation->set_rules('question_id', 'question id', 'trim|required|integer');
            $this->form_validation->set_rules('reason', 'reason', 'trim|required');
            $this->form_validation->set_rules('remark', 'remark', 'trim|required');

            $question_id = clean_input($this->input->post('question_id'));

            // run validation
            if ($this->form_validation->run() == false) {
                $this->delete_question_form($question_id);
            } else {
                $reason = clean_input($this->input->post('reason'));
                $remark = clean_input($this->input->post('remark'));

                $result = $this->question_model->deleteQuestion($question_id, $reason, $remark);

                if ($result) {
                    $sessionData = array(
                        'feedback'      => true,
                        'feedback_type' => 'success',
                        'feedback_msg'  => 'Question has been successfully deleted.',
                    );
                    $this->session->set_userdata($sessionData);
                    redirect('question_manager');
                } else {
                    $sessionData = array(
                        'feedback'      => true,
                        'feedback_type' => 'danger',
                        'feedback_msg'  => 'Failed to delete question form database.',
                    );
                    $this->session->set_userdata($sessionData);
                    redirect('question_manager');
                }
            }
        }
    }