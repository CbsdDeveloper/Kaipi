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
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
      
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($baccion,$bmodulo){
      
    
      	$qquery = array(
      			array( campo => 'id_audita',           valor => '-',        filtro => 'N',           visor => 'S'),

      	        array( campo => 'transaccion',         valor => '-',        filtro => 'N',            visor => 'S'),

      			array( campo => 'accion',              valor => $baccion,   filtro => 'S',             visor => 'S'),

      			array( campo => 'modulo',              valor => $bmodulo,   filtro => 'S',           visor => 'S'),

      			array( campo => 'fecha',               valor => '-',        filtro => 'N',           visor => 'S'),

      			array( campo => 'texto',               valor => '-',        filtro => 'N',          visor => 'S'),

      	        array( campo => 'sesion',              valor => '-',        filtro => 'N',          visor => 'S'),

      		    array( campo => 'fmodificacion',       valor => '-',        filtro => 'N',          visor => 'S'),

      		    array( campo => 'hora',                valor => '-',        filtro => 'N',          visor => 'S'),
                
                array( campo => 'tabla',                valor =>'-',        filtro =>  'N',          visor => 'S')
             
      	);
      	       
       
      	$resultado = $this->bd->JqueryCursorVisor('web_auditoria',$qquery);
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (trim($fetch['id_audita']),
      				$fetch['modulo'],
      				$fetch['fecha'],
                    $fetch['sesion'],
      				$fetch['tabla']
      				
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
 
  