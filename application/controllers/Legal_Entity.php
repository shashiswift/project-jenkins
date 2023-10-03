<?php
class Legal_Entity extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Legal_Entity_model', 'legalEntity_model');
        $this->permission('Legal_Entity/index');
    }

    public function index()
    {
        $this->showDisplay('legal_entity/legalEntity_list');
    }

    public function legalEntity_listing($search, $page = 0)
    {
        if (!empty($search) && $search != 'NULL') {
            $search = strtolower(base64_decode($search));
        } else {
            $search = NULL;
        }
        $per_page = 10;

        if ($page != 0) {
            $page = ($page - 1) * $per_page;
        }
        $total_row = $this->legalEntity_model->legalEntity_list(NULL, NULL, $search, '1');
        $data['pagination'] = $this->ajax_pagination('legalEntity/legalEntity_listing', $total_row,$per_page);
        $result = $this->legalEntity_model->legalEntity_list($per_page, $page, $search);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->legal_entity_name . '</td>';
                $html .= '<td>' . $value->legal_entity_desc . '</td>';
                $html .= '<td>' . $value->created_on . '</td>';
                $html .= '<td>';
                if ($this->permission_action('Legal_Entity/edit_legalEntity')) {
                    $html .= '<button type="button" class="btn btn-sm edit_legalEntity" data-toggle="modal" data-target="#edit_legalEntity" data-one="' . $value->legal_entity_id . '"><img width="28px" src="' . base_url('public/icon/edit.png') . '" alt="GEOCHEM"></button>';
                }
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="14"><h4>NO RECORD FOUND</h4></td></tr>';
        }
        $data['result'] = $html;
        echo json_encode($data);
    }

    public function add_legalEntity()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('legal_entity_name', 'Legal Entity Name', 'trim|required');
        $this->form_validation->set_rules('legal_entity_desc', 'Legal Entity Description', 'trim|required');
        if ($this->form_validation->run() == true) {
            $data['legal_entity_name'] = $this->input->post('legal_entity_name');
            $data['legal_entity_desc'] = $this->input->post('legal_entity_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->legalEntity_model->insert_data('gmark_legal_entity_type', $data);
            if ($result) {
                $this->legalEntity_model->total_log('Add Legal Entity Name:- ' . $data['legal_entity_name'] . ' ');
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

    public function get_legalentity_details()
    {
        $legal_entity_id = $this->input->post('legal_entity_id');
        $data = $this->legalEntity_model->get('*', 'gmark_legal_entity_type', ['legal_entity_id' => $legal_entity_id]);
        echo json_encode($data);
    }

    public function edit_legalEntity()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('legal_entity_id', 'Unique ID', 'trim|required');
        $this->form_validation->set_rules('legal_entity_name', 'Legal Entity Name', 'trim|required');
        $this->form_validation->set_rules('legal_entity_desc', 'Legal Entity Description', 'trim|required');
        if ($this->form_validation->run() == true) {
            $data = $this->input->post();
            $data['legal_entity_id'] = base64_decode($data['legal_entity_id']);
            $data['legal_entity_name'] = $this->input->post('legal_entity_name');
            $data['legal_entity_desc'] = $this->input->post('legal_entity_desc');
            $user_id = $this->session->userdata('user_data')->id;
            $data['created_by'] = $user_id;
            $result = $this->legalEntity_model->update_row('gmark_legal_entity_type', $data, ['legal_entity_id' => $data['legal_entity_id']]);
            if ($result) {
                $this->legalEntity_model->total_log('Update Legal Entity Name:- ' . $data['legal_entity_name'] . ' ');
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
