<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GlobalSearch extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalSearch_model', 'GSM');
    }

    public function index($data)
    {
        $data = $this->GSM->SearchKey(strtolower(base64_decode($data)));
        $html = '<div class="search-header">NO RECORD </div><div class="search-item"><a href="javascript:void(0);"><img class="mr-3 rounded" width="30" src="' . base_url('assets/img/products/product-3-50.png') . '" alt="product">NO RECORD FOUND </a></div>';
        if (count($data) > 0) {
            $html = '';
            foreach ($data as $controller => $header) {
                $html .= '<div class="search-header"> In ' . strtoupper($controller) . ' </div>';
                foreach ($header[0] as $key  => $value) {
                    $html .= '<div class="search-item">
                    <a data-val="' . strtoupper($value->seq_no) . '" data-cont="' . $header[1] . '" href="javascript:void(0);" class="goToSearchPage">
                    <img class="mr-3 rounded" width="30" src="' . base_url('assets/img/products/product-' . rand(1, 5) . '-50.png') . '" alt="product"><small>' . strtoupper($value->seq_no) . '</small></a>';
                    if (isset($value->invoice_number)) {
                        $html .= '<a data-val="' . strtoupper($value->seq_no) . '" data-cont="' . $header[1] . '" href="javascript:void(0);" class="goToSearchPage" ><small>' . strtoupper($value->invoice_number) . '</small></a>';
                    }
                    if (isset($value->coc_no)) {
                        $html .= '<a data-val="' . strtoupper($value->seq_no) . '" data-cont="' . $header[1] . '" href="javascript:void(0);" class="goToSearchPage" ><small>' . strtoupper($value->coc_no) . '</small></a>';
                    }
                    $html .= '</div>';
                }
            }
        }
        echo json_encode(['search-result' => $html]);
    }

    public function setValue()
    {
        $post = $this->input->post();
        $this->session->set_flashdata('searchVal',$post['search']);
        echo json_encode($post['controller']);
    }
}
