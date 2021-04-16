<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_signup extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	
	public function get_list_event($id_divisi = null){
		
		$this->db->where('is_active', 1);
		$this->db->order_by('department_id');
		$this->db->order_by('ordering');
		$result = $this->db->get('list_incentive_sp')->result_array();
		if(!empty($id_divisi)){
			$data = array();
			foreach($result as $row){
				$temp = explode(",", $row['department_id']);
				foreach($temp as $row2){
					if($row2 == $id_divisi){
						array_push($data, $row);
					}
				}
			}
			return $data;
		}else{
			return $result;
		}
	}
	
	public function get_list_event_confirm($id_divisi = null){
		
		$this->db->where('is_active', 1);
		$this->db->where_not_in('id', array('11'));
		$this->db->order_by('department_id');
		$this->db->order_by('ordering');
		$result = $this->db->get('list_incentive_sp')->result_array();
		if(!empty($id_divisi)){
			$data = array();
			foreach($result as $row){
				$temp = explode(",", $row['department_id']);
				foreach($temp as $row2){
					if($row2 == $id_divisi){
						array_push($data, $row);
					}
				}
			}
			return $data;
		}else{
			return $result;
		}
	}

	public function get_list_event_batch($id_divisi = null){
		
		$this->db->where('is_active', 1);
		$this->db->where('is_batch', 1);
		$this->db->order_by('department_id');
		$this->db->order_by('ordering');
		$result = $this->db->get('list_incentive_sp')->result_array();
		if(!empty($id_divisi)){
			$data = array();
			foreach($result as $row){
				$temp = explode(",", $row['department_id']);
				foreach($temp as $row2){
					if($row2 == $id_divisi){
						array_push($data, $row);
					}
				}
			}
			return $data;
		}else{
			return $result;
		}
	}

	public function get_detail_event($name){
		$this->db->where('lower(name)', strtolower($name));
		return $this->db->get('list_incentive_sp')->row_array();
	}

	public function get_list_warrior(){
		$this->db->where('level', 'user');
		$this->db->where('status', 'aktif');
		$this->db->order_by('username');
		return $this->db->get('user')->result_array();
	}

	public function get_list_task(){
		$this->db->where('date <=', date('Y-m-d'));
		$this->db->where('date >=', date('Y-m-d', strtotime(date('Y-m-d').'-200days')));
		$this->db->order_by('date', 'desc');
		return $this->db->get('task')->result_array();
	}
	
	public function get_list_task_all(){
		$this->db->where('date <=', date('Y-m-d'));
		// $this->db->where('date >=', date('Y-m-d', strtotime(date('Y-m-d').'-30days')));
		$this->db->order_by('date', 'desc');
		return $this->db->get('task')->result_array();
	}

	public function is_email_exist($email){
		$result = $this->db->get_where('participant', array('email' => $email));
		if($result->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_data_waiting($department_id = null){
		$this->db->select('transaction_id, event_name, participant_name, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age, gender, participant.phone, participant.email, is_reattendance, is_upgrade, branch_name, class_name, paid_value, paid_date, payment_type, transfer_atas_nama, is_approved, is_rejected, closing_type, user.username');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('rc_branch', 'transaction.branch_id = rc_branch.branch_id', 'left');
		$this->db->join('rc_class', 'transaction.class_id = rc_class.class_id', 'left');
		$this->db->where('is_approved', 0);
		if(!empty($department_id)){
			$this->db->where('department_id', $department_id);
		}
		$this->db->order_by('participant_name');
		return $this->db->get('participant')->result_array();
	}

	public function get_data_signup_confirm($parameter = array()){
		$this->db->select('transaction_id, event_name, participant_name, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age, gender, participant.phone, participant.email, branch_name, is_reattendance, is_upgrade, paid_value, paid_date, transfer_atas_nama, closing_type, payment_type, user.username, referral, ifnull(concat(DATE_FORMAT(task.date, "%d-%M-%Y"), " | ", task.event, " | ", task.location), "") as task');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('task', 'transaction.id_task = task.id', 'left');
		$this->db->join('rc_branch', 'rc_branch.branch_id = transaction.branch_id');
		$this->db->where('is_approved', 0);
		$this->db->where('is_rejected', 0);
		if(!empty($parameter['event_name'])){
			$this->db->where('event_name', $parameter['event_name']);
		}
		// if(!empty($parameter['sales_id'])){
		// 	$this->db->where('sales_id', $parameter['sales_id']);
		// }
		if(!empty($parameter['id_task'])){
			$this->db->where('id_task', $parameter['id_task']);
		}

		$this->db->order_by('participant_name');
		return $this->db->get('participant')->result_array();
	}

	public function get_data_signup_approved($id_divisi = null, $parameter = array()){
		$this->db->select('transaction_id, transaction.participant_id, event_name, participant_name, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age, gender, participant.phone, participant.email, branch_name, class_name, paid_value, paid_date, payment_type, transfer_atas_nama, closing_type, user.username, referral, ifnull(concat(DATE_FORMAT(task.date, "%d-%M-%Y"), " | ", task.event, " | ", task.location), "") as task, is_reattendance, is_upgrade');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('task', 'transaction.id_task = task.id', 'left');
		$this->db->join('rc_branch', 'transaction.branch_id = rc_branch.branch_id', 'left');
		$this->db->join('rc_class', 'transaction.class_id = rc_class.class_id', 'left');
		
		$this->db->where('is_approved', 1);
		if(!empty($id_divisi)){
			$this->db->where('department_id', $id_divisi);
		}
		if(!empty($parameter['event']) && $parameter['event'] != 'all'){
			$this->db->where('event_name', $parameter['event']);
		}
		if(!empty($parameter['batch']) && $parameter['batch'] != 'all'){
			$this->db->where('batch_id', $parameter['batch']);
		}
		if(!empty($parameter['sp']) && $parameter['sp'] != 'all'){
			$this->db->where('id_task', $parameter['sp']);
		}
		if(!empty($parameter['type']) && $parameter['type'] != 'all'){
			$this->db->where('closing_type', $parameter['type']);
		}
		if(!empty($parameter['branch']) && $parameter['branch'] != 'all'){
			$this->db->where('transaction.branch_id', $parameter['branch']);
		}
		if(!empty($parameter['class']) && $parameter['class'] != 'all'){
			$this->db->where('transaction.class_id', $parameter['class']);
		}
		$this->db->order_by('participant_name');
		return $this->db->get('participant')->result_array();
	}

	public function insert_participant($data){
		$this->db->insert('participant', $data);
		return $this->db->insert_id();
	}

	public function insert_transaction($data){
		return $this->db->insert('transaction', $data);
	}

	public function insert_incentive($data){
		return $this->db->insert('incentive', $data);
	}

	public function delete_transaction($id){
		$result 			= $this->db->get_where('transaction', array('transaction_id' => $id))->row_array();
		$total_transaction 	= $this->db->get_where('transaction', array('participant_id' => $result['participant_id']));
		$id_affiliate 		= $result['id_affiliate'];
		$id_task 			= $result['id_task'];
		if(!empty($id_affiliate)){
			$url = $this->config->item('reseller_url').'request/set_affiliate_default';
			$response = curl_post($url, array('id' => $id_affiliate));
		}

		if($total_transaction->num_rows() > 1){
			# delete transaction
			$this->db->where('transaction_id', $id);
			return $this->db->delete('transaction');
		}else{
			# delete transaction + participant
			$this->db->where('transaction_id', $id);
			$this->db->delete('transaction');

			$this->db->where('participant_id', $result['participant_id']);
			return $this->db->delete('participant');
		}

	}

	public function get_data_master_trx($parameter = array()){
		$this->db->select('transaction_id, event_name, participant_name, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age, gender, participant.phone, participant.email, paid_value, paid_date, payment_type, transfer_atas_nama, closing_type, user.username, referral, ifnull(concat(DATE_FORMAT(task.date, "%d-%M-%Y"), " | ", task.event, " | ", task.location), "") as task, is_reattendance, is_upgrade, branch_name, class_name');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('task', 'transaction.id_task = task.id', 'left');
		$this->db->join('rc_branch', 'transaction.branch_id = rc_branch.branch_id', 'left');
		$this->db->join('rc_class', 'transaction.class_id = rc_class.class_id', 'left');
		$this->db->where('is_approved', 1);
		if(!empty($parameter) && $parameter['event'] != 'all'){
			$this->db->where('event_name', $parameter['event']);
		}

		if(!empty($parameter) && $parameter['batch'] != 'all'){
			if($parameter['batch'] != 'none'){
				$this->db->where('batch_id', $parameter['batch']);
			}else{
				$this->db->where('batch_id', 0);
			}
		}

		if(!empty($parameter) && $parameter['warrior'] != 'all'){
			$this->db->where('sales_id', $parameter['warrior']);
		}

		if(!empty($parameter) && $parameter['sp'] != 'all'){
			$this->db->where('id_task', $parameter['sp']);
		}

		if(!empty($parameter['date_start'])){
			$this->db->where('DATE_FORMAT(timestamp, "%Y-%m-%d") >=', $parameter['date_start']);
		}

		if(!empty($parameter['date_end'])){
			$this->db->where('DATE_FORMAT(timestamp, "%Y-%m-%d") <=', $parameter['date_end']);
		}

		if(!empty($parameter) && $parameter['type'] != 'all'){
			$this->db->where('closing_type', $parameter['type']);
		}

		if(!empty($parameter) && $parameter['branch'] != 'all'){
			$this->db->where('transaction.branch_id', $parameter['branch']);
		}

		if(!empty($parameter) && $parameter['class'] != 'all'){
			$this->db->where('transaction.class_id', $parameter['class']);
		}

		$this->db->order_by('participant_name');
		return $this->db->get('participant')->result_array();
	}

	public function export_data_master_trx($parameter = array()){
		$this->db->select('transaction_id, event_name, participant.participant_name, participant.birthdate, TIMESTAMPDIFF(YEAR, participant.birthdate, CURDATE()) AS age, participant.gender, participant.phone, participant.email, participant.address, participant.school, participant.is_vegetarian, participant.is_allergy, mom.participant_name as mom_name, mom.phone as mom_phone, mom.email as mom_email, mom.job as mom_job, dad.participant_name as dad_name, dad.phone as dad_phone, dad.email as dad_email, dad.job as dad_job, signup_type, is_reattendance, branch_name, class_name, source, paid_value, paid_date, payment_type, transfer_atas_nama, closing_type, remark, user.username as sales, referral, ifnull(concat(DATE_FORMAT(task.date, "%d-%M-%Y"), " | ", task.event, " | ", task.location), "") as task, timestamp');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('participant dad', 'participant.dad_id = dad.participant_id', 'left');
		$this->db->join('participant mom', 'participant.mom_id = mom.participant_id', 'left');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('task', 'transaction.id_task = task.id', 'left');
		$this->db->join('rc_branch', 'transaction.branch_id = rc_branch.branch_id', 'left');
		$this->db->join('rc_class', 'transaction.class_id = rc_class.class_id', 'left');
		$this->db->where('is_approved', 1);
		if(!empty($parameter) && $parameter['event'] != 'all'){
			$this->db->where('event_name', $parameter['event']);
		}

		if(!empty($parameter) && $parameter['batch'] != 'all'){
			if($parameter['batch'] != 'none'){
				$this->db->where('batch_id', $parameter['batch']);
			}else{
				$this->db->where('batch_id', 0);
			}
		}

		if(!empty($parameter) && $parameter['warrior'] != 'all'){
			$this->db->where('sales_id', $parameter['warrior']);
		}

		if(!empty($parameter) && $parameter['sp'] != 'all'){
			$this->db->where('id_task', $parameter['sp']);
		}

		if(!empty($parameter['date_start'])){
			$this->db->where('DATE_FORMAT(timestamp, "%Y-%m-%d") >=', $parameter['date_start']);
		}

		if(!empty($parameter['date_end'])){
			$this->db->where('DATE_FORMAT(timestamp, "%Y-%m-%d") <=', $parameter['date_end']);
		}

		if(!empty($parameter) && $parameter['type'] != 'all'){
			$this->db->where('closing_type', $parameter['type']);
		}

		if(!empty($parameter['branch']) && $parameter['branch'] != 'all'){
			$this->db->where('transaction.branch_id', $parameter['branch']);
		}
		if(!empty($parameter['class']) && $parameter['class'] != 'all'){
			$this->db->where('transaction.class_id', $parameter['class']);
		}

		$this->db->order_by('participant_name');
		return $this->db->get('participant');
	}

	public function get_data_master_participant($parameter = array()){
		$this->db->select('participant.participant_id, participant.participant_name, participant.birthdate, TIMESTAMPDIFF(YEAR, participant.birthdate, CURDATE()) AS age, participant.gender, participant.phone, participant.email, participant.address, participant.school, participant.is_vegetarian, participant.is_allergy, mom.participant_name as mom_name, mom.phone as mom_phone, mom.email as mom_email, mom.job as mom_job, dad.participant_name as dad_name, dad.phone as dad_phone, dad.email as dad_email, dad.job as dad_job, participant.date_created, count(participant.participant_id) as jmlh_trx');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id', 'left');
		$this->db->join('participant dad', 'participant.dad_id = dad.participant_id', 'left');
		$this->db->join('participant mom', 'participant.mom_id = mom.participant_id', 'left');
		$this->db->where('is_paid_off', 1);
		// $this->db->where('closing_type', 'Lunas');
		$this->db->group_by('participant.participant_id');
		if(!empty($parameter['email'])){
			$this->db->where('email', $parameter['email']);
		}

		if(!empty($parameter['phone'])){
			$this->db->where('participant.phone', $parameter['phone']); // edit: specify table [han han 20190506]
		}

		if(!empty($parameter['age1'])){
			$this->db->where('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >=', $parameter['age1']);
		}

		if(!empty($parameter['age2'])){
			$this->db->where('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <=', $parameter['age2']);
		}

		if(!empty($parameter['kondisi']) && $parameter['kondisi'] != 'all'){
			if($parameter['kondisi'] == 'is_vegetarian'){
				$this->db->where('is_vegetarian', 1);
			}else if($parameter['kondisi'] == 'is_allergy'){
				$this->db->where('is_allergy', 1);
			}
		}		

		if(!empty($parameter['date_start'])){
			$this->db->where('date_created >=', $parameter['date_start']);
		}

		if(!empty($parameter['date_end'])){
			$this->db->where('date_created <=', $parameter['date_end']);
		}

		$this->db->order_by('participant_name');
		return $this->db->get('participant');
	}

	public function export_data_signup_approved($id_divisi, $parameter = array()){
		$this->db->select('transaction.event_name, batch_label, participant.participant_name, participant.birthdate, TIMESTAMPDIFF(YEAR, participant.birthdate, CURDATE()) AS age, participant.gender, participant.phone, participant.email, participant.address, participant.school, participant.is_vegetarian, participant.is_allergy, mom.participant_name as mom_name, mom.phone as mom_phone, mom.email as mom_email, mom.job as mom_job, dad.participant_name as dad_name, dad.phone as dad_phone, dad.email as dad_email, dad.job as dad_job, signup_type, ifnull(concat(DATE_FORMAT(task.date, "%d-%M-%Y"), " | ", task.event, " | ", task.location), "") as sp, source, paid_value, paid_date, payment_type, transfer_atas_nama, closing_type, branch_name, class_name, is_reattendance, remark, user.username as sales, referral, timestamp');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('participant dad', 'participant.dad_id = dad.participant_id', 'left');
		$this->db->join('participant mom', 'participant.mom_id = mom.participant_id', 'left');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('task', 'transaction.id_task = task.id', 'left');
		$this->db->join('batch', 'transaction.batch_id = batch.batch_id', 'left');
		$this->db->join('rc_branch', 'transaction.branch_id = rc_branch.branch_id', 'left');
		$this->db->join('rc_class', 'transaction.class_id = rc_class.class_id', 'left');
		$this->db->where('is_approved', 1);
		if(!empty($id_divisi)){
			$this->db->where('department_id', $id_divisi);
		}
		if(!empty($parameter['event']) && $parameter['event'] != 'all'){
			$this->db->where('transaction.event_name', $parameter['event']);
		}
		if(!empty($parameter['batch']) && $parameter['batch'] != 'all'){
			$this->db->where('transaction.batch_id', $parameter['batch']);
		}
		if(!empty($parameter['sp']) && $parameter['sp'] != 'all'){
			$this->db->where('id_task', $parameter['sp']);
		}
		if(!empty($parameter['type']) && $parameter['type'] != 'all'){
			$this->db->where('closing_type', $parameter['type']);
		}
		if(!empty($parameter['branch']) && $parameter['branch'] != 'all'){
			$this->db->where('transaction.branch_id', $parameter['branch']);
		}
		if(!empty($parameter['class']) && $parameter['class'] != 'all'){
			$this->db->where('transaction.class_id', $parameter['class']);
		}
		$this->db->order_by('transaction.event_name');
		$this->db->order_by('participant_name');
		return $this->db->get('participant');
	}

	public function get_detail_signup_by($transaction_id){
		$this->db->select('transaction_id, event_name, participant_name, participant.phone, participant.email, paid_value, paid_date, remark, id_affiliate, closing_type, id_task, sales_id, event_price, event_commision');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->where('transaction_id', $transaction_id);
		$this->db->order_by('participant_name');
		return $this->db->get('participant')->row_array();
	}

	public function get_data_participant_by_email($email){
		$this->db->where('email', $email);
		return $this->db->get('participant')->row_array();
	}

	public function get_data_participant_by_id($participant_id){
		$this->db->where('participant_id', $participant_id);
		return $this->db->get('participant')->row_array();
	}

	public function get_participant_transaction($participant_id){
		$this->db->select('transaction_id, transaction.transaction_id, transaction.event_name, participant_name, paid_value, paid_date, ifnull(batch_label, "-") as batch_label');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('batch', 'transaction.batch_id = batch.batch_id', 'left');
		$this->db->where('is_paid_off', 1);
		$this->db->where('transaction.participant_id', $participant_id);
		$this->db->order_by('timestamp', 'desc');
		return $this->db->get('participant')->result_array();
	}

	public function get_data_transaction_detail($transaction_id){
		$this->db->select('transaction.*, participant.*, user.username, referral, ifnull(concat(DATE_FORMAT(task.date, "%d-%M-%Y"), " | ", task.event, " | ", task.location), "") as task, batch_label');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('task', 'transaction.id_task = task.id', 'left');
		$this->db->join('batch', 'transaction.batch_id = batch.batch_id', 'left');
		$this->db->where('transaction.transaction_id', $transaction_id);
		return $this->db->get('participant')->row_array();
	}

	public function get_data_repayment_transaction($transaction_id){
		$this->db->select('transaction.transaction_id, transaction.remark, participant_name, transaction.event_name, transaction.paid_value, transaction.paid_date, repayment_last_paid, repayment_last_paid_date, is_repayment_update');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->where('transaction.transaction_id', $transaction_id);
		return $this->db->get('participant')->row_array();
	}

	public function get_data_participant_by_phone($phone){
		$this->db->select('a.*, b.participant_name as dad_name, b.email as dad_email, b.phone as dad_phone, b.job as dad_job, c.participant_name as mom_name, c.email as mom_email, c.phone as mom_phone, c.job as mom_job');
		$this->db->join('participant b', 'a.dad_id = b.participant_id', 'left');
		$this->db->join('participant c', 'a.mom_id = c.participant_id', 'left');
		$this->db->where('a.phone', $phone);
		$result = $this->db->get('participant a');
		if($result->num_rows() > 0){
			return $result->row_array();
		}else{
			return false;
		}
	}

	public function master_get_detail_transaction($id){
		$this->db->select('transaction.event_name, signup_type, ifnull(concat(DATE_FORMAT(task.date, "%d-%M-%Y"), " | ", task.event, " | ", task.location), "") as task, is_reattendance, closing_type, payment_type, transfer_atas_nama, paid_value, paid_date, user.username as sales, participant.participant_name, participant.birthdate, participant.gender, participant.phone, participant.email, source, referral, remark, event_commision, mom.participant_name as mom_name, mom.phone as mom_phone, mom.email as mom_email, mom.job as mom_job, dad.participant_name as dad_name, dad.phone as dad_phone, dad.email as dad_email, dad.job as dad_job');
		$this->db->join('participant', 'transaction.participant_id = participant.participant_id');
		$this->db->join('participant dad', 'participant.dad_id = dad.participant_id', 'left');
		$this->db->join('participant mom', 'participant.mom_id = mom.participant_id', 'left');
		$this->db->join('user', 'transaction.sales_id = user.id');
		$this->db->join('task', 'transaction.id_task = task.id', 'left');
		$this->db->where('transaction_id', $id);
		return $this->db->get('transaction')->row_array();
	}

	public function get_list_hp_program(){
		return $this->db->get_where('list_incentive_sp', array('is_hp_full_program' => 2, 'is_active' => 1))->result_array();
	}

	public function get_data_event_by_name($event){
		return $this->db->get_where('list_incentive_sp', array('lower(name)' => strtolower($event)))->row_array();
	}

	public function get_data_event_by_id($id){
		return $this->db->get_where('list_incentive_sp', array('id' => $id))->row_array();
	}

	public function get_branch_active(){
		$this->db->where('branch_status', 1);
		return $this->db->get('rc_branch')->result_array();
	}

	public function get_class_active(){
		$this->db->where('class_status', 1);
		return $this->db->get('rc_class')->result_array();
	}

	public function update($data, $id){
		$this->db->where('transaction_id', $id);
		return $this->db->update('transaction', $data);
	}

	public function update_participant($data, $id){
		$this->db->where('participant_id', $id);
		return $this->db->update('participant', $data);
	}

}