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
	private $anio;
	private $login;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
 		
		$this->obj     = 	new objects;

		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->anio       =  $_SESSION['anio'];
	}
   
	//--- calcula libro diario
	function grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta,$auxiliares){
		
 
		$where = $this->sqlwhere($f1,$f2,$cuenta,$id_asiento,$cuentat);
		
 		
		$sql = 'SELECT  a.id_asiento  ,
                                a.fecha ,
        						a.comprobante ,
        						a.cuenta ,
                                b.detalle as dcuenta,
                                a.detalle ,
        						a.debe , 
                                a.haber  ,b.aux, a.id_asientod, a.partida
        						FROM co_diario a
                                join co_plan_ctas b on a.registro = b.registro and
                                                  b.anio = '.$this->bd->sqlvalue_inyeccion($this->anio, true).' and
                                                  a.anio = '.$this->bd->sqlvalue_inyeccion($this->anio, true).' and 
                                                  a.cuenta = b.cuenta and '. $where.'
                                 ORDER BY a.fecha asc,a.comprobante asc,a.cuenta';
  		
		echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
		
		$this->titulo($f1,$f2);
		
 		echo '</div> ';
		
		$stmt = $this->bd->ejecutar($sql);
		
		$ndebe  = 0;
		$nhaber = 0;
		
		
		echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
		
		$this->cabecera();
		
		
		while ($x=$this->bd->obtener_fila($stmt)){
		    
		    $where_aux = '';
		    
		    if ( $auxiliares == 'S'){
		        
    		    if (trim($x['aux']) == 'S'){
    		        
    		        $where_aux = $this->detalle_auxiliar($f1,$f2,$x['cuenta'],$x['id_asiento'],$x['id_asientod']);
    		        
    		    }
		    }
		    
		    echo "<tr>";
		    
		    echo "<td>".$x['id_asiento']."</td>";
		    echo "<td>".$x['fecha']."</td>";
		    echo "<td>".$x['comprobante']."</td>";
		    echo "<td>".$x['cuenta']."</td>";
		    echo "<td>".$x['dcuenta']."</td>";
			echo "<td>".$x['partida']."</td>";
		    echo "<td>".$x['detalle'].$where_aux."</td>";
 		    echo "<td align='right'>".number_format($x['debe'],2)."</td>";
		    echo "<td align='right'>".number_format($x['haber'],2)."</td>";
 		    
		    echo "</tr>";
		    
		    $ndebe  = $ndebe + $x['debe'];
		    $nhaber = $nhaber+ $x['haber'] ;
		    
		}
 
		
		echo "<tr>";
		
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'></td>";
		echo "<td align='right'><b>".number_format($ndebe,2)."</b></td>";
		echo "<td align='right'><b>".number_format($nhaber,2)."</b></td>";
		
		
		echo "</tr>";
 		echo "</table>";
 		echo '</div> ';
		
		unset($x); //eliminamos la fila para evitar sobrecargar la memoria
		
		pg_free_result ($stmt) ;
 
		$saldo = $ndebe - $nhaber;
		
		if ( $saldo <> 0) {
		    echo ' <div class="col-md-12" style="padding-bottom:5;padding-top:5px" align="right"> ';
		    echo '<h4><b>SALDO:  '.number_format($saldo,2).'</b></h4>';
		    echo '</div>';
		}
		else
		{
			echo '<h4>&nbsp;</h4>';
		}
 
	
		$this->firmas( );
	}
 
	function sqlwhere($f1,$f2,$cuenta,$id_asiento,$cuentat){
		
		//inicializamos la clase para conectarnos a la bd
 		
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
		
		
		
		$where    = $cadena0.$cadena1.$cadena2.$cadena4.$cadena5;
		
		$longitud = strlen($where);
	
		$where    = substr( $where,0,$longitud - 5);
		
		
		return   $where;
		
		
		
	}
	
	function cabecera(){
	    
	    echo '<table id ="tabla1" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 10px;table-layout: auto">
                <tr>';
             	    echo '<th width="5%" >Asiento</th>';
            	    echo '<th width="5%" >Fecha</th>';
            	    echo '<th width="10%" >Comprobante</th>';
            	    echo '<th width="10%" >Cuenta</th>';
            	    echo '<th width="15%" >Detalle</th>';
					echo '<th width="10%" >Partida</th>';
            	    echo '<th width="35%" >Descripcion</th>';
            	    echo '<th width="5%" >Debe</th>';
            	    echo '<th width="5%" >Haber</th>';
      	echo '</tr>';
	    
	}
	//-----------------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
 
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'"  width="200" height="120" >';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTABILIDAD ( PERIODO '.$this->anio.' ) </b><br>
                        <b>LIBRO DIARIO POR UNIDAD EJECUTORA '.$f1.'  al '.$f2.'</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
	    
	}
 
	
	function firmas( ){
	    

		$cliente= 'CO-AA';
	   
		$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
	
		$pie_contenido = $reporte_pie["pie"];
	
		// NOMBRE / CARGO
		$a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
		$pie_contenido = str_replace('#AUTORIDAD',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_AUTORIDAD',trim($a10['carpetasub']), $pie_contenido);
		
		 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
		$pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);
	
		 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
		 $pie_contenido = str_replace('#CONTADOR',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_CONTADOR',trim($a10['carpetasub']), $pie_contenido);
	
		 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
		 $pie_contenido = str_replace('#TESORERO',trim($a10['carpeta']), $pie_contenido);
		 $pie_contenido = str_replace('#CARGO_TESORERO',trim($a10['carpetasub']), $pie_contenido);

		 echo  $pie_contenido;
	
	}
//-------------------
	function detalle_auxiliar( $f1,$f2,$cuenta,$id_asiento,$id_asientod){
	    
 
	    
	    $sql = 'SELECT  idprov,razon, (debe + haber) as saldo
                  from view_aux
                 where id_asiento = '.$this->bd->sqlvalue_inyeccion($id_asiento, true).' and 
                       id_asientod = '.$this->bd->sqlvalue_inyeccion($id_asientod, true).' and 
                          cuenta  = '.$this->bd->sqlvalue_inyeccion($cuenta, true);
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    
	    $cadena = ' <table class="table table-striped table-bordered table-hover" width="100%" style="font-size: 10px;"> ';
	    
	    while ($xx= $this->bd->obtener_fila($stmt1)){
	        
	        $cadena .= '<tr>'. "<td>".$xx['razon']."</td>". "<td align='right'>".number_format($xx['saldo'],2)."</td></tr>";
	    }
	    
	    $cadena .= ' </table>';
	    
	    return $cadena;
 
      
	
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =      $_POST["ffecha1"];
	$f2 				=      $_POST["ffecha2"];
	$id_asiento          =     $_POST["id_asiento"];
	
	$cuentat   =     $_POST["cuentat"];
	$cuenta    =     $_POST["cuenta"];
	$auxiliares=     $_POST["auxiliares"];
 
 
	
	$gestion->grilla( $id_asiento,$f1,$f2,$cuentat,$cuenta,$auxiliares);
 
	
}
?>