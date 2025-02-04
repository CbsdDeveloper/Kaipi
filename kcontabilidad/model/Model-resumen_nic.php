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
		
	    
	    
	    $detalle = '(select b.detalle 
                       from co_plan_ctas b  
                      where trim(b.cuenta) = substr(max(a.cuenta),1,1)'. '  and 
                            b.registro = '.$this->bd->sqlvalue_inyeccion($this->ruc , true).' and 
                            b.anio =  '.$this->bd->sqlvalue_inyeccion($anio , true).'
                            ) ' ;
	    
		
		$sql = 'SELECT
            				'.$detalle.' as "Detalle",
            				sum(a.debe) as "Debe",
                            sum(a.haber) as "Haber",
                            (sum(a.debe) - sum(a.haber)) as "Saldo"
            		  FROM co_plan_ctas a
            		  where
                            a.registro = '.$this->bd->sqlvalue_inyeccion($this->ruc , true).' and 
                            a.anio ='.$this->bd->sqlvalue_inyeccion($anio , true).' 
            		  group by  substr(a.cuenta,1,1)
            		  order by substr(a.cuenta,1,1)';
		
		
		$resultado  = $this->bd->ejecutar($sql);
		
		$tipo 		    = $this->bd->retorna_tipo();
		
		$formulario = '';
 		
		$this->obj->grid->KP_sumatoria(2,"Debe","Haber", "Saldo",'');
		
		$this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta',$formulario,'N','','','','');  
       		
		
		$ViewResumen= '<h4><br>'.' Resumen Financiero periodo '.$anio.'</br></h4>';
		
       		echo $ViewResumen;
	
	}
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_POST["fanio"]))	{
	
 
	$anio 				=     $_POST["fanio"];
	
 
	$gestion->grilla( $anio);
 
	
}

?>