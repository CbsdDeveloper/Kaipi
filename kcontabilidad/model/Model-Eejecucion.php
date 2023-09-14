<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class proceso{
	
 	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $anio;
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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		
		$this->anio       =  $_SESSION['anio'];
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$reporte){
		
	    $valor1 = 0;
	    $valor2 = 0;
	    $valor3 = 0;
	    
	    echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
	    
	    $this->titulo($f1,$f2);
	    
	    echo '</div> ';
	    
	    echo '<div class="col-md-2"> </div><div class="col-md-7" style="padding: 30px">  ';
 	    
	    
	    echo '<h5><b>SUPERAVIT O DEFICIT CORRIENTE</b></h5>';
	    
	    $this->cabecera('INGRESOS CORRIENTES');
	    $ingreso = $this->Bloque_Activo($f1,$f2,1,1,$reporte);
	    
	    $this->cabecera('GASTOS CORRIENTES');
	    $gasto = $this->Bloque_Activo($f1,$f2,1,2,$reporte);
	    
	    
	    $datos['t1'] = $ingreso['t1'] - $gasto['t1'];
	    $datos['t2'] = $ingreso['t2'] - $gasto['t2'];
	    $datos['t3'] = $ingreso['t3'] - $gasto['t3'];
	    
	    $this->cabecera_total('<b>SUPERAVIT O DEFICIT CORRIENTE</b>',$datos);
	    
	    $valor1 = $datos['t1'] +  $valor1;
	    $valor2 = $datos['t2'] +  $valor2;
	    $valor3 = $datos['t3'] +  $valor3;

	    
	    
	    echo '<h5><b>SUPERAVIT O DEFICIT DE INVERSION</b></h5>';
	    
	    $this->cabecera('INGRESOS DE CAPITAL');
	    $ingreso = $this->Bloque_Activo($f1,$f2,2,1,$reporte);
	    
	    $this->cabecera('GASTOS DE PRODUCCION');
	    $gasto1 = $this->Bloque_Activo($f1,$f2,2,2,$reporte);
	    
	    $this->cabecera('GASTOS DE INVERSION');
	    $gasto2 = $this->Bloque_Activo($f1,$f2,2,3,$reporte);
	    
	    
	    $this->cabecera('GASTOS DE CAPITAL');
	    $gasto3 = $this->Bloque_Activo($f1,$f2,2,4,$reporte);
 	    
	    
	    $datos['t1'] = $ingreso['t1'] -  ( $gasto1['t1'] + $gasto2['t1'] + $gasto3['t1'] );
	    $datos['t2'] = $ingreso['t2'] -  ( $gasto1['t2'] + $gasto2['t2'] + $gasto3['t2'] );
	    $datos['t3'] = $ingreso['t3'] -  ( $gasto1['t3'] + $gasto2['t3'] + $gasto3['t3'] );
	    
	    $this->cabecera_total('<b>SUPERAVIT O DEFICIT DE INVERSION</b>',$datos);
	    
	    $valor1 = $datos['t1'] +  $valor1;
	    $valor2 = $datos['t2'] +  $valor2;
	    $valor3 = $datos['t3'] +  $valor3;
	    
	    echo '<h5><b> SUPERAVIT O DEFICIT DE FINANCIAMIENTO</b></h5>';
	   
	    $this->cabecera('INGRESOS DE FINANCIAMIENTO');
	    $ingreso = $this->Bloque_Activo($f1,$f2,3,1,$reporte);
	    
	    $this->cabecera('APLICACION DEL FINANCIAMIENTO');
	    $gasto = $this->Bloque_Activo($f1,$f2,3,2,$reporte);
	    
	    
	    
	    $datos['t1'] = $ingreso['t1'] - $gasto['t1'];
	    $datos['t2'] = $ingreso['t2'] - $gasto['t2'];
	    $datos['t3'] = $ingreso['t3'] - $gasto['t3'];
	    
	    $this->cabecera_total('<b>SUPERAVIT O DEFICIT DE FINANCIAMIENTO</b>',$datos);
	    
	    $valor1 = $datos['t1'] +  $valor1;
	    $valor2 = $datos['t2'] +  $valor2;
	    $valor3 = $datos['t3'] +  $valor3;
	    
	    
	    
	    $datos['t1'] = $valor1;
	    $datos['t2'] = $valor2;
	    $datos['t3'] = $valor3;
	    $this->cabecera_total('<b>SUPERAVIT O DEFICIT PRESUPUESTARIO</b>',$datos);
	    
	    echo '</div> ';
	    
	    
	    

	    $this->firmas( );
 
		
	 
	}
	//----------------------------------------
	public function Bloque_Activo( $f1,$f2,$orden1,$orden2,$reporte ){
	    
	    
	    $sql = 'SELECT    nivel1, nivel2, nivel3, grupo1, grupo2, grupo3, cuenta, tipo, sin_signo, con_signo, estado
                    FROM presupuesto.matriz_ejecucion
                    where nivel1 = '.$this->bd->sqlvalue_inyeccion( $orden1 ,true).' and
                          nivel2 =  '.$this->bd->sqlvalue_inyeccion( $orden2 ,true) ;
	    
	 
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    $t1 = 0;
	    $t2 = 0;
	    $t3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
 	        
	        if ( trim($x['cuenta']) == '37'){
	            
	            $codificado = $this->suma_codificado($f1, $f2,trim($x["tipo"]) ,trim($x["cuenta"]));
	            
	            $devengado = $this->suma_ejecutado_caja(trim($x["cuenta"]));
	            
	            $saldo = $codificado - $devengado ;
	            
	        }else{
	            $codificado = $this->suma_codificado($f1, $f2,trim($x["tipo"]) ,trim($x["cuenta"]));
	            
	            $devengado = $this->suma_ejecutado($f1, $f2,trim($x["tipo"]) ,trim($x["cuenta"]));
	            
	            $saldo = $codificado - $devengado ;
	        }
	        

	        
	        echo "<tr>";
	        echo "<td><b>".$x['cuenta']."</b></td>";
	        echo "<td> ".$x['grupo3']." </td>";
	        echo "<td align='right'>".number_format($codificado,2)."</td>";
	        echo "<td align='right'>".number_format($devengado,2)."</td>";
	        echo "<td align='right'>".number_format($saldo,2)."</td>";
			echo "</tr>";

			if (trim($reporte)  == '1'){

				 if (abs($saldo) > 0  ){
						echo '<tr>
						<td></td>
						<td colspan="3">';
								$this->_detalle_cuenta($x['cuenta'], trim($x["tipo"]),$f1,$f2);
						echo '</td>
						<td></td>
						</tr>';
			   }
 		   }

	        
	        $t1 = $t1 + $codificado;
	        $t2 = $t2 + $devengado;
	        $t3 = $t3 + $saldo;
	    }
	    
	    echo "<tr>";
	    echo "<td></td>";
	    echo "<td></td>";
	    echo "<td align='right'><strong>".number_format($t1,2)."</strong></td>";
	    echo "<td align='right'><strong>".number_format($t2,2)."</strong></td>";
	    echo "<td align='right'><strong>".number_format($t3,2)."</strong></td></tr>";
	    
	    echo '</table>';
	    
	    $datos['t1'] = $t1;
	    $datos['t2'] = $t2;
	    $datos['t3'] = $t3;
	     
	    return $datos;
	}
	//------------------------//--------------------------
