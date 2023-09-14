<?php
session_start();
date_default_timezone_set('UTC');
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale (LC_TIME,"spanish");
 

require '../kconfig/Db.class.php';  

class _crearXMLFactura01{
	
	private $obj;
	private $bd;
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;

    private $valida;

    //-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function _crearXMLFactura01( ){
		//inicializamos la clase para conectarnos a la bd
		
        $this->bd	   =	new Db ;
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        $this->valida = 0; 
	}
   
	//--- calcula libro diario

	function Crear_autorizacion( $id){
		
            $ADatos       =  $this->bd->query_array(  'web_registro',  '*', 'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)  );
            $estab        =  trim($ADatos['estab'] )  ;
            $ptoEmi       =  '001';
            $ambiente     =  $ADatos['ambiente'];
            $serie        =  trim($estab).trim($ptoEmi);

   
            //---------------- cliente factura ----------------------
            $Array_Cabecera = $this->bd->query_array( 'view_inv_movimiento','*','id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true));
	        $longitud       = strlen(trim($Array_Cabecera['autorizacion'])) ;

            if ($longitud  < 2) {


                require_once("./RideSRI20/XmlDoc.php");
                
                
                $data=XmlDoc::createClaveAcceso($Array_Cabecera['fechaa'],
                    "1",
                    trim($ADatos['ruc_registro']),
                    $ambiente,
                    $serie,
                    trim($Array_Cabecera['comprobante']),
                    $id,
                    1);

     
                   
                 $this->valida = 0;     
             
                 $sql = "UPDATE inv_movimiento
                 SET 	autorizacion=".$this->bd->sqlvalue_inyeccion($data, true)."
                WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);

                $this->bd->ejecutar($sql);
             
                 
             }else{
                
                 $this->valida = 1;  
                 $data        = $Array_Cabecera['autorizacion'];
                  
             }

             return $data ;
	}
/*
*/
function K_comprobante(  ){
	 
 
	        
    $sql = "SELECT   coalesce(factura,0) as secuencia
            FROM web_registro
            where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc   ,true);
    
        
    $parametros 			= $this->bd->ejecutar($sql);
    
    $secuencia 				= $this->bd->obtener_array($parametros);
     
    $contador = $secuencia['secuencia'] + 1;
    
    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
    
    
    $sqlEdit = "UPDATE web_registro
               SET 	factura=".$this->bd->sqlvalue_inyeccion($contador, true)."
              WHERE ruc_registro=".$this->bd->sqlvalue_inyeccion($this->ruc , true);
    
    
    $this->bd->ejecutar($sqlEdit);
    
    return $input ;
}

    //-------------

     function genera_archivo( $id,$data){

        if ( $this->valida == 0){
            $this->xml_creacion( $id,$data);
         }
    }

    //---------------

    function xml_creacion( $id,$data){


        $ADatos       =  $this->bd->query_array(  'web_registro',  '*', 'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)  );
        $estab        =  trim($ADatos['estab'] )  ;
        $ptoEmi       =  '001';
        $ambiente     =  $ADatos['ambiente'];
        $serie        =  trim($estab).trim($ptoEmi);

        //---------------- cliente factura ----------------------
      
         $Array_Cabecera = $this->bd->query_array( 'view_inv_movimiento','*','id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true));

         require_once("./RideSRI20/XmlDoc.php");
 
 
         $ruta = '.xml/'; 

         $ruta = ''; 

          
        $dir        =  explode("Sucursal", $ADatos['direccion']);
        $direccion  =  $dir[0]; // piece1
        $sucursal   =  $dir[1]; // piece1
        
        if (empty($sucursal)){
            $sucursal = $direccion;
        }

        // infoTributaria $estab  $ptoEmi

        $infoTrib=array(
            'ambiente' => 		$ambiente,
            'tipoEmision' => 	"1",
            'razonSocial' => 	trim($ADatos['razon']),
            'nombreComercial' =>trim($ADatos['comercial']),
            'ruc' => 			trim($ADatos['ruc_registro']),
            'claveAcceso' => 	trim($data), 
            'codDoc' => 		"01",
            'estab' => 			$estab,
            'ptoEmi' => 		$ptoEmi,
            'secuencial' => 	trim($Array_Cabecera['comprobante']),
            'dirMatriz' => 		trim($direccion)
    );

    $infoAdic=array('campoAdicional'=>array());

 
                $infoAdic=array(
                    'campoAdicional'=>array(
                        array( '@attributes' => array('nombre' => "Direccion"), '@value' => trim($Array_Cabecera['direccion'])),
                        array( '@attributes' => array('nombre' => "Email"), '@value' => trim($Array_Cabecera['correo'])),
                        array( '@attributes' => array('nombre' => "Observacion"), '@value' => trim($Array_Cabecera['detalle']))  
                    )
                );
      
         $especial =  trim($ADatos['especial']);
         $regimen  =  trim($ADatos['regimen']);
         $agente   =  trim($ADatos['agente']);

         $forma_pago   =  '20';
    
        
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

    
        $sql_det = 'SELECT id, codigo, producto, unidad,
                             cantidad, costo, total, tipo, monto_iva,
                             tarifa_cero, tributo, baseiva, sesion, id_movimiento
                      FROM  view_factura_detalle
                     where id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);

        // detalles
        

        $stmt1              = $this->bd->ejecutar($sql_det);
        $importeTotal       = 0;
        $totalSinImpuestos  = 0;

        // infoFactura
        $detalles=array("detalle"=>array());

        while ($x=$this->bd->obtener_fila($stmt1)){   
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

                $valida =  $baseimponible +  $valor;

                $producto           =  trim($x['producto']);
                $producto =  str_replace ( ';' , ' ',  $producto);
                $producto =  str_replace ( '/' , ' ',  $producto);
                $producto =  str_replace ( ':' , ' ',  $producto);

                if ( $valida  > 0  ) {

                     

                        $impuestos=array('impuesto'=>array(
                            'codigo' => "2",
                            'codigoPorcentaje' => $codigoporcentaje,
                            'tarifa' => $tarifa,
                            'baseImponible' => round($baseimponible,2),
                            'valor' => round($valor,2),
                        ));
                        ///----------------------------------------------------
                        $totalsiniva        =  $x['baseiva'] + $x['tarifa_cero'] ;
                        $totalSinImpuestos  =  $totalSinImpuestos + $totalsiniva;
                    
                        $producto           =  trim($x['producto']);
                        $codigo1            =  trim($x['id']);

                        $costo =round($totalsiniva / $cantidad,4) ;
				
                        array_push($detalles['detalle'],array(
                            'codigoPrincipal' => $codigo1 ,
                            'descripcion' => $producto ,
                            'cantidad' => $cantidad,
                            'precioUnitario' => $costo  ,
                            'descuento' => "0.00",
                            'precioTotalSinImpuesto' =>$totalsiniva,
                            'impuestos' => $impuestos
                        ));

 
                    }        
        }
       
        $idprov                      = trim( $Array_Cabecera['idprov'] );
        $ncontador                   = strlen(trim($idprov));  // 01-RUC 05-cedula 06-pasaporte 07-consumidor final 08-identificacion exterior 09-placa
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
        $totalImp   = array('totalImpuesto'=>array());

        $sql_det1 = 'SELECT tributo, sum(total) as total, sum(monto_iva) as monto_iva,
                            sum(tarifa_cero) as tarifa_cero, sum(baseiva) as baseiva
                      FROM  view_factura_detalle
                     where id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true).' group by tributo';

 

        $stmt2      = $this->bd->ejecutar($sql_det1);

        while ($x=$this->bd->obtener_fila($stmt2)){
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

                        $valda = $baseimponible1  + $valor1 ;
                    
                        if ( $valda > 0  ) {

                            array_push($totalImp['totalImpuesto'],array(
                                'codigo' => "2",
                                'codigoPorcentaje' =>  $codigoporcentaje1,
                                'baseImponible' => round($baseimponible1,2),
                                'valor' => $valor1
                            ));

                           
                        }

        }

        ///-------------------------------------
        $trozos = explode("-", $Array_Cabecera['fechaa'],3);
        $anio   = $trozos[0];
        $mes    =  $trozos[1];
        $dia    =  $trozos[2];
        $fecha = $dia.'/'.$mes.'/'.$anio;

        $infoFact=array(
            'fechaEmision' => $fecha,
            'dirEstablecimiento' => trim($sucursal),
            'obligadoContabilidad' => $ADatos['obligado'],
            'tipoIdentificacionComprador' => $tipoidentificacioncomprador,
            'razonSocialComprador' => trim($Array_Cabecera['razon']),
            'identificacionComprador' =>trim($idprov),
            'totalSinImpuestos' => $totalSinImpuestos,
            'totalDescuento' => "0",
            'totalConImpuestos' => $totalImp,
            'propina' => "0.00",
            'importeTotal' => $importeTotal,
            'moneda' => "DOLAR",
            'pagos' => array(
                'pago' => array(
                    array(
                        'formaPago' =>  $forma_pago,
                        'total' => $importeTotal
                    )
                )
            )
        );

       
               //$MATRIZ1 = array_combine ($infoAdic ,  $infoAdic_01);
               $factura = array(    
                'infoTributaria' => $infoTrib,
                'infoFactura' => 	$infoFact,
                'detalles' => 		$detalles,
                'infoAdicional' => 	$infoAdic
            );
            
            $ruta = 'xml/';
            
            $factura['infoTributaria']['claveAcceso']=  $data ;
            XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea
            XmlDoc::cleanEspecialCharacters($factura/*, array('&',"'","\"", '<', '>'), array("&amp;", "&apos;", "&quot;", "&lt;", "&gt;")*/); // Limpia algunos caracteres especiales
            $xml=XmlDoc::createDocElect("factura", '2.1.0', $factura); // crea objeto xml
             
            $xml->saveFormatedXML($ruta.$factura['infoTributaria']['claveAcceso'].'.xml',false,false);
            
            
            header("Content-Type: application/xml; charset=utf-8");
            
            echo $xml->saveXML();

 
        

    }
 	 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new _crearXMLFactura01;
 
    $id				=   $_GET["id"];

    $data = 'Emision del comprobante electronico'; 
   
    $data = $gestion->Crear_autorizacion( $id);

    $gestion->genera_archivo( $id,$data);
 
    echo $data;
	
 
?>