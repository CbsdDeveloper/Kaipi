<?php 
     session_start( );   
  
   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	 
 	global $bd,$obj,$datos, $formulario,$set;
        
    $obj   = 	new objects;

	$bd	   =	new Db;
	
	$set   = 	new ItemsController;

    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
          
    $action = trim(@$_POST["action"]);
    
    $id =  @$_POST["id_rol"];
     
    if ($action == 'editar'){
		
        K_editar($id);
    
	} elseif ($action  == 'add') {
    
		K_agregar($action );
    
	} elseif ($action  == 'del') {
    
		K_eliminar( $id);
    }
 
    
 
    /////////////// llena para consultar
 function K_editar($id){
 
 global $bd,$obj,$datos, $formulario,$set;
 	 
 	 $sesion 	 = $_SESSION['email'];
 	 $hoy 		 = $bd->hoy();
	 $ruc 		 = $_SESSION['ruc_registro'];
  	 
 	 $sql = " UPDATE nom_rol_pago
					   SET 	estado=".$bd->sqlvalue_inyeccion(@$_POST["estado"], true).",
 							fecha=".$bd->sqlvalue_inyeccion(@$_POST["fecha"], true).",
							novedad=".$bd->sqlvalue_inyeccion(@$_POST["novedad"], true).",
							sesion=".$bd->sqlvalue_inyeccion($sesion, true)."	
 					 WHERE id_rol=".$bd->sqlvalue_inyeccion($id, true);

     $resultado = $bd->ejecutar($sql);
	 
  
    
    echo '<script language="javascript">window.parent.scrollTo (0,0);</script>';
    echo '<img src="../../kimages/b_act.png"/> <b>INFORMACION ACTUALIZADA CON EXITO </b><br>';   
   
    K_consulta($id );
 
    // $obj->var->_enlace($formulario.'?action=editar&tid='.$id.'#tab2');
  }	 
  
  function K_consulta($id ){
 
    global $bd,$obj,$datos, $formulario,$set;	 
 
 
 		 $sql = "SELECT *
 		       FROM nom_rol_pago  
              where id_rol = ".$bd->sqlvalue_inyeccion($id ,true);
  	
     $resultado = $bd->ejecutar($sql);
  	 $datos = $bd->obtener_array( $resultado);
 
  
  }	
  // agregar
  /////////////// llena datos de la consulta individual
 function K_agregar( ){

    global $bd,$obj,$datos, $formulario,$set;

 	// parametros kte 
	 $sesion 	 = $_SESSION['email'];
 	 $hoy 		 = $bd->hoy();
 	 $ruc = $_SESSION['ruc_registro']; 
	 $periodo = @$_POST["id_periodo"];
	 
	 $sql = "SELECT anio, mes
 		       FROM co_periodo
              where id_periodo = ".$bd->sqlvalue_inyeccion($periodo ,true);
  	
     $resultado = $bd->ejecutar($sql);
  	 $datos_periodo = $bd->obtener_array( $resultado);
	 
 	
 	$sql = "INSERT INTO nom_rol_pago(
            id_periodo, mes, anio, registro, estado, fecha, novedad, 
            sesion) VALUES (".
 			  $bd->sqlvalue_inyeccion(@$_POST["id_periodo"], true).",".
 			  $bd->sqlvalue_inyeccion($datos_periodo["mes"], true).",".
 			  $bd->sqlvalue_inyeccion($datos_periodo["anio"], true).",".
 			  $bd->sqlvalue_inyeccion($ruc, true).",".			  
 			  $bd->sqlvalue_inyeccion(@$_POST["estado"], true).",".	
			  $bd->sqlvalue_inyeccion(@$_POST["fecha"], true).",".			  
 			  $bd->sqlvalue_inyeccion(@$_POST["novedad"], true).",".	
			  $bd->sqlvalue_inyeccion($sesion, true).")";
  
    	     $resultado = $bd->ejecutar($sql);
 		     $id = $bd->ultima_secuencia('nom_rol_pago'); 
		 
 
         $action = 'editar';
       
      echo '<script language="javascript">window.parent.scrollTo (0,0);</script>';
      echo '<script language="javascript">'."window.document.getElementById('id_rol').value ='".$id."' </script>";
      echo '<script language="javascript">'."window.document.getElementById('action').value ='". $action."' </script>";
     
      
      K_consulta($id );
      echo '<img src="../../kimages/b_oki.png"/> <b>DATOS INSERTADOS CON EXITO </b><br>';  
 	 $datos['action'] = 'editar';
       
  }	
  
     /////////////// llena para eliminar
 function K_eliminar($id ){
 
 global $bd,$obj,$datos, $formulario,$set;
   	
 	if ($id > 0){
		
	/* $sql = "SELECT count(*) as nro_registros
	  FROM inv_movimiento_det  where idproducto = ".$bd->sqlvalue_inyeccion($id ,true);
  	
     $resultado = $bd->ejecutar($sql);
  	 $datos_valida = $bd->obtener_array( $resultado);
	 
  	  if ($datos_valida['nro_registros'] == 0){
		  $sql = " delete from web_producto
		 		    where idproducto=".$bd->sqlvalue_inyeccion($id, true);
	
		$resultado = $bd->ejecutar($sql);
	
	     $action = 'nulo';
		 echo '<script language="javascript">'."window.document.getElementById('action').value ='". $action."' </script>";
		 echo '<script language="javascript">location.reload() </script>';
		 echo '<script language="javascript">window.parent.scrollTo (0,0);</script>';
	   } */
	 }

  }	
   	
 ?>
 
  