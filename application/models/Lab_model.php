<?php
class Lab_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    public function get_lab_list($per_page, $page, $search, $count = NULL){
        if($per_page != NULL || $page != NULL){
            $this->db->limit($per_page, $page); 
        }
        $this->db->order_by('created_on','DESC');

        if(!empty($search)){
            $this->db->like('LOWER(lab_name)',$search);
        }

        $this->db->select('lab_id, lab_name, lab_desc, created_on');
        $this->db->from('gmark_laboratory_type');
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
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

?>