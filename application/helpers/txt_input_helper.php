<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function input_text_form($caption, $id_id, $name_name, $placeholder){
	//variables to be passed: id_id, name_name, placeholder, help_block
    echo "<label>".$caption."</label>";
    echo "<div class=\"form-group\">";
         echo "<input type = \"text\" class=\"form-control\" id = \"".$id_id."\" name = \"".$name_name."\" placeholder = \"".$placeholder."\">";
    echo "</div>";
}

function update_text_form($caption, $id_id, $name_name, $help_block, $value,$addon){
    //variables to be passed: id_id, name_name, caption, help_block
    echo "<label>".$caption."</label>";
    echo "<div class=\"form-group\">";
         echo "<input type = \"text\" class=\"form-control\" id = \"".$id_id."\" name = \"".$name_name."\" value = \"".$value."\">";
     echo "</div>";
}

function input_text_form_readonly($caption, $id_id, $name_name, $help_block, $value, $addon){
    //variables to be passed: id_id, name_name, caption, help_block
    echo "<label>".$caption."</label>";
    echo "<div class=\"form-group\">";
         echo "<input readonly type = \"text\" class=\"form-control\" id = \"".$id_id."\" name = \"".$name_name."\" value = \"".$value."\">";
     echo "</div>";
}

function input_date_form($caption, $id_id, $name_name, $help_block){
	//variables to be passed: id_id, name_name, caption, help_block
    echo "<div class=\"form-group\">";
         echo "<label>".$caption."</label>";
         echo "<input type = \"date\" class=\"form-control\" id = \"".$id_id."\" name = \"".$name_name."\">";
         echo "<p class=\"help-block\">".$help_block."</p>";
     echo "</div>";
}

function update_date_form($caption, $id_id, $name_name, $value, $help_block){
    //variables to be passed: id_id, name_name, caption, help_block
    echo "<div class=\"form-group\">";
         echo "<label>".$caption."</label>";
         echo "<input type = \"date\" class=\"form-control\" id = \"".$id_id."\" name = \"".$name_name."\" value = \"".$value."\"";
         echo "<p class=\"help-block\">".$help_block."</p>";
     echo "</div>";
}

function encr($plain_text){
    //this is to encrypt all fields
    $CI =& get_instance();
    return $CI->encryption->encrypt($plain_text);
}

function decr($plain_text){
    //this is to decrypt all fields
    $CI =& get_instance();
    return $CI->encryption->decrypt($plain_text);
}

function uencode($plain_text){
    return urlencode(base64_encode($plain_text));
}

function udecode($plain_text){
    return base64_decode(urldecode($plain_text));
}


function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}