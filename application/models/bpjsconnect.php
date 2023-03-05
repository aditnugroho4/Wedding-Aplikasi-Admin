<?php
	$consID = '7523';
	$consSecret = '7bDC183AE6';
	date_default_timezone_set("Asia/Jakarta");
	$tStamp = strtotime(date("Y/m/d H:i:s"));
	$timestamp = $tStamp;
	$data = $consID.'&'.$timestamp;
	
	$signature = hash_hmac('sha256', $data, $consSecret, true);
	$encodedSignature = base64_encode($signature);
//	$encodedSignature = urlencode($encodedSignature);
 
 //echo "X-cons-id: " .$data ."<br>";
// echo "X-timestamp:" .$tStamp ."<br>";
// echo "X-signature: " .$encodedSignature;
?>
	