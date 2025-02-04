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
      
      public function BusquedaGrilla(  ){
          
        
 

          $qquery = array( 
              array( campo => 'estado_pago',   valor => 'N',  filtro => 'S',   visor => 'S'),
              array( campo => 'id_asiento',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'fecha',        valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'asiento_detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'debe',    valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'opago',   valor => '-',  filtro => 'N',   visor => 'S'),
          );
           
 
              
        $this->bd->_order_by('fecha');
          
      	$resultado = $this->bd->JqueryCursorVisor('rentas.view_diario_caja',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 

            if ($fetch['opago'] == '1'){
                $check ='checked';
            }else{
                $check =' ';
            }
        
            if (   $fetch['debe'] > 0 ) {
            
                    $output[] = array (
                                        $fetch['id_asiento'],
                                        $fetch['fecha'],
                                        trim($fetch['asiento_detalle']),
                                        $fetch['debe'],
                                        $check
                                        
                                );
                            }	             
      	}	
      
      	echo json_encode($output);
       
      }
      
 
 }    
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
 
 $gestion   = 	new grilla_cierre;
     
   
    	$gestion->BusquedaGrilla(  );
   		 
  
  
   
 ?>