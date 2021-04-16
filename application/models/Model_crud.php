<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_crud extends CI_Model {

	function contruct()
	{
		parent::__construct();
	}
	
	function get_info_event($id){
	    $this->db->where('id',$id);
	    $query =  $this->db->get('list_incentive_sp');
	    
	   
	    return $query ->result();
	    
	}
	
	function get_username(){
	    $sql = 'SELECT * FROM user where `as` IS NULL and  ((`status` = "aktif" ) or (`status` IS NULL))';
		$query = $this->db->query($sql);
		
	    if($query->num_rows() > 0){
	        return $query->result();
	    }else{
	        return false;
	    }
	    
	}
	
	function check_active_user($id){
	    $this->db->where('id',$id);
	    $query = $this->db->get('user');
	    
	    if($query->num_rows() > 0){
	        foreach($query->result() as $r){
	            if($r->status == 'tidak aktif'){
	                return false;
	            }else{
	                return true;
	            }
	        }
	    }else{
	        return false;
	    }
	}
	
	function delete_list_incentive($id){
	    $this->db->where('id',$id);
	    $this->db->delete('incentive');
	    
	    return true;
	}
	
	function delete_cuti_izin($id){
	    $this->db->where('id',$id);
	    $this->db->delete('cuti_izin');
	    
	    return true;
	}
	
	function delete_cuti_sakit($id){
	    $this->db->where('id',$id);
	    $this->db->delete('cuti_sakit');
	    
	    return true;
	}
	
	function get_event($idevent,$id_user){
	    $this->db->from('task');
	    $this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->where('task_user.id',$idevent);
		$this->db->where('id_user',$id_user);
		$query = $this->db->get();
	    
	    return $query->result();
	}
	
	//For Auto WA
	function get_my_id($contact_uid){
	    
	    $this->db->where('no_hp',$contact_uid);
	    $query = $this->db->get('user');
	    
	    if ($query -> num_rows() > 0)
		{
			foreach($query->result() as $usr){
	            $id = $usr-> id;
    	    }
    	    
    	    return $id;
    	    
		}else{
			return false;
		}
		
	}
	
	
	//For Auto WA
	function get_my_overtime_id($id){
	    $this->db->select('SUM(nilai) as nl', false);
	    $this->db->where('id_user',$id);
	    $query = $this->db->get('lembur');
	    
	    foreach($query->result() as $ot){
	        $over = $ot-> nl;
	    }
	    
	    return $over;
	    
	}
	
	function get_my_overtime(){
	    $this->db->select('SUM(nilai) as nl', false);
	    $this->db->where('id_user',$this->session->userdata('id'));
	    $query = $this->db->get('lembur');
	    
	    foreach($query->result() as $ot){
	        $over = $ot-> nl;
	    }
	    
	    return $over;
	    
	}
	
	
	function add_newevent_incen($name,$dp,$lunas){
	    $data = array(
	        'name' => $name,
	        'dp' => $dp,
	        'lunas' => $lunas
	    );
	    
	    $this->db->insert('list_incentive_sp',$data);
	    return true;
	}
	
	function delete_event_incent($id){
	    $this->db->where('id',$id);
	    $this->db->delete('list_incentive_sp');
	    
	    return true;
	}
	
	function get_my_cutiizin_id($id){

	    $this->db->select('YEAR(tgl) as thn, SUM(plus) as pl, SUM(nilai) as nl');
	    $this->db->where('YEAR(tgl)', date('Y'));
	    $this->db->where('id_user',$id);
	    $query = $this->db->get('cuti_izin');
	    
	    foreach($query->result() as $izin){
	        $cuti_izin_plus = $izin-> pl;
	        $cuti_izin_minus = $izin-> nl;
	    }
	    
	    $izin = $cuti_izin_plus - $cuti_izin_minus;
	    
	    return $izin;
	}
	
	function get_my_cutiizin(){

	    $this->db->select('YEAR(tgl) as thn, SUM(plus) as pl, SUM(nilai) as nl');
	    //$this->db->where('YEAR(tgl)', date('Y'));
	    $this->db->where('id_user',$this->session->userdata('id'));
	    $query = $this->db->get('cuti_izin');
	    
	    foreach($query->result() as $izin){
	        $cuti_izin_plus = $izin-> pl;
	        $cuti_izin_minus = $izin-> nl;
	    }
	    
	    $izin = $cuti_izin_plus - $cuti_izin_minus;
	    
	    return $izin;
	}
	
	function get_my_cutisakit_id($id){

	    $this->db->select('YEAR(tgl) as thn, SUM(plus) as pl, SUM(nilai) as nl');
	    $this->db->where('YEAR(tgl)', date('Y'));
	    $this->db->where('id_user',$id);
	    $query = $this->db->get('cuti_sakit');
	    
	    foreach($query->result() as $sakit){
	        $cuti_sakit_plus = $sakit-> pl;
	        $cuti_sakit_minus = $sakit-> nl;
	    }
	    
	    $sakit = $cuti_sakit_plus - $cuti_sakit_minus;
	    
	    return $sakit;
	}
	
	function get_my_cutisakit(){

	    $this->db->select('YEAR(tgl) as thn, SUM(plus) as pl, SUM(nilai) as nl');
	    $this->db->where('YEAR(tgl)', date('Y'));
	    $this->db->where('id_user',$this->session->userdata('id'));
	    $query = $this->db->get('cuti_sakit');
	    
	    foreach($query->result() as $sakit){
	        $cuti_sakit_plus = $sakit-> pl;
	        $cuti_sakit_minus = $sakit-> nl;
	    }
	    
	    $sakit = $cuti_sakit_plus - $cuti_sakit_minus;
	    
	    return $sakit;
	}
	
	function get_all_incentive_list(){
	    $query = $this->db->get('list_incentive_sp');
	    if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	}
	
	function get_addlembur(){
	
		$iduser = $this->session->userdata('id');
		$date_start = date('Y-m-d', strtotime("-7 days"));
		$date_end = date('Y-m-d');
		
		$sql = 'SELECT * 
FROM lembur_app_spv
WHERE IF(  `status` =  "tidak", (`tgl_Approved` BETWEEN  "'.$date_start.'" AND  "'.$date_end.'" ),((( tgl_Approved BETWEEN  "'.$date_start.'" AND  "'.$date_end.'" ) AND (( acc_hr =  "ya"
)OR ( acc_hr =  "tidak" ) )) OR ( acc_hr IS NULL ) )) AND (id_user = '.$iduser.') ORDER BY `tgl` ASC';

		$query = $this->db->query($sql);
		
		
		return $query->result();
	}
	
	function delete_addlembur($id){
		$this->db->where('id',$id);
		$this->db->where('status',null);
		$query = $this->db->get('lembur_app_spv');
		
		if ($query -> num_rows() == 1)
		{
			$this->db->where('id', $id);
			$this->db->delete('lembur_app_spv');
			return true;
		}else{
			return false;
		}

	}
	
	
	
	function update_addlembur($id, $desc, $nilai){
    	$data = array(
    	    'deskripsi' => $desc,
	        'nilai' => $nilai
        );
	        
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv',$data);
		return true;
	}
	
	
	function get_acclembur(){
	    
	    $this->db->from('user');
	    $this->db->join('divisi', 'divisi.id = user.id_divisi', 'left');
		$this->db->where('departement','Manager');
		$this->db->where('user.id',$this->session->userdata('id'));
		$query = $this->db->get();

        if($query->num_rows() <> null ){
		
		    $this->db->select('*, lembur_app_spv.id as idt, lembur_app_spv.status as lass');
    	 	$this->db->from('lembur_app_spv');
    		$this->db->join('divisi', 'divisi.id = lembur_app_spv.id_divisi', 'left');
    		$this->db->join('user', 'user.id = lembur_app_spv.id_user', 'left');
    		
    		$where = '((nilai > 2 AND lembur_app_spv.status is null) OR (nilai > 0 AND departement = "Manager" AND lembur_app_spv.status is null) )';
       	    $this->db->where($where);
       	    
       	    $this->db->order_by('tgl','asc');
       	
    		//$this->db->where('nilai >','2');
    		//$this->db->where('lembur_app_spv.status', null);
    		
    		$query = $this->db->get();
		    return $query->result();
		    
        }else{
            $this->db->select('*, lembur_app_spv.id as idt, lembur_app_spv.status as lass');
    	 	$this->db->from('lembur_app_spv');
    		$this->db->join('divisi', 'divisi.id = lembur_app_spv.id_divisi', 'left');
    		$this->db->join('user', 'user.id = lembur_app_spv.id_user', 'left');
    		$this->db->where('id_user_spv',$this->session->userdata('id'));
    		$this->db->where("nilai BETWEEN '0' AND '2'");
    		$this->db->where('lembur_app_spv.status', null);
    		
    		$this->db->order_by('tgl','asc');
    		
    		$query = $this->db->get();
		    return $query->result();
        }
	
	}
	
	function get_acchr_lembur(){
			
		$this->db->select('*, lembur_app_spv.id as idt, lembur_app_spv.status as lass');
	 	$this->db->from('lembur_app_spv');
		$this->db->join('user', 'user.id = lembur_app_spv.id_user', 'left');
		$this->db->where('lembur_app_spv.status', 'ya');
		$this->db->where('lembur_app_spv.acc_hr', null);
		
		$query = $this->db->get();
		return $query->result();
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
	
	function toapprove_lembur_hr($id){
	
		//Update Status
		$data = array(
	               'acc_hr' => 'ya',
	               'tgl_approved' => date('Y-m-d')
	        );
	
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv', $data);
		
		//Mendapatkan datanya
		$this->db->where('id',$id);
		$query = $this->db->get('lembur_app_spv');
		
		if ($query -> num_rows() == 1)
		{
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
			 	
		 	$this->db->insert('lembur',$data);
		 	return true;
					
		}else{
			return false;
		}
		
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
	
	function toreject_lembur_hr($id){
		//Update Status
		$data = array(
	               'acc_hr' => 'tidak',
	               'tgl_approved' => date('Y-m-d')
	        );
	
		$this->db->where('id', $id);
		$this->db->update('lembur_app_spv', $data);
		return true;
	}
	
	function addlembur($desc,$nilai,$tgl){
		
		/*$this->db->where('tgl',$tgl);
		$this->db->where('id_user',$this->session->userdata('id'));
		$query = $this->db->get('lembur_app_spv');
		
		
		//Deteksi tanggal belum diinput
		if ($query -> num_rows() > 0)
		{
			return false;
		}else{
			
		}*/
		
		$data = array(
	 		'id_user' => $this->session->userdata('id'),
	 		'id_divisi' => $this->session->userdata('iddivisi'),
	 		'tgl' => $tgl,
	 		'deskripsi' => $desc,
	 		'nilai' => $nilai
		 );
		 	
	 	$this->db->insert('lembur_app_spv',$data);
	 	return true;
	
	
		
	}
 
	function change_pic_user($new_pic)
	{
	
		$data = array(
	               'picture' => $new_pic
	        );
	
		$this->db->where('id', $this->session->userdata('id'));
		$this->db->update('user', $data); 
		
		$this->session->set_userdata('picture',$new_pic);
		
		return true;
	
	 }
	 
	 function check_approved_incentive($id)
	 {
	     $this->db->where('id_task',$id);
	     $this->db->where('status_acc',null);
	     
	     $query = $this->db->get('incentive');
	     
	    if ($query -> num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}
	     
	 }
	 
	 function approved_incentive($id)
	 {
	 	$data = array(
           'status_acc' => 'ya',
           'tgl_acc' => date('Y-m-d')
	    );
	        
	 	$this->db->where('id_task',$id);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function unapproved_incentive($id)
	 {
	 	$data = array(
	               'status_acc' => null,
	               'status_paid' => null,
	               'tgl_acc' => null
	        );
	        
	 	$this->db->where('id_task',$id);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function approved_incentive_satuan($ii)
	 {
	 	$data = array(
	               'status_acc' => 'ya',
	               'tgl_acc' => date('Y-m-d')
	    );
	        
	 	$this->db->where('id',$ii);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function can_approved_incentive_satuan($ii)
	 {
	 	$data = array(
	               'status_acc' => null,
	               'status_paid' => null,
	               'tgl_acc' => null
	    );
	        
	 	$this->db->where('id',$ii);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function check_paid_incentive($id)
	 {
	     $this->db->where('id_task',$id);
	     $this->db->where('status_paid',null);
	     
	     $query = $this->db->get('incentive');
	     
	    if ($query -> num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}
	     
	 }
	 
	 function approved_paid_satuan($ii)
	 {
	 	$data = array(
	               'status_paid' => 'paid'
	    );
	        
	 	$this->db->where('id',$ii);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function can_approved_paid_satuan($ii)
	 {
	 	$data = array(
	               'status_paid' => null
	    );
	        
	 	$this->db->where('id',$ii);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function approved_paid_all($id_task)
	 {
	 	$data = array(
	               'status_paid' => 'paid'
	    );
	        
	 	$this->db->where('id_task',$id_task);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function unapproved_paid_all($id_task)
	 {
	 	$data = array(
	               'status_paid' => null
	    );
	        
	 	$this->db->where('id_task',$id_task);
	 	$this->db->update('incentive', $data);
	 	
	 	return true;	 
	 }
	 
	 function send_notif_incentive($id_task){

		$this->db->select('*, incentive.id as ici, incentive.id_user as iit');
	 	$this->db->from('incentive');
		$this->db->join('task', 'task.id = incentive.id_task', 'left');
		$this->db->join('user', 'user.id = incentive.id_user', 'left');
		
	 	$this->db->where('id_task',$id_task);
	 	$this->db->order_by('iit', 'asc');
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function komisilunas($id_task){
	 	$this->db->where('id',$id_task);
	 	$query = $this->db->get('task');
	 	
	 	if ($query -> num_rows() > 0)
		{
			foreach($query->result() as $r){
				$komisilunas = $r->komisi_lunas;
			}
			
			return $komisilunas;
		}else{
			return false;
		}
	 }
	 
	 function komisidp($id_task){
	 	$this->db->where('id',$id_task);
	 	$query = $this->db->get('task');
	 	
	 	if ($query -> num_rows() > 0)
		{
			foreach($query->result() as $r){
				$komisilunas = $r->komisi_dp;
			}
			
			return $komisilunas;
		}else{
			return false;
		}
	 }
	 	 
	 function birdtest_lock($status)
	 {
	 	if($status == 'LOCKED'){
		 	$data = array(
		               'lock' => 'no'
		        );
	        }else{
	        	$data = array(
		               'lock' => 'yes'
		        );
	        };
	        
	
		$this->db->where('id', 1);
		$this->db->update('birdtest_settings', $data); 

		return true;
	 }
	 
	 function birdtest_war($username,$waktu,$p,$d,$e,$o)
	 {
	 	//Search ID User
	 	$this->db->where('username',$username);
		$query = $this->db->get('user');
		
		foreach($query->result() as $r){
			$id_user = $r->id;
		}
		
		$this->db->where('id_user',$id_user);
		$search = $this->db->get('birdtest');
		if ($search -> num_rows() > 0)
		{
			$data = array(
		 		'id_user' => $id_user,
		 		'waktu' => $waktu,
		 		'peacock' => $p,
		 		'dove' => $d,
		 		'eagle' => $e,
		 		'owl' => $o
		 	);
		 	
		 	$this->db->where('id_user',$id_user);
		 	$this->db->update('birdtest',$data);
		 	return true;
		 	
		 	
		}else{
			$data = array(
		 		'id_user' => $id_user,
		 		'waktu' => $waktu,
		 		'peacock' => $p,
		 		'dove' => $d,
		 		'eagle' => $e,
		 		'owl' => $o
			 );
			 	
		 	$this->db->insert('birdtest',$data);
		 	return true;
		}
		
		
	 	
	 }
	 
	 function getusername_report_task()
	 {
	 	//$ignore = array('aktif', null);
		//$this->db->where_in('status', $ignore);
		
		$where = '(status="aktif" or status is null)';
       		$this->db->where($where);
       
		$this->db->order_by('id','asc');
	 	$query = $this->db->get('user');
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function get_birdtest_settings()
	 {
	 	$this->db->where('id', 1);
	 	$query = $this->db->get('birdtest_settings');
	 	
	 	if ($query -> num_rows() > 0)
		{
			foreach($query->result() as $r){
				$lock = $r->lock;
			}
			
			return $lock;	
		}else{
			return false;
		}
	 }
	 
	 function getusername_detail_incentive()
	 {
		//$this->db->where('as', null);
		
		$where = '(status="aktif" or status is null)';
       		$this->db->where($where);
		       		
		$this->db->order_by('id','asc');
	 	$query = $this->db->get('user');
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function info_pd_incentive()
	 {
	 
	 	$this->db->select('*, task_user.id as tui');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		
		$date_start = date('Y-m-d', strtotime("-30 days"));
		$date_end = date('Y-m-d', strtotime("+360 days"));
		
		$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (tugas="pd") AND ((id_user='.$this->session->userdata('id').' AND (persetujuan_pengganti = "tidak" OR persetujuan_pengganti IS null)) OR (id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti = "ya"))' ;
	 	
	 	$query = $this->db->where($where);
	 	$this->db->order_by('date','asc');
	 	
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function add_incentive($id_event,$user,$peserta,$bayar,$closing,$programlain)
	 {
	 
	 	//Search ID User
	 	$this->db->where('username',$user);
		$query = $this->db->get('user');
		
		foreach($query->result() as $r){
			$id_user = $r->id;
		}
		
		//Tanggal Sekarang
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
	 	    
	 	    if ($query -> num_rows() == 1)
    		{
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
		 	
	 	$this->db->insert('incentive',$data);
	 	return true;
	 
	 }
	 
	 function update_incentive($id_incentive,$user,$peserta,$bayar,$closing,$id_event,$programlain)
	{
	
		//Search ID User
	 	$this->db->where('username',$user);
		$query = $this->db->get('user');
		
		foreach($query->result() as $r){
			$id_user = $r->id;
		}
		
		//Tanggal Sekarang
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
    			
    			$this->db->where('id',$id_incentive);
    			$this->db->update('incentive',$data);
    			
		    }else{
		        
		        $this->db->where('name',$programlain);
	 	    
    	 	    $query = $this->db->get('list_incentive_sp');
    	 	    
    	 	    if ($query -> num_rows() == 1)
        		{
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
    			    $this->db->update('incentive',$data);
        		 
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
    			
    			$this->db->insert('incentive',$data);
    			
		    }else{
		        
		         $this->db->where('name',$programlain);
	 	    
    	 	    $query = $this->db->get('list_incentive_sp');
    	 	    
    	 	    if ($query -> num_rows() == 1)
        		{
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
    			    
    			    $this->db->insert('incentive',$data);
    			    
        		}else{
        		    return false;
        		}
		        
		    }
			
			
			
		}
		
		return true;
		
	}
	 
	 function get_hsl_incentive($id_event)
	 {
	 	$this->db->select('*, incentive.id as ici');
	 	$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');
		$this->db->join('user', 'user.id = incentive.id_user', 'left');
		
	 	$this->db->where('id_task',$id_event);
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 	
	 
	 }
	 
	 function get_hsl_number_incentive($id_event)
	 {
	 	$this->db->select('*');
	 	$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');
		$this->db->join('user', 'user.id = incentive.id_user', 'left');
		
	 	$this->db->where('id_task',$id_event);
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query -> num_rows();
		}else{
			return false;
		}
	 	
	 
	 }
	 
	 function del_list_incentive($id_incentive)
	 {
	 	$this->db->where('id',$id_incentive);
	 	$this->db->delete('incentive');
	 	return true;
	 
	 }
	 
	 function get_my_incentive()
	 {
	 	$this->db->from('task');
		$this->db->join('incentive', 'task.id = incentive.id_task', 'left');

		
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->where('status_acc','ya');

	 	$this->db->order_by('id_task','desc');
	 	$this->db->order_by('date','desc');
	 	$this->db->order_by('program_lain','desc');
	 	
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function get_my_incentive_paid(){
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
	 
	 function get_my_incentive_unpaid(){
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
	 
	 
	 function get_list_incentive()
	 {
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
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
		
	 }
	 
	 function get_list_incentive_last()
	 {
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
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
		
	 }
	 
	 	 
	 function get_all_incentive($id)
	 {
	 	$this->db->select('*, incentive.id as ii');
	 	$this->db->from('incentive');
		$this->db->join('task', 'incentive.id_task = task.id', 'left');
	 	$this->db->join('user', 'incentive.id_user = user.id', 'left');
		
	 	$this->db->where('task.id',$id);
	 	$this->db->order_by('id_user','asc');
		
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function get_pd_incentive($id_event)
	 {
	 	$this->db->select('*, task_user.id as tui, task.id as ti');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		
		$id_pd = $this->session->userdata('id');
		
	 	/*$this->db->where('id_user',$this->session->userdata('id'));
	 	$this->db->where('id_task',$id_event);
	 	$query = $this->db->where('tugas','pd');*/
	 	
	 	$where = "((id_user = '$id_pd') OR (id_pengganti = '$id_pd')) AND id_task = '$id_event' AND tugas = 'pd'";
        $this->db->where($where);
	 	
	 	$this->db->order_by('date','desc');
	 	
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function get_event_all_notpay($iduser)
	 {
	 	$this->db->where('id_user',$iduser);
	 	$this->db->where('paytask',null);
	 	$query = $this->db->get('task_user');
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->num_rows();
		}else{
			return false;
		}
	 }
	 
	 function get_event_all_pay($iduser)
	 {
	 	$this->db->where('id_user',$iduser);
	 	$this->db->where('paytask',1);
	 	$this->db->where('hadir','ya');
	 	$query = $this->db->get('task_user');
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->num_rows();
		}else{
			return false;
		}
	 }
	 function get_event_all_hutang($iduser)
	 {
	 	$date_start = '2016-01-01';
		$date_end = date('Y-m-d', strtotime("-3 days"));
		
	 	$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (id_user='.$iduser.' AND (task_user.hadir = "tidak")) AND (paytask is Null)' ;
	 	$this->db->where($where);
	 	
	 	$this->db->select('*, task_user.id as tui');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
	 	$query = $this->db->get();
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->num_rows();
		}else{
			return false;
		}
	 }
	 
	function cek_uang_masuk($ji,$bp,$np,$tgl,$jp,$norek)
	{
	
		$data = array(
		 		'id_user' => $this->session->userdata('id'),
		 		'jenis_income' => $ji,
		 		'bank_pengirim' => $bp,
		 		'nama_pengirim' => $np,
		 		'tgl_kirim' => $tgl,
		 		'jumlah' => $jp,
		 		'ke_rekening' => $norek
		 	);
		 	
	 	$this->db->insert('cek_uang_masuk',$data);
	 	return true;
	
	}
	
	function user_add_task_paytask()
	{
		$ignore = array('taskadmin', 'admin');
		$this->db->where_not_in('username', $ignore);
		$query = $this->db->get('user');
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
		
	
	}
	
	function user_add_task_paytask_adding($idevent,$username)
	{
	
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		
		foreach($query->result() as $r){
			$id_user = $r->id;
		}
		
		//cek user id not in that event
		$this->db->where('id_user',$id_user);
		$this->db->where('id_task',$idevent);
		$query = $this->db->get('task_user');
		
		if ($query -> num_rows() > 0)
		{
			return false;
		}else{
			$data = array(
		 		'id_task' => $idevent,
		 		'id_user' => $id_user,
		 		'paytask' => 1
	 		);
	 	
		 	$this->db->insert('task_user',$data);
			return true;
		}
	
	}
	
	function get_cek_uang_masuk()
	{
		$this->db->where('id_user',$this->session->userdata('id'));
		$this->db->order_by('id','desc');
		$query = $this->db->get('cek_uang_masuk');
		
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	}
	
	function get_cek_uang_masuk_all()
	{
		$this->db->select('*, cek_uang_masuk.id as cumi');
		$this->db->from('cek_uang_masuk');
		$this->db->join('user', 'user.id = cek_uang_masuk.id_user', 'left');
		
		$this->db->order_by('cumi','desc');
		$query = $this->db->get();
		
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	}
	
	function approve_moneychecker($idcumi)
	{
		$data = array (
			'approve' => 'ya',
			'tgl_approve' => date('Y-m-d')
		);
		
		$this->db->where('id',$idcumi);
		$this->db->update('cek_uang_masuk',$data);
		
		return true;
		
	}
	function not_approve_moneychecker($idcumi)
	{
		$data = array (
			'approve' => 'tidak',
			'tgl_approve' => date('Y-m-d')
		);
		
		$this->db->where('id',$idcumi);
		$this->db->update('cek_uang_masuk',$data);
		
		return true;
		
	}
	 
	 function getusername_event($idevent)
	 {
	 	$this->db->where('id_task',$idevent);
	 	$query = $this->db->get('task_user');
	 	
	 	return $query->result();
	 	
	 }
	 
	 function get_minus_event()
	 {
	 
	 	$date_start = '2016-01-01';
		$date_end = date('Y-m-d', strtotime("-1 days"));
		
	 	$where = '((date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (id_user='.$this->session->userdata('id').' AND (task_user.hadir = "tidak")) AND (paytask is Null) )' ;
	 	$this->db->where($where);
	 	
	 	$this->db->select('*, task_user.id as tui');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 
	 }
	 
	 function get_plus_event()
	 {
	 	$this->db->where('paytask',1);
	 	$this->db->where('hadir','ya');
	 	$this->db->where('id_user',$this->session->userdata('id'));
	 	
	 	$query = $this->db->get('task_user');
	 	
	 	if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 	
	 }
	 
	 function batalkan_pertukaran($idevent)
	 {
	 
	 	$data = array(
	 		'id_pengganti' => null,
	 		'persetujuan_pengganti' => null
	 	);
	 	
	 	$this->db->where('id',$idevent);
	 	$this->db->update('task_user',$data);
	 	return true;
	 
	 }
	 
	 function get_user_mail($idevent)
	 {
	 
	 	$this->db->where('id',$idevent);
	 	$query = $this->db->get('task_user');
	 	
	 	foreach ($query->result() as $r){
	 		$idu = $r->id_user;
	 	}
	 	
	 	$this->db->where('id',$idu);
	 	$query = $this->db->get('user');
	 	
	 	return $query->result();
	 	
	 
	 }
	 
	 function riject_konfirmasi_pertukaran($idevent)
	 {
	 
	 	$data = array(
	 		'id_pengganti' => null,
	 		'persetujuan_pengganti' => null
	 	);
	 	
	 	$this->db->where('id',$idevent);
	 	$this->db->update('task_user',$data);
	 	return true;
	 
	 }
	 
	 function getidtask_get($idevent)
	 {
	 	$this->db->where('id',$idevent);
	 	$query = $this->db->get('task');
	 	
	 	return $query->result();
	 }
	 
	 function update_report_pd($idevent, $iduser, $tugas, $dp, $modul, $lunas, $hadir)
	 {
	 
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
	 	
	 	if ($query -> num_rows() == 1)
		{
			$data = array(
		 		'tugas' => $tugas,
		 		'dp' => $dp,
		 		'modul' => $modul,
		 		'lunas' => $lunas,
		 		'hadir' => $hadir
		 	);
		 	
		 	$this->db->where('id_task',$idevent);
		 	$this->db->where('id_user',$iduser);
		 	$this->db->update('task_user',$data);
		 	return true;
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
		 	$this->db->update('task_user',$data);
		 	return true;
		}
		
		
	 	
	 	
	 }
	 
	 function update_report_pd_task($idevent,$daftar,$ots,$hadir,$tidak_hadir)
	 {
	 	
	 	$data = array(
	 		'daftar' => $daftar,
	 		'ots' => $ots,
	 		'hadir' => $hadir,
	 		'tidak_hadir' => $tidak_hadir	 		
	 	);
	 	
	 	$this->db->where('id',$idevent);
	 	$this->db->update('task',$data);
	 	return true;
	 	
	 }
	 
	 function getusername_event_get($id)
	 {
	 	$this->db->where('id',$id);
	 	$qn = $this->db->get('user');
	 	
	 	return $qn->result();
	 }
	 
	 function tambah_war_task($id_task,$username)
	 {	 	
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id_user = $r->id;
	 	}
	 	
	 	//check user have been added or not in this event
		$this->db->where('id_task',$id_task);
		$this->db->where('id_user',$id_user);
	 	$query = $this->db->get('task_user');
	 	if ($query -> num_rows() == null)
		{	 	
		 	$data = array(
		 		'id_task' => $id_task,
		 		'id_user' => $id_user		
		 	);
		 	
		 	$this->db->insert('task_user',$data);
		 	return true;
		 }else{
		 	//always true because we dont need to adding again
		 	return true;
		 }
	 }
	 
	 function pay_war_task($id_task,$username)
	 {	 	
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id_user = $r->id;
	 	}
	 	
	 	//check user have been added or not in this event
		$this->db->where('id_task',$id_task);
		$this->db->where('id_user',$id_user);
	 	$query = $this->db->get('task_user');
	 	if ($query -> num_rows() == null)
		{	 	
		 	$data = array(
		 		'id_task' => $id_task,
		 		'id_user' => $id_user,
		 		'paytask' => 1		
		 	);
		 	
		 	$this->db->insert('task_user',$data);
		 	return true;
		 }else{
		 	//always true because we dont need to adding again
		 	return true;
		 }
	 }
	 
	 function get_satuan_task($id)
	 {
	     $this->db->where('id',$id);
	     $query = $this->db->get('task');
	     
	     if ($query -> num_rows() == 1)
		{
			return $query->result();
		}else{
			return false;
		}
	     
	 }
	 
	 function get_task()
	 {
	 	
		
		$this->db->select('*, task.id as idt');
		$this->db->from('task');
		
		//Pengambilan data dimulai dari tanggal sekarang hingga 1 tahun kedepan
		$date_start = date('Y-m-d');
		$thn = date('Y') + 1;
		$date_end = date(''.$thn.'-m-d');
		
	 	$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
	 	$this->db->where($where);
	 	
	 	
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->order_by('date','asc');
		//Ini filter baru ditambahkan yg event
		$this->db->order_by('event','asc');
		$this->db->order_by('idt','asc');
		
		
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function get_alltask()
	 {
	 	
		
		$this->db->select('*, task.id as idt');
		$this->db->from('task');
		
		//Pengambilan data hanya 1 tahun
		$thn = date('Y') - 1;
		$date_start = date(''.$thn.'-m-d');

		$date_end = date('Y-m-d', strtotime("-1 days"));
		
	 	$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
	 	$this->db->where($where);
	 	
	 	
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->order_by('date','desc');
		$this->db->order_by('idt','desc');
		
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 
	 //cek user tidak ada event disaat yang sama
	 function event_digantikan_cek($idevent,$getname)
	 {
	 	$this->db->where('username',$getname);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$iduser = $r->id;
	 	}
	 	
	 	$this->db->where('id',$idevent);
	 	$query = $this->db->get('task_user');
	 	
	 	foreach($query->result() as $r){
	 		$idt = $r->id_task;
	 	}
	 	
	 	$this->db->where('id_task',$idt);
	 	$this->db->where('id_user',$iduser);
	 	$query = $this->db->get('task_user');
	 	
	 	if ($query -> num_rows() <> 0)
		{
			return false;
		}else{
			return true;
		}
		
	 
	 }
	 
	  //Cek user tidak sedang menggantikan / tidak ada request
	 function event_digantikan_request($idevent,$getname)
	 {
	 	$this->db->where('username',$getname);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$iduser = $r->id;
	 	}
	 	
	 	$this->db->where('id',$idevent);
	 	$query = $this->db->get('task_user');
	 	
	 	foreach($query->result() as $r){
	 		$idt = $r->id_task;
	 	}
	 	
	 	$this->db->where('id_task',$idt);
	 	$this->db->where('id_pengganti',$iduser);
	 	$query = $this->db->get('task_user');
	 	
	 	if ($query -> num_rows() <> 0)
		{
			return false;
		}else{
			return true;
		}
		
	 
	 }
	 
	 function event_digantikan($idevent,$getname)
	 {
	 	$this->db->where('username',$getname);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$iduser = $r->id;
	 	}
	 	
	 	$data = array(
	 		'id_pengganti' => $iduser,
	 		'persetujuan_pengganti' => null
	 	);
	 	
	 	$this->db->where('id',$idevent);
	 	$this->db->update('task_user',$data);
	 	return true;
	 
	 }
	 
	 function get_username_penggantitask($id)
	 {
	 	$this->db->where('id',$id);
	 	$query = $this->db->get('user');
	 	
	 	if ($query -> num_rows() == 1)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function get_mytask()
	 {
	 	$date_start = date('Y-m-d', strtotime("-30 days"));
		$date_end = date('Y-m-d', strtotime("+360 days"));
		
	 	$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND (id_user='.$this->session->userdata('id').' OR (id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti = "ya"))' ;
	 	$this->db->where($where);
	 	
		
	 	
	 	$this->db->select('*, task_user.id as tui');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 	
	 }
	 
	 function get_all_mytask()
	 {
	 	//$this->db->where('id_user', $this->session->userdata('id'));
	 	
	 	$where = 'id_user='.$this->session->userdata('id').' OR (id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti = "ya") ';
	 	$this->db->where($where);
	 	
	 	$this->db->select('*, task_user.id as tui');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->order_by('date','desc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 	
	 }
	 
	 function get_submission_task()
	 {
	 	
	 	$date_start = date('Y-m-d', strtotime("-1 days"));
		$date_end = date('Y-m-d', strtotime("+360 days"));
		
	 	$where = '(date BETWEEN "'.$date_start.'" AND  "'.$date_end.'") AND id_user='.$this->session->userdata('id').' AND id_pengganti <>'.null;
	 	$this->db->where($where);
	 	
	 	
	 	$this->db->select('*, task_user.id as tui');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 	
	 }
	 
	 function approve_request_task($idtask,$idpengganti)
	 {
	 	$data = array(
	 		'id_pengganti' => $idpengganti,
	 		'persetujuan_pengganti' => 'ya'
	 	);
	 	
	 	$this->db->where('id',$idtask);
	 	$this->db->update('task_user',$data);
	 	return true;
	 }
	 
	 function get_request_task()
	 {
	 	
	 	$where = 'id_pengganti='.$this->session->userdata('id').' AND persetujuan_pengganti ='.null;
	 	$this->db->where($where);
	 	
	 	$this->db->select('*, task_user.id as tui');
	 	$this->db->from('task');
		$this->db->join('task_user', 'task.id = task_user.id_task', 'left');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 	
	 }
	 
	 function edit_task($id,$nama,$location,$tgl,$jenis_report,$komisi_dp,$komisi_lunas)
	 {
	 	$data = array(
	 		'event' => $nama,
	 		'location' => $location,
	 		'date' => $tgl,
	 		'jenis_report' => $jenis_report,
	 		'komisi_dp' => $komisi_dp,
	 		'komisi_lunas' => $komisi_lunas
	 	);
	 	
	 	$this->db->where('id',$id);
	 	$this->db->update('task',$data);
	 	
	 	return true;
	 }
	 
	  function delete_task($id)
	 {
	 	$this->db->where('id',$id);
	 	$this->db->delete('task');
	 	
	 	$this->db->where('id_task',$id);
	 	$this->db->delete('task_user');
	 	
	 	return true;
	 }
	 
	 
	 function delete_wartask($id_task,$id_user)
	 {
	 	$this->db->where('id_task',$id_task);
	 	$this->db->where('id_user',$id_user);
	 	$this->db->delete('task_user');
	 	
	 	return true;
	 }
	 
	 function getpd($id_task,$username)
	 {
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id_user = $r->id;
	 	}
	 	
	 	//Change PD event to null first
	 	$data = array(
	               'tugas' => Null
	        );
	        $this->db->where('tugas','pd');
	        $this->db->where('id_task',$id_task);
	        $this->db->update('task_user', $data);
	 	
	 	//Make New pd
	 	$data = array(
	               'tugas' => 'pd'
	        );

	 	$this->db->where('id_task',$id_task);
	 	$this->db->where('id_user',$id_user);
	 	$this->db->update('task_user', $data);
	 	
	 	return true;
	 }
	 
	 
	 function getusername_task($id)
	 {
	 	$this->db->where('id_task',$id);
		$this->db->from('task_user');
		$this->db->join('user', 'user.id = task_user.id_user', 'left');
		$query = $this->db->get();
		
		if ($query -> num_rows() > 0)
		{
			return $query->result();
		}else{
			return false;
		}
	 }
	 
	 function get_select_task($id,$token)
	 {
	 
	 	if(md5($id)==$token){
		 	$this->db->where('id',$id);
		 	$query = $this->db->get('task');
		 	
		 	if ($query -> num_rows() == 1)
			{
				return $query->result();
			}else{
				return false;
			}
		}else{
			return false;
		}
	 }
	 
	 function change_data_user($name,$divisi,$position)
	{
	
		$data = array(
	               'name' => $name ,
	               'position' => $position,
	               'divisi' => $divisi,
	                         
	        );
	
		$this->db->where('id', $this->session->userdata('id'));
		$this->db->update('user', $data); 
		
		$this->session->set_userdata('name',$name);
		$this->session->set_userdata('position',$position);
		$this->session->set_userdata('divisi',$divisi);
		
		return true;
	
	 }
	 
	 function cek_next_pass($lp)
	 {
	 
	 	$this->db->select('*');
		$this->db->from('user');
		$this->db->where('id',$this->session->userdata('id'));
		$this->db->where('password',MD5($lp));
		$query = $this->db->get();
		if ($query -> num_rows() == 1)
		{
			return $query->result();
		}else{
			return false;
		}
	 
	 }
	 
	 function tambah_task($nama,$location,$date,$jenis_report,$komisi_lunas,$komisi_dp)
	 {
	 	$data = array(
	 		'event' => $nama,
	 		'location' => $location,
	 		'date' => $date,
	 		'jenis_report' => $jenis_report,
	 		'komisi_lunas' => $komisi_lunas,
	 		'komisi_dp' => $komisi_dp
	 	);
	 	
	 	$this->db->insert('task',$data);
	 	
	 	return true;
	 		 	
	 }
	 
	 function get_total_cuti($username){
	 
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
		
	 	$this->db->where('id_user',$id);
	 	$this->db->order_by('tgl','asc');

		
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
	 
	 function get_total_cuti_sakit($username){
	 
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
	 	
	 	//Get month on january with date is 1 with same this years
	 	$bln = 01;
		$thn = date("Y");
		$d=01;
		$lastdate = $thn.'-'.$bln.'-'.$d;
		
		//Get now date
		$getnow = date('Y-m-j');
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->order_by('tgl','asc');
	 	$this->db->where('tgl >=', $lastdate);
		$this->db->where('tgl <=', $getnow);
	 	$query = $this->db->get('cuti_sakit');
	 	
	 	$nilai = 0;
	 	foreach ($query->result() as $r){
	 		if($r->plus <> 0){
	 			$nilai = $nilai + $r->plus;
	 		}else{
	 			$nilai = $nilai - $r->nilai;
	 		}
	 	}
	 	
	 	return $nilai;
	 
	 }
	 
	 function get_total_lembur($username){
		$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
		
	 	$this->db->where('id_user',$id);
		
		$this->db->select_sum('nilai');
	 	$query = $this->db->get('lembur');
	 	
	 	foreach($query->result() as $r){
	 		$lembur = $r->nilai;
	 	}
	 	
	 	return $lembur;
	 }
	 
	 function change_pass($np)
	 {
	 	$data = array(
	               'password' => md5($np)	               	                         
	        );
	        
	        $this->db->where('id', $this->session->userdata('id'));
		$this->db->update('user', $data);
	 }
	 
	 function getusername()
	 {
	 	//$this->db->where('as', null);
	 	$where = '(status="aktif" or status is null)';
       		$this->db->where($where);
	 	
	 	$query = $this->db->get('user');
	 	if ($query -> num_rows() > 0)
		{
	 		return $query->result();
	 	}else{
	 		return false;
	 	}
	 }
	 
	 function get_birdtest($username)
	 {
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
	 	$this->db->where('id_user', $id);
	 	$query = $this->db->get('birdtest');
	 	if ($query -> num_rows() > 0)
		{
	 		return $query->result();
	 	}else{
	 		return false;
	 	}
	 }
	 
	 function getusername_bulanan()
	 {
	 	$this->db->where('as', null);
	 	$this->db->where('jenis_cuti','bulanan');
	 	$query = $this->db->get('user');
	 	if ($query -> num_rows() > 0)
		{
	 		return $query->result();
	 	}else{
	 		return false;
	 	}
	 }
// 	 function getusername_tahunan()
// 	 {
// 	 	$this->db->where('as', null);
// 	 	$this->db->where('jenis_cuti','tahunan');
// 	 	$query = $this->db->get('user');
// 	 	if ($query -> num_rows() > 0)
// 		{
// 	 		return $query->result();
// 	 	}else{
// 	 		return false;
// 	 	}
// 	 }
	 
	 function tambah_cuti_manual($getnm,$plus,$tgl,$deskripsi)
	 {
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
	 	
	 	$this->db->insert('cuti_izin',$data);
	 	
	 	return true;

	 }
	 
	 
	 function tambah_cuti_bulanan($id_user)
	 {
	
	 	$data = array (
	 		'id_user' => $id_user,
	 		'tgl' => date('Y-m-d'),
	 		'deskripsi' => 'Pencairan cuti Izin Bulanan',
	 		'plus' => 1
	 		);
	 	
	 	$this->db->insert('cuti_izin',$data);
	 	
	 	$data = array (
	 		'id_user' => $id_user,
	 		'tgl' => date('Y-m-d'),
	 		'deskripsi' => 'Pencairan cuti Sakit Bulanan',
	 		'plus' => 1
	 		);
	 	
	 	$this->db->insert('cuti_sakit',$data);
	 }
	 
// 	 function tambah_cuti_tahunan($id_user)
// 	 {
	
// 	 	$data = array (
// 	 		'id_user' => $id_user,
// 	 		'tgl' => date('Y-m-d'),
// 	 		'deskripsi' => 'Pencairan cuti Izin Tahunan',
// 	 		'plus' => 12
// 	 		);
	 	
// 	 	$this->db->insert('cuti_izin',$data);
	 	
// 	 	$data = array (
// 	 		'id_user' => $id_user,
// 	 		'tgl' => date('Y-m-d'),
// 	 		'deskripsi' => 'Pencairan cuti Sakit Tahunan',
// 	 		'plus' => 12
// 	 		);
	 	
// 	 	$this->db->insert('cuti_sakit',$data);
// 	 }
	 
	 function hapus_user($id)
	 {
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
	 
	 function pluslembur($jamlembur,$name,$tgl,$deskripsi,$nilai)
	 {
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
 	
 		$this->db->insert('lembur',$data);
 	
 		return true;
	 	
	 	
	 	
	 	

	 }
	 
	 function minuslembur($jamlembur,$name,$tgl,$deskripsi,$nilai)
	 {
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
 	
 		$this->db->insert('lembur',$data);
 	
 		return true;
	 	

	 }
	 
	  function minuscuti($name,$tgl,$deskripsi,$tcuti)
	 {
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
	 	
	 	$this->db->insert($tcuti,$data);
	 	
	 	return true;

	 }
	 
	 function getdivisi(){
	     
	     $query = $this->db->get('divisi');
	     return $query->result();
	     
	 }
	 
	 function getuser()
	 {
	    //hidden yg sudah resign
	 	//$this->db->where('as', null);
	 	
	 	$where = '(status="aktif" or status is null)';
       	$this->db->where($where);
       		
	 	$query = $this->db->get('user');
	 	if ($query -> num_rows() > 0)
		{
	 		return $query->result();
	 	}else{
	 		return false;
	 	}
	 }
	 
	 function getuser_person($getname)
	 {
	    $this->db->where('username',$getname);
	    
	 	$query = $this->db->get('user');
	 	if ($query -> num_rows() > 0)
		{
	 		return $query->result();
	 	}else{
	 		return false;
	 	}
	 }
	 
	 function getuser_admin()
	 {

	 	$query = $this->db->get('user');
	 	if ($query -> num_rows() > 0)
		{
	 		return $query->result();
	 	}else{
	 		return false;
	 	}
	 }
	 
	 
	 
	 function cek_user_null($username,$email)
	 {
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	
	 	if ($query -> num_rows() == null)
		{
			$this->db->where('email',$email);
	 		$query = $this->db->get('user');
	 		
	 		if ($query -> num_rows() == null)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	 }
	 
	 function tambah_user($nama,$username,$email,$pass,$jenis,$ci,$cs,$lembur)
	 {
	 	//Add New Member
	 	$data = array (
	 		'name' => ucwords($nama),
	 		'username' => strtolower($username),
	 		'email' => $email,
	 		'jenis_cuti' => $jenis,
	 		'password' => md5($pass)
	 	);
	 	
	 	$this->db->insert('user',$data);
	 	
	 	//Get id username
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
	 
	 function edit_user($id,$nama,$jenis_cuti,$depart,$status)
	 {
	 	$data = array (
	 		'name' => $nama,
	 		'jenis_cuti' => $jenis_cuti,
	 		'id_divisi' => $depart,
	 		'status' => $status
	 	);
	 	
	 	$this->db->where('id',$id);
	 	$this->db->update('user',$data);
	 	
	 	return true;
	 }
	 
	 function get_edit_user($id)
	 {
	    $this->db->select('*, user.id as idu');
	    $this->db->from('user');
	    $this->db->join('divisi', 'divisi.id = user.id_divisi', 'left');
	 	$this->db->where('user.id',$id);
	 	$query = $this->db->get();
	 	
	 	return $query->result();
	 }
	 
	 function get_remove_user($id)
	 {
	 	$this->db->where('id',$id);
	 	$query = $this->db->get('user');
	 	
	 	return $query->result();
	 }
	 
	 function getlembur($name)
	 {
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
	 
	 //Get Over Time by Searching date
	 function cari_tgl($name,$cari_tgl)
	 {
	 	$this->db->where('username',$name);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
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
	 
	 function get_detail_lembur($user,$tgl)
	 {
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
	 
	 function delete_detail_lembur($id)
	 {
	 	$this->db->where('id',$id);
	 	$this->db->delete('lembur');
	 	
	 	return true;
	 }
	 
	 
	 function get_lembur_sblm($name,$date)
	 {
	 
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
	 
	 function cari_cuti_izin()
	 {
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
	 
	 function cari_cuti_sakit()
	 {
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
	 
	 function cari_lembur_bulan($bln,$thn)
	 {
		/*$bln = date("m");
		$thn = date("Y");*/
		
		$d=01;
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
	 
	 
	 function cari_desk($name,$cari_tgl)
	 {
	 	$this->db->where('username',$name);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
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
	 
	 function get_laphr()
	 {
	 
	 	$this->db->select('*');
	 	$this->db->from('user');
	 	$this->db->where('as', null);
	 	$query = $this->db->get();
	 	
	 	//$laporan[] = array( 
	 		
	 	foreach($query->result() as $n){
	 		echo $n->id;
	 	}
	 		
	 			//array($name,'tes'),
	 			//array('rua','yus'),
	 	
	 		
	 		
		//);
		
		//return $laporan;
	 
	 }
	 
	 function get_cuti_izin_sblm($username, $fromthn)
	 {
	 
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
	 	//Get month on January with date is 1 with same this years
	 	$bln = 01;
		$thn = $fromthn;
		$d=01;
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
	 
	 function get_cuti_izin($username, $fromthn)
	 {
	 
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
	 	
	 	//Get month on january with date is 2 with same this years
	 	$bln = 01;
		$thn = $fromthn;
		$d=02;
		$lastdate = $thn.'-'.$bln.'-'.$d;
		
		//Get now date
		$getnow = date('Y-m-j');
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->order_by('tgl','asc');
	 	$this->db->where('tgl >=', $lastdate);
		$this->db->where('tgl <=', $getnow);
	 	$query = $this->db->get('cuti_izin');
	 	
	 	return $query->result();
	 	
	 	
	 }
	 
	 function get_cuti_sakit($username)
	 {
	 
	 	$this->db->where('username',$username);
	 	$query = $this->db->get('user');
	 	foreach($query->result() as $r){
	 		$id = $r->id;
	 	}
	 	
	 	
	 	//Get month on january with date is 1 with same this years
	 	$bln = 01;
		$thn = date("Y");
		$d=01;
		$lastdate = $thn.'-'.$bln.'-'.$d;
		
		//Get now date
		$getnow = date('Y-m-j');
	 	
	 	$this->db->where('id_user',$id);
	 	$this->db->order_by('tgl','asc');
	 	$this->db->where('tgl >=', $lastdate);
		$this->db->where('tgl <=', $getnow);
	 	$query = $this->db->get('cuti_sakit');
	 	
	 	return $query->result();
	 	
	 	
	 }
     
     
}