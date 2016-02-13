<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_users extends CI_Controller {
	
	public function index()
	{
		$this->load->model('model_user');
		if($this->model_user->userId() != 1)
			redirect("main/front");
		else{
			$this->load->helper('form');
			$data['login'] = $this->model_user->isLoggedIn();
			$this->load->view('header');
			$this->load->view('nav', $data);
			
			if($this->input->post('submit')){
				$data['success_title'] = "User was deleted!";
				$this->load->view('content_success',$data);
				
				for($id=2; !$this->input->post("user_".$id); $id++);
				
				$this->model_user->deleteUser($id);
			}
			else{
				$data['users'] = $this->model_user->listUsers();
				$this->load->view('content_admin_users', $data);
			}
			$this->load->view('footer');
		}
	}
	
}
?>