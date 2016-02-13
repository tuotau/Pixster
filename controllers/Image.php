<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {
	

	public function index($image)
	{
		$this->load->library('form_validation');
		$this->load->model('model_images');
		$this->load->model('model_user');
		$data['login'] = $this->model_user->isLoggedIn();
		$data['userId'] = $this->model_user->userId();
		$data['role'] = $this->model_user->getRole($data['userId']);
		
		$data['image'] = $this->model_images->getImageInfo($image);
		$this->load->view('header');
		$this->load->view('nav', $data);
		if($data['image']->num_rows() == 0){
			$data['success_title'] = "Image you requested has been deleted, or its id was incorrect ";
			$data['redirect'] = "../main";
			$this->load->view('content_success',$data);
		}
		else{
			$data['image'] = $data['image']->row();
			$data['username'] = $this->model_user->getUsername($data['image']->user_id)->row()->username;
			$data['vote'] = $this->model_images->hasVoted($data['image']->image_id);
			$data['comments'] = $this->model_images->getComments($data['image']->image_id);
			
			/*Form*/
			$this->form_validation->set_rules('comment', 'Comment', 'required|min_length[5]|max_length[299]|htmlspecialchars');
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('content_image', $data);
			}
			else{
				$data['success_title'] = "Your comment was posted";
				$data['redirect'] = "../image/".$data['image']->image_id;
				$this->load->view('content_success',$data);
				$this->model_images->addComment($data['image']->image_id, $this->input->post('comment', true));
			}
		}
		$this->load->view('footer');
		
	}
	
}
?>