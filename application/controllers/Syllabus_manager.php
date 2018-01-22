<?php defined('BASEPATH') or exit('No direct script access allowed');

class Syllabus_manager extends CI_Controller
{
    public $global_data = array();

    public function __construct()
    {
        parent::__construct();

        // load syllabus model
        $this->load->model(array('syllabus_model'));

        // initilize global data
        $this->global_data['page_name']  = 'syllabus';
        $this->global_data['page_title'] = 'Syllabus Manager';
        $this->global_data['header']     = $this->load->view('template/header', $this->global_data, true);
        $this->global_data['navbar']     = $this->load->view('template/navbar', $this->global_data, true);
        $this->global_data['footer']     = $this->load->view('template/footer', null, true);
        $this->global_data['feedback']     = $this->load->view('template/feedback', null, true);
    }

    // default page of controller
    public function index()
    {
        $syllabus_data['syllabus_data'] = $this->syllabus_model->get_all_syllabus();
        $this->load->view('syllabus/default_view', array_merge($this->global_data, $syllabus_data));
    }

    // create new syllabus form
    public function create_syllabus_form()
    {
        $this->load->view('syllabus/form/create_syllabus_form', array_merge($this->global_data));
    }

    // insert new syllabus into database
    public function insert_syllabus()
    {
        // form validate
        $this->form_validation->set_rules('syllabus_title', 'syllabus title', 'trim|required|min_length[6]|max_length[120]');
        $this->form_validation->set_rules('syllabus_tags', 'syllabus tags', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('syllabus_category', 'syllabus category', 'trim|required|max_length[255]');

        if (empty($_FILES['userfile']['name'])) {
            $this->form_validation->set_rules('userfile', 'syllabus attachement', 'required');
        }

        if ($this->form_validation->run() == false) {
            // failed to validate form. please try again.
            $this->load->view('syllabus/form/create_syllabus_form', array_merge($this->global_data));
        } else {
            // form successfully validation done
            // upload file on server
            $upload_config = array(
                // 'file_name'=> 'audio_1',
                'upload_path'   => './assets/resource/syllabus/pdf',
                "overwrite"     => true,
                'encrypt_name'  => true,
                'remove_spaces' => true,
                'allowed_types' => 'pdf',
                'max_size'      => 0,
            );

            // check upload path folder is available else create new one
            if (!is_dir($upload_config['upload_path'])) {
                mkdir($upload_config['upload_path'], 0777, true);
            }

            // load library for file uploading and config.
            $this->load->library('upload', $upload_config);

            // do uploading
            if (!$this->upload->do_upload('userfile')) {
                // file uploading errors occured
                $upload_error['upload_error'] = array('error' => $this->upload->display_errors());
                $this->load->view('syllabus/form/create_syllabus_form', array_merge($this->global_data, $upload_error));
            } else {
                // file upload successfull
                // clean inputs and store into $data variable
                $data = array(
                    'syllabus_title'          => clean_input($this->input->post('syllabus_title')),
                    'syllabus_tags'           => strtolower(clean_input(comma_format($this->input->post('syllabus_tags')))),
                    'syllabus_category'       => strtolower(clean_input(comma_format($this->input->post('syllabus_category')))),
                    'syllabus_file_name'      => $this->upload->data('file_name'),
                    'syllabus_file_type'      => $this->upload->data('file_type'),
                    'syllabus_file_full_path' => $this->upload->data('full_path'),
                    'syllabus_file_ext'       => $this->upload->data('file_ext'),
                    'syllabus_file_size'      => $this->upload->data('file_size'),
                    'syllabus_views'          => 0,
                    'syllabus_published'      => 1,
                );

                $result = $this->syllabus_model->insert_syllabus($data);

                // check $result is true or false
                // if $result is true then syllabus upload successfully done
                // failed to upload syllabus file throw error
                if ($result) {
                    $status = array(
                        'feedback'     => true,
                        'feedback_type' => 'success',
                        'feedback_msg' => 'Syllabus has been successfully created',
                    );
                    $this->session->set_userdata($status);
                    redirect('syllabus_manager');
                } else {
                    $status = array(
                        'feedback'     => true,
                        'feedback_type' => 'danger',
                        'feedback_msg' => 'Failed to created syllabus. Please try again.',
                    );
                    $this->session->set_userdata($status);
                    redirect('syllabus_manager');
                }
            }
        }
    }

    // update_syllabus_form
    public function update_syllabus_form($syllabus_id = '')
    {
        if ($syllabus_id !== '' && is_integer(intval($syllabus_id))) {
            $syllabus_data['syllabus_data'] = $this->syllabus_model->get_syllabus_by_id($syllabus_id);

            if ($syllabus_data['syllabus_data']) {
                $this->load->view('syllabus/form/update_syllabus_form', array_merge($this->global_data, $syllabus_data));
            } else {
                echo 'You\'re trying to access syllabus which is not exist into database';
            }
        }
    }

    // update syllabus details into database
    public function update_syllabus($syllabus_id = '')
    {
        if ($syllabus_id !== '' && is_integer(intval($syllabus_id)) && $syllabus_id == $this->input->post('syllabus_id')) {
            // form validate
            $this->form_validation->set_rules('syllabus_id', 'syllabus identity', 'trim|required|integer');
            $this->form_validation->set_rules('syllabus_title', 'syllabus title', 'trim|required|min_length[6]|max_length[120]');
            $this->form_validation->set_rules('syllabus_tags', 'syllabus tags', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('syllabus_category', 'syllabus category', 'trim|required|max_length[255]');

            if (empty($_FILES['userfile']['name'])) {
                $this->form_validation->set_rules('userfile', 'syllabus attachement', 'required');
            }

            if ($this->form_validation->run() == false) {
                // failed to validate form. please try again.
                $this->load->view('syllabus/form/create_syllabus_form', array_merge($this->global_data));
            } else {
                // form successfully validation done
                // upload file on server
                $upload_config = array(
                    'upload_path'   => './assets/resource/syllabus/pdf',
                    "overwrite"     => true,
                    'encrypt_name'  => true,
                    'remove_spaces' => true,
                    'allowed_types' => 'pdf',
                    'max_size'      => 0,
                );

                // check upload path folder is available else create new one
                if (!is_dir($upload_config['upload_path'])) {
                    mkdir($upload_config['upload_path'], 0777, true);
                }

                // load library for file uploading and config.
                $this->load->library('upload', $upload_config);

                // do uploading
                if (!$this->upload->do_upload('userfile')) {
                    // file uploading errors occured
                    $upload_error['upload_error'] = array('error' => $this->upload->display_errors());
                    $this->load->view('syllabus/form/create_syllabus_form', array_merge($this->global_data, $upload_error));
                } else {
                    // file upload successfull
                    // clean inputs and store into $data variable
                    $syllabus_id = clean_input($this->input->post('syllabus_id'));

                    $data = array(
                        'syllabus_title'          => clean_input($this->input->post('syllabus_title')),
                        'syllabus_tags'           => strtolower(clean_input(comma_format($this->input->post('syllabus_tags')))),
                        'syllabus_category'       => strtolower(clean_input(comma_format($this->input->post('syllabus_category')))),
                        'syllabus_file_name'      => $this->upload->data('file_name'),
                        'syllabus_file_type'      => $this->upload->data('file_type'),
                        'syllabus_file_full_path' => $this->upload->data('full_path'),
                        'syllabus_file_ext'       => $this->upload->data('file_ext'),
                        'syllabus_file_size'      => $this->upload->data('file_size'),
                        'syllabus_views'          => 0,
                        'syllabus_published'      => 1,
                    );

                    $result = $this->syllabus_model->update_syllabus($syllabus_id, $data);

                    // check $result is true or false
                    // if $result is true then syllabus upload successfully done
                    // failed to upload syllabus file throw error
                    if ($result) {
                        $status = array(
                            'feedback'     => 1,
                            'feedback_msg' => 'syllabus_successfully_created',
                        );
                        $this->session->set_userdata($status);
                        redirect('syllabus_manager');
                    } else {
                        $status = array(
                            'feedback'     => 1,
                            'feedback_msg' => 'syllabus_failed_created',
                        );
                        $this->session->set_userdata($status);
                        redirect('syllabus_manager');
                    }
                }
            }
        } else {
            echo 'Your trying to update invalid syllabus information';
        }
    }

    public function delete_syllabus_form($syllabus_id)
    {
        $data['syllabus_data'] = $this->syllabus_model->get_syllabus_by_id($syllabus_id);
        $this->load->view('syllabus/delete_syllabus_view', array_merge($this->global_data, $data));
    }

    /**
     * delete syllabus form process
     * @return void
     */
    public function delete_syllabus_process()
    {
        $this->output->enable_profiler(true);
        // form validation
        $this->form_validation->set_rules('syllabus_id', 'syllabus id', 'trim|required|integer');
        $this->form_validation->set_rules('reason', 'reason', 'trim|required');
        $this->form_validation->set_rules('remark', 'remark', 'trim|required');

        $syllabus_id = clean_input($this->input->post('syllabus_id'));

        // run validation
        if ($this->form_validation->run() == false) {
            $this->delete_syllabus_form($syllabus_id);
        } else {
            $reason = clean_input($this->input->post('reason'));
            $remark = clean_input($this->input->post('remark'));

            $result = $this->syllabus_model->deleteSyllabus($syllabus_id, $reason, $remark);

            if ($result) {
                $sessionData = array(
                    'feedback'      => true,
                    'feedback_type' => 'success',
                    'feedback_msg'  => 'Syllabus has been successfully deleted.',
                );
                $this->session->set_userdata($sessionData);
                redirect('syllabus_manager');
            } else {
                $sessionData = array(
                    'feedback'      => true,
                    'feedback_type' => 'danger',
                    'feedback_msg'  => 'Failed to delete syllabus form database.',
                );
                $this->session->set_userdata($sessionData);
                redirect('syllabus_manager');
            }
        }
    }
}
