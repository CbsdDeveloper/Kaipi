<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kpresupuesto/model/Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class archivo_finanzas{
	
 
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function archivo_finanzas( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->login     =  trim($_SESSION['login']);
 		
		$this->anio       =  $_SESSION['anio'];
		
		$this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
		
	}
   
	//--- calcula libro diario
	function balance_periodo( $f2 ){
		
	    $aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];

	    $nombre_archivo = '../../archivos/balance'.$anio.'-'.$mes.'.txt';
	    
	    $archivo = 'balance'.$anio.'-'.$mes.'.txt';
	        
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
 	    
 	    
	    $separador = '|';
 	    
	    
	    //-------------- detalle balance  ----
	    $sql = 'SELECT cuenta, grupo, subgrupo, nivel1, nivel2, detalle, inicial_debe, inicial_haber,
	    debe, haber, suma_debe, suma_haber, deudor, acreedor, anio, sesion, deudor_acreedor, impresion, idpxesigef
                 FROM co_resumen_balance where anio ='.$this->bd->sqlvalue_inyeccion($this->anio , true).'
                 order by cuenta';
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $t1 =      $x['grupo'];
	        $t2 =      $x['subgrupo'];
	        $t3 =      $x['nivel1'];
	        
	        $inicial_debe  =   $x['inicial_debe'] ;
	        $inicial_haber  =  $x['inicial_haber'] ;
	        
	        $debe       =  $this->_cero( $x['debe'] ) ;
	        $haber      =  $this->_cero( $x['haber'] ) ;
 
	        $suma_debe   = $this->_cero($x['suma_debe'] )  ;
	        $suma_haber  = $this->_cero($x['suma_haber'])  ;
	        
	    
	        
	        $deudor   = $this->_cero( abs($x['deudor'] ) ) ;
	        $acreedor = $this->_cero( abs($x['acreedor'] )) ;
	        
	        $v1 = abs($x['deudor'] )  + $inicial_debe  +  $x['debe'];
	        $v2 = abs($x['acreedor'] ) + $inicial_haber + $x['haber'] ;
	        
	        if (($v1 + $v2) > 0 ) {
	        
	        $cadena  = $mes.$separador.
	                   $t1.$separador.
	                   $t2.$separador.
	                   $t3.$separador.
	                   $inicial_debe.$separador.
	                   $inicial_haber.$separador.
	                   $debe.$separador.
	                   $haber.$separador.
	                   $suma_debe.$separador.
	                   $suma_haber.$separador.
	                   $deudor.$separador.
	                   $acreedor;
 
	        
	        if (!empty($cadena)) {
	            
	            fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	            
	        }
	        $i++;
	        
	        }
	        
	    }
	    
	    fclose($fh);
	    
	    echo 'BALANCE DE COMPROBACION <br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	  
	}
	//---------------
	function balance_periodo_bde( $f2 ){
	    
	    $aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];
	    
	    $xx = $this->bd->query_array(
	        'web_registro',
	        'codigo1, unidade',
	        'ruc_registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true)
	        );
	    
	    
	    $codigoc  = $xx['codigo1'] ;
	    $unidade  = $xx['unidade'] ;
	    
	    $nombre_archivo = '../../archivos/balance_bde_'.$anio.'-'.$mes.'.txt';
	    
	    $archivo = 'balance_bde_'.$anio.'-'.$mes.'.txt';
	    
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
	    
	    $separador      = "\t";
	    
	    //-------------- detalle balance  ----
	    $sql = 'SELECT cuenta, grupo, subgrupo,   detalle, deudor_acreedor,
                       sum(inicial_debe) inicial_debe, sum(inicial_haber) inicial_haber,
	                   sum(debe) debe, sum(haber) haber, 
                       sum(suma_debe) suma_debe, sum(suma_haber) suma_haber, 
                       sum(deudor) deudor, sum(acreedor) acreedor
                 FROM co_resumen_balance 
                where anio ='.$this->bd->sqlvalue_inyeccion($this->anio , true).'
                group by cuenta, grupo, subgrupo,   detalle,deudor_acreedor
                 order by cuenta';
	    
 
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $t1 =      $x['grupo'];
	        $t2 =      $x['subgrupo'];
	        $t3 =      $t1.$t2;
 	        
	        $partida  = $codigoc.$unidade;
	        
	        $inicial_debe  =   $x['inicial_debe'] ;
	        $inicial_haber  =  $x['inicial_haber'] ;
	        
	  //      $debe       =  $this->_cero( $x['debe'] ) ;
	  //      $haber      =  $this->_cero( $x['haber'] ) ;
	        
	        $suma_debe   = $this->_cero($x['suma_debe'] )  ;
	        $suma_haber  = $this->_cero($x['suma_haber'])  ;
	        
	        
	        
	        $deudor   = $this->_cero( abs($x['deudor'] ) ) ;
	        $acreedor = $this->_cero( abs($x['acreedor'] )) ;
	        
	        $v1 = abs($x['deudor'] )  + $inicial_debe  +  $x['debe'];
	        $v2 = abs($x['acreedor'] ) + $inicial_haber + $x['haber'] ;
	        
	        if (($v1 + $v2) > 0 ) {
	            
	            $cadena  = $partida.$mes.$separador.
	            $t3.$separador.
	            $inicial_debe.$separador.
	            $inicial_haber.$separador.
	            $suma_debe.$separador.
	            $suma_haber.$separador.
	            $deudor.$separador.
	            $acreedor;
	            
	            
	            if (!empty($cadena)) {
	                
	                fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	                
	            }
	            $i++;
	            
	        }
	        
	    }
	    
	    fclose($fh);
	    
	    
	    $this->bd->libera_cursor($stmt1);
	    
	    echo 'BALANCE DE COMPROBACION <br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	    
	}

	//---------------------------------------------
	//--- calcula libro diario
	function balance_inicial( $f2){
	    
	    $aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];
	    
	    $nombre_archivo = '../../archivos/balance_inicial'.$anio.'-'.$mes.'.txt';
	    
	    $archivo = 'balance_inicial'.$anio.'-'.$mes.'.txt';
	    
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
	    
	    
	    $separador = '|';
	    
	    
	    //-------------- detalle balance  ----
	    $sql = 'SELECT cuenta, grupo, subgrupo, nivel1, nivel2, detalle, inicial_debe, inicial_haber,
	    debe, haber, suma_debe, suma_haber, deudor, acreedor, anio, sesion, deudor_acreedor, impresion, idpxesigef
                 FROM co_resumen_balance where anio ='.$this->bd->sqlvalue_inyeccion($this->anio , true).'
                 order by cuenta';
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $t1 =      $x['grupo'];
	        $t2 =      $x['subgrupo'];
	        $t3 =      $x['nivel1'];
	        
	        $inicial_debe  =   $x['inicial_debe'] ;
	        $inicial_haber  =  $x['inicial_haber'] ;
	        
	        
	        
	        $cadena  = $mes.$separador.
	        $t1.$separador.
	        $t2.$separador.
	        $t3.$separador.
	        $inicial_debe.$separador.
	        $inicial_haber;
	         
	        $total = $inicial_debe + $inicial_haber;
	        
	        if (!empty($cadena)) {
	            
	            if ( $total  > 0 ) {
	             fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	            }
	            
	        }
	        $i++;
	    }
	    
	    fclose($fh);
	    
	    echo 'BALANCE DE COMPROBACION INICIAL<br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	    
	}

	/*
	detalle Reciprocas
	*/

	function detalle_tran( $f2){
	    
		$aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];

	    $nombre_archivo = '../../archivos/detalla_tran_'.$anio.'-'.$mes.'.txt';
	    $archivo 		= 'detalla_tran_'.$anio.'-'.$mes.'.txt';
	        
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
 	    
 	    $separador = '|';
	    
	    //-------------- detalle balance  ----
	    $sql = "SELECT periodo, ruc, cuenta_1, nivel_11, nivel_12, sum(deudor_1) deudor_1, sum(acreedor_1) acreedor_1, 
		ruc1, nombre, grupo, subgrupo, item, 
	   cuenta_2, nivel_21, nivel_22, 
	   sum(deudor_2) deudor_2, 
	   sum(acreedor_2) acreedor_2, 
	    asiento, 
	   min(tramite) as tramite, 
	   min(fecha) as fecha,  min(fecha_pago) as fecha_pago,  COALESCE(min(id_asiento_ref),0) as id_asiento_ref
 FROM  co_reciprocas WHERE anio='".$anio."' and mes ='".(round($mes))."'
 group by periodo, ruc, cuenta_1, nivel_11, nivel_12, ruc1, nombre, grupo, subgrupo, item,cuenta_2,nivel_21, nivel_22,asiento
 order by cuenta_1, nivel_11";
	     
	//  print_r($sql);
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
			$ruc =     trim($x['ruc']);
			$cuenta_1 =     trim($x['cuenta_1']);
	    	$nivel_11 =     trim($x['nivel_11']);
			$nivel_12 =     trim($x['nivel_12']);

			$ruc1   =     trim($x['ruc1']);
			$nombre =     substr( trim($x['nombre']),0,199)   ;
	        
	        $deudor_1  =    $x['deudor_1'] ;
	        $acreedor_1  =  $x['acreedor_1'] ;
	        
			$grupo        =     trim($x['grupo']);
	    	$subgrupo     =     trim($x['subgrupo']);
			$item =     trim($x['item']);

			$cuenta_2 =     trim($x['cuenta_2']);
	    	$nivel_21 =     trim($x['nivel_21']);
			$nivel_22 =     trim($x['nivel_22']);

	        $deudor_2       =  $this->_cero( $x['deudor_2'] ) ;
	        $acreedor_2     =  $this->_cero( $x['acreedor_2'] ) ;
  
			$asiento 		=     trim($x['asiento']);
	    	$id_asiento_ref =     trim($x['id_asiento_ref']);
	        
			$aperiodo = explode('-',$x['fecha']);
			$anio = $aperiodo[0];
	    	$mes  = $aperiodo[1];
	    	$dia = $aperiodo[2];

			$fecha1 = $dia.'/'.$mes.'/'.$anio;
 
			$aperiodo = explode('-',$x['fecha_pago']);
			$anio = $aperiodo[0];
	    	$mes  = $aperiodo[1];
	    	$dia = $aperiodo[2];

			$fecha2= $dia.'/'.$mes.'/'.$anio;
	  
	        
	        $cadena  = $mes.$separador.
	                   $ruc.$separador.
	                   $cuenta_1.$separador.
	                   $nivel_11.$separador.
	                   $nivel_12.$separador.
	                   $deudor_1.$separador.
	                   $acreedor_1.$separador.
	                   $ruc1.$separador.
	                   $nombre.$separador.
	                   $grupo.$separador.
					   $subgrupo.$separador.
					   $item.$separador.
					   $cuenta_2.$separador.
					   $nivel_21.$separador.
					   $nivel_22.$separador.
					   $deudor_2.$separador.
					   $acreedor_2.$separador.
					   $asiento.$separador.
					   $id_asiento_ref.$separador.
	                   $fecha1.$separador.
	                   $fecha2;
  
	            
	            fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	            
	        
	        $i++;
	        
	   
	        
	    }
	    
	    fclose($fh);
	    
	    echo 'BALANCE DE COMPROBACION <br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	    
 
	    
	}

	

	/*
	inicial axuliar
	*/
	//---------------------------------------------
	//--- calcula libro diario
	function balance_inicial_aux( $f2){
	    
	    $aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];
	    
	    $nombre_archivo = '../../archivos/balance_inicial_aux'.$anio.'-'.$mes.'.txt';
	    
	    $archivo = 'balance_inicial_aux_'.$anio.'-'.$mes.'.txt';
	    
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
	    
	    
	    $separador = '|';
	    
	    
	    //-------------- detalle balance  ----
	    $sql = "SELECT  mes,   mayor, grupo, subgrupo, idprov, sum(debe_aux) as debe, sum(haber_aux) as haber 
		FROM  view_esigef_ini
		where tipo = 'T' and anio= ".$this->bd->sqlvalue_inyeccion($this->anio , true)."
		group by  mes,   mayor, grupo, subgrupo, idprov
		order by mes,   mayor, grupo, subgrupo, idprov";
 
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $t1 =      $x['mayor'];
	        $t2 =      $x['grupo'];
	        $t3 =      $x['subgrupo'];

			$idprov 	=      trim($x['idprov']);

			$ArrayRazon = $this->bd->query_array('par_ciu','razon', 'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true));


			if ( $idprov  == '9999999999999'  ) {
				$razon =     'CONSUMIDOR FINAL';
			}
			else{
				$razon =       substr(trim($ArrayRazon['razon']),0,200);
				$razon = 	   str_replace('Ñ','N', $razon);
				$razon = 	   str_replace('.','', $razon);
		    }
			
 
	       
	        
	        $inicial_debe  =   $x['debe'] ;
	        $inicial_haber  =  $x['haber'] ;
	        
	        
	        
	        $cadena  = $mes.$separador.
	        $t1.$separador.
	        $t2.$separador.
	        $t3.$separador.
			$idprov.$separador.
			$razon.$separador.
	        $inicial_debe.$separador.
	        $inicial_haber;
	         
	        $total = $inicial_debe + $inicial_haber;
	        
	        if (!empty($cadena)) {
	            
	            if ( $total  > 0 ) {
	             fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	            }
	            
	        }
	        $i++;
	    }
	    
	    fclose($fh);
	    
	    echo 'BALANCE DE COMPROBACION INICIAL DE APERTURA<br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	    
	}
	
	function trasferencias( $f2){
	    
	    $aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];
	    
