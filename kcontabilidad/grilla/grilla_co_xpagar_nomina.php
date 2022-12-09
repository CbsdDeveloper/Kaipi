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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
           
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
                $this->anio       =  $_SESSION['anio'];
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($tipo){
      
        	
      	$sql = "SELECT id_tramite, fcompromiso,comprobante,  unidad,user_sol,detalle,proveedor
                FROM presupuesto.view_pre_tramite
                where tipo=  'N' and estado = ".$this->bd->sqlvalue_inyeccion($tipo,true). " and anio=".$this->bd->sqlvalue_inyeccion($this->anio ,true);
                      	
      	$output = array();
      	
      	$resultado  = $this->bd->ejecutar($sql);
       	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
  	      $output[] = array (
      				    $fetch['id_tramite'],
 						$fetch['fcompromiso'],
 	                    $fetch['proveedor'],
 	                    $fetch['comprobante'],
      				    $fetch['unidad'],
      				    $fetch['detalle']
       		
      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
}
//------------------ 
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
    		if (isset($_GET['tipo']))	{
    		    
    		 
    		    $tipo= $_GET['tipo'];
    		    
    		    
    		    $gestion->BusquedaGrilla($tipo);
    		    
    		}
 
  
   
 ?>
 
  