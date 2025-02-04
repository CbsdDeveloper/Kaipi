<?php
session_start();
date_default_timezone_set('UTC');
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale (LC_TIME,"spanish");
 

require '../kconfig/Db.class.php';  

class _crearXMLiquidacion{
	
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
    function _crearXMLiquidacion( ){
		//inicializamos la clase para conectarnos a la bd
		
        $this->bd	   =	new Db ;
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
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
            $Array_Cabecera = $this->bd->query_array( 'view_liquidaciones','*','id_liquida ='.$this->bd->sqlvalue_inyeccion($id,true));
	        $longitud       = strlen(trim($Array_Cabecera['autorizacion'])) ;

          
 

            if ($longitud  < 5) {

            
                require "RideSRI20/XmlDoc.php" ;
                
                $comprobante = trim($Array_Cabecera['secuencial']);

                 $data=XmlDoc::createClaveAcceso($Array_Cabecera['fecharegistro'],
                     "3",
                     $this->ruc,
                     $ambiente,
                     $serie,
                     $comprobante,
                     $id,
                     1);
          
                 
                   
                 $this->valida = 1;     
             
                 $sql = "UPDATE co_liquidacion
                        SET 	autorizacion=".$this->bd->sqlvalue_inyeccion($data, true)."
                        WHERE id_liquida=".$this->bd->sqlvalue_inyeccion($id, true);
 
                 
                $this->bd->ejecutar($sql);
            
                 
             }else{
                
                 $this->valida = 1;  
                 $data        = $Array_Cabecera['autorizacion'];
                  
             }
            

             return $data ;
	}
//----------------------------------------
	function tipo_contribuyente( $idprov  ){
	    
	    
 	    
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
	    
 	    
	    return $tipoidentificacioncomprador ;
	}
/*
*/
function K_comprobante(  ){
	 
 
	        
    $sql = "SELECT   coalesce(retencion,0) as secuencia
            FROM web_registro
            where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc   ,true);
    
        
    $parametros 			= $this->bd->ejecutar($sql);
    
    $secuencia 				= $this->bd->obtener_array($parametros);
     
    $contador = $secuencia['secuencia'] + 1;
    
    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
    
    
    $sqlEdit = "UPDATE web_registro
               SET 	retencion=".$this->bd->sqlvalue_inyeccion($contador, true)."
              WHERE ruc_registro=".$this->bd->sqlvalue_inyeccion($this->ruc , true);
    
    
    $this->bd->ejecutar($sqlEdit);
    
