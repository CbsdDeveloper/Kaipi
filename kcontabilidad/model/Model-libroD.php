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
	function grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta){
		
 
		$where = $this->sqlwhere($f1,$f2,$cuenta,$id_asiento,$cuentat);
		
		
		$datos = $this->bd->query_array('co_diario a, co_plan_ctas b',
				'(sum(a.debe)  -  sum(a.haber) ) as saldo',
				'a.registro = b.registro and
                                                a.cuenta = b.cuenta and '.$where);
		
		
		$sql_aux = '(select max(x.razon) || '."' ('".' || count(*) || '."')'".'
                              from view_aux x
                             where  x.registro = '.$this->bd->sqlvalue_inyeccion($this->ruc, true). ' and
                                    a.cuenta = x.cuenta and x.id_asiento = a.id_asiento) as "Beneficiario"';
		
		$case = "CASE WHEN a.tipo ='P' THEN 'Anticipo Proveedor' ELSE 'Financiero' END ";
		
		$espacio = " || ' '";
		
		
		//--------------------
		
		$sql = 'SELECT  a.id_asiento as "Id",
                                a.fecha as "Fecha Aprobacion",
        						a.comprobante || '."' '".'  as "Comprobante",
        						a.cuenta '.$espacio.' as "Cta Contable",
                                b.detalle as "Nombre Cuenta",
                                a.detalle as "Detalle" ,
        						a.debe as "Debe", a.haber as "Haber"
        						FROM view_diario_digitado a, co_plan_ctas b
                                WHERE  a.registro = b.registro and
                                       a.cuenta = b.cuenta and '. $where.'
                                ORDER BY a.fecha asc,a.comprobante asc';
		
		
		$Viewlibro = ' <h5><br>Libro Diario periodo '.$f1.' al '.$f2.'</br></h5>';
		
 
		echo $Viewlibro;
		
		
		$resultado  = $this->bd->ejecutar($sql);
	
		$tipo 		= $this->bd->retorna_tipo();
		
		$this->obj->grid->KP_sumatoria(7,"Debe","Haber", "","");
		
 
		
		$this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
		
 
		
		if ($datos['saldo'] <> 0) {
			echo '<h4>SALDO:'.number_format($datos['saldo'],2).'</h4>';
		}
		else
		{
			echo '<h4>&nbsp;</h4>';
		}
 
	
	}
 
	function sqlwhere($f1,$f2,$cuenta,$id_asiento,$cuentat){
		
		//inicializamos la clase para conectarnos a la bd
		//@$_POST["fecha1"],@$_POST["fecha2"], @$_POST["cuenta"],@$_POST["id_asiento"], @$_POST["cuentat"]
		
		$cadena0 =  '( a.registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
		
		if ( strlen ($cuenta) > 1){
			$cadena1 = '( a.cuenta ='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true).") and ";
		}
		
		if ( strlen ($f1) > 1){
			$cadena2 = '( a.fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".$this->bd->sqlvalue_inyeccion(trim($f2),true)." ) and ";
		}
		
		if ( strlen ($id_asiento) > 1){
			$cadena4 = '( a.id_asiento ='.$this->bd->sqlvalue_inyeccion(trim($id_asiento),true).") and ";
		}
		
		if ( strlen ($cuentat) > 1){
			$cadena5 = '( a.cuenta like '.$this->bd->sqlvalue_inyeccion(trim($cuentat),true).") and ";
		}
		
		
		
		$where    = $cadena0.$cadena1.$cadena2.$cadena3.$cadena4.$cadena5;
		
		$longitud = strlen($where);
	
		$where    = substr( $where,0,$longitud - 5);
		
		
		return   $where;
		
		
		
	}
	
}
///------------------------------------------------------------------------


$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =     $_POST["ffecha1"];
	$f2 				=     $_POST["ffecha2"];
	$id_asiento=     $_POST["id_asiento"];
	
	$cuentat   =     $_POST["cuentat"];
	$cuenta    =     $_POST["cuenta"];
 
 
	
	$gestion->grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta);
 
	
}


?>