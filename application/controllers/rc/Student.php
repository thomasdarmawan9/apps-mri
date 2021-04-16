<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Student extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_branch');
		$this->load->model('model_periode');
		$this->load->model('model_classroom');
		$this->load->model('model_absensi');
		$this->load->model('model_student');
		$this->load->model('model_signup');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && (strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128'))){
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

	public function manage(){
		if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
			# as supervisor
			$data['periode'] 		= $this->model_periode->get_active_periode();
			$data['list_branch'] 	= $this->model_branch->get_active_branch();
			$data['school'] 		= $this->model_periode->get_program();
			$data['class'] 			= $this->model_classroom->get_active_class();
			$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
			$data['type'] 			= array("modul", "full program");
			$data['special'] 		= array("None", "Special Case", "Free");
			$data['tab'] 			= 'regular';

			$data['list_warrior'] 		= $this->model_signup->get_list_warrior();
			$data['list_signup_type']	= array('SP', 'PTM', 'Others');
			$data['list_closing_class'] = array('modul', 'full program');
			$data['list_source'] 		= array('Facebook Ads', 'WI/CI', 'Email Blast', 'Referral', 'Others');
			$data['list_payment_type'] 	= array('EDC', 'Transfer', 'Cash', 'Others');
			if(!empty($this->input->get())){
				if($this->input->get('periode') != 'all'){
					$periode			= $this->model_periode->get_data($this->input->get('periode'));
				}else{
					$periode['periode_start_date'] = '';
					$periode['periode_end_date'] = '';
				}
				$data['list'] 		= $this->model_student->get_filtered_student($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'regular');
			}else{
				$data['list'] 		= array();
			}
			set_active_menu('student');
			init_view('rc/student_manage_spv', $data);
		}else{
			# as trainer
			$data['periode'] 		= $this->model_periode->get_active_periode();
			$data['school'] 		= $this->model_periode->get_program();
			$data['class'] 			= $this->model_classroom->get_active_class();
			$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
			$data['type'] 			= array("modul", "full program");
			$data['tab'] 			= 'regular';
			if(!empty($this->input->get())){
				if($this->input->get('periode') != 'all'){
					$periode			= $this->model_periode->get_data($this->input->get('periode'));
				}else{
					$periode['periode_start_date'] = '';
					$periode['periode_end_date'] = '';
				}
				$data['list'] 		= $this->model_student->get_filtered_student($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'regular');
			}else{
				$data['list'] 		= array();
			}
			set_active_menu('student');
			init_view('rc/student_manage', $data);
		}
	}

	public function manage_adult(){
		if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
			# as supervisor
			$data['periode'] 		= $this->model_periode->get_active_periode_adult();
			$data['list_branch'] 	= $this->model_branch->get_active_branch();
			$data['school'] 		= $this->model_periode->get_program_adult();
			$data['class'] 			= $this->model_classroom->get_active_class_adult();
			$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
			$data['type'] 			= array("modul", "full program");
			$data['special'] 		= array("None", "Special Case", "Free");
			$data['tab'] 			= 'adult';

			$data['list_warrior'] 		= $this->model_signup->get_list_warrior();
			$data['list_signup_type']	= array('SP', 'PTM', 'Others');
			$data['list_closing_class'] = array('modul', 'full program');
			$data['list_source'] 		= array('Facebook Ads', 'WI/CI', 'Email Blast', 'Referral', 'Others');
			$data['list_payment_type'] 	= array('EDC', 'Transfer', 'Cash', 'Others');
			if(!empty($this->input->get())){
				if($this->input->get('periode') != 'all'){
					$periode			= $this->model_periode->get_data($this->input->get('periode'));
				}else{
					$periode['periode_start_date'] = '';
					$periode['periode_end_date'] = '';
				}
				$data['list'] 		= $this->model_student->get_filtered_student($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'adult');
			}else{
				$data['list'] 		= array();
			}
			set_active_menu('student');
			init_view('rc/student_manage_adult_spv', $data);
		}else{
			# as trainer
			$data['periode'] 		= $this->model_periode->get_active_periode_adult();
			$data['school'] 		= $this->model_periode->get_program_adult();
			$data['class'] 			= $this->model_classroom->get_active_class_adult();
			$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
			$data['type'] 			= array("modul", "full program");
			$data['tab'] 			= 'adult';
			if(!empty($this->input->get())){
				if($this->input->get('periode') != 'all'){
					$periode			= $this->model_periode->get_data($this->input->get('periode'));
				}else{
					$periode['periode_start_date'] = '';
					$periode['periode_end_date'] = '';
				}
				$data['list'] 		= $this->model_student->get_filtered_student($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'adult');
			}else{
				$data['list'] 		= array();
			}
			set_active_menu('student');
			init_view('rc/student_manage_adult', $data);
		}
	}

	public function submission(){
		if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || ($this->session->userdata('id') == '32') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || ($this->session->userdata('id') == '128')){
			# as supervisor
			$data['list'] = $this->model_student->get_data_submission_waiting();
			set_active_menu('submission');
			init_view('rc/student_submission_spv', $data);
		}else{
			# as trainer
			$data['list'] = $this->model_student->get_data_submission($this->session->userdata('id'));
			set_active_menu('submission');
			init_view('rc/student_submission', $data);
		}
	}

	public function submission_add(){
		$data['periode'] 		= $this->model_periode->get_active_periode();
		$data['branch'] 		= $this->model_branch->get_branch_trainer($this->session->userdata('id'));
		$data['list_branch'] 	= $this->model_branch->get_active_branch();
		$data['school'] 		= $this->model_periode->get_program();
		$data['class'] 			= $this->model_classroom->get_active_class();
		if(!empty($this->input->get())){
			if($this->input->get('periode') != ''){
				$periode 			= $this->model_periode->get_data($this->input->get('periode'));
				// dd($periode);
				$data['list'] 		= $this->model_student->get_student_list($periode['periode_start_date'], $periode['periode_end_date'], $this->input->get('branch'), $this->input->get('school'), $this->input->get('class'), 'regular');
			}else{
				$data['list'] 		= $this->model_student->get_student_list('','', $this->input->get('branch'), $this->input->get('school'), $this->input->get('class'), 'regular');
			}
		}else{
			$data['list'] 		= array();
		}
		dd($data);
// 		var_dump($data['branch']);
		// set_active_menu('submission');
		// init_view('rc/student_submission_add', $data);
	}

	public function submission_adult_add(){
		$data['periode'] 		= $this->model_periode->get_active_periode_adult();
		$data['branch'] 		= $this->model_branch->get_branch_trainer($this->session->userdata('id'));
		$data['list_branch'] 	= $this->model_branch->get_active_branch();
		$data['school'] 		= $this->model_periode->get_program_adult();
		$data['class'] 			= $this->model_classroom->get_active_class_adult();
		if(!empty($this->input->get())){
			if($this->input->get('periode') != ''){
				$periode 			= $this->model_periode->get_data($this->input->get('periode'));
				// dd($periode);
				$data['list'] 		= $this->model_student->get_student_list($periode['periode_start_date'], $periode['periode_end_date'], $this->input->get('branch'), $this->input->get('school'), $this->input->get('class'), 'adult');
			}else{
				$data['list'] 		= $this->model_student->get_student_list('','', $this->input->get('branch'), $this->input->get('school'), $this->input->get('class'), 'adult');
			}
		}else{
			$data['list'] 		= array();
		}
		set_active_menu('submission');
		init_view('rc/student_submission_adult_add', $data);
	}

	public function change_student(){
		$post 		= $this->input->post();
		$update_student = array(
							'branch_id' => $post['ch_branch_to'],
							'program_id' => $post['ch_program_to'],
							'class_id' => $post['ch_class_to'],
							);
		$result1 		= $this->model_student->update($update_student, $post['ch_student_id']);
		$periode_detail_id = $this->model_periode->get_periode_detail_id($post['ch_periode_id'], $post['ch_program_from'])['periode_detail_id'];
		$update_absen 	= array(
							'branch_id' => $post['ch_branch_to'],
							'program_id' => $post['ch_program_to'],
							'class_id' => $post['ch_class_to'],
							);
		$where_absen 	= array(
							'branch_id' => $post['ch_branch_from'],
							'program_id' => $post['ch_program_from'],
							'class_id' => $post['ch_class_from'],
							'periode_detail_id' => $periode_detail_id,
							'student_id' => $post['ch_student_id'],
							);
		$response 		= $this->model_student->update_absen($update_absen, $where_absen);
		if($response){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('rc/student/manage?'.$post['ch_redirect']));
	}

	public function submission_submit(){
		$post 		= $this->input->post();
		$insert['student_id'] 			= $post['student_id'];
		$insert['periode_detail_id'] 	= $this->model_periode->get_periode_detail_id($post['periode_id'], $post['program_from'])['periode_detail_id'];
		$insert['branch_from'] 			= $post['branch_from'];
		$insert['program_from']			= $post['program_from'];
		$insert['class_from']			= $post['class_from'];
		$insert['branch_to']			= $post['branch_to'];
		$insert['program_to']			= $post['program_to'];
		$insert['class_to']				= $post['class_to'];
		$insert['change_status']		= 'waiting';
		$insert['input_by']				= $this->session->userdata('id');
		$insert['timestamp'] 			= setNewDateTime();
		$result = $this->model_student->insert_submission($insert);
		if($result){
			flashdata('success', 'Berhasil menambahkan data pengajuan');
		}else{
			flashdata('error', 'Gagal menambahkan data');
		}

		redirect(base_url('rc/student/submission'));
	}

	public function submit_edit_form(){
		$post = $this->input->post();
		if(!empty($post['dad_id'])){
			# jika data ayah tersedia di database
			$participant['dad_id'] 			= $post['dad_id'];
			$dad['participant_name']		= $post['dad_name'];
			$dad['email'] 					= $post['dad_email'];
			$dad['phone'] 					= $post['dad_phone'];
			$dad['job'] 					= $post['dad_job'];
			$dad['gender'] 					= 'L';
			$dad['date_created']			= setNewDateTime();
			$this->model_signup->update_participant($dad, $participant['dad_id']);
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
			$mom['participant_name']		= $post['mom_name'];
			$mom['email'] 					= $post['mom_email'];
			$mom['phone'] 					= $post['mom_phone'];
			$mom['job'] 					= $post['mom_job'];
			$mom['gender'] 					= 'P';
			$mom['date_created']			= setNewDateTime();
			$this->model_signup->update_participant($mom, $participant['mom_id']);		
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
		$participant['participant_name'] 	= $post['participant_name'];
		$participant['gender'] 				= $post['gender'];
		$participant['phone'] 				= $post['phone'];
		$participant['email'] 				= $post['email'];
		$participant['birthdate'] 			= $post['birthdate'];
		$student['program_type'] 			= $post['program_type']; 
		$student['start_date'] 				= $post['start_date'];
		$student['end_date'] 				= $post['end_date'];
		if(!empty($post['special_status'])){
		    $student['special_status'] 			= $post['special_status'];
		}
		if(!empty($post['special_note'])){
		    $student['special_note'] 			= $post['special_note'];
		}
		$result1 = $this->model_signup->update_participant($participant, $post['participant_id']);
		$result2 = $this->model_student->update($student, $post['student_id']);
		if($result1 && $result2){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('rc/student/manage?'.$post['redirect']));
	}

	public function delete_submission(){
		$id 		= $this->input->post('id');
		$response	= $this->model_student->delete_submission($id);
		if($response){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function approve_submission(){
		$id 			= $this->input->post('id');
		$detail 		= $this->model_student->get_data_submission_by($id);
		$update_student = array(
							'branch_id' => $detail['branch_to'],
							'program_id' => $detail['program_to'],
							'class_id' => $detail['class_to'],
							);
		$result1 		= $this->model_student->update($update_student, $detail['student_id']);

		$update_absen 	= array(
							'branch_id' => $detail['branch_to'],
							'program_id' => $detail['program_to'],
							'class_id' => $detail['class_to'],
							);
		$where_absen 	= array(
							'branch_id' => $detail['branch_from'],
							'program_id' => $detail['program_from'],
							'class_id' => $detail['class_from'],
							'periode_detail_id' => $detail['periode_detail_id'],
							'student_id' => $detail['student_id'],
							);
		$result2 		= $this->model_student->update_absen($update_absen, $where_absen);
		$response	= $this->model_student->update_submission(array('change_status' => 'approved'), $id);
		if($response){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function submit_upgrade_student(){
		$post = $this->input->post();
		$detail = $this->model_student->get_data($post['student_id']);
		$event  = $this->model_signup->get_data_event_by_id($detail['program_id']);

		if($post['closing_type'] == 'Modul'){
			$transaction['participant_id'] 			= $detail['participant_id'];
			$transaction['event_id'] 				= $detail['program_id'];
			$transaction['event_name'] 				= $post['program'];
			$transaction['event_price'] 			= $event['price'];
			$transaction['signup_type'] 			= $post['signup_type'];
			$transaction['source'] 					= $post['source'];
			$transaction['payment_type'] 			= $post['payment_type'];
			$transaction['transfer_atas_nama'] 		= $post['atas_nama'];
			$transaction['paid_value'] 				= $post['paid_value'];
			$transaction['paid_date'] 				= $post['paid_date'];
			$transaction['closing_type'] 			= $post['closing_type'];
			$transaction['remark'] 					= $post['remark'];
			$transaction['class_modul'] 			= $post['modul_class'];
			$transaction['full_program_startdate'] 	= $post['full_program_startdate'];
			$transaction['full_program_enddate'] 	= $post['full_program_enddate'];
			$transaction['branch_id'] 				= $detail['branch_id'];
			$transaction['class_id'] 				= $detail['class_id'];
			$transaction['sales_id'] 				= $post['id_user_closing'];
			$transaction['department_id'] 			= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
			$transaction['input_by'] 				= $this->session->userdata('id');
			$transaction['timestamp'] 				= setNewDateTime();
			$result = $this->model_signup->insert_transaction($transaction);	
			$student['participant_id'] 		= $detail['participant_id'];
			$student['program_id'] 			= $detail['program_id'];
			$student['branch_id'] 			= $detail['branch_id'];
			$student['class_id'] 			= $detail['class_id'];
			$student['program_type'] 		= $transaction['closing_type'];
			$student['start_date'] 			= $transaction['full_program_startdate'];
			$student['end_date'] 			= $transaction['full_program_enddate'];
			$student['student_status'] 		= 'active';
			$result2 = $this->model_student->insert($student);
			$this->model_student->update(array('upgrade_to_newmodul' => 1), $post['student_id']);
		}else{
			$transaction['participant_id'] 			= $detail['participant_id'];
			$transaction['event_id'] 				= $detail['program_id'];
			$transaction['event_name'] 				= $post['program'];
			$transaction['event_price'] 			= $event['price'];
			$transaction['signup_type'] 			= $post['signup_type'];
			$transaction['source'] 					= $post['source'];
			$transaction['payment_type'] 			= $post['payment_type'];
			$transaction['transfer_atas_nama'] 		= $post['atas_nama'];
			$transaction['paid_value'] 				= $post['paid_value'];
			$transaction['paid_date'] 				= $post['paid_date'];
			$transaction['closing_type'] 			= $post['closing_type'];
			$transaction['remark'] 					= $post['remark'];
			$transaction['class_modul'] 			= $post['modul_class'];
			$transaction['full_program_startdate'] 	= $detail['start_date'];
			$transaction['full_program_enddate'] 	= $post['full_program_enddate'];
			$transaction['branch_id'] 				= $detail['branch_id'];
			$transaction['class_id'] 				= $detail['class_id'];
			$transaction['sales_id'] 				= $post['id_user_closing'];
			$transaction['department_id'] 			= $this->db->get_where('divisi', array('departement' => 'MRLC 1'))->row_array()['id'];
			$transaction['input_by'] 				= $this->session->userdata('id');
			$transaction['timestamp'] 				= setNewDateTime();
			$transaction['is_upgrade'] 				= 1;
			$result = $this->model_signup->insert_transaction($transaction);	

			$student['program_type'] 		= $transaction['closing_type'];
			$student['end_date'] 			= $transaction['full_program_enddate'];
			$student['student_status'] 		= 'active';
			$result2 = $this->model_student->update($student, $post['student_id']);
		}
		if($result2){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		redirect(base_url('rc/student/manage?'.$post['url']));
	}


	public function export_data_student(){
		$periode	= $this->model_periode->get_data($this->input->get('periode'));
		$data 		= $this->model_student->get_filtered_student_export($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'regular');
		$filename 	= "Data Student - ".strtotime(setNewDateTime());
		exportToExcel($data, 'Sheet 1', $filename);
	}

	public function export_data_student_adult(){
		$periode	= $this->model_periode->get_data($this->input->get('periode'));
		$data 		= $this->model_student->get_filtered_student_export($this->input->get(), $periode['periode_start_date'], $periode['periode_end_date'], 'adult');
		$filename 	= "Data Student - ".strtotime(setNewDateTime());
		exportToExcel($data, 'Sheet 1', $filename);
	}

	public function delete_student(){
		$id 		= $this->input->post('id');
		$response	= $this->model_student->delete($id);
		if($response){
			$this->model_absensi->delete_by_student($id);
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}


	public function reject_submission(){
		$id 		= $this->input->post('id');
		$response	= $this->model_student->update_submission(array('change_status' => 'rejected'), $id);
		if($response){
			flashdata('success', 'Berhasil mengubah data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function json_get_detail_student(){
		$id 		= $this->input->post('id');
		$response	= $this->model_student->get_data($id);
		echo json_encode($response);
	}

	public function json_get_detail_student_upgrade(){
		$id 		= $this->input->post('id');
		$response	= $this->model_student->get_data_student_upgrade($id);
		echo json_encode($response);
	}

	public function json_remove_trainer(){
		$id 		= $this->input->post('id');
		$response 	= $this->model_branch->update_branch_trainer($id, 0);
		if($response){
			flashdata('success', 'Berhasil menghapus data');
		}else{
			flashdata('error', 'Gagal mengubah data');
		}
		echo json_encode($response);
	}

	public function json_get_history_trx(){
		$id 		= $this->input->post('id');
		$response	= $this->model_student->get_history_trx($id);
		echo json_encode($response);
	}

	public function json_get_data_participant_by_id(){
		$id 	= secure($this->input->post('id'));
		$result = $this->model_student->get_data_student_detail($id);
		echo json_encode($result);
	}
	
}