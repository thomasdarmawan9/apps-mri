<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_repayment extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_data_list_dp($department_id){
		$this->db->select('transaction_id, event_name, participant_name, participant.phone, participant.email, paid_value, paid_date, payment_type');
		$this->db->join('transaction', 'participant.participant_id = transaction.participant_id');
		$this->db->where('closing_type', 'DP');
		$this->db->where('is_paid_off', 0);
		$this->db->where('is_approved', 0);
		if(!empty($department_id)){
			$this->db->where('department_id', $department_id);
		}
		$this->db->order_by('participant_name');
		return $this->db->get('participant')->result_array();
	}

	public function get_data_list_repayment($department_id){
		$this->db->select('repayment_id, event_name, participant_name, repayment.payment_type, is_repayment_paid_off, repayment.transfer_atas_nama, repayment.paid_value, repayment.paid_date, repayment.remark, repayment.is_approved, repayment.is_rejected');
		$this->db->join('transaction', 'repayment.transaction_id = transaction.transaction_id');
		$this->db->join('participant', 'participant.participant_id = transaction.participant_id');
		$this->db->where('closing_type', 'DP');
		$this->db->or_where('is_paid_off', 0);
		$this->db->where('is_repayment_update', 1);
		if(!empty($department_id)){
			$this->db->where('department_id', $department_id);
		}
		$this->db->order_by('participant_name');
		return $this->db->get('repayment')->result_array();
	}

	public function get_data_list_repayment_waiting($param){
		$this->db->select('repayment_id, repayment.transaction_id, event_name, participant_name, repayment.payment_type, is_repayment_paid_off, repayment.transfer_atas_nama, transaction.paid_value as dp, repayment.paid_value, repayment.paid_date, repayment.remark');
		$this->db->join('transaction', 'repayment.transaction_id = transaction.transaction_id');
		$this->db->join('participant', 'participant.participant_id = transaction.participant_id');
		$this->db->where('closing_type', 'DP');
		$this->db->where('is_paid_off', 0);
		$this->db->where('is_repayment_update', 1);
		$this->db->where('repayment.is_approved', 0);
		$this->db->where('repayment.is_rejected', 0);
		if(!empty($param['event_name'])){
			$this->db->where('transaction.event_id', $param['event_name']);
		}
		$this->db->order_by('participant_name');
		return $this->db->get('repayment')->result_array();
	}

	public function get_list_event(){
		
		$this->db->order_by('department_id');
		$this->db->order_by('ordering');
		$this->db->where('is_batch', 1);
		return $this->db->get('list_incentive_sp')->result_array();
	}

	public function get_list_event2(){
		$this->db->where('is_active', 1);
		$this->db->order_by('department_id');
		$this->db->order_by('ordering');
		return $this->db->get('list_incentive_sp')->result_array();
	}

	public function get_detail_repayment_by($id){
		$this->db->where('repayment_id', $id);
		return $this->db->get('repayment')->row_array();
	}

	public function get_data_transaction($id){
		$this->db->where('transaction_id', $id);
		return $this->db->get('transaction')->row_array();
	}

	public function insert($data){
		return $this->db->insert('repayment', $data);
	}

	public function update($data, $id){
		$this->db->where('repayment_id', $id);
		return $this->db->update('repayment', $data);
	}


}