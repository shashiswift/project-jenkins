<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regenerate extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Regenrate_model', 'RM');
        $this->permission('Regenerate/index');    
    }
    public function index()
    {
        $this->showDisplay('re-generate/index');
    }
    public function approval()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('reason', 'REASON', 'trim|required|min_length[5]');
        if ($this->form_validation->run() == TRUE) {
            //report_content
            //re_generate
            $post = $this->input->post();
            $user_id = $this->session->userdata('user_data');
            $post['registration_id'] = base64_decode($post['registration_id']);
            $req = $this->RM->get('seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
            $coc = $this->RM->get('coc_no', 'report_content', ['registration_id' => $post['registration_id']]);
            if ($req) {
                $data = array(
                    'registration_id' => $post['registration_id'],
                    'reason' => $post['reason'],
                    'created_by' => $user_id->id,
                    'coc_number' => $coc->coc_no,
                );
                $request = $this->RM->insert_data('re_generate_request', $data);
                if ($request) {
                    $update = $this->RM->update_row('report_content', ['re_generate' => 1], ['registration_id' => $post['registration_id']]);
                    if ($update) {
                        $job = $this->RM->get('job_no', 'job_number', ['registration_id' => $post['registration_id']]);
                        $coc = $this->RM->get('coc_no,aws_path', 'report_content', ['registration_id' => $post['registration_id']]);
                        $this->RM->gmark_registration_log($post['registration_id'], $req->seq_no . ' REQUEST FOR RE-GENERTE REPORT');
                        $message = '<html><body>';
                        $message .= '<p>Dear Sir/Madam</p><br/>';
                        $message .= '<p>REQUEST FOR RE-GENERATE   : ' . $req->seq_no . '</p>';
                        $message .= '<p>Kindly find COC/NCR certificate as attachment</p>';
                        $message .= '<p>REASON : ' . $post['reason'] . '</p>';
                        $message .= '<p>REQUEST BY Name: ' . $user_id->first_name . ' ' . $user_id->last_name . '</p>';
                        $message .= '<p></p>';
                        $message .= '</body></html>';
                        send_mail_function(APPROVALFORREGENERATE, CC, $message, 'RE-GENERATE REQUEST FOR REPORT No. ' . $coc->coc_no, $coc->aws_path);
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SUCCESSFULLY RE-GENERATE REQUEST APPROVAL SUBMIT'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'ERROR WHILE RE-GENERATE REQUEST APPROVAL SUBMIT'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'ERROR WHILE RE-GENERATE REASON SUBMIT'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'NO RECORD FOUND FOR THIS REPORT'
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
    public function re_generate_listing($search, $page = 0)
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
        $total_row = $this->RM->get_reports_list(NULL, NULL, $search, $where, '1');
        $data['pagination'] = $this->ajax_pagination('Regenerate/re_generate_listing', $total_row, $per_page);
        $result = $this->RM->get_reports_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . $value->coc_number . '</td>';
                $html .= '<td>' . $value->job_no . '</td>';
                $html .= '<td>' . $value->seq_no . '</td>';
                $html .= '<td>';
                if ($value->status == 0) {
                    $html .= 'APPROVED';
                } elseif ($value->status == 2) {
                    $html .= 'REJECT';
                } else {
                    $html .= 'PENDING';
                }
                $html .= '</td>';
                $html .= '<td>' . date('d-M-Y', strtotime($value->created_on)) . '</td>';
                $html .= '<td>';
                if ($value->status == 0) {
                    $html .= '<img title="ALREADY APPROVED" width="32px" src="' . base_url('public/icon/approved_re_generate_request.png') . '" alt="GEOCHEM">';
                } elseif ($value->status == 2) {
                    $html .= '<img title="ALREADY REJECT" width="32px" src="' . base_url('public/icon/reject_re-generate_request.png') . '" alt="GEOCHEM">';
                } else {
                    if ($this->permission_action('Regenerate/approved')) {
                        $html .= '<a data-id="' . base64_encode($value->id) . '" class="btn btn-sm approved_request" title="APPROVED REQUEST" href="javascript:void(0);"><img width="32px" src="' . base_url('public/icon/approved_re_generate_request.png') . '" alt="GEOCHEM"></a>';
                    }
                    if ($this->permission_action('Regenerate/reject')) {
                        $html .= '<a data-id="' . base64_encode($value->id) . '" class="btn btn-sm reject_request" title="REJECT REQUEST" href="javascript:void(0);"><img width="32px" src="' . base_url('public/icon/reject_re-generate_request.png') . '" alt="GEOCHEM"></a>';
                    }
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
    public function approved()
    {
        $post = $this->input->post();
        $user_id = $this->session->userdata('user_data');
        $post['id'] = base64_decode($post['id']);
        $get = $this->RM->get('registration_id,created_by,coc_number', 're_generate_request', ['id' => $post['id']]);
        if ($get) {
            $update = $this->RM->update_row('re_generate_request', ['status' => 0], ['id' => $post['id']]);
            if ($update) {
                $update = $this->RM->update_row('report_content', ['re_generate' => 3], ['registration_id' => $get->registration_id]);
                if ($update) {
                    $seq = $this->RM->get('seq_no', 'gmark_registration', ['registration_id' => $get->registration_id]);
                    $this->RM->gmark_registration_log($get->registration_id, $seq->seq_no . ' :- RE-GENERATE REQUEST APPROVED');
                    $user = $this->RM->get('email', 'users', ['id' => $get->created_by]);
                    $message = '<html><body>';
                    $message .= '<p>Dear Sir/Madam</p><br/>';
                    $message .= '<p>REQUEST FOR RE-GENERATE   : ' . $seq->seq_no . '</p>';
                    $message .= '<p>Kindly find COC/GEC certificate as attachment</p>';
                    $message .= '<p>COC NUMBER: ' . $get->coc_number . '</p>';
                    $message .= '<p>APPROVED BY Name: ' . $user_id->first_name . ' ' . $user_id->last_name . '</p>';
                    $message .= '<p></p>';
                    $message .= '</body></html>';
                    send_mail_function($user->email, CC, $message, 'APPROVED RE-GENERATE REQUEST FOR REPORT No. ' . $get->coc_number);
                    $msg = array(
                        'status' => 1,
                        'msg' => 'SUCCESSFULLY APPROVED RE-GENERATE COC No.:-  ' . $seq->seq_no
                    );
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'REPORT CONTANT ERROR'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT UPDATE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'msg' => 'NO RECORD FOUND'
            );
        }
        echo json_encode($msg);
    }
    public function reject()
    {
        $post = $this->input->post();
        $user_id = $this->session->userdata('user_data');
        $post['id'] = base64_decode($post['id']);
        $get = $this->RM->get('registration_id,created_by,coc_number', 're_generate_request', ['id' => $post['id']]);
        if ($get) {
            $update = $this->RM->update_row('re_generate_request', ['status' => 2], ['id' => $post['id']]);
            if ($update) {
                $update = $this->RM->update_row('report_content', ['re_generate' => 0], ['registration_id' => $get->registration_id]);
                if ($update) {
                    $seq = $this->RM->get('seq_no', 'gmark_registration', ['registration_id' => $get->registration_id]);
                    $this->RM->gmark_registration_log($get->registration_id, $seq->seq_no . ' :- RE-GENERATE REQUEST APPROVED');
                    $user = $this->RM->get('email', 'users', ['id' => $get->created_by]);
                    $message = '<html><body>';
                    $message .= '<p>Dear Sir/Madam</p><br/>';
                    $message .= '<p>REQUEST FOR RE-GENERATE   : ' . $seq->seq_no . '</p>';
                    $message .= '<p>Kindly find COC/GEC certificate as attachment</p>';
                    $message .= '<p>COC NUMBER: ' . $get->coc_number . '</p>';
                    $message .= '<p>APPROVED BY Name: ' . $user_id->first_name . ' ' . $user_id->last_name . '</p>';
                    $message .= '<p></p>';
                    $message .= '</body></html>';
                    send_mail_function($user->email, CC, $message, 'REJECT RE-GENERATE REQUEST FOR REPORT No. ' . $get->coc_number);
                    $msg = array(
                        'status' => 1,
                        'msg' => 'SUCCESSFULLY APPROVED RE-GENERATE COC No.:-  ' . $seq->seq_no
                    );
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'REPORT CONTANT ERROR'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT UPDATE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'msg' => 'NO RECORD FOUND'
            );
        }
        echo json_encode($msg);
    }
}
