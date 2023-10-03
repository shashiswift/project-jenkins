<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $checkUser = $this->session->userdata('user_data');
        if (empty($checkUser->first_name)) {
            redirect('Login');
        }
        //$this->output->enable_profiler(true);
    }
    public function showDisplay($template, $data = NULL)
    {
        $this->load->view('dist/_partials/header');
        $this->load->view($template, $data);
        $this->load->view('dist/_partials/footer');
    }
    public function file_selected_test()
    {
        $this->form_validation->set_message('file_selected_test', 'FILE REQUIRED PLEASE SELECT');
        if (empty($_FILES['images']['name']) || (is_array($_FILES['images']['name']) && count($_FILES['images']['name']) < 1)) {
            return false;
        } else {
            return true;
        }
    }
    public function upload_file($file_temp, $file_type, $file_name, $folder_struture)
    {
        require '../vendor/autoload.php';
        if (!empty($file_temp)) {
            // Set Amazon S3 Credentials
            $image =  sanitizeFileName($file_name);
            $keyName = $folder_struture . '/' . $image;
            $s3 = S3Client::factory(
                array(
                    'credentials' => array(
                        'key' => SECRET_ACCESS_KEY,
                        'secret' => SECRET_ACCESS_CODE
                    ),
                    'version' => 'latest',
                    'region' => 'ap-south-1', //write your region name 
                    'signature' => 'v4',
                )
            );
            try {
                $result = $s3->putObject(
                    array(
                        'Bucket' => BUCKETNAME,
                        'Key' => $keyName,
                        'Body'   => fopen($file_temp, 'r+'),
                        'ContentType' => $file_type,
                        'ACL'          => 'public-read',
                        'SourceFile' => $file_temp,
                        'StorageClass' => 'STANDARD'
                    )
                );
                if ($result['ObjectURL']) {
                    return $result['ObjectURL'];
                }
            } catch (S3Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
                return false;
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
                return false;
            }
            return false;
        }
    }
    public function delete_file_from_aws($folder)
    {
        require '../vendor/autoload.php';
        // Set Amazon S3 Credentials
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => SECRET_ACCESS_KEY,
                    'secret' => SECRET_ACCESS_CODE
                ),
                'version' => 'latest',
                'region' => 'ap-south-1', //write your region name 
                'signature' => 'v4',
            )
        );
        $Delete = $s3->deleteObject(array(
            'Bucket' => BUCKETNAME,
            'Key' => $folder
        ));
        if ($Delete) {
            return true;
        } else {
            return false;
        }
    }

    public function back_up($id)
    {
        if ($id == '8520') {
            set_time_limit(0);
            ini_set("memory_limit", -1);
            $this->load->dbutil();
            $prefs = array(
                'format'      => 'zip',
                'filename'    => 'my_db_backup.sql'
            );
            $backup = &$this->dbutil->backup($prefs);
            $db_name = 'backup-GMARK-' . date("Y-m-d-H-i-s") . '.zip';
            $this->load->helper('file');
            $this->load->helper('download');
            force_download($db_name, $backup);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function back_upfiles($id)
    {
        if ($id == '8520') {
            set_time_limit(0);
            ini_set("memory_limit", -1);
            $this->load->library('zip');
            $this->zip->read_dir(FCPATH, FALSE);
            $this->zip->download('GMARK_DB_backup' . date("Y-m-d-H-i-s") . '.zip');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function uploadpdf($file_name, $folder_sturcture)
    {
        require '../vendor/autoload.php';
        if (!empty($file_name)) {

            $keyName = $folder_sturcture . sanitizeFileName(basename($file_name));
            $path_parts = pathinfo($file_name);

            $file_type = $path_parts['extension'];;
            $s3 = S3Client::factory(
                array(
                    'credentials' => array(
                        'key' => SECRET_ACCESS_KEY,
                        'secret' => SECRET_ACCESS_CODE
                    ),
                    'version' => 'latest',
                    'region' => 'ap-south-1', //write your region name 
                    'signature' => 'v4',
                )
            );
            try {
                $result = $s3->putObject(
                    array(
                        'Bucket' => BUCKETNAME,
                        'Key' => $keyName,
                        'Body' => fopen($file_name, 'r+'),
                        'ContentType' => $file_type,
                        'ACL' => 'public-read',
                        'SourceFile' => $file_name,
                        'StorageClass' => 'STANDARD'
                    )
                );
                if ($result['ObjectURL']) {
                    $data['aws_path'] = $result['ObjectURL'];
                    return $data;
                }
            } catch (S3Exception $e) {
                echo $this->session->set_flashdata('error', $e->getMessage());
                return false;
            } catch (Exception $e) {
                echo $this->session->set_flashdata('error', $e->getMessage());
                return false;
            }
            return false;
        }
    }
    public function upload_data_aws($pdf_body, $folder_struture)
    {
        require '../vendor/autoload.php';
        $image = basename($folder_struture);
        $keyName = $folder_struture;
        // Set Amazon S3 Credentials
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => SECRET_ACCESS_KEY,
                    'secret' => SECRET_ACCESS_CODE
                ),
                'version' => 'latest',
                'region' => 'ap-south-1', //write your region name 
                'signature' => 'v4',
            )
        );
        try {
            // Put on S3
            $result = $s3->putObject(
                array(
                    'Bucket' => BUCKETNAME,
                    'Key' => $keyName,
                    'Body' => $pdf_body,
                    'ContentType' => 'application/pdf',
                    'ACL' => 'public-read'
                )
            );

            if ($result['ObjectURL']) {
                return array('aws_path' => $result['ObjectURL'], 'file_name' => $image);
            } else {
                return false;
            }
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
    public function uploadQRcode($file_name)
    {
        require '../vendor/autoload.php';
        if (!empty($file_name)) { {
                $data = array();
                $keyName = 'GMARK/assets/QRcode/' . basename($file_name);
                // Set Amazon S3 Credentials
                $s3 = S3Client::factory(
                    array(
                        'credentials' => array(
                            'key' => SECRET_ACCESS_KEY,
                            'secret' => SECRET_ACCESS_CODE
                        ),
                        'version' => 'latest',
                        'region' => 'ap-south-1', //write your region name 
                        'signature' => 'v4',
                    )
                );

                try {
                    // Create temp file
                    $tempFilePath = QRCODE . basename($file_name);
                    $type = filetype($tempFilePath);
                    // Put on S3
                    $result = $s3->putObject(
                        array(
                            'Bucket' => BUCKETNAME,
                            'Key' => $keyName,
                            'Body' => fopen($tempFilePath, 'r+'),
                            'ContentType' => $type,
                            'ACL' => 'public-read',
                            'SourceFile' => $tempFilePath,
                            'StorageClass' => 'STANDARD'
                        )
                    );

                    if ($result['ObjectURL']) {
                        unlink($tempFilePath);
                        return array_merge($data, array('aws_path' => $result['ObjectURL']));
                    }
                } catch (S3Exception $e) {
                    echo $this->session->set_flashdata('error', $e->getMessage());
                    return false;
                } catch (Exception $e) {
                    echo $this->session->set_flashdata('error', $e->getMessage());
                    return false;
                }
                return $data;
            }
        } else {
            return false;
        }
    }
    public function ajax_pagination($function_with_controller, $total_row, $per_page)
    {
        $config['base_url'] = base_url($function_with_controller);
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $per_page;
        $config['full_tag_open']    = '<div class="pagination text-center small"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="">';
        $config['last_tag_close']  = '</span></li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
    public function permission($controller_with_function)
    {
        if (!in_array($controller_with_function, $this->session->userdata('permission'))) {
            show_error('YOU HAVE NO PERMISSION TO ACCESS CONTACT ADMIN', '404', 'NO PERMISSION');
        }
    }
    public function permission_action($controller_with_function)
    {
        return exist_val($controller_with_function, $this->session->userdata('permission'));
    }
    public function resizeImage($filename)
    {
        $this->image_lib->clear();
        $source_path = LOCAL_PATH . $filename;
        $target_path = LOCAL_PATH;
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'width' => 300,
            'height' => 200,
        );
        $this->image_lib->initialize($config_manip);
        if (!$this->image_lib->resize()) {
            $this->image_lib->display_errors();
        }

        $this->image_lib->clear();
    }
    public function samplePhoto($file_name, $folder_sturcture,$filepath)
    {
        require '../vendor/autoload.php';
        if (!empty($file_name)) {

            $path_parts = pathinfo($filepath);
            $file_type = $path_parts['extension'];;
            $keyName = $folder_sturcture .$file_name.'.'.$file_type;

            $s3 = S3Client::factory(
                array(
                    'credentials' => array(
                        'key' => SECRET_ACCESS_KEY,
                        'secret' => SECRET_ACCESS_CODE
                    ),
                    'version' => 'latest',
                    'region' => 'ap-south-1', //write your region name 
                    'signature' => 'v4',
                )
            );
            try {
                $result = $s3->putObject(
                    array(
                        'Bucket' => BUCKETNAME,
                        'Key' => $keyName,
                        'Body' => fopen($filepath, 'r+'),
                        'ContentType' => $file_type,
                        'ACL' => 'public-read',
                        'SourceFile' => $filepath,
                        'StorageClass' => 'STANDARD'
                    )
                );
                if ($result['ObjectURL']) {
                    $data['aws_path'] = $result['ObjectURL'];
                    return $data;
                }
            } catch (S3Exception $e) {
                echo $this->session->set_flashdata('error', $e->getMessage());
                return false;
            } catch (Exception $e) {
                echo $this->session->set_flashdata('error', $e->getMessage());
                return false;
            }
            return false;
        }
    }
}
