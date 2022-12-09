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

 

$sql = "select  id_rol,novedad ,sum(ingreso) ingreso, sum(descuento) as descuento, sum(ingreso) - sum(descuento) as apagar
            from view_rol_impresion
            where idprov = ".$bd->sqlvalue_inyeccion(trim($idprov), true).' and 
                   anio='.$bd->sqlvalue_inyeccion(trim($banio), true). " 
            group by id_rol,novedad
        order by 1";

 

$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO


 
$evento   = "goToRol-0";  // nombre funcion javascript-columna de codigo primario
$edita    = 'editar';
$del      = '';
 

$cabecera =  "Codigo,Novedad,Ingresos, Descuentos, A pagar"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR

$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>


  