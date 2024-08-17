<?php
session_start();
date_default_timezone_set('UTC');
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale (LC_TIME,"spanish");
 
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../kconfig/Db.class.php';  

class proceso{
	
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
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
        $this->bd	   =	new Db ;
		
		$this->ruc       =  trim($_SESSION['ruc_registro']);
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		$this->bd->conectar('postgres','db_kaipi','Cbsd2019');
        $this->valida = 0; 
	}
   
	//--- calcula libro diario

	function Crear_autorizacion( $id){
		
            $ADatos       =  $this->bd->query_array(  'web_registro',  '*', 'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)  );

            $estab        =  $this->_establecimiento( trim($ADatos['estab'] ))  ;

            $ptoEmi       =  '001';
            $ambiente     =  $ADatos['ambiente'];
            $serie        =  trim($estab).trim($ptoEmi);

   
            //---------------- cliente factura ----------------------
            $Array_Cabecera = $this->bd->query_array( 'rentas.view_ren_factura','*','id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true));
	        $longitud       = strlen(trim($Array_Cabecera['autorizacion'])) ;

            if ($longitud  < 2) {

                require "RideSRI/XmlDoc.php" ;

                $tipo_secuencia = $this->_establecimiento_tipo( trim($estab)   );

                if (  $tipo_secuencia == 1 ){
                    $secuencial = $this->K_comprobante_usuario(  trim($estab)   );
                }else{
                    $secuencial = $this->K_comprobante();
                }

               
               
                 $data=XmlDoc::createClaveAcceso($Array_Cabecera['fecha'],
                     "1",
                     $this->ruc,
                     $ambiente,
                     $serie,
                     $secuencial,
                     $id,
                     1);
                 
                   
                 $this->valida = 0;     
             
                 $sql = "UPDATE rentas.ren_movimiento
                                  SET autorizacion=".$this->bd->sqlvalue_inyeccion($data, true).",
                                      envio = ".$this->bd->sqlvalue_inyeccion('P', true).",
                                      secuencial=".$this->bd->sqlvalue_inyeccion($secuencial, true)."
                                WHERE id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
                 
                $this->bd->ejecutar($sql);
             
                 
             }else{
                
                 $this->valida = 1;  
                 $data        = $Array_Cabecera['autorizacion'];
                  
             }

             return $data ;
	}
/*
*/
function K_comprobante_usuario(  $estab ){
	 

    $secuencia           =  $this->bd->query_array(  'wk_config',  
    'modulo,carpetasub as secuencia', 
    'formato='.$this->bd->sqlvalue_inyeccion('SI' ,true)  .' and 
     modulo ='.$this->bd->sqlvalue_inyeccion(trim(  $estab ),true)
  );
 
	        
 
     
    $contador = $secuencia['secuencia'] + 1;
    
    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
    
    
    $sqlEdit = "UPDATE wk_config
               SET 	carpetasub=".$this->bd->sqlvalue_inyeccion($contador, true)."
              WHERE modulo=".$this->bd->sqlvalue_inyeccion(trim( $estab ), true);
    
    
    $this->bd->ejecutar($sqlEdit);
    
    return $input ;
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

        // echo $this->valida;
        $this->valida = 0;
       if ( $this->valida == 0){
            $this->xml_creacion( $id,$data);
       }
    }

    //---------------
    function _establecimiento_tipo( $estab   ){


        $ADatosUser       =  $this->bd->query_array(  'par_usuario',  'establecimiento', 'email='.$this->bd->sqlvalue_inyeccion(  $this->sesion ,true)  );

        $valida           =  $this->bd->query_array(  'wk_config',  
                                                      'count(*) as nn', 
                                                      'formato='.$this->bd->sqlvalue_inyeccion('SI' ,true)  .' and 
                                                       modulo ='.$this->bd->sqlvalue_inyeccion(trim($ADatosUser['establecimiento'] ),true)
                                                    );       

      if (  $valida['nn']  > 0 ){
     
        $valida_esta           =  $this->bd->query_array(  'wk_config',  
                                                      'modulo,carpetasub', 
                                                      'formato='.$this->bd->sqlvalue_inyeccion('SI' ,true)  .' and 
                                                       modulo ='.$this->bd->sqlvalue_inyeccion(trim($ADatosUser['establecimiento'] ),true)
                                                    );

        return 1 ;                                          

     }else
      {
    
        return 0 ;
    }
                                                    

    }
    //---------------
    function _establecimiento( $estab   ){


        $ADatosUser       =  $this->bd->query_array(  'par_usuario',  'establecimiento', 'email='.$this->bd->sqlvalue_inyeccion(  $this->sesion ,true)  );

        $valida           =  $this->bd->query_array(  'wk_config',  
                                                      'count(*) as nn', 
                                                      'formato='.$this->bd->sqlvalue_inyeccion('SI' ,true)  .' and 
                                                       modulo ='.$this->bd->sqlvalue_inyeccion(trim($ADatosUser['establecimiento'] ),true)
                                                    );       

      if (  $valida['nn']  > 0 ){
     
        $valida_esta           =  $this->bd->query_array(  'wk_config',  
                                                      'modulo,carpetasub', 
                                                      'formato='.$this->bd->sqlvalue_inyeccion('SI' ,true)  .' and 
                                                       modulo ='.$this->bd->sqlvalue_inyeccion(trim($ADatosUser['establecimiento'] ),true)
                                                    );

        return trim($valida_esta['modulo']);                                          

     }else
      {
    
        return $estab  ;
    }
                                                    

    }
    //---------------


    function xml_creacion( $id,$data){


        $ADatos       =  $this->bd->query_array(  'web_registro',  '*', 'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)  );

        $estab        =  $this->_establecimiento( trim($ADatos['estab'] ))  ;
        
        $ptoEmi       =  '001';
        
        $ambiente     =  $ADatos['ambiente'];

        $serie        =  trim($estab).trim($ptoEmi);

        //---------------- cliente factura ----------------------
      
        $Array_Cabecera = $this->bd->query_array( 'rentas.view_ren_factura','*','id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true));
   
        require_once("./RideSRI/XmlDoc.php");
       
        $ruta       =  $this->bd->_url_externo(72); // ruta xml 

 
         
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
                'secuencial' => 	trim($Array_Cabecera['secuencial']),
                'dirMatriz' => 		$direccion
        );

 
        $valida_placa = trim($Array_Cabecera['novedad']);
        $existe_valida = strlen( $valida_placa );

        $placa = ' ';
        if (  $existe_valida > 0 ) {
            $placa = ' Nro.Placa '. $valida_placa ;
        }
        $detalle = trim($Array_Cabecera['detalle']). $placa;

                $infoAdic=array(
                    'campoAdicional'=>array(
                        array( '@attributes' => array('nombre' => "Direccion"), '@value' => trim($Array_Cabecera['direccion'])),
                        array( '@attributes' => array('nombre' => "Email"), '@value' => trim($Array_Cabecera['correo'])),
                        array( '@attributes' => array('nombre' => "Observacion"), '@value' =>substr($detalle , 0, 299) )  
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
        $sql_det = 'SELECT   idproducto_ser as id, idproducto_ser as codigo, 
                             substring(servicio,0,299) as producto, 
                             unidad,
                             cantidad, 
                             costo, 
                             total, 
                             monto_iva,
                             tarifa_cero, 
                             tributo, 
                             baseiva,
                             coalesce(descuento,0)  as descuento
                      FROM  rentas.view_ren_factura_detalle
                     where id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);

        $stmt1              = $this->bd->ejecutar($sql_det);
        $importeTotal       = 0;
        $totalSinImpuestos  = 0;

 

        // infoFactura
        $detalles=array("detalle"=>array());



        while ($x=$this->bd->obtener_fila($stmt1)){   
                $importeTotal =  round($x['total'],2) ;
                $monto_iva    =  round($x['monto_iva'],2) ;
                $cantidad     =  $x['cantidad'] ;
                $tarifa_cero  =  $x['tarifa_cero'] ;
                $base         =  $x['baseiva'] ;
                $descuento    =  $x['descuento'] ;
                $costo        =  $x['costo'] ;

                 //-----------------------------------------------------
                if( trim($x['tributo']) ==  'I' ){
                    $codigoporcentaje       = '4';
                    $baseimponible          = $base;
                    $valor                  = round($monto_iva  ,2);
                    $tarifa                 = 15;
                }
                if(  trim($x['tributo'])  == 'T' ){
                    $codigoporcentaje       = '0';
                    $baseimponible          = round($tarifa_cero,2);
                    $valor                  = '0';
                    $tarifa                 =  0;
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
                  $totalsiniva        =  $x['baseiva'] + $x['tarifa_cero'] ;
             //   $totalSinImpuestos  =  $totalSinImpuestos + $totalsiniva;
                $producto           =  trim($x['producto']);

                array_push($detalles['detalle'],array(
                    'codigoPrincipal' => $x['id'],
                    'descripcion' => $producto ,
                    'cantidad' => $cantidad,
                    'precioUnitario' => round($costo,2),
                    'descuento' =>$descuento,
                    'precioTotalSinImpuesto' =>$totalsiniva,
                    'impuestos' => $impuestos
                ));

                $descuento = 0;
        }
        //------------------------------------------------------------------------------
       
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
       
 

        $sql_det1   = 'SELECT tributo, sum(total) as total, sum(monto_iva) as monto_iva,
                            sum(tarifa_cero) as tarifa_cero, sum(baseiva) as baseiva, 
                            sum(coalesce(descuento,0)) as descuento
                      FROM  rentas.view_ren_factura_detalle
                     where id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true).' group by tributo';

        $stmt2      = $this->bd->ejecutar($sql_det1);

      
        $descuento  = 0;
        $totalpago = 0;
        $importeTotaldatos = 0;
        $totalSinImpuestos = 0;

        $totalImp          = array('totalImpuesto'=>array());

        while ($x=$this->bd->obtener_fila($stmt2)){

                        $monto_iva    = round($x['monto_iva'],2) ;
                        $tarifa_cero  = $x['tarifa_cero'] ;
                        $base         = $x['baseiva'] ;
                       
                     
                        //-----------------------------------------------------
                        if( trim($x['tributo']) ==  'I' ){
                            $codigoporcentaje1 = '4';
                            $baseimponible1  = round($base,2);
                            $valor1          = round($monto_iva,2);
                            $tarifa          = 15;
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
                            'codigoPorcentaje' => $codigoporcentaje1,
                            'baseImponible' => round($baseimponible1,2),
                            'valor' => $valor1
                        ));
 
                        $totalSinImpuestos =    $totalSinImpuestos  + ( $tarifa_cero  +   $base);  
                        $importeTotaldatos =   $importeTotaldatos + $x['total'] ;
                        $descuento         =   $descuento + $x['descuento'] ;
        }

        ///-------------------------------------
        $trozos = explode("-", $Array_Cabecera['fecha'],3);
        $anio   = $trozos[0];
        $mes    =  $trozos[1];
        $dia    =  $trozos[2];
        $fecha = $dia.'/'.$mes.'/'.$anio;

      //  $importeTotaldatos =  round($totalpago,2) -  round($descuento,2);


        $infoFact=array(
            'fechaEmision' => $fecha,
            'dirEstablecimiento' => trim($sucursal),
            'obligadoContabilidad' => $ADatos['obligado'],
            'tipoIdentificacionComprador' => $tipoidentificacioncomprador,
            'razonSocialComprador' => trim($Array_Cabecera['razon']),
            'identificacionComprador' =>$idprov,
            'totalSinImpuestos' => $totalSinImpuestos,
            'totalDescuento' =>  $descuento,
            'totalConImpuestos' => $totalImp,
            'propina' => "0.00",
            'importeTotal' => $importeTotaldatos,
            'moneda' => "DOLAR",
            'pagos' => array(
                'pago' => array(
                    array(
                        'formaPago' => "01",
                        'total' => $importeTotaldatos
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
 
        $factura['infoTributaria']['claveAcceso']= $data ;

        XmlDoc::cleanSaltosLinea($factura); // Limpia saltos de linea

        $xml=XmlDoc::createDocElect("factura",'2.1.0',$factura); // crea objeto xml

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

$gestion   = 	new proceso;
 
    $id				=   $_GET["id"];

    $data = 'Emision del comprobante electronico'; 
   
    $data = $gestion->Crear_autorizacion( $id);

 

    $gestion->genera_archivo( $id,$data);
 
    echo $data;
	
 
?>