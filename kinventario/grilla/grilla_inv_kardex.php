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
      public function BusquedaGrilla(  $idcategoria,$idproducto ){
      
 
          
          if ( $idproducto  == '0')  {
              $carga = 'N' ;
          }else{
              $carga = 'S' ;
          }
 
          
      	$qquery = 
      			array( 
      			array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'cuenta_inv',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'ingreso',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'egreso',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'saldo',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'minimo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'promedio',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'lifo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'tipo',   valor => 'B',  filtro => 'S',   visor => 'S'),
      			    array( campo => 'idcategoria',   valor => $idcategoria,  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'estado',   valor => 'S',  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'registro',   valor => $this->ruc,  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'idproducto',   valor =>$idproducto,  filtro => $carga,   visor => 'S') 
        			);
 
      			
      	$resultado = $this->bd->JqueryCursorVisor('web_producto',$qquery );
      	
      	$output = array();
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    
      	    $x = $this->bd->query_array('view_movimiento_det_cta',
      	                                 'max(id_movimiento) id_movimiento', 
      	                                 "tipo='I' and idproducto=".$this->bd->sqlvalue_inyeccion($fetch['idproducto'],true)
      	        );
      	    
      	    $y = $this->bd->query_array('view_inv_movimiento',
      	        'razon',
      	        "id_movimiento=".$this->bd->sqlvalue_inyeccion($x['id_movimiento'],true)
      	        );
 
      	        
      	    
      		$output[] = array (
      							$fetch['idproducto'],
      		                    $fetch['producto'],
      		                    $fetch['minimo'],
      		                    $fetch['cuenta_inv'],
      		                    $fetch['ingreso'],
      		                    $fetch['egreso'],
      		                    $fetch['saldo'],
      		                    $fetch['promedio'], 
      		                    $fetch['lifo'],
      		                    $y['razon']
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
   			 if (isset($_GET['idcategoria']))	{
   			 
    			     
    			     
    			 	
   			     $idcategoria= $_GET['idcategoria'];
   			 	
   			     $idproducto= $_GET['idproducto'];
   			 	
    		 	 	 
   			     $gestion->BusquedaGrilla( $idcategoria,$idproducto);
   			 	 
   			 }
 
  
  
   
 ?>
 
  