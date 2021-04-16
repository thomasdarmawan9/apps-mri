<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Signup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_signup');
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
		$data['event'] 				= $this->model_signup->get_list_event($this->session->userdata('iddivisi'));
		$data['list_warrior'] 		= $this->model_signup->get_list_warrior();	
		$data['list_task'] 			= $this->model_signup->get_list_task();
		if(strpos($this->session->userdata('divisi'), 'MRLC') !== false){
			$mrlc 					= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
			$data['waiting'] 		= $this->model_signup->get_data_waiting($mrlc);
		}else{
			$data['waiting'] 		= $this->model_signup->get_data_waiting($this->session->userdata('iddivisi'));
		}
		$data['list_signup_type']	= array('SP', 'PTM', 'Others');
		$data['list_closing_type'] 	= array('DP', 'Lunas');
		$data['list_closing_class'] = array('Modul', 'Full Program');
		$data['list_source'] 		= array('Facebook Ads', 'Email Blast', 'Referral', 'Others');
		$data['list_payment_type'] 	= array('EDC', 'Transfer', 'Cash', 'Others');
		set_active_menu('Add Signup');
		init_view('user/content_signup_add', $data);
	}

	public function submit_data_referral(){
		$post = $this->input->post();
		$timestamp = setNewDateTime();
		$isExist = $this->model_signup->is_email_exist($post['email']);
		if(empty($post['gender'])){
			$post['gender'] = '-';
		}
		if(!$isExist){
			$participant = array(
							'participant_name' 	=> $post['participant_name'],
							'birthdate' 		=> $post['birthdate'],
							'gender' 			=> $post['gender'],
							'phone' 			=> $post['phone'],
							'email' 			=> $post['email'],
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
							'date_created' 		=> $timestamp
							); 
			$insert_id = $this->model_signup->insert_participant($participant);
			$detail_event = $this->model_signup->get_detail_event($post['event_name']);
			
			if($post['signup_type'] == 'sp'){
				$incentive = array(
							'id_task' 			=> $post['id_task'],
							'id_user' 			=> $post['id_user_closing'],
							'peserta' 			=> $post['participant_name'],
							'total' 			=> $post['paid_value'],
							'jenis_lunas' 		=> $post['closing_type'],
							'tgl_proses' 		=> date('Y-m-d'),
							'program_lain'		=> $post['event_name'],
							'komisi_program_lain' => ($post['closing_type'] == 'lunas')? $detail_event['lunas'] : $detail_event['dp'] 
							);

				$insert_incentive = $this->model_signup->insert_incentive($incentive);
			}

			$transaction = array(
							'participant_id' 	=> $insert_id,
							'event_name' 		=> $post['event_name'],
							'event_commision' 	=> $detail_event['lunas'],
							'event_price' 		=> $detail_event['price'],
							'signup_type' 		=> $post['signup_type'],
							'source' 			=> 'referral',
							'paid_value' 		=> $post['paid_value'],
							'paid_date' 		=> $post['paid_date'],
							'closing_type' 		=> $post['closing_type'],
							'remark' 			=> $post['remark'],
							'is_paid' 			=> 0,
							'is_attend' 		=> 0,
							'batch_id' 			=> 0,
							'id_task' 			=> $post['id_task'],
							'referral' 			=> $post['ref_username'],
							'id_affiliate' 		=> $post['id_affiliate'],
							'id_user_closing' 	=> $post['id_user_closing'],
							'id_user_input' 	=> $this->session->userdata('id'),
							'id_user_approve' 	=> '',
							'timestamp' 		=> $timestamp
							);
			$insert_transaction = $this->model_signup->insert_transaction($transaction);
			if($insert_transaction){
				$url = $this->config->item('reseller_url').'request/set_affiliate_is_paid';
				$response = curl_post($url, array('id' => $post['id_affiliate']));
				flashdata('success', 'Berhasil menambahkan data.');
			}else{
				flashdata('error', 'Gagal menambahkan data.');
			}

		}else{
			flashdata('error', 'Maaf, data peserta sudah ada di database');
		}

		redirect(base_url('user/signup/'));
	}

	public function submit_data_reattendance(){
		$post = $this->input->post();
		$participant = array(
						'birthdate' 		=> $post['birthdate'],
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
		$update_participant = $this->model_signup->update_participant($participant, $post['participant_id']);
		$detail_event = $this->model_signup->get_detail_event($post['event_name']);
		if($post['signup_type'] == 'sp'){
			$incentive = array(
						'id_task' 			=> $post['id_task'],
						'id_user' 			=> $post['id_user_closing'],
						'peserta' 			=> $post['participant_name'],
						'total' 			=> $post['paid_value'],
						'jenis_lunas' 		=> $post['closing_type'],
						'tgl_proses' 		=> date('Y-m-d'),
						'program_lain'		=> $post['event_name'],
						'komisi_program_lain' => ($post['closing_type'] == 'lunas')? $detail_event['lunas'] : $detail_event['dp'] 
						);

			$insert_incentive = $this->model_signup->insert_incentive($incentive);
		}
		$transaction = array(
						'participant_id' 	=> $post['participant_id'],
						'event_name' 		=> $post['event_name'],
						'event_commision' 	=> $detail_event['lunas'],
						'event_price' 		=> $detail_event['price'],
						'signup_type' 		=> $post['signup_type'],
						'source' 			=> $post['source'],
						'paid_value' 		=> $post['paid_value'],
						'paid_date' 		=> $post['paid_date'],
						'closing_type' 		=> $post['closing_type'],
						'remark' 			=> $post['remark'],
						'is_paid' 			=> 0,
						'is_attend' 		=> 0,
						'batch_id' 			=> 0,
						'id_task' 			=> $post['id_task'],
						'referral' 			=> '',
						'id_affiliate' 		=> '',
						'id_user_closing' 	=> $post['id_user_closing'],
						'id_user_input' 	=> $this->session->userdata('id'),
						'id_user_approve' 	=> '',
						'timestamp' 		=> setNewDateTime()
						);
		$insert_transaction = $this->model_signup->insert_transaction($transaction);
		if($insert_transaction){
			flashdata('success', 'Berhasil menambahkan data.');
		}else{
			flashdata('error', 'Gagal menambahkan data.');
		}
		redirect(base_url('user/signup/'));
	}

		
	public function all(){

		$data['list_warrior'] 		= $this->model_signup->get_list_warrior();	
		$data['list_task'] 			= $this->model_signup->get_list_task_all();
		$data['filter'] 			= $this->input->get();
		if(!empty($this->input->get())){
			if(strpos($this->session->userdata('divisi'), 'MRLC') !== false){
				$mrlc 				= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
				$data['event'] 		= $this->model_signup->get_list_event($mrlc);
				$data['list']  		= $this->model_signup->get_data_signup_approved($mrlc, $this->input->get());
			}else{
				$data['event'] 		= $this->model_signup->get_list_event($this->session->userdata('iddivisi'));
				$data['list'] 		= $this->model_signup->get_data_signup_approved($this->session->userdata('iddivisi'), $this->input->get());
			}
		}else{
			if(strpos($this->session->userdata('divisi'), 'MRLC') !== false){
				$mrlc 				= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
				$data['event'] 		= $this->model_signup->get_list_event($mrlc);
			}else{
				$data['event'] 		= $this->model_signup->get_list_event($this->session->userdata('iddivisi'));
			}
			$data['list'] 			= array();			
		}
		// $data['list'] = $this->model_signup->get_data_signup_approved($this->session->userdata('id'), $parameter);
		set_active_menu('List Signup');
		init_view('user/content_signup_list',$data);
	}

	public function delete(){
		$id = $this->input->post('id');
		$result = $this->model_signup->delete_transaction($id);
		if($result){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal menghapus data');
		}
		echo json_encode($result);
	}

	public function export_data_transaction(){
		// dd(column_letter(0));
		$data		= $this->model_signup->export_data_signup_approved($this->session->userdata('iddivisi'), $this->input->get());
		$filename 	= "Data_transaksi_".strtotime(setNewDateTime());
		exportToExcel($data, 'Sheet 1', $filename);
	}

	public function json_email_exist(){
		$isExist = $this->model_signup->is_email_exist($this->input->post('email'));
		echo json_encode($isExist);
	}

	public function get_data_participant(){
		$email 	= secure($this->input->post('email'));
		$result = $this->model_signup->get_data_participant_by_email($email);
		echo json_encode($result);
	}

	public function json_get_data_transaksi(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_signup->get_data_repayment_transaction($id);
		echo json_encode($response);
	}

	public function json_phone_exist(){
		$phone 		= $this->input->post('phone');
		$response 	= $this->model_signup->get_data_participant_by_phone($phone);
		echo json_encode($response);
	}

	public function json_get_data_event(){
		$id 		= $this->input->post('event');
		$response 	= $this->model_signup->get_data_event_by_id($id);
		echo json_encode($response);
	}

	public function search_data_by_phone(){
		$phone 		= secure($this->input->post('phone'));
		$isExist 	= $this->model_signup->get_data_participant_by_phone($phone);
		if(!$isExist){
			# jika bukan existing customer, maka cek apakah terdaftar di apps reseller
			$url = $this->config->item('reseller_url').'request/get_data_participant_active';
			$curl_response = curl_post($url, array('phone' => $phone));
			$extract = json_decode($curl_response);
			if(!$extract){
				$response['type'] 	= 'new';
			}else{
				# data reseller
				$event 		= $this->model_signup->get_data_event_by_name($extract->event);
				$iddivisi 	= $this->session->userdata('iddivisi');
				if($iddivisi == $event['department_id']){
					# jika eventnya sesuai dengan divisi/ department spv
					$response['type'] = 'reseller';
					$response['data'] = (array) $extract;
					$response['data']['id_event'] = $event['id'];
				}else{
					# jika eventnya tidak sesuai dengan divisi/ department spv
					$response['type'] 		= 'new';
				}
			}
		}else{
			# existing customer
			$response['type'] = 'exist';
			$response['data'] = $isExist;
		}
		echo json_encode($response);
	}

	public function submit_form_participant(){
		$post = $this->input->post();
		if(empty($post['gender'])){
			$post['gender'] = '-';
		}
		$participant['participant_name']	= $post['participant_name'];
		$participant['birthdate'] 			= $post['birthdate'];
		$participant['gender'] 				= $post['gender'];
		$participant['phone'] 				= $post['phone'];
		$participant['email'] 				= $post['email'];
		$participant['address'] 			= $post['address'];
		$participant['school'] 				= $post['school'];
		$participant['date_created'] 		= setNewDateTime();
		if(!empty($post['dad_id'])){
			# jika data ayah tersedia di database
			$participant['dad_id'] 			= $post['dad_id'];		
		}else if(!empty($post['dad_phone'])){
			# data baru ayah
			$dad['participant_name']		= $post['dad_name'];
			$dad['email'] 					= $post['dad_email'];
			$dad['phone'] 					= $post['dad_phone'];
			$dad['job'] 					= $post['dad_job'];
			$dad['gender'] 					= 'L';
			$dad['date_created']			= setNewDateTime();
			$participant['dad_id'] 			= $this->model_signup->insert_participant($dad);
		}else{
			$participant['dad_id'] 			= "";
		}

		if(!empty($post['mom_id'])){
			# jika data ibu tersedia di database
			$participant['mom_id'] 			= $post['mom_id'];		
		}else if(!empty($post['mom_phone'])){
			# data baru ibu
			$mom['participant_name']		= $post['mom_name'];
			$mom['email'] 					= $post['mom_email'];
			$mom['phone'] 					= $post['mom_phone'];
			$mom['job'] 					= $post['mom_job'];
			$mom['gender'] 					= 'P';
			$mom['date_created']			= setNewDateTime();
			$participant['mom_id'] 			= $this->model_signup->insert_participant($mom);
		}else{
			$participant['mom_id'] 			= "";
		}


		if(!empty($post['participant_id'])){
			# jika data existing customer
			$participant_id 				= $post['participant_id'];
			$result 						= $this->model_signup->update_participant($participant, $participant_id);
		}else if(!empty($post['affiliate_id'])){
			# jika data reseller
			$participant_id 				= $this->model_signup->insert_participant($participant);
			$transaction['id_affiliate'] 	= $post['affiliate_id'];
		}else{
			# jika data baru
			$participant_id 				= $this->model_signup->insert_participant($participant);
		}
		
		$event 							= $this->model_signup->get_data_event_by_id($post['event_name']);
		$transaction['participant_id'] 	= $participant_id;
		$transaction['event_id'] 		= $post['event_name'];
		$transaction['event_name'] 		= $event['name'];
		$transaction['event_commision'] = $post['event_commision'];
		$transaction['event_price'] 	= $event['price'];
		$transaction['reseller_fee'] 	= $event['reseller_fee'];
		$transaction['signup_type'] 	= $post['signup_type'];
		$transaction['source'] 			= $post['source'];
		$transaction['payment_type'] 	= $post['payment_type'];
		$transaction['transfer_atas_nama'] = $post['atas_nama'];
		$transaction['paid_value']		= $post['paid_value'];
		$transaction['paid_date']		= $post['paid_date'];
		$transaction['closing_type']	= $post['closing_type'];
		$transaction['remark']			= $post['remark'];
		if(!empty($post['is_reattendance'])){
			$transaction['is_reattendance']	= 1;
		}
		$transaction['referral'] 		= $post['referral'];
		$transaction['sales_id'] 		= $post['id_user_closing'];
		$transaction['id_task'] 		= $post['id_task'];
		$transaction['department_id'] 	= $this->session->userdata('iddivisi');
		$transaction['input_by']		= $this->session->userdata('id');
		$transaction['timestamp'] 		= setNewDateTime();

		$result = $this->model_signup->insert_transaction($transaction);
		if($result){
			flashdata('success', 'Berhasil menambahkan data.');
		}else{
			flashdata('error', 'Gagal menambahkan data.');
		}
		redirect(base_url('user/signup'));
	}

	public function submit_form_student(){
		$post = $this->input->post();
		// dd($post);
		$participant['participant_name']	= $post['std_participant_name'];
		$participant['birthdate'] 			= $post['std_birthdate'];
		if($empty($post['std_gender'])){
			$participant['gender'] 			= $post['std_gender'];
		}else{
			$participant['gender'] 			= '-';
		}
		$participant['phone'] 				= $post['std_phone'];
		$participant['email'] 				= $post['std_email'];
		$participant['address'] 			= $post['std_address'];
		$participant['school'] 				= $post['std_school'];
		$participant['date_created'] 		= setNewDateTime();
		
		if(!empty($post['std_is_vegetarian'])){
			$participant['is_vegetarian'] 	= $post['std_is_vegetarian'];
		}else{
			$participant['is_vegetarian'] 	= 0;
		}

		if(!empty($post['std_is_allergy'])){
			$participant['is_allergy'] 	= $post['std_is_allergy'];
		}else{
			$participant['is_allergy'] 	= 0;
		}

		if(!empty($post['std_dad_id'])){
			# jika data ayah tersedia di database
			$participant['dad_id'] 			= $post['std_dad_id'];		
		}else if(!empty($post['std_dad_phone'])){
			# data baru ayah
			$dad['participant_name']		= $post['std_dad_name'];
			$dad['email'] 					= $post['std_dad_email'];
			$dad['phone'] 					= $post['std_dad_phone'];
			$dad['job'] 					= $post['std_dad_job'];
			$dad['gender'] 					= 'L';
			$dad['date_created']			= setNewDateTime();
			$participant['dad_id'] 			= $this->model_signup->insert_participant($dad);
		}else{
			$participant['dad_id'] 			= "";
		}

		if(!empty($post['std_mom_id'])){
			# jika data ibu tersedia di database
			$participant['mom_id'] 			= $post['std_mom_id'];		
		}else if(!empty($post['std_mom_phone'])){
			# data baru ibu
			$mom['participant_name']		= $post['std_mom_name'];
			$mom['email'] 					= $post['std_mom_email'];
			$mom['phone'] 					= $post['std_mom_phone'];
			$mom['job'] 					= $post['std_mom_job'];
			$mom['gender'] 					= 'P';
			$mom['date_created']			= setNewDateTime();
			$participant['mom_id'] 			= $this->model_signup->insert_participant($mom);
		}else{
			$participant['mom_id'] 			= "";
		}


		if(!empty($post['participant_id_std'])){
			# jika data existing customer
			$participant_id 				= $post['participant_id_std'];
			$result 						= $this->model_signup->update_participant($participant, $participant_id);
		}else if(!empty($post['affiliate_id'])){
			# jika data reseller
			$participant_id 				= $this->model_signup->insert_participant($participant);
		}else{
			# jika data baru
			$participant_id 				= $this->model_signup->insert_participant($participant);
		}
		
		$event 							= $this->model_signup->get_data_event_by_id($post['std_event_name']);
		$transaction['participant_id'] 	= $participant_id;
		$transaction['event_id'] 		= $post['std_event_name'];
		$transaction['event_name'] 		= $event['name'];
		$transaction['event_commision'] = $post['std_event_commision'];
		$transaction['event_price'] 	= $event['price'];
		$transaction['reseller_fee'] 	= $event['reseller_fee'];
		$transaction['signup_type'] 	= $post['std_signup_type'];
		$transaction['source'] 			= $post['std_source'];
		$transaction['payment_type'] 	= $post['std_payment_type'];
		$transaction['transfer_atas_nama'] = $post['std_atas_nama'];
		$transaction['paid_value']		= $post['std_paid_value'];
		$transaction['paid_date']		= $post['std_paid_date'];
		$transaction['closing_type']	= $post['std_closing_type'];
		$transaction['class_modul'] 	= $post['modul_class'];
		$transaction['id_task'] 		= $post['std_id_task'];
		if($post['std_closing_type'] == 'Full Program'){
			$transaction['is_full_program'] 		= 1;
			$transaction['full_program_startdate']	= $post['full_program_startdate'];
			$transaction['full_program_enddate'] 	= date('Y-m-d H:i:s', strtotime('+2 years', strtotime($post['full_program_startdate'])));
		}
		$transaction['remark']			= $post['std_remark'];
		if(!empty($post['std_is_upgrade'])){
			$transaction['is_upgrade']	= 1;
		}
		$transaction['referral'] 		= $post['std_referral'];
		$transaction['sales_id'] 		= $post['std_id_user_closing'];
		$transaction['department_id'] 	= $this->session->userdata('iddivisi');
		$transaction['input_by']		= $this->session->userdata('id');
		$transaction['timestamp'] 		= setNewDateTime();

		$result = $this->model_signup->insert_transaction($transaction);
		if($result){
			flashdata('success', 'Berhasil menambahkan data.');
		}else{
			flashdata('error', 'Gagal menambahkan data.');
		}
		redirect(base_url('user/signup'));
	}
	

	public function add_repayment(){
		$this->load->model('model_repayment');
		$data['list'] 			= $this->model_repayment->get_data_list_dp($this->session->userdata('iddivisi'));
		$data['repayment'] 		= $this->model_repayment->get_data_list_repayment($this->session->userdata('iddivisi'));
		$data['list_payment_type'] 	= array('EDC', 'Transfer', 'Cash', 'Others');
		set_active_menu('Add Repayment');
		init_view('user/content_signup_repayment', $data);
	}

	public function submit_repayment(){
		$this->load->model('model_repayment');
		$post 					= $this->input->post();
		$data 					= $this->model_repayment->get_data_transaction($post['transaction_id']);
		$post['dp'] 			= $data['paid_value'];
		$post['timestamp'] 		= setNewDateTime();
		$post['input_by'] 		= $this->session->userdata('id');
		$response = $this->model_repayment->insert($post);
		if($response){
			$this->model_signup->update(array('is_repayment_update' => 1), $post['transaction_id']);
			flashdata('success', 'Berhasil memasukkan data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function json_master_get_detail_transaction(){
		$id 	= secure($this->input->post('id'));
		$result = $this->model_signup->master_get_detail_transaction($id);
		echo json_encode($result);
	}

	public function json_get_batch_list(){
		$this->load->model('model_batch');
		$event 		= $this->input->post('event');
		$response 	= $this->model_batch->get_list_batch($event);
		echo json_encode($response);
	}
	
}