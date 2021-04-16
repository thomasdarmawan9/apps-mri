<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Incentive extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
		$this->load->model('model_incentive');
		$this->load->model('model_task');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72' || $this->session->userdata('id') == '163'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['results'] = $this -> model_incentive -> get_list_incentive_last();
		set_active_menu('Last Task');
		init_view('finance/content_list_incentive_last', $data);
	}
	
	public function future(){		
		$data['results'] = $this -> model_incentive -> get_list_incentive();
		set_active_menu('Future Task');
		init_view('finance/content_list_incentive', $data);
	}
	
	public function detail(){
		$id = $_GET['id'];
		$data['results'] = $this -> model_incentive -> get_all_incentive($id);
		$data['cek_app_incen'] = $this -> model_incentive -> check_approved_incentive($id);
		$data['cek_paid_incen'] = $this -> model_incentive -> check_paid_incentive($id);
		$data['username'] = $this-> model_login -> getusername();
		$data['pro_lain'] = $this-> model_incentive -> get_all_incentive_list();
		
		set_active_menu('Detail Incentive');
		init_view('finance/content_list_detail_incentive', $data);
	}
	
	public function moneychecker(){
		$data['results'] = $this -> model_incentive -> get_cek_uang_masuk_all();
		
		set_active_menu('Money Checker');
		init_view('finance/content_moneychecker', $data);
	}
	
	public function add_row_incentive_finance()
	{	
		$redirect = $this->input->post('redirect');
		$baris = secure($this->input->post('baris'));
		
		redirect($redirect.'&baris='.$baris);		
	
	}
	
	function add_incentive_by_finance()
	{
	    $baris 		= secure($this->input->post('baris'));
	    $id_event	= secure($this->input->post('id_event'));
		
		$eventp = $this->input->post('eventp');
	    $locp = $this->input->post('locp');
	    $tglp = $this->input->post('tglp');
		

	    for ($i = 0; $i < $baris; $i++){
	        $war[] 		= secure($this->input->post('war'.$i));
    	    $peserta[]	= secure($this->input->post('peserta'.$i));
    	    $byr[] 		= secure($this->input->post('byr'.$i));
    	    
    	    $jns 		= secure($this->input->post('jenis'.$i));
    	    $jns_closing[] = $jns;
    	    
    	    $id_program = secure($this->input->post('program'.$i));
    	    
    	    $detail_program = $this -> model_task -> get_info_event($id_program);
    	    
    	    foreach($detail_program as $r){
    	        $dp = $r->dp;
    	        $lunas = $r->lunas;
    	        
    	        if($jns == 'dp'){
    	            $hsl_komisi = $dp;
    	        }elseif($jns == 'lunas'){
    	            $hsl_komisi = $lunas;
    	        }
    	        
    	        $nama_event = $r->name;
    	    }
    	    
    	    
    	    
    	    $komisi[] = $hsl_komisi;
    	    $program[] = $nama_event;
	    }
	    
	    $result = array();

        foreach ($war as $id => $key) {
            $result[$key] = array(
                'war'       => $war[$id],
                'peserta'   => $peserta[$id],
                'program'   => $program[$id],
                'byr'       => $byr[$id],
                'jns'       => $jns_closing[$id],
                'komisi' => $komisi[$id]
            );
        }
	    
	    
	    foreach($result as $r){
	        
            $data = array(
                   'id_task' => $id_event,
                   'id_user' => $r['war'],
                   'peserta' => $r['peserta'],
                   'program_lain'=> $r['program'],
                   'total' => $r['byr'],
                   'komisi_program_lain' => $r['komisi'],
                   'jenis_lunas' => $r['jns']
            );

            $this->db->insert('incentive', $data);
        }
		
		
		
		$token = md5($id_event);
		
		flashdata('success','Penambahan data sukses');
        redirect(base_url()."finance/incentive/detail?id=$id_event&token=$token&event=$eventp&loc=$locp&tgl=$tglp",'refresh');

	}
	
	public function delete_list_incentive(){
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    
	    $ide = $_GET['ide'];
	    $event = $_GET['event'];
	    $loc = $_GET['loc'];
	    $tgl = $_GET['tgl'];
	    
	    if(md5($id) == $token){
	        $result = $this -> model_incentive -> delete_list_incentive($id);
	        if($result){
				flashdata('success','Delete data sukses');
	            redirect(base_url().'finance/incentive/detail/?id='.$ide.'&token='.md5($ide).'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
	        }else{
				flashdata('error','Delete data gagal');
	            redirect(base_url().'finance/incentive/detail/?id='.$ide.'&token='.md5($ide).'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
	        }
	    }
	}
	
	public function approved_incentive()
	{
	
		$id = $_GET['id'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_incentive -> approved_incentive($id);
			$data['hasil'] = $this -> model_task -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			flashdata('success','Semua berhasil di approve pada event ini');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal melakukan approve');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}
	
	}
	
	public function unapproved_incentive()
	{	
		$id = $_GET['id'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_incentive -> unapproved_incentive($id);
			$data['hasil'] = $this -> model_task -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			flashdata('success','Semua berhasil di unapprove pada event ini');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal melakukan unapprove');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}	
	}
	
	public function approved_paid_all()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_incentive -> approved_paid_all($id);
			$data['hasil'] = $this -> model_task -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			
			flashdata('success','Semua berhasil di ubah menjadi paid');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal merubah status menjadi paid');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}
	}
	
	public function unapproved_paid_all()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_incentive -> unapproved_paid_all($id);
			$data['hasil'] = $this -> model_task -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			
			flashdata('success','Semua berhasil di ubah menjadi unpaid');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal merubah status menjadi unpaid');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}
	}
	
	public function approved_incentive_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_incentive -> approved_incentive_satuan($ii);
			$data['hasil'] = $this -> model_task -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			flashdata('success','Berhasil merubah status menjadi approve');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal merubah status menjadi approve');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}
	}
	
	public function can_approved_incentive_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_incentive -> can_approved_incentive_satuan($ii);
				$data['hasil'] = $this -> model_task -> get_satuan_task($id);
				foreach($data['hasil'] as $r){
    			    $event = $r->event;
    			    $loc = $r->location;
    			    $tgl = $r->date;
    			}
    			flashdata('success','Berhasil merubah status menjadi unapprove');
				redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal merubah status menjadi unapprove');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}
	}
	
	public function approved_paid_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_incentive -> approved_paid_satuan($ii);
			$data['hasil'] = $this -> model_task -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			flashdata('success','Berhasil merubah status menjadi paid');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal merubah status menjadi paid');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}
	}
	
	public function can_approved_paid_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_incentive -> can_approved_paid_satuan($ii);
				$data['hasil'] = $this -> model_task -> get_satuan_task($id);
				foreach($data['hasil'] as $r){
    			    $event = $r->event;
    			    $loc = $r->location;
    			    $tgl = $r->date;
    			}
    			flashdata('success','Berhasil merubah status menjadi unpaid');
				redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			flashdata('error','Gagal merubah status menjadi unpaid');
			redirect(base_url().'finance/incentive/detail/?id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}
	}
	
	public function send_notif_incentive(){
	
		$id_task = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($id_task)){
			$data['emailku'] = $this -> model_incentive -> send_notif_incentive($id_task);
			
			$this->load->view('email_incentive',$data);
		}

	}
	
	public function approved_moneychecker()
	{
		$idcumi = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		
		if($token == md5($idcumi)){
		
			$results = $this -> model_incentive -> approve_moneychecker($idcumi);
			
			if($results){
				flashdata('success','Proses approved telah disimpan dan terhubung kepada user');
				redirect(base_url().'finance/incentive/moneychecker','refresh');
			}else{
				flashdata('error','Proses Approve gagal');
				redirect(base_url().'finance/incentive/moneychecker','refresh');
			}
		}else{
				flashdata('error','Terjadi kesalahan dalam memproses');
				redirect(base_url().'finance/incentive/moneychecker','refresh');
		
		}
		
	}
	
	public function not_approved_moneychecker()
	{
		$idcumi = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		
		if($token == md5($idcumi)){
		
			$results = $this -> model_incentive -> not_approve_moneychecker($idcumi);
			
			if($results){
				flashdata('success','Proses approved telah diriject dan info riject telah terhubung kepada user');
				redirect(base_url().'finance/incentive/moneychecker','refresh');
			}else{
				flashdata('error','Proses Riject gagal');
				redirect(base_url().'finance/incentive/moneychecker','refresh');
			}
		}else{
				flashdata('error','Terjadi kesalahan dalam memproses');
				redirect(base_url().'finance/incentive/moneychecker','refresh');
		
		}
		
	}

	


}