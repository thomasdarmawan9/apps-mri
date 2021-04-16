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
            if (!empty($level || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72')) {
                return call_user_func_array(array($this, $method), $param);
            } else {
                redirect(base_url('login'));
            }
        } else {
            display_404();
        }
    }

    public function report_merchandise()
    {
        $data['completed'] = $this->model_merchandise->get_completed_merch();
        $data['hold']      = $this->model_merchandise->get_hold_merch();
        $data['waiting']   = $this->model_merchandise->get_waiting_approve();
        $data['results']   = $this->model_merchandise->get_report_merch();
        set_active_menu('Report Merchandise');
        init_view('admin/content_reportmerch', $data);
    }

    public function report_completed()
    {
        $data['results']  = $this->model_merchandise->get_report_completed();
        set_active_menu('Report Merchandise - Approved');
        init_view('admin/content_reportmerch_approved', $data);
    }

    public function report_hold()
    {
        $data['results']  = $this->model_merchandise->get_report_hold();
        set_active_menu('Report Merchandise - Rejected');
        init_view('admin/content_reportmerch_rejected', $data);
    }

    public function report_waiting_approve()
    {
        $data['results']  = $this->model_merchandise->get_report_waiting_approve();
        set_active_menu('Report Merchandise - Waiting Approve');
        init_view('admin/content_reportmerch_waiting', $data);
    }
}

/* End of file Merchandise.php */
/* Location: ./application/controllers/admin/Merchandise.php */
