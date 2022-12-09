<?php
 

$certPath   = "certificate/eliana_isabel_duran_granda.p12";

/*
 if (openssl_pkcs12_read(file_get_contents($certPath), $certs, $passphrase)) {
 
      $privateKey = openssl_pkey_get_private($certs['pkey']);
	  $publicKey = openssl_x509_read($certs['cert']);
	  $extras = $certs['extracerts'];
	  
	 
    }else{
	
	 echo "Error: No se puede leer el fichero del certificado\n";
	
}
 
 
    $Mensaje = 'JOSE ANDRES SANDOVAL CONTABILIDAD';

       $privateKey = openssl_pkey_get_private($certs['pkey']);
	  $publicKey = openssl_x509_read($certs['cert'])

if(openssl_verify($Mensaje, $privateKey, $publicKey)) 
    print "<p>La firma se verifica satisfactoriamente</p>";
  else
    print "<p>Fallo en la verificación de la firma</p>";


   
 
  // Se verifica el mensaje que supuestamente se ha recibido
  if(openssl_verify($Mensaje, $Firma, $publicKey)) 
    print "<p>La firma se verifica satisfactoriamente</p>";
  else
    print "<p>Fallo en la verificación de la firma</p>";
 
*/

 /*

  // y se usa para firmar el mensaje
  openssl_sign($Mensaje,$Firma, $privateKey);

echo $Mensaje.'<br>';

echo $Firma ;*/
?>

<?php


 

 

/*
  $Mensaje = 'JOSE ANDRESA SANDOVAL CONTABILIDAD';
  $certPathp   = "certificate/eliana_isabel_duran_granda.pem";
  $passphrase = "Esteban2006";


$certificate =  'file://'.realpath('certificate/eliana_isabel_duran_granda.pem');
 
// el mensaje que quiere firmar, por lo que el destinatario puede estar serguro de fue usted
// el que lo envió
$data = <<<EOD
ELIANA ISABEL DURAN GRANDA
EOD;
// guardar el mensaje en un archivo
$fp = fopen("mensaje.txt", "w");
fwrite($fp, $data);
fclose($fp);
// encriptarlo

$prepend = "file://";

openssl_pkcs7_sign(realpath(dirname(__FILE__)) . "/mensaje.txt",
        realpath(dirname(__FILE__)) . "/firmado.txt",
        $prepend . realpath(dirname(__FILE__)) ."/certificate/eliana_isabel_duran_granda.pem",
        array($prepend . realpath(dirname(__FILE__)) ."/certificate/eliana_isabel_duran_granda.pem", "Esteban2006"), $headers);

*/

/*
if (openssl_pkcs7_sign("mensaje.txt", "firmado.txt", $certPathp,
    array($certPathp ,$passphrase),
    array("Para" => "joes@example.com", // sintaxis asociativa
          "DE: C.G. <presidente@example.com>", // sintaxis indexada
          "Tema" => "Confidencial")
    )) {
    // mensaje firmado - ¡envíelo!
    exec(ini_get("ruta_correo") . " < firmado.txt");
}*/
 
/*
  // Se obtiene la clave privada con la que se va a firmar
  $Clave = openssl_pkey_get_private(file_get_contents($certPathp),$passphrase);
  // y se usa para firmar el mensaje
  openssl_sign($Mensaje,$Firma, $Clave);

  $Cert = openssl_x509_read(file_get_contents($certPathp));

  echo $Mensaje.'<br>';

  // Se verifica el mensaje que supuestamente se ha recibido
  if(openssl_verify($Mensaje, $Firma, $Cert)) 
    print "<p>La firma se verifica satisfactoriamente</p>";
  else
    print "<p>Fallo en la verificación de la firma</p>";
 

  // echo $Firma.'<br>';
 
 
  $ssl = openssl_x509_parse($Cert);



 
echo  $ssl['extensions'].'<br>';

$datos =   $ssl['extensions'];


 print_r($datos);

echo  $datos['subjectAltName'].'<br>';


*/
 /*



echo  $datos['O'].'<br>';


echo  $datos['subjectAltName'].'<br>';

*/

// /C=EC/O=BANCO CENTRAL DEL ECUADOR/OU=ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE/L=QUITO/serialNumber=0000426040/CN=ELIANA ISABEL DURAN GRANDA

	
  // Liberación del certificado y la clave
  //openssl_x509_free($Cert);
  //openssl_pkey_free($Clave);


