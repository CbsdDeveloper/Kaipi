<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;

$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$anio   = $_SESSION['anio'];


$cuenta        = trim($_GET['cuenta']);   // VARIABLE DE ENTRADA CODIGO DE BITACORA

$tipo 		     = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES

 


$tipo_cta =  substr(trim($cuenta),0,1); 
	    
if( $tipo_cta == '1'){
	        
    $sql = 'SELECT idprov ,
               razon    ,
               sum(debe) as debe,
               sum(haber) as haber  ,
                sum(debe) - sum(haber) as saldo
        FROM view_aux
        where cuenta = '.$bd->sqlvalue_inyeccion($cuenta,true)." and
              anio = ".$bd->sqlvalue_inyeccion($anio,true)." and
              estado = ".$bd->sqlvalue_inyeccion('aprobado',true)."
         group by idprov,razon
        having sum(debe) - sum(haber)   <> 0";   
     
    
}else{
    
    $sql = 'SELECT idprov ,
               razon  ,
               sum(debe)  as debe,
               sum(haber) as haber,  
               sum(haber) - sum(debe) as saldo
        FROM view_aux
        where cuenta = '.$bd->sqlvalue_inyeccion($cuenta,true)." and
              anio = ".$bd->sqlvalue_inyeccion($anio,true)." and
             estado = ".$bd->sqlvalue_inyeccion('aprobado',true)."  
         group by idprov,razon
        having sum(haber) - sum(debe)   <> 0";  
    
    
    
}

$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO


 

$evento   = "goToURL_agrega-0";  // nombre funcion javascript-columna de codigo primario
$edita    = 'editar';
$del      = '';


  
$cabecera =  "Identificacion,Nombre Beneficiario,Debe,Haber,Saldo"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR




$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>


  