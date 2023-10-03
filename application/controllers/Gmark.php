<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gmark extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gmark_model');
        $this->load->helper('url');
        $this->permission('Gmark/index');
    }

    public function index()
    {
        $data['lab_name'] = $this->Gmark_model->get_data_from_table('lab_id,lab_name', 'gmark_laboratory_type');
        $data['country'] = $this->Gmark_model->get_countries('country_id,country_name', NULL, [195, 234, 120, 180, 17, 167, 247]);
        $data['applicantion'] = $this->Gmark_model->get_result('application_id,application_name', 'gmark_application');
        $this->showDisplay('g-mark/gmark_list', $data);
    }

    public function registration()
    {
        $data['customer_type'] = $this->Gmark_model->get_result('*', 'customer_type');
        $this->showDisplay('g-mark/gmark_registration', $data);
    }


    public function gmark_listing($applicant_id, $manufacture_id, $factory_id, $lab_id, $start_date, $end_date, $destination, $applicantion_name, $search, $page = 0)
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
        $total_row = $this->Gmark_model->get_gmark_list(NULL, NULL, $search, $where, '1');
        $required_document = $this->Gmark_model->get('count(*) as count', 'documents', ['doc_need >' => 0, 'status' => 1]);
        $data['pagination'] = $this->ajax_pagination('Gmark/gmark_listing', $total_row, $per_page);
        $result = $this->Gmark_model->get_gmark_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->seq_no . '</td>';
                $html .= '<td>' . $value->application_name . '</td>';
                $html .= '<td>' . $value->applicant_name . '</td>';
                $html .= '<td>' . $value->manufacturer_name . '</td>';
                $html .= '<td>' . $value->factory_name . '</td>';
                $html .= '<td>' . $value->destination_name . '</td>';
                $html .= '<td>' . $value->lab_name . '</td>';
                $html .= '<td>' . (($value->status > 0) ? 'ACTIVE' : 'IN-ACTIVE') . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                
                if($value->cancelled_request == 0){
                if ($this->permission_action('Gmark/edit_gmark_registration')) {
                    $html .= '<a class="btn btn-sm" title="EDIT REQUEST" href="' . base_url('Gmark/edit_gmark_registration?rg=' . base64_encode($value->registration_id)) . '"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></a>';
                }
                if ($this->permission_action('Gmark/ViewRequestPdf')) {
                    $html .= '<a class="btn btn-sm ViewRequestSrc" href="javascript:void(0);" title="VIEW REQUEST PDF" data-toggle="modal" data-src="' . base_url('Gmark/ViewRequestPdf/' . base64_encode($value->registration_id)) . '" data-target="#viewRequest"><img width="32px" src="' . base_url('public/icon/VIEW_REPORT.png') . '" alt="GEOCHEM"></a>';
                }
                if ($this->permission_action('Gmark/Upload_document')) {
                    $html .= '<a  href="javascript:void(0);" title="UPLOAD DOCUMENTS" class="btn btn-sm doc_upload" data-toggle="modal" data-id="' . base64_encode($value->registration_id) . '" data-target="#document_list"><img width="28px" src="' . base_url('public/icon/documents_view.png') . '" alt="GEOCHEM"></a>';
                }
                if ($this->permission_action('Gmark/view_document_listing')) {
                    if ($value->reg_status > 0) {
                        $html .= '<a href="javascript:void(0);" title="VIEW UPLOADED DOCUMENTS" class="btn btn-sm doc_view" data-toggle="modal" data-id="' . base64_encode($value->registration_id) . '" data-target="#view_document_list"><img width="28px" src="' . base_url('public/icon/view_documents.png') . '" alt="GEOCHEM"></a>';
                    }
                }
                if ($value->rfc_id && $value->rfc_id > 0) {
                    if ($this->permission_action('Gmark/EDIT_Rfc_document')) {
                        $html .= '<a class="btn btn-sm" title="EDIT RFC DOCUMENT" href="' . base_url('Gmark/EDIT_Rfc_document?rfc_id=' . base64_encode($value->rfc_id)) . '"><img width="28px" src="' . base_url('public/icon/EDIT_RFC.png') . '" alt="GEOCHEM"></a>';
                    }
                    if ($this->permission_action('Gmark/rfc_pdf') || $this->permission_action('Gmark/release_rfc_pdf')) {
                        $html .= '<a class="btn btn-sm view_rfc_src" data-release="' . (($this->permission_action('Gmark/release_rfc_pdf')) ? (base_url('Gmark/release_rfc_pdf?rg=' . base64_encode($value->registration_id))) : '') . '" data-text="' . base_url('Gmark/rfc_pdf?rg=' . base64_encode($value->registration_id)) . '" data-toggle="modal" data-target="#view_Rfc" title="RFC DOCUMENT PDF" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/RFC_PDF.png') . '" alt="GEOCHEM"></a>';
                    }
                } else {
                    if ($this->permission_action('Gmark/Rfc_document')) {
                        $html .= '<a class="btn btn-sm" title="ADD RFC DOCUMENT" href="' . base_url('Gmark/Rfc_document?rg=' . base64_encode($value->registration_id)) . '"><img width="28px" src="' . base_url('public/icon/RFC.png') . '" alt="GEOCHEM"></a>';
                    }
                }
                if ($this->permission_action('Gmark/approved_request')) {
                    if ($required_document->count <= $value->upload_document) {
                        if ($value->reg_status < 2) {
                            $html .= '<a class="btn btn-sm approved" data-text="' . base_url('Gmark/approved_request?rg=' . base64_encode($value->registration_id)) . '" title="APPROVED" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/approved_request.png') . '" alt="GEOCHEM"></a>';
                        }
                    }
                }
                if ($this->permission_action('Gmark/log')) {
                    $html .= '<a class="btn btn-sm log" data-id="' . base64_encode($value->registration_id) . '" data-toggle="modal" data-target="#log" title="LOG" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/log.png') . '" alt="GEOCHEM"></a>';
                }
                 $html .= '<a href="#" data-toggle="modal" data-target="#RequestCancel"'
                         . ' onclick="setRequestId('. $value->registration_id .')"'
                         . ' class="RequestCancel"><img src="'. base_url('public/icon/del.png') . '" Title="Cancel Request" width="32px"></a>';
                }else{
                    $html .= '<a href="#" data-toggle="popover" data-trigger="focus" data-content="'. (!empty($value->cacelled_reason) ? $value->cacelled_reason : "") .'"><img src="'. base_url('public/icon/del.png') . '" Title="View Cancelled Reason" width="32px"></a>'; 
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

    // insert value of application 
    public function add_application()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('app_name', 'Application Name', 'trim|required|is_unique[gmark_application.application_name]');
        $this->form_validation->set_rules('app_desc', 'Application Description', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data['application_name'] = $this->input->post('app_name');
            $data['application_desc'] = $this->input->post('app_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->Gmark_model->insert_data('gmark_application', $data);
            if ($result) {
                $this->Gmark_model->total_log('Add Application Name:- ' . $data['application_name'] . ' ');
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
        echo json_encode($msg);
    }

    // get value application

    public function get_application()
    {
        $result = $this->Gmark_model->get_data_from_table('application_id,application_name', 'gmark_application');

        echo json_encode($result);
    }

    // insert laboratory 

    public function add_lab()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('lab_name', 'Lab Name', 'trim|required|is_unique[gmark_laboratory_type.lab_name]');
        $this->form_validation->set_rules('lab_desc', 'Lab Description', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data['lab_name'] = $this->input->post('lab_name');
            $data['lab_desc'] = $this->input->post('lab_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->Gmark_model->insert_data('gmark_laboratory_type', $data);
            if ($result) {
                $this->Gmark_model->total_log('Add LAB Name:- ' . $data['lab_name'] . ' ');
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

        echo json_encode($msg);
    }
    public function add_sub_lab()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('gmark_laboratory_type_id', 'Lab Name', 'trim|required');
        $this->form_validation->set_rules('Sub_lab_name', 'Sub Lab Name', 'trim|required|is_unique[gmark_sub_laboratory_type.Sub_lab_name]');
        $this->form_validation->set_rules('Sub_lab_desc', 'Sub Lab Description', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->Gmark_model->insert_data('gmark_sub_laboratory_type', $data);
            if ($result) {
                $this->Gmark_model->total_log('Add SUB LAB Name:- ' . $data['Sub_lab_name'] . ' ');
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

        echo json_encode($msg);
    }
    // get value of laboratory

    public function get_lab()
    {
        $result = $this->Gmark_model->get_data_from_table('lab_id,lab_name', 'gmark_laboratory_type');
        echo json_encode($result);
    }

    // insert legal entity type 

    public function add_legal_entity()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('legal_entity_name', 'Entity Name', 'trim|required|is_unique[gmark_legal_entity_type.legal_entity_name]');
        $this->form_validation->set_rules('legal_entity_desc', 'Entity Desc', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data['legal_entity_name'] = $this->input->post('legal_entity_name');
            $data['legal_entity_desc'] = $this->input->post('legal_entity_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $insert = $this->Gmark_model->insert_data('gmark_legal_entity_type', $data);
            if ($insert) {
                $this->Gmark_model->total_log('Add Legal Entity Name:- ' . $data['legal_entity_name'] . ' ');
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

        echo json_encode($msg);
    }

    // get legal entity type

    public function get_legal_entity()
    {
        $result = $this->Gmark_model->get_data_from_table('legal_entity_id,legal_entity_name', 'gmark_legal_entity_type');
        echo json_encode($result);
    }


    // add examination method

    public function add_ex_method()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('ex_method_name', 'Examination Method Name', 'trim|required|is_unique[gmark_examination_method.ex_method_name]');
        $this->form_validation->set_rules('ex_method_desc', 'Examination Method Description', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data['ex_method_name'] = $this->input->post('ex_method_name');
            $data['ex_method_desc'] = $this->input->post('ex_method_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $insert = $this->Gmark_model->insert_data('gmark_examination_method', $data);
            if ($insert) {
                $this->Gmark_model->total_log('Add Examination Method Name:- ' . $data['ex_method_name'] . ' ');
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

        echo json_encode($msg);
    }

    // get value of laboratory

    public function get_ex_method()
    {
        $result = $this->Gmark_model->get_data_from_table('ex_method_id,ex_method_name', 'gmark_examination_method');
        echo json_encode($result);
    }

    // gmark registration form submit

    public function insert_gmark_registration()
    {
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        $this->form_validation->set_rules('application_type', 'Application Name', 'trim|required');
        $this->form_validation->set_rules('certificate_no', 'CERTIFICATE NO.', 'trim|min_length[3]');
        $this->form_validation->set_rules('test_report_no', 'TEST REPORT NO.', 'trim|min_length[3]');
        $this->form_validation->set_rules('sign_id', 'Signatory Name ', 'trim|required|is_natural_no_zero');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $this->db->trans_begin();
            $products = $product_cons = array();
            $seq_no = NULL;
            if (isset($data['product'])) {
                $products = $data['product'];
                unset($data['product']);
            }
            if (isset($data['product_con'])) {
                $product_cons = $data['product_con'];
                unset($data['product_con']);
            }
            if (isset($data['factory_id'])) {
                $data['factory_id'] = implode(',', $data['factory_id']);
            }
            if (isset($data['destination'])) {
                $data['destination'] = implode(',', $data['destination']);
            }
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $insert = $this->Gmark_model->insert_data('gmark_registration', $data);
            $seq_insert = $this->Gmark_model->insert_data('registration_seq', ['created_by' => $user_id]);
            $seq_no = 'GC-DXB-GSO-' . date('Y') . '-' . str_pad($seq_insert, 5, 0, STR_PAD_LEFT);
            $this->Gmark_model->update_row('gmark_registration', ['seq_no' => $seq_no], ['registration_id' => $insert]);
            if ($products && count($products) > 0) {
                foreach ($products as $key => $value) {
                    $products[$key]['registration_id'] = $insert;
                    $products[$key]['created_by'] = $user_id;
                }
                $insert_pro = $this->Gmark_model->insert_multi_data('gmark_products', $products);
            }
            if ($product_cons && count($product_cons) > 0) {
                foreach ($product_cons as $key => $value) {
                    $product_cons[$key]['registration_id'] = $insert;
                    $product_cons[$key]['created_by'] = $user_id;
                }
                $insert_pro_con = $this->Gmark_model->insert_multi_data('gmark_product_con', $product_cons);
            }
            $this->Gmark_model->gmark_registration_log($insert, 'G-MARK NO:- ' . $seq_no . ' Registration Successfully ');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $msg = array(
                    'status' => 0,
                    'msg' => 'Error in G-MARK re-gistration'
                );
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'G-MARK NO:- ' . $seq_no . ' Registration Successfully ');
                $msg = array(
                    'status' => 1,
                    'msg' => 'G-MARK NO:- ' . $seq_no . ' Registration Successfully '
                );
            }
            // if ($insert) {

            //     $this->Gmark_model->gmark_registration_log($insert, 'G-MARK NO:- ' . $seq_no . ' Registration Successfully ');
            //     $msg = array(
            //         'status' => 1,
            //         'msg' => 'G-MARK NO:- ' . $seq_no . ' Registration Successfully '
            //     );
            // } else {
            //     $msg = array(
            //         'status' => 0,
            //         'msg' => 'Error in G-MARK re-gistration'
            //     );
            // }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => validation_errors(),
                'msg' => 'PLEASE ENTER VALID RECORDS'
            );
        }
        echo json_encode($msg);
    }

    // EDIT FORM REGESTRATION
    public function edit_submit_gmark_registration()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('application_type', 'Application Name', 'trim|required');
        $this->form_validation->set_rules('certificate_no', 'CERTIFICATE NO.', 'trim|min_length[3]');
        $this->form_validation->set_rules('test_report_no', 'TEST REPORT NO.', 'trim|min_length[3]');
        $this->form_validation->set_rules('sign_id', 'Signatory Name ', 'trim|required|is_natural_no_zero');
        if ($this->form_validation->run() == TRUE) {
            $this->db->trans_begin();
            $data = $this->input->post();
            $data['registration_id'] = base64_decode($data['registration_id']);
            $insert_pro = $insert_pro_con = FALSE;
            if (isset($data['product'])) {
                $products = $data['product'];
                unset($data['product']);
            }
            if (isset($data['product_con'])) {
                $product_cons = $data['product_con'];
                unset($data['product_con']);
            }
            if (isset($data['factory_id'])) {
                $data['factory_id'] = implode(',', $data['factory_id']);
            }
            if (isset($data['destination'])) {
                $data['destination'] = implode(',', $data['destination']);
            }
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $insert = $this->Gmark_model->update_row('gmark_registration', $data, ['registration_id' => $data['registration_id']]);

            foreach ($products as $key => $value) {
                $products[$key]['registration_id'] = $data['registration_id'];
                $products[$key]['created_by'] = $user_id;
            }
            foreach ($product_cons as $key => $value) {
                $product_cons[$key]['registration_id'] = $data['registration_id'];
                $product_cons[$key]['created_by'] = $user_id;
            }
            $this->Gmark_model->delete_data('gmark_products', ['registration_id' => $data['registration_id']]);
            $this->Gmark_model->delete_data('gmark_product_con', ['registration_id' => $data['registration_id']]);
            $insert_pro = $this->Gmark_model->insert_multi_data('gmark_products', $products);
            $insert_pro_con = $this->Gmark_model->insert_multi_data('gmark_product_con', $product_cons);


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }


            if ($insert_pro && $insert_pro_con) {
                $seq = $this->Gmark_model->get('seq_no', 'gmark_registration', ['registration_id' => $data['registration_id']]);
                $this->Gmark_model->status_update($data['registration_id'], 1);
                $this->Gmark_model->gmark_registration_log($data['registration_id'], 'G-MARK NO:- ' . $seq->seq_no . ' Registration Successfully UPDATE');
                $msg = array(
                    'status' => 1,
                    'msg' => 'G-MARK NO:- ' . $seq->seq_no . ' Registration Successfully UPDATE '
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'Error in G-MARK re-gistration UPDATE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => validation_errors(),
                'msg' => 'PLEASE ENTER VALID RECORDS'
            );
        }
        echo json_encode($msg);
    }

    public function edit_gmark_registration()
    {
        $get = $this->input->get();
        $get['rg'] = base64_decode($get['rg']);
        $data['customer_type'] = $this->Gmark_model->get_result('*', 'customer_type');
        $data['result'] = $this->Gmark_model->get('*', 'gmark_registration', ['registration_id' => $get['rg']]);
        $data['product'] = $this->Gmark_model->get_result('*', 'gmark_products', ['registration_id' => $get['rg']]);
        $data['product_con'] = $this->Gmark_model->get_result('*', 'gmark_product_con', ['registration_id' => $get['rg']]);
        $this->showDisplay('g-mark/edit_gmark_registration', $data);
    }


    public function get_sub_lab()
    {
        $data = $this->input->post();
        echo json_encode($this->Gmark_model->get_result('Sub_lab_id,Sub_lab_name', 'gmark_sub_laboratory_type', ['gmark_laboratory_type_id' => $data['lab_id']]));
    }

    // country_of_destination
    public function get_country()
    {
        $country = $this->input->post();
        $data = $this->Gmark_model->get_countries('country_id,country_name', NULL, $country['country_id']);
        echo json_encode($data);
    }
     // country_of_destination
     public function get_destination()
     {
         $country = $this->input->post();
         $data = $this->Gmark_model->get_destination();
         echo json_encode($data);
     }

    public function fetch_country()
    {
        echo json_encode($this->Gmark_model->fetch_country());
    }

    public function customer_Add()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('entity_name', 'Legal entity Name', 'trim|required|is_unique[gmark_customers.entity_name]');
        $this->form_validation->set_rules('customer_type', 'Customer Type', 'trim|required');
        $this->form_validation->set_rules('licence_no', 'Licence Number', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('country', 'COUNTRY.', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('contact_title', 'CONTACT TITLE', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|is_unique[gmark_customers.email]');
        $this->form_validation->set_rules('department', 'DEPARTMENT', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $result = $this->Gmark_model->insert_data('gmark_customers', $data);
            if ($result) {
                $this->Gmark_model->total_log('Add CUSTOMER NAME :- ' . $data['entity_name'] . ' ');
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
                'errors' => $this->form_validation->error_array(),
                'msg' => 'PLEASE ENTER VALID TEXT'
            );
        }
        echo json_encode($msg);
    }
    public function get_customer()
    {
       
        $result = $this->Gmark_model->get_data_from_table('customers_id,entity_name', 'gmark_customers');

        echo json_encode($result);
    }
    public function get_customer_details()
    {
        $data = $this->input->post();
        echo json_encode($this->Gmark_model->get('*', 'gmark_customers', ['customers_id' => $data['customer_id']]));
    }
    public function search()
    {
        $post = $this->input->post();
        $post['coloum'] = explode(',', $post['coloum']);
        foreach ($post['coloum'] as $key => $value) {
            $like[$value] = $post['key'];
        }
        echo json_encode($this->Gmark_model->like_result($post['table'], $post['select'], $like));
    }

    public function Upload_document()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('documents_id', 'DOCUMENT TITLE', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('document_others', 'DOCUMENT REMARK', 'trim|min_length[3]');
        $this->form_validation->set_rules('images', 'Document', 'callback_file_selected_test');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $data['registration_id'] = base64_decode($data['registration_id']);
            $file = $_FILES['images'];
            $seq = $this->Gmark_model->get('seq_no', 'gmark_registration', ['registration_id' => $data['registration_id']]);
            if ($seq) {
                $upload_path = $this->upload_file($file['tmp_name'], $file['type'], $seq->seq_no . '-' . date('H:i:s') . '.' . pathinfo(basename($file['name']), PATHINFO_EXTENSION), 'GMARK/' . $seq->seq_no . '/documents');
                echo "<pre>";
                print_r($upload_path);
                exit;
                
                if ($upload_path) {
                    $data['upload_path'] = $upload_path;
                    $user_id = $this->session->userdata('user_data')->id;
                    $data['created_by'] = $user_id;
                    $insert = $this->Gmark_model->insert_data('document_registration', $data);
                    if ($insert) {
                        $document_name = $this->Gmark_model->get('document_name', 'documents', ['document_id' => $data['documents_id']]);
                        $this->Gmark_model->gmark_registration_log($data['registration_id'], $seq->seq_no . ' :- Documents Name: ' . $document_name->document_name . ' UPLOADED');
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SUCCESSFULLY INSERTED'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'DATA INSERT ERROR'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'FILE UPLOAD ERROR'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'NO REQUEST FOUND'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => validation_errors(),
                'msg' => 'PLEASE ENTER VALID TEXT'
            );
        }
        echo json_encode($msg);
    }

    public function document_listing()
    {
        echo json_encode($this->Gmark_model->get_result('document_id,document_name', 'documents', ['status' => 1]));
    }

    public function view_document_listing()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('id', 'UNIQUE ID', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $data['id'] = base64_decode($data['id']);
            $result = $this->Gmark_model->document_listing(['document_registration.registration_id' => $data['id']]);
            if ($result && count($result) > 0) {
                $html = '<table class="table table-striped table-sm"><thead><tr><th>Sn.</th><th>TITLE</th><th>ACTION</th></tr></thead><tbody>';
                $sn = 1;
                foreach ($result as $value) {
                    $html .= '<tr>';
                    $html .= '<td>' . $sn . '</td>';
                    $html .= '<td>' . $value->document_name . '</td>';
                    $html .= '<td>';
                    if ($this->permission_action('Gmark/view_document_listing')) {
                        $html .= '<a class="btn btn-sm" href="' . base_url('Gmark/download_file?doc_id=') . base64_encode($value->doc_id) . '">VIEW</a>';
                    }
                    if ($this->permission_action('Gmark/delte_document')) {
                        $html .= '<a data-delte="upload_path" data-reg="' . base64_encode($value->registration_id) . '" data-primary="doc_id" data-table="document_registration" data-id="' . base64_encode($value->doc_id) . '" class="btn btn-sm text-danger delete_doc" href="javascript:void(0);">DELETE</a>';
                    }
                    $html .= '</td>';
                    $html .= '<tr>';
                    $sn++;
                }

                $html .= '</tbody></table>';
                $msg = array(
                    'status' => 1,
                    'msg' => 'RECORD FOUND',
                    'html' => $html
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT FOUND',
                    'html' => '<h1>NO RECORD FOUND</h1>'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => validation_errors(),
                'msg' => 'RECORD NOT AVAILABLE'
            );
        }
        echo json_encode($msg);
    }

    public function delte_document()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('coloum', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('table', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('delete', 'UNIQUE ID', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $data['id'] = base64_decode($data['id']);
            $result = $this->Gmark_model->get('*', $data['table'], [$data['coloum'] => $data['id']]);
            if ($result && count($result) > 0) {
                $result = (array)$result;
                $file = explode('.com/', $result[$data['delete']]);
                $delete = $this->delete_file_from_aws($file[1]);
                if ($delete) {
                    $delete_row = $this->Gmark_model->delete_data($data['table'], [$data['coloum'] => $data['id']]);
                    if ($delete_row) {
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SUCCESSFULLY DELETED RECORD & FILE'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'FILE DELETE BUT RECORD NOT DELETE SOME ISSSUE'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'FILE NOT DELETE SOME ISSSUE'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT FOUND',
                    'html' => '<h1>NO RECORD FOUND</h1>'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => validation_errors(),
                'msg' => 'RECORD NOT AVAILABLE'
            );
        }
        echo json_encode($msg);
    }

    public function Rfc_document()
    {
        $get = $this->input->get();
        $get['rg'] = base64_decode($get['rg']);
        $data['product_con'] = $this->Gmark_model->get_result('*', 'gmark_products', ['registration_id' => $get['rg']]);
        $data['rg'] = $get['rg'];
        $this->showDisplay('rfc/index', $data);
    }
    public function rfc_submit()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('exporte_id', 'EXPORTER', 'trim');
        $this->form_validation->set_rules('importer_id', 'IMPORTER', 'trim');
        $this->form_validation->set_rules('type_rfc', 'COMPANY DETAILS TYPE', 'trim|required|in_list[GEC,COC]');
        $this->form_validation->set_rules('manufacture_id', 'MANUFACTURE', 'trim');
        $this->form_validation->set_rules('inv_no', 'INVOICE NUMBER', 'trim');
        $this->form_validation->set_rules('inv_date', 'INVOICE DATE', 'trim');
        $this->form_validation->set_rules('inv_value', 'INVOICE VALUE', 'trim');
        $this->form_validation->set_rules('inv_cur', 'INVOICE CURRENCY', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $user_id = $this->session->userdata('user_data')->id;
            $post = $this->input->post();
            $post['registration_id'] = base64_decode($post['registration_id']);
            $post['created_by'] = $user_id;
            $product = $post['product_con'];
            unset($post['product_con']);
            $result = $this->Gmark_model->get('count(*) as count,seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
            if ($result && $result->count > 0) {
                $insert = $this->Gmark_model->insert_data('rfc_document', $post);
                if ($insert) {
                    foreach ($product as $key => $value) {
                        $product[$key]['status'] = 1;
                        $product[$key]['created_by'] = $user_id;
                        $product[$key]['registration_id'] = $post['registration_id'];
                    }

                    $delete = $this->Gmark_model->delete_data('gmark_products', ['registration_id' => $post['registration_id']]);
                    $product_cons = $this->Gmark_model->insert_multi_data('gmark_products', $product);
                    if ($delete && $product_cons) {
                        $this->Gmark_model->gmark_registration_log($post['registration_id'], $result->seq_no . ' :- RFC DOCUMENT CREATED ');
                        $this->session->set_flashdata('success', $result->seq_no . ' :- RFC DOCUMENT CREATED ');
                        $file = $this->rfcStoreLocal($post['registration_id']);
                        $user = $this->Gmark_model->get('CONCAT(first_name," ",last_name) as name,email', 'users', ['id' => $user_id]);
                        $msg = ' <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">';
                        $msg .= '<tr style="display:block;"><td width="84"><a style="text-align:center; display:block; height: 64px; width: 64px; "><img src="' . base_url('assets/img/avatar/avatar-' . rand(1, 4) . '.png') . '" style="border-radius:50%;" alt="Profile Picture"></a></td><td style="vertical-align:top;"><h3 style="color: #4d4d4d; font-size: 20px; font-weight: 400; line-height: 30px; margin-bottom: 3px; margin-top:0;"><strong>' . (($user) ? $user->name : 'UNKNOWN USER') . '</strong> RFC document created for application on ' . date("l jS \of F Y h:i:s A") . '. </h3></td></tr>';
                        $msg .= '</table>';
                        send_mail_function(RFC_NOTIFY, CC, $msg, 'GMARK ' . $result->seq_no . ' :- RFC DOCUMENT CREATED', $file['file_path']);
                        if ($file && file_exists($file['file_path'])) {
                            unlink($file['file_path']);
                        }
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SUCCESSFULLY CREATE RFC DOCUMENT'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'PRODUCT TABLE NOT UPDATE PLEASE CHECK'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'ERROR'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'errors' => '<div class="text-danger">NO RECORD FOUND</div>',
                    'msg' => 'RECORD NOT AVAILABLE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' =>  $this->form_validation->error_array(),
                'msg' => 'SOMETHING WRONG! PLEASE CHECK ALL FIELDS.'
            );
        }
        echo json_encode($msg);
    }
    public function EDIT_Rfc_document()
    {
        $get = $this->input->get();
        $get['rfc_id'] = base64_decode($get['rfc_id']);
        $data['result'] = $this->Gmark_model->get('*', 'rfc_document', ['rfc_id' => $get['rfc_id']]);
        if ($data['result']) {
            $data['product_con'] = $this->Gmark_model->get_result('*', 'gmark_products', ['registration_id' => $data['result']->registration_id]);
            $data['rfc_id'] = $get['rfc_id'];
            $this->showDisplay('rfc/edit', $data);
        } else {
            show_error('NO RECORD FOUND', '404', 'YOU HAVE WRONG KEY');
        }
    }

    public function submit_edit_rfc()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('rfc_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('exporte_id', 'EXPORTER', 'trim');
        $this->form_validation->set_rules('importer_id', 'IMPORTER', 'trim');
        $this->form_validation->set_rules('type_rfc', 'COMPANY DETAILS TYPE', 'trim|required|in_list[GEC,COC]');
        $this->form_validation->set_rules('manufacture_id', 'MANUFACTURE', 'trim');
        $this->form_validation->set_rules('inv_no', 'INVOICE NUMBER', 'trim');
        $this->form_validation->set_rules('inv_date', 'INVOICE DATE', 'trim');
        $this->form_validation->set_rules('inv_value', 'INVOICE VALUE', 'trim');
        $this->form_validation->set_rules('inv_cur', 'INVOICE CURRENCY', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $user_id = $this->session->userdata('user_data')->id;
            $post = $this->input->post();
            $post['rfc_id'] = base64_decode($post['rfc_id']);
            $product = $post['product_con'];
            unset($post['product_con']);
            $result = $this->Gmark_model->get('count(*) as count,registration_id', 'rfc_document', ['rfc_id' => $post['rfc_id']]);
            if ($result && $result->count > 0) {
                $update = $this->Gmark_model->update_row('rfc_document', $post, ['rfc_id' => $post['rfc_id']]);
                if ($update) {
                    foreach ($product as $key => $value) {
                        $product[$key]['status'] = 1;
                        $product[$key]['created_by'] = $user_id;
                        $product[$key]['registration_id'] = $result->registration_id;
                    }
                    $delete = $this->Gmark_model->delete_data('gmark_products', ['registration_id' => $result->registration_id]);
                    $product_cons = $this->Gmark_model->insert_multi_data('gmark_products', $product);
                    if ($delete && $product_cons) {
                        $result = $this->Gmark_model->get('registration_id,seq_no', 'gmark_registration', ['registration_id' => $result->registration_id]);
                        $this->Gmark_model->gmark_registration_log($result->registration_id, $result->seq_no . ' :- RFC DOCUMENT EDIT ');
                        $this->session->set_flashdata('success', $result->seq_no . ' :- RFC DOCUMENT EDIT ');
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SUCCESSFULLY EDIT RFC DOCUMENT'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'PRODUCT TABLE NOT UPDATE PLEASE CHECK'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'DOCUMENT NOT UPDATE SUCCESSFULLY'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT AVAILABLE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' =>  $this->form_validation->error_array(),
                'msg' => 'SOMETHING WRONG! PLEASE CHECK ALL FIELDS.'
            );
        }
        echo json_encode($msg);
    }
    public function rfc_pdf()
    {
        $get = $this->input->get();
        $get['rg'] = base64_decode($get['rg']);
        if ($get['rg'] > 0) {
            $data['result'] = $this->Gmark_model->rfc_pdf(['rfc_document.registration_id' => $get['rg']]);
            $data['result_products'] = $this->Gmark_model->get_result('*', 'gmark_products', ['registration_id' => $get['rg']]);
            $this->load->library('M_pdf');
            $this->m_pdf->pdf->charset_in = 'UTF-8';
            $this->m_pdf->pdf->setAutoTopMargin = 'stretch';
            $this->m_pdf->pdf->lang = 'ar';
            $html = $this->load->view('rfc/pdf', $data, true);
            $this->m_pdf->pdf->WriteHTML($html);
            $this->m_pdf->pdf->Output('RFC_DOCUMENT.pdf', 'I');
        } else {
            show_error('NO KEY FOUND', '404', 'PLEASE DONT CHANGE ANYTHING');
        }
    }

    public function rfcStoreLocal($id)
    {
        $data['result'] = $this->Gmark_model->rfc_pdf(['rfc_document.registration_id' => $id]);
        $data['result_products'] = $this->Gmark_model->get_result('*', 'gmark_products', ['registration_id' => $id]);
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->charset_in = 'UTF-8';
        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';
        $this->m_pdf->pdf->lang = 'ar';
        $html = $this->load->view('rfc/pdf', $data, true);
        $this->m_pdf->pdf->WriteHTML($html);
        $file_pth = LOCAL_PATH . 'RFC_DOCUMENT_' . date('dMY') . '-' . rand(0, 999) . '.pdf';
        $this->m_pdf->pdf->Output($file_pth, 'F');
        return ['file_path' => $file_pth, 'rfc_id' => $data['result']->rfc_id];
    }

    public function release_rfc_pdf()
    {
        $get = $this->input->get();
        $get['rg'] = base64_decode($get['rg']);
        $result = $this->Gmark_model->get('registration_id,seq_no', 'gmark_registration', ['registration_id' => $get['rg']]);
        if ($get['rg'] > 0 && $result) {
            $user_id = $this->session->userdata('user_data')->id;
            $file_pth = $this->rfcStoreLocal($get['rg']);
            $folder = 'GMARK/' . $result->seq_no . '/documents/';
            $aws_path = $this->uploadpdf($file_pth['file_path'], $folder);
            if ($aws_path && count($aws_path) > 0) {
                unlink($file_pth['file_path']);
                $update = $this->Gmark_model->update_row('rfc_document', ['aws_path' => $aws_path['aws_path'], 'pdf_genrate' => 1], ['rfc_id' => $file_pth['rfc_id']]);
                $document_id = $this->Gmark_model->get('document_id', 'documents', ['LOWER(document_name)' => 'rfc']);
                if ($update && $document_id) {
                    $this->Gmark_model->gmark_registration_log($get['rg'], $result->seq_no . ' :- RFC GENERATE FOR RELEASE');
                    $this->Gmark_model->status_update($get['rg'], 1);
                    $post = array(
                        'upload_path' => $aws_path['aws_path'],
                        'documents_id' => $document_id->document_id,
                        'created_by' => $user_id,
                        'registration_id' => $get['rg']
                    );
                    $insert = $this->Gmark_model->insert_data('document_registration', $post);
                    if ($insert) {
                        $this->load->helper('file');
                        delete_files(LOCAL_PATH);
                        $this->Gmark_model->gmark_registration_log($get['rg'], $result->seq_no . ' :- RFC GENERATED AND SUBMIT ON DOCUMENTS');
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SUCCESSFULLY RFC DOCUMENT SUBMIT'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'ERROR WHILE SUBMITTING RFC DOCUMENT'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'ERROR WHILE RFC DOCUMENT UPDATE'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RFC DOCUMENT ON UPLOAD AWS'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'msg' => 'RFC DOCUMENT ON UPLOAD AWS'
            );
        }
        echo json_encode($msg);
    }

    public function approved_request()
    {
        $get = $this->input->get();
        $get['rg'] = base64_decode($get['rg']);
        if ($get['rg'] > 0) {
            $count = $this->Gmark_model->get('count(*) as count', 'job_number', ['registration_id' => $get['rg']]);
            if ($count && $count->count < 1) {
                $update = $this->Gmark_model->update_row('gmark_registration', ['reg_status' => 2], ['registration_id' => $get['rg']]);
                if ($update) {
                    $user_id = $this->session->userdata('user_data')->id;
                    // job_number
                    $data = array(
                        'registration_id' => $get['rg'],
                        'created_by' => $user_id
                    );
                    $insert_id = $this->Gmark_model->insert_data('job_number', $data);
                    if ($insert_id && $insert_id > 0) {
                        $job_no = 'GMARK-' . date('Y') . '-' . str_pad($insert_id, 6, 0, STR_PAD_LEFT);
                        $update = $this->Gmark_model->update_row('job_number', ['job_no' => $job_no], ['job_id' => $insert_id]);
                        if ($update) {
                            $seq = $this->Gmark_model->get('seq_no', 'gmark_registration', ['registration_id' => $get['rg']]);
                            $this->Gmark_model->gmark_registration_log($get['rg'], $seq->seq_no . ' :- APPROVED JOB NO IS :- ' . $job_no);
                            $msg = array(
                                'status' => 1,
                                'msg' => 'JOB NUMBER GENERATE & APPROVED SUCCESSFULLY'
                            );
                        } else {
                            $msg = array(
                                'status' => 0,
                                'msg' => 'JOB NUMBER GENERATE ERROR'
                            );
                        }
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'APPROVED SOMETHING WRONG'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'REQUEST APPROVED ERROR'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'ALREADY APPROVED'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'msg' => 'RFC DOCUMENT ON UPLOAD AWS'
            );
        }
        echo json_encode($msg);
    }
    public function download_file()
    {
        $get = $this->input->get();
        $get['doc_id'] = base64_decode($get['doc_id']);
        $url = $this->Gmark_model->get('upload_path', 'document_registration', ['doc_id' => $get['doc_id']]);
        if ($url) {
            $this->load->helper('file'); // Load file helper
            $this->load->helper('download');
            $data = read_file($url->upload_path); // Use file helper to read the file's
            $name = basename($url->upload_path);
            force_download($name, $data);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function log()
    {
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        $result = $this->Gmark_model->log(['gmark_registration_id' => $post['id']]);
        if ($result) {
            $page = 1;
            $html = '<table class="table table-striped"><thead><tr><th scope="col">#</th><th scope="col">TEXT</th><th scope="col">USER</th><th scope="col">TIME</th></tr></thead><tbody>';
            foreach ($result as $key => $value) {
                $html .= '<tr><th scope="row">' . $page . '.</th><td>' . $value->text . '</td><td>' . $value->created_by . '</td><td>' . (($value->created_on)) . '</td></tr>';
                $page++;
            }
            $html .= '</tbody></table>';
            $result = $html;
        } else {
            $result = 'NO RECORD FOUND';
        }
        echo json_encode($result);
    }
    public function user_signatory()
    {
        echo json_encode($this->Gmark_model->get_result('id,CONCAT(users.first_name," ",users.last_name) as name', 'users', ['signatory >' => 0]));
    }
    public function currency()
    {
        echo json_encode($this->Gmark_model->get_result('code,CONCAT(name," (",symbol,")") as name', 'currency'));
    }
    public function ViewRequestPdf($id)
    {
        $data = array();
        $data['result'] = $data['product'] = $data['product_con'] = NULL;
        $id = base64_decode($id);
        if ($id > 0) {
            $data['result'] = $this->Gmark_model->RequestFormPdfData(['gmark.registration_id' => $id]);
            if ($data['result']) {
                $data['product'] = $this->Gmark_model->get_result('hs_code,product,trade_mark,mode_type_ref,technical_details', 'gmark_products', ['registration_id' => $id]);
                $data['product_con'] = $this->Gmark_model->get_result('hs_code,product,other_con_mark,applicable_standard,test_report', 'gmark_product_con', ['registration_id' => $id]);
            }
        }
        $this->RequestPDF('g-mark/pdf', $data, (($data['result']) ? $data['result']->seq_no : 'REQUEST' . rand(0, 999) . date('dMY')) . '.pdf', 'I');
    }
    public function RequestPDF($pdf, $data, $filename, $type = 'I')
    {
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->charset_in = 'UTF-8';
        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';
        $this->m_pdf->pdf->lang = 'ar';
        $html = $this->load->view($pdf, $data, true);
        $this->m_pdf->pdf->WriteHTML($html);
        return $this->m_pdf->pdf->Output($filename, $type);
    }
    
    public function cancelRequest() {
//        $this->db->query('alter table gmark_registration add cancelled_reason varchar(255) default null');
//        echo "<pre>"; print_r($this->db->list_fields('gmark_registration')); die;
        $data = $this->input->post();
        $res = $this->db->update('gmark_registration', ['cancelled_request' => 1, 'cancelled_reason' => $data['reason_for_cancel']], ['registration_id' => $data['request_id']]);
//        echo "<pre>"; print_r($this->db->last_query()); die;
        if ($res) {
            $this->session->set_flashdata('success', 'Request Cancelled Successfully!');
        }
        redirect('Gmark');
    }

}
