<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Notes_model extends CI_Model
    {
        function get_all_notes()
        {
            $query = $this->db->get('notes_tb');
            return $query->result_array();
        }

        // insert new notes into database
        function insert_notes($data = '')
        {
          if($data !== ''){
            $query = $this->db->insert('notes_tb', $data);
            return $query;
          }else{
            return false;
          }
        }

        function get_notes_by_id($notes_id = '')
        {
            if($notes_id !== '' && is_integer(intval($notes_id))){
                $query= $this->db->get_where('notes_tb', array('note_id' => $notes_id));
                return $query->result_array();
            }else{
                return false;
            }
        }

        function update_notes($notes_id = '', $data = '')
        {
            if($notes_id !== '' && $data !== ''){
                $this->db->where('note_id', $notes_id);
                $query = $this->db->update('notes_tb', $data);
                return $query;
            }else{
                return false;
            }
        }

        function getNotesByCategory($needle = '', $optional_arg = ''){
          if($needle !== '' && $optional_arg === 'latest'){
            $this->db->order_by('note_id', 'DESC');
            $query = $this->db->get_where('notes_tb', array('note_category'=>$needle));
            return $query->result_array();
          }else{
            return false;
          }
        }
    }
