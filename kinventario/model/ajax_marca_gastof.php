<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 
$total     = $_GET['total'];

 
$id_importacion = $_GET['id_importacion'];


 
$sql = 'SELECT id_importacionfacitem,   cantidad, costo,
	                         costo  as parcial	,
                    		costo + advalorem + infa +  salvaguardia + aranceles as costo_importa,
                    		porcentaje, costo1, costo2, costoitem
            FROM inv_importaciones_fac_item
            where id_importacion = '.$bd->sqlvalue_inyeccion($id_importacion,true);


$resultado1  = $bd->ejecutar($sql);

while ($fetch=$bd->obtener_fila($resultado1)){
    
    $porcentaje  = ($fetch['porcentaje'] / 100) * $total;
    
    $costofinanciero = $porcentaje / $fetch['cantidad'] ;
    
    $id           = $fetch['id_importacionfacitem'] ;
    $costo1       = $fetch['costo1'] ;
    $costoitem    = $costo1 + $costofinanciero;
    
    $sql = " UPDATE inv_importaciones_fac_item
							              SET 	costo2      =".$bd->sqlvalue_inyeccion(round($costofinanciero,2), true).",
											    costoitem  =".$bd->sqlvalue_inyeccion(round($costoitem,2), true)."
							      WHERE id_importacionfacitem=".$bd->sqlvalue_inyeccion($id, true);
    
    $bd->ejecutar($sql);
    
    $DistribuyeGasto = 'Dato actualizado correctamente';
    

    
}
 

echo $DistribuyeGasto; 



?>