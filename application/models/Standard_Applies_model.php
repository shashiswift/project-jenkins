<?php

class Standard_Applies_model extends MY_Model
{
    function make_query($post)
    {
        $this->db->select(['c.id', 'c.standard', 'c.year', '(CONCAT(u.first_name, " ", u.last_name)) as user_name', 'DATE_FORMAT(c.created_on, "%d/%m/%Y") as created_on',  'c.status'])
                ->from('standard_applies c')
                ->join('users u', 'c.created_by = u.id', 'left');
        if (isset($post['search']['value']) && !empty($post['search']['value'])) {
            $this->db->like('c.standard', $post['search']['value']);
            $this->db->or_like('c.year', $post["search"]["value"]);  
            $this->db->or_like('CONCAT(u.first_name, " ", u.last_name)', $post["search"]["value"]);  
        }
        if (isset($post["order"])) {
            $this->db->order_by(['c.id', 'c.standard', 'c.year', 'c.created_by', 'c.created_on', 'c.status'][$post['order']['0']['column']], $post['order']['0']['dir']);
        } else {
            $this->db->order_by('c.id', 'DESC');
        }
    }

    function fetch_records($post)
    {
        $this->make_query($post);
        if ($post["length"] != -1) {
            $this->db->limit($post['length'], $post['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data($post)
    {
        $this->make_query($post);
        return $this->db->get()->num_rows();
    }

    function get_all_data()
    {
        return $this->db->select('*')->from('standard_applies')->count_all_results();
    }

    public function check_code($id, $standard)
    { 
        $this->db->where_not_in('id', $id);
        $this->db->where(['LOWER(standard)' => strtolower($standard)]);
        $query = $this->db->get('standard_applies');
        return ($query->num_rows() > 0) ? true : false;
    }

    public function check_name($id, $year)
    { 
        $this->db->where_not_in('id', $id);
        $this->db->where(['LOWER(year)' => strtolower($year)]);
        $query = $this->db->get('standard_applies');
        return ($query->num_rows() > 0) ? true : false;
    }

    public function standard_applies_log($record_id)
    {
        $query = $this->db->select('CONCAT(u.first_name, " ", u.last_name) as full_name, c.record_id, c.source_module, c.operation, c.action_message, DATE_FORMAT(c.activity_on, "%d-%b-%Y %r") as activity_on')
            ->join('users u', 'c.admin_id = u.id', 'left')
            ->where(['c.record_id' => $record_id, 'source_module' => 'standard_applies'])
            ->order_by('c.log_id', 'DESC')
            ->get('standard_applies_log c');
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }
}
