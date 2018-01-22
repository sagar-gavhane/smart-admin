<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delete_model extends CI_Model
{
    public function delete_table($table_name, $table_id, $table_content, $reason, $remark = '')
    {
        if ($remark !== '') {
            $data = array(
                'delete_table_name' => $table_name,
                'delete_table_id'   => $table_id,
                'delete_content'    => $table_content,
                'delete_reason'     => $reason,
                'delete_remark'     => $remark,
            );

            $query = $this->db->insert('deletes_tb', $data);
            return $query;
        } else {
            return false;
        }
    }
}
