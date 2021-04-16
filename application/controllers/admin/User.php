<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class User extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && $level == 'admin' || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}
	
	public function index(){
		$data['results'] = $this->model_login->getuser_admin();
		set_active_menu('Data User');
		init_view('admin/content_user', $data);
	}

	public function add(){
		$data = "";
		set_active_menu('Add user');
		init_view('admin/content_tambahuser');
	}

	public function edit($id){
		$data['results'] 	= $this->model_login->get_edit_user($id);
		$data['divisi'] 	= $this->model_login->getdivisi();
		set_active_menu('Edit user');
		init_view('admin/content_edituser', $data);
	}

	public function delete(){
		$id 		= $this->input->post('id');
		$results 	= $this->model_login->hapus_user($id);
		
		if($results){
			flashdata('success','Segala data user tersebut sudah terhapus dari sistem');
		}else{
			flashdata('error','Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function submit_add(){
		$nama 		= $this->input->post('nama');
		$username 	= $this->input->post('username');
		$email 		= strtolower($this->input->post('email'));
		$jenis 		= $this->input->post('jenis');
		$ci 		= $this->input->post('cutiizin');
		$cs 		= $this->input->post('cutisakit');
		$lembur 	= $this->input->post('lembur');
		$plus 		= $this->input->post('plus');
		
		if($plus==null){
			$lembur = $lembur;
		}else{
			$lembur = $lembur + 0.5;
		}
		
		$pass = substr(md5($username),0,6);
		
		$results = $this->model_login->cek_user_null($username, $email);
		if($results){
			$pesan = '<html><body>Selamat akun Anda di Mri.co.id telah dibuat, sebagai berikut :<br>Username : <username> <br>Pass : <pass> </body></html>';
			
			$pesan = str_replace("<username>", $username, $pesan);
			$pesan = str_replace("<pass>", $pass, $pesan);
			
			$to = $email;
			$subject = 'Selamat Akun Apps.mri.co.id anda sudah berhasil dibuat. :)';
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
			
			$results = $this->model_login->tambah_user($nama,$username,$email,$pass,$jenis,$ci,$cs,$lembur);
			if($results){
				flashdata('success','User baru berhasil dibuat');
			}
		}else{
			flashdata('error','User baru gagal ditambahkan');
		}

		redirect(base_url('admin/user'));
	}

	public function submit_edit(){
		$id 		= $this->input->post('id');
		$nama 		= $this->input->post('nama');
		$jenis_cuti = $this->input->post('cuti');
		$depart 	= $this->input->post('depart');
		$status 	= $this->input->post('status');
		$results 	= $this->model_login->edit_user($id, $nama, $jenis_cuti, $depart, $status);
		
		if($results){
			flashdata('success','Data user berhasil diubah');
		}else{
			flashdata('error','Data user gagal diubah');
		}
		redirect(base_url('admin/user'));
	}

	public function data(){
		set_active_menu('Data User');
		
		$this->db->select('username, nama_lengkap, tempat_lahir, no_ktp, no_npwp, email_pribadi, jenis_kelamin, status_diri, agama, alamat_tinggal, alamat_asal, universitas, telp_rumah, nama_ayah, nama_ibu, no_hp_ibu, nama_saudara, no_hp_saudara, hubungan_keluarga, no_kk, nama_org_terdekat, alamat_org_terdekat, hubungan_org_terdekat, no_hp_org_terdekat');
		$this->db->where('level', 'user');
		$query = $this->db->get('user');
		
		exportToExcel($query, $title = 'user', $filename = 'Data Warrior MRG');
		
	}
	
	public function export()
	{
		set_active_menu('Data User');

		$this->db->select('a.username as Username, a.no_hp as No HP, a.email as E-mail, b.departement as Divisi, a.jenis_cuti as Jenis Cuti, a.status as Status');
		$this->db->join('divisi b', 'a.id_divisi = b.id', 'inner');
		$query = $this->db->get('user a');

		exportToExcel($query, $title = 'user', $filename = 'Data Warrior MRG');
	}

	
	
}