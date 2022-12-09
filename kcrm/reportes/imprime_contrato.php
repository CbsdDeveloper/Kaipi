<?php 
session_start( );  
//ob_start(); 
require('kreportes.php'); 
 
$gestion   		= 	new ReportePdf; 	


$id 		    = trim($_GET['codigo']);
$cotiza 		= trim($_GET['cotiza']);
$idvengestion 	= trim($_GET['idvengestion']);
$version	 	= trim($_GET['version']);
$fversion	 	= trim($_GET['fversion']);

$datos 			= $gestion->Cotizacion_contrato($cotiza);

$datosx 		= $gestion->cliente_contrato(trim($datos['idprov']));

$fcontrato = $gestion->fecha_plazo($fversion);

$file = file_get_contents('contrato_01.htm'); //cargo el archivo

 //{cliente} {cedula} {telefono}  {direccion}  {detalle}  {precio}   {plazo} {dias}

$file = str_ireplace('{cedula}', trim($datos['idprov']), $file);   

$file = str_ireplace('{cliente}', trim($datos['razon']), $file);   
	
$file = str_ireplace('{fecha_contrato}', $fcontrato, $file);  

$file = str_ireplace('{telefono}', trim($datosx['telefono']), $file);  

$file = str_ireplace('{direccion}', trim($datosx['direccion']), $file);  

//$file = str_ireplace('{titulo}', $variableTitulo, $file);  

echo $file;

 

 
 /*
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A5', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(utf8_decode(ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 */
?>
