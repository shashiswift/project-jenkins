<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApplicationType extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Application_model');
        $this->load->helper('url');
        $this->permission('ApplicationType/index');
    }

    public function index()
    {
        $this->showDisplay('applicationType/index');
    }

    public function application_listing($search, $page = 0)
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
        $data['pagination'] = $this->ajax_pagination('Application/application_listing',$total_row,$per_page);
        $result = $this->Application_model->get_application_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->application_name . '</td>';
                $html .= '<td>' . $value->application_desc . '</td>';

                $html .= '<td>' . $value->first_name . '</td>';

                // $html .= '<td>' . (($value->status > 0) ? 'ACTIVE' : 'IN-ACTIVE') . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if ($this->permission_action('ApplicationType/edit_application')) {
                    $html .= '<button type="button" title="EDIT APPLICATION" class="btn btn-sm edit_application_data" data-toggle="modal" data-id="' . base64_encode($value->application_id) . '" data-target="#edit_application"  ><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM" ></button>';
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
            // print_r($data);die;
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
        $id = base64_decode($this->input->post('id'));
        $result = $this->Application_model->get('*', 'gmark_application', ['application_id' => $id]);

        echo json_encode($result);
    }

    // insert laboratory 


    public function edit_application()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('id', 'Application Name', 'trim|required');
        $this->form_validation->set_rules('app_name', 'Application Name', 'trim|required|callback_check_unique');
        $this->form_validation->set_rules('app_desc', 'Application Description', 'trim|min_length[3]');
        if ($this->form_validation->run() == TRUE) {
            $data['application_id'] = $this->input->post('id');

            $data['application_name'] = $this->input->post('app_name');
            $data['application_desc'] = $this->input->post('app_desc');
            $result =   $this->Application_model->update_data($data);
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
    public function check_unique()
    {
        $post = $this->input->post();
        $this->db->select('count(*) as count');
        $this->db->where('LOWER(application_name)', strtolower($post['app_name']));
        $this->db->where_not_in('application_id', [$post['id']]);
        $result = $this->db->get('gmark_application')->row();
        if ($result->count > 0) {
            $this->form_validation->set_message('check_unique', 'The {field} field can UNIQUE');
            return FALSE;
        } else {
            return TRUE;
        }
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

}
