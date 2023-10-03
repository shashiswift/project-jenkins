<?php

class Report_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function get_reports_list($per_page, $page, $search, $where, $count = NULL)
    {
        $this->db->order_by('job_number.job_id', 'DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(gmark.seq_no)', $search);
            $this->db->or_like('LOWER(report_content.coc_no)', $search);
            $this->db->or_like('LOWER(gmark.certificate_no)', $search);
            $this->db->or_like('LOWER(gmark.test_report_no)', $search);
            $this->db->or_like('LOWER(applicant.entity_name)', $search);
            $this->db->or_like('LOWER(manufacturer.entity_name)', $search);
            $this->db->or_like('LOWER(licensee.entity_name)', $search);
            $this->db->group_end();
        }
        $this->db->from('job_number');
        $this->db->join('gmark_registration as gmark', 'job_number.registration_id=gmark.registration_id', 'left');
        $this->db->join('gmark_laboratory_type as lab', 'lab.lab_id=gmark.lab_id', 'left');
        $this->db->join('gmark_sub_laboratory_type as sub_lab', 'sub_lab.Sub_lab_id=gmark.sub_lab_id', 'left');
        $this->db->join('gmark_customers as applicant', 'applicant.customers_id=gmark.applicant_id', 'left');
        $this->db->join('gmark_customers as manufacturer ', 'manufacturer.customers_id=gmark.manufacturer_id', 'left');
        $this->db->join('report_content', 'report_content.registration_id=gmark.registration_id', 'left');
        $this->db->join('gmark_customers as factory', 'FIND_IN_SET(factory.customers_id,gmark.factory_id) <> 0', 'left', false);
        $this->db->join('gmark_customers as licensee', 'licensee.customers_id=gmark.licensee_id', 'left');
        $this->db->join('mst_country', 'FIND_IN_SET(mst_country.country_id,gmark.destination) <> 0', 'left', false);
        $this->db->join('gmark_application', 'gmark_application.application_id=gmark.application_type', 'left');
        $this->db->join('invoice_details', 'invoice_details.registration_id = gmark.registration_id', 'left');
        $this->db->where('gmark.reg_status >=',  3);
