
<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   =	new Db;
    

    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
 
    $smtp1		    = trim($_GET['smtp1']);
    $puerto1 	    = trim($_GET['puerto1']);
    $acceso1	 	= trim($_GET['acceso1']);
    $email1	 		= trim($_GET['email1']);
    
    
 
	$sql = 'UPDATE par_usuario 
            SET  smtp1  ='.$bd->sqlvalue_inyeccion($smtp1, true).',
                 puerto1='. $bd->sqlvalue_inyeccion($puerto1, true).',
                 acceso1='.$bd->sqlvalue_inyeccion(base64_encode($acceso1), true).' 
             WHERE email='. $bd->sqlvalue_inyeccion(trim($email1), true);
 	
			            				
	$bd->ejecutar($sql);
	 
    $ResultadoUserWeb='Ok';
			            				
			            				
	 
	 echo $ResultadoUserWeb;
         
	 
	 //--------------------------
 
	 
	 $pkcs12        =  $smtp1;
	 $cert_password =  $acceso1;
	 
	 $certificate = array();

 

    $folder = '../../kdocumento/reportes/';
	 
	 $pkcs12 = file_get_contents( $folder.$pkcs12);

 
	 
	 
	 if (openssl_pkcs12_read($pkcs12, $certificate, $cert_password)) {
	     
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
	     
	     
		 $content =  str_replace ( 'p12' , 'pem' ,  $smtp1);

		 
		 $content =  $folder.$content;
		 
	 
		 
	     file_put_contents($content  , $pem_file_contents);
	     
	     
	     
	     
	 }
	 
 
	 
 
 
  ?> 
								
 
 
 