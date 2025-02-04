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
      public function BusquedaGrilla($id_importacionfac) {
      
          $output = array();
          
          $total_peso =  $this->total_variable($id_importacionfac) ;
          
          $this->edita_valor($id_importacionfac,$total_peso);
          
          
          $where = ' a.id_importacion = '.$this->bd->sqlvalue_inyeccion($id_importacionfac,true).' and a.idproducto = b.idproducto  ';
             
          $sql = 'SELECT  a.id_importacionfacitem,  a.idproducto, a.partida, a.cantidad, a.costo, a.peso_item, 
                          a.advalorem, a.infa, a.iva, a.salvaguardia, a.aranceles,
                          (a.advalorem + a.infa + a.salvaguardia + a.aranceles) as tt,
                          b.producto, b.referencia,a.porcentaje, a.costo1, a.costo2, a.costoitem
                from inv_importaciones_fac_item a, web_producto b
                where '. $where;
          

          
          $resultado  = $this->bd->ejecutar($sql);
          
        
          $i = 1;
          
          while ($fetch=$this->bd->obtener_fila($resultado)){
              
              $output[] = array (
                  $fetch['partida'],
                  $fetch['producto'],
                  $fetch['costo'],
                  $fetch['advalorem'],
                  $fetch['tt'],
                  $fetch['costo1'],
                  $fetch['porcentaje'],
                  $fetch['costo2'],
                  $fetch['costoitem'] ,
                  $fetch['id_importacionfacitem'] 
              );
              
              
              $i =  $i + 1;
              
          }
       
      	
      	 echo json_encode($output);
      	
      	
      	}
      	//--------------------------------------------------
      	public function total_variable($id_importacionfac) {
      	    
      	    
      	    $x = $this->bd->query_array('inv_importaciones_fac_item',
      	                                'sum(costo)  as total', 
      	                                'id_importacion='.$this->bd->sqlvalue_inyeccion($id_importacionfac,true)
      	        );
      	    
      	    return $x['total'];
      	    
      	}
      	//---------------
      	public function edita_valor($id_importacionfac,$total) {
      	    
      	    
      	    $sql = 'SELECT id_importacionfacitem,   cantidad, costo,
	                         costo  as parcial	,
                    		 (advalorem/cantidad) + (infa/cantidad)  +  (salvaguardia/cantidad)  + (aranceles/cantidad)  as costo_importa,  
                    		porcentaje, costo1, costo2, costoitem
            FROM inv_importaciones_fac_item
            where id_importacion = '.$this->bd->sqlvalue_inyeccion($id_importacionfac,true);
      	    
       	    
      	    $resultado1  = $this->bd->ejecutar($sql);
      	   	    
      	    while ($fetch=$this->bd->obtener_fila($resultado1)){
      	        
      	        $porcentaje  = ($fetch['parcial'] / $total) * 100;
      	        $id          = $fetch['id_importacionfacitem'] ;
      	        $costo       = $fetch['costo_importa']  +  $fetch['costo']  ;
      	        
      	        $sql = " UPDATE inv_importaciones_fac_item
							              SET 	costo1      =".$this->bd->sqlvalue_inyeccion($costo, true).",
											    porcentaje  =".$this->bd->sqlvalue_inyeccion(round($porcentaje,2), true)." 
							      WHERE id_importacionfacitem=".$this->bd->sqlvalue_inyeccion($id, true);
      	        
      	        $this->bd->ejecutar($sql);
      	        
      	        
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
    		if (isset($_GET['id']))	{
    			
    		    $id_importacionfac  = $_GET['id'];
     	 		
    		    $gestion->BusquedaGrilla($id_importacionfac);
    			
    		}
    		
    		
    	 
    	 
    		
         
  
  
  
   
 ?>
 
  