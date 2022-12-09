 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$sesion 	 =     $_SESSION['email'];
	
 	
	
	$Array = $bd->query_array('ven_cliente','count(*) as nn', 'id_campana<>'.$bd->sqlvalue_inyeccion(0,true) );
 
	
	
	$TotalCampana = utf8_encode('<div class="media">
	<div class="media-left">
	<img src="../../kimages/if_user_group_50709.png" class="media-object" style="width:48px">
	</div>
	<div class="media-body">
	<h4 class="media-heading"><b>'.$Array["nn"].'</b></h4>
	<p>Contactos definidos en la campaña</p>
	</div>
	</div>
	<hr>');
	
	//----------------------------------------
	
	
	$sql = "SELECT id_campana, medio, titulo, contactos ,estado,publica
    	FROM ven_campana
        WHERE  publica="."'S'";
	
	$stmt = $bd->ejecutar($sql);
	
	 	
	
	$TotalCampana .=  utf8_encode( ' <h6><b> Resumen por Campañas </b></h6><ul class="list-group">');
	
	while ($fila1=$bd->obtener_fila($stmt)){
	    
	    $nombre = $fila1['titulo'].' - '.$fila1['medio'];
	    
	    $contactos = $fila1['contactos'];
	    
	    if(empty($fila1['contactos'])){
	        $Ar = $bd->query_array('ven_cliente','count(*) as nn', 'id_campana='.$bd->sqlvalue_inyeccion($fila1['id_campana'],true) );
	        $contactos = $Ar['nn'];
	        //-----------------------------------------------
	        $sql = "UPDATE ven_campana
				    SET contactos = ".$bd->sqlvalue_inyeccion($contactos,true). " 
				  where id_campana=".$bd->sqlvalue_inyeccion($fila1['id_campana'],true) ;
	        
	        $bd->ejecutar($sql);
	        
	    }
	    
	    $TotalCampana .=   '<li class="list-group-item">'.$nombre.' <span class="badge">'.$contactos.'</span></li>';
	    
	}
	
	$TotalCampana .=  ( ' </ul>' );
 
   //----------------------------------------
	
 
   $sql = "SELECT medio,  sum(contactos) as nn
    	FROM ven_campana 
        group by medio";
   
   $stmt = $bd->ejecutar($sql);
   
   
   $TotalCampana .=  utf8_encode( ' <h6><b> Resumen por tipos de Campaña </b></h6><ul class="list-group">');
 
   while ($fila1=$bd->obtener_fila($stmt)){
       
       $nombre = $fila1['medio'];
          
       
       $TotalCampana .=   '<li class="list-group-item">'.$nombre.' <span class="badge">'.$fila1['nn'].'</span></li>';
       
   }
   
   $TotalCampana .=  ( ' </ul>' );
	
  
	echo $TotalCampana;
?>
 
  