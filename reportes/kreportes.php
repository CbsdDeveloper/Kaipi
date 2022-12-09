<?php
session_start();
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';
require '../kconfig/convertir.php';
include('phpqrcode/qrlib.php'); 

class ReportePdf{

	public $obj ;
	public $bd ;
	public $ruc;
	public $empleado;
	public $Registro;
	public $sesion;
	
	public $idprov;
	

	//Constructor de la clase
	function ReportePdf(){

    	$this->obj     = 	new objects;
		
		$this->bd     = 	new Db;
	
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

		$this->ruc       =  trim($_SESSION['ruc_registro']);
		
		$this->sesion 	 = $_SESSION['login'] ;
		
 		
	}
/*
firmas para reportes
*/
	function FirmasPie(){
	    
	    $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(11,true));
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    $a13 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	   
 	    
	    $a16 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(16,true));
	    $a17 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(17,true));


	    $a20 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(20,true));

	    
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
	    
	    $datos["e10"] = $a16["carpeta"];            // guardaalmacen
	    $datos["e11"] = $a16["carpetasub"];
	    
	    $datos["b10"] = $a20["carpeta"];   // bienes
	    $datos["b11"] = $a20["carpetasub"];

	    $datos["th10"] = $a17["carpeta"];   // talento humano
	    $datos["th11"] = $a17["carpetasub"];
	    
	    
	    
	    
	    $usuarios = $this->bd->__user(trim($this->sesion));
	    
	    $datos['elaborado'] = ucwords(strtolower($usuarios['completo']));
	    $datos['unidad']    =  ucwords(strtolower($usuarios['unidad']));
	    
	    return $datos;
	}

	function datos_cargos($id){
	    
	 
	    $d = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion($id,true));
	   

	    $datos["d1"] = $d["carpeta"];   
	    $datos["d2"] = $d["carpetasub"];

	    $usuarios = $this->bd->__user(trim($this->sesion));
	    
	    $datos['elaborado'] = ucwords(strtolower($usuarios['completo']));
	    $datos['unidad']    =  ucwords(strtolower($usuarios['unidad']));
	    
	    return $datos;
	}
	//---------
	function conocer_mes($cmes) {
	    
	    $mes = $this->bd->_mesc($cmes);
	    
	    return $mes;
	}
	//------------------------------------
	function Cabecera($codigo){
		
		//--- beneficiario
	    $sql = "SELECT id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo, id_periodo, documento, 					
                      idprov, id_asiento_ref, proveedor, razon, direccion, telefono, correo, contacto, fechaa, anio, mes, transaccion
	  			FROM  view_inv_movimiento
					where  id_movimiento= ".$this->bd->sqlvalue_inyeccion($codigo ,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado_cab); 
		 
		return $datos;
	}
	/*
	visor de poliza impresion
	*/
	function ConsultaPoliza($codigo){
	    
	    //--- beneficiario
	    $sql = "SELECT *
	  			FROM  garantias.view_polizas 
					where  idpoliza= ".$this->bd->sqlvalue_inyeccion($codigo ,true);
	    
	    $resultado_cab = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado_cab);
	    
 	    $datos['mes'] = $this->bd->_mes($datos['mes_emision']);
 	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
	    
	    $datos["f10"] = $a14["carpeta"];
	    $datos["f11"] = $a14["carpetasub"];
	    
	    
	    
	    return $datos;
	}

	/*
	pie de pagina
	*/
	function pie_cliente($cliente){
 	    
	    $Auser = $this->bd->query_array('par_usuario',  'completo', 
	        'login='.$this->bd->sqlvalue_inyeccion($this->sesion ,true)
	        );
  
	    
			echo '<table width="100%" border="0" cellpadding="0" style="font-size: 10px">
				<tbody>
					<tr>
					<td width="30%" class="tablaPie" align="center">&nbsp;</td>
					<td width="30%" class="tablaPie" align="center">&nbsp;</td>
					<td width="40%" class="tablaPie" align="center">&nbsp;</td>
					</tr>
					<tr>
					<td width="30%" class="tablaPie1" align="center">'.utf8_encode($Auser['completo']).'</td>
					<td width="30%" class="tablaPie1" align="center">&nbsp;</td>
					<td width="40%" class="tablaPie1" align="center">'.utf8_encode($cliente).'</td>
					</tr>
					<tr>
					<td class="tablaPie1" align="center">Elaborado</td>
					<td class="tablaPie1" align="center">Autorizado</td>
					<td class="tablaPie1" align="center">Cliente</td>
					</tr>
				</tbody>
				</table>
				<br> 
			<table width="100%" border="0" cellpadding="0" align="left">
			<tbody>
				<tr>
				<td width="10%" align="left" valign="bottom"> <p class="page" style="font-size: 10px;color: #363636">	 </p>  </td>
				<td width="90%" align="right" valign="bottom"><img width="80" height="80" src="documento.png"/> 	</td>
				</tr>
			</tbody>
			</table>';
	    
	}

/*
pie para roles de pago
*/
	function pie_rol($cliente){
	    
	  
	    $reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion('TH-PI' ,true) );
	    
        $pie_contenido = $reporte_pie["pie"];
	    
		$pie_contenido = str_replace('#CEDULA',$this->idprov, $pie_contenido);

		$pie_contenido = str_replace('#FUNCIONARIO',$this->empleado, $pie_contenido);
	    
		echo $pie_contenido ;
	     
	    
	}
 
	//--- resumen IR
	function GrillaAsiento($id_asiento){
		
		$sql_detalle = 'SELECT a.cuenta , b.detalle ,a.debe , a.haber , a.aux
 				   FROM co_asientod a, co_plan_ctas b
				  where a.cuenta = b.cuenta and a.registro = b.registro and
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

	//---------
	//--- resumen IR
	function GrillaMovimiento($codigo){
	    
	    $sql_detalle = 'SELECT id, codigo, producto, unidad, cantidad, costo, 
                               total, tipo, monto_iva, tarifa_cero, tributo, baseiva, sesion
	  			 FROM  view_factura_detalle where id_movimiento='.$this->bd->sqlvalue_inyeccion($codigo, true).' order by 3 asc';
	    
	    $estilo = ' style="font-size: 10px;" class="tabla"';
	    
	    $estilo1 = ' style="font-size: 10px;" class="tablaTotal"';
	        
	    echo  '<h6> &nbsp; </h6>
                <table width="100%">
				  <tr>
			        <td width="10%" '.$estilo.' align="center">Codigo</td>
					<td width="50%" '.$estilo.' align="center">Detalle</td>
					<td width="10%" '.$estilo.' align="center">Unidad</td>
					<td width="10%" '.$estilo.' align="center">Cantidad</td>
                    <td width="10%" '.$estilo.' align="center">Unitario</td>
                    <td width="10%" '.$estilo.' align="center">Total</td>
				  </tr>';
	    
	    $stmt_detalle = $this->bd->ejecutar($sql_detalle);
	    
	    $valor1 = 0;
	    $valor2 = 0;
	    $monto_iva  = 0;
	    $tarifa_cero   = 0;
	    $baseiva  = 0;
	    
	    
	    while ($row=$this->bd->obtener_fila($stmt_detalle)){
	        echo  '<tr>
					   <td width="10%" '.$estilo.'  align="left">'.$row["codigo"].'</td>
						<td width="50%" '.$estilo.'  align="left">'.$row["producto"].'</td>
                        <td width="10%" '.$estilo.'  align="center">'.$row["unidad"].'</td>
                        <td width="10%" '.$estilo.'  align="center">'.$row["cantidad"].'</td>
 				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["costo"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["total"], 2, ',', '.').'</td>';
	        echo  "</tr>";
	        
	        $valor1 = $valor1 + $row["costo"];
	        $valor2 = $valor2 + $row["total"];
	        
	        $monto_iva     = $monto_iva + $row["monto_iva"];
	        $tarifa_cero   = $tarifa_cero + $row["tarifa_cero"];
	        $baseiva       = $baseiva + $row["baseiva"];
	    }
	    
	
	    
	    echo '<tr>
				<td width="10%"></td>
				<td width="50%"></td>
                <td width="10%"></td>
                <td width="10%"></td>
				<td width="10%" '.$estilo1.'  align="right">&nbsp; </td>
				<td width="10%" '.$estilo1.'  align="right">&nbsp; </td>';
	    echo "</tr>";
	    
	    echo '<tr>
				<td width="10%"></td>
				<td width="50%"></td>
                <td width="10%"></td>
                <td width="10%"></td>
				<td width="10%" '.$estilo1.' ><b>Base 0% </b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($tarifa_cero, 2, ',', '.').'</b></td>';
	    echo "</tr>";
	    
	    echo '<tr>
				<td width="10%"></td>
				<td width="50%"></td>
                <td width="10%"></td>
                <td width="10%"></td>
				<td width="10%" '.$estilo1.' ><b>Base 12% </b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($baseiva, 2, ',', '.').'</b></td>';
	    echo "</tr>"; 
	    
	    echo '<tr>
				<td width="10%"></td>
				<td width="50%"></td>
                <td width="10%"></td>
                <td width="10%"></td>
				<td width="10%" '.$estilo1.' ><b>Monto IVA </b></td>
				<td width="10%" '.$estilo.'  align="right"><b>'.number_format($monto_iva, 2, ',', '.').'</b></td>';
	    echo "</tr>";
	    
	    echo '<tr>
				<td width="10%"></td>
				<td width="50%"></td>
                <td width="10%"></td>
                <td width="10%"></td>
				 <td width="10%">TOTAL $</td>
				<td width="10%" '.$estilo.'  align="right"> <b>'.number_format($valor2, 2, ',', '.').'</b></td>';
	    echo "</tr>";
	    
	    echo  "</table>";
	    
	    
	    
	}
	
	//--- resumen IR
	function LibroBancos( $idbancos,$ffecha1,$ffecha2){
		
	 
		$array = explode("-", $ffecha2);
      	
      	$anio = $array[0];
      	
      	$sql_where =  "registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." AND
						      	  cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true). " AND
						      	fecha < ". $this->bd->sqlvalue_inyeccion($ffecha1,true). " AND
								anio = ". $this->bd->sqlvalue_inyeccion($anio,true);	
      	
       $Asaldos = $this->bd->query_array( 'view_bancos',
     									'(sum(debe) - sum(haber)) as saldo', 
     									$sql_where);
      	
      	
      	
      	$sql = "SELECT fecha,id_asiento,comprobante,cheque,razon,detalle,debe,haber
      					FROM view_bancos
						WHERE registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." AND
									 cuenta = ".$this->bd->sqlvalue_inyeccion(trim($idbancos),true). " AND
                                     fecha BETWEEN ". $this->bd->sqlvalue_inyeccion($ffecha1,true)." AND ".$this->bd->sqlvalue_inyeccion($ffecha2,true)."
									order by cheque,fecha";
      	 	
		$estilo = 'class="solid" style="font-size: 9px" ';
		
		echo  '<table>
					<tr>
					  <td width="10%" '.$estilo.' align="center">Fecha</td>
					  <td width="10%" '.$estilo.' align="center">Asiento</td>
					  <td width="10%" '.$estilo.' align="center">Referencia</td>
					<td width="20%" '.$estilo.' align="center">Beneficiario</td>
					<td width="26%" '.$estilo.' align="center">Detalle</td>
					<td width="8%" '.$estilo.' align="center">Ingreso</td>
					<td width="8%" '.$estilo.' align="center">Egreso</td>
					<td width="8%" '.$estilo.' align="center">Saldo</td>	
				   </tr>';
		 
		$resultado  = $this->bd->ejecutar($sql);
      	
      	$saldo = $Asaldos['saldo'];
      	
      	while ($row=$this->bd->obtener_fila($resultado)){
      	
      		$saldo = $saldo + $row['debe'] - $row['haber'];
      		$saldot = round($saldo,2);
			echo  '<tr>
				    <td width="10%" '.$estilo.'  align="left">'.$row["fecha"].'</td>
					<td width="10%" '.$estilo.'  align="left">'.$row["id_asiento"].'</td>
					<td width="10%" '.$estilo.'  align="left">'.$row["comprobante"].'</td>
					<td width="20%" '.$estilo.'  align="left">'.$row["razon"].'</td>
					<td width="26%" '.$estilo.'  align="left">'.$row["detalle"].'</td>
					<td width="8%" '.$estilo.'  align="right">'.number_format($row["debe"], 2, ',', '.').'</td>
					<td width="8%" '.$estilo.'  align="right">'.number_format($row["haber"], 2, ',', '.').'</td>
					<td width="8%" '.$estilo.'  align="right">'.number_format($saldot, 2, ',', '.').'</td>';
			echo  "</tr>";
       	}
  		echo  "</table>";
 	}

	//---
	function Empresa( ){
		
		$sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$this->Registro = $this->bd->obtener_array( $resultado);

		return $this->Registro['razon'];
	}

	//-------------------------------
	function _empresa($empresa ){
	    
	    $empre = base64_decode($empresa);
	    
	    $sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	trim($empre ), true);
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $this->Registro = $this->bd->obtener_array( $resultado);
	    
	    echo $this->Registro['razon'];
	}

	//-----------------
	function _Cab( $dato ){
	      
	    return $this->Registro[$dato];
	}

