<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function randomPassword()
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function generatePDF($html, $flag)
{
    //    $CI = & get_instance();
    //    $CI->load->library('pdf');
    //    $dompdf = new Dompdf\Dompdf();
    //    // Set Font Style
    //    $dompdf->set_option('defaultFont', 'Courier');
    //    $dompdf->loadHtml($html);
    //    // To Setup the paper size and orientation
    //    $dompdf->setPaper('A4', 'landscape');
    //    // Render the HTML as PDF
    //    $dompdf->render();
    //    // Get the generated PDF file contents
    //    $pdf = $dompdf->output();
    //    if ($flag == '1') {
    //        $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
    //        exit(0);
    //    } else {
    //        return $pdf;
    //    }
}

function send_mail_function($to = NULL, $cc = NULL, $msg = NULL, $sub = NULL, $attachment_path = NULL)
{
    $CI = &get_instance();
    $CI->load->library('email');
    $CI->email->clear(TRUE);
     $logo=base_url('public/img/logo/logo-login.png');
     //exit;
    $message = '<!doctype html><html lang="en-US"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><title>GEOCHEM GMARK</title><meta name="description" content="GEOCHEM GMARK"><style type="text/css">a:hover{ text-decoration: none !important;} :focus{ outline: none; border: 0;} </style></head><body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" bgcolor="#eaeeef" leftmargin="0"><table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: `Open Sans`, sans-serif;"><tr><td><table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td style="height:80px;">&nbsp;</td></tr><tr><td style="text-align:center;"><a href="'.base_url().'" title="logo"><img width="210" src="'.base_url('public/img/logo/logo-login.png').'" title="GEOCHEM" alt="GEOCHEM"></a></td></tr><tr><td height="40px;">&nbsp;</td></tr><tr><td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:600px; background:white; border-radius:3px; text-align:left;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);"><tr><td style="padding:40px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td><h1 style="color: #1e1e2d; font-weight: 500; margin: 0; font-size: 32px;font-family:`Rubik`,sans-serif;"></h1></td></tr><tr><td>';
    $message .=  $msg ;
    $message .= '</td></tr></table></td></tr></table></td></tr><tr><td style="height:25px;">&nbsp;</td></tr><tr><td style="text-align:center;"><p style="font-size:14px; color:#455056bd; line-height:18px; margin:0 0 0;">Credit <strong><a href="'.base_url().'"> GMARK GEOCHEM MIDDLE EAST </a></strong></p></td></tr><tr><td style="height:80px;">&nbsp;</td></tr></table></td></tr></table></body></html>';
    // print_r($message);die;
    if (is_array($to) && count($to) > 1)
        $to_user = implode(',', $to); // convert email array to string
    else
        $to_user = $to;

    if (is_array($cc) && count($cc) > 1){
        $cc_user = implode(',', $cc); // convert email array to string
    }
    else{
        $cc_user = $cc;
    }
    $config['protocol'] = PROTOCOL;
    $config['smtp_host'] = HOST;
    $config['smtp_user'] = USER;
    $config['smtp_pass'] = PASS;
    $config['smtp_port'] = PORT;
    $config['newline'] = "\r\n";
    $config['smtp_crypto'] = CRYPTO;
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $CI->email->initialize($config);
    $CI->email->from(FROM, 'GEOCHEM');
    $CI->email->to($to_user);
    if ($cc_user) {
        $CI->email->cc($cc_user);
    }
    $CI->email->cc(CC);
    $CI->email->subject($sub);
    $CI->email->message($message);
    if ($attachment_path) {
        if (is_array($attachment_path)) {
            for ($i = 0; $i < count($attachment_path); $i++) {
                $CI->email->attach($attachment_path[$i]);
            }
        } else {
            $CI->email->attach($attachment_path);
        }
    }
    $bool = $CI->email->send();
    if ($bool) {
        return true;
    } else {
        return false;
    }
}


