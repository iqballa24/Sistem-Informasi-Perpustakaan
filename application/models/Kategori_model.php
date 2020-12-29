<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kategori_model extends CI_Model
{

    //nama tabel dari database
    var $table = 'kategori';

    //field yang ditampilkan
    var $column_order = array(null, 'kategori');

    //field yang diizin untuk pencarian 
    var $column_search = array('kategori');

    //field pertama yang diurutkan
    var $order = array('kategori' => 'asc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {

        $this->db->select('*');
        $this->db->from($this->table);

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

    //function read berfungsi mengambil/read data dari table buku di database
    public function read()
    {

        //sql read
        $this->db->select('*');
        $this->db->from('kategori a');
        $this->db->order_by('a.kategori ASC');
        $query = $this->db->get();

        //$query->result_array = mengirim data ke controller dalam bentuk semua data
        return $query->result_array();
    }

    public function read_check($kategori)
    {
        $this->db->select('*');
        $this->db->from('kategori');
        $this->db->where('kategori', $kategori);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function read_single($id)
    {

        //sql read
        $this->db->select('*');
        $this->db->from('kategori');

        //$id = id data yang dikirim dari controller (sebagai filter data yang dipilih)
        //filter data sesuai id yang dikirim dari controller
        $this->db->where('id_kategori', $id);

        $query = $this->db->get();

        //query->row_array = mengirim data ke controller dalam bentuk 1 data
        return $query->row_array();
    }

    //function insert berfungsi menyimpan/create data ke table kategori di database
    public function insert($input)
    {
        //$input = data yang dikirim dari controller
        return $this->db->insert('kategori', $input);
    }

    //function update berfungsi merubah data ke table kategori di database
    public function update($input, $id)
    {
        //$id = id data yang dikirim dari controller (sebagai filter data yang diubah)
        //filter data sesuai id yang dikirim dari controller
        $this->db->where('id_kategori', $id);

        //$input = data yang dikirim dari controller
        return $this->db->update('kategori', $input);
    }

    //function delete berfungsi menghapus data dari table kategori di database
    public function delete($id)
    {
        //$id = id data yang dikirim dari controller (sebagai filter data yang dihapus)
        $this->db->where('id_kategori', $id);
        return $this->db->delete('kategori');
    }
}
