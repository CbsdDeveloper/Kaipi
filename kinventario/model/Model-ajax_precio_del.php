<?php 
    session_start();  
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
	$obj   = 	new objects;
	$bd	   =    new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['id']))	{
 	  
		 $id_detalle = $_GET['id'];
         
       	 $idcodigo   = $_GET['codigo'];
             
		 
	    /// elimina la cuenta
		 $sql = " delete from inv_producto_vta
		 		       where id_productov=".$bd->sqlvalue_inyeccion($id_detalle, true);
	
 	  	$bd->ejecutar($sql);		
		    
	    }
	    
        $div = '#precio_grilla';
        
        $url = '../model/Model-ajax_precio.php?id='.$idcodigo;
        
        echo '<script type="text/javascript">';
        echo "  opener.$('".$div."').load('".$url."');   ";
        echo '</script>';  
  
        $obj->var->kaipi_cierre_pop();
        
 	 
?>