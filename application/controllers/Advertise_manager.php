<?php defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Advertise_manager extends CI_Controller
    {
        public $global_data = array();

        public function __construct()
        {
            parent::__construct();
            
            // load audio model
            $this->load->model(array('advertise_model'));
            
            // initilize global data
            $this->global_data['page_name'] = 'advertise';
            $this->global_data['page_title'] = 'Advertise Manager';
            $this->global_data['header'] = $this->load->view('template/header', $this->global_data, true);
            $this->global_data['navbar'] = $this->load->view('template/navbar', $this->global_data, true);
            $this->global_data['footer'] = $this->load->view('template/footer', null, true);
        }

        // default page of controller
        public function index()
        {
        	$received_ads_data['received_ads_data'] = $this->advertise_model->getTenReceivedAds();
        	$send_ads_data['send_ads_data'] = $this->advertise_model->getTenSendAds();

            $this->load->view('advertise/default_view', array_merge($this->global_data, $received_ads_data, $send_ads_data));
        }

        public function received_advertise(){
        	$received_ads_data['received_ads_data'] = $this->advertise_model->getAllReceivedAds();
        	// echo '<pre>';
        	// echo 'Received Ads Data';
        	// print_r($received_ads_data);
        	// echo '</pre>';
        	$this->load->view('advertise/received_advertise_view', array_merge($this->global_data, $received_ads_data));
        }

        public function send_advertise_form(){
        	$this->load->view('advertise/form/send_advertise_form', array_merge($this->global_data));
        }  

        // insert send ads
        public function insert_send_ads(){
        	// form validation
        	$this->form_validation->set_rules('send_ads_title', 'send ads title', 'trim|required|min_length[6]|max_length[120]');
        	$this->form_validation->set_rules('send_ads_desc', 'send ads description', 'trim|required|min_length[15]|max_length[300]');
        	$this->form_validation->set_rules('send_ads_weblink', 'send ads weblink', 'trim|required|valid_url');
        	$this->form_validation->set_rules('send_ads_show_days', 'send ads show days', 'trim|required|integer|greater_than_equal_to[1]|less_than_equal_to[365]');

        	if (empty($_FILES['userfile']['name'])){
                $this->form_validation->set_rules('userfile', 'advertise attachement', 'required');
            }

            if($this->form_validation->run() == false){
            	$this->load->view('advertise/form/send_advertise_form', array_merge($this->global_data));
            }else{
            	// form successfully validation done
                // upload file on server
                $upload_config = array(
                    // 'file_name'=> 'audio_1',
                    'upload_path' => './assets/resource/ads/image',
                    "overwrite"=> true,
                    'encrypt_name' => true,
                    'remove_spaces' => true,
                    'allowed_types' => 'gif|jpg|png|jpeg',
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
                    $this->load->view('advertise/form/send_advertise_form', array_merge($this->global_data, $upload_error));
                }else{
                	// file upload successfull
                    // clean inputs and store into $data variable

                	$startDate = date("Y-m-d H:i:s");
                	
                	$lastDate = strtotime("+". $this->input->post('send_ads_show_days') ." day" , strtotime($startDate));
                	$lastDate = date("Y-m-d H:i:s", $lastDate);

                	$data = array(
                		'send_ad_title'=> clean_input(ucwords(strtolower($this->input->post('send_ads_title')))),
                		'send_ad_desc'=> clean_input(ucfirst(strtolower($this->input->post('send_ads_title')))),
                		'send_ad_web_link'=> clean_input(strtolower($this->input->post('send_ads_weblink'))),
                		'send_ad_show_days'=> clean_input($this->input->post('send_ads_show_days')),
                		'send_ad_last_date'=> $lastDate,
                		'send_ad_file_name' => $this->upload->data('file_name'),
                        'send_ad_file_type' => $this->upload->data('file_type'),
                        'send_ad_file_full_path' => $this->upload->data('full_path'),
                        'send_ad_file_ext' => $this->upload->data('file_ext'),
                        'send_ad_file_size' => $this->upload->data('file_size'),
                        'send_ad_views' => 0,
                	);

                	$result = $this->advertise_model->insert_send_ads($data);

                	// check $result is true or false
                    // if $result is true then ad upload successfully done
                    // failed to upload ad file throw error
                    if($result){
                        $status = array(
                            'feedback' => 1,
                            'feedback_msg' => 'ad_successfully_sent'
                        );
                        $this->session->set_userdata($status);
                        redirect('advertise_manager');
                    }else{
                        $status = array(
                            'feedback' => 1,
                            'feedback_msg' => 'ad_sending_failed'
                        );
                        $this->session->set_userdata($status);
                        redirect('advertise_manager');
                    }

                }
            }
        }

        public function update_advertise_form($send_ad_id)
        {

        }

        public function delete_advertise_form($send_ad_id)
        {
            $data['question_data'] = $this->question_model->get_question_by_id($questionID);
            $this->load->view('question/delete_question_view', array_merge($this->global_data, $data));
        }
    }