<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model {

	
	public function isLoggedIn()
	{
		return ($this->session->userdata('user_id') == false ? false : true);
	}
	
	public function userId(){
		return $this->session->userdata('user_id');
	}
	
	public function login($username, $password){
		$query = "SELECT user_id, username, password, email, role FROM users WHERE username = ?";
		$result = $this->db->query($query, array($username));
		if ($result->num_rows() == 1)
		{
			$row = $result->row();
			if(password_verify($password, $row->password) || $password == $row->password){
				$user = array(
					   'user_id'  => $row->user_id,
					   'username' => $row->username,
					   'email' => $row->email,
					   'role' => $row->role
				);
				$this->session->set_userdata($user);
				return true;
			}
		}
		
		return false;
	}
	
	public function uniqueUsername($username){
		$query = "SELECT username FROM users WHERE username = ?";
		$result = $this->db->query($query, array($username));
		if ($result->num_rows() == 0)
			return true;
		
		return false;
	}
	
	public function createUser($username, $password, $email){
		$password = password_hash($password, PASSWORD_BCRYPT);
		$query = ($this->db->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1"));
		$row = $query->row();
		$user_id = $row->user_id +1;
		$query = "INSERT INTO users (user_id, username, password, email, role) VALUES (?,?,?,?,1)";
		$result = $this->db->query($query, array($user_id, $username, $password, $email));
		$this->login($username, $password);
	}
	
	public function updateUser($username, $password, $email){
		if($username != false){
			$query = "UPDATE users SET username = ? WHERE user_id = ?";
			$this->db->query($query, array($username, $this->session->userdata('user_id')));
			$this->session->set_userdata('username', $username);
		}
		if($password != false){
			$password = password_hash($password, PASSWORD_BCRYPT);
			$query = "UPDATE users SET password = ? WHERE user_id = ?";
			$this->db->query($query, array($password, $this->session->userdata('user_id')));
		}
		if($email != false){
			$query = "UPDATE users SET email = ? WHERE user_id = ?";
			$this->db->query($query, array($email, $this->session->userdata('user_id')));
			$this->session->set_userdata('email', $email);
		}
	}
	
	public function deleteUser($id){
		if($this->model_user->userId() == 1){
			$this->load->model('model_images');
			$query = "SELECT image_id FROM images WHERE user_id = ?";
			$images = $this->db->query($query, array($id));
			foreach($images->result() as $row){
				$this->model_images->deleteImage($row->image_id);
			}
			
			$query = "DELETE FROM comments WHERE user_id = ?";
			$this->db->query($query, array($id));
			
			$query = "DELETE FROM users WHERE user_id = ?";
			$this->db->query($query, array($id));
		}
		
	}
	
	public function getUsername($user_id){
		$user_id = intval($user_id);
		$query = "SELECT username FROM users WHERE user_id = ?";
		return $this->db->query($query, array($user_id));
	}	
	
	public function getRole($user_id){
		$user_id = intval($user_id);
		$query = "SELECT role FROM users WHERE user_id = ?";
		return $this->db->query($query, array($user_id))->row()->role;
	}

	
	public function listUsers(){
		$query = "SELECT user_id, username FROM users ORDER BY user_id";
		return $this->db->query($query);
	}
}
