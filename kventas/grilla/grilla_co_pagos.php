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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
                $this->anio       =  $_SESSION['anio'];
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2,$idbancos  ){
      
      	
      	$fecha = ' fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
      				               $this->bd->sqlvalue_inyeccion($ffecha2,true) ;
      	
      				   
      	 if ($festado == '-'){
      	     
      	     $sql = "SELECT  fecha, spi,  razon,cheque, detalle, monto,id_asiento_aux,tipo,id_asiento,comprobantec,comprobante,idprov
				  FROM view_auxbancos
				 WHERE monto > 0 and
                       anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)."  and
                       cuenta =  ".$this->bd->sqlvalue_inyeccion($idbancos,true). " AND
					   registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND " .
					   $fecha;
      	 }
      	 else {
      	     $sql = "SELECT  fecha, spi,  razon,cheque, detalle, monto,id_asiento_aux,tipo,id_asiento,comprobantec,comprobante,idprov
				  FROM view_auxbancos
				 WHERE monto > 0 and
                       anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)."  and
                       pago =  ".$this->bd->sqlvalue_inyeccion(trim($festado),true). " AND
					   cuenta =  ".$this->bd->sqlvalue_inyeccion($idbancos,true). " AND
					   registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND " .
					   $fecha;
      	 }
      				               
      	
          	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $monto      =  number_format($fetch['monto'],2);
      	    $id_asiento =  $fetch['id_asiento'];
      	    $detalle    =  trim($fetch['detalle']);
      	    
      	    if ($fetch['spi'] == 'S' ){
      	        $monto =  $monto.' '.'<img src="../../kimages/spi.png" align="absmiddle" >';
      	    }
      	    
      	   
      	    
 			$output[] = array (
 			            $id_asiento,
      				    $fetch['fecha'],
 			            $fetch['comprobante'],
 			            $fetch['tipo'],
      				    $fetch['razon'],
 			            $detalle,
 			            $monto,
  					    $fetch['id_asiento_aux'],
 			            $fetch['spi'],
 			            trim($fetch['idprov'])
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
 
  