//	    $fecha1 = $anio.'-'.$mes. '-01';
	   
	    $sql = "SELECT   subgrupo, mayor, subcuenta,   sum(debe) as debe, sum(haber) as haber
                FROM  view_diario_esigef
                where subgrupo   in ('113.18','213.78','113.28','213.78')  and 
                      anio = "."'".$anio."'"."  and
                      mes = "."'".$mes."'"." 
                group by subgrupo,mayor, subcuenta
                order by subgrupo" ;
 
	    
	    $nombre_archivo = '../../archivos/trasferencia_'.$anio.'-'.$mes.'.txt';
	    
	    $archivo = 'trasferencia_'.$anio.'-'.$mes.'.txt';
	    
	    
	    $separador = '|';
	    
	    //-------------- detalle balance  ----
 	    
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
   
	    // 12|113|28|00|9999999999996|1860001020001|1511425.96|1459155.16|0
	    // 12|213|78|00|1860001020001|1760005030001|8010.06|8337.11|0 this->ruc       =  $_SESSION['ruc_registro'];
 
 
	    $stmt1 = $this->bd->ejecutar($sql);
	    
	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $t1 =      $x['mayor'];
	        $t2 =      $x['subcuenta'];
	        $t3 =      '00';
	        
	        $debe       =  $this->_cero( $x['debe'] ) ;
	        $haber      =  $this->_cero( $x['haber'] ) ;
	        
	        $ruc            =  $this->ruc ;
	        $ruc1           = '9999999999996';
 	         
	       
	        
	        if ( $t1 == '113'){
	            $cadena  = $mes.$separador.
	            $t1.$separador.
	            $t2.$separador.
	            $t3.$separador.
	            $ruc1.$separador.
	            $ruc.$separador.
	            $debe.$separador.
	            $haber.$separador.'0';
	            
	        }else{
	            $cadena  = $mes.$separador.
	            $t1.$separador.
	            $t2.$separador.
	            $t3.$separador.
	            $ruc.$separador.
	            $ruc.$separador.
	            $debe.$separador.
	            $haber.$separador.'0';
	        }
	        
 	        
	        
	        if (!empty($cadena)) {
	            
	            fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	            
	        }
	        $i++;
	    }
	    
 
	    fclose($fh); 
	  
 
	    echo 'ARCHIVO TRASFERENCIAS <br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	    
	}
	//----------------------------------------------------------
	function presupuesto_inicial(  $f2 ){
	    
  
	    $aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];
	    
	    $nombre_archivo = '../../archivos/cedula_inicial_'.$anio.'-'.$mes.'.txt';
	    
	    $archivo = 'cedula_inicial_'.$anio.'-'.$mes.'.txt';
	    
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
	    
	    
	    $separador = '|';
	    
	    
	    //-------------- detalle balance  ----
	    $sql  = 'SELECT tipo, clasificador, grupo, subgrupo, item, compentencia, orientador,
                              inicial, codificado, aumento, disminuye, certificado,
                               compromiso, devengado, pagado, anio
                        FROM presupuesto.view_gestion_resumen
                        where inicial >  0 and anio  ='.$this->bd->sqlvalue_inyeccion($anio, true). 
                            ' order by tipo desc, clasificador';
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    $i = 1;
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $tipo =    $x['tipo'];
	        $t1 =      $x['grupo'];
	        $t2 =      $x['subgrupo'];
	        $t3 =      $x['item'];
	        $t4 =      $x['compentencia'];
	        $t5 =      $x['orientador'];
	    
	        
	        $inicial  =   $x['inicial'] ;
 	        
	        // 12|I|38|01|01|219500.00
	       //  12|G|51|01|05|000|99999999|381576.00
	        
	        $cadena  =  $mes.$separador.
	                    $tipo.$separador.
            	        $t1.$separador.
            	        $t2.$separador.
            	        $t3.$separador;
	        
	        if ( $tipo == 'I') {
	            
	            $cadena  =  $cadena.$inicial;
	            
	        }else {
	            $cadena  =  $cadena.
	                        $t4.$separador.
	                        $t5.$separador.
	                        $inicial;
	        }
	        
	       
	        
	        
	        if (!empty($cadena)) {
	            
	            fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	            
	        }
	        
	        
	        
	        $i++;
	    }
	    
	    fclose($fh);
	    
	    echo 'PRESUPUESTO INICIAL<br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	    
	    
	}
