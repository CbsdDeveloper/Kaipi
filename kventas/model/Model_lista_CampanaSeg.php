 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$sesion 	 =     $_SESSION['email'];
	
	$id_campana		 =     $_GET["id"];
	
	
	$Array = $bd->query_array('ven_cliente','count(*) as nn', 'id_campana='.$bd->sqlvalue_inyeccion($id_campana,true) );
 
	
	
	$ContactosCampana = utf8_encode('<div class="media">
	<div class="media-left">
	<img src="../../kimages/if_users_1902261.png" class="media-object" style="width:48px">
	</div>
	<div class="media-body">
	<h4 class="media-heading"><b>'.$Array["nn"].'</b></h4>
	<p>Contactos definidos en la campaña</p>
	</div>
	</div>
	<hr>');
	
 
	 	    
    $sql = "SELECT estado,   count(*) as nn
    	FROM ven_cliente
    	where id_campana =".$bd->sqlvalue_inyeccion($id_campana,true)."
        group by estado";
             
     $stmt = $bd->ejecutar($sql);
		
    
     $ContactosCampana .=  utf8_encode( ' <h6><b> Resumen por estados de Campaña </b></h6><ul class="list-group">');
    
 
     
     
   while ($fila=$bd->obtener_fila($stmt)){
      
       $estado = $fila['estado'];
       
       $estado = trim($fila['estado']);
       
       if ($estado == '0'){
           $nombre = 'No Confirmados';
       }elseif ($estado == '1'){
           $nombre = 'Por Verificar';
       }elseif ($estado == '2'){
           $nombre = 'Verificado';
       }elseif ($estado == '3'){
           $nombre = 'Potenciales Clientes';
       }elseif ($estado == '4'){
           $nombre = 'Interesado En espera';
       }elseif ($estado == '5'){
           $nombre = 'Interesado sin confirmar';
       }elseif ($estado == '6'){
           $nombre = 'Interesado confirmado';
       }elseif ($estado == '7'){
           $nombre = 'Seguimiento introduccion producto';
       }elseif ($estado == '9'){
           $nombre = 'No existe Informacion disponible';
       }
       
       
       $ContactosCampana .=   '<li class="list-group-item">'.$nombre.' <span class="badge">'.$fila['nn'].'</span></li>';
  
   }
   
   $ContactosCampana .=  ( ' </ul>' );
 
   //----------------------------------------
   
   $sql = "SELECT sesion,   count(*) as nn
    	FROM ven_cliente
    	where id_campana =".$bd->sqlvalue_inyeccion($id_campana,true)."
        group by sesion";
   
   $stmt = $bd->ejecutar($sql);
   
   
   $ContactosCampana .=  utf8_encode( ' <h6><b> Resumen por usuarios de Campaña </b></h6><ul class="list-group">');
 
   while ($fila1=$bd->obtener_fila($stmt)){
       
       $nombre = $fila1['sesion'];
          
       
       $ContactosCampana .=   '<li class="list-group-item">'.$nombre.' <span class="badge">'.$fila1['nn'].'</span></li>';
       
   }
   
   $ContactosCampana .=  ( ' </ul>' );
	
   
   //----------------------------------------
   
   $sql = "SELECT canton,   count(*) as nn
    	FROM ven_cliente
    	where id_campana =".$bd->sqlvalue_inyeccion($id_campana,true)."
        group by canton";
   
   $stmt = $bd->ejecutar($sql);
   
   
   $ContactosCampana .=  utf8_encode( ' <h6><b> Resumen por Ciudades de Campaña </b></h6><ul class="list-group">');
   
   while ($fila1=$bd->obtener_fila($stmt)){
       
       $nombre = $fila1['canton'];
       
       
       $ContactosCampana .=   '<li class="list-group-item">'.$nombre.' <span class="badge">'.$fila1['nn'].'</span></li>';
       
   }
   
   $ContactosCampana .=  ( ' </ul>' );
   
   
   //----------------------------------------
   
   $sql = "SELECT proceso,   count(*) as nn
    	FROM ven_cliente
    	where id_campana =".$bd->sqlvalue_inyeccion($id_campana,true)."
        group by proceso";
   
   $stmt = $bd->ejecutar($sql);
   
   
   $ContactosCampana .=  utf8_encode( ' <h6><b> Resumen gestion de Email </b></h6><ul class="list-group">');
   
   while ($fila1=$bd->obtener_fila($stmt)){
       
       $nombre = $fila1['proceso'];
       
       
       $ContactosCampana .=   '<li class="list-group-item">'.$nombre.' <span class="badge">'.$fila1['nn'].'</span></li>';
       
   }
   
   $ContactosCampana .=  ( ' </ul>' );
   
   
	echo $ContactosCampana;
?>
 
  