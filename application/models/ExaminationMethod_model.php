<?php
class ExaminationMethod_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    public function examination_listing($per_page, $page, $search, $count = NULL){
        if($per_page != NULL || $page != NULL){
            $this->db->limit($per_page, $page); 
        }
        $this->db->order_by('created_on','DESC');

        if(!empty($search)){
            $this->db->like('LOWER(ex_method_name)',$search);
        }

        $this->db->select('ex_method_id, ex_method_name, ex_method_desc, created_on');
        $query = $this->db->get('gmark_examination_method');
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