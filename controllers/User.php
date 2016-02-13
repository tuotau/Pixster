<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
		
	public function index()
	{
		$this->load->library('form_validation');
		$this->load->model('model_user');
		$data['login'] = $this->model_user->isLoggedIn();
		if($data['login']){
			$this->load->view('header');
			$this->load->view('nav', $data);
			
			$this->form_validation->set_rules('username', 'Username', 'min_length[5]|max_length[15]|htmlspecialchars|callback_uniqueUsername');
			$this->form_validation->set_rules('password', 'New password', 'min_length[5]|max_length[15]|htmlspecialchars');
			$this->form_validation->set_rules('old_password', 'Current password', 'required|min_length[5]|max_length[15]|htmlspecialchars|callback_loginCheck['.$this->session->userdata('username').']');
			$this->form_validation->set_rules('email', 'Email', 'valid_email|htmlspecialchars');
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('content_user');
			}
			else{
				$data['success_title'] = "Your information was updated!";
				$this->load->view('content_success',$data);
				$this->model_user->updateUser($this->input->post('username', true),$this->input->post('password', true),$this->input->post('email', true));
			}
			$this->load->view('footer');
		}
		else
			redirect("login");
	}
	
	public function uniqueUsername($username){
		$success = $this->model_user->uniqueUsername($username);
		if($success)
			return true;
		
		$this->form_validation->set_message('uniqueUsername', "This username already exists!");
		return false;
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