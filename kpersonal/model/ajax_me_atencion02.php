<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

// VARIABLE DE ENTRADA CODIGO DE BITACORA

$id_atencion       = $_GET['id_atencion'];  

// TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES

$tipo 		     = $bd->retorna_tipo(); 


$sql = "select  id_atencion_per,pe_tipo, pe_detalle
            from medico.ate_medica_personal
            where id_atencion = ".$bd->sqlvalue_inyeccion($id_atencion, true).
            " order by id_atencion_per desc";

$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO


$datos = $bd->query_array('medico.ate_medica','estado', 'id_atencion='.$bd->sqlvalue_inyeccion($id_atencion,true));


$evento   = "goToURL_personal-0";  // nombre funcion javascript-columna de codigo primario
$edita    = 'editar';
$del      = 'del';


if ( trim($datos['estado']) == 'autorizado'){
    $evento = '';
    $edita    = '';
    $del      = '';
    
}

/*
 entrada:
 resultado =  resulta do del sql
 tipo      =  tipo de conexion
 editar    =  evento editar / seleccionar
 del       =  evento eliminar / del
 evento    =  nombre funcion javascript separada - index de la variable clave
 cabecera  = columnas
 */

$cabecera =  "Codigo,Tipo,Antecedente"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR




$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>