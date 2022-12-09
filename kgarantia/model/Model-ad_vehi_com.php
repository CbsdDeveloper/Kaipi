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


$filtro =  "placa_ve = ".$bd->sqlvalue_inyeccion('-',true);

if ( $val1 > 3){
    $filtro =  "chofer like ".$bd->sqlvalue_inyeccion($vchofer.'%',true). " and 
                anio=".$bd->sqlvalue_inyeccion($year,true) ;
}

if ( $val2 > 3){
    $filtro =  "placa_ve like ".$bd->sqlvalue_inyeccion($vcarro.'%',true). " and 
    anio=".$bd->sqlvalue_inyeccion($year,true) ;
}

if ($vorden > 1){
    $filtro =  "id_combus = ".$bd->sqlvalue_inyeccion($vorden,true). " and 
    anio=".$bd->sqlvalue_inyeccion($year,true) ;
}
 

        $stmt1=  $bd->query_cursor(
            'adm.view_comb_vehi',                           // tabla
            "id_combus  || ' ' id_combus,  fecha, referencia || ' ' as Comprobante,descripcion, placa_ve,chofer_actual,tipo_comb, cantidad, costo,total_consumo",  // campos
            $filtro,                                     // condicion
            '',                                          // grupo
            'id_combus desc',                             // orden   
            '10',                                        // limit
            '0',                                        // offet
            '0'                                         // debug 0 | 1 ver sql
            );
    
                
            $obj->table->table_basic_js($stmt1, // resultado de la consulta
            $tipo,                             // tipo de conexoin
            'seleccion',                      // icono de edicion = 'editar' - seleccion
            '',			                     // icono de eliminar = 'del'
            'Enlazar-0' ,            // evento funciones parametro Nombnre funcion - codigo primerio
            "Orden, Fecha, Comprobante, Vehiculo,Placa, Funcionario,Combustible,Cantidad,Costo,Total" , // nombre de cabecera de grill basica,
            '10px',                       // tamaño de letra
            'id'                         // id
            );

  
?>
  
  