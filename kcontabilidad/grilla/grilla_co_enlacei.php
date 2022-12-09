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
            //inicializamos la clase para conectarnos a la bd
 
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
      public function BusquedaGrilla( $tipo  ){
      
 
        	
      	$sql = 'SELECT   partida, detalle, clasificador,cuenta, nombre_cuenta, anio
                FROM presupuesto.view_enlace_contable_ingreso
                where  clasificador like '.$this->bd->sqlvalue_inyeccion( $tipo.'%',true).'  and 
                       anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' 
                order by partida';
                      	
 
      	$output = array();
      	
      	$resultado  = $this->bd->ejecutar($sql);
       	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
  	      $output[] = array (
      				        trim($fetch['partida']),
                      trim($fetch['detalle']),
                      trim($fetch['clasificador']),
  	                  trim($fetch['cuenta']),
                      trim($fetch['nombre_cuenta'])
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
     		
    		$tipo = $_GET['tipo'];

    		$gestion->BusquedaGrilla($tipo );
            	 
 
  
   
 ?>
 
  