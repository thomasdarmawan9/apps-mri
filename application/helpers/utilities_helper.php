<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('secure')) {
  function secure($input){

    $input = trim($input);
    $input = htmlentities($input);
    return $input;
  }
}

if (!function_exists('alphaID')) {
    /**
     * Detail https://kvz.io/blog/2009/06/10/create-short-ids-with-php-like-youtube-or-tinyurl/
     * Translates a number to a short alhanumeric version
     *
     * Translated any number up to 9007199254740992
     * to a shorter version in letters e.g.:
     * 9007199254740989 --> PpQXn7COf
     *
     * specifiying the second argument true, it will
     * translate back e.g.:
     * PpQXn7COf --> 9007199254740989
     *
     * this function is based on any2dec && dec2any by
     * fragmer[at]mail[dot]ru
     * see: http://nl3.php.net/manual/en/function.base-convert.php#52450
     *
     * If you want the alphaID to be at least 3 letter long, use the
     * $pad_up = 3 argument
     *
     * In most cases this is better than totally random ID generators
     * because this can easily avoid duplicate ID's.
     * For example if you correlate the alpha ID to an auto incrementing ID
     * in your database, you're done.
     *
     * The reverse is done because it makes it slightly more cryptic,
     * but it also makes it easier to spread lots of IDs in different
     * directories on your filesystem. Example:
     * $part1 = substr($alpha_id,0,1);
     * $part2 = substr($alpha_id,1,1);
     * $part3 = substr($alpha_id,2,strlen($alpha_id));
     * $destindir = "/".$part1."/".$part2."/".$part3;
     * // by reversing, directories are more evenly spread out. The
     * // first 26 directories already occupy 26 main levels
     *
     * more info on limitation:
     * - http://blade.nagaokaut.ac.jp/cgi-bin/scat.rb/ruby/ruby-talk/165372
     *
     * if you really need this for bigger numbers you probably have to look
     * at things like: http://theserverpages.com/php/manual/en/ref.bc.php
     * or: http://theserverpages.com/php/manual/en/ref.gmp.php
     * but I haven't really dugg into this. If you have more info on those
     * matters feel free to leave a comment.
     *
     * The following code block can be utilized by PEAR's Testing_DocTest
     * <code>
     * // Input //
     * $number_in = 2188847690240;
     * $alpha_in  = "SpQXn7Cb";
     *
     * // Execute //
     * $alpha_out  = alphaID($number_in, false, 8);
     * $number_out = alphaID($alpha_in, true, 8);
     *
     * if ($number_in != $number_out) {
     *   echo "Conversion failure, ".$alpha_in." returns ".$number_out." instead of the ";
     *   echo "desired: ".$number_in."\n";
     * }
     * if ($alpha_in != $alpha_out) {
     *   echo "Conversion failure, ".$number_in." returns ".$alpha_out." instead of the ";
     *   echo "desired: ".$alpha_in."\n";
     * }
     *
     * // Show //
     * echo $number_out." => ".$alpha_out."\n";
     * echo $alpha_in." => ".$number_out."\n";
     * echo alphaID(238328, false)." => ".alphaID(alphaID(238328, false), true)."\n";
     *
     * // expects:
     * // 2188847690240 => SpQXn7Cb
     * // SpQXn7Cb => 2188847690240
     * // aaab => 238328
     *
     * </code>
     *
     * @author  Kevin van Zonneveld <kevin@vanzonneveld.net>
     * @author  Simon Franz
     * @author  Deadfish
     * @author  SK83RJOSH
     * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
     * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
     * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
     * @link    http://kevin.vanzonneveld.net/
     *
     * @param mixed   $in   String or long input to translate
     * @param boolean $to_num  Reverses translation when true
     * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
     * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
     *
     * @return mixed string or long
     * 
     * in untuk memasukan karakter yang akan di encrypt
     * Pad_up adalah minimal character
     * To_num jika true artinya decode, kalau false artinya encode
     * pass_key kunci yang akan digunakan dari encode dan decode
     */
     
    function alphaID($in, $to_num = false, $pad_up = 7, $pass_key = 'mrg37')
    {
      $out   =   '';
      $index = 'bcdfghjklmnpqrstvwxyz0123456789BCDFGHJKLMNPQRSTVWXYZ';
      $base  = strlen($index);
    
      if ($pass_key !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID
    
        for ($n = 0; $n < strlen($index); $n++) {
          $i[] = substr($index, $n, 1);
        }
    
        $pass_hash = hash('sha256',$pass_key);
        $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);
    
        for ($n = 0; $n < strlen($index); $n++) {
          $p[] =  substr($pass_hash, $n, 1);
        }
    
        array_multisort($p, SORT_DESC, $i);
        $index = implode($i);
      }
    
      if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $len = strlen($in) - 1;
    
        for ($t = $len; $t >= 0; $t--) {
          $bcp = bcpow($base, $len - $t);
          $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
        }
    
        if (is_numeric($pad_up)) {
          $pad_up--;
    
          if ($pad_up > 0) {
            $out -= pow($base, $pad_up);
          }
        }
      } else {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
          $pad_up--;
    
          if ($pad_up > 0) {
            $in += pow($base, $pad_up);
          }
        }
    
        for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
          $bcp = bcpow($base, $t);
          $a   = floor($in / $bcp) % $base;
          $out = $out . substr($index, $a, 1);
          $in  = $in - ($a * $bcp);
        }
      }
    
      return $out;
    }
}

