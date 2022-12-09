<?php 
session_start( );  
ob_start(); 
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';
require '../../kconfig/convertir.php'; /*Incluimos el fichero de la clase objetos*/	
$obj     = 	new objects;
$bd     = 	new Db;


$id		= $_GET['a'];

 
$sql = 'SELECT a.fechap,a.idprov,a.haber,  b.razon
		FROM co_asiento_aux a, par_ciu b 
		where  a.idprov = b.idprov and a.id_asiento_aux='.$bd->sqlvalue_inyeccion($id,true);
	
     $resultado = $bd->ejecutar($sql);
  	 $datos = $bd->obtener_array( $resultado);
	
    $monto_imprime = 0;
	$monto_imprime = (float) $datos['haber'] ;
    $imprime = (convertir($monto_imprime)). ' dólares -----------------' ;	
?> 
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
</head>		
<body leftmargin="0">
   <table width="380" border="0" cellpadding="2" cellspacing="2" style="font-size: 9;font-weight: bold;font-family: Verdana, 'sans-serif'">
  <tbody>
    <tr>
      <td width="237"><?php echo trim($datos['razon']); ?></td>
      <td width="137"><?php echo $monto_imprime ?></td>
    </tr>
    <tr>
      <td><img src="b.jpg" width="1" height="14" alt=""/><?php echo trim($imprime); ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?php echo trim($_SESSION['ciudad']); ?>, <?php echo trim($datos['fechap']); ?></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</body>
</html>
<?php 
 
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
 
?>
