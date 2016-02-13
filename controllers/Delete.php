<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends CI_Controller {
	
	
	public function index($method, $args){
		$type = $method;
		$id = $args;
		$this->load->model('model_images');
		$this->load->model('model_user');
		
		$data['login'] = $this->model_user->isLoggedIn();
		$this->load->view('header');
		$this->load->view('nav', $data);
		$user_id = $this->model_user->userId();
		
		
		if($type == 0 ){
			$image = $this->model_images->getImageInfo($id);
			if($image->num_rows() == 0){
				$data['success_title'] = "The image id provided was incorrect!";
				$data['redirect'] = "../../../main";
				$this->load->view('content_success',$data);
			}
			else{
				$image = $image->row();
				if($user_id == 1 || $image->user_id == $user_id){
					$this->model_images->deleteImage($id);
					$data['success_title'] = "Image deleted!";
					$data['redirect'] = "../../../main";
					$this->load->view('content_success',$data);
					
				}
				else{
					$data['success_title'] = "You don't have rights to delete this image!";
					$data['redirect'] = "../../../image/".$id;
					$this->load->view('content_success',$data);
					
				}
			}
		}
		else if($type == 1){
			$comment = $this->model_images->getCommentInfo($id);
			if($comment->num_rows() == 0){
				$data['success_title'] = "The comment id provided was incorrect!";
				$data['redirect'] = "../../../main";
				$this->load->view('content_success',$data);
			}
			else{
				$comment = $comment->row();
				$image = $this->model_images->getImageInfo($comment->image_id)->row();
				if($user_id == 1 || $image->user_id == $user_id){
					$this->model_images->deleteComment($id);
					$data['success_title'] = "Comment deleted!";
					$data['redirect'] = "../../../main";
					$this->load->view('content_success',$data);
					
				}
				else{
					$data['success_title'] = "You don't have rights to delete this comment!";
					$data['redirect'] = "../../../main";
					$this->load->view('content_success',$data);
					
				}
			}	
		}
		else{
				$data['success_title'] = "Unknown error occurred!";
				$data['redirect'] = "../../../main";
				$this->load->view('content_success',$data);
		}
		$this->load->view('footer');
		
	}
	
	
}
?>