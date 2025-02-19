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
      public function BusquedaGrilla(){
      
       
      	$qquery = 
      			array( 
      			    array( campo => 'id_cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'productos',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'competencias',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'jerarquico',   valor => '-',  filtro => 'N',   visor => 'S')
       			);
      
       
        $output = array();
      			
      	$resultado = $this->bd->JqueryCursorVisor('nom_cargo',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 

          $hora = $this->bd->query_array('view_nomina_rol',  
          'count(*) as nn',                       
          'id_cargo='.$this->bd->sqlvalue_inyeccion(  trim( $fetch['id_cargo']),true) 
          );

 

      		$output[] = array (
      							$fetch['id_cargo'],
                    $fetch['nombre'],
                    $fetch['productos'],
      		          $fetch['competencias'] , 
                    $fetch['jerarquico'] ,
                    $hora['nn'] ,
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
     
        	$gestion->BusquedaGrilla();
   			 	 
 
  
  
   
 ?>
 
  