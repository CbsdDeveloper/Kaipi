<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
                $this->sesion 	 =  trim($_SESSION['email']);
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($idsede,$vestado,$ffecha1,$ffecha2){
      
          $cadena1 =  '( idsede = '.$this->bd->sqlvalue_inyeccion($idsede ,true).') and ';
          
          $cadena2 =  '( tipo = '.$this->bd->sqlvalue_inyeccion('B',true).') and ';
          
          $cadena3 = '( estado ='.$this->bd->sqlvalue_inyeccion(trim($vestado),true).") and ";
          
          $cadena4 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
          
             
          
          $where = $cadena1.$cadena2.$cadena3.$cadena4;
          
          $sql = 'SELECT id_acta, documento, fecha, detalle, resolucion
                    from activo.ac_movimiento 
                   where '. $where;
 
          
          $resultado  = $this->bd->ejecutar($sql);
          
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
            $x = $this->bd->query_array('activo.ac_movimiento_det',
            'count(*) as nn',
            'id_acta='.$this->bd->sqlvalue_inyeccion( $fetch['id_acta'],true)
            );
            
       	    
		 	$output[] = array (
		      				    $fetch['id_acta'],
                		 	    $fetch['documento'],
                		 	    $fetch['fecha'],
                		 	    $fetch['detalle'],
		 	                    $fetch['resolucion'] ,
                                $x['nn']
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
    
            
 
                $idsede    = $_GET['vidsede'];
                $vestado   = $_GET['vestado'];
                $ffecha1   = $_GET['ffecha1'];
                $ffecha2   = $_GET['ffecha2'];
                 
        	 
                $gestion->BusquedaGrilla($idsede,$vestado,$ffecha1,$ffecha2);
 
  
  
   
 ?>
 
  