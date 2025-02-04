<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
                $this->sesion 	 =  trim($_SESSION['email']);
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($vestado,$vperiodo){
      
  
  
          $qquery = array( 
              array( campo => 'id_bien_dep',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'estado',valor => $vestado,filtro => 'S', visor => 'S'),
              array( campo => 'anio',     valor => $vperiodo,filtro => 'S', visor => 'S') ,
              array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'sesionm',valor => '-',filtro => 'N', visor => 'S') 
           
          );
  
          $resultado = $this->bd->JqueryCursorVisor('activo.ac_bienes_cab_dep',$qquery );
 
 
          
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    if ( $fetch['tipo'] == 'A'){
      	        $mensaje = '( ANUAL )';
      	    }else{
      	        $mensaje = '( MENSUAL )';
      	    }
      	        
       	    
		 	$output[] = array (
		      				    $fetch['id_bien_dep'],
                		 	    $fetch['fecha'],
                		 	    $fetch['cuenta'],
                		 	    $fetch['anio'],
		 	                    trim($fetch['detalle']).' '.$mensaje,
		 	                    $fetch['estado'] 
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
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['vestado']))	{
  
                 $vestado = $_GET['vestado'];
                 $vperiodo= $_GET['vperiodo'];
                 
 
                 $gestion->BusquedaGrilla($vestado,$vperiodo);
            	 
            }
  
  
   
 ?>
 
  