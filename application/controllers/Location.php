<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->database(); // load database
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->helper("txt_input_helper");
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('encryption');

		$this->load->model('mod_pub');
	}

	public function region($reg_code = '')
	{

		$prov = $this->mod_pub->get_province($reg_code);

		$provinces = array();
		foreach ($prov as $prov) {
			$provinces[] = array(
				'key' 	=> $prov->psgc_pcode,
				'value' => $prov->province
			);
		}
		echo json_encode($provinces);
		die();
	}

	public function province($prov_code = '')
	{

		$mun = $this->mod_pub->get_muncity($prov_code);

		$muncity = array();
		foreach ($mun as $mun) {
			$muncity[] = array(
				'key' 	=> $mun->psgc_mcode,
				'value' => $mun->muncity
			);
		}
		echo json_encode($muncity);
		die();
	}


	public function get_muncity($city_code = '')
	{

		$brgy = $this->mod_pub->get_brgy($city_code);

		$my_brgy = array();
		foreach ($brgy as $brgy) {
			$my_brgy[] = array(
				'key' 	=> $brgy->psgc_bcode,
				'value' => $brgy->brgy
			);
		}
		echo json_encode($my_brgy);
		die();
	}

	public function get_main_crop($main_crop = '')
	{

		$my_crop = $this->mod_pub->get_main_crop($main_crop);

		$crop = array();
		foreach ($my_crop as $my_crop) {
			$crop[] = array(
				'key' 	=> $my_crop->name,
				'value' => $my_crop->name
			);
		}
		echo json_encode($crop);
		return true;
	}

	

}//end class
