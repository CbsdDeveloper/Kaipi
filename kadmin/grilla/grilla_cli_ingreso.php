<?php 
session_start();   
  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
/**
 Clase contenedora para la creacion del formulario de busquedas
 @return
 **/

class proceso{
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      
      /**
       Constructor de la clase  del formulario de busquedas
       @return
       **/ 
      function proceso( ){
  
                $this->obj       = 	new objects;
                
                $this->bd	     =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      /**
       Funcion que visualiza la grilla de informacion de acuerdo a los filtros generados
       @return
       **/ 
      public function BusquedaGrilla($naturaleza,$ciudad,$bestado,$crazon,$ccedula){
      
        $nbandera = 0;
        $sfiltro  = 'S';
        $sfiltro1 = 'S';
        $filtro2  = 'N';
        $filtro3  = 'N';
        
      	if ($naturaleza == '-'){
      		$sfiltro = 'N';
      	} 
      	
      	if ($ciudad == '0'){
      	    $sfiltro1 = 'N';
      	} 
      	
      	$lon     =  strlen($crazon);
      	
      	if ( $lon >  3 ){
      	    $filtro2  = 'S';
      	    $dato     = 'LIKE.'. strtoupper($crazon).'%';
      	    $nbandera = 1;
      	}
       	
      	$lon     =  strlen($ccedula);
       	if ( $lon >  3 ){
      	    $filtro3  = 'S';
      	    $dato1    = 'LIKE.'. strtoupper($ccedula).'%';
      	    $nbandera = 1;
      	}
       	
           	
      	$qquery = array(
      	        array( campo => 'idprov',      valor => $dato1,      filtro =>$filtro3,   visor => 'S'),
      	        array( campo => 'razon',       valor => $dato,       filtro => $filtro2,   visor => 'S'),
      			array( campo => 'correo',      valor => '-',         filtro => 'N',   visor => 'S'),
      			array( campo => 'direccion',   valor => '-',         filtro => 'N',   visor => 'S'),
      			array( campo => 'telefono',    valor => '-',         filtro => 'N',   visor => 'S'),
      			array( campo => 'estado',      valor =>$bestado,     filtro => 'S',   visor => 'N'),
      	        array( campo => 'idciudad',    valor =>$ciudad,      filtro => $sfiltro1,   visor => 'N'),
      			array( campo => 'naturaleza',  valor =>$naturaleza,  filtro => $sfiltro,   visor => 'N'),
      			array( campo => 'modulo',      valor =>"C",          filtro => 'N',   visor => 'N')
      	);
      	
      	if ( $nbandera > 0  ){
       
              	$resultado = $this->bd->JqueryCursorVisor('par_ciu',$qquery );
              	
              	while ($fetch = $this->bd->obtener_fila($resultado)){
              		
              		$output[] = array (
              				trim($fetch['idprov']),
              				$fetch['razon'],
              				$fetch['correo'],
              				$fetch['telefono']
              				
              		);
               	}
              	
              	      	echo json_encode($output);
              	
              	}
      	}
 
   
 }    
 //------------------------------------------------------------------------
 // Llamada de la clase para visualizacion de la grilla de busqueda de datos
 //------------------------------------------------------------------------
 
    		$gestion   = 	new proceso;
     	 
    		if (isset($_GET['bnaturaleza']))	{
    			
    			$naturaleza   = $_GET['bnaturaleza'];
    			$ciudad       = $_GET['bidciudad'];
    			$bestado      = $_GET['bestado'];
     			$crazon       = $_GET['crazon'];
     			$ccedula      = $_GET['ccedula'];
    			
     			$gestion->BusquedaGrilla($naturaleza,$ciudad,$bestado,$crazon,$ccedula);
    			
    		}
 
 ?>