/* 
nombre banco
*/	
	function NombreBanco($idbanco ){
		
		$sql = "select max(detalle) as detalle
				from co_plan_ctas 
				where cuenta = ".$this->bd->sqlvalue_inyeccion($idbanco, true)." and 
                      registro  =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);
		
		$resultado = $this->bd->ejecutar($sql);

		$datos = $this->bd->obtener_array( $resultado);

		return $datos['detalle'];
	}
	

/*
formulario para  anticipos 
*/
function solicitud_anticipo( $id ){

	$Contenido = $this->bd->query_array('ven_plantilla', 'contenido', 'id_plantilla='.$this->bd->sqlvalue_inyeccion( 1 ,true) );

	$Contenido2 = $this->bd->query_array('ven_plantilla', 'contenido', 'id_plantilla='.$this->bd->sqlvalue_inyeccion( 2,true) );
	    
	$datos     = $this->bd->query_array('view_lista_anticipo','idprov,fecha,documento,mensual,rige,plazo,solicita,anio,idprov_ga', 'id_anticipo='.$this->bd->sqlvalue_inyeccion( $id ,true) );

	$bancoa    = $this->bd->query_array('view_nomina_banco', 'banco,codigo_banco', 'identificacion='.$this->bd->sqlvalue_inyeccion( trim($datos['idprov'])  ,true) );

	$asolicita = $this->bd->query_array('view_nomina_rol','razon,idprov,cargo,regimen,sueldo,direccion,movil,correo,telefono', 'idprov='.$this->bd->sqlvalue_inyeccion( trim($datos['idprov'])  ,true) );

	$garantea = $this->bd->query_array('view_nomina_rol','razon,idprov,cargo,regimen,sueldo,direccion,movil,correo,telefono', 'idprov='.$this->bd->sqlvalue_inyeccion( trim($datos['idprov_ga'])  ,true) );
 

	$sueldo         =  $datos['solicita'];
 	$sueldo_letras  =  convertir($sueldo);

	 $rige  			=  $this->bd->_mes($datos['rige']);
	 $hasta 			=  $datos['rige'] + $datos['plazo'];
	 $hasta 			=  $this->bd->_mes($hasta -1);

	$contenido		 = $Contenido['contenido'] ;

	$contenido       = str_replace('#SOLICITANTE',trim($asolicita['razon']), $contenido);
	$contenido       = str_replace('#RUC',trim($asolicita['idprov']),   $contenido);
	$contenido       = str_replace('#CARGO',trim($asolicita['cargo']),    $contenido);
	$contenido       = str_replace('#REGIMEN',trim($asolicita['regimen']), $contenido);
	$contenido       = str_replace('#SUELDO',  trim($asolicita['sueldo']), $contenido);
	$contenido       = str_replace('#PLAZO',trim($datos['plazo']), $contenido);
	$contenido       = str_replace('#ANIO', trim($datos['anio']), $contenido);
	$contenido       = str_replace('#PRESTAMO', $datos['solicita'],   $contenido);
	$contenido       = str_replace('#DESCUENTO', trim($datos['mensual']),   $contenido);
	$contenido       = str_replace('#BANCO',  trim($bancoa['banco']),   $contenido);
	$contenido       = str_replace('#CUENTA', trim($bancoa['codigo_banco']),   $contenido);

	$contenido       = str_replace('#MES',    strtoupper($rige), $contenido);
	$contenido       = str_replace('#HASTA',  strtoupper($hasta), $contenido);

	$contenido       = str_replace('#GARANTE',	 trim($garantea['razon']), $contenido);
	$contenido       = str_replace('#GA_CARGO',  trim($garantea['cargo']),   $contenido);
	$contenido       = str_replace('#CA_SUELDO', trim($garantea['sueldo']),   $contenido);


	$contenido       = str_replace('#LETRASSUELDO',    $sueldo_letras, $contenido);

	$datos['contenido'] = $contenido  ;
 
	
		
	$contenido		 = $Contenido2['contenido'] ;
	
	$contenido       = str_replace('#LETRASSUELDO',    $sueldo_letras, $contenido);
	$contenido       = str_replace('#PRESTAMO',		   $datos['solicita'],   $contenido);
	$contenido       = str_replace('#DOCUMENTO',       trim($datos['documento']), $contenido);
	$contenido       = str_replace('#HASTA',  strtoupper($hasta), $contenido);
	$contenido       = str_replace('#ANIO',      trim($datos['anio']), $contenido);
	
	$contenido       = str_replace('#SOLICITA', trim($asolicita['razon']), $contenido);
	$contenido       = str_replace('#CEDULA',   trim($asolicita['idprov']),   $contenido);
	$contenido       = str_replace('#DIRECCION',trim($asolicita['direccion']),   $contenido);
	$ADICIONAL1 	 = 'Telf: '.trim($asolicita['telefono']) .' / '.trim($asolicita['movil']).' / '.trim($asolicita['correo']);
	$contenido       = str_replace('#ADICIONAL1', $ADICIONAL1,   $contenido);
  	
	
	 $contenido       = str_replace('#GARANTE', trim($garantea['razon']), $contenido);
	 $contenido       = str_replace('#GAR_RUC',   trim($garantea['idprov']),   $contenido);
	 $contenido       = str_replace('#GAR_VIVE',trim($garantea['direccion']),   $contenido);
   	 $ADICIONAL1      = 'Telf: '.trim($garantea['telefono']) .' / '.trim($garantea['movil']).' / '.trim($garantea['correo']);
 	 $contenido       = str_replace('#ADICIONAL2', $ADICIONAL1,   $contenido);
 
	$DIA_COMPLETO    = $this->bd->_fecha_completa($datos['fecha']);
	$contenido       = str_replace('#DIA_COMPLETO', $DIA_COMPLETO,   $contenido);
	
	$DIA_COMPLETO    = $this->bd->_fecha_completa($datos['fecha']);
	
	$fecha_final = date('Y').'-12-31';
	
	$numero_dias =  $this->dias_pasados($datos['fecha'],$fecha_final);
	
	$contenido       = str_replace('#DIAS_PRESTAMO', $numero_dias, $contenido);
	
	//#DIAS_PRESTAMO
	
	$datos['fecha_completa'] = $DIA_COMPLETO  ;
	
	$datos['contenido2'] = $contenido  ;

	return $datos;
   

 
}
	
	
	  //---------------
  function dias_pasados($fecha_inicial,$fecha_final)
  {
        
        $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
        $dias = abs($dias); $dias = floor($dias);
        return $dias;

  }
	
/*
cuerpo de permisos
*/
	function cuerpo_permiso($tipo, $datos ){

		
		
		$dias = (strtotime($datos['fecha_in'])-strtotime($datos['fecha_out']))/86400;
		
       	$dias = floor($dias) ;
		
		
		
		if ( trim($tipo) == 'Vacacion'){
			
			$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim('TH-EV') ,true) );
		}
		
		if ( trim($tipo) == 'Vacaciones'){
			
			$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim('TH-EV') ,true) );
		}
		
		if ( trim($tipo) == 'vacaciones'){
			
			$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim('TH-EV') ,true) );
		}
		
		
	    if ( trim($tipo) == 'permiso_hora'){
 			$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim('TH-EP') ,true) );
		}
		
		 if ( trim($tipo) == 'permiso_dia'){
 			$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim('TH-PD') ,true) );
			   	$dias      =  $dias + 1;
		}
		
		
		$pie_contenido = $reporte_pie['pie'];
	 
 
		$hora = (date("H:i:s", strtotime("00:00") + strtotime($datos['hora_in']) - strtotime($datos['hora_out']) ));
		
		
		
		$pie_contenido = str_replace('#DESDE',trim($datos['fecha_out']), $pie_contenido);
		
		$pie_contenido = str_replace('#HASTA',trim($datos['fecha_in']), $pie_contenido);
		
		$pie_contenido = str_replace('#HORA_DESDE',trim($datos['hora_out']), $pie_contenido);
		
		$pie_contenido = str_replace('#HORA_HASTA',trim($datos['hora_in']), $pie_contenido);
		
		$pie_contenido = str_replace('#MOTIVO',trim($datos['motivo']), $pie_contenido);
		
		$pie_contenido = str_replace('#DETALLE',trim($datos['novedad']), $pie_contenido);
		
		
		$pie_contenido = str_replace('#HORAS', $hora , $pie_contenido);
		
 
		
		
		$f1 = $this->bd->_fecha_completa($datos['fecha_out'],'S');
		$f2 = $this->bd->_fecha_completa($datos['fecha_in'],'S');
		
		$pie_contenido = str_replace('#DIAS',$dias, $pie_contenido);
		
		$pie_contenido = str_replace('#DIA_DESDE',$f1, $pie_contenido);
		
		$pie_contenido = str_replace('#DIA_HASTA',$f2, $pie_contenido);
		
		
		$fecha = $this->bd->_fecha_completa($datos['fecha'],'S');
			
		$pie_contenido = str_replace('#FECHA',$fecha, $pie_contenido);
			
			
			 
 		
		echo $pie_contenido ;
		
		
		}
