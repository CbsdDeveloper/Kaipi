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
        
                $this->bd->conectar_sesion_ventas();
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($nombre_agua){
      
        
     
          $nombre = strtoupper (trim($nombre_agua)).'%' ;
       
          $qquery = array( 
              array( campo => 'id_factura',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'usuario ',   valor => 'LIKE.'.$nombre,  filtro => 'S',   visor => 'S'),
              array( campo => 'cedula',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'ano',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'periodo',   valor => '-',  filtro => 'N',   visor => 'S')
           );
         
        // filtro para fechas
     
        
          
      	$resultado = $this->bd->JqueryCursorVisor('view_agua_adicional',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	 
      	    
      		$output[] = array (
      		                    $fetch['id_factura'],
      		                    $fetch['usuario'],
      		                    $fetch['cedula'],
      		                    $fetch['direccion'],
      		                    $fetch['ano'],
      		                    $fetch['periodo'] 
      		                     
       					);
      	}	
      
      	echo json_encode($output);
      }
      
      //-----------------------------
      
      
      
      
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
     
   
   			 //------ consulta grilla de informacion
   			 if (isset($_GET['nombre_agua']))	{
   			 
    			 	
   			     $nombre_agua = trim($_GET['nombre_agua']);
   			 	
   			 	 
   		 	 	 
    			 	
   			     $gestion->BusquedaGrilla($nombre_agua);
   			 	 
   			 }
 
  
  
   
 ?>
 
  