<?php if($this->session->userdata('logged_in')) { ?>


	<?php 
	
		$this->load->view('header_war.php');
		$this->load->view('head_war.php');
		$this->load->view('sidebar_war.php'); 
		
			
			
		//Cek username <> Admin
		if(($this->session->userdata('username')<>'admin')&&($this->session->userdata('username')<>'taskadmin')&&($this->session->userdata('username')<>'finance')){
			
			if($_GET['auth']=='dashboard'){
			    
				
			}
			elseif($_GET['auth']=='addlembur'){
				$data['hsl'] = $this -> model_crud -> get_addlembur();
				$this->load->view('content_addlembur.php',$data);
			}
			elseif($_GET['auth']=='acclembur'){
				$data['hsl'] = $this -> model_crud -> get_acclembur();
				$this->load->view('content_acclembur.php',$data);
			}
			elseif($_GET['auth']=='editlembur'){
				$this->load->view('content_edit_addlembur.php');
			}
			elseif($_GET['auth']=='report'){
			    
			    //Mendeteksi username
				$name = $this->session->userdata('username');
				
				//cek apakah ada post untuk bulan dan tahun
				if (empty($_POST['bln']) || (empty($_POST['thn'])) ){
    				//How to Get Date same this Month
    				//Get Much days in Month
    				$bln = date("m");
    				$thn = date("Y");
				}else{
				    $bln = $_POST['bln'];
    				$thn = $_POST['thn'];
				}
				
				//Memasukan data bulan kedalam array data agar bisa diextrak di view
				$data['bln'] = $bln;
				$data['thn'] = $thn;
				
				//Mengecek jumlah hari/tanggal pada bulan di tahun tersebut
				$jmh_hari = cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
				
				$i=0;$plus=0;
				
				//Looping sebanyak jumlah hari/tanggal
				for($d=1;$d <= $jmh_hari;$d++){
				    
				    //Memulai pencarian dari tanggal 1 dibulan tersebut
					$cari_tgl = $thn.'-'.$bln.'-'.$d;
					
					//Mendapatkan jam lembur di tanggal tersebut
					$hsl_cari = $this -> model_crud -> cari_tgl($name,$cari_tgl);
					
					$hsl_desk = $this -> model_crud -> cari_desk($name,$cari_tgl);
					$jam = $this -> model_crud -> cari_lembur_bulan($bln,$thn);
					
					$hasil[$i][0] = $cari_tgl;
					$hasil[$i][1] = $hsl_desk;
					
					if($hsl_cari == '-'){
					$hasil[$i][2] = '-';
					$hasil[$i][3] = '-';
					$hasil[$i][4] = $jam + $plus;
					}
					if($hsl_cari == 0){
					$hasil[$i][2] = '-';
					$hasil[$i][3] = '-';
					$hasil[$i][4] = $jam + $plus;
					}
					elseif($hsl_cari > 0){
					$hasil[$i][2] = $hsl_cari;
					$plus = $plus + $hsl_cari;
					$hasil[$i][3] = '-';
					$hasil[$i][4] = $jam + $plus;
					}
					elseif($hsl_cari < 0){
					$hasil[$i][2] = '-';
					$plus = $plus + $hsl_cari;
					$hasil[$i][3] = $hsl_cari;
					$hasil[$i][4] = $jam + $plus;
					}
					$i = $i+1;
				}
				$data['hasil']= $hasil;	
				$data['jmh_hari']= $jmh_hari;
				
				
				$data['results']= $this -> model_crud -> cari_cuti_izin();
				$i=0;$min=0;
				$izin[]=null;
				foreach($data['results'] as $r){
				
					$izin[$i][0] = $r->tgl;
					$izin[$i][1] = $r->deskripsi;
					if($i == 0){
						$awal = 12;
						$izin[$i][2] = 12;
					}else{
						$izin[$i][2] = '-';
					}
					$min = $min - 1;
					$izin[$i][3] = -1;
					$sisa = $awal + $min;
					$izin[$i][4] = $sisa;
				
					$i = $i+1;
				}
				
				$data['jmh_izin'] = $i;
				$data['izin'] = $izin;
				
				
				$data['results']= $this -> model_crud -> cari_cuti_sakit();
				$i=0;$min=0;
				$sakit[]=null;
				foreach($data['results'] as $r){
				
					$sakit[$i][0] = $r->tgl;
					$sakit[$i][1] = $r->deskripsi;
					if($i == 0){
						$awal = 12;
						$sakit[$i][2] = 12;
					}else{
						$sakit[$i][2] = '-';
					}
					$min = $min - 1;
					$sakit[$i][3] = -1;
					$sisa = $awal + $min;
					$sakit[$i][4] = $sisa;
				
					$i = $i+1;
				}
				
				$data['jmh_sakit'] = $i;
				$data['sakit'] = $sakit;
				
				$data['jmhdg'] = $jam;
				
				$this->load->view('content_report.php',$data);
			}
			
			elseif($_GET['auth']=='member_izin'){
				
				$thn = date('Y');
				$username = $this->session->userdata('username');
				$data['cekname'] = $this->session->userdata('username');
				$data['cutisblm'] = $this -> model_crud -> get_cuti_izin_sblm($username, $thn);
				$data['results'] = $this -> model_crud -> get_cuti_izin($username, $thn);
				
				//Get name user
				$data['allname'] = $this -> model_crud -> getusername();
				$this->load->view('content_member_cuti.php',$data);
			}
			
			elseif($_GET['auth']=='member_sakit'){
				
				$username = $this->session->userdata('username');
				$data['cekname'] = $this->session->userdata('username');
				$data['results'] = $this -> model_crud -> get_cuti_sakit($username);
				
				//Get name user
				$data['allname'] = $this -> model_crud -> getusername();
				$this->load->view('content_member_sakit.php',$data);
			}
			
			elseif($_GET['auth']=='mytask'){
				$data['results'] = $this -> model_crud -> get_mytask();
				$data['hasil'] = $this -> model_crud -> getusername();
				
				$data['minus'] = $this -> model_crud -> get_minus_event();
				$data['plus'] = $this -> model_crud -> get_plus_event();
				
				$minus = 0;
				if($data['minus']){
					foreach($data['minus'] as $m){
						$minus = $minus + 1;
					}
				}
				
				$minus = $minus * 2;
				
				$plus = 0;
				if($data['plus']){
					foreach($data['plus'] as $p){
						$plus = $plus + 1;
					}
				}
				
				$hasil = $plus - $minus;
				
				$data['sp'] = $hasil;
				
				$this->load->view('content_mytask.php', $data);
			
			}
			
			elseif($_GET['auth']=='submission_task'){
				$data['results'] = $this -> model_crud -> get_submission_task();
				$data['hasil'] = $this -> model_crud -> getusername();
				$this->load->view('content_pengajuan_task.php', $data);
			
			}
			
			elseif($_GET['auth']=='request_task'){
				$data['results'] = $this -> model_crud -> get_request_task();
				$data['hasil'] = $this -> model_crud -> getusername();
				$this->load->view('content_permohonan_task.php', $data);
			
			}
			
			elseif($_GET['auth']=='all_task'){
				$data['results'] = $this -> model_crud -> get_all_mytask();
				$data['hasil'] = $this -> model_crud -> getusername();
				$this->load->view('content_all_task.php', $data);
			
			}
			
			elseif($_GET['auth']=='check_uang_masuk'){
				$data['results'] = $this -> model_crud -> get_cek_uang_masuk();
				$this->load->view('content_cek_uang_masuk.php',$data);
			
			}
			
			elseif($_GET['auth']=='bird_test'){
				$data['lock'] = $this -> model_crud -> get_birdtest_settings();
				$this->load->view('content_bird_test.php',$data);
			
			}
			
			elseif($_GET['auth']=='report_incentive'){
				$data['results'] = $this -> model_crud -> info_pd_incentive();
				$this->load->view('content_report_incentive.php',$data);
			
			}
			
			elseif($_GET['auth']=='report_detail_incentive'){
			
			    //mendapatkan url GET id
				$id_event = $_GET['id'];
				
				//mendapatkan url GET token
				$token = $_GET['token'];
				
				//cek apakah token sudah sesuai dengan id
				if(md5($id_event) == $token){
				    
				    //Jika sama maka cek pd incentive
					$data['results'] = $this -> model_crud -> get_pd_incentive($id_event);
					
					//Dapatkan semua nama warriors
					$data['user'] = $this -> model_crud -> getusername_detail_incentive();
					
					//Cek Pd incentive
					if($data['results']){
					    
					    //Jika Pd incentive diizinkan, maka buka halaman content report detail incentive
					    $data['listprogram'] = $this -> model_crud -> get_all_incentive_list();
						$this->load->view('content_report_detail_incentive.php',$data);
					}else{
					    
					    //Jika salah maka tolak dan arahkan ke halaman report incentive
						redirect('/?auth=report_incentive','refresh');
					}
					
				}else{
					redirect('/?auth=report_incentive','refresh');
				}
			
			}
			
			elseif($_GET['auth']=='report_update_detail_incentive'){
			
				$id_event = $_GET['id'];
				$token = $_GET['token'];
				
				if(md5($id_event) == $token){
					$data['results'] = $this -> model_crud -> get_pd_incentive($id_event);
					$data['user'] = $this -> model_crud -> getusername_detail_incentive();
					$data['hsl'] = $this -> model_crud -> get_hsl_incentive($id_event);
					$data['hslnm'] = $this -> model_crud -> get_hsl_number_incentive($id_event);
					if($data['results']){
					    $data['listprogram'] = $this -> model_crud -> get_all_incentive_list();
						$this->load->view('content_report_update_detail_incentive.php',$data);
					}else{
						redirect('/?auth=report_update_incentive','refresh');
					}
				}else{
					redirect('/?auth=report_incentive','refresh');
				}
			
			}
			
			
			
			elseif($_GET['auth']=='incentive'){

				$data['results'] = $this -> model_crud -> get_my_incentive();
				$data['paid'] = $this -> model_crud -> get_my_incentive_paid();
				$data['unpaid'] = $this -> model_crud -> get_my_incentive_unpaid();
				$this->load->view('content_incentive.php',$data);
			
			}
			
			elseif($_GET['auth']=='report_pd'){
				
				$idevent= $_GET['idevent'];
				$token = $_GET['token'];
				
				if(md5($idevent) == $token){
					$data['results'] = $this -> model_crud -> getusername_event($idevent);
					
					$i = 0;
					foreach ($data['results'] as $r){
						
						if($r->persetujuan_pengganti == 'ya'){
							$id = $r->id_pengganti;
						}else{
							$id = $r->id_user;
						}
						
						$data['usr'] = $this -> model_crud -> getusername_event_get($id);
						
						foreach($data['usr'] as $rn){
							$hasil[$i][0] = $rn->username;
						}
						$hasil[$i][1] = $r->tugas;
						$hasil[$i][2] = $r->dp;
						$hasil[$i][3] = $r->modul;
						$hasil[$i][4] = $r->lunas;
						$hasil[$i][5] = $id;
						$hasil[$i][6] = $r->hadir;
						
						$data['event'] = $this -> model_crud -> getidtask_get($idevent);
						foreach($data['event'] as $re){
							$hasil[0][7] = $re->jenis_report;
							
							if($hasil[0][7]=='peserta'){
								$hasil[0][8] = $re->daftar;
								$hasil[0][9] = $re->ots;
								$hasil[0][10] = $re->hadir;
								$hasil[0][11] = $re->tidak_hadir;						
							}elseif($hasil[0][7]=='keluarga'){
								$explode_daftar = $re->daftar;
								
								if(strlen($explode_daftar) > 0){
									
									$daftar_pecah = explode(",", $explode_daftar);
									
									$hasil[1][8] = $daftar_pecah[0];
									$hasil[2][8] = $daftar_pecah[1];
									
									$explode_ots = $re->ots;
									$ots_pecah = explode(",", $explode_ots);
									
									$hasil[1][9] = $ots_pecah[0];
									$hasil[2][9] = $ots_pecah[1];
									
									$explode_hadir = $re->hadir;
									$hadir_pecah = explode(",", $explode_hadir);
									
									$hasil[1][10] = $hadir_pecah[0];
									$hasil[2][10] = $hadir_pecah[1];
									
									$explode_tidak_hadir = $re->tidak_hadir;
									$tidak_hadir_pecah = explode(",", $explode_tidak_hadir);
									
									$hasil[1][11] = $tidak_hadir_pecah[0];
									$hasil[2][11] = $tidak_hadir_pecah[1];
								}
							}
						}

						
					$i = $i + 1;
					}
					
					$data['jmh'] = $i;
					$data['hasil']= $hasil;
					$data['idtask']= $idevent;
					
					$data['nm'] = $this -> model_crud ->user_add_task_paytask();
					
					$this->load->view('content_report_pd.php',$data);
				}else{
					redirect('/?auth=mytask','refresh');
				}
				
				
			
			}
			
		//End username <> admin
		}
		elseif($this->session->userdata('username')=='taskadmin'){
			if($_GET['auth']=='dashboard'){
				//$this->load->view('content_dashboard.php');
				redirect(base_url().'?auth=task','refresh');
			}
			elseif($_GET['auth']=='task'){
				$data['results'] = $this -> model_crud -> get_task();
				$this->load->view('content_get_task.php',$data);
			}
			elseif($_GET['auth']=='alltask'){
				$data['results'] = $this -> model_crud -> get_alltask();
				$this->load->view('content_get_alltask.php',$data);
			}
			elseif($_GET['auth']=='listincensp'){
				$data['results'] = $this -> model_crud -> get_all_incentive_list();
				$this->load->view('content_list_incentive_sp.php',$data);
			}
			elseif($_GET['auth']=='addtaskwarriors'){
				$id = $_GET['id'];
				$token = $_GET['token'];
				$data['results'] = $this -> model_crud -> get_select_task($id,$token);
				$data['hasil'] = $this -> model_crud -> getusername();
				$this->load->view('content_add_war_event.php',$data);
			}
			elseif($_GET['auth']=='addtask'){
				$this->load->view('content_add_task.php');
			}
			elseif($_GET['auth']=='editevent'){
				$id = $_GET['id'];
				$token = $_GET['token'];
				
				$data['results'] = $this -> model_crud -> get_select_task($id,$token);
				$this->load->view('content_edit_task.php',$data);

			}
			elseif($_GET['auth']=='delevent'){
				$id = $_GET['id'];
				$token = $_GET['token'];
				
				$data['results'] = $this -> model_crud -> get_select_task($id,$token);
				$this->load->view('content_konfirmasi_deltask.php',$data);

			}
			elseif($_GET['auth']=='getuser'){
				$this->load->view('content_get_user.php');
			}
			elseif($_GET['auth']=='choosepd'){
				$id = $_GET['id'];
				$token = $_GET['token'];
				$data['results'] = $this -> model_crud -> get_select_task($id,$token);
				$data['hasil'] = $this -> model_crud -> getusername_task($id);
				$this->load->view('content_choose_pd.php',$data);
			}
			elseif($_GET['auth']=='edittaskwarriors'){
				$id = $_GET['id'];
				$token = $_GET['token'];
				$data['results'] = $this -> model_crud -> get_select_task($id,$token);
				$data['hasil'] = $this -> model_crud -> getusername_task($id);
				$this->load->view('content_edittask_war.php',$data);
			}
			elseif($_GET['auth']=='reporttask'){
				$data['name'] = $this -> model_crud -> getusername_report_task();
				
				$baris=0;$i=0;
				foreach($data['name'] as $r){
					$hasil[$i][0] = $r->username;
					
					$data['jmh_event_no_pay'] = $this -> model_crud -> get_event_all_notpay($r->id);
					$hasil[$i][1] = $data['jmh_event_no_pay'];
					
					$data['jmh_event_pay'] = $this -> model_crud -> get_event_all_pay($r->id);
					$hasil[$i][2] = $data['jmh_event_pay'];
					
					$data['jmh_event_hutang'] = $this -> model_crud -> get_event_all_hutang($r->id);
					$hasil[$i][3] = $data['jmh_event_hutang'];
					
					$baris = $baris + 1;
					$i = $i + 1;
				}
				
				$data['hasil'] = $hasil;
				$data['baris'] = $baris;
				$this->load->view('content_reporttask.php',$data);
			}
			elseif($_GET['auth']=='report'){
				
				$idevent= $_GET['id'];
				$token = $_GET['token'];
				
				if(md5($idevent) == $token){
					$data['results'] = $this -> model_crud -> getusername_event($idevent);
					
					$i = 0;
					foreach ($data['results'] as $r){
						
						if($r->persetujuan_pengganti == 'ya'){
							$id = $r->id_pengganti;
							$idp = $r->id_user;
						}else{
							$id = $r->id_user;
							$idp = null;
						}
						
						$data['usr'] = $this -> model_crud -> getusername_event_get($id);
						
						if($idp <> null){
						    $data['usr_p'] = $this -> model_crud -> getusername_event_get($idp);
						    
						    foreach($data['usr_p'] as $rn){
    							$sblm_diganti = '<span style="color:red;">'.$rn->username.'</span> <i class="fa fa-caret-right" aria-hidden="true"></i> ';
    						}
						}else{
						    $sblm_diganti = "";
						}
						
						foreach($data['usr'] as $rn){
							$hasil[$i][0] = $sblm_diganti.' '.$rn->username;
						}
						$hasil[$i][1] = $r->tugas;
						$hasil[$i][2] = $r->dp;
						$hasil[$i][3] = $r->modul;
						$hasil[$i][4] = $r->lunas;
						$hasil[$i][5] = $id;
						$hasil[$i][6] = $r->hadir;
						
						$data['event'] = $this -> model_crud -> getidtask_get($idevent);
						foreach($data['event'] as $re){
							$hasil[0][7] = $re->jenis_report;
							
							if($hasil[0][7]=='peserta'){
								$hasil[0][8] = $re->daftar;
								$hasil[0][9] = $re->ots;
								$hasil[0][10] = $re->hadir;
								$hasil[0][11] = $re->tidak_hadir;						
							}elseif($hasil[0][7]=='keluarga'){
							
								$explode_daftar = $re->daftar;
								
								if(strlen($explode_daftar) > 0){
									$daftar_pecah = explode(",", $explode_daftar);
									
									$hasil[1][8] = $daftar_pecah[0];
									$hasil[2][8] = $daftar_pecah[1];
									
									$explode_ots = $re->ots;
									$ots_pecah = explode(",", $explode_ots);
									
									$hasil[1][9] = $ots_pecah[0];
									$hasil[2][9] = $ots_pecah[1];
									
									$explode_hadir = $re->hadir;
									$hadir_pecah = explode(",", $explode_hadir);
									
									$hasil[1][10] = $hadir_pecah[0];
									$hasil[2][10] = $hadir_pecah[1];
									
									$explode_tidak_hadir = $re->tidak_hadir;
									$tidak_hadir_pecah = explode(",", $explode_tidak_hadir);
									
									$hasil[1][11] = $tidak_hadir_pecah[0];
									$hasil[2][11] = $tidak_hadir_pecah[1];
									
								}
								
							
							}
							
							$data['hasil']= $hasil;
						}

						
					$i = $i + 1;
					}
					
					$data['jmh'] = $i;
					
					$data['idtask']= $idevent;
					
					$data['nm'] = $this -> model_crud ->user_add_task_paytask();
					
					$this->load->view('content_review_report.php',$data);
				}
				
			}
		
		}
		
		//Login username = finance
		elseif($this->session->userdata('username')=='finance'){
			if($_GET['auth']=='dashboard'){
				redirect('/?auth=list_incentive','refresh');
			}
			
			elseif($_GET['auth']=='list_incentive'){
				
				$data['results'] = $this -> model_crud -> get_list_incentive();
				$this->load->view('content_list_incentive.php',$data);
			}
			
			elseif($_GET['auth']=='list_incentive_last'){
				
				$data['results'] = $this -> model_crud -> get_list_incentive_last();
				$this->load->view('content_list_incentive_last.php',$data);
			}
			
			elseif($_GET['auth']=='list_detail_incentive'){
				$id = $_GET['id'];
				$data['results'] = $this -> model_crud -> get_all_incentive($id);
				$data['cek_app_incen'] = $this -> model_crud -> check_approved_incentive($id);
				$data['cek_paid_incen'] = $this -> model_crud -> check_paid_incentive($id);
				$data['username'] = $this-> model_crud -> get_username();
				$data['pro_lain'] = $this-> model_crud -> get_all_incentive_list();
				$this->load->view('content_list_detail_incentive.php',$data);
			}
			elseif($_GET['auth']=='moneychecker'){
				$data['results'] = $this -> model_crud -> get_cek_uang_masuk_all();
				$this->load->view('content_moneychecker.php',$data);
			
			}
		}
		
		//Cek username = admin
		elseif($this->session->userdata('username')=='admin'){
		
			if($_GET['auth']=='dashboard'){
				//$this->load->view('content_dashboard.php');
				redirect(base_url().'?auth=alllaphrcuti','refresh');
			}
		
			elseif($_GET['auth']=='user'){
				$data['results'] = $this -> model_crud -> getuser_admin();
				$this->load->view('content_user.php',$data);
			}
			elseif($_GET['auth']=='tambahuser'){
				$this->load->view('content_tambahuser.php');
			}
			elseif($_GET['auth']=='edituser'){
				$id = $_GET['id'];
				//$nama = $this->input->post('nama');
				//$data['results'] = $this -> model_crud -> edit_user($id,$nama);
				$data['results'] = $this -> model_crud -> get_edit_user($id);
				$data['divisi'] = $this -> model_crud -> getdivisi();
				$this->load->view('content_edituser.php',$data);
			}
			elseif($_GET['auth']=='acclembur'){
				$data['hsl'] = $this -> model_crud -> get_acchr_lembur();
				$this->load->view('content_acchrlembur.php',$data);
			}
			elseif($_GET['auth']=='lembur'){
				$data['results'] = $this -> model_crud -> getusername();
				$this->load->view('content_lembur.php',$data);
			}
			elseif($_GET['auth']=='detaillembur'){
				$user = $_GET['user'];
				$tgl = $_GET['tgl'];
				
				//Menampilkan data dari user dan tanggal yang dicari
				$data['results'] = $this -> model_crud -> get_detail_lembur($user,$tgl);
				$this->load->view('content_detaillembur.php',$data);
			}
			elseif($_GET['auth']=='alllaphrcuti'){
			    
				$data['results'] = $this -> model_crud -> getuser();
				
				$i=0;$jmhuser=0;
				if($data['results']<>null){
					foreach ($data['results'] as $r){
						$jmhuser = $jmhuser + 1;
						$username = $r->username;
						
						$hasil[$i][0] = $r->username;
						$hasil[$i][1] = $this -> model_crud -> get_total_cuti($username);
						$hasil[$i][2] = $this -> model_crud -> get_total_cuti_sakit($username);
						$hasil[$i][3] = $this -> model_crud -> get_total_lembur($username);
						
						$i = $i + 1;
					}
				}else{
				$hasil = null;
				}
				$data['jmhuser']= $jmhuser;
				$data['hasil']= $hasil;
				
				$this->load->view('content_all_cuti_izin.php',$data);
			}
			elseif($_GET['auth']=='laphrcuti'){
				
				if (isset($_POST["name"]) && !empty($_POST["name"]) && !empty($_POST['thn'])) {
					$username = $_POST['name'];
					$fromthn = $_POST['thn'];
					$data['cekname'] = $_POST['name'];
					$data['cutisblm'] = $this -> model_crud -> get_cuti_izin_sblm($username, $fromthn);
					$data['results'] = $this -> model_crud -> get_cuti_izin($username, $fromthn);
				}
				//Get name user
				$data['allname'] = $this -> model_crud -> getusername();
				$this->load->view('content_laporanhrcuti.php',$data);
			}
			elseif($_GET['auth']=='laphrcutiskt'){
				if (isset($_POST["name"]) && !empty($_POST["name"])) {
					$username = $_POST['name'];
					$data['cekname'] = $_POST['name'];
					$data['results'] = $this -> model_crud -> get_cuti_sakit($username);
				}
				//Get name user
				$data['allname'] = $this -> model_crud -> getusername();
				$this->load->view('content_laporancutiskt.php',$data);
			}
			elseif($_GET['auth']=='laphr'){
				//How to Get User
				$data['results'] = $this -> model_crud -> getuser();
				
					$i = 0;
					if($data['results']<>null){
						foreach($data['results'] as $r){
						
							if($r->username<>'admin'){
								//How to Get Balance
								$name = $r->username;
								$lembur = $this -> model_crud -> getlembur($name);
								
								//Get month and years on input box 
								$m = $this->input->post('month');
								$y = $this->input->post('year');
								
								//If input is null
								if($m == null && $y == null){
								    
								    $bln = date("m");
								    $thn = date("Y");
								    
								}else{
								    
								    $bln = $m;
								    $thn = $y;
								    
								    $data['bln'] = $m;
								    $data['thn'] = $y;
								    
								}
								
								$date = $thn.'-'.$bln.'-01';
								$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
								$newdate = date ( 'Y-m-j' , $newdate );
								
								$hsl_lmbr = $this -> model_crud -> get_lembur_sblm($name,$newdate);
								
								
								$jmh_hari = cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
								
								$totalovertime = 0;
								
								//Search Date
								for($d=1;$d <= $jmh_hari;$d++){
									$cari_tgl = $thn.'-'.$bln.'-'.$d;
									
									$hsl_cari = $this -> model_crud -> cari_tgl($name,$cari_tgl);
									$hasil[$i][$d+1] = $hsl_cari;	
									
									//Get total overtime
									$totalovertime = $totalovertime + $hsl_cari;
									
								}
								
								//Get total overtime
								$hasil[$i][$d+1] = $totalovertime;
								$hasil[$i][$d+2] = $hsl_lmbr;
								
								$hasil[$i][0] = $r->username;
								$hasil[$i][1] = $lembur;
								$i = $i + 1;
							}
						}
					}
				if(!empty($hasil)){
				$data['hasil']= $hasil;
				$data['jmh_hari']= $jmh_hari;
				$data['jmh_user']= $i;
				}
				
				$this->load->view('content_laporanhr.php',$data);
			}
			
			
			elseif($_GET['auth']=='hapususer'){
				$id = $_GET['id'];
				$data['results'] = $this -> model_crud ->get_remove_user($id);
				
				foreach($data['results'] as $r){
					$data['name'] = $r->username;
				}
				
				$this->load->view('content_remove.php',$data);
			}
			
			elseif($_GET['auth']=='loker'){
								
				$this->load->view('content_loker.php');
			}
			
			elseif($_GET['auth']=='birdtest'){
				$data['lock'] = $this -> model_crud -> get_birdtest_settings();
				$data['results'] = $this -> model_crud -> getusername();	
				$this->load->view('content_birdtest.php',$data);
			}
			
		
		//End Username = admin
		}
		
		
		
		if($_GET['auth']=='myaccount'){
			$this->load->view('content_myaccount.php');
		}

		$this->load->view('footer_war.php');
	
	?>
		

<?php }else{
 $data['link'] = $_SERVER['REQUEST_URI'];
 $this->load->view('login',$data); } ?>
