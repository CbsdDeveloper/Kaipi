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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( $nombre,$mes ){
      
      	
        $anio =   $_SESSION['anio'];

        $nombre = strtoupper(trim( $nombre )) . '%';
     
        $cadena0 = 'anio = '.$this->bd->sqlvalue_inyeccion( $anio,true). ' and ( registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
        
      	$cadena1 = ' mes = '.$this->bd->sqlvalue_inyeccion( $mes ,true). ' and ( razon like '.$this->bd->sqlvalue_inyeccion( $nombre,true).")  ";
 
 
      	
      	$sql = 'SELECT *
                from view_aux   where '. $cadena0.$cadena1.' order by razon,id_asiento';
      	
 
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	  	    
      	    
             	$output[] = array (
                  				    $fetch['id_asiento_aux'],
                                    $fetch['fecha'],
             						trim($fetch['cuenta']),
             	                    trim($fetch['cuenta_detalle']),
             	                    trim($fetch['razon']),
                                    trim($fetch['pago']),
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
  
          
            
            	$nombre = $_GET['nombre'];
             
            	$mes    = $_GET['mes'];
            	
            	$gestion->BusquedaGrilla($nombre,$mes);
            	 
             
            	 
   
  
  
   
 ?>
 
  