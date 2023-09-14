<?php
session_start();
date_default_timezone_set('UTC');
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale (LC_TIME,"spanish");
 

require '../kconfig/Db.class.php';  

class _crearXMLComprobante{
	
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
    function _crearXMLComprobante( ){
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
            $Array_Cabecera = $this->bd->query_array( 'view_anexos_compras',
                              ' coalesce(codigoe,0) as codigoe,transaccion,autretencion1,secretencion1,fecharegistro',
                              'id_compras ='.$this->bd->sqlvalue_inyeccion($id,true));
	        $longitud       = strlen(trim($Array_Cabecera['autretencion1'])) ;

            $transaccion =   trim($Array_Cabecera['transaccion'] );
            $codigoe     =   trim($Array_Cabecera['codigoe'] );
          
            $bandera = 0;

         
            if (  $transaccion  == 'E' ) {
                        $bandera = 1;
            } 

            if (  $codigoe > 0 ) {
                      $bandera = 1;
            } 

            
            if ($bandera  ==  0) {

            
                require "RideSRI20/XmlDoc.php" ;

                if ( empty(trim($Array_Cabecera['secretencion1']))){
            
                    $comprobante = $this->K_comprobante( );
                    
                }else{
                    
                    $comprobante = trim($Array_Cabecera['secretencion1']);
                    
                }
 
                $data=XmlDoc::createClaveAcceso($Array_Cabecera['fecharegistro'],
                     "7",
                     $this->ruc,
                     $ambiente,
                     $serie,
                     $comprobante,
                     $id,
                     1);
          
                 
                   
                 $this->valida = 0;     
             
                 $sql = "UPDATE co_compras
                 SET 	autretencion1=".$this->bd->sqlvalue_inyeccion($data, true).",
                         secretencion1=".$this->bd->sqlvalue_inyeccion($comprobante, true)."
                   WHERE id_compras=".$this->bd->sqlvalue_inyeccion($id, true);
 
                 
                $this->bd->ejecutar($sql);
            
                 
             }else{
                
                 $this->valida = 1;  
                 $data        = $Array_Cabecera['autretencion1'];
                  
             }
            

             return $data ;
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

        if ( $this->valida == 0){
            $this->xml_creacion( $id,$data);
         }
    }
 //----------------
 function _fecha( $fecha_dato){

 $trozos = explode("-", $fecha_dato,3);
 $anio         = $trozos[0];
 $mes          =  $trozos[1];
 $dia          =  $trozos[2];
 $fechaemision = $dia.'/'.$mes.'/'.$anio;

 return  $fechaemision ;
 
}
//------------------

function _query_fuente( $estado, $id){

     
    if (  trim($estado) == 'X'){

        $sql_det = "select '1' as codigo, 
                    codretair as  codigoretencion, 
                    baseimpair  as baseimponible,
                    round(porcentajeair,2)     as porcentajeretener,
                    valretair as valorretenido,
                    '01' as coddocsustento,
                    secuencial
            FROM  co_compras_f
            where id_compras = ".$this->bd->sqlvalue_inyeccion($id, true)." 
        union
        SELECT '2' as codigo, 
                (porcentaje_iva::text) as  codigoretencion, 
                montoiva  as baseimponible,
                cast(porcentaje as int)as porcentajeretener,
                retencion as valorretenido,
                '01' as coddocsustento,secuencial
        FROM  view_anexos_iva
        where grupo = 'S' and referencia = ".$this->bd->sqlvalue_inyeccion($id, true);

    
    }    
     else {

    $sql_det = "select '1' as codigo, 
                    codretair as  codigoretencion, 
                    baseimpair  as baseimponible,
                    round(porcentajeair,2)     as porcentajeretener,
                    valretair as valorretenido,
                    '01' as coddocsustento
            FROM  view_anexos_fuente
            where id_compras = ".$this->bd->sqlvalue_inyeccion($id, true)." 
            union
            SELECT '2' as codigo, 
                    (porcentaje_iva::text) as  codigoretencion, 
                    montoiva  as baseimponible,
                    cast(porcentaje as int)as porcentajeretener,
                    retencion as valorretenido,
                    '01' as coddocsustento
            FROM  view_anexos_iva
            where id_compras = ".$this->bd->sqlvalue_inyeccion($id, true);
        } 

    $stmt1              = $this->bd->ejecutar($sql_det);
   
    return  $stmt1 ;
    
   }

