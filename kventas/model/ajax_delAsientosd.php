<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	
    $obj   = 	new objects;
 
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
  
 	 if (isset($_GET['tid']))	{
 	  
		 $id_asientod = $_GET['tid'];
		 
 	     $id_asiento = $_GET['codigo'];
 
          $sql = "SELECT *
    	            FROM co_asiento  
                    where id_asiento = ".$bd->sqlvalue_inyeccion($id_asiento ,true);
      	
         $resultado = $bd->ejecutar($sql);
         
      	 $datos1 = $bd->obtener_array( $resultado);
	  
         // parametros kte 
  	     $estado     = $datos1["estado"];
	  
			    	 if (trim($estado) == 'digitado'){    
			    	   
			    	      $sql = 'delete from co_asientod
			    				 WHERE id_asientod='.$bd->sqlvalue_inyeccion($id_asientod, true);   
			    	 	  
			               $bd->ejecutar($sql);
			    		  
			      		  $sql = 'delete from co_asiento_aux
			    				 WHERE id_asientod='.$bd->sqlvalue_inyeccion($id_asientod, true);   
			      		  
			    	 	  $bd->ejecutar($sql);		  
			    	 } 
        }   
	    
  /*      var id_asiento = $('#id_asiento').val();
        
        var parametros = {
        	'id_asiento' : id_asiento
        };
        
        $.ajax({
        	data:  parametros,
        	url:   '../model/ajax_DetAsiento.php',
        	type:  'GET' ,
        	cache: false,
        	beforeSend: function () {
        		$("#DivAsientosTareas").html('Procesando');
        	},
        	success:  function (data) {
        		$("#DivAsientosTareas").html(data);
        		
        	}
        });
        
        */
        
       $div = '#DivAsientosTareas';
       $url = '../model/ajax_DetAsiento.php?id_asiento='.$id_asiento;
        
        
        echo '<script type="text/javascript">';
        echo "  opener.$('".$div."').load('".$url."');   ";
        echo '</script>';  
 
        $obj->var->kaipi_cierre_pop();
        
 	 
?>