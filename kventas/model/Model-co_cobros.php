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
				array( campo => 'montoi',     valor => '-',  filtro => 'N',   visor => 'S'),
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
		
 
		$id_asiento		=  $_POST["id_asiento"];

		$pago			=  trim($_POST["pago"]);

		$result			= 'El proceso ya fue realizado...';

		$fecha			= $this->bd->fecha($_POST["fecha"]);
		
		$tipo			= trim($_POST["tipo"]);

		$comprobante    = $_POST["comprobante"];
		
		$estadoa 		= $this->bd->query_array('co_asiento',
		    				'estado,fecha,id_periodo,anio',
		    				'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true)
		    				);
		
		
		if ( $pago	 == 'N')	{	

				$anio                 =  $estadoa['anio'];

				$comprobante          =  $this->bd->_secuencias($anio, 'CI',8);
				
					
					$sql1 = " UPDATE co_asiento_aux
								SET 	pago	     =".$this->bd->sqlvalue_inyeccion('S', true).",
										cheque       =".$this->bd->sqlvalue_inyeccion(trim($_POST["cheque"]), true).",
										tipo         =".$this->bd->sqlvalue_inyeccion(trim($tipo), true).",
										fechap		 =".$fecha.",
										comprobante  =".$this->bd->sqlvalue_inyeccion( $comprobante, true)."
							WHERE id_asiento_aux    =".$this->bd->sqlvalue_inyeccion($id, true);
					
					$this->bd->ejecutar($sql1);
					
						
					$result =  $this->div_resultado('procesado',$id,$comprobante);
  
		}
		 
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
	function _Comprobante_pago($idbancos,$cheque,$anio){
 	    
	  
	    $input          = $this->bd->_secuencias($anio, 'CI',8);
   
		
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
 
  