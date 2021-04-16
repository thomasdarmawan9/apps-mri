<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_merchandise extends CI_Model
{

    public function contruct()
    {
        parent::__construct();
    }

    public function add_product($name, $overtime)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = array(
            'nama_product' => $name,
            'ot'           => $overtime,
            'stok'         => '0',
            'timestamp'    => date('Y-m-d H:i:s')
        );

        return $this->db->insert('product', $data);
    }

    public function update_product($id, $name, $overtime)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = array(
            'nama_product' => $name,
            'ot' => $overtime,
            'timestamp' => date('Y-m-d H:i:s')
        );

        $this->db->where('id_product', $id);
        return $this->db->update('product', $data);
    }

    public function delete_product($id)
    {
        $this->db->where('id_product', $id);
        return $this->db->delete('product');
    }

    public function get_log_merch()
    {
        $date_start = date('Y-m-d', strtotime('-30 days'));
        $date_end = date('Y-m-d', strtotime("+360 days"));
        
        $where = '(sell_on_date BETWEEN "' . $date_start . '" AND  "' . $date_end . '")';
        
        $this->db->select('log_merch.*, product.nama_product as product, product.ot as overtime');
        $this->db->join('product', 'product.id_product = log_merch.id_product', 'left');
        $this->db->where('id_user', $this->session->userdata('id'));
        $this->db->where($where);
        $query = $this->db->get('log_merch');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_product()
    {
        $query = $this->db->get('product');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_user()
    {
        $this->db->select('SUM(lembur.nilai) as nl, user.name,');
        $this->db->join('lembur', 'lembur.id_user = user.id', 'left');
        $this->db->where('user.id', $this->session->userdata('id'));
        $this->db->order_by('user.id', 'ASC');
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_list_overtime($id_product)
    {
        $this->db->where('id_product', $id_product);
        return $this->db->get('product')->result_array();
    }


    public function insert_transaction($id_log_product, $id_product, $id_user, $sell_on_date, $size, $qty, $desc, $total, $grand_total, $is_done, $is_approve, $is_reject)
    {

        if ($this->session->userdata('is_mgr') == true) {
            $iddivisi = 1;
        } else {
            $iddivisi = $this->session->userdata('iddivisi');
        }

        $this->db->select('SUM(nilai) as nl');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('lembur');

        if ($query->num_rows() == 1) {
            foreach ($query->result() as $r) {
                $nilai = $r->nl;
            }

            if ($nilai >= $total) {

                $data = array(
                    'id_log_product' => $id_log_product,
                    'id_product'     => $id_product,
                    'id_user'        => $id_user,
                    'sell_on_date'   => $sell_on_date,
                    'size'           => $size,
                    'qty'            => $qty,
                    'description'    => $desc,
                    'total'          => $grand_total,
                    'is_done'        => $is_done,
                    'is_approve'     => $is_approve,
                    'is_reject'      => $is_reject
                );

                $data_hr = array(
                    'id_log_product' => $id_log_product,
                    'id_user'        => $id_user,
                    'id_divisi'      => $iddivisi,
                    'tgl'            => $sell_on_date,
                    'deskripsi'      => $desc,
                    'nilai'          => $grand_total,
                    'status'         => 'ya',
                );

                $this->db->insert('log_merch', $data);
                $this->db->insert('lembur_app_spv', $data_hr);

                return true;
            } else {
                return false;
            }
        }
    }


    public function edit_buy_merch($id_log_product)
    {
        $this->db->select('log_merch.*, product.nama_product, product.id_product, product.ot as overtime');
        $this->db->join('log_merch', 'log_merch.id_product = product.id_product', 'left');
        $this->db->order_by('log_merch.id_log_product');
        $this->db->where('log_merch.id_log_product', $id_log_product);
        return $this->db->get('product')->row();
    }

    public function update_transaction($id, $id_product, $size, $qty, $desc, $grand_total)
    {

        $data = array(
            'id_product'     => $id_product,
            'size'           => $size,
            'qty'            => $qty,
            'description'    => $desc,
            'total'          => $grand_total
        );

        $data_hr = array(
            'deskripsi'      => $desc,
            'nilai'          => $grand_total
        );

        $this->db->where('id_log_product', $id);
        $this->db->update('log_merch', $data);

        $this->db->where('id_log_product', $id);
        $this->db->update('lembur_app_spv', $data_hr);

        return true;
    }

    public function delete_transaction($id)
    {

        $this->db->where('id_log_product', $id);
        $this->db->delete('log_merch');

        $this->db->where('id_log_product', $id);
        $this->db->delete('lembur_app_spv');

        return true;
    }

    public function automation_code()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_log_product,3)) AS kd FROM log_merch WHERE DATE(sell_on_date)=CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('Ymd') . $kd;
    }

    public function get_report_merch($parameter = array())
    {
        $this->db->select('log_merch.*, product.nama_product as product, user.username as warrior, lembur_app_spv.tgl_approved as date_approved');
        $this->db->join('product', 'product.id_product = log_merch.id_product', 'left');
        $this->db->join('lembur_app_spv', 'lembur_app_spv.id_log_product = log_merch.id_log_product', 'left');
        $this->db->join('user', 'user.id = log_merch.id_user', 'left');
        $this->db->where('log_merch.is_reject', '0');
        $this->db->where('log_merch.sell_on_date >=', $parameter['date_start']);
        $this->db->where('log_merch.sell_on_date <=', $parameter['date_end']);
        $this->db->order_by('log_merch.date_done', null);
        $this->db->order_by('log_merch.is_approve', '0');
        $query = $this->db->get('log_merch');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_completed_merch()
    {
        $query = $this->db->query("SELECT COUNT(*) as nl FROM log_merch WHERE is_approve='1' AND is_done='1'");

        foreach ($query->result() as $ot) {
            $over = $ot->nl;
        }

        return $over;
    }

    public function get_hold_merch()
    {
        $query = $this->db->query("SELECT COUNT(*) as nl FROM log_merch WHERE is_approve='1' AND is_done='0' AND is_reject='0'");

        foreach ($query->result() as $ot) {
            $over = $ot->nl;
        }

        return $over;
    }

    public function get_waiting_approve()
    {
        $query = $this->db->query("SELECT COUNT(*) as nl FROM log_merch WHERE is_reject='0' AND is_approve='0' AND is_done='0'");

        foreach ($query->result() as $ot) {
            $over = $ot->nl;
        }

        return $over;
    }

    public function get_report_completed()
    {
        $this->db->select('log_merch.*, product.nama_product as product, user.username as warrior, lembur_app_spv.tgl_approved as date_approved');
        $this->db->join('product', 'product.id_product = log_merch.id_product', 'left');
        $this->db->join('lembur_app_spv', 'lembur_app_spv.id_log_product = log_merch.id_log_product', 'left');
        $this->db->join('user', 'user.id = log_merch.id_user', 'left');
        $this->db->where('log_merch.is_approve', '1');
        $this->db->where('log_merch.is_reject', '0');
        $this->db->where('log_merch.is_done', '1');
        $query = $this->db->get('log_merch');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_report_hold()
    {
        $this->db->select('log_merch.*, product.nama_product as product, user.username as warrior, lembur_app_spv.tgl_approved as date_approved');
        $this->db->join('product', 'product.id_product = log_merch.id_product', 'left');
        $this->db->join('lembur_app_spv', 'lembur_app_spv.id_log_product = log_merch.id_log_product', 'left');
        $this->db->join('user', 'user.id = log_merch.id_user', 'left');
        $this->db->where('log_merch.is_approve', '1');
        $this->db->where('log_merch.is_reject', '0');
        $this->db->where('log_merch.is_done', '0');
        $query = $this->db->get('log_merch');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_report_waiting_approve()
    {
        $this->db->select('log_merch.*, product.nama_product as product, user.username as warrior, lembur_app_spv.tgl_approved as date_approved');
        $this->db->join('product', 'product.id_product = log_merch.id_product', 'left');
        $this->db->join('lembur_app_spv', 'lembur_app_spv.id_log_product = log_merch.id_log_product', 'left');
        $this->db->join('user', 'user.id = log_merch.id_user', 'left');
         $this->db->where('log_merch.is_done', '0');
        $this->db->where('log_merch.is_approve', '0');
        $this->db->where('log_merch.is_reject', '0');
        $query = $this->db->get('log_merch');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function done_merch($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data = array(
            'date_done' => date('Y-m-d'),
            'is_done'   => '1'
        );

        $this->db->where('id_log_product', $id);
        $this->db->update('log_merch', $data);

        return true;
    }
}


/* End of file Model_merchandise.php */
/* Location: ./application/models/Model_merchandise.php */