/*
control de permisos formulario
*/
	function Permiso($id ){
	    
	    $sql = "select idprov, id_vacacion, tipo, motivo, cargoa, novedad, anio, fecha_in, 
            	fecha_out, dia_derecho, dia_acumula, dia_tomados, hora_tomados, dia_pendientes, hora_out,hora_in,
            	sesion, fecha, regimen, cargo, razon, correo, unidad, id_departamento, cierre, fecha_ingreso
				from view_nomina_vacacion
				where id_vacacion = ".$this->bd->sqlvalue_inyeccion($id, true)  ;
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado);
	    
		$Auser = $this->bd->query_array('view_nomina_user',
		'completo ,unidad,cargo ,orden,responsable,tipo_cargo,id_departamento',
		'idprov='.$this->bd->sqlvalue_inyeccion( trim($datos['idprov'])  ,true) 
		);

		$Abombe_firma = $this->bd->query_array('bomberos.view_bom_lista',
			'cargo,funcionario,unidad,idprov,funcion,unidad_apoyo',
			'idprov='.$this->bd->sqlvalue_inyeccion( $datos['idprov']  ,true)
			 
			);
		
		
		$Abombe_operaciones = $this->bd->query_array('bomberos.view_distributivo_bom',
			'ocompleto',
			'operaciones='.$this->bd->sqlvalue_inyeccion( $datos['idprov']  ,true)
			 
			);
		
			$xxx   = 0;
		    $apoyo = 0;
		
			if ( trim($Abombe_firma['funcion']) ==  'Encargado de Estacion' ){
				$xxx = 1;
			}
		
 		
		 /*  if ( !empty($Abombe_operaciones['ocompleto']) ){
				$xxx = 2;
			}*/
		
		  if ( trim($Abombe_firma['unidad_apoyo']) > 0  ){
			  
			   		  $apoyo = 1;
			  
					  $apoyo_firma = $this->bd->query_array('view_nomina_user',
									  'orden,completo,cargo,unidad,idprov',
									'id_departamento='.$this->bd->sqlvalue_inyeccion( $Abombe_firma['unidad_apoyo']  ,true) ." and responsable= 'S'"
					  );
			  
			  		  $datos['apoyo_completo']   = $apoyo_firma['completo'] ;
					  $datos['apoyo_orden']      = trim($apoyo_firma['orden']) ;
					  $datos['apoyo_cargo']      = $apoyo_firma['cargo'] ;
					  $datos['apoyo_idprov']     = $apoyo_firma['idprov'] ;
			  
			  		  $len =  strlen (trim($apoyo_firma['orden'])) ;
			  		  $datos['apoyo_tipo']        =  $len;
			  
 			}
		
 
		
		$datos['completo']   = $Auser['completo'] ;
		$datos['orden']      = $Auser['orden'] ;
 		$datos['elaborado']  = $Auser['completo'] ;
		$datos['tipo_cargo'] = $Auser['tipo_cargo'] ;
		$datos['jefe'] =$xxx  ;
		$datos['apoyo'] =$apoyo  ;
 
	    return $datos;
	}

 /*
 */
 function Distributivo_personal($id ){
	    
	$sql = "select *
			from bomberos.view_distributivo_bom
			where id_asigna_dis = ".$this->bd->sqlvalue_inyeccion($id, true)  ;
	 
	$resultado = $this->bd->ejecutar($sql);
	
	$datos = $this->bd->obtener_array( $resultado);
	 

	return $datos;
}

/*
*/
function Distributivo_dpersonal($id_asigna_dis ){
	    
	$sql = "SELECT id_departamento  , unidad, count(*) || ' ' as funcionario 
                FROM bomberos.view_dis_bom_lista
                where id_asigna_dis= ".$this->bd->sqlvalue_inyeccion(   $id_asigna_dis , true)."
                group by id_departamento, unidad";
	 	

	$resultado = $this->bd->ejecutar($sql);
  

	while ($fila= $this->bd->obtener_fila($resultado)){

		echo '<h4><b>'.$fila['unidad'].'('.$fila['funcionario'].')'.'</b></h4>';

		$this->Distributivo_ddpersonal($id_asigna_dis,$fila['id_departamento']);

	 
	}
	 
}

/*
*/
function Distributivo_dddpersonal($id_asigna_dis,$id_departamento,$grupo){

     
    
	$tipo = $this->bd->retorna_tipo();
	  
	$sql1 = "SELECT funcionario,
					funcion,
					responsable 
				FROM bomberos.view_dis_bom_lista
				where id_asigna_dis= ".$this->bd->sqlvalue_inyeccion(   $id_asigna_dis , true)." and 
				      id_departamento = ".$this->bd->sqlvalue_inyeccion(   $id_departamento , true)." and 
					  grupo = ".$this->bd->sqlvalue_inyeccion(  trim( $grupo ), true)."   
				order by responsable desc, funcionario";
	 
	$resultado1 = $this->bd->ejecutar($sql1);
	
 

	$this->obj->table->table_basic_js($resultado1, // resultado de la consulta
	$tipo,      // tipo de conexoin
	'',         // icono de edicion = 'editar'
	'',			// icono de eliminar = 'del'
	'' ,        // evento funciones parametro Nombnre funcion - codigo primerio
	"Nombre Funcionario,Funcion,Responsable",  // nombre de cabecera de grill basica,
	'10px',      // tamaño de letra
	'Caja'.$id_departamento ,
	'N', // muestra fila,
	'40%'
	);

	

	
}	
/*
*/
	function Distributivo_ddpersonal($id_asigna_dis,$id_departamento){

     
         $sql1 = "SELECT grupo
            FROM bomberos.view_dis_bom_lista
            where id_asigna_dis= ".$this->bd->sqlvalue_inyeccion(   $id_asigna_dis , true)." and 
                  id_departamento = ".$this->bd->sqlvalue_inyeccion(   $id_departamento , true)."
                  group by grupo
                  order by grupo";
    

                  $stmt12 = $this->bd->ejecutar($sql1);

 
                  while ($fila1=$this->bd->obtener_fila($stmt12)){
    
					  		 echo '<span><b>'.trim($fila1['grupo']).'</b></span>';
             
                              $this->Distributivo_dddpersonal(   $id_asigna_dis, $id_departamento ,trim($fila1['grupo']));
                    }

	

	
}	
	//---------------------
	function Accion($id ){
	    
 
	    $sql = "SELECT id_accion, idprov, anio, comprobante, fecha, tipo, motivo, fecha_rige, 
                       novedad, otro, estado, regimen, programa, id_departamento, id_cargo, 
                       sueldo, p_regimen, p_programa, p_id_departamento, p_id_cargo, p_sueldo, 
                       sesion, creacion, modificacion, fmodificacion, razon, direccion, correo, 
                       mes, finalizado, ffinalizacion,cargo,unidad,p_unidad,p_cargo,referencia,baselegal,nombre,apellido,idprovc
                FROM view_nom_accion
				where id_accion = ".$this->bd->sqlvalue_inyeccion($id, true)  ;
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado);
	    
	    
	    $Auser = $this->bd->query_array('par_usuario',
	        'completo',
	        'login='.$this->bd->sqlvalue_inyeccion($this->sesion ,true)
	        );
	    
	    $datos['elaborado'] = $Auser['completo'] ;

		
	 
	 

		 if (trim( $datos['idprovc']) == '-' ) {
		}else
		{
			$accion_firma = $this->bd->query_array('view_nomina_rol',
	        'razon ,cargo ,unidad',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim( $datos['idprovc']) ,true)  
	        );
			 
		     $encargado =	$this->bd->_es_encargado( $datos['idprovc']);
			 
			  $eti = " ";
			 
			 if ( $encargado == 1 ) {
				 $eti = " (E) ";
			 	}
			 
			  $datos['nombre_firma']    =   $accion_firma['razon']  ;
 			  $datos['responsable_firma'] = $accion_firma['unidad'] . $eti;  

		}
		   
        $sql ="SELECT '-' as codigo,' - ' as nombre union
                      SELECT idprov as codigo,  razon AS nombre
                          FROM view_nomina_rol
                          WHERE responsable = 'S' 
                      order by 2"   ;

	        $accion_elabora = $this->bd->query_array('view_nomina_user',
	        'completo , unidad,  cargo ',
	        'email='.$this->bd->sqlvalue_inyeccion(   trim($datos['sesion'] ) ,true) .' and 
			 sesion_corporativo='.$this->bd->sqlvalue_inyeccion( trim($datos['sesion'] ) ,true)
	        );


			$datos['nom_elabora'] = $accion_elabora['completo'] ;
			$datos['car_elabora'] = $accion_elabora['cargo'] ;
			$datos['uni_elabora'] = $accion_elabora['unidad'] ;	
	    
	    $datos['elaborado'] = $Auser['completo'] ;

		$datos['fecha_completo'] = $this->bd->_fecha_completa( $datos['fecha']);
	    
	    if ( trim($datos['tipo']) == 'Decreto'){
	        $datos['D'] = 'X' ;
	        $datos['A'] = '' ;
	        $datos['R'] = '' ;
	    }
	    if ( trim($datos['tipo']) == 'Acuerdo' ){
	        $datos['D'] = '' ;
	        $datos['A'] = 'X' ;
	        $datos['R'] = '' ;
	    }
	    if ( trim($datos['tipo']) == 'Resolucion'){
	        $datos['D'] = '' ;
	        $datos['A'] = '' ;
	        $datos['R'] = 'X' ;
	    }
	    
	    $datos_firmas = $this->firmas_todos( );
	    
	    $datos['jefe'] = $datos_firmas['g10'] ;
 	    
	    $datos['control'] = $datos_firmas['tt10'];
	    $datos['ccontrol'] = $datos_firmas['tt11'];
	    
	    $datos['tt'] = $datos_firmas['t10'];
	    $datos['ctt'] = $datos_firmas['t11'];
	    
	    return $datos;
	}
	
	//------------
	function Delegacion($id ){
	    
 
	    $sql = "SELECT id_delega, idprov, anio, comprobante, fecha, tipo, motivo, fecha_rige, 
                       novedad, otro, estado, regimen, programa, id_departamento, id_cargo, 
                       sueldo, p_regimen, p_programa, p_id_departamento, p_id_cargo, p_sueldo, 
                       sesion, creacion, modificacion, fmodificacion, razon, direccion, correo, 
                       mes, finalizado, ffinalizacion,cargo,unidad,p_unidad,p_cargo,referencia,baselegal,nombre,apellido,idprovc
                FROM view_nom_delegacion
				where id_delega = ".$this->bd->sqlvalue_inyeccion($id, true)  ;
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado);
	    
	    
	    $Auser = $this->bd->query_array('par_usuario',
	        'completo',
	        'login='.$this->bd->sqlvalue_inyeccion($this->sesion ,true)
	        );
	    
	    $datos['elaborado'] = $Auser['completo'] ;

		
	 
	 

		 if (trim( $datos['idprovc']) == '-' ) {
		}else
		{
			$accion_firma = $this->bd->query_array('view_nomina_rol',
	        'razon ,cargo ,unidad',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim( $datos['idprovc']) ,true)  
	        );
			 
		     $encargado =	$this->bd->_es_encargado( $datos['idprovc']);
			 
			  $eti = " ";
			 
			 if ( $encargado == 1 ) {
				 $eti = " (E) ";
			 	}
			 
			  $datos['nombre_firma']    =   $accion_firma['razon']  ;
 			  $datos['responsable_firma'] = $accion_firma['unidad'] . $eti;  

		}
		   
        $sql ="SELECT '-' as codigo,' - ' as nombre union
                      SELECT idprov as codigo,  razon AS nombre
                          FROM view_nomina_rol
                          WHERE responsable = 'S' 
                      order by 2"   ;

	        $accion_elabora = $this->bd->query_array('view_nomina_user',
	        'completo , unidad,  cargo ',
	        'email='.$this->bd->sqlvalue_inyeccion(   trim($datos['sesion'] ) ,true) .' and 
			 sesion_corporativo='.$this->bd->sqlvalue_inyeccion( trim($datos['sesion'] ) ,true)
	        );


			$datos['nom_elabora'] = $accion_elabora['completo'] ;
			$datos['car_elabora'] = $accion_elabora['cargo'] ;
			$datos['uni_elabora'] = $accion_elabora['unidad'] ;	
	    
	    $datos['elaborado'] = $Auser['completo'] ;

		$datos['fecha_completo'] = $this->bd->_fecha_completa( $datos['fecha']);
	    
	    
	    
	    $datos_firmas = $this->firmas_todos( );
	    
	    $datos['jefe'] = $datos_firmas['g10'] ;
 	    
	    $datos['control'] = $datos_firmas['tt10'];
	    $datos['ccontrol'] = $datos_firmas['tt11'];
	    
	    $datos['tt'] = $datos_firmas['t10'];
	    $datos['ctt'] = $datos_firmas['t11'];
	    
	    return $datos;
	}
