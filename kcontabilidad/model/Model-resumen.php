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
   
	//--- calcula libro diario
	function grilla($anio){
		
	    
 
		
		$sql = 'select a.titulo as cuenta_contable,
				       b.detalle , 
					   sum(a.debe) as debe, 
					   sum(a.haber) as haber ,
					   sum(a.debe) - sum(a.haber) as saldo
		from view_diario_res a, co_plan_ctas b
		where a.anio = '.$this->bd->sqlvalue_inyeccion($anio , true).'  and 
		 	  b.registro = '.$this->bd->sqlvalue_inyeccion($this->ruc , true).' and 
			  b.anio = a.anio::character varying::text and 
			  a.titulo = b.cuenta
		group by a.titulo,b.detalle order by 1';
		
		 
		 
		
		$resultado  = $this->bd->ejecutar($sql);
		
		$tipo 		    = $this->bd->retorna_tipo();
		
		$formulario = '';
 		
		$this->obj->grid->KP_sumatoria(3,"Debe","Haber", "Saldo",'');
		
		$this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta',$formulario,'N','','','','');  
       		
		
		$ViewResumen= '<h4><br>'.' Resumen Financiero periodo '.$anio.'</br></h4>';
		
       echo $ViewResumen;
	
	}
 
}
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

 
if (isset($_POST["fanio"]))	{
	
 
	$anio 				=     $_POST["fanio"];
	
 
	$gestion->grilla( $anio);
 
	
}

?>