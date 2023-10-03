<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Role_model');
        $this->permission('Role/index');
    }

    public function index()
    {
        $this->showDisplay('role/index');
    }

    public function role_listing($search, $page = 0)
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
        $total_row = $this->Role_model->get_role_list(NULL, NULL, $search, $where, '1');

        $data['pagination'] = $this->ajax_pagination('Role/role_listing', $total_row, $per_page);

        $result = $this->Role_model->get_role_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->name . '</td>';
                $html .= '<td>' . (($value->status > 0) ? 'ACTIVE' : 'IN-ACTIVE') . '</td>';
                $html .= '<td>';
                if ($this->permission_action('Role/edit')) {
                $html .= '<a href="javascript:void(0);" title="UPLOAD DOCUMENTS" class="btn btn-sm edit_role" data-toggle="modal" data-id="' . base64_encode($value->role_id) . '" data-target="#edit_application"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM" class="edit_application_data" ></a> ';
                }
                if ($this->permission_action('Role/save_permission')) {
                    $html .= '<a title="PERMISSION" href="javascript:void(0);" class="btn btn-sm permission" data-toggle="modal" data-id="' . base64_encode($value->role_id) . '" data-target="#role_permission"><img width="28px" src="' . base_url('public/icon/permission_role.png') . '" alt="GEOCHEM" class="edit_application_data" ></a>';
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
    public function add()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('name', 'ROLE NAME', 'trim|required|min_length[3]|is_unique[roles.name]');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $insert = $this->Role_model->insert_data('roles', $post);
            if ($insert) {
                $this->Role_model->total_log(' ADD ROLE NAME ' . $post['name']);
                $msg = array(
                    'status' => 1,
                    'msg' => 'SUCCESSFULLY INSERT ROLE'
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
    public function role_get()
    {
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        echo json_encode($this->Role_model->get('*', 'roles', ['role_id' => $post['id']]));
    }
    public function edit()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('name', 'ROLE NAME', 'trim|required|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $role = $this->Role_model->get('*', 'roles', ['role_id' => $post['role_id']]);
            $insert = $this->Role_model->update_row('roles', $post, ['role_id' => $post['role_id']]);
            if ($insert) {
                $this->Role_model->total_log('ROLE NAME CHANGE ' . $role->name . ' TO ' . $post['name']);
                $msg = array(
                    'status' => 1,
                    'msg' => 'SUCCESSFULLY INSERT ROLE'
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
    public function fetch_functions($controller)
    {
        return $this->Role_model->fetch_functions($controller);
    }
    public function fetch_controller()
    {
        return $this->Role_model->fetch_controller();
    }
    public function fetch_permission()
    {
        $post = $this->input->post();
        $post['role_id'] = base64_decode($post['role_id']);
        $functions = $this->Role_model->fetch_permission($post);
        if ($functions)
            echo json_encode($functions);
        else
            echo false;
    }
    public function save_permission()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('role_id', 'UNIQUE ID', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $roleID = base64_decode($this->input->post('role_id'));
            $functionID = $this->input->post('function_id');
            if (count($functionID) > 1) {
                $functionID = implode(',', $functionID);
            } else {
                $functionID = current($functionID);
            }
            $functions = $this->Role_model->save_permission($roleID, $functionID);
            if ($functions) {
                $msg = array(
                    'status' => 1,
                    'msg' => 'PERMISSION SET SUCCESSFULLY'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'PERMISSION NOT SET'
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
    public function fetch_list()
    {
        $controller = $this->fetch_controller();
        if ($controller) {
            $html = '<div class="col-4"><div class="list-group" id="list-tab" role="tablist">';
            $functions_html = '<div class="col-8"><div class="tab-content" id="nav-tabContent">';
            foreach ($controller as $key => $value) {
                $functions = $this->fetch_functions(['controller_name' => $value->controller_name]);
                $functions_html .= '<div class="tab-pane fade" id="list-' . $value->controller_name . '" role="tabpanel" aria-labelledby="list-home-list">';
                $html .= '<a class="list-group-item list-group-item-action" id="list-' . $value->controller_name . '-list" data-toggle="list" href="#list-' . $value->controller_name . '" role="tab" aria-selected="true">' . $value->controller_name . "</a>";
                foreach ($functions as $key1 => $value1) {
                    $functions_html .=  '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="function_id[]" value="' . $value1->function_id . '"><label class="form-check-label" for="inlineCheckbox1">' . $value1->alias . "</label></div>";
                }
                $functions_html .= '</div>';
            }
            $html .= ' </div></div>';
            $functions_html .= '</div></div>';
            $controller = $html . $functions_html;
        } else {
            $controller = false;
        }
        echo json_encode($controller);
    }
}
