<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     = 	new objects;
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$banio         = $_GET['banio'];   
$idprov        = $_GET['idprov'];   
$nombre        = $_GET['nombre'];  
$reporte       = trim($_GET['tipo']);  


$tipo 		     = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
 

echo ' <h4><b>'.$nombre.'</b>  </h4>';

if ( $reporte == '1'){  
    
    $sql = "select  id_rol, novedad, ingreso
            from view_rol_impresion
            where idprov = ".$bd->sqlvalue_inyeccion(trim($idprov), true)." and
                   anio=".$bd->sqlvalue_inyeccion(trim($banio), true). "  and
                   tipo=".$bd->sqlvalue_inyeccion(trim('Ingresos'), true). " and
                   nombre=".$bd->sqlvalue_inyeccion(trim($nombre), true). "
        order by 1";
    
    
     $cabecera =  "Codigo,Novedad,Ingresos"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
    
}else{  
    
    $sql = "select  id_rol, novedad, descuento
            from view_rol_impresion
            where idprov = ".$bd->sqlvalue_inyeccion(trim($idprov), true)." and
                   anio=".$bd->sqlvalue_inyeccion(trim($banio), true). "  and
                   tipo=".$bd->sqlvalue_inyeccion(trim('Descuentos'), true). " and
                   nombre=".$bd->sqlvalue_inyeccion(trim($nombre), true). "
        order by 1";
    
    
    $cabecera =  "Codigo,Novedad,Descuento"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
}



 

$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO


 
$evento   = " ";  // nombre funcion javascript-columna de codigo primario
$edita    = ' ';
$del      = '';
 


$obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);



$DetalleRequisitos= 'ok';

echo $DetalleRequisitos;



?>


  