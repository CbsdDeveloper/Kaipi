<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

include('../../reportes/phpqrcode/qrlib.php');

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
 		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
//------------------------------------------------------------
	function _etiqueta_sumatoria( $id,$tipo){
 	    
	    $bandera     =  1;
	    $array_datos =  array();
	    
	    if ($tipo == 'I'){
	        $destino = 'MOVIMIENTO INGRESOS';
	    }elseif ($tipo == 'E'){
	        $destino = 'MOVIMIENTO EGRESOS';
	    }elseif ($tipo == 'F'){
	        $destino = 'Facturacion';
	    }
	    
	    if ($id == 1 ){
	        if ($tipo == 'I'){
	            $this->obj->grid->KP_sumatoria(8,"baseimponible","iva", "tarifa0","total");
	        }else{
	            $this->obj->grid->KP_sumatoria(8,"total","", "","");
	        }
	    }elseif ($id == 2 ){
	        if ($tipo == 'I'){
	            $this->obj->grid->KP_sumatoria(4,"baseimponible","iva", "tarifa0","total");
	        }else{
	            $this->obj->grid->KP_sumatoria(4,"total","", "","");
	        }
	    }elseif ($id == 3 ){
	        if ($tipo == 'I'){
	            $this->obj->grid->KP_sumatoria(3,"baseimponible","iva", "tarifa0","total");
	        }else{
	            $this->obj->grid->KP_sumatoria(3,"total","", "","");
	        }
	    }elseif ($id == 4 ){
	        $destino = 'MOVIMIENTO INGRESOS';
	        $this->obj->grid->KP_sumatoria(3,"baseimponible","iva", "tarifa0","");
	    }elseif ($id == 5 ){
	        
	        $destino = 'RESUMEN POR PERIODO POR CUENTA';
	        $bandera  = 2;
	        
	    }elseif ($id == 6 ){
	        
	        $destino = 'RESUMEN POR PERIODO POR CUENTA';
	        $bandera = 0;
	        
	    }elseif ($id == 61 ){
	        
	        $destino = 'RESUMEN POR PERIODO POR CUENTA';
	        $bandera = 6;
	        
	    }elseif ($id == 62 ){
	        
	        $destino = 'RESUMEN POR PERIODO POR CUENTA';
	        $bandera = 7;
	        
	    }elseif ($id == 63 ){
	        
	        $bandera = 9;
	        
	    }elseif ($id == 64 ){
	        
	        $destino = 'RESUMEN POR PERIODO GENERAL';
	        $bandera = 8;
	        
	    }elseif ($id == 8 ){
	        $this->obj->grid->KP_sumatoria(5,"costo","", "","");
			$bandera = 81;
 	   }elseif ($id == 201 ){
		$destino = 'RESUMEN POR PERIODO GENERAL CONSUMO POR UNIDAD';
		$bandera = 201;
	}elseif ($id == 202 ){
		$destino = 'RESUMEN POR PERIODO GENERAL FINANCIERO POR UNIDAD';
		$bandera = 202;
	}elseif ($id == 205 ){
		$destino = 'RESUMEN POR ARTICULO/PRODUCTO';
		$bandera = 205;
	}
	elseif ($id == 301 ){
		$destino = 'RESUMEN POR ROTACION DE PRODUCTOS';
		$bandera = 301;
	 }
	    
	    $array_datos[0] = $destino;
	    $array_datos[1] = $bandera;
	    
	    return $array_datos;
	}
//-----------------------------------------
	function grilla( $f1,$f2,$tipo,$id,$cbodega,$ccuentas,$producto_busca){
	    
	     $tipodb 		= $this->bd->retorna_tipo();
	     $anioArray     = explode('-', $f2);
	     $anio          = $anioArray[0];
	     $f11           = $anio.'-01-01';
	     
	    
		 $this->titulo( $anio  );

	     $etiqueta     = $this->_etiqueta_sumatoria( $id, $tipo);
	     $destino      = $etiqueta[0];
	     $bandera      = $etiqueta[1];
	     
	     $sql         = $this->_sql( $f1,$f2,$tipo,$id,$ccuentas);
	     $ViewForm    = ' <h5><b>MOVIMIENTO DE INVENTARIOS </h5><h6> <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.' </h6> </b>';
	     $formulario  = '';
	     $action      = '';
	    
	     
	     echo $ViewForm;
  
		
	     if ( $bandera == 0 ){
	         
	        $this->Mov_grupo_inventarios(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas);
	         
	     }elseif($bandera == 1){
	         
			echo '<div class="col-md-12"> ';
	         $resultado  = $this->bd->ejecutar($sql);
	         $this->obj->grid->KP_GRID_CTA_query($resultado,$tipodb,'Id',$formulario,'S','',$action,'','',4);
			 $this->firmas_elaborado();

			 echo '</div> ';
	         
	     }elseif($bandera == 2){
	         
	       $this->Mov_grupo_conta(  $f1,$f2,$tipo,$id);
	         
	     }elseif($bandera == 7){
	         
	         $this->Mov_grupo_inventarios_saldos(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas);
	         
	     }elseif($bandera == 8){
	         
	         $this->Mov_grupo_inventarios_saldos1(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas);
	         
	     }elseif($bandera == 6){
	         
	         $this->Mov_grupo_inventarios_res(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas,1);
	         
	     }elseif($bandera == 9){
	         
	         $this->Mov_grupo_inventarios_res(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas,2);
	         
	    
		}elseif($bandera == 81){
	         
 			$this->Mov_grupo_detalle(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas, $sql );
			
		}elseif($bandera == 201){
				
		    $this->Mov_grupo_unidades(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas);

	    }elseif($bandera == 202){
				
		    $this->Mov_grupo_unidades1(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas);

		}elseif($bandera == 205){
				
		    $this->Mov_grupo_unidades_pro(  $f11,$f2,$tipo,$id,$cbodega,$ccuentas,$producto_busca);

	    }elseif($bandera == 301){
				
		    $this->Mov_grupo_rotacion(   $anio,$tipo,$id,$cbodega,$ccuentas);
	    }

		
	 
	}
