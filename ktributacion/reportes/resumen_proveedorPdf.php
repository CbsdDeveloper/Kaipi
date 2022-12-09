<?php

session_start( );

require '../../kconfig/Db.class.php';
 require '../../kconfig/Obj.conf.php';

class ReportePdf{

	public $obj ;
	public $bd ;

	//Constructor de la clase
	function ReportePdf(){
		//inicializamos la clase para conectarnos a la bd
		$this->obj     = 	new objects;
		$this->bd     = 	new Db;
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

	}
	/*
	*/
	function Grilladetalle_Proveedor_id($anio,$mes,$id){

	    
	    
	    
		$sql_maestro = " SELECT idprov, razon
					FROM view_anexos_compras 
					WHERE  mes = ".$this->bd->sqlvalue_inyeccion($mes,true)." AND 
						   idprov = ".$this->bd->sqlvalue_inyeccion($id,true)." AND 
                           anio = ".$this->bd->sqlvalue_inyeccion($anio,true)."
					GROUP BY   idprov, razon
					ORDER BY razon";
		
 
		
		
		$resultado  = $this->bd->ejecutar($sql_maestro);
		
		
		$estiloTabla = '    ';
		$estilo           = ' class="titulo"    ';

		$html='<table   '.$estiloTabla.'><tr><th width="100%" '.$col1.' align="left">PROVEEDOR</th></tr>';

		echo $html;
		 
		$valor1 = 0;
		$valor2 = 0;
		 
		while($row1=pg_fetch_assoc($resultado)) {
			$col1 = ' bgcolor="#ddd" ';
			echo '<tr>';
			echo '<th width="100%" '.$estilo .$col1.'>'.$row1["idprov"].' - '.$row1["razon"].'</th>';
			echo  "</tr> ";
			echo  "<tr>";
			echo  "<th width='100%' .".$estilo .">";
			$this->GrillaResumenRentasDetalle($row1["idprov"],$mes,$anio);
			echo  "</th></tr>";

		}
		echo "</table>";
			
	 
	}
 
