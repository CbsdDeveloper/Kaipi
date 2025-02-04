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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( ){
      
      	
        $anio =   $_SESSION['anio'];
     
       	$cadena0 =" substring(cuenta,1,3) in ('213','224') and anio = ".$this->bd->sqlvalue_inyeccion( $anio,true). ' and   registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).'  and ';
        
      	$cadena1 = '( aux_busca ='.$this->bd->sqlvalue_inyeccion(0,true).")  ";
 
 
      	
      	$sql = 'SELECT id_asiento,  fecha, cuenta,asiento_detalle, detalle ,id_asientod, debe, haber
                from view_diario_aux a where '. $cadena0.$cadena1.' order by id_asiento';
      	
       
       	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	  	    
      	    
             	$output[] = array (
                  				        $fetch['id_asiento'],
                                  $fetch['fecha'],
             						          trim($fetch['cuenta']),
             	                    trim($fetch['detalle']),
             	                    trim($fetch['asiento_detalle']),
                                  trim($fetch['id_asientod']),
                             	    $fetch['debe'],
                             	    $fetch['haber']
                    		);	 
      		
      	}
 
 
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
  
            	
            	$gestion->BusquedaGrilla( );
            	 
   
  
  
   
 ?>
 
  