<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


class proceso{
	
 	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $anio;
	private $compa;
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
		
		$this->compa      = 'N';
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$com1){
		
 
	    $this->compa = $com1;
	    
	    echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
	    
	    $this->titulo($f1,$f2);
	    
	    echo '</div> ';
	    
	    echo '<div class="col-md-2"> </div><div class="col-md-7" style="padding: 30px">  ';
 
	    
	    $this->cabecera('<b>RESULTADO DE EXPLOTACION</b>',$com1);
	    $ingreso1= $this->Bloque_Activo($f1,$f2,1,1);
	     
	    $this->cabecera('<b>RESULTADO DE OPERACION</b>',$com1);
	    $ingreso2 = $this->Bloque_Activo($f1,$f2,2,1);
	    
	    $this->cabecera('<b>TRANSFERENCIAS NETAS</b>',$com1);
	    $ingreso3 = $this->Bloque_Activo($f1,$f2,3,1);
	    
	    $this->cabecera('<b>RESULTADO FINANCIERO</b>',$com1);
	    $ingreso4 = $this->Bloque_Activo($f1,$f2,4,1);
	    
	   
	    $this->cabecera('<b>OTROS INGRESOS Y GASTOS</b>',$com1);
	    $ingreso5 = $this->Bloque_Activo($f1,$f2,5,1);
	    

	    
	    $datos_total = $ingreso1 + $ingreso2 + $ingreso3+$ingreso4+$ingreso5;
	    
	    $this->cabecera_total('<b>RESULTADO DEL EJERCICIO ACTUAL ( '.$this->anio.' ) </b>',$datos_total);
	  
	    
	    echo '</div> ';
	    
	    
	    

	    $this->firmas( );
 
		
	 
	}
	//----------------------------------------
	public function Bloque_Activo( $f1,$f2,$orden1,$orden2 ){
 
	    
	    $sql = 'SELECT    orden1, orden2, grupo1, grupo2, guia, cta1, cta2, cta3, sinsigno, consigno, anio
                    FROM presupuesto.matriz_resultados
                    where anio ='.$this->bd->sqlvalue_inyeccion(  $this->anio  ,true) .' and 
                         orden1 = '.$this->bd->sqlvalue_inyeccion( trim($orden1) ,true) .' order by orden2 ';
	    
	    
 
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
 
	    $t3 = 0;
	    $t4 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        //635.01-04;
	        //635.02/03-07
	        
	        
	        $guia    =  trim($x["guia"]);
	        $parte11 =  substr($guia, 6,1);
	        $guia    =  $parte11;
         
	        $saldo = $this->suma_ejecutado($f1, $f2,trim($x["cta1"]) ,trim($x["cta2"]) ,trim($x["cta3"])  ,trim($x["consigno"])  , $guia    );
  
	        
	        echo "<tr>";
	        echo "<td><b>".$x['guia']."</b></td>";
	        echo "<td>".$x['grupo2']."</td>";
 	        echo "<td align='right'>".number_format($saldo,2)."</td>";
 	        
 	        if (   $this->compa == 'S'){
 	            
 	            $saldoa = $this->suma_ejecutado_anterior($f1, $f2,trim($x["cta1"]) ,trim($x["cta2"]) ,trim($x["cta3"])  ,trim($x["consigno"]) ,$guia     );
  	            echo "<td bgcolor='#f9f9f9' style='color: #474747'  align='right'>".number_format($saldoa,2)."</td>";
  	            $t4 = $t4 + $saldoa;
 	            
 	        }else{
 	            echo "</tr>";
 	        }
 	        
 	       
	        
 	        $t3 = $t3 + $saldo;
 	        
	    }
	    
	    echo "<tr>";
	    echo "<td></td>";
	    echo "<td></td>";
 	    echo "<td align='right'>".number_format($t3,2)."</td>";
 	    
 	    if (   $this->compa == 'S'){
 	        echo "<td bgcolor='#f9f9f9' style='color: #474747'  align='right'>".number_format($t4,2)."</td></tr>";
 	    }else{
 	        echo "</tr>";
 	    }
 	   
	    
	    echo '</table>';
	    
 
	     
	    return $t3;
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
                        <b>ESTADO DE RESULTADOS   '.$f1.'  al '.$f2.'</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;<br>
                     &nbsp; <br>
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
 
	function suma_ejecutado($fecha1, $fecha2,  $cta1,$cta2,$cta3,$consigno,$guia =''){
		
	   
	    $cadena2 = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".
	   	    $this->bd->sqlvalue_inyeccion($fecha2,true)." )   ";
	    
	   	$saldo2 = 0;
	   	$saldo  = 0;
	   	    
 	   	$valida3 = strlen($cta3);
	   	$bandera = 0;
	   	
 
	   	if ( $guia == '-') {
	   	    // 635.01-04	635.01	635.04	635.01
	   	    $bandera = 1;
	   	}
	   	
	   	if ( $guia == '/') {
	   	    // 625.01/04	625.01	625.04  -------------   635.02/03-07 ----------624.01/04
 	   	    $bandera = 2;
	   	}
	   	
	   	if ( $bandera == 0 ){
	   	    if ($valida3 == 3){
	   	        $where = ' where mayor  =  ' .$this->bd->sqlvalue_inyeccion( $cta3   ,true).$cadena2;
	   	    }
	   	    if ($valida3 == 6){
	   	        $where = ' where subgrupo  =  ' .$this->bd->sqlvalue_inyeccion( $cta3   ,true).$cadena2;
	   	    }
	   	    
	   	}
   	    //----------------------------------------------------------------------------------------------------
 	   	if ( $bandera == 1 ){
 	   	    $where = ' where subgrupo  =  ' .$this->bd->sqlvalue_inyeccion( $cta1   ,true).$cadena2;
	   	    $bandera = 11; 
	   	}
	   	
	   	if ( $bandera == 2 ){
	   	    $where = ' where subgrupo  between  ' .$this->bd->sqlvalue_inyeccion( $cta1   ,true).' and
                           '.$this->bd->sqlvalue_inyeccion($cta2 ,true).$cadena2;
 	   	    
 	   	  
 	   	    
 	   	    if ($valida3 > 0 ){
 	   	        $bandera = 22; 
 	   	    }
	   	}
	   	
	   	if ( $bandera == 11 ){
	   	    $SQL1 = 'SELECT sum(debe) as debe, sum(haber) AS haber FROM view_diario_esigef
                     WHERE subgrupo  =  ' .$this->bd->sqlvalue_inyeccion( $cta2   ,true).$cadena2;
 	   	    
	   	    $resultado2   = $this->bd->ejecutar($SQL1);
	   	    $datos_sql2   = $this->bd->obtener_array( $resultado2);
	   	    $saldo2       =  $datos_sql2['debe'] - $datos_sql2['haber'] ;
	   	    if ( $consigno == '1'){
	   	        if ( $saldo2 <= 0 ){
	   	            $saldo2 = $saldo2 * -1;
	   	        }
	   	    }
	   	    else{
	   	        if ( $saldo2 > 0 ){
	   	            $saldo2 = $saldo2 * -1;
	   	        }
	   	    }
	   	}
	   	//-------------------------------------------
	   	if ( $bandera == 22 ){
	   	    $SQL1 = 'SELECT sum(debe) as debe, sum(haber) AS haber FROM view_diario_esigef
                     WHERE subgrupo  =  ' .$this->bd->sqlvalue_inyeccion( $cta3   ,true).$cadena2;
	   	    
	   	    $resultado2   = $this->bd->ejecutar($SQL1);
	   	    $datos_sql2   = $this->bd->obtener_array( $resultado2);
	   	    $saldo2       =  $datos_sql2['debe'] - $datos_sql2['haber'] ;
	   	    if ( $consigno == '1'){
	   	        if ( $saldo2 <= 0 ){
	   	            $saldo2 = $saldo2 * -1;
	   	        }
	   	    }
	   	    else{
	   	        if ( $saldo2 > 0 ){
	   	            $saldo2 = $saldo2 * -1;
	   	        }
	   	    }
	   	}
	   	
 	   	
	   	$SQL         = 'SELECT sum(debe) as debe, sum(haber) AS haber  FROM view_diario_esigef '.$where ;
	   	
 	   	
	   	$resultado1  = $this->bd->ejecutar($SQL);
	   	$datos_sql   = $this->bd->obtener_array( $resultado1);
	   	$saldo       =  $datos_sql['debe'] - $datos_sql['haber'] ;
	   	
	   	if ( $consigno == '1'){
	   	    if ( $saldo <= 0 ){
	   	        $saldo = $saldo * -1;
	   	    }
	   	}
	   	else{
	   	    if ( $saldo > 0 ){
	   	        $saldo = $saldo * -1;
	   	    }
	   	}
	   	
	   	
	   	
	   	return $saldo + $saldo2;
	   	
	   	
	   	 
	    
	    
	    
	    
 
	}
