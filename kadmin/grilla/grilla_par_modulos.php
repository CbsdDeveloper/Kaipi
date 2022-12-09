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
      public function BusquedaGrilla($baccion,$bmodulo){
      
      	
      	$lon      =  strlen($bmodulo);
      	$filtro2  = 'N';
      	
      	if ( $lon >  3 ){
      	    $filtro2= 'S';
      	    $dato = 'LIKE.'.($bmodulo).'%';   // PALABRA RESERVADA PARA BUSCAR COICIDENCIAS CON LA VARIABLE LIKE
      	}
       
      	
		 

      	$qquery = array(
      			array( campo => 'id_par_modulo',       valor => '-',       filtro => 'N',           visor => 'S'),
      	        array( campo => 'fid_par_modulo',      valor => '-',       filtro => 'N',            visor => 'S'),
      			array( campo => 'modulo',              valor => $dato,      filtro => $filtro2,      visor => 'S'),
      			array( campo => 'estado',              valor => '-',       filtro => 'N',           visor => 'S'),
      			array( campo => 'vinculo',             valor => '-',       filtro => 'N',           visor => 'S'),
      			array( campo => 'publica',             valor => '-',        filtro => 'N',          visor => 'S'),
      	        array( campo => 'script',              valor => '-',        filtro => 'N',          visor => 'S'),
      		    array( campo => 'tipo',                valor => '-',        filtro => 'N',          visor => 'S'),
      		    array( campo => 'ruta',                valor => '-',        filtro => 'N',          visor => 'S'),
                array( campo => 'accion',              valor =>$baccion,   filtro =>  'S',          visor => 'S'),
                array( campo => 'detalle',             valor =>'-',        filtro => 'N',           visor => 'S'),
                array( campo => 'logo',                valor =>'-',        filtro => 'N',           visor => 'S')
      	);
      	

       
      	$resultado = $this->bd->JqueryCursorVisor('par_modulos',$qquery);
       
    
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (trim($fetch['id_par_modulo']),
                    $fetch['fid_par_modulo'],
      				$fetch['modulo'],
      				$fetch['vinculo'],
      				$fetch['ruta']
      				
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
    		if (isset($_GET['baccion']))	{
    			
    			
    			$baccion	  = $_GET['baccion'];
    			$bmodulo       = $_GET['bmodulo'];
    			
    			$gestion->BusquedaGrilla($baccion,$bmodulo);
    			
    		
    		}
 
   
 ?>
 
  