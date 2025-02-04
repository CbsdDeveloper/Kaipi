<?php
session_start( );
require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
require_once(dirname(__file__)."/RideSRI/RideSRI.php");

$ruta_logo       =  $bd->_url_externo(74); // ruta xml 
$ruta            =  $bd->_url_externo(72); // ruta xml 
 
$ruc         = trim($_SESSION['ruc_registro']);

$id          = $_GET['id'];

$Array_Cabecera = $bd->query_array( 'rentas.view_ren_factura','*','id_ren_movimiento ='.$bd->sqlvalue_inyeccion($id,true));


//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );

 
if ( $Array_Cabecera['envio'] == 'S') {

        $imagen = trim($ADatos['carpeta']);
          
        $archivo = $ruta .trim($Array_Cabecera['autorizacion']);
        
        $logo    = $imagen;
         
        $echo    = true; // solo para ver los procesos
        
        // Muestro una Factura
         $file_autorized = $archivo.'_A.xml';
        
         $logo_path=$ruta_logo.$logo;

         
        try{
            
            $ride = new RideSRI();
            // Arg1 ruta a archivo fisico xml
            // Arg2 logo ride
            // Arg3 I=Visualizar, D=Descargar
            // Arg4 true=online, false=offline
            $FacturaElectronica = $ride->createRide($file_autorized, $logo_path, 'I', false); // Instancio la clase, y muestro el ride
            
         
            
        }catch (Exception $e) {
            echo '<b>ERROR AL EJECUTAR EL SCRIPT</b>';
            echo '<b>Excepci�n Capturada[</b> ',  $e->getMessage(), "]\n";
        }
} else  {
    
    echo '<h4><b>No se puede generar el documento RIDE</b></h4>';
    echo '<h5>Actualice la informacion con el icono (Emitir Factura Electronica)</h5>';
    
}
