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
      public function BusquedaGrilla(){
      

 
       	$qquery = 
      			array( 
      			    array( campo => 'id_accionl',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'legal',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'sesion',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'activo',   valor => '-',  filtro => 'N',   visor => 'S'),
                    array( campo => 'afecta',   valor => '-',  filtro => 'N',   visor => 'S')
       			);
      
       
        $output = array();
      			
      	$resultado = $this->bd->JqueryCursorVisor('nom_accion_lista',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_accionl'],
                                $fetch['nombre'],
                                $fetch['legal'],
      		                    $fetch['sesion'] , 
                                $fetch['activo'] 
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
     
        	$gestion->BusquedaGrilla();
   			 	 
 
  
  
   
 ?>
 
  