if (!function_exists('multisecure')) {
  function multisecure($array){
    foreach ($array as $key => $value) {
      $array[$key] = secure($value);
    }
    return $array;
  }
}

if (!function_exists('dd')) {
  function dd($var){
    if (is_object($var) || is_array($var)) {
      echo '<pre>';
      print_r($var);
      echo '</pre>';
    } else {
      echo $var;
    }
    exit();
  }
}

if (!function_exists('list_bulan')){
  function list_bulan(){
    $bulan = array(
              1 => "January",
              2 => "February",
              3 => "March",
              4 => "April",
              5 => "May",
              6 => "June",
              7 => "July",
              8 => "August",
              9 => "September",
              10 => "October",
              11 => "November",
              12 => "Desember",
            );
    return $bulan;
  }
}

if (!function_exists('flashdata')) {
  function flashdata($type, $message){
    $CI = &get_instance();
    $CI->session->set_flashdata($type, $message);
  }
}


if (!function_exists('api_url')){
  function api_url($url = ''){
    $client_url = 'http://localhost/appsmri/' . $url;
    return $client_url;
  }
}


if (!function_exists('optimus_curl')) {
  function optimus_curl($method, $url, $postdata)
  {
    $ch = curl_init();

        $postData = json_encode($postdata);

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3600,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);

        if($err){
          $response = $err;
        }

        $response = json_decode($result);
      
        return $response;

      
  }
}

