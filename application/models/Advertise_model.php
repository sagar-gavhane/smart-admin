<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Advertise_model extends CI_Model
    {
        function getTenReceivedAds(){
        	$this->db->limit(10);
        	$this->db->order_by('received_ad_id', 'DESC');
        	$query = $this->db->get('received_ads');
        	return $query->result_array();
        }

        function getTenSendAds(){
        	$this->db->limit(10);
            $this->db->order_by('send_ad_id', 'DESC');
            $query = $this->db->get('send_ads');
            return $query->result_array();
        }

        function getAllReceivedAds(){        	
        	$this->db->order_by('received_ad_id', 'DESC');
        	$query = $this->db->get('received_ads');
        	return $query->result_array();
        }

        function getAllSendAds(){
            $this->db->order_by('send_ad_id', 'DESC');
            $query = $this->db->get('send_ads');
            return $query->result_array();
        }

        function insert_send_ads($data = ''){
        	if($data !== ''){
        		$query = $this->db->insert('send_ads', $data);
        		return $query;
        	}else{
        		return false;
        	}
        }
    }