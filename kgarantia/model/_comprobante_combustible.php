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
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//--- busqueda de grilla primer tab
	//-----------------------------------------------------------------------------------------------------------
	public function BusquedaComprobante(   ){
		
	  
	     $siglas = $this->bd->_siglas_comprobantes();
	     
	     $longitud = strlen(trim($siglas));
	     
	     $anio = date('Y');
	     
	     $largo = 8 + $longitud ;
	     
			
	     $sql = "SELECT  coalesce (max(substring(referencia ,".$largo.",5)::numeric),0) as secuencia
					  FROM   adm.ad_vehiculo_comb";
	     
 			
			$parametros = $this->bd->ejecutar($sql);
			$secuencia  = $this->bd->obtener_array($parametros);
			
		  
		
			$cheque1 =  trim($secuencia['secuencia']) + 1 ;
		
		     $cheque = str_pad($cheque1, 5, "0", STR_PAD_LEFT);
		     
		     $cheque = trim($siglas).$anio.'COM'.$cheque;
		
		
		echo trim($cheque);
					   
					   
	}
	
	
}
///------------------------------------------------------------------------

$gestion   = 	new proceso;


 
 	$gestion->BusquedaComprobante();
	
 



?>
 
  