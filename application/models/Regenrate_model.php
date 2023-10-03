<?php

class Regenrate_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function get_reports_list($per_page, $page, $search, $where, $count = NULL)
    {
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $this->db->order_by('re_generate_request.id', 'DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(re_generate_request.coc_number)', $search);
            $this->db->or_like('LOWER(job_number.job_no)', $search);
            $this->db->or_like('LOWER(gmark.seq_no)', $search);
            $this->db->group_end();
        }
        $this->db->select('DISTINCT(re_generate_request.id) as id,re_generate_request.registration_id,job_number.job_no,re_generate_request.coc_number,gmark.seq_no,re_generate_request.created_on,re_generate_request.status');
        $this->db->from('re_generate_request');
        $this->db->join('gmark_registration as gmark', 're_generate_request.registration_id=gmark.registration_id', 'left');
        $this->db->join('job_number', 'job_number.registration_id=re_generate_request.registration_id', 'left');
        $this->db->join('report_content', 'report_content.registration_id=gmark.registration_id', 'left');
        if ($count == '1') {
            // $this->db->get_compiled_select(); for last query
            return $this->db->count_all_results();
        } else {
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                return $result->result();
            } else {
                return false;
            }
        }
    }
}
