<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crops extends CI_Controller {

    function __construct() {
        parent::__construct();
        // $this->load->database(); // load database
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('mod_registrations');
        $this->load->model('mod_crops');
        $this->load->model('mod_pub');
        $this->load->library('trackings');
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->helper('form');
        $this->load->helper("txt_input_helper");
    }

    function create_farm(){
        $data = new stdClass();
        $member_code = $_SESSION['user_code'];

        $data = array(
                'member_id'     => $_SESSION['member_id'],
                'farm_name'     => encr($this->input->post('farm_name')),
                'is_active'     => 'TRUE',
                'date_purchased'=> $this->input->post('date_purchased'),
                'region_code'   => encr($this->input->post('region')),
                'province_code' => encr($this->input->post('province')),
                'muncity_code'  => encr($this->input->post('muncity')),
                'brgy_code'     => encr($this->input->post('brgy')),
                'farm_practice' => encr($this->input->post('farm_practice')),
                'farm_genre'    => encr($this->input->post('farm_genre')),
                'farm_class'    => encr($this->input->post('farm_class')),
                'area'          => $this->input->post('planting_area'),
                'road_distance' => $this->input->post('road_distance'),
                'region'        => encr($this->mod_registrations->get_region_name($this->input->post('region'))),
                'province'      => encr($this->mod_registrations->get_province_name($this->input->post('province'))),
                'muncity'       => encr($this->mod_registrations->get_muncity_name($this->input->post('muncity'))),
                'brgy'          => encr($this->mod_registrations->get_brgy_name($this->input->post('brgy'))),
                'address'       => encr($this->input->post('address')),
                'encoded_by'    => encr($_SESSION['email']),
                'date_created'  => date("Y-m-d")
            );

        if ($this->mod_crops->create_farm($data)) {

            // user creation ok
            redirect(base_url() ."mem_profile?code=" . uencode($member_code));

        } else {

            // user creation failed, this should never happen
            $data->error = 'There was a problem creating your new farm. Please try again.';

            // send error to the view
            $this->load->view('templates/header', $data);
            $this->load->view('mem_profile?code=$member_code', $data);
            $this->load->view('templates/footer');

        }

    }


    function create_batch_crop($id){
        // create the data object
        $data = new stdClass();

        //Setting values for table columns
        $date_today = date("Y-m-d");
        $member_code = $_SESSION['user_code'];
      //  $farm_id = $_GET['farm_id'];

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        // $this->form_validation->set_rules('main_crop', 'Please Select Crop Cycle Category', 'required');
        // $this->form_validation->set_rules('crop_variety', 'Please check Crop variety', 'required');
        // $this->form_validation->set_rules('date_planted', 'Date Planted', 'required');
        // $this->form_validation->set_rules('date_harvested_start', 'Please fill Date start of Harvest', 'required');
        // $this->form_validation->set_rules('date_harvested_end', 'Please fill Date end of Harvest', 'required');
        // $this->form_validation->set_rules('yield_estimate', 'Please enter yield estimate', 'required|numeric');
        // $this->form_validation->set_rules('plant_area', 'Please enter plant area', 'required|numeric');

        // if ($this->form_validation->run() === false) {
        //     // validation not ok, send validation errors to the view
        //     redirect(base_url().'mem_profile?farm_id='.$farm_id . '&code='.$member_code, 'refresh');

        // } else {
            $date1 = new DateTime($this->input->post('date_planted'));
            $date2 = new DateTime($this->input->post('date_harvested_start'));

            $mat_index = $date2->diff($date1)->format("%a");
            $data = array(
                'farm_id'           => $id,
                'user_code'         => $member_code,
                'main_crop'         => encr($this->input->post('maincrop')),
                'crop_variety'      => encr($this->input->post('crop_sub')),
                'date_planted'      => $this->input->post('date_planted'),
                'date_planted_end' => $this->input->post('date_planted_end'),
                'yield_estimate'    => $this->input->post('yield_estimate'),
                'crop_cycle_category'=> encr($this->input->post('crop_cycle_cat')),
                'maturity_index'    => $mat_index,
                'crop_status'       => encr('1'),
                'soc_desc'          => encr('1'),
                'planting_area'     => $this->input->post('planting_area'),
                'yield_estimate'    => $this->input->post('yield_estimate'),
                'yield_actual'      => 0,
                'soc_damages_in_kg' => 0,
                'soc_damages_in_cash' => 0,
                'date_encoded'      => $date_today,
                // 'farm_name'  => $_SESSION['farm_name'],
                'region_code'       => encr($_SESSION['region']),
                'province_code'     => encr($_SESSION['province']),
                'muncity_code'      => encr($_SESSION['muncity']),
                'brgy_code'         => encr($_SESSION['brgy']),
                'region'            => encr($this->mod_registrations->get_region_name($_SESSION['region'])),
                'province'          => encr($this->mod_registrations->get_province_name($_SESSION['province'])),
                'muncity'           => encr($this->mod_registrations->get_muncity_name($_SESSION['muncity'])),
                'brgy'              => encr($this->mod_registrations->get_brgy_name($_SESSION['brgy'])),
                'encoded_by'        => encr($_SESSION['email'])
                // 'brgy_code'  => $_SESSION['brgy'],
                // 'farm_practice'  => $_SESSION['farm_practice'],
                // 'elevation'  => $_SESSION['elevation'],
                // 'road_distance'  => $_SESSION['road_distance']
            );

            $result=  $this->mod_crops->create_batch_crop($data);
                // farm creation ok
                //redirect(base_url().'mem_profile?code='.uencode($member_code));
                echo json_encode($result);
            		return true;
        // }
    }


    function update_batch_crop($id){
      $date_today = date("Y-m-d");

      $data = array(
            'date_planted'=> $this->input->post('planted_start'),
            'date_planted_end' => $this->input->post('planted_end'),
            'crop_status'       => encr($this->input->post('crop_status')),
            'soc_desc'          => encr($this->input->post('state_of_calamity')),
            'soc_damages_in_kg' => $this->input->post('damage_kg'),
            'soc_damages_in_cash'=> $this->input->post('damage_cash'),
            'last_updated'      => $date_today
        );
        $result= $this->mod_crops->update_batch_crop($id, $data);
        echo json_encode($result);
        return true;
    }

    function delete_batch_crop($id){
      $data = $this->mod_crops->delete_batch_crop($id);
      $this->load->view('lib_crops');
      // echo json_encode($data);
      // return true;
    }

    //add a crop to the library
    function create_main_crop(){

        $id = $this->input->post('cropid');
        $crop_code = substr($this->input->post('crop_name'), 0,3) . rand(1000,9999);
        $data = array(
          'name' => $this->input->post('crop_name'),
          'code' => $crop_code,
          'desc' => $this->input->post('desc'),
          'type' => $this->input->post('crop_type'),
          'is_active' => $this->input->post('is_active'),
        );

        if(empty($id)){
          $result = $this->mod_crops->create_main_crop($data);
          echo json_encode($result);
          return true;
        }
        else{
          $result = $this->mod_crops->update_main_crop($data,$id);
          echo json_encode($result);
          return true;
        }
    }

    function fetch_main_crop($id){
      $data = $this->mod_crops->fetch_main_crop($id);
      echo json_encode($data);
      return true;
    }


    function delete_main_crop($id){
      $data = $this->mod_crops->delete_main_crop($id);
      echo json_encode($data);
      return true;
    }


    function show_crop_sched(){

           $cc_id =  $_GET['cc_id'];
           $fetch_data = $this->mod_crops->make_datatables($cc_id);
           $data = array();
           foreach($fetch_data as $row)
           {
                $sub_array = array();
                $sub_array[] = "<a class=\"btn btn-warning btn-xs btn-flat btn-rect\" href =\"".base_url()."edit_crop_sched?id=".uencode($row->ccd_id)."\" ><i class=\"fa fa-pencil-square-o\"></i> Edit</a>";
                $sub_array[] = $row->harvest_sched_start;
                $sub_array[] = $row->harvest_sched_end;
                $sub_array[] = $row->yield_estimate;
                $sub_array[] = $row->yield_actual;
                $sub_array[] = $row->crop_remarks;

                $data[] = $sub_array;
           }
           $output = array(
                "draw"                  =>     intval($_POST["draw"]),
                "recordsTotal"          =>      $this->mod_crops->get_all_data($cc_id),
                "recordsFiltered"       =>     $this->mod_crops->get_filtered_data($cc_id),
                "data"                  =>     $data
           );
           echo json_encode($output);

    }

    function create_crop_sched(){
        if($_POST["action"] == "Add"){

            $data = array(
                'cc_id' => $this->input->post('cc_id'),
                'harvest_sched_start' => $this->input->post('harvest_sched_start'),
                'harvest_sched_end' => $this->input->post('harvest_sched_end'),
                'yield_estimate' => $this->input->post('yield_estimate'),
                'yield_actual' => $this->input->post('yield_actual'),
                'crop_remarks' => $this->input->post('remarks'),
                'date_encoded' => date("Y-m-d"),
                'encoded_by' => encr($_SESSION['email']),
            );
            $this->mod_crops->create_crop_detail_sched($data);
            echo 'Crop Schedule added!';

       }
    }

    function count_crop_sched(){
        echo "(28)";

    }


    function edit_crop_sched(){
        // create the data object
        $data = new stdClass();
        $member_id = $_SESSION['member_id'];
        $cc_id = $_SESSION['cc_id'];
        $ccd_id = $_GET['ccd_id'];
        $farm_id = $_SESSION['farm_id'];
        $user_code = $_SESSION['user_code'];
        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

            //Setting values for table columns
            $data = array(
                'harvest_sched_start'   => $this->input->post('harvest_sched_start'),
                'harvest_sched_end'     => $this->input->post('harvest_sched_end'),
                'yield_estimate'        => $this->input->post('yield_estimate'),
                'yield_actual'          => $this->input->post('yield_actual'),
                'crop_remarks'          => $this->input->post('remarks'),
                'date_encoded'          => date("Y-m-d"),
            );
            $this->mod_crops->edit_crop_sched($ccd_id, $data);
                // if ok
                redirect(base_url().'crop_sched?code='.uencode($user_code) . "&farm_id=".$farm_id. "&cc_id=" .$cc_id);

    }

////////////////////// *********************** MEMBER PROFILE ACTIVITIES ***************************** ///////////////////
    function create_batch_activity(){
        $id = $this->input->post('act_id');

        if(empty($id)){
          $data = array(
              'farm_id'             => $this->input->post('farm_id_act'),
              'encoded_by'          => $this->input->post('encoder'),
              'date_encoded'        => date('Y-m-d'),
              'date_action'         => date('Y-m-d'),
              'prep_category'       => $this->input->post('category'),
              'prep_category_sub'   => $this->input->post('sub_category'),
  	          'details'             => $this->input->post('details'),
              'last_updated'        => date('Y-m-d'),
          );

          $result=  $this->mod_crops->create_batch_activity($data);
          echo json_encode($result);
          return true;
        }else{
          $data = array(
              'encoded_by'          => $this->input->post('encoder'),
              'date_action'         => date('Y-m-d'),
              'prep_category'       => $this->input->post('category'),
              'prep_category_sub'   => $this->input->post('sub_category'),
  	          'details'             => $this->input->post('details'),
              'last_updated'        => date('Y-m-d'),
          );

          $result=  $this->mod_crops->update_batch_activity($data,$id);
          echo json_encode($result);
          return true;
        }


    }

    function fetch_batch_activity($id){
      $data = $this->mod_crops->fetch_activity($id);
  		echo json_encode($data);
  		return true;
    }

    function delete_batch_activity($id){
      $data = $this->mod_crops->delete_batch_activity($id);
  		echo json_encode($data);
  		return true;
    }

////////////////////// *********************** END MEMBER PROFILE ACTIVITIES ***************************** ////////////////

////////////////////// *********************** MEMBER PROFILE EXPENSES ***************************** ///////////////////
    function create_batch_expenses(){
        $id = $this->input->post('exp_id');
        $amount = $value = preg_replace('/[\,]/', '', $this->input->post('amount')); // AMOUNT

        if(empty($id)){
          $data = array(
              'date_encoded'        => date('Y-m-d'),
              'date_purchased'      => $this->input->post('dtpurchased'),
              'prod_category'       => $this->input->post('proCat'),
              'prod_name'           => $this->input->post('proName'),
              'prod_details'        => $this->input->post('details'),
              'amount'              => $amount,
              'farm_id'             => $this->input->post('farm_id_exp'),
              'last_updated'        => date('Y-m-d'),
          );

          $result=  $this->mod_crops->create_batch_expenses($data);
          echo json_encode($result);
          return true;
        }else{
          $data = array(
            'date_encoded'        => date('Y-m-d'),
            'date_purchased'      => $this->input->post('dtpurchased'),
            'prod_category'       => $this->input->post('proCat'),
            'prod_name'           => $this->input->post('proName'),
            'prod_details'        => $this->input->post('details'),
            'amount'              => $amount,
            'farm_id'             => $this->input->post('farm_id_exp'),
            'last_updated'        => date('Y-m-d'),
          );

          $result=  $this->mod_crops->update_batch_expenses($data,$id);
          echo json_encode($result);
          return true;
        }


    }

    function fetch_batch_expenses($id){
      $data = $this->mod_crops->fetch_expenses($id);
  		echo json_encode($data);
  		return true;
    }

    function delete_batch_expenses($id){
      $data = $this->mod_crops->delete_batch_expenses($id);
  		echo json_encode($data);
  		return true;
    }

////////////////////// *********************** END MEMBER PROFILE EXPENSES ***************************** ////////////////


////////////////////// *********************** MEMBER PROFILE BIODIVERSITY ***************************** ///////////////////
    function create_batch_biodiversity(){
        $id = $this->input->post('bio_id');

        if(empty($id)){
          $data = array(
              'farm_id'             =>$this->input->post('farm_id_bio'),
              'plant_category'      =>$this->input->post('plant_cat'),
              'plant_variety'       =>$this->input->post('plant_var'),
              'plant_name'          =>$this->input->post('plant_name'),
              'plant_about'         =>$this->input->post('plant_about'),
              'plant_count'         =>$this->input->post('plant_count'),
              'is_active'           =>false,
              'date_added'          =>date('Y-m-d'),
              'date_removed'        =>NULL,
              'last_updated'        =>NULL,
              'crop_replacement'    =>$this->input->post('crop_rep'),
          );

          $result=  $this->mod_crops->create_batch_biodiversity($data);
          echo json_encode($result);
          return true;
        }else{
          $data = array(
            'plant_category'      =>$this->input->post('plant_cat'),
            'plant_variety'       =>$this->input->post('plant_var'),
            'plant_name'          =>$this->input->post('plant_name'),
            'plant_about'         =>$this->input->post('plant_about'),
            'plant_count'         =>$this->input->post('plant_count'),
            'is_active'           =>false,
            'last_updated'        =>date('Y-m-d'),
            'crop_replacement'    =>$this->input->post('crop_rep'),
          );

          $result=  $this->mod_crops->update_batch_biodiversity($data,$id);
          echo json_encode($result);
          return true;
        }


    }

    function fetch_batch_biodiversity($id){
      $data = $this->mod_crops->fetch_biodiversity($id);
  		echo json_encode($data);
  		return true;
    }

    function delete_batch_biodiversity($id){
      $data = $this->mod_crops->delete_batch_biodiversity($id);
  		echo json_encode($data);
  		return true;
    }

////////////////////// *********************** END MEMBER PROFILE BIODIVERSITY ***************************** ////////////////

//////////////////// EDIT MAIN CROPS //////////////////

    function fetch_MainCrops($id){
      $data = $this->mod_crops->fetch_cultivated_crops($id);
  		echo json_encode($data);
  		return true;
    }

    function fetch_cropStatus(){
      $data = $this->mod_crops->fetch_cropStatus();
  		echo json_encode($data);
  		return true;
    }

    function fetch_calamity(){
      $data = $this->mod_crops->fetch_calamity();
  		echo json_encode($data);
  		return true;
    }

////////////////// DELETE MAIN CROPS //////////////////

} //class close
