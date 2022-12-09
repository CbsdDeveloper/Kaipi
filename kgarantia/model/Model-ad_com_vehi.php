<?php
session_start( );

require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$obj   = 	new objects;
$bd	   = new Db;

$vchofer = strtoupper(trim($_GET["vchofer"]));
$vcarro  = strtoupper(trim($_GET["vcarro"]));
$vorden  = trim($_GET["vorden"]);

$tipo   =  $bd->retorna_tipo();

$val1    = strlen($vchofer);
$val2    = strlen($vcarro);
 
$year    = date('Y');
$mes     = intval(date('m'));
$mes     = intval(date('m')) - 1; 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$filtro =  "placa = ".$bd->sqlvalue_inyeccion('-',true);

if ( $val1 > 3){
    $filtro =  "chofer like ".$bd->sqlvalue_inyeccion($vchofer.'%',true). " and 
                anio=".$bd->sqlvalue_inyeccion($year,true) ;
}

if ( $val2 > 3){
    $filtro =  "placa like ".$bd->sqlvalue_inyeccion($vcarro.'%',true). " and 
    anio=".$bd->sqlvalue_inyeccion($year,true) ;
}

if ($vorden > 1){
    $filtro =  "id_orden = ".$bd->sqlvalue_inyeccion($vorden,true). " and 
    anio=".$bd->sqlvalue_inyeccion($year,true) ;
}

        $stmt1=  $bd->query_cursor(
            'adm.view_adm_orden',                           // tabla
            "id_orden,  fecha_orden, motivo_traslado, origen, destino, chofer, descripcion,placa_ve",  // campos
            $filtro,                                     // condicion
            '',                                          // grupo
            'id_orden desc',                             // orden   
            '10',                                        // limit
            '0',                                        // offet
            '0'                                         // debug 0 | 1 ver sql
            );
    
                
            $obj->table->table_basic_js($stmt1, // resultado de la consulta
            $tipo,                             // tipo de conexoin
            'seleccion',                      // icono de edicion = 'editar' - seleccion
            '',			                     // icono de eliminar = 'del'
            'Enlazar-0' ,            // evento funciones parametro Nombnre funcion - codigo primerio
            "Orden, Fecha, Motivo, Origen, Destino, Funcionario, Descripcion, Nro. Placa" , // nombre de cabecera de grill basica,
            '10px',                       // tamaño de letra
            'id'                         // id
            );

  
?>
  
  