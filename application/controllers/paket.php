<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class paket extends CI_Controller {

	function __Construct(){
		parent::__construct();
		$this->load->model('mpaket');
		// do your validations
		while(!$this->session->userdata('loggedin'))
		{
			redirect(base_url('login'));
		}
	}

	public function index()
	{
		$query['title'] = $this->input->get('title', TRUE);
		if($query['title'] != "")
		{
			$this->db->like('title', $query['title']);
		}
		$query['row'] = $this->mpaket->get_paket();

		$data['menu'] = "paket";
		$data['title'] = "Paket | MJM Travel";

		$this->load->view('header', $data);
		$this->load->view('paket_view', $query);		
		$this->load->view('footer');
	}

	public function add()
	{
		$data['menu'] = "paket";
		$data['title'] = "Tambah Paket | MJM Travel";

		$this->load->view('header', $data);
		$this->load->view('paket_add_view');		
		$this->load->view('footer');
	}

	public function detail()
	{
		$get_id = $this->input->get("id", true);
		$query['row'] = $this->mpaket->detail($get_id);
		$query['userview_url'] = "http://localhost/company-profile-kons/";

		$data['menu'] = "paket";
		$data['title'] = "Detail Paket | MJM Travel";

		$this->load->view('header', $data);
		$this->load->view('paket_detail_view', $query);		
		$this->load->view('footer');
	}

	public function addpaket()
	{
		$config['upload_path'] = '../company-profile-kons/asset/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('banner')){
			echo "<script>alert('File Harus Gambar');location='".base_url()."paket/add'</script>";
		}else{
			$data = array(
						'title'=>$this->input->post('title'),
						'url_title'=>url_title($this->input->post('title'), "dash", TRUE),
						'harga'=>$this->input->post('harga'),
						'tgl_berangkat'=>$this->input->post('tgl_berangkat'),
						'deskripsi'=>$this->input->post('deskripsi'),
						'itinerary'=>$this->input->post('itinerary'),
						'fasilitas'=>$this->input->post('fasilitas'),
						'ketentuan'=>$this->input->post('ketentuan'),
						'status'=>$this->input->post('status'),
						'img'=>$this->upload->data('file_name')
					);
			$this->mpaket->add($data);
			echo "<script>alert('Simpan Berhasil');location='".base_url()."paket'</script>";
		}
	}

	public function editpaket()
	{
		// password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
		// password_verify($password, $hash);
		$config['upload_path'] = '../company-profile-kons/assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('banner')){
			echo "<script>alert('File Harus Gambar');location='".base_url()."paket/detail'</script>";
		}else{
			$data = array(
						'title'=>$this->input->post('title'),
						'harga'=>$this->input->post('harga'),
						'tgl_berangkat'=>$this->input->post('tgl_berangkat'),
						'deskripsi'=>$this->input->post('deskripsi'),
						'itinerary'=>$this->input->post('itinerary'),
						'fasilitas'=>$this->input->post('fasilitas'),
						'ketentuan'=>$this->input->post('ketentuan'),
						'status'=>$this->input->post('status'),
						'img'=>$this->upload->data('file_name')
					);
			$this->mpaket->add($data);
			echo "<script>alert('Simpan Berhasil');location='".base_url()."paket'</script>";
		}
	}

	public function delete()
	{
		$get_id = $this->input->get("id", true);
		$this->mpaket->deletepaket($get_id);
		redirect(base_url('paket/'));
	}

}
