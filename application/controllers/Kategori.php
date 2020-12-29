<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
            redirect('petugas/login');
        }

        //memanggil model
        $this->load->model('kategori_model');
    }

    public function index()
    {
        //mengarahkan ke function read
        $this->read();
    }

    //fungsi menampilkan data dalam bentuk json
    public function datatables()
    {
        //menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
        // sleep(2);

        //memanggil fungsi model datatables
        $list = $this->kategori_model->get_datatables();
        $data = array();
        $no   = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $field['kategori'];
            $row[] = '
					<a href="' . site_url('kategori/update/' . $field['id_kategori']) . '" class="btn btn-warning btn-sm" title="Edit">
						<i class="fas fa-edit"></i> 
					</a>
					<a href="' . site_url('kategori/delete/' . $field['id_kategori']) . '" class="btn btn-danger btn-sm btnHapus" title="Hapus">
						<i class="fas fa-trash-alt"></i> 
					</a>';

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $this->kategori_model->count_all(),
            "recordsFiltered" => $this->kategori_model->count_filtered(),
            "data"            => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function read()
    {
        //memanggil function read pada kategori model
        //function read berfungsi mengambil/read data dari table kota di database
         $data_kategori = $this->kategori_model->read();
         $NIP           = $this->session->userdata('nama');
         
         //mengirim data ke view
         $output = array(
             'judul'        => 'Kategori Buku',
             'theme_page'   => 'kategori_read',
             'data_kategori'=> $data_kategori,
             'data_petugas' => $NIP
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert()
    {
        $this->insert_submit();

         $NIP = $this->session->userdata('nama');
         $output = array(
             'judul'        => 'Tambah Kategori',
             'theme_page'   => 'kategori_insert',
             'data_petugas' => $NIP
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert_submit()
    {
        if ( $this->input->post('submit') == 'Simpan') {

            //aturan validasi input login
            $this->form_validation->set_rules('kategori', 'kategori', 'required|callback_insert_check');

            if ($this->form_validation->run() == TRUE) {
                
                //menangkap data input dari view
                $kategori = $this->input->post('kategori');
        
                //mengirim data ke model
                $input = array(
                    //format : nama field/kolom table => data input dari view
                    'kategori' => $kategori,
                );
        
                //memanggil function insert pada kota model
                //function insert berfungsi menyimpan/create data ke table kategori di database
                $data_kategori = $this->kategori_model->insert($input);

                //mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
                redirect('kategori/read');
            }

        }
    }

    public function insert_check(){

        //Menangkap data input dari view
        $kategori = $this->input->post('kategori');

        //check data di database
        $data_user = $this->kategori_model->read_check($kategori);

        if (!empty($data_user)) {

            //membuat pesan error
            $this->form_validation->set_message('insert_check', "Kategori ".$kategori." sudah ada dalam database");
            $this->session->set_tempdata('info', "Tidak dapat memasukan data yang sama", 1);
            return FALSE;
        }
        return TRUE;
    }

    public function update()
    {

        $this->update_submit();
        //menangkap id data yg dipilih dari view (parameter get)
         $id  = $this->uri->segment(3);
         $NIP = $this->session->userdata('nama');
         
         //function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
         $data_kategori_single = $this->kategori_model->read_single($id);
         
         //mengirim data ke view
         $output = array(
             'judul'      => 'Edit Kategori',
             'theme_page' => 'kategori_update',
             
             //mengirim data kota yang dipilih ke view
             'data_petugas'         => $NIP,
             'data_kategori_single' => $data_kategori_single,
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function update_submit()
    {

        if ($this->input->post('submit') == 'Simpan') {

            $this->form_validation->set_rules('kategori', 'kategori', 'required|callback_insert_check');

            if ($this->form_validation->run() == TRUE) {
                
                //menangkap id data yg dipilih dari view
                $id = $this->uri->segment(3);
        
                //menangkap data input dari view
                $kategori = $this->input->post('kategori');
        
                //mengirim data ke model
                $input = array(
                    //format : nama field/kolom table => data input dari view
                    'kategori' => $kategori,
                );
        
                //memanggil function update pada kategori model
                $data_kategori = $this->kategori_model->update($input, $id);

                //mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Data berhasil disimpan !', 1);
                redirect('kategori/read');
            }
        }
    }

    public function delete()
    {
        //menangkap id data yg dipilih dari view
        $id = $this->uri->segment(3);

        $this->db->db_debug = false; //disable debugging queries

        // Error handling
        if (!$this->kategori_model->delete($id)) {
            $msg =  $this->db->error();
            $this->session->set_tempdata('error', $msg['message'], 1);
        }

        //mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
        redirect('kategori/read');
    }
}