//--------------
	function firmas_todos( ){
	    
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    
	    $a10 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
	    
	    $a18 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(18,true));
	    
	    $a19 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(19,true));
	    
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
	    
	    $datos["g10"] = $a10["carpeta"];
	    $datos["g11"] = $a10["carpetasub"];
	    
	    $datos["t10"] = $a18["carpeta"];
	    $datos["t11"] = $a18["carpetasub"];
	    
	    
	    $datos["tt10"] = $a19["carpeta"];
	    $datos["tt11"] = $a19["carpetasub"];
	   
	    return $datos;
	    
	}
//-----------------------------	
	function firmas( ){
	    
	    $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
	    
	    $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
	    
	    $datos["f10"] = $a12["carpeta"];
	    $datos["f11"] = $a12["carpetasub"];
	    
	    
	    $datos["c10"] = $a14["carpeta"];
	    $datos["c11"] = $a14["carpetasub"];
	    
	    echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:10px"> ';
	    
	    echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	<td width="50%" style="text-align: center;padding: 30px">&nbsp;</td>
        	<td width="50%" style="text-align: center">&nbsp;</td>
        	</tr>
        	<tr>
        	<td style="text-align: center">'.$datos["f10"] .'r</td>
        	<td style="text-align: center">'.$datos["c10"].'</td>
        	</tr>
        	<tr>
        	<td style="text-align: center">'. $datos["f11"].'</td>
        	<td style="text-align: center">'.$datos["c11"].'</td>
        	</tr>
        	</tbody>
        	</table>';
	    
	    echo '</div> ';
	    
	}
//--------------------------------------------------------
	function ImagenLogo(){
	    
	    $sql11 = "SELECT   a.url,a.razon
				     	FROM web_registro a
				     	where a.ruc_registro =".$this->bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']) ,true);
	    
	    $resultado1 = $this->bd->ejecutar($sql11);
	    $datos11     = $this->bd->obtener_array( $resultado1);
	    
	    $_SESSION['logo'] = $datos11['url'];
	    
	    return trim($datos11['url']);
	    
	}
//--------------------------------------	
	function QR_DocumentoDoc($codigo){
	    
	    
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
//---------
function QR_Firma( ){
	    
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion(trim($_SESSION['email']),true)
	        );
	    
	    $sesion_elabora =  trim($datos['completo']);
	    
	    echo 'Documento Digital '.$_SESSION['login'].'- '. $sesion_elabora ;
	    
	}
//---------------
function QR_Documento_doc_a($nombre){
	    
	  
	    // $name    = $_SESSION['razon'] ;
	    // $elaborador = $_SESSION['login'];
	    // $sesion     = $_SESSION['email'];
	    
 
	    $hoy = date("Y-m-d H:i:s");
	    
	    // we building raw data
	    $codeContents .= 'FIRMADO POR:'.$nombre."\n";
	    $codeContents .= 'FECHA: '.$hoy."\n";
	    $codeContents .= 'VALIDAR CON: www.firmadigital.gob.ec '."\n";
	    $codeContents .= '2.4.0'."\n";
 
 	  //  $tempDir = EXAMPLE_TMP_SERVERPATH;
	    
	    QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
	
 }
 //---------
 function QR_DocumentoDoc_b($codigo ){
     
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
     
   //  $tempDir = EXAMPLE_TMP_SERVERPATH;
     
     QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
 }
//--------------------
	function _nombre($idprov){
	    
	    $empre = base64_decode($idprov);
	    
	    $sql = "SELECT  razon 
				FROM view_nomina_rol
				where idprov =".$this->bd->sqlvalue_inyeccion(	trim($empre ), true);
	    
	    $resultado = $this->bd->ejecutar($sql);
	    
	    $datos = $this->bd->obtener_array( $resultado);
	    
	    echo $datos['razon'];
 
	    
	}
	//----------------------------------
	function _actualiza_rol($id,$res){
	    
	    /*
	    $empre = base64_decode($idprov);
	    
	    $year = date('Y');
	    
	    if ($res == '1' ){
	        
	        $sql = "update  nom_rol_pagod
				set recibo = 'S'
				where idprov =".$this->bd->sqlvalue_inyeccion(	trim($empre ), true)." and
                      recibo= 'N' and anio = ".$this->bd->sqlvalue_inyeccion(	$year, true);
	        
	        $this->bd->ejecutar($sql);
	        
	    }
	    */
 
	    return 1; 
	    
	    
	}
	//-----------------------------
	function RolNombre($idprov,$id_rol){
	     
	//    $tipo = $this->bd->retorna_tipo();
	    
	    
	    $sql = "SELECT novedad,id_periodo  FROM nom_rol_pago where id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true);
	    
	    
	    $resultado = $this->bd->ejecutar($sql);
	    $datos = $this->bd->obtener_array( $resultado);
	    
/*	   
        $id_periodo = $datos['id_periodo'];
	    $periodo = $datos['novedad'];
	    
*/	    
	    
	    $sql = "SELECT *
                FROM view_nomina_rol
               where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true);
	    $resultado = $this->bd->ejecutar($sql);
	    $datos = $this->bd->obtener_array( $resultado);
	    
	    $this->empleado = $datos['razon'];
	    
	    
	    //--- abre el correo
	    $sql = "update  nom_rol_pagod
                set  recibo = ".$this->bd->sqlvalue_inyeccion('S',true)." 
               where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true).' and 
                     id_rol = '.$this->bd->sqlvalue_inyeccion($id_rol,true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	   
	    
	    
	}
//-----------------	
function RolNomina_Aporte($programa,$id_rol){

     
    
	$tipo = $this->bd->retorna_tipo();
	  

	 
	$sql = "  SELECT   idprov ,  empleado ,   unidad ,patronal as total
	FROM view_rol_impresion
	where tipoformula = 'RS'and 
			programa =". $this->bd->sqlvalue_inyeccion($programa,true). " and 
		 id_rol =". $this->bd->sqlvalue_inyeccion($id_rol,true)." order by empleado ";
	 
	$resultado = $this->bd->ejecutar($sql);
	
	  
 
	$this->obj->table->KP_sumatoria(4,3 ); 

	$this->obj->table->table_basic_js($resultado, // resultado de la consulta
	$tipo,      // tipo de conexoin
	'',         // icono de edicion = 'editar'
	'',			// icono de eliminar = 'del'
	'' ,        // evento funciones parametro Nombnre funcion - codigo primerio
	"Identificacion, Nombre Funcionario,Unidad,Aporte Patronal",  // nombre de cabecera de grill basica,
	'9px',      // tamaño de letra
	'Caja1'         // id
	);

	

	
}	
function RolNomina_periodo($id_rol){

	   
	$sql = "SELECT novedad,id_periodo  
	FROM nom_rol_pago 
   WHERE id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true);


$resultado = $this->bd->ejecutar($sql);
$datos = $this->bd->obtener_array( $resultado);
return $datos;
}	
//--------------------------------------------
function RolNomina($idprov,$id_rol){
	   
	        	       
      $this->idprov = $idprov;
    
    
	  $tipo = $this->bd->retorna_tipo();
		
	   
	  $sql = "SELECT novedad,id_periodo  
				FROM nom_rol_pago 
			   WHERE id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true);
	  
	 
	  $resultado = $this->bd->ejecutar($sql);
	  $datos = $this->bd->obtener_array( $resultado);
	  
	  $id_periodo = $datos['id_periodo'];
	  $periodo    = $datos['novedad'];
	   

	   
	  $sql = "SELECT *  
			   FROM view_nomina_rol 
			  where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true);
	  
	  
	  $resultado = $this->bd->ejecutar($sql);
	  
	  $datos = $this->bd->obtener_array( $resultado);
	   

	  $a17 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(17,true));
	  $datos["c10"] = $a17["carpeta"];
	  $datos["c11"] = $a17["carpetasub"];
 
	  
	  echo '<table class="table table-striped table-hover" width="80%">
		   <tbody>
		   <tr>
			   <td><h5><b>Periodo : '.$periodo.'</b></h5></td>
				<td>   </td>
		   </tr> 
		   <tr>';
	  echo '<td>Funcionario: '.$datos['razon'].'<br>Nro.Identificacion: '.$datos['idprov'].'<br>Cargo: '.$datos['cargo'].'<br>Regimen: '.$datos['regimen'].'</td>
	           <td> &nbsp;</td>
		   </tr> 
		   <tr>';
	   echo '<td> &nbsp;</td>
			 <td>&nbsp;</td>
			</tr>
			<tr>
			<td width="40%" align="left" valign="top">';

		  if (  trim($datos['sifondo']) == 'N') {
 		 
				 $sql = 'SELECT nombre as "INGRESO",ingreso as "Monto"
							 FROM view_rol_personal
							where idprov = '.$this->bd->sqlvalue_inyeccion($idprov ,true)." and 
								  id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
							   id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
							   ingreso > 0 and 
							   tipo = ".$this->bd->sqlvalue_inyeccion("I",true);
		 }else{
 		 
			$sql = 'SELECT nombre as "INGRESO",ingreso as "Monto"
						FROM view_rol_personal
					   where idprov = '.$this->bd->sqlvalue_inyeccion($idprov ,true)." and 
							 id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
						  id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
						  ingreso > 0 and id_config_matriz <> '2' and
						  tipo = ".$this->bd->sqlvalue_inyeccion("I",true);
     	}
				 
				 $resultado = $this->bd->ejecutar($sql);
				 
				 $this->obj->grid->KP_GRID_visor($resultado,$tipo,'100%'); 
				 
	 echo '</td>
			 <td width="40%" align="left" valign="top">';
	 
			 if (  trim($datos['sifondo']) == 'N') {
					$sql = 'SELECT nombre as "DESCUENTO",descuento as "Monto"
								FROM view_rol_personal
								where idprov = '.$this->bd->sqlvalue_inyeccion($idprov,true)." and 
									id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
								descuento > 0 and 
								id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
								tipo = ".$this->bd->sqlvalue_inyeccion("E",true);

		 	}else{		
				 
				$sql = 'SELECT nombre as "DESCUENTO",descuento as "Monto"
				FROM view_rol_personal
				where idprov = '.$this->bd->sqlvalue_inyeccion($idprov,true)." and 
					id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
				descuento > 0 and    id_config_matriz <> '11' and
				id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
				tipo = ".$this->bd->sqlvalue_inyeccion("E",true);
			}
																		
				  $resultado = $this->bd->ejecutar($sql);
				  $this->obj->grid->KP_GRID_visor($resultado,$tipo,'100%'); 
		echo '</td>
			   </tr>
			   <tr>';
	  
				  $sql = 'SELECT sum(ingreso) as ingreso,sum(descuento) as egreso
							 FROM view_rol_personal
							where idprov = '.$this->bd->sqlvalue_inyeccion($idprov ,true)." and 
								  id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
							   id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true);
				  
				  $resultado = $this->bd->ejecutar($sql);
				  $datos1 = $this->bd->obtener_array( $resultado);
				  $total = $datos1['ingreso'] -  $datos1['egreso'];
		   
	   echo '<td style="font-style: normal; color: #121212; font-weight: bold; font-size: 10px;">
			   Total   Ingreso: '.number_format(  $datos1['ingreso'],2).'</td>
			   <td style="font-style: normal; color: #121212; font-weight: bold; font-size: 10px;">
			   <span style="font-size: 10px; color: #050505; font-weight: bold;">Total Descuento:'. number_format($datos1['egreso'],2).'</span></td>
		   </tr>
		   <tr>
		   <td colspan="2" style="font-size: 13px; color: #050505; font-weight: bold;">
		   A pagar: '.number_format($total,2).'</td>
		   </tr>
			</tbody>
	   </table>
         <p>
        &nbsp;
        </p>

	<table class="table table-striped table-hover" width="80%">
  <tbody>
    <tr>
      <td colspan="2"><p>&nbsp;</p></td>
    </tr>
    <tr>
      <td width="40%" align="center">'.strtoupper($datos["c10"]).'
			 	<br>'.strtoupper($datos["c11"]).' <br>
			     ROLES DE PAGO TTHH</b><br></td>
      <td width="40%" align="center"><b>RECIBI CONFORME<br>'.
 strtoupper($datos['razon']).'<br>Id. '.$idprov.'</b><br></td>
    </tr>
  </tbody>
