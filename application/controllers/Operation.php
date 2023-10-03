<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operation extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('Operation_model','OM'); 
        $this->permission('Operation/index');    
    }

    public function index()
    {
        $this->showDisplay('operation/index');
    }
    public function operation_listing($search,$page)
    {
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
        $total_row = $this->OM->get_operation_list(NULL, NULL, $search, $where, '1');
        $data['pagination'] = $this->ajax_pagination('Operation/operation_listing',$total_row,$per_page);
        $result = $this->OM->get_operation_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->controller_name . '</td>';
                $html .= '<td>' . $value->function_name . '</td>';
                $html .= '<td>' . $value->alias . '</td>';
                $html .= '<td>';
                if ($this->permission_action('Operation/edit')) {
                    $html .= '<a title="EDIT" href="javascript:void(0);" class="btn btn-sm edit" data-toggle="modal" data-id="' . base64_encode($value->function_id) . '" data-target="#edit_operation"><img width="28px" src="' . base_url('public/icon/permission_role.png') . '" alt="GEOCHEM" class="edit_application_data" ></a>';
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
    public function add(){
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('function_name', 'FUNCTION NAME', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('controller_name', 'CONTROLLER NAME', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('alias', 'ALIAS NAME', 'trim|required|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $insert = $this->OM->insert_data('functions', $post);
            if ($insert) {
                $this->OM->total_log('ADD OPERATION NAME ' . $post['alias']);
                $msg = array(
                    'status' => 1,
                    'msg' => 'SUCCESSFULLY INSERT OPERATION'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'ERROR WHILE INSERT'
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
    public function operation_get()
    {
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        echo json_encode($this->OM->get('*', 'functions', ['function_id' => $post['id']]));
    }
    public function edit()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('function_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('function_name', 'FUNCTION NAME', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('controller_name', 'CONTROLLER NAME', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('alias', 'ALIAS NAME', 'trim|required|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $get = $this->OM->get('alias','functions',['function_id'=>$post['function_id']]);
            $insert = $this->OM->update_row('functions', $post,['function_id'=>$post['function_id']]);
            if ($insert) {
                $this->OM->total_log('EDIT OPERATION NAME CHANGE '. $get->alias . ' TO ' . $post['alias']);
                $msg = array(
                    'status' => 1,
                    'msg' => 'SUCCESSFULLY EDIT OPERATION'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'ERROR WHILE INSERT'
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
}
