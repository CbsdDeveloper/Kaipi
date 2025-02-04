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
      public function BusquedaGrilla($id_importacion) {
      
 
  
          
          $where = ' id_importacion = '.$this->bd->sqlvalue_inyeccion($id_importacion,true).'   ';
          
      
          
          $sql = 'SELECT id_importacionfac, id_importacion, fechafactura, registro, factura, nombre_factura, naturaleza, iconterm, valor
                from inv_importaciones_fac where '. $where;
          
 
 
          $resultado  = $this->bd->ejecutar($sql);
          
        
          $i = 1;
          
          while ($fetch=$this->bd->obtener_fila($resultado)){
              
              
              $x = $this->bd->query_array('inv_importaciones_fac_item', 
                                          'count(*) as nn', 
                                          'id_importacionfac='.$this->bd->sqlvalue_inyeccion($fetch['id_importacionfac'] ,true)
                  );
 
              
              $output[] = array (
                  $i,
                  $fetch['fechafactura'],
                  $fetch['factura'],
                  $fetch['nombre_factura'],
                  $fetch['valor'],
                  $fetch['naturaleza'],
                  $x['nn'],
                  $fetch['id_importacionfac'] 
              );
              
              
              $i =  $i + 1;
              
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
    		if (isset($_GET['id_importacion']))	{
    			
    		    $id_importacion  = $_GET['id_importacion'];
     	 		
    		    $gestion->BusquedaGrilla($id_importacion);
    			
    		}
    		
    		
    	 
    	 
    		
         
  
  
  
   
 ?>
 
  