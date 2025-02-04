<?php
session_start( );

require '../../kconfig/Db.class.php';    


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$fuente          = $_GET['fuente'];
$clasificador    = $_GET['clasificador'];
$actividad       = $_GET['actividad'];
$programa        = $_GET['programa'];

 
$anio = $_SESSION['anio'];

if ( $actividad == '-'){
    $qactividad = '';
}else{
    $qactividad =  ' actividad = '.$bd->sqlvalue_inyeccion($actividad,true) .' and ';
}

if ( $programa == '-'){
    $qprograma = '';
}else{
    $qprograma = ' funcion = '.$bd->sqlvalue_inyeccion($programa,true) .' and ';
}

$sql1 = "SELECT partida,  clasificador  || ' '  || detalle  as nombre
        FROM presupuesto.pre_gestion
        where tipo =  ".$bd->sqlvalue_inyeccion('G',true) .' and
        	  fuente = '.$bd->sqlvalue_inyeccion($fuente,true) .' and
        	  activo = '.$bd->sqlvalue_inyeccion('S',true) .' and
        	  '.$qactividad .$qprograma.' 
        	  grupo =  '.$bd->sqlvalue_inyeccion($clasificador,true) .' and
        	  disponible > 0 AND 
        	  anio ='.$bd->sqlvalue_inyeccion($anio,true) .' order by clasificador asc';
        

$sql1 = "SELECT partida,  subitem  || '  '  || detalle  as nombre
        FROM presupuesto.pre_gestion
        where tipo =  ".$bd->sqlvalue_inyeccion('G',true) .' and
        	  fuente = '.$bd->sqlvalue_inyeccion($fuente,true) .' and
        	  activo = '.$bd->sqlvalue_inyeccion('S',true) .' and
        	  '.$qactividad .$qprograma.'
        	  grupo =  '.$bd->sqlvalue_inyeccion($clasificador,true) .' and
        	  disponible > 0 AND
        	  anio ='.$bd->sqlvalue_inyeccion($anio,true) .' order by subitem asc';



$sql1 = "SELECT partida,  clasificador  || ' '  || detalle  as nombre
        FROM presupuesto.pre_gestion
        where tipo =  ".$bd->sqlvalue_inyeccion('G',true) .' and
        	  fuente = '.$bd->sqlvalue_inyeccion($fuente,true) .' and
        	  activo = '.$bd->sqlvalue_inyeccion('S',true) .' and
        	  '.$qactividad .$qprograma.'
        	  grupo =  '.$bd->sqlvalue_inyeccion($clasificador,true) .' and
         	  anio ='.$bd->sqlvalue_inyeccion($anio,true) .' order by clasificador asc';


$sql1 = "SELECT partida,  subitem  || '  '  || detalle  as nombre
        FROM presupuesto.pre_gestion
        where tipo =  ".$bd->sqlvalue_inyeccion('G',true) .' and
        	  fuente = '.$bd->sqlvalue_inyeccion($fuente,true) .' and
        	  activo = '.$bd->sqlvalue_inyeccion('S',true) .' and
        	  '.$qactividad .$qprograma.'
        	  grupo =  '.$bd->sqlvalue_inyeccion($clasificador,true) .' and
         	  anio ='.$bd->sqlvalue_inyeccion($anio,true) .' order by subitem asc';



$stmt1 = $bd->ejecutar($sql1);

echo '<option value="-"> [ Seleccione Partida ] </option>';


while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['partida'].'">'.$fila['nombre'].'</option>';
    
}





?>