</table>

 
            <p>
		          El presente documento fue generado de manera electrónica por la Dirección de Talento Humano y puede ser utilizado para sus fines correspondientes.
            </p>
 		  ';
	   
	  
        
	}

	//--------------------------------------------
function RolNomina_std($idprov,$id_rol){
	   
	        	       
         	       
	$this->idprov = $idprov;
    
    
	$tipo = $this->bd->retorna_tipo();
	  
	 
	$sql = "SELECT novedad,id_periodo  
			  FROM nom_rol_pago 
			 WHERE id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true);
	
   
	$resultado = $this->bd->ejecutar($sql);
	$datos = $this->bd->obtener_array( $resultado);
	
	$id_periodo = $datos['id_periodo'];
	$periodo    = $datos['novedad'];
	 

	 
	$sql = "SELECT *  
			 FROM view_nomina_rol 
			where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true);
	
	
	$resultado = $this->bd->ejecutar($sql);
	
	$datos = $this->bd->obtener_array( $resultado);
	 


	
	echo '<table class="table table-striped table-hover" width="100%">
		 <tbody>
		 <tr>
			 <td><h5><b>Periodo : '.$periodo.'</b></h5></td>
			  <td>   </td>
		 </tr> 
		 <tr>';
	echo '<td>Funcionario: '.$datos['razon'].'</td>
		  <td>'.'Nro.Identificacion: '.$datos['idprov'].'</td>
		 </tr> 
		 <tr>';
	 echo '<td>'.$datos['cargo'].'</td>
		   <td>&nbsp;</td>
		  </tr>
		  <tr>
		  <td width="50%" align="left" valign="top">';

		if (  trim($datos['sifondo']) == 'N') {
		
			   $sql = 'SELECT nombre as "INGRESO",ingreso as "Monto"
						   FROM view_rol_personal
						  where idprov = '.$this->bd->sqlvalue_inyeccion($idprov ,true)." and 
								id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
							 id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
							 ingreso > 0 and 
							 tipo = ".$this->bd->sqlvalue_inyeccion("I",true);
	   }else{
		
		  $sql = 'SELECT nombre as "INGRESO",ingreso as "Monto"
					  FROM view_rol_personal
					 where idprov = '.$this->bd->sqlvalue_inyeccion($idprov ,true)." and 
						   id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
						id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
						ingreso > 0 and id_config_matriz <> '2' and
						tipo = ".$this->bd->sqlvalue_inyeccion("I",true);
	   }
			   
			   $resultado = $this->bd->ejecutar($sql);
			   
			   $this->obj->grid->KP_GRID_visor($resultado,$tipo,'100%'); 
			   
   echo '</td>
		   <td width="50%" align="left" valign="top">';
   
		   if (  trim($datos['sifondo']) == 'N') {
				  $sql = 'SELECT nombre as "DESCUENTO",descuento as "Monto"
							  FROM view_rol_personal
							  where idprov = '.$this->bd->sqlvalue_inyeccion($idprov,true)." and 
								  id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
							  descuento > 0 and 
							  id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
							  tipo = ".$this->bd->sqlvalue_inyeccion("E",true);

		   }else{		
			   
			  $sql = 'SELECT nombre as "DESCUENTO",descuento as "Monto"
			  FROM view_rol_personal
			  where idprov = '.$this->bd->sqlvalue_inyeccion($idprov,true)." and 
				  id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
			  descuento > 0 and    id_config_matriz <> '11' and
			  id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true)." and 
			  tipo = ".$this->bd->sqlvalue_inyeccion("E",true);
		  }
																	  
				$resultado = $this->bd->ejecutar($sql);
				$this->obj->grid->KP_GRID_visor($resultado,$tipo,'100%'); 
	  echo '</td>
			 </tr>
			 <tr>';
	
			 if (  trim($datos['sifondo']) == 'N') {

				$sql = 'SELECT sum(ingreso) as ingreso,sum(descuento) as egreso
				FROM view_rol_personal
			   where idprov = '.$this->bd->sqlvalue_inyeccion($idprov ,true)." and 
					 id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
				  id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true);

			}else{	

				$sql = 'SELECT sum(ingreso) as ingreso,sum(descuento) as egreso
						   FROM view_rol_personal
						  where idprov = '.$this->bd->sqlvalue_inyeccion($idprov ,true)." and 
								id_rol = ".$this->bd->sqlvalue_inyeccion($id_rol,true)." and 
								id_config_matriz not in  ('11','2') and
							 id_periodo =".$this->bd->sqlvalue_inyeccion($id_periodo ,true);

			}
 
	
				$resultado = $this->bd->ejecutar($sql);
				$datos1 = $this->bd->obtener_array( $resultado);
				$total = $datos1['ingreso'] -  $datos1['egreso'];
		 
	 echo '<td style="font-style: normal; color: #121212; font-weight: bold; font-size: 10px;">
			 Total   Ingreso: '.number_format(  $datos1['ingreso'],2).'</td>
			 <td style="font-style: normal; color: #121212; font-weight: bold; font-size: 10px;">
			 <span style="font-size: 10px; color: #050505; font-weight: bold;">Total Descuento:'. number_format($datos1['egreso'],2).'</span></td>
		 </tr>
		 <tr>
		 <td colspan="2" style="font-size: 13px; color: #050505; font-weight: bold;">
		 A pagar: '.number_format($total,2).'</td>
		 </tr>
		  </tbody>
	 </table>
		
	 ';
	
	  
   
 
	 echo '<table width="100%" border="0" cellpadding="0" style="font-size: 10px">
   <tbody>
 	 
	 <tr>
		  <td align="center" class="tablaPie1"><p>&nbsp;</p><p>&nbsp;</p>TALENTO HUMANO </td>
	   <td align="center" class="tablaPie1"><p>&nbsp;</p><p>&nbsp;</p>  RECIBI CONFORME</td>
	 </tr>
   </tbody>
 </table>
 <p>
 El presente documento fue generado de manera electrónica y puede ser utilizado para sus fines correspondientes.
  </p>
 ';
		 
	
			
	  
  }
  
  //-----------_ObjetivosE
  
  function _ObjetivosE($Q_IDUNIDAD,$Q_IDPERIODO){
      
       
      
      $tabla_cabecera =  '<table width="90%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
      
      
      $sqlO1= "SELECT idestrategia_matriz,idestrategia_padre,objetivoe,objetivo 
                FROM planificacion.view_oe_oo
                where id_departamento = ".$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true)."  and 
                      anio = ".$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                order by idestrategia_matriz,idestrategia_padre';


      $stmt_ac = $this->bd->ejecutar($sqlO1);
      
      echo $tabla_cabecera;
      
      while ($x=$this->bd->obtener_fila($stmt_ac)){
          
          $objetivoe =  trim($x['objetivoe']);
          $objetivo =  trim($x['objetivo']);
          
          echo ' <tr>  <td align="justify" valign="top">';
        
          echo '<b>OBJETIVO ESTRATEGICO: '.$objetivoe.'</b><br>';
          echo '<b>OBJETIVO OPERATIVO:</b> '.$objetivo.'<br><br>';
          
          
          echo ' </tr>';
      }
      
     
      echo '</table>';
      
     
     
      
  }
  //---------------------------------------------	
  function _ActividadesPOA_RESUMEN($Q_IDUNIDAD,$Q_IDPERIODO){
      
      
      $Array = $this->bd->query_array('nom_departamento','nombre,programa', 'id_departamento='.$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true));
      
      
      echo "<h4>RESUMEN DE ACTIVIDADES PAPP <br>".$Array['nombre'].'-'.$Array['programa']."</h4>";
      
      $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
      
      
      $sqlO1= "SELECT   actividad,   aportaen,    aporte,    idactividad,avance
								   FROM planificacion.view_actividad_poa
				 				  WHERE estado = 'S' and id_departamento = ".$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
                                        anio = '.$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                order by idactividad' ;
      
      $stmt_ac = $this->bd->ejecutar($sqlO1);
      $numero2         = 1;
      
      echo $tabla_cabecera;
      
      while ($x=$this->bd->obtener_fila($stmt_ac)){
          
          $total_actividad = $x['avance']. ' %';
          
          $actividad =  trim($x['actividad']);
          
          echo '<tr>
                  <td width="80%" style="font-size: 10px;padding: 3px"><b>'.$numero2.'.- '.$actividad.'</b></td>
                  <td width="20%" style="font-size: 12px;padding: 3px">Avance '.$total_actividad.'</td>
                </tr><tr>
            <td colspan="2" style="padding: 5px">';
          
                $this->_Tareas_matriz($Q_IDUNIDAD,$Q_IDPERIODO,$x['idactividad']);
          
          echo '</td></tr>';
          
          $numero2 ++;
      }
      
      echo '</table>';
      
  }
  
  //--------------------------
