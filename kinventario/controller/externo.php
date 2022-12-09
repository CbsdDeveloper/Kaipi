<?php
session_start( );



require '../../kconfig/Db.class.php';

require '../../kconfig/Obj.conf.php';


$bd	   = new Db ;



$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

//--------------------------------------------------------------

$id          = $_GET['id'];


$ruc         = $_SESSION['ruc_registro'];

$Array_Cabecera = $bd->query_array(
    'view_inv_movimiento',
    'envio,autorizacion,transaccion',
    'id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
    );



//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso,felectronica',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );

$clave   =  trim($ADatos['acceso']);

$firma   = trim($ADatos['firma']);

$archivo =  trim($Array_Cabecera['autorizacion']);

$envio = trim($Array_Cabecera['envio']) ;

$autretencion1  = trim($Array_Cabecera['autorizacion']);

$ambiente   = trim($ADatos['ambiente']);
//--------------------------------------------------------------

$data = '999.No se genero validacion... genere nuevamente';


if ( $envio == 'S') {
    
    $data = 'Comprobante electronico autorizado';
    
}else {
    
    if ( trim($Array_Cabecera['transaccion']) == 'F') {
        
        
        // abrimos la sesión cURL
        $ch = curl_init();
        
        // definimos la URL a la que hacemos la petición
        
        //$url = "https://liderdoc.com/factura/facturae/autoriza_factura_externo.php";
        
        $url = "https://liderdoc.com/factura/facturae/autoriza_factura_externo1.php" ;
        
        curl_setopt($ch, CURLOPT_URL,$url);
        
         
        // definimos el número de campos o parámetros que enviamos mediante POST
        curl_setopt($ch, CURLOPT_POST, 1);
        // definimos cada uno de los parámetros
        
        $enlace_post = "autretencion1=".$autretencion1."&clave=".$clave."&archivo=".$archivo."&firma=".$firma."&ambiente=".$ambiente ;
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $enlace_post );
        
        // recibimos la respuesta y la guardamos en una variable
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $data = curl_exec ($ch);
        
        // cerramos la sesión cURL
        curl_close ($ch);
        
        $valida = substr(trim($data), 0, 2);
        
        if ( trim($valida) == 'OK') {
            
            $sql = "UPDATE inv_movimiento
    					 SET 	envio=".$bd->sqlvalue_inyeccion('S', true).",
                                transaccion=".$bd->sqlvalue_inyeccion('E', true)."
     			      WHERE id_movimiento=".$bd->sqlvalue_inyeccion($id, true);
            
            $bd->ejecutar($sql);
            
            // hacemos lo que queramos con los datos recibidos
            // por ejemplo, los mostramos
            //--------------------
            //------------------------------
            $ruta = 'https://liderdoc.com/factura/facturae/';
            
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
    }
}


//--------------------------------------
echo $data;

?>