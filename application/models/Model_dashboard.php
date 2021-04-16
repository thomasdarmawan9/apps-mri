<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dashboard extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	
    public function get_infomation()
    {
        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $information = $this->db->get('rc_information')->row();

        return $information;
	}
	
	public function get_list()
    {
        $this->db->select('list_sp.*, user.username');
        $this->db->join('user', 'user.id = list_sp.id_user', 'left');
        $this->db->where('list_sp.date_event', date('Y-m-d'));
        $this->db->order_by('list_sp.id', 'desc');
        return $this->db->get('list_sp')->result();
	}
	
	public function get_branch_leader()
    {
        $this->db->select('rc_branch.*, user.username, user.picture');
        $this->db->join('user', 'user.id = rc_branch.branch_lead_trainer', 'left');
        $this->db->where_not_in('rc_branch.branch_id', '0');
        $this->db->order_by('rc_branch.branch_id', 'asc');
        $branch_leader = $this->db->get('rc_branch');

        if ($branch_leader->num_rows() > 0) {
            return $branch_leader->result();
        } else {
            return false;
        }
	}
	
	
    public function get_student_active()
    {
        $active = $this->model_student->get_active_periode_now();
        $this->db->where('d.is_adult_class', 0);
        $this->db->select("a.*, participant_name, branch_name, class_name, c.name as program, TIMESTAMPDIFF(YEAR, e.birthdate, CURDATE()) AS age, 
        count(CASE 
        WHEN (program_type = 'modul' AND end_date <= '" . $active['periode_end_date'] . "' AND end_date >= '" . date('Y-m-d') . "') THEN 'Need to upgrade'
        WHEN (program_type = 'modul' AND end_date < '" . $active['periode_end_date'] . "' AND end_date < '" . date('Y-m-d') . "') THEN 'Dropout'
        WHEN (program_type = 'full program' AND end_date <= '" . date('Y-m-d') . "') THEN 'Graduated'
        WHEN (program_type = 'full program' AND end_date > '" . date('Y-m-d') . "' AND end_date <= '" . $active['periode_end_date'] . "') THEN 'Graduate soon'
        WHEN (end_date >= '" . $active['periode_start_date'] . "') THEN 'Active' 
        ELSE 'active' END)
         as status");
        $this->db->join('rc_branch b', 'a.branch_id = b.branch_id');
        $this->db->join('list_incentive_sp c', 'a.program_id = c.id');
        $this->db->join('rc_class d', 'a.class_id = d.class_id');
        $this->db->join('participant e', 'a.participant_id = e.participant_id');
        $this->db->where('end_date >=', $active['periode_start_date']);
        $this->db->where('end_date >=', date('Y-m-d'));

        $query =  $this->db->get('rc_student a')->result();

        foreach ($query as $row) {
            $student_active = $row->status;
        }

        return $student_active;
	}
	
	public function get_student_upgrade()
    {
        $active = $this->model_student->get_active_periode_now();
        $this->db->where('d.is_adult_class', 0);
        $this->db->select("a.*, participant_name, branch_name, class_name, c.name as program, TIMESTAMPDIFF(YEAR, e.birthdate, CURDATE()) AS age, 
        count(CASE 
        WHEN (program_type = 'modul' AND end_date <= '" . $active['periode_end_date'] . "' AND end_date >= '" . date('Y-m-d') . "') THEN 'Need to upgrade'
        WHEN (program_type = 'modul' AND end_date < '" . $active['periode_end_date'] . "' AND end_date < '" . date('Y-m-d') . "') THEN 'Dropout'
        WHEN (program_type = 'full program' AND end_date <= '" . date('Y-m-d') . "') THEN 'Graduated'
        WHEN (program_type = 'full program' AND end_date > '" . date('Y-m-d') . "' AND end_date <= '" . $active['periode_end_date'] . "') THEN 'Graduate soon'
        WHEN (end_date >= '" . $active['periode_start_date'] . "') THEN 'Active' 
        ELSE 'active' END)
         as status");
        $this->db->join('rc_branch b', 'a.branch_id = b.branch_id');
        $this->db->join('list_incentive_sp c', 'a.program_id = c.id');
        $this->db->join('rc_class d', 'a.class_id = d.class_id');
        $this->db->join('participant e', 'a.participant_id = e.participant_id');
        $this->db->where('program_type', 'modul');
        $this->db->where('end_date <=', $active['periode_end_date']);
        $this->db->where('end_date >=', date('Y-m-d'));

        $query = $this->db->get('rc_student a')->result();

        foreach ($query as $row) {
            $student_upgrade = $row->status;
        }

        return $student_upgrade;
	}
	
	
    public function get_student_grdsn()
    {
        $active = $this->model_student->get_active_periode_now();
        $this->db->where('d.is_adult_class', 0);
        $this->db->select("a.*, participant_name, branch_name, class_name, c.name as program, TIMESTAMPDIFF(YEAR, e.birthdate, CURDATE()) AS age, 
        count(CASE 
        WHEN (program_type = 'modul' AND end_date <= '" . $active['periode_end_date'] . "' AND end_date >= '" . date('Y-m-d') . "') THEN 'Need to upgrade'
        WHEN (program_type = 'modul' AND end_date < '" . $active['periode_end_date'] . "' AND end_date < '" . date('Y-m-d') . "') THEN 'Dropout'
        WHEN (program_type = 'full program' AND end_date <= '" . date('Y-m-d') . "') THEN 'Graduated'
        WHEN (program_type = 'full program' AND end_date > '" . date('Y-m-d') . "' AND end_date <= '" . $active['periode_end_date'] . "') THEN 'Graduate soon'
        WHEN (end_date >= '" . $active['periode_start_date'] . "') THEN 'Active' 
        ELSE 'active' END)
         as status");
        $this->db->join('rc_branch b', 'a.branch_id = b.branch_id');
        $this->db->join('list_incentive_sp c', 'a.program_id = c.id');
        $this->db->join('rc_class d', 'a.class_id = d.class_id');
        $this->db->join('participant e', 'a.participant_id = e.participant_id');
        $this->db->where('program_type', 'full program');
        $this->db->where('end_date >', date('Y-m-d'));
        $this->db->where('end_date <=', $active['periode_end_date']);

        $query = $this->db->get('rc_student a')->result();

        foreach ($query as $row) {
            $student_grdsn = $row->status;
        }

        return $student_grdsn;
    }
	
	public function get_all_photo(){
	    $where = "picture is  NOT NULL";
        $this->db->where($where);
        $this->db->where('status','aktif');
        $this->db->where('level','user');
        $this->db->order_by('id', 'RANDOM');
        
        $query = $this->db->get('user');
        
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
        
	}
	
	public function get_birthdate(){
	    $this->db->where('DAY(birthday)', date('d'));
	    $this->db->where('MONTH(birthday)', date('m'));
	    $this->db->where('status', 'aktif');
	    
	    $query = $this->db->get('user');
	    
	    if($query->num_rows() > 0){
	        return $query->result();
	    }else{
	        return false;
	    }
	}

	public function insert_event($data)
    {
        return $this->db->insert('list_sp', $data);
    }



}