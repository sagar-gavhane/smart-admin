<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function login_check($email_address = '', $password = '')
    {
        if($email_address != '' && $password != ''){
            // email address and password contain some value
        
            // $hash_password = $this->db->query("SELECT `users_tb`.`user_password` FROM `users_tb` WHERE `users_tb`.`user_email_address` = '$email_address'");
    
            $this->db->select('*')->where('user_email_address', $email_address)->limit(1);
            $query = $this->db->get('users_tb');
            
            // check result num row
            if($query->num_rows() != 0){                
                $hash_password = $query->result_array(); // $hash_password[0]['user_password'];
                $hash_password = $hash_password[0]['user_password']; // store user password into hash_password variable
                
                if(password_verify($password, $hash_password)){
                    return true;
                }else{
                    return false;
                }                
            }else{
                return false;
            }
        }else{
            return false; // may be email address or password is empty.
        }
    }
}