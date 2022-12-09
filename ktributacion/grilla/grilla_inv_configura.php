<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
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
      
      	// Soporte Tecnico
  
      	$qquery = array(
      	    array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'carpeta',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'carpetasub',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'formato',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'opcion',   valor => 'procesos',  filtro => 'S',   visor => 'N')
      	);
      
 
      	
      	$resultado = $this->bd->JqueryCursorVisor('wk_config',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (  $fetch['tipo'],
      		                     $fetch['carpeta'],
      		                     $fetch['modulo']	,
      		                     $fetch['carpetasub'] ,
                      		     $fetch['formato']  
      		    
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
 
 
   			 	 
   	     	$gestion->BusquedaGrilla( );
   			 	 
   	 
  
  
   
 ?>
 
  