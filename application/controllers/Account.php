<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Account extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
		$this->load->library('upload');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level)){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
	    $id_user = $this->session->userdata('id');
	    
	    $this->db->where('id',$id_user);
	    $data['my'] = $this->db->get('user')->row();
		set_active_menu('My Account');
		init_view('content_myaccount', $data);
	}

	public function change_pass(){
	    
	    
	    //Photo Image
		$config['upload_path']          = './inc/image/warriors';
		$config['allowed_types']        = 'gif|jpg|jpeg|png|JPG|JPEG|PNG';
		$config['max_size']             = 5120;
		$config['encrypt_name'] 	= TRUE;
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload('photo')){
			$photo = "";
			$msg_photo = $this->upload->display_errors();
		}else{
			
	                $gbr = $this->upload->data();
	                
	                
	                //Intinya mencari tengah
	                //Search Height
	                $thum_width_size = $gbr['image_width'];
	                $thum_height_size = $gbr['image_height'];
	                
	                
	                //crop berdasaran height atau width yang kecil maka dipilih
	                if( $thum_width_size > $thum_height_size)
	                {
	                	$thumb_size = $thum_height_size;
	                	
	                	//Untuk mendapatkan posisi tengah jika width lebih besar
		                $thum_center = $thum_width_size / 2;
		                $thum_get_crop = $thumb_size / 2;
		                $crop = $thum_center - $thum_get_crop;
		                $config['x_axis']= $crop;
		                
	                }else{
	                	$thumb_size = $thum_width_size;
	                	
	                	//Untuk mendapatkan posisi tengah jika height lebih besar
		                $thum_center = $thum_height_size / 2;
		                $thum_get_crop = $thumb_size / 2;
		                $crop = $thum_center - $thum_get_crop;
		                $config['y_axis']= $crop;
		                
	                }
	                
	                
	                //Intinya kompress size
	                $large_file = $gbr['file_size'];
	                
	                if($large_file > 4000){
	                	 $config['quality']		= '1.875%';
	                }elseif($large_file > 3000){
	                	 $config['quality']		= '2.5%';
	                }elseif($large_file > 2000){
	                	 $config['quality']		= '3.75%';
	                }elseif($large_file > 1000){
	                	 $config['quality']		= '5%';
	                }elseif($large_file > 1000){
	                	$config['quality']		= '10%';
	                }elseif($large_file > 500){
	                	$config['quality']		= '15%';
	                }elseif($large_file > 300){
	                	$config['quality']		= '12%';
	                }elseif($large_file > 200){
	                	$config['quality']		= '15%';
	                }elseif($large_file > 100){
	                	$config['quality']		= '50%';
	                }else{
	                	$config['quality']		= '95%';
	                }
	                                
	
	                
			//Compress Image
			$config['image_library']	='gd2';
			$config['source_image']		='./inc/image/warriors/'.$gbr['file_name'];
			$config['create_thumb']		= FALSE;
			$config['maintain_ratio']	= FALSE;
			
			$config['width']		= $thumb_size;
			$config['height']		= $thumb_size;		
			$config['new_image']		= './inc/image/warriors/pp/'.$gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->initialize($config);
			$this->image_lib->crop();
			
			//name image
			$imgprimary = $gbr['raw_name'];
			$imgtype = $gbr['file_ext'];
	                
	                $photo = $imgprimary.$imgtype;
	                $this->session->set_userdata('picture', $photo);
	                
	                $this->image_lib->clear();
	                
	   }
	         
	   //End photo Image
	        
	    $lp = $this->input->post('lp');
	    $np = $this->input->post('np');
    	$cp = $this->input->post('cp');
	    
	    if(!empty($lp) && (!empty($np) && (!empty($cp)))){
    		$results = $this->model_login->cek_next_pass($lp);
    		
    		if($results){
    			
    			if (strlen($np)>5){
    
    				if($np == $cp){
    					$result = $this->model_login->change_pass($np);
    					
    					if(!empty($photo)){
    					    $result = $this->model_login->change_photo($photo);
    					    flashdata('success','Password & Foto Kamu sekarang telah diubah');
    					}else{
    					    flashdata('success','Password Kamu sekarang telah diubah');
    					}
    					
    
    				}else{
    					flashdata('error','Gagal! Pastikan password baru lebih dari 5 karakter , pastikan password yang lalu sudah diisi dengan benar dan pastikan konfirmasi password sama dengan password baru');
    				}
    
    			}else{
    				flashdata('error','Gagal! Pastikan password baru lebih dari 5 karakter , pastikan password yang lalu sudah diisi dengan benar dan pastikan konfirmasi password sama dengan password baru');
    			}
    			
    		}else{
    			flashdata('error','Gagal! Pastikan password baru lebih dari 5 karakter , pastikan password yang lalu sudah diisi dengan benar dan pastikan konfirmasi password sama dengan password baru');
    		}
	    }else{
	        if(!empty($photo)){
	            $result = $this->model_login->change_photo($photo);
			    flashdata('success','Foto Kamu sekarang telah diubah');
			}
	    }
	    
	    if(empty($lp) && (empty($np) && (empty($cp) && (empty($photo))))){
	        $msg_photo = str_replace("<p>","",$msg_photo);
	        $msg_photo = str_replace("</p>","",$msg_photo);
	        flashdata('error',$msg_photo.' or sets password still null');
	    }
    	
    	
    	redirect(base_url('account'));
	}
	
	public function personal_data(){
	    $post = $this->input->post();
	    
	    $data = array(
	      'birthday' => secure($post['tanggallahir']),
	      'nama_lengkap' => secure($post['namalengkap']),
	      'tempat_lahir' => secure($post['kotalahir']),
	      'no_ktp' => secure($post['ktp']),
	      'no_npwp' => secure($post['npwp']),
	      'no_kk' => secure($post['kk']),
	      'email_pribadi' => secure($post['emailpribadi']),
	      'jenis_kelamin' => secure($post['jeniskelamin']),
	      'status_diri' => secure($post['statusdiri']),
	      'agama' => secure($post['agama']),
	      'alamat_tinggal' => secure($post['alamattinggal']),
	      'alamat_asal' => secure($post['alamatasal']),
	      'universitas' => secure($post['universitas']),
	      'telp_rumah' => secure($post['telprumah']),
	      'nama_ayah' => secure($post['namaayah']),
	      'no_hp_ayah' => secure($post['telpayah']),
	      'nama_ibu' => secure($post['namaibu']),
	      'no_hp_ibu' => secure($post['telpibu']),
	      'nama_saudara' => secure($post['namasaudara']),
	      'no_hp_saudara' => secure($post['telpsaudara']),
	      'hubungan_keluarga' => secure($post['hubungankeluarga']),
	      'nama_org_terdekat' => secure($post['namaorgterdekat']),
	      'alamat_org_terdekat' => secure($post['alamatorgterdekat']),
	      'hubungan_org_terdekat' => secure($post['hubunganorgterdekat']),
	      'no_hp_org_terdekat' => secure($post['telporgterdekat']),
	    );
	    
	    $this->db->where('id',$this->session->userdata('id'));
	    $result = $this->db->update('user',$data);
	    
	    if($result){
	        flashdata('success','Berhasil ubah data diri');
	    }else{
	        flashdata('error','Gagal ubah data diri');
	    }
	    
	    redirect(base_url('account'));
	    
	}


}