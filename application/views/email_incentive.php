<?php

		
		if(!empty($emailku)){
			
			$no = 1;
			foreach($emailku as $e){ 
			
				if($no == 1){
				
					$name = $e->username;
					$jl = $e->jenis_lunas;
					$emailto = $e->email;
					$event = $e->event;
					$location = $e->location;
					$tgl = $e->date;
					
					if($jl == 'lunas'){
						$komisi = $e->komisi_lunas;
					}else{
						$komisi = $e->komisi_dp;
					}
					
					$no = $no + 1;
				
				}elseif($name == $e->username){				
					
					$jl = $e->jenis_lunas;
					$emailto = $e->email;
					$event = $e->event;
					$location = $e->location;
					$tgl = $e->date;
					
					if($jl == 'lunas'){
						$komisi_tambah = $e->komisi_lunas;
					}else{
						$komisi_tambah = $e->komisi_dp;
					}
					
					$komisi = $komisi + $komisi_tambah;
				
				}else{ 
				
				
					
					$this->load->library('email');
					$from="andy@mri.co.id";
					$fromName="Merry Riana Indonesia";
					$to = $emailto;
					$subject = "Notifikasi Transfer Incentive";
					$data=array();
					$mesg = $this->load->view('theme_email_notif_incentive',$data,true);
					$mesg = str_replace("JUDUL","INCENTIVE",$mesg);
					$tagline = $event.' - '.$tgl;
					$text = "Terima kasih sudah membantu dalam kegiatan Acara kita, semoga kedepannya kita dapat closing lebih banyak lagi.";
					$mesg = str_replace("TAGLINE",$tagline,$mesg);
					$mesg = str_replace("SAMBUTAN",'Rp '.number_format($komisi),$mesg);
					$mesg = str_replace("PESAN",$text,$mesg);
					$res = "";
					
					$data = "username=".urlencode("andy@pediahost.com");
					$data .= "&api_key=".urlencode("fb4317fa-0fde-46e4-8510-2d6cfabf6413");
					$data .= "&from=".urlencode($from);
					$data .= "&from_name=".urlencode($fromName);
					$data .= "&to=".urlencode($to);
					$data .= "&subject=".urlencode($subject);
					if($mesg)
					  $data .= "&body_html=".urlencode($mesg);
			
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
					

					
					$name = $e->username;
					$jl = $e->jenis_lunas;
					$emailto = $e->email;
					$event = $e->event;
					$location = $e->location;
					$tgl = $e->date;
					
					if($jl == 'lunas'){
						$komisi = $e->komisi_lunas;
					}else{
						$komisi = $e->komisi_dp;
					}
					
				
				} 
				
			}
			
			$this->load->library('email');
			$from="andy@mri.co.id";
			$fromName="Merry Riana Indonesia";
			$to = $emailto;
			$subject = "Notifikasi Transfer Incentive";
			$data=array();
			$mesg = $this->load->view('theme_email_notif_incentive',$data,true);
			$mesg = str_replace("JUDUL","INCENTIVE",$mesg);
			$tagline = $event.' - '.$tgl;
			$text = "Terima kasih sudah membantu dalam kegiatan Acara kita, semoga kedepannya kita dapat closing lebih banyak lagi.";
			$mesg = str_replace("TAGLINE",$tagline,$mesg);
			$mesg = str_replace("SAMBUTAN",'Rp '.number_format($komisi),$mesg);
			$mesg = str_replace("PESAN",$text,$mesg);
			$res = "";
			
			$data = "username=".urlencode("andy@pediahost.com");
			$data .= "&api_key=".urlencode("fb4317fa-0fde-46e4-8510-2d6cfabf6413");
			$data .= "&from=".urlencode($from);
			$data .= "&from_name=".urlencode($fromName);
			$data .= "&to=".urlencode($to);
			$data .= "&subject=".urlencode($subject);
			if($mesg)
			  $data .= "&body_html=".urlencode($mesg);
	
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

		flashdata('success','Pengumuman Pengiriman Incentive telah berhasil dikirim');
		redirect(base_url().'finance/incentive','refresh');


?>