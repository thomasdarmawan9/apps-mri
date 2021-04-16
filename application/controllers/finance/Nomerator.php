<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nomerator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_finance');
        $this->load->model('Model_login');
    }

    public function _remap($method, $param = array())
	{
		if (method_exists($this, $method)) {
			$level = $this->session->userdata('level');
			if (!empty($level) || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72') {
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
        $data['results'] = $this->Model_finance->get_accountant_datatt();
        set_active_menu('Acc Nomerator');
        init_view('finance/content_accnomerator', $data);
	}

    public function toapprove_nomerator()
	{
		$id = $this->input->post('id');
		$results = $this->Model_finance->toapprove_nomerator($id);

		if ($results) {
			flashdata('success', 'Berhasil Diapprove');
		} else {
			flashdata('error', 'Gagal mengubah data.');
		}
		echo json_encode($results);
    }
    
    public function toreject_nomerator()
	{
		$id = $this->input->post('id');
		$results = $this->Model_finance->toreject_nomerator($id);

		if ($results) {
			flashdata('success', 'Berhasil menolak tanda terima.');
		} else {
			flashdata('error', 'Gagal mengubah data.');
		}
		echo json_encode($results);
	}

	public function report_nomerator()
	{	
		if (!empty($this->input->get())) {
			$data['results']             = $this->Model_finance->get_data_nomerator($this->input->get());
        } else {
			$data['results'] 			 = $this->Model_finance->get_all_nomerator();
		}
		set_active_menu('Report Nomerator');
        init_view('finance/content_report_nomerator',$data);
	}

	public function export_report_nomerator()
    {
        $data        = $this->Model_finance->export_report_nomerator($this->input->get());
        $filename    = "Report_Data_Nomerator_" . strtotime(setNewDateTime());
        exportToExcel($data, 'Sheet 1', $filename);
    }
    
    public function approve_nomerator()
	{
		$post 			= $this->input->post();
		$bank  			= $post['payment_source'];
		$indeks  		= $post['id_indeks'];
		$user			= $this->session->userdata('id');
		$receipt		= $post['receipt_number'];
		$tandaterima    = $post['id_tt'];

		$this->db->select('*');
		$this->db->where('id_bank', $bank);
		$get_pt = $this->db->get('fc_bank')->result();

		foreach ($get_pt as $row) {
			$pt = $row->id_pt;
		}

		$this->db->select('*');
		$this->db->where('id_indeks', $indeks);
		$result_indeks = $this->db->get('fc_indeks')->result();

		foreach ($result_indeks as $row) {
			$id_divisi = $row->id_divisi;
			$headdivisi = $row->head_divisi;
		}

		$data = array(
			'key_number' 	 => $post['key_number'],
			'id_bank' 	 	 => $post['payment_source'],
			'id_pt' 	 	 => $pt,
			'id_divisi'		 => $id_divisi,
			'id_indeks'		 => $post['id_indeks'],
			'id_hdivisi' 	 => $headdivisi,
			'id_user'		 => $user,
			'is_transfer' 	 => '0',
			'receipt_number' => $receipt,
			'jenis' 		 => 'income',
			'tgl_nota' 		 => $post['tgl_nota'],
			'bon' 			 => $post['bon'],
			'transaksi' 	 => $post['description'],
			'jumlah'		 => '1',
			'harga'			 => $post['total'],
			'expense'		 => '0',
			'income'		 => $post['total'],
			'date_created'   => date('Y-m-d H:i:s'),
		);

		$result = $this->Model_finance->approval_insert($data, $receipt, $tandaterima);

		if ($result) {
			flashdata('success', 'Transaksi Berhasil Ditambahkan');
		} else {
			flashdata('error', 'Gagal menambahkan transaksi atau Receipt sudah terpakai');
		}

		redirect(base_url('finance/accountant/approve_transaction'));
	}
}
?>