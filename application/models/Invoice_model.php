<?php
class Invoice_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function invoice_list($per_page, $page, $where, $search, $count = NULL)
    {
        $this->db->order_by('job_number.job_id', 'DESC');
        
        if (!empty($search)) {
            $this->db->like('LOWER(gmark.seq_no)', $search);
            $this->db->or_like('LOWER(job_number.job_no)', $search);
            $this->db->or_like('LOWER(invoice_details.invoice_number)', $search);
            $this->db->or_like('LOWER(gmark.certificate_no)', $search);
            $this->db->or_like('LOWER(gmark.test_report_no)', $search);
        }
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        
        $this->db->from('job_number');
        $this->db->join('gmark_registration as gmark', 'job_number.registration_id=gmark.registration_id', 'left');
        $this->db->join('gmark_laboratory_type as lab', 'lab.lab_id=gmark.lab_id', 'left');
        $this->db->join('gmark_sub_laboratory_type as sub_lab', 'sub_lab.Sub_lab_id=gmark.sub_lab_id', 'left');
        $this->db->join('gmark_customers as applicant', 'applicant.customers_id=gmark.applicant_id', 'left');
        $this->db->join('gmark_customers as manufacturer ', 'manufacturer.customers_id=gmark.manufacturer_id', 'left');
        $this->db->join('gmark_customers as factory', 'FIND_IN_SET(factory.customers_id,gmark.factory_id) <> 0', 'left', false);
        $this->db->join('gmark_customers as licensee', 'licensee.customers_id=gmark.licensee_id', 'left');
        $this->db->join('mst_country', 'FIND_IN_SET(mst_country.country_id,gmark.destination) <> 0', 'left', false);
        $this->db->join('gmark_application', 'gmark_application.application_id=gmark.application_type', 'left');
        $this->db->join('invoice_details', 'invoice_details.registration_id=gmark.registration_id', 'left');
        $this->db->where('gmark.reg_status >', '0');
        $this->db->group_by('gmark.registration_id');
        if ($count == '1') return $this->db->select('gmark.registration_id')->count_all_results(); // FOR COUNT
        
        $this->db->select('invoice_details.invoice_id,invoice_details.invoice_attachment_path_name,invoice_details.invoice_number,job_number.job_no,job_number.job_id,gmark.registration_id,gmark.status,gmark.reg_status,gmark.seq_no,gmark.certificate_no,gmark.test_report_no,gmark.created_on,gmark_application.application_name as application_name,applicant.entity_name as applicant_name,manufacturer.entity_name as manufacturer_name,GROUP_CONCAT( DISTINCT factory.entity_name) as factory_name,licensee.entity_name as licensee_name,lab.lab_name as lab_name,sub_lab.Sub_lab_name as sub_lab_name,GROUP_CONCAT(DISTINCT mst_country.country_name) as destination_name');

        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_company_country()
    {
        $this->db->select('*');
        $this->db->join('mst_country', 'country_id = mst_country_id');
        $query = $this->db->get('company_location_add');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
}
