<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
      public function BusquedaGrilla( $tipo,$fecha1,$fecha2,$sesionc,$tipofacturaf){
      
 
          if ( $sesionc == '-'){
              $filtro= 'N';
          }else{
              $filtro= 'S';
          }
       
          if ( $tipofacturaf == '9'){
                 $this->_Verifica_facturas();
          }
          
          
      	$qquery = 
      			array( 
      			array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'id_asiento_ref',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'fechaa',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'iva',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'base12',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'base0',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S') ,
      			    array( campo => 'sesion',   valor => trim($sesionc),  filtro => $filtro,   visor => 'N') ,
      			    array( campo => 'tipo',   valor => $tipo,  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'estado',   valor => 'aprobado',  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'registro',   valor => $this->ruc,  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'carga',   valor => $tipofacturaf,  filtro => 'S',   visor => 'N') 
        			);
      
      			 
        // filtro para fechas
      	$this->bd->__between('fechaa',$fecha1,$fecha2);
      			
      	$resultado = $this->bd->JqueryCursorVisor('view_ventas_fac',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_movimiento'],
      		                    $fetch['id_asiento_ref'],
      		                    $fetch['fechaa'],
      		                    $fetch['comprobante'],
      		                    $fetch['detalle'],
      		                    $fetch['idprov'],
      		                    $fetch['razon'],
      		                    $fetch['iva'], 
      		                    $fetch['base12'],
      		                    $fetch['base0'],
      		                    $fetch['total'] 
       					);
      	}	
      
      	echo json_encode($output);
      }
      
      //----------------------
      function _Verifica_facturas(   ){
          
          $sqlEdit = "update inv_movimiento
                       set carga = 9
                     where tipo = 'F' AND carga = 0 and substring(comprobante,1,1) = 'I' ";
          
          $this->bd->ejecutar($sqlEdit);
          
          
          
          
          
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
   			 if (isset($_GET['tipo']))	{
   			 
 
   			 	
   			 	$tipo= $_GET['tipo'];
   			 	
   			 	$fecha1= $_GET['fecha1'];
   			 	
   			 	$fecha2= $_GET['fecha2'];
   		 	 	 
   			 	$sesionc= $_GET['sesionc'];
   			 	
   			 	$tipofacturaf= $_GET['tipofacturaf'];
   			 	
   			 	
   			 	$gestion->BusquedaGrilla( $tipo,$fecha1,$fecha2,$sesionc,$tipofacturaf);
   			 	 
   			 }
 
  
  
   
 ?>
 
  