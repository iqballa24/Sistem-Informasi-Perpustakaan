<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail extends CI_Controller {

	public function __construct() {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
            redirect('petugas/login');
        }

        // memanggil model
        $this->load->model(array('peminjaman_model', 'anggota_model', 'buku_model','detail_model', 'pengembalian_model'));
    }

    public function index() {
		// mengarahkan ke function read
		$this->read();
    }

    public function read()
    {

        $id            = $this->uri->segment(3);
        $dt_peminjaman = $this->detail_model->detail($id);
        $kode          = $this->detail_model->getKode($id);
        $NIP           = $this->session->userdata('nama');
        
        // mengirim data ke view
        $output = array(
            'theme_page'    => 'detail_read',
            'judul'         => 'Buku yang dipinjam',
            'data_petugas'  => $NIP,
            'dt_peminjaman' => $dt_peminjaman,
            'kode'          => $kode
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert()
    {
        $this->insert_submit();

        // get Kode Pinjam dari database
        $kodedb      = $this->peminjaman_model->getKodePinjam();
        $nourut      = substr($kodedb, 3, 5);
        $kode_pinjam = $nourut + 1;

        $data_anggota    = $this->anggota_model->read();
        $data_peminjaman = $this->peminjaman_model->read();
        $status_pinjam   = $this->peminjaman_model->getPinjam();
        $data_buku       = $this->buku_model->read();
        $dt_peminjaman   = $this->detail_model->read();
        $NIP             = $this->session->userdata('nama');
        
        //mengirim data ke view
        $output = array(
             'judul'            => 'Transaksi Peminjaman',
             'theme_page'       => 'peminjaman_insert',
             'kode_pinjam'      => $kode_pinjam,
             'status_pinjam'    => $status_pinjam,
             'data_peminjaman'  => $data_peminjaman,
             'data_anggota'     => $data_anggota,
             'data_buku'        => $data_buku,
             'data_petugas'     => $NIP,
             'dt_peminjaman'    => $dt_peminjaman
        );


        //memanggil file view
        $this->load->view('theme/index', $output);
      
    }

    public function insert_submit()
    {

        if ($this->input->post('submit') == 'Tambah') {

            //aturan validasi input login
            $this->form_validation->set_rules('dt_pinjam', 'Kode Peminjaman', 'required');
            $this->form_validation->set_rules('buku', 'buku', 'required');

            if ($this->form_validation->run() == TRUE) {

                // menangkap data input dari view
                $dt_pinjam  = $this->input->post('dt_pinjam');
                $buku       = $this->input->post('buku');

                // mengirim data ke model
                $input = array(
                    // format : nama field/kolom table => data input dari view
                    'kd_pinjam' => $dt_pinjam,
                    'id_buku'       => $buku
                );

                // memanggil function insert pada anggota_model.php
                // function insert berfungsi menyimpan/create data ke table anggota di database
                $dt_peminjaman = $this->detail_model->insert($input);

                // mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Buku berhasil ditambahkan' , 1);
                redirect('peminjaman/insert');
            }
        }
    }

    public function delete()
    {
        // menangkap id data yg dipilih dari view
        $id = $this->uri->segment(3);

        // memanggil function delete pada anggota_model.php
        $data_detail = $this->detail_model->delete($id);

        // mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
        redirect('peminjaman/read/'.$id);
    }

    public function export()
    {
        $id            = $this->uri->segment(3);
        $dt_peminjaman = $this->detail_model->detail($id);
        $dt_peminjam   = $this->detail_model->peminjam($id);
        $NIP           = $this->session->userdata('nama');


        //mengirim data ke view
        $output = array(
            //data provinsi dikirim ke view
            'dt_peminjam'   => $dt_peminjam,
            'dt_peminjaman' => $dt_peminjaman,
            'data_petugas' => $NIP
        );

        //memanggil file view
        $this->load->view('detail_peminjaman_export', $output);
    }
    
}