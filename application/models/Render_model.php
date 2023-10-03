<?php

class Render_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function download_pdf($req,$report)
    {
        $this->db->select('coc_no,aws_path');
        $path = $this->db->get_where('report_content',['report_id'=>$report,'registration_id'=>$req]);
        if ($path->num_rows() > 0) {
            return $path->row();
        }
        else{
            return false;
        }
    }
}