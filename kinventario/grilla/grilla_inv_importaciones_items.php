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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($id_importacionfac) {
      
          
          $where = ' a.id_importacionfac = '.$this->bd->sqlvalue_inyeccion($id_importacionfac,true).' and a.idproducto = b.idproducto  ';
             
          $sql = 'SELECT  a.id_importacionfacitem,  a.idproducto, a.partida, a.cantidad, a.costo, a.peso_item, 
                          a.advalorem, a.infa, a.iva, a.salvaguardia, a.aranceles,
                          b.producto, b.referencia
                from inv_importaciones_fac_item a, web_producto b
                where '. $where;
          
 
          $resultado  = $this->bd->ejecutar($sql);
          
        
          $i = 1;
          
          while ($fetch=$this->bd->obtener_fila($resultado)){
              
              $output[] = array (
                  $fetch['partida'],
                  $fetch['producto'],
                  $fetch['peso_item'],
                  $fetch['cantidad'],
                  $fetch['costo'],
                  $fetch['advalorem'],
                  $fetch['aranceles'],
                  $fetch['infa'],
                  $fetch['iva'] ,
                  $fetch['id_importacionfacitem'] 
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
    		if (isset($_GET['id_importacionfac_key']))	{
    			
    		    $id_importacionfac  = $_GET['id_importacionfac_key'];
     	 		
    		    $gestion->BusquedaGrilla($id_importacionfac);
    			
    		}
    		
    		
    	 
    	 
    		
         
  
  
  
   
 ?>
 
  