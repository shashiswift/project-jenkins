<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Standard_Applies extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Standard_Applies_model', 'SAM');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Standard Applies';
        $this->showDisplay('standard_applies/standard_applies', $data);
        // $this->load->view('header', $data);
        // $this->load->view('standard_applies/standard_applies');
        // $this->load->view('footer');
    }

    function fetch_records()
    {
        $fetch_data = $this->SAM->fetch_records($this->input->post());
        $data = array();
        $sl = $this->input->post('start') + 1;
        foreach ($fetch_data as $key => $row) {
            $status = ($row->status == 1) ? 'checked' : '';
            $title = ($row->status == 1) ? 'Active' : 'In-Active';
            $btnStatus = $btnUpdate = $btnDelete = $btnLog = '';
            if (exist_val("Standard_Applies/status", $this->session->userdata("permission"))) {
                $btnStatus = '<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input standard_applies_status" id="standard_applies_status_' . $row->id . '" ' . $status . '>
                    <label class="custom-control-label" title="' . $title . '" id="standard_applies_status_title_' . $row->id . '" for="standard_applies_status_' . $row->id . '"></label>
                </div>';
            }
            if (exist_val("Standard_Applies/update", $this->session->userdata("permission"))) {
                $btnUpdate = '<button type="button" data-id="' . $row->id . '" class="btn btn-primary btn-sm standard_applies_edit" title="Update"><i class="fa fa-edit"></i></button>';
            }
            if (exist_val("Standard_Applies/delete", $this->session->userdata("permission"))) {
                $btnDelete = '<button type="button" data-id="' . $row->id . '" class="btn btn-danger btn-sm standard_applies_delete ml-2" title="Delete"><i class="fa fa-trash"></i></button>';
            }
            if (exist_val("Standard_Applies/log", $this->session->userdata("permission"))) {
                $btnLog = '<button type="button" data-id="' . $row->id . '" class="btn btn-info btn-sm standard_applies_log ml-2" title="Logs"><i class="fa fa-eye"></i></button>';
            }
            $sub_array = array();
            $sub_array[] = $sl;
            $sub_array[] = $row->standard;
            $sub_array[] = $row->year;
            $sub_array[] = $row->user_name;
            $sub_array[] = $row->created_on;
            $sub_array[] = $btnStatus;
            $sub_array[] =  $btnUpdate . $btnDelete . $btnLog;
            $data[] = $sub_array;
            $sl++;
        }

        echo json_encode([
            "draw"              => intval($this->input->post('draw')),
            "recordsTotal"      => $this->SAM->get_all_data(),
            "recordsFiltered"   => $this->SAM->get_filtered_data($this->input->post()),
            "data"              => $data
        ]);
    }

    public function fetch_edit_standard_applies()
    {
        echo json_encode($this->SAM->get('*', 'standard_applies', ['id' => $this->input->post('id')]));
    }

    public function check_code()
    {
        $id = $this->input->post('id');
        $standard = $this->input->post('standard');
        $check = $this->SAM->check_code($id, $standard);
        if ($check) {
            $this->form_validation->set_message('check_code', 'Standard can not be the same. "It Must be Unique."');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_name()
    {
        $id = $this->input->post('id');
        $year = $this->input->post('year');
        $check = $this->SAM->check_name($id, $year);
        if ($check) {
            $this->form_validation->set_message('check_name', 'Year can not be the same. "It Must be Unique."');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function standard_applies_process()
    {
        $this->form_validation->set_rules('standard', 'Standard', 'trim|required|callback_check_code');
        $this->form_validation->set_rules('year', 'Year', 'trim|required|callback_check_name');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            foreach ($this->input->post() as $key => $value) {
                $response['error'][$key] = form_error($key);
            }
        } else {
            $id = $this->input->post('id');
            $response = array(
                'message'   => 'Something went wrong.',
                'code'      => 0
            );

            $data = array(
                'standard'  => strtoupper($this->input->post('standard')),
                'year'      => $this->input->post('year')
            );

            if (empty($id)) {
                $data['created_on'] = date("Y-m-d h:i:s");
                $data['created_by'] = $this->session->userdata('user_data')->id;
                $result = $this->SAM->insert_data('standard_applies', $data);
                if ($result) {
                    $log_details = array(
                        'source_module'     => 'standard_applies',
                        'operation'         => 'standard_applies_process',
                        'admin_id'          => $this->session->userdata('user_data')->id,
                        'record_id'         => $result,
                        'action_message'    => 'Added new Standard Applies.'
                    );
                    $this->SAM->insert_data('standard_applies_log', $log_details);

                    $response = array(
                        'message'   => 'Record has been inserted.',
                        'code'      => 1
                    );
                }
            } else {
                $result = $this->SAM->update_row('standard_applies', $data, ['id' => $id]);
                if ($result) {

                    $log_details = array(
                        'source_module'     => 'standard_applies',
                        'operation'         => 'standard_applies_process',
                        'admin_id'          => $this->session->userdata('user_data')->id,
                        'record_id'         => $id,
                        'action_message'    => 'Updated standard applies.'
                    );
                    $this->SAM->insert_data('standard_applies_log', $log_details);

                    $response = array(
                        'message'   => 'Record has been updated.',
                        'code'      => 1
                    );
                }
            }
        }
        echo json_encode($response);
    }

    public function standard_applies_status()
    {
        $result = $this->SAM->update_row('standard_applies', ['status' => $this->input->post('status')], ['id' => $this->input->post('id')]);
        if ($result) {

            $act = ($this->input->post('status') == 1) ? 'Active' : 'In-Active';
            $log_details = array(
                'source_module'     => 'Standard_Applies',
                'operation'         => 'standard_applies_status',
                'admin_id'          => $this->session->userdata('user_data')->id,
                'record_id'         => $this->input->post('id'),
                'action_message'    => 'Status changed to ' . $act
            );
            $this->SAM->insert_data('standard_applies_log', $log_details);

            $response = array(
                'message'   => 'Status has been changed.',
                'code'      => 1
            );
        } else {
            $response = array(
                'message'   => 'Something went wrong.',
                'code'      => 0
            );
        }
        echo json_encode($response);
    }

    public function standard_applies_delete()
    {
        $result = $this->SAM->delete_data('standard_applies', ['id' => $this->input->post('id')]);
        if ($result) {

            $log_details = array(
                'source_module'     => 'standard_applies',
                'operation'         => 'standard_applies_delete',
                'admin_id'          => $this->session->userdata('user_data')->id,
                'record_id'         => $this->input->post('id'),
                'action_message'    => 'Deleted standard applies.'
            );
            $this->SAM->insert_data('standard_applies_log', $log_details);

            $response = array(
                'message'   => 'Record has been deleted.',
                'code'      => 1
            );
        } else {
            $response = array(
                'message'   => 'Something went wrong.',
                'code'      => 0
            );
        }
        echo json_encode($response);
    }

    public function standard_applies_log()
    {
        echo json_encode($this->SAM->standard_applies_log($this->input->post('record_id')));
    }
}
