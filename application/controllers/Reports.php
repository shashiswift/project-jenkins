<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
        $this->load->model('Gmark_model');
        $this->load->helper('url');
        $this->permission('Reports/index');
    }

    public function index()
    {
        $data['lab_name'] = $this->Gmark_model->get_data_from_table('lab_id,lab_name', 'gmark_laboratory_type');
        $data['country'] = $this->Gmark_model->get_destination();
        $data['applicantion'] = $this->Gmark_model->get_result('application_id,application_name', 'gmark_application');
        $this->showDisplay('report/index', $data);
    }

    public function report_listing($applicant_id, $manufacture_id, $factory_id, $lab_id, $start_date, $end_date, $destination, $applicantion_name, $search, $page = 0)
    {
        $where = NULL;
        if (!empty($applicant_id) && $applicant_id != 'NULL') {
            $where['gmark.applicant_id'] = $applicant_id;
        }
        if (!empty($manufacture_id) && $manufacture_id != 'NULL') {
            $where['gmark.manufacturer_id'] = $manufacture_id;
        }
        if (!empty($factory_id) && $factory_id != 'NULL') {
            $where['FIND_IN_SET("' . $factory_id . '",gmark.factory_id) <> 0 '] = NULL;
        }
        if (!empty($lab_id) && $lab_id != 'NULL') {
            $where['gmark.lab_id'] = $lab_id;
        }
        if (!empty($start_date) && $start_date != 'NULL') {
            $where['report_content.release_date >= '] = $start_date;
        }
        if (!empty($end_date) && $end_date != 'NULL') {
            $where['report_content.release_date <= '] = $end_date;
        }
        if (!empty($destination) && $destination != 'NULL') {
            $where['FIND_IN_SET("' . $destination . '",gmark.destination) <> 0 '] = NULL;
        }
        if (!empty($applicantion_name) && $applicantion_name != 'NULL') {
            $where['gmark.application_type'] = $applicantion_name;
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
        $total_row = $this->Report_model->get_reports_list(NULL, NULL, $search, $where, '1');
        $data['pagination'] = $this->ajax_pagination('Reports/report_listing', $total_row, $per_page);
        $result = $this->Report_model->get_reports_list($per_page, $page, $search, $where);
        $html = '';
        if ($result) {
            foreach ($result as $value) {
                $page++;
                $html .= '<tr>';
                $html .= '<th scope="col">' . $page . '</th>';
                $html .= '<td>' . (($value->coc_no) ? $value->coc_no : 'NOT GENERATED') . '</td>';
                $html .= '<td>' . $value->job_no . '</td>';
                $html .= '<td>' . $value->seq_no . '</td>';
                $html .= '<td>' . $value->application_name . '</td>';
                $html .= '<td>' . $value->applicant_name . '</td>';
                $html .= '<td>' . $value->destination_name . '</td>';
                $html .= '<td>' . $value->lab_name . '</td>';
                $html .= '<td>' . (($value->status > 0) ? 'ACTIVE' : 'IN-ACTIVE') . '</td>';
                $html .= '<td>';
                if (!empty($value->coc_type)) {
                    $html .= '<a class="btn btn-sm btn-primary"  data-id="1" title="' . (($value->coc_type == 1) ? 'GULF TYPE EXAMINATION CERTIFICATE' : 'CERTIFICATION OF CONFORMITY') . '" href="javascript:void(0);">' . (($value->coc_type == 1) ? 'GEC' : 'COC') . '</a>';
                } else {
                    $html .= 'N/A';
                }
                $html .= '</td>';
                $html .= '<td>' . date('d-M-Y', strtotime($value->created_on)) . '</td>';
                $html .= '<td>' . (($value->release_date) ? (date('d-M-Y', strtotime($value->release_date))) : 'NOT RELEASED') . '</td>';
                $html .= '<td>';
                if (empty($value->aws_path)) {
                     if (empty($value->gmark_qrcode)) {
                        $html .= '<a data-toggle="modal" data-target="#qr_code_update" data-id="' . base64_encode($value->registration_id) . '" class="btn btn-sm qrcode_update" title="UPDATE GMARK CODE" href="javasript:void(0);"><img width="32px" src="' . base_url('public/icon/gmarkQRCODE.png') . '" alt="GEOCHEM"></a>';
                    }
                    if ($this->permission_action('Reports/image_upload')) {
                        $html .= '<a data-toggle="modal" data-target="#report_add" class="btn btn-sm upload_image_rear" title="ADD PRODUCTS PHOTO" data-id="' . base64_encode($value->registration_id) . '" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/add_report.png') . '" alt="GEOCHEM"></a>';
                    }
                    if ($this->permission_action('Reports/image_upload_view')) {
                        $html .= '<a data-toggle="modal" data-target="#report_add_view" class="btn btn-sm rear_image" title="VIEW PRODUCTS PHOTO" data-id="' . base64_encode($value->registration_id) . '" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/image_view.png') . '" alt="GEOCHEM"></a>';
                    }
                    if ($value->report_id) {
                        if ($this->permission_action('Reports/edit_content_upload')) {
                            $html .= '<a data-toggle="modal" data-target="#report_content_edit" class="btn btn-sm content_edit" title="EDIT PDF CONTENT" data-id="' . base64_encode($value->registration_id) . '" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/PDF_CONTENT.png') . '" alt="GEOCHEM"></a>';
                        }
                        if ($this->permission_action('Reports/approved_pdf')) {
                            if (empty($value->approved_by)) {
                                $html .= '<a data-id="' . base64_encode($value->registration_id) . '" class="btn btn-sm pdf_report" title="APPROVED REPORT" href="javascript:void(0);"><img width="32px" src="' . base_url('public/icon/REPORT_APPROVED.png') . '" alt="GEOCHEM"></a>';
                            }
                        }
                    } else {
                        if ($this->permission_action('Reports/content_upload')) {
                            $html .= '<a data-toggle="modal" data-target="#report_content_add" class="btn btn-sm content_add" title="ADD PDF CONTENT" data-id="' . base64_encode($value->registration_id) . '" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/PDF_CONTENT.png') . '" alt="GEOCHEM"></a>';
                        }
                    }
                    if ($this->permission_action('Reports/pdf_view') || $this->permission_action('Reports/release_pdf')) {
                        if (!empty($value->coc_type) && $value->product_image > 0) {
                            $html .= '<a data-toggle="modal" data-approved="' . (($this->permission_action('Reports/release_pdf')) ? ((!empty($value->approved_by) ? $value->approved_by : '0')) : '0') . '" data-url="' . base_url('Reports/pdf_view?registration_id=' . base64_encode($value->registration_id)) . '" data-target="#report_content_approved" data-id="' . base64_encode($value->registration_id) . '" class="btn btn-sm pdf_view" title="VIEW GENERATE REPORT" href="javasript:void(0);"><img width="32px" src="' . base_url('public/icon/VIEW_REPORT.png') . '" alt="GEOCHEM"></a>';
                        } else {
                            $html .= '<a data-toggle="modal" data-approved="0" data-url="' . base_url('Reports/pdf_view?registration_id=' . base64_encode($value->registration_id)) . '" data-target="#report_content_approved" data-id="' . base64_encode($value->registration_id) . '" class="btn btn-sm pdf_view" title="VIEW GENERATE REPORT" href="javasript:void(0);"><img width="32px" src="' . base_url('public/icon/VIEW_REPORT.png') . '" alt="GEOCHEM"></a>';
                        }
                    }
                } else {
                    if ($this->permission_action('Reports/download_pdf')) {
                        if ($value->report_id) {
                            $html .= '<a class="btn btn-sm" title="DOWNLOAD REPORT" href="' . base_url('Reports/download_pdf?report_id=' . base64_encode($value->report_id)) . '"><img width="32px" src="' . base_url('public/icon/REPORT_DOWNLOAD.png') . '" alt="GEOCHEM"></a>';
                        }
                    }
                    if ($value->re_generate == 1) {
                        if ($this->permission_action('Regenerate/approval')) {
                            $html .= '<a data-id="' . base64_encode($value->registration_id) . '" class="btn btn-sm" title="WAIT FOR RE-GENERATE APPROVAL" ><img width="32px" src="' . base_url('public/icon/RE_GENERATE_APPROVAL.png') . '" alt="GEOCHEM"></a>';
                        }
                    } elseif ($value->re_generate == 3) {
                        if ($this->permission_action('Reports/re_genrate_process')) {
                            $html .= '<a data-id="' . base64_encode($value->registration_id) . '" class="btn btn-sm re_genrate_process" title="RE-GENERATE PROCESS" ><img width="32px" src="' . base_url('public/icon/re-generate-process.png') . '" alt="GEOCHEM"></a>';
                        }
                    } else {
                        if ($this->permission_action('Regenerate/approval')) {
                            $html .= '<a data-id="' . base64_encode($value->registration_id) . '" data-toggle="modal" data-target="#request_regenrate" class="btn btn-sm re_generate_request" title="RE-GENERATE REQUEST" ><img width="32px" src="' . base_url('public/icon/approval_regenrate.png') . '" alt="GEOCHEM"></a>';
                        }
                    }
                    if ($this->permission_action('Reports/download_all_pdf')) {
                        $html .= '<a title="DOWNLOAD ALL FILES" href="' . base_url('Reports/download_all_pdf?registration_id=' . base64_encode($value->registration_id)) . '"><img src="' . base_url('public/icon/zip_download.png') . '" alt="GEOCHEM"></a>';
                    }
                    // if ($this->permission_action('Reports/get_release_document')) {
                    //     $html .= '<a data-id="' . base64_encode($value->registration_id) . '" data-toggle="modal" data-target="#release_document_view" class="btn btn-sm release_document_list" title="VIEW RELEASE DOCUMENT" ><img width="32px" src="' . base_url('public/icon/view_release_document.png') . '" alt="GEOCHEM"></a>';
                    // }
                    if (empty($value->gmark_qrcode)) {
                        $html .= '<a data-toggle="modal" data-target="#qr_code_update" data-id="' . base64_encode($value->registration_id) . '" class="btn btn-sm qrcode_update" title="UPDATE GMARK CODE" href="javasript:void(0);"><img width="32px" src="' . base_url('public/icon/gmarkQRCODE.png') . '" alt="GEOCHEM"></a>';
                    } else {
                        if ($this->permission_action('Reports/send_email')) {
                            $html .= '<a data-id="' . base64_encode($value->registration_id) . '" data-toggle="modal" data-target="#release_document" class="btn btn-sm release_document_upload" title="REPORT SEND ON MAIL" ><img width="32px" src="' . base_url('public/icon/send_mail.png') . '" alt="GEOCHEM"></a>';
                        }
                    }
                }
                if ($this->permission_action('Reports/log')) {
                    $html .= '<a class="btn btn-sm log" data-id="' . base64_encode($value->registration_id) . '" data-toggle="modal" data-target="#log" title="LOG DETAILS" href="javascript:void(0);"><img width="28px" src="' . base_url('public/icon/log.png') . '" alt="GEOCHEM"></a>';
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
    public function image_upload()
    {

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $user_id = $this->session->userdata('user_data')->id;
            $post = $this->input->post();
            $post['registration_id'] = base64_decode($post['registration_id']);
            $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
            if ($seq) {
                $files = $_FILES;
                $config['upload_path']   = './public/uploads/';
                $config['allowed_types'] = '*';
                $config['remove_spaces'] = TRUE;
                $config['max_size']      = 6000;
                $this->load->library('upload', $config);
                $this->load->library('image_lib');
                $insert = array('registration_id' => $post['registration_id'], 'created_by' => $user_id);
                foreach ($files as $key => $file) {
                    if (!empty($files[$key]['name'])) {
                        if (!$this->upload->do_upload($key)) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $uploadedImage = $this->upload->data();
                            $this->resizeImage($uploadedImage['file_name']);
                            $path =  $this->samplePhoto($seq->seq_no . '-' . rand(0, 999) . '-' . date('H_i_s'), 'GMARK/' . $seq->seq_no . '/sample_photo', LOCAL_PATH . $uploadedImage['file_name']);
                            if ($path) {
                                unlink(LOCAL_PATH . $uploadedImage['file_name']);
                                $insert[$key] = $path['aws_path'];
                            } else {
                                $insert[$key] = LOCAL_PATH . $uploadedImage['file_name'];
                            }
                        }
                    }
                }
                $msg['msg'] = 'RECORD SUCCESSFULLY INSERT AND IMAGE UPLOAD ';
                $this->Gmark_model->gmark_registration_log($post['registration_id'], $seq->seq_no . ' :- PRODUCT IMAGE INSERT FOR REPORTS ');
                if (count($insert) > 2) {
                    $done = $this->Report_model->insert_data('sample_photo', $insert);
                    if ($done) {
                        $msg['status'] = 1;
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'RECORD NOT INSERT '
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'FILE UPLOAD ERROR',
                        'errors' => $error,
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT FOUND '
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
    public function file_check($file)
    {
        $files = $_FILES;
        foreach ($files as $key => $value) {
            if (empty($value['name']) || count($value['name']) < 1) {
                $this->form_validation->set_message('file_check', 'The ' . (($key == 'front_images') ? 'FRONT IMAGE' : 'REAR IMAGE') . ' FILE REQUIRED PLEASE SELECT');
                return false;
            }
        }
        return true;
    }
    public function get_image()
    {
        $post = $this->input->post();
        $result = $this->Report_model->get_result('*', 'sample_photo', ['status' => 1, 'registration_id' => base64_decode($post['registration_id'])]);
        $html = '';
        if ($result) {
            foreach ($result as $key => $value) {
                $html .= '<tr>';
                $html .= '<td>' . ($key + 1) . '</td>';
                if (!empty($value->front_img)) {
                    $html .= '<td><a href="' . base_url('Reports/download_sample_iamge/' . base64_encode($value->front_img)) . '">VIEW</a></td>';
                } else {
                    $html .= '<td>FRONT IMAGE NOT AVAILABLE</td>';
                }
                if (!empty($value->rear_img)) {
                    $html .= '<td><a href="' . base_url('Reports/download_sample_iamge/' . base64_encode($value->rear_img)) . '">VIEW</a></td>';
                } else {
                    $html .= '<td>REAR IMAGE NOT AVAILABLE</td>';
                }
                if (!empty($value->product_label)) {
                    $html .= '<td><a href="' . base_url('Reports/download_sample_iamge/' . base64_encode($value->product_label)) . '">VIEW</a></td>';
                } else {
                    $html .= '<td>PRODUCT LABEL LEFT NOT AVAILABLE</td>';
                }
                if (!empty($value->product_label2)) {
                    $html .= '<td><a href="' . base_url('Reports/download_sample_iamge/' . base64_encode($value->product_label2)) . '">VIEW</a></td>';
                } else {
                    $html .= '<td>PRODUCT LABEL RIGHT NOT AVAILABLE</td>';
                }
                if ($this->permission_action('Reports/image_upload_view')) {
                    $html .= '<td><a data-id="' . $value->photo_id . '" class="btn btn-sm delete_img_product" href="javascript:void(0);">DELETE</a></td>';
                } else {
                    $html .= '<td></td>';
                }
                $html .= '</tr>';
            }
        } else {
            $html = '<tr><td>NO RECORD FOUND</td></tr>';
        }

        echo json_encode($html);
    }

    public function pdf_view()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        //$this->output->enable_profiler(true);
        $get = $this->input->get();
        $get['registration_id'] = base64_decode($get['registration_id']);
            
        $data['gso_country_code']= $this->Report_model->gso_country_code(['gmark.registration_id' => $get['registration_id']]);
        $data['pdf_data'] = $this->Report_model->pdf_data(['gmark.registration_id' => $get['registration_id']]);
        $data['certified'] = $this->Gmark_model->get_result('*', 'list_certified_item', ['registration_id' => $get['registration_id']]);
        $data['sample_photo'] = $this->Gmark_model->get_result('front_img,rear_img,product_label,product_label2', 'sample_photo', ['registration_id' => $get['registration_id'], 'status' => 1]);
        $data['revision'] = $this->Gmark_model->get_result('created_on', 're_genrate_pdf', ['registration_id' => $get['registration_id'], 'status' => 1]);
        
        if ($data['pdf_data']->coc_type == 2) {
            $this->pdf('COC', $data);
        } elseif ($data['pdf_data']->coc_type == 1) {
            $this->pdf('GEC', $data);
        } else {
            $this->pdf('COC', $data);
        }
    }

    public function pdf($view_file, $data = NULL, $file_path = NULL)
    {
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->charset_in = 'UTF-8';
        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';
//        $this->m_pdf->pdf->debug = true;
        $this->m_pdf->pdf->lang = 'ar';
        if (empty($file_path)) {
            $this->m_pdf->pdf->SetWatermarkText('DRAFT');
            $this->m_pdf->pdf->showWatermarkText = true;
        } else {
            if (empty($data['pdf_data']->qr_code) || $data['pdf_data']->qr_code == '') {
                $this->load->library('Ciqrcode');
                $this->load->helper('file');
                delete_files(QRCODE, TRUE);
                $params['data'] =  base_url('Render/download_pdf?report_id=' . base64_encode($data['pdf_data']->report_id) . '&registration_id=' . base64_encode($data['pdf_data']->registration_id));
                $params['level'] = 'H';
                $params['size'] = 1;
                $params['savename'] = QRCODE . $data['pdf_data']->seq_no . '.png';
                $this->ciqrcode->generate($params); /// genrate image
                $filepath = basename($params['savename']);
                $qrcode = $this->uploadQRcode($filepath); // image uploaD ON AWS
                if ($qrcode) {
                    $final_update = array(
                        'qr_code' => $qrcode['aws_path']
                    );
                    $update = $this->Gmark_model->update_row('report_content', $final_update, ['report_id' => $data['pdf_data']->report_id]);
                    if ($update) {
                        $data['pdf_data']->qr_code = $final_update['qr_code'];
                    } else {
                        $data['pdf_data']->qr_code = $final_update['qr_code'];
                    }
                } else {
                    $data['pdf_data']->qr_code =  $params['savename'];
                }
            }
        }
      $html = $this->load->view($view_file, $data, true);
      //exit;
        $this->m_pdf->pdf->WriteHTML($html);
        if (isset($data['sample_photo']) && count($data['sample_photo']) > 0) {
            $sample_pic = array_chunk($data['sample_photo'],2);
            foreach ($sample_pic as $key => $value) {
                $this->m_pdf->pdf->AddPage();
                $table = $this->load->view('Table', ['sample_photo'=>$value], true);       
                $this->m_pdf->pdf->WriteHTML($table);
            }
        }
        if ($file_path) {
            # FOR SAVE IN LOCAL
            $this->m_pdf->pdf->Output($file_path, 'F');
        } else {
            # FOR VIEW
            $this->m_pdf->pdf->Output('DOCUMENT.pdf', 'I');
        }
    }
    public function content_upload()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('coc_type', 'REPORT TYPE', 'trim|required|in_list[1,2]');
        $this->form_validation->set_rules('date_of_issuance', 'DATE OF ISSUANCE', 'trim|required');
        $this->form_validation->set_rules('cab_method', 'CAB METHOD USED', 'trim|required');
        $this->form_validation->set_rules('technical_regulation', 'Technical Regulation', 'trim|required');
        $this->form_validation->set_rules('notify_body', 'NOTIFY BODY NO.', 'trim|required');
        // $this->form_validation->set_rules('means_shipping', 'Means OF Shipping', 'trim|required|in_list[AIR,SEA,LAND,OTHER]');
        // $this->form_validation->set_rules('shipment_doc', 'Shipping Documents', 'trim|required');
        $this->form_validation->set_rules('pro_name', 'Product Name/Detail', 'trim|required');
        $this->form_validation->set_rules('trade_brand', 'Trademark/Brand', 'trim|required');
        $this->form_validation->set_rules('country_origin', 'Country of Origin', 'trim|required');
        $this->form_validation->set_rules('designation', 'Model No/Type Designation', 'trim|required');
        // $this->form_validation->set_rules('lot_no', 'Lot No/Identification of Consignment', 'trim|required');
        $this->form_validation->set_rules('standard_applies[]', 'Standard Applies', 'trim|required');
        $this->form_validation->set_rules('country_complains[]', 'List of GSO Countries considered', 'trim|required');
        $this->form_validation->set_rules('file_ref', 'Evaluation Report/File Ref', 'trim|required');
        $this->form_validation->set_rules('certified_pro', 'Remark/Description related to certified product', 'trim');
        $this->form_validation->set_rules('electrical_rating', 'Technical data and Electrical Ratings', 'trim');
        // $this->form_validation->set_rules('pro_dimension', 'Product Dimensions (mm/cm)', 'trim|required');
        $this->form_validation->set_rules('length', 'Age Grading', 'trim|required');
        // $this->form_validation->set_rules('width', 'WIDTH', 'trim|required');
        // $this->form_validation->set_rules('height', 'HEIGHT', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $user_id = $this->session->userdata('user_data')->id;
            $post = $this->input->post();
            $post['standard_applies'] = implode(',', $post['standard_applies']);
            $post['country_complains'] = implode(',', $post['country_complains']);
            $post['created_by'] = $user_id;
            $post['statuts'] = 1;
            $post['registration_id'] = base64_decode($post['registration_id']);
            $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
            if ($seq) {
                $certified = $post['product'];
                unset($post['product']);
                $coc_type = $post['coc_type'];
                unset($post['coc_type']);
                $insert = $this->Report_model->insert_data('report_content', $post);
                if ($insert) {
                    foreach ($certified as $key => $value) {
                        $certified[$key]['created_by'] = $user_id;
                        $certified[$key]['registration_id'] = $post['registration_id'];
                    }
                    $insert_certified = $this->Report_model->insert_multi_data('list_certified_item', $certified);
                    if ($insert_certified) {
                        
                        $insert_certified = $this->Report_model->update_row('gmark_registration', ['coc_type' => $coc_type], ['registration_id' => $post['registration_id']]);
                        $this->Gmark_model->gmark_registration_log($post['registration_id'], $seq->seq_no . ' :- CONTENT UPLOAD');
                        $msg = array(
                            'status' => 1,
                            'msg' => 'RECORD INSERT'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'CERTIFIED RECORD NOT INSERT '
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'REPORT CONTENT RECORD NOT INSERT '
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT FOUND '
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => $this->form_validation->error_array(),
                'msg' => 'PLEASE ENTER VALID TEXT'
            );
        }
        echo json_encode($msg);
    }
    public function edit_content_upload()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('coc_type', 'REPORT TYPE', 'trim|required|in_list[1,2]');
        $this->form_validation->set_rules('date_of_issuance', 'DATE OF ISSUANCE', 'trim|required');
        $this->form_validation->set_rules('cab_method', 'CAB METHOD USED', 'trim|required');
        $this->form_validation->set_rules('technical_regulation', 'Technical Regulation', 'trim|required');
        $this->form_validation->set_rules('notify_body', 'NOTIFY BODY NO.', 'trim|required');
        // $this->form_validation->set_rules('means_shipping', 'Means OF Shipping', 'trim|required|in_list[AIR,SEA,LAND,OTHER]');
        // $this->form_validation->set_rules('shipment_doc', 'Shipping Documents', 'trim|required');
        $this->form_validation->set_rules('pro_name', 'Product Name/Detail', 'trim|required');
        $this->form_validation->set_rules('trade_brand', 'Trademark/Brand', 'trim|required');
        $this->form_validation->set_rules('country_origin', 'Country of Origin', 'trim|required');
        $this->form_validation->set_rules('designation', 'Model No/Type Designation', 'trim|required');
        // $this->form_validation->set_rules('lot_no', 'Lot No/Identification of Consignment', 'trim|required');
        $this->form_validation->set_rules('standard_applies[]', 'Standard Applies', 'trim|required');
        $this->form_validation->set_rules('country_complains[]', 'List of GSO Countries considered', 'trim|required');
        $this->form_validation->set_rules('file_ref', 'Evaluation Report/File Ref', 'trim|required');
        $this->form_validation->set_rules('certified_pro', 'Remark/Description related to certified product', 'trim');
        $this->form_validation->set_rules('electrical_rating', 'Technical data and Electrical Ratings', 'trim');
        // $this->form_validation->set_rules('pro_dimension', 'Product Dimensions (mm/cm)', 'trim|required');
        $this->form_validation->set_rules('length', 'Age Grading', 'trim|required');
        // $this->form_validation->set_rules('width', 'WIDTH', 'trim|required');
        // $this->form_validation->set_rules('height', 'HEIGHT', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $user_id = $this->session->userdata('user_data')->id;
            $post = $this->input->post();
            $post['standard_applies'] = implode(',', $post['standard_applies']);
            $post['country_complains'] = implode(',', $post['country_complains']);
            $post['registration_id'] = base64_decode($post['registration_id']);
            $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
            if ($seq) {
                $report_id = $this->Report_model->get('report_id', 'report_content', ['registration_id' => $post['registration_id']]);
                if (isset($post['product']) && count($post['product'])>0) {
                    $certified = $post['product'];
                    unset($post['product']);
                }
                if (isset($post['coc_type']) && !empty($post['coc_type'])) {
                    $coc_type = $post['coc_type'];
                    unset($post['coc_type']);
                }
                $update = $this->Report_model->update_row('report_content', $post, ['report_id' => $report_id->report_id]);
                if ($update) {
                    $insert_certified = true;
                    if (isset($certified) && count($certified) > 0) {
                        foreach ($certified as $key => $value) {
                            $certified[$key]['created_by'] = $user_id;
                            $certified[$key]['registration_id'] = $post['registration_id'];
                        }
                        $this->Report_model->delete_data('list_certified_item', ['registration_id' => $post['registration_id']]);
                        $insert_certified = $this->Report_model->insert_multi_data('list_certified_item', $certified);
                    }
                    if ($insert_certified) {
                        if (isset($coc_type) && !empty($coc_type)) {
                            $insert_certified = $this->Report_model->update_row('gmark_registration', ['coc_type' => $coc_type], ['registration_id' => $post['registration_id']]);
                        }
                        $this->Gmark_model->gmark_registration_log($post['registration_id'], $seq->seq_no . ' :- EDIT CONTENT UPLOAD');
                        $msg = array(
                            'status' => 1,
                            'msg' => 'RECORD INSERT'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'CERTIFIED RECORD NOT INSERT '
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'REPORT CONTENT RECORD NOT INSERT '
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'RECORD NOT FOUND '
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' =>  $this->form_validation->error_array(),
                'msg' => 'PLEASE ENTER VALID TEXT'
            );
        }
        echo json_encode($msg);
    }
    public function get_content()
    {
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        $data = $this->Gmark_model->get('*', 'report_content', ['registration_id' => $post['id']]);
        if ($data) {
            $data->coc_type = $this->Gmark_model->get('coc_type', 'gmark_registration', ['registration_id' => $post['id']]);
            $data->result = $this->Gmark_model->get_result('*', 'list_certified_item', ['registration_id' => $post['id']]);
        } else {
            $data = false;
        }
        echo json_encode($data);
    }
    public function approved_pdf()
    {
        $user_id = $this->session->userdata('user_data');
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        if (!empty($user_id->signature_path) || $user_id->signature_path != '') {
            $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['id']]);
            if ($seq) {
                $data = array(
                    'approved_by' => $user_id->id,
                    'user_name' => $user_id->first_name . ' ' . $user_id->last_name
                );
                $update = $this->Gmark_model->update_row('report_content', $data, ['registration_id' => $post['id'], 'statuts' => '1']);
                if ($update) {
                    $this->Gmark_model->status_update($post['id'],4);
                    $this->Gmark_model->gmark_registration_log($post['id'], $seq->seq_no . ' :- REPORT APPROVED BY ' . $user_id->first_name . ' ' . $user_id->last_name);
                    $msg = array('status' => 1, 'msg' => 'SUCCESSFULLY APPROVED ' . $seq->seq_no);
                } else {
                    $msg = array('status' => 0, 'msg' => 'ERROR WHILE APPROVED ' . $seq->seq_no);
                }
            } else {
                $msg = array('status' => 0, 'msg' => 'RECORD NOT FOUND');
            }
        } else {
            $msg = array('status' => 0, 'msg' => 'YOU NOT UPLOAD YOUR SIGNATURE');
        }

        echo json_encode($msg);
    }
    public function release_pdf()
    {
        $coc = TRUE;
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['id']]);
        if ($seq) { #coc_number_generate
            $data['pdf_data'] = $this->Report_model->pdf_data(['gmark.registration_id' => $post['id']]);
            $data['gso_country_code']= $this->Report_model->gso_country_code(['gmark.registration_id' => $post['id']]);
            if (empty($data['pdf_data']->coc_no) && $data['pdf_data']->coc_no == '') {
                $coc = $this->coc_number_generate($data['pdf_data']->report_id, $post['id'], $data['pdf_data']->coc_type);
                if ($coc) {
                    $data['pdf_data'] = $this->Report_model->pdf_data(['gmark.registration_id' => $post['id']]);
                }
            } else {
                $coc = $this->re_generate_coc_number_generate($data['pdf_data']->report_id, $post['id'], $data['pdf_data']->coc_type);
                if ($coc) {
                    $data['pdf_data'] = $this->Report_model->pdf_data(['gmark.registration_id' => $post['id']]);
                }
            }
            
            if ($coc) {
                $data['sample_photo'] = $this->Gmark_model->get_result('front_img,rear_img,product_label,product_label2', 'sample_photo', ['registration_id' => $post['id'], 'status' => 1]);
                $data['certified'] = $this->Gmark_model->get_result('*', 'list_certified_item', ['registration_id' => $post['id']]);
                $data['revision'] = $this->Gmark_model->get_result('created_on', 're_genrate_pdf', ['registration_id' => $post['id'], 'status' => 1]);
                $file_path = LOCAL_PATH . sanitizeFileName($seq->seq_no . '-' . rand(0, 999) . '-' . date('d-M-Y') . '-' . rand(0, 9999)) . '.pdf';
                if ($data['pdf_data']->coc_type == '1') {
                    $this->pdf('GEC', $data, $file_path);
                } elseif ($data['pdf_data']->coc_type == '2') {
                    $this->pdf('COC', $data, $file_path);
                }
                $exist = file_exists($file_path);
                if ($exist) {
                    $folder = 'GMARK/' . $data['pdf_data']->coc_no . '/REPORTS/';
                    $aws_path = $this->uploadpdf($file_path, $folder);
                    if ($aws_path) {
                        $update = $this->Gmark_model->update_row('report_content', ['aws_path' => $aws_path['aws_path'], 'release_date' => date('Y-m-d h:i:s A')], ['report_id' => $data['pdf_data']->report_id]);
                        if ($update) {
                            unlink($file_path);
                            $this->Gmark_model->gmark_registration_log($post['id'], $seq->seq_no . ' :- REPORT RELEASE');
                            $gmark_qrcode = $this->Report_model->get('gmark_qrcode', 'report_content', ['report_id' => $data['pdf_data']->report_id]);
                            if ($gmark_qrcode && !empty($gmark_qrcode->gmark_qrcode)) {
                                $this->Gmark_model->status_update($post['id'],7);
                            }else{
                                $this->Gmark_model->status_update($post['id'],5);
                            }
                            $msg = array('status' => 1, 'msg' => 'SUCCESSFULLY RELEASE ' . $seq->seq_no);
                        } else {
                            $msg = array('status' => 0, 'msg' => 'ERROR WHILE UPDATE FILE PATH ' . $seq->seq_no);
                        }
                    } else {
                        $msg = array('status' => 0, 'msg' => 'FILE NOT UPLOAD ON AWS SERVER ' . $seq->seq_no);
                    }
                } else {
                    $msg = array('status' => 0, 'msg' => 'FILE NOT CREATE ON SERVER ' . $seq->seq_no);
                }
            } else {
                $msg = array('status' => 0, 'msg' => 'COC NUMBER NOT GENERATE');
            }
        } else {
            $msg = array('status' => 0, 'msg' => 'RECORD NOT FOUND');
        }
        echo json_encode($msg);
    }
    public function coc_number_generate($report_id, $reg_id, $type)
    {
        if ($reg_id && $report_id) {
            $user_id = $this->session->userdata('user_data');
            $data = array(
                'report_id' => $report_id,
                'reg_id' => $reg_id,
                'created_by' => $user_id->id
            );
            if ($type == '1') {
                $insert = $this->Report_model->insert_data('coc_number_gec', $data);
            } else {
                $insert = $this->Report_model->insert_data('coc_number', $data);
            }
            if ($insert > 0) {
                if ($type == '1') {
                    $coc = 'GC-AE-' . date('Y') . '-' . '055' . '-' . str_pad($insert, 5, 0, STR_PAD_LEFT);
                    $this->Report_model->update_row('coc_number_gec', ['no' => $coc], ['id' => $insert]);
                } else {
                    $coc = 'GC-AE-055-' . str_pad($insert, 5, 0, STR_PAD_LEFT);
                    $this->Report_model->update_row('coc_number', ['no' => $coc], ['id' => $insert]);
                }
                $update = $this->Report_model->update_row('report_content', ['coc_no' => $coc], ['report_id' => $report_id]);
                if ($update) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function re_generate_coc_number_generate($report_id, $reg_id, $type)
    {
        if ($reg_id && $report_id) {
            $report_id;
            $coc = $this->Gmark_model->get('coc_no,no_re_generate,change_coc', 'report_content', ['report_id' => $report_id]);
            if ($coc) {
                /* CHANGE COC NUMBER OR NOT */

                if ($coc->change_coc > 0) {
                    $coc = $coc->coc_no;
                } else {
                    if ($type == '1') {
                        $ab = $this->Gmark_model->get('no as coc_no', 'coc_number_gec', ['report_id' => $report_id, 'reg_id' => $reg_id]);
                        if ($ab) {
                            $coc->coc_no = $ab->coc_no;
                        }
                    } else {
                        $ab = $this->Gmark_model->get('no as coc_no', 'coc_number', ['reg_id' => $report_id, 'reg_id' => $report_id]);
                        if ($ab) {
                            $coc->coc_no = $ab->coc_no;
                        }
                    }
                    $number = str_pad((int)$coc->no_re_generate, 2, "0", STR_PAD_LEFT);
                    if ($number == '00' || $number == 00) {
                        $coc = $coc->coc_no;
                    } else {
                        $coc = $coc->coc_no . '-' . $number;
                    }
                }
                /* END CHANGE COC NUMBER OR NOT */
                $update = $this->Report_model->update_row('report_content', ['coc_no' => $coc, 'change_coc' => 0], ['report_id' => $report_id]);
                if ($update) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function download_pdf()
    {
        $get = $this->input->get();
        $get['report_id'] = base64_decode($get['report_id']);
        $pdf = $this->Gmark_model->get('aws_path,coc_no', 'report_content', ['report_id' => $get['report_id']]);
        if ($pdf && !empty($pdf->aws_path)) {
            $this->load->helper('file'); // Load file helper
            $this->load->helper('download'); // Load Download helper
            $data = read_file($pdf->aws_path); // Use file helper to read the file's
            $name = basename($pdf->aws_path);
            force_download($name, $data);
        } else {
            $this->session->set_flashdata('error', 'NO RECORD FOUND');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function pdf_mark()
    {
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        $type = null;
        $seq = $this->Gmark_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['id']]);
        if ($seq) {
            $update = $this->Gmark_model->update_row('gmark_registration', ['coc_type' => $post['type']], ['registration_id' => $post['id']]);
            if ($update) {
                if ($post['type'] == 1) {
                    $type = 'GULF TYPE EXAMINATION CERTIFICATE';
                } elseif ($post['type'] == 2) {
                    $type = 'CERTIFICATION OF CONFORMITY';
                }
                $this->Gmark_model->gmark_registration_log($post['id'], $seq->seq_no . ' :- MARK ' . $type);
                $msg = array('status' => 1, 'msg' => 'SUCCESSFULLY MARK ' . $seq->seq_no . ' :- MARK ' . $type);
            } else {
                $msg = array('status' => 0, 'msg' => 'REOCRD NOT UPDATE FOR MARK ' . $type);
            }
        } else {
            $msg = array('status' => 0, 'msg' => 'REOCRD NOT FOUND FOR MARK');
        }
        echo json_encode($msg);
    }
    public function re_genrate_process()
    {
        $post = $this->input->post();
        $post['id'] = base64_decode($post['id']);
        $seq = $this->Gmark_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['id']]);
        if ($seq) {
            $old_pdf = $this->Gmark_model->get('aws_path,coc_no,change_coc,no_re_generate,release_date', 'report_content', ['registration_id' => $post['id']]);
            /* CHANGE COC NUMBER OR NOT */
            $update = array(
                'aws_path' => NULL,
                'approved_by' => NULL,
                're_generate' => 0,
                'release_date' => NULL,
                'release_date' => NULL,
                'gmark_qrcode' => NULL,
                'qr_code' => NULL
            );
            if ($old_pdf->change_coc > 0) {
                $update['change_coc'] = 0;
            } else {
                $update['no_re_generate'] = $old_pdf->no_re_generate + 1;
            }
            /* CHANGE COC NUMBER OR NOT */
            $update = $this->Gmark_model->update_row('report_content', $update, ['registration_id' => $post['id']]);
            if ($update) {
                $user_id = $this->session->userdata('user_data');
                $data = array(
                    'old_pdf' => $old_pdf->aws_path,
                    'created_by' => $user_id->id,
                    'registration_id' => $post['id'],
                    'coc_no' => $old_pdf->coc_no,
                    'release_date' => $old_pdf->release_date,
                );
                $insert = $this->Gmark_model->insert_data('re_genrate_pdf', $data);
                if ($insert) {
                    $this->Gmark_model->gmark_registration_log($post['id'], $seq->seq_no . ' :- RE-GENERATE REPORT SUCCESSFULLY');
                    $this->Gmark_model->update_row('gmark_registration',['reg_status'=>3], ['registration_id' => $post['id']]);
                    $msg = array('status' => 1, 'msg' => 'SUCCESSFULLY RE-GENERATE ' . $seq->seq_no);
                } else {
                    $msg = array('status' => 0, 'msg' => 'ERROR WHILE RE-GENERATE ');
                }
            } else {
                $msg = array('status' => 0, 'msg' => 'REOCRD NOT INSERT FOR RE-GENERATE');
            }
        } else {
            $msg = array('status' => 0, 'msg' => 'REOCRD NOT FOUND RE-GENERATE');
        }
        echo json_encode($msg);
    }
    public function download_all_pdf()
    {
        $get = $this->input->get();
        $get['registration_id'] = base64_decode($get['registration_id']);
        $seq = $this->Gmark_model->get('coc_no,aws_path', 'report_content', ['registration_id' => $get['registration_id']]);
        $result = $this->Gmark_model->document_listing(['document_registration.registration_id' => $get['registration_id']]);
        if ($result && ($seq && !empty($seq->aws_path))) {
            $this->load->library('zip');
            $this->zip->add_dir($seq->coc_no);
            $this->zip->add_dir($seq->coc_no . '/DOCUEMNTS');
            $this->zip->add_dir($seq->coc_no . '/RELEASEDOCUMENT');
            $this->zip->add_data($seq->coc_no . '/' . basename($seq->aws_path), file_get_contents($seq->aws_path));
            foreach ($result as $key => $value) {
                $this->zip->add_data($seq->coc_no . '/DOCUEMNTS/' . basename($value->upload_path), file_get_contents($value->upload_path));
            }
            $release = $this->Gmark_model->get_result('*', 'release_document', ['registration_id' => $get['registration_id']]);
            if ($release) {
                foreach ($release as $key => $value) {
                    $this->zip->add_data($seq->coc_no . '/RELEASEDOCUMENT/' . basename($value->upload_path), file_get_contents($value->upload_path));
                }
            }
            $this->Gmark_model->gmark_registration_log($get['registration_id'], $seq->coc_no . ' :- ALL FILES ZIP DOWNLOAD');
            $this->zip->download($seq->coc_no . '.zip');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function release_document_upload()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('document_no', 'DOCUMENT NUMBER', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $file = $_FILES['file'];
            $post['registration_id'] = base64_decode($post['registration_id']);
            $seq = $this->Gmark_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
            if ($seq) {
                $ins = $this->upload_file($file['tmp_name'], $file['type'], $seq->seq_no . '-' . rand(0, 999) . date('H:i:s') . '.' . pathinfo(basename($file['name']), PATHINFO_EXTENSION), 'GMARK/' . $seq->seq_no . '/releaseDocument');
                if ($ins) {
                    $post['upload_path'] = $ins;
                    $post['created_by'] = $this->session->userdata('user_data')->id;
                    $insert = $this->Gmark_model->insert_data('release_document', $post);
                    if ($insert) {
                        $this->Gmark_model->gmark_registration_log($post['registration_id'], $seq->seq_no . ' :- RELEASE DOCUMENT UPLOAD ' . $post['document_no']);
                        $msg = array(
                            'status' => 1,
                            'msg' => 'SUCCESSFULLY UPLOAD'
                        );
                    } else {
                        $msg = array(
                            'status' => 0,
                            'msg' => 'SUBMIT ERROR'
                        );
                    }
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'IMAGE UPLOAD ERROR'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'NO RECORD NOT FOUND'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => $this->form_validation->error_array(),
                'msg' => 'PLEASE ENTER VALID TEXT'
            );
        }
        echo json_encode($msg);
    }
    public function get_release_document()
    {
        $post = $this->input->post();
        echo json_encode($this->Report_model->release_view_document(base64_decode($post['id'])));
    }
    public function standard_applies()
    {
        $post = $this->input->post();

        // echo json_encode($this->Report_model->get_result('id,standard', 'standard_applies', ['year' => date('Y'), 'status >' => 0]));
        echo json_encode($this->Report_model->get_result('id,standard', 'standard_applies', ['status >' => 0]));
    }
    public function gmark_code_update()
    {
        $post = $this->input->post();
        $post['registration_id'] = base64_decode($post['registration_id']);
        $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
        if ($seq) {
            $file = $_FILES['file'];
            $qrcode = $this->upload_file($file['tmp_name'], $file['type'], $seq->seq_no . '-GMARK-' . rand(0, 999) . date('H:i:s') . '.' . (basename($file['name'])), 'GMARK/' . $seq->seq_no . '/GMARKQRCODE');
            if ($qrcode) {
                $this->Gmark_model->status_update($post['registration_id'],5);
                $update = $this->Report_model->update_row('report_content', ['gmark_qrcode' => $qrcode, 'aws_path' => NULL], ['registration_id' => $post['registration_id']]);
                if ($update) {
                    $this->Gmark_model->gmark_registration_log($post['registration_id'], $seq->seq_no . ' :- GMARK QR CODE UPDATE ');
                    $this->Gmark_model->status_update($post['registration_id'],6);
                    $msg = array(
                        'status' => 1, 'msg' => 'SUCCESSFULLY UPDATE PLEASE RELEASE AGAIN'
                    );
                } else {
                    $msg = array(
                        'status' => 0, 'msg' => 'ERROR WHILE RECORD UPDATE'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0, 'msg' => 'IMAGE NOT UPLOAD'
                );
            }
        } else {
            $msg = array(
                'status' => 0, 'msg' => 'NO RECORD FOUND FOR UPDATE'
            );
        }
        echo json_encode($msg);
    }
    public function send_email()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_rules('registration_id', 'UNIQUE ID', 'trim|required');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_emails');
        $this->form_validation->set_rules('subject', 'SUBJECT', 'trim|required');
        $this->form_validation->set_rules('text', 'CONTENT', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $post['registration_id'] = base64_decode($post['registration_id']);
            $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $post['registration_id']]);
            if ($seq) {
                $aws_path = $this->Report_model->get('aws_path', 'report_content', ['registration_id' => $post['registration_id']]);
                if ($aws_path && !empty($aws_path->aws_path)) {
                    send_mail_function($post['email'], CC, $post['text'], $post['subject'], $aws_path->aws_path);
                    $this->Gmark_model->gmark_registration_log($post['registration_id'], $seq->seq_no . ' :- EMAIL SUB:-  ' . $post['subject']);
                    $msg = array(
                        'status' => 1,
                        'msg' => 'SUCCESSFULLY SEND EMAIL WITH ATTACHMENTS'
                    );
                } else {
                    $msg = array(
                        'status' => 0,
                        'msg' => 'NO RECORD FOUND'
                    );
                }
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'NO RECORD FOUND'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'errors' => $this->form_validation->error_array(),
                'msg' => 'PLEASE ENTER VALID TEXT'
            );
        }
        echo json_encode($msg);
    }
    public function download_sample_iamge($path)
    {
        $path = base64_decode($path);
        $this->load->helper('download');
        $pdf_path    =   file_get_contents($path);
        $pdf_name    =   basename($path);
        force_download($pdf_name, $pdf_path);
    }
    public function delete_product_image()
    {
        $post = $this->input->post();
        if ($post['id']) {
            $update = $this->Report_model->update_row('sample_photo', ['status' => '0'], ['photo_id' => $post['id']]);
            if ($update) {
                $msg = array(
                    'status' => 1,
                    'msg' => 'SUCCESSFULLY DELETE'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'SOME THING WRONG WHILE DELETE PRODUCT IMAGES!'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'msg' => 'RECORD NOT FOUND'
            );
        }
        echo json_encode($msg);
    }
    public function insert_record()
    {
        $user_id = $this->session->userdata('user_data');
        $post = $this->input->post();
        $array = array();
        foreach ($post['data'] as $key => $value) {
            $array[$key]=array(
                'description'=>$value['FULL_DESCRIPTION'],
                'dimensions'=>$value['QTY'],
                'manufacturer'=>$value['MANUFACTURER'],
                'test_report_details'=>$value['TEST_REPORT_DETAILS'],
                'standards'=>$value['STANDARDS'],
                'created_by'=>$user_id->id,
                'registration_id'=>$post['id'],
            );
        }
        $insert_certified = $this->Report_model->insert_multi_data('list_certified_item', $array);
        if ($insert_certified) {
            $msg = array('status'=>1);
        } else {
            $msg = array('status'=>0);
        }
        echo json_encode($msg);
    }
    public function list_of_contain($reg_id=0,$per_page=10,$page=0)
    {
        if ($page != 0) {
            $page = ($page - 1) * $per_page;
        }
        $where= array('registration_id'=>$reg_id);
        $total_row = $this->Report_model->list_certified_item(NULL, NULL, $where, '1');
        $data['pagination'] = $this->ajax_pagination('Reports/list_of_contain/'.$reg_id.'/'.$per_page, $total_row, $per_page);
        $result = $this->Report_model->list_certified_item($per_page,$page,$where);
        $html = '';
        if ($result) {
            foreach ($result as $key => $value) {
                $html .= '<tr data-id="'.$value->id.'" data-req="'.$value->registration_id.'">';
                $html .= '<td>';
                $html .= ($page+1);
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<textarea class="form-control form-control-sm key_update" data-field="description" class="form-control">'.$value->description.'</textarea>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<textarea class="form-control form-control-sm key_update" data-field="dimensions" class="form-control">'.$value->dimensions.'</textarea>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<textarea class="form-control form-control-sm key_update" data-field="manufacturer" class="form-control">'.$value->manufacturer.'</textarea>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<textarea class="form-control form-control-sm key_update" data-field="test_report_details" class="form-control">'.$value->test_report_details.'</textarea>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<textarea class="form-control form-control-sm key_update" data-field="standards" class="form-control">'.$value->standards.'</textarea>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<a class="btn btn-sm btn-danger delete_row_list_of_certif">*</a>';
                $html .= '</td>';
                $html .= '</tr>';
                $page+=1;
            }
        }
        $data['result'] = $html;
        echo json_encode($data);
    }
    public function update_list_content($id,$req)
    {
        if ($id && $req ) {
            $delete = $this->Report_model->delete_data('list_certified_item',['id'=>$id,'registration_id'=>$req]);
            if ($delete) {
                $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' => $req]);
                $this->Gmark_model->gmark_registration_log($req, $seq->seq_no . ' :- PRODUCT IMAGE INSERT FOR REPORTS ');
                $msg = array('status'=>1,'msg'=>'SUCCESSFULLY DELETE');
            } else {
                $msg = array('status'=>0,'msg'=>'ERROR WHILE DELETE');
            }
        } else {
            $msg = array('status'=>0,'msg'=>'NO RECORD');

        }
        echo json_encode($msg);
        
    }
    public function update_report_content()
    {
        $post = $this->input->post();
        if ($post['req']) {
            if (!empty($post['id'])) {
                $query = $this->Report_model->update_row('list_certified_item', [$post['field'] => $post['value']], ['id' => $post['id'],'registration_id'=>$post['req']]);
            }else{
                $query = $this->Report_model->insert_data('list_certified_item', [$post['field'] => $post['value'],'registration_id'=>base64_decode($post['req'])]);
                $post['req'] = base64_decode($post['req']);
            }
            if ($query) {
                $seq = $this->Report_model->get('seq_no', 'gmark_registration', ['registration_id' =>$post['req']]);
                $this->Gmark_model->gmark_registration_log(base64_decode($post['req']), $seq->seq_no . ' :- LIST OF CERTIFIED ITEM UPDATE ');
                $msg = array(
                    'status' => 1,
                    'msg' => 'SUCCESSFULLY UPDATE'
                );
            } else {
                $msg = array(
                    'status' => 0,
                    'msg' => 'SOME THING WRONG WHILE UPDATE'
                );
            }
        } else {
            $msg = array(
                'status' => 0,
                'msg' => 'RECORD NOT FOUND'
            );
        }
        echo json_encode($msg);
    }
    public function trun_list($id)
    {
        $msg = array();
        if ($id) {
            $this->Report_model->delete_data('list_certified_item', ['registration_id' =>$id]);
            $msg['status']=1;
        }
        echo json_encode($msg);
    }
    
    
    public function reportToExcel($applicant_id, $manufacture_id, $factory_id, $lab_id, $start_date, $end_date, $destination, $applicantion_name, $search, $page = 0){
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $where = array();
        
        if (!empty($applicant_id) && $applicant_id != 'NULL') {
            $where['gmark.applicant_id'] = $applicant_id;
        }
        if (!empty($manufacture_id) && $manufacture_id != 'NULL') {
            $where['gmark.manufacturer_id'] = $manufacture_id;
        }
        if (!empty($factory_id) && $factory_id != 'NULL') {
            $where['FIND_IN_SET("' . $factory_id . '",gmark.factory_id) <> 0 '] = NULL;
        }
        if (!empty($lab_id) && $lab_id != 'NULL') {
            $where['gmark.lab_id'] = $lab_id;
        }
        if (!empty($start_date) && $start_date != 'NULL') {
            $where['report_content.release_date >= '] = $start_date;
        }
        if (!empty($end_date) && $end_date != 'NULL') {
            $where['report_content.release_date <= '] = $end_date;
        }
        if (!empty($destination) && $destination != 'NULL') {
            $where['FIND_IN_SET("' . $destination . '",gmark.destination) <> 0 '] = NULL;
        }
        if (!empty($applicantion_name) && $applicantion_name != 'NULL') {
            $where['gmark.application_type'] = $applicantion_name;
        }
        if (!empty($search) && $search != 'NULL') {
            $search = strtolower(base64_decode($search));
        } else {
            $search = NULL;
        }  
        $result = $this->Report_model->get_reports_list(NULL, NULL, $search, $where);

        $this->load->library('exportexcel');
        $this->exportexcel->setFilename("REPORT");
        $this->exportexcel->set_headers(['S.No.', 'Job No.', 'Request No.', 'COC No', 'Invoice Number', 'Total Amount', 'Applicant Name', 'Destination Name', 'Lab Name', 'Request Date','Release Date']);
        $this->exportexcel->set_columns(['job_no', 'seq_no', 'coc_no', 'invoice_number', 'total_amount', 'applicant_name', 'destination_name', 'lab_name',  'created_on','release_date']);
        $this->exportexcel->export_excel($result);
    }
    
  
}
