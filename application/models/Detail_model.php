<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_model extends CI_Model {

    public function read()
    {

        //sql read
        $this->db->select('*');
        $this->db->from('peminjaman a');
        $this->db->join('anggota b', 'a.id_anggota = b.id_anggota');
        $this->db->join('detail_peminjaman c', 'a.kd_pinjam = c.kd_pinjam');
        $this->db->join('buku d', ' c.id_buku= d.id_buku');
        $this->db->order_by('c.Id_detail DESC');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function detail($id)
    {

        //sql read
        $this->db->select('*');
        $this->db->from('peminjaman a');
        $this->db->join('detail_peminjaman b', 'a.kd_pinjam = b.kd_pinjam');
        $this->db->join('buku d', 'd.id_buku = b.id_buku');
        $this->db->join('kategori e', 'd.id_kategori = e.id_kategori');
        $this->db->join('penerbit c', 'd.id_penerbit = c.id_penerbit');
        $this->db->where('a.kd_pinjam', $id);
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function getKode($kd)
    {
        $this->db->distinct();
        $this->db->select('kd_pinjam');
        $this->db->from('detail_peminjaman a');
        $this->db->where('kd_pinjam', $kd);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function peminjam($id)
    {
        $this->db->select('distinct(a.kd_pinjam),a.*,b.*');
        $this->db->from('peminjaman a');
        $this->db->join('anggota b', 'a.id_anggota = b.id_anggota');
        $this->db->where('a.kd_pinjam', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function read_check($kd)
    {
        $this->db->select('*');
        $this->db->from('detail_peminjaman');
        $this->db->where('kd_pinjam', $kd);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function insert($input)
    {
        //$input = data yang dikirim dari controller
        return $this->db->insert('detail_peminjaman', $input);
    }

    public function delete($id)
    {
        //$id = id data yang dikirim dari controller (sebagai filter data yang dihapus)
        $this->db->where('Id_detail', $id);
        return $this->db->delete('detail_peminjaman');
    }

}
