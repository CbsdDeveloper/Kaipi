<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     =  new objects;
$bd    =    new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


// $bitacora        = $_GET['bitacora'];   // VARIABLE DE ENTRADA CODIGO DE BITACORA

$tipo            = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES


$sql = "select identificacion, nombre,      anio, mes, count(*) as dias
from view_nom_marcacion_fecha
group by identificacion, nombre,     anio, mes
order by nombre";
  
$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO

 
$evento   = "goToURL_marca-0";  // nombre funcion javascript-columna de codigo primario
$edita    = 'editar';
$del      = '';

 

$cabecera =  "Identificacion, Funcionario,Periodo,Mes, Nro.Dias"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
 

    /*
    entrada:
            resultado =  resulta do del sql
            tipo      =  tipo de conexion
            editar    =  evento editar / seleccionar
            del       =  evento eliminar / del
            evento    =  nombre funcion javascript separada - index de la variable clave
            cabecera  = columnas
    */

$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);

$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>