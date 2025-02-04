 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$sesion 	     =     $_SESSION['email'];
	
	$idusuario_actual			 =     $_GET["idusuario_actual"];
	$idsuario_recibe			 =     $_GET["idsuario_recibe"];
	$actual			 =     $_GET["actual"];
	$nuevo			 =     $_GET["nuevo"];
	
	
	$sesion_actual = _sesion($bd,$idusuario_actual );
	
	$sesion_recibe = _sesion($bd,$idsuario_recibe );
 
	 	    
    $sql = "SELECT idvencliente,  sesion 
            FROM public.ven_cliente
            where id_campana = 0 and sesion = ".$bd->sqlvalue_inyeccion(trim($sesion_actual),true);
             
     $stmt = $bd->ejecutar($sql);
		
  
     
   $i = 0;
   $j = 0;
   
   while ($fila=$bd->obtener_fila($stmt)){

       $id = $fila['idvencliente'];
       
       if ( $i < $nuevo) {
           
           $sql = "UPDATE ven_cliente
                      SET sesion = ".$bd->sqlvalue_inyeccion(trim($sesion_recibe),true)." 
                    where id_campana = 0 and idvencliente =".$bd->sqlvalue_inyeccion($id,true);
           
           $bd->ejecutar($sql);
           
           $j = $j + 1;
       }
 
       $i = $i + 1;
      
  }
  
  $Asignarcta = '<b>Contactos Asignados: '.$j.' correctamente</b>' ;
  
  echo $Asignarcta;
  
  //--------
  //-----------------------------------------------------------------------------------------------------------
  function _sesion($bd,$idusuario ){
      
      
      $AResultado = $bd->query_array(
          'par_usuario',
          'email', 
          'idusuario='.$bd->sqlvalue_inyeccion($idusuario,true)
          );
      
     
      return $AResultado['email'];
      
      
      
  }
  
?>
 
  