function _detalle_cuenta($cuenta, $tipo_mov,$f1,$f2){

	$wheref = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion(trim($f1),true)." and ".
		                             $this->bd->sqlvalue_inyeccion(trim($f2),true)." ) ";
		
 
	$tipo 		     = $this->bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
	
	$font ="10";
	$background="#ececec";
	

	if ( $tipo_mov ==  'G' ){

		$cuenta = '213.'.$cuenta.'%';

		$sql22 = "select cuenta,detalle_cuenta,  sum(haber) devengado
		from view_diario_detalle
		where anio =".$this->bd->sqlvalue_inyeccion($this->anio, true)." and estado = 'aprobado' and 
			  cuenta like ".$this->bd->sqlvalue_inyeccion($cuenta, true).$wheref." 
			  group by cuenta,detalle_cuenta";

     }

	 if ( $tipo_mov ==  'I' ){

		$cuenta = '113.'.$cuenta.'%';

		$sql22 = "select cuenta,detalle_cuenta, sum(debe) as devengado
		from view_diario_detalle
		where anio =".$this->bd->sqlvalue_inyeccion($this->anio, true)." and estado = 'aprobado' and 
			  cuenta like ".$this->bd->sqlvalue_inyeccion($cuenta, true).$wheref." 
			  group by cuenta,detalle_cuenta";

     }
 
 
	 
				$evento = '';
				$edita    = '';
				$del      = '';			
 
	  
	$resultado22  = $this->bd->ejecutar($sql22); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
	
	$cabecera =  "Cuenta,Detalle,Saldo"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR

  
 
	// $this->obj->table->table_pdf_js($resultado22,$tipo,$edita,$del,$evento ,$cabecera,$font,$background,"1");
	$this->obj->table->table_pdf_js($resultado22,$tipo,$cabecera);

 

}
	//------------------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'"  width="200" height="120">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="font-size: 14px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTABILIDAD ( PERIODO '.$this->anio.' ) </b><br>
                        <b>ESTADO DE EJECUCION PRESUPUESTARIA al '.$f2.'</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;<br>
                     &nbsp;<br>
                     &nbsp;</td>
                </tr>
 	   </table>';
	    
	}
