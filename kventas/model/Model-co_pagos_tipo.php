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
	public function BusquedaComprobante($festado,$idbancos  ){
		
		
		if  ($festado=='cheque'){
			
			$sql = "SELECT  (documento + 1) as secuencia
					  FROM co_plan_ctas 
					  where tipo_cuenta = 'B' AND 
						    registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND 
							cuenta = ".$this->bd->sqlvalue_inyeccion($idbancos,true);
			
			$parametros = $this->bd->ejecutar($sql);
			$secuencia  = $this->bd->obtener_array($parametros);
			
		}else{
			
			$sql = "SELECT  (count(*) + 1) as secuencia
					  FROM view_auxbancos
					  where pago = ".$this->bd->sqlvalue_inyeccion(trim('S'),true). " AND
							registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND
							cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true);
			
			$parametros = $this->bd->ejecutar($sql);
			
			$secuencia  = $this->bd->obtener_array($parametros);
 			
		}
		
		$cheque1 = trim($secuencia['secuencia']) ;
		
		$cheque = str_pad($cheque1, 8, "0", STR_PAD_LEFT);
		
		
		echo trim($cheque);
					   
					   
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
if (isset($_GET['fidbancos']))	{
	
	$festado= $_GET['tipo'];
	
 	$idbancos= $_GET['fidbancos'];
	
	
	
 	$gestion->BusquedaComprobante($festado,$idbancos);
	
}



?>
 
  