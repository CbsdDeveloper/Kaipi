<?php

session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$idasiento     = $_GET['id'] ;

$cadena = " || ' ' " ;

$sql = 'SELECT a.id_rubro_var '.$cadena.' as id, a.etiqueta, a.columna '.$cadena.' as columna,
                    a.nombre_variable as "Variable",
                    a.imprime as "Imprime"
 			FROM rentas.ren_rubros_var a
			WHERE    a.id_rubro='.$bd->sqlvalue_inyeccion($idasiento, true).'
			order by 1';

 


$resultado	 =  $bd->ejecutar($sql);

$tipo 		 = $bd->retorna_tipo();

$enlaceModal   ='myModalAux';

$evento        = 'go_modal' ;

$obj->grid->KP_grilla_detalle_modal($resultado,$tipo,'id', $enlaceModal,$evento,'g_detalle');
 
$div_mistareas = 'ok';

echo $div_mistareas;
?>

  