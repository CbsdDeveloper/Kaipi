<?php
session_start( );

require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';


include('phpqrcode/qrlib.php');

class ReportePdf{

	public $obj ;
	public $bd ;
	public $ruc;
	public $Registro;

	private $anio;
	public $sesion; 
	
	
	//Constructor de la clase
	function ReportePdf(){
		//inicializamos la clase para conectarnos a la bd
		$this->obj     = 	new objects;
		$this->bd     = 	new Db;
	
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->anio       =  $_SESSION['anio'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
	}
 
	//------------------------------------
	function CabCaja($asiento){
	    
 
	    
	    //--- beneficiario
	    $sqlB = "select fecha, registro, anio, mes, detalle, sesion, creacion, estado, cuenta
			       from co_caja
				  where  id_co_caja =".$this->bd->sqlvalue_inyeccion($asiento,true) ;
	    
	    
	    $resultadoB = $this->bd->ejecutar($sqlB);
	    
	    $datos         =$this->bd->obtener_array( $resultadoB); 
	    
	    return $datos;
	}
	//---------
	function LibroBancosSaldo( $idbancos,$ffecha1,$ffecha2){
	    
	    $array = explode("-", $ffecha2);
	    
	    $anio = $array[0];
	    
	    $sql_where =  "registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." AND
						      	  cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true). " AND
						      	fecha < ". $this->bd->sqlvalue_inyeccion($ffecha1,true). " AND
								anio = ". $this->bd->sqlvalue_inyeccion($anio,true);
	    
	    $Asaldos = $this->bd->query_array( 'view_bancos_concilia',
	        '(sum(debe) - sum(haber)) as saldo',
	        $sql_where);
	    
	    $saldo = $Asaldos['saldo'];
	    
	    return $saldo;
	}
	//---------------------
	function LibroBancos( $idbancos,$ffecha1,$ffecha2){
	    
	    
	    $array = explode("-", $ffecha2);
	    
	    $anio = $array[0];
	    
	    $sql_where =  "registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." AND
						      	  cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true). " AND
						      	fecha < ". $this->bd->sqlvalue_inyeccion($ffecha1,true). " AND
								anio = ". $this->bd->sqlvalue_inyeccion($anio,true);
	    
	    $Asaldos = $this->bd->query_array( 'view_bancos_concilia',
	        '(sum(debe) - sum(haber)) as saldo',
	        $sql_where);
	    
	    
	    
