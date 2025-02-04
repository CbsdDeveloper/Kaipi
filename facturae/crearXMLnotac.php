<?php 
session_start();
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

require_once("./RideSRI/XmlDoc.php");
 
$bd	   =	new Db;
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$id            = $_GET['id'];
$ruc           = trim($_SESSION['ruc_registro']);
$ruta          = ' '; 

//dirname(__file__);



$carpeta = 'xml' ;

$ADatos = $bd->query_array(  'web_registro',   '*',  'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true) );

$estab       = trim($ADatos['estab'] )  ;
$ptoEmi      =  '001';
$ambiente    =  $ADatos['ambiente'];

/* NOTA: Revisar q campos falta dependiendo del funcionamiento de la empresa, o agregar los opcionales en caso de ser necesarios */

$Array_Cabecera = $bd->query_array(
    'view_inv_movimiento',
    'id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo,
             id_periodo, documento, idprov, id_asiento_ref, proveedor, razon, direccion,
             telefono, correo, contacto, fechaa, anio, mes, transaccion, carga,autorizacion',
    'id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
    );


$Array_CabeceraNC = $bd->query_array(
    'doctor_vta',
    'idcliente, tipocomprobante, comprobante1, secuencial, codestab,
    coddocmodificado, numdocmodificado, fechaemision,
    secuencial1,
    cab_autorizacion, fechaemisiondocsustento, fecha_factura, estab1, ptoemi1',
    'id_diario ='.$bd->sqlvalue_inyeccion($id,true)
    );


$input = str_pad(trim($Array_CabeceraNC['secuencial1']), 9, "0", STR_PAD_LEFT);

$data = trim($Array_CabeceraNC['cab_autorizacion']);

$clave =  $data;

// infoTributaria
$infoTrib=array(
        'ambiente' => 		$ambiente,
		'tipoEmision' => 	"1",
        'razonSocial' => 	$ADatos['razon'],
        'nombreComercial' =>$ADatos['razon'],
        'ruc' => 			trim($ADatos['ruc_registro']),
        'claveAcceso' => 	$data, 
		'codDoc' => 		"04",
        'estab' => 			$estab,
        'ptoEmi' => 		$ptoEmi,
        'secuencial' => 	$input,
        'dirMatriz' => 		$ADatos['direccion']
);

 

// infoAdicional
$infoAdic=array(
    'campoAdicional'=>array( 
        array( '@attributes' => array('nombre' => "Email"), '@value' => $Array_Cabecera['correo']),
        array( '@attributes' => array('nombre' => "Observacion"), '@value' => trim($Array_Cabecera['detalle'])),
        array( '@attributes' => array('nombre' => "Direccion"), '@value' => trim($Array_Cabecera['direccion'])),
	)
);

//$Array_Cabecera['direccion']

// detalles
$sql_det = 'SELECT id, codigo, producto, unidad,
                             cantidad, costo, total, tipo, monto_iva,
                             tarifa_cero, tributo, baseiva, sesion, id_movimiento
                      FROM  view_factura_detalle
                     where id_movimiento ='.$bd->sqlvalue_inyeccion($id, true);


$stmt1              = $bd->ejecutar($sql_det);
$importeTotal       = 0;
$totalSinImpuestos  = 0;

// infoFactura

$detalles=array("detalle"=>array());

while ($x=$bd->obtener_fila($stmt1)){
    
    $importeTotal = $importeTotal +  $x['total'] ;
    $monto_iva    = round($x['monto_iva'],2) ;
    $cantidad     = $x['cantidad'] ;
    $tarifa_cero  = $x['tarifa_cero'] ;
    $base         = $x['baseiva'] ;
    
    //-----------------------------------------------------
    if( trim($x['tributo']) ==  'I' ){
        $codigoporcentaje       = '2';
        $baseimponible          = $base;
        $valor                  = round($monto_iva  ,2);
        $tarifa                 = 12;
    }
    if(  trim($x['tributo'])  == 'T' ){
        $codigoporcentaje       = '0';
        $baseimponible          = round($tarifa_cero,2);
        $valor                  = '0';
        $tarifa                 = 0;
    }
    ///---------------------------------------------------- $tarifa  round($baseimponible,2) ound($valor,2),
    $impuestos=array('impuesto'=>array(
        'codigo' => "2",
        'codigoPorcentaje' => $codigoporcentaje,
        'tarifa' => $tarifa,
        'baseImponible' => $baseimponible,
        'valor' => $valor
    ));
    ///----------------------------------------------------
    $totalsiniva        = $x['baseiva'] + $x['tarifa_cero'] ;
    $totalSinImpuestos  = $totalSinImpuestos + $totalsiniva;
    
    // round($totalsiniva / $cantidad,2),
    //$totalsiniva 
    
    array_push($detalles['detalle'],array(
        'codigoInterno' => $x['id'],
        'codigoAdicional' => $x['id'],
        'descripcion' => $x['producto'],
        'cantidad' => $cantidad,
        'precioUnitario' =>  round($totalsiniva / $cantidad,2),
        'descuento' => "0.00",
        'precioTotalSinImpuesto' => $totalsiniva,
        'impuestos' => $impuestos
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


///---------------------------------------------------- 
$totalImp=array('totalImpuesto'=>array());

$sql_det1 = 'SELECT tributo, sum(total) as total, sum(monto_iva) as monto_iva,
                            sum(tarifa_cero) as tarifa_cero, sum(baseiva) as baseiva
                      FROM  view_factura_detalle
                     where id_movimiento ='.$bd->sqlvalue_inyeccion($id, true).' group by tributo';

$stmt2 = $bd->ejecutar($sql_det1);

$total = 0;

while ($x=$bd->obtener_fila($stmt2)){
  
    $monto_iva    = round($x['monto_iva'],2) ;
    $tarifa_cero  = $x['tarifa_cero'] ;
    $base         = $x['baseiva'] ;
    
  //  $total = $total  + ($tarifa_cero + $base) + $monto_iva;
  
    $total = $total  + $monto_iva;
    
    //-----------------------------------------------------
    if( trim($x['tributo']) ==  'I' ){
        $codigoporcentaje1 = '2';
        $baseimponible1  = round($base,2);
        $valor1          = round($monto_iva,2);
        $tarifa          = 12;
    }
    
    if(  trim($x['tributo'])  == 'T' ){
        $codigoporcentaje1   = '0';
        $baseimponible1      = $tarifa_cero;
        $valor1              = '0';
        $tarifa              = 0;
    }
    ///----------------------------------------------------

    array_push($totalImp['totalImpuesto'],array(
        'codigo' => "2",
        'codigoPorcentaje' =>  $codigoporcentaje1,
        'baseImponible' => round($baseimponible1,2),
        'valor' => $valor1
    ));
    
}
  
///-------------------------------------
$trozos = explode("-", $Array_CabeceraNC['fechaemisiondocsustento'],3);

$anio = $trozos[0];
$mes =  $trozos[1];
$dia =  $trozos[2];

 
$fecha = $dia.'/'.$mes.'/'.$anio;


$trozos = explode("-", $Array_CabeceraNC['fecha_factura'],3);

$anio = $trozos[0];
$mes =  $trozos[1];
$dia =  $trozos[2];


$fecha_factura = $dia.'/'.$mes.'/'.$anio;

//$totalSinImpuestos

$infoFact=array(
    'fechaEmision' => $fecha,
    'tipoIdentificacionComprador' => $tipoidentificacioncomprador,
    'razonSocialComprador' => trim($Array_Cabecera['proveedor']),
    'identificacionComprador' =>$idprov,
    'obligadoContabilidad' => $ADatos['obligado'],
    'codDocModificado' => trim($Array_CabeceraNC['coddocmodificado']),
    'numDocModificado' => trim($Array_CabeceraNC['numdocmodificado']),
    'fechaEmisionDocSustento' => $fecha_factura,
    'totalSinImpuestos' =>  "0.00", 
    'valorModificacion' => $total, 
    'moneda' => 'DOLAR',
    'totalConImpuestos' => $totalImp,
	'motivo' => "DEVOLUCION" 
);

 

$factura = array(    
    'infoTributaria' => $infoTrib,
	'infoNotaCredito' => 	$infoFact,
	'detalles' => 		$detalles,
	'infoAdicional' => 	$infoAdic
);


$ruta       = dirname(__file__);

$carpeta    = 'xml' ;

$factura['infoTributaria']['claveAcceso']= $clave ;

XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea

$xml=XmlDoc::createDocElect("notaCredito",'1.1.0',$factura); // crea objeto xml

$xml->saveFormatedXML($ruta.'/'.$carpeta.'/'.$factura['infoTributaria']['claveAcceso'].'.xml',false,false);

header("Content-Type: application/xml; charset=utf-8");

echo $xml->saveXML();

?>