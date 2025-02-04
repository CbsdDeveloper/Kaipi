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
		$this->bd	   =	new Db;

		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();

		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd


		echo '<script type="text/javascript">';
		 
		echo  '$("#action").val("'.$accion.'");';
		 
		echo  '$("#idusuario").val("'.$id.'");';
		 
		echo '</script>';
		 
		 
		 
		if ($tipo == 0){

			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
				if ($accion == 'del')
				    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
					 
		}
		 
		if ($tipo == 1){


		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';

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
	function consultaId($accion,$id ){



		$qquery = array(
				array( campo => 'ruc_registro',   valor =>trim($id) ,  filtro => 'S',   visor => 'S'),
				array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'contacto',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'felectronica',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'fondo',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'comercial',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'estab',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'puerto',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'obligado',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'firma',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'carpeta',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'ambiente',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'web',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'mision',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'vision',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'email',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'acceso',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'url',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'enlace',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'factura',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'retencion',   valor => '-',  filtro => 'N',   visor => 'S'),
    		    array( campo => 'smtp',   valor => '-',  filtro => 'N',   visor => 'S')
	   );
 

		$datos = $this->bd->JqueryArrayVisor('web_registro',$qquery );

		$password = base64_decode($datos["acceso"]);

 
		 
		echo '<script type="text/javascript">';
		 
		echo  'imagenfoto("'.trim($datos['url']).'");';
		 
		echo '$("#acceso").val("'.trim($password).'")';
		 
		echo '</script>';
		 
		 

		$result =  $this->div_resultado($accion,$id,0);
		 
		echo  $result;
	}

	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------

	function xcrud($action,$id){


		// ------------------  agregar
		if ($action == 'add'){

			$this->agregar( $id );
			 
		}
		// ------------------  editar
		if ($action == 'editar'){

			$this->edicion($id );
			 
		}
		// ------------------  eliminar
		if ($action == 'del'){

			$this->eliminar($id );
			 
		}

	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( $id   ){
		 
		$password = @$_POST["acceso"];

		$clave = $this->obj->var->_codifica($password);
 	 
		$InsertQuery = array(
				array( campo => 'ruc_registro',   valor => $id),
				array( campo => 'razon',   valor => @$_POST["razon"]),
				array( campo => 'contacto',   valor => @$_POST["contacto"]),
				array( campo => 'correo',   valor => @$_POST["correo"]),
				array( campo => 'web',   valor => @$_POST["web"]),
				array( campo => 'acceso',   valor => 	$clave),
 				array( campo => 'direccion',   valor => @$_POST["direccion"]),
				array( campo => 'telefono',   valor => @$_POST["telefono"]),
				array( campo => 'email',   valor => @$_POST["email"]),
				array( campo => 'smtp',   valor => @$_POST["smtp"]),
				array( campo => 'puerto',   valor => @$_POST["puerto"]),
				array( campo => 'idciudad',   valor => @$_POST["idciudad"]),
 				array( campo => 'estado',   valor => @$_POST["estado"]),
				array( campo => 'url',   valor => @$_POST["url"]),
		        array( campo => 'felectronica',   valor => @$_POST["felectronica"]),
		        array( campo => 'comercial',   valor => @$_POST["comercial"]),
		        array( campo => 'retencion',   valor => @$_POST["retencion"]),
		        array( campo => 'fondo',   valor => @$_POST["fondo"]),
		        array( campo => 'estab',   valor => @$_POST["estab"]),
		        array( campo => 'factura',   valor => @$_POST["factura"]),
 				array( campo => 'mision',    valor => @$_POST["mision"]),
				array( campo => 'vision',   valor => @$_POST["vision"]),
    		    array( campo => 'obligado',   valor => @$_POST["obligado"]),
    		    array( campo => 'firma',    valor => @$_POST["firma"]),
    		    array( campo => 'carpeta',   valor => @$_POST["carpeta"]),
		        array( campo => 'ambiente',   valor => trim(@$_POST["ambiente"]))
		);
 
		
		
		
		$idD = $this->bd->JqueryInsertSQL('web_registro',$InsertQuery);

		//------------ seleccion de periodo
		 
		$result = $this->div_resultado('editar',$idD,1);
		 
		echo $result;

	}
	 
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		 
		//	$password = @$_POST["acceso"];
		//  $clave 	  = $this->obj->var->_codifica(trim($password));

		$password = @$_POST["acceso"];
		$clave    = $this->obj->var->_codifica($password);

 
		$UpdateQuery = array(
				array( campo => 'ruc_registro',   valor => $id ,  filtro => 'S'),
				array( campo => 'razon',   valor => @$_POST["razon"],  filtro => 'N'),
				array( campo => 'contacto',      valor => @$_POST["contacto"],  filtro => 'N'),
				array( campo => 'correo',      valor => @$_POST["correo"],    filtro => 'N'),
				array( campo => 'web',       valor => @$_POST["web"],  filtro => 'N') ,
				array( campo => 'acceso',       valor => $clave,  filtro => 'N'),
				array( campo => 'direccion',       valor => @$_POST["direccion"],  filtro => 'N') ,
				array( campo => 'telefono',      valor => @$_POST["telefono"],  filtro => 'N'),
				array( campo => 'mision',      valor => @$_POST["mision"],    filtro => 'N'),
				array( campo => 'vision',  valor => @$_POST["vision"],  filtro => 'N'),
		        array( campo => 'comercial',  valor => @$_POST["comercial"],  filtro => 'N'),
				array( campo => 'email',       valor => @$_POST["email"],  filtro => 'N'),
		        array( campo => 'retencion',       valor => @$_POST["retencion"],  filtro => 'N'),
				array( campo => 'url',       valor => @$_POST["url"],  filtro => 'N') ,
		        array( campo => 'fondo',       valor => @$_POST["fondo"],  filtro => 'N') ,
				array( campo => 'idciudad',       valor => @$_POST["idciudad"],  filtro => 'N') ,
				array( campo => 'estado',       valor => @$_POST["estado"],  filtro => 'N') ,
				array( campo => 'smtp',       valor => @$_POST["smtp"],  filtro => 'N') ,
		        array( campo => 'factura',       valor => @$_POST["factura"],  filtro => 'N') ,
		        array( campo => 'estab',       valor => @$_POST["estab"],  filtro => 'N') ,
		        array( campo => 'felectronica',       valor => @$_POST["felectronica"],  filtro => 'N') ,
 				array( campo => 'puerto',       valor => @$_POST["puerto"],  filtro => 'N')  ,
    		    array( campo => 'obligado',       valor => @$_POST["obligado"],  filtro => 'N') ,
		        array( campo => 'enlace',       valor => @$_POST["enlace"],  filtro => 'N') ,
    		    array( campo => 'firma',       valor => @$_POST["firma"],  filtro => 'N') ,
    		    array( campo => 'carpeta',       valor => @$_POST["carpeta"],  filtro => 'N')  ,
		        array( campo => 'ambiente',      valor => @$_POST["ambiente"],  filtro => 'N')  ,
		);
 	
	
		
		 
		$this->bd->JqueryUpdateSQL('web_registro',$UpdateQuery);
		 
		$result = $this->div_resultado('editar',$id,1);

		
		 
		

		echo $result;
	}

	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){


		$tipo   = @$_POST["tipo"];
		 
		
		if ($tipo == '-'){
			
			$numero = $this->bd->ReferenciaTabla('co_plan_ctas','registro',$id) +  $this->bd->ReferenciaTabla('co_periodo','registro',$id) ;
 				
			if  ($numero == 0) {
				
				$this->bd->JqueryDeleteSQL('web_registro',  'ruc_registro='.$this->bd->sqlvalue_inyeccion($id, true));
			
			}
  		   
			 
		}
  
		 
		$result = $this->div_limpiar();
 
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

	$accion    = $_GET['accion'];

	$id        = $_GET['id'];

	$gestion->consultaId($accion,$id);
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{

	$action = @$_POST["action"];

	$id =     @$_POST["ruc_registro"];

	$gestion->xcrud(trim($action),$id );
	 
}

 
 
?>
 
  