<?php
session_start( );

require '../../kconfig/Db.class.php';

require '../../kconfig/Obj.conf.php';

$bd	   = new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$id          = $_GET['id'];

$ruc         = $_SESSION['ruc_registro'];


$Array_Cabecera = $bd->query_array(
    'view_inv_movimiento',
    'envio,autorizacion',
    'id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
    );

//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso',
    'ruc_registro='.$bd->sqlvalue_inyeccion( trim($ruc),true)
    );

$clave          =  trim($ADatos['acceso']);
$firma          = trim($ADatos['firma']);
$archivo        =  trim($Array_Cabecera['autorizacion']);
$envio          = trim($Array_Cabecera['envio']) ;
$autretencion1  = trim($Array_Cabecera['autorizacion']);
$ambiente       = trim($ADatos['ambiente']);
//--------------------------------------------------------------
$data = '999.No se genero validacion... genere nuevamente '.$envio.' '.$archivo;


if ( $envio == 'S') {
    
    $data = 'Comprobante electronico autorizado';
    
}else {
    
  
        
        // abrimos la sesi�n cURL
        $ch = curl_init();
        
        // definimos la URL a la que hacemos la petici�n
        $url  = "http://206.189.231.35/factura/autoriza_factura_e.php";
        $ruta = 'http:/206.189.231.35/factura/xml/';
        
        curl_setopt($ch, CURLOPT_PORT, 80);
        
        curl_setopt($ch, CURLOPT_URL,$url);
        
        
        // definimos el n�mero de campos o par�metros que enviamos mediante POST
        curl_setopt($ch, CURLOPT_POST, 1);
        // definimos cada uno de los par�metros
        
        $enlace_post = "autretencion1=".$autretencion1."&clave=".$clave."&archivo=".$archivo."&firma=".$firma."&ambiente=".$ambiente ;
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $enlace_post );
   
        
        // recibimos la respuesta y la guardamos en una variable
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $data = curl_exec ($ch);
  
     
        
        // cerramos la sesi�n cURL
        curl_close ($ch);
        
        $valida = substr(trim($data), 0, 2);
        
        if ( trim($valida) == 'OK') {
            
            $sql = "UPDATE inv_movimiento
    					 SET 	envio=".$bd->sqlvalue_inyeccion('S', true).",
                                transaccion=".$bd->sqlvalue_inyeccion('E', true)."
     			      WHERE id_movimiento=".$bd->sqlvalue_inyeccion($id, true);
            
            $bd->ejecutar($sql);
             
            
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
            
            $sql = "UPDATE inv_movimiento
    					 SET 	envio=".$bd->sqlvalue_inyeccion('', true).",
                                autorizacion=".$bd->sqlvalue_inyeccion('', true).",
                                transaccion=".$bd->sqlvalue_inyeccion('', true)."
     			      WHERE id_movimiento=".$bd->sqlvalue_inyeccion($id, true);
            
            //    $bd->ejecutar($sql);
            
        }
    }
 

//--------------------------------------
echo $data;

?>