<?php
session_start( );

require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$obj   = 	new objects;
$bd	   = new Db;

$codigo =  $_GET["codigo"];
$tipo   = trim($_GET["tipo"]);
 
$tipodb   =  $bd->retorna_tipo();

 
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 
if ( $tipo == 'combustible'){
    $filtro =  "id_combus = ".$bd->sqlvalue_inyeccion($codigo,true) ;
}else{
    $filtro =  "id_orden = ".$bd->sqlvalue_inyeccion($codigo,true) ;
}
 

        $stmt1=  $bd->query_cursor(
            'adm.view_comb_orden',                           // tabla
            " id_orden_comb, referencia || ' ' as referencia,id_orden || ' '  as id_orden ,motivo_traslado,chofer,descripcion,placa,tipo_comb, cantidad, costo, total_consumo ",  // campos
            $filtro,                                     // condicion
            '',                                          // grupo
            'id_orden_comb desc',                             // orden   
            '10',                                        // limit
            '0',                                        // offet
            '0'                                         // debug 0 | 1 ver sql
            );
    
                
            $obj->table->table_basic_js($stmt1, // resultado de la consulta
            $tipodb,                             // tipo de conexoin
            '',                      // icono de edicion = 'editar' - seleccion
            '',			                     // icono de eliminar = 'del'
            'Del_Enlace-0' ,            // evento funciones parametro Nombnre funcion - codigo primerio
            "Ref, Orden Combustibe,Nro.Movilizacion,Motivo,Chofer,Vehiculo,placa,Combustible, Cantidad, Costo, Total Consumo" , // nombre de cabecera de grill basica,
            '11px',                       // tamaño de letra
            'idMatriz'                         // id
            );

  
?>
  
  