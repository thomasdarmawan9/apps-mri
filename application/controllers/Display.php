<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Display extends CI_Controller {

	public function __construct()
        {
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            // memuat model user
	 	    $this->load->model('model_crud');
        }
        

	public function index()
	{
		if(empty($_GET['auth'])){
			$this->session->set_flashdata('load', 'anda berhasil login');
			
			if($this->session->userdata('username')=='admin'){
				redirect(base_url().'?auth=alllaphrcuti','refresh');
			}else{
				redirect(base_url().'?auth=dashboard','refresh');
			}
		}else{
			$this->load->view('index');
		}
	}
	
	
	function add_incentive_by_finance()
	{
	    $baris = $this->input->post('baris');
	    $id_event = $this->input->post('id_event');
	    
	    for ($i = 0; $i < $baris; $i++){
	        $war[] = $this->input->post('war'.$i);
    	    $peserta[]= $this->input->post('peserta'.$i);
    	    $byr[] = $this->input->post('byr'.$i);
    	    
    	    $jns = $this->input->post('jenis'.$i);
    	    $jns_closing[] = $jns;
    	    
    	    $id_program = $this->input->post('program'.$i);
    	    
    	    $detail_program = $this -> model_crud -> get_info_event($id_program);
    	    
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
	}
	
	function export_lembur()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "lembur.csv";
        $query = "SELECT username, sum(nilai) as lembur FROM `lembur` left join user on user.id = lembur.id_user group by user.id";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
        
    }
    
    function export_cuti_izin()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "cuti_izin.csv";
        $query = "SELECT username, (sum(plus) - sum(nilai)) as cuti_izin FROM `cuti_izin` left join user on user.id = cuti_izin.id_user group by `id_user`";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
        
    }
    
     function export_cuti_sakit()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "cuti_sakit.csv";
        $query = "SELECT username, (sum(plus) - IFNULL(sum(nilai), 0)) as cuti_sakit FROM `cuti_sakit` left join user on user.id = cuti_sakit.id_user group by `id_user`";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
        
    }
    
    public function add_newevent_incen(){
        $name = $this->input->post('name');
        $dp = $this->input->post('dp');
        $lunas = $this->input->post('lunas');
        $result = $this -> model_crud -> add_newevent_incen($name,$dp,$lunas);
        
        if($result){
            $this->session->set_flashdata('msgadd','success');
            redirect(base_url().'?auth=listincensp','refresh');
        }else{
            $this->session->set_flashdata('msgadd','error');
            redirect(base_url().'?auth=listincensp','refresh');
        }
    }
    
    public function delete_event_incent(){
        $id = $_GET['id'];
        $token = $_GET['token'];
        
        if($token == md5($id)){
            $result = $this -> model_crud -> delete_event_incent($id);
            
            if($result){
                $this->session->set_flashdata('msgdel','success');
                redirect(base_url().'?auth=listincensp','refresh');
            }else{
                $this->session->set_flashdata('msgdel','error');
                redirect(base_url().'?auth=listincensp','refresh');
            }
            
        }else{
            $this->session->set_flashdata('msgdel','error');
            redirect(base_url().'?auth=listincensp','refresh');
        }
    }
    
	public function send_notif_incentive(){
	
		$id_task = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($id_task)){
			$data['emailku'] = $this -> model_crud -> send_notif_incentive($id_task);
			
			$this->load->view('email_incentive',$data);
		}
		
		
	
	}
	
	
	
	public function user_add_task_paytask_adding()
	{
		$idevent = $this->input->post('idevent');
		$username = $this->input->post('username');
		
		$eventname = $this->input->post('eventname');
		$date = $this->input->post('tgl');
		
		$results = $this -> model_crud -> user_add_task_paytask_adding($idevent,$username);
		
		if($results){
			$this->session->set_flashdata('msgpaytask','success');
			redirect('/?auth=report_pd&idevent='.$idevent.'&eventname='.$eventname.'&tgl='.$date.'&token='.md5($idevent).'','refresh');
		}else{
			$this->session->set_flashdata('msgpaytask','error');
			redirect('/?auth=report_pd&idevent='.$idevent.'&eventname='.$eventname.'&tgl='.$date.'&token='.md5($idevent).'','refresh');
		
		}
	
	}
	
	public function delete_addlembur(){
		$id = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_crud -> delete_addlembur($id);
			
			if($results){
				$this->session->set_flashdata('msgdel','success');
				redirect('?auth=addlembur','refresh');
			}else{
				$this->session->set_flashdata('msgdel','error');
				redirect('?auth=addlembur','refresh');			
			}
			
		}else{
			$this->session->set_flashdata('msgdel','error');
			redirect('?auth=addlembur','refresh');
		}
	}
	
	public function update_addlembur(){
	    $id = $this->input->post('id');
		$token = $this->input->post('token');
		$desc = $this->input->post('deskripsi');
		$nilai = $this->input->post('nilai');
		$plus = $this->input->post('plus');
		
		$msk = $this->input->post('msk');
		$plg = $this->input->post('plg');
		
		if($plus > 44){
		    $nilai = $nilai + 1;
		}elseif($plus > 30){
		    $plus = 0.5;
		    $nilai = $nilai + $plus;
		}elseif($plus > 14){
		    $plus = 0.5;
		    $nilai = $nilai + $plus;
		}elseif($plus > 0){
		    $plus = 0;
		    $nilai = $nilai;
		}elseif($plus > -14){
		    $plus = 0;
		    $nilai = $nilai;
		}elseif($plus > -30){
		    $plus = 0.5;
		    $nilai = $nilai - $plus;
		}elseif($plus > -59){
		    $nilai = $nilai - 1;
		}
		
		$desc = '<jam>'.$msk.' - '.$plg.'</jam> '.$desc;
		
		if($token == md5($id)){
			$results = $this -> model_crud -> update_addlembur($id, $desc, $nilai);
			
			if($results){
				$this->session->set_flashdata('msgupdate','success');
				redirect('?auth=addlembur','refresh');
			}else{
				$this->session->set_flashdata('msgupdate','error');
				redirect('?auth=addlembur','refresh');			
			}
			
		}else{
			$this->session->set_flashdata('msgupdate','error');
			redirect('?auth=addlembur','refresh');
		}
	}
	

	public function addlembur(){
	    
	    
		$tgl = $this->input->post('tgl');
		
		$now = date('Y-m-d');
		$last = '2016-01-01';
		//Mengecek agar proses input tidak melebihi waktu saat ini dan diatas tahun 2016
		if(($tgl <= $now) and ($last <= $tgl)){
		    
		    
    		$date_limit = date('Y-m-d', strtotime("-7 days"));
    	
    		$CheckInX = explode("-", $date_limit);
            $CheckOutX =  explode("-", $tgl);
            $date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
            $date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
            $interval =($date2 - $date1)/(3600*24);
    		
    	    if($interval > -1){
    	        $nilai = $this->input->post('nilai');
    	        $plus = $this->input->post('plus');
    	        
    	        if($nilai == 0 && $plus == 0){
    	            $this->session->set_flashdata('msgadd','error');
            		redirect('/?auth=addlembur','refresh');
    	        }else{
            		$desc = $this->input->post('deskripsi');
            		$msk = $this->input->post('msk');
            		$plg = $this->input->post('plg');
            		
            		
            		if($plus >= 30){
            		    $plus = 0.5;
            		    $nilai = $nilai + $plus;
            		}elseif($plus < 0){
            		    $plus = 0.5;
            		    $nilai = $nilai - $plus;
            		}else{
            		    $nilai = $nilai;
            		}
            		
            		$desc = '<jam>'.$msk.' - '.$plg.'</jam> '.$desc;
            		
            		$results = $this -> model_crud -> addlembur($desc,$nilai,$tgl);
            		
            		if($results){
            			$this->session->set_flashdata('msgadd','success');
            			redirect('/?auth=addlembur','refresh');
            		}else{
            			$this->session->set_flashdata('msgadd','error');
            			redirect('/?auth=addlembur','refresh');
            		}
    	        }
            		
    	    }else{
    	        $this->session->set_flashdata('msgtime','error');
        		redirect('/?auth=addlembur','refresh');
    	    }
    	    
		}else{
		    $this->session->set_flashdata('msgtime','error');
        	redirect('/?auth=addlembur','refresh');
		}
		
		
	}
	
	public function toapprove_lembur_spv(){
		$id = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_crud -> toapprove_lembur_spv($id);
			
			if($results){
				$this->session->set_flashdata('msgacc','success');
				redirect('/?auth=acclembur','refresh');
			}else{
				$this->session->set_flashdata('msgacc','error');
				redirect('/?auth=acclembur','refresh');
			}
		}else{
			$this->session->set_flashdata('msgacc','success');
			redirect('/?auth=acclembur','refresh');

		}
	}
	
	public function toapprove_lembur_hr(){
		$id = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_crud -> toapprove_lembur_hr($id);
			
			if($results){
				$this->session->set_flashdata('msgacc','success');
				redirect('/?auth=acclembur','refresh');
			}else{
				$this->session->set_flashdata('msgacc','error');
				redirect('/?auth=acclembur','refresh');
			}
		}else{
			$this->session->set_flashdata('msgacc','success');
			redirect('/?auth=acclembur','refresh');

		}
	}
	
	public function toreject_lembur_spv(){
		$id = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_crud -> toreject_lembur_spv($id);
			
			if($results){
				$this->session->set_flashdata('msgreject','success');
				redirect('/?auth=acclembur','refresh');
			}else{
				$this->session->set_flashdata('msgreject','error');
				redirect('/?auth=acclembur','refresh');
			}
		}else{
			$this->session->set_flashdata('msgreject','success');
			redirect('/?auth=acclembur','refresh');

		}
	}
	
	public function toreject_lembur_hr(){
		$id = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_crud -> toreject_lembur_hr($id);
			
			if($results){
				$this->session->set_flashdata('msgreject','success');
				redirect('/?auth=acclembur','refresh');
			}else{
				$this->session->set_flashdata('msgreject','error');
				redirect('/?auth=acclembur','refresh');
			}
		}else{
			$this->session->set_flashdata('msgreject','success');
			redirect('/?auth=acclembur','refresh');

		}
	}
	
	public function birdtest_lock(){
		$status = $this->input->post('status');
		$results = $this -> model_crud -> birdtest_lock($status);
		if($results){
			$this->session->set_flashdata('msglock','success');
			redirect('/?auth=birdtest','refresh');
		}else{
			$this->session->set_flashdata('msglock','error');
			redirect('/?auth=birdtest','refresh');
		
		}
	}
	
	public function birdtest_war(){
	
		$username = $this->session->userdata('username');
		date_default_timezone_set('Asia/Jakarta');
		$waktu = date("Y-m-d H:i:s");
		$p = ($this->input->post(base64_encode('p'))/37);
		$d = ($this->input->post(base64_encode('d'))/37);
		$e = ($this->input->post(base64_encode('e'))/37);
		$o = ($this->input->post(base64_encode('o'))/37);
		
		
		
		
		    $email = $this->session->userdata('email');
			
			//Email Notification he/her get cuti
			$pesan = '<html><body>Report BirdTest :<br>Peacock : <peacock> <br>Dove : <dove> <br>Eagle : <eagle><br>Owl : <owl>.</body></html>';
			$pesan = str_replace('<peacock>',$p,$pesan);
			$pesan = str_replace('<dove>',$d,$pesan);
			$pesan = str_replace('<eagle>',$e,$pesan);
			$pesan = str_replace('<owl>',$o,$pesan);
			
			$to = $email;
			$subject = 'Result your BirdTest';
			$body_html = $pesan;
			$from = 'support@mri.co.id';
			$fromName = 'Merry Riana Indonesia';
			$res = "";
	
			$data = "username=".urlencode("support@mri.co.id");
			$data .= "&api_key=".urlencode("81A9A016FB31BA386269F0F154675E3343868B0BE78FF9B1F768D7217F9BBD70E135DF791CABE999824B4370DFE35039");
			$data .= "&from=".urlencode($from);
			$data .= "&from_name=".urlencode($fromName);
			$data .= "&to=".urlencode($to);
			$data .= "&subject=".urlencode($subject);
			if($body_html)
			  $data .= "&body_html=".urlencode($body_html);
	
			$header = "POST /mailer/send HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
			$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
	
			if(!$fp)
			  return "ERROR. Could not open connection";
			else {
			  fputs ($fp, $header.$data);
			  while (!feof($fp)) {
				$res .= fread ($fp, 1024);
			  }
			  fclose($fp);
			}
			
		
		
		
		$results = $this -> model_crud -> birdtest_war($username,$waktu,$p,$d,$e,$o);
		if($results){
			$this->session->set_flashdata('msg','success');
			redirect('/?auth=bird_test','refresh');
		}else{
			$this->session->set_flashdata('msg','error');
			redirect('/?auth=bird_test','refresh');
		
		}
	}
	
	public function email_birdtest_result(){
	
		//Email Notification he/her get cuti
		$pesan = $this->load->view('email_birdtest_result');
		
		$to = 'support@mri.co.id';
		$subject = 'Request Task Allocation Anda ditolak';
		$body_html = $pesan;
		$from = 'support@mri.co.id';
		$fromName = 'Merry Riana Indonesia';
		$res = "";

		$data = "username=".urlencode("support@mri.co.id");
		$data .= "&api_key=".urlencode("81A9A016FB31BA386269F0F154675E3343868B0BE78FF9B1F768D7217F9BBD70E135DF791CABE999824B4370DFE35039");
		$data .= "&from=".urlencode($from);
		$data .= "&from_name=".urlencode($fromName);
		$data .= "&to=".urlencode($to);
		$data .= "&subject=".urlencode($subject);
		if($body_html)
		  $data .= "&body_html=".urlencode($body_html);

		$header = "POST /mailer/send HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
		$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);

		if(!$fp)
		  return "ERROR. Could not open connection";
		else {
		  fputs ($fp, $header.$data);
		  while (!feof($fp)) {
			$res .= fread ($fp, 1024);
		  }
		  fclose($fp);
		}
	
	}
	
	
	
	
	public function tambah_lembur(){
		$jamlembur = $this->input->post('jamlembur');
		$plus = $this->input->post('plus');
		$name['getname'] = $this->input->post('getname');
		$tgl = $this->input->post('tgl');
		$deskripsi = $this->input->post('deskripsi');
		
		$now = date('Y-m-d');
		$last = '2016-01-01';
		
		//Mengecek agar proses input tidak melebihi waktu saat ini dan diatas tahun 2016
		if(($tgl <= $now) and ($last <= $tgl)){
		
    		if($plus==null){
    			$nilai = $jamlembur;
    		}else{
    			$nilai = $jamlembur + 0.5;
    		}
    		
    		foreach ($name['getname'] as $nm){
    			$getnm = $nm;
    			$results = $this -> model_crud -> pluslembur($jamlembur,$getnm,$tgl,$deskripsi,$nilai);
    		}
    		
    		if($results){
    			$this->session->set_flashdata('msg','success');
    			redirect('https://apps.mri.co.id/?auth=lembur','refresh');
    		}
		
		}else{
		    $this->session->set_flashdata('msg','error');
    		redirect('https://apps.mri.co.id/?auth=lembur','refresh');
		}
		
	}
	
	public function kurang_lembur(){
		$jamlembur = $this->input->post('jamlembur');
		$minus = $this->input->post('minus');
		$name['getname'] = $this->input->post('getminusname');
		$tgl = $this->input->post('tgl');
		$deskripsi = $this->input->post('deskripsi');
		
		$now = date('Y-m-d');
		$last = '2016-01-01';
		
		//Mengecek agar proses input tidak melebihi waktu saat ini dan diatas tahun 2016
		if(($tgl <= $now) and ($last <= $tgl)){
		    
    		if($minus==null){
    			$nilai = 0 - $jamlembur;
    		}else{
    			$nilai = 0 - ($jamlembur + 0.5);
    		}
    		
    		foreach ($name['getname'] as $nm){
    			$getnm = $nm;
    			$results = $this -> model_crud -> pluslembur($jamlembur,$getnm,$tgl,$deskripsi,$nilai);
    		}
    		
    		if($results){
    			$this->session->set_flashdata('msgminus','success');
    			redirect('https://apps.mri.co.id/?auth=lembur','refresh');
    		}
    		
		}else{
		        $this->session->set_flashdata('msgminus','error');
		        redirect('https://apps.mri.co.id/?auth=lembur','refresh');
		}
		
	}
	
	public function tambah_user(){
		
		$nama = $this->input->post('nama');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$jenis = $this->input->post('jenis');
		
		$ci = $this->input->post('cutiizin');
		$cs = $this->input->post('cutisakit');
		$lembur = $this->input->post('lembur');
		$plus = $this->input->post('plus');
		
		if($plus==null){
			$lembur = $lembur;
		}else{
			$lembur = $lembur + 0.5;
		}
		
		$pass = substr(md5($username),0,6);
		
		$results = $this -> model_crud -> cek_user_null($username,$email);
		if($results){
		
		
			$pesan = '<html><body>Selamat akun Anda di Mri.co.id telah dibuat, sebagai berikut :<br>Username : <username> <br>Pass : <pass> </body></html>';
			
			$pesan = str_replace("<username>",$username,$pesan);
			$pesan = str_replace("<pass>",$pass,$pesan);
			
			$to = $email;
			$subject = 'Selamat Akun Apps.mri.co.id anda sudah berhasil dibuat. :)';
			$body_html = $pesan;
			$from = 'support@mri.co.id';
			$fromName = 'Merry Riana Indonesia';
			$res = "";
	
			$data = "username=".urlencode("support@mri.co.id");
			$data .= "&api_key=".urlencode("81A9A016FB31BA386269F0F154675E3343868B0BE78FF9B1F768D7217F9BBD70E135DF791CABE999824B4370DFE35039");
			$data .= "&from=".urlencode($from);
			$data .= "&from_name=".urlencode($fromName);
			$data .= "&to=".urlencode($to);
			$data .= "&subject=".urlencode($subject);
			if($body_html)
			  $data .= "&body_html=".urlencode($body_html);
	
			$header = "POST /mailer/send HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
			$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
	
			if(!$fp)
			  return "ERROR. Could not open connection";
			else {
			  fputs ($fp, $header.$data);
			  while (!feof($fp)) {
				$res .= fread ($fp, 1024);
			  }
			  fclose($fp);
			}
			
			$results = $this -> model_crud -> tambah_user($nama,$username,$email,$pass,$jenis,$ci,$cs,$lembur);
			if($results){
				$this->session->set_flashdata('tmbhuser','success');
				redirect('https://apps.mri.co.id/?auth=user','refresh');
			}
		}else{
			$this->session->set_flashdata('tmbhuser','failed');
			redirect('https://apps.mri.co.id/?auth=user','refresh');
		}
		
	}
	
	
	public function edit_user()
	{
			
			$id = $this->input->post('id');
			$nama = $this->input->post('nama');
			$jenis_cuti = $this->input->post('cuti');
			$depart = $this->input->post('depart');
			$status = $this->input->post('status');
			$results = $this -> model_crud -> edit_user($id,$nama,$jenis_cuti,$depart,$status);
			
			if($results)
			{
				$this->session->set_flashdata('edituser','success');
				redirect('https://apps.mri.co.id/?auth=user','refresh');
			}else{
				$this->session->set_flashdata('edituser','error');
				redirect('https://apps.mri.co.id/?auth=user','refresh');
			}
	}
	
	
	public function batalkan_pertukaran()
	{
		$idevent = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($idevent)){
			$results = $this -> model_crud -> batalkan_pertukaran($idevent);
			
			if($results){
				$this->session->set_flashdata('batalganti','success');
				redirect('/?auth=mytask','refresh');
			}else{
			
				$this->session->set_flashdata('batalganti','error');
				redirect('/?auth=mytask','refresh');
			
			}
		}else{
			$this->session->set_flashdata('batalganti','error');
			redirect('/?auth=mytask','refresh');
		}
	
	}
	
	public function cek_uang_masuk()
	{
		$ji = $this->input->post('ji');
		$bp = $this->input->post('bp');
		$np = $this->input->post('np');

		$tgl = $this->input->post('tgl');
		$jp = $this->input->post('jp');
		
		$norek = $this->input->post('norek');
		
		
		
		$results = $this -> model_crud -> cek_uang_masuk($ji,$bp,$np,$tgl,$jp,$norek);
		
		if($results){
			$this->session->set_flashdata('cekinput','success');
			redirect('/?auth=check_uang_masuk','refresh');
		}else{
			$this->session->set_flashdata('cekinput','error');
			redirect('/?auth=check_uang_masuk','refresh');
		}
		
		
	}
	
	public function approved_moneychecker()
	{
		$idcumi = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		
		if($token == md5($idcumi)){
		
			$results = $this -> model_crud -> approve_moneychecker($idcumi);
			
			if($results){
				$this->session->set_flashdata('msg','success');
				redirect('?auth=moneychecker','refresh');
			}else{
				$this->session->set_flashdata('msg','error');
				redirect('?auth=moneychecker','refresh');
			}
		}else{
				$this->session->set_flashdata('msg','error');
				redirect('?auth=moneychecker','refresh');
		
		}
		
	}
	
	public function not_approved_moneychecker()
	{
		$idcumi = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		
		if($token == md5($idcumi)){
		
			$results = $this -> model_crud -> not_approve_moneychecker($idcumi);
			
			if($results){
				$this->session->set_flashdata('msgnot','success');
				redirect('?auth=moneychecker','refresh');
			}else{
				$this->session->set_flashdata('msgnot','error');
				redirect('?auth=moneychecker','refresh');
			}
		}else{
				$this->session->set_flashdata('msgnot','error');
				redirect('?auth=moneychecker','refresh');
		
		}
		
	}
	
	
	
	public function tambah_task()
	{
		$nama = $this->input->post('nama');
		$location = $this->input->post('lokasi');
		$date = $this->input->post('tgl');
		
		$jenis_report = 'peserta';
		$komisi_lunas = $this->input->post('komisilunas');
		$komisi_dp = $this->input->post('komisidp');
		
		$results = $this -> model_crud -> tambah_task($nama,$location,$date,$jenis_report,$komisi_lunas,$komisi_dp);
		
		if($results){
			$this->session->set_flashdata('msg','success');
			redirect('?auth=task','refresh');
		}else{
			$this->session->set_flashdata('msg','error');
			redirect('?auth=task','refresh');
		}
	}
	
	public function edit_task()
	{
		$nama = $this->input->post('nama');
		$location = $this->input->post('lokasi');
		$tgl = $this->input->post('tgl');
		
		$jenis_report = 'peserta';
		$komisi_dp = $this->input->post('komisi_dp');
		$komisi_lunas = $this->input->post('komisi_lunas');
		
		$id = $this->input->post('id');
		$token = $this->input->post('token');
		
		if(md5($id) == $token) {
			$results = $this -> model_crud -> edit_task($id,$nama,$location,$tgl,$jenis_report,$komisi_dp,$komisi_lunas);
			
			if($results){
				$this->session->set_flashdata('msgupdate','success');
				redirect('?auth=task','refresh');
			}else{
				$this->session->set_flashdata('msgupdate','error');
				redirect('?auth=task','refresh');
			}
		}else{
			$this->session->set_flashdata('msgupdate','error');
			redirect('?auth=task','refresh');
		}
	}
	
	public function delete_task()
	{
		$id = $this->input->post('id');
		$token = $this->input->post('token');
		
		if(md5($id) == $token) {
			$results = $this -> model_crud -> delete_task($id);
			
			if($results){
				$this->session->set_flashdata('msgdelevent','success');
				redirect('?auth=task','refresh');
			}else{
				$this->session->set_flashdata('msgdelevent','error');
				redirect('?auth=task','refresh');
			}
		}else{
			$this->session->set_flashdata('msgdelevent','error');
			redirect('?auth=task','refresh');
		}
	}
	
	
	
	public function remove_user()
	{
			
			$status = $this->input->post('status');
			$id = $this->input->post('idrem');
			if($status=='ok'){
				$results = $this -> model_crud -> hapus_user($id);
			}
			
			if($results){
				$this->session->set_flashdata('deluser','success');
				redirect('https://apps.mri.co.id/?auth=user','refresh');
			}else{
				$this->session->set_flashdata('deluser','error');
				redirect('https://apps.mri.co.id/?auth=user','refresh');
			}
	}
	
	public function kurang_cuti(){
		
		$cuti = $this->input->post('cuti');
		$name['getname'] = $this->input->post('getname');
		$tgl = $this->input->post('tgl');
		$deskripsi = $this->input->post('deskripsi');

		if($cuti == 'izin'){
			$tcuti = 'cuti_izin';
		}else{
			$tcuti = 'cuti_sakit';
		}
		
		foreach ($name['getname'] as $nm){
			$getnm = $nm;
			$results = $this -> model_crud -> minuscuti($getnm,$tgl,$deskripsi,$tcuti);
		}
		
		if($results){
			$this->session->set_flashdata('msgcuti','success');
			redirect('https://apps.mri.co.id/?auth=lembur','refresh');
		}
		
	}
	
	public function tambah_cuti(){
		
		$plus = $this->input->post('jmhhr');
		$name['getname'] = $this->input->post('getname');
		$tgl = $this->input->post('tgl');
		$deskripsi = $this->input->post('deskripsi');
		
		foreach ($name['getname'] as $nm){
			$getnm = $nm;
			$results = $this -> model_crud -> tambah_cuti_manual($getnm,$plus,$tgl,$deskripsi);
		}
		
		if($results){
			$this->session->set_flashdata('msgcutitambah','success');
			redirect('https://apps.mri.co.id/?auth=lembur','refresh');
		}
		
	}
	
	public function delete_detail_lembur(){
		$id = $_GET['id'];
		$token = $_GET['token'];
		
		$user = $_GET['user'];
		$tgl = $_GET['tgl'];
		
		if(md5($id) == $token){
			$results = $this -> model_crud -> delete_detail_lembur($id);
			if($results){
				$this->session->set_flashdata('msg','success');
				redirect('?auth=detaillembur&user='.$user.'&tgl='.$tgl.'','refresh');
			}else{
				$this->session->set_flashdata('msg','errors');
				redirect('?auth=detaillembur&user='.$user.'&tgl='.$tgl.'','refresh');
			}
		}else{
				$this->session->set_flashdata('msg','errors');
				redirect('?auth=detaillembur&user='.$user.'&tgl='.$tgl.'','refresh');
		
		}
	}
	
	public function do_upload(){
	
	
		if(!empty($_FILES["userpic"]['name'])) { 

			$config['upload_path'] = './assets/profile';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
	                $config['encrypt_name']	= 'TRUE';
	                $new_name = time().$_FILES["userpic"]['name'];
			$config['file_name'] = $new_name;
			$config['max_size']	= 500;
			$config['max_width']  = 2000;
			$config['max_height']  = 2000;
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload('userpic'))
			{
				$error = array('error' => $this->upload->display_errors());
				redirect('https://apps.mri.co.id/?event=profil&error=true', $error );
			}
			else
			{

	 			$result = $this -> model_crud -> change_pic_user($new_name);
	 			
	 			$configfit['image_library'] = 'gd2';
				$configfit['source_image'] = './assets/profile/'.$new_name;
				$configfit['new_image'] = './assets/profile/pp/'.$new_name;
				$configfit['encrypt_name']	= 'TRUE';
				$configfit['maintain_ratio'] = FALSE;
				$configfit['width']         = 300;
				$configfit['height']       = 300;
				
				$this->load->library('image_lib', $configfit);
				$this->image_lib->resize();
					
			}
		
		}
		
		$name = $this->input->post('name');
		$divisi = $this->input->post('divisi');
		$position = $this->input->post('position');
		$result = $this -> model_crud -> change_data_user($name,$divisi,$position);
		
		redirect('https://apps.mri.co.id/?event=profil');
		
		
	}
	
	public function delete_list_incentive(){
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    
	    $ide = $_GET['ide'];
	    $event = $_GET['event'];
	    $loc = $_GET['loc'];
	    $tgl = $_GET['tgl'];
	    
	    if(md5($id) == $token){
	        $result = $this -> model_crud -> delete_list_incentive($id);
	        if($result){
	            redirect('https://apps.mri.co.id/?auth=list_detail_incentive&id='.$ide.'&token='.md5($ide).'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
	        }else{
	            redirect('https://apps.mri.co.id/?auth=list_detail_incentive&id='.$ide.'&token='.md5($ide).'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
	        }
	    }
	}
	
	public function delete_cuti_izin(){
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    
	    if(md5($id) == $token){
	        $result = $this -> model_crud -> delete_cuti_izin($id);
	        if($result){
	            redirect('https://apps.mri.co.id/?auth=laphrcuti');
	        }else{
	            redirect('https://apps.mri.co.id/?auth=laphrcuti');
	        }
	    }
	}
	
	public function delete_cuti_sakit(){
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    
	    if(md5($id) == $token){
	        $result = $this -> model_crud -> delete_cuti_sakit($id);
	        if($result){
	            $this->session->set_flashdata('delconfirm','success');
	            redirect('https://apps.mri.co.id/?auth=laphrcutiskt');
	        }else{
	            $this->session->set_flashdata('delconfirm','error');
	            redirect('https://apps.mri.co.id/?auth=laphrcutiskt');
	        }
	    }
	}
	
	public function next_change_pass(){
	
		$cp = $this->input->post('pass');
		$result = $this -> model_crud -> cek_next_pass($cp);
		
		if($result){
			$this->session->set_userdata('changepass',1);
			redirect('https://apps.mri.co.id/?event=profil&changepass=open');
		}else{
			redirect('https://apps.mri.co.id/?event=profil&changepass=close');
		}
	
	}
	
	public function tambah_war_task(){

		$id_task = $this->input->post('id');
		$token = $this->input->post('token');
		$name['getname'] = $this->input->post('getname');
		
		if(md5($id_task) == $token){ 
			foreach ($name['getname'] as $nm){
				$results = $this -> model_crud -> tambah_war_task($id_task,$nm);
			}
			
			if($results){
				$this->session->set_flashdata('msgaddwar','success');
				redirect('?auth=task');
			}else{
				$this->session->set_flashdata('msgaddwar','errors');
				redirect('?auth=task');
			}
			
		}else{
			$this->session->set_flashdata('msg','errors');
			redirect('?auth=task');
		}

	}
	
	public function pay_war_task(){

		$id_task = $this->input->post('id');
		$token = $this->input->post('token');
		$name['getname'] = $this->input->post('getname');
		
		if(md5($id_task) == $token){ 
			foreach ($name['getname'] as $nm){
				$results = $this -> model_crud -> pay_war_task($id_task,$nm);
			}
			
			if($results){
				$this->session->set_flashdata('msgaddwar','success');
				redirect('?auth=task');
			}else{
				$this->session->set_flashdata('msgaddwar','errors');
				redirect('?auth=task');
			}
			
		}else{
			$this->session->set_flashdata('msg','errors');
			redirect('?auth=task');
		}

	}
	
	public function delete_wartask()
	{
		$id_task =  $this->uri->segment(3);
  		$token_task =  $this->uri->segment(4);
  		
  		$id_user =  $this->uri->segment(5);
  		$token_user =  $this->uri->segment(6);
  
  		if((md5($id_task) == $token_task) && (md5($id_user) == $token_user))
		{
			$results = $this -> model_crud -> delete_wartask($id_task,$id_user);
			if($results){
				$this->session->set_flashdata('msgdelwar','success');
				redirect('?auth=task');
			}else{
				$this->session->set_flashdata('msgdelwar','errors');
				redirect('?auth=task');
			}
			
		}else{
			$this->session->set_flashdata('msg','errors');
			redirect('?auth=task');
		}
		
	}
	
	public function event_digantikan()
	{
		  $idevent =  $this->input->post('idevent');
		  $getname =   $this->input->post('getname');
		  
		  //Cek user tidak ada event juga disaat yang sama
		  $results = $this -> model_crud -> event_digantikan_cek($idevent,$getname);
		  
		  if($results){
		  
		  	//Cek user tidak sedang menggantikan / tidak ada request
		  	$results1 = $this -> model_crud -> event_digantikan_request($idevent,$getname);
		  	
		  		if($results1){
		  		
			  		$results2 = $this -> model_crud -> event_digantikan($idevent,$getname);
			  		
			  		$hs['user'] = $this -> model_crud -> getuser_person($getname);			  		
			  		
			  		foreach($hs['user'] as $r){
			  			$hp = $r->no_hp;
			  		}
			  		
			  		$nama = ucfirst($this->session->userdata('username'));
			  		$id_user = $this->session->userdata('id');
			  		
			  		$hsl['task'] = $this -> model_crud -> get_event($idevent,$id_user);
			  		
			  		foreach($hsl['task'] as $tsk){
			  			$event = $tsk->event;
			  			$lokasi = $tsk->location;
			  			$tgl = date("d-M-Y", strtotime($tsk->date));
			  			
			  			if($tsk->tugas == null){
			  				$tugas = "Tunggu Info Pd";
			  			}else{
			  				$tugas = $tsk->tugas;
			  			}
			  		}
			  		
					//Send Confirmation
				  	$token ="9289c10816467ec0a42430fd6add1e0a59fe3975b265b";
			      	$uid = "6281280539070";
			      	$t = time();$unik =$t.rand(10,100);
			      	$to = $hp;
			      	$pesan = urlencode("*Ada Permintaan Pergantian EVENT* \nEvent : $event, \nTanggal : $tgl,\nTugas : $tugas, \nOleh : $nama ");
			      	
				  
				  	$ch = curl_init(); 
					curl_setopt($ch, CURLOPT_URL, "https://www.waboxapp.com/api/send/chat"); 
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
					curl_setopt($ch, CURLOPT_POST, 1); 
					curl_setopt($ch, CURLOPT_POSTFIELDS, 'token='.$token.'&uid='.$uid.'&to='.$to.'&custom_uid='.$t.'&text='.$pesan.''); 
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
					curl_setopt($ch, CURLOPT_MAXREDIRS, 5); 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
					curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 25); 
					
					$response = curl_exec($ch); 
					//$info = curl_getinfo($ch); 
					//echo $response;
					curl_close ($ch);
 					//End Confirmation
  
				  	$this->session->set_flashdata('gantiinfo','success');
					redirect('?auth=mytask');  
		  		
		  		}else{
		  
			  		$this->session->set_flashdata('gantiinfox','errors');
					redirect('?auth=mytask');
				
				}
		  	
		  }else{
		  
		  	$this->session->set_flashdata('gantiinfoy','errors');
			redirect('?auth=mytask');
		  
		  }
		  
	}
	
	public function riject_konfirmasi_pertukaran()
	{
	
		$idevent = $_GET['idt'];
		$token = $_GET['token'];
		
		if($token == md5($idevent)){
			$results = $this -> model_crud -> riject_konfirmasi_pertukaran($idevent);
			
			if($results){
			
				$data['results'] = $this -> model_crud -> get_user_mail($idevent);
				
				foreach ( $data['results'] as $r ){
					$email = $r->email;
				}
				
				
				//Email Notification he/her get cuti
				$pesan = '<html><body>Maaf request pengajuan pergantian Task Allocation Anda ditolak.</body></html>';
				
				$to = $email;
				$subject = 'Request Task Allocation Anda ditolak';
				$body_html = $pesan;
				$from = 'support@mri.co.id';
				$fromName = 'Merry Riana Indonesia';
				$res = "";
		
				$data = "username=".urlencode("support@mri.co.id");
				$data .= "&api_key=".urlencode("81A9A016FB31BA386269F0F154675E3343868B0BE78FF9B1F768D7217F9BBD70E135DF791CABE999824B4370DFE35039");
				$data .= "&from=".urlencode($from);
				$data .= "&from_name=".urlencode($fromName);
				$data .= "&to=".urlencode($to);
				$data .= "&subject=".urlencode($subject);
				if($body_html)
				  $data .= "&body_html=".urlencode($body_html);
		
				$header = "POST /mailer/send HTTP/1.0\r\n";
				$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
				$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
		
				if(!$fp)
				  return "ERROR. Could not open connection";
				else {
				  fputs ($fp, $header.$data);
				  while (!feof($fp)) {
					$res .= fread ($fp, 1024);
				  }
				  fclose($fp);
				}
				
				
				
			
				$this->session->set_flashdata('riject','success');
				redirect('/?auth=request_task','refresh');
			}else{
			
				$this->session->set_flashdata('riject','error');
				redirect('/?auth=request_task','refresh');
			
			}
		}else{
			$this->session->set_flashdata('riject','error');
			redirect('/?auth=request_task','refresh');
		}
	
	}
	
	public function approve_request_task()
	{
		$idpengganti = $_GET['idpengganti'];
		$idtask = $_GET['idtask'];
		$results = $this -> model_crud -> approve_request_task($idtask,$idpengganti);
		
		if($results){
			$this->session->set_flashdata('msgapprove','success');
			redirect('?auth=request_task');
		}else{
			$this->session->set_flashdata('msgapprove','errors');
			redirect('?auth=request_task');
		}
	
	}
	
	public function update_report_pd()
	{
		$idevent = $this->input->post('idtask');
		$jmhuser = $this->input->post('jmhuser') ;
		
		for($i=0;$jmhuser > $i;$i++){
			$iduser = $this->input->post('userid'.$i);
			$tugas = $this->input->post('tugas'.$i);
			$dp = $this->input->post('dp'.$i);
			
			//Modul dihilangkan karena info sri tdk dibutuhkan dan sudah dijadikan satu dengan dp
			$modul = '';
			$lunas = $this->input->post('lunas'.$i);
			
			if(isset($_POST['hadir'.$i])){
				$hadir = 'ya';
			}else{
				$hadir = 'tidak';
			}
			
			
			$results = $this -> model_crud -> update_report_pd($idevent, $iduser, $tugas, $dp, $modul, $lunas, $hadir);
		}
		
		if($this->input->post('jns_report') == 'peserta'){
			$daftar = $this->input->post('daftar');
			$ots = $this->input->post('ots');
			$hadir = $this->input->post('hadir');
			$tidak_hadir = $this->input->post('tidak_hadir');
		}else{
			$daftar = $this->input->post('daftark').','.$this->input->post('daftara');
			$ots = $this->input->post('otsk').','.$this->input->post('otsa');
			$hadir = $this->input->post('hadirk').','.$this->input->post('hadira');
			$tidak_hadir = $this->input->post('tidak_hadirk').','.$this->input->post('tidak_hadira');
		}
		
			$results = $this -> model_crud -> update_report_pd_task($idevent,$daftar,$ots,$hadir,$tidak_hadir);
		
		
		
		$this->session->set_flashdata('msgokok','success');
		redirect('/?auth=mytask');
	}
	
	public function getpd()
	{
		$id_task = $this->input->post('id');
		$token = $this->input->post('token');
		$username = $this->input->post('getpd');
		
		if(md5($id_task) == $token){
			$results = $this -> model_crud -> getpd($id_task,$username);
			
			if($results){
				$this->session->set_flashdata('msgpd','success');
				redirect('/?auth=task');
			}else{
				$this->session->set_flashdata('msgpd','errors');
				redirect('/?auth=task');
			}
		}else{
			$this->session->set_flashdata('msgpd','errors');
			redirect('/?auth=task');
		
		}
	}
	
	public function approved_incentive()
	{
	
		$id = $_GET['id'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_crud -> approved_incentive($id);
			$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			redirect('/?auth=list_incentive');
		}
	
	}
	
	public function unapproved_incentive()
	{
	
		$id = $_GET['id'];
		$token = $_GET['token'];
		
		if($token == md5($id)){
			$results = $this -> model_crud -> unapproved_incentive($id);
			$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			redirect('/?auth=list_incentive');
		}
	
	}
	
	public function approved_incentive_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_crud -> approved_incentive_satuan($ii);
			$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			redirect('/?auth=list_incentive&fail');
		}
	}
	
	public function can_approved_incentive_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_crud -> can_approved_incentive_satuan($ii);
				$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
				foreach($data['hasil'] as $r){
    			    $event = $r->event;
    			    $loc = $r->location;
    			    $tgl = $r->date;
    			}
    			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}else{
			redirect('/?auth=list_incentive&fail');
		}
	}
	
	public function approved_paid_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_crud -> approved_paid_satuan($ii);
			$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			redirect('/?auth=list_incentive&fail');
		}
	}
	
	public function can_approved_paid_satuan()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_crud -> can_approved_paid_satuan($ii);
				$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
				foreach($data['hasil'] as $r){
    			    $event = $r->event;
    			    $loc = $r->location;
    			    $tgl = $r->date;
    			}
    			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
		}else{
			redirect('/?auth=list_incentive&fail');
		}
	}
	
	public function approved_paid_all()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_crud -> approved_paid_all($id);
			$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			redirect('/?auth=list_incentive&fail');
		}
	}
	
	public function unapproved_paid_all()
	{
	    $id = $_GET['id'];
	    $token = $_GET['token'];
	    $ii = $_GET['idu'];
	    $token_ii = $_GET['token_incen'];
	    
	    if(($token == md5($id)) AND ($token_ii == md5($ii))){
			$results = $this -> model_crud -> unapproved_paid_all($id);
			$data['hasil'] = $this -> model_crud -> get_satuan_task($id);
			
			foreach($data['hasil'] as $r){
			    $event = $r->event;
			    $loc = $r->location;
			    $tgl = $r->date;
			}
			redirect('/?auth=list_detail_incentive&id='.$id.'&token='.$token.'&event='.$event.'&loc='.$loc.'&tgl='.$tgl);
			
		}else{
			redirect('/?auth=list_incentive&fail');
		}
	}
	
	public function report_jumlah_incentive()
	{
		$id = $this->input->post('id');
		$token = $this->input->post('token');
		$jmh = $this->input->post('jmh');
		
		redirect('/?auth=report_detail_incentive&id='.$id.'&jmh='.$jmh.'&token='.$token.'');
	
	}
	
	public function add_incentive()
	{
		$id_event = $this->input->post('id_event');
		$jmh = $this->input->post('jmh');
		
			
		for($i=0; $jmh > $i; $i++){
		
			$user = $this->input->post('user'.$i.'');
			$peserta = $this->input->post('peserta'.$i.'');
			$bayar = $this->input->post('bayar'.$i.'');
			$closing = $this->input->post('closing'.$i.'');
			
			$programlain = $this->input->post('program_lain'.$i.'');
			
			$results = $this -> model_crud -> add_incentive($id_event,$user,$peserta,$bayar,$closing,$programlain);

		}
		
		if($results) {
			redirect('/?auth=report_incentive');
		}

	
	}
	
	public function update_incentive()
	{
		$id_event = $this->input->post('id_event');
		$jmh = $this->input->post('jmh');
		
			
		for($i=0; $jmh > $i; $i++){
			
			$id_incentive = $this->input->post('id_incentive'.$i.'');
			$user = $this->input->post('user'.$i.'');
			$peserta = $this->input->post('peserta'.$i.'');
			$bayar = $this->input->post('bayar'.$i.'');
			$closing = $this->input->post('closing'.$i.'');
			
			$programlain = $this->input->post('program_lain'.$i.'');
			
			$results = $this -> model_crud -> update_incentive($id_incentive,$user,$peserta,$bayar,$closing,$id_event,$programlain);

		}
		
		if($results) {
			redirect('?auth=report_update_detail_incentive&id='.$id_event.'&token='.md5($id_event));
		}
	}
	
	public function add_row_incentive()
	{
	
		$redirect = $this->input->post('redirect');
		$baris = $this->input->post('baris');
		
		redirect($redirect.'&baris='.$baris);
		
	
	}
	
	public function add_row_incentive_finance()
	{
	
		$redirect = $this->input->post('redirect');
		$baris = $this->input->post('baris');
		
		redirect($redirect.'&baris='.$baris);
		
	
	}
	
	public function del_list_incentive()
	{
	
		$id_incentive =  $this->uri->segment(3);
  		$token_incentive =  $this->uri->segment(4);
  		
  		$id_event =  $this->uri->segment(5);
  		
  		if(md5($id_incentive) == $token_incentive){
  		
  			$results = $this -> model_crud -> del_list_incentive($id_incentive);
  			$data['hslnm'] = $this -> model_crud -> get_hsl_number_incentive($id_event);
  			
  			if($data['hslnm'] > 0){
  			
	  			if($results){
	  				redirect('?auth=report_update_detail_incentive&id='.$id_event.'&token='.md5($id_event));
	  			}
  			}else{
  				redirect('/?auth=report_incentive');
  			}
  		
  		}else{
  			redirect('/?auth=report_incentive');
  		}
	
	}
	

	public function change_pass(){
	
		$lp = $this->input->post('lp');
		$results = $this -> model_crud -> cek_next_pass($lp);
		
		if($results){
			$np = $this->input->post('np');
			$cp = $this->input->post('cp');
			
			if (strlen($np)>5){
			
				if($np == $cp){
					$result = $this -> model_crud -> change_pass($np);
					$this->session->set_flashdata('gntpass','success');
					redirect('https://apps.mri.co.id/?auth=myaccount');
				
				}else{
					$this->session->set_flashdata('gntpass','error');
					redirect('https://apps.mri.co.id/?auth=myaccount');
				}
					
			}else{
					$this->session->set_flashdata('gntpass','error');
					redirect('https://apps.mri.co.id/?auth=myaccount');
			}
			
		}else{
					$this->session->set_flashdata('gntpass','error');
					redirect('https://apps.mri.co.id/?auth=myaccount');
		}
	}
	
	public function give_cuti_bulanan(){
	
		$hasil['nama'] = $this -> model_crud -> getusername_bulanan();
		
		foreach( $hasil['nama'] as $r ){
			$id_user = $r->id;
			$email = $r->email;
			
			$results = $this -> model_crud -> tambah_cuti_bulanan($id_user);
			
			
			//Email Notification he/her get cuti
			$pesan = '<html><body>Selamat Pencairan :<br>Cuti Izin : 1 <br>Cuti Sakit : 1 <br>Berhasil ditambahkan.</body></html>';
			
			$to = $email;
			$subject = 'Pencairan Cuti Bulanan berhasil ditambahkan';
			$body_html = $pesan;
			$from = 'support@mri.co.id';
			$fromName = 'Merry Riana Indonesia';
			$res = "";
	
			$data = "username=".urlencode("support@mri.co.id");
			$data .= "&api_key=".urlencode("81A9A016FB31BA386269F0F154675E3343868B0BE78FF9B1F768D7217F9BBD70E135DF791CABE999824B4370DFE35039");
			$data .= "&from=".urlencode($from);
			$data .= "&from_name=".urlencode($fromName);
			$data .= "&to=".urlencode($to);
			$data .= "&subject=".urlencode($subject);
			if($body_html)
			  $data .= "&body_html=".urlencode($body_html);
	
			$header = "POST /mailer/send HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
			$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
	
			if(!$fp)
			  return "ERROR. Could not open connection";
			else {
			  fputs ($fp, $header.$data);
			  while (!feof($fp)) {
				$res .= fread ($fp, 1024);
			  }
			  fclose($fp);
			}
			
		}
	
	    flashdata('success', 'Cuti Izin dan Sakit berhasil ditambahkan');
		redirect(base_url('hr/overtime'));
	
	}
	
	