/*
Array ( [name] => /C=EC/O=BANCO CENTRAL DEL ECUADOR/OU=ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE/L=QUITO/serialNumber=0000426040/CN=ELIANA ISABEL DURAN GRANDA 		[subject] => Array ( [C] => EC 
							 [O] => BANCO CENTRAL DEL ECUADOR 
							 [OU] => ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE 
							 [L] => QUITO [serialNumber] => 0000426040 
							 [CN] => ELIANA ISABEL DURAN GRANDA ) 
	   [hash] => 0dc8c310 
	   [issuer] => Array ( [C] => EC 
						   [O] => BANCO CENTRAL DEL ECUADOR 
						   [OU] => ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE 
						   [L] => QUITO 
						   [CN] => AC BANCO CENTRAL DEL ECUADOR ) 
	   	[version] => 2 
	    [serialNumber] => 1533151217 
	    [serialNumberHex] => 5B6207F1 
	    [validFrom] => 191219160515Z 
	    [validTo] => 211219163515Z 
	    [validFrom_time_t] => 1576771515 
	    [validTo_time_t] => 1639931715 
	    [signatureTypeSN] => RSA-SHA256 
	    [signatureTypeLN] => sha256WithRSAEncryption 
	    [signatureTypeNID] => 668 
	    [purposes] => Array ( 
				[1] => Array ( [0] => 
							  [1] => 
							  [2] => sslclient ) 
			    [2] => Array ( [0] => 1 
							   [1] => 
							   [2] => sslserver ) 
				[3] => Array ( [0] => 1 
							   [1] => 
							   [2] => nssslserver ) 
			    [4] => Array ( [0] => 
							   [1] => 
							   [2] => smimesign ) 
			    [5] => Array ( [0] => 1 
							   [1] => 
							   [2] => smimeencrypt ) 
			    [6] => Array ( [0] => 
							   [1] => 
							   [2] => crlsign ) 
			    [7] => Array ( [0] => 1 
							   [1] => 1 
							   [2] => any ) 
				[8] => Array ( [0] => 1 
							   [1] => 
							   [2] => ocsphelper ) 
			    [9] => Array ( [0] => 
							   [1] => 
							   [2] => timestampsign ) ) 
	   [extensions] => Array ( 
		   		[keyUsage] => Key Encipherment 
		        [authorityInfoAccess] => OCSP - URI:http://ocsp.eci.bce.ec/ejbca/publicweb/status/ocsp OCSP - URI:http://ocsp1.eci.bce.ec/ejbca/publicweb/status/ocsp [1.3.6.1.4.1.37947.3.1] =>  1102970900 [1.3.6.1.4.1.37947.3.2] =>  ELIANA ISABEL [1.3.6.1.4.1.37947.3.3] => DURAN [1.3.6.1.4.1.37947.3.4] => GRANDA [1.3.6.1.4.1.37947.3.7] => "VIA CHONE KM 7 RANCHO SAN FERNANDO [1.3.6.1.4.1.37947.3.8] =>  099166761 [1.3.6.1.4.1.37947.3.9] =>  Santo Domingo [1.3.6.1.4.1.37947.3.12] => ECUADOR [1.3.6.1.4.1.37947.3.11] =>  2360007880001 [1.3.6.1.4.1.37947.3.51] => SOFTWARE-ARCHIVO 
		        [subjectAltName] => email:epconstsantodomingo@gmail.com 
		        [crlDistributionPoints] => Full Name: URI:ldap://bceqldapsubp1.bce.ec/cn=CRL891,cn=AC%20BANCO%20CENTRAL%20DEL%20ECUADOR,l=QUITO,ou=ENTIDAD%20DE%20CERTIFICACION%20DE%20INFORMACION-ECIBCE,o=BANCO%20CENTRAL%20DEL%20ECUADOR,c=EC?certificateRevocationList?base URI:http://www.eci.bce.ec/CRL/eci_bce_ec_crlfilecomb.crl DirName: C = EC, O = BANCO CENTRAL DEL ECUADOR, OU = ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE, L = QUITO, CN = AC BANCO CENTRAL DEL ECUADOR, CN = CRL891 [authorityKeyIdentifier] => keyid:48:A2:DF:23:1F:1D:F8:2C:51:7A:8C:03:CD:49:32:A5:09:C1:94:AB [subjectKeyIdentifier] => CD:C4:3E:30:42:0A:DB:82:ED:37:E4:46:89:0F:EF:08:F1:59:0C:35 [basicConstraints] => CA:FALSE [1.2.840.113533.7.65.0] => 0 V8.1� ) )
*/
?>
 
 
 


 