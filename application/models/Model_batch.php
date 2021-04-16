<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_batch extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_list_batch($event_name = null){
		if(!empty($event_name)){
			$this->db->where('event_name', $event_name);
			$this->db->order_by('event_date', 'desc');
		}else{
			$this->db->order_by('event_name');
		}
		return $this->db->get('batch')->result_array();
	}

	public function get_detail_batch($id){
		return $this->db->get_where('batch', array('batch_id' => $id))->row_array();
	}

	public function get_data_peserta($batch_id){
		$detail = $this->get_detail_batch($batch_id);
		$this->db->select('transaction_id, event_name, participant_name, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age, gender, participant.phone, participant.email, paid_value, payment_type, paid_date, closing_type, user.username');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->where('is_paid_off', 1);
		$this->db->where('is_approved', 1);
		$this->db->where('batch_id', '0');
		$this->db->where('event_name', $detail['event_name']);
		// $this->db->order_by('participant_name');
		return $this->db->get('participant')->result_array();
	}

	public function get_data_peserta_batch($batch_id){
		$this->db->select('transaction_id, event_name, participant_name, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age, gender, participant.phone, participant.email, paid_value,  payment_type, paid_date, closing_type, branch_name, user.username, is_reattendance');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('rc_branch', 'rc_branch.branch_id = transaction.branch_id');
		$this->db->where('is_paid_off', 1);
		$this->db->where('batch_id', $batch_id);
		$this->db->order_by('participant_name');
		return $this->db->get('participant')->result_array();
	}

	public function get_data_export_batch($batch_id){
		$this->db->select('transaction.event_name, batch_label, participant_name, TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age, gender, participant.phone, participant.email, paid_value, payment_type, paid_date, closing_type, user.username, is_reattendance');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->join('user', 'user.id = transaction.sales_id');
		$this->db->join('batch', 'batch.batch_id = transaction.batch_id');
		$this->db->where('transaction.batch_id', $batch_id);
		$this->db->order_by('participant_name');
		return $this->db->get('participant');
	}

	public function remove_participant($id){
		$this->db->where('transaction_id', $id);
		return $this->db->update('transaction', array('batch_id' => 0));
	}
	

	public function insert($data){
		return $this->db->insert('batch', $data);
	}

	public function update($data, $id){
		$this->db->where('batch_id', $id);
		return $this->db->update('batch', $data);
	}


}