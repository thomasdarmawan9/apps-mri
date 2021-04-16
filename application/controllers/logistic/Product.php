<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Product extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
		$this->load->model('model_incentive');
		$this->load->model('model_product');
	}
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && $level == 'logistic'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index(){
		$data['results'] = $this->model_product->get_product();
		set_active_menu('Product');
		init_view('logistic/content_product', $data);
	}
	
	
	public function send_proccess(){
	    $post= $this->input->post();
	    
	    $this->db->delete('log_product', array('kode_form' => $post['kode_form']));
	    $this->db->delete('temporary_product', array('kode_form' => $post['kode_form']));
	    
	    
	    
	    //Membuat zona waktu jakarta indonesia
	    date_default_timezone_set("Asia/Jakarta");
	    
	    for($i=0;$i < count($post['request']); $i++){
	        //Membuat variable in dan out
	        $in = 0;$out = 0;
	        
	        //Melakukan Insert pada data temporary
	        $temporary['kode_form'] = $post['kode_form'];
	        $temporary['id_product'] = $post['request'][$i];
	        $temporary['in'] = $post['in'][$i];
	        $temporary['out'] = $post['out'][$i];
	        $temporary['timestamp'] = date('Y-m-d H:i:s');
	        $this->db->insert('temporary_product',$temporary);
	        
	        
	        $data['id_user'] = $post['userid'];
	        $data['id_product'] = $post['request'][$i];
	        $data['kode_form'] = $post['kode_form'];
	        $data['remark'] = 'By Form Request '.'('.$post['kode_form'].')';
	        $data['timestamp'] = date('Y-m-d H:i:s');
	        
	        
	        //Insert data Out
	        $data['qty'] = $post['out'][$i];
	        $data['status'] = 'out';
	        $data['is_approve'] = 1;
	        
	        $out = $out + $post['out'][$i];
	        
	        $this->db->insert('log_product', $data);
	        
	        
	        //Insert data In
	        $data['qty'] = $post['in'][$i];
	        $data['status'] = 'in';
	        $data['is_approve'] = null;
	        
	        $in = $in + $post['in'][$i];
	        
	        $this->db->insert('log_product', $data);
	        
	        
	        //Mencari selisih
    	    $difference = $in - $out;
    	    $this->db->where('id_product',$post['request'][$i]);
    	    $stok = $this->db->get('product')->row()->stok;
    	    
    	    //Menghitung hasil akhir
    	    $total = $stok + $difference;
    	    
    	    //Melakukan update Stok
    	    $updatestok = array(
    	            'stok' => $total,
    	    );
    	    
    	    $this->db->where('id_product',$post['request'][$i]);
	        $this->db->update('product',$updatestok);
	    }
	    
	    
	    
	    //Menonaktifkan form
	    $nonaktif = array(
                'is_done' => 1,
        );
        
	    $this->db->where('kode_form',$post['kode_form']);
	    $this->db->update('product_form',$nonaktif);
	    
	    flashdata('success','Data berhasil diproses');
	}
	
	public function add_temporary(){
	    $formid = $this->input->post('formid');
	    $merchendise = $this->input->post('request[]');
	    $out = $this->input->post('out[]');
	    $in = $this->input->post('in[]');
	    
	    $result = array();
        foreach($merchendise AS $key => $val){
            $result[] = array(
                'kode_form' => $formid,
                'id_product' => $_POST['request'][$key],
                'out' => $_POST['out'][$key],
                'in' => $_POST['in'][$key],
                'timestamp' => date('Y-m-d H:i:s')
            );
        }
        
        $result = $this->model_product->add_temporary($formid,$result);
        
        if($result){
	        flashdata('success', 'Berhasil menambahkan list form temporary');  
	    }else{
	        flashdata('error', 'Gagal menambahkan list form temporary');  
	    }
	    
	    redirect(base_url("logistic/product/event_request"),'refresh');
	}
	
	public function event_request(){
	    $data['sales'] = $this->model_login->getusername();
	    $data['listEvent'] = $this->model_incentive->get_all_incentive_list();
	    $data['results'] = $this->model_product->get_event_product_request();
		set_active_menu('Event Request');
		init_view('logistic/content_product_event_request', $data);
	}
	
	public function request(){
	    $data['results'] = $this->model_product->get_product_request();
		set_active_menu('List Request');
		init_view('logistic/content_product_request', $data);
	}
	
	public function get_json_product(){
	    $result = $this->model_product->get_product();
	    echo json_encode($result);
	}
	
	public function push_event_request(){
	    $id = secure($this->input->post('id'));
	    $result['event'] = $this->model_product->push_event_request($id);
	    $result['detail'] = $this->model_product->get_temporary_product($id);
	    $result['product'] = $this->model_product->get_product();
	    echo json_encode($result);
	}
	
	public function update_product_form(){
	    $id = secure($this->input->post('id'));
	    $kode = secure($this->input->post('kode'));
	    $id_user = secure($this->input->post('sales'));
	    $event = secure($this->input->post('event'));
	    $date = secure($this->input->post('date'));
	    $jmh_peserta = secure($this->input->post('jmh_peserta'));
	    $remark = secure($this->input->post('remark'));
	    
	    $result = $this->model_product->update_product_form($id, $kode, $id_user, $event, $date, $jmh_peserta, $remark);
	    
	    if($result){
	        flashdata('success', 'Berhasil meng-update list form');
	    }else{
	        flashdata('error', 'Mohon maaf proses update terjadi kesalahan, tolong pastikan kode form belum pernah dipakai oleh form lain!');  
	    }
	    
	    redirect(base_url("logistic/product/event_request"),'refresh');
	}
	
	public function add_event_product_request(){
	    $kode = secure($this->input->post('kode'));
	    $id_user = secure($this->input->post('sales'));
	    $event = secure($this->input->post('event'));
	    $event_date = secure($this->input->post('date'));
	    $jmh_peserta = secure($this->input->post('jmh_peserta'));
	    $remark = secure($this->input->post('remark'));
	    
	    $result = $this->model_product->add_event_product_request($kode,$id_user,$event,$event_date,$jmh_peserta,$remark);
	    
	    if($result){
	        flashdata('success', 'Berhasil menambah list form');  
	    }else{
	        flashdata('error', 'Gagal menambah list form mohon pastikan kode belum pernah di input');  
	    }
	    
	    redirect(base_url("logistic/product/event_request"),'refresh');
	}
	
	public function delete_event_product_request(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->delete_event_product_request($id);
	    
	    if($result){
	        flashdata('success', 'Berhasil hapus product');  
	    }else{
	        flashdata('error', 'Gagal hapus product');  
	    }
	    
	    echo json_encode($result);
	}
	
	public function delete_product(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->delete_product($id);
	    
	    if($result){
	        flashdata('success', 'Berhasil hapus product');  
	    }else{
	        flashdata('error', 'Gagal hapus product');  
	    }
	    echo json_encode($result);
	}
	
	public function add_product(){
	    
	    //Photo Image
		$config['upload_path']          = './inc/image/product';
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
			$config['source_image']		='./inc/image/product/'.$gbr['file_name'];
			$config['create_thumb']		= FALSE;
			$config['maintain_ratio']	= FALSE;
			
			$config['width']		= $thumb_size;
			$config['height']		= $thumb_size;		
			$config['new_image']		= './inc/image/product/thumb/'.$gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->initialize($config);
			$this->image_lib->crop();
			
			//name image
			$imgprimary = $gbr['raw_name'];
			$imgtype = $gbr['file_ext'];
	                
	                $photo = $imgprimary.$imgtype;
	                $this->image_lib->clear();
	                
	   }
	         
	   //End photo Image
	   
	   
	    $name = secure($this->input->post('name'));
	    $price = secure($this->input->post('price'));
	    $stock = secure($this->input->post('stock'));
	    $remark = secure($this->input->post('remark'));
	    
	    $result = $this->model_product->add_product($name, $price, $photo, $stock, $remark);
	    
	    if($result){
	        flashdata('success', 'Berhasil menambah produk');  
	    }else{
	        flashdata('error', 'Gagal menambah produk');  
	    }
	    
	    redirect(base_url("logistic/product"),'refresh');
	    
	}
	
	
	public function update_product(){
	    
	    //Photo Image
		$config['upload_path']          = './inc/image/product';
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
			$config['source_image']		='./inc/image/product/'.$gbr['file_name'];
			$config['create_thumb']		= FALSE;
			$config['maintain_ratio']	= FALSE;
			
			$config['width']		= $thumb_size;
			$config['height']		= $thumb_size;		
			$config['new_image']		= './inc/image/product/thumb/'.$gbr['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->initialize($config);
			$this->image_lib->crop();
			
			//name image
			$imgprimary = $gbr['raw_name'];
			$imgtype = $gbr['file_ext'];
	                
	                $photo = $imgprimary.$imgtype;
	                $this->image_lib->clear();
	                
	   }
	         
	   //End photo Image
	   
	    $id = secure($this->input->post('id'));
	    $name = secure($this->input->post('name'));
	    $price = secure($this->input->post('price'));
	    $remark = secure($this->input->post('remark'));
	    
	    $result = $this->model_product->update_product($id, $name, $price, $photo, $remark);
	    
	    if($result){
	        flashdata('success', 'Berhasil meng-update produk');  
	    }else{
	        flashdata('error', 'Gagal meng-update produk');  
	    }
	    
	    redirect(base_url("logistic/product"),'refresh');
	    
	    
	}
	
	public function add_stok_product(){
	    $id = secure($this->input->post('id'));
	    $qty = secure($this->input->post('qty'));
	    $remark = secure($this->input->post('remark'));
	    $result = $this->model_product->add_stok_product($id, $qty, $remark);
	    
	    if($result){
	        flashdata('success', 'Berhasil stok telah ditambahkan');  
	    }else{
	        flashdata('error', 'Gagal menambah stok produk');  
	    }
	    
	    redirect(base_url("logistic/product"),'refresh');
	}
	
	public function push_data(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->push_data($id);
		echo json_encode($result);
	}
	
	public function push_data_product_form(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->push_data_product_form($id);
		echo json_encode($result);
	}
	
	public function push_data_history(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->push_data_history($id);
		echo json_encode($result);
	}
	
	
	public function approve_request(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->approve_request($id);
	    
	    if($result == 'berhasil'){
	        flashdata('success', 'Berhasil mengurangi stok dari permintaan');  
	    }else{
	        flashdata('error', 'Maaf Stok tidak cukup! Hanya tersisa : '.$result);  
	    }
	    
	    echo json_encode($result);
	}
	
	public function reject_request(){
	    $id = secure($this->input->post('id'));
	    $result = $this->model_product->reject_request($id);
	    
	    if($result){
	        flashdata('success', 'Berhasil melakukan reject permintaan');  
	    }else{
	        flashdata('error', 'Maaf gagal melakukan reject');  
	    }
	    
	    echo json_encode($result);
	}

}