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
      public function BusquedaGrilla($idbancos,$ffecha1,$ffecha2){
      
      	$array = explode("-", $ffecha2);
      	
      	$anio = $array[0];
      	
      	$sql_where =  "registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." AND
					   cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true). " AND
					   fecha < ". $this->bd->sqlvalue_inyeccion($ffecha1,true). " AND
					   anio = ". $this->bd->sqlvalue_inyeccion($anio,true);	
      	
       $Asaldos = $this->bd->query_array( 'view_bancos',
     									  '(sum(debe) - sum(haber)) as saldo', 
     									  $sql_where);
      	
      	
      	
      	$sql = "SELECT fecha,id_asiento,comprobante,cheque,razon,detalle,debe,haber
      					FROM view_bancos
						WHERE registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." AND
							cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true). " AND
                            fecha BETWEEN ". $this->bd->sqlvalue_inyeccion($ffecha1,true)." AND ".
                                             $this->bd->sqlvalue_inyeccion($ffecha2,true)."
				order by fecha asc";
      	
      	  
      	
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	$saldo = $Asaldos['saldo'];
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      	
     	$saldo = $saldo +$fetch['debe'] - $fetch['haber'];
      
      
      		
      		$output[] = array (
	      					$fetch['fecha'],
	      				    $fetch['id_asiento'],
	      				    $fetch['comprobante'],
	      				    $fetch['cheque'],
	      				    $fetch['razon'],
	      				   $fetch['detalle'],
	      				   $fetch['debe'],
	      				   $fetch['haber'],
      					   round($saldo,2)
      				);
      		
      	}
      	
      

      	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['idbancos']))	{
            
            	$idbancos= $_GET['idbancos'];
            	$ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
             	 
            	$gestion->BusquedaGrilla($idbancos,$ffecha1,$ffecha2);
            	 
            }
  
  
   
 ?>
 
  