function _ActividadesPOA($Q_IDUNIDAD,$Q_IDPERIODO){
    
 
	$Array = $this->bd->query_array('nom_departamento','nombre,programa', 'id_departamento='.$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true));


    echo "<h4>RESUMEN DE ACTIVIDADES PAPP <br>".$Array['nombre'].'-'.$Array['programa']."</h4>";

    $tabla_cabecera =  '<table width="90%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
    
    
    $sqlO1= "SELECT   actividad,   aportaen,    aporte,    idactividad,avance
								   FROM planificacion.view_actividad_poa
				 				  WHERE estado = 'S' and id_departamento = ".$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
                                        anio = '.$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                order by idactividad' ;
  
	$stmt_ac = $this->bd->ejecutar($sqlO1);
    $numero2         = 1;
    
    echo $tabla_cabecera;
    
    while ($x=$this->bd->obtener_fila($stmt_ac)){
        
        $total_actividad = $x['avance']. ' %';
        $actividad =  trim($x['actividad']);
        echo '<tr>
        <td width="70%" style="font-size: 10px;padding: 3px"><b>'.$numero2.'.- '.$actividad.'</b></td>
            <td width="20%" style="font-size: 12px;padding: 3px">Avance '.$total_actividad.'</td>
            </tr><tr>
            <td colspan="2" style="padding: 5px">';
				$this->_Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$x['idactividad']);
        echo '</td></tr>';
        
        $numero2 ++;
    }
     
   echo '</table>';
 
}
//---------------------------------------------
function _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$idactividad){
    
  
    
    $sqlO2= 'SELECT   *
        FROM planificacion.view_tarea_poa
	   WHERE id_departamento = '.$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
            idactividad='.$this->bd->sqlvalue_inyeccion($idactividad,true). " and estado = 'S'
       ORDER BY fechainicial desc" ;
    
    $stmt_TA = $this->bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="3%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">No.</td>
      <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Tarea</td>
      <td class="derecha" width="16%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Responsable</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Inicio</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Asignado ($)</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Ejecutado ($)</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Avance </td>

      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Dias</td></tr>';
    
    $numero3  = 1;
    
	$codificado1= 0;
	$ejecutado1  = 0;	
		
    while ($z=$this->bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
        $nombre_funcionario = trim($z['nombre_funcionario']);
        $tarea              = trim($z['tarea']);
        $fecha              = $z['fechainicial'] ;
        
        $dias               = $z['dias_trascurrido_inicio'] ;

        if (  $dias   < 1 ) {
            $dias = 0;
        }

        $codificado         = number_format($z['codificado'],2,".",",");
        $ejecutado          = number_format($z['ejecutado'] ,2,".",",");
      
     
 
       
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px">'.$nombre_funcionario.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$fecha.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$codificado.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$ejecutado.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$z['avance'] .'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$dias.'</td>
            </tr>';
        
		
		$codificado1 =  $codificado1 + $z['codificado'];
		$ejecutado1  =  $ejecutado1 + $z['ejecutado'];	
     
        $numero3 ++;
    }
    
	 echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center"></td>
           
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px"> </td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px"> </td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">TOTAL</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($codificado1,2).'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($ejecutado1,2).'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px"> </td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center"> </td>
            </tr>';
        
    
    echo '</table>';

     
    
    return $codificado1;
}

//-----------------------------
function _Tareas_matriz($Q_IDUNIDAD,$Q_IDPERIODO,$idactividad){
    
    
    
    $sqlO2= 'SELECT   *
        FROM planificacion.view_tarea_poa
	   WHERE id_departamento = '.$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
            idactividad='.$this->bd->sqlvalue_inyeccion($idactividad,true). " and estado = 'S'
       ORDER BY fechainicial desc" ;
    
    $stmt_TA = $this->bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="3%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">No.</td>
      <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Tarea</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Inicio</td>
      <td class="derecha" width="6%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Asignado ($)</td>

   <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Ene-Mar</td>
   <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Abr-Jun</td>
   <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Jul-Sep</td>
   <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Oct-Dic</td>

      <td class="derecha" width="6%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Ejecutado ($)</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Avance (%) </td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Dias</td></tr>';
    
    $numero3  = 1;
    
    $codificado1= 0;
    $ejecutado1  = 0;
    $monto11  = 0;
    $monto21 = 0;
    $monto31 = 0;
    $monto41 = 0;
    
    while ($z=$this->bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
         $tarea              = trim($z['tarea']);
        $fecha              = $z['fechainicial'] ;
        
        $dias               = $z['dias_trascurrido_inicio'] ;
        
        if (  $dias   < 1 ) {
            $dias = 0;
        }
        
        $codificado         = number_format($z['codificado'],2,".",",");
        $ejecutado          = number_format($z['ejecutado'] ,2,".",",");
        
        $monto1   = number_format($z['monto1'] ,2,".",",");
        $monto2   = number_format($z['monto2'] ,2,".",",");
        $monto3   = number_format($z['monto3'] ,2,".",",");
        $monto4   = number_format($z['monto4'] ,2,".",",");
        
        
        
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$fecha.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$codificado.'</td>

             <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$monto1.'</td>
             <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$monto2.'</td>
             <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$monto3.'</td>
             <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$monto4.'</td>

              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.$ejecutado.'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$z['avance'] .'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">'.$dias.'</td>
            </tr>';
        
        
        $codificado1 =  $codificado1 + $z['codificado'];
        $ejecutado1  =  $ejecutado1 + $z['ejecutado'];
        
        
        $monto11  =  $monto11 + $z['monto1'];
        $monto21  =  $monto21 + $z['monto2'];
        $monto31  =  $monto31 + $z['monto3'];
        $monto41  =  $monto41 + $z['monto4'];
        
        $numero3 ++;
    }
    
    echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center"></td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px"> </td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center">TOTAL</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($codificado1,2).'</td>

   <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($monto11,2).'</td>
   <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($monto21,2).'</td>
   <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($monto31,2).'</td>
   <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($monto41,2).'</td>

              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: right">'.number_format($ejecutado1,2).'</td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px"> </td>
              <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px;text-align: center"> </td>
            </tr>';
    
    
    echo '</table>';
    
    
    
    return $codificado1;
}
/*
*/


function _ActividadesPOA_obj($Q_IDUNIDAD,$Q_IDPERIODO){
    

	
	$Array = $this->bd->query_array('nom_departamento','nombre,programa', 'id_departamento='.$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true));


    echo "<h4>RESUMEN DE OBJETIVOS  ESTRATEGICOS<br>".$Array['nombre'].'-'.$Array['programa']."</h4>";
  
    
    $sqlO2= "select  a.id_departamento , a.idobjetivo , b.objetivo , b.objetivoe ,
					sum(a.inicial) as inicial, sum(a.codificado) as codificado
					from planificacion.view_tarea_poa a, planificacion.view_oe_oo b
					where a.anio= ".$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true)." and 
						  a.idobjetivo = b.idobjetivo and
						  a.anio = b.anio and 
						  a.estado= 'S' and 
						  a.id_departamento =".$this->bd->sqlvalue_inyeccion($Q_IDUNIDAD,true)."
					group by a.id_departamento , a.idobjetivo ,b.objetivo, b.objetivoe";
	
	 
    
    $stmt_TA = $this->bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="40%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Objetivo Estrategico</td>
      <td class="derecha" width="30%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Objetivo Operativo</td>
      <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Inicial ($)</td>
      <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Codificado ($)</td></tr>';
    
    $numero3  = 1;

	$codificado1 = 0;
    $ejecutado1 = 0;

    while ($z=$this->bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
        $objetivoe = trim($z['objetivoe']);
        $objetivo              = trim($z['objetivo']);
 
        $codificado         = number_format($z['inicial'],2,".",",");
        $ejecutado          = number_format($z['codificado'] ,2,".",",");
      
 
       
        
        echo '<tr>
               <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px">'.$objetivoe.'</td>
              <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px">'.$objetivo.'</td>
               <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.$codificado.'</td>
              <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.$ejecutado.'</td>
             </tr>';
        
			 $codificado1 =   $codificado1 + $z['inicial'];
			 $ejecutado1 =  $ejecutado1 + $z['codificado'] ;

        $numero3 ++;
    }
    

	echo '<tr>
	<td class="filasupe" valign="top" style="font-size: 10px;padding: 5px"> </td>
    <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px"> TOTAL</td>
	<td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.number_format($codificado1,2).'</td>
    <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.number_format($ejecutado1,2).'</td>
  </tr>';
    
    echo '</table><h4>INDICADORES DE GESTION</h4>';

    
    $this->Indicadores($Q_IDUNIDAD,$Q_IDPERIODO);
     
    
    return 0;
}
/*
 
 */
function Indicadores($id_unidad,$Q_IDPERIODO){
    
    
    
    $sqlOO= 'SELECT   objetivo,   numero,idobjetivo
				FROM planificacion.view_indicadores_oo_res
				WHERE anio = '.$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND
					  id_departamento = '.$this->bd->sqlvalue_inyeccion($id_unidad,true);
    
    
    $stmt_oo = $this->bd->ejecutar($sqlOO);
    
    echo '<table class="actividad">
       		 <thead>
              <tr>
                <th class="derecha" width="30%"  style="text-align: center;padding: 5px" valign="top" bgcolor="#A5CAE1">Objetivo</th>
                <th class="derecha" width="25%"  style="text-align: center;padding: 5px" valign="top" bgcolor="#A5CAE1">Indicador</th>
                <th class="derecha" width="10%"  style="text-align: center;padding: 5px" valign="top" bgcolor="#A5CAE1">Meta</th>
				<th class="derecha" width="10%"  style="text-align: center;padding: 5px" valign="top" bgcolor="#A5CAE1">Periodo</th>
                <th class="derecha" width="25%"  style="text-align: center;padding: 5px" valign="top" bgcolor="#A5CAE1">Medio Verificacion</th>
            </tr><tbody>';
    
    while ($y=$this->bd->obtener_fila($stmt_oo)){
        
        $this->Indicadores_detalle($id_unidad,$Q_IDPERIODO,$y['numero'],$y['idobjetivo']);
        
    }
    echo  ' </tbody></table>';
 
}
/*
 
 */
function Indicadores_detalle($id_unidad,$Q_IDPERIODO,$nro,$IDOBJETIVO){
    
    $sqlOODetalle= 'SELECT    objetivo, indicador,  meta, formula,medio,   periodo,idobjetivoindicador
				FROM planificacion.view_indicadores_oo
				WHERE anio = '.$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND
					  estado = '.$this->bd->sqlvalue_inyeccion('S',true).' AND
					  idobjetivo = '.$this->bd->sqlvalue_inyeccion($IDOBJETIVO,true);
    
    
    
    
    $stmtDetalle = $this->bd->ejecutar($sqlOODetalle);
    
    $i = 0;
    
    while ($x=$this->bd->obtener_fila($stmtDetalle)){
        
       
        $imagen = '<img  align="absmiddle" src="indicadores.png"/> ';
        
        $imageno = '<img  align="absmiddle" src="oo.png"/> ';
        
        $imageni = ' ';
        
        
        
        if ($nro == 1){
            echo '<tr>
		                <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px">'.$imageno.$x['objetivo'].'</td>
		                <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px">'.$imagen.$x['indicador'].'</td>
		                <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px"><b>'.$x['meta'].'</b></td>
		                <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px">'.$imageni.$x['periodo'].'</td>
                        <td class="filasupe" valign="top" style="font-size: 9px;padding: 5px">'.$x['medio'].'</td>
           		      </tr>';
        }else {
            if ($i == 0){
                echo '<tr>
		     				<td valign="top" style="font-size: 9px;padding: 5px" class="filasupe" rowspan="'.$nro.'">'.$imageno.$x['objetivo'].'</td>
		     				<td valign="top" style="font-size: 9px;padding: 5px" class="filasupe">'.$imagen.$x['indicador'].'</td>
		     				<td valign="top" style="font-size: 9px;padding: 5px" class="filasupe"><b>'.$x['meta'].'</b></td>
		     				<td valign="top" style="font-size: 9px;padding: 5px" class="filasupe"> '.$imageni.$x['periodo'].'</td>
                            <td valign="top" style="font-size: 9px;padding: 5px" class="filasupe">'.$x['medio'].'</td>
						</tr>';
            }else{
                echo '<tr>
				                  <td valign="top" style="font-size: 9px;padding: 5px" class="filasupe">'.$imagen.$x['indicador'].'</td>
				                  <td valign="top" style="font-size: 9px;padding: 5px" class="filasupe"><b>'.$x['meta'].'</b></td>
				                  <td valign="top" style="font-size: 9px;padding: 5px" class="filasupe">'.$imageni.$x['periodo'].'</td>
                                  <td valign="top" style="font-size: 9px;padding: 5px" class="filasupe">'.$x['medio'].'</td>
				            </tr>';
            }
        }
        $i++;
    }
    
    
    
}

