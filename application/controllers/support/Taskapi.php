<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Taskapi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_task_api');
		$this->load->model('model_task');
		$this->load->model('model_login');
	} 

	public function api_index(){
		$post = json_decode(file_get_contents('php://input'), true);
		$data['results'] = $this->model_task_api->get_task($post);
		$data['divisi'] = $this->model_task->get_divisi();
		echo json_encode($data);
		
	}

	public function all(){
		$post = json_decode(file_get_contents('php://input'), true);
		$data['results'] = $this->model_task_api->get_alltask($post);
	
		// set_active_menu('Last Task Support');
		// init_view('support/content_get_alltask', $data);
		echo json_encode($data);
		// $this->load->view('content_get_alltask.php',$data);
	}

	public function add(){
		set_active_menu('Add Task');
		init_view('support/content_add_task');
	}

	public function addtaskwarrior($id){
		$post = json_decode(file_get_contents('php://input'), true);
		$data['results'] 	= $this->model_task->get_select_task($id)[0];
		echo json_encode($data);
	}

	public function addtaskwarriors(){
		$post = json_decode(file_get_contents('php://input'), true);
		$data['hasil'] 		= $this->model_login->getusername_api($post);
		echo json_encode($data);
	}


	public function tambah_war_task(){
		$post = json_decode(file_get_contents('php://input'), true);
		$id_task 			= $post['id'];
		$name['getname'] 	= $post['getname'];
		
		foreach ($name['getname'] as $nm){
			$results = $this->model_task->tambah_war_task($id_task, $nm);
		}
		
		echo json_encode($results);
	}

	public function pay_war_task(){
		$post = json_decode(file_get_contents('php://input'), true);
		$id_task 			= $post['id'];
		$name['getname'] 	= $post['getname'];
		
		foreach ($name['getname'] as $nm){
			$results = $this->model_task->pay_war_task($id_task, $nm);
		}

		echo json_encode($results);
	}

	public function submit(){
		$post = json_decode(file_get_contents('php://input'), true);
		$id 			= $post['id'];
		$nama 			= $post['nama'];
		$location 		= $post['location'];
		$lokasi         = $post['lokasi'];
		$date 			= $post['tgl'];
		$komisi_lunas 	= $post['komisilunas'];
		$komisi_dp 		= $post['komisidp'];
		if($post['username'] == 'taskadmin'){
			$id_divisi 		= $post['id_divisi'];
		}else{
			$id_divisi 		= $post['iddivisi'];
		}
		$jenis_report 	= 'peserta';
		if(empty($id)){
			# insert statement
			$results = $this->model_task->tambah_task($nama, $location, $date, $jenis_report, $komisi_lunas, $komisi_dp, $id_divisi,$lokasi);

			echo json_encode($results);
		}else{
			# update statement
			$results = $this->model_task->edit_task($id, $nama, $location, $date, $jenis_report, $komisi_dp, $komisi_lunas, $id_divisi,$lokasi);
			
			echo json_encode($results);
		}
	}

	public function delete(){
		$post = json_decode(file_get_contents('php://input'), true);
		$id 		= $post['id'];
		$results 	= $this->model_task->delete_task($id);

		echo json_encode($results);
	}

	public function delete_wartask(){
		$post = json_decode(file_get_contents('php://input'), true);
		$id_task = $post['id_task'];
		$id_user = $post['id_user'];
		$response = $this->model_task->delete_wartask($id_task, $id_user);
		
		echo json_encode($response);			
	}

	public function submit_pd(){
		$post = json_decode(file_get_contents('php://input'), true);
		$id_task 	= $post['id'];
		$username 	= $post['getpd'];
		$results 	= $this->model_task->getpd($id_task, $username);
		echo json_encode($results);
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
		$post = json_decode(file_get_contents('php://input'), true);
		$name 	= $post['name'];
		$dp 	= $post['dp'];
		$lunas 	= $post['lunas'];
		$result = $this->model_task->add_newevent_incen($name, $dp, $lunas);

		echo json_encode($result);
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
		$post = json_decode(file_get_contents('php://input'), true);
		$id 		= $post['id'];
		$response 	= $this->model_task->getidtask_get($id)[0];
		echo json_encode($response);
	}

	public function json_get_data_task(){
		$post = json_decode(file_get_contents('php://input'), true);
		$id 				= $post['id'];
		$response['event'] 	= $this->model_task->get_select_task($id)[0];
		$response['list']	= $this->model_task->getusername_task($id);
		echo json_encode($response);
	}

	
	
}
