<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->permission('User/index'); 
        
    }
    public function index()
    {
       // echo base_url();
        $this->showDisplay('user/index');
    }
    public function role_list()
    {
        echo json_encode($this->User_model->get_result('role_id,name', 'roles'));
    }
    public function add_user()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[1]');
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|min_length[3]');
        $this->form_validation->set_rules('email', 'EMAIL', 'required|trim|valid_email|min_length[3]|is_unique[users.email]');
        $this->form_validation->set_rules('role_id', 'ROLE', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('password', 'PASSWORD', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('cpassword', 'CONFIRM PASSWORD', 'trim|required|matches[password]');
        $this->form_validation->set_rules('default_country', 'COUNTRY', 'required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('address', 'ADDRESS', 'trim|min_length[3]');
        $this->form_validation->set_rules('status', 'STATUS', 'required|trim|in_list[0,1]');
        $this->form_validation->set_rules('phone_number', 'PHONE NUMBER', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            unset($data['cpassword']);
            $data['password'] = md5($data['password']);
            $result = $this->User_model->insert_data('users', $data);
            if ($result) {
                $this->User_model->total_log('Add USER Name :- ' . $data['first_name'] . ' LAST Name:- ' . $data['first_name']);
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
    public function get_user()
    {
        $post = $this->input->post();
        echo json_encode($this->User_model->get('*', 'users', $post));
    }
    public function edit_user()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[1]');
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|min_length[3]');
        $this->form_validation->set_rules('email', 'EMAIL', 'required|trim|valid_email|min_length[3]|callback_email_check');
        $this->form_validation->set_rules('role_id', 'ROLE', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('password', 'PASSWORD', 'trim|min_length[5]');
        $this->form_validation->set_rules('cpassword', 'CONFIRM PASSWORD', 'trim|matches[password]');
        $this->form_validation->set_rules('default_country', 'COUNTRY', 'required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('address', 'ADDRESS', 'trim|min_length[3]');
        $this->form_validation->set_rules('status', 'STATUS', 'required|trim|in_list[0,1]');
        $this->form_validation->set_rules('phone_number', 'PHONE NUMBER', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            unset($data['cpassword']);
            if (empty($data['password'])) {
                unset($data['password']);
            }else{
                $data['password'] = md5($data['password']);
            }
            $result = $this->User_model->update_row('users', $data, ['id' => $data['id']]);
            if ($result) {
                $this->User_model->total_log('EDIT USER Name :- ' . $data['first_name'] . ' Last Name :- ' . $data['first_name']);
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
                'errors' =>  $this->form_validation->error_array(),
                'msg' => 'PLEASE VALID ENTER'
            );
        }
        echo json_encode($msg);
    }
    public function email_check()
    {
        $data = $this->input->post();
        $this->db->like('email', $data['email']);
        $this->db->where_not_in('id', [$data['id']]);
        $result = $this->db->get('users');
        if ($result->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function User_listing($country, $role, $search, $page = 0)
    {
        $where = NULL;
        if (!empty($country) && $country != 'NULL') {
            $where['users.default_country'] = base64_decode($country);
        }
        if (!empty($role) && $role != 'NULL') {
            $where['users.role_id'] = base64_decode($role);
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
        $total_row = $this->User_model->get_user_list(NULL, NULL, $search, $where, '1');
        $data['pagination'] = $this->ajax_pagination('User/User_listing', $total_row, $per_page);
        $result = $this->User_model->get_user_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->first_name . ' ' . $value->last_name . '</td>';
                $html .= '<td>' . $value->email . '</td>';
                $html .= '<td>' . $value->country_name . '</td>';
                $html .= '<td>' . $value->name . '</td>';
                $html .= '<td>' . $value->last_login . '</td>';
                $html .= '<td>' . (($value->status > 0) ? 'ACTIVE' : 'IN-ACTIVE') . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if ($this->permission_action('User/edit_user')) {
                    $html .= '<a href="javascript:void(0);" title="UPLOAD DOCUMENTS" class="btn btn-sm edit_user" data-toggle="modal" data-id="' . base64_encode($value->id) . '" data-target="#edit_user_details"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="EDIT"></a>';
                }
                if ($this->permission_action('User/sign_upload')) {
                    $html .= '<a href="javascript:void(0);" title="VIEW SIGN UPLOAD" class="btn btn-sm use_sign" data-toggle="modal" data-id="' . base64_encode($value->id) . '" data-target="#USER_SIGNATURE"><img width="28px" src="' . base_url('public/icon/view_documents.png') . '" alt="VIEW"></a>';
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
    public function sign_upload()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('images', 'Document', 'callback_file_selected_test');
        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $data['id'] = base64_decode($data['id']);
            $img = $this->User_model->get('first_name,last_name,signature_path', 'users', ['id' => $data['id']]);
            $image_delte = TRUE;
            if ($img && !empty($img->signature_path)) {
                $file = explode('.com/', $img->signature_path);
                $image_delte = $this->delete_file_from_aws($file[1]);
            }
            if ($image_delte) {
                $file = $_FILES['images'];
                $upload_path = $this->upload_file($file['tmp_name'], $file['type'], (($img) ? ($img->first_name) : 'USER') . date('H:i:s') . '.' . pathinfo(basename($file['name']), PATHINFO_EXTENSION), 'GMARK/USER_SIGNATURE/');
                if ($upload_path) {
                    $result = $this->User_model->update_row('users', ['signature_path' => $upload_path], ['id' => $data['id']]);
                    if ($result) {
                        $this->User_model->total_log('UPDATE USER SIGNATURE USER Name :- ' . (($img) ? ($img->first_name) : 'USER'));
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SIGNATURE UPDATED'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'SIGNATURE NOT UPDATED'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'SIGNATUR NOT UPLOAD'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'SIGNATUR NOT DELETE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => validation_errors(),
                'msg' => 'PLEASE ENTER VALID SIGNATURE'
            );
        }
        echo json_encode($msg);
    }
}
