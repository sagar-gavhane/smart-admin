<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Job_model extends CI_Model
    {
        function insert_job($data = '')
        {
            if($data !== ''){
                $query = $this->db->insert('jobs_tb', $data);
                return $query;
            }
        }

        function get_all_jobs()
        {
            $query = $this->db->get('jobs_tb');
            return $query->result_array();
        }

        function get_job_by_id($job_id = '')
        {
            $query = $this->db->get_where('jobs_tb', array('job_id'=>$job_id));
            return $query->result_array();
        }

        function update_job($job_id = '', $data = '')
        {
            if($job_id !== '' && $data !== ''){
                $this->db->where('job_id', $job_id);
                $query = $this->db->update('jobs_tb', $data);
                return $query;
            }else{
                return false;
            }
        }

        function getJobsByCategory($needle = '', $optional_arg = ''){
          // echo $needle;
          if($needle !== '' && $optional_arg === 'latest'){
            $this->db->order_by('job_id', 'DESC');
            $query = $this->db->get_where('jobs_tb', array('job_category'=> $needle));
            return $query->result_array();
          }else{
            return false;
          }
        }

        /**
     * Delete job from database using job identity
     * @param  int $jobID - primary key of job table
     * @param  string $reason - string of reason
     * @param  string $remark - string of remark
     * @return boolean - true if success else false
     */
    public function deleteJob($jobID, $reason, $remark)
    {
        // first get job data from database
        $query = $this->db->get_where('jobs_tb', array('job_id' => $jobID));

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
                'delete_table_name' => 'jobs_tb',
                'delete_table_id'   => $jobID,
                'delete_content'    => $outputString,
                'delete_reason'     => $remark,
                'delete_remark'     => $reason,
            );

            // store grab data into deletes_tb
            $query = $this->db->insert('deletes_tb', $data);

            // check successfully inserted into table or not
            if ($query) {
                // delete syllabus from syllabus_tb
                $query = $this->db->delete('jobs_tb', array('job_id' => $jobID));

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
