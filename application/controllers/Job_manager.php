<?php defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Job_manager extends CI_Controller
    {
        public $global_data = array();

        public function __construct()
        {
            parent::__construct();
            
            
            // load audio model
            $this->load->model(array('job_model'));
            
            // initilize global data
            $this->global_data['page_name'] = 'job';
            $this->global_data['page_title'] = 'Job Manager';
            $this->global_data['header'] = $this->load->view('template/header', $this->global_data, true);
            $this->global_data['navbar'] = $this->load->view('template/navbar', $this->global_data, true);
            $this->global_data['footer'] = $this->load->view('template/footer', null, true);
            $this->global_data['feedback'] = $this->load->view('template/feedback', null, true);
        }

        // default page of controller
        public function index()
        {
            $jobs_data['jobs_data'] = $this->job_model->get_all_jobs();
            $this->load->view('job/default_view', array_merge($this->global_data, $jobs_data));
        }

        // create_job_form
        public function create_job_form()
        {
            $this->load->view('job/form/create_job_form', array_merge($this->global_data));
        }

        // insert_job
        public function insert_job()
        {
            // form validation            
            $this->form_validation->set_rules('job_title', 'job title', 'trim|required|min_length[6]|max_length[120]');
            $this->form_validation->set_rules('job_tags', 'job tags', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('job_category', 'job category', 'trim|required|max_length[255]');

            if (empty($_FILES['userfile']['name'])){
                $this->form_validation->set_rules('userfile', 'job attachement', 'required');
            }

            if($this->form_validation->run() == false){
                // failed to validate form. please try again.
                $this->load->view('job/form/create_job_form', array_merge($this->global_data));
            }else{
                // form successfully validation done
                // upload file on server
                $upload_config = array(
                    'upload_path' => './assets/resource/job/pdf',
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
                    $this->load->view('job/form/create_job_form', array_merge($this->global_data, $upload_error));
                }else{
                    // file upload successfull
                    // clean inputs and store into $data variable                    
                    $data = array(
                        'job_title' => clean_input($this->input->post('job_title')),
                        'job_tags' => strtolower(clean_input(comma_format($this->input->post('job_tags')))),
                        'job_category' => strtolower(clean_input(comma_format($this->input->post('job_category')))),
                        'job_file_name' => $this->upload->data('file_name'),
                        'job_file_type' => $this->upload->data('file_type'),
                        'job_file_full_path' => $this->upload->data('full_path'),
                        'job_file_ext' => $this->upload->data('file_ext'),
                        'job_file_size' => $this->upload->data('file_size'),
                        'job_views' => 0,
                        'job_published' => 1,
                    );

                    $result = $this->job_model->insert_job($data);

                    if($result){
                        $status = array(
                                'feedback' => 1,
                                'feedback_msg' => 'job_successfully_created'
                            );
                        $this->session->set_userdata($status);
                        redirect('job_manager');
                    }else{
                         $status = array(
                                'feedback' => 1,
                                'feedback_msg' => 'job_failed_created'
                            );
                        $this->session->set_userdata($status);
                        redirect('job_manager');
                    }
                }
            }
        }

        // update job form
        public function update_job_form($job_id = '')
        {
            if($job_id !== '' && is_integer(intval($job_id))){
                $jobs_data['jobs_data'] = $this->job_model->get_job_by_id($job_id);

                if($jobs_data['jobs_data']){
                    $this->load->view('job/form/update_job_form', array_merge($this->global_data, $jobs_data));
                }else{
                     echo 'You\'re trying to update job which is not exist into database. Please try again';
                }
            }else{
                 echo 'You\'re trying to update invalid job. Please try again';
            }
        }

        // update job
        public function update_job($job_id = '')
        {
            if($job_id !== ''){
                // form validation            
                $this->form_validation->set_rules('job_id', 'job id', 'trim|required|integer');
                $this->form_validation->set_rules('job_title', 'job title', 'trim|required|min_length[6]|max_length[120]');
                $this->form_validation->set_rules('job_tags', 'job tags', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('job_category', 'job category', 'trim|required|max_length[255]');

                if (empty($_FILES['userfile']['name'])){
                    $this->form_validation->set_rules('userfile', 'job attachement', 'required');
                }
                
                if($this->form_validation->run() == false){
                    // failed to validate form. please try again.
                    $this->load->view('job/form/create_job_form', array_merge($this->global_data));
                }else{
                    // form successfully validation done
                    // upload file on server
                    $upload_config = array(
                        'upload_path' => './assets/resource/job/pdf',
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
                        $this->load->view('job/form/create_job_form', array_merge($this->global_data, $upload_error));
                    }else{
                        // file upload successfull
                        // clean inputs and store into $data variable       
                        $job_id = clean_input($this->input->post('job_id'));
                        
                        $data = array(
                            'job_title' => clean_input($this->input->post('job_title')),
                            'job_tags' => strtolower(clean_input(comma_format($this->input->post('job_tags')))),
                            'job_category' => strtolower(clean_input(comma_format($this->input->post('job_category')))),
                            'job_file_name' => $this->upload->data('file_name'),
                            'job_file_type' => $this->upload->data('file_type'),
                            'job_file_full_path' => $this->upload->data('full_path'),
                            'job_file_ext' => $this->upload->data('file_ext'),
                            'job_file_size' => $this->upload->data('file_size'),
                            'job_views' => 0,
                            'job_published' => 1,
                        );

                        $result = $this->job_model->update_job($job_id, $data);

                        if($result){
                            $status = array(
                                    'feedback' => 1,
                                    'feedback_msg' => 'job_successfully_updated'
                                );
                            $this->session->set_userdata($status);
                            redirect('job_manager');
                        }else{
                            $status = array(
                                    'feedback' => 1,
                                    'feedback_msg' => 'job_failed_update'
                                );
                            $this->session->set_userdata($status);
                            redirect('job_manager');
                        }
                    }
                }
            }
        }

        public function delete_job_form($job_id)
        {
            $data['job_data'] = $this->job_model->get_job_by_id($job_id);
            $this->load->view('job/delete_job_view', array_merge($this->global_data, $data));
        }

        public function delete_job_process()
        {
            // form validation
            $this->form_validation->set_rules('job_id', 'job id', 'trim|required|integer');
            $this->form_validation->set_rules('reason', 'reason', 'trim|required');
            $this->form_validation->set_rules('remark', 'remark', 'trim|required');

            $job_id = clean_input($this->input->post('job_id'));

            // run validation
            if ($this->form_validation->run() == false) {
                $this->delete_job_form($job_id);
            } else {
                $reason = clean_input($this->input->post('reason'));
                $remark = clean_input($this->input->post('remark'));

                $result = $this->job_model->deleteJob($job_id, $reason, $remark);

                if ($result) {
                    $sessionData = array(
                        'feedback'      => true,
                        'feedback_type' => 'success',
                        'feedback_msg'  => 'Job has been successfully deleted.',
                    );
                    $this->session->set_userdata($sessionData);
                    redirect('job_manager');
                } else {
                    $sessionData = array(
                        'feedback'      => true,
                        'feedback_type' => 'danger',
                        'feedback_msg'  => 'Failed to delete job form database.',
                    );
                    $this->session->set_userdata($sessionData);
                    redirect('job_manager');
                }
            }
        }
    }