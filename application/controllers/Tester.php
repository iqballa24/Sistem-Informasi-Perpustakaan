<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tester extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('NIP'))) {
			redirect('petugas/login');
		}

        // memanggil model
		$this->load->library('grocery_CRUD');
		
    }

    public function index() {
		// mengarahkan ke function read
        $this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->tester();
	}

    public function tester()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('anggota');
			$crud->set_subject('Anggota Perpustakaan');
			$crud->required_fields('nama','prodi');
			$crud->columns('nama','nim','prodi','email','password');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

    public function _example_output($output = null)
	{
        $this->load->view('tester_read.php',$output); 
	}

}