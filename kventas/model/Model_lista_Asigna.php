 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$sesion 	 =     $_SESSION['email'];
	
	
	$ACarpeta = $bd->query_array('wk_config',
	    'carpetasub',
	    'tipo='.$bd->sqlvalue_inyeccion(2,true)
	    );
	
	$carpeta = trim($ACarpeta['carpetasub']);
	
	
	
	
	
    $sql = "SELECT idusuario, idvengrupo, completo, email, grupo
FROM public.view_ventas_grupo " ;
             
     $stmt = $bd->ejecutar($sql);
		    
   
  
   while ($fila=$bd->obtener_fila($stmt)){
      
       $foto   = _imagen( $bd, $fila['idusuario'] );
       $numero = _potenciales( $bd, trim($fila['email']));
       
       
       $imagen = $carpeta.$foto;
       
      
       
      echo '<div class="media">
                <div class="media-left">
                     <img data-toggle="modal" 
                     data-target="#myModal" 
                     onClick="AsignaLista('.$fila['idusuario'].','."'".trim($fila['completo'])."'".','.$numero.')" 
                     src="'.$imagen.'" class="media-object" style="width:45px">
           </div>
           <div class="media-body">
               <h5 class="media-heading">'.$fila['completo'].' <small><i>Nro. contactos '.$numero.'</i></small></h5>
               <p>'.$fila['grupo'].' - '.$fila['email'].'</p>
            </div>
         </div>';
      
  }
    
//------------------------
  function _imagen( $bd, $idusuario ){
   
      
      $ACarpeta = $bd->query_array('par_usuario',
          'url',
          'idusuario='.$bd->sqlvalue_inyeccion($idusuario,true)
          );
      
      $carpeta = trim($ACarpeta['url']);
      
      return $carpeta;
      
  }
 //---------------------
  function _potenciales( $bd, $sesion ){
      
      
      $ACarpeta = $bd->query_array('ven_cliente',
          'count(*) as nn',
          'id_campana = 0 and sesion='.$bd->sqlvalue_inyeccion($sesion,true)
          );
      
      $carpeta = trim($ACarpeta['nn']);
      
      return $carpeta;
      
  }
  

?>
 
  