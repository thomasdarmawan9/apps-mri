<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Birdtest extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_birdtest');
		$this->load->model('model_login');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level)){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['lock'] = $this->model_birdtest->get_birdtest_settings();
		set_active_menu('Bird Test');
		init_view('content_bird_test', $data);
	}
	
	public function report(){
		$data['lock'] = $this -> model_birdtest -> get_birdtest_settings();
		$data['results'] = $this -> model_login -> getusername();
		set_active_menu('Birdtest Report');		
		init_view('admin/content_birdtest.php',$data);
	}
	
	public function birdtest_lock(){
		$status = secure($this->input->post('status'));
		$results = $this -> model_birdtest -> birdtest_lock($status);
		if($results){
			$this->session->set_flashdata('success', 'Berhasil ubah data');
			redirect(base_url().'birdtest/report','refresh');
		}else{
			$this->session->set_flashdata('error','Gagal saat ubah');
			redirect(base_url().'birdtest/report','refresh');
		
		}
	}

	public function submit(){
		$username = $this->session->userdata('username');
		date_default_timezone_set('Asia/Jakarta');
		$waktu = date("Y-m-d H:i:s");
		$p = ($this->input->post(base64_encode('p'))/37);
		$d = ($this->input->post(base64_encode('d'))/37);
		$e = ($this->input->post(base64_encode('e'))/37);
		$o = ($this->input->post(base64_encode('o'))/37);

		$email = $this->session->userdata('email');

		//Email Notification he/her get cuti
		$pesan = '<html><body>Report BirdTest :<br>Peacock : <peacock> <br>Dove : <dove> <br>Eagle : <eagle><br>Owl : <owl>.</body></html>';
		$pesan = str_replace('<peacock>',$p,$pesan);
		$pesan = str_replace('<dove>',$d,$pesan);
		$pesan = str_replace('<eagle>',$e,$pesan);
		$pesan = str_replace('<owl>',$o,$pesan);
		
		$to = $email;
		$subject = 'Result your BirdTest';
		$body_html = $pesan;
		$from = 'support@pediahost.com';
		$fromName = 'Merry Riana Indonesia';
		$res = "";

		$data = "username=".urlencode("andy@pediahost.com");
		$data .= "&api_key=".urlencode("fb4317fa-0fde-46e4-8510-2d6cfabf6413");
		$data .= "&from=".urlencode($from);
		$data .= "&from_name=".urlencode($fromName);
		$data .= "&to=".urlencode($to);
		$data .= "&subject=".urlencode($subject);
		if($body_html)
			$data .= "&body_html=".urlencode($body_html);

		$header = "POST /mailer/send HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
		$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

		if(!$fp)
			return "ERROR. Could not open connection";
		else {
			fputs ($fp, $header.$data);
			while (!feof($fp)) {
				$res .= fread ($fp, 1024);
			}
			fclose($fp);
		}
		
		$results = $this->model_birdtest->birdtest_war($username, $waktu, $p, $d, $e, $o);
		if($results){
			flashdata('success','Data berhasil disimpan');
		}else{
			flashdata('error','Gagal menyimpan data');
		}
		redirect(base_url('birdtest'));
	}

	
}