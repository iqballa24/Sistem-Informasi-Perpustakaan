<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Denda extends CI_Controller {

	public function __construct() {
        parent::__construct();

		if (empty($this->session->userdata('NIP'))) {
			redirect('petugas/login');
		}

        // memanggil model
        $this->load->model(array('denda_model', 'peminjaman_model', 'pengembalian_model'));;
    }

    public function index() {
		// mengarahkan ke function read
		$this->read();
	}

	public function read()
	{

		$id         = $this->uri->segment(3);
		$data_denda = $this->denda_model->read($id);
		$kode 		= $this->denda_model->getKode($id);
		$jumlah 	= $this->denda_model->getDenda($id);
		$NIP        = $this->session->userdata('nama');
		
		// mengirim data ke view
		$output = array(
			'theme_page'    => 'denda_read',
			'judul'         => 'Detail Denda',
			'data_petugas'  => $NIP,
			'kode'  		=> $kode,
			'jumlah'  		=> $jumlah,
			'data_denda'	=> $data_denda
		);

		// memanggil file view
		$this->load->view('theme/index', $output);
	}

	public function insert()
	{

		$this->insert_submit();

		$data_pengembalian  = $this->pengembalian_model->read();
		$status_pinjam      = $this->peminjaman_model->getPinjam();
		$data_denda         = $this->denda_model->getJenisDenda();
		$NIP                = $this->session->userdata('nama');
		$data_kembali       = $this->pengembalian_model->getLastData();

		//mengirim data ke view
		$output = array(
			'judul'             => 'Transaksi Pengembalian',
			'theme_page'        => 'pengembalian_insert',
			'data_kembali'      => $data_kembali,
			'data_pengembalian' => $data_pengembalian,
			'data_denda'        => $data_denda,
			'status_pinjam'     => $status_pinjam,
			'data_petugas'      => $NIP
		);

		//memanggil file view
		$this->load->view('theme/index', $output);
	}

	public function insert_submit()
	{

		if ($this->input->post('submit') == 'Tambah') {

			$this->form_validation->set_rules('kd_pinjam', 'Kode Peminjaman', 'required');
			$this->form_validation->set_rules('denda', 'Jenis Denda', 'required|callback_insert_check');
			$this->form_validation->set_rules('value', 'value', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$kd_pinjam  = $this->input->post('kd_pinjam');
				$denda		= $this->input->post('denda');
				$value      = $this->input->post('value');
		
				// mengirim data ke model
				$input = array(
					'kd_kembali'   	 => $kd_pinjam,
					'id_jenis_denda' => $denda,
					'jumlah'       	 => $value
				);
		
				$data_denda = $this->denda_model->insert($input);
		
				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data denda berhasil ditambahkan, silahkan lihat pada action denda !', 1);
				redirect('denda/insert');
			}
			
		}

	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$kd	 	= $this->input->post('kd_pinjam');
		$denda	= $this->input->post('denda');
	
		//check data di database
		$data_user = $this->denda_model->read_check($denda, $kd);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->session->set_tempdata('error', "Tidak dapat memasukan 1 jenis denda yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}

	public function delete()
	{
		// menangkap id data yg dipilih dari view
		$id = $this->uri->segment(3);

		// memanggil function delete pada anggota_model.php
		$data_denda = $this->denda_model->delete($id);

		// mengembalikan halaman ke function read
		$this->session->set_tempdata('message', 'Sukses, Data berhasil dihapus', 1);
		redirect('pengembalian/read/');
	}

	public function export()
	{
		$id            	   = $this->uri->segment(3);
		$data_pengembalian = $this->denda_model->detail($id);
		$data_denda 	   = $this->denda_model->read($id);
		$NIP               = $this->session->userdata('nama');
		$jumlah 		   = $this->denda_model->getDenda($id);


		//mengirim data ke view
		$output = array(
			//data provinsi dikirim ke view
			'data_pengembalian' => $data_pengembalian,
			'data_denda'   		=> $data_denda,
			'data_petugas'      => $NIP,
			'jumlah'  			=> $jumlah,
		);

		//memanggil file view
		$this->load->view('denda_pengembalian_export', $output);
	}
}