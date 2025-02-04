<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   = new Db ;



$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

//--------------------------------------------------------------

$id          = $_GET['id_asiento'];

$ruc         = $_SESSION['ruc_registro'];

$Array_Cabecera = $bd->query_array(
    'co_compras',
    'codigoe,secretencion1, autretencion1',
    'id_compras ='.$bd->sqlvalue_inyeccion($id,true)
    );




//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso,felectronica',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );



$clave   =  trim($ADatos['acceso']);

$firma   = trim($ADatos['firma']);

$archivo =  trim($Array_Cabecera['autretencion1']);

$envio = trim($Array_Cabecera['codigoe']) ;

$autretencion1  = trim($Array_Cabecera['autretencion1']);
//--------------------------------------------------------------

$ambiente = trim($ADatos['ambiente']);

$data = 'Comprobante electronico NO autorizado';



if ( $envio == 1) {
    
    $data = 'Comprobante electronico autorizado';
    
}else {
    
    $data = 'Comprobante electronico por autorizado';
    
    
    // abrimos la sesi�n cURL
    $ch = curl_init();
    
    // definimos la URL a la que hacemos la petici�n
 
    
    $url  = "http://159.69.66.94/~grupoinv/factura/autoriza_comprobante_externo5.php";
    $ruta = 'http://159.69.66.94/~grupoinv/factura//';
    
    
    
    curl_setopt($ch, CURLOPT_URL,$url);
    
     // definimos el n�mero de campos o par�metros que enviamos mediante POST
    curl_setopt($ch, CURLOPT_POST, 1);
    
    
    $enlace_post = "autretencion1=".$autretencion1."&clave=".$clave."&archivo=".$archivo."&firma=".$firma."&ambiente=".$ambiente ;
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $enlace_post );
    
    // definimos cada uno de los par�metros
    
    // recibimos la respuesta y la guardamos en una variable
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $data = curl_exec ($ch);
    
    // cerramos la sesi�n cURL
    curl_close ($ch);
    
    $valida = substr(trim($data), 0,2);
    
    if ( trim($valida) == 'OK') {
        
        
        $sql = "UPDATE co_compras
                						                    SET 	codigoe=".$bd->sqlvalue_inyeccion(1, true).",
                                                                    transaccion=".$bd->sqlvalue_inyeccion('E', true)."
                 						                  WHERE id_compras=".$bd->sqlvalue_inyeccion($id, true);
        
        $bd->ejecutar($sql);
        
    }
    
    
    // hacemos lo que queramos con los datos recibidos
    // por ejemplo, los mostramos
    
    //  $ruta = "https://liderdoc.com/factura/facturae/";
    
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
//--------------------------------------
echo $data;

?>