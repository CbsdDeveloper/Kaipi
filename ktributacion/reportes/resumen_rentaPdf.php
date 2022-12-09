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
      ///----------------------------------
      function SqlGrid( $anio,$mes){
           
         $sql_maestro = "SELECT  codretair AS codigo, tiporetencion as retencion,sum(baseimpair) as b1, sum(valretair) as v1
									FROM view_anexos_fuente
									WHERE  registro = ".$this->bd->sqlvalue_inyeccion( $_SESSION['ruc_registro'],true)."  and
										  		  mes = ".$this->bd->sqlvalue_inyeccion($mes,true).' AND 
										  		 anio = '.$this->bd->sqlvalue_inyeccion($anio,true).'
									GROUP BY codretair, tiporetencion
									ORDER BY codretair';
		   
 
		  
		  
		$resultado  = $this->bd->ejecutar($sql_maestro);
		      
		return    $resultado;
      }
      //------------------------------------
       function GrillaResumenRentas( $resultado,$anio,$mes){
		
       	$estiloTabla = '    ';
       	$estilo           = ' class="titulo"    ';
       	$col1 ='';
		
       	$html='<table   '.$estiloTabla.'><tr><th width="100%" '.$col1.' align="center">TIPO DE RETENCION</th></tr>';
	
       	echo $html;
		   
			  $valor1 = 0;
			  $valor2 = 0;
	  
			  while($row1=pg_fetch_assoc ($resultado)) {
			  	  $col1 = ' bgcolor="#ddd" ';
			  	  echo '<tr>';
			  	  echo '<th width="100%" '.$estilo .$col1.'>'.$row1["codigo"].' - '.$row1["retencion"].'</th>';
			  	  echo  "</tr> ";
			  	  echo  "<tr>";
			  	  echo  "<th width='100%' .".$estilo .">";		
										 $this->GrillaResumenRentasDetalle($row1["codigo"],$mes,$anio);
				  echo  "</th></tr>";		
				
				  $valor1 =  $valor1 + $row1["b1"] ;
				  $valor2 =  $valor2 + $row1["v1"] ;
			  }
			echo "</table>";
			
			echo '<h6>Base Retencion: '.number_format($valor1, 2, ',', '.').'<br>
                      Monto Retenido:'.number_format($valor2, 2, ',', '.').'  </h6>';
		 
			    
			 
}	
//--- resumen IR
	function GrillaResumenRentasDetalle($codigo,$mes,$anio){
		
	 	/* $fecha = "to_char(V.FECHA_CONTABLE,'DD/MM/RRRR') as FECHA";
	 
		  $sql_detalle = "SELECT ".$fecha.", 
		  						 V.IDENTIFICACION, 
								 V.NOMBRE_CIU,  
								 V.FACTURA,  
								 round(V.BASE_RETENCION,2) as BASE_RETENCION,
								 round(V.VALOR_RETENCION,2) as VALOR_RETENCION
				FROM V_ANEXOS_TIPO_RETENCION V
				WHERE V.CODIGO = ".$this->bd->sqlvalue_inyeccion($codigo,true)." AND 
					          V.TMES       = ".$this->bd->sqlvalue_inyeccion($mes,true).'  AND 
					          V.TANIO    = '.$this->bd->sqlvalue_inyeccion($anio,true).'
				ORDER BY V.FECHA_CONTABLE';
				*/
		
		  $sql_detalle = "SELECT id_compras, secuencial, codretair, baseimpair, porcentajeair, valretair, anio, mes, 
  tiporetencion ,secretencion1,id_tramite
			FROM  view_anexos_fuente
			WHERE codretair = ".$this->bd->sqlvalue_inyeccion($codigo,true)." AND 
			      mes       = ".$this->bd->sqlvalue_inyeccion($mes,true)."  AND 
				  registro  = ".$this->bd->sqlvalue_inyeccion( $_SESSION['ruc_registro'],true).'  AND 
				  anio    = '.$this->bd->sqlvalue_inyeccion($anio,true).'
				ORDER BY secretencion1 asc';
		
		  		
 		 $stmt_detalle = $this->bd->ejecutar($sql_detalle);
  
  	   $estiloTabla = '    ';
  	   $estilo           = 'class="datos" ';
 
			
		echo  '<table  ' .$estiloTabla.'>
				  <tr>
					<th width="10%" '.$estilo .' align="center">Fecha</th>
					<th width="10%" '.$estilo .' align="center">Identificacion</th>
					<th width="30%" '.$estilo .' align="center">Contribuyente</th>
                    <th width="10%" '.$estilo .' align="center">Tramite</th>
					<th width="10%" '.$estilo .' align="center">Factura</th>
					<th width="10%" '.$estilo .' align="center">Comprobante</th>
					<th width="10%" '.$estilo .' align="center">Base</th>
					<th width="10%" '.$estilo .' align="center">Retencion</th>
				  </tr>';
		  
 		  $valor1 = 0;
		  $valor2 = 0;
	  
 	  while($row=pg_fetch_assoc($stmt_detalle)) {
		  
		  
		  $ARow = $this->bd->query_array('view_anexos_compras',
											   	'idprov, razon, id_compras , fecharegistro ', 
											   'id_compras='.$this->bd->sqlvalue_inyeccion($row["id_compras"],true)
											  ); 
 
		  
		   	 echo  '<tr>
					    <td width="10%" '.$estilo.'  align="left">'.$ARow["fecharegistro"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$ARow["idprov"].'</td> 
					    <td width="30%" '.$estilo.'  align="left">'.$ARow["razon"].'</td>
                        <td width="10%" '.$estilo.'  align="left">'.$ARow["id_tramite"].'</td>
						<td width="10%"'.$estilo.'  align="left">'.$row["secuencial"].'</td>   
						<td width="10%"'.$estilo.'  align="left">'.$row["secretencion1"].'</td>   
				    	<td width="10%" '.$estilo.'  align="right">'.number_format($row["baseimpair"], 2, ',', '.').'</td>
						<td width="10%" '.$estilo.'  align="right">'. number_format($row["valretair"], 2, ',', '.') .'</td>';		  	
			   echo  "</tr>";		
		  
		  
				 
				  $valor1 = $valor1 + $row["baseimpair"];
				  $valor2 = $valor2 + $row["valretair"];	 
		  
		   
 		}
	 	
   		echo '<tr>
				<td width="10%" '.$estilo.' ></td>
				<td width="10%"'.$estilo.' ></td>
				<td width="30%" '.$estilo.' ></td>
                <td width="10%" '.$estilo.' ></td>
				<td width="10%" '.$estilo.' ></td>
				<td width="10%" '.$estilo.' ></td>
				<td width="10%" align="right" '.$estilo.' ><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td width="10%" align="right" '.$estilo.' ><b>'.number_format($valor2, 2, ',', '.').'</b></td>';
	  echo "</tr>";	
   echo  "</table>";
	
 	 
																
 	
	}	
	//---
	function Empresa( ){
		
		 
		
		return $_SESSION['razon'];
	}
	
 }
 
?>