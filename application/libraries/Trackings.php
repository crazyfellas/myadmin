<?php 

Class Trackings{

	function get_page($my_page){
		$CI =& get_instance();
		date_default_timezone_set('Asia/Singapore');
		$date = date("Y-m-d  H:i:s");
	    $page_viewed 	= $my_page;
	    $ip_address 	= $_SERVER["REMOTE_ADDR"];
	    $email 			= $_SESSION["email"];
	    $datetime_viewed= $date;
	    $full_name 		= $_SESSION["full_name"];

		$data = array(
		   'page_viewed' 	=> $page_viewed,
		   'ip_address' 	=> $ip_address,
		   'email' 			=> $email,
		   'datetime_viewed'=> $datetime_viewed,
		   'full_name' 		=> $full_name
		);

		$CI->db->insert('track_page_trailings', $data); 
	}


}//close class
?>