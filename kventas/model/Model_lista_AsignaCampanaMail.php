 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$sesion 	 =     trim($_SESSION['email']);
	
	$id			 =     $_GET["id"];
	
	$estado		 =     trim($_GET["estado"]);
	
	
	if ( $estado == '1'){
	    
	    $sql = "SELECT idvencliente,   proceso, medio, sesion, detalle, acceso, fecha, id_campana
            FROM  ven_cliente
            where id_campana= 0 and sesion =".$bd->sqlvalue_inyeccion($sesion,true);
	} 
	
	if ( $estado == '2'){
	    $sql = "SELECT idvencliente,   proceso, medio, sesion, detalle, acceso, fecha, id_campana
            FROM  ven_cliente
            where id_campana= ".$bd->sqlvalue_inyeccion($id,true)." and 
                  estado= ".$bd->sqlvalue_inyeccion('1',true)." and 
                  sesion =".$bd->sqlvalue_inyeccion($sesion,true);
	    
	}
	 	    
  
             
     $stmt = $bd->ejecutar($sql);
		
     
     
  $i = 0;
  
   while ($fila=$bd->obtener_fila($stmt)){
      
       $idvencliente = $fila['idvencliente'];
       
       if ( $estado == '1'){
           
               $sqlEdit = "update ven_cliente
                         set   estado  =".$bd->sqlvalue_inyeccion($estado,true)."
                    where id_campana= ".$bd->sqlvalue_inyeccion(0,true)." and 
                             sesion =".$bd->sqlvalue_inyeccion($sesion,true);
               }
       
        if ( $estado == '2'){
                   
                   $sqlEdit = "update ven_cliente
                                  set id_campana =".$bd->sqlvalue_inyeccion($id,true).",
                                      estado  =".$bd->sqlvalue_inyeccion($estado,true)."
                                where id_campana= ".$bd->sqlvalue_inyeccion($id,true)." and
                                      idvencliente= ".$bd->sqlvalue_inyeccion($idvencliente,true) ;
          }
          
       $bd->ejecutar($sqlEdit);
       
       
       $i = $i + 1;
 
   }
   
   $ProcesoInformacion = 'Registros Procesados '.$i;
  
   echo $ProcesoInformacion;
  
?>
 
  