<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];

$Q_IDPERIODO = $_GET['Q_IDPERIODO'];

 
_Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO);





//-------------------------------------------------------------------------------------
//---------------------------------------------------------------------------

function _Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO){
 
    
    $sqlO1= ' SELECT   responsable ,nombre_funcionario,count(*) as nn
 FROM planificacion.view_tarea_poa
 where  id_departamento ='.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
        anio='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' 
 group by responsable ,nombre_funcionario order by 2';

 
      
    $stmt_ac = $bd->ejecutar($sqlO1);
    
     
 
echo '<div class="list-group"> <a href="#" class="list-group-item active">Responsables</a>';

    while ($x=$bd->obtener_fila($stmt_ac)){
        
        $total_actividad =  $x['nn'] ;
        
        $actividad      =  trim($x['nombre_funcionario']);
        
        $responsable    =  trim($x['responsable']);
       
        $evento =  '<a href="#" onClick="VisorObjetivosUserTar('."'".$responsable."'".')"><b>'.$actividad.'</b></a>';

        echo '<li class="list-group-item">'.$evento.'<span class="badge">'.$total_actividad.'</span>'.'</li>';
 
       
    }
    
     
    echo '</ul>';
 
    
    
    
}


?>
