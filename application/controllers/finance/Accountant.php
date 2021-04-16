<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accountant extends CI_Controller
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
		$data['finance'] = $this->model_login->getuser_finance();
		$data['results'] = $this->model_login->get_pt();
		set_active_menu('Data Accountant');
		init_view('finance/content_list_accountant', $data);
	}
	
	public function submit_form_accountant_add()
	{
		$post 		= $this->input->post();
		$nama 		= $post['nama'];
		$username 	= $post['username'];
		$pass 		= md5($this->input->post('password'));
		$status 	= $post['status'];
		$id_pt 		= serialize($post['id_pt']);

		# insert statement
		$results = $this->model_finance->tambah_accountant($nama, $username, $pass, $status, $id_pt);
		if ($results) {
			flashdata('success', 'Berhasil menambahkan data');
		} else {
			flashdata('error', 'Gagal menambahkan data');
		}

		redirect(base_url('finance/accountant'));
	}
	
	public function push_data_accountant()
	{
		$id = secure($this->input->post('id'));
		$result = $this->model_login->getuser_finance($id);
		$data['detail'] = $result;
		$data['hr'] = unserialize($result->id_pt);
		echo json_encode($data);
	}
	
	public function edit_accountant()
	{
		$post = $this->input->post();
		$id = $post['id'];

		$pt = serialize($post['id_pt']);

		if (!empty($post['pass'])) {
			$data = array(
				'name' => $post['nama'],
				'username' => $post['username'],
				'password' => md5($post['pass']),
				'id_pt' => $pt,
				'status' => $post['status']
			);
		} else {
			$data = array(
				'name' => $post['nama'],
				'username' => $post['username'],
				'id_pt' => $pt,
				'status' => $post['status']
			);
		}

		$result = $this->model_finance->edit_accountant($id, $data);

		if ($result) {
			flashdata('success', 'Berhasil melakukan update data Accountant!');
		} else {
			flashdata('error', 'Gagal melakukan update data Accountant!');
		}

		redirect(base_url('finance/accountant/'));
	}
	
	public function delete_accountant()
	{
		$id 		= $this->input->post('id');
		$results 	= $this->model_finance->hapus_accountant($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function transaction_lock()
	{
		$status = secure($this->input->post('status'));
		$bank = secure($this->input->post('id_bank'));
		$results = $this->model_finance->transaction_lock($status, $bank);
		if ($results) {
			$this->session->set_flashdata('success', 'Berhasil ubah data');
			redirect(base_url() . 'finance/accountant/pt', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Gagal saat ubah');
			redirect(base_url() . 'finance/accountant/pt', 'refresh');
		}
	}
	
	public function pt()
	{
		$data['results'] = $this->model_login->get_pt();
		$data['lock'] = $this->model_finance->get_lock();
		$data['bank'] = $this->model_finance->get_bank_key();
		set_active_menu('Data PT');
		init_view('finance/content_list_pt', $data);
	}
	
	public function submit_form_pt()
	{
		$post = $this->input->post();
		if (!empty($post['id_pt'])) {
			# update statement
			$id = $post['id_pt'];
			unset($post['id_pt']);
			$result = $this->model_finance->update_pt($post, $id);
			if ($result) {
				flashdata('success', 'Berhasil mengubah data');
			} else {
				flashdata('error', 'Gagal mengubah data');
			}
		} else {
			# insert statement
			$result = $this->model_finance->insert_pt($post);
			if ($result) {
				flashdata('success', 'Berhasil menambahkan data');
			} else {
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('finance/accountant/pt'));
	}
	
	public function json_get_pt_detail()
	{
		$id 		= $this->input->post('id_pt');
		$response 	= $this->model_finance->get_detail_pt($id);
		echo json_encode($response);
	}
	
	public function delete_pt()
	{
		$id 		= $this->input->post('id_pt');
		$results 	= $this->model_finance->hapus_pt($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function head_divisi()
	{
		$data['results'] = $this->model_login->get_fc_hdivisi();
		set_active_menu('Data Divisi');
		init_view('finance/content_list_hdivisi', $data);
	}
	
	public function submit_form_hdivisi()
	{
		$post = $this->input->post();
		if (!empty($post['id_hdivisi'])) {
			# update statement
			$id = $post['id_hdivisi'];
			unset($post['id_hdivisi']);
			$result = $this->model_finance->update_hdivisi($post, $id);
			if ($result) {
				flashdata('success', 'Berhasil mengubah data');
			} else {
				flashdata('error', 'Gagal mengubah data');
			}
		} else {
			# insert statement
			$result = $this->model_finance->insert_hdivisi($post);
			if ($result) {
				flashdata('success', 'Berhasil menambahkan data');
			} else {
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('finance/accountant/head_divisi'));
	}

	public function json_get_hdivisi_detail()
	{
		$id 		= $this->input->post('id_hdivisi');
		$response 	= $this->model_finance->get_detail_hdivisi($id);
		echo json_encode($response);
	}

	public function delete_hdivisi()
	{
		$id 		= $this->input->post('id_hdivisi');
		$results 	= $this->model_finance->hapus_hdivisi($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function bank()
	{
		$data['results'] = $this->model_login->get_bank();
		$data['pt'] = $this->model_login->get_pt();
		set_active_menu('Data Bank');
		init_view('finance/content_list_bank', $data);
	}
	
    function json_get_bank_list()
	{
		$id_bank 	= $this->input->post('id_bank');
		$response 	= $this->model_finance->get_detail_bank($id_bank);
		echo json_encode($response);
	}
	
	public function submit_form_bank()
	{
		$post = $this->input->post();
		if (!empty($post['id_bank'])) {
			# update statement
			$id = $post['id_bank'];
			unset($post['id_bank']);
			$result = $this->model_finance->update($post, $id);
			if ($result) {
				flashdata('success', 'Berhasil mengubah data');
			} else {
				flashdata('error', 'Gagal mengubah data');
			}
		} else {
			# insert statement
			$result = $this->model_finance->insert($post);

			if ($result) {
				flashdata('success', 'Berhasil menambahkan data');
			} else {
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('finance/accountant/bank'));
	}
	
	public function json_get_bank_detail()
	{
		$id 		= $this->input->post('id');
		$response 	= $this->model_finance->get_bank_detail($id);
		echo json_encode($response);
	}
	
	public function delete_bank()
	{
		$id 		= $this->input->post('id_bank');
		$results 	= $this->model_finance->hapus_bank($id);

		if ($results) {
			flashdata('success', 'Segala data bank tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function divisi()
	{
	    $data['hdivisi'] = $this->model_login->get_fc_hdivisi();
		$data['results'] = $this->model_login->get_fc_divisi();
		set_active_menu('Data Divisi');
		init_view('finance/content_list_divisi', $data);
	}
	
	public function tampil_chained()
	{
		$id = $_POST['id'];
		$dropdown_chained = $this->model_finance->tampil_data_chained($id);
		foreach ($dropdown_chained->result() as $baris) {
			echo "<option value='" . $baris->id_indeks . "'>" . $baris->nama_indeks . "</option>";
		}
	}
	
	public function tampil_chained_head()
	{
		$id = $_POST['id'];
		$dropdown_chained = $this->model_finance->tampil_data_chained_head($id);

		foreach ($dropdown_chained->result() as $baris) {
			echo "<option value='" . $baris->id_hdivisi . "'>".$baris->nama_hdivisi . "</option>";
		}
	}
	
	function get_autocomplete_divisi()
	{
		$this->load->model('model_finance');
		$row 		= secure($this->input->post('row'));
		$id_divisi 	= $this->input->post('id_divisi');
		$response 	= $this->model_finance->get_list_divisi($id_divisi);
		echo json_encode($response);
	}

	
	public function json_get_indeks_list()
	{
		$this->load->model('model_finance');
		$id_divisi 		= $this->input->post('id_divisi');
		$response 	= $this->model_finance->get_list_indeks($id_divisi);
		echo json_encode($response);
	}
	
	public function submit_form_divisi()
	{
		$post = $this->input->post();
		if (!empty($post['id_divisi'])) {
			# update statement
			$id = $post['id_divisi'];
			unset($post['id_divisi']);
			$result = $this->model_finance->update_divisi($post, $id);
			if ($result) {
				flashdata('success', 'Berhasil mengubah data');
			} else {
				flashdata('error', 'Gagal mengubah data');
			}
		} else {
			# insert statement
			$result = $this->model_finance->insert_divisi($post);
			if ($result) {
				flashdata('success', 'Berhasil menambahkan data');
			} else {
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('finance/accountant/divisi'));
	}
	
	public function json_get_divisi_detail()
	{
		$id 		= $this->input->post('id_divisi');
		$response 	= $this->model_finance->get_detail_divisi($id);
		echo json_encode($response);
	}
	
	public function delete_divisi()
	{
		$id 		= $this->input->post('id_divisi');
		$results 	= $this->model_finance->hapus_divisi($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function indeks()
	{
	    $data['hdivisi'] = $this->model_login->get_fc_hdivisi();
		$data['divisi'] = $this->model_login->get_fc_divisi();
		$data['results'] = $this->model_login->get_indeks();
		set_active_menu('Data Indeks');
		init_view('finance/content_list_indeks', $data);
	}
	
	public function submit_form_indeks()
	{
		$post = $this->input->post();
		if (!empty($post['id_indeks'])) {
			# update statement
			$id = $post['id_indeks'];
			unset($post['id_indeks']);
			$result = $this->model_finance->update_indeks($post, $id);
			if ($result) {
				flashdata('success', 'Berhasil mengubah data');
			} else {
				flashdata('error', 'Gagal mengubah data');
			}
		} else {
			# insert statement
			$result = $this->model_finance->insert_indeks($post);
			if ($result) {
				flashdata('success', 'Berhasil menambahkan data');
			} else {
				flashdata('error', 'Gagal menambahkan data');
			}
		}
		redirect(base_url('finance/accountant/indeks'));
	}
	
	public function json_get_indeks_detail()
	{
		$id 		= $this->input->post('id_indeks');
		$response 	= $this->model_finance->get_detail_indeks($id);
		echo json_encode($response);
	}
	
	public function delete_indeks()
	{
		$id 		= $this->input->post('id_indeks');
		$results 	= $this->model_finance->hapus_indeks($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function income()
	{
		$data['lock']    = $this->model_finance->get_lock_transaction();
		$data['bank']    = $this->model_finance->get_bank_drop();
		$data['divisi']  = $this->model_finance->get_income_divisi();
		$data['indeks']  = $this->model_login->get_indeks();
		$data['results'] = $this->model_finance->get_income();

		set_active_menu('Income Transaction Data');
		init_view('finance/content_list_income', $data);
	}
	
	public function add_transaction_income()
	{

		if (!empty($_GET['id_bank'])) {
			$id_bank = $_GET['id_bank'];
		} else {
			$id_bank = "";
		}
		$data['key']  	 = $this->model_finance->get_key();
		$data['pt']  	 = $this->model_finance->get_banktopt($id_bank);
		$data['bank']    = $this->model_finance->get_bank_drop();
		$data['divisi']  = $this->model_finance->get_income_divisi();
		set_active_menu('Add Income Transaction');
		init_view('finance/content_addtransaction_income', $data);
	}
	
    public function add_row_income_finance()
	{
		$redirect = $this->input->post('redirect');
		$key_number = secure($this->input->post('key_number'));
		$receipt_number = secure($this->input->post('receipt_number'));
		$jenis = 'income';
		$id_bank = secure($this->input->post('id_bank'));
		
		$this->db->select('*');
		$this->db->from('fc_bank');
		$this->db->where('id_bank', $id_bank);
		$result_bank = $this->db->get()->result();

		foreach ($result_bank as $row) {
			$bank_pt = $row->id_pt;
		}
		
		$bon = secure($this->input->post('bon'));
		$date = secure($this->input->post('date'));
		$baris = secure($this->input->post('baris'));

		redirect($redirect . 'baris=' . $baris . '&key_number=' . $key_number . '&receipt_number=' . $receipt_number . '&jenis=' . $jenis . '&id_bank=' . $id_bank . '&bon=' . $bon . '&date=' . $date . '&id_pt=' . $bank_pt);
	}
	
// 	public function submit_form_income()
// 	{
// 		$post = $this->input->post();
// 		$data = array(
// 			'id_bank'  	 	 => $this->input->post('id_bank'),
// 			'id_pt'  	 	 => $this->input->post('id_pt'),
// 			'id_divisi' 	 => $this->input->post('id_divisi'),
// 			'id_hdivisi' 	 => $this->input->post('head_divisi'),
// 			'id_indeks' 	 => $this->input->post('id_indeks'),
// 			'id_user' 	 	 => $this->session->userdata('id'),
// 			'is_transfer' 	 => '0',
// 			'receipt_number' => $this->input->post('receipt_number'),
// 			'jenis' 	   	 => $this->input->post('jenis'),
// 			'tgl_nota'  	 => $this->input->post('tgl_nota'),
// 			'bon' 	   	 	 => $this->input->post('bon'),
// 			'transaksi' 	 => $this->input->post('transaksi'),
// 			'jumlah'    	 => $this->input->post('jumlah'),
// 			'harga' 	     => $this->input->post('harga'),
// 			'expense'	 	 => $this->input->post('expense'),
// 			'income' 	 	 => $this->input->post('income'),
// 			'date_created' 	 => date('Y-m-d H:i:s'),
// 		);

// 		$result = $this->model_finance->insert_transaction($data);
// 		if ($result) {
// 			flashdata('success', 'Berhasil menambahkan data');
// 		} else {
// 			flashdata('error', 'Gagal menambahkan data');
// 		}

// 		redirect(base_url('finance/accountant/income'));
// 	}

    public function submit_form_income()
	{
		$post = $this->input->post();

		$baris 			= $this->input->post('baris');
		$row 			= $this->input->post('row');

		for ($i = 0; $row > $i; $i++) {
			$key_number 	= $this->input->post('key_number');
			$id_bank    	= $this->input->post('id_bank');
			$id_pt		 	= $this->input->post('id_pt');
			$id_divisi	 	= $this->input->post('id_divisi' . $i . '');
			$head_divisi 	= $this->input->post('head_divisi' . $i . '');
			$id_indeks 	 	= $this->input->post('id_indeks' . $i . '');
			$user			= $this->session->userdata('id');
			$is_transfer	= '0';
			$receipt_number = $this->input->post('receipt_number');
			$jenis			= $this->input->post('jenis');
			$tgl_nota		= $this->input->post('date');
			$bon			= $this->input->post('bon');
			$transaksi 	 	= $this->input->post('transaksi' . $i . '');
			$jumlah 	 	= $this->input->post('jumlah' . $i . '');
// 			$amount			= str_replace(',', '', $jumlah);
// 			$amounts			= floatval(number_format($amount, 3));
			$harga 	     	= $this->input->post('harga' . $i . '');
// 			$price			= str_replace(',', '', $harga);
// 			$prices			= floatval(number_format($price, 3));
			$expense		= '0';
			$income 	 	= $this->input->post('income' . $i . '');
			$incomes	    = str_replace(',', '', $income);
			$total_income	= floatval($incomes);
			$date			= date('Y-m-d H:i:s');

			$results 	 = $this->model_finance->insert_transaction_income($key_number, $id_bank, $id_pt, $id_divisi, $head_divisi, $id_indeks, $user, $is_transfer, $receipt_number, $jenis, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $expense, $total_income, $date);
		}
		if ($results) {
			flashdata('success', 'Berhasil menambahkan data');
		} else {
			flashdata('error', 'Gagal menambahkan data');
		}

		redirect(base_url('finance/accountant/income'));
	}
	
	public function json_get_income_transaction()
	{
		$id 	= secure($this->input->post('id'));
		$result = $this->model_finance->detail_get_income_transaction($id);
		echo json_encode($result);
	}
	
	public function edit_income($id)
	{
		$data['results'] = $this->model_finance->get_edit_income($id);
		$data['bank']    = $this->model_finance->get_bank_drop();
		$data['divisi']  = $this->model_finance->get_income_divisi();
		$data['indeks']  = $this->model_login->get_indeks();
		set_active_menu('Edit Income Transaction');
		init_view('finance/content_editincome', $data);
	}
	
	public function submit_edit_income()
	{
		$id	         	= $this->input->post('id_trans');
		$id_bank 		= $this->input->post('id_bank');
		$id_pt 			= $this->input->post('id_pt');
		$id_divisi 		= $this->input->post('id_divisi');
		$id_hdivisi 	= $this->input->post('id_hdivisi');
		$id_indeks 		= $this->input->post('id_indeks');
		$id_user 		= $this->session->userdata('id');
		$receipt_number = $this->input->post('receipt_number');
		$jenis 			= $this->input->post('jenis');
		$tgl_nota 		= $this->input->post('tgl_nota');
		$bon 			= $this->input->post('bon');
		$transaksi 		= $this->input->post('transaksi');
		$jumlah 		= $this->input->post('jumlah');
		$harga 			= $this->input->post('harga');
		$expense 		= $this->input->post('expense');
		$income 		= $this->input->post('income');

		$results 		= $this->model_finance->update_transaction($id, $id_bank, $id_pt, $id_divisi, $id_hdivisi, $id_indeks, $id_user, $receipt_number, $jenis, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $expense, $income);

		if ($results) {
			flashdata('success', 'Data Income berhasil diubah');
		} else {
			flashdata('error', 'Data Income gagal diubah');
		}
		redirect(base_url('finance/accountant/income'));
	}
	
	public function delete_transaction()
	{
		$id 		= $this->input->post('id_trans');
		$results 	= $this->model_finance->hapus_transaksi($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
	
	public function expense()
	{
		$data['lock'] = $this->model_finance->get_lock_transaction();
		$data['bank'] = $this->model_finance->get_bank_drop();
		$data['divisi'] = $this->model_finance->get_expense_divisi();
		$data['indeks'] = $this->model_login->get_indeks();
		$data['results'] = $this->model_finance->get_expense();
		set_active_menu('Expense Transaction Data');
		init_view('finance/content_list_expense', $data);
	}
	
	public function add_transaction_expense()
	{

		if (!empty($_GET['id_bank'])) {
			$id_bank = $_GET['id_bank'];
		} else {
			$id_bank = "";
		}
		$data['key']  	 = $this->model_finance->get_key();
		$data['pt']  	 = $this->model_finance->get_banktopt($id_bank);
		$data['bank']    = $this->model_finance->get_bank_drop();
		$data['divisi']  = $this->model_finance->get_expense_divisi();
		set_active_menu('Add Expense Transaction');
		init_view('finance/content_addtransaction_expense', $data);
	}
	
	public function add_row_expense_finance()
	{
		$redirect = $this->input->post('redirect');
		$key_number = secure($this->input->post('key_number'));
		$receipt_number = secure($this->input->post('receipt_number'));
		$jenis = 'expense';
		$id_bank = secure($this->input->post('id_bank'));
		
		$this->db->select('*');
		$this->db->from('fc_bank');
		$this->db->where('id_bank', $id_bank);
		$result_bank = $this->db->get()->result();

		foreach ($result_bank as $row) {
			$bank_pt = $row->id_pt;
		}
		
		$bon = secure($this->input->post('bon'));
		$date = secure($this->input->post('date'));
		$baris = secure($this->input->post('baris'));

		redirect($redirect . 'baris=' . $baris . '&key_number=' . $key_number . '&receipt_number=' . $receipt_number . '&jenis=' . $jenis . '&id_bank=' . $id_bank . '&bon=' . $bon . '&date=' . $date . '&id_pt=' . $bank_pt);
	}
	
	public function submit_form_expense()
	{
// 		$post = $this->input->post();
// 		$data = array(
// 			'id_bank'  	 	 => $this->input->post('id_bank'),
// 			'id_pt'  	 	 => $this->input->post('id_pt'),
// 			'id_divisi' 	 => $this->input->post('id_divisi'),
// 			'id_hdivisi' 	 => $this->input->post('head_divisi'),
// 			'id_indeks' 	 => $this->input->post('id_indeks'),
// 			'id_user' 	 	 => $this->session->userdata('id'),
// 			'is_transfer' 	 => '0',
// 			'receipt_number' => '',
// 			'jenis' 	   	 => $this->input->post('jenis'),
// 			'tgl_nota'  	 => $this->input->post('tgl_nota'),
// 			'bon' 	   	 	 => $this->input->post('bon'),
// 			'transaksi' 	 => $this->input->post('transaksi'),
// 			'jumlah'    	 => $this->input->post('jumlah'),
// 			'harga' 	     => $this->input->post('harga'),
// 			'expense' 	 	 => $this->input->post('expense'),
// 			'income' 	 	 => $this->input->post('income'),
// 			'date_created' 	 => date('Y-m-d H:i:s'),
// 		);

// 		$result = $this->model_finance->insert_transaction($data);
// 		if ($result) {
// 			flashdata('success', 'Berhasil menambahkan data');
// 		} else {
// 			flashdata('error', 'Gagal menambahkan data');
// 		}

// 		redirect(base_url('finance/accountant/expense'));

        $baris 			= $this->input->post('baris');
		$row 			= $this->input->post('row');

		for ($i = 0; $row > $i; $i++) {
			$key_number 	= $this->input->post('key_number');
			$id_bank    	= $this->input->post('id_bank');
			$id_pt		 	= $this->input->post('id_pt');
			$id_divisi	 	= $this->input->post('id_divisi' . $i . '');
			$head_divisi 	= $this->input->post('head_divisi' . $i . '');
			$id_indeks 	 	= $this->input->post('id_indeks' . $i . '');
			$user			= $this->session->userdata('id');
			$is_transfer	= '0';
			$receipt_number = $this->input->post('receipt_number');
			$jenis			= $this->input->post('jenis');
			$tgl_nota		= $this->input->post('date');
			$bon			= $this->input->post('bon');
			$transaksi 	 	= $this->input->post('transaksi' . $i . '');
			$jumlah 	 	= $this->input->post('jumlah' . $i . '');
// 			$amount			= str_replace(',', '', $jumlah);
// 			$amounts		= floatval(number_format($amount, 3));
			$harga 	     	= $this->input->post('harga' . $i . '');
// 			$price			= str_replace(',', '', $harga);
// 			$prices			= floatval(number_format($price, 3));
			$expense		= $this->input->post('expense' . $i . '');
			$income 	 	= '0';
			$expenses	    = str_replace(',', '', $expense);
			$total_expense	= floatval($expenses);
			$date			= date('Y-m-d H:i:s');

			$results 	 = $this->model_finance->insert_transaction_expense($key_number, $id_bank, $id_pt, $id_divisi, $head_divisi, $id_indeks, $user, $is_transfer, $receipt_number, $jenis, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $income, $total_expense, $date);
		}
		if ($results) {
			flashdata('success', 'Berhasil menambahkan data');
		} else {
			flashdata('error', 'Gagal menambahkan data');
		}

		redirect(base_url('finance/accountant/expense'));
	}
	
	public function json_get_expense_transaction()
	{
		$id 	= secure($this->input->post('id'));
		$result = $this->model_finance->detail_get_expense_transaction($id);
		echo json_encode($result);
	}
	
	public function edit_expense($id)
	{
		$data['results'] = $this->model_finance->get_edit_expense($id);
		$data['bank']    = $this->model_finance->get_bank_drop();
		$data['divisi']  = $this->model_finance->get_expense_divisi();
		$data['indeks']  = $this->model_login->get_indeks();
		set_active_menu('Edit Expense Transaction');
		init_view('finance/content_editexpense', $data);
	}
	
	public function submit_edit_expense()
	{
		$id	         	= $this->input->post('id_trans');
		$id_bank 		= $this->input->post('id_bank');
		$id_pt 			= $this->input->post('id_pt');
		$id_divisi 		= $this->input->post('id_divisi');
		$id_hdivisi 	= $this->input->post('head_divisi');
		$id_indeks 		= $this->input->post('id_indeks');
		$id_user 		= $this->session->userdata('id');
		$receipt_number = '';
		$jenis 			= $this->input->post('jenis');
		$tgl_nota 		= $this->input->post('tgl_nota');
		$bon 			= $this->input->post('bon');
		$transaksi 		= $this->input->post('transaksi');
		$jumlah 		= $this->input->post('jumlah');
		$harga 			= $this->input->post('harga');
		$expense 		= $this->input->post('expense');
		$income 		= $this->input->post('income');

		$results 		= $this->model_finance->update_transaction($id, $id_bank, $id_pt, $id_divisi, $id_hdivisi, $id_indeks, $id_user, $receipt_number, $jenis, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $expense, $income);

		if ($results) {
			flashdata('success', 'Data Transaksi berhasil diubah');
		} else {
			flashdata('error', 'Data Transaksi gagal diubah');
		}
		redirect(base_url('finance/accountant/expense'));
	}
	
	// Apps Nomerator
	public function approve_transaction()
	{
		$data['key']  	 = $this->model_finance->get_key();
		$data['bank']    = $this->model_finance->get_bank_nomerator();
		$data['indeks']  = $this->model_login->get_indeks();
		$data['results'] = $this->model_finance->get_approve_fromtt();
		set_active_menu('Approve Transaction');
		init_view('finance/content_approve_transaction', $data);
	}
	
	public function approve_nomerator()
	{
		$id = $this->input->post('id');
		$results = $this->model_finance->approve_nomerator($id);

		if ($results) {
			flashdata('success', 'Nomerator Sudah Berhasil di Setujui');
		} else {
			flashdata('error', 'Gagal melakukan Approve');
		}
		echo json_encode($results);
	}
	
	public function json_get_nomerator()
	{
		$this->load->model('model_finance');
		$id 	= $this->input->post('id');
		$response 	= $this->model_finance->get_list_nomerator($id);
		echo json_encode($response);
	}
	
	public function export_data_nomerator()
	{
	    $this->db->select('nomerator.date as Tanggal, user.username as From, nomerator.nomerator as Nomerator, fc_bank.name as Bank, nomerator.nama_peserta as Nama Peserta, nomerator.program as Program, nomerator.jumlah as Jumlah');
		$this->db->join('divisi','divisi.id = nomerator.id_divisi','left');
		$this->db->join('user','user.id = nomerator.id_user','left');
		$this->db->join('fc_bank','fc_bank.id_bank = nomerator.bank','left');
		$this->db->where('date >=', $_GET['date_start']);
		$this->db->where('date <=', $_GET['date_end']);
        //Dady 		
		if ($this->session->userdata('id') == '174'){
		$this->db->where_in('nomerator.id_divisi',array('28','29','33','38','39'));
		$this->db->where_in('nomerator.id_branch',array('0','1','2','3','38'));
        // Akib 			
		}else if($this->session->userdata('id') == '180'){
			$this->db->where_in('nomerator.id_divisi',array('3','37'));
        // Lifah 		
		}else if($this->session->userdata('id') == '182'){
			$this->db->where('nomerator.id_divisi','6');
		// Prisca
		}else if($this->session->userdata('id') == '181'){
		    $this->db->where_in('nomerator.id_divisi',array('28', '29','33', '39'));
			$this->db->where_in('nomerator.id_branch',array('5', '6', '7'));
		}
		$this->db->order_by('date','desc');
		
        $data        = $this->db->get('nomerator');
        $filename    = "Report_Data_Nomerator_" . strtotime(setNewDateTime());
        exportToExcel($data, 'Sheet 1', $filename);
	   
	}

}