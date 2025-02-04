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
      public function BusquedaGrilla($idprove){
      
      	
          $cadena4 = '';
          
          $sql = "update co_asiento
                   set marca =".$this->bd->sqlvalue_inyeccion('N', true)."
                where marca = ". $this->bd->sqlvalue_inyeccion('S', true) ;
          
          
          $this->bd->ejecutar($sql);
          
 
     
       	$cadena0 =  '( registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
       	$cadena1 = '( estado ='.$this->bd->sqlvalue_inyeccion(trim('aprobado'),true).") and ";
       	
       	$cadena3 = '( estado_pago ='.$this->bd->sqlvalue_inyeccion(trim('N'),true).") and ";
       
  
       	$cadena4 =  '( idprov = '.$this->bd->sqlvalue_inyeccion(trim($idprove),true).')   ';
       	
       	
      	$where = $cadena0.$cadena1.$cadena3.$cadena4;
      	
      	$sql = 'SELECT id_asiento, fecha, comprobante,idprov, beneficiario, detalle,  apagar
                from view_cxc 
                where '. $where;
      	
 
    	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
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
            if (isset($_GET['idprove']))	{
            
             	$idprove= $_GET['idprove'];
             	 
             	$gestion->BusquedaGrilla($idprove);
            	 
            }
  
  
   
 ?>
 
  