//        $this->db->where("CASE WHEN date(release_date) > '2022-05-03' THEN gmark.reg_status >= 3 else report_content.created_on <> '' OR report_content.release_date <> ''  END");     
//        $this->db->where("CASE WHEN date(report_content.created_on) > '2022-05-03' THEN gmark.reg_status >= 3 else report_content.created_on <> '' OR report_content.release_date <> ''  END");     
        $this->db->group_by('gmark.registration_id');
        
        if ($count == '1') return $this->db->select('gmark.registration_id')->count_all_results(); // FOR COUNT
        
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $this->db->join('sample_photo', 'sample_photo.registration_id=gmark.registration_id', 'left');
        $this->db->select('DISTINCT(gmark.registration_id) as registration_id,job_number.job_no,gmark.coc_type,gmark.status,gmark.reg_status,gmark.seq_no,gmark.certificate_no,gmark.test_report_no,gmark.created_on,gmark_application.application_name as application_name,applicant.entity_name as applicant_name,manufacturer.entity_name as manufacturer_name,GROUP_CONCAT( DISTINCT factory.entity_name) as factory_name,licensee.entity_name as licensee_name,lab.lab_name as lab_name,sub_lab.Sub_lab_name as sub_lab_name,GROUP_CONCAT(DISTINCT mst_country.country_name) as destination_name,report_content.coc_no,report_content.report_id,report_content.approved_by,report_content.aws_path,report_content.re_generate,report_content.release_date,report_content.gmark_qrcode,count(sample_photo.registration_id) as product_image,'
                . ' invoice_details.invoice_number, invoice_details.total_amount');


        $result = $this->db->get();
        if ($result->num_rows() > 0) {            
            //echo $this->db->last_query(); exit;
            return $result->result();
        } else {
            return false;
        }
    }

    public function pdf_data_old($where)
    {
        $this->db->select('DISTINCT(gmark.registration_id) as registration_id,report_content.*,gmark.coc_type,gmark.created_on as request_date,job_number.job_no,gmark.status,gmark.reg_status,gmark.seq_no,gmark.certificate_no,gmark.test_report_no,gmark.created_on,gmark_application.application_name as application_name,CONCAT(applicant.entity_name," ADD :- ",applicant.address) as applicant_name,CONCAT(manufacturer.entity_name," ADD:- ",manufacturer.address) as manufacturer_name,GROUP_CONCAT( DISTINCT CONCAT(factory.entity_name," ADD:- ", factory.address )) as factory_name,CONCAT(licensee.entity_name," ADD:- ",licensee.address) as licensee_name,lab.lab_name as lab_name,sub_lab.Sub_lab_name as sub_lab_name,GROUP_CONCAT(DISTINCT mst_country.country_name) as destination_name,users.signature_path,country_origin.country_name as country_origin,GROUP_CONCAT(DISTINCT(country_complains.gso_country_code)) as country_complains,GROUP_CONCAT(DISTINCT standard_applies.standard) as standard_applies');
        $this->db->from('gmark_registration as gmark');
        $this->db->join('job_number', 'job_number.registration_id=gmark.registration_id', 'left');
        $this->db->join('gmark_laboratory_type as lab', 'lab.lab_id=gmark.lab_id', 'left');
        $this->db->join('gmark_sub_laboratory_type as sub_lab', 'sub_lab.Sub_lab_id=gmark.sub_lab_id', 'left');
        $this->db->join('gmark_customers as applicant', 'applicant.customers_id=gmark.applicant_id', 'left');
        $this->db->join('gmark_customers as manufacturer ', 'manufacturer.customers_id=gmark.manufacturer_id', 'left');
        $this->db->join('gmark_customers as factory', 'FIND_IN_SET(factory.customers_id,gmark.factory_id) <> 0', 'left', false);
        $this->db->join('gmark_customers as licensee', 'licensee.customers_id=gmark.licensee_id', 'left');
        $this->db->join('mst_country', 'FIND_IN_SET(mst_country.country_id,gmark.destination) <> 0', 'left', false);
        $this->db->join('gmark_application', 'gmark_application.application_id=gmark.application_type', 'left');
        $this->db->join('report_content', 'report_content.registration_id=gmark.registration_id', 'left');
        $this->db->join('mst_country as country_origin', 'country_origin.country_id=report_content.country_origin', 'left', false);
        $this->db->join('mst_country as country_complains', 'FIND_IN_SET(country_complains.country_id,report_content.country_complains) <> 0', 'left', false);
        $this->db->join('standard_applies', 'FIND_IN_SET(standard_applies.id,report_content.standard_applies) <> 0', 'left', false);
        $this->db->join('users', 'report_content.approved_by=users.id', 'left');
        $this->db->where($where);
        $this->db->group_by('gmark.registration_id');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function pdf_data($where)
    {
        $this->db->select('DISTINCT(gmark.registration_id) as registration_id,report_content.*,gmark.coc_type,gmark.created_on as request_date,job_number.job_no,gmark.status,gmark.reg_status,gmark.seq_no,gmark.certificate_no,gmark.test_report_no,gmark.created_on,gmark_application.application_name as application_name,CONCAT(applicant.entity_name," ADD :- ",applicant.address) as applicant_name,CONCAT(manufacturer.entity_name," ADD:- ",manufacturer.address) as manufacturer_name,GROUP_CONCAT( DISTINCT CONCAT(factory.entity_name," ADD:- ", factory.address )) as factory_name,CONCAT(licensee.entity_name," ADD:- ",licensee.address) as licensee_name,lab.lab_name as lab_name,sub_lab.Sub_lab_name as sub_lab_name,GROUP_CONCAT(DISTINCT mst_country.country_name) as destination_name,users.signature_path,country_origin.country_name as country_origin,(select GROUP_CONCAT(DISTINCT(mc.gso_country_code)) from mst_country mc where  mc.gso_country_code IS NOT NULL order by mc.priority_order asc) as country_complains,GROUP_CONCAT(DISTINCT standard_applies.standard) as standard_applies');
        $this->db->from('gmark_registration as gmark');
        $this->db->join('job_number', 'job_number.registration_id=gmark.registration_id', 'left');
        $this->db->join('gmark_laboratory_type as lab', 'lab.lab_id=gmark.lab_id', 'left');
        $this->db->join('gmark_sub_laboratory_type as sub_lab', 'sub_lab.Sub_lab_id=gmark.sub_lab_id', 'left');
        $this->db->join('gmark_customers as applicant', 'applicant.customers_id=gmark.applicant_id', 'left');
        $this->db->join('gmark_customers as manufacturer ', 'manufacturer.customers_id=gmark.manufacturer_id', 'left');
        $this->db->join('gmark_customers as factory', 'FIND_IN_SET(factory.customers_id,gmark.factory_id) <> 0', 'left', false);
        $this->db->join('gmark_customers as licensee', 'licensee.customers_id=gmark.licensee_id', 'left');
        $this->db->join('mst_country', 'FIND_IN_SET(mst_country.country_id,gmark.destination) <> 0', 'left', false);
        $this->db->join('gmark_application', 'gmark_application.application_id=gmark.application_type', 'left');
        $this->db->join('report_content', 'report_content.registration_id=gmark.registration_id', 'left');
        $this->db->join('mst_country as country_origin', 'country_origin.country_id=report_content.country_origin', 'left', false);
       // $this->db->join('mst_country as country_complains', 'FIND_IN_SET(country_complains.country_id,report_content.country_complains) <> 0', 'left', false);
        $this->db->join('standard_applies', 'FIND_IN_SET(standard_applies.id,report_content.standard_applies) <> 0', 'left', false);
        $this->db->join('users', 'report_content.approved_by=users.id', 'left');
        $this->db->where($where);
        $this->db->group_by('gmark.registration_id');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    public function gso_country_code($where)
    {
        $this->db->select('mc.gso_country_code');
        $this->db->from('gmark_registration as gmark');       
        $this->db->join('report_content', 'report_content.registration_id=gmark.registration_id', 'left'); 
        $this->db->join('mst_country as mc', 'FIND_IN_SET(mc.country_id,report_content.country_complains) <> 0','left');
        $this->db->order_by('mc.priority_order','asc');     
        $this->db->where($where);
        
        $res = $this->db->get();
        //echo $this->db->last_query();
        if ($res->num_rows() > 0) {
            $results=$res->result_array();
            $cs=array();
            foreach($results as $row){
                $cs[]=$row['gso_country_code'];
            }
            $finalCountryCode=implode(",",$cs);
           return $finalCountryCode;
        } else {
            return false;
        }
    }
    public function release_view_document($id)
    {
        $this->db->select('release_document.*,CONCAT(users.first_name," ",users.last_name) as user_name');
        $this->db->join('users', 'release_document.created_by=users.id', 'left');
        $this->db->where('release_document.registration_id', $id);
        $result = $this->db->get('release_document');
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function list_certified_item($per_page, $page, $where, $count = null)
    {
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('list_certified_item');
        if ($count) {
            return $this->db->count_all_results();
            // echo $this->db->last_query();exit;
        } else {
            if ($per_page != NULL || $page != NULL) {
                $this->db->limit($per_page, $page);
            }
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }
}
