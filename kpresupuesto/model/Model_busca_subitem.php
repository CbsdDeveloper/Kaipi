<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
    
$tipo            = $_GET['tipo'];
$clasificador    = trim($_GET['item']);
 
 
if ( $tipo == 'I'){
    $tipo_dato = 'ingreso';
    $nivel = 4;
}else{
    $tipo_dato = 'gasto';
    $nivel = 5;
}

$sql1 = "SELECT   codigo, detalle 
        FROM presupuesto.pre_catalogo
        WHERE categoria = 'clasificador' and 
              subcategoria = ".$bd->sqlvalue_inyeccion($tipo_dato,true). " and
              codigo = ".$bd->sqlvalue_inyeccion($clasificador,true). " and 
            nivel = ".$bd->sqlvalue_inyeccion($nivel,true). "   and 
        estado = 'S' order by 1 asc";
 

$stmt1 = $bd->ejecutar($sql1);

 
$detalle ='' ;

while ($fila=$bd->obtener_fila($stmt1)){
    
    $detalle        =  trim($fila['detalle']);
    $clasificador   = trim($fila['codigo']);
    
}


$anio = $_SESSION['anio'];

$yy= $bd->query_array('presupuesto.pre_gestion',
                      'max(subitem) as nn', 
                      'anio = '.$bd->sqlvalue_inyeccion($anio,true).' and clasificador='.$bd->sqlvalue_inyeccion($clasificador,true)
                    );

if ($yy['nn']){
    $id = $yy['nn']  + 1 ;
    $clasificador = '';
} else {
    $id = 1 ;
}

$input = str_pad($id, 3, "0", STR_PAD_LEFT);

$comprobante_partida = $clasificador.$input ;

 
echo json_encode( array(
                        "a"=>trim($comprobante_partida), 
                        "b"=> trim($detalle) )  
                );



?>