	//------------------------------------GrillaResumenProveedor_id
	function GrillaResumenProveedor($anio,$mes){

	    
	    
	    
		$sql = "SELECT idprov, razon
					FROM view_anexos_compras 
					WHERE  mes = ".$this->bd->sqlvalue_inyeccion($mes,true).' AND 
                           anio = '.$this->bd->sqlvalue_inyeccion($anio,true)."
					GROUP BY   idprov, razon
					ORDER BY razon";
		
   
		
		$resultado_01  = $this->bd->ejecutar($sql);
		
		
		$estiloTabla = '    ';
		$estilo           = ' class="titulo"    ';

		$html='<table   '.$estiloTabla.'><tr><th width="100%" '.$col1.' align="left">PROVEEDOR</th></tr>';

		echo $html;
		 
		$valor1 = 0;
		$valor2 = 0;
		 
		while($row1=pg_fetch_assoc($resultado_01)) {
			$col1 = ' bgcolor="#ddd" ';
			echo '<tr>';
			echo '<th width="100%" '.$estilo .$col1.'>'.$row1["idprov"].' - '.$row1["razon"].'</th>';
			echo  "</tr> ";
			echo  "<tr>";
			echo  "<th width='100%' .".$estilo .">";
			$this->GrillaResumenRentasDetalle(trim($row1["idprov"]),$mes,$anio);
			echo  "</th></tr>";

		}
		echo "</table>";
			
	 
	}
	//--- resumen IR
	function GrillaResumenRentasDetalle($codigo,$mes,$anio){

		
	    $ruc       =  trim($_SESSION['ruc_registro']);
	    
		
		$sql_detalle = "SELECT fecharegistro AS fecha,
		  					   secuencial as factura,
								fechaemision as emision,
								autorizacion, 
                                detalle, 
 								baseimponible,
                                baseimpgrav,
								montoiva,
								id_compras,
								coalesce( valorretbienes,0)  + coalesce( valorretservicios,0) + coalesce(valretserv100,0)   as iva_retencion
							FROM view_anexos_compras  
							WHERE mes = ".$this->bd->sqlvalue_inyeccion($mes,true)." AND 
								  estado= ".$this->bd->sqlvalue_inyeccion('S',true).' AND 
                                  registro = '.$this->bd->sqlvalue_inyeccion($ruc,true).' AND 
								  anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' AND
							      idprov = '.$this->bd->sqlvalue_inyeccion($codigo,true).'
							ORDER BY fecharegistro';


						 

		$stmt_detalle = $this->bd->ejecutar($sql_detalle);

		$estiloTabla = '    ';
		$estilo           = 'class="datos" ';

			
		echo  '<table  ' .$estiloTabla.'>
				  <tr>
			        <th width="10%" '.$estilo.' align="center">Fecha</th>
					<th width="10%" '.$estilo.' align="center">Factura</th>
					<th width="10%" '.$estilo.' align="center">Emision</th>
					<th width="20%" '.$estilo.' align="center">Detalle</th>
					<th width="10%" '.$estilo.' align="center">Base 0%</th>
	                <th width="10%" '.$estilo.' align="center">Base 12%</th>
					<th width="10%" '.$estilo.' align="center">Monto IVA</th>
					<th width="10%" '.$estilo.' align="center">Ret.IVA</th>
					<th width="10%" '.$estilo.' align="center">Ret.Fuente</th>
 				  </tr>';

		$valor1 = 0;
		$valor2 = 0;
		$valor3 = 0;
		$valor4 = 0;
		$valor5 = 0;
		$valor6 = 0;
 		 
		while($row=pg_fetch_assoc($stmt_detalle)) {

			$xx = $this->bd->query_array('view_anexos_fuente',   // TABLA
			' coalesce(sum(valretair),0) as retencion',                      
			'id_compras='.$this->bd->sqlvalue_inyeccion($row['id_compras'],true) 
			);

			echo  '<tr>
					    <td width="10%" '.$estilo.'  align="left">'.$row["fecha"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["factura"].'</td> 
					    <td width="10%" '.$estilo.'  align="left">'.$row["emision"].'</td>
						<td width="20%" '.$estilo.'  align="left">'.$row["detalle"].'</td> 
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["baseimponible"], 2, ',', '.').'</td>	  	
				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["baseimpgrav"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["montoiva"], 2, ',', '.').'</td>   	
						<td width="10%" '.$estilo.'  align="right">'.number_format($row["iva_retencion"], 2, ',', '.').'</td> 
						<td width="10%" '.$estilo.'  align="right">'.number_format($xx["retencion"], 2, ',', '.').'</td> ';  	
 			echo  "</tr>";
			
			 
			
			$valor1 = $valor1 + $row["basenograiva"];
			$valor2 = $valor2 + $row["baseimponible"];
			$valor3 = $valor3 + $row["baseimpgrav"];
			$valor4 = $valor4 + $row["montoiva"];

			$valor5 = $valor5  + $row["iva_retencion"];
			$valor6 = $valor6  + $xx["retencion"];

 		}
		 
		echo '<tr>
				<td width="10%"></td>
				<td width="10%"></td>
				<td width="10%"></td>
				<td width="20%"></td>
  				<td width="10%" align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
				<td width="10%" align="right"><b>'.number_format($valor3, 2, ',', '.').'</b></td>
				<td width="10%" align="right"><b>'.number_format($valor4, 2, ',', '.').'</b></td>
				<td width="10%" align="right"><b>'.number_format($valor5, 2, ',', '.').'</b></td>
				<td width="10%" align="right"><b>'.number_format($valor6, 2, ',', '.').'</b></td>';
 		echo "</tr>";
		echo  "</table>";

	 


	}
	//---
	function Empresa( ){

 

		return $_SESSION['razon'];
	}

}

?>