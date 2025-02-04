<?php 
session_start( );   
  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php';   /*Incluimos el fichero de la clase objetos*/
  
class grilla_te_spi_pagos{
 
    
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function grilla_te_spi_pagos( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  trim($_SESSION['email']);
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($nanio,$ntipo,$nmes,$cuenta ,$nmes1){
      
      	

     
        $cadena0 =  '( tipo = '.$this->bd->sqlvalue_inyeccion( 'transferencia',true).') and ';
        
        $cadena1 =  "( coalesce(spi,'N') = 'N'  ) and monto_pago > 0 AND ";
        
        $cadena2 = '( anio ='.$this->bd->sqlvalue_inyeccion($nanio,true).") and ";
        
        $cadena5 = '( cuenta ='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true).") and ";
        
        $cadena3 = '( mes  between  '.$this->bd->sqlvalue_inyeccion($nmes,true).' and '. $this->bd->sqlvalue_inyeccion($nmes1,true).") and ";
      
        $cadena4 = '( modulo ='.$this->bd->sqlvalue_inyeccion($ntipo,true).")   ";
      	
        $where = $cadena0.$cadena1.$cadena2.$cadena5.$cadena3.$cadena4;
      	
      	$sql = 'SELECT id_asiento_aux, fecha, comprobante ,idprov,
      	               razon,  cod_banco, tipo_cta, cta_banco ,
                       detalle, monto_pago,anio,mes,modulo
                from view_bancos_pago  
                where '. $where.' order by fecha desc';
 
 
 
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
  
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
  
 
      	    
 	          $output[] = array (
      				    $fetch['id_asiento_aux'],
 						$fetch['comprobante'],
						$fetch['fecha'],
       				    trim($fetch['idprov']),
         	              trim($fetch['razon']),
          	              trim($fetch['detalle']),
         	              $fetch['monto_pago'] 
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
 
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new grilla_te_spi_pagos;
        
            //------ consulta grilla de informacion
            if (isset($_GET['nanio']))	{
            
                $nanio= $_GET['nanio'];
                $ntipo= $_GET['ntipo'];
                $nmes= $_GET['nmes'];
                $nmes1= $_GET['nmes1'];
                $cuenta= $_GET['ncuenta'];
                
 
                
 
             	 
                $gestion->BusquedaGrilla($nanio,$ntipo,$nmes ,$cuenta,$nmes1);
            	 
            }
  
 
 ?>
 
  