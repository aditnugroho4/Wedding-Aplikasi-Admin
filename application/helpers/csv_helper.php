<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function csvFromArray($arr,$platform)
{
	$csv = '';
	$CI = & get_instance(); 
	if(base64_decode($platform) == "Windows"){
		
		foreach ($arr as $key => $row) {
			$csv .= implode(';', $row) . "\n";
		}
	}else {
		foreach ($arr as $key => $row) {
		$csv .= implode('","', $row) . "\n";
		}
	}
	return $csv;
}?>