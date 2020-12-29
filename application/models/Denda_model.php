<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Denda_model extends CI_Model {

    // Menampilkan data detail denda
    public function read($id)
    {
        $this->db->select('*, (biaya * a.jumlah) as total_denda');
        $this->db->from('denda a ');
        $this->db->join('jenis_denda b','a.id_jenis_denda = b.id_jenis_denda');
        $this->db->join('pengembalian c', 'a.kd_kembali = c.kd_kembali');
        $this->db->where('c.kd_kembali', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function read_check($denda, $kd)
    {
        $this->db->select('*');
        $this->db->from('denda');
        $this->db->where('id_jenis_denda', $denda);
        $this->db->where('kd_kembali', $kd);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function insert($input)
    {
        //$input = data yang dikirim dari controller
        return $this->db->insert('denda', $input);
    }

    // Menampilkan jenis denda
    public function getJenisDenda()
    {
        $this->db->select('*');
        $this->db->from('jenis_denda');
        $query = $this->db->get();

        return $query->result_array();
    }

    // Menampilkan data kode peminjaman
    public function getKode($kd)
    {
        $this->db->distinct();
        $this->db->select('kd_pinjam');
        $this->db->from('pengembalian a');
        $this->db->join('denda b', 'a.kd_kembali = b.kd_kembali');
        $this->db->where('a.kd_kembali', $kd);
        $query = $this->db->get();

        return $query->result_array();
    }

    // Menampilkan data jumlah denda
    public function getDenda($kd)
    {
        $this->db->distinct();
        $this->db->select('SUM(biaya * a.jumlah) as total_denda');
        $this->db->from('denda a ');
        $this->db->join('jenis_denda b', 'a.id_jenis_denda = b.id_jenis_denda');
        $this->db->join('pengembalian c', 'a.kd_kembali = c.kd_kembali');
        $this->db->where('a.kd_kembali', $kd);
        $query = $this->db->get();

        return $query->result_array();
    }

    // Menampilkan data detail pengembalian
    public function detail($id)
    {
        // sql read
        $this->db->select('a.*, b.*, c.*, (tgl_kembali - bts_pinjam) as telat, (a.Jumlah - b.jumlah) as hilang');
        $this->db->from('peminjaman a');
        $this->db->join('pengembalian b', 'a.kd_pinjam = b.kd_pinjam');
        $this->db->join('anggota c', 'a.id_anggota = c.id_anggota');
        $this->db->where('b.kd_kembali', $id);
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function delete($id)
    {
        //$id = id data yang dikirim dari controller (sebagai filter data yang dihapus)
        $this->db->where('id_denda', $id);
        return $this->db->delete('denda');
    }
}