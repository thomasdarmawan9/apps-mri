<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Overtime extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_lembur');
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
		$data['results'] = $this->model_login->getusername();
		set_active_menu('Overtime');
		init_view('admin/content_lembur', $data);
	}

	public function acc(){
		$data['hsl'] = $this->model_lembur->get_acchr_lembur();
		set_active_menu('Acc Lembur');
		init_view('admin/content_acchrlembur', $data);
	}
	
	public function acc_merch()
	{
		$data['hsl'] = $this->model_lembur->get_acchr_merch();
		set_active_menu('Acc Merchandise');
		init_view('admin/content_acchrmerch', $data);
	}

	public function report_izin_hr(){
		if (isset($_POST["name"]) && !empty($_POST["name"]) && !empty($_POST['thn'])) {
			$username 			= $this->input->post('name');
			$fromthn 			= $this->input->post('thn');
			$data['cekname'] 	= $username;
			$data['thn'] 		= $fromthn;
			$data['cutisblm'] 	= $this->model_lembur->get_cuti_izin_sblm($username, $fromthn);
			$data['results'] 	= $this->model_lembur->get_cuti_izin($username, $fromthn);
		}

		$data['allname'] = $this->model_login->getusername();
		set_active_menu('Report Izin');
		init_view('admin/content_laporanhrcuti', $data);
	}

	public function report_sakit_hr(){
		if (isset($_POST["name"]) && !empty($_POST["name"])) {
			$username = $_POST['name'];
			$data['cekname'] = $_POST['name'];
			$data['results'] = $this->model_lembur->get_cuti_sakit($username);
		}
		$data['allname'] = $this->model_login->getusername();
		set_active_menu('Report Sakit');
		init_view('admin/content_laporancutiskt', $data);
	}

	public function report_hr(){
		$data['results'] = $this->model_login->getuser();

		$i = 0;
		if($data['results']<>null){
			foreach($data['results'] as $r){

				if($r->username<>'admin'){
					//How to Get Balance
					$name = $r->username;
					$lembur = $this->model_lembur->getlembur($name);
					
					//Get month and years on input box 
					$m = $this->input->post('month');
					$y = $this->input->post('year');
					if($m == null && $y == null){
						$bln = date("m");
						$thn = date("Y");
						$data['bln'] = $bln;
						$data['thn'] = $thn;
					}else{

						$bln = $m;
						$thn = $y;

						$data['bln'] = $m;
						$data['thn'] = $y;

					}
					
					$date = $thn.'-'.$bln.'-01';
					$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
					$newdate = date ( 'Y-m-j' , $newdate );
					
					$hsl_lmbr = $this->model_lembur->get_lembur_sblm($name,$newdate);
					
					
					$jmh_hari = cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
					
					$totalovertime = 0;
					
					//Search Date
					for($d=1;$d <= $jmh_hari;$d++){
						$cari_tgl = $thn.'-'.$bln.'-'.$d;
						
						$hsl_cari = $this->model_lembur->cari_tgl($name,$cari_tgl);
						$hasil[$i][$d+1] = $hsl_cari;	
						
						//Get total overtime
						$totalovertime = $totalovertime + $hsl_cari;
						
					}
					
					//Get total overtime
					$hasil[$i][$d+1] = $totalovertime;
					$hasil[$i][$d+2] = $hsl_lmbr;
					
					$hasil[$i][0] = $r->username;
					$hasil[$i][1] = $lembur;
					$i = $i + 1;
				}
			}
		}
		if(!empty($hasil)){
			$data['hasil']= $hasil;
			$data['jmh_hari']= $jmh_hari;
			$data['jmh_user']= $i;
		}
		$data['list_bulan'] = list_bulan();
		set_active_menu('Report HR');
		init_view('admin/content_laporanhr', $data);
	}

	public function detail_lembur($user, $tgl){
		$data['user'] 		= $user;
		$data['tgl'] 		= $tgl; 
		$data['results'] 	= $this->model_lembur->get_detail_lembur($user,$tgl);
		set_active_menu('Detail Lembur');
		init_view('admin/content_detaillembur', $data);
	}

	public function tambah_lembur(){
		$jamlembur 			= $this->input->post('jamlembur');
		$plus 				= $this->input->post('plus');
		$name['getname'] 	= $this->input->post('getname');
		$tgl 				= $this->input->post('tgl');
		$deskripsi 			= $this->input->post('deskripsi');
		
		$now 	= date('Y-m-d');
		$last 	= '2016-01-01';
		
		//Mengecek agar proses input tidak melebihi waktu saat ini dan diatas tahun 2016
		if(($tgl <= $now) and ($last <= $tgl)){

			if($plus==null){
				$nilai = $jamlembur;
			}else{
				$nilai = $jamlembur + 0.5;
			}

			foreach ($name['getname'] as $nm){
				$getnm = $nm;
				$results = $this->model_lembur->pluslembur($jamlembur, $getnm, $tgl, $deskripsi, $nilai);
			}

			if($results){
				flashdata('success','Jam Lembur sudah ditambahkan');
			}

		}else{
			flashdata('error','Pastikan tanggal tidak melebihi tanggal hari ini dan diatas tahun 2016');
		}
		redirect(base_url('admin/overtime'));		
	}

	public function kurang_lembur(){
		$jamlembur 			= $this->input->post('jamlembur');
		$minus 				= $this->input->post('minus');
		$name['getname'] 	= $this->input->post('getminusname');
		$tgl 				= $this->input->post('tgl');
		$deskripsi 			= $this->input->post('deskripsi');
		
		$now 	= date('Y-m-d');
		$last 	= '2016-01-01';
		
		//Mengecek agar proses input tidak melebihi waktu saat ini dan diatas tahun 2016
		if(($tgl <= $now) and ($last <= $tgl)){

			if($minus==null){
				$nilai = 0 - $jamlembur;
			}else{
				$nilai = 0 - ($jamlembur + 0.5);
			}

			foreach ($name['getname'] as $nm){
				$getnm = $nm;
				$results = $this->model_lembur->pluslembur($jamlembur, $getnm, $tgl, $deskripsi, $nilai);
			}

			if($results){
				flashdata('success','Jam Lembur sudah ditambahkan');
			}

		}else{
			flashdata('error','Pastikan tanggal tidak melebihi tanggal hari ini dan diatas tahun 2016');
		}

		redirect(base_url('admin/overtime'));
	}

	public function kurang_cuti(){
		
		$cuti 				= $this->input->post('cuti');
		$name['getname'] 	= $this->input->post('getname');
		$tgl 				= $this->input->post('tgl');
		$deskripsi 			= $this->input->post('deskripsi');

		if($cuti == 'izin'){
			$tcuti = 'cuti_izin';
		}else{
			$tcuti = 'cuti_sakit';
		}
		
		foreach ($name['getname'] as $nm){
			$getnm = $nm;
			$results = $this->model_lembur->minuscuti($getnm, $tgl, $deskripsi, $tcuti);
		}
		
		if($results){
			flashdata('success','Cuti sudah ditambahkan');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}

		redirect(base_url('admin/overtime'));
	}

	public function tambah_cuti(){
		
		$plus 				= $this->input->post('jmhhr');
		$name['getname'] 	= $this->input->post('getname');
		$tgl 				= $this->input->post('tgl');
		$deskripsi 			= $this->input->post('deskripsi');
		
		foreach ($name['getname'] as $nm){
			$getnm = $nm;
			$results = $this->model_lembur->tambah_cuti_manual($getnm, $plus, $tgl, $deskripsi);
		}
		
		if($results){
			flashdata('success','Cuti sudah ditambahkan');
		}else{
			flashdata('error', 'Gagal mengubah data');	
		}
		redirect(base_url('admin/overtime'));

	}

	public function approve_lembur(){
		$id = $this->input->post('id');
		$results = $this->model_lembur->approve_lembur_hr($id);

		if($results){
			flashdata('success','Jam lembur otomatis ditambahkan');
		}else{
			flashdata('error','Gagal mengubah data');
		}
		echo json_encode($results);
	}
	
	public function approve_merchandise()
	{
		$id = $this->input->post('id');
		$results = $this->model_lembur->approve_merch_hr($id);

		if ($results) {
			flashdata('success', 'Merchandise Sudah di Approve & Jam Lebur Otomatis Berkurang');
		} else {
			flashdata('error', 'Gagal melakukan Approve');
		}
		echo json_encode($results);
	}

	public function reject_lembur(){
		$id = $this->input->post('id');
		$results = $this->model_lembur->reject_lembur_hr($id);

		if($results){
			flashdata('success','Jam lembur tidak disetujui');
		}else{
			flashdata('error','Gagal mengubah data');
		}
		echo json_encode($results);
	}
	
	public function reject_merchandise()
	{
		$id = $this->input->post('id');
		$results = $this->model_lembur->reject_merch_hr($id);

		if ($results) {
			flashdata('success', 'Pengajuan Pembelian Merchandise tidak disetujui');
		} else {
			flashdata('error', 'Gagal melakukan Pembatalan Pembelian Merchandise');
		}
		echo json_encode($results);
	}

	public function delete_detail(){
		$id 		= $this->input->post('id');
		$results 	= $this->model_lembur->delete_detail_lembur($id);

		if($results){
			flashdata('success','Jam lembur telah diperbarui');
		}else{
			flashdata('error','Gagal mengubah data');
		}
		echo json_decode($results);
		
	}

	public function delete_cuti_izin(){
	    $id 		= $this->input->post('id');
        $result 	= $this->model_lembur->delete_cuti_izin($id);

        if($result){
        	flashdata('success','Berhasil mengubah data');
		}else{
			flashdata('error','Gagal mengubah data');
		}
        echo json_encode($result);
	}

	public function delete_cuti_sakit(){
	    $id 		= $this->input->post('id');
        $result 	= $this->model_lembur->delete_cuti_sakit($id);

        if($result){
            flashdata('success','Berhasil mengubah data');
        }else{
            flashdata('error','Gagal mengubah data');
        }
        echo json_encode($result);
	}
	
}