	    $sql = "SELECT fecha,id_asiento,comprobante,documento_pago,razon,detalle,debe,haber
      					FROM view_bancos_concilia
						WHERE registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." AND
									 cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true). " AND
                                     fecha BETWEEN ". $this->bd->sqlvalue_inyeccion($ffecha1,true)." AND ".$this->bd->sqlvalue_inyeccion($ffecha2,true)."
									order by fecha";
	    
	    $estilo = 'class="solid" style="font-size:8px" ';
	    
	    echo  '<table>
					<tr>
					  <td width="7%" '.$estilo.' align="center">Fecha</td>
					  <td width="7%" '.$estilo.' align="center">Referencia</td>
					<td width="20%" '.$estilo.' align="center">Beneficiario</td>
					<td width="45%" '.$estilo.' align="center">Detalle</td>
					<td width="7%" '.$estilo.' align="center">Ingreso</td>
					<td width="7%" '.$estilo.' align="center">Egreso</td>
					<td width="7%" '.$estilo.' align="center">Saldo</td>
				   </tr>';
	    
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    $saldo = $Asaldos['saldo'];
	    
	    while ($row=$this->bd->obtener_fila($resultado)){
	        
	        $saldo = $saldo + $row['debe'] - $row['haber'];
	        
	        $saldot = round($saldo,2);
	        echo  '<tr>
				    <td '.$estilo.'  align="left">'.$row["fecha"].'</td>
					<td '.$estilo.'  align="left">'.$row["comprobante"].'</td>
					<td '.$estilo.'  align="left">'.$row["razon"].'</td>
					<td '.$estilo.'  align="left">'.$row["detalle"].'</td>
					<td '.$estilo.'  align="right">'.number_format($row["debe"], 2, ',', '.').'</td>
					<td '.$estilo.'  align="right">'.number_format($row["haber"], 2, ',', '.').'</td>
					<td " '.$estilo.'  align="right">'.number_format($saldot, 2, ',', '.').'</td>';
	        echo  "</tr>";
	    }
	    echo  "</table>";
	}
	//---------------
	function GrillaSPI($asiento){
	    
	    
	    $x = $this->bd->query_array('tesoreria.te_spi_para',
	        ' fecha_pago, mes_pago, referencia_pago, localidad, responsable1, cargo1, responsable2, cargo2, cuenta_bce, empresa',
	        '1=1'
	        );
	    
	    
	    $z = $this->bd->query_array('tesoreria.spi_mov',
	        ' id_spi, fecha, fecha_envio, detalle, estado, referencia, sesion, creacion, sesionm, 
	        modificacion, anio, cuenta, beneficiario, codigo_control, validacion',
	        'id_spi='.$this->bd->sqlvalue_inyeccion($asiento,true)
	        );
	   
	    $y = $this->bd->query_array('tesoreria.spi_mov_det',
	        ' sum(monto_pagar) as total ,count(*) as nn,sum(cast(codigo_banco as numeric)) as suma_bancos',
	        'id_spi='.$this->bd->sqlvalue_inyeccion($asiento ,true)
	        );
	    
 
	    $date = date("Y-m-d");
	    
		 $datos['referencia'] = trim($z['referencia']) ;
		
	    $datos['empresa'] = trim($x['empresa']) ;
	    $datos['fecha'] = $date ;
	    $datos['fecha_envio'] = $z['fecha_envio'] ;
	    
	    $datos['control'] = trim($z['codigo_control']) ;
	    $datos['total'] =  $y['total'] ;
	    $datos['registros'] = $y['nn'] ;
	    
	    $datos['total'] =  $y['total'] ;
	    $datos['registros'] = $y['nn'] ;
	    
	    
	    $datos['cuenta_bce'] =  trim($x['cuenta_bce']) ;
	    $datos['localidad'] = trim($x['localidad']) ;
	    
	    
	    $datos['responsable1'] =  trim($x['responsable1']) ;
	    $datos['cargo1']       = trim($x['cargo1']) ;
	    $datos['responsable2'] =  trim($x['responsable2']) ;
	    $datos['cargo2']       = trim($x['cargo2']) ;
 
	    return $datos;
	    
	}
