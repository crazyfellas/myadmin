<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// This is a controller for farmer groups
class Mod_admin extends CI_Model {

	function __construct() {
		parent::__construct();
    	
	}

	function register_sys_user($data){
		$this->db->insert('users', $data);
	}

	public function get_user_id_from_email($email) {
		$this->db->select('user_id');
		$this->db->from('users');
		$this->db->where('email', $email);

		return $this->db->get()->row('user_id');
	}

	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('user_id', $user_id);
		return $this->db->get()->row();
		
	}

	public function resolve_user_login($email, $password) {
		$this->db->select('user_pw');
		$this->db->from('users');
		$this->db->where('email', $email);
		$hash_user_pw = $this->db->get()->row('user_pw');
		
		return $this->verify_password_hash($password, $hash_user_pw);
	}

	function hash_password($password) {
		return password_hash($password, PASSWORD_BCRYPT);
	}
	
	private function verify_password_hash($password, $hash) {
		return password_verify($password, $hash);	
	}


}
