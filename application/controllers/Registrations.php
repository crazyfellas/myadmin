<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrations extends CI_Controller {

	function __construct() {
		parent::__construct();
		// $this->load->database(); // load database
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('mod_registrations');
		$this->load->model('mod_pub');
        $this->load->model('mod_crops');
		$this->load->library('trackings');
		$this->load->library('form_validation');
		$this->load->library('encryption');
		$this->load->helper("tracker_helper");
		$this->load->helper('form');
		$this->load->helper("txt_input_helper");
	}

	public function index($page = 'index'){



		 $data['page_title'] = $page;
		$this->load->view('templates/header', $data);
		$this->load->view($page);
		$this->load->view('templates/footer');
	}

	/**
	 * register function.
	 *
	 * @access public
	 * @return void
	 */
	public function register() {

	// create the data object
		$data = new stdClass();

		// set validation rules
		//$this->form_validation->set_rules('user_code', 'user_code', 'trim|required|alpha_numeric|min_length[8]|is_unique[members.user_code]', array('is_unique' => 'This user_code already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[members.email]');
		// $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		// $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

		if ($this->form_validation->run() === false) {

			// validation not ok, send validation errors to the view
			$this->load->view('templates/header', $data);
			$this->load->view('client-register', $data);
			$this->load->view('templates/footer');

		} else {

			$code=$this->mod_registrations->getUserCode(); // FETCH Last USER CODE NUMBER
			$user_code = $code['user_code'] + 1;

			// set variables from the form
			$password = "tiklis@2017";
			$data = array(
				'password' 			=> $this->mod_registrations->hash_password($password),
				'ownership_type' 	=> encr($this->input->post('ownership_type')),
				'subscription_type' => encr($this->input->post('subscription_type')),
				'email'    			=> $this->input->post('email'),
				'mobile_number'    	=> encr($this->input->post('mobile_num')),
				'is_active' 		=> 'FALSE',
				'first_name' 		=> encr($this->input->post('first_name')),
				'middle_name' 		=> encr($this->input->post('middle_name')),
				'last_name' 		=> encr($this->input->post('last_name')),
				'birthdate'    		=> $this->input->post('birth_date'),
				'birthplace'    	=> encr($this->input->post('birth_place')),
				'mother_maiden_name'=> encr($this->input->post('mm_name')),
				'id_card'    		=> encr($this->input->post('card_used')),
				'id_card_number'    => encr($this->input->post('card_id_num')),
				'sex'    			=> encr($this->input->post('sex')),
				'civil_status'    	=> encr($this->input->post('civil_status')),
				'complete_address' 	=> encr($this->input->post('address')),
				'member_grp' 		=> 1,
				'org_chapter' 		=> $this->input->post('org_chapter'),
				'org_section' 		=> $this->input->post('org_section'),
				'encoded_by' 		=> encr($_SESSION['email']),
				'account_status' 	=> 'Active',
				'region_code' 		=> encr($this->input->post('region')),
				'province_code' 	=> encr($this->input->post('province')),
				'muncity_code' 		=> encr($this->input->post('muncity')),
				'brgy_code' 		=> encr($this->input->post('brgy')),
				'region' 			=> encr($this->mod_registrations->get_region_name($this->input->post('region'))),
				'province' 			=> encr($this->mod_registrations->get_province_name($this->input->post('province'))),
				'muncity' 			=> encr($this->mod_registrations->get_muncity_name($this->input->post('muncity'))),
				'brgy' 				=> encr($this->mod_registrations->get_brgy_name($this->input->post('brgy'))),
				'date_created' 		=> date("Y-m-d"),
				'user_code' => $user_code
			);

			if ($this->mod_registrations->create_user($data)) {

				// user creation ok
				$this->load->view('templates/header', $data);
				$this->load->view('registration_success', $data);
				$this->load->view('templates/footer');

			} else {

				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';

				// send error to the view
				$this->load->view('templates/header', $data);
				$this->load->view('user/register/register', $data);
				$this->load->view('templates/footer');

			}

		}

	}


	public function update_member() {

		// create the data object
		$data = new stdClass();

		// set validation rules
		// $this->form_validation->set_rules('user_code', 'user_code', 'trim|required|alpha_numeric|min_length[8]|is_unique[members.user_code]', array('is_unique' => 'This user_code already exists. Please choose another one.'));
		// $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[members.email]');
		// $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		// $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

			// set variables from the form
		$user_code = $_GET['user_code'];
			$data = array(
				'ownership_type' 	=> encr($this->input->post('ownership_type')),
				'subscription_type' => encr($this->input->post('subscription_type')),
				'email'    			=> encr($this->input->post('email')),
				'mobile_number'    	=> encr($this->input->post('mobile_num')),
				'first_name' 		=> encr($this->input->post('first_name')),
				'middle_name' 		=> encr($this->input->post('middle_name')),
				'last_name' 		=> encr($this->input->post('last_name')),
				'birthdate'    		=> $this->input->post('birth_date'),
				'birthplace'    	=> encr($this->input->post('birth_place')),
				'mother_maiden_name'=> encr($this->input->post('mm_name')),
				'id_card'    		=> encr($this->input->post('card_used')),
				'id_card_number'    => encr($this->input->post('card_id_num')),
				'sex'    			=> encr($this->input->post('sex')),
				'civil_status'    	=> encr($this->input->post('civil_status')),
				'complete_address' 	=> encr($this->input->post('address')),
				'member_grp' 		=> 1,
				'org_chapter' 		=> $this->input->post('org_chapter'),
				'account_status' 	=> 'Active',
				'region_code' 		=> encr($this->input->post('region')),
				'province_code' 	=> encr($this->input->post('province')),
				'muncity_code' 		=> encr($this->input->post('muncity')),
				'brgy_code' 		=> encr($this->input->post('brgy')),
				'region' 			=> encr($this->mod_registrations->get_region_name($this->input->post('region'))),
				'province' 			=> encr($this->mod_registrations->get_province_name($this->input->post('province'))),
				'muncity' 			=> encr($this->mod_registrations->get_muncity_name($this->input->post('muncity'))),
				'brgy' 				=> encr($this->mod_registrations->get_brgy_name($this->input->post('brgy'))),
				'last_updated' 		=> date("Y-m-d")
			);

			if ($this->mod_registrations->update_member($user_code,$data)) {

				// user creation ok
				$this->load->view('templates/header', $data);
				$this->load->view('index', $data);
				$this->load->view('templates/footer');

			} else {

				// user creation failed, this should never happen
				$data->error = 'There was a problem updating your account. Please try again.';

				// send error to the view
				$this->load->view('templates/header', $data);
				$this->load->view('index', $data);
				$this->load->view('templates/footer');

			}
	}


	public function org_register() {

		// create the data object
		$data = new stdClass();

		// set validation rules
		$this->form_validation->set_rules('user_code', 'user_code', 'trim|required|alpha_numeric|min_length[8]|is_unique[members.user_code]', array('is_unique' => 'This user_code already exists. Please choose another one.'));
		$this->form_validation->set_rules('org_email', 'org_email', 'trim|required|valid_email|is_unique[members.email]');
		// $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

		if ($this->form_validation->run() === false) {

			// validation not ok, send validation errors to the view
			$this->load->view('templates/header', $data);
			$this->load->view('org-register', $data);
			$this->load->view('templates/footer');

		} else {

			// set variables from the form
			//will go to members table
			$password = 'tiklis@2017';
			$data = array(
				'user_code' 		=> $this->input->post('user_code'),
				'ownership_type' 	=> encr($this->input->post('ownership_type')),
				'subscription_type' => encr($this->input->post('subscription_type')),
				'email'    			=> $this->input->post('org_email'),
				'mobile_number'    	=> encr($this->input->post('mobile_num')),
				'password' 			=> $this->mod_registrations->hash_password($password),
				'is_active' 		=> 'TRUE',
				'birthdate'    		=> $this->input->post('birth_date'),  //date established
				'org_chapter' 	=> $this->input->post('user_code'),
				'date_approved' 	=> $this->input->post('date_approved'),
				'account_status' 	=> encr('Active'),
				'region_code' 		=> encr($this->input->post('region')),
				'province_code' 	=> encr($this->input->post('province')),
				'muncity_code' 		=> encr($this->input->post('muncity')),
				'brgy_code'	 		=> encr($this->input->post('brgy')),
				'company_name' 		=> encr($this->input->post('org_official_name')),
				'region' 			=> encr($this->mod_registrations->get_region_name($this->input->post('region'))),
				'province' 			=> encr($this->mod_registrations->get_province_name($this->input->post('province'))),
				'muncity' 			=> encr($this->mod_registrations->get_muncity_name($this->input->post('muncity'))),
				'brgy' 				=> encr($this->mod_registrations->get_brgy_name($this->input->post('brgy'))),
				'member_grp' 		=> 2,
				'encoded_by' 		=> encr($_SESSION['email']),
				'date_created' 		=> date("Y-m-d")
			);

			//will go to organizations tables
			$org_data = array(
				'org_code' 			=> $this->input->post('user_code'),
				'org_entity' 		=> $this->input->post('org_entity'),
				'org_name' 			=> encr($this->input->post('org_official_name')),
				'date_established'  => $this->input->post('birth_date'), //date established
				'region_code' 		=> encr($this->input->post('region')),
				'province_code' 	=> encr($this->input->post('province')),
				'muncity_code' 		=> encr($this->input->post('muncity')),
				'brgy_code' 		=> encr($this->input->post('brgy')),
				'office_number' 	=> encr($this->input->post('office_number')),
				'org_email' 		=> $this->input->post('org_email'),
				'is_active' 		=> 'TRUE',
				'encoded_by' 		=> encr($_SESSION['email']),
				'last_updated' 		=> date("Y-m-d"),
				'date_approved' 	=> $this->input->post('date_approved'),
				'region' 			=> encr($this->mod_registrations->get_region_name($this->input->post('region'))),
				'province' 			=> encr($this->mod_registrations->get_province_name($this->input->post('province'))),
				'muncity' 			=> encr($this->mod_registrations->get_muncity_name($this->input->post('muncity'))),
				'brgy' 				=> encr($this->mod_registrations->get_brgy_name($this->input->post('brgy'))),
				'org_ownership_type'=> encr($this->input->post('ownership_type')),
				'org_subscription_type'=> encr($this->input->post('subscription_type')),
				'date_created' 		=> date("Y-m-d")
			);
			if ($this->mod_registrations->create_user($data) && $this->mod_registrations->create_organization($org_data)) {

				// user creation ok
				$this->load->view('templates/header', $data);
				$this->load->view('registration_success', $data);
				$this->load->view('templates/footer');

			} else {

				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';

				// send error to the view
				$this->load->view('templates/header', $data);
				$this->load->view('index', $data);
				$this->load->view('templates/footer');

			}

		}

	}


	public function update_org_profile() {

		// create the data object
		$org_data = new stdClass();
		$org_code = $_POST['org_code'];

			$org_data = array(
				'org_entity' 			=> $this->input->post('org_entity'),
				'org_name' 				=> encr($this->input->post('org_official_name')),
				'date_established'    	=> $this->input->post('birth_date'), //date established
				'region_code' 			=> encr($this->input->post('region')),
				'province_code' 		=> encr($this->input->post('province')),
				'muncity_code' 			=> encr($this->input->post('muncity')),
				'brgy_code' 			=> encr($this->input->post('brgy')),
				'office_number' 		=> encr($this->input->post('office_number')),
				'org_email' 			=> encr($this->input->post('org_email')),
				'is_active' 			=> 'TRUE',
				'last_updated' 			=> date("Y-m-d"),
				'date_approved' 		=> $this->input->post('date_approved'),
				'region' 				=> encr($this->mod_registrations->get_region_name($this->input->post('region'))),
				'province' 				=> encr($this->mod_registrations->get_province_name($this->input->post('province'))),
				'muncity' 				=> encr($this->mod_registrations->get_muncity_name($this->input->post('muncity'))),
				'brgy' 					=> encr($this->mod_registrations->get_brgy_name($this->input->post('brgy'))),
				'org_ownership_type' 	=> encr($this->input->post('ownership_type')),
				'org_subscription_type' => encr($this->input->post('subscription_type')),
				'date_created' 			=> date("Y-m-d")
			);
			if ($this->mod_registrations->update_org_profile($org_code,$org_data)) {

				// org update ok
				$this->load->view('templates/header', $org_data);
				$this->load->view('index', $org_data);
				$this->load->view('templates/footer');

			} else {

				// user creation failed, this should never happen
				$org_data->error = 'There was a problem creating your new account. Please try again.';

				// send error to the view
				$this->load->view('templates/header', $org_data);
				$this->load->view('index', $org_data);
				$this->load->view('templates/footer');
			}
	}

	public function sys_user_org_reg() {

		// create the data object
		$data = new stdClass();

		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		// $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

		if ($this->form_validation->run() === false) {

			// validation not ok, send validation errors to the view
			$this->load->view('templates/header', $data);
			$this->load->view('create-user', $data);
			$this->load->view('templates/footer');

		} else {

			// set variables from the form
			$password = $this->input->post('password');
			$data = array(
				'user_pw' 			=> $this->mod_registrations->hash_password($password),
				'is_active' 		=> 'TRUE',
				'full_name' 		=> encr($this->input->post('full_name')),
				'email'    			=> $this->input->post('email'),
				'contact_number'    => encr($this->input->post('contact_number')),
				'birth_date'    	=> $this->input->post('birth_date'),
				'system_access_lvl' => encr($this->input->post('system_access_lvl')),
				'org_chapter' 	=> $this->input->post('org_chapter'),
				'region_code' 		=> encr($this->input->post('region')),
				'province_code' 	=> encr($this->input->post('province')),
				'muncity_code' 		=> encr($this->input->post('muncity')),
				'region' 			=> encr($this->mod_registrations->get_region_name($this->input->post('region'))),
				'province' 			=> encr($this->mod_registrations->get_province_name($this->input->post('province'))),
				'muncity' 			=> encr($this->mod_registrations->get_muncity_name($this->input->post('muncity'))),
				'date_created' 		=> date("Y-m-d")
			);

			if ($this->mod_registrations->create_system_user($data)) {

				// user creation ok
				$this->load->view('templates/header', $data);
				$this->load->view('registration_success', $data);
				$this->load->view('templates/footer');

			} else {

				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';

				// send error to the view
				$this->load->view('templates/header', $data);
				$this->load->view('create-user-enumerator', $data);
				$this->load->view('templates/footer');

			}

		}

	}

	public function sys_user_reg() {

		// create the data object
		$data = new stdClass();

		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		// $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

		if ($this->form_validation->run() === false) {

			// validation not ok, send validation errors to the view
			$this->load->view('templates/header', $data);
			$this->load->view('create-user', $data);
			$this->load->view('templates/footer');

		} else {

			// set variables from the form
			$password = $this->input->post('password');
			$data = array(
				'user_pw' 			=> $this->mod_registrations->hash_password($password),
				'system_access_lvl' => encr($this->input->post('system_access_lvl')),
				'is_active' 		=> 'TRUE',
				'full_name' 		=> encr($this->input->post('full_name')),
				'email'    			=> $this->input->post('email'),
				'birth_date'    	=> $this->input->post('birth_date'),
				'org_chapter' 	=> $this->input->post('org_chapter'),
				'date_created' 		=> date("Y-m-d")
			);

			if ($this->mod_registrations->create_system_user($data)) {

				// user creation ok
				$this->load->view('templates/header', $data);
				$this->load->view('registration_success', $data);
				$this->load->view('templates/footer');

			} else {

				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';

				// send error to the view
				$this->load->view('templates/header', $data);
				$this->load->view('create-user', $data);
				$this->load->view('templates/footer');

			}

		}

	}

	public function generate_user_code(){

		// create the data object
		$data = new stdClass();

		$member_id = $_GET['member_id'];
			$data = array(
				'user_code' 		=> $this->input->post('user_code'),
				'date_approved'    	=> $this->input->post('member_id'),
				'is_active' 		=> 'TRUE',
				'last_updated' 		=> date("Y-m-d")
			);

			if ($this->mod_registrations->generate_user_code($member_id,$data)) {

				// user creation ok
				$this->load->view('templates/header', $data);
				$this->load->view('index', $data);
				$this->load->view('templates/footer');

			} else {

				// user creation failed, this should never happen
				$data->error = 'There was a problem updating your account. Please try again.';

				// send error to the view
				$this->load->view('templates/header', $data);
				$this->load->view('index', $data);
				$this->load->view('templates/footer');

			}

	}


////// CHECK DUPLICATES
function checkFarmer(){
	$email = $this->input->post('email');
	$query = $this->mod_registrations->getEmail($email);
			 $status ="true";
			 if($query){
			$status = "false";
		}
	echo $status;
 }


//////// CHECK_VERIFICATION

function verify_farmer(){
	$fname = $this->input->post('firstname');
	$lname = $this->input->post('lastname');
	$data = $this->mod_registrations->fetch_members($fname,$lname);
	echo json_encode($data);
	return true;
}


} //end class
