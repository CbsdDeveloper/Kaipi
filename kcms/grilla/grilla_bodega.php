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
      
      	// Soporte Tecnico
  
      	$qquery = array(
      	    array( campo => 'idbodega',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'ubicacion',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'activo',   valor => '-',  filtro => 'N',   visor => 'S'),
       	    array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'registro',   valor => $this->ruc,  filtro => 'S',   visor => 'N'),
      	);
      
 
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_bodega',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (  $fetch['idbodega'],
      		                     $fetch['nombre'],
      		                     $fetch['idprov']	,
      		                     $fetch['ubicacion'] ,
                      		    $fetch['razon'] ,
                      		    $fetch['activo'] ,
       		                     $fetch['telefono'] 
      		    
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
 
  