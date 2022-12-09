<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$anio       = $_SESSION['anio'];
$cuenta     = trim($_GET['id']);
$tipo       = trim($_GET['tipo']);
$partida    = trim($_GET['partida']);
 


if ( $tipo == 'partida'){
    
      $item =  substr($cuenta, 0,6).'%';
         
        $sql1 = "SELECT cuenta as codigo, ' [ ' || cuenta || ' ] '  || detalle   as nombre
            FROM co_plan_ctas
            where credito like  ".$bd->sqlvalue_inyeccion($item,true) ." and  univel ='S' and estado ='S' and 
                  anio = ".$bd->sqlvalue_inyeccion($anio,true).' order by 1' ;
    
         
}

if ( $tipo == 'cuenta'){
     
    $sql1 = "SELECT cuenta as codigo, ' [ ' || cuenta || ' ] '  || detalle   as nombre
            FROM co_plan_ctas
            where credito =   substring('".$partida."',1,2) and 
                  partida_enlace ='-' and 
                  univel ='S' and estado ='S' and
                  anio = ".$bd->sqlvalue_inyeccion($anio,true).' order by 1' ;
    
    echo '<option value="-"> [ 0. Seleccione catalogo ] </option>';
 
}    


if ( $tipo == 'partida_visor'){
    
    $cuenta     = trim($_GET['cuenta']);
    
    $sql1 = "SELECT cuenta as codigo, ' [ ' || cuenta || ' ] '  || detalle   as nombre
            FROM co_plan_ctas
            where cuenta = ".$bd->sqlvalue_inyeccion($cuenta,true)." and
                  univel ='S' and estado ='S' and
                  anio = ".$bd->sqlvalue_inyeccion($anio,true).' order by 1' ;
    
    
    
}  
 
 
$stmt1 = $bd->ejecutar($sql1);
 


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.$fila['nombre'].'</option>';
    
}



?>
								
 
 
 