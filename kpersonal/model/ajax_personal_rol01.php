<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$banio        = $_GET['banio'];   
$idprov        = $_GET['idprov'];   

$tipo 		     = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES



$sql = "select  nombre, sum (ingreso) ingreso
            from view_rol_impresion
            where idprov = ".$bd->sqlvalue_inyeccion(trim($idprov), true).' and
                   anio='.$bd->sqlvalue_inyeccion(trim($banio), true). " and
                   tipo = 'Ingresos'
            group by nombre
        order by 1";



$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO



$evento   = "goToDeta1-0";  // nombre funcion javascript-columna de codigo primario
$edita    = 'editar';
$del      = '';


$cabecera =  "Resumen Ingresos, Total"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR

echo '<div class="col-md-6"> ';

$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);

echo '  </div>';


 

$sql = "select  nombre, sum (descuento) descuento
            from view_rol_impresion
            where idprov = ".$bd->sqlvalue_inyeccion(trim($idprov), true).' and 
                   anio='.$bd->sqlvalue_inyeccion(trim($banio), true). "  and tipo = 'Descuentos'
            group by nombre
        order by 1";

 

$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO


 
$evento   = "goToDeta2-0";  // nombre funcion javascript-columna de codigo primario
$edita    = 'editar';
$del      = '';
 

$cabecera =  "Resumen Descuentos, Total"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR



echo '<div class="col-md-6"> ';

$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);


echo '  </div>';


 


?>


  