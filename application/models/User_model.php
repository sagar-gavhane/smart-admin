<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getUserByEmail($email_address = '')
    {
        if($email_address !== ''){
            $result = $this->db->get_where('users_tb', array('user_email_address' => $email_address));
            return $result->result_array();
        }else{
            return false;
        }
    }
}