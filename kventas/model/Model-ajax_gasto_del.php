<?php 
    session_start();  
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
	$obj   = 	new objects;
	$bd	   =    new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['tid']))	{
 	  
		 $id_detalle = $_GET['tid'];
		 $fecha      = $_GET['ref'];
		 
		 $ACierre = $bd->query_array(
		     'inv_movimiento',
		     'max(cierre) as cierre',
		     'fecha='.$bd->sqlvalue_inyeccion($fecha,true).' and
		    sesion='.$bd->sqlvalue_inyeccion($_SESSION['email'],true)
		     
		     ); 
 		 
		 if (  $ACierre["cierre"] == 'N'  ) {
    	  
    		 $sql = " delete from inv_producto_gasto
    		 		       where id_productogasto=".$bd->sqlvalue_inyeccion($id_detalle, true);
    	
     	  	 $bd->ejecutar($sql);		
 	  	
		 }
		    
	    }
	    
        $div = '#precio_grilla';
        
        $url = '../model/Model-ajax_gasto.php?fecha='.$fecha;
        
        echo '<script type="text/javascript">';
        echo "  opener.$('".$div."').load('".$url."');   ";
        echo '</script>';  
  
        $obj->var->kaipi_cierre_pop();
        
 	 
?>