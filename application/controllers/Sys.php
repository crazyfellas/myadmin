<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sys extends CI_Controller {


	function __construct() {
		parent::__construct();
		$this->load->database(); // load database
		$this->load->helper(array('url'));
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('encryption');
		$this->load->library('trackings');
		$this->load->helper("txt_input_helper");
		$this->load->helper("tracker_helper");
		$this->load->model('mod_admin');
		$this->load->model('mod_registrations');
		$this->load->model('mod_pub');
		$this->load->model('mod_crops');

	}

	//default landing page
	public function home($page = 'home')
	{
		$this->load->view($page);
	}

	public function index($page = 'index')
	{



		$data['page_title'] = $page;
		$this->load->view('templates/header', $data);
		$this->load->view($page);
		$this->load->view('templates/footer');
	}


	public function login() {

		// create the data object
		$data = new stdClass();

		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('email_code', 'Please Enter a valid email_code', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == false) {

			// validation not ok, send validation errors to the view
			$this->load->view('home');



		} else {

			// set variables from the form
			$email = $this->input->post('email_code');
			$password = $this->input->post('password');

			if ($this->mod_admin->resolve_user_login($email, $password)) {

				$user_id 	= $this->mod_admin->get_user_id_from_email($email);
				$user      	= $this->mod_admin->get_user($user_id);

				// set session user datas
				$_SESSION['user_id']      		= (int)$user->user_id;
				$_SESSION['email']        		= (string)$user->email;
				$_SESSION['full_name']   		= (string)decr($user->full_name);
				$_SESSION['region']     		= (string)decr($user->region);
				$_SESSION['province']     		= (string)decr($user->province);
				$_SESSION['muncity']     		= (string)decr($user->muncity);
				$_SESSION['region_code']   		= (string)decr($user->region_code);
				$_SESSION['province_code']   	= (string)decr($user->province_code);
				$_SESSION['muncity_code']   	= (string)decr($user->muncity_code);
				$_SESSION['brgy_code']   		= (string)decr($user->brgy_code);
				$_SESSION['org_chapter']   		= (string)$user->org_chapter;
				$_SESSION['system_access_lvl']	= (string)decr($user->system_access_lvl);
				$_SESSION['logged_in']    	  	= (bool)true;
				// $_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				// $_SESSION['is_admin']     = (bool)$user->is_admin;

				// user login ok
				$this->session->set_userdata(array('user_id' => $user_id));
				redirect('index');

			} else {

				// login failed
			//	$data->error = 'Wrong member code or Password.';

				// send error to the view
			//	$this->load->view('home', $data);

			echo $this->session->set_flashdata('msg','<div class="alert alert-danger">Invalid Username or Password</div>');
			$this->load->view('home');
			}

		}
	}


	public function change_user_pw(){
		// create the data object
		$data = new stdClass();

		// set validation rules
		$this->form_validation->set_rules('new_password', 'New Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

		if ($this->form_validation->run() == false) {
			//if pws did not match
			$this->load->view('templates/header', $data);
			$this->load->view('user-setting', $data);
			$this->load->view('templates/footer');
		}else{
			//if pw matched
			$password = $this->input->post('confirm_password');
			$new_pw = $this->mod_registrations->hash_password($password);
			$email = $_SESSION['email'];

				// check if the pw is successful
				if ($this->mod_registrations->change_user_pw($email,$new_pw)) {

					// farmer password changed ok
					$this->load->view('templates/header', $data);
					$this->load->view('user-setting', $data);
					$this->load->view('templates/footer');

				} else {
					// farmer password changed failed, this should never happen
					$data->error = 'There was a problem updating your password';

					// send error to the view
					$this->load->view('templates/header', $data);
					$this->load->view('user-setting', $data);
					$this->load->view('templates/footer');
					echo "<script>alert(\"Congratulations! Your Password has been changed.\");</script>";
				}

		}//close else
	}

	public function logout() {

		// create the data object
		$data = new stdClass();

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}

			// user logout ok
			$this->session->unset_userdata('email');
			redirect('/');

		} else {

			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('/');

		}

	}

} //close class
