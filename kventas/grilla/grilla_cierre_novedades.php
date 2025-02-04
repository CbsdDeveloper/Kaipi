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
      public function BusquedaGrilla($estado,$fecha1,$cajero){
      
                   
          $tipo1 = '' ;
          
          if ( $estado == '1'){
              $tipo1 = ' and autorizacion is null ';
          }
          if ( $estado == '2'){
              $tipo1 = ' and autorizacion is not null and envio is null ';
          }
          
          $periodo = explode('-',$fecha1);
          
          $anio = $periodo[0];
          $mes = $periodo[1];
 
     
          $sql_det = 'SELECT fecha, comprobante, idprov, razon, base12, iva, base0, total, cierre, id_movimiento, 
                             registro, sesion, creacion, estado, tipo, id_periodo, documento, id_asiento_ref, fechaa, 
                             direccion, telefono, correo, autorizacion, detalle, anio, mes, envio, carga
            	    FROM  view_ventas_fac
            	    where anio = '.$this->bd->sqlvalue_inyeccion($anio, true).' and 
                          mes = '.$this->bd->sqlvalue_inyeccion($mes, true).' and 
                          estado = '.$this->bd->sqlvalue_inyeccion('aprobado', true). $tipo1;
          
       $resultado = $this->bd->ejecutar($sql_det);
 
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    $lon     = strlen($fetch['autorizacion']);
      	    
      	    $envio   = trim($fetch['envio']);
      	    
      	    if ($lon==0){
      	        $imagen =  '<img src="../../kimages/star.png" title="FACTURA NO EMITIDA ELECTRONICAMENTE"/>';
      	    }else{
      	        if ( $envio == 'S'){
      	            $imagen =  '<img src="../../kimages/starok.png"   title="'.$fetch['autorizacion'].'"/>';
      	        }else{
      	            $imagen =  '<img src="../../kimages/star_medio.png"   title="'.$fetch['autorizacion'].'"/>';
      	        }
      	       
      	    }
      	    
      		$output[] = array (
      		                    $fetch['id_movimiento'],
      		    $fetch['fechaa'],$fetch['documento'],$fetch['comprobante'],$fetch['idprov'],
      		                    $fetch['razon'],$fetch['total'],$fetch['cierre'],$imagen,
      		                     
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
   			 if (isset($_GET['fecha1']))	{
   			 
   			 	$estado= $_GET['tipo'];
   			 	
    			$fecha1= $_GET['fecha1'];
    			
    			
    			$cajero= $_GET['cajero'];
  
   		 	 	 
    			$gestion->BusquedaGrilla($estado,$fecha1,$cajero);
   			 	 
   			 }
 
  
  
   
 ?>
 
  