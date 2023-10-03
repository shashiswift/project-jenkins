<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request_option extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Request_option_model', 'rom');
        $this->permission('Request_option/index');
    }
    public function index()
    {
        // echo base_url();
        $this->showDisplay('request_option/index');
    }


    public function get_request_option()
    {
        $post = $this->input->post();
        echo json_encode($this->rom->get('*', 'gmark_request_options', $post));
    }


    public function get_applicant()
    {
        $data = $this->rom->get_result('customers_id as id,entity_name as name', 'gmark_customers');
        echo json_encode($data);
    }

    public function add_request_option()
    {

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if (exist_val('Request_option/customers_id', $this->session->userdata('permission'))) {
            $customerIds = $this->rom->get('GROUP_CONCAT(customers_id) as ids', 'gmark_customers');
            $this->form_validation->set_rules('customers_id', 'Client Name', 'trim|required' . (($customerIds) ? '|in_list[' . $customerIds->ids . ']' : ''));
        }
        if (exist_val('Request_option/quotes_recv_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('quotes_recv_date', 'Query Received Date', 'trim|required');
        }
        if (exist_val('Request_option/client_conf_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('client_conf_date', 'Client Confirmation Date', 'trim|required');
        }
        if (exist_val('Request_option/charges_agreed', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('charges_agreed', 'Charges Agreed With Client', 'trim|required');
        }
        if (exist_val('Request_option/testing_req', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('testing_req', 'Testing Required', 'trim|in_list[1,0]');
        }
        if (exist_val('Request_option/testing_start_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('testing_start_date', 'Testing Start Date', 'trim');
        }
        if (exist_val('Request_option/testing_end_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('testing_end_date', 'Testing End Date', 'trim');
        }
        if (exist_val('Request_option/doc_recv_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('doc_recv_date', 'Document Received Date (Only Client)', 'trim');
        }
        if (exist_val('Request_option/cert_sent_client', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('cert_sent_client', 'Draft Certificate Sent to client', 'trim');
        }
        if (exist_val('Request_option/draft_cert_conf_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('draft_cert_conf_date', 'Draft Certificate Confirmation Date (From Client)', 'trim');
        }
        if (exist_val('Request_option/certificate_no', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('certificate_no', 'Certificate Number', 'trim|min_length[3]');
        }
        if (exist_val('Request_option/date_registration_gso', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('date_registration_gso', 'Date Of Registration GSO Portal', 'trim');
        }
        if (exist_val('Request_option/date_cert_upload_gso', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('date_cert_upload_gso', 'Date Of Certificate Upload In GSO', 'trim');
        }
        if (exist_val('Request_option/date_cert_approval_gso', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('date_cert_approval_gso', 'Date Of Certificate Approval (From GSO)', 'trim');
        }
        if (exist_val('Request_option/payment_status', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('payment_status', 'Payment Status', 'trim');
        }
        if (exist_val('Request_option/gso_status', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('gso_status', 'GSO Status', 'trim');
        }
        if (exist_val('Request_option/gso_status', $this->session->userdata('permission'))) {
            $gsoStatus = $this->rom->get('GROUP_CONCAT(id) as ids', 'gso_status');
            $this->form_validation->set_rules('gso_status', 'GSO Status', 'trim' . (($gsoStatus) ? '|in_list[' . $gsoStatus->ids . ']' : ''));
        }
        if (exist_val('Request_option/remarks', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]');
        }
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            unset($data['request_option_id']);
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->rom->insert_data('gmark_request_options', $data);
            if ($result) {
                $this->GsoStatus_model->total_log('Add REQUEST OPTION REMARK:- ' . (isset($data['remarks'])?$data['remarks']:'') . ' ');
                $msg = array(
                    'status' => 1,
                    'msg' => 'RECORD INSERTED'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT INSERT'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' =>  $this->form_validation->error_array(),
                'msg' => 'PLEASE VALID ENTER'
            );
        }
        echo json_encode($msg);
    }

    public function edit_req_option()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $this->form_validation->set_rules('request_option_id', 'UNIQUE ID', 'trim|required');

        if (exist_val('Request_option/customers_id', $this->session->userdata('permission'))) {
            $customerIds = $this->rom->get('GROUP_CONCAT(customers_id) as ids', 'gmark_customers');
            $this->form_validation->set_rules('customers_id', 'Client Name', 'trim|required' . (($customerIds) ? '|in_list[' . $customerIds->ids . ']' : ''));
        }
        if (exist_val('Request_option/quotes_recv_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('quotes_recv_date', 'Query Received Date', 'trim|required');
        }
        if (exist_val('Request_option/client_conf_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('client_conf_date', 'Client Confirmation Date', 'trim|required');
        }
        if (exist_val('Request_option/charges_agreed', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('charges_agreed', 'Charges Agreed With Client', 'trim|required');
        }
        if (exist_val('Request_option/testing_req', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('testing_req', 'Testing Required', 'trim|in_list[1,0]');
        }
        if (exist_val('Request_option/testing_start_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('testing_start_date', 'Testing Start Date', 'trim');
        }
        if (exist_val('Request_option/testing_end_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('testing_end_date', 'Testing End Date', 'trim');
        }
        if (exist_val('Request_option/doc_recv_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('doc_recv_date', 'Document Received Date (Only Client)', 'trim');
        }
        if (exist_val('Request_option/cert_sent_client', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('cert_sent_client', 'Draft Certificate Sent to client', 'trim');
        }
        if (exist_val('Request_option/draft_cert_conf_date', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('draft_cert_conf_date', 'Draft Certificate Confirmation Date (From Client)', 'trim');
        }
        if (exist_val('Request_option/certificate_no', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('certificate_no', 'Certificate Number', 'trim|min_length[3]');
        }
        if (exist_val('Request_option/date_registration_gso', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('date_registration_gso', 'Date Of Registration GSO Portal', 'trim');
        }
        if (exist_val('Request_option/date_cert_upload_gso', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('date_cert_upload_gso', 'Date Of Certificate Upload In GSO', 'trim');
        }
        if (exist_val('Request_option/date_cert_approval_gso', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('date_cert_approval_gso', 'Date Of Certificate Approval (From GSO)', 'trim');
        }
        if (exist_val('Request_option/payment_status', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('payment_status', 'Payment Status', 'trim');
        }
        if (exist_val('Request_option/gso_status', $this->session->userdata('permission'))) {
            $gsoStatus = $this->rom->get('GROUP_CONCAT(id) as ids', 'gso_status');
            $this->form_validation->set_rules('gso_status', 'GSO Status', 'trim' . (($gsoStatus) ? '|in_list[' . $gsoStatus->ids . ']' : ''));
        }
        if (exist_val('Request_option/remarks', $this->session->userdata('permission'))) {
            $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|min_length[3]');
        }

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->rom->update_row('gmark_request_options', $data, ['request_option_id' => $data['request_option_id']]);
            if ($result) {
                $this->GsoStatus_model->total_log('EDIT REQUEST OPTION REMARK:- ' . (isset($data['remarks'])?$data['remarks']:'') . ' ');
                $msg = array(
                    'status' => 1,
                    'msg' => 'RECORD UPDATED'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT UPDATED'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' =>  $this->form_validation->error_array(),
                'msg' => 'PLEASE VALID ENTER'
            );
        }
        echo json_encode($msg);
    }

    public function req_option_listing($client, $search, $page = 0)
    {
        $where = NULL;
        if (!empty($client) && $client != 'NULL') {
            $where['client.customers_id'] = base64_decode($client);
        }
        if (!empty($search) && $search != 'NULL') {
            $search = strtolower(base64_decode($search));
        } else {
            $search = NULL;
        }

        $per_page = 10;

        if ($page != 0) {
            $page = ($page - 1) * $per_page;
        }
        $total_row = $this->rom->get_req_list(NULL, NULL, $search, $where, '1');
        $data['pagination'] = $this->ajax_pagination('Request_option/req_option_listing', $total_row, $per_page);
        $result = $this->rom->get_req_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' .  (empty($value->client_name) ? 'N/A' : $value->client_name) . '</td>';
                $html .= '<td>' .  (empty($value->certificate_no) ? 'N/A' : $value->certificate_no) . '</td>';
                $html .= '<td>' .  (empty($value->charges_agreed) ? 'N/A' : $value->charges_agreed) . '</td>';
                $html .= '<td>' . (($value->testing_req > 0) ? 'Yes' : 'No') . '</td>';
                $html .= '<td>' .  (empty($value->testing_start_date) ? 'N/A' : $value->testing_start_date) . '</td>';
                $html .= '<td>' .  (empty($value->testing_end_date) ? 'N/A' : $value->testing_end_date) . '</td>';
                $html .= '<td>' .  (empty($value->payment_status) ? 'N/A' : $value->payment_status) . '</td>';
                $html .= '<td>' .  (empty($value->gso_status) ? 'N/A' : $value->gso_status) . '</td>';
                $html .= '<td>' .  (empty($value->created_on) ? 'N/A' : $value->created_on) . '</td>';
                $html .= '<td>';
                if ($this->permission_action('Request_option/edit_req_option')) {
                    $html .= '<a href="javascript:void(0);" title="UPDATE REQUEST OPTIONS" class="btn btn-sm update_req" data-toggle="modal" data-id="' . base64_encode($value->request_option_id) . '" data-target="#req_modal"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="EDIT"></a>';
                }

                $html .= '</td>';
                $html .= '/<tr>';
            }
        } else {
            $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
        }
        $data['result'] = $html;
        echo json_encode($data);
    }
    public function gso_statusList()
    {
        $data = $this->rom->get_result('id,name', 'gso_status');
        echo json_encode($data);
    }
}
