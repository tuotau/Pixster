<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	/*public function index()
	{
		$this->load->view('welcome_message');
	}*/
	
	public function index()
	{
		$this->front();
	}
	
	public function front()
	{
		$this->load->model('model_images');
		$this->load->model('model_user');
		$data['thumbnails'] = $this->model_images->getRecentImagesThumbnails(10);
		$data['images'] = $this->model_images->getRecentImages(10);
		$data['login'] = $this->model_user->isLoggedIn();
		$this->load->view('header');
		$this->load->view('nav', $data);
		$this->load->view('content_front', $data);
		$this->load->view('footer');
	}

	public function vote($id, $vote){
		$this->load->model('model_images');
		$success = $this->model_images->vote($id, $vote);
		echo $success;
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect('main');
	}
	
	

}
