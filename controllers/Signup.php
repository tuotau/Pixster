<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
		
	public function index()
	{
		$this->load->library('form_validation');
		
		$this->load->model('model_user');
		$data['login'] = $this->model_user->isLoggedIn();
		$this->load->view('header');
		$this->load->view('nav', $data);
		
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[15]|htmlspecialchars|callback_uniqueUsername');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[15]|htmlspecialchars');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|htmlspecialchars');
		
		if ($this->form_validation->run() == FALSE){
			$this->load->view('content_signup');
		}
		else{
			$data['success_title'] = "Signup was succesfull!";
			$this->load->view('content_success',$data);
			$this->model_user->createUser($this->input->post('username', true),$this->input->post('password', true),$this->input->post('email', true));
		}
		$this->load->view('footer');
	}
	
	public function uniqueUsername($username){
		$success = $this->model_user->uniqueUsername($username);
		if($success)
			return true;
		
		$this->form_validation->set_message('uniqueUsername', "This username already exists!");
		return false;
	}
}
?>