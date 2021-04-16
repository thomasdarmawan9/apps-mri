<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model {

	public function contruct()
	{
		parent::__construct();
	}
	
	public function login($user,$password){
		$this->db->select('user.*, departement, id_user_spv, signup_privilege, student_privilege, user.branch_id, ifnull(branch_lead_trainer, 0) as branch_leader');
		$this->db->from('user');
		$this->db->join('divisi', 'user.id_divisi = divisi.id', 'left');
		$this->db->join('rc_branch', 'user.id = rc_branch.branch_lead_trainer', 'left');
		$this->db->where('username',$user);
		$this->db->where('password',MD5($password));
		$this->db->where('status', 'aktif');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			date_default_timezone_set("Asia/Jakarta");
			
			$data = array(
				'username' => $user,
				'date' => date("Y-m-d H:i:s"),
				'action' => 'login',
				'notes' => $password
			);
			
			$this->db->insert('history_access',$data);
			return $query->result();	    
		}else{
			return false;
		}
	}

	public function getusername(){
	    
	    if(!empty($this->session->userdata('is_hr_division'))){
	        $division = unserialize($this->session->userdata('is_hr_division'));
	        $this->db->where_in('id_divisi',$division);
	    }
	    
	    $where = '(status="aktif" or status is null)';
		$this->db->where($where);
		$this->db->where('level', 'user');
		$query = $this->db->get('user');
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getusername_api($post){
	    
	    if(!empty($post['is_hr_division'])){
	        $division = unserialize($post['is_hr_division']);
	        $this->db->where_in('id_divisi',$division);
	    }
	    
	    $where = '(status="aktif" or status is null)';
		$this->db->where($where);
		$this->db->where('level', 'user');
		$query = $this->db->get('user');
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function add_hr($data){
	    return $this->db->insert('user',$data);
	}
	
	public function get_hr($id=null){
	    $this->db->where('level','hr');
	    if(!empty($id)){
	        $this->db->where('id',$id);
	        return $this->db->get('user')->row();
	    }else{
	        return $this->db->get('user')->result();
	    }
	}
	
	public function edit_hr($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update('user',$data);
	}
	
	public function delete_hr($id){
	    $this->db->where('id',$id);
	    return $this->db->delete('user');
	}
	
	public function get_warrior_story(){
		$where = '(status="aktif" or status is null)';
		$this->db->where($where);
		$this->db->where('level', 'user');
		$this->db->where('link_warrior_story is NOT NULL', NULL, FALSE);
		$this->db->order_by('id', 'RANDOM');
		$query = $this->db->get('user');
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function delete_divisi($id){
	    
	    //Melakukan update divisi menjadi kosong
	    $data = array ( 'id_divisi' => null );
	    $this->db->where('id_divisi',$id);
	    $this->db->update('user',$data);
	    
	    
	    $this->db->where('id',$id);
	    return $this->db->delete('divisi');
	}
	
	public function add_divisi($data){
	    return $this->db->insert('divisi',$data);
	}
	
	public function add_manager($data){
	    return $this->db->insert('manager',$data);
	}
	
	public function edit_divisi_manager($id = null)
	{
		$this->db->select('manager.*, divisi.departement, user.username');
		$this->db->join('divisi', 'divisi.id = manager.detail_access_divisi', 'left');
		$this->db->join('user', 'user.id = manager.id_user', 'left');
		// $this->db->order_by('divisi.departement');
		if (!empty($id)) {
			$this->db->where('id_manager', $id);
			return $this->db->get('manager')->row();
		} else {
			return $this->db->get('manager')->result();
		}
	}

	public function edit_manager($id, $data)
	{
		$this->db->where('id_manager', $id);
		return $this->db->update('manager', $data);
	}
	
	public function get_manager($id=null){
	    if($id <> null){
	        $this->db->where('id_user',$id);
	    }
	    
	    $this->db->from('manager');
	    $this->db->join('user','manager.id_user = user.id');
	    return $this->db->get()->result();
	}

	public function getuser_person($getname){
		$this->db->where('username',$getname);
		
		$query = $this->db->get('user');
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function cek_next_pass($lp){
		
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('id',$this->session->userdata('id'));
		$this->db->where('password',MD5($lp));
		$query = $this->db->get();
		if ($query -> num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function change_pass($np){
		$data = array(
			'password' => md5($np)	               	                         
		);
		
		$this->db->where('id', $this->session->userdata('id'));
		return $this->db->update('user', $data);
	}
	
	public function change_photo($photo){
	    
	    //Check Photo first
	    $this->db->where('id', $this->session->userdata('id'));
	    $where = "picture is  NOT NULL";
        $this->db->where($where);
        
	    $query = $this->db->get('user');
	    
	    if($query->num_rows() == 1){
	        $get = $query->row()->picture;
	        unlink("inc/image/warriors/".$get);
	        unlink("inc/image/warriors/pp/".$get);
	    }
	    
	    $data = array(
	        'picture' => $photo  
	    );
	    
	    $this->db->where('id', $this->session->userdata('id'));
		return $this->db->update('user', $data);
	}

	public function getuser_admin(){
		$this->db->order_by('status');
		$this->db->where('level', 'user');
		$query = $this->db->get('user');
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function delete_manager($id){
	    $this->db->where('id_manager',$id);
	    return $this->db->delete('manager');
	}
	
	public function edit_divisi($id,$divisiname,$id_spvuser){
	    $this->db->where('id',$id);
	    $data = array ( 'departement' => $divisiname, 'id_user_spv' => $id_spvuser);
	    return $this->db->update('divisi',$data);
	}
	
	public function get_divisi($id=null){
	    if($id <> null){
	        $this->db->where('divisi.id',$id);
	    }
	    
	    $this->db->select('*, divisi.id as divisiid');
	    $this->db->from('divisi');
	    $this->db->join('user', 'divisi.id_user_spv = user.id');
	    return $this->db->get()->result();
	}
	
	public function get_all_division()
	{
		return $this->db->get('divisi')->result();
	}
	
	public function get_user_divisi($id){
	    $this->db->select('*, user.id as usi');
	    $this->db->where('divisi.id',$id);
	    $this->db->where('status','aktif');
	    $this->db->from('user');
	    $this->db->join('divisi', 'divisi.id = user.id_divisi');
	    return $this->db->get()->result();
	}

	public function cek_user_null($username, $email){
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	
	 	if ($query -> num_rows() == null){
			$this->db->where('email',$email);
	 		$query = $this->db->get('user');
	 		
	 		if ($query -> num_rows() == null){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function tambah_user($nama, $username, $email, $pass, $jenis, $ci, $cs, $lembur){
	 	$data = array (
	 		'name' => ucwords($nama),
	 		'username' => strtolower($username),
	 		'email' => $email,
	 		'jenis_cuti' => $jenis,
	 		'password' => md5($pass)
	 	);
	 	
	 	$this->db->insert('user',$data);
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	
	 	foreach($query->result() as $n){
	 		$nm = $n->id;
	 	}
	 	
	 	//set cuti izin right now
	 	$data = array (
	 		'id_user' => $nm,
	 		'tgl' => date('Y-m-j'),
	 		'deskripsi' => 'Set Awal Cuti Izin',
	 		'plus' => $ci
	 	);
	 	
	 	$this->db->insert('cuti_izin',$data);
	 	
	 	//set cuti sakit right now
	 	$data = array (
	 		'id_user' => $nm,
	 		'tgl' => date('Y-m-j'),
	 		'deskripsi' => 'Set Awal Cuti Sakit',
	 		'plus' => $cs
	 	);
	 	
	 	$this->db->insert('cuti_sakit',$data);
	 	
	 	//set lembur right now
	 	$data = array (
	 		'id_user' => $nm,
	 		'tgl' => date('Y-m-j'),
	 		'deskripsi' => 'Set Awal Lembur',
	 		'nilai' => $lembur
	 	);
	 	
	 	$this->db->insert('lembur',$data);
	 	
	 	return true;
	}

	public function hapus_user($id){
	 	$this->db->where('id',$id);
	 	$this->db->delete('user'); 
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->delete('lembur'); 
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->delete('cuti_izin');
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->delete('cuti_sakit');
	 	
	 	return true;
	}

	public function get_edit_user($id){
	    $this->db->select('*, user.id as idu');
	    $this->db->from('user');
	    $this->db->join('divisi', 'divisi.id = user.id_divisi', 'left');
	 	$this->db->where('user.id',$id);
	 	$query = $this->db->get();
	 	
	 	return $query->result();
	}

	public function getdivisi(){
	    $query = $this->db->get('divisi');
	    return $query->result();
	}

	public function edit_user($id, $nama, $jenis_cuti, $depart, $status){
	 	$data = array (
	 		'name' => $nama,
	 		'jenis_cuti' => $jenis_cuti,
	 		'id_divisi' => $depart,
	 		'status' => $status
	 	);
	 	
	 	$this->db->where('id',$id);
	 	return $this->db->update('user',$data);
	}
	
	public function getuser(){
	 	$where = '(status="aktif" or status is null)';
       	$this->db->where($where);
       		
	 	$query = $this->db->get('user');
	 	if ($query -> num_rows() > 0){
	 		return $query->result();
	 	}else{
	 		return false;
	 	}
	 }
	 
	public function get_pt(){
		$this->db->order_by('id_pt');
		$query = $this->db->get('fc_pt');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
   public function get_detail_bank()
	{
		$this->db->order_by('id_bank');
		$query = $this->db->get('fc_bank');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_bank()
	{
		$this->db->select('fc_bank.id_bank, fc_bank.rek_bank, fc_bank.name, fc_bank.saldo_awal, fc_bank.atas_nama ,fc_bank.saldo_awal+SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as nl, SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as tr, SUM(fc_transaksi.income) as ic, SUM(fc_transaksi.expense) as ex, fc_pt.name as pt');
		$this->db->from('fc_bank');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->join('fc_transaksi', 'fc_transaksi.id_bank = fc_bank.id_bank', 'left');

		if ($this->session->userdata('id') == '67') {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			//$this->db->group_by('fc_transaksi.id_bank');
			$this->db->group_by('fc_bank.id_bank');
			$this->db->order_by('fc_bank.id_bank', 'DESC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		} else if ($this->session->userdata('is_pt') == true) {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			//$this->db->group_by('fc_transaksi.id_bank');
			//$this->db->group_by('fc_transfer_in.id_bank');
			$this->db->group_by('fc_bank.id_bank');
			$this->db->order_by('fc_bank.id_bank', 'DESC');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		}
	}
	
	public function get_fc_hdivisi()
	{
		$this->db->order_by('no_hdivisi', 'ASC');
		$query = $this->db->get('fc_hdivisi');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_fc_divisi()
	{
		$this->db->order_by('no_divisi', 'ASC');
		$query = $this->db->get('fc_divisi');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_indeks()
	{
		$this->db->select('fc_indeks.*, fc_divisi.no_divisi, fc_divisi.nama_divisi');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_indeks.id_divisi', 'left');
		$this->db->order_by('fc_indeks.no_indeks', 'ASC');
		$query = $this->db->get('fc_indeks');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getuser_finance($id = null)
	{
		$this->db->select('user.*, fc_pt.name as pt');
		$this->db->join('fc_pt', 'fc_pt.id_pt = user.id_pt', 'left');
		$this->db->order_by('user.name');
		$this->db->where('user.level', 'finance');
		if (!empty($id)) {
			$this->db->where('id', $id);
			return $this->db->get('user')->row();
		} else {
			return $this->db->get('user')->result();
		}
	}
	
}
