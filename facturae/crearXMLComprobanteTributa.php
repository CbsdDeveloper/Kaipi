<?php 
function xml_creacion( $bd,$data,$Array_Cabecera,$ADatos,$id,$ambiente,$estab,$ptoEmi,$comprobante){
require "RideSRI/libs/xml/XmlDoc.php" ;
$ruta     = dirname(__file__);
$carpeta = 'xml' ;
/* NOTA: Revisar q campos falta dependiendo del funcionamiento de la empresa, o agregar los opcionales en caso de ser necesarios */
$id = $Array_Cabecera['id_compras'];

// infoTributaria
$infoTrib=array(
        'ambiente' => 		$ambiente,
		'tipoEmision' => 	"1",
        'razonSocial' => 	trim($ADatos['razon']),
        'nombreComercial' =>trim($ADatos['razon']),
        'ruc' => 			$ADatos['ruc_registro'],
        'claveAcceso' => 	$data, 
		'codDoc' => 		"07",
        'estab' => 			$estab,
        'ptoEmi' => 		$ptoEmi,
        'secuencial' => 	$comprobante,
        'dirMatriz' => 		trim($ADatos['direccion'])
);

$detalle = 'Adquisicion compra referencia nro.'.$Array_Cabecera['secuencial'];

if (!empty($Array_Cabecera['detalle'])){
    $detalle = $detalle.' '.$Array_Cabecera['detalle'];
}

// infoAdicional
$resolucion = 'Segun la resolucion NAC-DNCRAS20-00000001';

$infoAdic=array(
    'campoAdicional'=>array( 
        array( '@attributes' => array('nombre' => "Email"), '@value' => $Array_Cabecera['correo']),
        array( '@attributes' => array('nombre' => "Agentes de retencion"), '@value' => $resolucion),
        array( '@attributes' => array('nombre' => "Observacion"), '@value' => $detalle)
	)
);
 
$sql_det = "select '1' as codigo, 
        	  codretair as  codigoretencion, 
        	  baseimpair  as baseimponible,
        	  round(porcentajeair,2)     as porcentajeretener,
        	  valretair as valorretenido,
        	  '01' as coddocsustento
        FROM  view_anexos_fuente
        where id_compras = ".$bd->sqlvalue_inyeccion($id, true)." 
        union
        SELECT '2' as codigo, 
        	  (porcentaje_iva::text) as  codigoretencion, 
        	  montoiva  as baseimponible,
        	    cast(porcentaje as int)as porcentajeretener,
        	  retencion as valorretenido,
        	  '01' as coddocsustento
        FROM  view_anexos_iva
        where id_compras = ".$bd->sqlvalue_inyeccion($id, true);

 
$stmt1              = $bd->ejecutar($sql_det);
///-------------------------------------
$trozos = explode("-", $Array_Cabecera['fechaemision'],3);

$anio = $trozos[0];
$mes =  $trozos[1];
$dia =  $trozos[2];

$fechaemision = $dia.'/'.$mes.'/'.$anio;
// infoFactura
$impuestos=array("impuesto"=>array());

while ($x=$bd->obtener_fila($stmt1)){
  
    $numDocSustento  = $Array_Cabecera['establecimiento'] .$Array_Cabecera['puntoemision'] .$Array_Cabecera['secuencial'] ;
       
  /*   $impuestos=array('impuesto'=>array(
        'codigo' => $x['codigo'],
        'codigoRetencion' => $x['codigoretencion'],
        'baseImponible' => round($x['baseimponible'],2),
        'porcentajeRetener' => round($x['porcentajeretener'],2),
        'valorRetenido' => round($x['valorretenido'],2),
        'codDocSustento' =>  $x['coddocsustento'] ,
        'numDocSustento' => $numDocSustento ,
        'fechaEmisionDocSustento' => $fechaemision
    ));
     */
 
    array_push($impuestos['impuesto'],array(
        'codigo' => $x['codigo'],
        'codigoRetencion' => $x['codigoretencion'],
        'baseImponible' => round($x['baseimponible'],2),
        'porcentajeRetener' => round($x['porcentajeretener'],2),
        'valorRetenido' => round($x['valorretenido'],2),
        'codDocSustento' =>  $x['coddocsustento'] ,
        'numDocSustento' => $numDocSustento ,
        'fechaEmisionDocSustento' => $fechaemision
    ));
 
 
}
 
///----------------------------------------------------
$idprov = trim( $Array_Cabecera['idprov'] );

$ncontador = strlen(trim($idprov));  // 01-RUC 05-cedula 06-pasaporte 07-consumidor final 08-identificacion exterior 09-placa
$tipoidentificacioncomprador = '06';

if ($ncontador == 10){
    $tipoidentificacioncomprador = '05';
}

if ($ncontador == 13){
    $tipoidentificacioncomprador = '04';
}

if ($idprov == '9999999999999'){
    
    $tipoidentificacioncomprador = '07';
}

if ($idprov== '9999999999'){
    
    $tipoidentificacioncomprador = '07';
    $idprov = '9999999999999';
}

//-----------------------------
 
$trozos = explode("-", $Array_Cabecera['fecharegistro'],3);

$anio = $trozos[0];
$mes =  $trozos[1];
$dia =  $trozos[2];

$fecha = $dia.'/'.$mes.'/'.$anio;

$periodoFiscal =  $mes.'/'.$anio;

$infoFact=array(
    'fechaEmision' => $fecha,
    'dirEstablecimiento' => $ADatos['direccion'],
    'obligadoContabilidad' => $ADatos['obligado'],
    'tipoIdentificacionSujetoRetenido' => $tipoidentificacioncomprador,
    'razonSocialSujetoRetenido' => $Array_Cabecera['razon'],
    'identificacionSujetoRetenido' =>$idprov,
    'periodoFiscal' => $periodoFiscal 
 );

//	-<comprobanteRetencion id="comprobante" version="1.0.0">
$factura = array(    
    'infoTributaria' => $infoTrib,
	'infoCompRetencion' => 	$infoFact,
    'impuestos' => 		$impuestos,
	'infoAdicional' => 	$infoAdic
);
 
 
$factura = array(
    'infoTributaria' => $infoTrib,
    'infoCompRetencion' => 	$infoFact,
    'impuestos' => 		$impuestos,
    'infoAdicional' => 	$infoAdic
);

echo $ruta.'/'.$carpeta.'/'.$factura['infoTributaria']['claveAcceso'].'.xml';


XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea


$xml=XmlDoc::createDocElect("comprobanteRetencion",'1.0.0',$factura); // crea objeto xml


$xml->saveFormatedXML($ruta.'/'.$carpeta.'/'.$factura['infoTributaria']['claveAcceso'].'.xml',false,false);


header("Content-Type: application/xml; charset=utf-8");

echo $xml->saveXML();
}
?>