if (!function_exists('init_view')) {
  function init_view($view, $data = array()){
    $CI = &get_instance();
    $CI->load->view('header_war.php');
    $CI->load->view('head_war.php');
	
	//Total Count Apply For Spv Or Manager
	if($CI->session->userdata('is_mgr') == true){
	    
        //Membuat array pada divisi yang dihandle dari database
        $divisi = unserialize($CI->session->userdata('is_mgr_division'));
	    
	    $where = '((nilai > 2 AND lembur_app_spv.status is null AND lembur_app_spv.id_divisi IN ('.implode(',',$divisi).') ) OR (nilai > 0 AND lembur_app_spv.id_user = '.$CI->session->userdata('id').' AND lembur_app_spv.status is null) )';
   	    $CI->db->where($where);
	    
	    $data['acc'] = $CI->db->get('lembur_app_spv')->num_rows();
	    
	}else if($CI->session->userdata('is_spv') == true){
		$CI->db->from('lembur_app_spv');
		$CI->db->join('divisi','divisi.id = lembur_app_spv.id_divisi','left');
		
		if($CI->session->userdata('divisi') == 'Manager'){
			$CI->db->where('nilai >', 2);
		}else{
			$CI->db->where('id_user_spv',$CI->session->userdata('id'));
			$CI->db->where('nilai <=', 2);
		}
		
		$CI->db->where('status is null', null, false);
		$query = $CI->db->get();
		$data['acc'] = $query->num_rows();
	}else{
		$data['acc'] = '';
	}
	
	
	//Total Count Task Permit
	$CI->db->where('id_pengganti',$CI->session->userdata('id'));
	$CI->db->where('persetujuan_pengganti IS NULL',NULL,false);
	$query1 = $CI->db->get('task_user');
	$data['task_permite'] = $query1->num_rows();
	
	//Total Count Task Submission
	$CI->db->where('id_user',$CI->session->userdata('id'));
	$CI->db->where('id_pengganti <>',NULL);
	
	$CI->db->where('date >=', date('Y-m-d', strtotime("-1 days")));
	$CI->db->where('date <', date('Y-m-d', strtotime("+360 days")));
	
	$CI->db->from('task');
	$CI->db->join('task_user', 'task.id = task_user.id_task', 'left');
	
	$query2 = $CI->db->get();
	$data['task_submission'] = $query2->num_rows();
	
	//Total Count Report Incentive
	$CI->db->select('*, task_user.id as tui');
	$CI->db->from('task');
	$CI->db->join('task_user', 'task.id = task_user.id_task', 'left');
	
	$date_start = date('Y-m-d', strtotime("-7 days"));
	$date_end = date('Y-m-d', strtotime("+360 days"));
	
	$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (tugas="pd") AND ((id_user='.$CI->session->userdata('id').' AND (persetujuan_pengganti = "tidak" OR persetujuan_pengganti IS null)) OR (id_pengganti='.$CI->session->userdata('id').' AND persetujuan_pengganti = "ya"))' ;
	$CI->db->where($where);
	$CI->db->order_by('date','asc');

	$query3 = $CI->db->get();
	$data['report_incentive'] = $query3->num_rows();
	
	
	$where ="is_approve is NULL AND is_reject is NULL AND status = 'out' ";
	$CI->db->where($where);
	$data['request_product'] = $CI->db->get('log_product')->num_rows();
	
	
    $date_start = date('Y-m-d', strtotime("-7 days"));
	$date_end = date('Y-m-d', strtotime("+1 days"));
	$where = '((action_logistic is NULL) OR (action_logistic BETWEEN "'.$date_start.'" AND  "'.$date_end.'")) AND (id_user = '.$CI->session->userdata('id').')';
    $CI->db->where($where);

    $data['my_request_product'] = $CI->db->get('log_product')->num_rows();
	
    $CI->load->view('sidebar_war.php',$data);
	
    $CI->load->view($view, $data);
    $CI->load->view('footer_war.php');
  }
}

if (!function_exists('display_404')) {
  function display_404(){
    $CI = &get_instance();
    $CI->load->view('404');
  }
}

if (!function_exists('set_active_menu')) {
  function set_active_menu($menu){
    $CI = &get_instance();
    $CI->session->set_userdata('menu_active', $menu);
  }
}

if (!function_exists('get_url')) {
  function get_url(){
    return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  }
}

if (!function_exists('get_ip')) {
  function get_ip(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}

if (!function_exists('get_browser_user')) {
  function get_browser_user(){
    $u_agent  = $_SERVER['HTTP_USER_AGENT'];
    $bname    = 'Unknown';
    $platform = 'Unknown';
    $version  = "";

    if (preg_match('/linux/i', $u_agent)) {
      $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
      $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
      $platform = 'windows';
    }

    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
      $bname = 'Internet Explorer';
      $ub    = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
      $bname = 'Mozilla Firefox';
      $ub    = "Firefox";
    } elseif (preg_match('/OPR/i', $u_agent)) {
      $bname = 'Opera';
      $ub    = "Opera";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
      $bname = 'Google Chrome';
      $ub    = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
      $bname = 'Apple Safari';
      $ub    = "Safari";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
      $bname = 'Netscape';
      $ub    = "Netscape";
    }

    $known   = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }

    $i = count($matches['browser']);
    if ($i != 1) {
      if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
        $version = $matches['version'][0];
      } else {
        $version = $matches['version'][1];
      }
    } else {
      $version = $matches['version'][0];
    }

    if ($version == null || $version == "") {$version = "?";}
    return array(
      'userAgent' => $u_agent,
      'name'      => $bname,
      'version'   => $version,
      'platform'  => $platform,
      'pattern'   => $pattern,
    );
  }
}

if ( ! function_exists('setNewDateTime')){
  function setNewDateTime(){
    date_default_timezone_set("Asia/Jakarta");
    $date = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
    return $date->format('Y-m-d H:i:s');
  }
}

