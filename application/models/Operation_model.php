<?php

class Operation_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function get_operation_list($per_page, $page = 0, $search, $where, $count = NULL)
    {
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $this->db->order_by('functions.function_id', 'DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(functions.controller_name)', $search);
            $this->db->or_like('LOWER(functions.function_name)', $search);
            $this->db->or_like('LOWER(functions.alias)', $search);
            $this->db->group_end();
        }
        $result = $this->db->get('functions');
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
