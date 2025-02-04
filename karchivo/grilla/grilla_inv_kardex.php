<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class grilla_inv_kardex{
 
  
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function grilla_inv_kardex( ){
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
      
 
          $filtro   = 'S';
          $longitud = strlen($idproducto);
          
          if ( $longitud  > 5)  {
              $carga      = 'S' ;
              $idproducto = strtoupper(trim($idproducto)).'%';
              $filtro = 'N';
          }else{
              $carga = 'N' ;
              $filtro = 'S';
          }
 
          
      	$qquery = 
      			array( 
      			array( campo => 'producto',   valor => 'LIKE.'.$idproducto,  filtro =>$carga,   visor => 'S'),
      			array( campo => 'cuenta_inv',   valor => $idcategoria,  filtro => $filtro,   visor => 'S'),
      			array( campo => 'ingreso',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'egreso',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'saldo',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'minimo',   valor => '-',  filtro => 'N',   visor => 'S'),
      		    array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'promedio',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'lifo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'tipo',   valor => 'B',  filtro => 'S',   visor => 'S'),
      			    array( campo => 'idcategoria',   valor => '-',  filtro => 'N',   visor => 'N') ,
      			    array( campo => 'estado',   valor => 'S',  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'registro',   valor => $this->ruc,  filtro => 'S',   visor => 'N') ,
      			    array( campo => 'idproducto',   valor =>'N',  filtro => 'N',   visor => 'S') 
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
      		                    $fetch['cuenta_inv'],
      		                    round($fetch['ingreso'],2),
      		                    round($fetch['egreso'],2),
      		                    round($fetch['saldo'],4),
      		                    round($fetch['promedio'],4), 
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
 
    		$gestion   = 	new grilla_inv_kardex;
     
   
   			 //------ consulta grilla de informacion
   			 if (isset($_GET['idcategoria']))	{
   			 
    			     
    			     
    			 	
   			     $idcategoria= $_GET['idcategoria'];
   			 	
   			     $idproducto= $_GET['idproducto'];
   			 	
    		 	 	 
   			     $gestion->BusquedaGrilla( $idcategoria,$idproducto);
   			 	 
   			 }
 
  
  
   
 ?>
 
  