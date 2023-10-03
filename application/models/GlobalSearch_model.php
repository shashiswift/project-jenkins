
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GlobalSearch_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function SearchKey($search)
    {
        $data = array();
        /* STORE IN CACHE FOR ALL QUERY USE */
        $this->db->start_cache();

        $this->db->select('gmark.seq_no,applicant.entity_name as applicant_name');
        $this->db->group_by('gmark.registration_id');

        $this->db->stop_cache();
        /* STOP STORE IN CACHE FOR ALL QUERY USE */


        if (exist_val('Gmark/index', $this->session->userdata('permission'))) {

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
            $this->db->limit(3);
            $request = $this->db->get();
            if ($request->num_rows() > 0) {
                $data['request'] = [$request->result(), 'Gmark'];
            }
        }


        if (exist_val('Invoice/index', $this->session->userdata('permission'))) {


            if (!empty($search)) {
                $this->db->group_start();
                $this->db->like('LOWER(gmark.seq_no)', $search);
                $this->db->or_like('LOWER(job_number.job_no)', $search);
                $this->db->or_like('LOWER(invoice_details.invoice_number)', $search);
                $this->db->or_like('LOWER(gmark.certificate_no)', $search);
                $this->db->or_like('LOWER(gmark.test_report_no)', $search);
                $this->db->or_like('LOWER(applicant.entity_name)', $search);
                $this->db->or_like('LOWER(manufacturer.entity_name)', $search);
                $this->db->or_like('LOWER(licensee.entity_name)', $search);
                $this->db->group_end();
            }
            $this->db->select('job_number.job_no,invoice_details.invoice_number');
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
            $this->db->limit(3);
            $request = $this->db->get();
            if ($request->num_rows() > 0) {
                $data['invoice'] = [$request->result(), 'Invoice'];
            }
        }


        if (exist_val('Reports/index', $this->session->userdata('permission'))) {

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
            $this->db->select('job_number.job_no,invoice_details.invoice_number,report_content.coc_no');
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
            $this->db->join('invoice_details', 'invoice_details.registration_id=gmark.registration_id', 'left');
            $this->db->limit(3);
            $request = $this->db->get();
            if ($request->num_rows() > 0) {
                $data['report'] = [$request->result(), 'Reports'];
            }
        }


        $this->db->flush_cache();

        if (exist_val('Customer/index', $this->session->userdata('permission'))) {
            if (!empty($search)) {
                $this->db->like('LOWER(gmark_customers.entity_name)', $search);
                $this->db->or_like('LOWER(gmark_customers.contact_name)', $search);
                $this->db->or_like('LOWER(gmark_customers.contact_title)', $search);
                $this->db->or_like('LOWER(gmark_customers.department)', $search);
                $this->db->or_like('LOWER(gmark_customers.email)', $search);
            }
            $this->db->select('gmark_customers.entity_name as seq_no');
            $this->db->join('mst_country', 'mst_country.country_id = gmark_customers.country', 'left');
            $this->db->join('customer_type', 'customer_type_id = customer_type', 'left');
            $this->db->limit(3);
            $request = $this->db->get('gmark_customers');
            if ($request->num_rows() > 0) {
                $data['Customer'] = [$request->result(), 'Customer'];
            }
        }


        if (exist_val('User/index', $this->session->userdata('permission'))) {
            if (!empty($search)) {
                $this->db->group_start();
                $this->db->like('LOWER(users.email)', $search);
                $this->db->or_like('LOWER(concat(users.first_name," ",users.last_name))', $search);
                $this->db->group_end();
            }
            $this->db->select('concat(users.first_name," ",users.last_name) as seq_no,roles.name as invoice_number');
            $this->db->join('roles', 'roles.role_id=users.role_id', 'left');
            $this->db->join('mst_country', 'mst_country.country_id=users.default_country', 'left');
            $this->db->limit(3);
            $request = $this->db->get('users');
            if ($request->num_rows() > 0) {
                $data['User'] = [$request->result(), 'User'];
            }
        }


        return $data;
    }
}