//-------------
function GrillaEnlaces($id_asiento){
	    
	    
	    
	    $a = $this->bd->query_array('co_asientod',
	                                  'count(*) as hay_partida', 
	                                  'partida  is not null and id_asiento = '.$this->bd->sqlvalue_inyeccion($id_asiento,true)
	        );
	    
	   
	    if ( $this->id_tramite  > 0 ){
	        
	        $sql_detalle = "select a.programa,a.partida, a.item, b.detalle, a.cuenta,sum(a.debe) as debe
                            from co_asientod a, presupuesto.pre_catalogo b
                            where a.id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)." and
                            	  a.principal = 'S' and
                            	  a.item = b.codigo and b.tipo= 'arbol'
                            group by a.partida, a.cuenta, a.item, a.programa,b.detalle
                            order by a.programa, a.item, a.cuenta";
                         
	        $tipo_cabe = 'Devengado';
	    }else{
	        
	        $xx = $this->bd->query_array('view_diario_presupuesto',
	            'count(*) as hay_partida',
	            "partida_enlace = 'ingreso' and id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento,true)
	            );
	        
	        if ( $xx["hay_partida"]  > 0 ) {
	            
	            $sql_detalle = "select b.funcion as programa , b.partida,
                                   b.item_presupuesto as item, b.cuenta,
                                   b.detalle_presupuesto as detalle,
                                   sum(b.haber)   as debe
            	    from view_diario_presupuesto b
            	    where b.id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)."  and
            	    b.partida_enlace = 'ingreso' and
                    b.anio = ".$this->bd->sqlvalue_inyeccion(	$this->anio, true)."
            	    group by b.partida,b.funcion, b.cuenta, b.item_presupuesto  ,b.detalle_presupuesto
            	    order by b.funcion, b.item_presupuesto, b.cuenta";
	            
	        }else{
	            
	            $sql_detalle = "select b.funcion as programa , b.partida,
                                   b.item_presupuesto as item, b.cuenta,
                                   b.detalle_presupuesto as detalle,
                                   sum(b.debe)   as debe
            	    from view_diario_presupuesto b
            	    where b.id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)."  and
            	    b.partida_enlace = '-' and
                    b.anio = ".$this->bd->sqlvalue_inyeccion(	$this->anio, true)."
            	    group by b.partida,b.funcion, b.cuenta, b.item_presupuesto  ,b.detalle_presupuesto
            	    order by b.funcion, b.item_presupuesto, b.cuenta";
	        }
	        
	        
	        $tipo_cabe = 'Pagado';
	        
	    }
	    
	    
	    if ( $a["hay_partida"]  > 0 ) {
 
	                echo '<h5>Enlace Contable-Presupuestario </h5>';
	        
            	    $estilo = 'class="solid" style="font-size: 9px" ';
            	    
            	    echo  '<table>
            				  <tr>
                                 <td width="10%" '.$estilo.' align="center">Programa</td>
                                <td width="20%" '.$estilo.' align="center">Partida</td>
                                <td width="10%" '.$estilo.' align="center">Item</td>
            					<td width="40%" '.$estilo.' align="center">Detalle</td>
             			        <td width="10%" '.$estilo.' align="center">Cuenta</td>
            					<td width="10%" '.$estilo.' align="center">'.$tipo_cabe.'</td>
              				  </tr>';
            	    
            	    $stmt_detalle = $this->bd->ejecutar($sql_detalle);
            	    
             	    $valor2 = 0;
            	    
            	    while ($row=$this->bd->obtener_fila($stmt_detalle)){
            	        echo  '<tr>
            					   <td width="10%" '.$estilo.'  align="left">'.$row["programa"].'</td>
                                    <td width="20%" '.$estilo.'  align="left">'.$row["partida"].'</td>
                                    <td width="10%" '.$estilo.'  align="left">'.$row["item"].'</td>
                                    <td width="40%" '.$estilo.'  align="left">'.  ($row["detalle"]).'</td>
                                    <td width="10%" '.$estilo.'  align="left">'.$row["cuenta"].'</td>
            						<td width="10%" '.$estilo.'  align="right">'.number_format($row["debe"], 2, ',', '.').'</td>';
            	        echo  "</tr>";
            	        
             	        $valor2 = $valor2 + $row["debe"];
            	    }
            	    
            	    echo '<tr>
            				<td width="10%"></td>
            				<td width="20%"></td>
                            <td width="10%"></td>
                            <td width="40%"></td>
                            <td width="10%"></td>
            				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>';
            	    echo "</tr>";
            	    echo  "</table>";
	    }
	    
	    
	}
	
	//---------------------------
	function GrillaSPIBancos($asiento){
	    
	    $cadena = " || ' '" ;
	    
	    $tipo = $this->bd->retorna_tipo();
	    
	    $sql = 'SELECT  codigo_banco  '.$cadena.' as "Codigo Banco",
                 nombre_banco as "Institucion Pagadora",
                 count(*) as "Nro.Registro",
                 sum(monto_pagar) as "Monto"
            FROM tesoreria.view_spi_detalle
            where id_spi = '.$this->bd->sqlvalue_inyeccion($asiento  , true).'
            group by codigo_banco,nombre_banco';
	    
	    
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	  
	    echo '<div  style="font-size: 10px;padding-top: 10px;padding-bottom: 10px">';
	    
	    $this->obj->grid->KP_sumatoria(3,"Nro.Registro","Monto", "","");
	    
	    $this->obj->grid->KP_GRID_visor($resultado,$tipo,'80%');
	    
	    
	    echo '  </div>';
	    
	}
//--------------
	function GrillaSPIBancosDetalle($asiento){
	    
	    
	    $cadena = " || ' '" ;
	    
	    $tipo = $this->bd->retorna_tipo();
	    
	    $sql = 'SELECT  idprov '.$cadena.' as "Identificacion",
                        razon as "Beneficiario",
                        nombre_banco as "Banco",
                        nro_cuenta '.$cadena.' as "Nro.Cuenta",
                        monto_pagar as total
            FROM tesoreria.view_spi_detalle
            where id_spi = '.$this->bd->sqlvalue_inyeccion($asiento  , true).'
            order by razon';
	    
	    
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    
	    echo '<div  style="font-size: 10px;padding-top: 10px;padding-bottom: 10px">';
	    
	    $this->obj->grid->KP_sumatoria(5,"total","", "","");
	    
	    $this->obj->grid->KP_GRID_visor($resultado,$tipo,'80%');
	    
	    
	    echo '  </div>';
	    
	}
