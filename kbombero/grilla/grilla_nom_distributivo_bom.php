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
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla(  $vestado ){
      
 

          $anio = date('Y');
 
       	$qquery = 
      			array( 
      			    array( campo => 'id_asigna_dis',   valor => '-',  filtro => 'N',   visor => 'S'),
                         array( campo => 'fecha_solicitud',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'doccumento',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'estado',valor =>  $vestado ,filtro => 'S', visor => 'S'),
                         array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'autoriza',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'operaciones',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'acompleto',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'aemail',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'aresponsable',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'aid_departamento',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'ocompleto',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'oemail',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'oresponsable',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'oid_departamento',valor => '-',filtro => 'N', visor => 'S'),
                         array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'S') 
       			);
      
       
          $output = array();
      			
      	$resultado = $this->bd->JqueryCursorVisor('bomberos.view_distributivo_bom',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      						                    	$fetch['id_asigna_dis'],
                                        $fetch['fecha_solicitud'],
                                        trim($fetch['doccumento']),
      		                              trim($fetch['detalle'] ), 
                                        trim($fetch['acompleto']) ,
                                        trim($fetch['sesion'] )
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
     
          $vestado    = $_GET['vestado'];

        	$gestion->BusquedaGrilla(  $vestado  );
   			 	 

             
 
  
  
   
 ?>
 
  