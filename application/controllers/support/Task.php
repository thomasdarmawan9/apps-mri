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
			if(!empty($level) && $level == 'support' || $this->session->userdata('id') == '28' ||  $this->session->userdata('id') == '43' || $this->session->userdata('id') == '44' || $this->session->userdata('id') == '64' || $this->session->userdata('id') == '76' || $this->session->userdata('id') == '82' || $this->session->userdata('id') == '63' || $this->session->userdata('id') == '88' || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72' || $this->session->userdata('id') == '169' || $this->session->userdata('id') == '133'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['results'] = $this->model_task->get_task();
		$data['divisi'] = $this->model_task->get_divisi();
		
// 		$data['get_branch'] = $this->model_task->get_all_branch();
// 		$data['get_event'] = $this->model_task->get_all_event();
		set_active_menu('Future Task Support');
		init_view('support/content_get_task', $data);
	}

	public function all(){
		$data['results'] = $this->model_task->get_alltask();
		dd($data);
		die();
		set_active_menu('Last Task Support');
		init_view('support/content_get_alltask', $data);
		// $this->load->view('content_get_alltask.php',$data);
	}

	public function add(){
		set_active_menu('Add Task');
		init_view('support/content_add_task');
	}

	public function addtaskwarrior($id){
		$data['results'] 	= $this->model_task->get_select_task($id)[0];
		$data['hasil'] 		= $this->model_login->getusername_api();
		// set_active_menu('Add Task Warrior');
		// init_view('support/content_add_war_event', $data);
		dd($data);
		die();
	}


	public function tambah_war_task(){
		$id_task 			= $this->input->post('id');
		$name['getname'] 	= $this->input->post('getname');
		
		foreach ($name['getname'] as $nm){
			$results = $this->model_task->tambah_war_task($id_task, $nm);
		}
		
		if($results){
			flashdata('success','Warriors berhasil dimasukan kedalam Event');
		}else{
			flashdata('error','Gagal menambahkan warriors kedalam Event');
		}
		redirect(base_url('support/task/'));
	}

	public function pay_war_task(){

		$id_task 			= $this->input->post('id');
		$name['getname'] 	= $this->input->post('getname');
		
		foreach ($name['getname'] as $nm){
			$results = $this->model_task->pay_war_task($id_task, $nm);
		}

		if($results){
			flashdata('success','Warriors berhasil dimasukan kedalam Event');
		}else{
			flashdata('error','Gagal menambahkan warriors kedalam Event');
		}
		redirect(base_url('support/task/'));
	}

	public function submit(){
		$id 			= $this->input->post('id');
		$nama 			= $this->input->post('nama');
		$location 		= $this->input->post('location');
		$lokasi         = $this->input->post('lokasi');
		$date 			= $this->input->post('tgl');
		$komisi_lunas 	= $this->input->post('komisilunas');
		$komisi_dp 		= $this->input->post('komisidp');
		if($this->session->userdata('username') == 'taskadmin'){
			$id_divisi 		= $this->input->post('id_divisi');
		}else{
			$id_divisi 		= $this->session->userdata('iddivisi');
		}
		$jenis_report 	= 'peserta';
		if(empty($id)){
			# insert statement
			$results = $this->model_task->tambah_task($nama, $location, $date, $jenis_report, $komisi_lunas, $komisi_dp, $id_divisi,$lokasi);

			if($results){
				flashdata('success','Event ditambahkan di List');
			}else{
				flashdata('error','Gagal menambahkan data');
			}
		}else{
			# update statement
			$results = $this->model_task->edit_task($id, $nama, $location, $date, $jenis_report, $komisi_dp, $komisi_lunas, $id_divisi,$lokasi);
			if($results){
				flashdata('success','Berhasil mengubah data');
			}else{
				flashdata('error','Gagal mengubah data');
			}
		}
		redirect(base_url('support/task/'));
	}

//     public function submit(){
// 		$id 			= $this->input->post('id');
// 		$nama 			= $this->input->post('nama');
// 		$location 		= $this->input->post('location');
// 		$lokasi			= $this->input->post('lokasi');
// 		$date 			= $this->input->post('tgl');
// 		$komisi_lunas 	= $this->input->post('komisilunas');
// 		$komisi_dp 		= $this->input->post('komisidp');
		
// 		if($this->session->userdata('username') == 'taskadmin'){
// 			$id_divisi 		= $this->input->post('id_divisi');
// 		}else{
// 			$id_divisi 		= $this->session->userdata('iddivisi');
// 		}
// 		$username		= $this->session->userdata('taskadmin');
// 		$jenis_report 	= 'peserta';
// 		if(empty($id)){
// 			# insert statement
// 			$results = $this->model_task->tambah_task($nama, $location, $date, $jenis_report, $komisi_lunas, $komisi_dp,$id_divisi,$lokasi,$username);

