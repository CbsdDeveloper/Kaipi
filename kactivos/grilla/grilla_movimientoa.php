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
      public function BusquedaGrilla($vidsede,$fecha1,$fecha2,$idtramite,$factura,$proveedor){
      
        
          
          $filtra1 = 'N';
          
          if ( $idtramite > 0 ){
              $filtra1 = 'S';
          }
          
          $longi   = strlen(trim($factura));
          $filtra2 = 'N' ;
          if ( $longi > 3 ){
              $filtra2 = 'S';
              $factura1 = '%'.trim($factura).'%';
          }
          
          $longi   = strlen(trim($proveedor));
          $filtra3 = 'N' ;
          if ( $longi > 3 ){
              $filtra3 = 'S';
           }
          
          
          
          
          
      	$qquery = 
      			array( 
      			array( campo => 'sede',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'id_tramite',   valor => $idtramite,  filtro => $filtra1,   visor => 'S'),
      			array( campo => 'idproveedor',   valor => trim($proveedor),  filtro => $filtra3,   visor => 'S'),
      			array( campo => 'proveedor',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'fecha_adquisicion',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'factura',   valor => 'LIKE.'.$factura1,  filtro => $filtra2,   visor => 'S'),
      			array( campo => 'cantidad',     valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'costo',     valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'idsede',     valor => $vidsede ,  filtro => 'S',   visor => 'N'),
        			);
 
      			
        // filtro para fechas
      	$this->bd->__between('fecha_adquisicion',$fecha1,$fecha2);
      			
      	$resultado = $this->bd->JqueryCursorVisor('activo.view_bienes_tramite',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_tramite'],$fetch['factura'],$fetch['fecha_adquisicion'],
      		                    $fetch['idproveedor'],$fetch['proveedor'],
      		                    $fetch['cantidad'],$fetch['costo']
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
   			 if (isset($_GET['vidsede']))	{
   			 
   			     $idtramite= $_GET['idtramite'];
   			 	
   			     $factura= $_GET['factura'];
   			     
   			 	$proveedor= $_GET['proveedor'];
   			 	
   			 	$fecha1= $_GET['fecha1'];
   			 	
   			 	$vidsede= $_GET['vidsede'];
   			 	
   			 	$fecha2= $_GET['fecha2'];
   		 	 	 
   			 	$gestion->BusquedaGrilla($vidsede,$fecha1,$fecha2,$idtramite,$factura,$proveedor);
   			 	 
   			 }
 
  
  
   
 ?>
 
  