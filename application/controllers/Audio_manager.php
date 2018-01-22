<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Audio Manager Controller - Handling Audio Operations
 */
class Audio_manager extends CI_Controller
{
    public $global_data = array();

    public function __construct()
    {
        parent::__construct();

        // load audio model
        $this->load->model(array('audio_model', 'delete_model'));

        // initilize global data
        $this->global_data['page_name']  = 'audio';
        $this->global_data['page_title'] = 'Audio Manager';
        $this->global_data['header']     = $this->load->view('template/header', $this->global_data, true);
        $this->global_data['navbar']     = $this->load->view('template/navbar', $this->global_data, true);
        $this->global_data['footer']     = $this->load->view('template/footer', null, true);
        $this->global_data['feedback']     = $this->load->view('template/feedback', null, true);
    }

    /**
     * default page
     * @return void - show dafult page of audio manager
     */
    public function index()
    {
        $audio_data['audio_data'] = $this->audio_model->get_all_audio();
        $this->load->view('audio/default_view', array_merge($this->global_data, $audio_data));
    }

    // upload audio form page
    public function upload_audio_form()
    {
        $this->load->view('audio/upload_audio_form', array_merge($this->global_data));
    }

    // insert new audio into database
    public function insert_audio()
    {
        // form validation
        $this->form_validation->set_rules('audio_title', 'audio title', 'trim|required|min_length[6]|max_length[120]');
        $this->form_validation->set_rules('audio_tags', 'audio tags', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('audio_category', 'audio category', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('audio_desc', 'audio description', 'trim|required|min_length[15]|max_length[300]');

        // run validation
        if ($this->form_validation->run() == false) {
            // failed to validate form hence redirected to upload audio form
            $this->upload_audio_form();
        } else {
            // config upload audio path
            $upload_config = array(
                // 'file_name'=> 'audio_1',
                'upload_path'   => './assets/resource/audio/', //base_url().'assets/resource/audio/',
                "overwrite"     => true,
                'encrypt_name'  => true,
                'remove_spaces' => true,
                'allowed_types' => 'gif|mp3',
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
                $error = array('error' => $this->upload->display_errors());
            } else {
                // file upload successfull
                // clean inputs
                $data = array(
                    'audio_title'          => clean_input($this->input->post('audio_title')),
                    'audio_tags'           => strtolower(clean_input(comma_format($this->input->post('audio_tags')))),
                    'audio_category'       => strtolower(clean_input(comma_format($this->input->post('audio_category')))),
                    'audio_desc'           => ucfirst(strtolower(clean_input($this->input->post('audio_desc')))),
                    'audio_file_name'      => $this->upload->data('file_name'),
                    'audio_file_type'      => $this->upload->data('file_type'),
                    'audio_file_full_path' => $this->upload->data('full_path'),
                    'audio_file_ext'       => $this->upload->data('file_ext'),
                    'audio_file_size'      => $this->upload->data('file_size'),
                    'audio_views'          => 0,
                    'audio_published'      => 1,
                );

                // store $data array into database
                $result = $this->audio_model->upload_audio($data);

                // check $result is true or false
                // if $result is true then audio upload successfully done
                // failed to upload audio file throw error
                if ($result == true) {
                    $status = array(
                        'feedback'     => true,
                        'feedback_type' => 'success',
                        'feedback_msg' => 'Audio has been successfully uploaded.',
                    );
                    $this->session->set_userdata($status);
                    redirect('audio_manager');
                } else {
                    $status = array(
                        'feedback'     => true,
                        'feedback_type' => 'danger',
                        'feedback_msg' => 'Failed to upload audio. Please try again.',
                    );
                    $this->session->set_userdata($status);
                    redirect('audio_manager');
                }
            }
        }
    }

    // update form
    public function update_audio_form($audio_id = '')
    {
        // check $audio is not null and is integer
        if ($audio_id !== '' && is_integer(intval($audio_id))) {
            // get audio data from database;
            $audio_data['audio_data'] = $this->audio_model->get_audio_by_id($audio_id);

            // check content inside audio data array
            if ($audio_data['audio_data']) {
                $this->load->view('audio/form/update_audio_form', array_merge($this->global_data, $audio_data));
            } else {
                $msg =  'You have try to pass invalid audio id';
                show_error($msg);
            }
        } else {
            $msg = 'you have try to pass invalid input';
            show_error($msg);
        }
    }

    // update form action
    public function update_audio($audio_id = '')
    {
        if ($audio_id !== '' && $audio_id == $this->input->post('audio_id') && is_numeric(intval($audio_id))) {
            // form validation
            $this->form_validation->set_rules('audio_id', 'audio id', 'trim|required|integer');
            $this->form_validation->set_rules('audio_title', 'audio title', 'trim|required|min_length[6]|max_length[120]');
            $this->form_validation->set_rules('audio_tags', 'audio tags', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('audio_category', 'audio category', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('audio_desc', 'audio description', 'trim|required|min_length[15]|max_length[300]');

            // run validation
            if ($this->form_validation->run() == false) {
                // failed to validate form hence redirected to upload audio form
                $audio_data['audio_data'] = $this->audio_model->get_audio_by_id($audio_id);

                if ($audio_data['audio_data']) {
                    $this->load->view('audio/form/update_audio_form', array_merge($this->global_data, $audio_data));
                } else {
                    echo 'You have try to pass invalid audio id';
                }
            } else {
                // validation done
                // config upload audio path
                $upload_config = array(
                    // 'file_name'=> 'audio_1',
                    'upload_path'   => './assets/resource/audio/', //base_url().'assets/resource/audio/',
                    "overwrite"     => true,
                    'encrypt_name'  => true,
                    'remove_spaces' => true,
                    'allowed_types' => 'gif|mp3',
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
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    // file upload successfull
                    // clean inputs
                    $data = array(
                        'audio_title'          => clean_input($this->input->post('audio_title')),
                        'audio_tags'           => strtolower(clean_input(comma_format($this->input->post('audio_tags')))),
                        'audio_category'       => strtolower(clean_input(comma_format($this->input->post('audio_category')))),
                        'audio_desc'           => ucfirst(strtolower(clean_input($this->input->post('audio_desc')))),
                        'audio_file_name'      => $this->upload->data('file_name'),
                        'audio_file_type'      => $this->upload->data('file_type'),
                        'audio_file_full_path' => $this->upload->data('full_path'),
                        'audio_file_ext'       => $this->upload->data('file_ext'),
                        'audio_file_size'      => $this->upload->data('file_size'),
                        'audio_views'          => 0,
                        'audio_published'      => 1,
                    );

                    // store $data array into database
                    $audio_id = clean_input($this->input->post('audio_id'));
                    $result = $this->audio_model->update_audio($data, $audio_id);

                    // check $result is true or false
                    // if $result is true then audio upload successfully done
                    // failed to upload audio file throw error
                    if ($result == true) {
                        $status = array(
                            'feedback'     => true,
                            'feedback_type' => 'success',
                            'feedback_msg' => 'Audio file has been successfully updated.',
                        );
                        $this->session->set_userdata($status);
                        redirect('audio_manager');
                    } else {
                        $status = array(
                            'feedback'     => true,
                            'feedback_type' => 'danger',
                            'feedback_msg' => 'Failed to upload audio file.',
                        );
                        $this->session->set_userdata($status);
                        redirect('audio_manager');
                    }
                }
            }
        } else {
            $msg = 'you have try to pass invalid inputs, please try again';
            show_error($msg);
        }
    }

    // delete_audio_form
    public function delete_audio_form($audio_id = '')
    {
        if ($audio_id !== '' && is_integer(intval($audio_id))) {
            $audio_data['audio_data'] = $this->audio_model->get_audio_by_id($audio_id);

            if ($audio_data['audio_data']) {
                $this->load->view('audio/form/delete_audio_form', array_merge($this->global_data, $audio_data));
            } else {
                echo 'Your trying to delete audio which is not exist into database. Please try again.';
            }
        } else {
            echo 'Your trying delete audio without passing audio identity';
        }
    }

    // delete_audio
    public function delete_audio($audio_id = '')
    {
        if ($audio_id !== '' && is_integer(intval($audio_id))) {
            // form validation
            $this->form_validation->set_rules('audio_id', 'audio identity', 'trim|required|integer');
            $this->form_validation->set_rules('reason', 'reason', 'trim|required');
            $this->form_validation->set_rules('remark', 'remark', 'trim|min_length[15]|max_length[300]');

            $audio_data['audio_data'] = $this->audio_model->get_audio_by_id($audio_id);

            if ($audio_data['audio_data']) {
                $GLOBALS['table_content'] = '';

                foreach ($audio_data['audio_data'][0] as $key => $value) {
                    $temp = "key: $key and value: $value <br>";
                    $GLOBALS['table_content'] .= $temp;
                }

                $delete_reason = clean_input($this->input->post('reason'));
                $delete_remark = clean_input($this->input->post('remark'));

                $result = $this->delete_model->delete_table('audios_tb', $audio_id, $GLOBALS['table_content'], $delete_reason, $delete_remark);

                if ($result) {
                    $delete_result = $this->audio_model->delete_audio($audio_id);

                    if ($delete_result) {
                        $status = array(
                            'feedback'     => true,
                            'feedback_type' => 'success',
                            'feedback_msg' => 'Audio has been successfully deleted'
                        );
                        // add feedback into session
                        $this->session->set_userdata($status);
                        redirect('audio_manager');
                    } else {
                        $status = array(
                            'feedback'     => true,
                            'feedback_type' => 'danger',
                            'feedback_msg' => 'Failed to delete audio. Please try agian.',
                        );
                        // add feedback into session
                        $this->session->set_userdata($status);
                        redirect('audio_manager');
                    }
                } else {
                    $status = array(
                        'feedback'     => true,
                        'feedback_type' => 'danger',
                        'feedback_msg' => 'Failed to delete audio. Please try agian.',
                    );
                    // add feedback into session
                    $this->session->set_userdata($status);
                    redirect('audio_manager');
                }
            } else {
                echo 'Your trying to delete audio which is not exist into database. Please try again.';
            }
        } else {
            echo 'Your trying delete audio without passing audio identity';
        }
    }
}
