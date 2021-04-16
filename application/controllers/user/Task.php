<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Task extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_task');
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
		$data['results'] 	= $this->model_task->get_mytask();
		$data['hasil'] 		= $this->model_login->getusername();
		$data['minus'] 		= $this->model_task->get_minus_event();
		$data['plus'] 		= $this->model_task->get_plus_event();
		
		$minus = 0;
		if($data['minus']){
			foreach($data['minus'] as $m){
				$minus = $minus + 1;
			}
		}
		
		$minus = $minus * 2;
		
		$plus = 0;
		if($data['plus']){
			foreach($data['plus'] as $p){
				$plus = $plus + 1;
			}
		}
		
		$hasil = $plus - $minus;
		
		$data['sp'] = $hasil;
		set_active_menu('My Task');
		init_view('user/content_mytask', $data);
	}

	public function request(){
		$data['results'] 	= $this->model_task->get_request_task();
		$data['hasil'] 		= $this->model_login->getusername();
		set_active_menu('Request Task');
		init_view('user/content_permohonan_task', $data);
	}

	public function submission(){
		$data['results'] 	= $this->model_task->get_submission_task();
		$data['hasil'] 		= $this->model_login->getusername();
		set_active_menu('Submission Task');
		init_view('user/content_pengajuan_task', $data);
	}

	public function all(){
		$data['results'] 	= $this->model_task->get_all_mytask();
		$data['hasil'] 		= $this->model_login->getusername();
		set_active_menu('All Task');
		init_view('user/content_all_task', $data);
	}

	public function batalkan_pertukaran($idevent, $token){
		if($token == md5($idevent)){
			$results = $this->model_task->batalkan_pertukaran($idevent);
			
			if($results){
				flashdata('success','Berhasil dibatalkan');
			}else{

				flashdata('error','Pertukaran gagal dibatalkan');
			}
		}else{
			flashdata('error','Pertukaran gagal dibatalkan');
		}
		redirect(base_url('user/task'));
	}

	public function event_digantikan(){
		$idevent =  $this->input->post('idevent');
		$getname = $this->input->post('getname');
		$results = $this->model_task->event_digantikan_cek($idevent, $getname);
		
		if($results){
		  	//Cek user tidak sedang menggantikan / tidak ada request
			$results1 = $this->model_task->event_digantikan_request($idevent,$getname);

			if($results1){

				$results2 = $this->model_task->event_digantikan($idevent,$getname);

				$hs['user'] = $this->model_login->getuser_person($getname);			  		

				foreach($hs['user'] as $r){
					$hp = $r->no_hp;
				}

				$nama = ucfirst($this->session->userdata('username'));
				$id_user = $this->session->userdata('id');

				$hsl['task'] = $this->model_task->get_event($idevent, $id_user);

				foreach($hsl['task'] as $tsk){
					$event = $tsk->event;
					$lokasi = $tsk->location;
					$tgl = date("d-M-Y", strtotime($tsk->date));

					if($tsk->tugas == null){
						$tugas = "Tunggu Info Pd";
					}else{
						$tugas = $tsk->tugas;
					}
				}

				//Send Confirmation
				$token ="9289c10816467ec0a42430fd6add1e0a59fe3975b265b";
				$uid = "6281280539070";
				$t = time();$unik =$t.rand(10,100);
				$to = $hp;
				$pesan = urlencode("*Ada Permintaan Pergantian EVENT* \nEvent : $event, \nTanggal : $tgl,\nTugas : $tugas, \nOleh : $nama ");

				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, "https://www.waboxapp.com/api/send/chat"); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
				curl_setopt($ch, CURLOPT_POST, 1); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, 'token='.$token.'&uid='.$uid.'&to='.$to.'&custom_uid='.$t.'&text='.$pesan.''); 
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
				curl_setopt($ch, CURLOPT_MAXREDIRS, 5); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 25); 

				$response = curl_exec($ch); 
					//$info = curl_getinfo($ch); 
					//echo $response;
				curl_close ($ch);
 					//End Confirmation

				flashdata('success','Event telah berhasil di request');
			}else{
				flashdata('error','Request gagal diproses, user sudah terdapat di Event Ini.');
			}
		}else{
			flashdata('error','Maaf, User sudah menggantikan orang lain / di Request orang lain.');
		}
		redirect(base_url('user/task'));
	}

	public function approve_request($idpengganti, $idtask){
		$results = $this->model_task->approve_request_task($idtask, $idpengganti);
		
		if($results){
			flashdata('success','List Event telah ditambahkan kedalam List');
		}else{
			flashdata('error','List Event gagal ditambahkan kedalam List');
		}

		redirect(base_url('user/task/request'));
	}

	public function reject_konfirmasi_pertukaran($idevent, $token){
		if($token == md5($idevent)){
			$results = $this->model_task->reject_konfirmasi_pertukaran($idevent);
			
			if($results){
				$data['results'] = $this->model_task->get_user_mail($idevent);
				
				foreach ( $data['results'] as $r ){
					$email = $r->email;
				}
				//Email Notification he/her get cuti
				$pesan = '<html><body>Maaf request pengajuan pergantian Task Allocation Anda ditolak.</body></html>';
				
				$to = $email;
				$subject = 'Request Task Allocation Anda ditolak';
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
				flashdata('success','Sukses mengubah data');
			}else{
				flashdata('error','Gagal mengubah data');
			}
		}else{
			flashdata('error','Gagal mengubah data');
		}
		redirect(base_url('user/task/request'));	
	}

	public function report_pd($idevent, $token){
		if(md5($idevent) == $token){
			$data['results'] = $this->model_task->getusername_event($idevent);
			$i = 0;
			foreach ($data['results'] as $r){
				
				if($r->persetujuan_pengganti == 'ya'){
					$id = $r->id_pengganti;
				}else{
					$id = $r->id_user;
				}
				
				$data['usr'] = $this->model_task->getusername_event_get($id);
				
				foreach($data['usr'] as $rn){
					$hasil[$i][0] = $rn->username;
				}
				$hasil[$i][1] = $r->tugas;
				$hasil[$i][2] = $r->dp;
				$hasil[$i][3] = $r->modul;
				$hasil[$i][4] = $r->lunas;
				$hasil[$i][5] = $id;
				$hasil[$i][6] = $r->hadir;
				
				$data['event'] = $this->model_task->getidtask_get($idevent);
				foreach($data['event'] as $re){
					$hasil[0][7] = $re->jenis_report;
					
					if($hasil[0][7]=='peserta'){
						$hasil[0][8] = $re->daftar;
						$hasil[0][9] = $re->ots;
						$hasil[0][10] = $re->hadir;
						$hasil[0][11] = $re->tidak_hadir;						
					}elseif($hasil[0][7]=='keluarga'){
						$explode_daftar = $re->daftar;
						
						if(strlen($explode_daftar) > 0){
							
							$daftar_pecah = explode(",", $explode_daftar);
							
							$hasil[1][8] = $daftar_pecah[0];
							$hasil[2][8] = $daftar_pecah[1];
							
							$explode_ots = $re->ots;
							$ots_pecah = explode(",", $explode_ots);
							
							$hasil[1][9] = $ots_pecah[0];
							$hasil[2][9] = $ots_pecah[1];
							
							$explode_hadir = $re->hadir;
							$hadir_pecah = explode(",", $explode_hadir);
							
							$hasil[1][10] = $hadir_pecah[0];
							$hasil[2][10] = $hadir_pecah[1];
							
							$explode_tidak_hadir = $re->tidak_hadir;
							$tidak_hadir_pecah = explode(",", $explode_tidak_hadir);
							
							$hasil[1][11] = $tidak_hadir_pecah[0];
							$hasil[2][11] = $tidak_hadir_pecah[1];
						}
					}
				}

				
				$i = $i + 1;
			}
			
			$data['jmh'] 		= $i;
			$data['hasil']		= $hasil;
			$data['idtask']		= $idevent;
			$data['tgl'] 		= $data['event'][0]->date;
			$data['event'] 		= $data['event'][0]->event;
			$data['idevent'] 	= $idevent;
			$data['nm'] 		= $this->model_task->user_add_task_paytask();
			set_active_menu('My Task');
			init_view('user/content_report_pd',$data);
		}else{
			redirect(base_url('user/task'));
		}
	}

	public function paytask_adding(){
		$idevent 	= $this->input->post('idevent');
		$username 	= $this->input->post('username');
		$eventname 	= $this->input->post('eventname');
		$date 		= $this->input->post('tgl');
		
		$results = $this->model_task->user_add_task_paytask_adding($idevent, $username);
		
		if($results){
			flashdata('success','Warriors ditambahkan kedalam list');
		}else{
			flashdata('error','Warriors sudah terdapat dievent ini');
		}
		redirect(base_url('user/task/report_pd/'.$idevent.'/'.md5($idevent)));
	}

	public function update_report_pd(){
		$idevent = $this->input->post('idtask');
		$jmhuser = $this->input->post('jmhuser') ;
		
		for($i=0; $jmhuser > $i; $i++){
			$iduser = $this->input->post('userid'.$i);
			$tugas = $this->input->post('tugas'.$i);
			$dp = $this->input->post('dp'.$i);
			
			//Modul dihilangkan karena info sri tdk dibutuhkan dan sudah dijadikan satu dengan dp
			$modul = '';
			$lunas = $this->input->post('lunas'.$i);
			
			if(isset($_POST['hadir'.$i])){
				$hadir = 'ya';
			}else{
				$hadir = 'tidak';
			}
			
			
			$results = $this->model_task->update_report_pd($idevent, $iduser, $tugas, $dp, $modul, $lunas, $hadir);
		}
		
		if($this->input->post('jns_report') == 'peserta'){
			$daftar = $this->input->post('daftar');
			$ots = $this->input->post('ots');
			$hadir = $this->input->post('hadir');
			$tidak_hadir = $this->input->post('tidak_hadir');
		}else{
			$daftar = $this->input->post('daftark').','.$this->input->post('daftara');
			$ots = $this->input->post('otsk').','.$this->input->post('otsa');
			$hadir = $this->input->post('hadirk').','.$this->input->post('hadira');
			$tidak_hadir = $this->input->post('tidak_hadirk').','.$this->input->post('tidak_hadira');
		}
		
		$results = $this->model_task->update_report_pd_task($idevent,$daftar,$ots,$hadir,$tidak_hadir);
		
		if($results){
			flashdata('success', 'Berhasil menyimpan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('user/task/'));
	}
	
	public function sesi_perkenalan()
	{
		$data['results'] = $this->model_task->get_sp();
		set_active_menu('Event');
		init_view('user/content_list_sesi_perkenalan', $data);
	}
	
	public function json_get_sp_detail()
	{
		$id 		= $this->input->post('id');
		$response 	= $this->model_task->get_sp_detail($id);
		echo json_encode($response);
	}
	
	public function submit_form_sp()
	{
		$post = $this->input->post();
        $location = $post['location'];
		$lokasi = $post['lokasi'];
		if($lokasi == 'others'){
    		$data_insert = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $location,
    			'is_confirm' => $post['is_confirm'],
    			'date_created' => date('Y-m-d')
    		);
    
    		$data_update = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $location,
    			'is_confirm' => $post['is_confirm'],
    		);
		}else{
		    $data_insert = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $lokasi,
    			'is_confirm' => $post['is_confirm'],
    			'date_created' => date('Y-m-d')
    		);
    
    		$data_update = array(
    			'id_user'	=> $this->session->userdata('id'),
    			'id_divisi'  => $this->session->userdata('iddivisi'),
    			'event' => $post['event'],
    			'date_event' => $post['date_event'],
    			'location' => $lokasi,
    			'is_confirm' => $post['is_confirm'],
    		);
		}

		if (!empty($post['id'])) {
			# update statement
			$id = $post['id'];
			unset($post['id']);
			$result = $this->model_task->update_sp($data_update, $id);
			if ($result) {
				flashdata('success', 'Berhasil mengubah data');
			} else {
				flashdata('error', 'Gagal mengubah data');
			}
		} else {
			# insert statement
			$result = $this->model_task->insert_sp($data_insert);

			if ($result) {
				flashdata('success', 'Berhasil menambahkan data');
			} else {
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('user/task/sesi_perkenalan'));
	}
	
	public function delete_sp()
	{
		$id 		= $this->input->post('id');
		$results 	= $this->model_task->hapus_data_sp($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}

	
}