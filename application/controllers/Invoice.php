<?php
class Invoice extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_model');
        $this->load->model('Gmark_model');
        $this->permission('Invoice/index');
    }

    public function index()
    {
        $data['lab_name'] = $this->Invoice_model->get_result('lab_id,lab_name', 'gmark_laboratory_type');
        $data['country'] = $this->Gmark_model->get_countries('country_id,country_name', NULL, [195, 234, 120, 180, 17, 167, 247]);
        $data['applicantion'] = $this->Invoice_model->get_result('application_id,application_name', 'gmark_application');
        $data['country_invoice'] = $this->Invoice_model->get_company_country();
        $this->showDisplay('invoice/invoice_listing', $data);
    }


    public function invoice_listing($applicant_id, $manufacture_id, $factory_id, $lab_id, $start_date, $end_date, $destination, $applicantion_name, $search, $page = 0)
    {
        $where = NULL;
        if (!empty($applicant_id) && $applicant_id != 'NULL') {
            $where['gmark.applicant_id'] = $applicant_id;
        }
        if (!empty($manufacture_id) && $manufacture_id != 'NULL') {
            $where['gmark.manufacturer_id'] = $manufacture_id;
        }
        if (!empty($factory_id) && $factory_id != 'NULL') {
            $where['FIND_IN_SET("' . $factory_id . '",gmark.factory_id) <> 0 '] = NULL;
        }
        if (!empty($lab_id) && $lab_id != 'NULL') {
            $where['gmark.lab_id'] = $lab_id;
        }
        if (!empty($start_date) && $start_date != 'NULL') {
            $where['gmark.created_on >= '] = $start_date;
        }
        if (!empty($end_date) && $end_date != 'NULL') {
            $where['gmark.created_on <= '] = $end_date;
        }
        if (!empty($destination) && $destination != 'NULL') {
            $where['FIND_IN_SET("' . $destination . '",gmark.destination) <> 0 '] = NULL;
        }
        if (!empty($applicantion_name) && $applicantion_name != 'NULL') {
            $where['gmark.application_type'] = $applicantion_name;
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
        $total_row = $this->Invoice_model->invoice_list(NULL, NULL, $where,$search, '1');
        $data['pagination'] = $this->ajax_pagination('Invoice/invoice_listing',$total_row,$per_page);
        $result = $this->Invoice_model->invoice_list($per_page, $page, $where,$search);
        $html = '';
        if ($result) {
            foreach ($result as $value) {

                $page++;
                $html .= '<tr>';
                $html .= '<th align="center" scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->job_no . '</td>';
                $html .= '<td>' . (!empty($value->invoice_number) ? $value->invoice_number : 'NOT GENERATED') . '</td>';
                $html .= '<td>' . $value->seq_no . '</td>';
                $html .= '<td>' . $value->application_name . '</td>';
                $html .= '<td>' . $value->applicant_name . '</td>';
                $html .= '<td>' . $value->manufacturer_name . '</td>';
                $html .= '<td>' . $value->factory_name . '</td>';
                $html .= '<td>' . $value->destination_name . '</td>';
                $html .= '<td>' . $value->lab_name . '</td>';
                $html .= '<td>' . $value->sub_lab_name . '</td>';
                $html .= '<td>' . (($value->status > 0) ? 'ACTIVE' : 'IN-ACTIVE') . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if (!empty($value->invoice_id) && $value->invoice_id > 0) {
                    if ($this->permission_action('Invoice/edit_invoice')) {
                        $html .= '<a title="EDIT INVOICE" href="javascript:void(0);" class="btn btn-sm edit_invoice" data-toggle="modal" data-target="#editInvoiceModal" data-one="' . $value->invoice_id . '"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></a>';
                    }
                    if ($this->permission_action('Invoice/view')) {
                        $html .= '<a target="_blank" title="VIEW INVOICE" download="" href="' . $value->invoice_attachment_path_name . '" class="btn btn-sm"><img width="28px" src="' . base_url('public/icon/invoice_download.png') . '" alt="GEOCHEM"></a>';
                    }
                } else {
                    if ($this->permission_action('Invoice/edit_invoice')) {
                        $html .= '<a title="ADD INVOICE" href="javascript:void(0);" class="btn btn-sm add_invoice" data-toggle="modal" data-target="#addInvoiceModal" data-one="' . $value->registration_id . '"><img width="28px" src="' . base_url('public/icon/add_invoice.png') . '" alt="GEOCHEM"></a>';
                    }
                }
                $html .= '</td></tr>';
            }
        } else {
            $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
        }
        $data['result'] = $html;
        echo json_encode($data);
    }

    public function get_country()
    {
        $country = $this->input->post('country');
        $data = $this->Invoice_model->get('*', 'company_location_add', ['mst_country_id' => $country]);
        echo json_encode($data);
    }

    public function add_invoice()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('payment_amount', 'Total amount', 'trim|required');
        $this->form_validation->set_rules('discount', 'Discount', 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('country_tax', 'Country Tax', 'trim|required');
        $this->form_validation->set_rules('company_country', 'Company Country', 'trim|required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('company_location', 'Company Location', 'trim|required');
        if ($this->form_validation->run() == true) {
            $data['payment_amount']         = $this->input->post('payment_amount');
            $data['discount']               = $this->input->post('discount');
            $data['country_tax']            = $this->input->post('country_tax');
            $data['tax_type']               = $this->input->post('input_tax_type') ? $this->input->post('input_tax_type') : '';
            $data['tax_type_value']         = $this->input->post('input_tax_value') ? $this->input->post('input_tax_value') : '';
            $data['company_country']        = $this->input->post('company_country');
            $data['company_name']           = $this->input->post('company_name');
            $data['company_location']       = $this->input->post('company_location');
            $data['note']                   = $this->input->post('note');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            // Invoice number generation
            $query = $this->Invoice_model->insert_data('invoice_number', array('registration_id' => $this->input->post('registration_id'), 'created_on' => date("Y-m-d H:i:s")));
            $last_insert_id = $query;
            $invid_number = str_pad($last_insert_id, 5, "0", STR_PAD_LEFT);
            $invoice_num_seq = "INV-" . date("y") . "-" . "0" . $invid_number;
            $data['registration_id'] = $this->input->post('registration_id');
            $data['invoice_number'] = $invoice_num_seq;
            $reg = $this->Invoice_model->get('registration_id,seq_no', 'gmark_registration', ['registration_id' => $data['registration_id']]);
            // tax calculation
            $amount_after_discount = $total_amount = $data['payment_amount'] - (float)($data['payment_amount'] * ($data['discount'] / 100));

            if (!empty($data['tax_type']) && !empty($data['tax_type_value']) && $data['tax_type'] != '' && $data['tax_type_value'] != '') {
                $country_tax_data = $data['tax_type'] . ',' . $data['tax_type_value'];
                $this->Invoice_model->insert_data('country_tax', array('country_tax_name' => $data['tax_type'], 'tax_precentage' => $data['tax_type_value']));
            } else if (!empty($data['country_tax'])) {
                $country_tax_data = $data['country_tax'];
            } else {
                $country_tax_data = '';
            }
            $tax_type = $country_tax_data;
            $tax_precent = explode(',', $tax_type);
            $total_amount = $total_amount + (float)($total_amount * ($tax_precent[1] / 100));
            $data['total_amount'] = $total_amount;
            $result = $this->Invoice_model->insert_data('invoice_details', $data);
            if ($result) {
                $data['total_amount'] = $amount_after_discount;
                $job_number = $this->Invoice_model->get('job_no', 'job_number', ['registration_id' => $data['registration_id']]);
                $reg = $this->Invoice_model->get('registration_id,seq_no,applicant_id', 'gmark_registration', ['registration_id' => $data['registration_id']]);
                $contact = $this->Invoice_model->get('entity_name,address,country', 'gmark_customers', ['customers_id' => $reg->applicant_id]);
                $country = $this->Invoice_model->get('country_name', 'mst_country', ['country_id' => $contact->country]);
                // Generate pdf
                $data_for_pdf['result']['job_number'] = $job_number->job_no;
                $data_for_pdf['result']['country_tax_data'] = $country_tax_data;
                $data_for_pdf['result']['company_location'] = $data['company_location'];
                $data_for_pdf['result']['company_name'] = $data['company_name'];
                $data_for_pdf['result']['invoice_note'] = $data['note'];
                $data_for_pdf['result']['country'] = $data['company_country'];
                $data_for_pdf['result']['invoice_number'] = $data['invoice_number'];
                $data_for_pdf['result']['applicant_name'] = $contact->entity_name;
                $data_for_pdf['result']['applicant_address'] = $contact->address;
                $data_for_pdf['result']['applicant_country'] = $country->country_name;
                $data_for_pdf['result']['discount'] = $data['discount'];
                $data_for_pdf['result']['payment_amount'] = $data['payment_amount'];
                $pdf_body = generate_invoice_pdf_dom($data['total_amount'], $data_for_pdf, 'mypdf');
               
                $folder = 'GMARK/' . $reg->seq_no . '/INVOICE/' . $reg->seq_no . '-Invoice.pdf';
                $invoice_file_details = $this->upload_data_aws($pdf_body, $folder);
                $file['invoice_attachment_path_name'] = $invoice_file_details['aws_path'];
                $file['invoice_attachment_name'] = $invoice_file_details['file_name'];
                $this->Invoice_model->update_row('invoice_details', $file, ['invoice_id' => $result]);
                $this->Invoice_model->gmark_registration_log($reg->registration_id,$reg->seq_no.' Add Invoice:- ' . $data['invoice_number'] . ' ');
                $this->Invoice_model->status_update($reg->registration_id,3);
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
                'errors' => validation_errors(),
                'msg' => 'PLEASE VALID ENTER'
            );
        }
        echo json_encode($msg);exit;
    }

    public function get_invoice_details()
    {
        $invoice_id = $this->input->post('invoice_id');
        $data = $this->Invoice_model->get('*', 'invoice_details', ['invoice_id' => $invoice_id]);
        echo json_encode($data);
    }

    public function edit_invoice()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('invoice_id', 'Unique ID', 'trim|required');
        $this->form_validation->set_rules('payment_amount', 'Total amount', 'trim|required');
        $this->form_validation->set_rules('discount', 'Discount', 'trim|required|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('country_tax', 'Country Tax', 'trim|required');
        $this->form_validation->set_rules('company_country', 'Company Country', 'trim|required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('company_location', 'Company Location', 'trim|required');
        if ($this->form_validation->run() == true) {
            $data['invoice_id']             = base64_decode($this->input->post('invoice_id'));
            $data['payment_amount']         = $this->input->post('payment_amount');
            $data['discount']               = $this->input->post('discount');
            $data['country_tax']            = $this->input->post('country_tax');
            $data['tax_type']               = $this->input->post('input_tax_type') ? $this->input->post('input_tax_type') : '';
            $data['tax_type_value']         = $this->input->post('input_tax_value') ? $this->input->post('input_tax_value') : '';
            $data['company_country']        = $this->input->post('company_country');
            $data['company_name']           = $this->input->post('company_name');
            $data['company_location']       = $this->input->post('company_location');
            $data['note']                   = $this->input->post('note');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            // tax calculation
           $amount_after_discount = $total_amount = $data['payment_amount'] - (float)($data['payment_amount'] * ($data['discount'] / 100));
            if (!empty($data['tax_type']) && !empty($data['tax_type_value']) && $data['tax_type'] != '' && $data['tax_type_value'] != '') {
                $country_tax_data = $data['tax_type'] . ',' . $data['tax_type_value'];
                $this->Invoice_model->insert_data('country_tax', array('country_tax_name' => $data['tax_type'], 'tax_precentage' => $data['tax_type_value']));
            } else if (!empty($data['country_tax'])) {
                $country_tax_data = $data['country_tax'];
            } else {
                $country_tax_data = '';
            }
            $tax_type = $country_tax_data;
            $tax_precent = explode(',', $tax_type);
            $total_amount = $total_amount + (float)($total_amount * ($tax_precent[1] / 100));
            $data['total_amount'] = $total_amount;
            $result = $this->Invoice_model->update_row('invoice_details', $data, ['invoice_id' => $data['invoice_id']]);
            if ($result) {
                $data['total_amount'] = $amount_after_discount;
                $reg = $this->Invoice_model->get('registration_id,created_on', 'invoice_details', ['invoice_id' => $data['invoice_id']]);
                $job_number = $this->Invoice_model->get('job_no', 'job_number', ['registration_id' => $reg->registration_id]);
                $reg = $this->Invoice_model->get('registration_id,seq_no,applicant_id', 'gmark_registration', ['registration_id' => $reg->registration_id]);
                $contact = $this->Invoice_model->get('entity_name,address,country', 'gmark_customers', ['customers_id' => $reg->applicant_id]);
                $country = $this->Invoice_model->get('country_name', 'mst_country', ['country_id' => $contact->country]);
                // Generate pdf
                $data_for_pdf['result']['job_number'] = $job_number->job_no;
                $data_for_pdf['result']['country_tax_data'] = $country_tax_data;
                $data_for_pdf['result']['company_location'] = $data['company_location'];
                $data_for_pdf['result']['company_name'] = $data['company_name'];
                $data_for_pdf['result']['invoice_note'] = $data['note'];
                $data_for_pdf['result']['country'] = $data['company_country'];
                $data_for_pdf['result']['invoice_number'] = $this->input->post('invoice_number');
                $data_for_pdf['result']['applicant_name'] = $contact->entity_name;
                $data_for_pdf['result']['applicant_address'] = $contact->address;
                $data_for_pdf['result']['applicant_country'] = $country->country_name;
                $data_for_pdf['result']['discount'] = $data['discount'];
                $data_for_pdf['result']['payment_amount'] = $data['payment_amount'];
                $pdf_body = generate_invoice_pdf_dom($data['total_amount'], $data_for_pdf, 'mypdf');
                $folder = 'GMARK/' . $reg->seq_no . '/INVOICE/' .$this->input->post('invoice_number'). '-Invoice.pdf';
                $invoice_file_details = $this->upload_data_aws($pdf_body, $folder);
                
                $file['invoice_attachment_path_name'] = $invoice_file_details['aws_path'];
                $file['invoice_attachment_name'] = $invoice_file_details['file_name'];
                $update = $this->Invoice_model->update_row('invoice_details', $file, ['invoice_id' => $data['invoice_id']]);
                // print_r($this->db->last_query());
                // print_r($invoice_file_details);exit;
                if ($update) {
                    $this->Invoice_model->gmark_registration_log($reg->registration_id, $reg->seq_no . ' :- INVOICE EDIT NO. ' . $this->input->post('invoice_number'));
                    $msg = array(
                        'status' => 1,
                        'msg' => 'SUCCESSFULLY EDIT INVOICE NO.' . $this->input->post('invoice_number')
                    );
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'INVOICE NOT UPDATE'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT UPDATE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => validation_errors(),
                'msg' => 'PLEASE VALID ENTER'
            );
        }
        echo json_encode($msg);
        exit;
    }
}
