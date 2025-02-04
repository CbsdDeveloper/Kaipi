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
      public function BusquedaGrilla( $tipo,$fecha1,$fecha2){
      
          $this->_Verifica_suma_facturas();
       
      	$qquery = 
      			array( 
      			array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'proveedor',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'iva',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'base12',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'base0',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'tipo',   valor => $tipo,  filtro => 'S',   visor => 'N'),
      			    array( campo => 'estado',   valor => 'aprobado',  filtro => 'S',   visor => 'N'),
      			    array( campo => 'registro',   valor =>  $this->ruc,  filtro => 'S',   visor => 'N')
       			);
      
        // filtro para fechas
      	$this->bd->__between('fecha',$fecha1,$fecha2);
      			
      	$resultado = $this->bd->JqueryCursorVisor('view_inv_transaccion',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_movimiento'],
      		                    $fetch['fecha'],
      		                    $fetch['comprobante'],
      		                    $fetch['detalle'],
      		                    $fetch['idprov'],
      		                    $fetch['proveedor'],
      		                    $fetch['iva'], 
      		                    $fetch['base12'],
      		                    $fetch['base0'],
      		                    $fetch['total'] 
       					);
      	}	
      
      	pg_free_result($resultado);
      	
      	
      	echo json_encode($output);
      }
   
      function _Verifica_suma_facturas(   ){
          
          
          $sql_det1 = 'SELECT id_movimiento,    iva, base0, base12, total
                        FROM inv_movimiento
                        where base0 is null and base12 is null';
          
          
          
          $stmt1 = $this->bd->ejecutar($sql_det1);
          
          
          while ($x=$this->bd->obtener_fila($stmt1)){
              
              $id = $x['id_movimiento'];
              
              $ATotal = $this->bd->query_array(
                  'inv_movimiento_det',
                  'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
                  ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
                  );
              
              $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
              
              $this->bd->ejecutar($sqlEdit);
              
              
          }
          
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
   		 	 	 
   			 	$gestion->BusquedaGrilla( $tipo,$fecha1,$fecha2);
   			 	 
   			 }
 
  
  
   
 ?>
 
  