// 			if($results){
// 				flashdata('success','Event ditambahkan di List');
// 			}else{
// 				flashdata('error','Gagal menambahkan data');
// 			}
// 		}else{
// 			# update statement
// 			$results = $this->model_task->edit_task($id, $nama, $location, $date, $jenis_report, $komisi_dp, $komisi_lunas,$id_divisi,$lokasi,$username);
// 			if($results){
// 				flashdata('success','Berhasil mengubah data');
// 			}else{
// 				flashdata('error','Gagal mengubah data');
// 			}
// 		}
// 		redirect(base_url('support/task/'));
// 	}

	public function delete(){
		$id 		= $this->input->post('id');
		$results 	= $this->model_task->delete_task($id);

		if($results){
			$this->session->set_flashdata('success','Berhasil menghapus data.');
		}else{
			$this->session->set_flashdata('error','Gagal menghapus data.');
		}
		echo json_encode($results);
	}

	public function delete_wartask(){
		$id_task = $this->input->post('id_task');
		$id_user = $this->input->post('id_user');
		$response = $this->model_task->delete_wartask($id_task, $id_user);
		if($response){
			flashdata('success','Warriors berhasil dihapus dari event');
		}else{
			flashdata('error','Gagal mengubah data');
		}
		flashdata('modal_active', $id_task);
		echo json_encode($response);			
	}

	public function submit_pd(){
		$id_task 	= $this->input->post('id');
		$username 	= $this->input->post('getpd');
		$results 	= $this->model_task->getpd($id_task, $username);
		
		if($results){
			flashdata('success','PD berhasil ditentukan.');
		}else{
			flashdata('error','Gagal mengubah data');
		}
		redirect(base_url('support/task'));		
	}

	public function report($idevent){
		$data['results'] = $this->model_task->getusername_event($idevent);

		$i = 0;
		foreach ($data['results'] as $r){

			if($r->persetujuan_pengganti == 'ya'){
				$id = $r->id_pengganti;
				$idp = $r->id_user;
			}else{
				$id = $r->id_user;
				$idp = null;
			}

			$data['usr'] = $this->model_task->getusername_event_get($id);

			if($idp <> null){
				$data['usr_p'] = $this->model_task->getusername_event_get($idp);

				foreach($data['usr_p'] as $rn){
					$sblm_diganti = '<span style="color:red;">'.$rn->username.'</span> <i class="fa fa-caret-right" aria-hidden="true"></i> ';
				}
			}else{
				$sblm_diganti = "";
			}

			foreach($data['usr'] as $rn){
				$hasil[$i][0] = $sblm_diganti.' '.$rn->username;
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
				$data['hasil']= $hasil;
			}
			$i = $i + 1;
		}
		$data['jmh'] 	= $i;
		$data['idtask']	= $idevent;
		$data['tgl'] 	= $data['event'][0]->date;
		$data['event'] 	= $data['event'][0]->event;
		$data['nm'] 	= $this->model_task->user_add_task_paytask();
		set_active_menu('Report Task');
		init_view('support/content_review_report', $data);
	}

	public function overview(){
		$data['name'] = $this->model_task->getusername_report_task();
		$baris	= 0;
		$i 		= 0;
		foreach($data['name'] as $r){
			$hasil[$i][0] = $r->username;
			$data['jmh_event_no_pay'] 	= $this->model_task->get_event_all_notpay($r->id);
			$hasil[$i][1] 				= $data['jmh_event_no_pay'];
			
			$data['jmh_event_pay'] 		= $this->model_task->get_event_all_pay($r->id);
			$hasil[$i][2] 				= $data['jmh_event_pay'];
			
			$data['jmh_event_hutang'] 	= $this->model_task->get_event_all_hutang($r->id);
			$hasil[$i][3] 				= $data['jmh_event_hutang'];
			
			$baris = $baris + 1;
			$i = $i + 1;
		}
		
		$data['hasil'] = $hasil;
		$data['baris'] = $baris;
		set_active_menu('Overview Task');
		init_view('support/content_overviewtask', $data);
	}

	public function list_incentive(){
		$data['results'] = $this->model_task->get_all_incentive_list();
		echo json_encode($data);
	}

	public function add_newevent(){
		$name 	= $this->input->post('name');
		$dp 	= $this->input->post('dp');
		$lunas 	= $this->input->post('lunas');
		$result = $this->model_task->add_newevent_incen($name, $dp, $lunas);

		if($result){
			flashdata('success','Incentive Event berhasil ditambahkan');
		}else{
			flashdata('error','Gagal menambah data');
		}
		redirect(base_url('support/task/list_incentive'));
	}

	public function delete_event_incent(){
		$id 	= $this->input->post('id');
		$result = $this->model_task->delete_event_incent($id);

		if($result){
			flashdata('success','Data berhasil dihapus.');
		}else{
			flashdata('error','Gagal mengubah data.');
		}
		echo json_encode($result);            
	}

	public function json_get_data_event(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_task->getidtask_get($id)[0];
		echo json_encode($response);
	}

	public function json_get_data_task(){
		$id 				= $this->input->post('id');
		$response['event'] 	= $this->model_task->get_select_task($id)[0];
		$response['list']	= $this->model_task->getusername_task($id);
		echo json_encode($response);
	}

	
	
}
