<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id_asiento = $_GET['id'];

$estado     = $_GET['estado'];

$ruc        = $_SESSION['ruc_registro'];

$id_importacion = $_GET['id_importacion'];



$sqlEdit = "UPDATE co_asiento
              SET marca = ".$bd->sqlvalue_inyeccion($estado ,true)."
                    where id_asiento = ".$bd->sqlvalue_inyeccion($id_asiento ,true).' and
                          idmovimiento='.$bd->sqlvalue_inyeccion($id_importacion ,true);
 

$bd->ejecutar($sqlEdit);



$sql = "SELECT  sum(a.debe)  as monto
                    FROM view_diario a
                    join co_plan_ctas b on  a.idmovimiento = ". $bd->sqlvalue_inyeccion($id_importacion , true)." and
                         a.tipo='M' and
                         a.debe > 0 and
                         a.base is null and
                         a.registro = ". $bd->sqlvalue_inyeccion(trim($ruc) , true)."  and
                         a.cuenta= b.cuenta and
                    	 a.registro = b.registro and b.tipo_cuenta <> 'I' and 
                          a.marca=  ". $bd->sqlvalue_inyeccion(trim('S') , true) ;

 

$sql    = $bd->ejecutar($sql);
$datos1 = $bd->obtener_array( $sql);

$total_gasto_resumen     = $datos1["monto"];

echo $total_gasto_resumen;

?>