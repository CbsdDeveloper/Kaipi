 <?php
 
    session_start( );   

	require_once '../lib/dompdf/dompdf_config.inc.php';


	  if (isset($_GET["ac12d2"]))	{

		 $codigo 	 = $_GET["ac12d2"];
 	
		 $dompdf = new DOMPDF();
 
	
		$dompdf->load_html( file_get_contents( 'http://190.152.220.237/gestiona/kadmin/reportes/reporte_certificacion.php?codigo='.$codigo  ) );

		//  portrait   landscape

		$dompdf->render();

		// $dompdf->setPaper('A4', 'portrait');

		$dompdf->stream("solicitud.pdf", array("Attachment" => false));
	
		//   $dompdf->stream("mi_archivo.pdf");
		  

	   }
 
	
?>