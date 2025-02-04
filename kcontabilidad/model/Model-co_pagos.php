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
	function div_resultado($accion,$id,$comprobante){
		//inicializamos la clase para conectarnos a la bd
	
		echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($comprobante).'"  );</script>';
 
		$resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
		
		
		if ($accion == 'pagado'){
		    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
		}
		
		if ($accion == 'editar'){
		    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
		}
		
			
			if ($accion == 'procesado'){
			    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
			}
				
		    if ($accion == 'del'){
		        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
		    }
				
 
		    
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
		 	
		$qquery = array(
				array( campo => 'id_asiento_aux',    valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'id_asiento',    valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'pago',         valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'razon',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cuenta',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'monto',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cheque',  valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		$datos = $this->bd->JqueryArrayVisor('view_auxbancos',$qquery );
 		
		if ($datos['pago'] == 'S'){
			$accion = 'pagado';
		}else{
			$accion = 'editar';
		}
 
		$result =  $this->div_resultado($accion,$id,$datos['comprobante']). '['.$id.'] '.$accion;
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
	function aprobacion($action,$id  ){
		
	 	//$pago 			= $_POST["pago"];
		$id_asiento		= $_POST["id_asiento"];
		$fecha			= $this->bd->fecha($_POST["fecha"]);
		
		$cuenta			= $_POST["cuenta"];
		$cheque			= $_POST["cheque"];
		
		$tipo			= $_POST["tipo"];
		
		$comprobante    = $_POST["comprobante"];
		
		$anio           =  $this->bd->_anio($fecha);
		$result = $comprobante.' No genero ';
		
 
 
 	 	    $sql = "UPDATE co_asiento
						SET 	estado_pago  =".$this->bd->sqlvalue_inyeccion('S', true)."
					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asiento, true);
	 	    
			$this->bd->ejecutar($sql);
			
			 
			$comprobante = $this->_Comprobante($cuenta,$cheque,$anio);
			
			$sql1 = " UPDATE co_asiento_aux
						SET 	pago	     =".$this->bd->sqlvalue_inyeccion('S', true).",
								cheque       =".$this->bd->sqlvalue_inyeccion(trim($_POST["cheque"]), true).",
								tipo         =".$this->bd->sqlvalue_inyeccion(trim($tipo), true).",
								fechap		 =".$fecha.",
							    comprobante  =".$this->bd->sqlvalue_inyeccion( $comprobante, true)."
					 WHERE id_asiento_aux    =".$this->bd->sqlvalue_inyeccion($id, true);
			
			$this->bd->ejecutar($sql1);
			
			 	
			$result =  $this->div_resultado('procesado',$id,$comprobante);
			 
 
		 
		 
		 
		 
		echo $result;
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		
		 
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
		// ------------------  eliminar
		if ($action == 'aprobacion'){
			
			$this->aprobacion($action,$id );
			
		}
		
	}
 
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
  
 		
	}
	//--------------------------------------------------------------------------
	function _Comprobante($idbancos,$cheque,$anio){
		
	
	    $Acomprobante = $this->bd->query_array('co_plan_ctas',
	        'documento',
	        'cuenta='.$this->bd->sqlvalue_inyeccion(trim($idbancos),true).' and
             anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
             registro='.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)
	        );
	    
		
		$comp = $Acomprobante['documento'] ;
		
		$input= str_pad($comp, 8, "0", STR_PAD_LEFT).'-'.$anio;
		
		$contador = $comp + 1;
		
	  // actualiza cheque
		$sql = 'UPDATE co_plan_ctas
		 		       SET  documento ='.$this->bd->sqlvalue_inyeccion($contador, true)."
				   where tipo_cuenta  = 'B' AND
						    registro  = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND
							cuenta    = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true);
		
		$this->bd->ejecutar($sql);
		
 
		
		return $input ;
	}
	/////////////// llena para consultar
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
	
	$accion    		    = $_GET['accion'];
	$id            		= $_GET['id'];
	  
	$gestion->consultaId($accion,$id);
	 
 
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 			=     $_POST["action"];
	 
	$id 				=     $_POST["id_asiento_aux"];
 
    $gestion->xcrud( trim($action) ,  $id  );
 
	
}



?>
 
  