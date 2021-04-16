<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Dashboard extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_dashboard');
		$this->load->model('model_login');
		$this->load->model('model_student');
		$this->load->model('model_branch');
		$this->load->model('model_periode');
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
		$data['inf']     		 = $this->model_dashboard->get_infomation();
		$data['list_schedule']   = $this->model_dashboard->get_list();
		$data['branch_leader']   = $this->model_dashboard->get_branch_leader();
		$data['student_active']  = $this->model_dashboard->get_student_active();
		$data['student_upgrade'] = $this->model_dashboard->get_student_upgrade();
		$data['student_grdsn']   = $this->model_dashboard->get_student_grdsn();
		// $data['student_do']      = $this->model_dashboard->get_student_do();
		// $data['student_grad']    = $this->model_dashboard->get_student_grad();

		// foreach($data)

		// dd($data['student_grad']);

		set_active_menu('dashboard');
		init_view('content_dashboard', $data);
	}

	public function submit_schedule()
	{
		$post = $this->input->post();
		$location = $post['location'];
		$lokasi = $post['lokasi'];
		if ($lokasi == 'others') {
			$tempat = $location;
		} else {
			$tempat = $lokasi;
		}
		$data_event = array(
			'id_user'	=> $this->session->userdata('id'),
			'id_divisi'  => $this->session->userdata('iddivisi'),
			'event' => $post['event'],
			'date_event' => $post['date_event'],
			'location' => $tempat,
			// 'type'		=> 'mrlc',
			'is_confirm' => '-',
			'date_created' => date('Y-m-d')
		);


		# insert statement
		$result = $this->model_dashboard->insert_event($data_event);

		if ($result) {
			flashdata('success', 'Berhasil menambahkan jadwal');
		} else {
			flashdata('error', 'Gagal menambahkan jadwal');
		}

		redirect(base_url('dashboard'));
	}


	public function export(){
		if($this->session->userdata('level') == 'admin'){
	        $data = $this->model_dashboard->get_data_dashboard_admin();
	        $filename = 'Laporan All - '.date('Y-m-d');
	       	exportToExcel($data, 'Sheet 1', $filename);
        }else if($this->session->userdata('level') == 'hr'){
        	$data = $this->model_dashboard->get_data_dashboard_admin();
	        $filename = 'Laporan All - '.date('Y-m-d');
	       	exportToExcel($data, 'Sheet 1', $filename);
        }else{
        	display_404();
        }
	}
	
	
	
	/*          ~ New Function TO DO LIST (Fiqi) ~            */
	public function todolist()
	{
		$data['all_user'] = $this->model_dashboard->get_all_user();
		$data['todo_app'] = $this->model_dashboard->get_todo();
		set_active_menu('To Do List');
		init_view('user/content_mylist',$data);
	}

	public function json_get_todo_detail()
	{
		$id 		= $this->input->post('id');
		$response 	= $this->model_dashboard->get_todo_detail($id);
		echo json_encode($response);
	}

	public function submit_todo_dash()
	{

		$data_user = array(
			'id_user' => $this->session->userdata('id'),
			'to_id' => 0,
			'id_divisi' => $this->session->userdata('iddivisi'),
			'description' => $this->input->post('description'),
			'status_todo' => 0,
			'type' => 'me',
			'date' => date('Y-m-d')
		);

		$result_user = $this->model_dashboard->insert_newtodo_user($data_user);
		if ($result_user) {
			flashdata('success', 'Berhasil menambahkan data');
		}else{
			flashdata('error', 'Gagal menambahkan data');
		}
		redirect(base_url('dashboard'));
	}

	public function tofinish_todo()
	{
		$id = $this->input->post('id');
		// var_dump($id);
		$results = $this->model_dashboard->finish_todo($id);

		if ($results) {
			flashdata('success', 'Berhasil');
		} else {
			flashdata('error', 'Gagal.');
		}
		echo json_encode($results);
	}
	
	public function todelete_todo()
	{
		$id = $this->input->post('id');
		$results = $this->model_dashboard->delete_todo($id);

		if ($results) {
			flashdata('success', 'Berhasil');
		} else {
			flashdata('error', 'Gagal.');
		}
		echo json_encode($results);
	}
	
	/*                         New Function TO DO LIST (Fiqi)                          */
	

}