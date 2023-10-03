<?php

class Dashboard_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function activityLog($page, $perPage, $count = 0)
    {

        $this->db->from('gmark_log_all_users');
        $this->db->join('users', 'gmark_log_all_users.created_by=users.id', 'left');

        if ($count) return $this->db->count_all_results(); # for count all result

        $this->db->select('gmark_log_all_users.desc,CONCAT(users.first_name," ",users.last_name) as name,IF(HOUR(TIMEDIFF(now(),gmark_log_all_users.created_on)) < 1 , IF(MINUTE(TIMEDIFF(now(),gmark_log_all_users.created_on)) < 1 ,"Now",CONCAT(MINUTE(TIMEDIFF(now(),gmark_log_all_users.created_on)),"m")  ) ,CONCAT(HOUR(TIMEDIFF(now(),gmark_log_all_users.created_on)),"h") ) as diff');
        $this->db->order_by('gmark_log_all_users.id', 'DESC');
        $this->db->limit($perPage, $page);
        $result = $this->db->get();

        return (($result->num_rows() > 0) ?  $result->result()  :  false); # for get result
    }
    public function standardLatest($page, $perPage, $count = 0)
    {

        $this->db->from('standard_applies');
        $this->db->join('users', 'standard_applies.created_by=users.id', 'left');
        $this->db->where(['standard_applies.year=year(now())'=>null]);
        if ($count) return $this->db->count_all_results(); # for count all result
        
        $this->db->select('standard_applies.standard,CONCAT(users.first_name," ",users.last_name) as name, DATE_FORMAT(standard_applies.created_on , "%e %M %Y") as diff');
        $this->db->order_by('standard_applies.id', 'DESC');
        $this->db->limit($perPage, $page);
        $result = $this->db->get();
        return (($result->num_rows() > 0) ?  $result->result()  :  false); # for get result
        
    }
    
    public function TaskList($page, $perPage, $count = 0)
    {
        $this->db->from('gmark_registration');
        $this->db->join('invoice_details', 'gmark_registration.registration_id = invoice_details.registration_id', 'left');
        
        if ($count) return $this->db->count_all_results(); # for count all result
        
        
        $this->db->select('gmark_registration.seq_no,CONCAT(users.first_name," ",users.last_name) as name, IF(request_status.name is null,"Draft Request",request_status.name) AS status',FALSE);
        $this->db->join('report_content', 'report_content.registration_id = gmark_registration.registration_id', 'left');
        $this->db->join('users', 'users.id=gmark_registration.created_by', 'left');
        $this->db->join('request_status', 'request_status.id=gmark_registration.reg_status', 'left');
        $this->db->order_by('gmark_registration.registration_id', 'DESC');
        $this->db->limit($perPage, $page);
        $result = $this->db->get();
        return (($result->num_rows() > 0) ?  $result->result()  :  false); # for get result
    }
}
