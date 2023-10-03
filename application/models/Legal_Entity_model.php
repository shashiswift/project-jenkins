<?php
class Legal_Entity_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    public function legalEntity_list($per_page, $page, $search,  $count = NULL){
        if($per_page != NULL || $page != NULL){
            $this->db->limit($per_page, $page); 
        }
        $this->db->order_by('created_on','DESC');

        if(!empty($search)){
            $this->db->like('LOWER(legal_entity_name)',$search);
        }
        

        $this->db->select('legal_entity_id, legal_entity_name, legal_entity_desc, created_on');
        $this->db->from('gmark_legal_entity_type');
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