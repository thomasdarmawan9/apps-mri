<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Referral extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_task');
    }

    public function _remap($method, $param = array())
    {
        if (method_exists($this, $method)) {
            $level = $this->session->userdata('level');
            if ((!empty($level)) && ($this->session->userdata('signup_privilege') == 1) || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72') {
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
        $data['program'] = $this->model_task->get_program_referral();
        $data['referror'] = $this->model_task->get_referror();

        if (!empty($this->input->get())) {
            $data['filter']               = $this->model_task->get_data_referral($this->input->get())->result_array();
        } else {
            $data['filter']               = array();
        }

        set_active_menu('List Referral');
        init_view('user/content_list_referral', $data);
    }

    public function submit_data_referral()
    {
        $post = $this->input->post();

        $signup_date = $post['signup_date'];
        if ($signup_date == '') {

            $data = array(
                'date_referral' => date('Y-m-d'),
                'status_tele'   => $post['status'],
                'description'   => $post['description'],

            );
        } else {
            $data = array(
                'date_referral' => date('Y-m-d'),
                'status_tele'   => $post['status'],
                'description'   => $post['description'],
                'signup_date'   => $signup_date
            );
        }

        $id = $post['id_referral'];
        unset($post['id_referral']);
        $url = $post['url'];

        $result = $this->model_task->update_referral($data, $id);
        if ($result) {
            flashdata('success', 'Berhasil mengubah data');
        } else {
            flashdata('error', 'Gagal mengubah data');
        }

        redirect(base_url('user/referral?' . $url));
    }

    public function referror()
    {
        $data['results'] = $this->model_task->get_referror();
        $data['branch'] = $this->model_task->get_branch();
         
        set_active_menu('List Referror');
        init_view('user/content_list_referror', $data);
    }

    public function submit_form_referror()
    {
        $post = $this->input->post();
        
        if($this->session->userdata('branch') != '0'){
            $branch_id = $this->session->userdata('branch');
        }else{
            $branch_id = $post['branch_id'];
        }

        $data_insert = array(
            
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'id_user'     => $this->session->userdata('id'),
            'id_divisi'     => $this->session->userdata('iddivisi'),
            'is_branch'    => $branch_id,
            'date_created' => date('Y-m-d H:i:s')
        );

        $data_update = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            // 'id_user'     => $this->session->userdata('id'),
            // 'id_divisi'     => $this->session->userdata('iddivisi'),
        );

        $phone = $post['phone'];


        if (!empty($post['id_referror'])) {
            # update statement
            $id = $post['id_referror'];
            unset($post['id_referror']);
            $result = $this->model_task->update_referror($data_update, $id, $phone);
            if ($result) {
                flashdata('success', 'Berhasil mengubah data');
            } else {
                flashdata('error', 'Nomor Telepon sudah Ada');
            }
        } else {
            # insert statement
            $result = $this->model_task->insert_referror($data_insert, $phone);

            if ($result) {
                flashdata('success', 'Berhasil menambahkan data');
            } else {
                flashdata('error', 'Gagal menambahkan data');
            }
        }
        redirect(base_url('user/referral/referror'));
    }

    public function json_get_referror_detail()
    {
        $id         = $this->input->post('id_referror');
        $response     = $this->model_task->get_referror_detail($id);
        echo json_encode($response);
    }

    public function delete_referror()
    {
        $id         = $this->input->post('id_referror');
        $results     = $this->model_task->hapus_data_referror($id);

        if ($results) {
            flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
        } else {
            flashdata('error', 'Gagal menghapus data.');
        }
        echo json_encode($results);
    }

    public function master_referral()
    {
        $data['results'] = $this->model_task->get_referral();
        $data['referror'] = $this->model_task->get_referror();
        $data['program'] = $this->model_task->get_program_referral();
        set_active_menu('Master Referral');
        init_view('user/content_addreferral', $data);
    }

    public function submit_form_referral()
    {
        $post = $this->input->post();

        $data_insert = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'program' => $post['program'],
            'referral' => $post['referror'],
            'status_tele' => '-',
            'id_user'     => $this->session->userdata('id'),
            'id_divisi'     => $this->session->userdata('iddivisi'),
            'date_created' => date('Y-m-d H:i:s')
        );

        $data_update = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'program' => $post['program'],
            'referral' => $post['referror'],
            'id_user'     => $this->session->userdata('id'),
            'id_divisi'     => $this->session->userdata('iddivisi'),
        );


        if (!empty($post['id_referral'])) {
            # update statement
            $id = $post['id_referral'];
            unset($post['id_referral']);
            $result = $this->model_task->update_referral($data_update, $id);
            if ($result) {
                flashdata('success', 'Berhasil mengubah data');
            } else {
                flashdata('error', 'Gagal mengubah data');
            }
        } else {
            # insert statement

            $result = $this->model_task->insert_referral($data_insert);

            if ($result) {
                flashdata('success', 'Berhasil menambahkan data');
            } else {
                flashdata('error', 'Gagal menambahkan data');
            }
        }
        redirect(base_url('user/referral/master_referral'));
    }

    public function json_get_referral_detail()
    {
        $id         = $this->input->post('id_referral');
        $response     = $this->model_task->get_referral_detail($id);
        echo json_encode($response);
    }

    public function delete_referral()
    {
        $id         = $this->input->post('id_referral');
        $results    = $this->model_task->hapus_data_referral($id);

        if ($results) {
            flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
        } else {
            flashdata('error', 'Gagal menghapus data.');
        }
        echo json_encode($results);
    }

    public function export_referral()
    {
        // $this->db->select('date_referral as Tanggal Referral, name as Nama, email as E-mail, phone as No.Telp, program as Program, referral as Referral, status_tele as Status Tele, description as Keterangan');
        // if (!empty($param['program']) && ($param['program'] != 'all')) {
        //     $this->db->where('list_referral.program', $param['program']);
        // }
        // if (!empty($param['status_tele']) && ($param['status_tele'] != 'all')) {
        //     $this->db->where('list_referral.status_tele', $param['status_tele']);
        // }
        // if (!empty($param['referror']) && ($param['referror'] != 'all')) {
        //     $this->db->where('list_referral.referral', $param['referror']);
        // }
        // $query = $this->db->get('list_referral');

        $data        = $this->model_task->export_data_referral($this->input->get());
        $filename     = "Report_Data_Referral_" . strtotime(setNewDateTime());
        exportToExcel($data, 'Sheet 1', $filename);
    }
}

/* End of file Referral.php */
/* Location: ./application/controllers/user/Referral.php */