if( ! function_exists('exportToExcel')){
  function exportToExcel($data = array(), $title = 'test', $filename = 'test'){
    $CI     = &get_instance();
    $CI->load->library('excel');
    $objPHPExcel    = new Excel();

        // Nama Field Baris Pertama
    $fields = $data->list_fields();
    $col = 0;
    foreach ($fields as $field)
    {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).'1:'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getFont()->setBold(true);
      $col++;
    }

    // Isi datanya
    $row = 2;
    foreach($data->result() as $data)
    {
      $col = 0;
      foreach ($fields as $field)
      {

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field)->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).$row.':'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 

        $col++;
      }

      $row++;
    }

    $objPHPExcel->setActiveSheetIndex(0);
    //Set Title
    $objPHPExcel->getActiveSheet()->setTitle($title);

    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'.xls"'); 
    header('Cache-Control: max-age=0'); //no cache
    //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
  }
}

if( ! function_exists('exportAbsen')){
  function exportAbsen($detail = array(), $header = array(), $student, $data = array(), $rekap = array(), $title = 'test', $filename = 'test'){
    $CI     = &get_instance();
    $CI->load->library('excel');
    $objPHPExcel    = new Excel();
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1, 'Branch');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,1, $detail['branch']);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2, 'Periode');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,2, $detail['periode_name']);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,3, 'School');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3, $detail['program']);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,4, 'Class');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,4, $detail['class_name']);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,5, 'Trainer');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,5, $detail['trainer']);
    # Nama Field Baris Pertama
    $col = 0;
    foreach ($header as $field){
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 7, $field);
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).'7:'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getFont()->setBold(true);
      if($field != 'Student' && $field != 'Type'){
       $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).'7:'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
      $col++;
    }

    # Isi datanya
    $row = 8;
    for($i = 0; $i < count($student); $i++){
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, ($i+1))->getColumnDimension(column_letter(1))->setAutoSize(true);;
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(1).$row.':'.column_letter(1).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $student[$i]['participant_name'])->getColumnDimension(column_letter(2))->setAutoSize(true);;
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $student[$i]['program_type'])->getColumnDimension(column_letter(3))->setAutoSize(true);;
      $col = 3;
      for($j = 0; $j < count($data); $j++){
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data[$j][$i]['is_attend'])->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).$row.':'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $col++;
      }
      $row++;
    }

    # Isi rekapnya
    $row += 1;
    $col = 3;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($col-1), $row, "From Other Class")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    for($i = 0; $i < count($rekap); $i++){
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rekap[$i]['other_class'])->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).$row.':'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $col++; 
    }

    $row += 1;
    $col = 3;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($col-1), $row, "Bonus")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    for($i = 0; $i < count($rekap); $i++){
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rekap[$i]['bonus_class'])->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).$row.':'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $col++; 
    }

    $row += 1;
    $col = 3;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($col-1), $row, "Attendance")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    for($i = 0; $i < count($rekap); $i++){
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rekap[$i]['attendance'])->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).$row.':'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $col++; 
    }

    $row += 1;
    $col = 3;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($col-1), $row, "Total Attendance")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    for($i = 0; $i < count($rekap); $i++){
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rekap[$i]['total_attendance'])->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).$row.':'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $col++; 
    }

    $row += 1;
    $col = 3;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($col-1), $row, "Notes")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    for($i = 0; $i < count($rekap); $i++){
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rekap[$i]['recap_notes'])->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle(column_letter(($col+1)).$row.':'.column_letter(($col+1)).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $col++; 
    }

    $row += 3;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, "Keterangan")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($row+1), "v = hadir")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($row+2), "x = tidak hadir")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($row+3), "xv = hadir di kelas lain")->getColumnDimension(column_letter(($col+1)))->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(0);

    # Set Title
    $objPHPExcel->getActiveSheet()->setTitle($title);

    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'.xls"'); 
    header('Cache-Control: max-age=0'); //no cache
    # Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
  }
}

if (!function_exists('column_letter')) {
  function column_letter($c){
    $c = intval($c);
    if ($c <= 0) return '';

    $letter = '';
             
    while($c != 0){
       $p = ($c - 1) % 26;
       $c = intval(($c - $p) / 26);
       $letter = chr(65 + $p) . $letter;
    }
    
    return $letter;
  }
}

if (!function_exists('curl_post')) {
  function curl_post($url, $data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }
}

if (!function_exists('curl_post_https')) {
  function curl_post_https($url, $data){
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data,
      
    ));
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }
}