function generate_invoice_pdf_dom($netTotal, $data_for_pdf, $pdf_page)
{
    // print_r($data_for_pdf); die;
    $pdf_data['result'] = $data_for_pdf['result'];
    //         $pdf_data['fob_value'] =  $data_for_pdf['fob_value']['fob_value']; remove it changes by sangeeta 11 april
    $pdf_data['net_value'] = $netTotal;
    $pdf_data['invoice_gen_date'] = date('d-M-Y');
    // instantiate and use the dompdf class
    $CI = &get_instance();
    $CI->load->library('pdf');
    $CI->load->view($pdf_page, $pdf_data);
    $html = $CI->output->get_output();
    $CI->dompdf->set_option('enable_html5_parser', true);
    $CI->dompdf->loadHtml($html);
    $CI->dompdf->setPaper('A4', 'portrait');
    $CI->dompdf->render();
    // $CI->dompdf->stream('booking', array("Attachment" => 0));
    // die;exit;
    //         $filename = 'invoice' . '-' . date('d-M').'-' .rand(1000, 9999).'.pdf';
    //        $filePath = LOCAL_PATH.$filename;
    //        file_put_contents($filePath, $CI->dompdf->output());
    //        chmod($filePath, 0777);
    return $CI->dompdf->output();
    //        exit;
    //        file_put_contents($filePath, $CI->dompdf->output());
}
function sanitizeFileName($filename)
{

    //  	$dangerous_characters = array(" ", '"', "'", "&", "/", "\\", "?", "#");
    $dangerous_characters =  array("?", ' ', "[", "]", "/", "\\", "=", "<", ">", ":", ";", ", ", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", "%", "+", chr(0));
    return str_replace($dangerous_characters, '_', $filename);
}

/*----------------deepa --------28/02/2020-----------barcode ----------------*/

function barcode($filepath = "", $text = "0", $size = "20", $orientation = "horizontal", $code_type = "code128", $print = false, $SizeFactor = 1)
{
    $code_string = "";
    // Translate the $text into barcode the correct $code_type
    if (in_array(strtolower($code_type), array("code128", "code128b"))) {
        $chksum = 104;
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ($X = 1; $X <= strlen($text); $X++) {
            $activeKey = substr($text, ($X - 1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum = ($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
        $code_string = "211214" . $code_string . "2331112";
    }

    // Pad the edges of the barcode
    $code_length = 20;
    if ($print) {
        $text_height = 30;
    } else {
        $text_height = 0;
    }

    for ($i = 1; $i <= strlen($code_string); $i++) {
        $code_length = $code_length + (int) (substr($code_string, ($i - 1), 1));
    }

    if (strtolower($orientation) == "horizontal") {
        $img_width = $code_length * $SizeFactor;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length * $SizeFactor;
    }

    $image = imagecreate($img_width, $img_height + $text_height);

    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);

    imagefill($image, 0, 0, $white);
    if ($print) {
        imagestring($image, 5, 31, $img_height, $text, $black);
    }

    $location = 10;
    for ($position = 1; $position <= strlen($code_string); $position++) {
        $cur_size = $location + (substr($code_string, ($position - 1), 1));
        if (strtolower($orientation) == "horizontal")
            imagefilledrectangle($image, $location * $SizeFactor, 0, $cur_size * $SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black));
        else
            imagefilledrectangle($image, 0, $location * $SizeFactor, $img_width, $cur_size * $SizeFactor, ($position % 2 == 0 ? $white : $black));
        $location = $cur_size;
        // echo $location;die;

    }

    //imagepng($image);
    $filepath = BARCODE;
    //str_replace('/', '-', $text);
    //echo $text; exit;
    $savePath = $filepath . $text . ".png";
    @chmod($savePath, 0755);
    $bool = imagepng($image, $savePath);

    // echo $bool;die;

    ob_start();
    imagepng($image);
    $image_data = ob_get_contents();
    ob_end_clean();

    return $image_data;
}
function array_flatten($array)
{
    if (!is_array($array)) {
        return FALSE;
    }
    $result = array();
    $sn = 0;
    foreach ($array as $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[$sn] = $value;
        }
        $sn++;
    }
    return $result;
}

function exist_val($val, $permission)
{
    if (is_array($permission)) {
        if (!in_array($val, $permission)) {
            return FALSE;
        } else {
            return TRUE;
        }
    } else {
        if ($val != $permission) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

