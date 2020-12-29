<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
            redirect('petugas/login');
        }

        //memanggil model
        $this->load->model(array('dashboard_model','petugas_model','buku_model'));
    }

    public function index()
    {
        //mengarahkan ke function read
        $this->read();
    }

    public function read()
    {
        $NIP              = $this->session->userdata('nama');
        $data_anggota     = $this->dashboard_model->jumlah_anggota();
        $data_peminjaman  = $this->dashboard_model->total_peminjaman_buku();
        $data_koleksi     = $this->dashboard_model->jumlah_koleksi();
        $data_buku_grafik = $this->dashboard_model->jumlah_penerbit();
        $data_transaksi   = $this->dashboard_model->total_transaksi();
        $data_buku        = $this->dashboard_model->total_buku();
        $data_jumlah_buku = $this->dashboard_model->jumlah_buku();

        $output = array(
            'judul'            => 'Dashboard',
            'theme_page'       => 'dashboard_read',
            'data_anggota'     => $data_anggota,
            'data_peminjaman'  => $data_peminjaman,
            'data_buku'        => $data_buku,
            'data_koleksi'     => $data_koleksi,
            'data_transaksi'   => $data_transaksi,
            'data_petugas'     => $NIP,
            'data_buku_grafik' => $data_buku_grafik,
            'data_jumlah_buku' => $data_jumlah_buku,
        );

        $this->load->view('theme/index', $output);
    }

}