<?php 
session_start();   
  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
/**
 Clase contenedora para la creacion del formulario de busquedas
 @return
 **/

class grilla_requerimiento_b{
 
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
      function grilla_requerimiento_b( ){
  
                $this->obj       = 	new objects;
                
                $this->bd	     =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                
                $this->anio       =  $_SESSION['anio'];
 
      }
   
      /**
       Funcion que visualiza la grilla de informacion de acuerdo a los filtros generados
       @return
       **/ 
      public function BusquedaGrilla( $bestado ){
       
           	
          if ( $bestado== '1'){
              $estado = 'solicitado';
          }
          
          if ( $bestado== '2'){
              $estado = 'digitado';
          }
          if ( $bestado== '3'){
              $estado = 'aprobado';
          }
          
          if ( $bestado== '5'){
              $estado = 'anulado';
          }
          
          $datos = $this->bd->__user( $this->sesion);
          
          $idprov = trim($datos['cedula']);
          
           
          
              
      	$qquery = array(
      			array( campo => 'id_movimiento',      valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'fecha',      valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'comprobante',      valor => '-',         filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   valor => '-',         filtro => 'N',   visor => 'S'),
      			array( campo => 'sesion',    valor => '-',         filtro => 'N',   visor => 'S'),
      	        array( campo => 'idprov',      valor =>$idprov,     filtro => 'S',   visor => 'N'),
      	        array( campo => 'estado',      valor =>$estado,     filtro => 'S',   visor => 'N'),
      	        array( campo => 'anio',        valor =>$this->anio,      filtro => 'S',   visor => 'N'),
      			array( campo => 'tipo',        valor =>"E",          filtro => 'S',   visor => 'N')
      	);
      	
      	
        
              	$resultado = $this->bd->JqueryCursorVisor('view_inv_movimiento',$qquery  );
              	
              	while ($fetch = $this->bd->obtener_fila($resultado)){
              		
              		$output[] = array (
              		        $fetch['id_movimiento'],
              		        $fetch['fecha'],
              				trim($fetch['comprobante']),
              		        trim($fetch['detalle']),
              				$fetch['sesion']
               				
              		);
               	}
              	
             echo json_encode($output);
              	
               
      	}
 
   
 }    
 //------------------------------------------------------------------------
 // Llamada de la clase para visualizacion de la grilla de busqueda de datos
 //------------------------------------------------------------------------
 
    		$gestion   = 	new grilla_requerimiento_b;
     	 
    	 
    			
    			 
    			$bestado      = $_GET['estado'];
     		 
     			$gestion->BusquedaGrilla( $bestado);
    			
    	 
 ?>