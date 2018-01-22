<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Question_model extends CI_Model
    {
        function insert_question($data = '')
        {
            if($data !== ''){
                $query = $this->db->insert('questions_tb', $data);
                return $query;
            }
        }

        function get_all_questions()
        {
            $query = $this->db->get('questions_tb');
            return $query->result_array();
        }

        function get_question_by_id($question_id = '')
        {
            $query = $this->db->get_where('questions_tb', array('question_id'=>$question_id));
            return $query->result_array();
        }

        function update_question($question_id = '', $data = '')
        {
            if($question_id !== '' && $data !== ''){
                $this->db->where('question_id', $question_id);
                $query = $this->db->update('questions_tb', $data);
                return $query;
            }else{
                return false;
            }
        }

        function getQuestionByCategory($needle = '', $optional_arg = ''){
          if($needle !== '' && $optional_arg === 'latest'){
            $this->db->order_by('question_id', 'DESC');
            $query = $this->db->get_where('questions_tb', array('question_category' => $needle));
            return $query->result_array();
          }else{
            return false;
          }
        }

    /**
     * Delete question from database using question identity
     * @param  int $questionID - primary key of question table
     * @param  string $reason - string of reason
     * @param  string $remark - string of remark
     * @return boolean - true if success else false
     */
    public function deleteQuestion($questionID, $reason, $remark)
    {
        // first get syllabus data from database
        $query = $this->db->get_where('questions_tb', array('question_id' => $questionID));

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
                'delete_table_name' => 'questions_tb',
                'delete_table_id'   => $questionID,
                'delete_content'    => $outputString,
                'delete_reason'     => $remark,
                'delete_remark'     => $reason,
            );

            // store grab data into deletes_tb
            $query = $this->db->insert('deletes_tb', $data);

            // check successfully inserted into table or not
            if ($query) {
                // delete syllabus from syllabus_tb
                $query = $this->db->delete('questions_tb', array('question_id' => $questionID));

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