//-------------
	function CabAsientoanula($asiento){
	    
	    //--- beneficiario
	    $sqlB = "select *
			       from co_anulados
				  where id_anulados =".$this->bd->sqlvalue_inyeccion($asiento,true)."   limit 1";
	    
	    
 	    $resultadoB = $this->bd->ejecutar($sqlB);
	    
	    $datos         =$this->bd->obtener_array( $resultadoB);
	    
	    
      $tipo_mov = 'COMPROBANTE DE EGRESO ';
	 
	    
	    
	      
	    $datos['tipoc']   = $tipo_mov;
	    
	    $datos['cheque'] = 'Anulado';
	    
	    $datos['tipo_pago']   = 'Trasf';
	    
	    $datos['pagado'] = '0.00';
	    
	    
	    $datos['comprobante_pago'] = $datos['autorizacion'];
	    
	    
	    if ( $datos['nomina'] == 'S'){
	        
	        $datos['proveedor'] = 'PERSONAL DE TALENTO HUMANO - NOMINA ROL DE PAGOS';
	        $datos['idprov']    = '0000000000';
	        
	        
	    }
	    
	    
	    ///-------------------------------------------
	    $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    $a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
	    
	    $datos["p10"] = $a10["carpeta"];
	    $datos["p11"] = $a10["carpetasub"];
	    $datos["g10"] = $a11["carpeta"];
	    $datos["g11"] = $a11["carpetasub"];
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    $datos["t10"] = $a13["carpeta"];
	    $datos["t11"] = $a13["carpetasub"];
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    $datos["e10"] = $a15["carpeta"];
	    $datos["e11"] = $a15["carpetasub"];
	    
	    
	    $this->id_tramite  = $datos['id_tramite'];
	    
	    
	    
	    
	    $usuarios = $this->bd->__user($this->sesion);
	    
	    $datos['elaborado'] = ucwords(strtolower($usuarios['completo']));
	    
	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
	 
	    
	    
	    return $datos;
	}
	//-----------------------------
	function CabAsiento($asiento){
	    
	    //--- beneficiario
	    $sqlB = "select a.idprov ,a.debe,a.haber,a.cheque,a.tipo,
                        b.cuenta,b.tipo_cuenta,b.tipo,a.anio,a.comprobante
			       from co_asiento_aux a, co_plan_ctas b
				  where a.cuenta = b.cuenta and b.tipo_cuenta = 'B' AND
				  		   a.id_asiento =".$this->bd->sqlvalue_inyeccion($asiento,true)."   limit 1";
	    
	    
	    $resultadoB = $this->bd->ejecutar($sqlB);
	    
	    $datosB         =$this->bd->obtener_array( $resultadoB);
	    
	    
	    if ($datosB['debe']  > 0 ){
	        $tipo_mov = 'COMPROBANTE DE INGRESO';
	    }
	    else{
	        $tipo_mov = 'COMPROBANTE DE PAGO ';
	    }
	    
	    
	    
	    
	    
	    if (!empty($datosB['idprov'])){
	        
	        $sqlE = "UPDATE co_asiento
					    SET idprov =".$this->bd->sqlvalue_inyeccion(trim($datosB['idprov']), true)."
 					  WHERE idprov is null and
					  	    id_asiento =".$this->bd->sqlvalue_inyeccion($asiento, true);
	        
	        $this->bd->ejecutar($sqlE);
	    }
	    
	    $sql = "SELECT *
	  				   FROM view_asientos
					  WHERE id_asiento =".$this->bd->sqlvalue_inyeccion($asiento,true);
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $datos         =$this->bd->obtener_array( $resultado);
	    
	    
	    
	    if ($datos['tipo'] == 'R' ){
	        $datos['tipo_asiento_imprime'] = 'G1 INGRESOS';
	        $tipo_mov = 'COMPROBANTE DE INGRESO';
	    }else{
	        $datos['tipo_asiento_imprime'] = '';
	    }
	    
	    $datos['tipoc']   = $tipo_mov;
	    
	    $datos['cheque'] = $datosB['cheque'];
	    
	    $datos['tipo_pago']   = trim($datosB['tipo']);
	    
	    $datos['pagado'] = $datosB['debe'] +  $datosB['haber'];
	    
	    
	    $datos['comprobante_pago'] = $datosB['comprobante'];
	    
	    
	    if ( $datos['nomina'] == 'S'){
	        
	        $datos['proveedor'] = 'PERSONAL DE TALENTO HUMANO - NOMINA ROL DE PAGOS';
	        $datos['idprov']    = '0000000000';
	        
	        
	    }
	    
	    
	    ///-------------------------------------------
	    $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    $a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
	    
	    $datos["p10"] = $a10["carpeta"];
	    $datos["p11"] = $a10["carpetasub"];
	    $datos["g10"] = $a11["carpeta"];
	    $datos["g11"] = $a11["carpetasub"];
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    $datos["t10"] = $a13["carpeta"];
	    $datos["t11"] = $a13["carpetasub"];
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    $datos["e10"] = $a15["carpeta"];
	    $datos["e11"] = $a15["carpetasub"];
	    
	    
	    $this->id_tramite  = $datos['id_tramite'];
	    
	    
	    
	    
 

	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
 	    
		 $usuarios = $this->bd->__user($this->sesion);
		
		$datos['elaborado'] =  $usuarios['completo'] ;  
		
 	    
	    
	    return $datos;
	}
	
	
	function CabAsientoOrden($asiento){
	    
	    //--- beneficiario
	    $sqlB = "SELECT a.id_asiento,
                    a.fecha,
                    a.registro,
                    a.detalle,
                    a.sesion,
                    a.comprobante,
                    a.estado,
                    a.documento,
                    a.modulo,
                    a.idprov,a.anio,
                    ( SELECT x.razon
                           FROM par_ciu x
                          WHERE x.idprov = a.idprov) AS proveedor,
                    a.tipo,a.id_tramite, a.apagar
                   FROM co_asiento a
                  WHERE a.id_asiento  =".$this->bd->sqlvalue_inyeccion($asiento,true)."   limit 1";
	    
	    
	    $resultadoB = $this->bd->ejecutar($sqlB);
	    
	    $datos         =$this->bd->obtener_array( $resultadoB);
	    
 
 ///-------------------------------------------
	    $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    $a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
 	    
	    $datos["p10"] = $a10["carpeta"];
	    $datos["p11"] = $a10["carpetasub"];
	    $datos["g10"] = $a11["carpeta"];
	    $datos["g11"] = $a11["carpetasub"];
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    $datos["t10"] = $a13["carpeta"];
	    $datos["t11"] = $a13["carpetasub"];
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    $datos["e10"] = $a15["carpeta"];
	    $datos["e11"] = $a15["carpetasub"];
	    
	    $idprov = trim($datos["idprov"]);
	    
	    
	    $a16 = $this->bd->query_array('par_ciu','id_banco, tipo_cta,cta_banco', 'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true));
	    
	    $id_banco = trim($a16["id_banco"]);
	    
	    $a17 = $this->bd->query_array('par_catalogo','nombre', 'idcatalogo='.$this->bd->sqlvalue_inyeccion($id_banco,true));
	    
	    if ($a16["tipo_cta"] == '0'){
	        $datos["tipo_cuenta"] = 'Ahorros';
	    }else{
	        $datos["tipo_cuenta"] = 'Corriente';
	    }
	    
	    $datos["cuenta"] = $a16["cta_banco"];
	    $datos["banco"]  = $a17["nombre"];
 
	    
	    if ( empty( $datos["apagar"])){
	        
	        $a20 =  $this->bd->query_array('co_asiento_aux','haber', 
	               'id_asiento='.$this->bd->sqlvalue_inyeccion($asiento,true). ' and 
                    idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)." and cuenta like '111.%'"
	            );
	        
	        $datos["apagar"] = $a20["haber"];
	        
	        $sql = "update co_asiento_aux set 
                           detalle=".$this->bd->sqlvalue_inyeccion(trim($datos["detalle"]),true).", 
                           comprobante=".$this->bd->sqlvalue_inyeccion(trim($datos["comprobante"]),true).'
                    where id_asiento='.$this->bd->sqlvalue_inyeccion($asiento,true);
	        
	        $this->bd->ejecutar($sql);
	    }
 
	    return $datos;
	}
	//--- resumen IR
	
	function GrillaResumenCuentasCaja($fanio,$fmes,$cuenta){
	    
	    
	    $sql ="SELECT  idprov  as identificacion,
                      razon as nombre,
                      sum(montoi) as ingreso,
                      sum(monto) as egreso,
                      count(*) as registros
            FROM view_auxbancos
            where registro=".$this->bd->sqlvalue_inyeccion(trim($this->ruc), true)." and
                  transaccion=".$this->bd->sqlvalue_inyeccion('X', true)." and
                  anio=".$this->bd->sqlvalue_inyeccion($fanio, true)." and
                  mes=".$this->bd->sqlvalue_inyeccion($fmes, true)." and
                  estado=".$this->bd->sqlvalue_inyeccion('aprobado', true).' and
                  cuenta='.$this->bd->sqlvalue_inyeccion($cuenta, true).' 
            group by idprov,razon
            order by 3 desc';
	    
	    
	    $estilo = 'class="solid" style="font-size: 9px" ';
	    
	    echo  '<table>
				  <tr>
			        <td width="20%" '.$estilo.' align="center">Identificacion</td>
					<td width="40%" '.$estilo.' align="center">Nombre</td>
                    <td width="10%" '.$estilo.' align="center">Nro.Transacciones</td>
					<td width="10%" '.$estilo.' align="center">Ingresos</td>
					<td width="10%" '.$estilo.' align="center">Egresos</td>
                    <td width="10%" '.$estilo.' align="center">Saldo</td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql);
	    
	    $valor1 = 0;
	    $valor2 = 0;
	    
	    $saldo = 0;
	    
	    while ($row=$this->bd->obtener_fila($stmt_detalle)){
	      
	        $saldo = $saldo + ($row["ingreso"] -$row["egreso"] ) ;
	        
	        echo  '<tr>
					   <td width="20%" '.$estilo.'  align="left">'.$row["identificacion"].'</td>
						<td width="40%" '.$estilo.'  align="left">'.$row["nombre"].'</td>
	                   <td width="10%" '.$estilo.'  align="center">'.$row["registros"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["ingreso"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["egreso"], 2, ',', '.').'</td> 
	                    <td width="10%" '.$estilo.'  align="right">'.number_format($saldo, 2, ',', '.').'</td>';
	        echo  "</tr>";
	        
	        $valor1 = $valor1 + $row["ingreso"];
	        $valor2 = $valor2 + $row["egreso"];
	    }
	    
	    echo '<tr>
				<td width="20%"></td>
				<td width="50%"></td>
                <td width="10%"></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
	            <td width="10%"></td>';
	    echo "</tr>";
	    echo  "</table>";
	    
            	    
	}
