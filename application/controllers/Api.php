<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->model(array('video_model', 'audio_model', 'notes_model', 'question_model', 'syllabus_model', 'job_model', 'advertise_model'));
        // $this->output->enable_profiler(TRUE);
    }

    public function video($action, $needle = '', $optional_arg = ''){
      // $action = category, $needle = category_name, $optional_arg = latest
      $action = strtolower(clean_input($action));
      $needle = strtolower(clean_input($needle));
      $optional_arg = strtolower(clean_input($optional_arg));

      if($action === 'category' && $needle !== '' && $optional_arg === 'latest'){
        $video_data = $this->video_model->getVideoByCategory($needle, $optional_arg);
        $this->output->set_content_type('application/json')->set_output(json_encode($video_data));
      }elseif($action === 'id' && $needle !== ''){
        // get video of single video and $arg as video id
        $video_data = $this->video_model->get_video_by_id($needle);
        $this->output->set_content_type('application/json')->set_output(json_encode($video_data));
      }else{
        return false;
      }
    }

    public function audio($action = '', $needle = '', $optional_arg = '')
    {
        // turn all into lowercase
        $action = strtolower(clean_input($action));
        $needle = strtolower(clean_input($needle));
        $optional_arg = strtolower(clean_input($optional_arg));

        if($action === 'category' && $needle !== '' && $optional_arg === 'latest'){
            $audio_data = $this->audio_model->getAudioByCategory($needle, $optional_arg);
            $this->output->set_content_type('application/json')->set_output(json_encode($audio_data));
        }elseif($action === 'single' && $needle !== ''){
          // get single audio from database using $needle as audio_id
          $audio_data = $this->audio_model->get_audio_by_id($needle);
          $this->output->set_content_type('application/json')->set_output(json_encode($audio_data));
        }else{
          return false;
        }
    }

    public function notes($action = '', $needle = '', $optional_arg = ''){
      // turn all into lowercase
      $action = strtolower(clean_input($action));
      $needle = strtolower(clean_input($needle));
      $optional_arg = strtolower(clean_input($optional_arg));



      // action = category, $needle = categoryName, $optional_arg = 'latest'
      if($action === 'category' && $needle !== '' && $optional_arg === 'latest'){
        $notes_data = $this->notes_model->getNotesByCategory($needle, $optional_arg);
        $this->output->set_content_type('application/json')->set_output(json_encode($notes_data));
      }elseif($action === 'id' && $needle !== ''){
        // action = id and $needle is note_id
        $notes_data = $this->notes_model->get_notes_by_id($needle);
        $this->output->set_content_type('application/json')->set_output(json_encode($notes_data));
      }else{
        return false;
      }
    }

    public function question($action = '', $needle = '', $optional_arg = ''){

      // turn all into lowercase
      $action = strtolower(clean_input($action));
      $needle = strtolower(clean_input($needle));
      $optional_arg = strtolower(clean_input($optional_arg));

      if($action === 'category' && $needle !== '' && $optional_arg === 'latest'){
        $question_data = $this->question_model->getQuestionByCategory($needle, $optional_arg);
        $this->output->set_content_type('application/json')->set_output(json_encode($question_data));
      }elseif($action === 'id' && $needle !== ''){
        $question_data = $this->question_model->get_question_by_id($needle);
        $this->output->set_content_type('application/json')->set_output(json_encode($question_data));
      }else{
        return false;
      }
    }

    public function syllabus($action = '', $needle = '', $optional_arg = ''){
      // turn all into lowercase
      $action = strtolower(clean_input($action));
      $needle = strtolower(clean_input($needle));
      $optional_arg = strtolower(clean_input($optional_arg));

      if($action === 'category' && $needle !== '' && $optional_arg === 'latest'){
        $syllabus_data = $this->syllabus_model->getSyllabusByCategory($needle, $optional_arg);
        $this->output->set_content_type('application/json')->set_output(json_encode($syllabus_data));
      }else if($action === 'id' && $needle !== ''){
        $syllabus_data = $this->syllabus_model->get_syllabus_by_id($needle);
        $this->output->set_content_type('application/json')->set_output(json_encode($syllabus_data));
      }else{
        return false;
      }
    }

    public function jobs($action = '', $needle = '', $optional_arg = ''){
      // turn all into lowercase
      $action = strtolower(clean_input($action));
      $needle = strtolower(clean_input($needle));
      $optional_arg = strtolower(clean_input($optional_arg));

      if($action === 'category' && $needle !== '' && $optional_arg === 'latest'){
        $jobs_data = $this->job_model->getJobsByCategory($needle, $optional_arg);
        $this->output->set_content_type('application/json')->set_output(json_encode($jobs_data));
      }else if($action === 'id' && $needle !== ''){
        $jobs_data = $this->job_model->get_job_by_id($needle);
        $this->output->set_content_type('application/json')->set_output(json_encode($jobs_data));
      }else{
        return false;
      }
    }

    public function ads_send(){
        $data = array(
            'received_ad_full_name' => $this->input->post('fullName'),
            'received_ad_contact_number' => $this->input->post('contactNumber'),
            'received_ad_email_address' => $this->input->post('emailAddress'),
            'received_ad_message' => $this->input->post('message')
        );
        
        $this->db->insert('received_ads', $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(true));
    }

    public function view_ads(){
    	$send_ads_data = $this->advertise_model->getAllSendAds();
    	$this->output->set_content_type('application/json')->set_output(json_encode($send_ads_data));
    }

    public function test()
    {
        echo json_encode('test done');
    }
}
