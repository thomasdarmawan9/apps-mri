<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Signup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_signup');
		$this->load->model('model_batch');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && $level == 'finance'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		
	}

	public function confirm(){
		if(!empty($this->input->post())){
			if(!empty($this->input->post('event'))){
				$parameter['event_name'] = $this->input->post('event');
				$data['filter']['event_name'] = $parameter['event_name'];
			}else{
				$parameter['event_name'] = '';
			}

			if(!empty($this->input->post('warrior'))){
				$parameter['id_user_closing'] = $this->input->post('warrior');
				$data['filter']['id_user'] = $parameter['id_user_closing'];
			}else{
				$parameter['id_user_closing'] = '';
			}

			if(!empty($this->input->post('sp'))){
				$parameter['id_task'] = $this->input->post('sp');
				$data['filter']['id_task'] = $parameter['id_task'];
			}else{
				$parameter['id_task'] = '';
			}
		}else{
			$parameter = array();
		}
		$data['event'] 				= $this->model_signup->get_list_event();
		$data['list_warrior'] 		= $this->model_signup->get_list_warrior();	
		$data['list_task'] 			= $this->model_signup->get_list_task();
		$data['waiting'] 			= $this->model_signup->get_data_signup_confirm($parameter);
		$data['list_signup_type']	= array('sp', 'tele', 'other');
		$data['list_closing_type'] 	= array('dp', 'lunas');
		$data['list_source'] 		= array('facebook Ads', 'other');
		set_active_menu('Confirm Signup');
		init_view('finance/content_signup_confirm', $data);
	}

	public function batch(){
		if(!empty($this->input->post('event'))){
			$data['filter']['event_name'] = $this->input->post('event');
		}else{
			$data['filter']['event_name'] = '';
		}
		$data['event'] 				= $this->model_signup->get_list_event();
		$data['list'] 				= $this->model_batch->get_list_batch($data['filter']['event_name']);
		set_active_menu('Set Batch');
		init_view('finance/content_signup_batch', $data);
	}

	public function batch_detail($batch_id){
		if(!empty($batch_id)){
			$data['detail'] 		= $this->model_batch->get_detail_batch($batch_id);
			$data['signup'] 		= $this->model_batch->get_data_peserta($batch_id);
			$data['peserta'] 		= $this->model_batch->get_data_peserta_batch($batch_id);
			set_active_menu('Set Batch');
			init_view('finance/content_signup_batch_detail', $data);
		}else{
			redirect(base_url('finance/signup/batch'));
		}
	}

	public function master(){
		$data['event'] 				= $this->model_signup->get_list_event();
		$data['list_task']			= $this->model_signup->get_list_task_all();
		$data['list_warrior'] 		= $this->model_signup->get_list_warrior();
		if(!empty($this->input->get())){
			$data['list'] 			= $this->model_signup->get_data_master_trx($this->input->get());
		}else{
			$data['list'] 			= array();			
		}
		set_active_menu('Master Data Transaksi');
		init_view('finance/content_signup_master_trx', $data);
	}

	public function master_participant(){
		if(!empty($this->input->get())){
			$data['list'] 			= $this->model_signup->get_data_master_participant($this->input->get())->result_array();
		}else{
			$data['list'] 			= array();			
		}
		// dd($data);
		set_active_menu('Master Data Peserta');
		init_view('finance/content_signup_master_participant', $data);
	}

	public function submit_form(){
		$post = $this->input->post();
		if(!empty($post['batch_id'])){
			# update statement
			$id = $post['batch_id'];
			unset($post['batch_id']);
			$result = $this->model_batch->update($post, $id);
			if($result){
				flashdata('success', 'Berhasil mengubah data');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
		}else{
			# insert statement
			$result = $this->model_batch->insert($post);
			if($result){
				flashdata('success', 'Berhasil menambahkan data');
			}else{
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('finance/signup/batch'));
	}

	public function add_to_batch(){
		$batch_id = $this->input->post('batch_id');
		if(!empty($this->input->post('transaction_id'))){
			$participant = $this->input->post('transaction_id');

			foreach($participant as $row){
				$result = $this->model_signup->update(array('batch_id' => $batch_id), $row);
			}

			if($result){
				flashdata('success', 'Berhasil menambahkan data peserta.');
			}else{
				flashdata('error', 'Gagal mengubah data');
			}
		}
		
		redirect(base_url('finance/signup/batch_detail/'.$batch_id));
	}
	
	public function approve(){
		$id 		= $this->input->post('id');
		$data 		= array('is_paid' => 1, 'id_user_approve' => $this->session->userdata('id'));
		$detail 	= $this->model_signup->get_detail_signup_by($id);
		$response 	= $this->model_signup->update($data, $id);
		if($response){
			$url = 'https://merryriana.com/reseller/request/set_affiliate_is_approve';
			$response = curl_post($url, array('id' => $detail['id_affiliate']));
			flashdata('success', 'Berhasil melakukan approval');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function export_batch($batch_id){
		$detail		= $this->model_batch->get_detail_batch($batch_id);
		$filename 	= str_replace(' ', '', $detail['event_name']).'_'.str_replace(' ', '', $detail['batch_label']);
		$data 		= $this->model_batch->get_data_export_batch($batch_id); 
		exportToExcel($data, 'Sheet 1', $filename);
	}

	public function export_data_trx(){
		$data		= $this->model_signup->export_data_master_trx($this->input->get());
		$filename 	= "Master_data_transaksi_".strtotime(setNewDateTime());
		exportToExcel($data, 'Sheet 1', $filename);
	}

	public function export_data_participant(){
		$data		= $this->model_signup->get_data_master_participant($this->input->get());
		$filename 	= "Master_data_peserta_".strtotime(setNewDateTime());
		exportToExcel($data, 'Sheet 1', $filename);
	}

	public function json_get_batch_detail(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_batch->get_detail_batch($id);
		echo json_encode($response);
	}

	public function json_remove_participant(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_batch->remove_participant($id);
		if($response){
			flashdata('success', 'Berhasil membatalkan data peserta.');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function json_get_batch_list(){
		$event 		= $this->input->post('event');
		$response 	= $this->model_batch->get_list_batch($event);
		echo json_encode($response);
	}

	public function json_get_data_transaksi(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_signup->get_detail_signup_by($id);
		echo json_encode($response);
	}

	public function update_paidoff_transaction(){
		$post 					= $this->input->post();
		$post['closing_type'] 	= 'lunas';
		$transaction_id 		= $post['transaction_id'];
		unset($post['transaction_id']);
		$response = $this->model_signup->update($post, $transaction_id);
		if($response){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function update_participant(){
		$post = $this->input->post();
		$update = array(
						'participant_name' 	=> $post['participant_name'],
						'birthdate' 		=> $post['birthdate'],
						'gender'   			=> $post['gender'],
						'phone'   			=> $post['phone'],
						'email'   			=> $post['email'],
						'address' 			=> $post['address'],
						'school' 			=> $post['school'],
						'is_vegetarian' 	=> (!empty($post['is_vegetarian']))? 1 : 0,
						'is_allergy' 		=> (!empty($post['is_allergy']))? 1 : 0,
						'dad_name' 			=> $post['dad_name'],
						'dad_phone' 		=> $post['dad_phone'],
						'dad_email' 		=> $post['dad_email'],
						'dad_job' 			=> $post['dad_job'],
						'mom_name' 			=> $post['mom_name'],
						'mom_phone' 		=> $post['mom_phone'],
						'mom_email' 		=> $post['mom_email'],
						'mom_job' 			=> $post['mom_job'],
						);
		$response = $this->model_signup->update_participant($update, $post['participant_id']);
		if($response){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}

		redirect(base_url('finance/signup/master_participant?'.$post['redirect']));
	}

	public function json_participant_get_transaction(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_signup->get_participant_transaction($id);
		echo json_encode($response);
	}

	public function json_get_data_participant_by_id(){
		$id 	= secure($this->input->post('id'));
		$result = $this->model_signup->get_data_participant_by_id($id);
		echo json_encode($result);
	}
}