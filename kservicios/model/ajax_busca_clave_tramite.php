<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$tipo       = $bd->retorna_tipo();

$documento  = trim($_GET['id']).'%';

$doc_nombre = trim($_GET['doc_nombre']).'%';

$lon1        = strlen(trim($_GET['id'])) ;
$lon2        = strlen(trim($_GET['doc_nombre'])) ;


if ( ($lon1  + $lon2) > 0 ) {
  
    if ( $lon1  > 0  ){
       $condicion =  "documento like ".$bd->sqlvalue_inyeccion($documento,true) .' and estado='.$bd->sqlvalue_inyeccion('E',true) ;
    }else{
       $condicion =  "contribuyente like ".$bd->sqlvalue_inyeccion($doc_nombre,true) .' and estado='.$bd->sqlvalue_inyeccion('E',true) ;
    }

            $stmt1      =  $bd->query_cursor(
                'rentas.view_ren_movimiento_web ', // tabla
                "id_par_ciu || ' ' as id_par_ciu,contribuyente,fecha,detalle, apagar",               
                $condicion , // condicion
                '',                      // grupo
                'documento',            // orden   
                '10',                  // limit
                '0',                      // offet
                '0'                      // debug 0 | 1 ver sql
                );
                
            
                $obj->table->table_basic_js($stmt1, // resultado de la consulta
                $tipo,      // tipo de conexoin
                'seleccion',         // icono de edicion = 'editar' / seleccion
                '',			// icono de eliminar = 'del'
                'asignar-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                "Ciu,Contribuyente,Fecha,Detalle,Total",  // nombre de cabecera de grill basica,
                '11px',      // tamaño de letra
                'tablaBasica'         // id
            );
   
 }

?>