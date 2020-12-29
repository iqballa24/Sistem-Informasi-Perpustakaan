<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
            redirect('petugas/login');
        }

        // memanggil model
        $this->load->model(array('pengembalian_model','peminjaman_model', 'denda_model'));
    }

    public function index()
    {
        // mengarahkan ke function read
        $this->read();
    }

    //fungsi menampilkan data dalam bentuk json
    public function datatables()
    {
        //menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
        // sleep(2);

        //memanggil fungsi model datatables
        $list  = $this->pengembalian_model->get_datatables();
        $data  = array();
        $no    = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $date1 = date_create($field['bts_pinjam']);
            $date2 = date_create($field['tgl_kembali']);
            $row   = array();
            $row[] = $no;
            $row[] = $field['kd_pinjam'];
            $row[] = $field['nama'];
            $row[] = date_format($date1, "D, d M Y");
            $row[] = date_format($date2, "D, d M Y");
            $row[] = $field['Jumlah'].' Buku' ;
            $row[] = $field['jumlah'] . ' Buku';
            $row[] = '
                    <a href="'.site_url('denda/read/' . $field['kd_kembali']).'" class="btn btn-info btn-sm" title="Lihat denda">
                        <i class="fas fa-money-bill-wave"></i> 
                    </a>
					<a href="' . site_url('pengembalian/delete/' . $field['kd_kembali']) . '" class="btn btn-danger btn-sm btnHapus" title="Hapus">
						<i class="fas fa-trash-alt"></i> 
                    </a>
                    <a href="'.site_url('denda/export/' . $field['kd_kembali']). '" class="btn btn-success btn-sm" title="Export data">
                        <i class="fas fa-file-excel"></i> 
                    </a>';

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->pengembalian_model->count_all(),
            "recordsFiltered" => $this->pengembalian_model->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function read()
    {

        $data_pengembalian = $this->pengembalian_model->read();
        $NIP = $this->session->userdata('nama');

        // mengirim data ke view
        $output = array(
            'theme_page' => 'pengembalian_read',
            'judul'      => 'Data Pengembalian',
            'data_pengembalian' => $data_pengembalian,
            'data_petugas'      => $NIP
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert()
    {

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
        

        // menangkap data input dari view
        $kd_pinjam      = $this->input->post('kd_pinjam');
        $tgl_kembali    = $this->input->post('tgl_kembali');
        $jumlah         = $this->input->post('jumlah');

        // mengirim data ke model
        $input = array(
            // format : nama field/kolom table => data input dari view
            'kd_pinjam'    => $kd_pinjam,
            'tgl_kembali'  => $tgl_kembali,
            'jumlah'       => $jumlah
        );

        // memanggil function insert pada anggota_model.php
        // function insert berfungsi menyimpan/create data ke table anggota di database
        $data_pengembalian = $this->pengembalian_model->insert($input);

        // mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Transaksi pengembalian berhasil !', 1);
        redirect('pengembalian/insert');
    
    }

    public function delete()
    {
        // menangkap id data yg dipilih dari view
        $id = $this->uri->segment(3);

        // memanggil function delete pada anggota_model.php
        $data_pengembalian = $this->pengembalian_model->delete($id);

        // mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
        redirect('pengembalian/read');
    }

    public function export()
    {
        $data_pengembalian = $this->pengembalian_model->read();
        $NIP = $this->session->userdata('nama');

        //mengirim data ke view
        $output = array(

            //data provinsi dikirim ke view
            'data_pengembalian' => $data_pengembalian,
            'data_petugas'      => $NIP
        );

        //memanggil file view
        $this->load->view('pengembalian_export', $output);
    }

}