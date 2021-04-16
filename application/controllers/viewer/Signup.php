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
			if(!empty($level) && $level == 'viewer'){
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
		if(!empty($this->input->get())){
			if(!empty($this->input->get('event'))){
				$parameter['event_name'] = $this->input->get('event');
				$data['filter']['event_name'] = $parameter['event_name'];
			}else{
				$parameter['event_name'] = '';
			}

			if(!empty($this->input->get('sp'))){
				$parameter['id_task'] = $this->input->get('sp');
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
		init_view('viewer/content_signup_confirm', $data);
	}

	public function confirm_repayment(){
		$this->load->model('model_repayment');
		if(!empty($this->input->get())){
			if(!empty($this->input->get('event'))){
				$parameter['event_name'] = $this->input->get('event');
				$data['filter']['event'] = $parameter['event_name'];
			}else{
				$parameter['event_name'] = '';
			}
		}else{
			$parameter = array();
		}
		$data['event'] 				= $this->model_repayment->get_list_event2();
		$data['waiting'] 			= $this->model_repayment->get_data_list_repayment_waiting($parameter);
		set_active_menu('Confirm Repayment');
		init_view('viewer/content_signup_confirm_repayment', $data);
	}

	public function batch(){
		if(!empty($this->input->post('event'))){
			$data['filter']['event_name'] = $this->input->post('event');
		}else{
			$data['filter']['event_name'] = '';
		}
		$data['event'] 				= $this->model_signup->get_list_event_batch();
		$data['list'] 				= $this->model_batch->get_list_batch($data['filter']['event_name']);
		set_active_menu('Set Batch');
		init_view('viewer/content_signup_batch', $data);
	}

	public function batch_detail($batch_id){
		if(!empty($batch_id)){
			$data['detail'] 		= $this->model_batch->get_detail_batch($batch_id);
			$data['signup'] 		= $this->model_batch->get_data_peserta($batch_id);
			$data['peserta'] 		= $this->model_batch->get_data_peserta_batch($batch_id);
			set_active_menu('Set Batch');
			init_view('viewer/content_signup_batch_detail', $data);
		}else{
			redirect(base_url('viewer/signup/batch'));
		}
	}

	public function master(){
		$data['event'] 				= $this->model_signup->get_list_event();
		$data['list_task']			= $this->model_signup->get_list_task_all();
		$data['list_warrior'] 		= $this->model_signup->get_list_warrior();
		$data['branch'] 			= $this->model_signup->get_branch_active();
		$data['class'] 				= $this->model_signup->get_class_active();
		if(!empty($this->input->get())){
			$data['list'] 			= $this->model_signup->get_data_master_trx($this->input->get());
		}else{
			$data['list'] 			= array();			
		}
		set_active_menu('Master Data Transaksi');
		init_view('viewer/content_signup_master_trx', $data);
	}

	public function master_participant(){
		if(!empty($this->input->get())){
			$data['list'] 			= $this->model_signup->get_data_master_participant($this->input->get())->result_array();
		}else{
			$data['list'] 			= array();			
		}
		set_active_menu('Master Data Peserta');
		init_view('viewer/content_signup_master_participant', $data);
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

	public function json_master_get_detail_transaction(){
		$id 	= secure($this->input->post('id'));
		$result = $this->model_signup->master_get_detail_transaction($id);
		echo json_encode($result);
	}
}