<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	private $saldos;
	
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
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
	
	   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
 
		if ($tipo == 0){
			
			if ($accion == 'editar'){
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			}
				
		    if ($accion == 'del'){
		        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
		    }
		 
		    echo '<script type="text/javascript">DetalleAsiento();</script>';
		}
		
		if ($tipo == 1){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
 			echo '<script type="text/javascript">DetalleAsiento();</script>';
			
		}
		
		if ($tipo == 2){
			
		    $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b>';
		    
		}
  	
 		
		return $resultado;
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
		$resultado = 'TRANSACCION ELIMINADA';
		
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
		return $resultado;
		
	}
	
	 
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
		 	
	 	$sql = " UPDATE co_asiento
				 SET 	estado_pago   =".$this->bd->sqlvalue_inyeccion('S', true)."
 			     WHERE id_asiento     =".$this->bd->sqlvalue_inyeccion($id, true);
	 	
	 	$this->bd->ejecutar($sql);
	 	 
	 	$result = 'Asiento modificado pagado';
	 	
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	    $sql = " UPDATE co_asiento
				 SET 	estado_pago   =".$this->bd->sqlvalue_inyeccion('N', true)."
 			     WHERE id_asiento     =".$this->bd->sqlvalue_inyeccion($id, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    $result = 'Asiento modificado No pagado';
	    
	    echo $result;
 		
	}
 
	 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
	
	$accion    		    = trim($_GET['accion']);
	$id            		= $_GET['id'];
	  
	if ($accion == 'ok'){
	    
	    $gestion->edicion($id);
	    
	}
	else{
	    
	    $gestion->eliminar($id);
	}
    
	 
	 
	
}

 



?>
 
  