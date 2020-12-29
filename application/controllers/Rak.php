<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
            redirect('petugas/login');
        }

        // memanggil model
        $this->load->model(array('rak_model', 'kategori_model'));
    }

    public function index()
    {
        // mengarahkan ke function read
        $this->read();
    }

    public function read()
    {

        $NIP = $this->session->userdata('nama');

        // mengirim data ke view
        $output = array(
            'theme_page' => 'rak_read',
            'judul'      => 'Data Rak',

            // data rak dikirim ke view
            'data_petugas' => $NIP
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    //fungsi menampilkan data dalam bentuk json
	public function datatables()
	{
		//menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
		// sleep(2);

		//memanggil fungsi model datatables
        $list = $this->rak_model->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['rak'];
			$row[] = $field['kategori'];
			$row[] = '
					<a href="'.site_url('rak/update/'.$field['id_rak']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i>
					</a>
					<a href="'.site_url('rak/delete/'.$field['id_rak']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id_rak'].'">
						<i class="fas fa-trash-alt"></i>
					</a>';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->rak_model->count_all(),
			"recordsFiltered" => $this->rak_model->count_filtered(),
            "data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	public function insert()
	{

		$this->insert_submit();
		$NIP = $this->session->userdata('nama');
		$data_kategori = $this->kategori_model->read();

		// mengirim data ke view
		$output = array(
			'theme_page' 	=> 'rak_insert',
			'judul' 	 	=> 'Tambah Data Rak',
			'data_kategori' => $data_kategori,
			'data_petugas' 	=> $NIP
		);

		// memanggil file view
		$this->load->view('theme/index', $output);
	}

	public function insert_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('rak', 'Rak', 'required|alpha_numeric|callback_insert_check');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$rak  	      = $this->input->post('rak');
				$kategori	  = $this->input->post('kategori');

				// mengirim data ke model
				$input = array(
					// format : nama field/kolom table => data input dari view
					'rak'  	 		=> $rak,
					'id_kategori'   => $kategori,
				);

				// memanggil function insert pada anggota_model.php
				// function insert berfungsi menyimpan/create data ke table anggota di database
				$data_rak = $this->rak_model->insert($input);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('rak/read');
			}
		}
	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$rak = $this->input->post('rak');

		//check data di database
		$data_user = $this->rak_model->read_check($rak);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check', "Rak " . $rak . " sudah ada dalam database");
			$this->session->set_tempdata('info', "Tidak dapat memasukan data yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}

	public function update()
	{
		//menangkap id data yg dipilih dari view (parameter get)
		$id = $this->uri->segment(3);
		$NIP = $this->session->userdata('nama');

		//function read berfungsi mengambil 1 data dari table kota sesuai id yg dipilih
		$data_rak_single = $this->rak_model->read_single($id);

		//mengambil daftar kategori dan penerbit
		$data_kategori = $this->kategori_model->read();

		//mengirim data ke view
		$output = array(
			'judul'      => 'Edit Rak',
			'theme_page' => 'rak_update',

			//mengirim data kota yang dipilih ke view
			'data_buku_single' => $data_rak_single,

			//mengirim daftar provinsi ke view
			'data_petugas'  => $NIP,
			'data_kategori' => $data_kategori,
		);

		//memanggil file view
		$this->load->view('theme/index', $output);
	}

	public function update_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('rak', 'Rak', 'required|alpha_numeric|callback_insert_check');
			$this->form_validation->set_rules('kategori', 'kategori', 'required');

			if ($this->form_validation->run() == TRUE) {

				//menangkap id data yg dipilih dari view
				$id = $this->uri->segment(3);

				// menangkap data input dari view
				$rak	  = $this->input->post('rak');
				$kategori = $this->input->post('kategori');

				// mengirim data ke model
				$input = array(
					// format : nama field/kolom table => data input dari view
					'rak'		  => $rak,
					'id_kategori' => $kategori,
				);

				//memanggil function update pada kategori model
				$data_rak = $this->rak_model->update($input, $id);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan !', 1);
				redirect('rak/read');
			}
		}
	}

	public function delete()
	{
		//menangkap id data yg dipilih dari view
		$id = $this->uri->segment(3);

		$this->db->db_debug = false; //disable debugging queries

		// Error handling
		if (!$this->rak_model->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
		redirect('rak/read');
	}
}
