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
                $this->sesion 	 =  $_SESSION['login'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( ){
      
        
  
      	$qquery = array( 
      			array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'objetivo',   valor => '-',  filtro => 'N',   visor => 'S') 
       	);
      
      	$resultado = $this->bd->JqueryCursorVisor('planificacion.matrizo',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (   $fetch['unidad'], $fetch['objetivo'] );
      		
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
    
  
   			 	 
    		$gestion->BusquedaGrilla( );
   			 	 
   	 
  
  
   
 ?>
 
  