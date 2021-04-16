<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_task_api extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_info_event($id){
		$this->db->where('id',$id);
		$query =  $this->db->get('list_incentive_sp');
		return $query ->result();
	}
	
	public function get_satuan_task($id){
		$this->db->where('id',$id);
		$query = $this->db->get('task');

		if ($query -> num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_mytask(){
		$date_start = date('Y-m-d', strtotime("-30 days"));
		$date_end = date('Y-m-d', strtotime("+360 days"));
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (id_user='.$this->session->userdata('id').' OR (id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti = "ya"))' ;
		$this->db->select('*, task_user.id as tui');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->where($where);
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function get_all_branch()
	{
		$this->db->where_not_in('branch_id','0');
		$query = $this->db->get('rc_branch');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_all_event()
	{
		$query = $this->db->get('list_incentive_sp');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
		
	}

	public function get_minus_event(){

		$date_start = '2016-01-01';
		$date_end = date('Y-m-d', strtotime("-1 days"));
		
		$where = '((date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (id_user='.$this->session->userdata('id').' AND (task_user.hadir = "tidak")) AND (paytask is Null) )' ;

		$this->db->select('*, task_user.id as tui');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->where($where);
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

	public function get_plus_event(){
		$this->db->where('paytask',1);
		$this->db->where('hadir','ya');
		$this->db->where('id_user',$this->session->userdata('id'));
		$query = $this->db->get('task_user');

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

	public function get_request_task(){

		$where = 'id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti ='.null;

		$this->db->select('*, task_user.id as tui');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->where($where);
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

	public function get_submission_task(){

		$date_start = date('Y-m-d', strtotime("-1 days"));
		$date_end = date('Y-m-d', strtotime("+360 days"));
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND id_user='.$this->session->userdata('id').' AND id_pengganti <>'.null;

		$this->db->select('*, task_user.id as tui');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->where($where);
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

	public function get_all_mytask(){
		$where = 'id_user='.$this->session->userdata('id').' OR (id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti = "ya") ';

		$this->db->select('*, task_user.id as tui');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->where($where);
		$this->db->order_by('date','desc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

	public function get_username_penggantitask($id){
		$this->db->where('id',$id);
		$query = $this->db->get('user');

		if ($query -> num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function batalkan_pertukaran($idevent){

		$data = array(
			'id_pengganti' => null,
			'persetujuan_pengganti' => null
		);

		$this->db->where('id',$idevent);
		return $this->db->update('task_user',$data);
	}

	public function event_digantikan_cek($idevent, $getname){
		$this->db->where('username',$getname);
		$iduser = $this->db->get('user')->row_array()['id'];

		$this->db->where('id',$idevent);
		$idt = $this->db->get('task_user')->row_array()['id_task'];

		$this->db->where('id_task',$idt);
		$this->db->where('id_user',$iduser);
		$query = $this->db->get('task_user');

		if ($query -> num_rows() <> 0){
			return false;
		}else{
			return true;
		}
	}

	public function event_digantikan_request($idevent, $getname){
		$this->db->where('username',$getname);
		$iduser = $this->db->get('user')->row_array()['id'];

		$this->db->where('id',$idevent);
		$idt = $this->db->get('task_user')->row_array()['id_task'];

		$this->db->where('id_task',$idt);
		$this->db->where('id_pengganti',$iduser);
		$query = $this->db->get('task_user');

		if ($query -> num_rows() <> 0){
			return false;
		}else{
			return true;
		}
	}

	public function event_digantikan($idevent, $getname){
		$this->db->where('username',$getname);
		$iduser = $this->db->get('user')->row_array()['id'];

		$data = array(
			'id_pengganti' => $iduser,
			'persetujuan_pengganti' => null
		);

		$this->db->where('id',$idevent);
		$this->db->update('task_user',$data);
		return true;
	}

	public function get_event($idevent, $id_user){
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->where('task_user.id',$idevent);
		$this->db->where('id_user',$id_user);
		$query = $this->db->get();
		return $query->result();
	}

	public function approve_request_task($idtask, $idpengganti){
		$data = array(
			'id_pengganti' => $idpengganti,
			'persetujuan_pengganti' => 'ya'
		);

		$this->db->where('id',$idtask);
		return $this->db->update('task_user',$data);
	}

	public function reject_konfirmasi_pertukaran($idevent){
		$data = array(
			'id_pengganti' => null,
			'persetujuan_pengganti' => null
		);

		$this->db->where('id',$idevent);
		return $this->db->update('task_user',$data);
	}

	public function get_user_mail($idevent){

		$this->db->where('id',$idevent);
		$idu = $this->db->get('task_user')->row_array()['id_user'];

		$this->db->where('id',$idu);
		$query = $this->db->get('user');

		return $query->result();
	}

	public function getusername_event($idevent){
		$this->db->where('id_task',$idevent);
		$query = $this->db->get('task_user');
		return $query->result();
	}

	public function getusername_event_get($id){
		$this->db->where('id',$id);
		$qn = $this->db->get('user');
		return $qn->result();
	}

	public function getidtask_get($idevent){
		$this->db->where('id', $idevent);
		$query = $this->db->get('task');
		return $query->result();
	}

	public function user_add_task_paytask(){
		$ignore = array('taskadmin', 'admin', 'finance');
		$this->db->where_not_in('username', $ignore);
		$where = '(status="aktif" or status is null)';
		$this->db->where($where);
		$query = $this->db->get('user');
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_task($post){
		// dd($post);
		// die();
		$sesid = $post['id'];
		$seddiv = $post['iddivisi'];
	    $student = "SELECT `student_privilege` FROM `divisi` WHERE `id_user_spv` = $sesid";
		$divisi = $this->db->query($student)->row('student_privilege');
		
		$branch = $this->db->select('b.alias')
					->from('divisihasbranch a')
					->join('rc_branch b', 'a.branch_id = b.branch_id')
					->where('a.divisi_id', $seddiv)
					->get()->result();

		$branch_name = array();

		foreach($branch as $row){
			array_push($branch_name, $row->alias);
		}
		$this->db->select('*, task.id as idt');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		if($divisi != 0){
			$this->db->join('divisihasbranch', 'task.id_divisi = divisihasbranch.divisi_id', 'left');
			$this->db->join('rc_branch', 'divisihasbranch.branch_id = rc_branch.branch_id', 'left');
		}
		
		$date_start = date('Y-m-d');
		$thn 		= date('Y') + 1;
		$date_end 	= date(''.$thn.'-m-d');
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
		// if($this->session->userdata('id') != '190' || $this->session->userdata('id') != '72'){
			if($divisi == 1){
				// $type ='1';
				$this->db->where_in('location', $branch_name);
			}
		// }
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
		$this->db->where($where);

		$this->db->order_by('date','desc');
		$this->db->order_by('idt','desc');
		$this->db->group_by('task.id');

		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function get_task_lama(){
		$this->db->select('*, task.id as idt');
		$this->db->from('task');

		$date_start = date('Y-m-d');
		$thn 		= date('Y') + 1;
		$date_end 	= date(''.$thn.'-m-d');
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
		$this->db->where($where);
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		
		if($this->session->userdata('id') != '190' || $this->session->userdata('id') != '72'){
			$this->db->where('task.id_divisi', $this->session->userdata('iddivisi'));
		}
		
		$this->db->order_by('date','asc');
		$this->db->order_by('event','asc');
		$this->db->order_by('idt','asc');
		$this->db->group_by('task.id');
		
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function get_divisi()
	{
		$this->db->select('*');
		$this->db->from('divisi');
		$this->db->where_not_in('id', array('4', '7', '14', '32', '34', '35', '36'));
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function user_add_task_paytask_adding($idevent, $username){

		$this->db->where('username',$username);
		$id_user = $this->db->get('user')->row_array()['id'];
		
		$this->db->where('id_user',$id_user);
		$this->db->where('id_task',$idevent);
		$query = $this->db->get('task_user');
		
		if ($query -> num_rows() > 0){
			return false;
		}else{
			$data = array(
				'id_task' => $idevent,
				'id_user' => $id_user,
				'paytask' => 1
			);

			return $this->db->insert('task_user',$data);
		}
	}

	public function update_report_pd($idevent, $iduser, $tugas, $dp, $modul, $lunas, $hadir){

		if(empty($hadir)){
			$hadir = null;
		}
		if(empty($dp)){
			$dp = null;
		}
		if(empty($modul)){
			$modul = null;
		}
		if(empty($lunas)){
			$lunas = null;
		}

		$this->db->where('id_user',$iduser);
		$this->db->where('id_task',$idevent);
		$query = $this->db->get('task_user');

		if ($query -> num_rows() == 1){
			$data = array(
				'tugas' => $tugas,
				'dp' => $dp,
				'modul' => $modul,
				'lunas' => $lunas,
				'hadir' => $hadir
			);

			$this->db->where('id_task',$idevent);
			$this->db->where('id_user',$iduser);
			return $this->db->update('task_user',$data);
		}else{
			$data = array(
				'tugas' => $tugas,
				'dp' => $dp,
				'modul' => $modul,
				'lunas' => $lunas,
				'hadir' => $hadir
			);

			$this->db->where('id_task',$idevent);
			$this->db->where('id_pengganti',$iduser);
			$this->db->where('persetujuan_pengganti','ya');
			return $this->db->update('task_user',$data);
		}
	}

	public function update_report_pd_task($idevent, $daftar, $ots, $hadir, $tidak_hadir){

		$data = array(
			'daftar' => $daftar,
			'ots' => $ots,
			'hadir' => $hadir,
			'tidak_hadir' => $tidak_hadir	 		
		);

		$this->db->where('id',$idevent);
		return $this->db->update('task',$data);
	}

	public function tambah_task($nama, $location, $date, $jenis_report, $komisi_lunas, $komisi_dp, $id_divisi,$lokasi){
// 		$data = array(
// 			'event' => $nama,
// 			'location' => $location,
// 			'date' => $date,
// 			'jenis_report' => $jenis_report,
// 			'komisi_lunas' => $komisi_lunas,
// 			'komisi_dp' => $komisi_dp,
// 			'id_divisi' => $id_divisi
// 		);

// 		return $this->db->insert('task',$data);

        if ($lokasi == 'others') {
			$data = array(
				'event' => $nama,
				'location' => $location,
				'date' => $date,
				'jenis_report' => $jenis_report,
				'komisi_lunas' => $komisi_lunas,
				'komisi_dp' => $komisi_dp,
				'id_divisi' => $id_divisi
			);
		}else{
			$data = array(
				'event' => $nama,
				'location' => $lokasi,
				'date' => $date,
				'jenis_report' => $jenis_report,
				'komisi_lunas' => $komisi_lunas,
				'komisi_dp' => $komisi_dp,
				'id_divisi' => $id_divisi
			);
		}

		return $this->db->insert('task', $data);
	}

	public function edit_task($id, $nama, $location, $tgl, $jenis_report, $komisi_dp, $komisi_lunas, $id_divisi,$lokasi){
// 		$data = array(
// 			'event' => $nama,
// 			'location' => $location,
// 			'date' => $tgl,
// 			'jenis_report' => $jenis_report,
// 			'komisi_dp' => $komisi_dp,
// 			'komisi_lunas' => $komisi_lunas,
// 			'id_divisi' => $id_divisi
// 		);

// 		$this->db->where('id',$id);
// 		return $this->db->update('task',$data);

        if ($lokasi == 'others') {
			$data = array(
				'event' => $nama,
				'location' => $location,
				'date' => $tgl,
				'jenis_report' => $jenis_report,
				'komisi_lunas' => $komisi_lunas,
				'komisi_dp' => $komisi_dp,
				'id_divisi' => $id_divisi
			);
		}else{
			$data = array(
				'event' => $nama,
				'location' => $lokasi,
				'date' => $tgl,
				'jenis_report' => $jenis_report,
				'komisi_lunas' => $komisi_lunas,
				'komisi_dp' => $komisi_dp,
				'id_divisi' => $id_divisi
			);
		}

		$this->db->where('id', $id);
		return $this->db->update('task', $data);
	}



//     public function tambah_task($nama, $location, $date, $jenis_report, $komisi_lunas, $komisi_dp, $id_divisi, $lokasi)
// 	{	
// 		$event = 'SP '.$nama;
// 		if ($lokasi == 'others') {
// 			$data = array(
// 				'event' => $event,
// 				'location' => $location,
// 				'date' => $date,
// 				'jenis_report' => $jenis_report,
// 				'komisi_lunas' => str_replace('.','',$komisi_lunas),
// 				'komisi_dp' => str_replace('.','',$komisi_dp),
// 				'id_divisi' => $id_divisi,
// 			);

// 		}else{
// 			$data = array(
// 				'event' => $event,
// 				'location' => $lokasi,
// 				'date' => $date,
// 				'jenis_report' => $jenis_report,
// 				'komisi_lunas' => str_replace('.','',$komisi_lunas),
// 				'komisi_dp' => str_replace('.','',$komisi_dp),
// 				'id_divisi' => $id_divisi,
// 			);

// 		}
// 		$this->db->insert('task', $data);

// 		$this->db->select('*');
// 		$this->db->from('task');
// 		$this->db->order_by('id','desc');
// 		$this->db->limit(1);
// 		$query = $this->db->get();

// 		foreach ($query->result() as $row) {
// 			$task = $row->id;
// 		}

// 		// Data untuk insert ke Menu Event
// 		$datanya = array(
// 			'id_task' => $task,
// 			'event' => $nama,
// 			'location' => $lokasi,
// 			'date_created' => date('Y-m-d'),
// 			'date_event' => date('Y-m-d'),
// 			'is_confirm' => '-',
// 			'id_divisi' => $this->session->userdata('iddivisi'),
// 			'id_user' => $this->session->userdata('id')
			
// 		);
		
// 		$this->db->insert('list_sp', $datanya);
// 		return true;
// 	}

// 	public function edit_task($id, $nama, $location, $tgl, $jenis_report, $komisi_dp, $komisi_lunas, $id_divisi, $lokasi)
// 	{
// 		if ($lokasi == 'others') {
// 			$data = array(
// 				'event' => $nama,
// 				'location' => $location,
// 				'date' => $tgl,
// 				'jenis_report' => $jenis_report,
// 				'komisi_lunas' => $komisi_lunas,
// 				'komisi_dp' => $komisi_dp,
// 				'id_divisi' => $id_divisi
// 			);

// 			// Data untuk insert ke Menu Event
// 			$datanya = array(
// 				'event' => $nama,
// 				'location' => $location,
// 				'date_created' => date('Y-m-d'),
// 				'date_event' => date('Y-m-d'),
// 				'is_confirm' => '-',
// 				'id_divisi' => $this->session->userdata('iddivisi')
// 			);
// 		}else{
// 			$data = array(
// 				'event' => $nama,
// 				'location' => $lokasi,
// 				'date' => $tgl,
// 				'jenis_report' => $jenis_report,
// 				'komisi_lunas' => $komisi_lunas,
// 				'komisi_dp' => $komisi_dp,
// 				'id_divisi' => $id_divisi
// 			);

// 			// Data untuk insert ke Menu Event
// 			$datanya = array(
// 				'event' => $nama,
// 				'location' => $lokasi,
// 				'date_created' => date('Y-m-d'),
// 				'date_event' => date('Y-m-d'),
// 				'is_confirm' => '-',
// 				'id_divisi' => $this->session->userdata('iddivisi')
// 			);
// 		}

// 		$this->db->where('id', $id);
// 		$this->db->update('task', $data);
// 		$this->db->update('list_sp', $datanya);
// 		return true;
// 	}
	
	

	public function delete_task($id){
		$this->db->where('id',$id);
		$this->db->delete('task');

		$this->db->where('id_task',$id);
		return $this->db->delete('task_user');
	}

	public function get_select_task($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('task');

		if ($query -> num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function tambah_war_task($id_task, $username){	 	
		$this->db->where('username',$username);
		$id_user = $this->db->get('user')->row_array()['id'];

		$this->db->where('id_task',$id_task);
		$this->db->where('id_user',$id_user);
		$query = $this->db->get('task_user');
		if ($query -> num_rows() == null){	 	
			$data = array(
				'id_task' => $id_task,
				'id_user' => $id_user		
			);

			return $this->db->insert('task_user',$data);
		}else{
			return true;
		}
	}

	public function pay_war_task($id_task, $username){	 	
		$this->db->where('username',$username);
		$id_user = $this->db->get('user')->row_array()['id'];

		$this->db->where('id_task',$id_task);
		$this->db->where('id_user',$id_user);
		$query = $this->db->get('task_user');
		if ($query -> num_rows() == null){	 	
			$data = array(
				'id_task' => $id_task,
				'id_user' => $id_user,
				'paytask' => 1		
			);

			return $this->db->insert('task_user',$data);
		}else{
			return true;
		}
	}

	public function delete_wartask($id_task, $id_user){
		$this->db->where('id_task',$id_task);
		$this->db->where('id_user',$id_user);
		return $this->db->delete('task_user');
	}

	public function getusername_task($id){
		$this->db->where('id_task',$id);
		$this->db->from('task_user');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getpd($id_task, $username){
		$this->db->where('username',$username);
		$id_user = $this->db->get('user')->row_array()['id'];

		$data = array(
			'tugas' => Null
		);
		$this->db->where('tugas','pd');
		$this->db->where('id_task', $id_task);
		$this->db->update('task_user', $data);

		$data = array(
			'tugas' => 'pd'
		);

		$this->db->where('id_task', $id_task);
		$this->db->where('id_user', $id_user);
		return $this->db->update('task_user', $data);
	}

	public function get_alltask($post){	 	
		
		$sesid = $post['id'];
		$seddiv = $post['iddivisi'];
	    $student = "SELECT `student_privilege` FROM `divisi` WHERE `id_user_spv` = $sesid";
		$divisi = $this->db->query($student)->row('student_privilege');

		$branch = $this->db->select('b.alias')
					->from('divisihasbranch a')
					->join('rc_branch b', 'a.branch_id = b.branch_id')
					->where('a.divisi_id', $seddiv)
					->get()->result();

		$branch_name = array();

		foreach($branch as $row){
			array_push($branch_name, $row->alias);
		}
		$this->db->select('*, task.id as idt');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		if($divisi != 0){
			$this->db->join('divisihasbranch', 'task.id_divisi = divisihasbranch.divisi_id', 'left');
			$this->db->join('rc_branch', 'divisihasbranch.branch_id = rc_branch.branch_id', 'left');
			$test = "apa aja 1";
		}else{
		    $test = "apa aja 2";
		}
// 		var_dump($test);
// 		die();
		//Pengambilan data hanya 1 tahun
		$thn = date('Y') - 1;
		$date_start = date(''.$thn.'-m-d');
		
		$date_end = date('Y-m-d', strtotime("-1 days"));
		// if($this->session->userdata('id') != '190' || $this->session->userdata('id') != '72'){
			if($divisi == 1){
				// $type ='1';
				$this->db->where_in('location', $branch_name);
			}
		// }
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
		$this->db->where($where);

		$this->db->order_by('date','desc');
		$this->db->order_by('idt','desc');
		$this->db->group_by('task.id');

		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function get_alltask_lama(){	 	
		
		$this->db->select('*, task.id as idt');
		$this->db->from('task');
		
		//Pengambilan data hanya 1 tahun
		$thn = date('Y') - 1;
		$date_start = date(''.$thn.'-m-d');

		$date_end = date('Y-m-d', strtotime("-1 days"));
		if($this->session->userdata('id') != '190' || $this->session->userdata('id') != '72'){
			$this->db->where('task.id_divisi', $this->session->userdata('iddivisi'));
		}
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
		$this->db->where($where);


		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
// 		if ($this->session->userdata('iddivisi') == '3' || $this->session->userdata('id') == '48'){
// 			$this->db->where('task.id_divisi', '3');
// 		}else if($this->session->userdata('iddivisi') == '28' || $this->session->userdata('id') == '64'){
// 			$this->db->where('task.id_divisi', '28');
// 		}else if($this->session->userdata('iddivisi') == '6' || $this->session->userdata('id') == '44'){
// 			$this->db->where('task.id_divisi', '6');
// 		}else if($this->session->userdata('iddivisi') == '29' || $this->session->userdata('id') == '76'){
// 			$this->db->where('task.id_divisi', '29');
// 		}else if($this->session->userdata('iddivisi') == '33' || $this->session->userdata('id') == '82'){
// 			$this->db->where('task.id_divisi', '33');
// 		}

		$this->db->order_by('date','desc');
		$this->db->order_by('idt','desc');
		$this->db->group_by('task.id');
		
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getusername_report_task(){
		$where = '(status="aktif" or status is null)';
		$this->db->where($where);
		$this->db->where('level', 'user');
		$this->db->order_by('id','asc');
		$query = $this->db->get('user');

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_event_all_notpay($iduser){
		$this->db->where('id_user', $iduser);
		$this->db->where('paytask', null);
		$query = $this->db->get('task_user');

		if ($query -> num_rows() > 0){
			return $query->num_rows();
		}else{
			return false;
		}
	}

	public function get_event_all_pay($iduser){
		$this->db->where('id_user', $iduser);
		$this->db->where('paytask', 1);
		$this->db->where('hadir','ya');
		$query = $this->db->get('task_user');

		if ($query -> num_rows() > 0){
			return $query->num_rows();
		}else{
			return false;
		}
	}

	public function get_event_all_hutang($iduser){
		$date_start = '2016-01-01';
		$date_end = date('Y-m-d', strtotime("-3 days"));
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (id_user='.$iduser.' AND (task_user.hadir = "tidak")) AND (paytask is Null)' ;
		$this->db->where($where);

		$this->db->select('*, task_user.id as tui');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->num_rows();
		}else{
			return false;
		}
	}

	public function get_all_incentive_list(){
	    $query = $this->db->get('list_incentive_sp');
	    if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function add_newevent_incen($name, $dp, $lunas){
	    $data = array(
	        'name' => $name,
	        'dp' => $dp,
	        'lunas' => $lunas
	    );
	    
	    return $this->db->insert('list_incentive_sp',$data);
	}

	public function delete_event_incent($id){
	    $this->db->where('id',$id);
	    return $this->db->delete('list_incentive_sp');
	}

	public function update($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('task_user', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		return $this->db->delete('task_user');
	}
	
	public function get_sp()
	{
	    $date_start = date('Y-m-d', strtotime('-1 days'));
		$date_end = date('Y-m-d', strtotime("+360 days"));
		$where = '(date_event BETWEEN "' . $date_start . '" AND  "' . $date_end . '")';
		$this->db->where($where);
		$this->db->where('id_divisi', $this->session->userdata('iddivisi'));
		$this->db->order_by('date_event');
		$query = $this->db->get('list_sp');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function insert_sp($data)
	{
		return $this->db->insert('list_sp', $data);
	}


	public function update_sp($data, $id)
	{
		$this->db->where('id', $id);
		return $this->db->update('list_sp', $data);
	}
	
	public function get_sp_detail($id)
	{
		return $this->db->get_where('list_sp', array('id' => $id))->row_array();
	}
	
	public function hapus_data_sp($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('list_sp');

		return true;
	}
	
	public function get_referror()
	{
	    $this->db->select('list_referror.*, user.username, user.branch_id as branchid, rc_branch.branch_name');
	   // $this->db->where('id_divisi', $this->session->userdata('iddivisi'));
	    $this->db->join('user', 'list_referror.id_user = user.id');
	    $this->db->join('rc_branch', 'list_referror.is_branch = rc_branch.branch_id');
		$this->db->order_by('date_created');
		$query = $this->db->get('list_referror');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_branch()
	{
		$this->db->order_by('branch_id', 'asc');
// 		$this->db->where_not_in('branch_id', array('0'));
		$query = $this->db->get('rc_branch');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function insert_referror($data, $phone)
	{
		$this->db->select('phone');
		$this->db->where('phone', $phone);
		$query = $this->db->get('list_referror');

		if ($query->num_rows() == 1) {
			return false;
		} else {
			return $this->db->insert('list_referror', $data);
		}
	}

	public function get_referror_detail($id)
	{

		return $this->db->get_where('list_referror', array('id_referror' => $id))->row_array();
	}

	public function update_referror($data, $id, $phone)
	{

		$this->db->where('id_referror', $id);
		return $this->db->update('list_referror', $data);
	}

	public function hapus_data_referror($id)
	{
		$this->db->where('id_referror', $id);
		$this->db->delete('list_referror');
		
		$this->db->where('referral', $id);
		$this->db->delete('list_referral');

		return true;
	}

	public function get_referral()
	{
	    $this->db->select('list_referral.*, list_referror.name as referror, list_incentive_sp.name as program_name');
		$this->db->join('list_referror', 'list_referror.id_referror = list_referral.referral', 'left');
		$this->db->join('list_incentive_sp', 'list_referral.program = list_incentive_sp.alias', 'left');
// 		$this->db->where('list_referral.id_divisi', $this->session->userdata('iddivisi'));
		$this->db->order_by('list_referral.date_created');
		$query = $this->db->get('list_referral');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_program_referral()
	{
		$this->db->order_by('name');
		$this->db->where_not_in('id', array('3', '12', '13', '14', '15', '16', '17', '20', '21', '22', '23', '25'));
		$query = $this->db->get('list_incentive_sp');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}

//         $this->db->where('is_active', '1');
// 		$this->db->order_by('department_id');
// 		$this->db->order_by('ordering');
// 		$result = $this->db->get('list_incentive_sp')->result_array();
// 		if (!empty($id_divisi)) {
// 			$data = array();
// 			foreach ($result as $row) {
// 				$temp = explode(",", $row['department_id']);
// 				foreach ($temp as $row2) {
// 					if ($row2 == $id_divisi) {
// 						array_push($data, $row);
// 					}
// 				}
// 			}
// 			return $data;
// 		} else {
// 			return $result;
// 		}
	}

	public function insert_referral($data)
	{
		return $this->db->insert('list_referral', $data);
	}

	public function get_referral_detail($id)
	{
	    $this->db->select('list_referral.*, list_referror.name as referror, list_incentive_sp.name as program_name');
		$this->db->join('list_referror', 'list_referror.id_referror = list_referral.referral', 'left');
		$this->db->join('list_incentive_sp', 'list_referral.program = list_incentive_sp.alias', 'left');
		$this->db->where('list_referral.id_referral', $id);
		return $this->db->get('list_referral')->row_array();
	}

	public function update_referral($data, $id)
	{
		$this->db->where('id_referral', $id);
		return $this->db->update('list_referral', $data);
	}

	public function hapus_data_referral($id)
	{
		$this->db->where('id_referral', $id);
		$this->db->delete('list_referral');

		return true;
	}

	public function get_data_referral($param = null)
	{
		$this->db->select('list_referral.*, list_referror.name as referror, list_incentive_sp.name as program_name');
		$this->db->join('list_referror', 'list_referror.id_referror = list_referral.referral', 'left');
		$this->db->join('list_incentive_sp', 'list_referral.program = list_incentive_sp.alias', 'left');

		if (!empty($param['program']) && ($param['program'] != 'all')) {
			$this->db->where('list_referral.program', $param['program']);
		}
		if (!empty($param['status_tele']) && ($param['status_tele'] != 'all')) {
			$this->db->where('list_referral.status_tele', $param['status_tele']);
		}
		if (!empty($param['referror']) && ($param['referror'] != 'all')) {
			$this->db->where('list_referral.referral', $param['referror']);
		}
		$this->db->order_by('date_created');
		return $this->db->get('list_referral');
	}

	public function export_data_referral($parameter = array())
	{
		$this->db->select('list_referral.date_referral as Tanggal Referral, list_referral.name as Nama, list_referral.email as E-mail, list_referral.phone as Telp, list_referral.program as Program, list_referror.name as Referror, list_referral.status_tele as Status Tele, list_referral.description as Keterangan');
		$this->db->join('list_referror', 'list_referror.id_referror = list_referral.referral', 'left');
		$this->db->join('list_incentive_sp', 'list_referral.program = list_incentive_sp.alias', 'left');
		
		if (!empty($parameter['program']) && ($parameter['program'] != 'all')) {
			$this->db->where('list_referral.program', $parameter['program']);
		}
		if (!empty($parameter['status_tele']) && ($parameter['status_tele'] != 'all')) {
			$this->db->where('list_referral.status_tele', $parameter['status_tele']);
		}
		if (!empty($parameter['referror']) && ($parameter['referror'] != 'all')) {
			$this->db->where('list_referral.referral', $parameter['referror']);
		}
		return $this->db->get('list_referral');
	}


}
