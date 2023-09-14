<?php 

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl");
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT,1000);
	$result = curl_exec($ch);
	curl_close($ch);

	if ($result == NULL) {
		echo "ERROR  curl_setopt : ";
		echo curl_errno($ch) ."<br>";
	}else{
		
		echo "ok  vale esto: ";
		
	}	
	
	 
	echo phpinfo();