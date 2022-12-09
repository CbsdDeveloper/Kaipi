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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2,$fcuenta,$fbeneficiario='-'){
      
      	

     
        $cadena0 =  '( estado = '.$this->bd->sqlvalue_inyeccion(trim($festado),true).') and ';
        
        $cadena1 = '( cuenta ='.$this->bd->sqlvalue_inyeccion(trim($fcuenta),true).") and ";
        
 //       $cadena3 = '( beneficiario ='.$this->bd->sqlvalue_inyeccion(trim($fbeneficiario),true).") and ";
 
        $cadena3 = ' ';
      
      	$cadena2 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
      	$where = $cadena0.$cadena3.$cadena1.$cadena2;
      	
      	$sql = 'SELECT id_spi, fecha, fecha_envio, detalle, estado, beneficiario,
      	       referencia, sesion, creacion, sesionm, modificacion, anio, cuenta
                from tesoreria.spi_mov   where '. $where;
 
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
  
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
  
      	    
      	    $x = $this->bd->query_array('tesoreria.spi_mov_det',
      	                               'sum(monto_pagar) as tt', 
      	                                'id_spi='.$this->bd->sqlvalue_inyeccion($fetch['id_spi'],true)
      	        );
      	    
      	    
 	          $output[] = array (
      				    $fetch['id_spi'],
 						$fetch['referencia'],
						$fetch['fecha'],
       				    trim($fetch['detalle']),
         	              $fetch['beneficiario'],
         	              $fetch['sesionm'],
 	                      $x['tt']
        		);	 
      		
      	}
 
 
      	pg_free_result($resultado);
      	
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
            if (isset($_GET['ffecha1']))	{
            
                $ffecha1= $_GET['ffecha1'];
                $ffecha2= $_GET['ffecha2'];
                $festado= $_GET['festado'];
                $fcuenta= $_GET['fcuenta'];
                 
 
             	 
                $gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2,$fcuenta,'-');
            	 
            }
  
  
   
 ?>
 
  