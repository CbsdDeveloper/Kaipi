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
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
 		
		$this->hoy 	     =  date("Y-m-d");    	 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	 
		
	}
	 
  
	
	//--------------------------------------------------------------------------------
	function CargaTareas($idproceso){
		
 
		
		$sql     = "select tarea,idtarea,notificacion
                      from flow.wk_procesoflujo 
                     where idproceso = ".$idproceso." and idtarea > 0 order by idtarea";
		

		$stmt_nivel1 = $this->bd->ejecutar($sql);
		
		echo '<ul class="list-group">';
		
		echo '<li class="list-group-item"><h6><b>TAREAS DEL PROCESO</b></h6></li>';
		
		
		while ($x=$this->bd->obtener_fila($stmt_nivel1)){
 
				$completo 	  = trim($x['tarea']);
				
				$notificacion = trim($x['notificacion']);

				$Secuencia    = '';
				
				if ( empty($notificacion)){
				    $kimages_a = ' ';
				}else{
				    $kimages_a = ' <img src="../../kimages/ok_save.png"  align="absmiddle" />';
				}
  	
				$kimages       = '<img src="../../kimages/form.png"  title="Formulario" align="absmiddle"> ';
				
				$a 		       = '<a href="#" onClick="wktarea('.$x['idtarea'].','.$idproceso.')">'.$kimages.'</a> &nbsp; ';
				
				echo '<li class="list-group-item">'.$a.$Secuencia.$completo.$kimages_a.'</li>';
			
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
 
  