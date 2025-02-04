<?php
session_start( );

require '../../kconfig/Db.class.php';

require '../../kconfig/Obj.conf.php';

$bd	   = new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$id          = $_GET['id'];

$ruc         = $_SESSION['ruc_registro'];

$Array_Cabecera = $bd->query_array(
    'guia_cabecera',
    'estado,claveacceso',
    'cab_codigo ='.$bd->sqlvalue_inyeccion($id,true)
    );



//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso,felectronica',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );

$clave   =  trim($ADatos['acceso']);

$firma   = trim($ADatos['firma']);

$archivo =  trim($Array_Cabecera['claveacceso']);

$envio = trim($Array_Cabecera['estado']) ;

$autretencion1  = trim($Array_Cabecera['claveacceso']);

$ambiente   = trim($ADatos['ambiente']);
//--------------------------------------------------------------

$data = '999.No se genero validacion... genere nuevamente';


if ( $envio == 'autorizado') {
    
    $data = 'Comprobante electronico autorizado';
    
}else {
 
    if ( trim($Array_Cabecera['estado']) == 'aprobado') {
        
        
      //  $url  = "http://167.99.0.234/facturacion/electronica/autoriza_guia_externo.php";
      
        //  $url  = "http://167.99.0.234/facturacion/electronica/"; http://cabildo.ec/k-rosa/control/
        //  $ruta = 'http://167.99.0.234/facturacion/electronica/'; http://www.s2i.com.ec/kaipi/facturae/
        
        $url  = "http://159.69.66.94/~grupoinv/factura/autoriza_nc_externo4.php";
        $ruta = 'http://159.69.66.94/~grupoinv/factura//';
        
      
     //    $url  = "http://liderdoc.com/factura/facturae/autoriza_guia_externo.php";
     //    $ruta = 'http://liderdoc.com/factura/facturae/';
        
        
        $enlace_post = "autretencion1=".$autretencion1."&clave=".$clave."&archivo=".$archivo."&firma=".$firma."&ambiente=".$ambiente ;
        
       
        // abrimos la sesión cURL
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,$url);
      //  curl_setopt($ch, CURLOPT_PORT, 80);
        curl_setopt($ch, CURLOPT_POST, 1);
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $enlace_post );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec ($ch);
        // cerramos la sesión cURL
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
            // Show me the result
            curl_close($ch);
            print $data ;
        }
        
        curl_close ($ch);
        
       
        
        $valida = substr(trim($data), 0, 2);
        
        if ( trim($valida) == 'OK') {
            
            $sql = "UPDATE guia_cabecera
            						   SET 	estado=".$bd->sqlvalue_inyeccion('autorizado', true)."
             						 WHERE cab_codigo=".$bd->sqlvalue_inyeccion($id, true);
            
            $bd->ejecutar($sql);
            
            // hacemos lo que queramos con los datos recibidos
            $file_signed    = $ruta.$autretencion1.'_A.xml';
            $archivo_signed = '../../facturae/xml/'.$autretencion1.'_A.xml';
            
            $ch = curl_init($file_signed);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            $output = curl_exec($ch);
            //Guardamos la imagen en un archivo
            $fh = fopen($archivo_signed , 'w');
            fwrite($fh, $output);
            fclose($fh);
        }
        else {
            
          
            
        //    $bd->ejecutar($sql);
            
        } 
    }
}


//--------------------------------------
echo $data;

?>