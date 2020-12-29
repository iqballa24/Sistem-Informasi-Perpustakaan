<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_Denda extends CI_Controller {
	public function __construct() {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
			redirect('petugas/login');
		}

        // memanggil model
        $this->load->model('jenis_denda_model');
    }

    public function index() {
        // mengarahkan ke function read
        $this->read();
    }

    //fungsi menampilkan data dalam bentuk json
    public function datatables()
    {
        //menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
        // sleep(2);

        //memanggil fungsi model datatables
        $list = $this->jenis_denda_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field['jenis_denda'];
            $row[] = 'Rp.' . number_format($field['biaya']);
            $row[] = '
					<a href="' . site_url('jenis_denda/update/' . $field['id_jenis_denda']) . '" class="btn btn-warning btn-sm" title="edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="' . site_url('jenis_denda/delete/' . $field['id_jenis_denda']) . '" class="btn btn-danger btn-sm btnHapus" title="hapus">
						<i class="fas fa-trash-alt"></i> 
					</a>';

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->jenis_denda_model->count_all(),
            "recordsFiltered" => $this->jenis_denda_model->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function read() {
        // memanggil function read pada jenis_denda_model.php
        // function read berfungsi mengambil/read data dari table jenis_denda di database
        $data_jenis_denda = $this->jenis_denda_model->read();
        $NIP = $this->session->userdata('nama');


        // mengirim data ke view
        $output = array(
            'judul'      => 'Data Denda',
            'theme_page' => 'jenis_denda_read',

            // data penerbit dikirim ke view
            'data_jenis_denda' => $data_jenis_denda,
            'data_petugas' => $NIP
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert() {
        $this->insert_submit();

         $NIP = $this->session->userdata('nama');

        // mengirim data ke view
        $output = array(
            'judul'      => 'Tambah Jenis Denda',
            'theme_page' => 'jenis_denda_insert',
            'data_petugas' => $NIP
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert_submit() {
        if ($this->input->post('submit') == 'Simpan') {

            // aturan validasi input login
            $this->form_validation->set_rules('jenis_denda', 'Jenis denda', 'required|callback_insert_check');
            $this->form_validation->set_rules('biaya', 'Biaya', 'required');

            if ($this->form_validation->run() == TRUE) {

                // menangkap data input dari view
                $jenis_denda = $this->input->post('jenis_denda');
                $biaya       = $this->input->post('biaya');

                // mengirim data ke model
                $input = array(
                    // format : nama field/kolom table => data input dari view
                    'jenis_denda' => $jenis_denda,
                    'biaya' 	  => $biaya,
                );

                // memanggil function insert pada jenis_denda_model.php
                // function insert berfungsi menyimpan/create data ke table jenis_denda di database
                $data_jenis_denda = $this->jenis_denda_model->insert($input);

                // mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Data berhasil ditambahkan', 1);

                redirect('jenis_denda/read');
            }
        }
    }

    public function insert_check() {
        // menangkap data input dari view
        $jenis_denda = $this->input->post('jenis_denda');

        // check data di database
        $data_user = $this->jenis_denda_model->read_check($jenis_denda);

        if (!empty($data_user)) {

            // membuat pesan error
            $this->form_validation->set_message('insert_check', "jenis denda " . $jenis_denda . " sudah tersedia");
            $this->session->set_tempdata('info', "Tidak dapat memasukan data yang sama", 1);
            return FALSE;
        }

        return TRUE;
    }

    public function update() {
        $this->update_submit();
        // menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(3);
        $NIP = $this->session->userdata('nama');


        // function read_single berfungsi mengambil 1 data dari table jenis_denda sesuai id yg dipilih
        $data_jenis_denda_single = $this->jenis_denda_model->read_single($id);

        // mengirim data ke view
        $output = array(
            'judul' 	 => 'Ubah Jenis Denda',
            'theme_page' => 'jenis_denda_update',

            // mengirim data penerbit yang dipilih ke view
            'data_jenis_denda_single' => $data_jenis_denda_single,
            'data_petugas' => $NIP
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function update_submit() {

        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(3);

        if ($this->input->post('submit') == 'Simpan') {

            // aturan validasi input login
            $this->form_validation->set_rules('jenis_denda', 'Jenis denda', 'required|callback_insert_check');
            $this->form_validation->set_rules('biaya', 'Biaya', 'required');

            if ($this->form_validation->run() == TRUE) {

                // menangkap data input dari view
                $jenis_denda = $this->input->post('jenis_denda');
                $biaya       = $this->input->post('biaya');

                // mengirim data ke model
                $input = array(
                    // format : nama field/kolom table => data input dari view
                    'jenis_denda' => $jenis_denda,
                    'biaya'       => $biaya,
                );

                // memanggil function insert pada jenis_denda_model.php
                // function insert berfungsi menyimpan/create data ke table jenis_denda di database
                $data_jenis_denda = $this->jenis_denda_model->update($input, $id);

                // mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Data berhasil disimpan', 1);

                redirect('jenis_denda/read');
            }
        }
    }

    public function delete() {
        // menangkap id data yg dipilih dari view
        $id = $this->uri->segment(3);

        // memanggil function delete pada jenis_denda_model.php
        $data_jenis_denda = $this->jenis_denda_model->delete($id);

        // mengembalikan halaman ke function 
        $this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
        redirect('jenis_denda/read');
    }
}