<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_absensi extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	

	public function get_list_class($periode, $branch, $trainer){
		$this->db->select('a.trainer_class_id, b.periode_id, e.name as program, b.periode_modul, f.class_name, b.presence, a.last_session, a.periode_detail_id, a.branch_id, a.program_id, a.class_id');
		$this->db->join('rc_periode_detail b', 'a.periode_detail_id = b.periode_detail_id');
		$this->db->join('list_incentive_sp e', 'a.program_id = e.id');
		$this->db->join('rc_class f', 'a.class_id = f.class_id');
		$this->db->where('b.periode_id', $periode);
		$this->db->where('a.branch_id', $branch);
		$this->db->where('a.trainer_id', $trainer);
		return $this->db->get('rc_trainer_class a')->result_array();
	}

	public function get_student_class($branch, $program, $class, $start, $end, $is_adult = 0){
		$this->db->select('student_id, b.participant_name, program_type, start_date, end_date, a.branch_id, a.class_id, c.branch_name, a.program_id, d.name as program, e.class_name');
		if($branch != 'all'){
			$this->db->where('a.branch_id', $branch);
		}
		if($class != 'all'){
			$this->db->where('a.class_id', $class);
		}

		if($is_adult > 0){
			$this->db->where('e.is_adult_class', 1);
		}
		$this->db->where('a.program_id', $program);
		$this->db->where('student_status', 'active');
		$this->db->group_start();
		$this->db->where('start_date <=', $end);
		$this->db->where('end_date >=', $start);
		$this->db->group_end();
		$this->db->join('participant b', 'a.participant_id = b.participant_id');
		$this->db->join('rc_branch c', 'a.branch_id = c.branch_id');
		$this->db->join('list_incentive_sp d', 'a.program_id = d.id');
		$this->db->join('rc_class e', 'a.class_id = e.class_id');
		$this->db->order_by('participant_name');
		return $this->db->get('rc_student a')->result_array();
		// dd($this->db->last_query());
	}

	public function get_list_absen($periode_detail, $branch, $program, $class, $sesi){
		$this->db->select('a.absen_id, a.student_id, participant_name, d.name as program, e.class_name, is_attend, is_change, change_to, f.branch_name as branch_to, g.class_name as class_to, h.branch_name as branch_from, i.class_name as class_from');
		$this->db->join('rc_student b', 'a.student_id = b.student_id');
		$this->db->join('participant c', 'b.participant_id = c.participant_id');
		$this->db->join('list_incentive_sp d', 'a.program_id = d.id');
		$this->db->join('rc_class e', 'a.class_id = e.class_id');
		$this->db->join('rc_branch f', 'a.branch_id_change = f.branch_id', 'left');
		$this->db->join('rc_class g', 'a.class_id_change = g.class_id', 'left');
		$this->db->join('rc_branch h', 'a.branch_id_from = h.branch_id', 'left');
		$this->db->join('rc_class i', 'a.class_id_from = i.class_id', 'left');
		$this->db->where('a.periode_detail_id', $periode_detail);
		$this->db->where('a.branch_id', $branch);
		$this->db->where('a.program_id', $program);
		$this->db->where('a.class_id', $class);
		$this->db->where('a.session', $sesi);
		$this->db->order_by('participant_name');
		return $this->db->get('rc_absen a')->result_array();
	}

	public function get_list_absen_rekap($periode_detail, $branch, $program, $class, $sesi){
		$this->db->where('periode_detail_id', $periode_detail);
		$this->db->where('branch_id', $branch);
		$this->db->where('program_id', $program);
		$this->db->where('class_id', $class);
		$this->db->where('session', $sesi);
		return $this->db->get('rc_absen_recap')->row_array();
	}

	public function get_list_class_spv($filter, $type){
		$this->db->select('a.trainer_class_id, b.periode_id, periode_name, branch_name, e.name as program, b.periode_modul, f.class_name, g.username as name, presence, last_session, a.periode_detail_id, a.branch_id, a.program_id, a.class_id');
		$this->db->join('rc_periode_detail b', 'a.periode_detail_id = b.periode_detail_id');
		$this->db->join('rc_periode c', 'b.periode_id = c.periode_id');
		$this->db->join('rc_branch d', 'a.branch_id = d.branch_id');
		$this->db->join('list_incentive_sp e', 'a.program_id = e.id');
		$this->db->join('rc_class f', 'a.class_id = f.class_id');
		$this->db->join('user g', 'a.trainer_id = g.id');
		if($type == 'regular'){
			$this->db->where('f.is_adult_class', 0);
		}else{
			$this->db->where('f.is_adult_class', 1);
		}
		if(!empty($filter) && $filter['periode'] != 'all'){
			$this->db->where('b.periode_id', $filter['periode']);
		}
		if(!empty($filter) && $filter['branch'] != 'all'){
			$this->db->where('a.branch_id', $filter['branch']);
		}
		if(!empty($filter) && $filter['school'] != 'all'){
			$this->db->where('a.program_id', $filter['school']);
		}
		if(!empty($filter) && $filter['class'] != 'all'){
			$this->db->where('a.class_id', $filter['class']);
		}
		$this->db->where('c.periode_status', 1);
		$this->db->order_by('periode_start_date', 'desc');
		$this->db->order_by('a.branch_id');
		$this->db->order_by('a.program_id');
		$this->db->order_by('a.class_id');
		return $this->db->get('rc_trainer_class a')->result_array();
	}

	public function get_list_absen_export($periode_detail, $branch, $program, $class, $start, $end, $sesi){

		$query = "	
					SELECT a.student_id, b.participant_name, c.session, c.is_attend
					FROM rc_student a 
					JOIN participant b on a.participant_id = b.participant_id
					JOIN rc_absen c on a.student_id = c.student_id
					WHERE a.branch_id = '$branch' AND a.program_id = '$program' AND a.class_id = '$class' AND c.periode_detail_id = '$periode_detail' AND student_status = 'active'
					AND (start_date <= '$end' AND end_date >= '$start') AND session = '$sesi'
					ORDER BY participant_name
					";
		return $this->db->query($query)->result_array();
	}

	public function get_rekap_absen($periode, $branch = null){
		$this->db->select('a.*');
		$this->db->join('rc_periode_detail b', 'a.periode_detail_id = b.periode_detail_id');
		$this->db->where('b.periode_id', $periode);
		if(!empty($branch)){
			$this->db->where('a.branch_id', $branch);
		}
		return $this->db->get('rc_absen_recap a')->result_array();
	}

	public function get_rekap_absen_spv($param = null, $type){
		$this->db->select('a.*');
		$this->db->join('rc_periode_detail b', 'a.periode_detail_id = b.periode_detail_id');
		if(!empty($param['periode']) && $param['periode'] != 'all'){
			$this->db->where('b.periode_id', $param['periode']);
		}
		if(!empty($param['branch']) && $param['branch'] != 'all'){
			$this->db->where('a.branch_id', $param['branch']);
		}
		if(!empty($param['school']) && $param['school'] != 'all'){
			$this->db->where('a.program_id', $param['school']);
		}
		if(!empty($param['class']) && $param['class'] != 'all'){
			$this->db->where('a.class_id', $param['class']);
		}
		$this->db->join('rc_class c', 'a.class_id = c.class_id');
		if($type == 'regular'){
			$this->db->where('c.is_adult_class', 0);
		}else{
			$this->db->where('c.is_adult_class', 1);
		}
		return $this->db->get('rc_absen_recap a')->result_array();
	}

	public function insert($data){
		return $this->db->insert('rc_absen', $data);
	}

	public function update($data, $id){
		$this->db->where('absen_id', $id);
		return $this->db->update('rc_absen', $data);
	}

	public function delete($id){
		$this->db->where('absen_id', $id);
		return $this->db->delete('rc_absen');
	}

	public function delete_change_to($id){
		$this->db->where('change_to', $id);
		return $this->db->delete('rc_absen');
	}

	public function delete_by_student($id){
		$this->db->where('student_id', $id);
		return $this->db->delete('rc_absen');
	}

	public function insert_recap($data){
		return $this->db->insert('rc_absen_recap', $data);
	}

	public function update_recap($data, $id){
		$this->db->where('recap_id', $id);
		return $this->db->update('rc_absen_recap', $data);
	}


}