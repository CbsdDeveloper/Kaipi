<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $id            		= $_GET['id'];
    
    $ViewFormTareaUs	= '<div class="list-group">';
    
    $sql = "select tarea,tiempo,tipotiempo ,idtarea
              from flow.wk_procesoflujo 
             where idproceso = ".$bd->sqlvalue_inyeccion($id,true)." and idtarea  <> 0   
             order by idtarea";
 
    $stmt_nivel1= $bd->ejecutar($sql);
    
 
    while ($x=$bd->obtener_fila($stmt_nivel1)){
    	
        $ViewFormTareaUs .= '<a href="#" class="list-group-item"><h5 class="list-group-item-heading" style="font-weight:550">'.trim($x['tarea']).'</h5>';
        
        $ViewFormTareaUs .=  unidades_tarea($bd,$id,$x['idtarea']);
        
        $ViewFormTareaUs .= '</a>';
 
    	
    }
 
    $ViewFormTareaUs .= '</div>'; 
    
    echo $ViewFormTareaUs ;
  //-----------------------------------------------
  
    function unidades_tarea($bd,$id,$idtarea){
        
        $sql = " SELECT  nombre
                FROM flow.view_proceso_unidad
                where idproceso = ".$bd->sqlvalue_inyeccion($id,true)." and  
                      idtarea = ".$bd->sqlvalue_inyeccion($idtarea,true)." group by nombre";
 
        
        $cadena = '';
        
        $stmt_nivelTarea= $bd->ejecutar($sql);
        
 
        while ($y=$bd->obtener_fila($stmt_nivelTarea)){
            
            $cadena .=  '<p class="list-group-item-text"> <img src="../../kimages/use_wk.png"/>'. trim($y['nombre']).'</p>';
            
        }
        
        return $cadena ;
    }  
    
?>
