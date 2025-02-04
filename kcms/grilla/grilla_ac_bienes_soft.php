<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
    
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( ){
      
 
          
          
          $qquery = array( 
              array( campo => 'id_software',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'categoria',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'licencia',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'sesionm',valor => '-',filtro => 'N', visor => 'S')
 
          );
  
          
          $resultado = $this->bd->JqueryCursorVisor('flow.itil_software',$qquery );
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $x = $this->bd->query_array('flow.itil_software_user',
      	                                'count(*) as nn', 
      	        'id_software='.$this->bd->sqlvalue_inyeccion($fetch['id_software'],true)
      	        );
      	    
 
      	    
		 	$output[] = array (
		      				    $fetch['categoria'],
		 						$fetch['detalle'],
		      				    $fetch['licencia'],
		      				    $fetch['sesionm'],
		 	                    $x['nn'],
		 	                    $fetch['id_software'],
 		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
 
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
 
                
           $gestion->BusquedaGrilla( );
            	 
       
  
   
 ?>
 
  