    return $input ;
}
    //-------------

     function genera_archivo( $id,$data){

        //if ( $this->valida == 0){
            $this->xml_creacion( $id,$data);
       //  }
    }

    //---------------

    function xml_creacion( $id,$data){


        $ADatos       =  $this->bd->query_array(  'web_registro',  '*', 'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)  );
        $estab        =  trim($ADatos['estab'] )  ;
        $ptoEmi       =  '001';
        $ambiente     =  $ADatos['ambiente'];
  

        //---------------- cliente factura ----------------------
      
        $Array_Cabecera = $this->bd->query_array( 'view_liquidaciones','*','id_liquida ='.$this->bd->sqlvalue_inyeccion($id,true));

        $trozos = explode("-", $Array_Cabecera['fechaemision'],3);
        
        $anio = $trozos[0];
        $mes =  $trozos[1];
        $dia =  $trozos[2];
        
        $fechaEmision = $dia.'/'.$mes.'/'.$anio;
        
        //$periodoFiscal =  $mes.'/'.$anio;
        
        $total_sin   =  $Array_Cabecera['baseimponible']  + $Array_Cabecera['baseimpgrav'] ;
        $total_con   =  $total_sin  + $Array_Cabecera['montoiva'] ;
        
        $base_iva    = $Array_Cabecera['baseimpgrav'];
        $montoiva    = $Array_Cabecera['montoiva'];
        
        $idprov = trim( $Array_Cabecera['idprov'] );
        $detalle= trim( $Array_Cabecera['detalle'] );
        
         
        $tipoidentificacioncomprador = $this->tipo_contribuyente( $idprov ) ;
        
        require_once("./RideSRI20/XmlDoc.php");
  
             
        // infoTributaria
        $infoTrib=array(
            'ambiente' => 		$ambiente,
            'tipoEmision' => 	"1",
            'razonSocial' => 	trim($ADatos['razon']),
            'nombreComercial' =>trim($ADatos['comercial']),
            'ruc' => 			trim($ADatos['ruc_registro']),
            'claveAcceso' => 	trim($data),
            'codDoc' => 		"03",
            'estab' => 			trim($estab),
            'ptoEmi' => 		trim($ptoEmi),
            'secuencial' => 	trim($Array_Cabecera['secuencial']),
            'dirMatriz' => 		trim($ADatos['direccion']),
            //   'agenteRetencion' => '0',
            // 'contribuyenteRimpe'  => $regimen
        );
        
        ///------------------------------------------------------------
        
        $totalConImpuestos       = array("totalImpuesto"=>array());
         
        if ( $montoiva > 0 ) {
            array_push($totalConImpuestos['totalImpuesto'],
                array(
                    'codigo' => '2',
                    'codigoPorcentaje' => '2',
                    'baseImponible' => $base_iva,
                    'tarifa' => '12',
                    'valor' => $montoiva
                ));
        }
        
        if ( $Array_Cabecera['baseimponible']  > 0 ) {
            array_push($totalConImpuestos['totalImpuesto'],
                array(
                    'codigo' => '2',
                    'codigoPorcentaje' => '0',
                    'baseImponible' => $Array_Cabecera['baseimponible'] ,
                    'tarifa' => '0',
                    'valor' => $Array_Cabecera['baseimponible'] 
                ));
        }
      
        
        $pagos       = array("pago"=>array());
        
        array_push($pagos['pago'],
            array(
                'formaPago' => $Array_Cabecera['formadepago'] ,
                'total' => $total_con,
                'plazo' => '30'
            ));
        
         ///------------------------------------------------------------

        $infoLiquidacionCompra=array(
            'fechaEmision' => $fechaEmision,
            'dirEstablecimiento' => trim($ADatos['direccion']),
            'tipoIdentificacionProveedor' => $tipoidentificacioncomprador,
            'razonSocialProveedor' => trim($Array_Cabecera['razon']),
            'identificacionProveedor' =>trim($idprov),
            'direccionProveedor' => trim($Array_Cabecera['direccion']),
            'totalSinImpuestos' => $total_sin,
            'totalDescuento' => '0.00',
           // 'codDocReembolso' => '0',
            'totalComprobantesReembolso' => $total_con,
            'totalBaseImponibleReembolso' => $total_sin,
            'totalImpuestoReembolso' => $montoiva,
            'totalConImpuestos' => $totalConImpuestos,
            'importeTotal'  => $total_con,
            'moneda'  => 'dolar',
            'pagos' => $pagos
        );
        
        //---------
      
        
        $sql_det = "SELECT id_liquidad, id_liquida, detalle, cantidad, precio, baseimponible, baseimpgrav, montoiva, registro, sesion 
                FROM co_liquidacion_d
                where id_liquida = ".$this->bd->sqlvalue_inyeccion($id, true);
 
   
    
        $stmt1              = $this->bd->ejecutar($sql_det);
        
        $detalles    = array("detalle"=>array());
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            $total_base = $x['baseimponible'] + $x['baseimpgrav'];
            $monto_iva =  $x['montoiva'];
            
            $precioTotalSinImpuesto =  $x['precio'] *  $x['cantidad'];
            
            if ( $monto_iva > 0 ){
                $codigoPorcentaje = '2';
                $tarifa = '12';
            }else {
                $codigoPorcentaje = '0';
                $tarifa = '0';
                $monto_iva = '0.00';
            }
            
            $impuestos       = array("impuesto"=>array());
            
            array_push($impuestos['impuesto'],
                array(
                    'codigo' => '2' ,
                    'codigoPorcentaje' => $codigoPorcentaje,
                    'tarifa' => $tarifa,
                    'baseImponible' => $total_base,
                    'valor' => $monto_iva
                ));
            
            array_push($detalles['detalle'],
                array(
                    'codigoPrincipal' => $x['id_liquidad'],
                    'descripcion' => trim($x['detalle']),
                    'cantidad' => round($x['cantidad'],2),
                    'precioUnitario' => round($x['precio'],2),
                    'precioSinSubsidio' => round($x['precio'],2),
                    'descuento' => '0.00', 
                    'precioTotalSinImpuesto' => $precioTotalSinImpuesto,
                    'impuestos'  => $impuestos
                ));
            
        }
        
        $infoAdic=array(
            'campoAdicional'=>array(
                array( '@attributes' => array('nombre' => "Direccion"), '@value' => trim($Array_Cabecera['direccion'])),
                array( '@attributes' => array('nombre' => "Email"), '@value' => trim($Array_Cabecera['correo'])),
                array( '@attributes' => array('nombre' => "Observacion"), '@value' => trim( $detalle))
            )
        );
        
         
        //----------------------------------------
 
        
        $factura = array(
            'infoTributaria' => $infoTrib,
            'infoLiquidacionCompra'  =>  $infoLiquidacionCompra,
            'detalles' => 		$detalles,
            'infoAdicional' => 	$infoAdic
        );
        
        
        $ruta = 'xml/';
        
        $factura['infoTributaria']['claveAcceso']= $data ;
        
        XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea
        XmlDoc::cleanEspecialCharacters($factura/*, array('&',"'","\"", '<', '>'), array("&amp;", "&apos;", "&quot;", "&lt;", "&gt;")*/); // Limpia algunos caracteres especiales
        $xml=XmlDoc::createDocElect("liquidacionCompra", '1.1.0', $factura); // crea objeto xml
        
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

$gestion   = 	new _crearXMLiquidacion;
 
    $id				=   $_GET["id"];

    $data = 'Emision del comprobante electronico'; 
   
    $data = $gestion->Crear_autorizacion( $id);

    $gestion->genera_archivo( $id,$data);
 
    echo $data;
	
 
?>