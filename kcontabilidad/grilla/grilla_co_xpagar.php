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
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2){
      
      	
      	$sql_ruc ='(SELECT x.razon FROM par_ciu x where x.idprov = a.idprov) as razon';
     
       	$cadena0 =  '( a.registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
      	$cadena1 = '( a.estado ='.$this->bd->sqlvalue_inyeccion(trim($festado),true).") and ";
      	
      	$cadena00 = '( a.modulo ='.$this->bd->sqlvalue_inyeccion(trim('cxpagar'),true).") and ";
      
      	$cadena2 = '( a.fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	
      	$where = $cadena00.$cadena0.$cadena1.$cadena2;
      	
      	$sql = 'SELECT a.id_asiento,
                       a.fecha,
                       a.comprobante,
                       a.detalle,'.$sql_ruc.',
                       a.tipo, a.estado_pago,
                       a.modulo, a.documento, a.idprov
                from co_asiento a where '. $where;
      	
       
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	  
      	  $comprobante = $this->_11_ActualizaMovimiento( $fetch['id_asiento'],  trim($fetch['idprov']) );
      	  
      	  if (empty($comprobante)){
      	      
      	      $imagen  = '<img src="../../kimages/star.png" align="absmiddle"   />';
      	
      	  }else{
      	   
      	      $imagen  = '<img src="../../kimages/starok.png" align="absmiddle"   />';
      	  
      	  }
      	  
      	  
      	    
 	      $output[] = array (
      				    $fetch['id_asiento'],
 						$fetch['fecha'],
 	                    $fetch['comprobante'],
      				    $fetch['razon'],
 	                    $fetch['documento'],
      				    $fetch['detalle'],
 	                    $fetch['estado_pago'],
 	                    $imagen
      		
      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
      	
//------------------ 
function _11_ActualizaMovimiento($id ,$idprov  ){
      	    
      	    $Array_Cabecera = $this->bd->query_array(
      	        'view_anexos_compras',
      	        'secretencion1, autretencion1',
      	        'id_asiento ='.$this->bd->sqlvalue_inyeccion($id,true).' and codigoe = 1 and 
                 idprov ='.$this->bd->sqlvalue_inyeccion($idprov,true)
      	        );
      	    
      	     
      	    
      	 return $Array_Cabecera['autretencion1'] ;
      	    
  
      	    
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
             	 
            	$gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2);
            	 
            }
  
  
   
 ?>
 
  