<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard_model extends CI_Model 
{

	public function jumlah_anggota() {
		// sql read
        $this->db->select('COUNT(id_anggota) as total');
        $this->db->from('anggota');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function total_peminjaman_buku()
    {
        // sql read
        $pinjam = '<p style="color: red;">Pinjam</p>';
        $this->db->select('judul, COUNT(judul) as total' );
        $this->db->from('peminjaman a');
        $this->db->join('detail_peminjaman b', 'a.kd_pinjam = b.kd_pinjam');
        $this->db->join('buku c', 'c.id_buku = b.id_buku');
        $this->db->group_by('c.id_buku');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function total_buku()
    {
        // sql read
        $this->db->select('SUM(stok_buku)  as total');
        $this->db->from('buku');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function jumlah_koleksi()
    {
        // sql read
        $this->db->select('count(judul)  as total');
        $this->db->from('buku');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function total_transaksi()
    {
        // sql read
        $this->db->select('COUNT(kd_pinjam)  as total');
        $this->db->from('peminjaman');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function jumlah_penerbit()
    {
        // sql read
        $this->db->SELECT('penerbit.penerbit AS penerbit');
        $this->db->SELECT('COUNT(buku.id_penerbit) AS total_penerbit');
        $this->db->FROM('buku');
        $this->db->JOIN('penerbit', 'buku.id_penerbit = penerbit.id_penerbit');
        $this->db->GROUP_BY('buku.id_penerbit');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function jumlah_buku()
    {
        // sql read
        $this->db->SELECT('kategori.kategori AS kategori');
        $this->db->SELECT('SUM(stok_buku) AS total');
        $this->db->FROM('buku');
        $this->db->JOIN('kategori', 'buku.id_kategori = kategori.id_kategori');
        $this->db->GROUP_BY('buku.id_kategori');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }
}