//--------------------
	function presupuesto_periodo(  $f2 ){
	    
	  
	    $aperiodo = explode('-',$f2);
	    
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];
	    
	    $nombre_archivo = '../../archivos/cedula_'.$anio.'-'.$mes.'.txt';
	    
	    $archivo = 'cedula_'.$anio.'-'.$mes.'.txt';
	    
	    
	    $fh = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
 
	    
	    $separador = '|';
	    
	    
	    //-------------- detalle balance  ----
	    $sql  = 'SELECT tipo, grupo, subgrupo, item, max(competencia) competencia, 
                        max(orientador) orientador, 
                        sum(inicial) inicial,
                        sum(reformas) reformas, 
                        sum(codificado) codificado,
                        sum(compromiso) compromiso,  
                        sum(devengado) devengado, 
                        sum(pagado) pagado, 
                        max(anio) anio
                   FROM presupuesto.view_gestion_periodo
                 where anio = '.$this->bd->sqlvalue_inyeccion($anio, true)." and tipo = 'I'
                group by tipo,grupo, subgrupo, item";
	    
	    
	    $sql  = $sql. ' union SELECT tipo, grupo, subgrupo, item, competencia,
                        orientador,
                        inicial,
                        reformas, codificado,compromiso,  devengado, pagado, anio
                   FROM presupuesto.view_gestion_periodo
                 where anio = '.$this->bd->sqlvalue_inyeccion($anio, true)." and tipo = 'G'
                order by 2, 3, 4";
  	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    
	    
	    $i = 1;
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $tipo =    $x['tipo'];
	        $t1 =      $x['grupo'];
	        $t2 =      $x['subgrupo'];
	        $t3 =      $x['item'];
	        $t4 =      $x['competencia'];
	        $t5 =      $x['orientador'];
	        
	        
	        $valida = $x['inicial'] +  $x['codificado'] +  $x['devengado'] ;
	        
	        $inicial  =  $this->_cero( $x['inicial']) ;
         
	        $t6 =     $this->_cero( $x['reformas']);
	        $t7 =     $this->_cero(  $x['codificado']);
	        $t8 =     $this->_cero(  $x['devengado'] );
	        $t9 =      $x['pagado'];
	        $t10 =      $x['compromiso'];
	        
	        // 12|I|38|01|01|219500.00
	        //  12|G|51|01|05|000|99999999|381576.00
	        
	        $cadena  =  $mes.$separador.
	        $tipo.$separador.
	        $t1.$separador.
	        $t2.$separador.
	        $t3.$separador;
	        
	        if ( $tipo == 'I') {
	            
	            $saldo = round($t7,2) - round($t8,2);
	            
	            $saldo = $this->_cero($saldo) ;
	            
	            $cadena  =  $cadena.$inicial.$separador.$t6.$separador.$t7.$separador.$t8.$separador.$t9.$separador.$saldo;
	            
	        }else {
	            
	            $saldoc = round($t7,2) - round($t10,2);
	            $saldod = round($t7,2) - round($t8,2);
	            
	            $saldoc = $this->_cero($saldoc) ;
	            
	            $saldod = $this->_cero($saldod) ;
  	            
	            
	            $cadena  =  $cadena. $t4.$separador. $t5.$separador. $inicial.$separador.$t6.$separador.$t7.$separador.$t10.$separador.$t8.$separador.$t9.$separador.$saldoc.$separador.$saldod;
	        }
	        
	        
	        if ( $valida > 0 ){
        	        
        	        if (!empty($cadena)) {
        	            
        	            fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
        	            
        	        }
        	        
	              $i++;
	        }
	      
	    }
	    
	    fclose($fh);
	    
	    echo 'PRESUPUESTO INICIAL<br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo</a>';
	    
	    
	}