//--------------------------------------------
	 
	function firmas( ){
	    
		$cliente= 'CO-EF';
	   
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
	///------------------
 
	function suma_ejecutado($fecha1, $fecha2,$tipo ,$grupo){
		
	   
	    $cadena2 = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".
	   	    $this->bd->sqlvalue_inyeccion($fecha2,true)." )   ";
	    
	    
	 
	    if ( $tipo == 'I') {
	        
	        $SQL = 'SELECT  sum(haber) AS devengado 
            	    FROM view_diario
            	    where  anio =' .$this->bd->sqlvalue_inyeccion(  $this->anio   ,true)." and 
                           partida_enlace = 'ingreso' and 
                           grupo = ".$this->bd->sqlvalue_inyeccion($grupo ,true).$cadena2;
	        
	    }else{
	        $SQL = 'SELECT  sum(debe) AS devengado
            	    FROM view_diario
            	    where tipo_presupuesto= 1 and   
                          anio =' .$this->bd->sqlvalue_inyeccion(  $this->anio   ,true).' and 
                          grupo = '.$this->bd->sqlvalue_inyeccion($grupo ,true).$cadena2;
	        
	    }
	    
	  
	    
 
	    $resultado1 = $this->bd->ejecutar($SQL);
	    
	    $datos_sql   = $this->bd->obtener_array( $resultado1);
 
	    
	    return $datos_sql['devengado'];
	    
	    
	    
 
	}
	//---------------
	function suma_ejecutado_caja( $grupo){
	    
 
	 
	   	        
	   	        $SQL = 'SELECT   sum(monto) as devengado
            	    FROM presupuesto.pre_caja
            	    where  anio =' .$this->bd->sqlvalue_inyeccion(  $this->anio   ,true)." and
                           partida like '37%' " ;
 
	   	    
	   	    $resultado1 = $this->bd->ejecutar($SQL);
	   	    
	   	    $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	    
	   	    
	   	    return $datos_sql['devengado'];
	   	    
	   	    
	   	    
	   	    
	}
	/// 
	//------------------------------------------------------------------------
	function cabecera($titulo){
	    
	    echo '<table  class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 13px;table-layout: auto">';
	    echo ' <tr>
                  <td colspan="5"><b>'.$titulo.'</b></td>
                 </tr>
                <tr>
                   <td width="10%">Cuenta</td>
                   <td width="45%">Concepto</td>
                   <td width="15%">Codificado</td>
                    <td width="15%">Ejecutado</td>
                    <td width="15%">Diferencia</td>
                </tr>';
	    
	        
	}
	//------------------------------------------
	function cabecera_total($titulo,$datos){
	    
	    echo '<table width="100%" style="font-size: 13px;table-layout: auto">';
	    echo '  <tr>
                    <td width="55%"></b>'.$titulo.'</b></td>
                    <td width="15%" align="right"><b>'.number_format($datos["t1"],2).'</b></td>
                    <td width="15%" align="right"><b>'.number_format($datos["t2"],2).'</b></td>
                    <td width="15%" align="right"><b>'.number_format($datos["t3"],2).'</b></td>
                </tr></table>';
	    
	    
	}
	//----------------------------------------------------------------------------------------------
	public function suma_codificado($fecha1, $fecha2,$tipo ,$grupo){
		
	    $trozos = explode("-", $fecha1,3);
	    
	    $anio1 = $trozos[0];
	  
		$saldos = $this->bd->query_array( 'presupuesto.pre_gestion',
				'COALESCE(sum(codificado),0) as codificado',
		         'anio= '.$this->bd->sqlvalue_inyeccion($anio1 ,true).' and
                 tipo ='.$this->bd->sqlvalue_inyeccion($tipo ,true).' and
                 grupo ='.$this->bd->sqlvalue_inyeccion($grupo ,true)
		      );
				 
		return $saldos['codificado'];
				
	}
 	 
	//--- ultimo nivel
	public function cabecera_nivel1( $fecha1, $fecha2 ){
 
	    $sql = 'SELECT nivel1,   grupo1
	    FROM presupuesto.matriz_ejecucion
	    group by nivel1, grupo1 order by 1';
	    
	    
	    $resultado  = $this->bd->ejecutar($sql);
	    
	   echo  '<table  class="table table-striped table-bordered table-hover table-checkable"  width="100%" border="1" cellspacing="0" cellpadding="0">';
	   
	   echo ' <tr>
              <td  align="center" width="5%" >CUENTA</td>
              <td width="65%" >CONCEPTO</td>
              <td width="10%" align="right">CODIFICADO</td>
              <td width="10%" align="right">EJECUTADO</td>
              <td width="10%" align="right">DIFERENCIA</td>
             </tr>';
        	    
	    while ($x=$this->bd->obtener_fila($resultado)){
	        
	            $nivel1 =  trim($x["nivel1"]);
	        
     	        echo '<tr>
                  <td  align="center" bgcolor="#D7D7D7"width="5%">&nbsp;</td>
                  <td width="65%" style="padding: 4px" bgcolor="#D7D7D7"><b>'.trim($x["grupo1"]).'</b></td>
                  <td width="10%" bgcolor="#D7D7D7">&nbsp;</td>
                  <td width="10%" bgcolor="#D7D7D7">&nbsp;</td>
                  <td width="10%" bgcolor="#D7D7D7">&nbsp;</td>
                 </tr><tr><td colspan="5">&nbsp;</td></tr>';
     	        
     	        //-------------------------------------------------------------
     	        $sql1 = 'SELECT nivel2,   grupo2
                FROM presupuesto.matriz_ejecucion
                where nivel1 = '.$this->bd->sqlvalue_inyeccion($nivel1 ,true).'
                group by nivel2, grupo2';
     	        
     	        $resultado2  = $this->bd->ejecutar($sql1);
     	        
     	        echo  '<tr><td colspan="5"><table width="100%" ';
     	        
     	        while ($y=$this->bd->obtener_fila($resultado2)){
     	            
     	            echo '<tr>
                  <td  align="right" width="5%">'.trim($y["nivel2"]).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td width="65%" style="padding: 4px" ><b>'.trim($y["grupo2"]).'</b></td>
                  <td width="10%">&nbsp;</td>
                  <td width="10%">&nbsp;</td>
                  <td width="10%">&nbsp;</td>
                 </tr>';
     	            
     	            //------------------------------------------------------------------------------------------
     	            $sql2 = 'SELECT   grupo3, cuenta, tipo, sin_signo, con_signo, estado
                            FROM presupuesto.matriz_ejecucion
                            where nivel1 = '.$this->bd->sqlvalue_inyeccion($nivel1 ,true).' and 
                                  nivel2 = '.$this->bd->sqlvalue_inyeccion(trim($y["nivel2"]) ,true)       ;
     	            //-----------------------------------------------------------------------------------------
     	            $resultado3  = $this->bd->ejecutar($sql2);
     	            
     	            echo  '<tr><td colspan="5"><table width="100%" border="0" cellspacing="1" cellpadding="1">';
     	            
     	            while ($z=$this->bd->obtener_fila($resultado3)){
     	                
     	                $codificado = $this->suma_codificado($fecha1, $fecha2,trim($z["tipo"]) ,trim($z["cuenta"]));
      	                
     	                $devengado = $this->suma_ejecutado($fecha1, $fecha2,trim($z["tipo"]) ,trim($z["cuenta"]));
     	                   
     	                $codificado_1 = number_format($codificado,2,".",",");
     	                
     	                $devengado_1 = number_format($devengado,2,".",",");
     	                
     	                $diferencia1 =  $codificado - $devengado;
     	                
     	                $diferencia = number_format($diferencia1,2,".",",");
     	                
     	                echo '<tr >
                              <td  style="border-collapse: collapse; border: 1px solid #CBCBCB;padding: 3px" align="right" width="5%">'.trim($z["cuenta"]).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                              <td style="border-collapse: collapse; border: 1px solid #CBCBCB;padding: 3px"  width="65%">'.trim($z["grupo3"]).'</td>
                              <td align="right" style="border-collapse: collapse; border: 1px solid #CBCBCB;padding: 3px" width="10%">'.$codificado_1.'</td>
                              <td align="right" style="border-collapse: collapse; border: 1px solid #CBCBCB;padding: 3px" width="10%">'.$devengado_1.'</td>
                              <td align="right" style="border-collapse: collapse; border: 1px solid #CBCBCB;padding: 3px" width="10%">'.$diferencia.'</td>
                             </tr>';
     	            }
     	            echo  '</td></table>';
     	        }
     	        echo  '</td></table>';
      	        //--------------------------------------------------------------
     	    
            }

 	    echo  '</table>';
	    
 	   
	}

}
///------------------------------------------------------------------------

$gestion   = 	new proceso;
 
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =     $_POST["ffecha1"];
	$f2 				=     $_POST["ffecha2"];

	$reporte 				=     $_POST["reporte"];
 
 
	$gestion->grilla( $f1,$f2,$reporte );
 
	
}

?>