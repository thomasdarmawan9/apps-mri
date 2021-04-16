<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class SignupApi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_signup');
	}

	public function api_get_list_event(){
		$post = json_decode(file_get_contents('php://input'), true);

		$data = $this->model_signup->get_list_event($post['iddivisi']);
		echo json_encode($data);
	}

	public function api_get_signup2(){
		$post = json_decode(file_get_contents('php://input'), true);
		$data['list_warrior'] 	= $this->model_signup->get_list_warrior();	
		$data['list_task'] 			= $this->model_signup->get_list_task();
		if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28') || ($post['id'] == 32) || ($post['id'] == '155')) {
			$mrlc 					= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
			$data['branch'] 		= $this->model_signup->get_branch_active();
			$data['waiting'] 		= $this->model_signup->get_data_waiting($mrlc);
			$data['class'] 			= $this->model_signup->get_class_active();
			// dd($mrlc);
		}else{
			$data['waiting'] 		= $this->model_signup->get_data_waiting($post['iddivisi']);
			$data['branch'] 		= "";
			$data['class'] 			= "";
		}
		
		echo json_encode($data);
	}

	public function search_data_by_phone(){
		$post = json_decode(file_get_contents('php://input'), true);

		$phone 		= secure($post['phone']);
		$isExist 	= $this->model_signup->get_data_participant_by_phone($phone);
		if(!$isExist){
			# jika bukan existing customer, maka cek apakah terdaftar di apps reseller
			$url = $this->config->item('reseller_url').'request/get_data_participant_active';
			$curl_response = curl_post_https($url, array('phone' => $phone));
			$extract = json_decode($curl_response);
			if(!$extract){
				$response['type'] 	= 'new';
			}else{
				# data reseller
				$event 		= $this->model_signup->get_data_event_by_name($extract->event);
				if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28') || ($post['id'] == 32) || ($post['id'] == '155')) {
					$iddivisi = $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
				}else{
					$iddivisi 	= $post['iddivisi'];
				}
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


	public function submit_form_student(){
		$this->load->model('model_student');
		$post = json_decode(file_get_contents('php://input'), true);

		// dd($post);
		// die();
		$participant['participant_name']	= $post['std_participant_name'];
		$participant['birthdate'] 			= $post['std_birthdate'];
		if(!empty($post['std_gender'])){
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
		if($event['is_hp_full_program'] == 1){
			# Jika pilih HP Full Program, maka melakukan insert data sebanyak data is_hp_full_program = 2
			$list_hp = $this->model_signup->get_list_hp_program();
			foreach($list_hp as $row){
				$transaction['participant_id'] 	= $participant_id;
				$transaction['event_id'] 		= $row['id'];
				$transaction['event_name'] 		= $row['name'];
				$transaction['event_commision'] = $post['std_event_commision'];
				if(!empty($post['std_family_discount'])){
					# harga family discount
					$transaction['event_price'] 	= $row['price_promo'] - $row['family_discount'];
					$transaction['paid_value']		= $row['price_promo'] - $row['family_discount'];
				}else{
					# harga promo
					$transaction['event_price'] 	= $row['price_promo'];
					$transaction['paid_value']		= $row['price_promo'];
				}
				$transaction['reseller_fee'] 	= $event['reseller_fee'];
				$transaction['signup_type'] 	= $post['std_signup_type'];
				$transaction['branch_id'] 		= $post['std_branch'];
				$transaction['class_id'] 		= $post['std_class'];
				$transaction['source'] 			= $post['std_source'];
				$transaction['payment_type'] 	= $post['std_payment_type'];
				$transaction['transfer_atas_nama'] = $post['std_atas_nama'];
				$transaction['edc_detail'] 		= $post['std_detail_edc'] . ' ' . $post['std_payment_source'] . $post['std_cicilan'];
				$transaction['paid_date']		= $post['std_paid_date'];
				$transaction['closing_type']	= $post['std_closing_type'];
				$transaction['class_modul'] 	= $post['modul_class'];
				$transaction['id_task'] 		= $post['std_id_task'];
				if($post['std_closing_type'] == 'Full Program'){
					$transaction['is_full_program'] 		= 1;
					$transaction['full_program_startdate']	= $post['full_program_startdate'];
					$transaction['full_program_enddate'] 	= date('Y-m-d H:i:s', strtotime('+2 years', strtotime($post['full_program_startdate'])));
				}else{
					$transaction['full_program_startdate']	= $post['full_program_startdate'];
					$month 									= 4 * $post['modul_class'];
					$transaction['full_program_enddate'] 	= date('Y-m-d H:i:s', strtotime('+'.$month.' months', strtotime($post['full_program_startdate'])));
				}
				$transaction['remark']			= $post['std_remark'];
				if(!empty($post['std_is_upgrade'])){
					$transaction['is_upgrade']	= 1;
				}
				$transaction['referral'] 		= $post['std_referral'];
				$transaction['sales_id'] 		= $post['std_id_user_closing'];
				if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28') || ($post['id'] == 32) || ($post['id'] == '155')) {
					$mrlc 							= $this->db->get_where('divisi', array('departement' => 'MRLC-1'))->row_array()['id'];
					$transaction['department_id'] 	= $mrlc;
				}else{
					$transaction['department_id'] 	= $post['iddivisi'];
				}
				$transaction['input_by']		= $post['id'];
				$transaction['timestamp'] 		= setNewDateTime();

				# melakukan pengecekan apakah data sudah tercatat di tabel rc_student
				$isStudent = $this->model_student->get_student_by_participant_program($participant_id, $transaction['event_id']);
				if($isStudent->num_rows() > 0 ){
					# jika ya, update data
					$student['branch_id'] 			= $transaction['branch_id'];
					$student['class_id'] 			= $transaction['class_id'];
					$student['program_type'] 		= strtolower($transaction['closing_type']);
					$student['end_date'] 			= $transaction['full_program_enddate'];
					$student['student_status'] 		= 'active';
					$this->model_student->update($student, $isStudent->row_array()['student_id']);
				}else{
					# jika tidak, insert data
					$student['participant_id'] 		= $participant_id;
					$student['program_id'] 			= $transaction['event_id'];
					$student['branch_id'] 			= $transaction['branch_id'];
					$student['class_id'] 			= $transaction['class_id'];
					$student['program_type'] 		= strtolower($transaction['closing_type']);
					$student['start_date'] 			= $transaction['full_program_startdate'];
					$student['end_date'] 			= $transaction['full_program_enddate'];
					$student['student_status'] 		= 'active';
					$this->model_student->insert($student);
				}

				$result = $this->model_signup->insert_transaction($transaction);	
			}
		}else{
			# Jika tidak
			$transaction['participant_id'] 	= $participant_id;
			$transaction['event_id'] 		= $post['std_event_name'];
			$transaction['event_name'] 		= $event['name'];
			$transaction['event_commision'] = $post['std_event_commision'];
			$transaction['event_price'] 	= $event['price'];
			$transaction['reseller_fee'] 	= $event['reseller_fee'];
			$transaction['signup_type'] 	= $post['std_signup_type'];
			$transaction['branch_id'] 		= $post['std_branch'];
			$transaction['class_id'] 		= $post['std_class'];
			$transaction['source'] 			= $post['std_source'];
			$transaction['payment_type'] 	= $post['std_payment_type'];
			$transaction['transfer_atas_nama'] = $post['std_atas_nama'];
			$transaction['edc_detail'] 		= $post['std_detail_edc'] . ' ' . $post['std_payment_source'] . $post['std_cicilan'];
			$transaction['paid_value']		= $post['std_paid_value'];
			$transaction['paid_date']		= $post['std_paid_date'];
			$transaction['closing_type']	= $post['std_closing_type'];
			$transaction['class_modul'] 	= $post['modul_class'];
			$transaction['id_task'] 		= $post['std_id_task'];
			if($post['std_closing_type'] == 'Full Program'){
				$transaction['is_full_program'] 		= 1;
				$transaction['full_program_startdate']	= $post['full_program_startdate'];
				$transaction['full_program_enddate'] 	= date('Y-m-d H:i:s', strtotime('+2 years', strtotime($post['full_program_startdate'])));
			}else{
				$transaction['full_program_startdate']	= $post['full_program_startdate'];
				$month 									= 4 * $post['modul_class'];
				$transaction['full_program_enddate'] 	= date('Y-m-d H:i:s', strtotime('+'.$month.' months', strtotime($post['full_program_startdate'])));
			}
			$transaction['remark']			= $post['std_remark'];
			if(!empty($post['std_is_upgrade'])){
				$transaction['is_upgrade']	= 1;
			}
			$transaction['referral'] 		= $post['std_referral'];
			$transaction['sales_id'] 		= $post['std_id_user_closing'];
			if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28') || ($post['id'] == 32) || ($post['id'] == '155')) {
				$mrlc 							= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
				$transaction['department_id'] 	= $mrlc;
			}else{
				$transaction['department_id'] 	= $post['iddivisi'];
			}
			$transaction['input_by']		= $post['id'];
			$transaction['timestamp'] 		= setNewDateTime();

			# melakukan pengecekan apakah data sudah tercatat di tabel rc_student
			$isStudent = $this->model_student->get_student_by_participant_program($participant_id, $transaction['event_id']);
			if($isStudent->num_rows() > 0 ){
				# jika ya, update data
				if(!empty($post['std_free_student'])){
					$student['special_status']	= 'Free';
				}
				$student['branch_id'] 			= $transaction['branch_id'];
				$student['class_id'] 			= $transaction['class_id'];
				$student['program_type'] 		= strtolower($transaction['closing_type']);
				$student['end_date'] 			= $transaction['full_program_enddate'];
				$student['student_status'] 		= 'active';
				$this->model_student->update($student, $isStudent->row_array()['student_id']);
			}else{
				# jika tidak, insert data
				if(!empty($post['std_free_student'])){
					$student['special_status']	= 'Free';
				}
				$student['participant_id'] 		= $participant_id;
				$student['program_id'] 			= $transaction['event_id'];
				$student['branch_id'] 			= $transaction['branch_id'];
				$student['class_id'] 			= $transaction['class_id'];
				$student['program_type'] 		= strtolower($transaction['closing_type']);
				$student['start_date'] 			= $transaction['full_program_startdate'];
				$student['end_date'] 			= $transaction['full_program_enddate'];
				$student['student_status'] 		= 'active';
				$this->model_student->insert($student);
			}

			$result = $this->model_signup->insert_transaction($transaction);
		}
		// echo json_encode($result);
		if(isset($result)){
			echo json_encode($result);
		}else{
			$this->db->error();
		}
		// redirect(base_url('user/signup'));
	}
		
	public function api_all(){
		$post = json_decode(file_get_contents('php://input'), true);

		$data['list_warrior'] 		= $this->model_signup->get_list_warrior();	
		$data['list_task'] 			= $this->model_signup->get_list_task_all();
		$data['branch'] 			= $this->model_signup->get_branch_active();
		$data['class'] 				= $this->model_signup->get_class_active();
		$data['filter'] 			= $post['filter'];
		if(!empty($post['filter'])){
			if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28') || ($post['id'] == 32) || ($post['id'] == '155')) {
				$mrlc 				= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
				$data['event'] 		= $this->model_signup->get_list_event($mrlc);
				$data['list']  		= $this->model_signup->get_data_signup_approved($mrlc, $post['filter']);
			}else{
				$data['event'] 		= $this->model_signup->get_list_event($this->session->userdata('iddivisi'));
				$data['list'] 		= $this->model_signup->get_data_signup_approved($this->session->userdata('iddivisi'), $post['filter']);
			}
		}else{
			if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28')) {
				$mrlc 				= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
				$data['event'] 		= $this->model_signup->get_list_event($mrlc);
			}else{
				$data['event'] 		= $this->model_signup->get_list_event($this->session->userdata('iddivisi'));
			}
			$data['list'] 			= array();			
		}

		echo json_encode($data);

	}

	public function json_get_batch_list(){
		$post = json_decode(file_get_contents('php://input'), true);

		$this->load->model('model_batch');
		$event 		= $post['event'];
		$response 	= $this->model_batch->get_list_batch($event);
		echo json_encode($response);
	}

	public function json_master_get_detail_transaction(){
		$post = json_decode(file_get_contents('php://input'), true);

		$id 	= secure($post['id']);
		$result = $this->model_signup->master_get_detail_transaction($id);
		echo json_encode($result);
	}

	// public function export_data_transaction(){
	// 	$post = json_decode(file_get_contents('php://input'), true);
	// 	// dd(column_letter(0));
	// 	if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28') || ($post['id'] == 32) || ($post['id'] == '155')) {
	// 		$divisi	= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
	// 	}else{
	// 		$divisi = $post['iddivisi'];
	// 	}
	// 	$signup		= $this->model_signup->export_data_signup_approved($divisi, $post['filter']);
	// 	$data['list_fields'] = $signup->list_fields();
	// 	$data['results'] = $signup->result();
	// 	// $filename 	= "Data_transaksi_".strtotime(setNewDateTime());
	// 	// exportToExcel($data, 'Sheet 1', $filename);
	// 	echo json_encode($data);
	// 	// return $data;
	// }

	public function export_data_transaction(){
		$post = json_decode(file_get_contents('php://input'), true);
		if ((strpos($post['divisi'], 'MRLC')  !== false) || ($post['id'] == '28') || ($post['id'] == 32) || ($post['id'] == '155')) {
					$divisi	= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
				}else{
					$divisi = $post['iddivisi'];
				}
		$signup		= $this->model_signup->export_data_signup_approved($divisi, $post['filter']);
		$data['list_fields'] = $signup->list_fields();
		$data['results'] = $signup->result();
		echo json_encode($data);
	}

	public function json_email_exist(){
		$post = json_decode(file_get_contents('php://input'), true);

		$isExist = $this->model_signup->is_email_exist($post['email']);
		echo json_encode($isExist);
	}

	public function get_data_participant(){
		$post = json_decode(file_get_contents('php://input'), true);

		$email 	= secure($post['email']);
		$result = $this->model_signup->get_data_participant_by_email($email);
		echo json_encode($result);
	}

	public function json_get_data_transaksi(){
		$post = json_decode(file_get_contents('php://input'), true);

		$id 		= $post['id'];
		$response 	= $this->model_signup->get_data_repayment_transaction($id);
		echo json_encode($response);
	}

	public function json_phone_exist(){
		$post = json_decode(file_get_contents('php://input'), true);

		$phone 		= $post['phone'];
		$response 	= $this->model_signup->get_data_participant_by_phone($phone);
		echo json_encode($response);
	}

	public function json_get_data_event(){
		$post = json_decode(file_get_contents('php://input'), true);

		$id 		= $post['event'];
		$response 	= $this->model_signup->get_data_event_by_id($id);
		echo json_encode($response);
	}

}