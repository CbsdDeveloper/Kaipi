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
      public function BusquedaGrilla($ffecha1,$ffecha2,$idprove){
      
      	
          $this->actualiza_pago( );
          
          $cadena4 = '';
          
          if ($idprove  <> '-'){
              
              $cadena4 =  '( idprov = '.$this->bd->sqlvalue_inyeccion(trim($idprove),true).') and ';
              
          }else{
              
              $sql = "update co_asiento
                   set marca =".$this->bd->sqlvalue_inyeccion('N', true)."
                where marca = ". $this->bd->sqlvalue_inyeccion('S', true) ;
              
              
              $this->bd->ejecutar($sql);
              
          }
      
       	$cadena0 =  '( registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
       	$cadena1 = '( estado ='.$this->bd->sqlvalue_inyeccion(trim('aprobado'),true).") and ";
       	
       	$cadena5 = '( transaccion <>'.$this->bd->sqlvalue_inyeccion(trim('X'),true).") and ";
      	
       	$cadena3 = '( estado_pago ='.$this->bd->sqlvalue_inyeccion(trim('N'),true).") and ";
       
      	$cadena2 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
      	$where = $cadena0.$cadena1.$cadena3.$cadena4.$cadena5.$cadena2;
      	
      	$sql = 'SELECT id_asiento, fecha, comprobante,idprov, beneficiario, detalle,  apagar
                from view_cxp 
                where '. $where.' order by id_asiento';
      	
    	
 
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 	      $output[] = array (
      				    $fetch['id_asiento'],
 						$fetch['fecha'],
      				    $fetch['comprobante'],
      				    $fetch['idprov'],
 	                    $fetch['beneficiario'],
         	            $fetch['detalle'],
 	                    $fetch['apagar'] 
      		
      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
    //----------------------------------  	
   	public function actualiza_pago( ){
   	    
   	    $sql="SELECT id_asiento,idprov
                from view_cxp 
                where estado_pago = 'N'";
   	    
   	    $resultado  = $this->bd->ejecutar($sql);
   	    
    	    
   	    while ($fetch=$this->bd->obtener_fila($resultado)){
   	        
   	        $id_asiento =  $fetch['id_asiento'];
   	        $idprov     =   trim($fetch['idprov']);
   	        
   	        $x = $this->bd->query_array('co_asiento_aux','sum(haber) - sum(debe) as monto', 
   	                                    'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true).' and 
                                         idprov = '.$this->bd->sqlvalue_inyeccion($idprov,true)." and cuenta like '2%'"
   	            );
   	        
   	        $sqlEdit ="update  co_asiento 
                        set apagar = ".$this->bd->sqlvalue_inyeccion($x['monto'],true).' 
                        where id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true);
   	        
   	        $this->bd->ejecutar($sqlEdit);
   	    }
   	    
      	    
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
            	$idprove= $_GET['idprove'];
             	 
            	$gestion->BusquedaGrilla($ffecha1,$ffecha2,$idprove);
            	 
            }
  
  
   
 ?>
 
  