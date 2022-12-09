<?php 
session_start();   
  
    require '../../kconfig/Db.class.php';   
 	
    require '../../kconfig/Obj.conf.php';  
  
  
    class proceso{
 
    
 
      private $obj;
      private $bd;
      
      public  $ruc;
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
 
                $this->ruc = $_SESSION['ruc_registro'];
                
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($PK_codigo,$concepto,$bitem){
      
          $cuenta       = '';
          $detalle      = '';
          $clasificador = '';
      
          $anio = $_SESSION['anio'];
     
      
      if (!empty($PK_codigo)) {
          $cuenta = ' and  cuenta like '.$this->bd->sqlvalue_inyeccion($PK_codigo.'%',true);
          $detalle = '';
          $clasificador = '';
       }
      
       if (!empty($concepto)) {
           $detalle = ' and  detalle like '.$this->bd->sqlvalue_inyeccion($concepto.'%',true);
           $cuenta = '';
           $clasificador = '';
       }
      
       if (!empty($bitem)) {
           $detalle = '';
           $cuenta = '';
           $clasificador = ' and  ( debito like '.$this->bd->sqlvalue_inyeccion($bitem.'%',true).' or 
                                    credito like '.$this->bd->sqlvalue_inyeccion($bitem.'%',true).') ';
       }
       
       
       $output = array();
      
       $sql = 'SELECT cuenta, detalle,univel, nivel, impresion, registro,estado
                FROM co_plan_ctas
                where anio = '.$this->bd->sqlvalue_inyeccion($anio ,true).' and  
                      registro = '.$this->bd->sqlvalue_inyeccion($this->ruc,true) .$cuenta.$detalle.$clasificador;
       
       $resultado  = $this->bd->ejecutar($sql);

        $i = 1;
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    $estado = 'N';
      	    
      	  	    
      	   
      	    if ($fetch['impresion'] == '1'){
                $check ='checked';
            }else{
                $check =' ';
            }

            if (trim($fetch['estado']) == 'S'){
                $check1 ='checked';
            }else{
                $check1 =' ';
            }

      		$output[] = array (
      		                trim($fetch['cuenta']),
      		                trim($fetch['detalle']),
                             trim($check1),
      		                $fetch['univel'],
      		                $fetch['nivel'],
      		                trim($check),
      		                $i
      		);
      		 
      		$i++;
      	}

      	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 
 
    		$gestion   = 	new proceso;
          
            //------ consulta grilla de informacion
            if (isset($_GET['GrillaCodigo']))	{
            
            	$PKcodigo  = $_GET['GrillaCodigo'];
            	
            	$detalle = $_GET['detalle'];
             	 
            	$bitem = $_GET['bitem'];
            	
            	$gestion->BusquedaGrilla(trim($PKcodigo) ,trim($detalle),trim($bitem));
            	 
            }
  
  
   
?>
