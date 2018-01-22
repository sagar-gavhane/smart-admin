<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Video Manager Controller
 */
class Video_manager extends CI_Controller
{
    public $global_data = array();

    public function __construct()
    {
        parent::__construct();
        // load models
        $this->load->model(array('video_model', 'delete_model'));

        // initilize global data
        $this->global_data['page_name']  = 'video';
        $this->global_data['page_title'] = 'Video Manager';
        $this->global_data['header']     = $this->load->view('template/header', $this->global_data, true);
        $this->global_data['navbar']     = $this->load->view('template/navbar', $this->global_data, true);
        $this->global_data['feedback'] = $this->load->view('template/feedback', null, true);
        $this->global_data['footer']     = $this->load->view('template/footer', null, true);
    }

    /**
     * default index
     *
     * @return void
     */
    public function index()
    {
        $video_details['video_details'] = $this->video_model->get_all_video();
        $video_details['video_details'] = array_reverse($video_details['video_details']); // array reverse to show latest video first
        $this->load->view('video/default_view', array_merge($this->global_data, $video_details));
    }

    public function upload_video_form()
    {
        $this->load->view('video/form/upload_video_form', array_merge($this->global_data));
    }

    public function insert_video()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('video_manager');
        }
        // form validtion
        $this->form_validation->set_rules('video_youtube_link', 'youtube link', 'trim|required|valid_url|regex_match[/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/]');
        $this->form_validation->set_rules('video_title', 'video title', 'trim|required|min_length[6]|max_length[120]');
        $this->form_validation->set_rules('video_tags', 'video tags', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('video_category', 'video category', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('video_desc', 'video description', 'trim|required|min_length[15]|max_length[300]');

        // run validation
        if ($this->form_validation->run() == false) {
            // load upload video form
            $this->load->view('video/form/upload_video_form', array_merge($this->global_data));
        } else {
            // extract youtube video id from youtube link
            $youtube_video_id = $this->video_model->get_video_id(clean_input($this->input->post('video_youtube_link', true)));

            // check status of video id
            $video_id_status = $this->video_model->check_video_id($youtube_video_id['v']);

            // video tags format
            $video_tags = $this->video_model->comma_format($this->input->post('video_tags', true));

            // video category format
            $video_category = $this->video_model->comma_format($this->input->post('video_category', true));

            // if video id is not already in database
            if ($video_id_status === false) {
                $data = array(
                    'video_youtube_id'   => clean_input($youtube_video_id['v']),
                    'video_youtube_link' => clean_input($this->input->post('video_youtube_link', true)),
                    'video_title'        => ucfirst(strtolower(clean_input($this->input->post('video_title', true)))),
                    'video_tags'         => strtolower($video_tags),
                    'video_category'     => strtoupper($video_category),
                    'video_desc'         => ucfirst(strtolower(clean_input($this->input->post('video_desc', true)))),
                    'video_views'        => 0,
                    'video_published'    => 0,
                );

                // store return result into $store_result variable
                $store_result = $this->video_model->upload_video($data);

                // check video is successfully stored or not
                if ($store_result === true) {
                    // video upload successfully
                    $result = array(
                        'feedback'     => true,
                        'feedback_type' => 'success',
                        'feedback_msg' => 'video_uploaded_successfully',
                    );
                    // add feedback into session
                    $this->session->set_userdata($result);
                    $get_video_details = $this->video_model->get_by_key_value('video_youtube_id', $youtube_video_id['v']);

                    // store video id into variable
                    $video_id = $get_video_details[0]['video_id'];

                    // redirect to view video page with video id
                    redirect("video_manager/view_video/" . $video_id);
                } else {
                    // video uploading failed
                    $result = array(
                        'feedback'     => true,
                        'feedback_type' => 'danger',
                        'feedback_msg' => 'Failed to update video. Please try again.',
                    );
                    // add feedback into session
                    $this->session->set_userdata($result);
                    // reload upload video form with error message
                    $this->load->view('video/form/upload_video_form', array_merge($this->global_data));
                }
            } else {
                // if video already exist
                $result = array(
                    'feedback'     => true,
                    'feedback_type' => 'warning',
                    'feedback_msg' => 'Video already exist into database',
                );
                // add feedback into session
                $this->session->set_userdata($result);
                // reload upload video form with error message
                $this->load->view('video/form/upload_video_form', array_merge($this->global_data));
            }
        }
    }

    // view video by id
    public function view_video($video_id = '')
    {
        if ($video_id !== '') {
            $video_details['video_details'] = $this->video_model->get_video_by_id($video_id);
            $this->load->view('video/single_video_view', array_merge($this->global_data, $video_details));
        } else {
            echo 'You have tried to access video without passing video identity.';
        }
    }

    // delete_video_form
    public function delete_video_form($video_id = '')
    {
        if ($video_id !== '' && is_integer(intval($video_id))) {
            $video_data['video_data'] = $this->video_model->get_video_by_id($video_id);

            if ($video_data['video_data']) {
                $this->load->view('video/form/delete_video_form', array_merge($this->global_data, $video_data));
            } else {
                echo 'Your trying to delete video which is not exist into database. Please try again.';
            }
        } else {
            echo 'Your trying delete video without passing video identity';
        }
    }

    // delete_video
    public function delete_video($video_id = '')
    {
        if ($video_id !== '' && is_integer(intval($video_id))) {
            // form validation
            $this->form_validation->set_rules('video_id', 'video identity', 'trim|required|integer');
            $this->form_validation->set_rules('reason', 'reason', 'trim|required');
            $this->form_validation->set_rules('remark', 'remark', 'trim|min_length[15]|max_length[300]');

            $video_data['video_data'] = $this->video_model->get_video_by_id($video_id);

            if ($video_data['video_data']) {
                $GLOBALS['table_content'] = '';

                foreach ($video_data['video_data'][0] as $key => $value) {
                    $temp = "key: $key and value: $value <br>";
                    $GLOBALS['table_content'] .= $temp;
                }

                $delete_reason = clean_input($this->input->post('reason'));
                $delete_remark = clean_input($this->input->post('remark'));

                $result = $this->delete_model->delete_table('videos_tb', $video_id, $GLOBALS['table_content'], $delete_reason, $delete_remark);

                if ($result) {
                    $delete_result = $this->video_model->delete_video($video_id);

                    if ($delete_result) {
                        $status = array(
                            'feedback'     => true,
                            'feedback_type' => 'success',
                            'feedback_msg' => 'Video has been successfully deleted from database',
                        );
                        // add feedback into session
                        $this->session->set_userdata($status);
                        redirect('video_manager');
                    } else {
                        $status = array(
                            'feedback'     => true,
                            'feedback_type' => 'danger',
                            'feedback_msg' => 'Failed to delete video from database. Please try again',
                        );
                        // add feedback into session
                        $this->session->set_userdata($status);
                        redirect('video_manager');
                    }
                } else {
                    $status = array(
                        'feedback'     => true,
                        'feedback_type' => 'danger',
                        'feedback_msg' => 'Failed to delete video from database. Please try again',
                    );
                    // add feedback into session
                    $this->session->set_userdata($status);
                    redirect('video_manager');
                }
            } else {
                echo 'Your trying to delete video which is not exist into database. Please try again.';
            }
        } else {
            echo 'Your trying delete video without passing video identity';
        }
    }

    public function update_video_form($video_id = '')
    {
        $video_id = intval(clean_input($video_id));

        if (is_integer($video_id) && $video_id !== 0) {
            $data['video_id']   = $video_id;
            $data['video_data'] = $this->video_model->get_video_by_id($video_id);
            $this->load->view('video/form/update_video_form_view', array_merge($this->global_data, $data));
        } else {
            $msg = 'You are try to update video without passing valid video identity. Please pass valid video identity';
            show_error($msg);
        }
    }

    public function update_video_process()
    {
        $this->output->enable_profiler(true);
        // form validation
        $this->form_validation->set_rules('video_id', 'video identity', 'trim|required|integer');
        $this->form_validation->set_rules('video_youtube_id', 'video youtube id', 'trim|required');
        $this->form_validation->set_rules('youtube_link', 'video link', 'trim|required|valid_url');
        $this->form_validation->set_rules('youtube_title', 'youtube title', 'trim|required');
        $this->form_validation->set_rules('youtube_tags', 'youtube tags', 'trim|required');
        $this->form_validation->set_rules('video_category', 'youtube tags', 'trim|required');
        $this->form_validation->set_rules('description', 'video description', 'trim|required');

        $video_id = clean_input($this->input->post('video_id'));

        // run validation
        if ($this->form_validation->run() == false) {
            $this->update_video_form($video_id);
        }else{
            // validation done
            $video_id = clean_input($this->input->post('video_id'));
            $video_youtube_id = $this->video_model->get_video_id(clean_input($this->input->post('youtube_link')));
            $youtube_link = clean_input($this->input->post('youtube_link'));
            $youtube_title = clean_input($this->input->post('youtube_title'));
            $youtube_tags = clean_input($this->input->post('youtube_tags'));
            $youtube_category = clean_input($this->input->post('video_category'));
            $youtube_description = clean_input($this->input->post('description'));

            $data = array(
                'video_youtube_id' => $video_youtube_id['v'],
                'video_youtube_link' => $youtube_link,
                'video_title' => $youtube_title,
                'video_tags' => $youtube_tags,
                'video_category' => $youtube_category,
                'video_desc' => $youtube_description,
            );

            $result = $this->video_model->update_video($data, $video_id);

            if($result){
                $sessionData = array(
                    'feedback' => true,
                    'feedback_type' => 'success',
                    'feedback_msg' => 'Video has been successfully updated.'
                );
                
                $this->session->set_userdata( $sessionData );
                redirect('video_manager');
            }else{
                $sessionData = array(
                    'feedback' => true,
                    'feedback_type' => 'danger',
                    'feedback_msg' => 'Something went wrong. Failed to update video.'
                );
                
                $this->session->set_userdata( $sessionData );
                redirect('video_manager');
            }
        }
    }
}
