<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->model('model_user');
		$data['login'] = $this->model_user->isLoggedIn();
		if($data['login']){
			$this->load->view('header');
			$this->load->view('nav', $data);
			$this->load->view('content_upload', array('error' => ' ' ));
			$this->load->view('footer');
		}
		else
			redirect("login");
	}

	function do_upload()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[99]|htmlspecialchars');
		$this->form_validation->set_rules('description', 'description', 'required|min_length[5]|max_length[399]');
		
		$config['upload_path'] = './images/';
		$config['allowed_types'] = 'jpg';
		$config['max_size']	= '2000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  =  false;
		$config['encrypt_name']  =  true; 
		$config['max_filename']  =  '150';

		$this->load->library('upload', $config);
		
		$this->load->model('model_user');
		$data['login'] = $this->model_user->isLoggedIn();

		if ($this->form_validation->run() == FALSE || ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
		
			$this->load->view('header');
			$this->load->view('nav', $data);
			$this->load->view('content_upload', $error);
			$this->load->view('footer');
		}
		else
		{
			$upload_data = $this->upload->data(); 
			$file_name = $upload_data['file_name'];
			$file_path = $upload_data['full_path'];

			$this->load->model('model_images');
			$this->model_images->addImage($file_name, $this->input->post('title'), $this->input->post('description'), $file_path);
			
			
			$this->load->view('header');
			$this->load->view('nav', $data);
			$data['success_title'] = "Your image has been uploaded!";
			$data['redirect'] = "../main";
			$this->load->view('content_success',$data);
			$this->load->view('footer');
		}
	}
}
?>