//------------------
	function presupuesto_periodo_bede(  $f2 ){
	    
 	    
	    $xx = $this->bd->query_array(
	        'web_registro',
	        'codigo1, unidade',
	        'ruc_registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true)
	        );
	    
	    
	    $codigoc  = $xx['codigo1'] ;
	    $unidade  = $xx['unidade'] ;
	    $aperiodo = explode('-',$f2);
	    $mes  = $aperiodo[1];
	    $anio = $aperiodo[0];
	    $nombre_archivo = '../../archivos/cedula_ingresos_'.$anio.'-'.$mes.'.txt';
	    $archivo        = 'cedula_ingresos_'.$anio.'-'.$mes.'.txt';
	    $fh             = fopen($nombre_archivo, 'w+') or die("Se produjo un error al crear el archivo");
	    $separador      = "\t";
 	    //-------------- detalle balance  ----
	    $sql  = "SELECT tipo, grupo, subgrupo, item, competencia,
                        orientador,
                        inicial,
                        reformas, codificado,compromiso,  devengado, pagado, anio
                   FROM presupuesto.view_gestion_periodo
                 where tipo = 'I' and anio = ".$this->bd->sqlvalue_inyeccion($anio, true);
	    
	    $stmt1 = $this->bd->ejecutar($sql);
 	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	    
	        $t1 =      $x['grupo'];
	        $t2 =      $x['subgrupo'];
	        $t3 =      $x['item'];
  
	        $partida  = $codigoc.$unidade.$t1.$t2.$t3.'1';
	        $valida   = $x['inicial'] +  $x['codificado'] +  $x['devengado'] ;
	        $inicial  =  $this->_cero( $x['inicial']) ;
	        
	        $t6 =      $this->_cero( $x['reformas']);
	        $t7 =      $this->_cero(  $x['codificado']);
	        $t8 =      $this->_cero(  $x['devengado'] );
	        $t9 =      $x['pagado'];
	        $t10 =     $x['compromiso'];
 
	        $itemb=  $t1.$t2.$t3;
	        $yx = $this->bd->query_array(
	            'presupuesto.pre_catalogo',
	            'detalle',
	            'codigo='.$this->bd->sqlvalue_inyeccion(trim($itemb) ,true)
	            );
	        $nombre = trim($yx['detalle']);
	        
	        $cadena  =  $partida.$separador.$mes.$separador.$nombre.$separador.
	        $inicial.$separador.
	        $t6.$separador.
	        $t7.$separador.
	        $t10.$separador.$t8.$separador.$t9;
 	        
	        if ( $valida > 0 ){
 	            if (!empty($cadena)) {
 	                fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
 	            }
 	            $i++;
	        }
 	    }
	    
	    fclose($fh);
	    $this->bd->libera_cursor($stmt1);
	    //--------------------------------------------
	    //--------------------------------------------
	    //--------------------------------------------
	    //--------------------------------------------
	    $nombre_archivo1 = '../../archivos/cedula_gasto_'.$anio.'-'.$mes.'.txt';
	    $archivo1        = 'cedula_gasto_'.$anio.'-'.$mes.'.txt';
	    $fh             = fopen($nombre_archivo1, 'w+') or die("Se produjo un error al crear el archivo");
 	    
	    //-------------- detalle balance  ----
	    $sql1  = "SELECT  grupo, subgrupo, item,  funcion,
                        inicial,
                        reformas, codificado,compromiso,  devengado, pagado, anio
                   FROM presupuesto.view_gestion_periodo_bde
                 where tipo = 'G' and anio = ".$this->bd->sqlvalue_inyeccion($anio, true);
	    
	    $stmt2 = $this->bd->ejecutar($sql1);
	    $i = 1;
	    while ($x=$this->bd->obtener_fila($stmt2)){
	        
	       
	        $t1 =      $x['grupo'];
	        $t2 =      $x['subgrupo'];
	        $t3 =      $x['item'];
	        
	        
	        
	        $f = substr( $x['funcion'],0,2);
	        
	        $partida  = $codigoc.$unidade.$f.$t1.$t2.$t3.'1';
	        $valida   = $x['inicial'] +  $x['codificado'] +  $x['devengado'] ;
	        $inicial  =  $this->_cero( $x['inicial']) ;
	        
	        $t6 =      $this->_cero( $x['reformas']);
	        $t7 =      $this->_cero(  $x['codificado']);
	        $t8 =      $this->_cero(  $x['devengado'] );
	        $t9 =      $x['pagado'];
	        $t10 =     $x['compromiso'];
	        
	        $itemb=  $t1.$t2.$t3;
	        $yx = $this->bd->query_array(
	            'presupuesto.pre_catalogo',
	            'detalle',
	            'codigo='.$this->bd->sqlvalue_inyeccion(trim($itemb) ,true)
	            );
	        $nombre = trim($yx['detalle']);
	        
	        $cadena  =  $partida.$separador.$mes.$separador.$nombre.$separador.
	        $inicial.$separador.
	        $t6.$separador.
	        $t7.$separador.
	        $t10.$separador.$t8.$separador.$t9;
	        
	        if ( $valida > 0 ){
	            if (!empty($cadena)) {
	                fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
	            }
	            $i++;
	        }
	    }
	    
	    fclose($fh);
	    $this->bd->libera_cursor($stmt2);
	    //--------------------------------------------
	    echo 'PRESUPUESTO <br>Archivo generado '.$nombre_archivo.'<br> Nro. filas '.$i;
	    
	    echo '<br><br><a href="'.$nombre_archivo.'" download="'.$archivo.'" >Presione para descargar Archivo Ingresos</a><br>';
	    
	    echo '<br><br><a href="'.$nombre_archivo1.'" download="'.$archivo1.'" >Presione para descargar Archivo Gastos</a>';
	    
	    
	}
	
