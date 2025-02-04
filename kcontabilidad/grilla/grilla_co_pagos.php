<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
                $this->anio       =  $_SESSION['anio'];
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2,$idbancos  ){
      
      	
      	$fecha = ' fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
      				               $this->bd->sqlvalue_inyeccion($ffecha2,true) ;
      	
      				               
      	
      	$sql = "SELECT  fecha,   razon,cheque, detalle, monto,id_asiento_aux,tipo,id_asiento
				  FROM view_auxbancos
				 WHERE monto > 0 and 
                       anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)."  and 
                       pago =  ".$this->bd->sqlvalue_inyeccion(trim($festado),true). " AND 
					   cuenta =  ".$this->bd->sqlvalue_inyeccion($idbancos,true). " AND 
					   registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND " . 
      				   $fecha;
      	
         	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 			$output[] = array (
 			             $fetch['id_asiento'],
      				    $fetch['fecha'],
      				    $fetch['razon'],
      				    $fetch['cheque'],
 					    $fetch['detalle'],
 					    $fetch['monto'],
 			             $fetch['tipo'],
 					    $fetch['id_asiento_aux']
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
            if (isset($_GET['festado']))	{
            
            	$festado= $_GET['festado'];
            	$ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
            	$idbancos= $_GET['idbancos'];
            	
            	
            	
            	$gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2,$idbancos);
            	 
            }
  
  
   
 ?>
 
  