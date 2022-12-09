
<?php session_start( );   

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	global $bd;
	global $obj;
	global $datos;
	global $formulario;
    $obj   = 	new objects;
	$bd	   =	Db::getInstance();
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 	//damos salida a la tabla
	 $id =	$_SESSION['ruc_registro'];
	 $sql = "SELECT *
 	  FROM web_registro  where ruc_registro =".$bd->sqlvalue_inyeccion($id ,true);
  	
     $resultado = $bd->ejecutar($sql);
  	 $datos = $bd->obtener_array( $resultado);	
 
 # Cargamos la librería dompdf.
  
$html='
<table width="800" border="0" cellpadding="0" cellspacing="0">
   <tr><td class="titulo">'.$_SESSION['razon'].'</td><td>&nbsp;</td>
    </tr><tr>
      <td class="label2">RUC: '.$_SESSION['ruc_registro'].'</td><td>&nbsp;</td>
    </tr> <tr>
      <td class="label2">Dirección: '.$datos['direccion'].'</td><td>&nbsp;</td>
    </tr><tr>
      <td class="label2">Telefono: '.$datos['telefono'].' Email : '.$datos['correo'].'</td><td class="label1">&nbsp; </td>
    </tr>
  </table> ';

  $idasiento		= $_GET['a'];
 	//////////////////////////
	  $sql = "SELECT *
	  FROM view_acf_acta  where id_acta = ".$bd->sqlvalue_inyeccion($idasiento ,true);
  	
 
     $resultado = $bd->ejecutar($sql);
   $datos = $bd->obtener_array( $resultado); 
 
 


 $html_comprobante ='
 <div class="borde">
 <table width="800" border="0" cellpadding="0" cellspacing="1" class="label1"  >
     <tr>
      <td colspan="4" align="center" class="subtitulo" >ACTA ENTREGA RECEPCIÓN </td>
    </tr>
    <tr>
      <td width="106">&nbsp;</td><td width="427">&nbsp;</td><td width="122" align="right">Nro.Acta Recepción</td>
      <td width="125" align="left" class="label3">'.$datos['id_acta'].'</td>
    </tr>
    <tr>
      <td align="right" >Responsable</td><td align="left" class="label3">'.$datos['razon'].'</td>
      <td align="right" >Aprobacion</td><td align="left" class="label3">'.$datos['fecha'].'</td>
    </tr>
   <tr>
      <td align="right" >Nro.identificación</td><td align="left" class="label3">'.$datos['idprov'].'</td>
      <td align="right" >Fecha</td><td align="left" class="label3">'.$datos['fecha'].'</td>
    </tr>
    <tr>
      <td align="right" >Correo Electrónico</td><td align="left" class="label3">'.$datos['correo'].'</td>
      <td align="right" >Ubicación</td><td align="left" class="label3">'.$datos['direccion'].'</td>
    </tr>
    <tr>
      <td align="right" >Detalle</td><td colspan="3" align="left" class="label3">'.$datos['novedad'].'</td>
    </tr>
  </table>
 </div>';
 
   $sql = 'SELECT  a.idactivo as "Nro Activo", a.nombre as "Identificación",a.serie as "Nro.Serie",a.detalle as "Novedad", a.costo as "Costo"
			  FROM view_acf_catalogo a, acf_acta_biend b
			  where a.idactivo = b.idactivo and id_acta ='.$bd->sqlvalue_inyeccion($idasiento ,true);
			  
 
	
    $resultado  = $bd->ejecutar($sql);
    $tipo 		= $bd->retorna_tipo();
    $html_detalle = $obj->grid->KP_GRID_REPORTE($resultado,$tipo,4,'Costo','','',''); 
	
    

 $html_pie ='	
     <p>&nbsp;</p>
	 <p>&nbsp;</p>
     <p>&nbsp;</p>
	<table >
     <tr>
      <td align="center" valign="top" class="bordep">Elaborado</td>
      <td align="center" valign="top" class="bordep">Entrega</td>
      <td align="center" valign="top" class="bordep">Recepción
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  </td>
   </tr>
  </table>';
  
	  
include("../../pdf/mpdf.php");

$mpdf=new mPDF('c','A4','',''); 

$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
 // LOAD a stylesheet
$stylesheet = file_get_contents('impresion.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html,2);
$mpdf->WriteHTML($html_comprobante);
$mpdf->WriteHTML($html_detalle);
 $mpdf->WriteHTML($html_pie); 
 
$mpdf->Output('acta_entrega.pdf','I');
exit; 

  ?> 
