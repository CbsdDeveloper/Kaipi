<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$fecha           = $_GET['fecha'];   // VARIABLE DE ENTRADA CODIGO DE BITACORA

$sesion 	     = trim($_SESSION['email']);

$tipo 		     = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES

$hoy            = date('Y-m-d');

$datos = $bd->__user($sesion);

$idprov = $datos['idprov'];


$sql = "select desde || ' ' || hora_desde as desde, hasta ||' ' || hora_saluda as hora,destino,mo_salida,registro
        FROM  hoja_ruta
            where registro = ".$bd->sqlvalue_inyeccion($fecha, true). " and
                  idprov=".$bd->sqlvalue_inyeccion($idprov, true). "
            order by desde desc";

 

$datos_titulo    = $bd->__user($sesion);

$unidad          = $datos_titulo['unidad'];
$completo        = $datos_titulo['completo'];

$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO


$evento   = '';
$edita    = '';
$del      = '';


/*
 entrada:
 resultado =  resulta do del sql
 tipo      =  tipo de conexion
 editar    =  evento editar / seleccionar
 del       =  evento eliminar / del
 evento    =  nombre funcion javascript separada - index de la variable clave
 cabecera  = columnas
 */

 

$cabecera =  "DESDE,HASTA,ACTIVIDAD,DESCRIPCION ,REGISTRO"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR


$tema       = '<h3><b>ACTIVIDADES DIARIAS</b></h3>';
$titulo_ref = '<b>'.$completo.'<br>'.$hoy .'</b>';

titulo($obj,$sesion,$unidad ,$tema,$titulo_ref);

echo '<h4><b>'.$datos_titulo['completo'] .'<br>'.$datos_titulo['cargo'].'<br>'.$datos_titulo['cedula'].'</h4></b>';


$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera,'12');



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;

//------------------------------------------------------------------
function titulo($obj,$sesion,$unidad ,$titulo,$titulo_ref){
    
    
    $obj->table->titulo_cab( $unidad ,$titulo,$titulo_ref) ;
    
    
    
}


?>


  