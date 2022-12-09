<?php   
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $anio       =  $_SESSION['anio'];
    
    
    $qquery =  array(
        array( campo => 'funcion',   valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'partida',   valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'clasificador',   valor => '-',  filtro => 'N',   visor => 'S'),
        array( campo => 'disponible',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'anio',       valor =>$anio,  filtro => 'S',   visor => 'N')
    );
    
    
    $resultado = $bd->JqueryCursorVisor('presupuesto.view_gasto_nomina_grupo',$qquery );
    
    while ($fetch=$bd->obtener_fila($resultado)){
        
        $output[] = array (
            $fetch['funcion'],$fetch['partida'],$fetch['detalle'],
            $fetch['clasificador'],$fetch['disponible'] 
        );
    }
    
    echo json_encode($output);
    
 
 
 
 ?>