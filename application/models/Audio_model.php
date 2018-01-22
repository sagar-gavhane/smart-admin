<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Audio_model extends CI_Model
{
    function get_all_audio($category='', $id = '')
    {
        // $category and $id both are null
        if($category === '' && $id === ''){
            $query = $this->db->get('audios_tb');
            return $query->result_array();
        }

        // $category have some value, $id is null
        if($category !== '' && $id === ''){
            $query = $this->db->get_where('audios_tb', array('audio_category'=>$category));
            return $query->result_array();
        }
    }

    // upload new audio into database
    function upload_audio($data = '')
    {
        if($data !== ''){
            $result = $this->db->insert('audios_tb', $data);
            return $result;
        }
    }

    function update_audio($data, $audio_id)
    {
        $query = $this->db->update('audios_tb', $data, array('audio_id'=>$audio_id));
        return (boolean)$query;
    }

    // get audio data from database using id
    function get_audio_by_id($audio_id)
    {
        $query = $this->db->get_where('audios_tb', array('audio_id'=>$audio_id));
        return $query->result_array();
    }

    // delete audio
    public function delete_audio($audio_id = '')
    {
        if($audio_id != ''){
            $this->db->where('audio_id', $audio_id);
            $query = $this->db->delete('audios_tb');
            return $query;
        }else{
            return false;
        }
    }

    public function get_by_key_value($key = '', $value = '', $number_of_records = '')
    {
        if($key !== '' && $value !== '' && $number_of_records == ''){
            $query = $this->db->get_where('audios_tb', array($key => $value));
            return $query->result_array();
        }elseif($key !== '' && $value !== '' && $number_of_records !== ''){
            if($number_of_records <= 10){
                $this->db->limit(10);
                $query = $this->db->get_where('audios_tb', array($key => $value));
            }else{
                $this->db->limit(10);
                $this->db->offset($number_of_records);
                $query = $this->db->get_where('audios_tb', array($key => $value));
            }
                return $query->result_array();

        }else{
            return false;
        }
    }

    public function getAudioByCategory($needle, $optional_arg = ''){
      // $needle = category_name
      if($needle !== '' && $optional_arg === 'latest'){
        $this->db->where('audio_category', $needle);
        $this->db->order_by('audio_id', 'DESC');
        $query = $this->db->get('audios_tb');
        return $query->result_array();
      }else{
        return false;
      }
    }
}
