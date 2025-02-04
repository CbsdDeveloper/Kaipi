<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$bitacora        = $_GET['bitacora'];   // VARIABLE DE ENTRADA CODIGO DE BITACORA

$tipo 		     = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES

 

    $sql = "select  id_bom_acti,tipo_actividad,actividad_d,fecha_creacion,tiempo
            from bomberos.bombero_actividad
            where id_bita_bom = ".$bd->sqlvalue_inyeccion($bitacora, true).
            " order by id_bom_acti desc";
  
$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO

$datos = $bd->query_array('bomberos.bitacora_bom','estado', 'id_bita_bom='.$bd->sqlvalue_inyeccion($bitacora,true));

$evento   = "goToURL_bomberos_actividad(-0";  // nombre funcion javascript-columna de codigo primario
$edita    = 'editar';
$del      = 'del';

if ( trim($datos['estado']) == 'autorizado'){
    $evento = '';
    $edita    = '';
    $del      = '';
    
}

$cabecera =  "Codigo,Novedad,Actividad desarrollada,Creado,Hora"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
 

    /*
    entrada:
            resultado =  resulta do del sql
            tipo      =  tipo de conexion
            editar    =  evento editar / seleccionar
            del       =  evento eliminar / del
            evento    =  nombre funcion javascript separada - index de la variable clave
            cabecera  = columnas
    */

$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);

$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>


  