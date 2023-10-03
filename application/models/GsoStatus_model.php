<?php
class GsoStatus_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    public function get_lab_list($per_page, $page, $search, $count = NULL){
        if($per_page != NULL || $page != NULL){
            $this->db->limit($per_page, $page); 
        }
        $this->db->order_by('created_on','DESC');
        if(!empty($search)){
            $this->db->like('LOWER(name)',$search);
        }
        $this->db->select('id, name, created_on');
        $this->db->from('gso_status');
        $query = $this->db->get();
        if($count == '1'){
            return $query->num_rows();
        } else {
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }
}
