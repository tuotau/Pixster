<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_images extends CI_Model {

	
	public function getRecentImagesThumbnails($amount)
	{
		$query = $this->db->query("SELECT image_id FROM images ORDER BY created LIMIT $amount");
		$images = array();
		foreach($query->result() as $row)
			array_push($images,  base_url()."thumbnails/".$row->image_id);
		return $images;
	}
	
	public function getRecentImages($amount)
	{
		$query = $this->db->query("SELECT image_id FROM images ORDER BY created LIMIT $amount");
		$images = array();
		foreach($query->result() as $row)
			array_push($images,  base_url()."index.php/image/".$row->image_id);
		return $images;
	}
	
	public function getImageInfo($image_id)
	{
		$query = "SELECT image_id, user_id, caption, description, created, vote FROM images WHERE image_id = ?";
		return $this->db->query($query, array($image_id));
	}
	
	public function addImage($file_name, $title, $description, $file_path)
	{
		$user_id  = $this->session->userdata('user_id');
		$query = "INSERT INTO images (user_id, image_id, caption, description, vote, created) VALUES (?,?,?,?,0,localtimestamp)";
		$result = $this->db->query($query, array($user_id, $file_name, $title, $description));
		
		if(is_file($file_path))
		{
			chmod($file_path, 0664);
		}
		
		//Making the thumbnail
		
		$config['image_library'] = 'gd2';
		$config['source_image']	= $file_path;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	= 150;
		$config['height']	= 100;
		$config['thumb_marker']	= '';
		$config['new_image']	= "/home/stud/sis/tt96430/public_html/PHP/Pixster/thumbnails/$file_name";

		$this->load->library('image_lib', $config); 

		$this->image_lib->resize();
		
	}
	public function deleteImage($id)
	{
		unlink("/home/stud/sis/tt96430/public_html/PHP/Pixster/thumbnails/".$id);
		unlink("/home/stud/sis/tt96430/public_html/PHP/Pixster/images/".$id);
		
		$query = "DELETE FROM comments WHERE image_id = ?";
		$this->db->query($query, array($id));
		
		$query = "DELETE FROM votes WHERE image_id = ?";
		$this->db->query($query, array($id));
		
		$query = "DELETE FROM images WHERE image_id = ?";
		$this->db->query($query, array($id));
	}
	
	
	/* Votes */
	
	public function vote($image_id, $vote)
	{
		$user_id = $this->session->userdata('user_id');
		$change = 1;
		if(!$user_id)
			return "User_id was incorrect, please log in (again)!";
		
		$query = "SELECT vote FROM votes WHERE image_id = ? AND user_id = ?";
		$result = $this->db->query($query, array($image_id, $user_id));
		if ($result->num_rows() != 0){
			if($result->row()->vote == $vote)
				return "You have already cast this vote for this image!";
			else{
				$query = "DELETE FROM votes WHERE image_id = ? AND user_id = ?";
				$this->db->query($query, array($image_id, $user_id));
				$change = 2;
			}
		}
		if($vote == -1 || $vote == 1){
			$query = "SELECT vote FROM images WHERE image_id = ?";
			$result = $this->db->query($query, array($image_id));
			if ($result->num_rows() == 0)
				return "Image was not found, it might have been deleted!";
			$result = $result->row()->vote;
			$query = "UPDATE images SET vote = ? WHERE image_id = ?";
			$this->db->query($query, array($result + ($vote * $change), $image_id));
			
			$query = "INSERT INTO votes (image_id, user_id, vote) VALUES (?,?,?)";
			$this->db->query($query, array($image_id, $user_id, $vote));
			return "true";
		}
		
		return "You tried to vote for more than one point you little hacker!!";
	}
	
	public function hasVoted($image_id){
		$user_id = $this->session->userdata('user_id');
		if(!$user_id)
			return 0;
		$query = "SELECT vote FROM votes WHERE image_id = ? AND user_id = ?";
		$result = $this->db->query($query, array($image_id, $user_id));
		if ($result->num_rows() == 0)
			return 0;
		else
			return $result->row()->vote;
	}
	
	/* Comments */
	
	public function getComments($image_id){
		$query = "SELECT c.comment_id, c.comment, u.username, c.created FROM comments AS c, users AS u WHERE c.image_id = ? AND c.user_id = u.user_id ORDER BY created DESC";
		return $this->db->query($query, array($image_id));
	}
	
	public function getCommentInfo($comment_id){
		$query = "SELECT comment_id, image_id, user_id, comment, created FROM comments WHERE comment_id=?";
		return $this->db->query($query, array($comment_id));
		
	}
	
	public function addComment($image_id, $comment){
		$result = ($this->db->query("SELECT comment_id FROM comments ORDER BY comment_id DESC LIMIT 1"));
		$comment_id= 0;
		if($result->num_rows() != 0){
			$row = $result->row();
			$comment_id = $row->comment_id +1;
		}
		$user_id = $this->session->userdata('user_id');
		$query = "INSERT INTO comments (comment_id, image_id, user_id, comment, created) VALUES (?,?,?,?, localtimestamp)";
		$this->db->query($query, array($comment_id, $image_id, $user_id, $comment));
	}
	
	public function deleteComment($id){
		$query = "DELETE FROM comments WHERE comment_id = ?";
		$this->db->query($query, array($id));
		
	}
}
