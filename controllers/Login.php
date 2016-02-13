<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{
		$this->load->library('form_validation');
		
		$this->load->model('model_user');
		
		$this->form_validation->set_rules('username', 'Username', 'required|htmlspecialchars');
		$this->form_validation->set_rules('password', 'Password', 'required|htmlspecialchars|callback_loginCheck['.$this->input->post("username", true).']');
		
		if ($this->form_validation->run() != FALSE)
			redirect('main');
		else{
			$data['login'] = $this->model_user->isLoggedIn();
			$this->load->view('header');
			$this->load->view('nav', $data);
			$this->load->view('content_login');
			$this->load->view('footer');
		}
		
	}
	
	public function loginCheck($password, $username){
		$success = $this->model_user->login($username, $password);
		if($success)
			return true;
		
		$this->form_validation->set_message('loginCheck', "Your username and password don't match!");
		return false;
	}
}
?>