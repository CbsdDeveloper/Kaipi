<?php

session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
$id_rubro     = $_GET['id'] ;

$cadena = " || ' ' " ;

$sql = 'SELECT a.id_matriz_var '.$cadena.' as id,
                    a.catalogo as "Catalogo", a.tipo_cat as "Es Catalogo Relacional",
                    a.sesion as "Imprime"
 			FROM rentas.ren_servicios_var a
			WHERE    a.idrubro='.$bd->sqlvalue_inyeccion($id_rubro, true).'
			order by 1';

 

$resultado	 =  $bd->ejecutar($sql);

$tipo 		 = $bd->retorna_tipo();

$enlaceModal   ='myModalServicios';

$evento        = 'go_matriz-go_visor' ;

$obj->grid->KP_grilla_detalle_modal($resultado,$tipo,'id', $enlaceModal,$evento,'g_matriz');
 
$div_mistareas = 'ok';

echo $div_mistareas;
?>

  