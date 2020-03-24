<?php

function indonesian_date($timestamp = '', $date_format = 'l, j F Y | H:i')
{
    if (trim($timestamp) == '') {
        $timestamp = time();
    } elseif (!ctype_digit($timestamp)) {
        $timestamp = strtotime($timestamp);
    }

    $date_format = preg_replace("/S/", "", $date_format);
    $pattern     = array(
        '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
        '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
        '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
        '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
        '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
        '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
        '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
        '/November/', '/December/',
    );
    $replace = array(
        'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
        'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember',
    );
    $date = date($date_format, $timestamp);
    $date = preg_replace($pattern, $replace, $date);
    $date = "{$date}";
    return $date;
}

function to_date_format($datetime, $to = 'd F Y')
{
    $format = indonesian_date($datetime, $to);
    return $format;
}

function generate_slug($field, $model, $id = null)
{
    $ci          = &get_instance();
    $get         = $ci->{$model}->first($id);
    $created_at  = $get->created_at;
    $slug        = url_title(strtolower($ci->input->post($field, true)) . '-' . to_date_format($created_at, 'His'));
    $data_update = array(
        'slug' => $slug,
    );
    $ci->{$model}->edit($get->id, $data_update);
}

function error_upload_message($edit_url = null, $error = null)
{
    if (!is_null($edit_url) && !is_null($error)) {
        $ci = &get_instance();
        $ci->session->set_flashdata('message', array('message' => $error, 'class' => 'alert-danger'));
        redirect($edit_url);
    }
    return false;
}

function unlink_file($location = null)
{
    if (!is_null($location)) {
        if (!is_dir($location)) {
            if (is_file($location)) {
                unlink($location);
                return true;
            }
            return false;
        }
        return false;
    }
    return false;
}

function format_currency($number = 0, $without_rp = true)
{
    $currency = ($without_rp == true) ? (number_format($number, 0, ",", ".")) : ('Rp. ' . number_format($number, 0, ",", "."));
    return $currency;
}

function create_folder($path)
{
    if (!is_dir($path)) {
        if (!file_exists($path)) {
            $oldmask = umask(0);
            $create  = mkdir($path, 0777, true);
            umask($oldmask);
        }
    }
    return false;
}

function get_session($sess)
{
    $ci = &get_instance();
    return $ci->session->userdata($sess);
}

function set_session($arr)
{
    $ci = &get_instance();
    return $ci->session->set_userdata($arr);
}

function get_config_item($config = null)
{
    if (!is_null($config)) {
        $ci = &get_instance();
        return $ci->config->item($config);
    }
    return false;
}

function encode_crypt($param)
{
    $ci = &get_instance();
    return str_replace(array('+', '/', '='), array('.', '_', '~'), $ci->encryption->encrypt($param));
}

function decode_crypt($param)
{
    $ci = &get_instance();
    return $ci->encryption->decrypt(str_replace(array('.', '_', '~'), array('+', '/', '='), $param));
}

function replace_dot($number, $dot = '.')
{
    return str_replace($dot, '', $number);
}
