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
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase proceso
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->anio       =  $_SESSION['anio'];
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2){
      
     
        $fmodulo = 'anticipo';
     
      	$cadena5 =  '( a.anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).') and ';
      	
       	$cadena0 =  '( a.registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
      	$cadena1 = '( a.estado ='.$this->bd->sqlvalue_inyeccion(trim($festado),true).") and ";
      
      	$cadena2 = '( a.fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
       $cadena01 =  '( a.modulo = '.$this->bd->sqlvalue_inyeccion(trim($fmodulo),true).') and ';
     
      	 
      	
      	$where = $cadena0.$cadena5.	$cadena1.$cadena01.$cadena2;
      	
      	$sql = 'SELECT a.id_asiento,
                       a.fecha,
                       a.comprobante,
                       a.detalle,  a.sesion, a.documento,
                       a.tipo,
                       a.modulo,a.apagar,a.base,a.proveedor
                from view_asientos a where '. $where;
      	
      
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 	          $output[] = array (
      				    $fetch['id_asiento'],
 						      $fetch['fecha'],
						      $fetch['comprobante'],
 	                trim($fetch['detalle']).' '.trim($fetch['proveedor']),
      				    trim($fetch['documento']),
                  trim($fetch['apagar']),
                  trim($fetch['base'])
        		);	 
      		
      	}
 
 
      	pg_free_result($resultado);
      	
       echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------ 
    		$gestion   = 	new proceso;
          
            if (isset($_GET['festado']))	{
            
            	$festado= $_GET['festado'];
            	$ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
             
             	 
            	
            	
            	$gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2);
            	 
            }
  
  
   
 ?>
 
  