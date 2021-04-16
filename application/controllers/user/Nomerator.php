<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nomerator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Model_finance');
		$this->load->model('Model_incentive');
		$this->load->model('Model_login');
		$this->load->library('form_validation');
		$this->load->helper('text');
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
    
    public function index(){
        $data['results']    = $this->Model_finance->get_nomerator();
	    $data['program']    = $this->Model_finance->get_programtt();
	    $data['branch']     = $this->Model_finance->get_active_branch();
		$data['hp_branch']  = $this->Model_finance->get_hp_branch();

        set_active_menu('Add Nomerator');
        init_view('user/content_nomerator', $data);
    }

    public function json_get_tt_detail()
	{
		$id 		= $this->input->post('id');
		$response 	= $this->Model_finance->get_tt_detail($id);
		echo json_encode($response);
	}

    public function submit_form_nomerator()
    {
	    error_reporting(0);

		$post 			= $this->input->post();
		$nomerator  	= $post['headnumber'] . $post['bodynumber'];
		$headnumber 	= $post['headnumber'];
		$lprogram   	= $post['location'];
		$holiday    	= $post['holiday'];
		$type   		= $post['type'];
		$sp   			= $post['type_psa'];
		$payment   		= $post['payment'];
		$payment_isp   	= $post['payment_isp'];
		$payment_nisp   = $post['payment_nisp'];
		$branch 		= $this->session->userdata('branch');
		$bank			= $post['bank'];
		$id_program 	= $post['program'];
		$keterangan 	= $post['keterangan'];

	    if ($id_program != 'others') {
			$this->db->select('*');
			$this->db->where('id', $id_program);
			$program = $this->db->get('list_incentive_sp')->result();

			foreach ($program as $row) {
				$program = $row->name;
				$alias   = $row->alias;
			}
		} else if ($id_program == 'others') {
			$program = 'others';
		}

		$this->db->select('branch_name');
		$this->db->where('branch_id', $branch);
		$location = $this->db->get('rc_branch')->result();

		foreach ($location as $row) {
			$location = $row->branch_name;
		}

		$this->db->select('*');
		$this->db->where('name', $bank);
		$bank = $this->db->get('fc_bank')->result();

		foreach ($bank as $row) {
			$bank = $row->id_bank;
		}

		if (($location == 'Puri Indah') || ($lprogram == 'Puri Indah')) {
			$lindex = 'PI';
		} elseif (($location == 'BSD') || ($lprogram == 'BSD')) {
			$lindex = 'BSD';
		} elseif (($location == 'Kelapa Gading') || ($lprogram == 'Kelapa Gading')) {
			$lindex = 'KG';
		} elseif (($location == 'Permata Hijau') || ($lprogram == 'Permata Hijau')) {
			$lindex = 'PH';
		} elseif (($location == 'Palem') || ($lprogram == 'Palem')) {
			$lindex = 'PL';
		} elseif (($location == 'Banjar Wijaya') || ($lprogram == 'Banjar Wijaya')) {
			$lindex = 'BW';
		} elseif (($location == 'Surabaya') || ($lprogram == 'Surabaya')) {
			$lindex = 'SBY';
		} elseif (($location == 'Semarang') || ($lprogram == 'Semarang')) {
			$lindex = 'Smg';
		} elseif (($location == 'Samarinda') || ($lprogram == 'Samarinda')) {
			$lindex = 'Smd';
		} elseif (($location == 'Bandung') || ($lprogram == 'Bandung')) {
			$lindex = 'Bdg';
		}


		if (($program == 'Public Speaking') || ($program == 'Smart Learning') || ($program == 'Life and Success')) {

			if ($type == 'fp' && $payment == 'Lunas') {
				$index		= 'Full Program OTS' . ' ' . $alias . ' ' . $lindex;
			} elseif ($type == 'fp' && $payment == 'Cicilan') {
				$index		= 'Full Program Cicilan' . ' ' . $alias . ' ' . $lindex;
			} elseif ($type == 'modul' && $payment == 'Lunas') {
				$index		= 'Modul OTS' . ' ' . $alias . ' ' . $lindex;
			} elseif ($type == 'modul' && $payment == 'Cicilan') {
				$index		= 'Modul Cicilan' . ' ' . $alias . ' ' . $lindex;
			} elseif ($type == 'upgrade' && $payment == 'Lunas') {
				$index		= 'Upgrade OTS' . ' ' . $alias . ' ' . $lindex;
			} elseif ($type == 'upgrade' && $payment == 'Cicilan') {
				$index		= 'Upgrade Cicilan OTS' . ' ' . $alias . ' ' . $lindex;
			}
		} elseif ($program == 'Holiday Program') {
			if ($holiday == 'ps' && $payment == 'Lunas') {
				$index		= 'HP Public Speaking OTS' . ' '  . $lindex;
			} elseif ($holiday == 'ps' && $payment == 'Cicilan') {
				$index		= 'HP Public Speaking Cicilan' . ' ' . $lindex;
			} elseif ($holiday == 'sl' && $payment == 'Lunas') {
				$index		= 'HP Smart Learning OTS' . ' ' . $lindex;
			} elseif ($holiday == 'sl' && $payment == 'Cicilan') {
				$index		= 'HP Smart Learning Cicilan' . ' ' . $lindex;
			} elseif ($type == 'drp' && $payment == 'Lunas') {
				$index		= 'HP Dream Planning OTS' . ' ' . $lindex;
			} elseif ($type == 'drp' && $payment == 'Cicilan') {
				$index		= 'HP Dream Planning Cicilan' . ' ' . $lindex;
			}
		} elseif ($program == 'Public Speaking Academy') {
			if (($sp == 'sp' && $payment == '')) {
				$index		= 'Sesi Perkenalan' . ' ' . $alias . ' ' . $lindex;
			} elseif ($sp == 'fp' && $payment == 'Lunas') {
				$index		= 'Full Program OTS' . ' ' . $alias . ' ' . $lindex;
			} elseif ($sp == 'fp' && $payment == 'Cicilan') {
				$index		= 'Full Program Cicilan' . ' ' . $alias . ' ' . $lindex;
			} elseif ($sp == 'modul' && $payment == 'Lunas') {
				$index		= 'Modul OTS' . ' ' . $alias . ' ' . $lindex;
			} elseif ($sp == 'modul' && $payment == 'Cicilan') {
				$index		= 'Modul Cicilan' . ' ' . $alias . ' ' . $lindex;
			}
		} elseif (($program == 'Life Camp') || ($program == 'I Love Marketing') || ($program == 'Life Mastery') || ($program == 'Train The Trainer') || ($program == 'Business Breaktrough')) {
			if ($payment_isp == 'Pelunasan') {
				$index		= $payment_isp . ' ' . 'DP' . ' ' . $alias;
			} else {
				$index		=  $payment_isp . ' ' . $alias;
			}
		} elseif ($program == 'Leadership Camp') {
			if ($payment_isp == 'Pelunasan') {
				$index		= $payment_nisp . ' ' . 'DP' . ' ' . $alias;
			} else {
				$index		=  $payment_nisp . ' ' . $alias;
			}
		} elseif ($program == 'others') {
			$index		= '';
		}

		if (($program == 'Public Speaking') || ($program == 'Smart Learning') || ($program == 'Life and Success')) {
			$description = 'Student RC an' . ' ' . $post['nama_peserta'];
		} elseif ($program == 'Public Speaking Academy') {
			if ($sp == 'sp') {
				$description		= 'SP ' . $alias . ' ' . $post['date'] . ' ' . 'an ' . $post['nama_lengkap'];
			} else {
				$description		= 	$description = 'Student RC an' . ' ' . $post['nama_peserta'];
			}
		} elseif (($program == 'Life Camp') || ($program == 'I Love Marketing') || ($program == 'Life Mastery') || ($program == 'Train The Trainer') || ($program == 'Business Breaktrough')) {
			if ($sp == 'sp') {
				$description		= 'SP ' . $alias . ' ' . $lindex . ' ' . $post['date'] . ' ' . 'an ' . $post['nama_lengkap'];
			} else {
				$description		= $alias . ' an' . ' ' . $post['nama_peserta'];
			}
		} elseif ($program == 'Leadership Camp') {
			$description		= $alias . ' an' . ' ' . $post['nama_peserta'];
		} elseif ($program == 'others') {
			$description		= $keterangan;
		}

	    if ($program != 'others') {

			$this->db->select('*');
			$this->db->where('nama_indeks', $index);
			$result_indeks = $this->db->get('fc_indeks')->result();

			foreach ($result_indeks as $row) {
				$id_indeks = $row->id_indeks;
				$id_divisi = $row->id_divisi;
				$headdivisi = $row->head_divisi;
			}
		} elseif ($program == 'others') {
			$id_indeks  = '';
			$id_divisi  = '';
			$headdivisi = '';
		}
		
// 		var_dump($index);

		$data_insert = array(
			'id_user' => $this->session->userdata('id'),
			'id_divisi' => $this->session->userdata('iddivisi'),
			'id_branch' => $branch,
			'divisi'	=> $id_divisi,
			'indeks'	=> $id_indeks,
			'headdivisi' => $headdivisi,
			'bank'		=> $bank,
			'type'		=> 'income',
			'nomerator' => $post['headnumber'] . $post['bodynumber'],
			'nama_peserta' => $post['nama_peserta'],
			'program' => ucfirst($program),
			'jumlah' => str_replace('.', '', $post['jumlah']),
			'description' => $description,
			'date' => $post['date'],
		);

		// $data_update = array(
		// 	'id_user' => $this->session->userdata('id'),
		// 	'id_divisi' => $this->session->userdata('iddivisi'),
		// 	'id_branch' => $branch,
		// 	'nomerator' => $post['headnumber'] . $post['bodynumber'],
		// 	'nama_peserta' => $post['nama_peserta'],
		// 	'pemilik_kartu' => $post['pemilik_kartu'],
		// 	'program' => $post['program'],
		// 	'jumlah' => str_replace('.', '', $post['jumlah']),
		// 	'date' => $post['date']
		// );

		// // Menyimpan data sementara jika proses simpan gagal.
		// // $this->session->set_userdata($data_insert);

		// if (!empty($post['id'])) {
		// 	# update statement
		// 	$id = $post['id'];
		// 	unset($post['id']);
		// 	$result = $this->Model_finance->update_tandaterima($data_update, $id, $nomerator);
		// 	if ($result) {
		// 		flashdata('success', 'Berhasil mengubah data');
		// 	} else {
		// 		flashdata('error', 'Gagal mengubah data atau nomerator sudah terpakai');
		// 	}
		// } else {
		# insert statement
		$result = $this->Model_finance->insert_nomerator($data_insert, $nomerator);

		if ($result) {
			flashdata('success', 'Berhasil menambahkan data');
		} else {
			flashdata('error', 'Gagal menambahkan data atau nomerator sudah terpakai');
		}

		redirect(base_url('user/nomerator'));
	}

    public function delete_nomerator()
	{
		$id 		= $this->input->post('id');
		$results 	= $this->Model_finance->delete_nomerator($id);

		if ($results) {
			flashdata('success', 'Segala data tersebut sudah terhapus dari sistem');
		} else {
			flashdata('error', 'Gagal menghapus data.');
		}
		echo json_encode($results);
	}
}
?>