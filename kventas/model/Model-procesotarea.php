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
	private $ATabla;
	private $tabla ;
	private $secuencia;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  $_SESSION['email'];
 		
		$this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	 
		
	}
	 
  
	
	//--------------------------------------------------------------------------------
	function CargaTareas($idproceso){
		
		$flujo = $this->bd->query_array('wk_proceso',
				'nombre',
		    'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true)
				);
		
		$nombre   = $flujo['nombre'];
		
		
		$sql = "select tarea,idtarea from wk_procesoflujo where idproceso = ".$idproceso." and idtarea > 0 order by idtarea";
		
		$stmt_nivel1= $this->bd->ejecutar($sql);
		
 	 
		
		echo '<ul class="list-group">';
		
		echo '<li class="list-group-item"><h6><b>TAREAS DEL PROCESO</b></h6></li>';
		
		$total = 0;
		
		while ($x=$this->bd->obtener_fila($stmt_nivel1)){
 
				$completo = trim($x['tarea']);
				
				$Secuencia = '['.trim($x['idtarea']).']';
 
			 
				$imagen = '<a href="#" onClick="javascript:wktarea('.$x['idtarea'].','.$idproceso.')" > 
                                <img src="../../kimages/form.png"  title="Formulario" align="absmiddle"  > 
                            </a> &nbsp; ';
				echo '<li class="list-group-item">'.$imagen.$Secuencia.' '.$completo.'</li>';
			
		}
		
		$listaTareas= '</ul>';
		
		
		echo $listaTareas;
		
	 
		
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
	 
	$gestion->CargaTareas($id);
	
}

 


?>
 
  