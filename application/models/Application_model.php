<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Application_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public  function get_application_list($per_page, $page = 0, $search, $where, $count = NULL)
    {
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $this->db->order_by('gmark_application.application_id', 'DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(gmark_application.application_name)', $search);
            $this->db->or_like('LOWER(gmark_application.application_desc)', $search);
            $this->db->group_end();
        }
        $this->db->select('gmark_application.*,users.first_name');
        $this->db->join('users', 'users.id = gmark_application.created_by', 'left');
        $this->db->from('gmark_application');
        $result = $this->db->get();
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

    // common function for getting data for dropdown

    public function get_data_from_table($select, $table)
    {
        $result = $this->db->select($select)
            ->from($table)
            ->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }


    // get countries

    public function get_countries($col = '*', $where = NULL, $where_in = NULL)
    {

        $this->db->select($col);
        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!empty($where_in)) {
            $this->db->where_in('country_id', $where_in);
        }

        $result = $this->db->get('mst_country');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    // insert gmark_registration 
    public function insert_gmarkRegistration($data)
    {
        $result = $this->db->insert('gmark_application_details', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function document_listing($where)
    {
        $this->db->select('document_registration.upload_path,documents.document_name,document_registration.doc_id,document_registration.registration_id');
        $this->db->join('documents', 'documents.document_id=document_registration.documents_id', 'left');
        $this->db->where($where);
        $document = $this->db->get('document_registration');
        if ($document->num_rows() > 0) {
            return $document->result();
        } else {
            return false;
        }
    }
    public function update_data($data)
    {
        $edit =  array(
            'application_name' => $data['application_name'],
            'application_desc' => $data['application_desc'],

        );
        $id = $data['application_id'];

        $result = $this->db->where('application_id', $id)->update('gmark_application', $edit);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function check_application_name($id){
$result = $this->db->where('application_id',$id)->select('gmark_application.application_name')->get('gmark_application');
if($result->num_rows() > 0){
     
    $result=$result->row();
    return $result->application_name;
}
else{
    return false;
}
    }
}
