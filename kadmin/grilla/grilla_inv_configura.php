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
    
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla(  $param   ){
      
      	// Soporte Tecnico
  
      	$qquery = array(
      	    array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'carpeta',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'carpetasub',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'formato',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'opcion',   valor =>  trim($param)  ,  filtro => 'S',   visor => 'N'),
      	    array( campo => 'registro',   valor => $this->ruc,  filtro => 'N',   visor => 'N')
      	);
      
 
      	$output = array();
      	
      	$resultado = $this->bd->JqueryCursorVisor('wk_config',$qquery);
      
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
 
 
            $param = $_GET['param'];
   			 	 
   	     	$gestion->BusquedaGrilla(   $param  );
   			 	 
   	 
  
  
   
 ?>
 
  