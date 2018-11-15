<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function track_page($my_page){
	$CI =& get_instance();
	return $CI->trackings->get_page($my_page);

}

