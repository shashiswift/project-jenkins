<?php

class Request_option_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }


    public  function get_req_list($per_page, $page, $search, $where, $count = NULL)
    {
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $this->db->order_by('req.request_option_id', 'DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(client.entity_name)', $search);
            $this->db->or_like('LOWER(req.certificate_no)', $search);
            $this->db->or_like('LOWER(req.testing_start_date)', $search);
            $this->db->or_like('LOWER(req.testing_end_date)', $search);
            $this->db->or_like('LOWER(req.payment_status)', $search);
            $this->db->or_like('LOWER(req.created_on)', $search);
            $this->db->group_end();
        }
        $this->db->select('req.*,client.entity_name as client_name');
        $this->db->join('gmark_customers client', 'client.customers_id=req.customers_id', 'left');
        $result = $this->db->get('gmark_request_options req');
        if ($count == '1') {
            return $result->num_rows();
        } else {
            if ($result->num_rows() > 0) {
                return $result->result();
            } else {
                return false;
            }
        }
    }
}
