<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_incentive extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function get_list_incentive_last(){
		$this->db->select('*, task.id as tid, count(jenis_lunas) as jmh');
		$this->db->from('task');
		$this->db->join('incentive', 'incentive.id_task = task.id', 'left');
		
		$date_start = '2016-01-01';
		$date_end = date('Y-m-d');
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
		$this->db->where($where);

		$this->db->order_by('date','desc');
		$this->db->group_by('tid');
		
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_list_incentive(){
		$this->db->select('*, task.id as tid, count(jenis_lunas) as jmh');
		$this->db->from('task');
		$this->db->join('incentive', 'incentive.id_task = task.id', 'left');

		$date_start = date('Y-m-d');
		$date_end = date('Y-m-d' , strtotime("+1 days"));

		$where = '(date > "'.$date_start.'")' ;
		$this->db->where($where);

		$this->db->order_by('date','asc');
		$this->db->group_by('tid');

		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function delete_list_incentive($id){
		$this->db->where('id',$id);
		return $this->db->delete('incentive');
	}
	
	public function get_all_incentive($id){
		$this->db->select('*, incentive.id as ii');
		$this->db->from('incentive');
		$this->db->join('task', 'incentive.id_task = task.id', 'left');
		$this->db->join('user', 'incentive.id_user = user.id', 'left');
		
		$this->db->where('task.id',$id);
		$this->db->order_by('id_user','asc');
		
		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function check_approved_incentive($id){
		$this->db->where('id_task', $id);
		$this->db->where('status_acc', null);

		$query = $this->db->get('incentive');

		if ($query -> num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function unapproved_incentive($id){
		$data = array(
			'status_acc' => null,
			'status_paid' => null,
			'tgl_acc' => null
		);

		$this->db->where('id_task',$id);
		return $this->db->update('incentive', $data);
	}

	public function approved_incentive($id){
		$data = array(
			'status_acc' => 'ya',
			'tgl_acc' => date('Y-m-d')
		);

		$this->db->where('id_task',$id);
		return $this->db->update('incentive', $data);
	}

	public function approved_paid_all($id_task){
		$data = array(
			'status_paid' => 'paid'
		);

		$this->db->where('id_task',$id_task);
		return $this->db->update('incentive', $data);
	}

	public function unapproved_paid_all($id_task){
		$data = array(
			'status_paid' => null
		);

		$this->db->where('id_task',$id_task);
		return $this->db->update('incentive', $data);
	}

	public function approved_incentive_satuan($ii){
		$data = array(
			'status_acc' => 'ya',
			'tgl_acc' => date('Y-m-d')
		);

		$this->db->where('id',$ii);
		return $this->db->update('incentive', $data);
	}

	public function can_approved_incentive_satuan($ii){
		$data = array(
			'status_acc' => null,
			'status_paid' => null,
			'tgl_acc' => null
		);

		$this->db->where('id',$ii);
		return $this->db->update('incentive', $data);
	}

	public function approved_paid_satuan($ii){
		$data = array(
			'status_paid' => 'paid'
		);

		$this->db->where('id',$ii);
		return $this->db->update('incentive', $data);
	}

	public function can_approved_paid_satuan($ii){
		$data = array(
			'status_paid' => null
		);

		$this->db->where('id',$ii);
		return $this->db->update('incentive', $data);
	}

	public function check_paid_incentive($id){
		$this->db->where('id_task',$id);
		$this->db->where('status_paid',null);

		$query = $this->db->get('incentive');

		if ($query -> num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function info_pd_incentive(){

		$this->db->select('*, task_user.id as tui');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		//-60 days
		$date_start = date('Y-m-d', strtotime("-300 days"));
		$date_end = date('Y-m-d', strtotime("+360 days"));
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (tugas="pd") AND ((id_user='.$this->session->userdata('id').' AND (persetujuan_pengganti = "tidak" OR persetujuan_pengganti IS null)) OR (id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti = "ya"))' ;

		$query = $this->db->where($where);
		$this->db->order_by('date','asc');

		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_my_incentive(){
		$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');
		$this->db->join('user', 'user.id = incentive.id_user', 'left');
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->where('status_acc','ya');
		$this->db->order_by('id_task','desc');
		$this->db->order_by('date','desc');
		$this->db->order_by('program_lain','desc');

		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_my_incentive_paid(){
		$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->where('status_acc','ya');
		$this->db->where('status_paid','paid');
		$query = $this->db->get();

		$paid = null;
		foreach($query->result() as $r){
			if($r->program_lain <> null){
				$paid = $paid + $r->komisi_program_lain;
			}else{
				if($r->jenis_lunas == 'dp'){
					$paid = $paid + $r->komisi_dp;
				}else{
					$paid = $paid + $r->komisi_lunas;
				}
			}
		}

		if($paid > 1000){
			return 'Rp '.number_format($paid/1000).' Ribu';
		}else{
			return 'Rp '.number_format($paid);
		}
	}

	public function get_my_incentive_unpaid(){
		$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->where('status_acc','ya');
		$this->db->where('status_paid',null);
		$query = $this->db->get();

		$unpaid = null;
		foreach($query->result() as $r){
			if($r->program_lain <> null){
				$unpaid = $unpaid + $r->komisi_program_lain;
			}else{
				if($r->jenis_lunas == 'dp'){
					$unpaid = $unpaid + $r->komisi_dp;
				}else{
					$unpaid = $unpaid + $r->komisi_lunas;
				}
			}
		}

		if($unpaid > 1000){
			return 'Rp '.number_format($unpaid/1000).' Ribu';
		}else{
			return 'Rp '.number_format($unpaid);
		}
	}

	public function get_pd_incentive($id_event){
		$this->db->select('*, task_user.id as tui, task.id as ti');
		$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		
		$id_pd = $this->session->userdata('id');
		$where = "((id_user = '$id_pd') OR (id_pengganti = '$id_pd')) AND id_task = '$id_event' AND tugas = 'pd'";
		$this->db->where($where);

		$this->db->order_by('date','desc');

		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getusername_detail_incentive(){

		$where = '(status="aktif" or status is null)';
		$this->db->where($where);

		$this->db->order_by('id','asc');
		$query = $this->db->get('user');

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_hsl_incentive($id_event){
		$this->db->select('*, incentive.id as ici');
		$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');
		$this->db->join('user', 'user.id = incentive.id_user', 'left');
		
		$this->db->where('id_task',$id_event);
		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}	 
	}

	public function get_hsl_number_incentive($id_event){
		$this->db->select('*');
		$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');
		$this->db->join('user', 'user.id = incentive.id_user', 'left');
		
		$this->db->where('id_task',$id_event);
		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query -> num_rows();
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
	
	public function send_notif_incentive($id_task){

		$this->db->select('*, incentive.id as ici, incentive.id_user as iit');
		$this->db->from('incentive');
		$this->db->join('task', 'task.id = incentive.id_task', 'left');
		$this->db->join('user', 'user.id = incentive.id_user', 'left');
		
		$this->db->where('id_task',$id_task);
		$this->db->order_by('iit', 'asc');
		$query = $this->db->get();

		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_cek_uang_masuk_all(){
		$this->db->select('*, cek_uang_masuk.id as cumi');
		$this->db->from('cek_uang_masuk');
		$this->db->join('user', 'user.id = cek_uang_masuk.id_user', 'left');
		
		$this->db->order_by('cumi','desc');
		$query = $this->db->get();
		
		
		if ($query -> num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function approve_moneychecker($idcumi){
		$data = array (
			'approve' => 'ya',
			'tgl_approve' => date('Y-m-d')
		);
		
		$this->db->where('id',$idcumi);
		return $this->db->update('cek_uang_masuk',$data);
	}

	public function not_approve_moneychecker($idcumi){
		$data = array (
			'approve' => 'tidak',
			'tgl_approve' => date('Y-m-d')
		);
		
		$this->db->where('id',$idcumi);
		return $this->db->update('cek_uang_masuk',$data);
	}

	public function add_incentive($id_event, $user, $peserta, $bayar, $closing, $programlain){
		$this->db->where('username',$user);
		$id_user = $this->db->get('user')->row_array()['id'];
		$tgl = date('Y-m-d');
		if($programlain == 'default'){
			$data = array(
				'id_task' => $id_event,
				'id_user' => $id_user,
				'peserta' => $peserta,
				'total' => $bayar,
				'jenis_lunas' => $closing,
				'tgl_proses' => $tgl
			);
		}else{
			$this->db->where('name',$programlain);
			$query = $this->db->get('list_incentive_sp');
			if ($query -> num_rows() == 1){
				foreach($query->result() as $r){
					if($closing == 'dp'){
						$komisi = $r->dp;
					}elseif($closing == 'lunas'){
						$komisi = $r->lunas;
					}
				}

				$data = array(
					'id_task' => $id_event,
					'id_user' => $id_user,
					'peserta' => $peserta,
					'total' => $bayar,
					'jenis_lunas' => $closing,
					'tgl_proses' => $tgl,
					'program_lain' => $programlain,
					'komisi_program_lain' => $komisi
				);

			}else{
				return false;
			}
		}

		return $this->db->insert('incentive',$data);
	}

	public function update_incentive($id_incentive, $user, $peserta, $bayar, $closing, $id_event, $programlain){
		$this->db->where('username',$user);
		$id_user = $this->db->get('user')->row_array()['id'];
		$tgl = date('Y-m-d');
		
		if($id_incentive<>'null'){
			if($programlain == 'default'){
				$data = array (
					'id_user' => $id_user,
					'peserta' => $peserta,
					'total' => $bayar,
					'jenis_lunas' => $closing,
					'tgl_proses' => $tgl
				);
				$this->db->where('id', $id_incentive);
				return $this->db->update('incentive', $data);
			}else{
				$this->db->where('name', $programlain);
				$query = $this->db->get('list_incentive_sp');

				if ($query -> num_rows() == 1){
					foreach($query->result() as $r){
						if($closing == 'dp'){
							$komisi = $r->dp;
						}elseif($closing == 'lunas'){
							$komisi = $r->lunas;
						}
					}

					$data = array(
						'id_task' => $id_event,
						'id_user' => $id_user,
						'peserta' => $peserta,
						'total' => $bayar,
						'jenis_lunas' => $closing,
						'tgl_proses' => $tgl,
						'program_lain' => $programlain,
						'komisi_program_lain' => $komisi
					);


					$this->db->where('id',$id_incentive);
					return $this->db->update('incentive',$data);

				}else{
					return false;
				}
			}
		}else{
			if($programlain == 'default'){
				$data = array (
					'id_task' => $id_event,
					'id_user' => $id_user,
					'peserta' => $peserta,
					'total' => $bayar,
					'jenis_lunas' => $closing,
					'tgl_proses' => $tgl
				);
				return $this->db->insert('incentive',$data);
			}else{
				$this->db->where('name',$programlain);

				$query = $this->db->get('list_incentive_sp');

				if ($query -> num_rows() == 1){
					foreach($query->result() as $r){
						if($closing == 'dp'){
							$komisi = $r->dp;
						}elseif($closing == 'lunas'){
							$komisi = $r->lunas;
						}
					}

					$data = array (
						'id_task' => $id_event,
						'id_user' => $id_user,
						'peserta' => $peserta,
						'total' => $bayar,
						'jenis_lunas' => $closing,
						'tgl_proses' => $tgl,
						'program_lain' => $programlain,
						'komisi_program_lain' => $komisi
					);

					return $this->db->insert('incentive',$data);

				}else{
					return false;
				}
			}
		}
	}

	public function del_list_incentive($id_incentive){
		$this->db->where('id',$id_incentive);
		return $this->db->delete('incentive');
	}

	public function update($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('incentive', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		return $this->db->delete('incentive');
	}

}