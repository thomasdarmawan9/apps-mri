<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_lembur extends CI_Model {

	public function contruct(){
		parent::__construct();
	}

	public function get_addlembur(){

		$iduser = $this->session->userdata('id');
		$date_start = date('Y-m-d', strtotime("-7 days"));
		$date_end = date('Y-m-d');
		
		$sql = 'SELECT * 
		FROM lembur_app_spv
		WHERE IF(  `status` =  "tidak", (`tgl_Approved` BETWEEN  "'.$date_start.'" AND  "'.$date_end.'" ),((( tgl_Approved BETWEEN  "'.$date_start.'" AND  "'.$date_end.'" ) AND (( acc_hr =  "ya") OR ( acc_hr =  "tidak" ) )) OR ( acc_hr IS NULL ) )) AND (id_user = '.$iduser.') ORDER BY `tgl` ASC';

		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_acclembur(){
	    
	    if($this->session->userdata('is_mgr') == true){
	        
	        $this->db->select('*, lembur_app_spv.id as idt, lembur_app_spv.status as lass');
	        $this->db->from('lembur_app_spv');
    		$this->db->join('divisi','divisi.id = lembur_app_spv.id_divisi','left');
    		$this->db->join('user', 'user.id = lembur_app_spv.id_user', 'left');
	        
	        //Membuat array pada divisi yang dihandle dari database
	        $divisi = unserialize($this->session->userdata('is_mgr_division'));
    	    
    	    $where = '((nilai > 2 AND lembur_app_spv.status is null AND lembur_app_spv.id_divisi IN ('.implode(',',$divisi).') ) OR (nilai > 0 AND lembur_app_spv.id_user = '.$this->session->userdata('id').' AND lembur_app_spv.status is null) )';
       	    $this->db->where($where);
       	    
       	    $this->db->order_by('tgl','asc');
    	    
    	    return $this->db->get()->result();
	        
	    }else if($this->session->userdata('is_spv') == true){
	        
	        $this->db->select('*, lembur_app_spv.id as idt, lembur_app_spv.status as lass');
	        $this->db->from('lembur_app_spv');
    		$this->db->join('divisi','divisi.id = lembur_app_spv.id_divisi','left');
    		$this->db->join('user', 'user.id = lembur_app_spv.id_user', 'left');
    		
			$this->db->where('id_user_spv',$this->session->userdata('id'));
			$this->db->where('nilai <=', 2);
    		
    		$this->db->where('lembur_app_spv.status is null', null, false);
    		
    		$this->db->order_by('tgl','asc');
    		
    		return $this->db->get()->result();
	        
	    }else{
	        //Dia bukan seorang Manager ataupun Spv
	        return false;
	    }
	
	}
	
	function toapprove_lembur_spv($id){
	
		//Update Status
		$data = array(
	          'status' => 'ya'
	    );
	
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv', $data);
		
		//Mendapatkan datanya
		$this->db->where('id',$id);
		$query = $this->db->get('lembur_app_spv');
		return true;
	}
	
	function toreject_lembur_spv($id){
		//Update Status
		$data = array(
	               'status' => 'tidak',
	               'tgl_approved' => date('Y-m-d')
	        );
	
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv', $data);
		return true;
	}

	public function cari_tgl($name, $cari_tgl){
		$this->db->where('username',$name);
		$id = $this->db->get('user')->row_array()['id'];
		
		$this->db->where('id_user',$id);
		$this->db->where('tgl',$cari_tgl);
		$query = $this->db->get('lembur');
		
		$hasil = 0;
		
		if ($query -> num_rows() == null){
			$hasil = '-';
		}else{
			foreach($query->result() as $r){
				$hasil = $hasil + $r->nilai;	 			 
			}
		}
		
		return $hasil;
		
	}

	public function cari_desk($name, $cari_tgl){
		$this->db->where('username',$name);
		$id = $this->db->get('user')->row_array()['id'];
		
		$this->db->where('id_user',$id);
		$this->db->where('tgl',$cari_tgl);
		$query = $this->db->get('lembur');
		
		if ($query -> num_rows() == null){
			$hasil = '-';
		}else{
			foreach($query->result() as $r){
				$hasil = $r->deskripsi;
			}
		}
		
		return $hasil;
		
	}

	public function cari_lembur_bulan($bln, $thn){
		$d = 01;
		$date = $thn.'-'.$bln.'-'.$d;

		$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
		$newdate = date ( 'Y-m-j' , $newdate );
		
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->where('tgl >=', '2016-01-01');
		$this->db->where('tgl <=', $newdate);
		
		$this->db->select_sum('nilai');
		$query = $this->db->get('lembur');
		foreach($query->result() as $r){
			$jam = $r->nilai;
		}

		return $jam;
		
	}

	public function cari_cuti_izin(){
		$bln = '12';
		$thn = date("Y");
		$d= '31';
		$date_last = $thn.'-'.$bln.'-'.$d;
		
		$date_start = $thn.'-01-01';
		
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->where('tgl >=', $date_start);
		$this->db->where('tgl <=', $date_last);
		$this->db->order_by("tgl","asc");
		$query = $this->db->get('cuti_izin');
		return $query->result();
	}

	public function cari_cuti_sakit(){
		$bln = '12';
		$thn = date("Y");
		$d= '31';
		$date_last = $thn.'-'.$bln.'-'.$d;
		
		$date_start = $thn.'-01-01';
		
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->where('tgl >=', $date_start);
		$this->db->where('tgl <=', $date_last);
		$this->db->order_by("tgl","asc");
		$query = $this->db->get('cuti_sakit');
		return $query->result();
	}

	public function addlembur($desc,$nilai,$tgl){
	    if($this->session->userdata('is_mgr') == true){
	        $iddivisi = 1;
	    }else{
	        $iddivisi = $this->session->userdata('iddivisi');
	    }
	    
		$data = array(
			'id_user' => $this->session->userdata('id'),
			'id_divisi' => $iddivisi,
			'tgl' => $tgl,
			'deskripsi' => $desc,
			'nilai' => $nilai
		);
		
		return $this->db->insert('lembur_app_spv',$data);
	}

	public function get_data_lembur($id = null){
		return $this->db->get_where('lembur_app_spv', array('id' => $id))->row_array();
	}

	public function pluslembur($jamlembur, $name, $tgl, $deskripsi, $nilai){
		$this->db->where('username',$name);
		$query = $this->db->get('user');

		foreach($query->result() as $n){
			$nm = $n->id;
		}

		$data = array (
			'id_user' => $nm,
			'tgl' => $tgl,
			'deskripsi' => $deskripsi,
			'nilai' => $nilai
		);

		return $this->db->insert('lembur',$data);
	}

	public function minuscuti($name, $tgl, $deskripsi, $tcuti){
		$this->db->where('username',$name);
		$query = $this->db->get('user');

		foreach($query->result() as $n){
			$nm = $n->id;
		}

		$data = array (
			'id_user' => $nm,
			'tgl' => $tgl,
			'deskripsi' => $deskripsi,
			'nilai' => 1
		);

		return $this->db->insert($tcuti,$data);
	}

	public function tambah_cuti_manual($getnm, $plus, $tgl, $deskripsi){
		$this->db->where('as', null);
		$this->db->where('username',$getnm);
		$query = $this->db->get('user');

		foreach($query->result() as $n){
			$nm = $n->id;
		}

		$data = array (
			'id_user' => $nm,
			'tgl' => $tgl,
			'deskripsi' => $deskripsi,
			'plus' => $plus
		);

		return $this->db->insert('cuti_izin',$data);
	}

	public function get_acchr_lembur(){

		$this->db->select('*, lembur_app_spv.id as idt, lembur_app_spv.status as lass');
		$this->db->from('lembur_app_spv');
		$this->db->join('user', 'user.id = lembur_app_spv.id_user', 'left');
		$this->db->where('lembur_app_spv.status', 'ya');
		$this->db->where('lembur_app_spv.acc_hr', null);
		
		if(!empty($this->session->userdata('is_hr'))){
		    $divisi = unserialize($this->session->userdata('is_hr_division'));
		    $this->db->where_in('user.id_divisi',$divisi);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_acchr_merch()
	{
		$this->db->select('*, lembur_app_spv.id as idt, lembur_app_spv.status as lass');
		$this->db->from('lembur_app_spv');
		$this->db->join('user', 'user.id = lembur_app_spv.id_user', 'left');
		$this->db->where('lembur_app_spv.status', 'ya');
		$where = "lembur_app_spv.id_log_product is  NOT NULL";
		$this->db->where($where);
		$this->db->where('lembur_app_spv.acc_hr', null);

		if (!empty($this->session->userdata('is_hr'))) {
			$divisi = unserialize($this->session->userdata('is_hr_division'));
			$this->db->where_in('user.id_divisi', $divisi);
		}

		$query = $this->db->get();
		return $query->result();
	}

	public function approve_lembur_hr($id){
		$data = array(
			'acc_hr' => 'ya',
			'tgl_approved' => date('Y-m-d')
		);
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv', $data);

		$this->db->where('id',$id);
		$query = $this->db->get('lembur_app_spv');
		
		if($query -> num_rows() == 1){
			foreach($query->result() as $r){
				$id_user = $r->id_user;
				$tgl = $r->tgl;
				$deskripsi = $r->deskripsi;
				$nilai = $r->nilai;
			}
			
			$data = array(
				'id_user' => $id_user,
				'tgl' => $tgl,
				'deskripsi' => $deskripsi,
				'nilai' => $nilai
			);

			return $this->db->insert('lembur',$data);
		}else{
			return false;
		}
		
	}
	
	public function approve_merch_hr($id)
	{
		$data = array(
			'acc_hr' => 'ya',
			'tgl_approved' => date('Y-m-d')
		);
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv', $data);

		$this->db->where('id', $id);
		$query = $this->db->get('lembur_app_spv');

		if ($query->num_rows() == 1) {
			foreach ($query->result() as $r) {
				$id_user = $r->id_user;
				$tgl = $r->tgl;
				$deskripsi = $r->deskripsi;
				$nilai = $r->nilai;
				$id_log_product = $r->id_log_product;
			}

			$data = array(
				'id_user' => $id_user,
				'tgl' => $tgl,
				'deskripsi' => $deskripsi,
				'nilai' => $nilai
			);

			$data_merch = array(
				'is_approve' => '1'
			);

			$this->db->where('id_log_product', $id_log_product);
			$this->db->update('log_merch', $data_merch);

			$this->db->insert('lembur', $data);

			return true;
		} else {
			return false;
		}
	}

	public function reject_lembur_hr($id){
		$data = array(
			'acc_hr' => 'tidak',
			'tgl_approved' => date('Y-m-d')
		);

		$this->db->where('id', $id);
		return $this->db->update('lembur_app_spv', $data);
	}
	
	public function reject_merch_hr($id)
	{
		$data = array(
			'acc_hr' => 'tidak',
			'tgl_approved' => date('Y-m-d')
		);
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv', $data);

		$this->db->where('id', $id);
		$query = $this->db->get('lembur_app_spv');

		if ($query->num_rows() == 1) {
			foreach ($query->result() as $r) {

				$id_log_product = $r->id_log_product;
			}

			$data_merch = array(
				'is_reject' => '1'
			);

			$this->db->where('id_log_product', $id_log_product);
			$this->db->update('log_merch', $data_merch);

			return true;
		} else {
			return false;
		}
	}

	public function getlembur($name){
		$this->db->where('username',$name);
		$query = $this->db->get('user');
		foreach($query->result() as $r){
			$id = $r->id;
		}

		$this->db->where('id_user',$id);
		$this->db->select_sum('nilai');
		$query = $this->db->get('lembur');

		foreach($query->result() as $r){
			$jam = $r->nilai;
		}

		return $jam;
	}

	public function get_lembur_sblm($name, $date){

		$this->db->where('username',$name);
		$query = $this->db->get('user');
		foreach($query->result() as $r){
			$id = $r->id;
		}

		$date_start = '2017-01-01';
		
		$this->db->where('id_user',$id);
		$this->db->where('tgl >=', $date_start);
		$this->db->where('tgl <=', $date);
		
		$this->db->select_sum('nilai');
		$query = $this->db->get('lembur');

		foreach($query->result() as $r){
			$lembur = $r->nilai;
		}

		return $lembur;
	}

	public function get_detail_lembur($user, $tgl){
		$this->db->where('username',$user);
		$query = $this->db->get('user');
		
		foreach($query->result() as $r){
			$id = $r->id;
		}
		
		$this->db->where('id_user',$id);
		$this->db->where('tgl',$tgl);
		$query = $this->db->get('lembur');
		
		return $query->result();
	}

	public function get_cuti_izin_sblm($username, $fromthn){
		
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		foreach($query->result() as $r){
			$id = $r->id;
		}
		
		$bln = 01;
		$thn = $fromthn;
		$d 	 = 01;
		$getnow = $thn.'-'.$bln.'-'.$d;
		
		$this->db->where('id_user',$id);
		$this->db->order_by('tgl','asc');
		$this->db->where('tgl >=', '2016-01-01');
		$this->db->where('tgl <=', $getnow);
		
		$nilai = 0;
		$query = $this->db->get('cuti_izin');
		
		foreach($query->result() as $r){
			if($r->plus <> 0){
				$nilai = $nilai + $r->plus;
			}else{
				$nilai = $nilai - $r->nilai;
			}
		}
		
		return $nilai;
	}

	public function get_cuti_izin($username, $fromthn){
		
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		foreach($query->result() as $r){
			$id = $r->id;
		}

		$bln = 01;
		$thn = $fromthn;
		$d 	 = 02;
		$lastdate = $thn.'-'.$bln.'-'.$d;
		
		$getnow = date('Y-m-j');
		
		$this->db->where('id_user',$id);
		$this->db->order_by('tgl','asc');
		$this->db->where('tgl >=', $lastdate);
		$this->db->where('tgl <=', $getnow);
		$query = $this->db->get('cuti_izin');
		
		return $query->result();
	}

	public function get_cuti_sakit($username){
		
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		foreach($query->result() as $r){
			$id = $r->id;
		}

		$bln = 01;
		$thn = date("Y");
		$d=01;
		$lastdate = $thn.'-'.$bln.'-'.$d;

		$getnow = date('Y-m-j');
		
		$this->db->where('id_user',$id);
		$this->db->order_by('tgl','asc');
		$this->db->where('tgl >=', $lastdate);
		$this->db->where('tgl <=', $getnow);
		$query = $this->db->get('cuti_sakit');
		
		return $query->result();
	}

	public function delete_detail_lembur($id){
		$this->db->where('id',$id);
		return $this->db->delete('lembur');
	}

	public function delete_cuti_izin($id){
	    $this->db->where('id',$id);
	    return $this->db->delete('cuti_izin');
	}

	public function delete_cuti_sakit($id){
	    $this->db->where('id',$id);
	    return $this->db->delete('cuti_sakit');
	}

	public function update($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('lembur_app_spv', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		return $this->db->delete('lembur_app_spv');
	}


}