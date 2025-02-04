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
		
		
		$this->anio       =  $_SESSION['anio'];
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2){
		
	    
	    echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
	    
	    $this->titulo($f1,$f2);
	    
	    echo '</div> ';
	    
	    echo '<div class="col-md-2"> </div><div class="col-md-7" style="padding: 30px">  ';
	   
	    $this->cabecera('<b>FUENTES CORRIENTES</b>');
	    $ingreso1= $this->Bloque_Activo($f1,$f2,1,1);
	    
	    $this->cabecera('<b>USOS CORRIENTES</b>');
	    $ingreso2= $this->Bloque_Activo($f1,$f2,1,2);
 	    
	    $saldo1 = $ingreso1 + $ingreso2;
 	    
	    //---------------------------------------------------------------
	    $this->cabecera_total('SUPERAVIT O DEFICIT CORRIENTE',$saldo1);
	    //-----------------------------------------------------------------
	    
	    
	    $this->cabecera('<b>FUENTES DE CAPITAL</b>');
	    $ingreso3= $this->Bloque_Activo($f1,$f2,2,1);
	    
	    
	    $valida = $this->Bloque_Activo_verifica($f1,$f2,2,2);
	    if ( $valida  <> 0 ){
	        $this->cabecera('<b>USOS DE PRODUCCION, INVERSION Y CAPITAL</b>');
	        $ingreso4= $this->Bloque_Activo($f1,$f2,2,2);
	        
	    }
	    
	 	    
	    $saldo2 = $ingreso3 + $ingreso4;
	    $this->cabecera_total('SUPERAVIT O DEFICIT DE CAPITAL',$saldo2);
	   
	    $activo = $saldo1 + $saldo2;
	    
	    echo '<h5 align="right" style="background-color:#e0ebff;padding:5px"><b>SUPERAVIT O DEFICIT BRUTO '.number_format($activo ,2).'</b></h5>';
 	    
 	    
	    echo '<p>&nbsp;</p>';
 	    
	    $valida = $this->Bloque_Pasivo_verifica($f1,$f2,3,1);
	    if ( $valida  <> 0 ){
	        $this->cabecera('<b>FUENTES DE FINANCIAMIENTO</b>');
	        $pasivo1= $this->Bloque_Pasivo($f1,$f2,3,1);
 	    }
	    
	  
 	    $valida = $this->Bloque_Pasivo_verifica($f1,$f2,3,2);
 	    if ( $valida  <> 0 ){
 	        $this->cabecera('<b>USOS DE FINANCIAMIENTOS</b>');
 	        $pasivo2= $this->Bloque_Pasivo($f1,$f2,3,2);
 	    }
 	    
 	    
	    
	    $saldo3 = $pasivo1+ $pasivo2;
	    
	    if ( $saldo3  <> 0 ){
	        $this->cabecera_total('SUPERAVIT O DEFICIT DE FINANCIAMIENTO',$saldo3);
	    }
	    
	  	    
	    echo '<h5>FLUJOS NO PRESUPUESTARIOS / FLUJOS NETOS</h5>';
	       
	    $valida = $this->Bloque_Pasivo_verifica($f1,$f2,4,1);
	    if ( $valida  <> 0 ){
	        $this->cabecera('<b>COBROS</b>');
	        $pasivo3= $this->Bloque_Pasivo($f1,$f2,4,1);
	    }
	    
	    $valida = $this->Bloque_Pasivo_verifica($f1,$f2,4,2);
	    if ( $valida  <> 0 ){
	        $this->cabecera('<b>PAGOS</b>');
	        $pasivo4= $this->Bloque_Pasivo($f1,$f2,4,2);
	    }
	       
	    
	    $saldo4 = $pasivo3+ $pasivo4;
	    
	    $this->cabecera_total('FLUJOS NO PRESUPUESTARIOS / FLUJOS NETOS',$saldo4);
	    
	    echo '<h5>VARIACIONES NO PRESUPUESTARIAS</h5>';
	    
	    $this->cabecera('<b>VARIACIONES NETAS</b>');
	    
	    $pasivo5= $this->Bloque_Pasivo($f1,$f2,5,1);
	    
	    
	    $activo1 = $saldo3 + $saldo4 + $pasivo5  ;
	    
	    echo '<h5 align="right" style="background-color:#e0ebff;padding:5px"><b>SUPERAVIT O DEFICIT BRUTO '.number_format($activo1 ,2).'</b></h5>';
	    
	    if ( abs($activo) == abs($activo1)){
	        echo '<h6 align="right" >oK</h6>';
	    }else{
	        $val = $activo + $activo1;
	        echo '<h6 align="right" ><b>DIFERENCIA FLUJO '.number_format($val ,2).'</b></h6>';
	    }
	    
	    
	    
	    echo '</div> ';
	    
	    
	    
	    
	    $this->firmas( );
	    
		
	 
	}
	//----------------------------------------
	public function Bloque_Activo( $f1,$f2,$orden1,$orden2 ){
 
	    
	    $sql = 'SELECT   orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, anio
	             FROM presupuesto.matriz_flujo
                    where seccion = '.$this->bd->sqlvalue_inyeccion('SECCION1',true) .' and 
                           orden1='.$this->bd->sqlvalue_inyeccion( $orden1 ,true) .' and 
                          anio='.$this->bd->sqlvalue_inyeccion( $this->anio  ,true) .' and 
                          orden2='.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' order by orden3' ;
 
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
 
	    $t3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
         
	        $saldo = $this->suma_ejecutado($f1, $f2,trim($x["cuenta"])  ,trim($x["consigno"])      );
  
	        if ( $saldo <> 0 ){
	        
	        echo "<tr>";
	       // echo "<td>".$x['cuenta']."</td>";
	        echo "<td>".$x['grupo3']."</td>";
 	        echo "<td align='right'>".number_format($saldo,2)."</td>";
	        
 	        $t3 = $t3 + $saldo;
 	        
 	        echo "</tr>";
	        }
	    }
	    
	    
	    echo "<tr>";
	   // echo "<td></td>";
	    echo "<td></td>";
 	    echo "<td align='right'>".number_format($t3,2)."</td></tr>";
	    
	    echo '</table>';
	    
 
	     
	    return $t3;
	}
	//----------------------
	//----------------------------------------
	public function Bloque_Activo_verifica( $f1,$f2,$orden1,$orden2 ){
	    
	    
	    $sql = 'SELECT   orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, anio
	             FROM presupuesto.matriz_flujo
                    where seccion = '.$this->bd->sqlvalue_inyeccion('SECCION1',true) .' and
                           orden1='.$this->bd->sqlvalue_inyeccion( $orden1 ,true) .' and
                          anio='.$this->bd->sqlvalue_inyeccion( $this->anio  ,true) .' and
                          orden2='.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' order by orden3' ;
	    
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    
	    $t3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        
	        $saldo = $this->suma_ejecutado($f1, $f2,trim($x["cuenta"])  ,trim($x["consigno"])      );
	        
	        if ( $saldo <> 0 ){
 	            
	            $t3 = $t3 + $saldo;
	            
 	        }
	    }
	    
	     
	    
	    
	    return $t3;
	}
	//------------------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="200" height="120">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="font-size: 14px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTABILIDAD ( PERIODO '.$this->anio.' ) </b><br>
                        <b>ESTADO DE FLUJO DEL EFECTIVO   '.$f1.'  al '.$f2.'</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
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
 
	function suma_ejecutado($fecha1, $fecha2,  $cta1,$consigno){
		
	   
	    $cadena2 = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".
	   	    $this->bd->sqlvalue_inyeccion($fecha2,true)." )   ";
	    
	   	    
	   	    $subgrupo = $cta1.'%';
	   	    
	   	    $len    = strlen(trim($cta1));
	   	    
	   	    $cadena = substr($cta1, 0,3);
	   	    
	   	    $bandera = 0 ;
	   	 
	   	    if ( $consigno == '1')	   {
	   	        
	   	        $select = 'SELECT sum(haber) as monto ';
	   	        
	   	        if ( $len == 3) {
	   	            $where = ' mayor  like ' .$this->bd->sqlvalue_inyeccion( $subgrupo   ,true).$cadena2;
	   	        }else {
	   	            $where = ' subgrupo  = ' .$this->bd->sqlvalue_inyeccion( $cta1   ,true).$cadena2;
	   	        }
	   	    }
	   	    
	   	    if ( $consigno == '-1')	   {
	   	        
	   	        $select = 'SELECT sum(debe) as monto ';
	   	        
	   	        if ( $len == 3) {
	   	            $where = ' mayor  like ' .$this->bd->sqlvalue_inyeccion( $subgrupo   ,true).$cadena2;
	   	        }else {
	   	            $where = ' subgrupo  = ' .$this->bd->sqlvalue_inyeccion( $cta1   ,true).$cadena2;
	   	        }
	   	    }
	   	    
	   	    //-----------------------------------------------------------------------------
	   	    
	   	    $SQL = $select. ' FROM view_diario_esigef   where '.$where;
	   	    
	   	    if ( $cadena == '112') {
	   	        
	   	        $select = 'SELECT (sum(debe)  - sum(haber)) as monto ';
	   	        $SQL = $select. ' FROM view_diario_esigef   where '.$where;
	   	        $resultado1  = $this->bd->ejecutar($SQL);
	   	        $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	        $saldo       =  $datos_sql['monto']  ;
	   	        
	   	        $Asaldo = $this->bd->query_array('view_diario_esigef',
	   	                                         'sum(debe) - sum(haber) as saldoi',
	   	                                         "mayor like '112%' and 
                                                  tipo = 'A' and 
                                                  anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	            );
	   	        
	   	        $saldo = $Asaldo["saldoi"] -  $saldo;
	   	        
	   	        $bandera = 1;
	   	    }
	   	    
	   	    
	   	    if ( $cadena == '212') {
	   	        
	   	        $select = 'SELECT (sum(debe)  - sum(haber)) as monto ';
	   	        $SQL = $select. ' FROM view_diario_esigef   where '.$where;
	   	        $resultado1  = $this->bd->ejecutar($SQL);
	   	        $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	        $saldo       =  $datos_sql['monto']  ;
	   	        
	   	        $Asaldo = $this->bd->query_array('view_diario_esigef',
	   	            'sum(debe) - sum(haber) as saldoi',
	   	            "mayor like '212%' and tipo = 'A' and
                     anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	            );
	   	        
	   	        $saldo = ( $saldo- $Asaldo["saldoi"] ) * -1  ;
	   	        
	   	        $bandera = 1;
	   	    }
	   	    
	   	    
	   	    if ( $cadena == '111') {
	   	        
	   	        $select = 'SELECT (sum(debe)  - sum(haber)) as monto ';
	   	        $SQL = $select. ' FROM view_diario_esigef   where '.$where;
	   	        
	   	        $resultado1  = $this->bd->ejecutar($SQL);
	   	        $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	        $saldo       =  $datos_sql['monto']  ;
 	   	        
	   	        $Asaldo = $this->bd->query_array('view_diario_esigef','sum(debe) - sum(haber) as saldoi',
	   	            "mayor like '111%' and 
                           tipo = 'A' and   
                           anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	            );
	   	        
	   	        $saldo = $Asaldo["saldoi"] -  $saldo;
	   	        
	   	        $bandera = 1;
	   	        
	   	    }
	   	    
	   	    
	   	    if ( $cadena == '619') {
	   	        
	   	        if ( $cta1 == '619.91') {
	   	            
	   	            $select = 'SELECT (sum(debe)  - sum(haber)) as monto ';
	   	            $resultado1  = $this->bd->ejecutar($SQL);
	   	            $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	            $saldo       =  $datos_sql['monto']  ;
	   	            
	   	            
	   	            $Asaldo = $this->bd->query_array('view_diario_esigef','sum(debe) - sum(haber) as saldoi',
	   	                "subgrupo like '619.91%' and 
                        tipo = 'A' and 
                        anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	                );
	   	            
	   	            $saldo = $Asaldo["saldoi"] -  $saldo;
	   	            
	   	            $bandera = 1;
	   	        }
	   	    }
	   	    
 	   	
	  
 	  
	   	if ( $bandera == 0 ){
	   	    
	   	    $resultado1  = $this->bd->ejecutar($SQL);
	   	    $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	    $saldo       =  $datos_sql['monto']  ;
	   	    
	   	    if ( $consigno == '-1'){
	   	        $saldo = $saldo * -1;
	   	    }
	   	}else{
 	   	    	    if ( $consigno == '-1'){
     	   	            $saldo = $saldo * -1;
     	   	    }
	   	}
	  
	    
	    
	    return $saldo;
	    
	    
	    
 
	}
	//------------------------------------------------------------------------
	function cabecera($titulo){
	    
	//    $anio = $this->anio - 1;
	    
	    echo '<table  class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 14px;table-layout: auto">';
	  
	    echo '<tr>
                  <td colspan="3"><b>'.$titulo.'</b></td>
              </tr>';
	    
	    /*<tr>
                   <td width="20%">Flujos de (*) </td>
                   <td width="50%">Concepto</td>
                   <td align="right" width="15%">Vigente<br> ('.$this->anio.')</td>
                 
                </tr>*/
	        
	}
	//------------------------------------------
	function cabecera_total($titulo,$saldo){
	    
	    echo '<table width="100%" style="font-size: 14px;table-layout: auto">';
	    echo '  <tr>
                    <td width="80%"><b>'.$titulo.'</b></td>
                    <td width="20%" align="right"><b>'.number_format($saldo,2).'</b></td>
                </tr></table>';
	    
	    
	}
 
	//--- ultimo nivel
	public function Bloque_Pasivo( $f1,$f2,$orden1,$orden2 ){
	    
	    
	    $sql = 'SELECT   orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, anio
	             FROM presupuesto.matriz_flujo
                    where seccion = '.$this->bd->sqlvalue_inyeccion('SECCION2',true) .' and
                          anio='.$this->bd->sqlvalue_inyeccion( $this->anio  ,true) .' and 
                           orden1='.$this->bd->sqlvalue_inyeccion( $orden1 ,true) .' and
                          orden2='.$this->bd->sqlvalue_inyeccion( $orden2 ,true) .' order by orden3 ';
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    
	    $t3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        
	        $saldo = $this->suma_ejecutado($f1, $f2,trim($x["cuenta"])  ,trim($x["consigno"])      );
	        
	        if ( $saldo <> 0 ){
	        
	        echo "<tr>";
	     //   echo "<td>".$x['cuenta']."</td>";
	        echo "<td>".$x['grupo3']."</td>";
	        echo "<td align='right'>".number_format($saldo,2)."</td>";
	        
	        $t3 = $t3 + $saldo;
	        
	        echo "</tr>";
	        
	        }
	    }
	    
	    echo "<tr>";
 	    echo "<td></td>";
	    echo "<td align='right'>".number_format($t3,2)."</td></tr>";
	    
	    echo '</table>';
	    
	    
	    
	    return $t3;
	}
//----------------------------------------------------------------------------------------	
	//--- ultimo nivel
	public function Bloque_Pasivo_verifica( $f1,$f2,$orden1,$orden2 ){
	    
	    
	    $sql = 'SELECT   orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, anio
	             FROM presupuesto.matriz_flujo
                    where seccion = '.$this->bd->sqlvalue_inyeccion('SECCION2',true) .' and
                          anio='.$this->bd->sqlvalue_inyeccion( $this->anio  ,true) .' and
                           orden1='.$this->bd->sqlvalue_inyeccion( $orden1 ,true) .' and
                          orden2='.$this->bd->sqlvalue_inyeccion( $orden2 ,true) .' order by orden3 ';
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    
	    $t3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        
	        $saldo = $this->suma_ejecutado($f1, $f2,trim($x["cuenta"])  ,trim($x["consigno"])      );
	        
	        if ( $saldo <> 0 ){
 	            $t3 = $t3 + $saldo;
  	        }
	    }
	    
	  
	    return $t3;
	}
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_POST["brfecha1"]))	{
	
	$f1 			    =     $_POST["brfecha1"];
	$f2 				=     $_POST["brfecha2"];
 
 
	$gestion->grilla( $f1,$f2 );
 
	
}



?>
 
  