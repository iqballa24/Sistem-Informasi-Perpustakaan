<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model {

    var $table = array('peminjaman');

    //field yang ditampilkan
    var $column_order = array(null, 'kd_pinjam','nama', 'tgl_pinjam', 'bts_pinjam', 'Jumlah', 'status');

    //field yang diizin untuk pencarian 
    var $column_search = array('kd_pinjam','nama', 'tgl_pinjam', 'bts_pinjam', 'status');

    //field pertama yang diurutkan
    var $order = array('kd_pinjam' => 'DESC');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {

        $this->db->select('*');
        $this->db->from('peminjaman a');
        $this->db->join('anggota b', 'a.id_anggota = b.id_anggota');

        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            $search = $this->input->post('search');
            if ($search['value'])

            // jika datatable mengirimkan pencarian dengan metode POST
            {
                // looping awal 
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $search['value']);
                } else {
                    $this->db->or_like($item, $search['value']);
                }

                if (count($this->column_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
        }

        if ($this->input->post('order')) {
            $order = $this->input->post('order');
            $this->db->order_by($this->column_order[$order['0']['column']], $order['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
        $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();
        return $query->result_array();
    }

    //menghitung tota data sesuai filter/pagination
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    //menghitung total data di table
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // function read berfungsi mengambil/read data dari table anggota di database
    public function read()
    {
        //sql read
        $this->db->select('*');
        $this->db->from('peminjaman a');
        $this->db->join('anggota b', 'a.id_anggota = b.id_anggota');
        $this->db->order_by('a.kd_pinjam DESC');
        $query = $this->db->get();

        // $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function read_single($kd)
    {

        // sql read
        $this->db->select('*');
        $this->db->from('peminjaman');

        // $id = id data yang dikirim dari controller (sebagai filter data yang dipilih)
        // filter data sesuai id yang dikirim dari controller
        $this->db->where('kd_pinjam', $kd);

        $query = $this->db->get();

        // query -> row_array = mengirim data ke controller dalam bentuk 1 data
        return $query->row_array();
    }

    public function read_check($kd_pinjam)
    {
        $this->db->select('*');
        $this->db->from('peminjaman');
        $this->db->where('kd_pinjam', $kd_pinjam);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getPinjam()
    {
        $this->db->select('*');
        $this->db->from('peminjaman a');
        $this->db->join('anggota b', 'a.id_anggota=b.id_anggota');
        $this->db->where('status', 'p');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getLastData()
    {
        $this->db->select('kd_pinjam');
        $this->db->from('peminjaman');
        $this->db->order_by('kd_pinjam', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getKodePinjam()
    {
        $query = $this->db->query("SELECT MAX(kd_pinjam) as kodepinjam from peminjaman");
        $hasil = $query->row();

        return $hasil->kodepinjam;
    }

    public function insert($input)
    {
        //$input = data yang dikirim dari controller
        return $this->db->insert('peminjaman', $input);
    }

    public function update($input, $kd)
    {
        //$id = id data yang dikirim dari controller (sebagai filter data yang diubah)
        //filter data sesuai id yang dikirim dari controller
        $this->db->where('kd_pinjam', $kd);

        //$input = data yang dikirim dari controller
        return $this->db->update('peminjaman', $input);
    }

    public function delete($id)
    {
        //$id = id data yang dikirim dari controller (sebagai filter data yang dihapus)
        $this->db->where('kd_pinjam', $id);
        return $this->db->delete(array('detail_peminjaman' ,'peminjaman'));
    }
}