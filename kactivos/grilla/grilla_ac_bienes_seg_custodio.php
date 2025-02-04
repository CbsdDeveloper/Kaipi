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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($codigo,$accion){
      
  
          $valor = trim($codigo);
          
          if ( trim($accion)  == 'user'){
              
              
              $sql = "SELECT id_acta, clase_documento, documento, fecha, estado, detalle, resolucion, 
                             idprov, idprov_entrega, tipo 
                FROM activo.ac_movimiento
                where idprov =  ". $this->bd->sqlvalue_inyeccion($valor,true)." and 
                      trim(clase_documento)  <> 'Acta Baja de Bienes'
                union 
                SELECT id_acta, clase_documento, documento, fecha, estado, detalle, resolucion, 
                    idprov, idprov_entrega, tipo 
                FROM activo.ac_movimiento
                where idprov_entrega = ". $this->bd->sqlvalue_inyeccion($valor,true)." and 
                      trim(clase_documento) <> 'Acta Baja de Bienes'";

             
              $resultado  = $this->bd->ejecutar($sql);
           
              
           }else {
              
               $qquery = array(
                   array( campo => 'id_acta',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'clase_documento',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'nombre_entrega',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'modificacion',valor => '-',filtro => 'N', visor => 'S'),
                   array( campo => 'id_bien',     valor => $valor,filtro => 'S', visor => 'S')
               );
               
             
               
               $resultado = $this->bd->JqueryCursorVisor('activo.view_acta_detalle',$qquery );
               
          }
          
         
 /*
          
          
          SELECT estado, id_acta_det, id_acta, id_bien, sesion, creacion, marca, tipo, tipo_bien, descripcion, serie, estado_bien, 
          costo_adquisicion, clasificador, clase, anio, razon, fecha, clase_documento, documento, detalle, resolucion, idprov, unidad
          FROM activo.;
          
       */   
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $detalle =  trim($fetch['detalle']);
      	    
      	    if ( trim($accion) == 'item'){
      	        $detalle =  $fetch['razon'] . ' -> ' .$fetch['nombre_entrega']. ' - ' .$detalle;
      	    }
      	    
      	    
      	    if ( trim($accion) == 'user'){
      	        
      	        
      	        $xx = $this->bd->query_array('par_ciu',   // TABLA
      	            'razon',                        // CAMPOS
      	            'idprov='.$this->bd->sqlvalue_inyeccion( trim($fetch['idprov']),true) // CONDICION
      	            );
      	        
      	        $xy = $this->bd->query_array('par_ciu',   // TABLA
      	            'razon',                        // CAMPOS
      	            'idprov='.$this->bd->sqlvalue_inyeccion( trim($fetch['idprov_entrega']),true) // CONDICION
      	            );
      	        
      	        if (empty($xy['razon'])){
      	            $detalle =  $xx['razon'] .' - ' .$detalle;
      	        }else{
      	            $detalle =  $xx['razon'] . ' -> ' .$xy['razon']. ' - ' .$detalle;
      	        }
            	        
      	    }
      	    
		 	$output[] = array (
		      				    $fetch['id_acta'],
		 						trim($fetch['clase_documento']),
		      				    trim($fetch['documento']),
		      				    $fetch['fecha'],
		 	                    $detalle,
                 		 	    $fetch['modificacion']
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
 
    		$gestion   = 	new proceso;
 
 
            //------ consulta grilla de informacion
            if (isset($_GET['accion']))	{
            
 
              
                $codigo = $_GET['codigo'];
                $accion  = $_GET['accion'];
              	 
                $gestion->BusquedaGrilla($codigo,$accion);
            	 
            }
  
  
   
 ?>
 
  