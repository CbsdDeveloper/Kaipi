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
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( ){
      
            
 
     
      	$qquery = array(
      			array( campo => 'idvengrupo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'grupo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'completo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'email',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S')
       	);
      	
       
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_venta_zona',$qquery );
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
        	    
      		$output[] = array (
      				$fetch['idvengrupo'],
      				$fetch['grupo'],
      		        $fetch['completo'],
      		        $fetch['email'],
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
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
    	
    		//------ consulta grilla de informacion
    	 
         	$gestion->BusquedaGrilla( );
 
  
  
  
   
 ?>
 
  