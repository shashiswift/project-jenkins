<?php
    class GsoStatus extends MY_Controller{

        
        function __construct(){
            parent::__construct();
            $this->load->model('GsoStatus_model');
            $this->permission('Lab/index');
        }

        public function index(){
           $this->showDisplay('gsostatus/index');
        }

        public function lab_listing($search, $page = 0){
            if (!empty($search) && $search != 'NULL') {
                $search = strtolower(base64_decode($search));
            } else {
                $search = NULL;
            }
            $per_page = 10;

            if ($page != 0) {
                $page = ($page - 1) * $per_page;
            }
            $total_row = $this->GsoStatus_model->get_lab_list(NULL, NULL, $search, '1');
            $data['pagination'] = $this->ajax_pagination('GsoStatus/lab_listing',$total_row,$per_page);
            $result = $this->GsoStatus_model->get_lab_list($per_page, $page, $search);
            $html = '';
            if($result){
                foreach($result as $value){
                    $page++;
                    $html .= '<tr>';
                    $html .= '<th scope="col">' . $page . '</th>';
                    $html .= '<td>' . $value->name . '</td>';
                    $html .= '<td>' . $value->created_on . '</td>';
                    $html .= '<td>';
                    if ($this->permission_action('GsoStatus/editGsoStatus')) {
                        $html .= '<button type="button" class="btn btn-sm edit_lab" data-toggle="modal" data-target="#labEditModal" data-one="'.$value->id.'"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></button>';
                    }
                    $html .= '</tr>';
                }
            } else {
                $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
            }
            $data['result'] = $html;
            echo json_encode($data);
        }

        public function add_lab(){
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            $this->form_validation->set_rules('name','Status Name','trim|required');
            if($this->form_validation->run() == true){
                $data['name'] = $this->input->post('name');
                $user_id = $this->session->userdata('user_data')->id;
                $data['created_by'] = $user_id;
                $result = $this->GsoStatus_model->insert_data('gso_status', $data);
                if ($result) {
                    $this->GsoStatus_model->total_log('Add GSO STATUS Name:- ' . $data['name'] . ' ');
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

        public function get_lab_details(){
            $lab_id = $this->input->post('lab_id');
            $data = $this->GsoStatus_model->get('*', 'gso_status', ['id' => $lab_id]);
            echo json_encode($data);
        }

        public function edit_lab(){
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            $this->form_validation->set_rules('id','Unique ID','trim|required');
            $this->form_validation->set_rules('name','Status Name','trim|required');
            if($this->form_validation->run() == true){
                $data = $this->input->post();
                $data['id'] = base64_decode($data['id']);
                $user_id = $this->session->userdata('user_data')->id;
                $data['created_by'] = $user_id;
                $result = $this->GsoStatus_model->update_row('gso_status', $data, ['id' => $data['id']]);
                if ($result) {
                    $this->GsoStatus_model->total_log('Edit Status Name:- ' . $data['name'] . ' ');
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
