<?php

session_start( );

require '../../kconfig/Db.class.php';
 require '../../kconfig/Obj.conf.php';

class ReportePdf{

	public $obj ;
	public $bd ;
	public $ruc;
	public $Registro;

	//Constructor de la clase
	function ReportePdf(){
		//inicializamos la clase para conectarnos a la bd
		$this->obj     = 	new objects;
		$this->bd     = 	new Db;
	
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

		$this->ruc       =  $_SESSION['ruc_registro'];
		
	}
 
	//------------------------------------
	function CabAsiento($asiento){
		
		//--- beneficiario
		$sqlB = "select a.idprov ,a.debe,a.haber,a.cheque,a.tipo,b.cuenta,b.tipo_cuenta,b.tipo
			       from co_asiento_aux a, co_plan_ctas b
				  where a.cuenta = b.cuenta and b.tipo_cuenta = 'B' AND
				  		   a.id_asiento =".$this->bd->sqlvalue_inyeccion($asiento,true)."   limit 1";
		 
		
		$resultadoB = $this->bd->ejecutar($sqlB);
		
		$datosB         =$this->bd->obtener_array( $resultadoB); 
		
		
		if ($datosB['debe']  > 0 ){
			$tipo_mov = 'COMPROBANTE DE INGRESO';
		}	
		else{
			$tipo_mov = 'COMPROBANTE DE EGRESO';
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
		
		$datos['cheque'] = $datosB['cheque'];  
		$datos['tipo']   = $datosB['tipo'];  
		$datos['pagado'] = $datosB['debe'] +  $datosB['haber'];  
		 
		$datos['tipoc']   = $tipo_mov;  
		
		return $datos;
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
		
		$sql = "SELECT razon
				FROM web_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$datos = $this->bd->obtener_array( $resultado);

		return $datos['razon'];
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
}

?>