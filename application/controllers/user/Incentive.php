<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Incentive extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_incentive');
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
		$data['results'] 	= $this->model_incentive->get_my_incentive();
		$data['paid'] 		= $this->model_incentive->get_my_incentive_paid();
		$data['unpaid'] 	= $this->model_incentive->get_my_incentive_unpaid();
		set_active_menu('Incentive');
		init_view('user/content_incentive', $data);
	}

	public function report(){
		$data['results'] = $this->model_incentive->info_pd_incentive();
		set_active_menu('Report Incentive');
		init_view('user/content_report_incentive', $data);
	}

	public function report_jumlah(){
		$id 	= $this->input->post('id');
		$token 	= $this->input->post('token');
		$jmh 	= $this->input->post('jmh');
		redirect(base_url('user/incentive/report_detail_incentive/'.$id.'/'.$jmh.'/'.$token));
	}

	public function uang_masuk(){
		$this->load->model('model_uang_masuk');
		$data['results'] = $this->model_uang_masuk->get_uang_masuk();
		set_active_menu('Uang Masuk');
		init_view('user/content_uang_masuk', $data);
	}

	public function report_detail_incentive($id_event, $jumlah, $token){
		
		if(md5($id_event) == $token){
			$data['jumlah'] 	= $jumlah;
			$data['results'] 	= $this->model_incentive->get_pd_incentive($id_event)[0];
			$data['user'] 		= $this->model_incentive->getusername_detail_incentive();
			if($data['results']){
				$data['listprogram'] = $this->model_incentive->get_all_incentive_list();
				set_active_menu('Report Detail');
				init_view('user/content_report_detail_incentive', $data);
			}else{
				flashdata('error', 'Gagal!');
				redirect(base_url('user/incentive/report'));
			}
		}else{
			flashdata('error', 'Token miss match!');
			redirect(base_url('user/incentive/report'));
		}
	}

	public function report_detail($id_event, $token){
		if(md5($id_event) == $token){
			$data['id_event'] 	= $id_event;
			$data['results'] 	= $this->model_incentive->get_pd_incentive($id_event)[0];
			$data['user'] 		= $this->model_incentive->getusername_detail_incentive();
			$data['hsl'] 		= $this->model_incentive->get_hsl_incentive($id_event);
			$data['hslnm'] 		= $this->model_incentive->get_hsl_number_incentive($id_event);
			if($data['results']){
				$data['listprogram'] = $this->model_incentive->get_all_incentive_list();
				set_active_menu('Report Detail');
				init_view('user/content_report_update_detail_incentive', $data);
			}else{
				redirect(base_url('user/report'));
			}
		}else{
			redirect(base_url('user/report'));
		}
	}

	public function add_incentive(){
		$id_event 	= $this->input->post('id_event');
		$jmh 		= $this->input->post('jmh');

		for($i = 0; $jmh > $i; $i++){
			$user 		= $this->input->post('user'.$i.'');
			$peserta 	= $this->input->post('peserta'.$i.'');
			$bayar 		= $this->input->post('bayar'.$i.'');
			$closing 	= $this->input->post('closing'.$i.'');
			$programlain = $this->input->post('program_lain'.$i.'');
			$results 	= $this->model_incentive->add_incentive($id_event, $user, $peserta, $bayar, $closing, $programlain);
		}
		if($results) {
			flashdata('success', 'Berhasil menyimpan data.');
		}else{
			flashdata('error', 'Gagal mengubah data.');
		}
		redirect(base_url('user/incentive/report'));
	}

	public function add_row($id_event){
		$baris = $this->input->post('baris');
		redirect(base_url('user/incentive/report_detail/'.$id_event.'/'.md5($id_event).'?row='.$baris));
	}

	public function update_incentive(){
		$id_event 	= $this->input->post('id_event');
		$jmh 		= $this->input->post('jmh');
		for($i=0; $jmh > $i; $i++){
			$id_incentive 	= $this->input->post('id_incentive'.$i.'');
			$user 			= $this->input->post('user'.$i.'');
			$peserta 		= $this->input->post('peserta'.$i.'');
			$bayar 			= $this->input->post('bayar'.$i.'');
			$closing 		= $this->input->post('closing'.$i.'');
			$programlain 	= $this->input->post('program_lain'.$i.'');
			$results 		= $this->model_incentive->update_incentive($id_incentive, $user, $peserta, $bayar, $closing, $id_event, $programlain);
		}
		if($results) {
			flashdata('success', 'Berhasil menyimpan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('user/incentive/report_detail/'.$id_event.'/'.md5($id_event)));
	}

	public function del_list_incentive(){

		$id_incentive 		= $this->input->post('id_incentive');
		$id_event 			= $this->input->post('id_event');
		$results			= $this->model_incentive->del_list_incentive($id_incentive);
		$data['hslnm'] 		= $this->model_incentive->get_hsl_number_incentive($id_event);

		if($data['hslnm'] > 0){
			if($results){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
		}else{
			flashdata('error', 'Gagal mengubah data');
		}

		echo json_encode($results);
	}
	
}