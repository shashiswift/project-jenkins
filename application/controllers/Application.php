<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Application extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Application_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->showDisplay('application/index');
    }

    public function registration()
    {
        $this->showDisplay('g-mark/gmark_registration');
    }


    public function application_listing($search, $page =0)
    {
        // echo $page;die;
        $where = NULL;
        
        if (!empty($search) && $search != 'NULL') {
            $search = strtolower(base64_decode($search));
        } else {
            $search = NULL;
        }

        $per_page = 10;

        if ($page != 0) {
            $page = ($page - 1) * $per_page;
        }
        $total_row = $this->Application_model->get_application_list(NULL, NULL, $search, $where, '1');
        $config['base_url'] = base_url() . 'Application/application_listing';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $per_page;

        $config['full_tag_open']    = '<div class="pagging text-center small"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';

        $this->pagination->initialize($config);
       
        $data['pagination'] = $this->pagination->create_links();
       
        $result = $this->Application_model->get_application_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->application_name . '</td>';
                $html .= '<td>' . $value->application_desc . '</td>';
                
                $html .= '<td>' . $value->created_by . '</td>';
                
                // $html .= '<td>' . (($value->status > 0) ? 'ACTIVE' : 'IN-ACTIVE') . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                $html .= '<button type="button" title="UPLOAD DOCUMENTS" class="btn btn-sm" data-toggle="modal" data-id="' . base64_encode($value->application_id) . '" data-target="#edit_application"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM" class="edit_application_data" ></button>';
                
                   
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
            $result = $this->Application_model->insert_data('gmark_application', $data);
            if ($result) {
                $this->Application_model->total_log('Add Application Name:- ' . $data['application_name'] . ' ');
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
        $result = $this->Application_model->get_data_from_table('application_id,application_name', 'gmark_application');

        echo json_encode($result);
    }

    // insert laboratory 

    
    public function edit_application()
    {
        $get = $this->input->get();
        $get['rg'] = base64_decode($get['rg']);
        $data['result'] = $this->Application_model->get('*', 'gmark_application', ['application_id' => $get['rg']]);
        echo json_encode($result);
        
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

    public function fetch_country()
    {
        echo json_encode($this->Gmark_model->fetch_country());
    }

    public function customer_Add()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('entity_name', 'Legal entity Name', 'trim|required|is_unique[gmark_customers.entity_name]');
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
                'errors' => validation_errors(),
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
                if ($upload_path) {
                    $data['upload_path'] = $upload_path;
                    $user_id = $this->session->userdata('user_data')->id;
                    $data['created_by'] = $user_id;
                    $insert = $this->Gmark_model->insert_data('document_registration', $data);
                    if ($insert) {
                        $document_name = $this->Gmark_model->get('document_name', 'documents', ['document_id' => $data['documents_id']]);
                        $this->Gmark_model->gmark_registration_log($data['registration_id'], $seq->seq_no . ' :- Documents Name: ' . $document_name->document_name . ' UPLOADED');
                        $this->Gmark_model->status_update($data['registration_id'], 1);
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
                    $html .= '<a class="btn btn-sm" href="' . $value->upload_path . '">VIEW</a>';
                    $html .= '<a data-delte="upload_path" data-reg="'.base64_encode($value->registration_id).'" data-primary="doc_id" data-table="document_registration" data-id="' . base64_encode($value->doc_id) . '" class="btn btn-sm text-danger delete_doc" href="javascript:void(0);">DELETE</a>';
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
            $result = $this->Gmark_model->get('*',$data['table'],[$data['coloum']=>$data['id']]);
            if ($result && count($result) > 0) {
                $file = explode('.com/',$result->$data['delete']);
                $delete = $this->delete_file_from_aws($file[1]);
                if ($delete) {
                    $delete_row = $this->Gmark_model->delete_data($data['table'],[$data['coloum']=>$data['id']]);
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
        $this->showDisplay('rfc/index');
    }

}
