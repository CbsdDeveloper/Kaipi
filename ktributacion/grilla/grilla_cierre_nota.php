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
      public function BusquedaGrilla(  $nc_anio ){
      
          $output = array();
          
          $sql1 = "SELECT a.fechaemision, a.idcliente, b.razon,  a.secuencial, 
                     	    a.cab_autorizacion, a.numdocmodificado, a.valorretbienes,a.fecha_factura,a.id_diario
                    FROM doctor_vta a
                    join par_ciu b on a.idcliente = b.idprov and 
                         date_part('year'::text, a.fechaemision) = ".$this->bd->sqlvalue_inyeccion( $nc_anio ,true) ." and 
                         a.registro =".$this->bd->sqlvalue_inyeccion($this->ruc,true) ;

            
          $resultado = $this->bd->ejecutar($sql1);
      
       	while ($fetch=$this->bd->obtener_fila($resultado)){
      	    
      		$output[] = array (
      		                    $fetch['fechaemision'],
                                trim($fetch['idcliente']),
      		                    trim($fetch['razon']),
                                trim($fetch['secuencial']),
                                trim($fetch['cab_autorizacion']),
                                trim($fetch['numdocmodificado']) ,
      		                    $fetch['valorretbienes'] ,
      		                    $fetch['fecha_factura'] ,
      		                    $fetch['id_diario'] ,
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
     
            $nc_anio        = $_GET['nc_anio'];

   		   $gestion->BusquedaGrilla(  $nc_anio);
   
 
  
  
   
 ?>
 
  