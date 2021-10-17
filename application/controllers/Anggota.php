<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (empty($this->session->userdata('NIP'))) {
			redirect('petugas/login');
		}

		// memanggil model
		$this->load->model('anggota_model');
		$this->load->library('grocery_CRUD');
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
					<a id="btn_edit" class="btn btn-warning btn-sm item_update" data="' . $field['id_anggota'] . '"><i class="fas fa-edit"></i></a>
					<a href="' . site_url('anggota/delete/' . $field['id_anggota']) . '" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "' . $field['id_anggota'] . '">
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

	public function insert()
	{

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

	public function insert_submit()
	{

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

	public function delete()
	{
		// menangkap id data yg dipilih dari view
		$id = $this->uri->segment(3);

		$this->db->db_debug = false; //disable debugging queries

		// Error handling
		if (!$this->anggota_model->delete($id)) {
			$msg =  $this->db->error();
			$this->session->set_tempdata('error', $msg['message'], 1);
		}

		//mengembalikan halaman ke function read
		$this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
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

	function save()
	{

		//aturan validasi input login
		$this->form_validation->set_rules('nim', 'nim', 'required|min_length[5]|numeric');
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('program_studi', 'prodi', 'required');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$errors = strip_tags(validation_errors());
			// $errors = array(
			// 	'error'   => true,
			// 	'nim' => form_error('nim'),
			// 	'nama' => form_error('nama'),
			// 	'program_studi' => form_error('program_studi'),
			// 	'email' => form_error('email')
			// );
			echo json_encode(['error' => $errors]);
			die();
		} else {
			echo json_encode(['success' => 'Record added successfully.']);

			$data = array(
				// menangkap data input dari view
				'nim'	  => $this->input->post('nim'),
				'nama'	  => $this->input->post('nama'),
				'prodi'	  => $this->input->post('program_studi'),
				'email'	  => $this->input->post('email'),
				'password' => $this->input->post('nim'),

			);
			$result = $this->db->insert('anggota', $data);
			return $result;
		}
	}

	function get_update($id)
	{
		$id = $this->uri->segment(3);

		$data_anggota_single = $this->anggota_model->read_single($id);

		echo json_encode($data_anggota_single);
	}

	function Simpan()
	{
		//aturan validasi input login
		$this->form_validation->set_rules('nim_u', 'nim', 'required|min_length[5]|numeric');
		$this->form_validation->set_rules('nama_u', 'nama', 'required');
		$this->form_validation->set_rules('program_studi_u', 'prodi', 'required');
		$this->form_validation->set_rules('email_u', 'email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$errors = strip_tags(validation_errors());
			echo json_encode(['error' => $errors]);
			die();
		} else {
			echo json_encode(['success' => 'Record update successfully.']);

			$input = array(
				// menangkap data input dari view
				'nim'	  => $this->input->post('nim_u'),
				'nama'	  => $this->input->post('nama_u'),
				'prodi'	  => $this->input->post('program_studi_u'),
				'email'	  => $this->input->post('email_u')

			);
			$data_anggota = $this->anggota_model->update($input, $this->input->post('id_anggota'));
			return $data_anggota;
		}
	}

	public function import()
	{
		$NIP = $this->session->userdata('nama');

		// mengirim data ke view
		$output = array(
			'theme_page' 	=> 'anggota_import',
			'judul' 	 	=> 'Import Data Anggota',
			'data_petugas' 	=> $NIP
		);

		$this->load->view('theme/index', $output);
	}

	public function upload()
	{
		include APPPATH . 'third_party\PHPExcel\PHPExcel.php';

		$config['upload_path']   = './upload_folder/excel/';
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size']     = 10000;
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
			$this->session->set_tempdata('error', 'Gagal Import!' . $this->upload->display_errors(), 1);
			redirect('anggota/import');
		} else {
			$data_upload = $this->upload->data();
			$excelrender = new PHPExcel_Reader_Excel2007();
			$loadExcel = $excelrender->load('upload_folder/excel/' . $data_upload['file_name']);
			$sheet = $loadExcel->getActiveSheet()->toArray(null, true, true, true, true, true);

			$data = array();

			$numrow = 1;
			foreach ($sheet as $row) {
				if ($numrow > 1) {
					array_push($data, array(
						'id_anggota' => $row['A'],
						'nim' 		 => $row['B'],
						'nama' 		 => $row['C'],
						'prodi' 	 => $row['D'],
						'email' 	 => $row['E'],
						'password' 	 => $row['F'],
					));
				}
				$numrow++;
			}
			$this->db->insert_batch('anggota', $data);
			unlink(realpath('upload_folder/excel/' . $data_upload['file_name']));

			$this->session->set_tempdata('message', 'Success Import', 1);
			redirect('anggota/read');
		}
	}
}
