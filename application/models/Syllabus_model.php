<?php defined('BASEPATH') or exit('No direct script access allowed');

class Syllabus_model extends CI_Model
{

    public function get_all_syllabus()
    {
        $query = $this->db->get('syllabus_tb');
        return $query->result_array();
    }

    public function get_syllabus_by_id($syllabus_id)
    {
        $query = $this->db->get_where('syllabus_tb', array('syllabus_id' => $syllabus_id));
        return $query->result_array();
    }

    public function insert_syllabus($data = '')
    {
        if ($data !== '') {
            $query = $this->db->insert('syllabus_tb', $data);
            return $query;
        } else {
            return false;
        }
    }

    public function update_syllabus($syllabus_id = '', $data = '')
    {
        if ($syllabus_id !== '' && $data !== '') {
            $this->db->where('syllabus_id', $syllabus_id);
            $query = $this->db->update('syllabus_tb', $data);
            return $query;
        } else {
            return false;
        }
    }

    public function getSyllabusByCategory($needle = '', $optional_arg = '')
    {
        if ($needle !== '' && $optional_arg === 'latest') {
            $this->db->order_by('syllabus_id', 'DESC');
            $query = $this->db->get_where('syllabus_tb', array('syllabus_category' => $needle));
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Delete syllabus from database using syllabus identity
     * @param  int $syllabusID - primary key of syllabus table
     * @param  string $reason - string of reason
     * @param  string $remark - string of remark
     * @return boolean - true if success else false
     */
    public function deleteSyllabus($syllabusID, $reason, $remark)
    {
        // first get syllabus data from database
        $query = $this->db->get_where('syllabus_tb', array('syllabus_id' => $syllabusID));

        if ($query->num_rows() === 1) {
            // prepare data to store into delete table
            $result      = $query->result_array();
            $outputArray = []; // empty output array to store temp. data

            foreach ($result[0] as $key => $value) {
                $temp = 'key: ' . $key . ' and value: ' . $value;
                array_push($outputArray, $temp);
            }

            // Join array elements with a string
            $outputString = implode(', ', $outputArray);

            $data = array(
                'delete_table_name' => 'syllabus_tb',
                'delete_table_id'   => $syllabusID,
                'delete_content'    => $outputString,
                'delete_reason'     => $remark,
                'delete_remark'     => $reason,
            );

            // store grab data into deletes_tb
            $query = $this->db->insert('deletes_tb', $data);

            // check successfully inserted into table or not
            if ($query) {
                // delete syllabus from syllabus_tb
                $query = $this->db->delete('syllabus_tb', array('syllabus_id' => $syllabusID));

                // check for table successfully deleted
                if ($query) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
