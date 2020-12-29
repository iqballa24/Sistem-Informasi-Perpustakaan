<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends CI_Controller {

	public function __construct() {
        parent::__construct();

        if (empty($this->session->userdata('NIP'))) {
            redirect('petugas/login');
        }

        // memanggil model
        $this->load->model(array('peminjaman_model', 'anggota_model', 'buku_model','detail_model', 'pengembalian_model'));
    }

    //fungsi menampilkan data dalam bentuk json
    public function datatables()
    {
        //menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
        // sleep(2);

        //memanggil fungsi model datatables
        $list = $this->peminjaman_model->get_datatables();
        $data = array();
        $no   = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $date1 = date_create($field['tgl_pinjam']);
            $date2 = date_create($field['bts_pinjam']);
            $row   = array();
            $row[] = $no;
            $row[] = $field['kd_pinjam'];
            $row[] = $field['nama'];
            $row[] = date_format($date1, "D, d M Y");
            $row[] = date_format($date2, "D, d M Y");
            $row[] = $field['Jumlah']. ' Buku';
            $row[] = $field['status'];
            $row[] = '
                    <a href="' . site_url('detail/read/' . $field['kd_pinjam']) . '" class="btn btn-info btn-sm" title="Detail peminjaman">
						<i class="fas fa-search"></i>
					</a>
					<a href="' . site_url('peminjaman/delete/' . $field['kd_pinjam']) . '" class="btn btn-danger btn-sm hapus" title="Hapus">
						<i class="fas fa-trash-alt"></i>
                    </a>
                    <a href="' . site_url('detail/export/' . $field['kd_pinjam']) . '" class="btn btn-success btn-sm" title="Export data">
                        <i class="fas fa-file-excel"></i>
                    </a>';

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $this->peminjaman_model->count_all(),
            "recordsFiltered" => $this->peminjaman_model->count_filtered(),
            "data"            => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function index() {
		// mengarahkan ke function read
		$this->read();
	}

	public function read() {
		
        $data_peminjaman = $this->peminjaman_model->read();
        $NIP = $this->session->userdata('nama');
         
         // mengirim data ke view
         $output = array(
                     'theme_page'   => 'peminjaman_read',
                     'judul' 	    => 'Data Peminjaman',
                    
                     // data peminjaman dikirim ke view
                     'data_peminjaman' => $data_peminjaman,
                     'data_petugas'    => $NIP
					);

		// memanggil file view
		$this->load->view('theme/index', $output);
    }

    public function insert()
    {
        $this->insert_submit();
        
        $data_anggota    = $this->anggota_model->read();
        $data_peminjaman = $this->peminjaman_model->read();
        $status_pinjam   = $this->peminjaman_model->getPinjam();
        $data_buku       = $this->buku_model->read();
        $dt_peminjaman   = $this->detail_model->read();
        $NIP             = $this->session->userdata('nama');
        
        //mengirim data ke view
        $output = array(
            'judul'             => 'Transaksi Peminjaman',
            'theme_page'        => 'peminjaman_insert',
            'data_peminjaman'   => $data_peminjaman,
            'status_pinjam'     => $status_pinjam,
            'data_petugas'      => $NIP,
            'data_anggota'      => $data_anggota,
            'data_buku'         => $data_buku,
            'dt_peminjaman'     => $dt_peminjaman
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert_submit()
    {

        if ($this->input->post('submit') == 'Simpan') {

            //aturan validasi input login
            $this->form_validation->set_rules('kd_pinjam', 'Kode Peminjaman', 'required|callback_insert_check');
            $this->form_validation->set_rules('nama', 'Nama Anggota', 'required');
            $this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'required');
            $this->form_validation->set_rules('bts_pinjam', 'Batas Pinjam', 'required');

            if ($this->form_validation->run() == TRUE) {

                // menangkap data input dari view
                $kd_pinjam      = $this->input->post('kd_pinjam');
                $nama           = $this->input->post('nama');
                $tgl_pinjam     = $this->input->post('tgl_pinjam');
                $bts_pinjam     = $this->input->post('bts_pinjam');

                // mengirim data ke model
                $input = array(
                    // format : nama field/kolom table => data input dari view
                    'kd_pinjam'    => $kd_pinjam,
                    'id_anggota'   => $nama,
                    'tgl_pinjam'   => $tgl_pinjam,
                    'bts_pinjam'   => $bts_pinjam
                );

                // memanggil function insert pada anggota_model.php
                // function insert berfungsi menyimpan/create data ke table anggota di database
                $data_peminjaman = $this->peminjaman_model->insert($input);

                // mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Sukses, data berhasil ditambahkan !', 3);
                redirect('peminjaman/insert');
            }
        }
    }

    public function insert_check()
    {

        //Menangkap data input dari view
        $kd_pinjam = $this->input->post('kd_pinjam');

        //check data di database
        $data_user = $this->detail_model->read_check($kd_pinjam);

        if (!empty($data_user)) {

            //membuat pesan error
            $this->form_validation->set_message('insert_check', "Kode Peminjaman " . $kd_pinjam . " sudah ada dalam database");
            return FALSE;
        }
        return TRUE;
    }

    public function update()
    {
        //menangkap id data yg dipilih dari view (parameter get)
         $id  = $this->uri->segment(3);
         $NIP = $this->session->userdata('nama');
         
         //function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
         $data_peminjaman_single = $this->peminjaman_model->read_single($id);
         $data_anggota           = $this->anggota_model->read();
         
         //mengirim data ke view
         $output = array(
             'judul'                 => 'Edit Data Peminjaman',
             'theme_page'            => 'peminjaman_update',
             'data_anggota'          => $data_anggota,
             'data_peminjaman_single'=> $data_peminjaman_single,
             'data_petugas'          => $NIP
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function update_submit()
    {
        //menangkap id data yg dipilih dari view
        $kd = $this->uri->segment(3);

        // menangkap data input dari view
        $nama           = $this->input->post('nama');
        $tgl_pinjam     = $this->input->post('tgl_pinjam');
        $bts_pinjam     = $this->input->post('bts_pinjam');

        // mengirim data ke model
        $input = array(
            // format : nama field/kolom table => data input dari view
            'id_anggota' => $nama,
            'tgl_pinjam' => $tgl_pinjam,
            'bts_pinjam' => $bts_pinjam
        );

        //memanggil function update pada kategori model
        $data_peminjaman = $this->peminjaman_model->update($input, $kd);

        //mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Sukses, data berhasil disimpan !', 1);
        redirect('peminjaman/read');
    
    }

    public function delete()
    {
        // menangkap id data yg dipilih dari view
        $id = $this->uri->segment(3);

        // memanggil function delete pada anggota_model.php
        $data_peminjaman = $this->peminjaman_model->delete($id);

        // mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Sukses, data berhasil dihapus', 1);
        redirect('peminjaman/read');
    }

    public function export()
    {
        $data_peminjaman = $this->peminjaman_model->read();
        $NIP = $this->session->userdata('nama');

        //mengirim data ke view
        $output = array(

            //data provinsi dikirim ke view
            'data_peminjaman' => $data_peminjaman,
            'data_petugas' => $NIP
        );

        //memanggil file view
        $this->load->view('peminjaman_export', $output);
    }
}