// 	public function give_cuti_tahunan(){
	
// 		$hasil['nama'] = $this -> model_crud -> getusername_tahunan();
		
// 		foreach( $hasil['nama'] as $r ){
// 			$id_user = $r->id;
// 			$email = $r->email;
			
// 			$results = $this -> model_crud -> tambah_cuti_tahunan($id_user);
			
			
// 			//Email Notification he/her get cuti
// 			$pesan = '<html><body>Selamat Pencairan :<br>Cuti Izin : 12 <br>Cuti Sakit : 12 <br>Berhasil ditambahkan.</body></html>';
			
// 			$to = $email;
// 			$subject = 'Pencairan Cuti Tahunan berhasil ditambahkan';
// 			$body_html = $pesan;
// 			$from = 'support@mri.co.id';
// 			$fromName = 'Merry Riana Indonesia';
// 			$res = "";
	
// 			$data = "username=".urlencode("support@mri.co.id");
// 			$data .= "&api_key=".urlencode("81A9A016FB31BA386269F0F154675E3343868B0BE78FF9B1F768D7217F9BBD70E135DF791CABE999824B4370DFE35039");
// 			$data .= "&from=".urlencode($from);
// 			$data .= "&from_name=".urlencode($fromName);
// 			$data .= "&to=".urlencode($to);
// 			$data .= "&subject=".urlencode($subject);
// 			if($body_html)
// 			  $data .= "&body_html=".urlencode($body_html);
	
// 			$header = "POST /mailer/send HTTP/1.0\r\n";
// 			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
// 			$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
// 			$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
	
// 			if(!$fp)
// 			  return "ERROR. Could not open connection";
// 			else {
// 			  fputs ($fp, $header.$data);
// 			  while (!feof($fp)) {
// 				$res .= fread ($fp, 1024);
// 			  }
// 			  fclose($fp);
// 			}
		
		
			
// 		}
	
	
	
// 	}
	
	
	
	
}
