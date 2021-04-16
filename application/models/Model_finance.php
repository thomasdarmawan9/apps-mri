<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_finance extends CI_Model
{

	public function contruct()
	{
		parent::__construct();
	}

    public function get_now_transaction()
	{
		$pt = unserialize($this->session->userdata('is_id_pt'));
		$in = '(' . implode(',', $pt) . ')';
		$bln = date("m");
		$query = $this->db->query("SELECT SUM(income)-SUM(expense) AS nl FROM fc_transaksi WHERE MONTH(tgl_nota) = '" . $bln . "' AND fc_transaksi.id_pt IN $in");
		//$query = $this->db->query("SELECT SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as nl FROM fc_transaksi INNER JOIN fc_bank ON fc_transaksi.id_bank = fc_bank.id_bank WHERE fc_transaksi.tgl_nota between DATE_FORMAT(CURDATE() ,'%Y-%m-01') AND DATE_FORMAT(CURDATE() ,'%Y-%m-31') AND fc_bank.id_pt IN $in");
		foreach ($query->result() as $ot) {
			$over = $ot->nl;
		}

		return $over;
	}

	public function get_last_transaction()
	{
		$pt = unserialize($this->session->userdata('is_id_pt'));
		$in = '(' . implode(',', $pt) . ')';
		$bln = date("m") - 1;
		$query = $this->db->query("SELECT SUM(income)-SUM(expense) as nl FROM fc_transaksi WHERE MONTH(tgl_nota) = '" . $bln . "' AND fc_transaksi.id_pt IN $in");
		//$query = $this->db->query("SELECT SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as nl FROM fc_transaksi INNER JOIN fc_bank ON fc_transaksi.id_bank = fc_bank.id_bank WHERE fc_transaksi.tgl_nota >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY) and fc_transaksi.tgl_nota <= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND fc_bank.id_pt IN $in");
		foreach ($query->result() as $ot) {
			$over = $ot->nl;
		}

		return $over;
	}

	public function get_my_transaction($id)
	{
        $bln = date("m");
        $query = $this->db->query("SELECT SUM(income)-SUM(expense) as myth FROM fc_transaksi WHERE MONTH(tgl_nota) = '" . $bln . "' AND id_pt='$id'");
		//$query = $this->db->query("SELECT SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as myth FROM fc_transaksi INNER JOIN fc_bank ON fc_transaksi.id_bank = fc_bank.id_bank WHERE fc_transaksi.tgl_nota between DATE_FORMAT(CURDATE() ,'%Y-%m-01') AND DATE_FORMAT(CURDATE() ,'%Y-%m-31') AND fc_bank.id_pt='$id'");
		foreach ($query->result() as $ot) {
			$over = $ot->myth;
		}

		return $over;
	}

	public function get_my_income($id)
	{
        $bln = date("m");
        $query = $this->db->query("SELECT SUM(income) as nl FROM fc_transaksi WHERE MONTH(tgl_nota) = '" . $bln . "' AND id_pt='$id'");
		//$query = $this->db->query("SELECT SUM(fc_transaksi.income) as nl FROM fc_transaksi INNER JOIN fc_bank ON fc_transaksi.id_bank = fc_bank.id_bank WHERE fc_transaksi.tgl_nota between DATE_FORMAT(CURDATE() ,'%Y-%m-01') AND DATE_FORMAT(CURDATE() ,'%Y-%m-31') AND fc_bank.id_pt='$id'");
		foreach ($query->result() as $ot) {
			$over = $ot->nl;
		}

		return $over;
	}

	public function get_my_expense($id)
	{
        $bln = date("m");
		$query = $this->db->query("SELECT SUM(expense) as nl FROM fc_transaksi WHERE MONTH(tgl_nota) = '" . $bln . "' AND id_pt='$id'");
		//$query = $this->db->query("SELECT SUM(fc_transaksi.expense) as nl FROM fc_transaksi INNER JOIN fc_bank ON fc_transaksi.id_bank = fc_bank.id_bank WHERE fc_transaksi.tgl_nota between DATE_FORMAT(CURDATE() ,'%Y-%m-01') AND DATE_FORMAT(CURDATE() ,'%Y-%m-31') AND fc_bank.id_pt='$id'");
		foreach ($query->result() as $ot) {
			$over = $ot->nl;
		}

		return $over;
	}


	public function get_dashboard_finance()
	{
	   $this->db->select('fc_bank.id_bank, fc_bank.name, fc_bank.saldo_awal, fc_bank.atas_nama, fc_pt.name as pt, fc_pt.id_pt, fc_transaksi.income, fc_transaksi.expense ,SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as nl, SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as tr, SUM(fc_transaksi.income) as ic, SUM(fc_transaksi.expense) as ex, fc_transaksi.tgl_nota');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		
		$bln = date("m");
		$where = "MONTH(fc_transaksi.tgl_nota) = '" . $bln . "'";
		
		if ($this->session->userdata('id') == '67') {
		    $this->db->group_by('fc_bank.id_pt');
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->where($where);
			$this->db->group_by('fc_transaksi.id_pt');
			//$query = ("fc_transaksi.tgl_nota between DATE_FORMAT(CURDATE() ,'%Y-%m-01') AND DATE_FORMAT(CURDATE() ,'%Y-%m-31')");
			//$this->db->group_by('fc_transaksi.id_bank');
			//$this->db->where('fc_transaksi.tgl_nota >=', date('Y-m-01'));
			//$this->db->where('fc_transaksi.tgl_nota <=', date('Y-m-31'));
			//$date_start = date('%Y-09-01');
			//$date_end = date('%Y-09-31');
			//$this->db->where_in(array('fc_transaksi.tgl_nota =>' => $date_start, 'fc_transaksi.tgl_nota <=' => $date_end));
			$this->db->order_by('fc_bank.name', 'ASC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		} else if (($this->session->userdata('id') != '67') && ($this->session->userdata('is_pt') == true)) {
		    $this->db->group_by('fc_bank.id_pt');
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			//$this->db->group_by('fc_transaksi.id_bank');
			//$this->db->group_by('fc_transfer_in.id_bank');
		    //$this->db->where('fc_transaksi.tgl_nota >=', date('Y-m-01'));
			//$this->db->where('fc_transaksi.tgl_nota <=', date('Y-m-31'));
			$this->db->where($where);
			$this->db->group_by('fc_transaksi.id_pt');
			$this->db->order_by('fc_bank.name', 'ASC');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		}
	}

	public function get_dashboard_detail($id)
	{
	    $bln = date("m");
		$where = "MONTH(fc_transaksi.tgl_nota) = '" . $bln . "'";
		
		$this->db->select('fc_bank.id_bank, fc_bank.rek_bank, fc_bank.name, fc_bank.saldo_awal, fc_bank.atas_nama ,fc_bank.saldo_awal+SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as nl, SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as tr, SUM(fc_transaksi.income) as ic, SUM(fc_transaksi.expense) as ex, fc_pt.name as pt');
		$this->db->from('fc_bank');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->join('fc_transaksi', 'fc_transaksi.id_bank = fc_bank.id_bank', 'left');
		$this->db->group_by('fc_bank.id_bank');
		$this->db->where('fc_bank.id_pt', $id);
		$this->db->where($where);

		$this->db->where('fc_bank.id_pt', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}	
	
	public function get_lock()
	{
		$this->db->select('fc_transaction_setting.*, fc_bank.name as bank, fc_pt.name as pt');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaction_setting.id_bank', 'left');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->where('fc_transaction_setting.id', 1);
		$query = $this->db->get('fc_transaction_setting');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_lock_transaction()
	{
		$this->db->where('id', 1);
		$query = $this->db->get('fc_transaction_setting');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $r) {
				$lock = $r->lock;
			}
			return $lock;
		} else {
			return false;
		}
	}
	
	function transaction_lock($status, $id_bank)
	{
		if ($status == 'LOCKED') {
			$data = array(
				'lock' => '',
				'id_bank' => ''
			);
		} else {
			$data = array(
				'lock' => 'yes',
				'id_bank' => $id_bank
			);
		};

		$this->db->where('id', 1);
		$this->db->update('fc_transaction_setting', $data);

		return true;
	}
	
	public function get_list_bank_from($bank_from)
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt,');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->where('fc_bank.id_bank', $bank_from);
		$this->db->order_by('fc_bank.id_bank', 'desc');
		return $this->db->get('fc_bank')->result_array();
	}

	public function get_list_bank_to($bank_to)
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->where('fc_bank.id_bank', $bank_to);
		$this->db->order_by('fc_bank.id_bank', 'desc');
		return $this->db->get('fc_bank')->result_array();
	}
	
	public function insert_pt($data)
	{
		return $this->db->insert('fc_pt', $data);
	}

	public function update_pt($data, $id)
	{
		$this->db->where('id_pt', $id);
		return $this->db->update('fc_pt', $data);
	}
	
	public function get_detail_pt($id)
	{
		return $this->db->get_where('fc_pt', array('id_pt' => $id))->row_array();
	}

	public function hapus_pt($id)
	{
		$this->db->where('id_pt', $id);
		$this->db->delete('fc_pt');

		return true;
	}
	
	public function insert_hdivisi($data)
	{
		return $this->db->insert('fc_hdivisi', $data);
	}

	public function update_hdivisi($data, $id)
	{
		$this->db->where('id_hdivisi', $id);
		return $this->db->update('fc_hdivisi', $data);
	}
	
	public function get_detail_hdivisi($id)
	{
		return $this->db->get_where('fc_hdivisi', array('id_hdivisi' => $id))->row_array();
	}
	
	public function hapus_hdivisi($id)
	{
		$this->db->where('id_hdivisi', $id);
		$this->db->delete('fc_hdivisi');

		return true;
	}
	
	public function insert_divisi($data)
	{
		return $this->db->insert('fc_divisi', $data);
	}

	public function update_divisi($data, $id)
	{
		$this->db->where('id_divisi', $id);
		return $this->db->update('fc_divisi', $data);
	}
	
	public function get_detail_divisi($id)
	{
		return $this->db->get_where('fc_divisi', array('id_divisi' => $id))->row_array();
	}
	
	public function hapus_divisi($id)
	{
		$this->db->where('id_divisi', $id);
		$this->db->delete('fc_divisi');

		return true;
	}
	
	public function insert_indeks($data)
	{
		return $this->db->insert('fc_indeks', $data);
	}

	public function update_indeks($data, $id)
	{
		$this->db->where('id_indeks', $id);
		return $this->db->update('fc_indeks', $data);
	}
	
	public function get_list_divisi($id_divisi)
	{
		$this->db->select('fc_indeks.*, fc_divisi.nama_divisi as divisi, fc_hdivisi.nama_hdivisi as hdivisi');
		$this->db->join('fc_hdivisi', 'fc_hdivisi.id_hdivisi = fc_indeks.head_divisi', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi    = fc_indeks.id_divisi', 'left');
		$this->db->where('fc_indeks.id_divisi', $id_divisi);
		$this->db->order_by('fc_indeks.id_divisi', 'desc');
		return $this->db->get('fc_indeks')->result_array();
	}
	
	public function get_detail_indeks($id)
	{
		return $this->db->get_where('fc_indeks', array('id_indeks' => $id))->row_array();
	}
	
	public function get_list_indeks($id_divisi)
	{
		$this->db->select('fc_indeks.*, fc_divisi.nama_divisi as divisi, fc_hdivisi.nama_hdivisi as hdivisi');
		$this->db->join('fc_hdivisi', 'fc_hdivisi.id_hdivisi = fc_indeks.head_divisi', 'right');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi    = fc_indeks.id_divisi', 'left');
		$this->db->where('fc_indeks.id_divisi', $id_divisi);
		$this->db->order_by('fc_indeks.id_divisi', 'desc');
		return $this->db->get('fc_indeks')->result_array();
	}
	
	/*public function get_list_indeks($id_divisi = null)
	{
		if (!empty($id_divisi)) {
			$this->db->where('id_divisi', $id_divisi);
			$this->db->order_by('id_divisi', 'desc');
		} else {
			$this->db->order_by('id_divisi');
		}
		return $this->db->get('fc_indeks')->result_array();
	}*/
	
	public function hapus_indeks($id)
	{
		$this->db->where('id_indeks', $id);
		$this->db->delete('fc_indeks');

		return true;
	}
	
	public function tambah_accountant($nama, $username, $pass, $status, $id_pt)
	{
		$data = array(
			'name' => ucwords($nama),
			'username' => strtolower($username),
			'password' => $pass,
			'email' => '-',
			'id_divisi' => '34',
			'status' => $status,
			'level' => 'finance',
			'id_pt' => $id_pt
		);

		$this->db->insert('user', $data);
		$this->db->where('username', $username);
		$query = $this->db->get('user');

		foreach ($query->result() as $n) {
			$nm = $n->id;
		}

		return true;
	}
	
	public function edit_accountant($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('user', $data);
	}
	
	public function hapus_accountant($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('user');

		return true;
	}
	
	public function insert($data)
	{
		return $this->db->insert('fc_bank', $data);
	}

	public function update($data, $id)
	{
		$this->db->where('id_bank', $id);
		return $this->db->update('fc_bank', $data);
	}
	
	public function get_banktopt($id_bank)
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->where('fc_bank.id_bank', $id_bank);
		$this->db->order_by('fc_bank.id_bank', 'desc');
		return $this->db->get('fc_bank')->result();
	}
	
	public function get_bank_detail($id)
	{
		return $this->db->get_where('fc_bank', array('id_bank' => $id))->row_array();
	}
	
	public function hapus_bank($id)
	{
		$this->db->where('id_bank', $id);
		$this->db->delete('fc_bank');

		return true;
	}
	
	public function get_bank_drop()
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt');
		$this->db->from('fc_bank');
		$this->db->join('user', 'user.id_pt = fc_bank.id_pt', 'left');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		if ($this->session->userdata('id') == '67') {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			//$in = implode(',', $pt);
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->order_by('fc_bank.name', 'ASC');
			$query = $this->db->get();
			return $query->result();
		} else {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			//$in = implode(',', $pt);
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->order_by('fc_bank.name', 'ASC');
			$query = $this->db->get();
			return $query->result();
		}
	}
	
	public function get_bank_nomerator()
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt');
		$this->db->from('fc_bank');
		$this->db->join('user', 'user.id_pt = fc_bank.id_pt', 'left');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->order_by('fc_bank.name', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_income()
	{
		$this->db->select('fc_transaksi.*, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
						  fc_indeks.no_indeks, fc_indeks.nama_indeks');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		//$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		//$this->db->join('user', 'user.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		if ($this->session->userdata('id') == '67') {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$where = "fc_transaksi.jenis='income' OR fc_transaksi.jenis = 'all'";
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") >=',  date("m", strtotime("-2 month")));
// 			$this->db->or_where('DATE_FORMAT(tgl_nota,"%m")', date('m'));
			$this->db->where($where);
			$this->db->order_by('fc_transaksi.key_number', 'ASC');
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');
			$this->db->order_by('fc_transaksi.id_trans', 'ASC');
		
// 			$date = date('m');
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m")', $date);
// 			$this_month = date('m');
//  			$limit_month = date('m') - 3;
//  			$this->db->where('DATE_FORMAT(date_created,"%m") >=', $limit_month);
// / 			$this->db->where('DATE_FORMAT(date_created,"%m") <=', $this_month);
		
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		} else if ($this->session->userdata('is_pt') == true) {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$where = "fc_transaksi.jenis='income' OR fc_transaksi.jenis = 'all'";
			$this->db->where('DATE_FORMAT(tgl_nota,"%m")', date('m'));
			$this->db->where($where);
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") >=', $limit_month);
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") <=', $this_month);
// 			$date = date('m');
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m")', $date);
// 			$this_month = date('m');
// 			$limit_month = date('m') - 3;
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") >=', $limit_month);
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") <=', $this_month);
		
			$this->db->order_by('fc_transaksi.key_number', 'ASC');
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');
			$this->db->order_by('fc_transaksi.id_trans', 'ASC');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		}
	}
	
	public function get_income_divisi()
	{
		$where = "jenis='income' OR jenis = 'all'";
		$this->db->where($where);
		$this->db->order_by('no_divisi');
		$query = $this->db->get('fc_divisi');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function tampil_data_chained($id)
	{
		$query = $this->db->query("SELECT * FROM fc_indeks LEFT JOIN fc_divisi ON fc_indeks.id_divisi=fc_divisi.id_divisi WHERE fc_divisi.id_divisi = '$id'");
		return $query;
	}
	
	public function tampil_data_chained_head($id)
	{
	    $query = $this->db->query("SELECT * FROM fc_hdivisi LEFT JOIN fc_divisi ON fc_hdivisi.id_hdivisi=fc_divisi.head_divisi WHERE fc_divisi.id_divisi = '$id'");
		return $query;
	}
	
	public function get_key()
	{
		$q = $this->db->query("SELECT MAX(RIGHT(key_number,4)) AS kd FROM fc_transaksi WHERE DATE(date_created)=CURDATE()");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int) $k->kd) + 1;
				$kd = sprintf("%04s", $tmp);
			}
		} else {
			$kd = "0001";
		}
		date_default_timezone_set('Asia/Jakarta');
		return 'mr' . date('md') . $kd;
	}
	
	public function insert_transaction($data)
	{
		return $this->db->insert('fc_transaksi', $data);
	}
	
	public function insert_transaction_income($key_number, $id_bank, $id_pt, $id_divisi, $head_divisi, $id_indeks, $user, $is_transfer, $receipt_number, $jenis, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $expense, $total_income, $date)
	{
		$data = array(
			'key_number'  	 => $key_number,
			'id_bank'  	 	 => $id_bank,
			'id_pt'  	 	 => $id_pt,
			'id_divisi' 	 => $id_divisi,
			'id_hdivisi' 	 => $head_divisi,
			'id_indeks' 	 => $id_indeks,
			'id_user' 	 	 => $user,
			'is_transfer' 	 => $is_transfer,
			'receipt_number' => $receipt_number,
			'jenis' 	   	 => $jenis,
			'tgl_nota'  	 => $tgl_nota,
			'bon' 	   	 	 => $bon,
			'transaksi' 	 => $transaksi,
			'jumlah'    	 => $jumlah,
			'harga' 	     => $harga,
			'expense'	 	 => $expense,
			'income' 	 	 => $total_income,
			'date_created' 	 => $date,
		);

		return $this->db->insert('fc_transaksi', $data);
	}
	
	public function insert_transaction_expense($key_number, $id_bank, $id_pt, $id_divisi, $head_divisi, $id_indeks, $user, $is_transfer, $receipt_number, $jenis, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $income, $total_expense, $date)
	{
		$data = array(
			'key_number'  	 => $key_number,
			'id_bank'  	 	 => $id_bank,
			'id_pt'  	 	 => $id_pt,
			'id_divisi' 	 => $id_divisi,
			'id_hdivisi' 	 => $head_divisi,
			'id_indeks' 	 => $id_indeks,
			'id_user' 	 	 => $user,
			'is_transfer' 	 => $is_transfer,
			'receipt_number' => $receipt_number,
			'jenis' 	   	 => $jenis,
			'tgl_nota'  	 => $tgl_nota,
			'bon' 	   	 	 => $bon,
			'transaksi' 	 => $transaksi,
			'jumlah'    	 => $jumlah,
			'harga' 	     => $harga,
			'expense'	 	 => $total_expense,
			'income' 	 	 => $income,
			'date_created' 	 => $date,
		);

		return $this->db->insert('fc_transaksi', $data);
	}
	
	public function detail_get_income_transaction($id)
	{
		$this->db->select('fc_transaksi.*, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
		fc_indeks.no_indeks, fc_indeks.nama_indeks');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		$this->db->group_by('fc_transaksi.id_bank');
		$this->db->where('fc_transaksi.id_trans', $id);
		return $this->db->get()->row_array();
	}
	
	public function get_edit_income($id)
	{
		$this->db->select('fc_transaksi.*, SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as tr, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
						  fc_indeks.no_indeks, fc_indeks.nama_indeks, fc_pt.name as pt');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		if ($this->session->userdata('id') == '67') {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			//$where = "fc_transaksi.jenis='income' OR fc_transaksi.jenis = 'all'";
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$this->db->where('fc_transaksi.jenis', 'income');
			//$this->db->or_where('fc_transaksi.jenis', 'all');
			$this->db->group_by('fc_transaksi.id_bank');
			$this->db->where('fc_transaksi.id_trans', $id);
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');

			$query = $this->db->get();

			return $query->result();
		} else {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->group_by('fc_transaksi.id_bank');
			//$where = "fc_transaksi.jenis='income' OR fc_transaksi.jenis = 'all'";
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$this->db->where('fc_transaksi.jenis', 'income');
			//$this->db->or_where('fc_transaksi.jenis', 'all');
			$this->db->where('fc_transaksi.id_trans', $id);
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');

			$query = $this->db->get();

			return $query->result();
		}
	}

    public function update_transaction($id, $id_bank, $id_pt, $id_divisi, $id_hdivisi, $id_indeks, $id_user, $receipt_number, $jenis, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $expense, $income) //$saldo_akhir
	{
		$data = array(
			'id_bank' => $id_bank,
			'id_pt' => $id_pt,
			'id_divisi' => $id_divisi,
			'id_hdivisi' => $id_hdivisi,
			'id_indeks' => $id_indeks,
			'id_user' => $id_user,
			'receipt_number' => $receipt_number,
			'jenis' => $jenis,
			'tgl_nota' => $tgl_nota,
			'bon' => $bon,
			'transaksi' => $transaksi,
			'jumlah' => $jumlah,
			'harga' => $harga,
			'expense' => $expense,
			'income' => $income,
			//'saldo_akhir' => $saldo_akhir
		);

		$this->db->where('id_trans', $id);
		return $this->db->update('fc_transaksi', $data);
	}
	
	public function hapus_transaksi($id)
	{
		$this->db->where('id_trans', $id);
		$this->db->delete('fc_transaksi');

		return true;
	}
	
	public function get_expense()
	{
		$this->db->select('fc_transaksi.*, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
						  fc_indeks.no_indeks, fc_indeks.nama_indeks');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		//$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		//$this->db->join('user', 'user.id = fc_transaksi.id_user', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		if ($this->session->userdata('id') == '67') {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$where = "fc_transaksi.jenis='expense' OR fc_transaksi.jenis = 'all'";
			$this->db->where($where);
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") >=', $limit_month);
// // 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") <=', $this_month);
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") >=',  date("m", strtotime("-2 month")));
// 			$this->db->or_where('DATE_FORMAT(tgl_nota,"%m")', date('m'));
		
	    	$this->db->order_by('fc_transaksi.key_number', 'ASC');
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');
			$this->db->order_by('fc_transaksi.id_trans', 'ASC');
// 			$this_month = date('m');
// 			$limit_month = date('m') - 2;
// 			$this->db->where('DATE_FORMAT(date_created,"%m") >=', $limit_month);
// 			$this->db->where('DATE_FORMAT(date_created,"%m") <=', $this_month);
		
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		} else if ($this->session->userdata('is_pt') == true) {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$where = "fc_transaksi.jenis='expense' OR fc_transaksi.jenis = 'all'";
			$this->db->where('DATE_FORMAT(tgl_nota,"%m")', date('m'));
			$this->db->where($where);
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m")', date('m'));
// 			$this->db->where('DATE_FORMAT(tgl_nota,"%m") >=',  date("m", strtotime("-2 month")));
// 			$this->db->or_where('DATE_FORMAT(tgl_nota,"%m")', date('m'));
		
// 			$this_month = date('m');
// 			$limit_month = date('m') - 2;
// 			$this->db->where('DATE_FORMAT(date_created,"%m") >=', $limit_month);
// 			$this->db->where('DATE_FORMAT(date_created,"%m") <=', $this_month);
			
		    $this->db->order_by('fc_transaksi.key_number', 'ASC');
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');
			$this->db->order_by('fc_transaksi.id_trans', 'ASC');

			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		}
	}
	
	public function get_expense_divisi()
	{
		$where = "jenis='expense' OR jenis = 'all'";
		$this->db->where($where);
		$this->db->order_by('no_divisi');
		$query = $this->db->get('fc_divisi');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function detail_get_expense_transaction($id)
	{
		$this->db->select('fc_transaksi.*, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
		fc_indeks.no_indeks, fc_indeks.nama_indeks');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		$this->db->group_by('fc_transaksi.id_bank');
		$this->db->group_by('fc_bank.id_bank');
		$this->db->where('fc_transaksi.id_trans', $id);
		return $this->db->get()->row_array();
	}
	
	public function get_edit_expense($id)
	{
		$this->db->select('fc_transaksi.*, SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as tr, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
						  fc_indeks.no_indeks, fc_indeks.nama_indeks, fc_pt.name as pt');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		if ($this->session->userdata('id') == '67') {

			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->group_by('fc_transaksi.id_bank');
			//$where = "fc_transaksi.jenis='expense' OR fc_transaksi.jenis = 'all'";
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$this->db->where('fc_transaksi.jenis', 'expense');
			//$this->db->or_where('fc_transaksi.jenis', 'all');
			$this->db->where('fc_transaksi.id_trans', $id);
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');

			$query = $this->db->get();

			return $query->result();
		} else {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->group_by('fc_transaksi.id_bank');
			//$where = "fc_transaksi.jenis='expense' OR fc_transaksi.jenis = 'all'";
			$this->db->where_in('fc_transaksi.is_transfer', '0');
			$this->db->where('fc_transaksi.jenis', 'expense');
			//$this->db->or_where_in('fc_transaksi.jenis', 'all');
			$this->db->where('fc_transaksi.id_trans', $id);
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');

			$query = $this->db->get();

			return $query->result();
		}
	}
	
	public function get_report($parameter = array())
	{
		$this->db->select('fc_transaksi.*, fc_bank.rek_bank, fc_bank.name as bank, fc_indeks.no_indeks, fc_indeks.nama_indeks, fc_divisi.nama_divisi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');

		if ($this->session->userdata('id') == '67') {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
		} else {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
		}

		if (!empty($parameter['date_start'])) {
			$this->db->where('fc_transaksi.tgl_nota >=', $parameter['date_start']);
		}

		if (!empty($parameter['date_end'])) {
			$this->db->where('fc_transaksi.tgl_nota <=', $parameter['date_end']);
		}

		if (!empty($parameter) && $parameter['id_bank'] != 'all') {
			$this->db->where('fc_bank.id_bank', $parameter['id_bank']);
		}

		if (!empty($parameter) && $parameter['id_divisi'] != 'all') {
			$this->db->where('fc_divisi.id_divisi', $parameter['id_divisi']);
		}

		if (!empty($parameter) && $parameter['id_indeks'] != 'all') {
			$this->db->where_in('fc_indeks.id_indeks', array($parameter['id_indeks'], $parameter['index']));
		}
		
		if (!empty($parameter) && $parameter['is_transfer'] != 'all') {
			$this->db->where('fc_transaksi.is_transfer', $parameter['is_transfer']);
		}

		/*if ($this->input->get('add_index') == 'on') {
			if (!empty($parameter) && $parameter['index'] != 'all') {
				$this->db->where_in('fc_indeks.id_indeks', $parameter['index']);
			}
		}*/
        $pt = unserialize($this->session->userdata('is_id_pt'));
		$this->db->where_in('fc_bank.id_pt', $pt);
		$this->db->order_by('fc_transaksi.id_trans', 'ASC');
		$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');
		return $this->db->get('fc_transaksi')->result_array();
	}
	
	public function detail_get_report_monthly($id)
	{
		$this->db->select('fc_transaksi.*, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
		fc_indeks.no_indeks, fc_indeks.nama_indeks');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		$this->db->group_by('fc_transaksi.id_bank');
		$this->db->where('fc_transaksi.id_trans', $id);
		return $this->db->get()->row_array();
	}
	
	public function get_edit_report($id)
	{
		$this->db->select('fc_transaksi.*, SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as tr, fc_bank.rek_bank, fc_bank.name as bank, fc_divisi.no_divisi, fc_divisi.nama_divisi, 
						  fc_indeks.no_indeks, fc_indeks.nama_indeks, fc_pt.name as pt');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		if ($this->session->userdata('id') == '67') {

			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->group_by('fc_transaksi.id_bank');
			$this->db->where('fc_transaksi.id_trans', $id);
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');

			$query = $this->db->get();

			return $query->result();
		} else {
			$pt = unserialize($this->session->userdata('is_id_pt'));
			$this->db->where_in('fc_bank.id_pt', $pt);
			$this->db->group_by('fc_transaksi.id_bank');
			$this->db->where('fc_transaksi.id_trans', $id);
			$this->db->order_by('fc_transaksi.tgl_nota', 'ASC');

			$query = $this->db->get();

			return $query->result();
		}
	}
	
	public function update_report($id, $id_bank, $id_pt, $id_divisi, $id_hdivisi, $id_indeks, $id_user, $receipt_number, $tgl_nota, $bon, $transaksi, $jumlah, $harga, $expense, $income) //$saldo_akhir
	{
		$data = array(
			'id_bank' => $id_bank,
			'id_pt' => $id_pt,
			'id_divisi' => $id_divisi,
			'id_hdivisi' => $id_hdivisi,
			'id_indeks' => $id_indeks,
			'id_user' => $id_user,
			'receipt_number' => $receipt_number,
			'tgl_nota' => $tgl_nota,
			'bon' => $bon,
			'transaksi' => $transaksi,
			'jumlah' => $jumlah,
			'harga' => $harga,
			'expense' => $expense,
			'income' => $income,

		);

		$this->db->where('id_trans', $id);
		return $this->db->update('fc_transaksi', $data);
	}
	
	public function delete_report($id)
	{
		$this->db->where('id_trans', $id);
		$this->db->delete('fc_transaksi');

		return true;
	}
	
	public function export_data_report_monthly($parameter = array())
	{
		$this->db->select('fc_transaksi.id_trans, fc_transaksi.tgl_nota as Tanggal Nota, user.name as Writen By, fc_bank.name as Payment Source, fc_transaksi.receipt_number as Receipt Number ,fc_transaksi.is_transfer as Transfer, fc_transaksi.jenis as Type, fc_divisi.nama_divisi as Divisi, fc_indeks.nama_indeks as Indeks, fc_transaksi.bon as Bon, fc_transaksi.transaksi as Transaction, fc_transaksi.jumlah as Qty, fc_transaksi.harga as Price, fc_transaksi.income as Db, fc_transaksi.expense as Cr, fc_bank.saldo_awal as Saldo Awal, as Saldo');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		$this->db->join('user', 'user.id = fc_transaksi.id_user', 'left');
		if (!empty($parameter['date_start'])) {
			$this->db->where('fc_transaksi.tgl_nota >=', $parameter['date_start']);
		}

		if (!empty($parameter['date_end'])) {
			$this->db->where('fc_transaksi.tgl_nota <=', $parameter['date_end']);
		}

		if (!empty($parameter) && $parameter['id_bank'] != 'all') {
			$this->db->where('fc_bank.id_bank', $parameter['id_bank']);
		}

		if (!empty($parameter) && $parameter['id_divisi'] != 'all') {
			$this->db->where('fc_divisi.id_divisi', $parameter['id_divisi']);
		}

		if (!empty($parameter) && $parameter['id_indeks'] != 'all') {
			$this->db->where_in('fc_indeks.id_indeks', array($parameter['id_indeks'], $parameter['index']));
		}
		
		if (!empty($parameter) && $parameter['is_transfer'] != 'all') {
			$this->db->where('fc_transaksi.is_transfer', $parameter['is_transfer']);
		}
		
		
        $pt = unserialize($this->session->userdata('is_id_pt'));
		$this->db->where_in('fc_bank.id_pt', $pt);
		$this->db->order_by('fc_transaksi.tgl_nota');
		return $this->db->get('fc_transaksi');
	}
	
	public function get_transfer()
	{
		$this->db->select('fc_transaksi.*, fc_bank.name as bank, fc_divisi.nama_divisi, fc_indeks.nama_indeks');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_divisi', 'fc_divisi.id_divisi = fc_transaksi.id_divisi', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');
		$this->db->join('user', 'user.id = fc_transaksi.id_user', 'left');
		//$this->db->where('fc_transaksi.bank_from', 1);
		$this->db->where('fc_transaksi.is_transfer', 1);
		$this->db->order_by('fc_transaksi.id_trans', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_detail_bank($id_bank)
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->where('fc_bank.id_bank', $id_bank);
		$this->db->order_by('fc_bank.id_bank', 'desc');
		return $this->db->get('fc_bank')->result_array();
	}
	
	public function get_saldo_awal($id)
	{

		$this->db->select('*');
		$this->db->from('fc_bank');
		$this->db->group_by('id_bank');
		$this->db->where('id_bank', $id);
		$query = $this->db->get();
		return $query->row_array();

		//return $this->db->get_where('fc_bank', array('id_bank' => $id))->row_array();
	}

	public function get_saldo($id)
	{
		$this->db->select('fc_transaksi.*, fc_bank.saldo_awal+SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as yaaa');
		$this->db->from('fc_transaksi');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->group_by('fc_transaksi.id_bank');
		$this->db->where('fc_transaksi.id_bank', $id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_detail_bank_transfer($id)
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt, fc_bank.name as bank');
		$this->db->from('fc_bank');
		//$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_bank.id_pt', 'left');
		$this->db->group_by('id_bank');
		$this->db->where('id_bank', $id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_bank_key()
	{
		$this->db->select('fc_bank.*, fc_pt.name as pt');
		$this->db->join('fc_pt', 'fc_bank.id_pt = fc_pt.id_pt', 'left');
		$this->db->order_by('fc_bank.name', 'asc');
		$query = $this->db->get('fc_bank');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function insert_transfer_expense($data_expense)
	{
		return $this->db->insert('fc_transaksi', $data_expense);
	}

	public function insert_transfer_income($data_income)
	{
		return $this->db->insert('fc_transaksi', $data_income);
	}
	
	public function automation_code()
	{
		$q = $this->db->query("SELECT MAX(RIGHT(transfer_code,3)) AS kd FROM fc_transaksi WHERE DATE(date_created)=CURDATE()");
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
	
	public function hapus_transfer($tc)
	{
		$this->db->where('transfer_code', $tc);
		$this->db->delete('fc_transaksi');

		return true;
	}
	
	public function get_pt_summary($parameter = array())
	{
		$pt 	= $parameter['id_pt'];
		$this->db->select('name as pt');
		$this->db->where('id_pt', $pt);
		$query = $this->db->get('fc_pt');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_finance_summary($parameter = array())
	{
		$this->db->select('fc_bank.name as bank, fc_transaksi.tgl_nota, fc_indeks.nama_indeks as indeks, fc_transaksi.transaksi, fc_transaksi.jumlah as qty, fc_transaksi.harga as price, fc_transaksi.income, fc_transaksi.expense');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');

		$pt 	= $parameter['id_pt'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$this->db->where('fc_transaksi.id_pt', $pt);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%m')", $vbulan);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%Y')", $vtahun);
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('fc_transaksi.tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_finance_summary_income($parameter = array())
	{
		$this->db->select('fc_bank.name as bank, fc_transaksi.tgl_nota, fc_indeks.nama_indeks as indeks, fc_transaksi.transaksi, fc_transaksi.jumlah as qty, fc_transaksi.harga as price, fc_transaksi.income, fc_transaksi.expense');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');

		$pt 	= $parameter['id_pt'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$this->db->where('fc_transaksi.id_pt', $pt);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%m')", $vbulan);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%Y')", $vtahun);
		$this->db->where('fc_transaksi.jenis', 'income');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('fc_transaksi.tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_finance_summary_expense($parameter = array())
	{
		$this->db->select('fc_bank.name as bank, fc_transaksi.tgl_nota, fc_indeks.nama_indeks as indeks, fc_transaksi.transaksi, fc_transaksi.jumlah as qty, fc_transaksi.harga as price, fc_transaksi.income, fc_transaksi.expense');
		$this->db->join('fc_pt', 'fc_pt.id_pt = fc_transaksi.id_pt', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');

		$pt 	= $parameter['id_pt'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$this->db->where('fc_transaksi.id_pt', $pt);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%m')", $vbulan);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%Y')", $vtahun);
		$this->db->where('fc_transaksi.jenis', 'expense');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('fc_transaksi.tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}


	public function get_initial_balance($parameter = array())
	{
		$pt  = $parameter['id_pt'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		//$query = $this->db->query("SELECT SUM(DISTINCT(fc_bank.saldo_awal))+SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as ibalance FROM fc_transaksi RIGHT JOIN fc_bank ON fc_bank.id_pt=fc_transaksi.id_pt WHERE fc_bank.id_pt='$pt' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%m')='$vbulan'-1 AND DATE_FORMAT(fc_transaksi.tgl_nota, '%Y')='$vtahun'");

		$query = $this->db->query("SELECT SUM(total) as ibalance FROM (SELECT SUM(DISTINCT(fc_bank.saldo_awal)) AS total FROM fc_bank WHERE fc_bank.id_pt='$pt' UNION ALL SELECT (SUM(fc_transaksi.income)-SUM(fc_transaksi.expense)) AS total FROM fc_transaksi WHERE fc_transaksi.id_pt='$pt' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%m')='$vbulan'-1 AND DATE_FORMAT(fc_transaksi.tgl_nota, '%Y')='$vtahun' AND fc_transaksi.is_transfer='0') a");

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}


	public function get_final_balance($parameter = array())
	{

		$pt  = $parameter['id_pt'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		//$query = $this->db->query("SELECT SUM(DISTINCT(fc_bank.saldo_awal))+SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as fbalance FROM fc_transaksi RIGHT JOIN fc_bank ON fc_bank.id_pt=fc_transaksi.id_pt WHERE fc_bank.id_pt='$pt' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%m')='$vbulan' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%Y')='$vtahun'");

		$query = $this->db->query("SELECT SUM(total) as fbalance FROM (SELECT SUM(DISTINCT(fc_bank.saldo_awal)) AS total FROM fc_bank WHERE fc_bank.id_pt='$pt' UNION ALL SELECT (SUM(fc_transaksi.income)-SUM(fc_transaksi.expense)) AS total FROM fc_transaksi WHERE fc_transaksi.id_pt='$pt' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%m')='$vbulan' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%Y')='$vtahun' AND fc_transaksi.is_transfer='0') a");

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_balance_finsum($parameter = array())
	{
		$this->db->select('SUM(income)-SUM(expense) as blnc');

		if (!empty($parameter['id_pt'])) {
			$this->db->where('id_pt', $parameter['id_pt']);
		}

		if (!empty($parameter['month'])) {
			$vbulan = $parameter['month'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%m') >=", $vbulan);
		}

		if (!empty($parameter['tahun'])) {
			$vtahun = $parameter['tahun'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%Y')", $vtahun);
		}

		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_income_finsum($parameter = array())
	{
		$this->db->select('SUM(income) as inc');

		if (!empty($parameter['id_pt'])) {
			$this->db->where('id_pt', $parameter['id_pt']);
		}

		if (!empty($parameter['month'])) {
			$vbulan = $parameter['month'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%m')", $vbulan);
		}

		if (!empty($parameter['tahun'])) {
			$vtahun = $parameter['tahun'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%Y')", $vtahun);
		}

		$this->db->where('fc_transaksi.jenis', 'income');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_expense_finsum($parameter = array())
	{
		$this->db->select('SUM(expense) as exp');

		if (!empty($parameter['id_pt'])) {
			$this->db->where('id_pt', $parameter['id_pt']);
		}

		if (!empty($parameter['month'])) {
			$vbulan = $parameter['month'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%m')", $vbulan);
		}

		if (!empty($parameter['tahun'])) {
			$vtahun = $parameter['tahun'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%Y')", $vtahun);
		}

		$this->db->where('fc_transaksi.jenis', 'expense');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	public function get_fc_mrlc()
	{
		$mrlc = array('2' => '2', '3' => '3', '4' => '4', '5' => '5', '7' => '7', '9' => '9');
		$this->db->where_in('id_hdivisi', $mrlc);
		$this->db->order_by('id_hdivisi');
		$query = $this->db->get('fc_hdivisi');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_mrlc_branch($parameter = array())
	{
		$branch 	= $parameter['branch'];
		$this->db->select('nama_hdivisi as branch');
		$this->db->where('id_hdivisi', $branch);
		$query = $this->db->get('fc_hdivisi');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_mrlc_pl($parameter = array())
	{
		$this->db->select('*');

		$branch 	= $parameter['branch'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$this->db->where('id_hdivisi', $branch);
		$this->db->where("DATE_FORMAT(tgl_nota,'%m')", $vbulan);
		$this->db->where("DATE_FORMAT(tgl_nota,'%Y')", $vtahun);
		$this->db->where('is_transfer', '0');
		$this->db->order_by('tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function initial_balance_mrlc($parameter = array())
	{
		$branch = $parameter['branch'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$query = $this->db->query("SELECT SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as ibalance FROM fc_transaksi RIGHT JOIN fc_bank ON fc_bank.id_bank=fc_transaksi.id_bank WHERE fc_transaksi.id_hdivisi='$branch' AND DATE_FORMAT(tgl_nota, '%m')='$vbulan'-1 AND DATE_FORMAT(tgl_nota, '%Y')='$vtahun' AND fc_transaksi.is_transfer='0'");

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function final_balance_mrlc($parameter = array())
	{

		$branch  = $parameter['branch'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$query = $this->db->query("SELECT SUM(fc_transaksi.income)-SUM(fc_transaksi.expense) as fbalance FROM fc_transaksi RIGHT JOIN fc_bank ON fc_bank.id_bank=fc_transaksi.id_bank WHERE fc_transaksi.id_hdivisi='$branch' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%m')='$vbulan' AND DATE_FORMAT(fc_transaksi.tgl_nota, '%Y')='$vtahun' AND fc_transaksi.is_transfer='0'");

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_balance_mrlc($parameter = array())
	{
		$this->db->select('SUM(income)-SUM(expense) as blnc');

		if (!empty($parameter['branch'])) {
			$this->db->where('id_hdivisi', $parameter['branch']);
		}

		if (!empty($parameter['month'])) {
			$vbulan = $parameter['month'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%m') >=", $vbulan);
		}

		if (!empty($parameter['tahun'])) {
			$vtahun = $parameter['tahun'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%Y')", $vtahun);
		}

		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_income_mrlc($parameter = array())
	{
		$this->db->select('SUM(income) as inc');

		if (!empty($parameter['branch'])) {
			$this->db->where('id_hdivisi', $parameter['branch']);
		}

		if (!empty($parameter['month'])) {
			$vbulan = $parameter['month'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%m')", $vbulan);
		}

		if (!empty($parameter['tahun'])) {
			$vtahun = $parameter['tahun'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%Y')", $vtahun);
		}

		$this->db->where('fc_transaksi.jenis', 'income');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_expense_mrlc($parameter = array())
	{
		$this->db->select('SUM(expense) as exp');

		if (!empty($parameter['branch'])) {
			$this->db->where('id_hdivisi', $parameter['branch']);
		}

		if (!empty($parameter['month'])) {
			$vbulan = $parameter['month'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%m')", $vbulan);
		}

		if (!empty($parameter['tahun'])) {
			$vtahun = $parameter['tahun'];
			$this->db->where("DATE_FORMAT(tgl_nota,'%Y')", $vtahun);
		}

		$this->db->where('fc_transaksi.jenis', 'expense');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_pl_mrlc($parameter = array())
	{
		$this->db->select('fc_bank.name as bank, fc_transaksi.tgl_nota, fc_hdivisi.nama_hdivisi as branch, fc_indeks.nama_indeks as indeks, fc_transaksi.transaksi, fc_transaksi.jumlah as qty, fc_transaksi.harga as price, fc_transaksi.income, fc_transaksi.expense');
		$this->db->join('fc_hdivisi', 'fc_hdivisi.id_hdivisi = fc_transaksi.id_hdivisi', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');

		$branch  = $parameter['branch'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$this->db->where('fc_transaksi.id_hdivisi', $branch);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%m')", $vbulan);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%Y')", $vtahun);
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('fc_transaksi.tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function finance_pl_income_mrlc($parameter = array())
	{
		$this->db->select('fc_bank.name as bank, fc_transaksi.tgl_nota, fc_hdivisi.nama_hdivisi as branch ,fc_indeks.nama_indeks as indeks, fc_transaksi.transaksi, fc_transaksi.jumlah as qty, fc_transaksi.harga as price, fc_transaksi.income, fc_transaksi.expense');
		$this->db->join('fc_hdivisi', 'fc_hdivisi.id_hdivisi = fc_transaksi.id_hdivisi', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');

		$branch  = $parameter['branch'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$this->db->where('fc_transaksi.id_hdivisi', $branch);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%m')", $vbulan);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%Y')", $vtahun);
		$this->db->where('fc_transaksi.jenis', 'income');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('fc_transaksi.tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function finance_pl_expense_mrlc($parameter = array())
	{
		$this->db->select('fc_bank.name as bank, fc_transaksi.tgl_nota, fc_hdivisi.nama_hdivisi as branch ,fc_indeks.nama_indeks as indeks, fc_transaksi.transaksi, fc_transaksi.jumlah as qty, fc_transaksi.harga as price, fc_transaksi.income, fc_transaksi.expense');
		$this->db->join('fc_hdivisi', 'fc_hdivisi.id_hdivisi = fc_transaksi.id_hdivisi', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = fc_transaksi.id_bank', 'left');
		$this->db->join('fc_indeks', 'fc_indeks.id_indeks = fc_transaksi.id_indeks', 'left');

		$branch  = $parameter['branch'];
		$vbulan = $parameter['month'];
		$vtahun = $parameter['tahun'];

		$this->db->where('fc_transaksi.id_hdivisi', $branch);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%m')", $vbulan);
		$this->db->where("DATE_FORMAT(fc_transaksi.tgl_nota,'%Y')", $vtahun);
		$this->db->where('fc_transaksi.jenis', 'expense');
		$this->db->where('fc_transaksi.is_transfer', '0');
		$this->db->order_by('fc_transaksi.tgl_nota');
		$query = $this->db->get('fc_transaksi');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
    
    /*=========================== Apps Nomerator ============================*/
	public function get_nomerator()
	{	
		$this->db->select('nomerator.*,user.name');
		$this->db->join('user','user.id = nomerator.id_user','left');
		
// 		if($this->session->userdata('iddivisi') == '3'){
// 			$this->db->where('tanda_terima.id_divisi','3');
// 			$this->db->where('tanda_terima.id_user',$this->session->userdata('id'));
// 		}elseif($this->session->userdata('iddivisi') == '6'){
// 			$this->db->where('tanda_terima.id_divisi','6');
// 			$this->db->where('tanda_terima.id_user',$this->session->userdata('id'));
// 		}elseif($this->session->userdata('iddivisi') == '28'){
// 			$this->db->where('tanda_terima.id_divisi','28');
// 			$this->db->where('tanda_terima.id_user',$this->session->userdata('id'));
// 		}elseif($this->session->userdata('iddivisi') == '29'){
// 			$this->db->where('tanda_terima.id_divisi','29');
// 			$this->db->where('tanda_terima.id_user',$this->session->userdata('id'));
// 		}elseif($this->session->userdata('iddivisi') == '33'){
// 			$this->db->where('tanda_terima.id_divisi','33');
// 			$this->db->where('tanda_terima.id_user',$this->session->userdata('id'));
// 		}else{
// 		    $this->db->where('tanda_terima.id_divisi',$this->session->userdata('iddivisi'));
// 			$this->db->where('tanda_terima.id_user',$this->session->userdata('id'));
// 		}

		// User Acc Tanda Terima
// 		$this->db->where('nomerator.id_divisi', $this->session->userdata('iddivisi'));
		$this->db->where('nomerator.id_user', $this->session->userdata('id'));
		$this->db->order_by('id','desc');
		$this->db->order_by('nomerator','desc');
		$this->db->order_by('date','desc');
		$query = $this->db->get('nomerator');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_accountant_datatt(){
	    $this->db->select('nomerator.*,user.name');
		$this->db->join('user','user.id = nomerator.id_user','left');
// 		//Dady
// 	   	if ($this->session->userdata('id') == '174'){
// 		$this->db->where_in('tanda_terima.id_divisi',array('28','29','33','38','39'));
// 		$this->db->where_in('tanda_terima.id_branch',array('0','1','2','3','4','7','38','39'));
//         // Akib 			
// 		}else if($this->session->userdata('id') == '180'){
// 			$this->db->where_in('tanda_terima.id_divisi',array('3','37'));
//         // Lifah 		
// 		}else if($this->session->userdata('id') == '182'){
// 			$this->db->where('tanda_terima.id_divisi','6');
// 		// Prisca
// 		}else if($this->session->userdata('id') == '181'){
// 		    $this->db->where_in('tanda_terima.id_divisi',array('29','33'));
// 		}
		
		$this->db->order_by('id','desc');
		$this->db->order_by('nomerator','desc');
		$this->db->order_by('date','desc');
		$query = $this->db->get('nomerator');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_data_nomerator($parameter = array())
	{
		$this->db->select('*');
// 		$this->db->where('status_acc','ya');
		$this->db->join('user','user.id = nomerator.id_user','left');
		if (!empty($parameter['nomerator'])) {
			$this->db->like('nomerator.nomerator', $parameter['nomerator']);
		}
		$this->db->order_by('date','desc');
// 		$this->db->order_by('nomerator','desc');
		return $this->db->get('nomerator')->result_array();
	}

	public function get_all_nomerator()
	{
		$this->db->select('nomerator.*,user.name');
		$this->db->join('user','user.id = nomerator.id_user','left');
        // $this->db->where('status_acc','ya');
		$this->db->order_by('date','desc');
// 		$this->db->order_by('nomerator','desc');
		$query = $this->db->get('nomerator');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function insert_nomerator($data, $nomerator){

		$this->db->select('nomerator');
		$this->db->where('nomerator',$nomerator);	
		$query = $this->db->get('nomerator');
		if($query->num_rows() > 0){
			return false;
		}else{
			return $this->db->insert('nomerator',$data);	
		}
	}

	public function get_tt_detail($id)
	{
		return $this->db->get_where('nomerator', array('id' => $id))->row_array();
	}

	public function update_tandaterima($data, $id, $nomerator)
	{
		$this->db->select('nomerator');
		$this->db->where('nomerator',$nomerator);
		$this->db->where_not_in('id', $id);
		$query = $this->db->get('nomerator');
		
		if($query->num_rows() > 0){
			return false;
		}else{
			$this->db->where('id',$id);
			return $this->db->update('nomerator',$data);
		}
	}

	public function delete_nomerator($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('nomerator');

		return true;
	}

	function toapprove_nomerator($id)
	{
		//Update Status
		$data = array(
			'status_acc' => 'ya',
			'tgl_approve' => date('Y-m-d')
		);

		$this->db->where('id', $id);
		$this->db->update('nomerator', $data);

		//Mendapatkan datanya
		$this->db->where('id', $id);
		$query = $this->db->get('nomerator');
		return true;
	}

	function toreject_nomerator($id)
	{
		// Update Status
		$data = array(
			'status_acc' => 'tidak',
			'tgl_approve' => date('Y-m-d')
		);

		$this->db->where('id', $id);
		$this->db->update('nomerator', $data);
		return true;
	}
	
	public function get_programtt()
	{
		$this->db->select('*');
		$this->db->where_not_in('id', array('12', '13', '14', '15', '16', '17', '18', '20', '21', '22', '23', '25', '28', '29'));
		$query = $this->db->get('list_incentive_sp');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_active_branch()
	{
		$this->db->select('*');
		$this->db->where_not_in('branch_id', array('0'));
		$query = $this->db->get('rc_branch');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_hp_branch()
	{
		$this->db->select('*');
		$this->db->where_not_in('branch_id', array('0', '8', '9'));
		$query = $this->db->get('rc_branch');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function export_report_nomerator($parameter = array())
	{
		$this->db->select('user.username as Sales, divisi.departement as Divisi, nomerator.nomerator as Nomerator, nomerator.nama_peserta as Nama Peserta, nomerator.pemilik_kartu as Pemilik Kartu, nomerator.program as Program, nomerator.jumlah as Jumlah, nomerator.date as Tanggal');
		$this->db->join('divisi','divisi.id = nomerator.id_divisi','left');
		$this->db->join('user','user.id = nomerator.id_user','left');
		$this->db->where('status_acc','ya');
		$this->db->order_by('date','desc');
		if (!empty($parameter['nomerator'])) {
			$this->db->like('nomerator.nomerator', $parameter['nomerator']);
		}
        
		$this->db->order_by('date');
		return $this->db->get('nomerator');
	}
	
	public function get_approve_fromtt()
	{
		$this->db->select('nomerator.*, user.username, fc_bank.name as bank_name');
		$this->db->join('user', 'user.id = nomerator.id_user', 'left');
		$this->db->join('fc_bank', 'fc_bank.id_bank = nomerator.bank', 'left');
		
        //Dady 		
		if ($this->session->userdata('id') == '174'){
// 		$this->db->where_in('nomerator.id_divisi',array('28','29','33','38','39'));
		$this->db->where_in('nomerator.id_branch',array('0','1','4','3'));
        // Akib 			
		}else if($this->session->userdata('id') == '180'){
			$this->db->where_in('nomerator.id_divisi',array('3','37'));
        // Lifah 		
		}else if($this->session->userdata('id') == '182'){
			$this->db->where('nomerator.id_divisi','6');
		// Prisca
		}else if($this->session->userdata('id') == '181'){
		  //  $this->db->where_in('nomerator.id_divisi',array('28', '29','33', '39'));
			$this->db->where_in('nomerator.id_branch',array('2','5', '6', '7', 10));
		}
		$this->db->order_by('nomerator.date');
		$query = $this->db->get('nomerator');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function approval_insert($data, $receipt, $tandaterima)
	{
		$data_update = array(
			'to_transaction' => 'ya',
		);
		$this->db->select('receipt_number');
		$this->db->where('receipt_number', $receipt);
		$query = $this->db->get('fc_transaksi');
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$this->db->where('id', $tandaterima);
			$this->db->update('nomerator', $data_update);

			$this->db->insert('fc_transaksi', $data);
			return true;
		}
	}
	
	public function approve_nomerator($id)
	{
		$data = array(
			'status_acc' => 'ya',
			'tgl_approve' => date('Y-m-d')
		);
		$this->db->where('id', $id);
		return $this->db->update('nomerator', $data);
	}
	
	public function get_list_nomerator($id)
	{
		return $this->db->get_where('nomerator', array('id' => $id))->row_array();
	}
	/*=========================== Apps Nomerator ============================*/

}

	

/* End of file Model_finance.php */
/* Location: ./application/models/Model_finance.php */
