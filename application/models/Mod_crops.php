<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_crops extends CI_Model {

    function create_farm($data){
        return $this->db->insert('farms', $data);
    }

    public function create_batch_crop($data) {
       //return $insert_id;
       return $this->db->insert('cultivated_crops', $data);
    }



	public function update_batch_crop($id,$data) {
	    //return $insert_id;
		$this->db->where('cc_id',$id);
	    return $this->db->update('cultivated_crops', $data);
	}

  function delete_batch_crop($id){
    $this->db->where('cc_id',$id);
	  $this->db->delete('cultivated_crops');
  }

  function create_main_crop($data){
    $this->db->insert('lib_crops', $data);
  }

  function fetch_main_crop($id){
    $this->db->select('*')->from('lib_crops');
    $this->db->where('crop_id',$id);
    $query = $this->db->get();
    return $query->row();
  }

  function update_main_crop($data,$id) {
    $this->db->where('crop_id',$id);
    $this->db->update('lib_crops', $data);
  }

  function delete_main_crop($id){
    $this->db->where('crop_id',$id);
    $this->db->delete('lib_crops');
  }


  public function edit_crop_sched($ccd_id,$data) {
    $this->db->where('ccd_id',$ccd_id);
      return $this->db->update('cultivated_crop_details', $data);
  }

  public function create_crop_detail_sched($data){
    $this->db->insert('cultivated_crop_details', $data);
  }

      function make_query($cc_id)
      {
          $this->db->select("*");
          $this->db->where('cc_id',$cc_id);
          $this->db->from('cultivated_crop_details');
          $this->db->order_by('ccd_id', 'DESC');
      }

      function make_datatables($cc_id){
          $this->db->select("*");
          $this->db->where('cc_id',$cc_id);
          $this->db->from('cultivated_crop_details');
          $this->db->order_by('ccd_id', 'DESC');

           $query = $this->db->get();
           return $query->result();
      }
      function get_filtered_data($cc_id){
          $this->db->select("*");
          $this->db->where('cc_id',$cc_id);
          $this->db->from('cultivated_crop_details');
          //$this->db->order_by('ccd_id', 'DESC');

           $query = $this->db->get();
           return $query->num_rows();
      }
      function get_all_data($cc_id)
      {
           $this->db->select("cc_id,harvest_sched_start,yield_estimate,yield_actual,remarks");
           $this->db->where('cc_id',$cc_id);
           $this->db->from('cultivated_crop_details');
           return $this->db->count_all_results();
      }

    public function count_org_farmers($id){
        $this->db->select('org_chapter');
        $this->db->from('members');
        $this->db->where('org_chapter', $id);
        $this->db->where('is_active=TRUE');
        return $this->db->count_all_results();
    }

////////////////////// *********************** MEMBER PROFILE ACTIVITIES ***************************** ///////////////////

    function fetch_activity($id){
      $this->db->where('fa_id', $id);
      $this->db->select('*')->from('farm_activities');
      $query = $this->db->get();
      return $query->row();
    }

    function create_batch_activity($data){
      $this->db->insert('farm_activities', $data);
    }

    function update_batch_activity($data,$id){
      $this->db->where('fa_id', $id);
      $this->db->update('farm_activities', $data);
    }

    function delete_batch_activity($id){
      $this->db->where('fa_id', $id);
      $this->db->delete('farm_activities');
    }

////////////////////// *********************** END MEMBER PROFILE ACTIVITIES ***************************** ////////////////

////////////////////// *********************** MEMBER PROFILE EXPENSES ***************************** ///////////////////


    function create_batch_expenses($data){
      $this->db->insert('farm_expenses', $data);
    }

    function fetch_expenses($id){
      $this->db->where('ce_id', $id);
      $this->db->select('*')->from('farm_expenses');
      $query = $this->db->get();
      return $query->row();
    }

    function update_batch_expenses($data,$id){
      $this->db->where('ce_id', $id);
      $this->db->update('farm_expenses', $data);
    }

    function delete_batch_expenses($id){
      $this->db->where('ce_id', $id);
      $this->db->delete('farm_expenses');
    }

////////////////////// *********************** END MEMBER PROFILE EXPENSES ***************************** ////////////////

////////////////////// *********************** MEMBER PROFILE BIODIVERSITY ***************************** ///////////////////


    function create_batch_biodiversity($data){
      $this->db->insert('biodiversity', $data);
    }

    function fetch_biodiversity($id){
      $this->db->where('bio_id', $id);
      $this->db->select('*')->from('biodiversity');
      $query = $this->db->get();
      return $query->row();
    }

    function update_batch_biodiversity($data,$id){
      $this->db->where('bio_id', $id);
      $this->db->update('biodiversity', $data);
    }

    function delete_batch_biodiversity($id){
      $this->db->where('bio_id', $id);
      $this->db->delete('biodiversity');
    }

////////////////////// *********************** END MEMBER PROFILE EXPENSES ***************************** ////////////////

//////////////////// EDIT MAIN CROPS //////////////////

    function fetch_cultivated_crops($id){
      $this->db->select('*')->from('cultivated_crops');
      $this->db->where('cc_id', $id);

      $query = $this->db->get();
      return $query->row();
    }

    function fetch_cropStatus(){
      $this->db->select('*')->from('lib_crop_status');
      $query = $this->db->get();
      return $query->result();
    }

    function fetch_calamity(){
      $this->db->select('*')->from('lib_state_of_calamity');
      $query = $this->db->get();
      return $query->result();
    }

//////////////////// END EDIT MAIN CROPS //////////////////

} //close class
