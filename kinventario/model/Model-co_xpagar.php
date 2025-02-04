<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
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
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
	
	   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
 
		if ($tipo == 0){
			
			if ($accion == 'editar'){
				$resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b>';
			}
				
		    if ($accion == 'del'){
		    	$resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b>';
		    }
				
		    echo '<script type="text/javascript">DetalleAsientoIR();</script>';
		}
		
		if ($tipo == 1){
			
 			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Registro Actualizado</b>';
 			
 			echo '<script type="text/javascript">DetalleAsientoIR();</script>';
			
		}
		
		if ($tipo == 2){
			
			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Asiento aprobado</b>';
			
		}
  	
	
		
		return $resultado;
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
		$resultado = '';
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
		return $resultado;
		
	}
	
	
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
	  
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		 
		// ------------------  editar
 
			
			$this->edicion($id);
			
 
 
 
		
	}
	 
	
 
	//-----------------------------------------------
  
 
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
		
    	 	
   	 	$unidad			        =  $_POST["id_asiento_ref"];
	 	
 
  	 	
  	 	
	 	$sql = " UPDATE inv_movimiento
        					   SET 	id_asiento_ref      =".$this->bd->sqlvalue_inyeccion($unidad, true)."
        					 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	 	
	 	$this->bd->ejecutar($sql);
 
 
	 	
	 	$result = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Transaccion actualizada</b>';
	 	
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


  
//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 		=     @$_POST["action"];
	
	$id 			=     @$_POST["idmovimiento"];
	 
 	$gestion->xcrud(trim($action) ,  $id  );
 
	
}



?>
 
  