/*
impresion de permisos de bomberos
*/
function firma_reportes($codigo_reporte,$idprov){
	


	$Auser = $this->bd->query_array('view_nomina_user',
	'completo ,unidad,cargo ,orden,responsable ,id_departamento',
	'idprov='.$this->bd->sqlvalue_inyeccion( trim( $idprov)  ,true)
	);
 


			$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($codigo_reporte) ,true) );

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

			 $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
			 $pie_contenido = str_replace('#PRESUPUESTO',trim($a10['carpeta']), $pie_contenido);
			 $pie_contenido = str_replace('#CARGO_PRESUPUESTO',trim($a10['carpetasub']), $pie_contenido);
	
	
	
			$Abombe = $this->bd->query_array('bomberos.view_bom_lista',
			'id_departamento,grupo',
			'idprov='.$this->bd->sqlvalue_inyeccion( trim( $idprov)  ,true)
			);

	
			$Abombe_firma = $this->bd->query_array('bomberos.view_bom_lista',
			'cargo,funcionario,unidad',
			'id_departamento='.$this->bd->sqlvalue_inyeccion( $Abombe['id_departamento']  ,true)." and 
			  funcion = 'Encargado de Estacion'" 
			);
	
	
		    if ( trim($Abombe['grupo']) == 'ESCUELA DE FORMACION Y ESPECIALIZACION'){
					
					$Auser2 = $this->bd->query_array('view_nomina_user',
						'completo ,unidad,cargo ,orden,responsable ',
						"responsable= 'S' and id_departamento =".$this->bd->sqlvalue_inyeccion( 2 ,true)
						);
				
 
					 	$pie_contenido = str_replace('#DIRECTOR',trim($Auser2['completo']), $pie_contenido);
						$pie_contenido = str_replace('#CARGO_DIRECTOR',trim($Auser2['cargo']), $pie_contenido);
			   }
	
	
			//------------- llama a la tabla de parametros ---------------------//

			if (  trim($Auser['responsable']) == 'S' ){

				$a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
				$pie_contenido = str_replace('#DIRECTOR',trim($a10['carpeta']), $pie_contenido);
				$pie_contenido = str_replace('#CARGO_DIRECTOR',trim($a10['carpetasub']), $pie_contenido);

			}else{

				$Auser1 = $this->bd->query_array('view_nomina_user',
				'completo ,unidad,cargo ,orden,responsable ',
				"responsable= 'S' and id_departamento=".$this->bd->sqlvalue_inyeccion( trim($Auser['id_departamento']) ,true)
				);
				
				if ( !empty($Auser1['completo'])){
				
						$pie_contenido = str_replace('#DIRECTOR',trim($Auser1['completo']), $pie_contenido);
						$pie_contenido = str_replace('#CARGO_DIRECTOR',trim($Auser1['cargo']), $pie_contenido);
				}else{
					
					
				   $ordenp  = trim($Auser['orden']);
				   $len     = strlen(  $ordenp );
					 
					
				   if ( $len == 3) {
					   
					   $orden_tipo = substr( $ordenp ,0,2);
 					   
					   $Auser1 = $this->bd->query_array('view_nomina_user',
						'completo ,unidad,cargo ,orden,responsable ',
						"responsable= 'S' and orden =".$this->bd->sqlvalue_inyeccion( trim($orden_tipo) ,true)
						);
					   
				    }
						$pie_contenido = str_replace('#DIRECTOR',trim($Auser1['completo']), $pie_contenido);
						$pie_contenido = str_replace('#CARGO_DIRECTOR',trim($Auser1['cargo']), $pie_contenido);
				}
				

			}

	 
	
			if (!empty(	$Abombe_firma['funcionario'])){

				$pie_contenido = str_replace('#ENCARGADO_ESTACION',trim($Abombe_firma['funcionario']), $pie_contenido);
				$pie_contenido = str_replace('#CARGO_ESTACION',trim($Abombe_firma['cargo']), $pie_contenido);
				$pie_contenido = str_replace('#UNIDAD_ESTACION',trim($Abombe_firma['unidad']), $pie_contenido);

		   } 
 		
		   
			 
		

			$pie_contenido = str_replace('#SOLICITA',trim($Auser['completo']), $pie_contenido);
			$pie_contenido = str_replace('#CARGO_SOLICITA',trim($Auser['cargo']), $pie_contenido);

			$usuarios = $this->bd->__user($this->sesion); // nombre del usuario actual

			$sesion   = ucwords(strtolower($usuarios['completo']));  


			$pie_contenido = str_replace('#SESION',$sesion, $pie_contenido);
	
	echo $pie_contenido ;

}

	
	/*
impresion de permisos de bomberos
*/
function firma_reportes_apoyo($codigo_reporte,$idprov,$apoyo_completo,$apoyo_cargo){
	

	
	$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($codigo_reporte) ,true)  );

	$pie_contenido = $reporte_pie["pie"];
	
	
	$usuarios = $this->bd->__user($this->sesion); // nombre del usuario actual
	$sesion   = ucwords(strtolower($usuarios['completo']));  
	 

	$Auser = $this->bd->query_array('view_nomina_user',
	'completo ,unidad,cargo ,orden,responsable ,id_departamento',
	'idprov='.$this->bd->sqlvalue_inyeccion( trim( $idprov)  ,true)
	);
 
			$pie_contenido = str_replace('#SOLICITA',trim($Auser['completo']), $pie_contenido);
	
			$pie_contenido = str_replace('#CARGO_SOLICITA',trim($Auser['cargo']), $pie_contenido);

			 
		   $pie_contenido = str_replace('#DIRECTOR',trim($apoyo_completo), $pie_contenido);
	
	        $pie_contenido = str_replace('#CARGO_DIRECTOR',trim($apoyo_cargo), $pie_contenido);
 	  

			$pie_contenido = str_replace('#SESION',$sesion, $pie_contenido);
	
	echo $pie_contenido ;

}


function tarea_pac( $seg  ){
    
    $datos_ejecuta   = $this->bd->query_array('planificacion.sitarea_seg', '*', 'idtarea_seg='.$this->bd->sqlvalue_inyeccion( $seg,true) );
    
    return $datos_ejecuta;
}

function tarea_reprogramacion( $seg  ){
    
    $datos_ejecuta   = $this->bd->query_array('planificacion.view_reprogramaciones', '*', 'id_sireprogra='.$this->bd->sqlvalue_inyeccion( $seg,true) );
    
    return $datos_ejecuta;
}

/*
 DATOS
 */

function K_comprobante_PAC( ){
    
    
    $anio = date('Y');
    
    $sql = "SELECT count(documento) as secuencia
			      FROM adm.view_viatico
			      where  anio = ".$this->bd->sqlvalue_inyeccion($anio ,true);
    
    $parametros 			= $this->bd->ejecutar($sql);
    
    $secuencia 				= $this->bd->obtener_array($parametros);
     
    $contador               = $secuencia['secuencia'] + 1;
    
    $input                  = str_pad($contador, 5, "0", STR_PAD_LEFT);
    
    return $input.'-'.$anio ;
}

/*
 * REVISION
 */
