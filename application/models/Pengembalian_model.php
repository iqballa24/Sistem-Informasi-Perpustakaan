<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian_model extends CI_Model {

    var $table = array('pengembalian');

    //field yang ditampilkan
    var $column_order = array(null, 'a.kd_pinjam','kd_kembali', 'nama', 'bts_pinjam', 'tgl_kembali', 'a.Jumlah','jumlah');

    //field yang diizin untuk pencarian 
    var $column_search = array('a.kd_pinjam', 'nama', 'bts_pinjam','tgl_kembali', 'a.Jumlah', 'jumlah');

    //field pertama yang diurutkan
    var $order = array('kd_kembali' => 'DESC');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {

        $this->db->select('*');
        $this->db->from('peminjaman a');
        $this->db->join('pengembalian b', 'a.kd_pinjam = b.kd_pinjam');
        $this->db->join('anggota c', 'a.id_anggota = c.id_anggota');

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
	
	public function read() {
		// sql read
        $this->db->select('*, DateDiff(tgl_kembali, bts_pinjam) as telat, (a.Jumlah - b.jumlah) as hilang');
        $this->db->from('peminjaman a');
        $this->db->join('pengembalian b', 'a.kd_pinjam = b.kd_pinjam');
        $this->db->join('anggota c', 'a.id_anggota = c.id_anggota');
        $this->db->order_by('a.kd_pinjam DESC');
        $query = $this->db->get();

		// $query -> result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function read_check($kd)
    {
        $this->db->select('*');
        $this->db->from('pengembalian');
        $this->db->where('kd_pinjam', $kd);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getLastData()
    {
        $this->db->select('*');
        $this->db->from('pengembalian');
        $this->db->order_by('kd_pinjam','desc');
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->result_array();
        // $query = $this->db->query('SELECT kd_kembali FROM pengembalian ORDER BY kd_pinjam DESC limit 1 ');
        // $hasil = $query->row();

        // return $hasil->kd_kembali;
    }

    public function insert($input)
    {
        //$input = data yang dikirim dari controller
        return $this->db->insert('pengembalian', $input);
    }

    public function delete($id)
    {
        //$id = id data yang dikirim dari controller (sebagai filter data yang dihapus)
        $this->db->where('kd_kembali', $id);
        return $this->db->delete(array('denda', 'pengembalian'));
    }
}