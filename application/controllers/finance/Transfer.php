<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transfer extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_login');
		$this->load->model('model_finance');
	}


	public function _remap($method, $param = array())
	{
		if (method_exists($this, $method)) {
			$level = $this->session->userdata('level');
			if (!empty($level) && $level == 'finance' || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72') {
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
		$data['lock'] = $this->model_finance->get_lock_transaction();
		$data['results'] = $this->model_finance->get_transfer();
		$data['pt'] = $this->model_login->get_pt();
		$data['bank_detail'] = $this->model_login->get_bank();
		$data['bank'] = $this->model_login->get_detail_bank();
		$data['indeks'] = $this->model_login->get_indeks();
		$data['divisi'] = $this->model_login->get_fc_divisi();
		set_active_menu('Transfer History');
		init_view('finance/content_list_transfer', $data);
	}

	function get_autocomplete_bank_from()
	{
	    $this->load->model('model_finance');
		$bank_from 	= $this->input->post('bank_from');
		$response 	= $this->model_finance->get_list_bank_from($bank_from);
		echo json_encode($response);
	}

	function get_autocomplete_bank_to()
	{
	    $this->load->model('model_finance');
		$bank_to 	= $this->input->post('bank_to');
		$response 	= $this->model_finance->get_list_bank_to($bank_to);
		echo json_encode($response);
	}


	public function submit_form_transfer()
	{
		$data_expense = array(
			'id_bank'  	 	 => $this->input->post('bank_from'),
			'id_pt'  	 	 => $this->input->post('pt_name'),
			'id_user' 	 	 => $this->session->userdata('id'),
			'is_transfer' 	 => '1',
			'transfer_code'  => $this->model_finance->automation_code(),
			'tgl_nota'		 => $this->input->post('tgl_nota'),
			'bon'			 => 'y-writen',
			'jenis' 	 	 => 'expense',
			'transaksi'    	 => $this->input->post('description'),
			'jumlah'		 => '1',
			'harga'		 	 => $this->input->post('amount'),
			'expense'		 => $this->input->post('amount'),
			'income'		 => '0',
			'date_created' 	 => date('Y-m-d H:i:s'),
		);

		$data_income = array(
			'id_bank'  	 	 => $this->input->post('bank_to'),
			'id_pt'  	 	 => $this->input->post('id_pt'),
			'id_user' 	 	 => $this->session->userdata('id'),
			'is_transfer' 	 => '1',
			'transfer_code'  => $this->model_finance->automation_code(),
			'tgl_nota'		 => $this->input->post('tgl_nota'),
			'bon'			 => 'y-writen',
			'jenis' 	 	 => 'income',
			'transaksi'    	 => $this->input->post('description'),
			'jumlah'		 => '1',
			'harga'		 	 => $this->input->post('amount'),
			'income'		 => $this->input->post('amount'),
			'expense'		 => '0',
			'date_created' 	 => date('Y-m-d H:i:s'),
		);

		$result_expense = $this->model_finance->insert_transfer_expense($data_expense);
		$result_income = $this->model_finance->insert_transfer_income($data_income);

		if (($result_expense) && ($result_income)) {
			flashdata('success', 'Berhasil menambahkan data');
		} else {
			flashdata('error', 'Gagal menambahkan data');
		}

		redirect(base_url('finance/transfer'));
	}

	public function delete_transfer()
	{
		$tc = $this->uri->segment(4);

		$results 	= $this->model_finance->hapus_transfer($tc);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}

		redirect(base_url('finance/transfer'), 'refresh');
	}

	/*public function report_transfer()
	{
		$data['results'] = $this->model_finance->get_report_transfer_out();
		$data['pt'] = $this->model_login->get_pt();
		$data['bank'] = $this->model_login->get_bank();
		$data['indeks'] = $this->model_login->get_indeks();
		$data['divisi'] = $this->model_login->get_fc_divisi();
		set_active_menu('Report Transfer');
		init_view('finance/content_report_transfer', $data);
	}*/
}

/* End of file Transfer.php */
/* Location: ./application/controllers/finance/Transfer.php */
