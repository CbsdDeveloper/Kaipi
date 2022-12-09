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
      public function BusquedaGrilla($bmodulo){
      
    
      	      $qquery = array(
                array( campo => 'idreporte_sis',           valor => '-',        filtro =>  'N',           visor => 'S'),
                array( campo => 'nombre',                  valor => '-',        filtro =>  'N',            visor => 'S'),
                array( campo => 'modulo',                  valor => $bmodulo,   filtro =>  'S',             visor => 'S'),
                array( campo => 'referencia',              valor =>'-',          filtro => 'N',           visor => 'S'),
                array( campo => 'archivo',                 valor => '-',        filtro =>  'N',           visor => 'S'),
                array( campo => 'ruta',                    valor => '-',        filtro =>  'N',          visor => 'S'),
                array( campo => 'pie',                     valor => '-',        filtro =>  'N',          visor => 'S')
               
             
        ); 
       
      	$resultado = $this->bd->JqueryCursorVisor('par_reporte',$qquery);
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (trim($fetch['idreporte_sis']),
      				$fetch['nombre'],
      				$fetch['modulo'],
                    $fetch['referencia'],
      				$fetch['archivo']
      				
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
    		if (isset($_GET['bmodulo']))	{
    				
    			$bmodulo       = $_GET['bmodulo'];
    			
    			$gestion->BusquedaGrilla($bmodulo);
    			
    		
    		}
 
   
 ?>
 
  