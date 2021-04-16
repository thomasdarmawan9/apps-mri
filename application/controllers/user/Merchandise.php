<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Merchandise extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_lembur');
        $this->load->model('model_product');
        $this->load->model('model_merchandise');
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
        $data['results'] = $this->model_product->get_product();
        set_active_menu('Merchandise');
        init_view('user/content_addmerch', $data);
    }

    public function add_product()
    {
        $name = secure($this->input->post('name'));
        $overtime = secure($this->input->post('overtime'));

        $result = $this->model_merchandise->add_product($name, $overtime);

        if ($result) {
            flashdata('success', 'Berhasil menambah produk');
        } else {
            flashdata('error', 'Gagal menambah produk');
        }

        redirect(base_url("user/merchandise"), 'refresh');
    }

    public function push_data()
    {
        $id = secure($this->input->post('id'));
        $result = $this->model_product->push_data($id);
        echo json_encode($result);
    }

    public function update_product()
    {

        $id = secure($this->input->post('id'));
        $name = secure($this->input->post('name'));
        $overtime = secure($this->input->post('overtime'));
        $result = $this->model_merchandise->update_product($id, $name, $overtime);

        if ($result) {
            flashdata('success', 'Berhasil meng-update produk');
        } else {
            flashdata('error', 'Gagal meng-update produk');
        }

        redirect(base_url("user/merchandise"), 'refresh');
    }

    public function delete_product()
    {
        $id = secure($this->input->post('id'));
        $result = $this->model_merchandise->delete_product($id);

        if ($result) {
            flashdata('success', 'Berhasil hapus product');
        } else {
            flashdata('error', 'Gagal hapus product');
        }
        echo json_encode($result);
    }

    public function buy_merchandise()
    {
        $data['product'] = $this->model_merchandise->get_product();
        $data['results'] = $this->model_merchandise->get_log_merch();
        $data['warrior'] = $this->model_merchandise->get_user();
        set_active_menu('Buy Merchandise');
        init_view('user/content_buymerch', $data);
    }

    public function apply_buy_merch()
    {
        $post = $this->input->post();

        date_default_timezone_set('Asia/Jakarta');


        // $merch_name     = $post['merch_name'];
        
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('id_product', $post['merch']);
        $merch_query = $this->db->get()->row_array();

        $merch_name = $merch_query['nama_product'];
        
        $description    = 'Pembelian Merchandise ' . $merch_name;
        $jam            = date('H:i');

        $total          = $post['total'];

        $id_log_product = $this->model_merchandise->automation_code();
        $id_product     = $post['merch'];
        $id_user        = $this->session->userdata('id');
        $sell_on_date   = date('Y-m-d');
        $size           = $post['size'];
        $qty            = $post['qty'];
        $desc           = '<jam>' . $jam . ' - ' . $jam . '</jam> ' . $description;
        $grand_total    = 0 - $total;
        $is_done        = '0';
        $is_approve     = '0';
        $is_reject      = '0';

        $result = $this->model_merchandise->insert_transaction($id_log_product, $id_product, $id_user, $sell_on_date, $size, $qty, $desc, $total, $grand_total, $is_done, $is_approve, $is_reject);

        if ($result) {
            flashdata('success', 'Berhasil ! ,Permintaan Barang Kamu Masih Harus di Approve HR');
        } else {
            flashdata('error', 'Gagal Nihh, Overtime Kamu Sepertinya Kurang');
        }

        redirect(base_url('user/merchandise/buy_merchandise'));
    }

    public function get_json_product()
    {
        $result  = $this->model_merchandise->get_product();
        echo json_encode($result);
    }

    public function get_autocomplete_overtime()
    {
        $this->load->model('model_finance');
        $id_product     = $this->input->post('merch');
        $response     = $this->model_merchandise->get_list_overtime($id_product);
        echo json_encode($response);
    }

    public function push_data_merchandise()
    {
        $id_log_product = secure($this->input->post('id_log_product'));
        $result = $this->model_merchandise->edit_buy_merch($id_log_product);
        $data['detail'] = $result;
        echo json_encode($data);
    }

    public function edit_buy_merch()
    {
        $post = $this->input->post();

        $id = $post['id_log_product'];

        date_default_timezone_set('Asia/Jakarta');


        // $merch_name     = $post['merch_name'];
        
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('id_product', $post['merch']);
        $merch_query = $this->db->get()->row_array();

        $merch_name = $merch_query['nama_product'];
        
        $description    = 'Pembelian Merchandise ' . $merch_name;
        $jam            = date('H:i');

        $total          = $post['total'];

        $id_product    = $post['merch'];
        $size          = $post['size'];
        $qty           = $post['qty'];
        $desc          = '<jam>' . $jam . ' - ' . $jam . '</jam> ' . $description;
        $grand_total   = 0 - $total;

        $results         = $this->model_merchandise->update_transaction($id, $id_product, $size, $qty, $desc, $grand_total);

        if ($results) {
            flashdata('success', 'Yeayyy Permintaan Data Kamu Berhasil Diubah');
        } else {
            flashdata('error', 'Kayanya Ada Masalah deh');
        }
        redirect(base_url('user/merchandise/buy_merchandise'));
    }

    public function delete_merchandise()
    {
        $id         = $this->input->post('id_log_product');
        $results     = $this->model_merchandise->delete_transaction($id);

        if ($results) {
            flashdata('success', 'Belanja Lagi yaa Nanti !!!');
        } else {
            flashdata('error', 'Kayanya Ada Masalah deh.');
        }
        echo json_encode($results);
    }

    public function report_merchandise()
    {
        $data['completed'] = $this->model_merchandise->get_completed_merch();
        $data['hold']      = $this->model_merchandise->get_hold_merch();
        $data['waiting']   = $this->model_merchandise->get_waiting_approve();
        // $data['results']   = $this->model_merchandise->get_report_merch();
         if (!empty($this->input->get())) {
            $data['results']   = $this->model_merchandise->get_report_merch($this->input->get());
        } else {
            $data['results']             = array();
        }
        set_active_menu('Report Merchandise');
        init_view('user/content_reportmerch', $data);
    }

    public function report_completed()
    {
        $data['results']  = $this->model_merchandise->get_report_completed();
        set_active_menu('Report Merchandise - Approved');
        init_view('user/content_reportmerch_approved', $data);
    }

    public function report_hold()
    {
        $data['results']  = $this->model_merchandise->get_report_hold();
        set_active_menu('Report Merchandise - Rejected');
        init_view('user/content_reportmerch_rejected', $data);
    }

    public function report_waiting_approve()
    {
        $data['results']  = $this->model_merchandise->get_report_waiting_approve();
        set_active_menu('Report Merchandise - Waiting Approve');
        init_view('user/content_reportmerch_waiting', $data);
    }

    public function done_merch()
    {
        $id          = $this->input->post('id_log_product');
        $results     = $this->model_merchandise->done_merch($id);

        if ($results) {
            flashdata('success', 'Yeayyy Barang Berhasil Sudah Dikasih ke Warrior !!!');
        } else {
            flashdata('error', 'Kayanya Ada Masalah deh.');
        }

        echo json_encode($results);
    }
}

/* End of file Merchandise.php */
/* Location: ./application/controllers/user/Merchandise.php */
