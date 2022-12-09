<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	public  $ATabla;
 	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( $sesion ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
	  	
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->sesion = $sesion;
		
		$this->consultaId( $sesion );
		
	}
 	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId( $sesion ){
		
 		
		$qquery = array( 
		        array( campo => 'email',   valor => $sesion,  filtro => 'S',   visor => 'S'),
				array( campo => 'idusuario',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'completo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'id_departamento',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'nomina',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tarea',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'solicitud',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'supervisor',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'responsable',   valor => '-',  filtro => 'N',   visor => 'S'),
 		        array( campo => 'url',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'tipourl',   valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
		$this->ATabla = $this->bd->JqueryArrayVisorDato('par_usuario',$qquery );
 		
		 
	}
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function _get($campo){
		
		
	    return  $this->ATabla[$campo];
		
	}
}
/*
 
$gestion   = 	new proceso($_SESSION['email']);

echo 'nombre'.$gestion->_get('completo');

*/
?>
 
  