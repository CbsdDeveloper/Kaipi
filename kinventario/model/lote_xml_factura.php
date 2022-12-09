 <?php 
 session_start( );
 
 require '../../kconfig/Db.class.php';  
 require '../../kconfig/Obj.conf.php';  
 
 require  '../../facturae/FirmaXades/FirmaElectronicaNativa.php'; 
 require "../../facturae/RideSRI/libs/xml/XmlDoc.php" ;
 
 
 $signer=new FirmaElectronica(); // Instancio la clase
 
 $bd	   =	new Db;
 
 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 //-------------------------------------------------
 // verifica sumatoria de facturas
 //--------------------------------------------------
 _Verifica_facturas( $bd  );
 _Verifica_suma_facturas(  $bd  );
 _Verifica_suma_facturas_Total(  $bd  ) ;
 
 $ruc         = $_SESSION['ruc_registro'];
 
 $date        = $_GET['date'];
 
 //---------------- empresa ruc -------------------
 //--------------------------------------------------
 $ADatos = $bd->query_array(
     'web_registro',
     'razon, contacto, correo,direccion,felectronica,estab,ruc_registro,obligado,firma,carpeta,ambiente',
     'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
     );
 
 $estab       = trim($ADatos['estab'] )  ;
 $ptoEmi      =  '001';
 $ambiente    =  $ADatos['ambiente'];
 
 
 $serie = trim($estab).trim($ptoEmi);
 
 //------------------------------------------------
 

 
 $sql = 'SELECT id_movimiento ,autorizacion
	     FROM view_inv_movimiento
	     WHERE fecha   ='.$bd->sqlvalue_inyeccion($date, true).' and
                estado ='.$bd->sqlvalue_inyeccion('aprobado', true).' and
		       registro='.$bd->sqlvalue_inyeccion($ruc, true);
 
 echo  $sql ;
 
 $stmt12   = $bd->ejecutar($sql);
 
 $contador = 1;
 
 while ($x=$bd->obtener_fila($stmt12)){
     
       $id = $x['id_movimiento'];
     
      $Array_Cabecera = $bd->query_array(
         'view_inv_movimiento',
         'id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo,
              id_periodo, documento, idprov, id_asiento_ref, proveedor, razon, direccion,
              telefono, correo, contacto, fechaa, anio, mes, transaccion, carga,autorizacion',
             'id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
         );
     
   
      if (empty($Array_Cabecera['autorizacion'])){
          
            $clave = $signer->createClaveAcceso($Array_Cabecera['fecha'],
                         "1", trim($ruc),
                             $ambiente,
                             $serie,
                             trim($Array_Cabecera['comprobante']),
                             $id,1);
                         
                      
                         $data  = $clave;
                         
                      
                       
                    //     xml_creacion1( $bd,$data,$Array_Cabecera,$ADatos,$id,$ambiente,$estab,$ptoEmi);
                         
                         $sql = "UPDATE inv_movimiento
                						   SET 	autorizacion=".$bd->sqlvalue_inyeccion($clave, true)."
                 						 WHERE id_movimiento=".$bd->sqlvalue_inyeccion($id, true);
                         
                         $bd->ejecutar($sql);
                   
                       
                         
                       //  unset($Array_Cabecera);  
                         
                         
                         $contador ++ ;
                 
                    
                    }
            }
    $data          = '  <br>Procesando Informacion ( '.$date.' ) Nro. '.$contador;
 
   //--------------------------------------------------------------------
   // firma
   //------------------------------------------------------------------------
   
    $sql = 'SELECT id_movimiento ,autorizacion
	     FROM view_inv_movimiento
	     WHERE fecha   ='.$bd->sqlvalue_inyeccion($date, true).' and
               transaccion is null and
                estado ='.$bd->sqlvalue_inyeccion('aprobado', true).' and
		       registro='.$bd->sqlvalue_inyeccion($ruc, true);
 
    
    $stmt121   = $bd->ejecutar($sql);
    
    $contador = 1;
    
    while ($xx=$bd->obtener_fila($stmt121)){
        
 
    $id = $xx['id_movimiento'];
        
    $ch = curl_init();
    
    // definimos la URL a la que hacemos la petición
    
    curl_setopt($ch, CURLOPT_URL,"https://g-kaipi.com/kaipi/facturae/autoriza_factura_firma_lote.php");
    
    //   curl_setopt($ch, CURLOPT_URL,"https://liderdoc.com/factura/autoriza_comprobante_externo.php");
    // definimos el número de campos o parámetros que enviamos mediante POST
    curl_setopt($ch, CURLOPT_POST, 1);
    // definimos cada uno de los parámetros
    curl_setopt($ch, CURLOPT_POSTFIELDS, "id=".$id );
    
    // recibimos la respuesta y la guardamos en una variable
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $data = curl_exec ($ch);
    
    // cerramos la sesión cURL
    curl_close ($ch);
 
    $contador ++ ;
    
    echo $contador;
    
    }
  
 echo $data; 
 
