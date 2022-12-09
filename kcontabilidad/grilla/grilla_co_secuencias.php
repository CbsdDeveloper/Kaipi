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
 
                $this->obj     =    new objects;
                $this->bd      =    new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion    =  $_SESSION['email'];
                
                $this->hoy       =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
      
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($banio){
      
      	$qquery = array(
      			array( campo => 'idsecuencias',        valor => '-',        filtro => 'N',          visor => 'S'),

      	        array( campo => 'detalle',             valor => '-',        filtro => 'N',          visor => 'S'),

      			array( campo => 'secuencia',           valor => '-',        filtro => 'N',          visor => 'S'),

      			array( campo => 'estado',              valor => '-',        filtro => 'N',          visor => 'S'),

      			array( campo => 'anio',                valor => $banio,     filtro => 'S',          visor => 'S'),

      			array( campo => 'tipo',                valor => '-',        filtro => 'N',          visor => 'S'),
                
      	        array( campo => 'tanio',               valor => '-',        filtro => 'N',          visor => 'S'),
      		   
      	);
      	
        $resultado = $this->bd->JqueryCursorVisor('co_secuencias',$qquery);
     	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
                    ($fetch['idsecuencias']),
                    $fetch['detalle'],
      				$fetch['secuencia'],
      				$fetch['estado'],
      				$fetch['tipo']
      				
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
    		if (isset($_GET['banio']))	{
    			
    			
    			$banio	  = $_GET['banio'];
    			
    			
    			$gestion->BusquedaGrilla($banio);
    			
    		
    		}
 
   
 ?>
 
  