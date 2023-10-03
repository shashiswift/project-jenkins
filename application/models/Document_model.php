<?php
class Document_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    public function document_list($per_page, $page, $search, $count = NULL){
        if($per_page != NULL || $page != NULL){
            $this->db->limit($per_page, $page); 
        }
        $this->db->order_by('documents.document_id','DESC');

        if(!empty($search)){
            $this->db->like('LOWER(document_name)',$search);
        }

        $this->db->select('*');
        $this->db->from('documents');
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
?>