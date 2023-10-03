<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Render extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Render_model');
    }
    public function download_pdf()
    {
        $get = $this->input->get();
        $report_id = base64_decode($get['report_id']);
        $registration_id = base64_decode($get['registration_id']);
        $path = $this->Render_model->download_pdf($registration_id, $report_id);
        if ($path && !empty($path->aws_path)) {
            $this->load->helper('file'); // Load file helper
            $this->load->helper('download'); // Load Download helper
            $data = read_file($path->aws_path); // Use file helper to read the file's
            $name = basename($path->aws_path);
            force_download($name, $data);
        } else {
            echo '<h1>NO RECORD FOUND</h1>';
        }
    }
}
