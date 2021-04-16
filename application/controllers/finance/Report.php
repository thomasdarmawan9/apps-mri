<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
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
        if (!empty($this->input->get())) {
            $data['results']             = $this->model_finance->get_report($this->input->get());
        } else {
            $data['results']             = array();
        }
        $data['lock'] = $this->model_finance->get_lock_transaction();
        $data['bank'] = $this->model_login->get_bank();
        $data['divisi'] = $this->model_login->get_fc_divisi();
        $data['indeks'] = $this->model_login->get_indeks();
        set_active_menu('Monthly Report Transaction');
        init_view('finance/content_monthly_report', $data);
    }
    
    public function export_report_monthly()
    {
        $data        = $this->model_finance->export_data_report_monthly($this->input->get());
        $filename     = "Report_Data_Monthly_" . strtotime(setNewDateTime());
        exportToExcel($data, 'Sheet 1', $filename);
    }

    
    public function edit_report($id)
    {
        $data['results'] = $this->model_finance->get_edit_report($id);
        $data['bank']    = $this->model_finance->get_bank_drop();
        $data['income']  = $this->model_finance->get_income_divisi();
        $data['expense']  = $this->model_finance->get_expense_divisi();
        $data['indeks']  = $this->model_login->get_indeks();
        set_active_menu('Edit Mothly Report');
        init_view('finance/content_editreport', $data);
    }
    
    public function edit_monthly_report()
    {
        $url             = $this->input->post('url');
        $id              = $this->input->post('id_trans');
        $id_bank         = $this->input->post('id_bank');
        $id_pt           = $this->input->post('id_pt');
        $id_divisi       = $this->input->post('id_divisi');
        $id_hdivisi      = $this->input->post('head_divisi');
        $id_indeks       = $this->input->post('id_indeks');
        $id_user         = $this->session->userdata('id');
        $receipt_number  = $this->input->post('receipt_number');
        $tgl_nota        = $this->input->post('tgl_nota');
        $bon             = $this->input->post('bon');
        $transaksi       = $this->input->post('transaksi');
        $jumlah          = $this->input->post('jumlah');
        $harga           = $this->input->post('harga');
        $expense         = $this->input->post('expense');
        $income          = $this->input->post('income');

        $results         = $this->model_finance->update_report($id, $id_bank, $id_pt, $id_divisi, $id_hdivisi, $id_indeks, $id_user, $receipt_number, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $expense, $income);

        if ($results) {
            flashdata('success', 'Report Monthly berhasil diubah');
        } else {
            flashdata('error', 'Report Monthly gagal diubah');
        }

        redirect(base_url() . 'finance/report?' . $url);
    }
    
    public function delete_report()
	{
		$id 		= $this->input->post('id_trans');
		$results 	= $this->model_finance->delete_report($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
    
    public function json_get_report_monthly()
    {
        $id     = secure($this->input->post('id'));
        $result = $this->model_finance->detail_get_report_monthly($id);
        echo json_encode($result);
    }
    
     public function finance_summary()
    {

        $data['lock'] = $this->model_finance->get_lock_transaction();
        $data['pt'] = $this->model_login->get_pt();
        $data['list_bulan'] = list_bulan();


        if (!empty($this->input->get())) {
            $data['results_pt']          = $this->model_finance->get_pt_summary($this->input->get());
            $data['results']             = $this->model_finance->get_finance_summary($this->input->get());
            $data['results_income']      = $this->model_finance->get_finance_summary_income($this->input->get());
            $data['results_expense']     = $this->model_finance->get_finance_summary_expense($this->input->get());
            $data['initial_balance']     = $this->model_finance->get_initial_balance($this->input->get());
            $data['final_balance']       = $this->model_finance->get_final_balance($this->input->get());
            $data['balance']             = $this->model_finance->get_balance_finsum($this->input->get());
            $data['income']              = $this->model_finance->get_income_finsum($this->input->get());
            $data['expense']             = $this->model_finance->get_expense_finsum($this->input->get());
        }

        set_active_menu('Finance Summary');
        init_view('finance/content_finance_summary', $data);
    }
    
    public function pl_mrlc()
    {
        $data['lock'] = $this->model_finance->get_lock_transaction();
        $data['mrlc'] = $this->model_finance->get_fc_mrlc();
        $data['list_bulan'] = list_bulan();

        if (!empty($this->input->get())) {
            $data['results_branch']       = $this->model_finance->get_mrlc_branch($this->input->get());
            $data['results']              = $this->model_finance->get_pl_mrlc($this->input->get());
            $data['results_income_mrlc']  = $this->model_finance->finance_pl_income_mrlc($this->input->get());
            $data['results_expense_mrlc'] = $this->model_finance->finance_pl_expense_mrlc($this->input->get());
            $data['initial_balance_mrlc'] = $this->model_finance->initial_balance_mrlc($this->input->get());
            $data['final_balance_mrlc']   = $this->model_finance->final_balance_mrlc($this->input->get());
            $data['balance']              = $this->model_finance->get_balance_mrlc($this->input->get());
            $data['income']               = $this->model_finance->get_income_mrlc($this->input->get());
            $data['expense']              = $this->model_finance->get_expense_mrlc($this->input->get());
        }

        set_active_menu('MRLC Profit & Loss');
        init_view('finance/content_report_mrlc', $data);
    }

}

/* End of file Report.php */
/* Location: ./application/controllers/finance/Report.php */
