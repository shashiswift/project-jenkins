<?php
class SubLab extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('SubLab_model');
        $this->permission('SubLab/index'); 
    }

    public function index(){
        $data['labs'] = $this->SubLab_model->get_result('*','gmark_laboratory_type');
        $this->showDisplay('sublab/subLab_list',$data);
    }

    public function sublab_listing($search, $lab_type, $page = 0){
        if (!empty($search) && $search != 'NULL') {
            $search = strtolower(base64_decode($search));
        } else {
            $search = NULL;
        }
        if (!empty($lab_type) && $lab_type != 'NULL') {
            $lab_type = base64_decode($lab_type);
        } else {
            $lab_type = NULL;
        }
        $per_page = 10;

        if ($page != 0) {
            $page = ($page - 1) * $per_page;
        }
        $total_row = $this->SubLab_model->get_sublab_list(NULL, NULL, $search, $lab_type, '1');
        $data['pagination'] = $this->ajax_pagination('SubLab/sublab_listing', $total_row, $per_page);
        $result = $this->SubLab_model->get_sublab_list($per_page, $page, $search, $lab_type);
        $html = '';
        if($result){
            foreach($result as $value){
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->lab_name . '</td>';
                $html .= '<td>' . $value->Sub_lab_name . '</td>';
                $html .= '<td>' . $value->Sub_lab_desc . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if ($this->permission_action('SubLab/edit_sublab')) {
                    $html .= '<button type="button" class="btn btn-sm edit_sublab" data-toggle="modal" data-target="#sublabEditModal" data-one="'.$value->Sub_lab_id.'"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></button>';
                }
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
        }
        $data['result'] = $html;
        echo json_encode($data);
    }

    public function add_sublab(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('lab_type','Lab Type','trim|required');
        $this->form_validation->set_rules('sublab_name','Sub Lab Name','trim|required');
        $this->form_validation->set_rules('sublab_desc','Sub Lab Description','trim|required');
        if($this->form_validation->run() == true){
            $data['gmark_laboratory_type_id'] = $this->input->post('lab_type');
            $data['Sub_lab_name'] = $this->input->post('sublab_name');
            $data['Sub_lab_desc'] = $this->input->post('sublab_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            // print_r($data); die; 
            $result = $this->SubLab_model->insert_data('gmark_sub_laboratory_type', $data);
            if ($result) {
                $this->SubLab_model->total_log('Add Sub LAB Name:- ' . $data['Sub_lab_name'] . ' ');
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

    public function get_sublab_details(){
        $lab_id = $this->input->post('subLab_id');
        $data = $this->SubLab_model->get('*', 'gmark_sub_laboratory_type', ['Sub_lab_id' => $lab_id]);
        echo json_encode($data);
    }

    public function edit_sublab(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('sublab_id','Unique ID','trim|required');
        $this->form_validation->set_rules('lab_type','Lab Type','trim|required');
        $this->form_validation->set_rules('sublab_name','Sub Lab Name','trim|required');
        $this->form_validation->set_rules('sublab_desc','Sub Lab Description','trim|required');
        if($this->form_validation->run() == true){
            $data = $this->input->post();
            $data['Sub_lab_id'] = base64_decode($data['sublab_id']);
            $record['gmark_laboratory_type_id'] = $this->input->post('lab_type');
            $record['Sub_lab_name'] = $this->input->post('sublab_name');
            $record['Sub_lab_desc'] = $this->input->post('sublab_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $record['created_by'] = $user_id;
            $result = $this->SubLab_model->update_row('gmark_sub_laboratory_type', $record, ['Sub_lab_id' => $data['Sub_lab_id']]);
            if ($result) {
                $this->SubLab_model->total_log('Edit Sub LAB Name:- ' . $record['Sub_lab_name'] . ' ');
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
                'errors' => validation_errors(),
                'msg' => 'PLEASE VALID ENTER'
            );
            }
        echo json_encode($msg);
    }
}
?>