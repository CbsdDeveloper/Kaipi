<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$anio       = $_GET["anio"];
$id         = $_GET["idbodega"];

 
$tipo    =    $bd->retorna_tipo();



$sql ="select a.cuenta_inv as inventario, b.detalle
                 FROM view_kardex_periodo a , co_plan_ctas b
                 where   a.cuenta_inv = b.cuenta and
	                     a.idbodega = ".$bd->sqlvalue_inyeccion( $id, true)." and
                         a.anio::character varying::text = b.anio
                  group by a.cuenta_inv, b.detalle  ";
 

$stmt_lista = $bd->ejecutar($sql);


echo '<div class="col-md-12"> <h4>Carga Inicial para el periodo '.$anio.'</h4>';

while ($x=$bd->obtener_fila($stmt_lista)){
    
    $cuenta = trim($x['inventario']);
    $detalle = trim($x['detalle']);
    
    
    $etiqueta = $cuenta.' '.$detalle;
    
    echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';
    
    movimiento_compras($bd,$obj,$id,$cuenta,$tipo,$anio);
    
}

echo '</div> ';


function movimiento_compras( $bd,$obj,$id,$cuenta,$tipo,$anio){
    
 
    
    $sql1 = "SELECT  cuenta_inv,cuenta_gas,idproducto|| ' ' as id,producto,unidad,cantidad,costo, total
    FROM view_inv_movimiento_det
    where  anio = ".$bd->sqlvalue_inyeccion($anio ,true).' and
    idbodega = '.$bd->sqlvalue_inyeccion($id ,true)."  and
    cuenta_inv = ".$bd->sqlvalue_inyeccion($cuenta ,true)."  and
    trim(transaccion) = 'carga inicial'
    order by cuenta_inv,producto";
    
    
    
    $stmt2 = $bd->ejecutar($sql1);
    
    $obj->table->table_basic_js($stmt2, // resultado de la consulta
    $tipo,      // tipo de conexoin
    '',         // icono de edicion = 'editar'
    '',			// icono de eliminar = 'del'
    '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
    "Cuenta,Gasto, Codigo,Articulo,Unidad,Saldo, Costo, Total" , // nombre de cabecera de grill basica,
    '12px',      // tama�o de letra
    'id'         // id
    );
    
 
    
}
 
 
  
    

?>
 
  