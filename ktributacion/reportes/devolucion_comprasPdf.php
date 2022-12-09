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
 
  
//--- resumen IR
	function GrillaIva($anio,$mes){
	
	    $cadena  =' ';
		 
		$sql = 'SELECT  V.fechaemision AS "Emision",
		                    V.idprov '.$cadena.' as "Identificacion",
		                    V.razon as "Contribuyente",
		                    V.comprobante as "Comprobante",
		                    V.secuencial '.$cadena.' as "Factura",
		                    V.establecimiento  ||   puntoemision as "Serie",
		                    V.autorizacion '.$cadena.' as "Autorizacion",
		                    V.baseimpgrav as "base",
		                    V.montoiva as "iva"
		                    FROM view_anexos_compras V
		                    WHERE  V.mes= '.$this->bd->sqlvalue_inyeccion($mes,true).' AND 
                                   V.estado= '.$this->bd->sqlvalue_inyeccion('S',true).' AND
                                   V.registro= '.$this->bd->sqlvalue_inyeccion( $_SESSION['ruc_registro'],true).' AND 
                                   V.anio = '.$this->bd->sqlvalue_inyeccion($anio,true);
		 
		 
		 
		
		
		$resultado  = $this->bd->ejecutar($sql);
  	
 
  	   
		$estilo           = 'class="etiqueta" ';
 
			
  	   $html='<table>
 			  <tr>
      			<th width="2%" '.$estilo.' align="center">Nro.</th>
				<th width="5%" '.$estilo.' align="center">Emision</th>
				<th width="6%" '.$estilo.' align="center">Identificacion</th>
				<th width=" 34%" '.$estilo.' align="center">Contribuyente</th>
				<th width="7%" '.$estilo.' align="center">Comprobante</th>
				<th width="6%" '.$estilo.' align="center">Factura</th>
				<th width="4%" '.$estilo.' align="center">Serie</th>
				<th width="23%" '.$estilo.' align="center">Autorizacion</th>
				<th width="6%" '.$estilo.' align="center">Base Imponible</th>
				<th width="6%" '.$estilo.' align="center">Monto IVA</th>
			  </tr>  ';
  	   
  	  echo $html;
  	  
  	   $valor1 = 0;
  	   $valor2 = 0;
  	   $i = 1;
  	   while ($row=$this->bd->Arrayfila($resultado)) {
    
  	   	$estilo           = 'class="datos" ';
  	   	
 	    $contribuyente = $this->sanear_string(ltrim(rtrim( ($row["2"])))); 
		   // $row["Autorizacion"]
		   // utf8_decode($row["Identificacion"]) $row["Factura"]
		   
		   $ide =  $row["1"];
		   $fac =  $row["4"];
		   $auto = $row["6"];
		   
  	    echo  '<tr>
      			<td width="2%" '.$estilo.' align="center">'.$i.'</td>
			    <td width="7%" '.$estilo.' >'.$row["0"].'</td>
				<td width="6%" '.$estilo.'>'.$ide.'</td>
				<td width="32%" '.$estilo.' >'.$contribuyente.'</td>
				<td width="7%" '.$estilo,'>'.$row["3"].'</td>
				<td width="6%" '.$estilo.' >'.$fac.'</td>
				<td width="4%" '.$estilo.'>'.$row["5"].'</td>
				<td width="23%" '.$estilo.' >'.$auto.'</td>
				<td width="6%"   '.$estilo.' align="right">'.number_format($row["7"], 2, ',', '.').'</td>
				<td width="6%"  '.$estilo.'  align="right">'.number_format($row["8"], 2, ',', '.').'</td>';
  	  echo  "</tr>";
  	   
  	   	$valor1 = $valor1 + $row["7"];
  	   	$valor2 = $valor2 + $row[ "8"];
  	   	$i++;
  	   }
   
  	   
  	   echo '<tr>
      			<td></td>
			    <td></td>
				<td> </td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td '.$estilo.' align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td  '.$estilo.' align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>';
  	   
  	   echo "</tr>";
  	   echo  "</table>";
  	    
 
 }	
 //---------------
 function GrillaIvaResumen($anio,$mes){
     
     
     $sql = 'SELECT  
		                    V.comprobante as "Comprobante",
                            sum(baseimponible) as basetarifa0,
 		                    sum(V.baseimpgrav) as "base",
		                    sum(V.montoiva) as "iva",
                            count(*) as registros
		                    FROM view_anexos_compras V
		                    WHERE  V.mes= '.$this->bd->sqlvalue_inyeccion($mes,true).' AND
                                   V.estado= '.$this->bd->sqlvalue_inyeccion('S',true).' AND
                                   V.registro= '.$this->bd->sqlvalue_inyeccion( $_SESSION['ruc_registro'],true).' AND
                                   V.anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' group by V.comprobante' ;
     
     $resultado  = $this->bd->ejecutar($sql);
     
      
     
     $estilo           = 'class="etiqueta" ';
     
     
     $html='<table>
 			  <tr>
 				<th width="60%" '.$estilo.' align="center">Comprobante</th>
 				<th width="10%" '.$estilo.' align="center">Nro.Registros</th>
 				<th width="10%" '.$estilo.' align="center">Base Tarifa 0</th>
				<th width="10%" '.$estilo.' align="center">Base Imponible</th>
				<th width="10%" '.$estilo.' align="center">Monto IVA</th>
  			  </tr>  ';
     
     echo $html;
     
     $valor1 = 0;
     $valor2 = 0;
     $valor3 =0;
     
     $i = 1;
     while ($row=$this->bd->Arrayfila($resultado)) {
         
         $estilo           = 'class="datos" ';
         
         $contribuyente = $this->sanear_string(ltrim(rtrim( ($row["0"]))));
         // $row["Autorizacion"]
         // utf8_decode($row["Identificacion"]) $row["Factura"]
         
         $ide =  $row["1"];
         $fac =  $row["2"];
         $auto = $row["3"];
         
         $con = $row["4"];
         echo  '<tr>
			    <td width="60%" '.$estilo.' >'.$contribuyente.'</td>
				<td width="10%" '.$estilo.'>'.$con.'</td>
 				<td width="10%"   '.$estilo.' align="right">'.number_format($ide, 2, ',', '.').'</td>
 				<td width="10%"   '.$estilo.' align="right">'.number_format($fac, 2, ',', '.').'</td>
				<td width="10%"  '.$estilo.'  align="right">'.number_format($auto, 2, ',', '.').'</td>';
         echo  "</tr>";
         
         $valor1 = $valor1 + $row["1"];
         $valor2 = $valor2 + $row[ "2"];
         $valor3 = $valor3 + $row[ "3"];
         $i++;
     }
     
     
     echo '<tr>
 				<td></td>
 				<td></td>
				<td '.$estilo.' align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td '.$estilo.' align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
				<td  '.$estilo.' align="right"><b>'.number_format($valor3, 2, ',', '.').'</b></td>';
     
     echo "</tr>";
     echo  "</table>";
     
     
     //--------------------V.codsustento
     
     $sql = 'SELECT
		                    V.codsustento as "Comprobante",
                            sum(baseimponible) as basetarifa0,
 		                    sum(V.baseimpgrav) as "base",
		                    sum(V.montoiva) as "iva",
                            count(*) as registros
		                    FROM view_anexos_compras V
		                    WHERE  V.mes= '.$this->bd->sqlvalue_inyeccion($mes,true).' AND
                                   V.estado= '.$this->bd->sqlvalue_inyeccion('S',true).' AND 
                                   V.registro= '.$this->bd->sqlvalue_inyeccion( $_SESSION['ruc_registro'],true).' AND
                                   V.anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' group by V.codsustento' ;
     
     $resultado1  = $this->bd->ejecutar($sql);
     
     
     $estilo           = 'class="etiqueta" ';
     
     
     $html='<table>
 			  <tr>
 				<th width="60%" '.$estilo.' align="center">Sustento Tributario</th>
 				<th width="10%" '.$estilo.' align="center">Nro.Registros</th>
 				<th width="10%" '.$estilo.' align="center">Base Tarifa 0</th>
				<th width="10%" '.$estilo.' align="center">Base Imponible</th>
				<th width="10%" '.$estilo.' align="center">Monto IVA</th>
  			  </tr>  ';
     
     echo $html;
     
     $valor1 = 0;
     $valor2 = 0;
     $valor3 =0;
     
     $i = 1;
     while ($row=$this->bd->Arrayfila($resultado1)) {
         
         $estilo           = 'class="datos" ';
         
         $contribuyente = $this->sanear_string(ltrim(rtrim( ($row["0"]))));
         // $row["Autorizacion"]
         // utf8_decode($row["Identificacion"]) $row["Factura"]
         
         $x = $this->bd->query_array('co_catalogo','detalle', 
             'codigo='.$this->bd->sqlvalue_inyeccion($contribuyente,true).' and  
              tipo='.$this->bd->sqlvalue_inyeccion('Sustento del Comprobante',true)
              );
         
 
         $etiqueta =  trim($x["detalle"]);
         
         $etiqueta = utf8_encode( utf8_decode($etiqueta)) ;
           
         
         $ide =  $row["1"];
         $fac =  $row["2"];
         $auto = $row["3"];
         
         $con = $row["4"];
         echo  '<tr>
			    <td width="60%" '.$estilo.' >'.$contribuyente.'-'.$etiqueta.'</td>
				<td width="10%" '.$estilo.'>'.$con.'</td>
 				<td width="10%"   '.$estilo.' align="right">'.number_format($ide, 2, ',', '.').'</td>
 				<td width="10%"   '.$estilo.' align="right">'.number_format($fac, 2, ',', '.').'</td>
				<td width="10%"  '.$estilo.'  align="right">'.number_format($auto, 2, ',', '.').'</td>';
         echo  "</tr>";
         
         $valor1 = $valor1 + $row["1"];
         $valor2 = $valor2 + $row[ "2"];
         $valor3 = $valor3 + $row[ "3"];
         $i++;
     }
     
     
     echo '<tr>
 				<td></td>
 				<td></td>
				<td '.$estilo.' align="right"><b>'.number_format($valor1, 2, ',', '.').'</b></td>
				<td '.$estilo.' align="right"><b>'.number_format($valor2, 2, ',', '.').'</b></td>
				<td  '.$estilo.' align="right"><b>'.number_format($valor3, 2, ',', '.').'</b></td>';
     
     echo "</tr>";
     echo  "</table>";
 }	
