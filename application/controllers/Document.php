<?php
class Document extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Document_model');
        $this->permission('Document/index');
    }

    public function index(){
        $this->showDisplay('Document/document_listing');
    }
    
    public function document_listing($search, $page = 0){
        if (!empty($search) && $search != 'NULL') {
            $search = strtolower(base64_decode($search));
        } else {
            $search = NULL;
        }
        $per_page = 10;

        if ($page != 0) {
            $page = ($page - 1) * $per_page;
        }
        $total_row = $this->Document_model->document_list(NULL, NULL, $search, '1');
        $data['pagination'] = $this->ajax_pagination('Document/document_listing',$total_row,$per_page);
        $result = $this->Document_model->document_list($per_page, $page, $search);
        $html = '';
        if($result){
            foreach($result as $value){
                $status = ($value->doc_need == 1)?'Required':'Not required';
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->document_name . '</td>';
                $html .= '<td>' . $status . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if ($this->permission_action('Document/edit_document')) {
                $html .= '<button type="button" class="btn btn-sm edit_document" data-toggle="modal" data-target="#documentEditModal" data-one="'.$value->document_id.'"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></button>';
                }
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
        }
        $data['result'] = $html;
        echo json_encode($data);
    }

    public function add_document(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('document_name','Name','trim|required');
        $this->form_validation->set_rules('doc_required','Require status','trim|required');
        if($this->form_validation->run() == true){
            $data['document_name'] = $this->input->post('document_name');
            $data['doc_need'] = $this->input->post('doc_required');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            // print_r($data); die;
            $result = $this->Document_model->insert_data('documents', $data);
            if ($result) {
                $this->Document_model->total_log('Add Document Name:- ' . $data['document_name'] . ' ');
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

    public function get_document_details(){
        $document_id = $this->input->post('document_id');
        $data = $this->Document_model->get('*', 'documents', ['document_id' => $document_id]);
        echo json_encode($data);
    }

    public function edit_document(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('document_id','Unique ID','trim|required');
        $this->form_validation->set_rules('document_name','Name','trim|required');
        $this->form_validation->set_rules('doc_required','Require status','trim|required');
        if($this->form_validation->run() == true){
            $post = $this->input->post();
            $post['document_id'] = base64_decode($post['document_id']);
            $data['document_name'] = $this->input->post('document_name');
            $data['doc_need'] = $this->input->post('doc_required');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->Document_model->update_row('documents', $data, ['document_id' => $post['document_id']]);
            if ($result) {
                $this->Document_model->total_log('Edit Document Name:- ' . $data['document_name'] . ' ');
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
                'errors' => validation_errors(),
                'msg' => 'PLEASE VALID ENTER'
            );
        }
        echo json_encode($msg);
    }
}