//--------------------
	function suma_ejecutado_anterior($fecha1, $fecha2,  $cta1,$cta2,$cta3,$consigno,$guia =''){
	    
	    
	   
	   	    
	    $anio = $this->anio - 1;
 	    
	    $cadena2 = ' and ( anio = '.$this->bd->sqlvalue_inyeccion($anio,true) .' )'  ;
	   	    
	   	    $valida = strlen($cta1);
	   	    
	   	    if ( $valida > 3 )    {
	   	        
	   	        $parte1 = substr($cta1, 0,3);
	   	        $parte2 = substr($cta1, 3,2);
	   	        $subgrupo = $parte1.'.'.$parte2;
	   	        
	   	        $subgrupo = $cta1;
	   	        
	   	        $parte11 = substr($cta2, 0,3);
	   	        $parte21 = substr($cta2, 3,2);
	   	        $subgrupo1 = $parte11.'.'.$parte21;
	   	        
	   	        $subgrupo1 = $cta2;
	   	        
	   	        $SQL = 'SELECT sum(debe) as debe, sum(haber) AS haber
            	    FROM view_diario_esigef
            	    where subgrupo  between  ' .$this->bd->sqlvalue_inyeccion( $subgrupo   ,true).' and
                           '.$this->bd->sqlvalue_inyeccion($subgrupo1 ,true).$cadena2;
	   	        
	   	        
	   	    }else{
	   	        //subgrupo
	   	        $parte1 = substr($cta3, 0,3);
	   	        $parte2 = substr($cta3, 3,2);
	   	        $subgrupo = $parte1.'.'.$parte2;
	   	        
	   	        $subgrupo = $cta3;
	   	        
	   	        $valida = strlen($cta3);
	   	        
	   	        if ( $valida == 3 ){
	   	            $SQL = 'SELECT sum(debe) as debe, sum(haber) AS haber
            	    FROM view_diario_esigef
            	    where mayor  =  ' .$this->bd->sqlvalue_inyeccion( $parte1   ,true).$cadena2;
	   	        }else{
	   	            $SQL = 'SELECT sum(debe) as debe, sum(haber) AS haber
            	    FROM view_diario_esigef
            	    where subgrupo  =  ' .$this->bd->sqlvalue_inyeccion( $subgrupo   ,true).$cadena2;
	   	        }
	   	        
	   	    }
	   	    
	   	    
	   	    $resultado1 = $this->bd->ejecutar($SQL);
	   	    
	   	    $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	    
	   	    $saldo =  $datos_sql['debe'] - $datos_sql['haber'] ;
	   	    
	   	    
	   	    if ( $consigno == '1'){
	   	        if ( $saldo <= 0 ){
	   	            $saldo = $saldo * -1;
	   	        }
	   	    }
	   	    else{
	   	        if ( $saldo > 0 ){
	   	            $saldo = $saldo * -1;
	   	        }
	   	    }
	   	    
	   	    return $saldo;
	   	    
	   	    
	   	    
	   	    
	}
	//------------------------------------------------------------------------
	function cabecera($titulo,$com1){
	    
	    $anio = $this->anio - 1;
	    
	    $cadena = '';
	    
	    if ( $com1 == 'S'){
	        $cadena = '<td align="right"  bgcolor="#f9f9f9" style="color: #474747" width="15%">Anterior<br> ('.$anio.')</td>';
	    }
	    
	    echo '<table  class="table table-bordered" width="100%" style="font-size: 13px;table-layout: auto">';	    
	    echo ' <tr>
                  <td colspan="5"><b>'.$titulo.'</b></td>
                 </tr>
                <tr>
                   <td width="15%">Cuenta</td>
                   <td width="55%">Concepto</td>
                   <td align="right" width="15%">Vigente<br> ('.$this->anio.')</td>
                   '.$cadena.'
                </tr>';
	    
 
	        
	}
	//------------------------------------------
	function cabecera_total($titulo,$saldo){
	    
	    echo '<table width="100%" style="font-size: 15px;table-layout: auto">';
	    echo '  <tr>
                    <td width="80%"></b>'.$titulo.'</b></td>
                    <td width="20%" align="right"><b>'.number_format($saldo,2).'</b></td>
                </tr></table>';
	    
	    
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
//----------------------------------------------------------------------------------------	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =     $_POST["ffecha1"];
	$f2 				=     $_POST["ffecha2"];
 
	$com1 				=     $_POST["com1"];
 
	$gestion->grilla( $f1,$f2 ,$com1);
 
	
}



?>