//---
	function Empresa( ){
		
		$sql = "SELECT razon
				FROM web_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion( $_SESSION['ruc_registro'],true);
	
	 
		$resultado = $this->bd->ejecutar($sql);
		
		$datos = $this->bd->obtener_array( $resultado);
		
		return $datos['razon'];
	}
	 
///-----------------------	 
	function sanear_string($string)
		{

			$string = trim($string);

			$string = str_replace(
				array('ÃƒÂ¡', 'ÃƒÂ ', 'ÃƒÂ¤', 'ÃƒÂ¢', 'Ã‚Âª', 'Ãƒï¿½', 'Ãƒâ‚¬', 'Ãƒâ€š', 'Ãƒâ€ž'),
				array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
				$string
			);

			$string = str_replace(
				array('ÃƒÂ©', 'ÃƒÂ¨', 'ÃƒÂ«', 'ÃƒÂª', 'Ãƒâ€°', 'ÃƒË†', 'ÃƒÅ ', 'Ãƒâ€¹'),
				array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
				$string
			);

			$string = str_replace(
				array('ÃƒÂ­', 'ÃƒÂ¬', 'ÃƒÂ¯', 'ÃƒÂ®', 'Ãƒï¿½', 'ÃƒÅ’', 'Ãƒï¿½', 'ÃƒÅ½'),
				array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
				$string
			);

			$string = str_replace(
				array('ÃƒÂ³', 'ÃƒÂ²', 'ÃƒÂ¶', 'ÃƒÂ´', 'Ãƒâ€œ', 'Ãƒâ€™', 'Ãƒâ€“', 'Ãƒâ€�'),
				array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
				$string
			);

			$string = str_replace(
				array('ÃƒÂº', 'ÃƒÂ¹', 'ÃƒÂ¼', 'ÃƒÂ»', 'ÃƒÅ¡', 'Ãƒâ„¢', 'Ãƒâ€º', 'ÃƒÅ“'),
				array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
				$string
			);

			$string = str_replace(
				array('ÃƒÂ±', 'Ãƒâ€˜', 'ÃƒÂ§', 'Ãƒâ€¡'),
				array('n', 'N', 'c', 'C',),
				$string
			);

			//Esta parte se encarga de eliminar cualquier caracter extraÃƒÂ±o
		/*	$string = str_replace(
				array("\",  
					 "#", "@", "|", "!", """,
					 "Ã‚Â·", "$", "%", "&", "/",
					 "(", ")", "?", "'", "Ã‚Â¡",
					 "Ã‚Â¿", "[", "^", "<code>", "]",
					 "+", "}", "{", "Ã‚Â¨", "Ã‚Â´",
					 ">", "< ", ";", ",", ":",
					 ".", " "),
				'',
				$string
			);
*/

			return $string;
		}
 }
 
?>