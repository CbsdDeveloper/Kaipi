<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   = 	new Db;
$registro = $_SESSION['ruc_registro'];
$idbodega = $_SESSION['idbodega'];
$bd->conectar($_SESSION['us'], '', $_SESSION['ac']);

$sql = "SELECT   (producto ) as producto, idproducto
				  FROM web_producto
				  where estado = 'S' and idcategoria in (83,84) and  tipo = 'B'  and saldo > 0 and 
                        registro = " . $bd->sqlvalue_inyeccion($registro, true) . " AND 
                        idbodega = " . $bd->sqlvalue_inyeccion($idbodega, true) . "
                  order by producto";

$articulo = array();
$stmt = $bd->ejecutar($sql);

$tabla = '<table class="table table-sm table-hover" id="tablaInventario">
  <thead>
    <tr>
      <th scope="col">Producto</th>
      <th scope="col">Acción</th>
    </tr>
  </thead>
  <tbody>
  #FILAS
  </tbody>
</table>';

$filas='';
while ($x = $bd->obtener_fila($stmt)) {
  $filas .= '<tr>
    <td scope="row">'.trim($x['producto']).'</td>
    <td><a href="#" class="btn btn-warning btn-sm" role="button" onClick="InsertaProductoTabla('.trim($x['idproducto']).')" > <span class="glyphicon glyphicon-plus"></span> Agregar</a></td>
  </tr>';
	// $cnombre =  trim($x['producto']);
	// $articulo[] =  $cnombre;
}
// $n = count($articulo);
// if ($n ==  0) {
// 	$articulo[] =  'NO EXISTE';
// }
// echo json_encode($articulo);
$tabla = str_replace("#FILAS", $filas, $tabla);
echo $tabla;

pg_free_result($stmt);