//-----------
	function _cero($dato){
	    
	    
	    $valor =   number_format($dato, 2, '.', '');
	    
	  /*  if ( $dato > 0 ){
             	    $p = explode('.', $dato);
            	    
            	    $valor = $dato;
            	    
            	    // 8436.00 
            	    
            	    if ( $p[1] > 0 ){
            	        $lie = strlen($p[1]);
            	        
            	        if ( $lie == 1 ){
            	            $valor = $p[0].'.'.$p[1].'0';
            	        }
            	        
            	    }else{
            	        
            	        $valor = $valor.'.00';
            	        
            	    }
             	    
            	    if ($p[0] == '0' ){
            	        
            	        $valor = '0.00';
            	        
            	    }
	    }else 
	    {
	        
	        $valor = '0.00';
	        
	    }
	    */
	    return $valor;
	}
//---------------
	function titulo($f1,$f2){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");
	    
	    $this->login     =  trim($_SESSION['login']);
	    
	    
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto"> 
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTABILIDAD ( PERIODO '.$this->anio.' ) </b><br>
                        <b>BALANCE DE COMPROBACION POR UNIDAD EJECUTORA '.$f1.'  al '.$f2.'</b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
	    
	}
	
	
	 
//----------------------------------------------------------------------------------------	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new archivo_finanzas;

 
//------ grud de datos insercion
if (isset($_GET["periodo"]))	{
	
    $f2 				=     $_GET["periodo"];
    
    $tipo               =     $_GET["id"];
 
	if ($tipo == '1'){
	    
	    $gestion->balance_periodo($f2);
	    
	}
	
	if ($tipo == '11'){
	    
	    $gestion->balance_inicial_aux($f2);
	    
	}

	if ($tipo == '7'){
	    
	    $gestion->balance_periodo_bde($f2);
	    
	}
	
	if ($tipo == '0'){
	    
	    $gestion->balance_inicial($f2);
	    
	}
	
	if ($tipo == '4'){
	    
	    $gestion->presupuesto_inicial($f2);
	    
	}
 
	
	if ($tipo == '5'){
	    
	    $gestion->presupuesto_periodo($f2);
	    
	}
	
	if ($tipo == '3'){
	    
	    $gestion->trasferencias($f2);
	    
	}
	
	if ($tipo == '8'){
	    
	    $gestion->presupuesto_periodo_bede($f2);
	    
	}
	

	if ($tipo == '12'){
	    
	    $gestion->detalle_tran($f2);
	    
	}
	
	
}

?>