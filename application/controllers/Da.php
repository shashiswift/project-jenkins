<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Da extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model', 'DM');
        if (!exist_val('Da/index', $this->session->userdata('permission'))) {
            redirect($_SERVER['HTTP_REFER']);
        }
    }
    public function index()
    {
        $this->showDisplay('Dashboard/index');
    }
    public function countDashboard()
    {
        $data = array();
        $data['requestCount'] = $this->DM->get('COUNT(registration_id) as no', 'gmark_registration');
        $data['requestDraftCount'] = $this->DM->get('COUNT(registration_id) as no', 'gmark_registration',['reg_status <'=>1]);
        $data['invoiceCount'] = $this->DM->get('COUNT(invoice_id) as no', 'invoice_details');
        $data['userCount'] = $this->DM->get('COUNT(id) as no', 'users');
        $data['reportCount'] = $this->DM->get('COUNT(report_id) as no', 'report_content', ['release_date !=' => '']);
        /* */
        $data['customerCount'] = $this->DM->get('COUNT(*) as no', 'gmark_customers'); 
        $data['activeUserCount'] = $this->DM->get('COUNT(*) as no', 'users', ['status' => 1]); 
        $data['cancelledRequestCount'] = $this->DM->get('COUNT(*) as no', 'gmark_registration', ['cancelled_request' => 1]); 
        $data['pendignReqCount'] = $this->DM->get('COUNT(*) as no', 'gmark_registration', ['reg_status <' => 2]); 
        echo json_encode($data);
    }
    public function saleCount()
    {
        $data = array();
        $data['invoiceYearCount'] = $this->DM->get('CONCAT("$",IF(SUM(total_amount),ROUND(SUM(total_amount),2),0)) as no', 'invoice_details',['YEAR(created_on)=YEAR(now())'=>NULL,'YEAR(created_on)=YEAR(now())'=>NULL]);
        $data['invoiceMonthCount'] = $this->DM->get('CONCAT("$",IF(SUM(total_amount),ROUND(SUM(total_amount),2),0)) as no', 'invoice_details',['MONTH(created_on)=MONTH(now())'=>NULL,'YEAR(created_on)=YEAR(now())'=>NULL]);
        $data['invoiceDayCount'] = $this->DM->get('CONCAT("$",IF(SUM(total_amount),ROUND(SUM(total_amount),2),0)) as no', 'invoice_details',['date(created_on) = Date(now())'=>NULL,'YEAR(created_on)=YEAR(now())'=>NULL]);
        echo json_encode($data);
    }
    public function latestActivity($page = 0)
    {
        $colorClass = ['badge-danger','badge-primary','badge-warning','badge-success','badge-light'];
        $per_page = 4;
        $page =  (($page != 0) ? ($page - 1) * $per_page : 0);
        $data = array();

        $data['activityPagination']['no'] = $this->ajax_pagination('Da/latestActivity', $this->DM->activityLog(NULL, NULL, 1), $per_page);
        $result = $this->DM->activityLog($page, $per_page);

        $html = ' <ul class="list-unstyled list-unstyled-border">';
        foreach ($result as $key => &$value) {
            $k = array_rand($colorClass);
            $html .= '<li class="media"><img class="mr-3 rounded-circle" width="50" src="' . base_url('assets/img/avatar/avatar-' . rand(1, 4) . '.png') . '" alt="Gmark avatar"><div class="media-body"><div class="float-right btn '.$colorClass[$k].' ">' . $value->diff . '</div><div class="media-title">' . $value->name . '</div><span class="text-small text-muted">' . $value->desc . '</span></div></li>';
        }
        $html .= '</ul>';

        $data['acitivityLog']['no']=$html;
        echo json_encode($data);
    }
    public function graphInvoice($where = 'week')
    {
        if ($where == 'week') {
            $result = $this->DM->getResultGroup('ROUND(SUM(total_amount),2) as no,DATE_FORMAT(created_on,"%e %M %Y") as date','invoice_details',['date(created_on) >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY'=>NULL,'date(created_on) < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY'=>NULL],'date(created_on)');
        }elseif($where == 'month'){
            $result = $this->DM->getResultGroup('ROUND(SUM(total_amount),2) as no,DATE_FORMAT(created_on,"%e %M %Y") as date','invoice_details',['month(created_on)=month(now())'=>NULL,'YEAR(created_no)=YEAR(now())'],'date(created_on)');
        }else{
            $result = $this->DM->getResultGroup('ROUND(SUM(total_amount),2) as no,MONTHNAME(created_on) as date','invoice_details',['YEAR(created_on)=Year(now())'=>NULL],'MONTH(created_on)');
        }
        echo json_encode($result);
    }

    public function latestStandard($page = 0)
    {
        $per_page = 4;
        $page =  (($page != 0) ? ($page - 1) * $per_page : 0);
        $data = array();

        $data['standardPagination']['no'] = $this->ajax_pagination('Da/latestStandard', $this->DM->standardLatest(NULL, NULL, 1), $per_page);
        $result = $this->DM->standardLatest($page, $per_page);

        $html = '';
        if ($result) {
            foreach ($result as $key => &$value) {
                $html .= '<tr>';
                $html .= '<td>  '.$value->standard.' </td>';
                $html .= '<td><a href="javascript:void(0);" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1">'.$value->name.' </a></td>';
                $html .= '<td><a class="btn btn-primary btn-action mr-1" >'.$value->diff.'</a></td>';
                $html .= '</tr>';
            }
        }

        $data['standardlisting']['no']=$html;
        echo json_encode($data);
    }
    public function signatoryList()
    {
        $data = array();
        $result = $this->DM->get_result('CONCAT(first_name," ",last_name) as name', 'users',['signatory >'=>0]);
        $html ='';
        foreach ($result as $key => &$value) {
            $html .= ' <div class="col-6 col-sm-3 col-lg-3 mb-4 mb-md-1"><div class="avatar-item mb-0"><img alt="image" src="'.base_url('assets/img/avatar/avatar-'.rand(1,5).'.png').'" class="img-fluid" data-toggle="tooltip" title="'.$value->name.'"><div class="avatar-badge" title="Signatory" data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></div></div></div>';
        }
        $data['signatoryList']['no']=$html;
        echo json_encode($data);
    }

    public function TaskList($page = 0)
    {
        $colorClass = ['badge-danger','badge-primary','badge-warning','badge-success','badge-light'];
        $per_page = 4;
        $page =  (($page != 0) ? ($page - 1) * $per_page : 0);
        $data = array();

        $data['TaskPagination']['no'] = $this->ajax_pagination('Da/TaskList', $this->DM->TaskList(NULL, NULL, 1), $per_page);
        $result = $this->DM->TaskList($page, $per_page);

        $html = '';
        if ($result) {
            foreach ($result as $key => &$value) {
                $k = array_rand($colorClass);
                $html .= '<li class="media"><img class="mr-3 rounded-circle" width="50" src="'.base_url('assets/img/avatar/avatar-'.rand(1,5).'.png').'" alt="avatar"><div class="media-body"><div class="badge badge-pill '.$colorClass[$k].' mb-1 float-right">'. $value->status .' </div><h6 class="media-title"><a href="javascript:void(0);">'. $value->seq_no .' </a></h6><div class="text-small text-muted">'.$value->name.' <div class="bullet"></div></div></div></li>';
            }
        }

        $data['Tasklisting']['no']=$html;
        echo json_encode($data);
    }

    public function download() {

        $sql="SELECT DISTINCT(gmark.registration_id) as registration_id, `job_number`.`job_no`, `gmark`.`coc_type`, `gmark`.`status`, `gmark`.`reg_status`, `gmark`.`seq_no`, `gmark`.`certificate_no`, `gmark`.`test_report_no`, `gmark`.`created_on`, `gmark_application`.`application_name` as `application_name`, `applicant`.`entity_name` as `applicant_name`, `manufacturer`.`entity_name` as `manufacturer_name`, GROUP_CONCAT( DISTINCT factory.entity_name) as factory_name, `licensee`.`entity_name` as `licensee_name`, `lab`.`lab_name` as `lab_name`, `sub_lab`.`Sub_lab_name` as `sub_lab_name`, GROUP_CONCAT(DISTINCT mst_country.country_name) as destination_name, `report_content`.`coc_no`, `report_content`.`report_id`, `report_content`.`approved_by`, `report_content`.`aws_path`, `report_content`.`re_generate`, `report_content`.`release_date`, `report_content`.`gmark_qrcode`, count(sample_photo.registration_id) as product_image, `invoice_details`.`invoice_number`, `invoice_details`.`total_amount` FROM `job_number` LEFT JOIN `gmark_registration` as `gmark` ON `job_number`.`registration_id`=`gmark`.`registration_id` LEFT JOIN `gmark_laboratory_type` as `lab` ON `lab`.`lab_id`=`gmark`.`lab_id` LEFT JOIN `gmark_sub_laboratory_type` as `sub_lab` ON `sub_lab`.`Sub_lab_id`=`gmark`.`sub_lab_id` LEFT JOIN `gmark_customers` as `applicant` ON `applicant`.`customers_id`=`gmark`.`applicant_id` LEFT JOIN `gmark_customers` as `manufacturer` ON `manufacturer`.`customers_id`=`gmark`.`manufacturer_id` LEFT JOIN `report_content` ON `report_content`.`registration_id`=`gmark`.`registration_id` LEFT JOIN gmark_customers as factory ON FIND_IN_SET(factory.customers_id,gmark.factory_id) <> 0 LEFT JOIN `gmark_customers` as `licensee` ON `licensee`.`customers_id`=`gmark`.`licensee_id` LEFT JOIN mst_country ON FIND_IN_SET(mst_country.country_id,gmark.destination) <> 0 LEFT JOIN `gmark_application` ON `gmark_application`.`application_id`=`gmark`.`application_type` LEFT JOIN `invoice_details` ON `invoice_details`.`registration_id` = `gmark`.`registration_id` LEFT JOIN `sample_photo` ON `sample_photo`.`registration_id`=`gmark`.`registration_id` WHERE `gmark`.`reg_status` >= 3 and `report_content`.`coc_no`!='' GROUP BY `gmark`.`registration_id` ORDER BY `job_number`.`job_id` ";
                

//echo "sdfds xscfsad";
        $res =$this->db->query($sql);
//echo "sdfds";
        // echo $this->db->last_query();
        // exit;
        $result = $res->result_array();

        /* echo "<pre>";
          print_r($finalList);
          exit; */

        $data = '';
        foreach ($result as $row) {
            $line = '';
            foreach ($row as $value) {
                if ((!isset($value) ) || ( $value == "" )) {
                    $value = "\t";
                } else {
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line) . "\n";
        }
        $data = str_replace("\r", "", $data);

        if ($data == "") {
            $data = "\n(0) Records Found!\n";
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=gmarkreport.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$data";
    }
    public function gmarkcustomerlist() {

        $sql="SELECT * from gmark_customers ";
                

//echo "sdfds xscfsad";
        $res =$this->db->query($sql);
//echo "sdfds";
        // echo $this->db->last_query();
        // exit;
        $result = $res->result_array();

        /* echo "<pre>";
          print_r($finalList);
          exit; */

        $data = '';
        foreach ($result as $row) {
            $line = '';
            foreach ($row as $value) {
                if ((!isset($value) ) || ( $value == "" )) {
                    $value = "\t";
                } else {
                    $value = str_replace('"', '""', $value);
                    $value = '"' . $value . '"' . "\t";
                }
                $line .= $value;
            }
            $data .= trim($line) . "\n";
        }
        $data = str_replace("\r", "", $data);

        if ($data == "") {
            $data = "\n(0) Records Found!\n";
        }

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=gmarkreport.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$data";
    }

}
