<?php 
session_start();
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

require_once("./RideSRI/XmlDoc.php");

$bd	   =	new Db;
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$id            = $_GET['id'];
$ruc           = trim($_SESSION['ruc_registro']);
$ruta          = ' '; //dirname(__file__);

 
$ADatos = $bd->query_array(  'web_registro',   '*',  'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true) );

$Array_Cabecera = $bd->query_array(   'view_anexos_compras',  '*', 'id_asiento ='.$bd->sqlvalue_inyeccion($id,true) );

$id          = $Array_Cabecera['id_asiento'];
$clave       = trim($Array_Cabecera['autretencion1']);
$comprobante = $Array_Cabecera['secretencion1'];
$estab       = trim($ADatos['estab'] )  ;
$ptoEmi      =  '002';
$ambiente    =  $ADatos['ambiente'];
 

// infoTributaria
$infoTrib=array(
        'ambiente' => 		$ambiente,
		'tipoEmision' => 	"1",
        'razonSocial' => 	trim($ADatos['razon']),
    'nombreComercial' =>trim($ADatos['comercial']),
    'ruc' => 			trim($ADatos['ruc_registro']),
     'claveAcceso' => 	$clave, 
	 'codDoc' => 		"07",
    'estab' => 			trim($estab),
    'ptoEmi' => 		trim($ptoEmi),
    'secuencial' => 	trim($comprobante),
    'dirMatriz' => 		trim($ADatos['direccion']),
);

$detalle = 'Adquisicion compra referencia nro.'.$Array_Cabecera['secuencial'];

if (!empty($Array_Cabecera['detalle'])){
    $detalle = $detalle.' '.trim($Array_Cabecera['detalle']);
}
 
// infoAdicional
$infoAdic=array('campoAdicional'=>array());

$infoAdic=array(
    'campoAdicional'=>array( 
        array( '@attributes' => array('nombre' => "Email"), '@value' => trim($Array_Cabecera['correo'])),
        array( '@attributes' => array('nombre' => "Observacion"), '@value' => $detalle)
	)
);
 
$especial =  trim($ADatos['especial']);
$regimen  =  trim($ADatos['regimen']);
$agente   =  trim($ADatos['agente']);

 
if ( strlen($especial) > 2){
   array_push($infoAdic['campoAdicional'],array(
       '@attributes' => array('nombre' => 'a '), '@value' =>  'Contribuyente Especial Nro '. $especial
   ));
}

if ( strlen($regimen) > 0){
   array_push($infoAdic['campoAdicional'],array(
       '@attributes' => array('nombre' => 'b '), '@value' => 'Contribuyente Regimen MicroEmpresas '.$regimen
   ));
}

if ( strlen($agente) > 2){
   array_push($infoAdic['campoAdicional'],array(
       '@attributes' => array('nombre' => 'c '), '@value' => 'Resolucion NAC-DNCRAS-'.$agente
   ));
}
 

// detalles
 
$sql_det = "select '1' as codigo, 
        	  codretair as  codigoretencion, 
        	  baseimpair  as baseimponible,
        	  round(porcentajeair,2)     as porcentajeretener,
        	  valretair as valorretenido,
        	  '01' as coddocsustento
        FROM  view_anexos_fuente
        where id_asiento = ".$bd->sqlvalue_inyeccion($id, true)." 
        union
        SELECT '2' as codigo, 
        	  cast(porcentaje_iva as char) as  codigoretencion, 
        	  montoiva  as baseimponible,
        	    cast(porcentaje as int)as porcentajeretener,
        	  retencion as valorretenido,
        	  '01' as coddocsustento
        FROM  view_anexos_iva
        where id_asiento = ".$bd->sqlvalue_inyeccion($id, true);

 
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
       
 
    array_push($impuestos['impuesto'],array(
        'codigo' => $x['codigo'],
        'codigoRetencion' => trim($x['codigoretencion']),
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

$ncontador = strlen(trim($idprov));   
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
    'dirEstablecimiento' => trim($ADatos['direccion']),
    'obligadoContabilidad' => $ADatos['obligado'],
    'tipoIdentificacionSujetoRetenido' => $tipoidentificacioncomprador,
    'razonSocialSujetoRetenido' => trim($Array_Cabecera['razon']),
    'identificacionSujetoRetenido' =>trim($idprov),
    'periodoFiscal' => $periodoFiscal 
 );

//	-<comprobanteRetencion id="comprobante" version="1.0.0">

$factura = array(    
    'infoTributaria' => $infoTrib,
	'infoCompRetencion' => 	$infoFact,
    'impuestos' => 		$impuestos,
	'infoAdicional' => 	$infoAdic
);

//<comprobanteRetencion id="comprobante" version="1.0.0">  
$ruta       = dirname(__file__);

$carpeta    = 'xml' ;

$factura['infoTributaria']['claveAcceso']= $clave ;

XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea

$xml=XmlDoc::createDocElect("comprobanteRetencion",'1.0.0',$factura); // crea objeto xml

$xml->saveFormatedXML($ruta.'/'.$carpeta.'/'.$factura['infoTributaria']['claveAcceso'].'.xml',false,false);

header("Content-Type: application/xml; charset=utf-8");

echo $xml->saveXML();

?>