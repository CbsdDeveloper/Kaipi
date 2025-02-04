<?php 
session_start( );
require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
/** 
* Copyright (c)2018 - EN Systems Apps
* @abstract Envia un mail con un xml y pdf adjunto
* @author Erik Niebla
* @mail ep_niebla@hotmail.com, ep.niebla@gmail.com
* @version 1.0
* Fecha de creación  2018-02-27
* http://ensystems.ddns.net
*/
require_once(dirname(__file__)."/RideSRI/RideSRI.php");

$ruta = dirname(__file__);


$id          = $_GET['id'];

$Array_Cabecera = $bd->query_array(
    'view_anexos_compras',
    'secretencion1, autretencion1,transaccion',
    'id_asiento ='.$bd->sqlvalue_inyeccion($id,true)
    );

$ruc         = $_SESSION['ruc_registro'];

//---------------- empresa ruc
$ADatos = $bd->query_array(
    'web_registro',
    'obligado,firma,carpeta,ambiente,acceso,felectronica',
    'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
    );
 

if ( $Array_Cabecera['transaccion'] == 'E' ) {
        
        
        $imagen = trim($ADatos['carpeta']);
        
        $carpeta = 'xml';
        
        $archivo = '/'.$carpeta.'/'.trim($Array_Cabecera['autretencion1']);
        
        $logo    = '/firmas/'.$imagen;
        
        // Muestro una Factura
        $file_autorized = $ruta.$archivo.'_A.xml';
        
        $logo_path=$ruta.$logo;
        
        if ( $ADatos['felectronica'] == 'S' ) {
        	
                try{	
                	
                	$ride = new RideSRI();
                	// Arg1 ruta a archivo fisico xml
                	// Arg2 logo ride
                	// Arg3 I=Visualizar, D=Descargar
                	// Arg4 true=online, false=offline 
                	// NOTA le puse offline xq no esta autorizada y para q aparezca la clave como autorizacion
                	$result = $ride->createRide($file_autorized, $logo_path, 'I', true); // Instancio la clase, y muestro el ride
                	
                }catch (Exception $e) { 
                	echo '<br/><b>ERROR AL EJECUTAR EL SCRIPT</b><br/>';
                	echo '<b>Excepción Capturada[</b> ',  $e->getMessage(), "]\n";	
                } 
                
        } 
} 
