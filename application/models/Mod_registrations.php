<?php

	class Mod_registrations extends CI_Model
	{

	public function create_user($data) {
		return $this->db->insert('members', $data);
	}

	public function update_member($user_code,$data) {
    $this->db->where('user_code',$user_code);
      return $this->db->update('members', $data);
	}

	public function generate_user_code($member_id,$data) {
    $this->db->where('member_id',$member_id);
      return $this->db->update('members', $data);
	}

	public function create_organization($org_data) {
		return $this->db->insert('organizations', $org_data);
	}

	public function update_org_profile($org_code,$org_data) {
    $this->db->where('org_code',$org_code);
      return $this->db->update('organizations', $org_data);
	}

	public function create_system_user($data) {
		return $this->db->insert('users', $data);

	}
	public function resolve_user_login($user_code, $password) {

		$this->db->select('password');
		$this->db->from('members');
		$this->db->where('user_code', $user_code);
		$hash = $this->db->get()->row('password');

		return $this->verify_password_hash($password, $hash);

	}

	public function get_region_name($region_code){
		$this->db->select('region');
		$this->db->from('lib_loc_regions');
		$this->db->where('psgc_rcode', $region_code);
		return $this->db->get()->row('region');
	}

	public function get_province_name($province_code){

		$this->db->select('province');
		$this->db->from('lib_loc_provinces');
		$this->db->where('psgc_pcode', $province_code);
		return $this->db->get()->row('province');
	}

	public function get_muncity_name($muncity_code){

		$this->db->select('muncity');
		$this->db->from('lib_loc_muncity');
		$this->db->where('psgc_mcode', $muncity_code);
		return $this->db->get()->row('muncity');
	}

	public function get_brgy_name($brgy_code){

		$this->db->select('brgy');
		$this->db->from('lib_loc_brgy');
		$this->db->where('psgc_bcode', $brgy_code);
		return $this->db->get()->row('brgy');
	}

	public function get_org_name($org_code){
		$this->db->select('org_name');
		$this->db->from('organizations');
		$this->db->where('org_code', $org_code);
		return $this->db->get()->row('org_name');
	}

	public function get_subscription_name($id){
		$this->db->select('subscription_name');
		$this->db->from('lib_subscription_types');
		$this->db->where('subscription_id', $id);
		return $this->db->get()->row('subscription_name');
	}

	public function get_ownership_name($id){
		$this->db->select('ownership_name');
		$this->db->from('lib_ownership_types');
		$this->db->where('ownership_id', $id);
		return $this->db->get()->row('ownership_name');
	}


	public function get_user_id_from_user_code($user_code) {

		$this->db->select('member_id');
		$this->db->from('members');
		$this->db->where('user_code', $user_code);
		return $this->db->get()->row('member_id');

	}

	/**
	 * get_user function.
	 *
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {

		$this->db->from('members');
		$this->db->where('member_id', $user_id);
		return $this->db->get()->row();

	}

	public function change_user_pw($email, $password){
		$this->db->set('user_pw', $password);
		$this->db->where('email', $email);
		$this->db->update('users');
	}

	function getEmail($email){
	 $this->db->like('email', strtolower($email));
	 $query = $this->db->get('members');
	 return $query->result();
	}

	function getUserCode(){
		$this->db->select_max('user_code')->from('members');
		$query = $this->db->get();
		  return $query->row_array();
	}

	function fetch_members($fname,$lname){
		$this->db->select("*")->from('members');
		$this->db->like('first_name', $fname);
		$this->db->like('last_name', $lname);
		$query = $this->db->get();
 		return $query->result();
	}


	/**
	 * hash_password function.
	 *
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	public function hash_password($password) {

		return password_hash($password, PASSWORD_BCRYPT);

	}

	/**
	 * verify_password_hash function.
	 *
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {

		return password_verify($password, $hash);

	}

	}
?>
