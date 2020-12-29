<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        //memanggil model
        $this->load->model(array('petugas_model'));
    }


    public function index()
    {
        //mengarahkan ke function read
        $this->login();
    }

    public function read()
    {

        $NIP = $this->session->userdata('nama');
        $level = $this->session->userdata('level');

        if ($level == 'petugas') {
            $this->session->set_tempdata('error', "Anda tidak memiliki hak akses", 0);
            redirect($_SERVER['HTTP_REFERER']);
        }

        // mengirim data ke view
        $output = array(
            'theme_page' => 'petugas_read',
            'judul'      => 'User management',

            // data anggota dikirim ke view
            'data_petugas' => $NIP
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    //fungsi menampilkan data dalam bentuk json
    public function datatables()
    {
        //menunda loading (bisa dihapus, hanya untuk menampilkan pesan processing)
        // sleep(2);

        //memanggil fungsi model datatables
        $list = $this->petugas_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');

        //mencetak data json
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field['NIP'];
            $row[] = $field['nama'];
            $row[] = $field['email'];
            $row[] = $field['level'];
            $row[] = '
					<a href="' . site_url('petugas/update/' . $field['NIP']) . '" class="btn btn-warning btn-sm " title="Edit">
						<i class="fas fa-pencil-alt"></i> Edit
					</a>
					<a href="' . site_url('petugas/delete/' . $field['NIP']) . '" class="btn btn-danger btn-sm btnHapus" title="Hapus" data = "' . $field['NIP'] . '">
						<i class="fas fa-trash-alt"></i> Hapus
					</a>';

            $data[] = $row;
        }

        //mengirim data json
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->petugas_model->count_all(),
            "recordsFiltered" => $this->petugas_model->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
    }

    public function insert()
    {

        $this->insert_submit();
        $NIP = $this->session->userdata('nama');

        // mengirim data ke view
        $output = array(
            'theme_page'     => 'petugas_insert',
            'judul'          => 'User management',
            'data_petugas'     => $NIP
        );

        // memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function insert_submit()
    {

        if ($this->input->post('submit') == 'Simpan') {

            //aturan validasi input login
            $this->form_validation->set_rules('nip', 'NIP', 'required|min_length[5]|numeric|callback_insert_check');
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('level', 'Level', 'required');

            if ($this->form_validation->run() == TRUE) {

                // menangkap data input dari view
                $nip    = $this->input->post('nip');
                $nama   = $this->input->post('nama');
                $email  = $this->input->post('email');
                $level  = $this->input->post('level');

                // mengirim data ke model
                $input = array(
                    // format : nama field/kolom table => data input dari view
                    'nip'       => $nip,
                    'nama'      => $nama,
                    'level'     => $level,
                    'password'  => $nip,
                    'email'     => $email
                );

                // memanggil function insert pada anggota_model.php
                // function insert berfungsi menyimpan/create data ke table anggota di database
                $data_petugas = $this->petugas_model->insert($input);

                // mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Data berhasil ditambahkan !', 1);
                redirect('petugas/read');
            }
        }
    }

    public function insert_check()
    {

        //Menangkap data input dari view
        $nip = $this->input->post('nip');

        //check data di database
        $data_user = $this->petugas_model->read_check($nip);

        if (!empty($data_user)) {

            //membuat pesan error
            $this->form_validation->set_message('insert_check', "NIP " . $nip . " sudah ada dalam database");
            $this->session->set_tempdata('error', "Tidak dapat memasukan data yang sama", 1);
            return FALSE;
        }
        return TRUE;
    }

    public function login()
    {

        //memanggil fungsi login submit	(agar di view tidak dilihat fungsi login submit)
        $this->login_submit();

        //mengirim data ke view
        $output = array(
            'judul' => 'Login'
        );

        //memanggil file view
        $this->load->view('login', $output);
    }

    private function login_submit()
    {

        //proses jika tombol login di submit
        if ($this->input->post('submit') == 'Login') {

            //aturan validasi input login
            $this->form_validation->set_rules('NIP', 'NIP', 'required|alpha_numeric|callback_login_check');
            $this->form_validation->set_rules('password', 'Password', 'required|alpha_numeric|min_length[5]');

            //jika validasi sukses 
            if ($this->form_validation->run() == TRUE) {

                redirect('dashboard/read');
            }
        }
    }

    public function login_check()
    {
        //menangkap data input dari view
        $NIP      = $this->input->post('NIP');
        $password = $this->input->post('password');

        //password encrypt
        $password_encrypt = md5($password);

        //check username & password sesuai dengan di database
        $data_user = $this->petugas_model->read_single($NIP, $password_encrypt);

        //jika cocok : dikembalikan ke fungsi login_submit (validasi sukses)
        if (!empty($data_user)) {

            //buat session user 
            $this->session->set_userdata('NIP', $data_user['NIP']);
            $this->session->set_userdata('nama', $data_user['nama']);
            $this->session->set_userdata('level', $data_user['level']);

            return TRUE;

            //jika tidak cocok : dikembalikan ke fungsi login_submit (validasi gagal)
        } else {

            //membuat pesan error
            $this->form_validation->set_message('login_check', 'Username & password tidak tepat');

            return FALSE;
        }
    }

    public function logout()
    {

        //hapus session user
        $this->session->unset_userdata('NIP');
        $this->session->unset_userdata('nama');

        //mengembalikan halaman ke function read
        redirect('petugas/login');
    }

    public function reset()
    {

        $this->reset_submit();
        $NIP = $this->session->userdata('nama');
        //mengirim data ke view
        $output = array(
            'theme_page'   => 'reset_password',
            'judul'        => 'Reset password',
            'data_petugas' => $NIP
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    private function reset_submit()
    {

        if ($this->input->post('submit') == 'Simpan') {

            //aturan validasi input login
            $this->form_validation->set_rules('password_lama', 'Current Password', 'required|alpha_numeric|callback_reset_check');
            $this->form_validation->set_rules('password_baru', 'New Password', 'required|alpha_numeric|min_length[5]|differs[password_lama]');
            $this->form_validation->set_rules('password_baru_ulangi', 'Confirm New Password', 'required|alpha_numeric|min_length[5]|matches[password_baru]');

            if ($this->form_validation->run() == TRUE) {

                //menangkap data input dari view
                $newPassword = $this->input->post('password_baru');

                //password encrypt
                $Password = md5($newPassword);

                //session user
                $id = $this->session->userdata('NIP');

                //mengirim data ke model
                $input = array(
                    //format : nama field/kolom table => data input dari view
                    'password' => $Password,
                );

                //memanggil function insert pada user model
                $data = $this->petugas_model->update($input, $id);

                //redirect ke provinsi (bisa dirubah ke controller & fungsi manapun)
                $this->session->set_tempdata('message', 'Password berhasil diubah !', 3);
                redirect('petugas/reset');
            }
        }
    }

    public function reset_check()
    {
        //menangkap data input dari view
        $currentPassword = $this->input->post('password_lama');

        //password encrypt
        $currentPassword = md5($currentPassword);

        //check username & password sesuai dengan di database
        $data_user = $this->petugas_model->read($currentPassword);

        //jika data user sesuai dengan di database
        if (empty($data_user)) {

            //membuat pesan error
            $this->form_validation->set_message('reset_check', 'Wrong Current Password');
            return FALSE;
        }

        //jika tidak cocok : dikembalikan ke fungsi login_submit (validasi gagal)
        return TRUE;
    }

    public function update()
    {

        $this->update_submit();
        // $this->load->library('encryption');

        //menangkap id data yg dipilih dari view (parameter get)
        $id  = $this->uri->segment(3);
        $NIP = $this->session->userdata('nama');

        //function read berfungsi mengambil 1 data dari table kategori sesuai id yg dipilih
        $data_petugas_single = $this->petugas_model->read_single_update($id);

        //mengirim data ke view
        $output = array(
            'judul'         => 'Edit User',
            'theme_page'    => 'petugas_update',
            'data_petugas'  => $NIP,

            //mengirim data kota yang dipilih ke view
            'data_petugas_single' => $data_petugas_single
        );

        //memanggil file view
        $this->load->view('theme/index', $output);
    }

    public function update_submit()
    {

        if ($this->input->post('submit') == 'Simpan') {

            //aturan validasi input login
            $this->form_validation->set_rules('nip', 'NIP', 'required|min_length[5]|numeric');
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');

            if ($this->form_validation->run() == TRUE) {

                //menangkap id data yg dipilih dari view
                $id = $this->uri->segment(3);

                // menangkap data input dari view
                $nip      = $this->input->post('nip');
                $nama     = $this->input->post('nama');
                $email    = $this->input->post('email');
                $level    = $this->input->post('level');
                $password = $this->input->post('password');

                //password encrypt
                $password_encrypt = md5($password);

                // mengirim data ke model
                $input = array(
                    // format : nama field/kolom table => data input dari view
                    'nip'       => $nip,
                    'nama'      => $nama,
                    'level'     => $level,
                    'password'  => $nip,
                    'email'     => $email,
                    'password'  => $password_encrypt
                );

                //memanggil function update pada kategori model
                $data_petugas = $this->petugas_model->update($input, $id);

                //mengembalikan halaman ke function read
                $this->session->set_tempdata('message', 'Data berhasil disimpan !', 1);
                redirect('petugas/read');
            }
        }
    }

    public function delete()
    {
        // menangkap id data yg dipilih dari view
        $id = $this->uri->segment(3);

        // memanggil petugas_model
        $this->petugas_model->delete($id);

        //mengembalikan halaman ke function read
        $this->session->set_tempdata('message', 'Data berhasil dihapus', 1);
        redirect('petugas/read');

    }
}
