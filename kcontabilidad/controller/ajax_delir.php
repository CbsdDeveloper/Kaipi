<?php 
    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Db.conf.php');   
	include ('../../kconfig/Obj.conf.php'); 
	
	$obj   = 	new objects;
	$bd	   =	Db::getInstance();	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
  
  
 	if (isset($_GET['id']))	{
	
    	 $id_compras = $_GET['id'];
	
    	 $codigo = $_GET['ref'];
	
    	 $id_asiento = $_GET['codigo'];
 		 
		 $sql = "SELECT * FROM co_asiento  where id_asiento = ".$bd->sqlvalue_inyeccion($id_asiento ,true);
  	
		 $resultado = $bd->ejecutar($sql);
		 $datos_asiento = $bd->obtener_array($resultado);
		 $bd->kfree_sql($resultado);
		 $estado     = $datos_asiento["estado"];
         
         
		 if (trim($estado) == 'digitado'){
	
    	 // busca la cuenta
         $sql = "SELECT b.cuenta 
               FROM  co_catalogo b
              where b.tipo = 'Fuente de Impuesto a la Renta' and b.codigo =".$bd->sqlvalue_inyeccion($codigo , true);
		
		$resultado1 = $bd->ejecutar($sql);
		$datos_sql = $bd->obtener_array( $resultado1);
		$cuenta = trim($datos_sql['cuenta']) ; 	  
	
        /// elimina la cuenta
		 $sql = " delete from co_asientod
		 		    where id_asiento=".$bd->sqlvalue_inyeccion($id_asiento, true).' and cuenta ='.$bd->sqlvalue_inyeccion($cuenta, true);
	
 	  	$resultado = $bd->ejecutar($sql);		
		// elimna el anexo
		 $sql = " delete from co_compras_f
		 		    where id_compras=".$bd->sqlvalue_inyeccion($id_compras, true).' and codretair ='.$bd->sqlvalue_inyeccion($codigo, true);
	
 	  	$resultado = $bd->ejecutar($sql);
   	    /// elimina la cuenta de auxiliar
		    /// elimina la cuenta
		 $sql = " delete from co_asiento_aux
		 		    where id_asiento=".$bd->sqlvalue_inyeccion($id_asiento, true).' and cuenta ='.$bd->sqlvalue_inyeccion($cuenta, true);
	
 	  	$resultado = $bd->ejecutar($sql);	  
            
	    }
     
        K_ejecuta_detalle('#retencion_fuente','../model/ajax_DetAsientoIR.php?id_asiento='.$id_asiento);  
         
	    $obj->var->kaipi_cierre_pop();
   		  
   	 }	
     
       function K_ejecuta_detalle($div,$url ){
     
      echo '<script type="text/javascript">';
      echo "  opener.$('".$div."').load('".$url."');   ";
      echo '</script>';  
     
      }
?>