<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
	private $tabla ;
	private $secuencia;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
 		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  $_SESSION['email'];
 		
		$this->hoy 	     =  date("Y-m-d");     
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	 
		
	}
	 
	    
 	 
	
	//--------------------------------------------------------------------------------
	function ProcesoNombre($id){
		
		
		$flujo = $this->bd->query_array('flow.view_proceso',
				'nombre, idproceso, responsable, completo, id_departamento, unidad,
										objetivo, tipo, alcance, entrada, salida, publica,indicador',
				'idproceso='.$this->bd->sqlvalue_inyeccion($id,true)
				);
 
		
		echo '<div class="panel panel-default">
				<div class="panel-body">
					<h5><img src="../controller/r.png" align="absmiddle"/> Proceso: <b>'.$flujo['nombre'].'</b></h5></div></div>';
		
		
		$div ='<div class="panel panel-default"><div class="panel-body">';
		$divi = '</div></div>';

		$ViewProceso = 'REFERENCIA:&nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['idproceso'].'<br>'.
				'RESPONSABLE: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['completo'].'<br>'.
				'DEPARTAMENTO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['unidad'].'<br><br>'.
				'OBJETIVO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['objetivo'].'<br>'.
				'PROCESO: &nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['tipo'].'<br>'.
				'AUTORIZADO:&nbsp;&nbsp;&nbsp;&nbsp;'. $flujo['publica'];
		
		
		$javascript = '<script>activar("'.$flujo['publica'].'")</script>';
		
		echo $javascript;
		
		
		echo $div.$ViewProceso.$divi;
		
		
		
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
if (isset($_GET['id']))	{
	
	 
	$id        = $_GET['id'];
	
 
	
	$gestion->ProcesoNombre($id);
	
}

 


?>
 
  