<?php 

session_start( );  
   	
 
require('kreportes.php'); 
    
$gestion   		= 	new ReportePdf; 	

$razon			=   $gestion->Empresa();
$nombre_usuario =   $gestion->UserFirma();
$unidad			=   $gestion->_Cab('depa');


 
$pkcs12         =  trim($_POST['smtp1']);
$cert_password1 =  trim($_POST['acceso1']);
$email1 	    =  trim($_SESSION['email']);
        		

$archivo_pem   =   $gestion->_Cab('archivo');

$certificate = array();


 
$pkcs12 = file_get_contents($pkcs12);


 
		if (openssl_pkcs12_read($pkcs12, $certificate, $cert_password1)) {
  					
			  if(is_file($archivo_pem)) {
 						 
				  		  $gestion->_actualiza_clave($cert_password1,$email1);
				  
				  		  echo 'FIRMA VALIDA';
			  }
				else  {
 
							if (isset($certificate['pkey'])) {
								$pem = null;
								openssl_pkey_export($certificate['pkey'], $pem, $cert_password);
								;
							}

							if (isset($certificate['cert'])) {
								$cert = null;
								openssl_x509_export($certificate['cert'], $cert);

							}

							if (isset($certificate['extracerts'][0])) {
								$extracert1 = null;
								openssl_x509_export($certificate['extracerts'][0], $extracert1);

							}

							if (isset($certificate['extracerts'][1])) {
								$extracert2 = null;
								openssl_x509_export($certificate['extracerts'][1], $extracert2);
							}

						   $pem_file_contents = $cert . $pem . $extracert1 . $extracert2;


							file_put_contents( $archivo_pem, $pem_file_contents);
					
							$gestion->_actualiza_clave($cert_password1,$email1);

						    echo 'FIRMA VALIDA';
				 }		 
 		
		} else {
		
			  echo 'ERROR EN FIRMA DE ARCHIVO';
			
 		}


  
  
 

?> 
