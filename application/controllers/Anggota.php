<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('NIP'))) {
			redirect('petugas/login');
		}

        // memanggil model
        $this->load->model('anggota_model');
    }

    public function index() {
		// mengarahkan ke function read
		$this->read();
	}

	public function read() {
	
		$NIP = $this->session->userdata('nama');

		// mengirim data ke view
		$output = array(
						'theme_page' => 'anggota_read',
						'judul' 	 => 'Data Anggota',

						// data anggota dikirim ke view
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
		$list = $this->anggota_model->get_datatables();
		$data = array();
		$no = $this->input->post('start');

		//mencetak data json
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['nim'];
			$row[] = $field['nama'];
			$row[] = $field['prodi'];
			$row[] = $field['email'];
			$row[] = $field['password'];
			$row[] = '
					<a href="'.site_url('anggota/update/'.$field['id_anggota']). '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="'.site_url('anggota/delete/'.$field['id_anggota']).'" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "'.$field['id_anggota'].'">
						<i class="fas fa-trash-alt"></i> 
					</a>';

			$data[] = $row;
		}

		//mengirim data json
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->anggota_model->count_all(),
			"recordsFiltered" => $this->anggota_model->count_filtered(),
			"data" => $data,
		);

		//output dalam format JSON
		echo json_encode($output);
	}

	public function insert() {

		$this->insert_submit();
		$NIP = $this->session->userdata('nama');
	
		// mengirim data ke view
		$output = array(
						'theme_page' 	=> 'anggota_insert',
						'judul' 	 	=> 'Tambah Data Anggota',
						'data_petugas' 	=> $NIP
					);

		// memanggil file view
		$this->load->view('theme/index', $output);
	}

	public function insert_submit() {

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('nim', 'nim', 'required|min_length[5]|numeric|callback_insert_check');
			$this->form_validation->set_rules('nama', 'nama', 'required');
			$this->form_validation->set_rules('prodi', 'prodi', 'required');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');

			if ($this->form_validation->run() == TRUE) {

				// menangkap data input dari view
				$nim	  = $this->input->post('nim');
				$nama	  = $this->input->post('nama');
				$prodi	  = $this->input->post('prodi');
				$email	  = $this->input->post('email');
		
				// mengirim data ke model
				$input = array(
								// format : nama field/kolom table => data input dari view
								'nim'  	 	=> $nim,
								'nama' 		=> $nama,
								'prodi' 	=> $prodi,
								'password'  => $nim,
								'email' 	=> $email
							);
		
				// memanggil function insert pada anggota_model.php
				// function insert berfungsi menyimpan/create data ke table anggota di database
				$data_anggota = $this->anggota_model->insert($input);

				// mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
				redirect('anggota/read');
			}

		}

	}

	public function insert_check()
	{

		//Menangkap data input dari view
		$nim = $this->input->post('nim');

		//check data di database
		$data_user = $this->anggota_model->read_check($nim);

		if (!empty($data_user)) {

			//membuat pesan error
			$this->form_validation->set_message('insert_check', "NIM " . $nim . " sudah ada dalam database");
			$this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
			return FALSE;
		}
		return TRUE;
	}

	public function update()
	{

		$this->update_submit();
		//menangkap id data yg dipilih dari view (parameter get)
		$id  = $this->uri->segment(3);
		$NIP = $this->session->userdata('nama');

		//function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
		$data_anggota_single = $this->anggota_model->read_single($id);

		//mengirim data ke view
		$output = array(
			'judul'	 		=> 'Edit Anggota',
			'theme_page' 	=> 'Anggota_update',
			'data_petugas' 	=> $NIP,

			//mengirim data kota yang dipilih ke view
			'data_anggota_single' => $data_anggota_single,
		);

		//memanggil file view
		$this->load->view('theme/index', $output);
	}

	public function update_submit()
	{

		if ($this->input->post('submit') == 'Simpan') {

			//aturan validasi input login
			$this->form_validation->set_rules('nim', 'nim', 'required|min_length[5]|numeric');
			$this->form_validation->set_rules('nama', 'nama', 'required');
			$this->form_validation->set_rules('prodi', 'prodi', 'required');
			$this->form_validation->set_rules('email', 'email', 'required');

			if ($this->form_validation->run() == TRUE) {

				//menangkap id data yg dipilih dari view
				$id = $this->uri->segment(3);

				// menangkap data input dari view
				$nim	  = $this->input->post('nim');
				$password = $this->input->post('password');
				$nama	  = $this->input->post('nama');
				$prodi	  = $this->input->post('prodi');
				$email	  = $this->input->post('email');

				// mengirim data ke model
				$input = array(
					// format : nama field/kolom table => data input dari view
					'nim'		=> $nim,
					'nama' 		=> $nama,
					'prodi' 	=> $prodi,
					'password'  => $password,
					'email'	    => $email
				);

				//memanggil function update pada kategori model
				$data_anggota = $this->anggota_model->update($input, $id);

				//mengembalikan halaman ke function read
				$this->session->set_tempdata('message', 'Data berhasil disimpan !', 1);
				redirect('anggota/read');
			}
		}
	}

	public function delete() {
		// menangkap id data yg dipilih dari view
		$id = $this->uri->segment(3);

		$this->db->db_debug = false; //disable debugging queries
		
		// Error handling
		if (!$this->anggota_model->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message','Data berhasil dihapus',1);
		redirect('anggota/read');
	}

	public function export()
	{
		$data_anggota = $this->anggota_model->read();
		$NIP = $this->session->userdata('nama');
		
		//mengirim data ke view
		$output = array(
			
			//data provinsi dikirim ke view
			'data_petugas' => $NIP,
			'data_anggota' => $data_anggota
		);

		//memanggil file view
		$this->load->view('anggota_export', $output);
	}
}