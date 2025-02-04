<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 



 
 
$bd	   =	new Db;
    

    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
    
    $anio       =  $_SESSION['anio'];



    
 
    $sqlO2= "select unidad_poa,  round(coalesce (sum(avance),0)/COUNT(*),2) as meta
            FROM planificacion.view_tarea_poa
            where anio = ".$bd->sqlvalue_inyeccion($anio,true)." 
            group by unidad_poa
            order by 2 desc limit 10"; 
    
            
        $resultado  = $bd->ejecutar($sqlO2);

        $category = array();
        $series1  = array();


        $category['name'] ='Unidad';
        $series1['name'] ='Meta';



        while ($r=$bd->obtener_fila($resultado)){

        $items = trim($r['unidad_poa']);

        $category['data'][] = $items;
        $series1['data'][] =  $r['meta'];




        }

        $result = array();

        array_push($result,$category);
        array_push($result,$series1);



print json_encode($result, JSON_NUMERIC_CHECK);


 
 
      
   
 
  ?> 
								
 
 
 