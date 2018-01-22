<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model
{
    // upload new video into database
    public function upload_video($data = '')
    {
        if($data !== ''){
            $result = $this->db->insert('videos_tb', $data);
            $affected_rows = $this->db->affected_rows();
            if($affected_rows != 0){
                return true;
            }else{
                return false;
            }
        }
    }

    // check video id already exist in database or not
    public function check_video_id($id){
        $query = $this->db->get_where('videos_tb', array('video_youtube_id'=>$id));
        $num_rows = $query->num_rows();

        if($num_rows != 0){
            return true; // if exist
        }else{
            return false; // if not exist
        }
    }

    // get video id from url
    public function get_video_id($url = ''){
        if($url !== ''){
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
            return $my_array_of_vars;
        }else{
            return false;
        }
    }

    // get video details by using key and value pair
    public function get_by_key_value($key = '', $value = '', $number_of_records = '')
    {
        if($key !== '' && $value !== '' && $number_of_records == ''){
            $query = $this->db->get_where('videos_tb', array($key => $value));
            return $query->result_array();
        }elseif($key !== '' && $value !== '' && $number_of_records !== ''){
            if($number_of_records <= 10){
                $this->db->limit(10);
                $query = $this->db->get_where('videos_tb', array($key => $value));
            }else{
                $this->db->limit(10);
                $this->db->offset($number_of_records);
                $query = $this->db->get_where('videos_tb', array($key => $value));
            }
                return $query->result_array();

        }else{
            return false;
        }
    }

    // string format in comma separated
    public function comma_format($string = '')
    {
        if($string !== ''){
            // temp array variable
            $tempArray = Array();
            // result array variable
            $resultArray = Array();

            // string to array convert
            $copyArray = explode(',', $string);

            foreach ($copyArray as $key => $value) {
                // clean inputs and push into result array
                array_push($resultArray, clean_input($value));
            }

            // array to string convert
            $resultArray = implode (",", $resultArray);

            return $resultArray;
        }
    }

    // get all videos from table in array format
    public function get_all_video($video_count = '')
    {
        // if video_count is null
        if($video_count === ''){
            $query = $this->db->get('videos_tb');
            return $query->result_array();
        }else if($video_count == '10') {
            $this->db->limit(10);
            $query = $this->db->get('videos_tb');
            return $query->result_array();
        }else if($video_count !== ''){
            $offset = (int)$video_count;
            $this->db->limit($offset, 10);
            $query = $this->db->get('videos_tb');
            return $query->result_array();
        }
    }

    // get all popular video from datbaase and return into array format
    public function get_all_popular_video($video_count = '')
    {
        if($video_count !== ''){
            $query = $this->db->query('SELECT * FROM videos_tb order by video_views desc limit 10');
            return $query->result_array();
        }
    }

    // get single video row by id
    public function get_video_by_id($video_id = '')
    {
        if($video_id !== ''){
            $query = $this->db->get_where('videos_tb', array('video_id'=>$video_id));
            return $query->result_array();
        }else{
            return false;
        }
    }

    // delete video
    public function delete_video($video_id = '')
    {
        if($video_id != ''){
            $this->db->where('video_id', $video_id);
            $query = $this->db->delete('videos_tb');
            return $query;
        }else{
            return false;
        }
    }

    public function getVideoByCategory($needle, $optional_arg = ''){
      // $needle = category_name
      if($needle !== '' && $optional_arg === 'latest'){
        $this->db->where('video_category', $needle);
        $this->db->order_by('video_id', 'DESC');
        $query = $this->db->get('videos_tb');
        return $query->result_array();
      }else{
        return false;
      }
    }

    public function update_video($data, $video_id)
    {
        $query = $this->db->update('videos_tb', $data, array('video_id' => $video_id));
        return (boolean)$query;
    }
}
