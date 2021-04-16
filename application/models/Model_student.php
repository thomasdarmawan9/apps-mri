<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_student extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function get_data($id){
		$this->db->select('a.*, b.participant_name');
		$this->db->where('student_id', $id);
		$this->db->join('participant b', 'a.participant_id = b.participant_id');
		return $this->db->get('rc_student a')->row_array();
	}
	
	public function get_data_student_upgrade($id){
		$this->db->select('a.*, b.branch_name, c.class_name, d.name as program, e.participant_name');
		$this->db->join('rc_branch b', 'a.branch_id = b.branch_id');
		$this->db->join('rc_class c', 'a.class_id = c.class_id');
		$this->db->join('list_incentive_sp d', 'a.program_id = d.id');
		$this->db->join('participant e', 'a.participant_id = e.participant_id');
		$this->db->where('a.student_id', $id);
		return $this->db->get('rc_student a')->row_array();
	}

	public function get_student_by_participant_program($participant, $program){
		$this->db->where('participant_id', $participant);
		$this->db->where('program_id', $program);
		return $this->db->get('rc_student');
	}

	public function get_student_list($start, $end, $branch, $program, $class, $type){
		$this->db->select('student_id, b.participant_name, program_type, branch_name, class_name, name as program');
		if($branch != 'all'){
			$this->db->where('a.branch_id', $branch);
		}
		if($program != 'all'){
			$this->db->where('a.program_id', $program);
		}
		if($class != 'all'){
			$this->db->where('a.class_id', $class);
		}
		if($start != '' && $end != ''){
			$this->db->group_start();
			$this->db->where('start_date <=', $end);
			$this->db->where('end_date >=', $start);
			$this->db->group_end();
		}

		if($type == 'regular'){
			$this->db->where('e.is_adult_class', 0);
		}else{
			$this->db->where('e.is_adult_class', 1);
		}
		
		$this->db->where('student_status', 'active');
		$this->db->join('participant b', 'a.participant_id = b.participant_id');
		$this->db->join('list_incentive_sp c', 'a.program_id = c.id');
		$this->db->join('rc_branch d', 'a.branch_id = d.branch_id');
		$this->db->join('rc_class e', 'a.class_id = e.class_id');
		$this->db->order_by('participant_name');
		return $this->db->get('rc_student a')->result_array();
		// dd($this->db->last_query());
	}

	public function get_data_submission($id){
		$this->db->select('a.*, participant_name, periode_name, f.branch_name as branch_from_name, g.name as program_from_name, h.class_name as class_from_name, i.branch_name as branch_to_name, j.name as program_to_name, k.class_name as class_to_name, l.username as input');
		$this->db->join('rc_student b', 'a.student_id = b.student_id');
		$this->db->join('participant c', 'b.participant_id = c.participant_id');
		$this->db->join('rc_periode_detail d', 'a.periode_detail_id = d.periode_detail_id');
		$this->db->join('rc_periode e', 'd.periode_id = e.periode_id');
		$this->db->join('rc_branch f', 'a.branch_from = f.branch_id');
		$this->db->join('list_incentive_sp g', 'a.program_from = g.id');
		$this->db->join('rc_class h', 'a.class_from = h.class_id');
		$this->db->join('rc_branch i', 'a.branch_to = i.branch_id');
		$this->db->join('list_incentive_sp j', 'a.program_to = j.id');
		$this->db->join('rc_class k', 'a.class_to = k.class_id');
		$this->db->join('user l', 'a.input_by = l.id');
		$this->db->where('input_by', $id);
		$this->db->order_by('change_status');
		return $this->db->get('rc_apply_change a')->result_array();
	}

	public function get_data_submission_waiting(){
		$this->db->select('a.*, participant_name, periode_name, f.branch_name as branch_from_name, g.name as program_from_name, h.class_name as class_from_name, i.branch_name as branch_to_name, j.name as program_to_name, k.class_name as class_to_name, l.username as input');
		$this->db->join('rc_student b', 'a.student_id = b.student_id');
		$this->db->join('participant c', 'b.participant_id = c.participant_id');
		$this->db->join('rc_periode_detail d', 'a.periode_detail_id = d.periode_detail_id');
		$this->db->join('rc_periode e', 'd.periode_id = e.periode_id');
		$this->db->join('rc_branch f', 'a.branch_from = f.branch_id');
		$this->db->join('list_incentive_sp g', 'a.program_from = g.id');
		$this->db->join('rc_class h', 'a.class_from = h.class_id');
		$this->db->join('rc_branch i', 'a.branch_to = i.branch_id');
		$this->db->join('list_incentive_sp j', 'a.program_to = j.id');
		$this->db->join('rc_class k', 'a.class_to = k.class_id');
		$this->db->join('user l', 'a.input_by = l.id');
        //Fix This Function -Temporary Function (Rizki) 		
		if($this->session->userdata('id') == '76'){
		    $this->db->where_in('a.branch_from', array('1','6'));
		    $this->db->where_in('a.branch_to', array('1','6'));
		}elseif($this->session->userdata('id') == '88'){
		    $this->db->where_in('a.branch_from', array('2','5'));
		    $this->db->where_in('a.branch_to', array('2','5'));
		}elseif($this->session->userdata('id') == '63'){
		    $this->db->where_in('a.branch_from', array('3','4'));
		    $this->db->where_in('a.branch_to', array('3','4'));
		}elseif($this->session->userdata('id') == '82'){
		    $this->db->where_in('a.branch_from', array('7'));
		    $this->db->where_in('a.branch_to', array('7'));
		}
        //End 		
		$this->db->where('change_status', 'waiting');
		$this->db->order_by('timestamp');
		return $this->db->get('rc_apply_change a')->result_array();
	}

	public function get_filtered_student($param = array(), $start, $end, $type){
		if($type == 'regular'){
			$active = $this->get_active_periode_now();
			$this->db->where('d.is_adult_class', 0);
		}else{
			$active = $this->get_active_periode_adult_now();
			$this->db->where('d.is_adult_class', 1);
		}
		$this->db->select("a.*, participant_name, branch_name, class_name, c.name as program, TIMESTAMPDIFF(YEAR, e.birthdate, CURDATE()) AS age, 
			(CASE 
			WHEN (program_type = 'modul' AND end_date <= '".$active['periode_end_date']."' AND end_date >= '".date('Y-m-d')."') THEN 'Need to upgrade'
			WHEN (program_type = 'modul' AND end_date < '".$active['periode_end_date']."' AND end_date < '".date('Y-m-d')."') THEN 'Dropout'
			WHEN (program_type = 'full program' AND end_date <= '".date('Y-m-d')."') THEN 'Graduated'
			WHEN (program_type = 'full program' AND end_date > '".date('Y-m-d')."' AND end_date <= '".$active['periode_end_date']."') THEN 'Graduate soon'
			WHEN (end_date >= '".$active['periode_start_date']."') THEN 'Active' 
			ELSE 'active' END)
			 as status");
		$this->db->join('rc_branch b', 'a.branch_id = b.branch_id');
		$this->db->join('list_incentive_sp c', 'a.program_id = c.id');
		$this->db->join('rc_class d', 'a.class_id = d.class_id');
		$this->db->join('participant e', 'a.participant_id = e.participant_id');


		if($param['class'] != 'all'){
			$this->db->where('a.class_id', $param['class']);
		}
		if($param['school'] != 'all'){
			$this->db->where('a.program_id', $param['school']);
		}
		if(!empty($param['branch']) && $param['branch'] != 'all'){
			$this->db->where('a.branch_id', $param['branch']);
		}else{
			if($this->session->userdata('is_spv') == false){
				$this->db->where('a.branch_id', $this->session->userdata('branch'));
			}
		}
		
		if($param['status'] != 'all'){
			if($param['status'] == 'Active'){
			    if($active['periode_start_date'] != ''){
				    $this->db->where('end_date >=', $active['periode_start_date']);
			    }
				$this->db->where('end_date >=', date('Y-m-d'));
				$type = '1';
			}else if($param['status'] == 'Need to upgrade'){
				$this->db->where('program_type', 'modul');
				if($active['periode_end_date'] != ''){
				    $this->db->where('end_date <=', $active['periode_end_date']);
				}
				$this->db->where('end_date >=', date('Y-m-d'));
				$type = '2';
			}else if($param['status'] == 'Dropout'){
				$this->db->where('program_type', 'modul');
				if($active['periode_end_date'] != ''){
				    $this->db->where('end_date <', $active['periode_end_date']);
				}
				$this->db->where('end_date <', date('Y-m-d'));
				$type = '3';
			}else if($param['status'] == 'Graduated'){
				$this->db->where('program_type', 'full program');
				$this->db->where('end_date <=', date('Y-m-d'));
				$type = '4';
			}else if($param['status'] == 'Graduate soon'){
				$this->db->where('program_type', 'full program');
				$this->db->where('end_date >', date('Y-m-d'));
				$this->db->where('end_date <=', $active['periode_end_date']);
				$type = '5';
			}
		}
		if(!empty($param['special'])){
			$this->db->where('special_status', $param['special']);
		}
		if(!empty($start) && !empty($end)){
			$this->db->group_start();
			$this->db->where('start_date <=', $end);
			$this->db->where('end_date >=', $start);
			$this->db->group_end();
		}
		$this->db->order_by('e.participant_name');
		return $this->db->get('rc_student a')->result_array();
	}

	public function get_chart_status_student($status, $branch = null, $program = null, $type = null){
		if($type = 'regular'){
			$active = $this->get_active_periode_now();
		}else{
			$active = $this->get_active_periode_adult_now();
		}
		$this->db->select("COUNT(student_id) as jumlah");
		if($status == 'Active'){
			$this->db->where('end_date >=', $active['periode_start_date']);
			// $this->db->where('end_date >=', date('Y-m-d'));
		}else if($status == 'Need to upgrade'){
			$this->db->where('program_type', 'modul');
			$this->db->where('end_date <=', $active['periode_end_date']);
			$this->db->where('end_date >=', date('Y-m-d'));
		}else if($status == 'Dropout'){
			$this->db->where('program_type', 'modul');
			$this->db->where('end_date <', $active['periode_end_date']);
			// $this->db->where('end_date <', date('Y-m-d'));
		}else if($status == 'Graduated'){
			$this->db->where('program_type', 'full program');
			$this->db->where('end_date <=', date('Y-m-d'));
		}else if($status == 'Graduate soon'){
			$this->db->where('program_type', 'full program');
			$this->db->where('end_date >', date('Y-m-d'));
			$this->db->where('end_date <=', $active['periode_end_date']);
		}
		if(!empty($branch)){
			$this->db->where('branch_id', $branch);
		}
		if(!empty($program)){
			$this->db->where('program_id', $program);
		}
		// $this->db->where('upgrade_to_newmodul', 0);
		$this->db->where('class_id > ', 0);
		return $this->db->get('rc_student a')->row_array()['jumlah'];
		  //dd($this->db->last_query());
	}

	public function get_active_periode_now(){
		$date = date('Y-m-d');
		$sql = "SELECT * from rc_periode where periode_status = 1 and is_adult_class = 0 and periode_start_date <= '$date' and periode_end_date >= '$date'";
		return $this->db->query($sql)->row_array();
	}

	public function get_active_periode_adult_now(){
		$date = date('Y-m-d');
		$sql = "SELECT * from rc_periode where periode_status = 1 and is_adult_class = 1 and periode_start_date <= '$date' and periode_end_date >= '$date'";
		return $this->db->query($sql)->row_array();
	}

	public function get_filtered_student_export($param = array(), $start, $end, $type){
		if($type == 'regular'){
			$this->db->where('g.is_adult_class', 0);
			$active = $this->get_active_periode_now();
		}else{
			$this->db->where('g.is_adult_class', 1);
			$active = $this->get_active_periode_adult_now();
		}
		$this->db->select("b.participant_name, TIMESTAMPDIFF(YEAR, b.birthdate, CURDATE()) AS age, branch_name, class_name, e.name as program, a.program_type, start_date, end_date, (CASE 
			WHEN (program_type = 'modul' AND end_date <= '".$active['periode_end_date']."' AND end_date >= '".date('Y-m-d')."') THEN 'need to upgrade'
			WHEN (program_type = 'modul' AND end_date < '".$active['periode_end_date']."' AND end_date < '".date('Y-m-d')."') THEN 'dropout'
			WHEN (program_type = 'full program' AND end_date <= '".date('Y-m-d')."') THEN 'graduated'
			WHEN (program_type = 'full program' AND end_date > '".date('Y-m-d')."' AND end_date <= '".$active['periode_end_date']."') THEN 'graduate soon'
			WHEN (end_date >= '".$active['periode_start_date']."') THEN 'active' 
			ELSE 'active' END) as status, b.phone, b.email, b.gender, b.birthdate, special_status, special_note, c.participant_name as dad_name, c.phone as dad_phone, c.email as dad_email, d.participant_name as mom_name, d.phone as mom_phone, d.email as mom_email");
		$this->db->join('participant b', 'a.participant_id = b.participant_id');
		$this->db->join('participant c', 'b.dad_id = c.participant_id', 'left');
		$this->db->join('participant d', 'b.mom_id = d.participant_id', 'left');
		$this->db->join('list_incentive_sp e', 'a.program_id = e.id');
		$this->db->join('rc_branch f', 'a.branch_id = f.branch_id');
		$this->db->join('rc_class g', 'a.class_id = g.class_id');
		if($param['class'] != 'all'){
			$this->db->where('a.class_id', $param['class']);
		}
		if($param['school'] != 'all'){
			$this->db->where('a.program_id', $param['school']);
		}
		if(!empty($param['branch']) && $param['branch'] != 'all'){
			$this->db->where('a.branch_id', $param['branch']);
		}else{
			if($this->session->userdata('is_spv') == false){
				$this->db->where('a.branch_id', $this->session->userdata('branch'));
			}
		}
		if($param['status'] != 'all'){
			// $active = $this->get_active_periode_now();
			if($param['status'] == 'Active'){
				$this->db->where('end_date >=', $active['periode_start_date']);
			}else if($param['status'] == 'Need to upgrade'){
				$this->db->where('program_type', 'modul');
				$this->db->where('end_date <=', $active['periode_end_date']);
				$this->db->where('end_date >=', date('Y-m-d'));
			}else if($param['status'] == 'Dropout'){
				$this->db->where('program_type', 'modul');
				$this->db->where('end_date <', $active['periode_end_date']);
				$this->db->where('end_date <', date('Y-m-d'));
			}else if($param['status'] == 'Graduate'){
				$this->db->where('program_type', 'full program');
				$this->db->where('end_date <=', date('Y-m-d'));
			}else if($param['status'] == 'Graduate soon'){
				$this->db->where('program_type', 'full program');
				$this->db->where('end_date >', date('Y-m-d'));
				$this->db->where('end_date <=', $active['periode_end_date']);
			}
		}
		if(!empty($param['special'])){
			$this->db->where('special_status', $param['special']);
		}
		if(!empty($start) && !empty($end)){
			$this->db->group_start();
			$this->db->where('start_date <=', $end);
			$this->db->where('end_date >=', $start);
			$this->db->group_end();
		}
			
		$this->db->order_by('b.participant_name');
		return $this->db->get('rc_student a');
	}

	public function get_history_trx($id){
		$this->db->select('participant_name, event_name, closing_type, paid_value, paid_date, timestamp, remark, d.username as sales, is_paid_off');
		$this->db->join('transaction b', 'a.participant_id = b.participant_id');
		$this->db->join('participant c', 'a.participant_id = c.participant_id');
		$this->db->join('user d', 'b.sales_id = d.id');
		$this->db->where('a.student_id', $id);
		// $this->db->where('is_paid_off', 1);
		$this->db->order_by('timestamp', 'desc');
		return $this->db->get('rc_student a')->result_array();
	}

	public function get_data_submission_by($id){
		$this->db->where('change_id', $id);
		return $this->db->get('rc_apply_change')->row_array();
	}

	public function get_data_student_detail($id){
		$this->db->select('a.*, b.dad_id, b.mom_id, b.participant_name, b.gender, b.phone, b.email, b.birthdate, c.participant_name as dad_name, c.phone as dad_phone, c.email as dad_email, c.job as dad_job, d.participant_name as mom_name, d.phone as mom_phone, d.email as mom_email, d.job as mom_job, branch_name, class_name, e.name as program, special_status, special_note');
		$this->db->join('participant b', 'a.participant_id = b.participant_id');
		$this->db->join('participant c', 'b.dad_id = c.participant_id', 'left');
		$this->db->join('participant d', 'b.mom_id = d.participant_id', 'left');
		$this->db->join('list_incentive_sp e', 'a.program_id = e.id');
		$this->db->join('rc_branch f', 'a.branch_id = f.branch_id');
		$this->db->join('rc_class g', 'a.class_id = g.class_id');
		$this->db->where('a.student_id', $id);
		return $this->db->get('rc_student a')->row_array();
	}


	public function insert($data){
		return $this->db->insert('rc_student', $data);
	}

	public function update($data, $id){
		$this->db->where('student_id', $id);
		return $this->db->update('rc_student', $data);
	}

	public function delete($id){
		$this->db->where('student_id', $id);
		return $this->db->delete('rc_student');
	}

	public function insert_submission($data){
		return $this->db->insert('rc_apply_change', $data);
	}

	public function update_submission($data, $id){
		$this->db->where('change_id', $id);
		return $this->db->update('rc_apply_change', $data);
	}

	public function delete_submission($id){
		$this->db->where('change_id', $id);
		return $this->db->delete('rc_apply_change');
	}

	public function update_absen($data, $where){
		$this->db->where($where);
		return $this->db->update('rc_absen', $data);
	}

}