//----------------------------------------
 function xml_creacion1( $bd,$data,$Array_Cabecera,$ADatos,$id,$ambiente,$estab,$ptoEmi){
     
     
     
     $ruta     = "../../facturae/" ;
     
     
     $carpeta = 'xml' ;
     
     /* NOTA: Revisar q campos falta dependiendo del funcionamiento de la empresa, o agregar los opcionales en caso de ser necesarios */
     
     // infoTributaria
     $infoTrib=array(
         'ambiente' => 		$ambiente,
         'tipoEmision' => 	"1",
         'razonSocial' => 	$ADatos['razon'],
         'nombreComercial' =>$ADatos['razon'],
         'ruc' => 			$ADatos['ruc_registro'],
         'claveAcceso' => 	$data,
         'codDoc' => 		"01",
         'estab' => 			$estab,
         'ptoEmi' => 		$ptoEmi,
         'secuencial' => 	$Array_Cabecera['comprobante'],
         'dirMatriz' => 		$ADatos['direccion']
     );
     
     
     
     // infoAdicional
     $infoAdic=array(
         'campoAdicional'=>array(
             array( '@attributes' => array('nombre' => "Email"), '@value' => $Array_Cabecera['correo']),
             array( '@attributes' => array('nombre' => "Observacion"), '@value' => $Array_Cabecera['detalle'])
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
         ///----------------------------------------------------
         $impuestos=array('impuesto'=>array(
             'codigo' => "2",
             'codigoPorcentaje' => $codigoporcentaje,
             'tarifa' => $tarifa,
             'baseImponible' => round($baseimponible,2),
             'valor' => round($valor,2),
         ));
         ///----------------------------------------------------
         $totalsiniva        = $x['baseiva'] + $x['tarifa_cero'] ;
         $totalSinImpuestos  = $totalSinImpuestos + $totalsiniva;
         
         array_push($detalles['detalle'],array(
             'codigoPrincipal' => $x['id'],
             'descripcion' => $x['producto'],
             'cantidad' => $cantidad,
             'precioUnitario' => round($totalsiniva / $cantidad,2),
             'descuento' => "0.00",
             'precioTotalSinImpuesto' =>$totalsiniva,
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
     
     while ($x=$bd->obtener_fila($stmt2)){
         
         $monto_iva    = round($x['monto_iva'],2) ;
         $tarifa_cero  = $x['tarifa_cero'] ;
         $base         = $x['baseiva'] ;
         
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
     //-----------------------------
     
     
     
     ///-------------------------------------
     $trozos = explode("-", $Array_Cabecera['fecha'],3);
     
     $anio = $trozos[0];
     $mes =  $trozos[1];
     $dia =  $trozos[2];
     
     
     $fecha = $dia.'/'.$mes.'/'.$anio;
     
     $infoFact=array(
         'fechaEmision' => $fecha,
         'dirEstablecimiento' => $ADatos['direccion'],
         'obligadoContabilidad' => $ADatos['obligado'],
         'tipoIdentificacionComprador' => $tipoidentificacioncomprador,
         'razonSocialComprador' => $Array_Cabecera['proveedor'],
         'identificacionComprador' =>$idprov,
         'totalSinImpuestos' => $totalSinImpuestos,
         'totalDescuento' => "0",
         'totalConImpuestos' => $totalImp,
         'propina' => "0.00",
         'importeTotal' => $importeTotal,
         'moneda' => "DOLAR",
         'pagos' => array(
             'pago' => array(
                 array(
                     'formaPago' => "20",
                     'total' => $importeTotal
                 )
             )
         )
     );
     
     $factura = array(
         'infoTributaria' => $infoTrib,
         'infoFactura' => 	$infoFact,
         'detalles' => 		$detalles,
         'infoAdicional' => 	$infoAdic
     );
     
     XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea
     
     $xml=XmlDoc::createDocElect("factura",'2.1.0',$factura); // crea objeto xml
     
     $xml->saveFormatedXML($ruta.'/'.$carpeta.'/'.$factura['infoTributaria']['claveAcceso'].'.xml',false,false);
     
     header("Content-Type: application/xml; charset=utf-8");
     
     echo $xml->saveXML();
       
     header("Content-Type: text/php;");
     //echo $xml->saveXML();
     
     
 }
 function _Verifica_facturas( $bd  ){
     
     $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 , 
                          tarifa_cero = total / cantidad , 
                          baseiva = 0 ,
                          costo = total / cantidad "."
 				 		 WHERE  tarifa_cero is null and
                                cantidad > 0 and
                                monto_iva is null and
                                tipo=".$bd->sqlvalue_inyeccion('T', true);
     
     $bd->ejecutar($sqlEdit);
     
     
     //--------------
     $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 ,
                          baseiva = 0 
 				 		 WHERE  cantidad > 0 and
                                tarifa_cero > 0 and
                                monto_iva is null and
                                tipo=".$bd->sqlvalue_inyeccion('T', true);
     
     $bd->ejecutar($sqlEdit);
     
     //-----
     
     $sqlEdit = "update inv_movimiento_det
				      set tarifa_cero = 0  
 				 		 WHERE  cantidad > 0 and
                                tarifa_cero is null and
                                monto_iva > 0 ";
     
     $bd->ejecutar($sqlEdit);
     
     //---------------
     
     
     $sql = "update inv_movimiento_det
                        set tipo = ".$bd->sqlvalue_inyeccion('T', true)."
                        where   cantidad > 0 and monto_iva = 0 and tipo is null" ;
     
     $bd->ejecutar($sql);
     
     
     $sql = "update inv_movimiento_det
                     set tarifa_cero = costo * cantidad,
                         total       = costo * cantidad
                   where  tipo = ".$bd->sqlvalue_inyeccion('T', true)." and
                          (monto_iva + tarifa_cero + baseiva) <> total" ;
     
     $bd->ejecutar($sql);
     
     
     //----------------
     $sqlEdit = "update inv_movimiento_det
				      set tarifa_cero = total / cantidad , baseiva = 0 ,costo = total / cantidad "."
 				 		 WHERE  cantidad = 1 and
                                monto_iva = 0 and total <> tarifa_cero  and
                                tipo=".$bd->sqlvalue_inyeccion('T', true);
     
     $bd->ejecutar($sqlEdit);
     
 }
 //---------------
 function _Verifica_suma_facturas(  $bd  ){
     
     
     $sql_det1 = "SELECT id_movimiento,    iva, base0, base12, total
                        FROM inv_movimiento
                        where (base0 is null  or iva is null ) and  estado = 'aprobado' ";
     
     $stmt1 = $bd->ejecutar($sql_det1);
     
     
     while ($x=$bd->obtener_fila($stmt1)){
         
         $id = $x['id_movimiento'];
         
         $ATotal = $bd->query_array(
             'inv_movimiento_det',
             'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
             ' id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
             );
         
         if ($ATotal['t1'] > 0) {
             
             $sqlEdit = "update inv_movimiento
        				           set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                                  base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                                  base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                                  total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
         				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
             
         }else {
             
             $sqlEdit = "update inv_movimiento
        				           set  estado = ".$bd->sqlvalue_inyeccion('anulado',true)."
          				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
             
         }
         
         $bd->ejecutar($sqlEdit);
         
         
     }
     
 }
 //----------------------------------------------
 //---------------
 function _Verifica_suma_facturas_Total(  $bd  ){
     
     
     $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where ( iva + base0 + base12) <> total and    estado = 'aprobado'";
     
     
     
     $stmt1 = $bd->ejecutar($sql_det1);
     
     
     while ($x=$bd->obtener_fila($stmt1)){
         
         $id = $x['id_movimiento'];
         
         $ATotal = $bd->query_array(
             'inv_movimiento_det',
             'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
             ' id_movimiento ='.$bd->sqlvalue_inyeccion($id,true)
             );
         
         $sqlEdit = "update inv_movimiento
				     set  iva = ".$bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$bd->sqlvalue_inyeccion( $id, true);
         
         $bd->ejecutar($sqlEdit);
         
         
     }
     
 }
 
  
?>