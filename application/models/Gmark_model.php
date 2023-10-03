<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gmark_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public  function get_gmark_list($per_page, $page, $search, $where, $count = NULL)
    {
        $this->db->order_by('gmark.registration_id', 'DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(gmark.seq_no)', $search);
            $this->db->or_like('LOWER(gmark.certificate_no)', $search);
            $this->db->or_like('LOWER(gmark.test_report_no)', $search);
            $this->db->or_like('LOWER(applicant.entity_name)', $search);
            $this->db->or_like('LOWER(manufacturer.entity_name)', $search);
            $this->db->or_like('LOWER(licensee.entity_name)', $search);
            $this->db->group_end();
        }
        
        $this->db->from('gmark_registration as gmark');
        $this->db->join('gmark_laboratory_type as lab', 'lab.lab_id=gmark.lab_id', 'left');
        $this->db->join('gmark_sub_laboratory_type as sub_lab', 'sub_lab.Sub_lab_id=gmark.sub_lab_id', 'left');
        $this->db->join('gmark_customers as applicant', 'applicant.customers_id=gmark.applicant_id', 'left');
        $this->db->join('gmark_customers as manufacturer ', 'manufacturer.customers_id=gmark.manufacturer_id', 'left');
        $this->db->join('gmark_customers as factory', 'FIND_IN_SET(factory.customers_id,gmark.factory_id) <> 0', 'left', false);
        $this->db->join('gmark_customers as licensee', 'licensee.customers_id=gmark.licensee_id', 'left');
        $this->db->join('mst_country', 'FIND_IN_SET(mst_country.country_id,gmark.destination) <> 0', 'left', false);
        $this->db->join('gmark_application', 'gmark_application.application_id=gmark.application_type', 'left');
        $this->db->group_by('gmark.registration_id');
        
        if ($count == '1')  return $this->db->select('gmark.registration_id')->count_all_results(); //FOR COUNT
        
        $this->db->join('rfc_document', 'rfc_document.registration_id=gmark.registration_id and rfc_document.pdf_genrate < 1', 'left');
        $this->db->select('DISTINCT(gmark.registration_id) as registration_id, gmark.cancelled_request ,gmark.status,gmark.reg_status,gmark.seq_no,gmark.certificate_no,gmark.test_report_no,gmark.created_on,gmark_application.application_name as application_name,applicant.entity_name as applicant_name,manufacturer.entity_name as manufacturer_name,GROUP_CONCAT( DISTINCT factory.entity_name) as factory_name,licensee.entity_name as licensee_name,lab.lab_name as lab_name,sub_lab.Sub_lab_name as sub_lab_name,GROUP_CONCAT(DISTINCT mst_country.country_name) as destination_name,rfc_document.rfc_id,( SELECT COUNT(DISTINCT documents.document_id) FROM documents JOIN document_registration ON document_registration.documents_id=documents.document_id WHERE documents.doc_need > 0 AND document_registration.registration_id=gmark.registration_id )as upload_document');
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
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

    public function get_destination()
    {

       $sql="select country_id,gso_country_code as country_name from mst_country  where gso_country_code IS NOT NULL order by priority_order asc";

        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
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

    public function rfc_pdf($where)
    {

        $this->db->select('rfc_document.*,gmark_registration.seq_no,concat(exporter.entity_name,", ",exporter.address) as exporter_name,exporter.phn_no as exporter_phn_no,exporter.email as exporter_email,exporter.contact_name as exporter_contact,concat(importer.entity_name,", ",importer.address) as importer_name,importer.phn_no as importer_phn_no,importer.email as importer_email,importer.contact_name as importer_contact,concat(manu.entity_name,", ",manu.address) as manu_name,manu.email as manu_email,manu.phn_no as manu_phn_no,manu.contact_name as manu_contact,currency.name as inv_cur');
        $this->db->join('gmark_registration', 'gmark_registration.registration_id=rfc_document.registration_id', 'left');
        $this->db->join('gmark_customers as exporter', 'exporter.customers_id=rfc_document.exporte_id', 'left');
        $this->db->join('gmark_customers as importer', 'importer.customers_id=rfc_document.importer_id', 'left');
        $this->db->join('gmark_customers as manu', 'manu.customers_id=rfc_document.manufacture_id', 'left');
        $this->db->join('currency', 'currency.code=rfc_document.inv_cur', 'left');
        $this->db->where($where);
        $this->db->where(['pdf_genrate <' => 1]);
        $result  = $this->db->get('rfc_document');
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function log($post)
    {
        $this->db->order_by('log_id', 'DESC');
        $this->db->select('gmark_request_log.text,CONCAT(users.first_name," ",users.last_name) as created_by,gmark_request_log.created_on');
        $this->db->join('users', 'gmark_request_log.created_by=users.id', 'left');
        $this->db->where($post);
        $result = $this->db->get('gmark_request_log');
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function RequestFormPdfData($where)
    {
        $this->db->select('gmark.coc_type,gmark.created_on as request_date,gmark.status,gmark.reg_status,gmark.seq_no,gmark.certificate_no,gmark.test_report_no,gmark.created_on,gmark_application.application_desc as application_name,CONCAT(applicant.entity_name," \n ",applicant.address) as applicant_name,CONCAT(manufacturer.entity_name," \n <br> ",manufacturer.address) as manufacturer_name,GROUP_CONCAT( DISTINCT CONCAT(factory.entity_name," \n <br> ", factory.address ),"\n <br>") as factory_name,CONCAT(licensee.entity_name," \n <br> ",licensee.address) as importer_name,lab.lab_name as lab_name,sub_lab.Sub_lab_name as sub_lab_name,gmark.destination,glel.legal_entity_name,gem.ex_method_name,GROUP_CONCAT(DISTINCT mst_country.country_name) as destination_name');
        $this->db->from('gmark_registration as gmark');
        $this->db->join('gmark_laboratory_type as lab', 'lab.lab_id=gmark.lab_id', 'left');
        $this->db->join('gmark_sub_laboratory_type as sub_lab', 'sub_lab.Sub_lab_id=gmark.sub_lab_id', 'left');
        $this->db->join('gmark_customers as applicant', 'applicant.customers_id=gmark.applicant_id', 'left');
        $this->db->join('gmark_customers as manufacturer ', 'manufacturer.customers_id=gmark.manufacturer_id', 'left');
        $this->db->join('gmark_customers as factory', 'FIND_IN_SET(factory.customers_id,gmark.factory_id) <> 0', 'left', false);
        $this->db->join('gmark_legal_entity_type as glel', 'glel.legal_entity_id=gmark.legal_entity_type', 'left');
        $this->db->join('gmark_examination_method as gem', 'gem.ex_method_id=gmark.examination_id', 'left');
        $this->db->join('gmark_customers as licensee', 'licensee.customers_id=gmark.licensee_id', 'left');
        $this->db->join('gmark_application', 'gmark_application.application_id=gmark.application_type', 'left');
        $this->db->join('mst_country', 'FIND_IN_SET(mst_country.country_id,gmark.destination) <> 0', 'left', false);
        $this->db->where($where);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
