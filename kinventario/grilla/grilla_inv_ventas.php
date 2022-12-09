<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( $tipo,$fecha1,$fecha2,$tipofacturaf){
      
 
          
          if ( $tipofacturaf  == '-1')  {
              $carga = 'N' ;
          }else{
              $carga = 'S' ;
          }
          
   
          
      	$qquery = 
      			array( 
      			array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'id_asiento_ref',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'iva',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'base12',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'base0',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S') ,
      			    array( campo => 'tipo',   valor => $tipo,  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'estado',   valor => 'aprobado',  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'registro',   valor => $this->ruc,  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'carga',   valor =>$tipofacturaf,  filtro => $carga,   visor => 'N') 
        			);
      
        // filtro para fechas
      	$this->bd->__between('fecha',$fecha1,$fecha2);
      			
      	$resultado = $this->bd->JqueryCursorVisor('view_ventas_fac',$qquery );
      	
      	$output = array();
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_movimiento'],
      		                    $fetch['id_asiento_ref'],
      		                    $fetch['fecha'],
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
   			 
   			     
   			    $tipofacturaf = $_GET['tipofacturaf'];
   			 	
   			 	$tipo= $_GET['tipo'];
   			 	
   			 	$fecha1= $_GET['fecha1'];
   			 	
   			 	$fecha2= $_GET['fecha2'];
   		 	 	 
   			 	$gestion->BusquedaGrilla( $tipo,$fecha1,$fecha2,$tipofacturaf);
   			 	 
   			 }
 
  
  
   
 ?>
 
  