<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Overtime extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_lembur');
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
		$this->apply();
	}

	public function apply(){
		$data['hsl'] = $this->model_lembur->get_addlembur();
		set_active_menu('Apply Overtime');
		init_view('user/content_addlembur', $data);
	}
	
	public function acc(){
		$data['hsl'] = $this->model_lembur->get_acclembur();
		set_active_menu('Acc Overtime');
		init_view('user/content_acclembur', $data);
	}

	public function history(){
		//Mendeteksi username
		$name = $this->session->userdata('username');
		$data['bulan'] = list_bulan();
		//cek apakah ada post untuk bulan dan tahun
		if (empty($_POST['bln']) || (empty($_POST['thn'])) ){
			//How to Get Date same this Month
			//Get Much days in Month
			$bln = date("m");
			$thn = date("Y");
		}else{
			$bln = $_POST['bln'];
			$thn = $_POST['thn'];
		}
		
		//Memasukan data bulan kedalam array data agar bisa diextrak di view
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		
		//Mengecek jumlah hari/tanggal pada bulan di tahun tersebut
		$jmh_hari = cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		
		$i=0;
		$plus=0;
		
		//Looping sebanyak jumlah hari/tanggal
		for($d=1; $d <= $jmh_hari; $d++){

		    //Memulai pencarian dari tanggal 1 dibulan tersebut
			$cari_tgl = $thn.'-'.$bln.'-'.$d;
			
			//Mendapatkan jam lembur di tanggal tersebut
			$hsl_cari = $this->model_lembur->cari_tgl($name,$cari_tgl);
			
			$hsl_desk = $this->model_lembur->cari_desk($name,$cari_tgl);
			$jam = $this->model_lembur->cari_lembur_bulan($bln,$thn);
			
			$hasil[$i][0] = $cari_tgl;
			$hasil[$i][1] = $hsl_desk;
			
			if($hsl_cari == '-'){
				$hasil[$i][2] = '-';
				$hasil[$i][3] = '-';
				$hasil[$i][4] = $jam + $plus;
			}
			if($hsl_cari == 0){
				$hasil[$i][2] = '-';
				$hasil[$i][3] = '-';
				$hasil[$i][4] = $jam + $plus;
			}
			elseif($hsl_cari > 0){
				$hasil[$i][2] = $hsl_cari;
				$plus = $plus + $hsl_cari;
				$hasil[$i][3] = '-';
				$hasil[$i][4] = $jam + $plus;
			}
			elseif($hsl_cari < 0){
				$hasil[$i][2] = '-';
				$plus = $plus + $hsl_cari;
				$hasil[$i][3] = $hsl_cari;
				$hasil[$i][4] = $jam + $plus;
			}
			$i = $i+1;
		}
		$data['hasil']= $hasil;	
		$data['jmh_hari']= $jmh_hari;
		
		
		$data['results']= $this->model_lembur->cari_cuti_izin();
		$i=0;$min=0;
		$izin[]=null;
		foreach($data['results'] as $r){

			$izin[$i][0] = $r->tgl;
			$izin[$i][1] = $r->deskripsi;
			if($i == 0){
				$awal = 12;
				$izin[$i][2] = 12;
			}else{
				$izin[$i][2] = '-';
			}
			$min = $min - 1;
			$izin[$i][3] = -1;
			$sisa = $awal + $min;
			$izin[$i][4] = $sisa;

			$i = $i+1;
		}
		
		$data['jmh_izin'] = $i;
		$data['izin'] = $izin;
		
		
		$data['results'] = $this->model_lembur->cari_cuti_sakit();
		$i=0;$min=0;
		$sakit[]=null;
		foreach($data['results'] as $r){

			$sakit[$i][0] = $r->tgl;
			$sakit[$i][1] = $r->deskripsi;
			if($i == 0){
				$awal = 12;
				$sakit[$i][2] = 12;
			}else{
				$sakit[$i][2] = '-';
			}
			$min = $min - 1;
			$sakit[$i][3] = -1;
			$sisa = $awal + $min;
			$sakit[$i][4] = $sisa;

			$i = $i+1;
		}
		
		$data['jmh_sakit'] = $i;
		$data['sakit'] = $sakit;
		
		$data['jmhdg'] = $jam;
		set_active_menu('Report');
		init_view('user/content_report', $data);
	}

	public function addlembur(){
		$tgl = $this->input->post('tgl');
		
		$now = date('Y-m-d');
		$last = '2016-01-01';
		//Mengecek agar proses input tidak melebihi waktu saat ini dan diatas tahun 2016
		if(($tgl <= $now) and ($last <= $tgl)){
			
			
			$date_limit = date('Y-m-d', strtotime("-7 days"));
			
			$CheckInX = explode("-", $date_limit);
			$CheckOutX =  explode("-", $tgl);
			$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
			$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
			$interval =($date2 - $date1)/(3600*24);
			
			if($interval > -1){
				$nilai = $this->input->post('nilai');
				$plus = $this->input->post('plus');
				
				if($nilai == 0 && $plus == 0){
					$this->session->set_flashdata('msgadd','error');
				}else{
					$desc = $this->input->post('deskripsi');
					$msk = $this->input->post('msk');
					$plg = $this->input->post('plg');
					
					
					if($plus >= 30){
						$plus = 0.5;
						$nilai = $nilai + $plus;
					}elseif($plus < -30){
						$plus = 1;
						$nilai = $nilai - $plus;
					}elseif($plus < 0){
						$plus = 0.5;
						$nilai = $nilai - $plus;
					}else{
						$nilai = $nilai;
					}
					
					$desc = '<jam>'.$msk.' - '.$plg.'</jam> '.$desc;
					
					$results = $this->model_lembur->addlembur($desc, $nilai, $tgl);
					
					if($results){
						$this->session->set_flashdata('success','Waiting for Approval');
					}else{
						$this->session->set_flashdata('error','error');
					}
				}
				
			}else{
				$this->session->set_flashdata('error','limit apply is 7 days for overtime and not for future submission');
			}
			
		}else{
			$this->session->set_flashdata('error','limit apply is 7 days for overtime and not for future submission');
		}
		redirect(base_url('user/overtime/apply'));
		
	}

	public function editlembur(){
		$tgl = $this->input->post('tgl');
		
		$now = date('Y-m-d');
		$last = '2016-01-01';
		//Mengecek agar proses input tidak melebihi waktu saat ini dan diatas tahun 2016
		if(($tgl <= $now) and ($last <= $tgl)){
			
			
			$date_limit = date('Y-m-d', strtotime("-7 days"));
			
			$CheckInX = explode("-", $date_limit);
			$CheckOutX =  explode("-", $tgl);
			$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
			$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
			$interval =($date2 - $date1)/(3600*24);
			
			if($interval > -1){
				$nilai = $this->input->post('nilai');
				$plus = $this->input->post('plus');
				
				if($nilai == 0 && $plus == 0){
					flashdata('error', 'Please to use Chrome Browser');
				}else{
					$desc = $this->input->post('deskripsi');
					$msk = $this->input->post('msk2');
					$plg = $this->input->post('plg2');
					$id = $this->input->post('id');
					
					if($plus >= 30){
						$plus = 0.5;
						$nilai = $nilai + $plus;
					}elseif($plus < 0){
						$plus = 0.5;
						$nilai = $nilai - $plus;
					}else{
						$nilai = $nilai;
					}
					
					$desc = '<jam>'.$msk.' - '.$plg.'</jam> '.$desc;
					$data = array(
						'tgl' 		=> $tgl,
						'deskripsi'	=> $desc,
						'nilai' 	=> $nilai
					);
					$results = $this->model_lembur->update($data, $id);
					
					if($results){
						flashdata('success','Waiting for Approval');
					}else{
						flashdata('error','Perubahan tidak berhasil disimpan');
					}
				}
				
			}else{
				flashdata('error','limit apply is 7 days for overtime and not for future submission');
			}
			
		}else{
			flashdata('error','limit apply is 7 days for overtime and not for future submission');
		}
		redirect(base_url('user/overtime/apply'));
		
	}
	
	public function toapprove_lembur_spv(){
		$id = $this->input->post('id');
		$results = $this->model_lembur->toapprove_lembur_spv($id);
		
		if($results){
			flashdata('success','Berhasil Diteruskan ke HR');
		}else{
			flashdata('error','Gagal mengubah data.');
		}
		echo json_encode($results);		
	}
	
	public function toreject_lembur_spv(){
		$id = $this->input->post('id');
		$results = $this->model_lembur->toreject_lembur_spv($id);
		
		if($results){
			flashdata('success','Berhasil menolak pengajuan.');
		}else{
			flashdata('error','Gagal mengubah data.');
		}
		echo json_encode($results);
	}
	

	public function cuti_izin(){
		$this->load->model('model_cuti_izin');
		$this->load->model('model_login');
		$thn 				= date('Y');
		$data['cekname'] 	= $this->session->userdata('username');
		$data['cutisblm'] 	= $this->model_cuti_izin->get_cuti_izin_sblm($data['cekname'], $thn);
		$data['results'] 	= $this->model_cuti_izin->get_cuti_izin($data['cekname'], $thn);
		$data['allname'] 	= $this->model_login->getusername();
		set_active_menu('Cuti Izin');
		init_view('user/content_cuti_izin', $data);
	}

	public function cuti_sakit(){
		$this->load->model('model_cuti_sakit');
		$this->load->model('model_login');
		$data['cekname'] = $this->session->userdata('username');
		$data['results'] = $this->model_cuti_sakit->get_cuti_sakit($data['cekname']);
		$data['allname'] = $this->model_login->getusername();
		set_active_menu('Cuti Sakit');
		init_view('user/content_cuti_sakit', $data);
	}

	public function deletelembur(){
		$id = $this->input->post('id');
		$result = $this->model_lembur->delete($id);
		if($result){
			flashdata('success', 'Data berhasil dihapus');
		}else{
			flashdata('error', 'Gagal melakukan perubahan data');
		}
		echo json_encode($result);
	}

	public function json_get_data_overtime(){
		$id 	= $this->input->post('id');
		$result = $this->model_lembur->get_data_lembur($id);
		$deskripsi = explode('</jam>', $result['deskripsi'])[1];
		$response = array(
			'data' => $result,
			'deskripsi' => $deskripsi
		);
		echo json_encode($response);
	}
}