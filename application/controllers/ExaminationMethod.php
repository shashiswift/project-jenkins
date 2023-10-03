<?php
class ExaminationMethod extends MY_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('ExaminationMethod_model');
        $this->permission('ExaminationMethod/index');
    }

    public function index(){
        $this->showDisplay('Examination_method/examination_method');
    }

    public function examination_listing($search, $page = 0){
        if (!empty($search) && $search != 'NULL') {
            $search = strtolower(base64_decode($search));
        } else {
            $search = NULL;
        }
        $per_page = 10;

        if ($page != 0) {
            $page = ($page - 1) * $per_page;
        }
        $total_row = $this->ExaminationMethod_model->examination_listing(NULL, NULL, $search, '1');
        $data['pagination'] = $this->ajax_pagination('ExaminationMethod/examination_listing',$total_row,$per_page);
        $result = $this->ExaminationMethod_model->examination_listing($per_page, $page, $search);
        $html = '';
        if($result){
            foreach($result as $value){
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->ex_method_name . '</td>';
                $html .= '<td>' . $value->ex_method_desc . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if ($this->permission_action('ExaminationMethod/edit_examination')) {
                $html .= '<button type="button" class="btn btn-sm edit_examination" data-toggle="modal" data-target="#edit_examination_data" data-one="'.$value->ex_method_id.'"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></button>';
                }
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
        }
        $data['result'] = $html;
        echo json_encode($data);
    }

    public function add_examination(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('ex_method_name','Name','trim|required');
        $this->form_validation->set_rules('ex_method_desc','Description','trim|required');
        if($this->form_validation->run() == true){
            $data['ex_method_name'] = $this->input->post('ex_method_name');
            $data['ex_method_desc'] = $this->input->post('ex_method_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->ExaminationMethod_model->insert_data('gmark_examination_method', $data);
            if ($result) {
                $this->ExaminationMethod_model->total_log('Add Examination Method Name:- ' . $data['ex_method_name'] . ' ');
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

    public function get_examination_details(){
        $examination_id = $this->input->post('examination_id');
        $data = $this->ExaminationMethod_model->get('*', 'gmark_examination_method', ['ex_method_id' => $examination_id]);
        echo json_encode($data);
    }

    public function edit_examination(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('ex_method_id','Unique ID','trim|required');
        $this->form_validation->set_rules('ex_method_name','Name','trim|required');
        $this->form_validation->set_rules('ex_method_desc','Description','trim|required');
        if($this->form_validation->run() == true){
            $data = $this->input->post();
            $data['ex_method_id'] = base64_decode($data['ex_method_id']);
            $data['ex_method_name'] = $this->input->post('ex_method_name');
            $data['ex_method_desc'] = $this->input->post('ex_method_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->ExaminationMethod_model->update_row('gmark_examination_method', $data, ['ex_method_id' => $data['ex_method_id']]);
            if ($result) {
                $this->ExaminationMethod_model->total_log('Edit Examination Method Name:- ' . $data['ex_method_name'] . ' ');
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
?>