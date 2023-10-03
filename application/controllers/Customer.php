<?php
class Customer extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->permission('Customer/index');        
    }

    public function index()
    {
        $data['country'] = $this->Customer_model->get_result('*', 'mst_country');
        $data['customer_type'] = $this->Customer_model->get_result('*', 'customer_type');
        $this->showDisplay('customer/customer_listing', $data);
    }

    public function customer_listing($type,$search, $page = 0)
    {
        $where = array();
        if (($type!= 'NULL' && $type != NULL) && $type > 0) {
            $where = array('gmark_customers.customer_type'=>$type);
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
        $total_row = $this->Customer_model->customer_listing(NULL, NULL,$where ,$search, '1');
        $data['pagination'] = $this->ajax_pagination('Customer/customer_listinging', $total_row, $per_page);
        $result = $this->Customer_model->customer_listing($per_page, $page,$where,$search);
        
        $html = '';
        if ($result){
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->customer_type_name . '</td>';
                $html .= '<td>' . $value->entity_name . '</td>';
                $html .= '<td>' . $value->address . '</td>';
                $html .= '<td>' . $value->country_name . '</td>';
                $html .= '<td>' . $value->contact_name . '</td>';
                $html .= '<td>' . $value->contact_title . '</td>';
                $html .= '<td>' . $value->department . '</td>';
                $html .= '<td>' . $value->phn_no . '</td>';
                $html .= '<td>' . $value->email . '</td>';
                $html .= '<td>' . $value->status . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if ($this->permission_action('Customer/edit_customer')) {
                    $html .= '<a href="javascript:void(0);" class="btn btn-sm edit_customer" data-toggle="modal" data-target="#edit_customer_data" data-one="' . $value->customers_id . '"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></a>';
                }
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
        }
        $data['result'] = $html;
        echo json_encode($data);
    }

    public function add_customer()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('customer_type', 'Customer Type', 'trim|required');
        $this->form_validation->set_rules('entity_name', 'Entity Name', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('licence_no', 'Licence Number', 'trim|required');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'trim|required');
        $this->form_validation->set_rules('contact_title', 'Contact Title', 'trim|required');
        $this->form_validation->set_rules('department', 'Department', 'trim|required');
        $this->form_validation->set_rules('phn_no', 'Phone No.', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == true) {
            $data['customer_type'] = $this->input->post('customer_type');
            $data['entity_name'] = $this->input->post('entity_name');
            $data['address'] = $this->input->post('address');
            $data['country'] = $this->input->post('country');
            $data['contact_name'] = $this->input->post('contact_name');
            $data['contact_title'] = $this->input->post('contact_title');
            $data['department'] = $this->input->post('department');
            $data['phn_no'] = $this->input->post('phn_no');
            $data['email'] = $this->input->post('email');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->Customer_model->insert_data('gmark_customers', $data);
            if ($result) {
                $this->Customer_model->total_log('Add Customer Name:- ' . $data['entity_name'] . ' ');
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

    public function get_customer_details()
    {
        $customer_id = $this->input->post('customer_id');
        $data = $this->Customer_model->get('*', 'gmark_customers', ['customers_id' => $customer_id]);
        echo json_encode($data);
    }

    public function edit_customer()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('customers_id', 'Unique ID', 'trim|required');
        $this->form_validation->set_rules('customer_type', 'Customer Type', 'trim|required');
        $this->form_validation->set_rules('entity_name', 'Entity Name', 'trim|required');
        $this->form_validation->set_rules('licence_no', 'Licence Number', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'trim|required');
        $this->form_validation->set_rules('contact_title', 'Contact Title', 'trim|required');
        $this->form_validation->set_rules('department', 'Department', 'trim|required');
        $this->form_validation->set_rules('phn_no', 'Phone No.', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == true) {
            $data = $this->input->post();
            $data['customers_id'] = base64_decode($data['customers_id']);
            $data['customer_type'] = $this->input->post('customer_type');
            $data['entity_name'] = $this->input->post('entity_name');
            $data['address'] = $this->input->post('address');
            $data['country'] = $this->input->post('country');
            $data['contact_name'] = $this->input->post('contact_name');
            $data['contact_title'] = $this->input->post('contact_title');
            $data['department'] = $this->input->post('department');
            $data['phn_no'] = $this->input->post('phn_no');
            $data['email'] = $this->input->post('email');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->Customer_model->update_row('gmark_customers', $data, ['customers_id' => $data['customers_id']]);
            if ($result) {
                $this->Customer_model->total_log('Add Customer Name:- ' . $data['entity_name'] . ' ');
                $msg = array(
                    'status' => 1,
                    'msg' => 'RECORD UPDATED'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT UPDATE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => $this->form_validation->error_array(),
                'msg' => 'PLEASE VALID ENTER'
            );
        }
        echo json_encode($msg);
    }
}
