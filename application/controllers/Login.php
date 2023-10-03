<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $checkUser = $this->session->userdata('user_data');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('captcha', 'captcha', 'trim|required|callback_captcha_word');
        if ($this->form_validation->run() == FALSE) {
            /* LAKSHAY CAPTCHA */
            $data['image'] = $this->captcha();
            /* END LAKSHAY CAPTCHA */
            $this->load->view('login', $data);
        } else {
            $post = $this->input->post();
            if ($post['captcha']) {
                unset($post['captcha']);
            }
            $clean = $this->security->xss_clean($post);
            $userInfo = $this->user_model->checkLogin(['LOWER(email)'=>strtolower($clean['email']),'password'=>$clean['password']]);
            if (!$userInfo) {
                $this->session->set_flashdata('flash_message', 'The login was unsucessful');
                redirect('login');
            } else {
                $this->session->set_flashdata('success', 'Login Sucessfully');
                $this->session->set_flashdata('login', 'Login Sucessfully'); //for open modal
                $this->session->set_userdata('user_data', $userInfo);
                $this->session->unset_userdata('captcha');
                if ($this->permission_redirect('Gmark/index')) {
                    redirect('Gmark');
                } elseif($this->permission_redirect('Invoice/index')) {
                    redirect('Invoice');
                } elseif($this->permission_redirect('Reports/index')) {
                    redirect('Reports');
                } elseif($this->permission_redirect('Regenerate/index')) {
                    redirect('Regenerate');
                } elseif($this->permission_redirect('ExaminationMethod/index')) {
                    redirect('ExaminationMethod');
                } elseif($this->permission_redirect('Lab/index')) {
                    redirect('Lab');
                } elseif($this->permission_redirect('Legal_Entity/index')) {
                    redirect('Legal_Entity');
                } elseif($this->permission_redirect('User/index')) {
                    redirect('User');
                } elseif($this->permission_redirect('Customer/index')) {
                    redirect('Customer');
                }else{
                    redirect('Role');
                }
                
            }
        }
    }

    public function captcha_word($word)
    {
        $word_session = $this->session->userdata('captcha');
        if ($word_session === $word) {
            return TRUE;
        } else {
            $this->form_validation->set_message('captcha_word', 'The {field} field can not be Match');
            return FALSE;
        }
    }

    public function captcha()
    {
        $this->load->helper('captcha');
        $filePath = base_url() . 'public/uploads/captcha/';
        $files = glob(LOCAL_PATH . 'captcha/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
        $vals = array(
            'img_path'      => 'public/uploads/captcha/',
            'img_url'       => $filePath,
            'img_width'     => '120',
            'img_height'    => 35,
            'expiration'    => 7200,
            'word_length'   => 4,
            'font_size'     => 42,
            'pool'          => '123456789ABCDEF',
            'colors'        => array(
                'background' => array(255, 255, 255), 'border' => array(155, 155, 155), 'text' => array(0, 0, 0),
                'grid' => array(255, 200, 40)
            )
        );

        $cap = create_captcha($vals);
        $this->session->set_userdata('captcha', $cap['word']);

        if ($this->input->get()) {
            echo $cap['image'];   # code...
        } else {
            return $cap['image'];
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('user_data');
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Logout Successfully');
        redirect('Login');
    }
    public function permission_redirect($controller_with_function)
    {
        return in_array($controller_with_function,$this->session->userdata('permission'));
    }
}
