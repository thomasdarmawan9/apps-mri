<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_branch extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_data($id = null){
		$this->db->select('rc_branch.*, username as name');
		$this->db->join('user', 'rc_branch.branch_lead_trainer = user.id');
		if(!empty($id)){
			$this->db->where('rc_branch.branch_id', $id);
			return $this->db->get('rc_branch')->row_array();
		}else{
			return $this->db->get('rc_branch')->result_array();
		}
	}

	public function get_active_branch(){
		$this->db->select('rc_branch.*, username');
		$this->db->join('user', 'user.id = rc_branch.branch_lead_trainer');
		$this->db->where('branch_status', 1);
		return $this->db->get('rc_branch')->result_array();
	}

	public function get_trainer(){
		$spv = $this->get_spv();
		// $lead = $this->get_lead_trainer();
		$this->db->select('user.id, user.username as name');
		$this->db->join('divisi', 'user.id_divisi = divisi.id');
		$this->db->like('departement', 'MRLC');
		$this->db->where_not_in('user.id', $spv);
		$this->db->where('user.status', 'aktif');
		// $this->db->where_not_in('user.id', $lead);
		$this->db->order_by('user.name');
		return $this->db->get('user')->result_array();
	}

	public function get_spv(){
		$this->db->select('id_user_spv');
		$this->db->like('departement', 'MRLC');
		$result = $this->db->get('divisi')->result_array();
		$data 	= array();
		foreach($result as $row){
			array_push($data, $row['id_user_spv']);
		}
		return $data;
	}

	public function get_lead_trainer(){
		$this->db->select('branch_lead_trainer');
		$result = $this->db->get('rc_branch')->result_array();
		$data 	= array();
		foreach($result as $row){
			array_push($data, $row['branch_lead_trainer']);
		}
		return $data;
	}

	public function get_trainer_without_branch(){
		$spv = $this->get_spv();
		$this->db->select('user.id, username');
		$this->db->join('divisi', 'user.id_divisi = divisi.id');
		$this->db->where('branch_id', 0);
		$this->db->where('user.status', 'aktif');
		$this->db->where_not_in('user.id', $spv);
		$this->db->like('departement', 'MRLC');
		return $this->db->get('user')->result_array();
	}

	public function get_trainer_branch($branch){
		$this->db->select('rc_branch.branch_id, branch_name, username, user.id, branch_lead_trainer');
		$this->db->join('user', 'rc_branch.branch_id = user.branch_id');
		$this->db->where('rc_branch.branch_id', $branch);
		$this->db->where('user.status', 'aktif');
		return $this->db->get('rc_branch')->result_array();
	}

// 	public function get_branch_trainer($id){
// 		$this->db->select('a.branch_id, branch_name');
// 		$this->db->join('rc_branch b', 'a.branch_id = b.branch_id');
// 		$this->db->where('trainer_id', $id);
// 		$this->db->group_by('a.branch_id');
// 		$this->db->order_by('trainer_class_id', 'desc');
// 		return $this->db->get('rc_trainer_class a')->row_array();
// 	}

    // NEW QUERY BRACH TRAINER(RIZKI)
    
    public function get_branch_trainer($id)
    {
        $this->db->select('b.branch_id, branch_name');
        $this->db->join('rc_branch b', 'a.branch_id = b.branch_id', 'inner');
        $this->db->where('a.id', $id);
        return $this->db->get('user a')->row_array();
    }

	public function insert($data){
		return $this->db->insert('rc_branch', $data);
	}

	public function update($data, $id){
		$this->db->where('branch_id', $id);
		return $this->db->update('rc_branch', $data);
	}

	public function update_branch_trainer($lead, $branch){
		$data = array('branch_id' => $branch);
		$this->db->where('id', $lead);
		return $this->db->update('user', $data);
	}

	public function delete($id){
		$this->db->where('branch_id', $id);
		return $this->db->delete('rc_branch');
	}

}