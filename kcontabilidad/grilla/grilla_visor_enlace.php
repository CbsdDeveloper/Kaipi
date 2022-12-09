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
      public function BusquedaGrilla($ffecha1,$ffecha2,$cuentaa){
      
      	
 
          
  
      
 
        $cadena3 = '( cuenta like '.$this->bd->sqlvalue_inyeccion($cuentaa.'%',true).") and ";
       
      	$cadena2 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
      	$where =  $cadena3.$cadena2;
      	
      	$sql = 'Select id_asiento,id_asientod ,detalle,cuenta,item,debe, haber,partida,fecha
                from view_diario_conta 
                where '. $where.' 
                group by id_asiento,id_asientod ,detalle,cuenta,item,debe, haber,partida,fecha
      	        order by  id_asiento';
      	
 
      	$resultado  = $this->bd->ejecutar($sql);
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 	      $output[] = array (
      				    $fetch['id_asiento'],
 						$fetch['id_asientod'],
      				    trim($fetch['detalle']),
 	                    trim($fetch['cuenta']),
             	        trim($fetch['item']),
 	                    trim($fetch['partida']),
         	            $fetch['debe'],
 	                    $fetch['haber'] 
      		
      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
    //----------------------------------  	
   	public function actualiza_pago( ){
   	    
   	   
   	    
      	    
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
            if (isset($_GET['ffecha1']))	{
            
             	$ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
            	$idprove= $_GET['cuentaa'];
            	
            	
             	 
            	$gestion->BusquedaGrilla($ffecha1,$ffecha2,$idprove);
            	 
            }
  
  
   
 ?>
 
  