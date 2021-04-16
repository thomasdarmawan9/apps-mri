<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_dashboard');
		$this->load->model('model_login');
		$this->load->model('model_gallery');
		$this->load->model('model_student');
		$this->load->model('model_branch');
		$this->load->model('model_periode');
	}

	public function _remap($method, $param = array())
	{
		if (method_exists($this, $method)) {
			$level = $this->session->userdata('level');
			if (!empty($level)) {
				return call_user_func_array(array($this, $method), $param);
			} else {
				redirect(base_url('login'));
			}
		} else {
			display_404();
		}
	}


	public function index()
	{
		$data['inf']     		 = $this->model_dashboard->get_infomation();
		$data['list_schedule']   = $this->model_dashboard->get_list();
		$data['list_photo']      = $this->model_gallery->get_photo();
		$data['branch_leader']   = $this->model_dashboard->get_branch_leader();
		$data['student_active']  = $this->model_dashboard->get_student_active();
		$data['student_upgrade'] = $this->model_dashboard->get_student_upgrade();
		$data['student_grdsn']   = $this->model_dashboard->get_student_grdsn();
		// $data['student_do']      = $this->model_dashboard->get_student_do();
		// $data['student_grad']    = $this->model_dashboard->get_student_grad();

		// foreach($data)

		// dd($data['student_grad']);



		//CHART DASHBOARD MRLC

		$data['status'] 		= array("Active", "Need to upgrade", "Graduate soon", "Dropout", "Graduated");
		$data['regular'] 		= $this->model_periode->get_program();
		$data['adult'] 			= $this->model_periode->get_program_adult();
		$data['branch'] 		= $this->model_branch->get_active_branch();

		foreach ($data['status'] as $key => $val) {
			$data['all'][$key]['label'] 	= $val;
			$data['all'][$key]['value'] 	= $this->model_student->get_chart_status_student($val);
		}

		foreach ($data['branch'] as $key => $val) {
			foreach ($data['status'] as $key2 => $val2) {
				$data['branch_status'][$key]['name'] = $val['branch_name'];
				$data['branch_status'][$key]['data'][$key2]['label'] = $val2;
				$data['branch_status'][$key]['data'][$key2]['value'] = $this->model_student->get_chart_status_student($val2, $val['branch_id']);
			}
		}

		# Data Regular CLass
		foreach ($data['branch'] as $key => $val) {
			foreach ($data['regular'] as $key2 => $val2) {
				foreach ($data['status'] as $key3 => $val3) {
					$data['stat_regular'][$key2]['program_id'] = $val2['id'];
					$data['stat_regular'][$key2]['program'] = $val2['name'];
					$data['stat_regular'][$key2][$key]['name'] = $val['branch_name'];
					$data['stat_regular'][$key2][$key]['data'][$key3]['label'] = $val3;
					$data['stat_regular'][$key2][$key]['data'][$key3]['value'] = $this->model_student->get_chart_status_student($val3, $val['branch_id'], $val2['id'], 'regular');
				}
			}
		}

		# Data Adult Class
		foreach ($data['branch'] as $key => $val) {
			foreach ($data['adult'] as $key2 => $val2) {
				foreach ($data['status'] as $key3 => $val3) {
					$data['stat_adult'][$key2]['program_id'] = $val2['id'];
					$data['stat_adult'][$key2]['program'] = $val2['name'];
					$data['stat_adult'][$key2][$key]['name'] = $val['branch_name'];
					$data['stat_adult'][$key2][$key]['data'][$key3]['label'] = $val3;
					$data['stat_adult'][$key2][$key]['data'][$key3]['value'] = $this->model_student->get_chart_status_student($val3, $val['branch_id'], $val2['id'], 'adult');
				}
			}
		}

		// END DASHBOARD CHART MRLC

		set_active_menu('dashboard');
		init_view('admin/content_dashboard_admin', $data);
	}

	public function submit_information()
	{
		$post = $this->input->post();

		$id = $post['id'];
		unset($post['id']);
		$data = array(
			'information' => $post['infomation'],
			'id_user' => $this->session->userdata('id'),
			'date_created' => date('Y-m-d')
		);
		$result = $this->model_dashboard->edit_information($id, $data);


		if ($result) {
			flashdata('success', 'Berhasil Memperbarui Informasi!');
		} else {
			flashdata('error', 'Gagal Memperbarui Informasi!');
		}

		redirect(base_url('dashboard'));
	}

	function load()
	{
		$event_data = $this->model_dashboard->get_schedule();
		foreach ($event_data->result_array() as $row) {
			$total = $row['event'];
			$data[] = array(
				'id' => $row['id'],
				'title' => $total,
				'date' => $row['date_event'],
				// 'end' => $row['event_end']
			);
		}
		echo json_encode($data);
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
			'event_end'	=> $post['date_event'],
			'location' => $tempat,
			'type'		=> 'mrlc',
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

	public function list_on_update()
	{
		$date_update = $this->input->post('date');
		$response = $this->model_dashboard->get_list_schedule($date_update);
		echo json_encode($response);
	}

	public function delete_schedule($date)
	{
		dd($date);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
