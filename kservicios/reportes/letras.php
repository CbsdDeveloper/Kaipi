<html>
<head>
  <style>
  @font-face {
    font-family: 'Elegance';
    font-style: normal;
    font-weight: bold;
    src: url("dompdf/lib/fonts/Courier-Bold.afm") format("truetype");
  }
  body {
    font-family: Elegance, sans-serif;
    font-weight: bold;
      src: url("dompdf/lib/fonts/Courier-Bold.afm") format("truetype");

  }
  </style>
</head>
<body>
  <div class="div">
    <p>hello world</p>
  

  </div>
  <div >
    <p>hello world</p>
  </div>

  
</body>
</html>

<?php 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


//$pdfOptions = new Options();
 
//$pdfOptions->set('defaultFont', 'Arial');

$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(  ob_get_clean())  ;

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador


 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>