//---------------------------
//----------------------------------------------------------------
function Mov_grupo_detalle( $f11,$f2,$tipo,$id,$cbodega,$ccuentas,$sql1 ){
	    
	 
	/*
		SELECT producto,
                                      cuenta_inv || ' ' as cuenta_inventario,
                                      cuenta_gas || ' ' as cuenta_gasto,
            	                      sum(cantidad)  || ' ' as cantidad,
                                      sum(coalesce(total)) as costo,
									  sum(coalesce(total)) /  sum(cantidad)  as media,
									  min(costo) as minimo,
									  max(costo) as maximo
									  */
	
if ( $ccuentas == '-') {
}
else {
    echo '<h4>Cuenta Seleccionada: '.$ccuentas .'</h4>';	
}


	$this->cabecera_mov();
	
	$stmt  = $this->bd->ejecutar($sql1);
  
 	
	while ($x=$this->bd->obtener_fila($stmt)){
		
		$idproducto = $x['idproducto'];
		$cantidad   = round($x['cantidad'],2);
		$costo_p    = $x['media'];   
 	    $costo      = $x['costo'];
		
		$minimo     = $x['minimo'];
		$maximo     = $x['maximo'];

		$cadena = '<a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalActualiza" onclick="BuscaCuenta('.$idproducto.')"> 
		'.$x['idproducto'].'</a>';
		
		$cadena1 = '<a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalActualiza" onclick="BuscaMov('.$idproducto.')"> 
		'.$x['producto'].'</a>';

		echo "<tr>";
		echo "<td>".$cadena ."</td>";
		echo "<td><b>".$cadena1 ."</b></td>";
	
		echo "<td><b>".$x['cuenta_inventario']."</b></td>";
		echo "<td><b>".$x['cuenta_gasto']."</b></td>";

		echo "<td>".$cantidad."</td>";

		echo "<td>".number_format($costo,4)."</td>";
		echo "<td>".number_format($costo_p,4)."</td>";

		echo "<td>".number_format($minimo,4)."</td>";
		echo "<td>".number_format($maximo,4)."</td>";
 
 

		echo "</tr>";
	}
 
	echo "</table>";
	
	
	unset($x); //eliminamos la fila para evitar sobrecargar la memoria
	
	pg_free_result ($stmt) ;
	
}	
//-----------------------------------------------------------	
	function _sql( $f1,$f2,$tipo,$id,$ccuentas){
	    
	    $anioArray     = explode('-', $f2);
	    $anio          = $anioArray[0];
	    
	    if ($id == 1)  {
        	        if ( $tipo == 'I') {


					   $sqlconta = " ( SELECT max(b.id_asiento) || '/<b>' || max(b.fecha) || '</b>' as periodo
									FROM co_asiento b
									WHERE b.id_tramite = a.id_tramite and b.estado= 'aprobado') as tramite_enlace_contable_fecha ";

        	            $sql = "SELECT a.id_movimiento as nro_movimiento,
									   '<b>' || a.fecha || '</b>'    as fecha_ingreso_inv,
									   a.comprobante as nro_comprobante,
                                       trim(a.detalle) detalle, 
									   a.id_tramite || ' ' as tramite,". $sqlconta.",
                                       a.idprov  || ' ' as identificacion,proveedor,
                                       a.base12 as baseimponible,
									   a.iva,
									   a.base0 as tarifa0,
									   a.total
                                    FROM  view_inv_transaccion a
                                    where a.tipo     ='".$tipo."' and
                                          a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                          a.estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                          (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )  order by a.fecha desc,a.comprobante desc ";

										 
        	        }else {
        	            $sql ="SELECT id_movimiento as nro_movimiento,  
										  fecha  as fecha_ingreso_inv,  
										  comprobante as nro_comprobante,
                                          trim(detalle) detalle,   unidad, idprov  || ' ' as identificacion,
                                          proveedor as solicita,  total
                                    FROM  view_inv_transaccion
                                    where tipo     ='".$tipo."' and
                                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                          estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
										  order by fecha desc,comprobante desc";
        	        }
	    }
	    
	    if ($id == 2)  {
         	        if ( $tipo == 'I') {
        	            $sql ="SELECT idprov  || ' ' as identificacion,proveedor,
                                  count(*) || ' ' as transaccion,
                                  sum(base12) as baseimponible,
                                  sum(iva) as iva,
                                  sum(base0) as tarifa0,
                                  sum(total) as total
                            FROM  view_inv_transaccion
                            where tipo     ='".$tipo."' and
                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                             group by  idprov,    proveedor
                             order by proveedor ";
        	        }else {
         	            $sql ="SELECT unidad   ,  transaccion as tipo,
                                   count(*) || ' ' as transaccion,
                                   sum(total) as total
                            FROM  view_inv_transaccion
                            where tipo     ='".$tipo."' and
                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                             group by  unidad,transaccion
                             order by unidad ";
        	        }
 	    }
	    
	    if ($id == 3)  {
	        $detalleMes = "CASE WHEN mes='1' THEN '01. ENERO' WHEN
                                   mes='2' THEN '02. FEBRERO' WHEN
                                   mes='3' THEN '03. MARZO' WHEN
                                   mes='4' THEN '04. ABRIL' WHEN
                                   mes='5' THEN '05. MAYO' WHEN
                                   mes='6' THEN '06. JUNIO' WHEN
                                   mes='7' THEN '07. JULIO' WHEN
                                   mes='8' THEN '08. AGOSTO' WHEN
                                   mes='9' THEN '09. SEPTIEMBRE' WHEN
                                   mes='10' THEN '10. OCTUBRE' WHEN
                                   mes='11' THEN '11. NOVIEMBRE' ELSE '12. DICIEMBRE' END ";
	        
                	        if ( $tipo == 'I') {
                	            $sql ="SELECT ".$detalleMes." as mes, count(*) || ' ' as transaccion,
                                          sum(base12) as baseimponible,
                                          sum(iva) as iva,
                                           sum(base0) as tarifa0,
                                          sum(total) as total
                                    FROM  view_inv_transaccion
                                    where tipo ='".$tipo."' and
                                          estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                          anio = ".$anio."
                                     group by  mes
                                     order by mes ";
                	        }else{
                	            $sql ="SELECT ".$detalleMes." as mes, count(*) || ' ' as transaccion,
                                           sum(total) as total
                                    FROM  view_inv_transaccion
                                    where tipo ='".$tipo."' and
                                          estado = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
                                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                          anio = ".$anio."
                                     group by  mes
                                     order by mes ";
                	        }
 	    }
	    
	    if ($id == 4)  {
        	        $tipo  = 'I';

        	        $sql   = "SELECT producto,
        	                      sum(cantidad)  || ' ' as cantidad,
                                  sum(coalesce(baseiva)) as baseimponible,
                                  sum(coalesce(monto_iva,0)) as iva,
                                  sum(coalesce(tarifa_cero,0)) as tarifa0
                            from view_movimiento_det_cta
                           where tipo ='".$tipo."' and
                                  estado = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
                                  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                             group by producto order by  producto ";
	    }
	 	    
	    if ($id == 8)  {
             	        if ( $ccuentas == '-'){
            	            $sql ="SELECT producto,idproducto,
                                      cuenta_inv || ' ' as cuenta_inventario,
                                      cuenta_gas || ' ' as cuenta_gasto,
            	                      sum(cantidad)  || ' ' as cantidad,
                                      sum(coalesce(total)) as costo,
									  sum(coalesce(total)) /  sum(cantidad)  as media,
									  min(costo) as minimo,
									  max(costo) as maximo
                                 from view_inv_movimiento_det
                               where  tipo ='".$tipo."' and
                                      estado = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
                                      (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                                 group by idproducto,producto,cuenta_inv,cuenta_gas order by  producto ";
            	        }else  {
            	            $sql ="SELECT producto,idproducto,
                                      cuenta_inv || ' ' as cuenta_inventario,
                                      cuenta_gas || ' ' as cuenta_gasto,
            	                      sum(cantidad)  || ' ' as cantidad,
                                      sum(coalesce(total)) as costo,
									  sum(coalesce(total)) /  sum(cantidad)  as media,
									  min(costo) as minimo,
									  max(costo) as maximo
                                 from view_inv_movimiento_det
                               where  tipo       ='".$tipo."' and
                                      estado     = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
                                      cuenta_inv = ".$this->bd->sqlvalue_inyeccion(trim($ccuentas), true)." and
                                      (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                                 group by idproducto,producto,cuenta_inv,cuenta_gas order by  producto ";
             	        }
 	    }
	    
	    return $sql;
	    
	}
	//------------------------------------------------------------------
	function Mov_grupo_inventarios_res( $f1,$f2,$tipo,$id,$cbodega,$ccuentas,$tipo_mov){
	    
	    
	    
	    echo '<div class="col-md-12"> ';
	    
	    $etiqueta = 'Resumen general por cuenta ';
	    
	    echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';
	    
                       $this->movimiento_compras_general($f1,$f2,$id,$cbodega,$tipo_mov);
	    
	    
	    echo '</div> ';
	}
	//------------------------------------------------------------------
	function movimiento_compras_general( $f1,$f2,$id,$cbodega,$tipo_mov){
 	
	    
	    $anioArray     = explode('-', $f2);
	    $anio          = $anioArray[0];
	    $fecha         = $anio.'-01-01';
	    
	if ( $cbodega == 0 ){
	    
	    $sql1 ="SELECT  sum(entrada) entrada,
                            sum(salida) salida,
                            sum(saldo) saldo,
                            sum(ventrada) ventrada,
                            sum(vsalida) vsalida,
                            sum(vsaldo) vsaldo,
                            cuenta_inv
                FROM  view_kardex_periodo
                group by cuenta_inv
            order by cuenta_inv";
 	}else{
	    
	    $sql1 ="SELECT  sum(entrada) entrada,
                            sum(salida) salida,
                            sum(saldo) saldo,
                            sum(ventrada) ventrada,
                            sum(vsalida) vsalida,
                            sum(vsaldo) vsaldo,
                            cuenta_inv
                FROM  view_kardex_periodo
	            where idbodega = ".$this->bd->sqlvalue_inyeccion( $cbodega, true)."
                group by cuenta_inv
               order by cuenta_inv";
 	}
 	
 	$this->cabecera_general($tipo_mov);
	
	$stmt  = $this->bd->ejecutar($sql1);
    $suma1 = 0;
	$suma2 = 0;
	$suma3 = 0;
	
	while ($x=$this->bd->obtener_fila($stmt)){
 	    
	    $xy = $this->bd->query_array('co_plan_ctas',   // TABLA
	        'max(detalle) as detalle',                        // CAMPOS
	        'cuenta='.$this->bd->sqlvalue_inyeccion(trim($x['cuenta_inv']),true) // CONDICION
	        );
	    
	    $detalle = $xy['detalle'];
	    $ningreso = $x['entrada'];
	    $nsalida  = $x['salida'];
	    $nsaldo   = $x['saldo'];
	    
	    $singreso = round($x['ventrada'],2);
	    $ssalida  = round($x['vsalida'],2);
	    $ssaldo   = round($x['vsaldo'],2);
	    
	    if ( $nsaldo >  0 ){
	        $costo_p = $ssaldo / $nsaldo;
	    }else{
	        $costo_p = $x['costo'];
	    }
	    
	    
	    $ssaldo = $singreso - $ssalida;
	    $suma1  = $singreso + $suma1 ;
	    $suma2  = $ssalida + $suma2;
	    
	    echo "<tr>";
	    echo "<td>".trim($x['cuenta_inv'])."</td>";
	    echo "<td><b>".$detalle."</b></td>";
	    echo "<td>".number_format($costo_p,4)."</td>";
	    
	    echo "<td>".$ningreso."</td>";
	    echo "<td>".$nsalida."</td>";
	    echo "<td>".$nsaldo."</td>";
	    
	    echo "<td>".number_format($singreso,2)."</td>";
	    echo "<td>".number_format($ssalida,2)."</td>";
	    echo "<td>".number_format($ssaldo,2)."</td>";
	    
	    if ( $tipo_mov == 2 ){
	        
	        $x_saldos = $this->bd->query_array('view_diario_conta',   // TABLA
	            'sum(debe) - sum(haber) as saldo',                        // CAMPOS
	            'anio='.$this->bd->sqlvalue_inyeccion($anio,true) .' and 
                cuenta='.$this->bd->sqlvalue_inyeccion(trim($x['cuenta_inv']),true)." and
                (fecha  BETWEEN "."'".$fecha."'". ' AND '."'".$f2."' ) " 
	            );
	        
	        $saldo_con = $ssaldo - $x_saldos['saldo'];
 
	        echo "<td>".number_format($x_saldos['saldo'],2)."</td>";
	        
	        echo "<td>".number_format($saldo_con,2)."</td>";
	        
	    }
	    echo "</tr>";
	}
	
	echo "<tr>";
	echo "<td> </td>";
	echo "<td> </td>";
	echo "<td> </td>";
	
	echo "<td> </td>";
	echo "<td> </td>";
	echo "<td> </td>";
	
	$suma3 = $suma1 - $suma2;
	
	echo "<td>".$suma1."</td>";
	echo "<td>".$suma2."</td>";
	echo "<td>".$suma3."</td>";
	echo "</tr>";
	
	echo "</table>";
	
	
	unset($x); //eliminamos la fila para evitar sobrecargar la memoria
	
	pg_free_result ($stmt) ;
	
}
//------------------------------------------------------------------
function cabecera_general($tipo){
    
    $cadena = '';
    $with   = '17%';
    $with1  = '34%';
    
    if ( $tipo == 2){
        $cadena =  '<th width="7%" bgcolor="#FFA8A9" >Balance ($)</th>'.
                   '<th width="7%" bgcolor="#FFA8A9" >Dif.</th>';
        $with   =  '10%';
        $with1  =  '27%';
    }
    echo '<table class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 10px;table-layout: auto">
               <th width="'.$with.'" >Cuenta</th>
        	   <th width="'.$with1.'" >Detalle</th>
               <th width="7%">Promedio</th>
        	   <th width="7%" bgcolor=#E6FF89>Entradas</th>
        	   <th width="7%" bgcolor=#E6FF89>Salidas</th>
        	   <th width="7%" bgcolor=#E6FF89>Saldo</th>
        	   <th width="7%" bgcolor="#FFA8A9">Ingreso</th>
        	   <th width="7%" bgcolor="#FFA8A9">Egreso ($)</th>
        	   <th width="7%" bgcolor="#FFA8A9" >Saldo ($)</th>'.$cadena.'
        		</tr> 	';
    
}
	//------------------------------------------------------------------
	function Mov_grupo_inventarios_saldos1( $f1,$f2,$tipo,$id,$cbodega,$ccuentas){
	    
	    $sql ="select a.cuenta_inv as inventario, b.detalle,a.idbodega
                 FROM view_kardex_periodo a , co_plan_ctas b
                 where   a.cuenta_inv = b.cuenta and
                         a.anio::character varying::text = b.anio
                  group by a.cuenta_inv,b.detalle,a.idbodega   ";
	    
	    
	    $stmt_lista = $this->bd->ejecutar($sql);
	    
	    echo '<div class="col-md-12"> ';
	    
	    while ($x=$this->bd->obtener_fila($stmt_lista)){
	        
	        $cuenta = trim($x['inventario']);
	        $detalle = trim($x['detalle']);
	        $cbodega =   $x['idbodega'] ;
	        
	        $etiqueta = $cuenta.' '.$detalle;
	        
	        echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';
	        $this->movimiento_compras_saldos($f1,$f2,$id,$cuenta,$cbodega);
	        
	    }
	    
	    echo '</div> ';
	}
	//------------------------------------------------------------------
	function Mov_grupo_inventarios_saldos( $f1,$f2,$tipo,$id,$cbodega,$ccuentas){
	    
	    if ( $ccuentas == '-'){
	        
	        $sql ="select a.cuenta_inv as inventario, b.detalle
                 FROM view_kardex_periodo a , co_plan_ctas b
                 where   a.cuenta_inv = b.cuenta and
                         a.idbodega = ".$this->bd->sqlvalue_inyeccion( $cbodega, true)." and
                         a.anio::character varying::text = b.anio
                  group by a.cuenta_inv,b.detalle  ";
	        
	    }else {
	        
	        $sql ="select a.cuenta_inv as inventario, b.detalle
                 FROM view_kardex_periodo a , co_plan_ctas b
                 where   a.cuenta_inv = b.cuenta and
	                     a.idbodega = ".$this->bd->sqlvalue_inyeccion( $cbodega, true)." and
                         a.cuenta_inv = ".$this->bd->sqlvalue_inyeccion( trim($ccuentas), true)." and
                         a.anio::character varying::text = b.anio
                  group by a.cuenta_inv, b.detalle  ";
	    }
	    
	  
	    
	    $stmt_lista = $this->bd->ejecutar($sql);
	    
	    
	    echo '<div class="col-md-12"> ';
	    
	    while ($x=$this->bd->obtener_fila($stmt_lista)){
	        
	        $cuenta   = trim($x['inventario']);
	        $detalle  = trim($x['detalle']);
	        $etiqueta = $cuenta.' '.$detalle;
	        
	        echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';
	        $this->movimiento_compras_saldos($f1,$f2,$id,$cuenta,$cbodega);
	        
	    }
	    
	    echo '</div> ';
	}
	//-------------------------------------------------------------------------------
	function movimiento_compras_saldos( $f1,$f2,$id,$cuenta,$cbodega){

	    $this->cabecera();
	    
	    $sql1 = "SELECT idbodega, idproducto, entrada, salida, saldo,
                ventrada, vsalida, vsaldo, anio, producto, cuenta_inv, cuenta_gas,
                unidad, minimo
                FROM  view_kardex_periodo
	            where idbodega = ".$this->bd->sqlvalue_inyeccion( $cbodega, true)." and
                      cuenta_inv = ".$this->bd->sqlvalue_inyeccion( trim($cuenta), true)." and
                      saldo > 0
            order by producto";
	    
	    $stmt  = $this->bd->ejecutar($sql1);
	    $suma1 = 0;
	    $suma2 = 0;
	    $suma3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $ningreso = $x['entrada'];
	        $nsalida  = $x['salida'];
	        $nsaldo   = $x['saldo'];
	        
	        
	        $singreso = round($x['ventrada'],2);
	        $ssalida  = round($x['vsalida'],2);
	        $ssaldo   = round($x['vsaldo'],2);
	        
	        if ( $nsaldo >  0 ){
	            $costo_p = $ssaldo / $nsaldo;
	        }else{
	            $costo_p = $x['costo'];
	        }
	        
	        $ssaldo = $singreso- $ssalida;
	        $suma1  = $singreso + $suma1 ;
	        $suma2  = $ssalida + $suma2;
	        
	        echo "<tr>";
	        echo "<td>".$x['idproducto']."</td>";
	        echo "<td><b>".$x['producto']."</b></td>";
	        echo "<td><b>".$x['unidad']."</b></td>";
	        echo "<td>".$x['minimo']."</td>";
	        echo "<td>".number_format($costo_p,4)."</td>";
	        
	        echo "<td>".$ningreso."</td>";
	        echo "<td>".$nsalida."</td>";
	        echo "<td>".$nsaldo."</td>";
	        
	        echo "<td>".number_format($singreso,2)."</td>";
	        echo "<td>".number_format($ssalida,2)."</td>";
	        echo "<td>".number_format($ssaldo,2)."</td>";
	        echo "</tr>";
	    }
	    
	    echo "<tr>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    
	    $suma3 = $suma1 - $suma2;
	    
	    echo "<td>".$suma1."</td>";
	    echo "<td>".$suma2."</td>";
	    echo "<td>".$suma3."</td>";
	    echo "</tr>";
	    
	    echo "</table>";
	    
	    
	    unset($x); //eliminamos la fila para evitar sobrecargar la memoria
	    
	    pg_free_result ($stmt) ;
	    
	}
	//------------------------------------------------------------------
	function Mov_grupo_conta( $f1,$f2,$tipo,$id){
	    
	    $etiqueta      = 'RESUMEN TRANSACCIONES CONTABILIDAD ';
	    $tipo1 		   =  $this->bd->retorna_tipo();
	    $formulario    =  '';
	    $action        =  '';
	    
	    $anioArray     = explode('-', $f2);
	    $anio          = $anioArray[0];
	    
	    echo '<div class="col-md-8"> ';
	    echo '<ul class="list-group">  <li class="list-group-item"> <b>'.$etiqueta.'</b></li> </ul>';
        	    // tomar en cuenta el campo de total sin iva
        	    //  sum(a.tarifa_cero)  + sum(a.baseiva)  as costo_total

        	    $sql1 ="SELECT    cuenta || ' ' as cuenta,
                                  item || ' ' as partida,
        	                      max(detalle_presupuesto) as Detalle,
        	                      sum(monto)   as costo_total
                        FROM  view_diario_inventario
                    	WHERE tipo  <> 'A' and
                     		  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and
							  cuenta <> '-' 
                        GROUP BY cuenta,item
                        ORDER BY 1";
         	    
        	    $resultado_1  = $this->bd->ejecutar($sql1);
        	    $this->obj->grid->KP_sumatoria(4,"costo_total","", "","");
        	    $this->obj->grid->KP_GRID_CTA_query($resultado_1,$tipo1,'Id',$formulario,'N','',$action,'','');
	    
	    echo '</div> ';
	    
	  
	    //-------------------------------------------------------------------
	    $etiqueta = 'RESUMEN DE INGRESOS DE EXISTENCIAS';
	    echo '<div class="col-md-8"> ';
	    echo ' <ul class="list-group"> <li class="list-group-item"> <b>'.$etiqueta.'</b></li> </ul>';
	    
	    // tomar en cuenta el campo de total sin iva
	    //  sum(a.tarifa_cero)  + sum(a.baseiva)  as costo_total
            	    $sql1 ="SELECT  cuenta_inv as inventario,
                                    ncuenta_inv as detalle, 
                                    cuenta_gas as gasto,
                                    clasificador || ' ' as clasificador,
            	                    sum(cantidad) as cantidad,
            	                    sum(total)  as costo_total
                            FROM view_inv_movimiento_conta
            	           WHERE tipo= 'I' and 
                     		     anio =". $this->bd->sqlvalue_inyeccion( $anio, true)." and
                     		     (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and 
								  cuenta_inv <> '-' 
                          GROUP BY  cuenta_inv,cuenta_gas,ncuenta_inv,clasificador 
                          ORDER BY cuenta_inv";
  	    
	    $resultado_2  = $this->bd->ejecutar($sql1);
	    $this->obj->grid->KP_sumatoria(6,"costo_total","", "","");
	    $this->obj->grid->KP_GRID_CTA_query($resultado_2,$tipo1,'Id',$formulario,'N','',$action,'','');
	    
	    echo '</div> ';
	    

	    $etiqueta = 'RESUMEN DE EGRESOS DE EXISTENCIAS';
	    
	    echo '<div class="col-md-8"> ';
	    echo ' <ul class="list-group">  <li class="list-group-item"> <b>'.$etiqueta.'</b></li>  </ul>';
	    // tomar en cuenta el campo de total  sin iva
 	    //  sum(a.tarifa_cero)  + sum(a.baseiva)  as costo_total
	    $sql2 ="SELECT  cuenta_inv as inventario,
                                    ncuenta_inv as detalle,
                                    cuenta_gas || ' ' as    gasto,
                                    clasificador || ' ' as clasificador,
            	                    sum(cantidad) as cantidad,
            	                    sum(total)  as costo_total
                            FROM view_inv_movimiento_conta
            	           WHERE tipo= 'E' and
                     		     anio =". $this->bd->sqlvalue_inyeccion( $anio, true)." and
                     		     (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )  and 
								  cuenta_inv <> '-' 
                          GROUP BY  cuenta_inv,cuenta_gas,ncuenta_inv,clasificador
                          ORDER BY cuenta_inv";
	    
	    
	    $resultado_3  = $this->bd->ejecutar($sql2);
	    $this->obj->grid->KP_sumatoria(6,"costo_total","", "","");
	    $this->obj->grid->KP_GRID_CTA_query($resultado_3,$tipo1,'Id',$formulario,'N','',$action,'','');
	    
	    echo '</div> ';
	    
	   
	    $etiqueta = '<a href="#" title="Realizar Contabilizacion del proceso (se emite el asiento en estado digitado)"  onClick="Contabilizar();" >PROCESO DE CONTABILIZACION PERIODO</a>';
	    echo '<div class="col-md-8"> ';
	    echo ' <ul class="list-group"> <li class="list-group-item"> <b>'.$etiqueta.'</b></li> </ul>';
	    
	    
	 
	    $sql1 ="select a.cuenta_gas as inventario, b.detalle, sum(a.total) as debe , 0 as haber
 		FROM view_inv_movimiento_conta a, co_plan_ctas b
 		where   a.tipo= 'E' and trim(a.cuenta_gas) = trim(b.cuenta) and
 			    a.anio::character varying::text = b.anio and
 			   (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and  cuenta_gas <> '-' 
         group by a.cuenta_gas, b.detalle
         union
         select cuenta_inv as inventario, ncuenta_inv as detalle, 0 as debe, sum(total) as haber
         		FROM view_inv_movimiento_conta
         		where  tipo= 'E'  and
         			   anio =". $this->bd->sqlvalue_inyeccion( $anio, true)." and
         			   (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
					    and  cuenta_inv <> '-' 
         group by cuenta_inv,ncuenta_inv order by 1 asc, 3 desc";
	    
	    
	    
	    $resultado_1  = $this->bd->ejecutar($sql1);

	    $this->obj->grid->KP_sumatoria(3,"debe","haber", "","");
	    $this->obj->grid->KP_GRID_CTA_query($resultado_1,$tipo1,'Id',$formulario,'N','',$action,'','');
	    
	    
	    $this->firmas();
	    
	    echo '</div> ';
 	    
	}
	//----------------------------------------------------------------
	function Mov_grupo_inventarios( $f1,$f2,$tipo,$id,$cbodega,$ccuentas){
	    
	    if ( $ccuentas == '-'){
	        
	        $sql ="select a.cuenta_inv as inventario, b.detalle
                 FROM view_kardex_periodo a , co_plan_ctas b
                 where   a.cuenta_inv = b.cuenta and
                         a.idbodega = ".$this->bd->sqlvalue_inyeccion( $cbodega, true)." and
                         a.anio::character varying::text = b.anio
                  group by a.cuenta_inv,b.detalle  ";
	        
	    }else {
	        
	        $sql ="select a.cuenta_inv as inventario, b.detalle
                 FROM view_kardex_periodo a , co_plan_ctas b
                 where   a.cuenta_inv = b.cuenta and
	                     a.idbodega = ".$this->bd->sqlvalue_inyeccion( $cbodega, true)." and
                         a.cuenta_inv = ".$this->bd->sqlvalue_inyeccion( trim($ccuentas), true)." and
                         a.anio::character varying::text = b.anio
                  group by a.cuenta_inv, b.detalle  ";
	    }
	    
	    
	    $stmt_lista = $this->bd->ejecutar($sql);
	    
	    
	    echo '<div class="col-md-12"> ';
	    
	    while ($x=$this->bd->obtener_fila($stmt_lista)){
	        
	        $cuenta = trim($x['inventario']);
	        $detalle = trim($x['detalle']);
	        
	        
	        $etiqueta = $cuenta.' '.$detalle;
	        
	        echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';
	        $this->movimiento_compras($f1,$f2,$id,$cuenta,$cbodega);
	        
	    }
	    
	    echo '</div> ';
	}
	//-----------------------------
	function Mov_grupo_rotacion(   $anio,$tipo,$id,$cbodega,$ccuentas){
	    
		$tipo1 		   =  $this->bd->retorna_tipo();

		echo '<div class="col-md-8"> ';
	   
						$sql = "SELECT producto ,max(fecha) fecha,sum(cantidad) as cantidad,sum(total) as total
						FROM view_inv_movimiento_det
						where anio =" .$this->bd->sqlvalue_inyeccion($anio,true)." and 
							tipo = 'E'
						group by producto
						order by 3 desc limit 12";

 
						$resultado1  = $this->bd->ejecutar($sql);

						$cabecera =  "Articulos mas solicitados ,Ultima Salida,Cantidad,Total";


						$evento   = "";
						$this->obj->table->table_basic_seleccion($resultado1,$tipo1,'','',$evento ,$cabecera);


						$sql = "SELECT producto ,max(fecha) fecha,sum(cantidad) as cantidad,sum(total) as total
						FROM view_inv_movimiento_det
						where anio =" .$this->bd->sqlvalue_inyeccion($anio,true)." and 
							tipo = 'I'
						group by producto
						order by 3 desc limit 12";


						$resultado  = $this->bd->ejecutar($sql);

						$cabecera =  "Articulos mas adquiridos,Ultima Compra,Cantidad,Total";


						$evento   = "";
						$this->obj->table->table_basic_seleccion($resultado,$tipo1,'','',$evento ,$cabecera);

						echo '</div> ';				

	}
	//-----------------------------------------
	function Mov_grupo_unidades( $f1,$f2,$tipo,$id,$cbodega,$ccuentas){
	    

		//$cbodega,$ccuentas

		if ( $cbodega == '0'){
			$cadenabod = '';
		}	
		else{
			$cadenabod =' and idbodega ='.$this->bd->sqlvalue_inyeccion( $cbodega , true);
		}	

		if ( $tipo == 'I') {
			$sql ="SELECT idprov  || ' ' as codigo, proveedor as nombre
				FROM  view_inv_transaccion
				where tipo     ='".$tipo."' and
					  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
					  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
					 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) ".$cadenabod ."
				 group by  idprov,    proveedor
				 order by proveedor ";
		}else {
			 $sql ="SELECT id_departamento || ' ' as codigo, unidad  as nombre
				FROM  view_inv_transaccion
				where tipo     ='".$tipo."' and
					  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
					  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
					 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )  ".$cadenabod ."
				 group by  unidad,id_departamento
				 order by unidad ";
		}
	    
	    
	    $stmt_lista = $this->bd->ejecutar($sql);
	    
	    
	    echo '<div class="col-md-8"> ';
	    
	    while ($x=$this->bd->obtener_fila($stmt_lista)){

	     	$codigo = trim($x['codigo']);
	        $detalle = trim($x['nombre']);
	        
	        
	        $etiqueta = $codigo.' '.$detalle;
	        
	        echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$etiqueta.'</b></li>
                   </ul>';

	           $this->movimiento_unidades($f1,$f2,$codigo,$tipo,$cbodega,$ccuentas);
	     
	    }
	    
	    echo '</div> ';
	}
//------------------------------
	function Mov_grupo_unidades_pro( $f1,$f2,$tipo,$id,$cbodega,$ccuentas,$producto){
	    

		//$cbodega,$ccuentas

		if ( $cbodega == '0'){
			$cadenabod = '';
		}	
		else{
			$cadenabod =' and idbodega ='.$this->bd->sqlvalue_inyeccion( $cbodega , true);
		}	


		$nombre_producto = '%'.trim(strtoupper($producto)).'%';
		
 
	 
		if ( $tipo == 'I') {

			$sql ="SELECT producto , idproducto 
				FROM  view_inv_movimiento_det
				where tipo     ='".$tipo."' and
			        	producto like  ".$this->bd->sqlvalue_inyeccion(	$nombre_producto  , true)." and
					  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
					 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) ".$cadenabod ."
					 group by producto , idproducto 
				 order by producto ";
		}else {

			 $sql ="SELECT producto , idproducto 
				FROM  view_inv_movimiento_det
				where tipo     ='".$tipo."' and
					producto like  ".$this->bd->sqlvalue_inyeccion(	$nombre_producto  , true)." and
					  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
					 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )  ".$cadenabod ."
					 group by producto , idproducto 
				 order by producto ";
		}
 
		 


	    
	    $stmt_lista = $this->bd->ejecutar($sql);
	    
	    
	    echo '<div class="col-md-8"> ';
	    
	    while ($x=$this->bd->obtener_fila($stmt_lista)){

	     	$codigo = trim($x['idproducto']);
	        $detalle = trim($x['producto']);
	        
	        
	     
	        echo ' <ul class="list-group">
                    <li class="list-group-item"> <b>'.$detalle.'</b></li>
                   </ul>';

	           $this->movimiento_unidades_pro($f1,$f2,$codigo,$tipo,$cbodega,$codigo);
	     
	    }
	    
	    echo '</div> ';

	 
	}
		//-----------------------------------------
		function Mov_grupo_unidades1( $f1,$f2,$tipo,$id,$cbodega,$ccuentas){
	    
		
			
			if ( $tipo == 'I') {
				$sql ="SELECT idprov  || ' ' as codigo, proveedor as nombre
					FROM  view_inv_transaccion
					where tipo     ='".$tipo."' and
						  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
						  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
						 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
					 group by  idprov,    proveedor
					 order by proveedor ";
			}else {
				 $sql ="SELECT id_departamento || ' ' as codigo, unidad  as nombre
					FROM  view_inv_transaccion
					where tipo     ='".$tipo."' and
						  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
						  estado   = ".$this->bd->sqlvalue_inyeccion('aprobado', true)." and
						 (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
					 group by  unidad,id_departamento
					 order by unidad ";
			}
			
			
			$stmt_lista = $this->bd->ejecutar($sql);
			
			
			echo '<div class="col-md-8"> ';
			
			while ($x=$this->bd->obtener_fila($stmt_lista)){
	
				 $codigo = trim($x['codigo']);
				$detalle = trim($x['nombre']);
				
				
				$etiqueta = $codigo.' '.$detalle;
				
				echo ' <ul class="list-group">
						<li class="list-group-item"> <b>'.$etiqueta.'</b></li>
					   </ul>';
	
				   $this->movimiento_unidades1($f1,$f2,$codigo,$tipo);
			 
			}
			
			echo '</div> ';
		}
	//----------------------------------------------------------------
	function cabecera_mov(){
	    

	    echo '<table class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 10px;table-layout: auto">
               
                <tr>
        	   <th width="10%" >Codigo</th>
        	   <th width="31%" >Articulo</th>
        	   <th width="12%" >Cuenta Inventario</th>
        	   <th width="12%">Cuenta Gasto</th>
               <th width="7%">Cantidad</th>
        	   <th width="7%" bgcolor=#E6FF89>Costo</th>
        	   <th width="7%" bgcolor=#E6FF89>Media</th>
        	   <th width="7%" bgcolor=#E6FF89>Minimo</th>
        	   <th width="7%" bgcolor="#FFA8A9">Maximo</th>
        		</tr> 	';
	    
	}
	//----------------------------------------------------------------
	function cabecera(){
	    
	    echo '<table class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 10px;table-layout: auto">
               <tr>
                  <th colspan="5" >&nbsp;</th>
                  <th colspan="3" bgcolor=#E6FF89>CANTIDAD</th>
                  <th colspan="3" bgcolor=#FFA8A9>MONTOS</th>
                </tr>
                <tr>
        	   <th width="10%" >Codigo</th>
        	   <th width="26%" >Articulo</th>
        	   <th width="8%" >Unidad</th>
        	   <th width="7%">Minimo</th>
               <th width="7%">Promedio</th>
        	   <th width="7%" bgcolor=#E6FF89>Entradas</th>
        	   <th width="7%" bgcolor=#E6FF89>Salidas</th>
        	   <th width="7%" bgcolor=#E6FF89>Saldo</th>
        	   <th width="7%" bgcolor="#FFA8A9">Ingreso</th>
        	   <th width="7%" bgcolor="#FFA8A9">Egreso ($)</th>
        	   <th width="7%" bgcolor="#FFA8A9" >Saldo ($)</th>
        		</tr> 	';
	    
	}
	//----------------------------------------------------------------
	function movimiento_compras( $f1,$f2,$id,$cuenta,$cbodega){
	    
	    $sql1 ="SELECT *
                FROM  view_kardex_periodo
	            where idbodega = ".$this->bd->sqlvalue_inyeccion( $cbodega, true)." and
                      cuenta_inv = ".$this->bd->sqlvalue_inyeccion( trim($cuenta), true)."
            order by producto";
	    
	    $this->cabecera();
	    
	    $stmt  = $this->bd->ejecutar($sql1);
	    $suma1 = 0;
	    $suma2 = 0;
	    $suma3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $ningreso = $x['entrada'];
	        $nsalida  = $x['salida'];
	        $nsaldo   = $x['saldo'];
	        
	        $singreso = round($x['ventrada'],2);
	        $ssalida  = round($x['vsalida'],2);
	        $ssaldo   = round($x['vsaldo'],2);
	        
	        if ( $nsaldo >  0 ){
	            $costo_p = $x['kpromedio'];  // $costo_p = $ssaldo / $nsaldo;
	        }else{
	            $costo_p = $x['costo'];
	        }
	        
	        $ssaldo = $singreso- $ssalida;
	        $suma1  = $singreso + $suma1 ;
	        $suma2  = $ssalida + $suma2;
	        
	        echo "<tr>";
	        echo "<td>".$x['idproducto']."</td>";
	        echo "<td><b>".$x['producto']."</b></td>";
	        echo "<td><b>".$x['unidad']."</b></td>";
	        echo "<td>".$x['minimo']."</td>";
	        echo "<td>".number_format($costo_p,4)."</td>";
	        
	        echo "<td>".$ningreso."</td>";
	        echo "<td>".$nsalida."</td>";
	        echo "<td>".$nsaldo."</td>";
	        
	        echo "<td>".number_format($singreso,2)."</td>";
	        echo "<td>".number_format($ssalida,2)."</td>";
	        echo "<td>".number_format($ssaldo,2)."</td>";
	        echo "</tr>";
	    }
	    
	    echo "<tr>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    
	    echo "<td> </td>";
	    echo "<td> </td>";
	    echo "<td> </td>";
	    
	    $suma3 = $suma1 - $suma2;
	    
	    echo "<td>".$suma1."</td>";
	    echo "<td>".$suma2."</td>";
	    echo "<td>".$suma3."</td>";
	    echo "</tr>";
	    
	    echo "</table>";
	    
	    
	    unset($x); //eliminamos la fila para evitar sobrecargar la memoria
	    
	    pg_free_result ($stmt) ;
	    
	}
	//-------------
	function movimiento_unidades($f1,$f2,$codigo,$tipo,$cbodega,$ccuentas){
	    
		$tipodb 		= $this->bd->retorna_tipo();
		
 
		
		if ( $cbodega == '0'){
			$cadenabod = '';
		}	
		else{
			$cadenabod =' and idbodega ='.$this->bd->sqlvalue_inyeccion( $cbodega , true);
		}	

		if ( $ccuentas == '-'){
			$cadenacta = '';
		}	
		else{
			$cadenacta =' and cuenta_inv ='.$this->bd->sqlvalue_inyeccion( $ccuentas , true);
		}	


		if ( $tipo == 'I'){
			$sql ="SELECT idproducto as codigo, producto,
					  sum(cantidad)  || ' ' as cantidad,
					  sum(coalesce(total)) as costo,
					  sum(coalesce(total)) /  sum(cantidad)  as media,
					  min(costo) as minimo,
					  max(costo) as maximo
				 from view_inv_movimiento_det
			   where  tipo ='".$tipo."' and
					  estado = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
					  idprov = ".$this->bd->sqlvalue_inyeccion( $codigo, true)." and
					  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) ".$cadenabod.$cadenacta ."
				 group by idproducto,producto order by  producto ";
		}else  {
			$sql ="SELECT idproducto as codigo, producto,
					  sum(cantidad)  || ' ' as cantidad,
					  sum(coalesce(total)) as costo,
					  sum(coalesce(total)) /  sum(cantidad)  as media,
					  min(costo) as minimo,
					  max(costo) as maximo
				 from view_inv_movimiento_det
			   where  tipo       ='".$tipo."' and
			          id_departamento = ".$this->bd->sqlvalue_inyeccion( $codigo, true)." and
					  estado     = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
					  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )  ".$cadenabod.$cadenacta ."
				 group by idproducto,producto order by  producto ";
		 }

		 $this->obj->grid->KP_sumatoria(3,"cantidad","costo", "","");

		 $resultado  = $this->bd->ejecutar($sql);
		 $formulario = '';
		 $action     = '';

		 $this->obj->grid->KP_GRID_CTA_query($resultado,$tipodb,'Id',$formulario,'S','',$action,'','',4);
	 
	    


	}

	//-------------
	function movimiento_unidades_pro($f1,$f2,$codigo,$tipo,$cbodega,$producto){
	    
		$tipodb 		= $this->bd->retorna_tipo();
		
 
		
		if ( $cbodega == '0'){
			$cadenabod = '';
		}	
		else{
			$cadenabod =' and idbodega ='.$this->bd->sqlvalue_inyeccion( $cbodega , true);
		}	

 			$cadenacta = '';
	 


		if ( $tipo == 'I'){
			$sql ="SELECT  b.nombre, 
					  sum(a.cantidad)  || ' ' as cantidad,
					  sum(coalesce(a.total)) as costo,
					  sum(coalesce(a.total)) /  sum(cantidad)  as media,
					  min(a.costo) as minimo,
					  max(a.costo) as maximo
				 from view_inv_movimiento_det a, nom_departamento b
			   where  a.tipo ='".$tipo."' and
					  a.estado = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
					  b.id_departamento = a.id_departamento  and 
					  a.idproducto = ".$this->bd->sqlvalue_inyeccion( $producto, true)." and
					  (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) ".$cadenabod.$cadenacta ."
				 group by  a.id_departamento, b.nombre order by  b.nombre ";
		}else  {
			$sql ="SELECT b.nombre, 
					  sum(a.cantidad)  || ' ' as cantidad,
					  sum(coalesce(a.total)) as costo,
					  sum(coalesce(a.total)) /  sum(cantidad)  as media,
					  min(a.costo) as minimo,
					  max(a.costo) as maximo
				 from view_inv_movimiento_det a, nom_departamento b
			   where  a.tipo       ='".$tipo."' and
			          a.idproducto = ".$this->bd->sqlvalue_inyeccion( $producto, true)." and
					  a.estado     = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
					  b.id_departamento = a.id_departamento  and 
					  (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )  ".$cadenabod.$cadenacta ."
					  group by  a.id_departamento, b.nombre order by  b.nombre ";
		 }

 

		 $this->obj->grid->KP_sumatoria(2,"cantidad","costo", "","");

		 $resultado  = $this->bd->ejecutar($sql);
		 $formulario = '';
		 $action     = '';

		 $this->obj->grid->KP_GRID_CTA_query($resultado,$tipodb,'Id',$formulario,'S','',$action,'','',4);
	 
	    


	}
	//-------------
	function movimiento_unidades1($f1,$f2,$codigo,$tipo){
	    
		$tipodb 		= $this->bd->retorna_tipo();
		
		 

		if ( $tipo == 'I'){
			$sql ="SELECT cuenta_inv as cuenta, ncuenta_inv as detalle,
					  sum(cantidad)  || ' ' as cantidad,
					  sum(coalesce(total)) as costo,
					  sum(coalesce(total)) /  sum(cantidad)  as media,
					  min(costo) as minimo,
					  max(costo) as maximo
				 from view_inv_movimiento_det
			   where  tipo ='".$tipo."' and
					  estado = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
					  idprov = ".$this->bd->sqlvalue_inyeccion( $codigo, true)." and
					  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
				 group by cuenta_inv,ncuenta_inv order by  cuenta_inv ";
		}else  {
			$sql ="SELECT cuenta_inv as cuenta, ncuenta_inv as detalle,
					  sum(cantidad)  || ' ' as cantidad,
					  sum(coalesce(total)) as costo,
					  sum(coalesce(total)) /  sum(cantidad)  as media,
					  min(costo) as minimo,
					  max(costo) as maximo
				 from view_inv_movimiento_det
			   where  tipo       ='".$tipo."' and
			          id_departamento = ".$this->bd->sqlvalue_inyeccion( $codigo, true)." and
					  estado     = ".$this->bd->sqlvalue_inyeccion( 'aprobado', true)." and
					  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
				 group by  cuenta_inv,ncuenta_inv order by  cuenta_inv  ";
		 }

		 $this->obj->grid->KP_sumatoria(3,"cantidad","costo", "","");

		 $resultado  = $this->bd->ejecutar($sql);
		 $formulario = '';
		 $action     = '';

		 $this->obj->grid->KP_GRID_CTA_query($resultado,$tipodb,'Id',$formulario,'S','',$action,'','',4);
	 
	    
	}
	//----------------------------------------------------------------
	function firmas( ){
	    
	    $a12           = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(16,true));
	    $datos["f10"]  = $a12["carpeta"];
	    $datos["f11"]  = $a12["carpetasub"];
	    $datos["c10"]  = '';
	    $datos["c11"]  = '';
	    
	    echo '<div class="col-md-12"  style="padding-bottom:10;padding-top:10px"> ';
	    
	    echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="50%" style="text-align: left;padding: 30px">&nbsp;</td>
        	<td width="50%" style="text-align: left">&nbsp;</td>
        	</tr>
        	<tr>
        	<td style="text-align: left">'.$datos["f10"] .' </td>
        	<td style="text-align: left">'.$datos["c10"].'</td>
        	</tr>
        	<tr>
        	<td style="text-align: left">'. $datos["f11"].'</td>
        	<td style="text-align: left">'.$datos["c11"].'</td>
        	</tr>
        	</tbody>
        	</table>';
	    
	    $this->QR_DocumentoDoc();
	    
	    echo '<img src="../model/logo_qr.png" width="100" height="100"/>';
 	    echo '</div> ';
	    
	}
	//--
	function titulo($anio){
        
        
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->login     =  trim($_SESSION['login']);
    
        
        
        
        $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
        
        echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>EXISTENCIAS ( PERIODO '.$anio.' ) </b><br></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
        
 
        
    }
	//----------------------------------------------------------------
	function firmas_elaborado( ){
	    
	    
	    
	    echo '<div class="col-md-12"  style="padding-bottom:10;padding-top:10px"> ';
	    
	    echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="50%" style="text-align: left;padding: 30px">&nbsp;</td>
        	<td width="50%" style="text-align: left">&nbsp;</td>
        	</tr>
        	<tr>
        	<td style="text-align: left">Impreso por: </td>
        	<td style="text-align: left"></td>
        	</tr>
        	<tr>
        	<td style="text-align: left">'.$this->sesion.'</td>
        	<td style="text-align: left"></td>
        	</tr>
        	</tbody>
        	</table>';
	    
	    $this->QR_DocumentoDoc();
	    
	    echo '<img src="../model/logo_qr.png" width="100" height="100"/>';
 	    echo '</div> ';
	    
	}
	function QR_DocumentoDoc(  ){
	    
	    $codigo     ='0';
	    $name       = $_SESSION['razon'] ;
	    $sesion     = trim($_SESSION['email']);
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
	        );
	    
	    $nombre     =  $datos['completo'];
	    $year       = date('Y');
	    $codigo     = str_pad($codigo,5,"0",STR_PAD_LEFT ).'-'.$year;
	    $elaborador = base64_encode($codigo);
	    
	    $hoy = date("Y-m-d H:i:s");
	    
	    // we building raw data
	    $codeContents .= 'GENERADO POR:'.$nombre."\n";
	    $codeContents .= 'FECHA: '.$hoy."\n";
	    $codeContents .= 'DOCUMENTO: '.$elaborador."\n";
	    $codeContents .= 'INSTITUCION :'.$name."\n";
	    $codeContents .= '2.4.0'."\n";
  	    
	    QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
	}
}
///------------------------------------------------------------------------

$gestion   = 	new proceso;
 
if (isset($_GET["id"]))	{
	
    $f1 			    =     $_GET["fecha1"];
    $f2 				=     $_GET["fecha2"];
    $tipo               =     $_GET["tipo"];
    $id                 =     $_GET["id"];
    
    $cbodega               =     $_GET["cbodega"];
    $ccuentas              =     $_GET["ccuentas"];
	$producto_busca =     $_GET["producto_busca"];
    
 
    $gestion->grilla( $f1,$f2,$tipo,$id,$cbodega,trim($ccuentas),$producto_busca);
 
	
}

 

?>
 
  