//--------------------
	
	function GrillaResumenMensualCaja($fanio,$fmes,$cuenta){
	    
	    
	    $sql ="SELECT  id_asiento as asiento,
              fecha,
               idprov  as identificacion,
              razon as nombre,
              detalle,
              comprobantec as comprobante,
              documento ,
              montoi as ingreso,
              monto as egreso,
              cuenta,anio, mes
            FROM view_auxbancos
            where registro=".$this->bd->sqlvalue_inyeccion(trim($this->ruc), true)." and
                  transaccion=".$this->bd->sqlvalue_inyeccion('X', true)." and
                  anio=".$this->bd->sqlvalue_inyeccion($fanio, true)." and
                  mes=".$this->bd->sqlvalue_inyeccion($fmes, true)." and
                  estado=".$this->bd->sqlvalue_inyeccion('aprobado', true).' and
                  cuenta='.$this->bd->sqlvalue_inyeccion($cuenta, true).'
               order by fecha asc , montoi desc';
	  
	      
	    $estilo = 'class="solid" style="font-size: 9px" ';
	    
	    echo  '<table>
				  <tr>
                    <td width="5%" '.$estilo.' align="center">Asiento</td>
                    <td width="10%" '.$estilo.' align="center">Fecha</td>
			        <td width="10%" '.$estilo.' align="center">Identificacion</td>
					<td width="30%" '.$estilo.' align="center">Nombre</td>
                    <td width="20%" '.$estilo.' align="center">Detalle</td>
					<td width="10%" '.$estilo.' align="center">Ingresos</td>
					<td width="10%" '.$estilo.' align="center">Egresos</td>
                    <td width="5%" '.$estilo.' align="center">Saldo</td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql);
	    
	    $valor1 = 0;
	    $valor2 = 0;
	    
	    $saldo = 0;
	    
	    while ($row=$this->bd->obtener_fila($stmt_detalle)){
	        
	        $saldo = $saldo + ($row["ingreso"] -$row["egreso"] ) ;
	        
	        echo  '<tr>
					   <td width="5%" '.$estilo.'  align="left">'.$row["asiento"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["fecha"].'</td>
	                   <td width="10%" '.$estilo.'  align="left">'.$row["identificacion"].'</td>
                       <td width="30%" '.$estilo.'  align="left">'.$row["nombre"].'</td>
	                   <td width="20%" '.$estilo.'  align="left">'.$row["detalle"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["ingreso"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["egreso"], 2, ',', '.').'</td>
	                    <td width="5%" '.$estilo.'  align="right">'.number_format($saldo, 2, ',', '.').'</td>';
	        echo  "</tr>";
	        
	        $valor1 = $valor1 + $row["ingreso"];
	        $valor2 = $valor2 + $row["egreso"];
	    }
	    
	    echo '<tr>
				<td width="5%"></td>
                <td width="10%"></td>
				<td width="10%"></td>
                <td width="30%"></td>
                <td width="20%"></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
	            <td width="5%"></td>';
	    echo "</tr>";
	    echo  "</table>";
	    
	    
	}
	//----------- 
	
	function GrillaResumenMensualCajaDet($fanio,$fmes,$cuenta){
	    
	    
	    $sql ="SELECT  id_asiento as asiento,
              fecha,
               idprov  as identificacion,
              razon as nombre,
              detalle,
              comprobantec as comprobante,
              documento ,
              montoi as ingreso,
              monto as egreso,
              cuenta,anio, mes
            FROM view_auxbancos
            where registro=".$this->bd->sqlvalue_inyeccion(trim($this->ruc), true)." and
                  transaccion=".$this->bd->sqlvalue_inyeccion('X', true)." and
                  anio=".$this->bd->sqlvalue_inyeccion($fanio, true)." and
                  mes=".$this->bd->sqlvalue_inyeccion($fmes, true)." and
                  estado=".$this->bd->sqlvalue_inyeccion('aprobado', true).' and
                  cuenta='.$this->bd->sqlvalue_inyeccion($cuenta, true).'
               order by fecha asc , montoi desc';
	    
	    
	    $estilo = 'class="solid" style="font-size: 9px" ';
	    
	    echo  '<table>
				  <tr>
                    <td width="5%" '.$estilo.' align="center">Asiento</td>
                    <td width="10%" '.$estilo.' align="center">Fecha</td>
			        <td width="10%" '.$estilo.' align="center">Identificacion</td>
					<td width="30%" '.$estilo.' align="center">Nombre</td>
                    <td width="20%" '.$estilo.' align="center">Detalle</td>
					<td width="10%" '.$estilo.' align="center">Ingresos</td>
					<td width="10%" '.$estilo.' align="center">Egresos</td>
                    <td width="5%" '.$estilo.' align="center">Saldo</td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql);
	    
	    $valor1 = 0;
	    $valor2 = 0;
	    
	    $saldo = 0;
	    
	    while ($row=$this->bd->obtener_fila($stmt_detalle)){
	        
	        $saldo = $saldo + ($row["ingreso"] -$row["egreso"] ) ;
	        
	        echo  '<tr>
					   <td width="5%" '.$estilo.'  align="left">'.$row["asiento"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["fecha"].'</td>
	                   <td width="10%" '.$estilo.'  align="left">'.$row["identificacion"].'</td>
                       <td width="30%" '.$estilo.'  align="left">'.$row["nombre"].'</td>
	                   <td width="20%" '.$estilo.'  align="left">'.$row["detalle"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["ingreso"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["egreso"], 2, ',', '.').'</td>
	                    <td width="5%" '.$estilo.'  align="right">'.number_format($saldo, 2, ',', '.').'</td>';
	        echo  "</tr>";
	        
	        $valor1 = $valor1 + $row["ingreso"];
	        $valor2 = $valor2 + $row["egreso"];
	    }
	    
	    echo '<tr>
				<td width="5%"></td>
                <td width="10%"></td>
				<td width="10%"></td>
                <td width="30%"></td>
                <td width="20%"></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
	            <td width="5%"></td>';
	    echo "</tr>";
	    echo  "</table>";
	    
	    
	}
	//--- resumen IR
	function GrillaAsiento($id_asiento){
		
		$sql_detalle = 'SELECT a.cuenta , b.detalle ,a.debe , a.haber , a.aux
 				   FROM co_asientod a, co_plan_ctas b
				  where a.cuenta = b.cuenta and 
                        a.registro = b.registro and
                        b.anio='.$this->bd->sqlvalue_inyeccion($this->anio , true).' and 
				  		a.id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento, true).' order by 5 asc, 2 desc';
		
		$estilo = 'class="solid" style="font-size: 9px" ';
		
		echo  '<table>
				  <tr>
			        <td width="10%" '.$estilo.' align="center">Cuenta</td>
					<td width="70%" '.$estilo.' align="center">Detalle</td>
					<td width="10%" '.$estilo.' align="center">Debe</td>
					<td width="10%" '.$estilo.' align="center">Haber</td>
				  </tr>';
		
		$stmt_detalle = $this->bd->ejecutar($sql_detalle);
		
		$valor1 = 0;
		$valor2 = 0;
		
		while ($row=$this->bd->obtener_fila($stmt_detalle)){
 			echo  '<tr>
					   <td width="10%" '.$estilo.'  align="left">'.$row["cuenta"].'</td>
						<td width="70%" '.$estilo.'  align="left">'.$row["detalle"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["debe"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["haber"], 2, ',', '.').'</td>';
			echo  "</tr>";
			
			$valor1 = $valor1 + $row["debe"];
			$valor2 = $valor2 + $row["haber"];
 		}
		
 		echo '<tr>
				<td width="10%"></td>
				<td width="70%"></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>';
 		echo "</tr>";
 		echo  "</table>";
		
 	 
 
	}
	
	//--- resumen IR
 
	//---
	function Empresa( ){
	    
	    $sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $this->Registro = $this->bd->obtener_array( $resultado);
	    
	    return $this->Registro['razon'];
	}
	function NombreBanco($idbanco ){
		
		$sql = "select detalle 
				from co_plan_ctas 
				where cuenta = ".$this->bd->sqlvalue_inyeccion($idbanco, true)." and registro  =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);
		
		$resultado = $this->bd->ejecutar($sql);

		$datos = $this->bd->obtener_array( $resultado);

		return $datos['detalle'];
	}
	
	//------------------------------------------
	//---
	function EmpresaCab( ){
		
		$sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$this->Registro = $this->bd->obtener_array( $resultado);

		return $this->Registro['razon'];
	}
	//-----------------
	function _Cab( $dato ){
	      
	    return $this->Registro[$dato];
	}
//------------
	function QR_DocumentoDoc($codigo ){
	    
	    
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
	    
	    $tempDir = EXAMPLE_TMP_SERVERPATH;
	    
	    QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
	}
	
	//----------------------------------------------
	function QR_Firma( ){
	    
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['email']),true)
	        );
	    
	    $sesion_elabora =  trim($datos['completo']);
	    
	    echo 'Documento Digital '.$_SESSION['login'].'- '. $sesion_elabora ;
	    
	}
	
	
	function firma_reportes($cliente){
	    
	  
	//------------- llama a la tabla de parametros ---------------------//
	
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

//	$pie_contenido = str_replace('#FUNCIONARIO',$this->empleado, $pie_contenido);
/*
	$usuarios = $this->bd->__user($this->sesion);
	$datos['elaborado'] = ucwords(strtolower($usuarios['completo']));  
	$usuarios = $this->bd->__user($this->sesion);
	$datos['elaborado'] = ucwords(strtolower($usuarios['completo']));  
*/
	
	echo $pie_contenido ;
 
}
	
}

?>