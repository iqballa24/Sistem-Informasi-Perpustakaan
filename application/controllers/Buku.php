<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
            redirect('petugas/login');
        }

        //memanggil model
        $this->load->model(array('buku_model', 'kategori_model', 'penerbit_model'));
    }

    public function index()
    {
        //mengarahkan ke function read
        $this->read();
    }

    public function read()
    {
        //memanggil function read pada kota model
        //function read berfungsi mengambil/read data dari table kota di database
        $data_buku = $this->buku_model->read();
        $NIP = $this->session->userdata('nama');

        //mengirim data ke view
        $output = array(
            'judul'         => 'Katalog Buku',
            'theme_page'    => 'buku_read',
            //data kota dikirim ke view
            'data_buku'     => $data_buku,
            'data_petugas'  => $NIP
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    //fungsi menampilkan data dalam bentuk json
    public function datatables()
    {
        //menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
        //sleep(2);

        //memanggil fungsi model datatables
        $list = $this->buku_model->get_datatables();
        $data = array();
        $no   = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field['judul'];
            $row[] = '<img src="' . base_url('upload_folder/' . $field['gambar']) . '" class="img-fluid" style="height:75px; width:55px;" alt="ini gambar">';
            $row[] = $field['kategori'];
            $row[] = $field['penerbit'];
            $row[] = $field['stok_buku'];
            $row[] = '
                    <a href="#" class="btn btn-info btn-sm detail" title="Detail" data-toggle="modal" data-target="#modal-detail" 
                        data-isbn="' . $field['ISBN'] . '"
                        data-judul="' . $field['judul'] . '"
                        data-terbit="' . $field['thn_terbit'] . '" 
                        data-gambar="' . $field['gambar'] . '" 
                        data-kategori="' . $field['kategori'] . '"
                        data-penerbit="' . $field['penerbit'] . '"
                        data-rate="' . $field['rating'] . '"
                        data-rak="' . $field['rak'] . '"> 
                        <i class="fas fa-search"></i>
                     </a>

                    <a href = "' . site_url('buku/update/' . $field['id_buku']) . '" class = "btn btn-warning btn-sm" title = "Edit">
                        <i class = "fas fa-edit"></i> 
                     </a>

                     <a href = "' . site_url('buku/delete/' . $field['id_buku']) . '" class ="btn btn-danger btn-sm btnHapus" title = "Hapus">
                        <i class = "fas fa-trash-alt"></i> 
                     </a>';

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $this->buku_model->count_all(),
            "recordsFiltered" => $this->buku_model->count_filtered(),
            "data"            => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function insert()
    {
        $this->insert_submit();
        //mengambil daftar provinsi dari table provinsi
        $data_kategori = $this->kategori_model->read();
        $data_penerbit = $this->penerbit_model->read();
        $NIP = $this->session->userdata('nama');

        //mengirim data ke view
        $output = array(
            'judul'      => 'Tambah buku',
            'theme_page' => 'buku_insert',

            //mengirim daftar provinsi ke view
            'data_petugas'  => $NIP,
            'data_kategori' => $data_kategori,
            'data_penerbit' => $data_penerbit,
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert_submit()
    {
        if ($this->input->post('submit') == 'Simpan') {

            //aturan validasi input login
            $this->form_validation->set_rules('isbn', 'ISBN', 'required|alpha_dash|callback_insert_check');
            $this->form_validation->set_rules('nama', 'Nama buku', 'required');
            $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
            $this->form_validation->set_rules('id_penerbit', 'Penerbit', 'required');
            $this->form_validation->set_rules('thnTerbit', 'Tahun Terbit', 'required|numeric');
            $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
            $this->form_validation->set_rules('rate', 'Rating', 'required');

            //setting library upload
            $config = array(
                'upload_path'    => './upload_folder/',
                'allowed_types'  => 'gif|jpg|png',
                'max_size'       => 5000
            );

            $this->load->library('upload', $config);

            if ($this->form_validation->run() == TRUE) {

                //menangkap data input dari view
                $kategori = $this->input->post('id_kategori');
                $penerbit = $this->input->post('id_penerbit');
                $isbn = $this->input->post('isbn');
                $thn  = $this->input->post('thnTerbit');
                $nama = $this->input->post('nama');
                $stok = $this->input->post('stok');
                $rate = $this->input->post('rate');

                //jika gagal upload
                if (!$this->upload->do_upload('userfile')) {

                    //mengambil daftar provinsi dari table provinsi
                    $data_kategori = $this->kategori_model->read();
                    $data_penerbit = $this->penerbit_model->read();
                    $NIP = $this->session->userdata('nama');

                    //respon alasan kenapa gagal upload
                    $response = $this->upload->display_errors();

                    //mengirim data ke view
                    $output = array(
                        'judul'      => 'Tambah buku',
                        'theme_page' => 'buku_insert',
                        'response'   => $response,

                        //mengirim daftar provinsi ke view
                        'data_kategori' => $data_kategori,
                        'data_penerbit' => $data_penerbit,
                        'data_petugas'  => $NIP
                    );

                    //memanggil file view
                    $this->load->view('theme/index', $output);

                    //jika berhasil upload
                } else {
                    $this->upload->do_upload('userfile');
                    $upload_data = $this->upload->data('file_name');

                    //mengirim data ke model
                    $input = array(
                        //format : nama field/kolom table => data input dari view
                        'id_kategori' => $kategori,
                        'id_penerbit' => $penerbit,
                        'isbn'        => $isbn,
                        'judul'       => $nama,
                        'stok_buku'   => $stok,
                        'thn_terbit'  => $thn,
                        'rating'      => $rate,
                        'gambar'      => $upload_data
                    );

                    //memanggil function insert pada kota model
                    //function insert berfungsi menyimpan/create data ke table buku di database
                    $data_buku = $this->buku_model->insert($input);

                    //mengembalikan halaman ke function read
                    $this->session->set_tempdata('message', 'Data berhasil ditambahkan', 1);
                    Redirect('buku/read');
                }
            }
        }
    }

    public function insert_check()
    {

        //Menangkap data input dari view
        $isbn  = $this->input->post('isbn');
        $judul = $this->input->post('judul');

        //check data di database
        $data_user = $this->buku_model->read_check($isbn);

        if (!empty($data_user)) {

            //membuat pesan error
            $this->form_validation->set_message('insert_check', "Buku dengan ISBN " . $isbn . " sudah ada", 1);
            $this->session->set_tempdata('info', "Tidak dapat memasukan data yang sama", 1);

            return FALSE;
        }
        return TRUE;
    }

    public function update()
    {
        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(3);
        $NIP = $this->session->userdata('nama');

        //function read berfungsi mengambil 1 data dari table kota sesuai id yg dipilih
        $data_buku_single = $this->buku_model->read_single($id);

        //mengambil daftar kategori dan penerbit
        $data_kategori = $this->kategori_model->read();
        $data_penerbit = $this->penerbit_model->read();

        //mengirim data ke view
        $output = array(
            'judul'      => 'Edit Buku',
            'theme_page' => 'buku_update',

            //mengirim data kota yang dipilih ke view
            'data_buku_single' => $data_buku_single,

            //mengirim daftar provinsi ke view
            'data_petugas'  => $NIP,
            'data_kategori' => $data_kategori,
            'data_penerbit' => $data_penerbit,
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function update_submit()
    {
        //setting library upload
        $config['upload_path']          = './upload_folder/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5000;
        $this->load->library('upload', $config);

        //menangkap data input dari view
        $kategori = $this->input->post('id_kategori');
        $penerbit = $this->input->post('id_penerbit');
        $isbn = $this->input->post('isbn');
        $thn  = $this->input->post('thnTerbit');
        $nama = $this->input->post('nama');
        $stok = $this->input->post('stok');
        $rate = $this->input->post('rate');

        //menangkap id data yg dipilih dari view (parameter get)
        $id = $this->uri->segment(3);

        //jika gagal upload
        if (!$this->upload->do_upload('userfile')) {

            //function read berfungsi mengambil 1 data dari table kota sesuai id yg dipilih
            $data_buku_single = $this->buku_model->read_single($id);

            //mengambil daftar provinsi dari table provinsi
            $data_kategori = $this->kategori_model->read();
            $data_penerbit = $this->penerbit_model->read();
            $NIP = $this->session->userdata('nama');


            //respon alasan kenapa gagal upload
            $response = $this->upload->display_errors();

            //mengirim data ke view
            $output = array(
                'judul'         => 'Edit buku',
                'theme_page'    => 'buku_update',
                'response'      => $response,

                //mengirim data kota yang dipilih ke view
                'data_buku_single' => $data_buku_single,

                //mengirim daftar provinsi ke view
                'data_kategori' => $data_kategori,
                'data_penerbit' => $data_penerbit,
                'data_petugas'  => $NIP,
            );

            //memanggil file view
            $this->load->view('theme/index', $output);

            //jika berhasil upload
        } else {
            $this->upload->do_upload('userfile');
            $upload_data = $this->upload->data('file_name');

            //mengirim data ke model
            $input = array(
                //format : nama field/kolom table => data input dari view
                'id_kategori' => $kategori,
                'id_penerbit' => $penerbit,
                'isbn'        => $isbn,
                'judul'       => $nama,
                'stok_buku'   => $stok,
                'thn_terbit'  => $thn,
                'rating'      => $rate,
                'gambar'      => $upload_data
            );

            //memanggil function insert pada kota model
            //function insert berfungsi menyimpan/create data ke table buku di database
            $data_buku = $this->buku_model->update($input, $id);

            //mengembalikan halaman ke function read
            $this->session->set_tempdata('message', 'Data berhasil disimpan', 1);
            Redirect('buku/read');
        }
    }

    public function delete()
    {
        //menangkap id data yg dipilih dari view
        $id = $this->uri->segment(3);

        $this->db->db_debug = false; //disable debugging queries

        // Error handling
        if (!$this->buku_model->delete($id)) {
            $msg =  $this->db->error();
            $this->session->set_tempdata('error', $msg['message'], 1);
        }

        //mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
        redirect('buku/read');
    }

    public function export()
    {
        $data_buku = $this->buku_model->read();
        $NIP = $this->session->userdata('nama');

        //mengirim data ke view
        $output = array(

            //data provinsi dikirim ke view
            'data_petugas' => $NIP,
            'data_buku' => $data_buku
        );

        //memanggil file view
        $this->load->view('buku_export', $output);
    }

    public function filterBook()
    {
        $NIP = $this->session->userdata('nama');

        $output = array(
            'judul'         => 'Pencarian Buku',
            'theme_page'    => 'buku_filter',
            'data_petugas'  => $NIP

        );

        $this->load->view('theme/index', $output);
    }

    public function fetchBook()
    {
        $query = $this->input->post('query');

        if ($query != '') {
            $qry = "SELECT * from buku a join penerbit b on a.id_penerbit = b.id_penerbit join kategori c on a.id_kategori = c.id_kategori where judul LIKE '$query%'";
            $result = $this->db->query($qry);
    
            echo json_encode($result->result_array());
        }else{
            echo json_encode(['empty' => 'Ketik nama buku yang ingin dicari']);
			die();
        }
    }
}
