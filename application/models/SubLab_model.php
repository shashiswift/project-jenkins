<?php
class SubLab_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    public function get_sublab_list($per_page, $page, $search, $lab_type, $count = NULL){
        if($per_page != NULL || $page != NULL){
            $this->db->limit($per_page, $page); 
        }
        $this->db->order_by('created_on','DESC');

        if(!empty($search)){
            $this->db->like('LOWER(gmark_sub_laboratory_type.Sub_lab_name)',$search);
        }
        if(!empty($lab_type)){
            $this->db->where('gmark_laboratory_type.lab_id',$lab_type);
        }

        $this->db->select('Sub_lab_id, lab_name, Sub_lab_name, Sub_lab_desc, gmark_sub_laboratory_type.created_on');
        $this->db->from('gmark_sub_laboratory_type');
        $this->db->join('gmark_laboratory_type','lab_id = gmark_laboratory_type_id');
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