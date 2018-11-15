<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// This is a controller for farmer groups
class Mod_pub extends CI_Model {

  function __construct() {
    parent::__construct();
  }
  function get_province($reg_code){

$query = $this->db->query("select * from lib_loc_provinces where psgc_rcode='" .$reg_code."'");
return $query->result();

    // $stmt = "SELECT * FROM lib_loc_provinces WHERE psgc_rcode=?";
    // $q = $this->db->query($stmt, $reg_code);
    // return $q->result();
  }

  function get_muncity($prov_code){

    $query = $this->db->query("select * from lib_loc_muncity where psgc_pcode='" .$prov_code."'");
return $query->result();

    // $stmt = "SELECT * FROM lib_cities WHERE prov_code=?";
    // $q = $this->db->query($stmt, $prov_code);
    // return $q->result();
  }

  function get_brgy($city_code){
      $query = $this->db->query("select * from lib_loc_brgy where psgc_mcode='" .$city_code."' order by brgy asc");
      return $query->result();

    //$stmt = "SELECT * FROM lib_brgy WHERE city_code=? order by brgy_name";
    //$q = $this->db->query($stmt, $city_code);
    //return $q->result();
  }	

  function get_main_crop($crop_type){
        $query = $this->db->query("select * from lib_crops where type ='" .$crop_type."'");
        return $query->result();

    //$stmt = "SELECT * FROM lib_brgy WHERE city_code=? order by brgy_name";
    //$q = $this->db->query($stmt, $city_code);
    //return $q->result();
  }

}
