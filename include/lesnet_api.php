<?php
	#TODO: dump this and write my own version of this right in the lesBalance widget code

	#From les.net
	#modified by Devon to get the apikey and idkey from params instead of in the script

function lesnet_api($url,$json_string,$authenticate=0,$apikey='',$idkey='') {

	// version 0.0.1

	// params:
	// [0] - URL 
	// [1] - $json : a json string
	// [2] - $authenticate : send authentication credentials yes/no
	// [2] - $apikey
	// [2] - $idkey

	$json_request = json_decode($json_string,TRUE);

	if ($authenticate) {
		$json_request['authentication']['apikey']	= $apikey;
		$json_request['authentication']['idkey']	= $idkey;
	}

	if (!isset($json_request['sequence'])) {
		$json_request['sequence']	= time();
	}

	$json = json_encode($json_request);

	if (substr($url,strlen($url),1) != '/') {
		$url .= "/";
	}

	$headers   = array();
	$headers[] = 'Content-Type: application/json';

        $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.les.net/v1/$url");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $json_result = curl_exec ($ch);

	curl_close($ch);

	if (!$json_result) {
		return FALSE;
	}

	return $json_result;
}

?>
