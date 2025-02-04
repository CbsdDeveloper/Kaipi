<?php 
session_start();   
  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
/**
 Clase contenedora para la creacion del formulario de busquedas
 @return
 **/

class grilla_viatico{
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $anio;
      
      /**
       Constructor de la clase  del formulario de busquedas
       @return
       **/ 
      function grilla_viatico( ){
  
                $this->obj       = 	new objects;
                
                $this->bd	     =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                
                $this->anio       =  $_SESSION['anio'];
 
      }
   
      /**
       Funcion que visualiza la grilla de informacion de acuerdo a los filtros generados
       @return
       **/ 
      public function BusquedaGrilla( $bestado ){
       
                       
      	$qquery = array(
      			array( campo => 'id_viatico',         valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'fecha',              valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'documento',          valor => '-',         filtro => 'N',   visor => 'S'),
      			array( campo => 'ciudad_comision',    valor => '-',         filtro => 'N',   visor => 'S'),
      			array( campo => 'motivo',             valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'modificacion',       valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'envio',       valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'estado',      valor =>$bestado,     filtro => 'S',   visor => 'N'),
      	        array( campo => 'anio',        valor =>$this->anio,      filtro => 'S',   visor => 'N') 
      	);
      	
       
              	$resultado = $this->bd->JqueryCursorVisor('adm.view_viatico',$qquery  );
              	
              	while ($fetch = $this->bd->obtener_fila($resultado)){
              		
              	    $envio =  trim($fetch['envio']);

              	    if ( $envio  == 'N') {
              	        $imagen = '<img src="../../kimages/m_rojo.png" align="absmiddle" />';
              	    }else {
              	        $imagen = '<img src="../../kimages/m_verde.png" align="absmiddle" />';
              	    }
              	        
              	    
              	    
              		$output[] = array (
              		        $fetch['id_viatico'],
              		        $fetch['fecha'],
              				trim($fetch['documento']),
              		        trim($fetch['ciudad_comision']),
              		        $imagen.' '.trim($fetch['motivo']),
              				$fetch['modificacion'],$envio
               				
              		);
               	}
              	
             echo json_encode($output);
              	
               
      	}
 
   
 }    
 //------------------------------------------------------------------------
 // Llamada de la clase para visualizacion de la grilla de busqueda de datos
 //------------------------------------------------------------------------
 
    		$gestion   = 	new grilla_viatico;
     	 
    	 
    			
    			 
    			$bestado      = $_GET['estado'];
     		 
     			$gestion->BusquedaGrilla( $bestado);
    			
    	 
 ?>