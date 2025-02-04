<?php 
session_start();   
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
    /**
     Clase contenedora para la creacion del formulario de visualizacion
     @return
     **/
    
    class grilla_cierre{
 
      private $obj;
      private $bd;
      
      /**
       Clase contenedora para la creacion del formulario de visualizacion
       @return
       **/
      function grilla_cierre(){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      
      public function BusquedaGrilla( $fecha1 ){
          
        
       
 

          $qquery = array( 
              array( campo => 'fecha_pago',   valor => $fecha1,  filtro => 'S',   visor => 'S'),
              array( campo => 'sesion',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S'),
          );
           
              
        $this->bd->_order_by('fecha_pago');
          
      	$resultado = $this->bd->JqueryCursorVisor('rentas.view_ren_caja_cierre_con',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
       
          $ACaja      = $this->bd->query_array('par_usuario',
          'caja, supervisor, url,completo,tipourl',
          'email='.$this->bd->sqlvalue_inyeccion( trim($fetch['sesion']),true)
);


            
      		$output[] = array (
      		                    $fetch['fecha_pago'],
      		                    trim($ACaja['completo']),
                              '-',
                              $fetch['total'],
                              trim($fetch['sesion'])
                                
       					);
      	}	
      
      	echo json_encode($output);
       
      }
      
 
 }    
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
 
 $gestion   = 	new grilla_cierre;
     
   
    			 if (isset($_GET['fecha1']))	{
   			 
 
           			 	
           			 	$fecha1 = $_GET['fecha1'];
           			 	
              			 	
           			 	$gestion->BusquedaGrilla( $fecha1 );
   			 	 
   			 }
 
  
  
   
 ?>