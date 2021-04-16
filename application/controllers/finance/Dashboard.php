<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
		$this->load->model('model_finance');
	}

	public function _remap($method, $param = array()){
		if(method_exists($this, $method)){
			$level = $this->session->userdata('level');
			if(!empty($level) && $level == 'finance' || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72'){
				return call_user_func_array(array($this, $method), $param);
			}else{
				redirect(base_url('login'));				
			}
		}else{
			display_404();
		}
	}

	public function index()
	{
        $data['transaction'] = $this->model_finance->get_now_transaction();
		$data['last'] = $this->model_finance->get_last_transaction();
		$data['bank'] = $this->model_finance->get_dashboard_finance();
		set_active_menu('Dashboard Finance');
		init_view('finance/content_dashboard', $data);
	}
	
	public function dashboard_detail($id)
	{
		$data['transaction'] = $this->model_finance->get_my_transaction($id);
		$data['income'] = $this->model_finance->get_my_income($id);
		$data['expense'] = $this->model_finance->get_my_expense($id);
		$data['results'] = $this->model_finance->get_dashboard_detail($id);
		set_active_menu('Dashboard Detail');
		init_view('finance/content_dashboard_detail', $data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/finance/Dashboard.php */