 //----------------
 function _informacion_adicional( $Array_Cabecera,$ADato){

 
    $detalle = 'Adquisicion compra referencia nro.'.$Array_Cabecera['secuencial'];
        
    if (!empty($Array_Cabecera['detalle'])){
        $detalle = $detalle.' '.$Array_Cabecera['detalle'];
    }
    if (  trim($Array_Cabecera['estado']) == 'X'){
     $detalle = 'Adquisicion compra referencia nro.'.$Array_Cabecera['detalle'];
    }    

    $infoAdic=array(
                'campoAdicional'=>array(
                    array( '@attributes' => array('nombre' => "Direccion"), '@value' => trim($Array_Cabecera['direccion'])),
                    array( '@attributes' => array('nombre' => "Email"), '@value' => trim($Array_Cabecera['correo'])),
                    array( '@attributes' => array('nombre' => "Observacion"), '@value' => trim( $detalle))  
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


    return   $infoAdic ;
    
   }
 //----------------
 function _tipo_identificacion( $idprov){

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
     }
   
    return  $tipoidentificacioncomprador ;
    
   }
    //---------------

    function xml_creacion( $id,$data){


        $ADatos       =  $this->bd->query_array(  'web_registro',  '*', 'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)  );
        $estab        =  trim($ADatos['estab'] )  ;
        $ptoEmi       =  '001';
        $ambiente     =  $ADatos['ambiente'];
 
        //---------------- cliente factura ----------------------
      
        $Array_Cabecera = $this->bd->query_array( 'view_anexos_compras','*','id_compras ='.$this->bd->sqlvalue_inyeccion($id,true));

        require_once("./RideSRI20/XmlDoc.php");
 
        $ruta       =  $this->bd->_url_externo(72); // ruta xml 
          
        $dir        =  explode("Sucursal", $ADatos['direccion']);
        $direccion  =  $dir[0]; // piece1
        $sucursal   =  $dir[1]; // piece1
        
        if (empty($sucursal)){
            $sucursal = $direccion;
        }
        $fechaemision          = $this->_fecha($Array_Cabecera['fechaemision']);
        $fechaRegistroContable = $this->_fecha($Array_Cabecera['fecharegistro']);
        
        $total_sin          =  $Array_Cabecera['basenograiva'] + $Array_Cabecera['baseimponible']  + $Array_Cabecera['baseimpgrav'] ;
        $total_con          =  $total_sin  + $Array_Cabecera['montoiva'] ;
        $base_iva           =  $Array_Cabecera['baseimpgrav'];
        $montoiva           =  $Array_Cabecera['montoiva'];
        $numAutDocSustento  =  trim($Array_Cabecera['autorizacion'] )  ;
        $numDocSustento     =  $Array_Cabecera['establecimiento'] .$Array_Cabecera['puntoemision'] .$Array_Cabecera['secuencial'] ;
        
        
        $regimen                     = 'CONTRIBUYENTE RÉGIMEN RIMPE';
        $idprov                      =  trim( $Array_Cabecera['idprov'] );
        $tipoidentificacioncomprador =  $this->tipo_contribuyente( $idprov ) ;
        
        // infoTributaria
        $infoTrib=array(
            'ambiente' => 		$ambiente,
            'tipoEmision' => 	"1",
            'razonSocial' => 	trim($ADatos['razon']),
            'nombreComercial' =>trim($ADatos['comercial']),
            'ruc' => 			trim($ADatos['ruc_registro']),
            'claveAcceso' => 	trim($data), 
            'codDoc' => 		"07",
            'estab' => 			trim($estab),
            'ptoEmi' => 		trim($ptoEmi),
            'secuencial' => 	trim($Array_Cabecera['secretencion1']),
            'dirMatriz' => 		trim($ADatos['direccion']),
        );
  

        $infoAdic = $this->_informacion_adicional($Array_Cabecera,$ADatos);
 
        $tipoidentificacioncomprador = $this->_tipo_identificacion($idprov);
        $fecha                       = $this->_fecha($Array_Cabecera['fecharegistro']);

        $trozos                      = explode("-", $Array_Cabecera['fecharegistro'],3);
        $anio = $trozos[0];
        $mes =  $trozos[1];
        $periodoFiscal =  $mes.'/'.$anio;

        $infoFact=array(
            'fechaEmision' => $fecha,
            'dirEstablecimiento' => trim($ADatos['direccion']),
            'obligadoContabilidad' => $ADatos['obligado'],
            'tipoIdentificacionSujetoRetenido' => $tipoidentificacioncomprador,
            'parteRel' => 'SI',
            'razonSocialSujetoRetenido' => trim($Array_Cabecera['razon']),
            'identificacionSujetoRetenido' =>trim($idprov),
            'periodoFiscal' => $periodoFiscal
        );


        if (  trim($Array_Cabecera['estado']) == 'X'){

            $sql = "select * 
                      from view_anexos_compras  
                      where coalesce(codigoe,0) = 0 and referencia = ".$this->bd->sqlvalue_inyeccion($id, true);
        
            $stmtq              = $this->bd->ejecutar($sql);
            
            $docsSustento1  = array("docSustento"=>array());

            while ($x_compras=$this->bd->obtener_fila($stmtq)){
 

                    $numDocSustento  = $x_compras['establecimiento'] .$x_compras['puntoemision'] .$x_compras['secuencial'] ;
                    $fechaemision          = $this->_fecha($x_compras['fechaemision']);
                    $fechaRegistroContable = $this->_fecha($x_compras['fecharegistro']);
                    
                    $total_sin          =  $x_compras['basenograiva'] + $x_compras['baseimponible']  + $x_compras['baseimpgrav'] ;
                    $total_con          =  $total_sin  + $x_compras['montoiva'] ;
                    $base_iva           =  $x_compras['baseimpgrav'];
                    $montoiva           =  $x_compras['montoiva'];


                    $idcompras =  $x_compras['id_compras'];

                    $pagos          = array("pago"=>array());
                         
                    array_push($pagos['pago'],
                        array(
                            'formaPago' => '01',
                            'total' =>  $total_con
                        ));

                        $impuestosiva       = array("impuestoDocSustento"=>array());
                        $codigoPorcentaje   = '2';
                        
                        array_push($impuestosiva['impuestoDocSustento'],
                            array(
                                'codImpuestoDocSustento' => '2',
                                'codigoPorcentaje' => $codigoPorcentaje ,
                                'baseImponible' =>$base_iva,
                                'tarifa' => '12',
                                'valorImpuesto' => $montoiva,
                            ));   

                            $stmt_deta  = $this->_query_fuente('S',$idcompras);
 
                            $impuestos    = array("retencion"=>array());
             
                             while ($x_det=$this->bd->obtener_fila($stmt_deta)){
                                             
                                             array_push($impuestos['retencion'],
                                                 array(
                                                     'codigo' => $x_det['codigo'],
                                                     'codigoRetencion' => trim($x_det['codigoretencion']),
                                                     'baseImponible' => round($x_det['baseimponible'],2),
                                                     'porcentajeRetener' => round($x_det['porcentajeretener'],2),
                                                     'valorRetenido' => round($x_det['valorretenido'],2),
                                                 ));
                          }
                       


                            array_push($docsSustento1['docSustento'],
                            array(
                                'codSustento' =>  '01' ,
                                'codDocSustento'=>  '01' ,
                                'numDocSustento' => $numDocSustento ,
                                'fechaEmisionDocSustento' => $fechaemision,
                                'fechaRegistroContable' => $fechaRegistroContable,
                                'numAutDocSustento' => $numAutDocSustento,
                                'pagoLocExt' => '01',
                                'totalComprobantesReembolso' => $total_con,
                                'totalBaseImponibleReembolso' =>$total_sin,
                                'totalImpuestoReembolso' =>  $montoiva ,
                                'totalSinImpuestos' => $total_sin,
                                'importeTotal' =>  $total_con,
                                'impuestosDocSustento'  => $impuestosiva,
                                'retenciones' => $impuestos,
                                'pagos' => $pagos
                            ));




                }    

        }    
         else {
                       $stmt1  = $this->_query_fuente($Array_Cabecera['estado'],$id);
 
                       $impuestos    = array("retencion"=>array());
        
                        while ($x=$this->bd->obtener_fila($stmt1)){
                                        
                                        array_push($impuestos['retencion'],
                                            array(
                                                'codigo' => $x['codigo'],
                                                'codigoRetencion' => trim($x['codigoretencion']),
                                                'baseImponible' => round($x['baseimponible'],2),
                                                'porcentajeRetener' => round($x['porcentajeretener'],2),
                                                'valorRetenido' => round($x['valorretenido'],2),
                                            ));
                     }
                  

                     $impuestosiva       = array("impuestoDocSustento"=>array());
                     $codigoPorcentaje   = '2';
                     
                     array_push($impuestosiva['impuestoDocSustento'],
                         array(
                             'codImpuestoDocSustento' => '2',
                             'codigoPorcentaje' => $codigoPorcentaje ,
                             'baseImponible' =>$base_iva,
                             'tarifa' => '12',
                             'valorImpuesto' => $montoiva,
                         ));


                         $docsSustento1  = array("docSustento"=>array());
                         $reembolsos     = array("reembolsos"=>array());
                         $pagos          = array("pago"=>array());
                         
                         array_push($pagos['pago'],
                             array(
                                 'formaPago' => '01',
                                 'total' =>  $total_con
                             ));
                         
                         $numDocSustento  = $Array_Cabecera['establecimiento'] .$Array_Cabecera['puntoemision'] .$Array_Cabecera['secuencial'] ;
      
                         array_push($docsSustento1['docSustento'],
                            array(
                                'codSustento' =>  '01' ,
                                'codDocSustento'=>  '01' ,
                                'numDocSustento' => $numDocSustento ,
                                'fechaEmisionDocSustento' => $fechaemision,
                                'fechaRegistroContable' => $fechaRegistroContable,
                                'numAutDocSustento' => $numAutDocSustento,
                                'pagoLocExt' => '01',
                                'totalComprobantesReembolso' => $total_con,
                                'totalBaseImponibleReembolso' =>$total_sin,
                                'totalImpuestoReembolso' =>  $montoiva ,
                                'totalSinImpuestos' => $total_sin,
                                'importeTotal' =>  $total_con,
                                'impuestosDocSustento'  => $impuestosiva,
                                'retenciones' => $impuestos,
                                'pagos' => $pagos
                            ));
            } 

    
            
//	-<comprobanteRetencion id="comprobante" version="1.0.0">
            $factura = array(
                'infoTributaria' => $infoTrib,
                'infoCompRetencion' => 	$infoFact,
                'docsSustento' => 		$docsSustento1,
                'infoAdicional' => 	$infoAdic
            );
            
            $ruta = 'xml/';
            
            $factura['infoTributaria']['claveAcceso']= $data ;
            
            XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea
            XmlDoc::cleanEspecialCharacters($factura/*, array('&',"'","\"", '<', '>'), array("&amp;", "&apos;", "&quot;", "&lt;", "&gt;")*/); // Limpia algunos caracteres especiales
            $xml=XmlDoc::createDocElect("comprobanteRetencion", '2.0.0', $factura); // crea objeto xml
            
            $xml->saveFormatedXML($ruta.$factura['infoTributaria']['claveAcceso'].'.xml',false,false);
            
            
            header("Content-Type: application/xml; charset=utf-8");
            
            echo $xml->saveXML();
 

    }
    //-----------------------------------
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
 	 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new _crearXMLComprobante;
 
    $id				=   $_GET["id_asiento"];

    $data = 'Emision del comprobante electronico'; 
   
   $data = $gestion->Crear_autorizacion( $id);

   $gestion->genera_archivo( $id,$data);
 
    echo $data;
	
 
?>