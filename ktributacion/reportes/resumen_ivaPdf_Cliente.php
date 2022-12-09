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
           
          $ruc       =  $_SESSION['ruc_registro'];
          
          $sql_maestro = 'SELECT  sum(baseimpgrav) as base, sum(montoiva) as iva, sum(retencion) as rete,  porcentaje, ivaretencion
          FROM  view_anexos_iva
          where anio ='.$this->bd->sqlvalue_inyeccion($anio,true). ' and  
                mes  ='.$this->bd->sqlvalue_inyeccion($mes,true). ' and  
                registro  ='.$this->bd->sqlvalue_inyeccion($ruc,true). ' 
          group by porcentaje,ivaretencion';
          
           
          $resultado  = $this->bd->ejecutar($sql_maestro);
		
		$estiloTabla = '    ';
		$estilo           = ' class="titulo"    ';
		
		echo  '<table  ' .$estiloTabla.'>
				  <tr>
					<th width="60%" '.$estilo.' align="center">Retencion IVA Retenido</th>
					<th width="10%" '.$estilo.' align="center">Porcentaje</th>
					<th width="10%" '.$estilo.' align="center">Base Imponible</th>
					<th width="10%" '.$estilo.' align="center">Iva</th>
					<th width="10%" '.$estilo.' align="center">Monto Retenido</th>
 				  </tr>';
		
		$valor1 = 0;
		$valor2 = 0;
		
		while($row=pg_fetch_assoc($resultado)) {
		    echo  '<tr>
		   	 		    <td width="60%" '.$estilo.'  align="left">'.$row["ivaretencion"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["porcentaje"].'</td>
					    <td width="10%"  '.$estilo.'  align="right">'.$row["base"].'</td>
						<td width="10%" '.$estilo.'  align="right">'.$row["iva"].'</td>
						<td width="10%" '.$estilo.'  align="right">'.$row["rete"].'</td>';
 		    echo  "</tr>";
		    
		    $valor1 = $valor1 + $row["iva"];
		    $valor2 = $valor2 + $row["rete"];
		}
		
		echo  '<table>';
		echo '<h6> &nbsp; </h6>';
		
		return    1;
      }
      //------------------------------------
      ///----------------------------------
      function SqlGridProve( $anio,$mes){
          
          $ruc       =  $_SESSION['ruc_registro'];
          
          echo '<h6>  &nbsp;  </h6>';
          
          echo '<h6>GESTION TRIBUTARIA RESUMEN DE VENTAS </h6>';
          
 
          
 
          $sql_maestro = 'SELECT id_asiento, fechaemision,idcliente, razon,secuencial, basenograiva, baseimponible, baseimpgrav, 
                                   montoiva
           FROM  view_anexos_ventas
          where anio ='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                mes  ='.$this->bd->sqlvalue_inyeccion($mes,true). ' and
                registro  ='.$this->bd->sqlvalue_inyeccion($ruc,true). '
          order by   fechaemision asc,secuencial';
          
          
          $resultado  = $this->bd->ejecutar($sql_maestro);
          
          $estiloTabla = '    ';
          $estilo           = ' class="titulo"    ';
          
          echo  '<table  ' .$estiloTabla.'>
				  <tr>
					<th width="5%" '.$estilo.' align="center">Asiento</th>
					<th width="10%" '.$estilo.' align="center">Fecha</th>
					<th width="10%" '.$estilo.' align="center">Identificacion</th>
					<th width="25%" '.$estilo.' align="center">Cliente</th>
					<th width="10%" '.$estilo.' align="center">Factura</th>
                     <th width="10%" '.$estilo.' align="center">Base 0%</th>
                    <th width="10%" '.$estilo.' align="center">Base 12%</th>
                    <th width="10%" '.$estilo.' align="center">IVA</th>
                    <th width="10%" '.$estilo.' align="center">Total</th>
 				  </tr>';
          
          $valor1 = 0;
          $valor2 = 0;
          $valor3 = 0;
          $valor4 = 0;
          
         
            
          while($row=pg_fetch_assoc($resultado)) {
              
              $total = $row["baseimponible"] +  $row["baseimpgrav"] + $row["montoiva"];
              
              echo  '<tr>
		   	 		    <td width="5%" '.$estilo.'  align="left">'.$row["id_asiento"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["fechaemision"].'</td>
					    <td width="10%"  '.$estilo.'  align="left">'.$row["idcliente"].'</td>
						<td width="25%" '.$estilo.'  align="left">'.$row["razon"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["secuencial"].'</td> 
                         <td width="10%" '.$estilo.'  align="right">'.$row["baseimponible"].'</td> 
                        <td width="10%" '.$estilo.'  align="right">'.$row["baseimpgrav"].'</td>
                        <td width="10%" '.$estilo.'  align="right">'.$row["montoiva"].'</td>  
                        <td width="10%" '.$estilo.'  align="right">'.$total.'</td> ';
               echo  "</tr>";
              
              $valor1 = $valor1 + $row["baseimponible"];
              $valor2 = $valor2 + $row["baseimpgrav"];
              $valor3 = $valor3 + $row["montoiva"];
              $valor4 = $valor4 + $total;
          }
          
          echo  '<tr>
		   	 		    <td width="5%" '.$estilo.'  align="left"> </td>
						<td width="10%" '.$estilo.'  align="left"> </td>
					    <td width="10%"  '.$estilo.'  align="left"> </td>
						<td width="25%" '.$estilo.'  align="left"> </td>
						<td width="10%" '.$estilo.'  align="left"></td>
                         <td width="10%" '.$estilo.'  align="right">'.$valor1.'</td>
                        <td width="10%" '.$estilo.'  align="right">'.$valor2.'</td>
                        <td width="10%" '.$estilo.'  align="right">'.$valor3.'</td>
                        <td width="10%" '.$estilo.'  align="right">'.$valor4.'</td> ';
          echo  "</tr>";
          
          echo  '<table>';
          echo '<h6> &nbsp; </h6>';
          
          return    1;
      }
      //------------------------------------
      function SqlGridRenta( $anio,$mes){
          
          $ruc       =  $_SESSION['ruc_registro'];
          
          $sql_maestro = 'SELECT  codretair,tiporetencion, SUM(baseimpair) as base, SUM(valretair) as rete
          FROM  view_anexos_fuente
          where anio ='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                mes  ='.$this->bd->sqlvalue_inyeccion($mes,true). ' and
                registro  ='.$this->bd->sqlvalue_inyeccion($ruc,true). '
          group by codretair,tiporetencion';
          
 
          
          $resultado  = $this->bd->ejecutar($sql_maestro);
          
          $estiloTabla = '    ';
          $estilo           = ' class="titulo"    ';
          
          echo  '<table  ' .$estiloTabla.'>
				  <tr>
					<th width="70%" '.$estilo.' align="center">Retencion en la Fuente</th>
					<th width="10%" '.$estilo.' align="center">Codigo</th>
					<th width="10%" '.$estilo.' align="center">Base Imponible</th>
 					<th width="10%" '.$estilo.' align="center">Monto Retenido</th>
 				  </tr>';
          
          $valor1 = 0;
          $valor2 = 0;
          
          while($row=pg_fetch_assoc($resultado)) {
              echo  '<tr>
		   	 		    <td width="70%" '.$estilo.'  align="left">'.$row["tiporetencion"].'</td>
						<td width="10%" '.$estilo.'  align="left">'.$row["codretair"].'</td>
					    <td width="10%"  '.$estilo.'  align="right">'.$row["base"].'</td>
						<td width="10%" '.$estilo.'  align="right">'.$row["rete"].'</td>';
               echo  "</tr>";
              
              $valor1 = $valor1 + $row["base"];
              $valor2 = $valor2 + $row["rete"];
          }
          
          echo  '<table>';
          echo '<h6> &nbsp; </h6>';
          
          return    1;
      }
	//-----------------------
      function SqlGridMes( $anio,$mes){
          
          $ruc       =  $_SESSION['ruc_registro'];
          
          $sql_maestro = 'SELECT  mes,count(*) as nn, SUM(baseimponible) as base0, SUM(baseimpgrav) as base12,
                          SUM(montoiva) as iva
          FROM  view_anexos_ventas
          where anio ='.$this->bd->sqlvalue_inyeccion($anio,true). ' and
                 registro  ='.$this->bd->sqlvalue_inyeccion($ruc,true). '
          group by mes ORDER BY 1';
          
  
             
          
          $resultado  = $this->bd->ejecutar($sql_maestro);
          
          $estiloTabla = '    ';
          $estilo           = ' class="titulo"    ';
          
          echo  '<table  ' .$estiloTabla.'>
				  <tr>
					<th width="10%" '.$estilo.' align="center">Mes</th>
					<th width="30%" '.$estilo.' align="center">Detalle Mensual Ventas</th>
					<th width="20%" '.$estilo.' align="right">Nro.Facturas</th>
 					<th width="10%" '.$estilo.' align="right">Base 0%</th>
                    <th width="10%" '.$estilo.' align="right">Base 12%</th>
                    <th width="10%" '.$estilo.' align="right">Monto IVA</th>
                    <th width="10%" '.$estilo.' align="right">Total</th>
 				  </tr>';
          
          $valor1 = 0;
          $valor2 = 0;
          
          while($row=pg_fetch_assoc($resultado)) {
              
              $total = $row["base0"] +  $row["base12"] + $row["iva"];
              
              $mes = $this->bd->_mesc($row["mes"]) ;
              
              
              echo  '<tr>
		   	 		    <td width="10%" '.$estilo.'  align="center">'.$row["mes"].'</td>
						<td width="30%" '.$estilo.'  align="left">'.$mes.'</td>
                        <td width="20%" '.$estilo.'  align="right">'.$row["nn"].'</td>
                        <td width="10%" '.$estilo.'  align="right">'.$row["base0"].'</td>
                        <td width="10%" '.$estilo.'  align="right">'.$row["base12"].'</td>
					    <td width="10%"  '.$estilo.'  align="right">'.$row["iva"].'</td>
						<td width="10%" '.$estilo.'  align="right">'.$total.'</td>';
              echo  "</tr>";
              
              $valor1 = $valor1 + $row["base0"];
              $valor2 = $valor2 + $row["base12"];
          }
          
          echo  '<table>';
          echo '<h6> &nbsp; </h6>';
          
          return    1;
      }
	//---
	function Empresa( ){
		
	    return $_SESSION['razon'];
	}
	
 }
 
?>