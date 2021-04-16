<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_product extends CI_Model {

	public function contruct(){
		parent::__construct();
	}
	
	public function get_temporary_product($id){
	    $this->db->where('id_product_form',$id);
	    $kode_form = $this->db->get('product_form')->row()->kode_form;
	    
	    $this->db->where('kode_form',$kode_form);
	    return $this->db->get('temporary_product')->result();
	}
	
	public function get_product(){
	    $query = $this->db->get('product');
		
		if($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return false;
		}
	}
	
	public function add_temporary($formid,$result){
	    $this->db->delete('temporary_product', array('kode_form' => $formid));
	    return $this->db->insert_batch('temporary_product',$result);
	}
	
	public function push_event_request($id){
	    $this->db->from('product_form');
	    $this->db->join('user','user.id = product_form.id_user');
	    $this->db->where('id_product_form',$id);
	    return $this->db->get()->row();
	}
	
	public function update_product_form($id, $kode, $id_user, $event, $date, $jmh_peserta, $remark){
	    
	    $this->db->where('id_product_form',$id);
	    $this->db->where('kode_form',$kode);
	    $count = $this->db->get('product_form')->num_rows();
	    
	    if($count <> 1){
	        
	        $this->db->where('kode_form',$kode);
	        $checkavailable = $this->db->get('product_form')->num_rows();
	        
	        if(empty($checkavailable)){
	        
    	        //Get value Kode Form Before Update
        	    $this->db->where('id_product_form',$id);
        	    $kode_form = $this->db->get('product_form')->row()->kode_form;
        	    
        	    //And Than make update for tabel log product
        	    $datalog = array ( 'kode_form' => $kode );
        	    $this->db->where('kode_form', $kode_form);
        	    $this->db->update('log_product',$datalog);
        	    
        	    //And Than make update for tabel temporary_product
        	    $this->db->where('kode_form', $kode_form);
        	    $this->db->update('temporary_product',$datalog);
        	    
        	    //For The Last We Change tabel Product Form
        	    $data = array(
        	            'kode_form' => $kode,
        	            'id_user' => $id_user,
        	            'event' => $event,
        	            'event_date' => $date,
        	            'jumlah_peserta' => $jmh_peserta,
        	            'remark' => $remark
        	    );
        	        
                $this->db->where('id_product_form', $id);
                return $this->db->update('product_form',$data);
        	
	        }else{
	            return false;
	        }
	    }else{
	        //For The Last We Change tabel Product Form
    	    $data = array(
    	            'kode_form' => $kode,
    	            'id_user' => $id_user,
    	            'event' => $event,
    	            'event_date' => $date,
    	            'jumlah_peserta' => $jmh_peserta,
    	            'remark' => $remark
    	    );
    	        
            $this->db->where('id_product_form', $id);
            return $this->db->update('product_form',$data);
	    }
	    
	    
	}
	
	public function push_data_product_form($id){
	    $this->db->from('product_form');
	    $this->db->join('user','user.id = product_form.id_user');
	    $this->db->where('id_product_form',$id);
	    return $this->db->get()->row_array();
	}
	
	public function add_event_product_request($kode,$id_user,$event,$event_date,$jmh_peserta,$remark){
	    
	    date_default_timezone_set('Asia/Jakarta');
	    
	    $this->db->where('kode_form',$kode);
	    $check = $this->db->get('product_form')->num_rows();
	    
	    if(empty($check)){
	        
    	    $data = array(
    	            'kode_form' => $kode,
    	            'id_user' => $id_user,
    	            'event' => $event,
    	            'event_date' => $event_date,
    	            'jumlah_peserta' => $jmh_peserta,
    	            'remark' => $remark,
    	            'timestamp' => date('Y-m-d H:i:s')
    	        );
    	        
    	   return $this->db->insert('product_form',$data);
	   
	    }else{
	        return false;
	    }
	    
	}
	
	public function delete_event_product_request($id_product_form){
	    
	    //Get Kode Form
	    $this->db->where('id_product_form',$id_product_form);
	    $kode_form = $this->db->get('product_form')->row()->kode_form;
	    
	    //Delete kode_form dari tabel log_product
	    $this->db->where('kode_form',$kode_form);
	    $this->db->delete('log_product');
	    
	    //Delete id_product_form dari tabel product_form
	    $this->db->where('id_product_form',$id_product_form);
	    return $this->db->delete('product_form');
	    
	}
	
	public function get_event_product_request(){
	    $this->db->from('product_form');
	    $this->db->join('user','user.id = product_form.id_user');
	    
	    $this->db->order_by('timestamp','desc');
	    return $this->db->get()->result();
	}
	
	public function get_product_request(){
	    $this->db->select('product.id_product, log_product.id_product, log_product.id_log_product, product.picture ,username, nama_product, log_product.timestamp, log_product.id_user, qty, log_product.status, log_product.remark');
	    $this->db->from('product');
	    $this->db->join('log_product','product.id_product = log_product.id_product');
	    $this->db->join('user','user.id = log_product.id_user');
	    $this->db->where('log_product.status','out');
	    $this->db->where('is_approve is NULL AND is_reject is NULL');
	    $query = $this->db->get();
		
		if($query->num_rows() > 0){
		    return $query->result();
		}else{
		    return false;
		}
	}
	
	public function get_my_request(){
	    $this->db->select('product.id_product, product.nama_product, product.picture, log_product.id_log_product, log_product.id_product, log_product.id_user, log_product.qty, log_product.status, log_product.is_approve, log_product.is_reject, log_product.action_logistic, log_product.remark, log_product.timestamp, user.id, user.username');
	    $this->db->from('product');
	    $this->db->join('log_product','product.id_product = log_product.id_product');
	    $this->db->join('user','log_product.id_user = user.id');
	    $this->db->where('log_product.id_user',$this->session->userdata('id'));
	    
	    $date_start = date('Y-m-d', strtotime("-7 days"));
		$date_end = date('Y-m-d', strtotime("+1 days"));
		
		$where = '(action_logistic is NULL) OR (action_logistic BETWEEN "'.$date_start.'" AND  "'.$date_end.'")' ;
        $this->db->where($where);

	    return $query = $this->db->get()->result();
	}
	
	public function push_data($id){
	    $this->db->where('id_product',$id);
	    return $this->db->get('product')->row_array();
	}
	

	public function add_product($name, $price, $photo, $stock, $remark){
	    date_default_timezone_set('Asia/Jakarta');
	    $data = array(
	                'nama_product' => $name,
	                'price' => $price,
	                'picture'   => $photo,
	                'stok'  => $stock,
	                'remark' => $remark,
	                'timestamp' => date('Y-m-d H:i:s')
	            );
	   
		$this->db->insert('product', $data);
		
		$last_id = $this->db->insert_id();
		
		$data = array(
	                'id_product' => $last_id,
    	            'id_user' => $this->session->userdata('id'),
    	            'price_on_date' => $price,
    	            'qty' => $stock,
    	            'status' => 'in',
    	            'remark' => $remark,
    	            'timestamp' => date('Y-m-d H:i:s')
	            );
	   
		return $this->db->insert('log_product', $data);
	}
	
	public function update_product($id, $name, $price, $photo, $remark){
	    date_default_timezone_set('Asia/Jakarta');
	    if(!empty($photo)){
	        
	        $this->db->where('id_product',$id);
	        $r = $this->db->get('product')->row()->picture;
	        
	        if(!empty($r)){
	            unlink('inc/image/product/'.$r);
	            unlink('inc/image/product/thumb/'.$r);
	        }
	        
	        $data = array(
        	            'nama_product' => $name,
        	            'price' => $price,
        	            'picture' => $photo,
        	            'remark' => $remark,
        	            'timestamp' => date('Y-m-d H:i:s')
	               );
	       
	       $this->db->where('id_product',$id);     
	       return $this->db->update('product',$data);
	    }else{
	        $data = array(
        	            'nama_product' => $name,
        	            'price' => $price,
        	            'remark' => $remark,
        	            'timestamp' => date('Y-m-d H:i:s')
	               );
	       
	       $this->db->where('id_product',$id);     
	       return $this->db->update('product',$data);
	    }
	}
	
	public function add_stok_product($id, $qty, $remark){
	    date_default_timezone_set('Asia/Jakarta');
	    $this->db->where('id_product',$id);
	    $qty_update = ($this->db->get('product')->row()->stok) + $qty;
	    
	    $dt = array ('stok' => $qty_update);
	    $this->db->where('id_product',$id);
	    $this->db->update('product',$dt);
	    
	    $data = array(
	            'id_product' => $id,
	            'id_user' => $this->session->userdata('id'),
	            'qty' => $qty,
	            'status' => 'in',
	            'remark' => $remark,
	            'timestamp' => date('Y-m-d H:i:s')
	        );
	   
	   return $this->db->insert('log_product', $data);
	}
	
	public function delete_product($id){
	    
	    $this->db->where('id_product',$id);
	    $r = $this->db->get('product')->row()->picture;
	    
	    if(!empty($r)){
	        unlink('inc/image/product/'.$r);
	        unlink('inc/image/product/thumb/'.$r);
	    }
	    
	    $this->db->where('id_product',$id);
	    $this->db->delete('product');
	    
	    $this->db->where('id_product',$id);
	    return $this->db->delete('log_product');
	}
	
	public function push_data_history($id){
	    $this->db->select('product.id_product, log_product.id_product, username, nama_product, log_product.timestamp, log_product.id_user, qty, log_product.status, log_product.is_approve, log_product.remark');
	    $this->db->from('log_product');
	    $this->db->join('product','product.id_product = log_product.id_product');
	    $this->db->join('user','user.id = log_product.id_user');
	    $this->db->where('log_product.id_product',$id);
	    
	    /*$where = 'log_product.is_approve is null or log_product.is_approve = 0';
	    $this->db->where($where);*/
	    $query = $this->db->get();
	    
	    return $query->result();
	}
	
	
	public function approve_request($id){
	    date_default_timezone_set('Asia/Jakarta');
	    $this->db->where('id_log_product',$id);
	    $query1 = $this->db->get('log_product');
	    
	    foreach ($query1->result() as $r1){
	        $id_product = $r1->id_product;
	        $qty_out = $r1->qty;
	    }
	    
	    $this->db->where('id_product',$id_product);
	    $query2 = $this->db->get('product');
	    
	    foreach ($query2->result() as $r2){
	        $qty_stok = $r2->stok;
	    }
	    
	    $stok = $qty_stok - $qty_out;
	    
	    if($stok > -1){
    	    $dt = array ('stok' => $stok);
    	    
    	    $this->db->where('id_product',$id_product);
    	    $this->db->update('product',$dt);
    	    
    	    
    	    $data = array ( 'is_approve' => 1, 'action_logistic' => date('Y-m-d H:i:s'));
    	    $this->db->where('id_log_product',$id);
    	    $this->db->update('log_product',$data);
    	    return 'berhasil';
	    }else{
	        return $qty_stok;
	    }
	}
	
	public function reject_request($id){
	    date_default_timezone_set('Asia/Jakarta');
	    
	    $this->db->where('id_log_product',$id);
	    $data = array( 'is_reject' => 1, 'action_logistic' => date('Y-m-d H:i:s'));
	    return $this->db->update('log_product',$data);
	}
	
	
	public function add_request($id, $qty, $remark){
	    $this->db->where('id_product',$id);
	    $qty_stok = $this->db->get('product')->row()->stok;
	    
	    if($qty_stok >= $qty){
	        $data = array( 'id_product' => $id, 'id_user' => $this->session->userdata('id'), 'qty' => $qty, 'status' => 'out', 'remark' => $remark ,'timestamp' => date('Y-m-d H:i:s'));
	        return $this->db->insert('log_product',$data);
	    }else{
	        return false;
	    }
	}
	
	public function cancel_request($id){
	    $this->db->where('id_log_product',$id);
	    return $this->db->delete('log_product');
	}


}