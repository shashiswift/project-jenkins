<?php
class Customer_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    public function customer_listing($per_page, $page,$where,$search, $count = NULL){
        if($per_page != NULL || $page != NULL){
            $this->db->limit($per_page, $page); 
        }
        $this->db->order_by('created_on','DESC');

        if(!empty($search)){
            $this->db->like('LOWER(gmark_customers.entity_name)',$search);
            $this->db->or_like('LOWER(gmark_customers.contact_name)',$search);
            $this->db->or_like('LOWER(gmark_customers.contact_title)',$search);
            $this->db->or_like('LOWER(gmark_customers.department)',$search);
            $this->db->or_like('LOWER(gmark_customers.email)',$search);
        }
        $this->db->select('customers_id, entity_name, address, country_name, contact_name, contact_title, department, phn_no, email, (case when gmark_customers.status = 1 then "Active" else "Inacive" end) as status, gmark_customers.created_on, customer_type_name');
        $this->db->join('mst_country','mst_country.country_id = gmark_customers.country','left');
        $this->db->join('customer_type','customer_type_id = customer_type','left');
        if (count($where)>0) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        $query = $this->db->get('gmark_customers');
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