<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
	} 
	
	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			return call_user_func_array(array($this, $method), $param);
		}else{
			display_404();
		}
	}

	private $page_name 		= 'Login';
	private $title 			= 'Please Login, First...';
	private $description 	= 'Welcome to Merry Riana Learning Centre';
	private $keywords 		= 'login, welcome visitor';
	public $credit 			= 'Andy Ajhis Ramadhan';

	public function index(){
		if(!$this->session->userdata('logged_in')){
			// $data['page_name'] = $this->page_name;
			// $data['title'] = $this->title;
			// $data['description'] = $this->description;
			// $data['keywords'] = $this->keywords;
			// $data['credit'] = $this->credit;
			$this->load->helper(array('form'));
			$this->load->view('login2');
		}else{
			redirect(base_url('dashboard'));
		}
	}

	public function verification_api()
    {
		$post = json_decode(file_get_contents('php://input'), true);
		
        $user = $this->db->select('user.*, departement, id_user_spv, signup_privilege, student_privilege, user.branch_id, ifnull(branch_lead_trainer, 0) as branch_leader')
		->join('divisi', 'user.id_divisi = divisi.id', 'left')
		->join('rc_branch', 'user.id = rc_branch.branch_lead_trainer', 'left')
		->where('username', $post['username'])
		->where('password', md5($post['password']))
		->where('status','aktif')
		->get('user');
		
        if($user){
            if($user->num_rows() > 0){
                $data['results'] = $user->row_array();
                $data['message'] = 'Berhasil Login';
                $data['status'] = 200;
            }else{
                $data['results'] = 'kosong';
                $data['message'] = 'Username atau password yang kamu masukkan salah';
                $data['status'] = 200;
            }
        }else{
            $data['results'] = [];
            $data['message'] = 'error';
            $data['status'] = 500;
        }

        echo json_encode($data);
    }
	
	public function verification(){
		$this->load->model('model_login');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		
		$length_pass = strlen($this->input->post('password'));
		if($length_pass >= 6){
		    $this->form_validation->set_rules('user', 'User', 'required|callback_check_username');
		}else{
		    $this->form_validation->set_message('min_length', '<div class="alert alert-info alert-danger"><a class="panel-close close" data-dismiss="alert" >×</a><i class="fa fa-exclamation-triangle"></i>	Sorry minimal Password 6 Character.</div>');
		}
		
		
 		// memeriksa rules berdasarkan callback check_username
		if($this->form_validation->run() == false){
			$this->index();
		}else{
 			// jika berhasil
 			//Attention for setup profile picture
 			$this->session->set_flashdata('ultah','yes');
			redirect(base_url('dashboard'));	
		}
        
	}
	
 	// callback check_username
	public function check_username(){
		$user = $this->input->post('user');
		$password = $this->input->post('password');
		$data = $this->model_login->login($user, $password)[0];
		
		if($data){
			$this ->session->set_userdata('id', $data->id);
			$this->session->set_userdata('email', $data->email);
			$this->session->set_userdata('username', $data->username);
			$this->session->set_userdata('birthday', $data->birthday);
			$this->session->set_userdata('name', $data->name);
			$this->session->set_userdata('picture', $data->picture);
			$this->session->set_userdata('anim', $data->anime);
			$this->session->set_userdata('signup_privilege', $data->signup_privilege);
			$this->session->set_userdata('student_privilege', $data->student_privilege);
			$this->session->set_userdata('logged_in', true);
			$this->session->set_userdata('level', $data->level);
			$this->session->set_userdata('iddivisi', $data->id_divisi);
			$this->session->set_userdata('divisi', $data->departement);
			$this->session->set_userdata('branch', $data->branch_id);
			$this->session->set_userdata('branch_leader', $data->branch_leader);
			if($data->id == $data->id_user_spv){
				$this->session->set_userdata('is_spv', true);
			}else{
				$this->session->set_userdata('is_spv', false);
			}
			
			$this->db->where('id_user',$data->id);
			$mgr = $this->db->get('manager')->row();
			if(!empty($mgr)){
				$this->session->set_userdata('is_mgr', true);
				$this->session->set_userdata('is_mgr_division', $mgr->detail_access_divisi);
			}else{
				$this->session->set_userdata('is_mgr', false);
				$this->session->set_userdata('is_mgr_division', false);
			}
			
			if(!empty($data->hr_access_divisi)){
				$this->session->set_userdata('is_hr', true);
				$this->session->set_userdata('is_hr_division', $data->hr_access_divisi);
			}else{
				$this->session->set_userdata('is_hr', false);
				$this->session->set_userdata('is_hr_division', false);
			}
			
			if(!empty($data->id_pt)){
				$this->session->set_userdata('is_pt', true);
				$this->session->set_userdata('is_id_pt', $data->id_pt);
			}else{
				$this->session->set_userdata('is_pt', false);
				$this->session->set_userdata('is_id_pt', false);
			}
			
			return true;
		}else{
			$this->form_validation->set_message('check_username','<div class="alert alert-info alert-danger"><a class="panel-close close" data-dismiss="alert" >×</a><i class="fa fa-exclamation-triangle"></i>	Your password or username is wrong.</div>');
			return false;
		}
		
		
	}


	
	public function send_changepasslink(){
	    //Email Notification he/her get cuti
	    
	    $email = secure($this->input->post('email'));
	    
	    $this->db->where('email',$email);
	    $query = $this->db->get('user');
	    
	    if($query->num_rows() == 1){
	        $encode = alphaID($query->row()->id);
	        
	        $to = $email;
    		$subject = 'Hallo '.$query->row()->username.' | Konfirmasi Ubah Password - MRG';
    		$body_html = '<p>Ini link untuk ubah password-nya <a href="'.base_url('login/changepass/'.$encode).'">KLIK DISINI</a> <br>atau copy link ini : '.base_url('login/changepass/'.$encode).'</p>';
    		$from = 'support@pediahost.com';
    		$fromName = 'Merry Riana Group';
    		$res = "";
    
    		$data = "username=".urlencode("andy@pediahost.com");
    		$data .= "&api_key=".urlencode("fb4317fa-0fde-46e4-8510-2d6cfabf6413");
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
	        
	    }else{
	        $this->session->set_flashdata('item','Email user tidak ditemukan!');
	        redirect(base_url('login'));
	    }
	    
	    $this->session->set_flashdata('item','Link confirmasi perubahan password sudah dikirim melalui email Anda!');
	    redirect(base_url('login'));
	    
	}
	
	public function changepass($encode){
	    $id = (alphaID($encode,true,7,'mrg37'));
	    
	    $this->db->where('id',$id);
	    $query = $this->db->get('user');
	    if($query->num_rows() == 1){
	        $data['id'] = $encode;
	        $this->load->view('reset_pass',$data);
	    }else{
	        redirect(base_url());
	    }
	    
	}
	
	
	public function resetpass(){
	    $post = $this->input->post();
	    $encode = secure($post['id']);
	    $np = secure($post['np']);
	    $cp = secure($post['cp']);
	    
	    $id = (alphaID($encode,true,7,'mrg37'));
	    $this->db->where('id',$id);
	    $query = $this->db->get('user');
	    if($query->num_rows() == 1){
	   
	        if($np == $cp){
	            
	            
	            $data = array(
                    'password' => md5($np)
                );
	            
	            $this->db->where('id',$id);
	            $result = $this->db->update('user',$data);
	            
	            if($result){
	                
	                $to = $query->row()->email;
            		$subject = 'Hallo '.$query->row()->username.' | Hak Akses Login - MRG';
            		$body_html = '<p>Berikut ini hak akses login Anda :<br> Username : '.$query->row()->username.'<br> Password : '.$np.'</p>';
            		$from = 'support@pediahost.com';
            		$fromName = 'Merry Riana Group';
            		$res = "";
            
            		$data = "username=".urlencode("andy@pediahost.com");
            		$data .= "&api_key=".urlencode("fb4317fa-0fde-46e4-8510-2d6cfabf6413");
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
	                
	                
	                $this->session->set_flashdata('item','Berhasil merubah password! Detail hak akses sudah dikirimkan melalui email.');
	                redirect(base_url('login'));
	            }
	            
	        }else{
	            $this->session->set_flashdata('item','Confirm password tidak sesuai dengan new password!');
	            redirect(base_url('login'));
	        }
	        
	    }else{
	        redirect(base_url());
	    }
	}
	
}