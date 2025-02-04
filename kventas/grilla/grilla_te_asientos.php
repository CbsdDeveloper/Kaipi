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
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
     
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->anio       =  $_SESSION['anio'];
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2,$fmodulo){
      
     
     
      	$cadena5 =  '( a.anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).') and ';
      	
       	$cadena0 =  '( a.registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
      	$cadena1 = '( a.estado ='.$this->bd->sqlvalue_inyeccion(trim($festado),true).") and ";
      
      	$cadena2 = '( a.fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	if ( $fmodulo == '-'){
      	    $cadena01 =  '';
      	}
      	else {
      	    $cadena01 =  '( a.modulo = '.$this->bd->sqlvalue_inyeccion(trim($fmodulo),true).') and ';
      	}
      
      	
      	
      	$where = $cadena0.$cadena5.$cadena01.$cadena1.$cadena2;
      	
      	$sql = 'SELECT a.id_asiento,
                       a.fecha,
                       a.comprobante,
                       a.detalle, a.razon,a.login,
                       a.tipo,
                       a.modulo
                from view_asientos_diario a where '. $where;
      	
       
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 	          $output[] = array (
      				    $fetch['id_asiento'],
 						$fetch['fecha'],
						$fetch['comprobante'],
 	                    trim($fetch['detalle']).' '.trim($fetch['razon']),
      				    trim($fetch['login'])
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
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['festado']))	{
            
            	$festado= $_GET['festado'];
            	$ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
            	$fmodulo= $_GET['fmodulo'];
             	 
            	
            	$gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2,$fmodulo);
            	 
            }
  
  
   
 ?>
 
  