function viatico_solicita($cliente, $id  ){
    
    
    //------------- llama a la tabla de parametros ---------------------//
    
    $reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
    
    $pie_contenido = $reporte_pie["pie"];
     
    $datos   = $this->bd->query_array('adm.view_viatico', '*', 'id_viatico='.$this->bd->sqlvalue_inyeccion( $id,true) );
    
    $len = strlen(trim($datos['documento']));
    
    if ($len > 4  ) {
         $documento  =   $datos['documento'];
     }else{
         $documento  =   $this->K_comprobante_PAC();
         
         $sql        =   "update adm.viatico
                            set documento = ".$this->bd->sqlvalue_inyeccion( $documento,true)."
                            where id_viatico =".$this->bd->sqlvalue_inyeccion($id,true)  ;
         
         $datos['documento'] = $documento;
         $this->bd->ejecutar($sql);
     }
  
    
    
    $pie_contenido = str_replace('#FECHA',trim($datos['fecha'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#FUNCIONARIO',trim($datos['razon'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#PUESTO',trim($datos['cargo'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#DOCUMENTO',trim( $datos['documento'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#CIUDAD',trim($datos['ciudad_comision'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#UNIDADSERVIDOR',trim($datos['unidad'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#SALIDA_FECHA',trim($datos['fecha_salida'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#SALIDA_HORA',trim($datos['hora_salida'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#LLEGADA_FECHA',trim($datos['fecha_llegada'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#LLEGADA_HORA',trim($datos['hora_llegada'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#LLEGADA_HORA',trim($datos['hora_llegada'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#SERVIDORES',trim($datos['servidores'] ), $pie_contenido);
    $pie_contenido = str_replace('#DESCRIPCION',trim($datos['motivo'] ), $pie_contenido);
    
    
    $pie_contenido = str_replace('#IDA_TIPO',trim($datos['tipo_tras1'] ), $pie_contenido);
    $pie_contenido = str_replace('#VUELTA_TIPO',trim($datos['tipo_tras2'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#IDA_TRANSPORTE',trim($datos['nombre_tras1'] ), $pie_contenido);
    $pie_contenido = str_replace('#VUELTA_TRANSPORTE',trim($datos['nombre_tras2'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#IDA_RUTA',trim($datos['ruta1'] ), $pie_contenido);
    $pie_contenido = str_replace('#VUELTA_RUTA',trim($datos['ruta2'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#IDA_SA_FECHA',trim($datos['fecha_sa1'] ), $pie_contenido);
    $pie_contenido = str_replace('#IDA_SA_HORA',trim($datos['hora_sa1'] ), $pie_contenido);  
    $pie_contenido = str_replace('#VUELTA_SA_FECHA',trim($datos['fecha_sa2'] ), $pie_contenido);
    $pie_contenido = str_replace('#VUELTA_SA_HORA',trim($datos['hora_sa2'] ), $pie_contenido);
    
    
 
    $pie_contenido = str_replace('#IDA_LLE_FECHA',trim($datos['fecha_sa11'] ), $pie_contenido);
    $pie_contenido = str_replace('#IDA_LLE_HORA',trim($datos['hora_sa11'] ), $pie_contenido);
    $pie_contenido = str_replace('#VUELTA_LLE_FECHA',trim($datos['fecha_sa22'] ), $pie_contenido);
    $pie_contenido = str_replace('#VUELTA_LLE_HORA',trim($datos['hora_sa22'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#CARGO_FUNCIONARIO',trim($datos['cargo'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#NOMBRE_BANCO',trim($datos['banco'] ), $pie_contenido);
    $pie_contenido = str_replace('#NUMERO_CUENTA',trim($datos['nro_cuenta'] ), $pie_contenido);
    $pie_contenido = str_replace('#TIPO_CUENTA',trim($datos['tipo_cuenta'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#SOLICITUD',trim($datos['documento'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#REVISADO_FUNCIONARIO',trim($datos['revisado'] ), $pie_contenido);
    $pie_contenido = str_replace('#AUTORIZADO_FUNCIONARIO',trim($datos['autorizado'] ), $pie_contenido);
 
   
    
    $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(17,true));
    $pie_contenido = str_replace('#TALENTOHUMANO',trim($a10['carpeta']), $pie_contenido);
     
    
    
    
    echo $pie_contenido ;
    
}
/*
 aval de pac
 */
	
function aval_pac($cliente, $id,$seg  ){
    
    
    //------------- llama a la tabla de parametros ---------------------//
    
    $reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
    
    $pie_contenido = $reporte_pie["pie"];
    
    
    $datos_tarea   = $this->bd->query_array('planificacion.view_tarea_poa', '*', 'idtarea='.$this->bd->sqlvalue_inyeccion( $id,true) );
    
    $enlace_pac =  $datos_tarea['enlace_pac'];
	
    $datos_ejecuta   = $this->bd->query_array('planificacion.sitarea_seg', '*', 'idtarea_seg='.$this->bd->sqlvalue_inyeccion( $seg,true) );
 
	$datos_pac       = $this->bd->query_array('adm.adm_pac', '*', 'id_pac='.$this->bd->sqlvalue_inyeccion( $enlace_pac,true) );
	 
	
	$referencia =  $id.'-'.$seg;
	
	$descripcion =  $datos_pac['detalle'] .' CPC '.$datos_pac['cpc']; 
	
	$partida = $datos_pac['partida'] ;
	$TOTAL   = $datos_pac['total'] ;
		
	$fecha_completa =  $this->bd->_fecha_completa($datos_ejecuta['fecha_adm'] );
	$fecha_ultima   =  $this->bd->_fecha_completa($datos_ejecuta['fecha_ultima'] );
	
 	
 		
	$pie_contenido = str_replace('#DESCRIPCION',trim($descripcion), $pie_contenido);
	
	$pie_contenido = str_replace('#PARTIDA',trim($partida), $pie_contenido);
	
	$pie_contenido = str_replace('#PROCEDIMIENTO',trim($datos_pac['procedimiento'] ), $pie_contenido);
	
	$TOTAL=  number_format($TOTAL,2) ;
	
	$pie_contenido = str_replace('#TOTAL',trim($TOTAL), $pie_contenido);
	
	
	$pie_contenido = str_replace('#DOCUMENTO',trim($datos_ejecuta['documento_adm'] ), $pie_contenido);
	$pie_contenido = str_replace('#FECHA',$fecha_completa, $pie_contenido);
	
	$pie_contenido = str_replace('#REFERENCIA',$referencia, $pie_contenido);
	
	
	$pie_contenido = str_replace('#EMITEFECHA',$fecha_ultima, $pie_contenido);
	
 	
	$pie_contenido = str_replace('#TRANSACCION',trim($datos_ejecuta['seg_secuencia'] ), $pie_contenido);
		
	$referencia     = $datos_pac['c1'].' '.$datos_pac['c2'].' '.$datos_pac['c3'].' '.$datos_pac['c4'];
	
	$pie_contenido  = str_replace('#CUATRIMESTRE',$referencia, $pie_contenido);
	
	 
 
	
	$sesion = trim($_SESSION['email']);
	
    $usuarios = $this->bd->__user(trim($sesion)); // nombre del usuario actual
	
 	
	$id_departamento = $usuarios['id_departamento'];
	
    $adirector   = $this->bd->query_array('view_nomina_user', 'completo ,cargo,unidad ',
					   'director='.$this->bd->sqlvalue_inyeccion( 'S',true). ' and 
					   id_departamento='.$this->bd->sqlvalue_inyeccion( $id_departamento,true)
					   );
 
 
		
   $responsable_dato = $adirector['completo'].'<br>'.$adirector['cargo'].'<br>'.$adirector['unidad'];
	
  $pie_contenido = str_replace('#DIRECTOR_UNIDAD',$responsable_dato, $pie_contenido);
 
	
	//-----------------
    $pie_contenido = str_replace('#SOLICITADO',$responsable_dato, $pie_contenido);
	
 
    echo $pie_contenido ;
    
}
//----------------
function aval_poa($cliente, $id,$seg  ){
    
    
    //------------- llama a la tabla de parametros ---------------------//
    
    $reporte_pie     = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
    
    $datos_tarea     = $this->bd->query_array('planificacion.view_tarea_poa', '*', 'idtarea='.$this->bd->sqlvalue_inyeccion( $id,true) );
    
    $datos_ejecuta   = $this->bd->query_array('planificacion.sitarea_seg', '*', 'idtarea_seg='.$this->bd->sqlvalue_inyeccion( $seg,true) );
     
    $datos_oo        = $this->bd->query_array('planificacion.view_actividad_poa', '*', 'idobjetivo='.$this->bd->sqlvalue_inyeccion( $datos_tarea['idobjetivo'],true) );
     
    $usuarios        = $this->bd->__user(trim($datos_tarea['sesion']));  
    
    $id_departamento = $usuarios['id_departamento'];
    
    $adirector   = $this->bd->query_array('view_nomina_user', '*','director='.$this->bd->sqlvalue_inyeccion( 'S',true). ' and
                   id_departamento='.$this->bd->sqlvalue_inyeccion( $id_departamento,true)  );
    
    
    
    $pie_contenido      =  $reporte_pie["pie"];
    
    $actividad          =  trim($datos_tarea['actividad_poa']) .' / '.trim($datos_tarea['tarea']);
    
    $item               =  trim($datos_tarea['actividad']) .'  - '.trim($datos_tarea['clasificador']). ' <br>'.trim($datos_tarea['item_presupuestario']);
    
    $fecha_completa     =  $this->bd->_fecha_completa($datos_ejecuta['seg_fecha'] );
    
 
    $TOTAL              =  $datos_tarea['codificado'];
    $TOTAL              =  number_format($TOTAL,2) ;
    
    $solicitado         =  $datos_ejecuta['seg_solicitado'];
    $solicitado         =  number_format($solicitado,2) ;
    
    
    
    
    
    
    $pie_contenido = str_replace('#UNIDAD',trim($datos_tarea['unidad_poa'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#OBJETIVO',trim($datos_oo['objetivo'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#ACTIVIDAD',trim( $actividad ), $pie_contenido);
    
    $pie_contenido = str_replace('#FECHA_INICIO',trim( $fecha_completa ), $pie_contenido);
    
    $pie_contenido = str_replace('#RESPONSABLE',trim($usuarios['completo'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#ITEM',trim( $item ), $pie_contenido);
    
    $pie_contenido = str_replace('#CERTIFICADO',$TOTAL, $pie_contenido);
    
    $pie_contenido = str_replace('#MONTO_PIDE',$solicitado, $pie_contenido);
    
    $pie_contenido = str_replace('#JUSTIFICACION',trim($datos_ejecuta['seg_tarea_seg'] ), $pie_contenido);
    
    
    $pie_contenido = str_replace('#SOLICITA_FIR',trim($usuarios['completo'] ), $pie_contenido);
    
    
    $pie_contenido = str_replace('#FIRMA_UNI',trim($usuarios['unidad'] ), $pie_contenido);
    
    
 
    
    
    $responsable_dato = $adirector['completo'].'<br>'.$adirector['cargo'].'<br>'.$adirector['unidad'];
    
    $pie_contenido = str_replace('#DIRECTOR_UNIDAD',$responsable_dato, $pie_contenido);
    
    
    //-----------------
    $pie_contenido = str_replace('#SOLICITADO',$responsable_dato, $pie_contenido);
    
    
    echo $pie_contenido ;
    
}

//------------------------

function aval_repro($cliente, $id,$seg,$datos  ){
    
    
    //------------- llama a la tabla de parametros ---------------------//
    
    $reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($cliente) ,true) );
    
    $pie_contenido = $reporte_pie["pie"];
    
    
    $datos_tarea   = $this->bd->query_array('planificacion.view_tarea_poa', '*', 'idtarea='.$this->bd->sqlvalue_inyeccion( $id,true) );
    
    
    $fecha_completa =  $this->bd->_fecha_completa($datos['fecha'] );
    
    $pie_contenido = str_replace('#NSOLICITUD',trim($datos['comprobante'] ), $pie_contenido);
    $pie_contenido = str_replace('#UNIDAD',trim($datos['unidad'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#ANIO',trim($datos['anio'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#FECHAEMISION',trim( $fecha_completa), $pie_contenido);
    
    $pie_contenido = str_replace('#PROGRAMA',trim($datos_tarea['actividad'] ), $pie_contenido);
    
    
    $pie_contenido = str_replace('#ACTIVIDAD',trim($datos_tarea['actividad_poa'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#TAREA',trim($datos_tarea['tarea'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#ITEM',trim($datos_tarea['clasificador'] ), $pie_contenido);
    
    $pie_contenido = str_replace('#PRESUPUESTARIA',trim($datos_tarea['item_presupuestario'] ), $pie_contenido);
    
    
    $pie_contenido = str_replace('#JUSTIFICACION',trim($datos['detalle'] ), $pie_contenido);
    
    
    $pie_contenido = str_replace('#RTAREA',trim($datos['funcionario'] ), $pie_contenido);
    
    
    /*
    $enlace_pac =  $datos_tarea['enlace_pac'];
    
    $datos_ejecuta   = $this->bd->query_array('planificacion.sitarea_seg', '*', 'idtarea_seg='.$this->bd->sqlvalue_inyeccion( $seg,true) );
    
    $datos_pac       = $this->bd->query_array('adm.adm_pac', '*', 'id_pac='.$this->bd->sqlvalue_inyeccion( $enlace_pac,true) );
    
    
    $referencia =  $id.'-'.$seg;
    
    $descripcion =  $datos_pac['detalle'] .' CPC '.$datos_pac['cpc'];
    
    $partida = $datos_pac['partida'] ;
    $TOTAL   = $datos_pac['total'] ;
    
    $fecha_completa =  $this->bd->_fecha_completa($datos_ejecuta['fecha_adm'] );
    $fecha_ultima   =  $this->bd->_fecha_completa($datos_ejecuta['fecha_ultima'] );
    
    
    
    $pie_contenido = str_replace('#DESCRIPCION',trim($descripcion), $pie_contenido);
    
    $pie_contenido = str_replace('#PARTIDA',trim($partida), $pie_contenido);
    
    $pie_contenido = str_replace('#PROCEDIMIENTO',trim($datos_pac['procedimiento'] ), $pie_contenido);
    
    $TOTAL=  number_format($TOTAL,2) ;
    
    $pie_contenido = str_replace('#TOTAL',trim($TOTAL), $pie_contenido);
    
    
    $pie_contenido = str_replace('#DOCUMENTO',trim($datos_ejecuta['documento_adm'] ), $pie_contenido);
    $pie_contenido = str_replace('#FECHA',$fecha_completa, $pie_contenido);
    
    $pie_contenido = str_replace('#REFERENCIA',$referencia, $pie_contenido);
    
    
    $pie_contenido = str_replace('#EMITEFECHA',$fecha_ultima, $pie_contenido);
    
    
    $pie_contenido = str_replace('#TRANSACCION',trim($datos_ejecuta['seg_secuencia'] ), $pie_contenido);
    
    $referencia     = $datos_pac['c1'].' '.$datos_pac['c2'].' '.$datos_pac['c3'].' '.$datos_pac['c4'];
    
    $pie_contenido  = str_replace('#CUATRIMESTRE',$referencia, $pie_contenido);
    
    
    
    
    $sesion = trim($_SESSION['email']);
    
    $usuarios = $this->bd->__user(trim($sesion)); // nombre del usuario actual
    
    
    $id_departamento = $usuarios['id_departamento'];
    
    $adirector   = $this->bd->query_array('view_nomina_user', 'completo ,cargo,unidad ',
        'director='.$this->bd->sqlvalue_inyeccion( 'S',true). ' and
					   id_departamento='.$this->bd->sqlvalue_inyeccion( $id_departamento,true)
        );
    
    
    
    $responsable_dato = $adirector['completo'].'<br>'.$adirector['cargo'].'<br>'.$adirector['unidad'];
    
    $pie_contenido = str_replace('#DIRECTOR_UNIDAD',$responsable_dato, $pie_contenido);
    
    
    //-----------------
    $pie_contenido = str_replace('#SOLICITADO',$responsable_dato, $pie_contenido);
    
    */
    echo $pie_contenido ;
    
}
	
}

 

?>