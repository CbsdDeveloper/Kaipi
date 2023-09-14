<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    private $saldos;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    
    private $ATabla;
    private $tabla ;
    private $secuencia;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _compras_mensual( $anio,$mes ){
        
        $sql ="update co_compras
                  set serie1='001001',  fechaemiret1=fecharegistro
                where serie1 is null";
        
        $this->bd->ejecutar($sql);
        
        
        
        $sql ="delete from co_compras_f   where codretair = '-' ";
        $this->bd->ejecutar($sql);
        
        
        
        $sql = "SELECT  V.codsustento,
                    V.tpidprov AS tpidprov,
                    V.idprov AS idprov,
                    V.tipocomprobante ,
                    V.fecharegistro ,
                    V.establecimiento ,
                    V.puntoemision ,
                    V.secuencial ,
                    V.fechaemision ,
                    V.autorizacion ,
                    basenograiva,
                   baseimponible  ,
                  baseimpgrav  ,
                   montoice  ,
                  montoiva,
                  valorretbienes ,
                  valorretservicios,
                  valretserv100 ,
                  pagoLocExt,
                  paisEfecPago as paisefecpago  ,
                  faplicconvdobtrib ,
                  fpagextsujretnorleg ,
                  formadepago,
                     '-' AS codretair,
                    0 AS baseimpair,
                    1 AS porcentajeair,
                    0 AS valretair,
                   '-' AS codRetair1,
                    0 AS baseimpair2,
                    1 AS porcentajeair2,
                    0 AS valretair2,
                    substr(V.serie1, 1, 3)  as estabretencion1,
                    substr(V.serie1, 4, 3)  as ptoemiretencion1,
                    secretencion1,
                    autretencion1,
                    fechaemiret1,
                    CASE WHEN porcentaje_iva= 5 THEN valorretservicios   ELSE  0 end as valorretservicios20,
                    CASE WHEN porcentaje_iva= 4 THEN valorretbienes   ELSE  0 end as valorbienes10,
                    id_compras,razon,
                    docmodificado,
                    secmodificado,
                    estabmodificado,
                    autmodificado
             FROM view_anexos_compras V
             WHERE V.mes = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                   V.estado = ".$this->bd->sqlvalue_inyeccion('S',true)." and
                   V.registro = ".$this->bd->sqlvalue_inyeccion( $this->ruc,true)." and
                   V.anio=".$this->bd->sqlvalue_inyeccion($anio,true);
        
    

         $stmt = $this->bd->ejecutar($sql);
        
        return   $stmt;
        
    }
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _empresa( $anio,$mes  ){
        
        $sql = "SELECT razon,felectronica,estab
				FROM web_registro
				where ruc_registro = ".$this->bd->sqlvalue_inyeccion(  $this->ruc,true);
        
        $resultado = $this->bd->ejecutar($sql);
        $datos     = $this->bd->obtener_array( $resultado);
        
        $sql_EDIT = 'update co_ventas 
                        set codestab = '.$this->bd->sqlvalue_inyeccion($datos['estab'],true)."
                      where date_part('month'::text, fechaemision)  = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                            registro    = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                            date_part('year'::text, fechaemision)   = ".$this->bd->sqlvalue_inyeccion($anio,true);
        
 
        
        $this->bd->ejecutar($sql_EDIT);
        
        
        if ($datos['felectronica'] == 'S') {
            
            $sql_EDIT = 'update co_ventas
                        set tipoemision = '.$this->bd->sqlvalue_inyeccion('E',true)."
                       where date_part('month'::text, fechaemision)  = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                            registro    = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                            date_part('year'::text, fechaemision)   = ".$this->bd->sqlvalue_inyeccion($anio,true);
              
            $this->bd->ejecutar($sql_EDIT);
        }
         
        $sql_EDIT = 'update co_ventas
                        set tipoemision = '.$this->bd->sqlvalue_inyeccion('F',true)."
                      where basenograiva > ".$this->bd->sqlvalue_inyeccion(0,true)." AND 
                            date_part('month'::text, fechaemision)  = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                            registro    = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                            date_part('year'::text, fechaemision)   = ".$this->bd->sqlvalue_inyeccion($anio,true);
        
        $this->bd->ejecutar($sql_EDIT);
         
        
        
        return $datos;
        
    }
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($anio,$mes ){
        
         $datos           = $this->_empresa($anio,$mes);
         $razon           = $this->bd->eliminar_simbolos($datos['razon']);
         $ventas          = $this->_ventas($anio,$mes);
         $ventas_existe   = $ventas['siventa'];
         $anulado_existe  = $this->_anulados( $anio,$mes);
        
       
        $stmt           = $this->_compras_mensual($anio,$mes);
        $stmt_ventas    = $this->genera_ventas( $anio,$mes);
        $stmt_anulado   = $this->genera_anulados( $anio,$mes);
        
    
        
        print '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
        print '<iva>';
        print '<TipoIDInformante>R</TipoIDInformante>';
        print '<IdInformante>'.$this->ruc.'</IdInformante>';
        print '<razonSocial>'.trim($razon).'</razonSocial>';
        print '<Anio>'.$anio.'</Anio>';
        print '<Mes>'.$mes.'</Mes>';
        
        print '<numEstabRuc>'.$datos['estab'].'</numEstabRuc>';
        print '<totalVentas>'.trim(str_replace(',','.',$ventas['total'])).'</totalVentas>' ;
        
 
        print '<codigoOperativo>IVA</codigoOperativo>';
        print  '<compras>';
 
        while ($x=$this->bd->obtener_fila($stmt)){
            print  '<detalleCompras>';
            print  '<codSustento>'.$this->idsus(trim($x['idprov']), $x['codsustento']).'</codSustento>';
          
     
            $tipo = $this->idtipo(trim($x['idprov']), '');
            $ba = 0;
            print  '<tpIdProv>'.$this->idruc($x['idprov']).'</tpIdProv>';
            print  '<idProv>'.trim($x['idprov']).'</idProv>';
            $tipo = ltrim(rtrim($x['tipocomprobante']));
           
            if (empty($x['tipocomprobante'])){
                $tipo = '01';
            }
            
            print  '<tipoComprobante>'. $tipo.'</tipoComprobante>';
            /*
            if ($tipo=='03'){
                if (idruc($x['idprov']) == '03'){
                    print  '<tipoProv>02</tipoProv>';
                    print  '<denoProv>'.str_replace('.','',trim($x['razon'])).'</denoProv>';
                    $ba = 1;
                }else{

                }    
            }
            */
            if ($tipo=='15'){
                     print  '<tipoProv>01</tipoProv>';
                     print  '<denoProv>'.str_replace('.','',trim($x['razon'])).'</denoProv>';
                    $ba = 1;
             }
         
            if ($x['codretair'] == '332'){
                print  '<parteRel>NO</parteRel>';
            }
            else{
                if ($ba == 1){
                    print  '<parteRel>NO</parteRel>';
                }else {
                    print  '<parteRel>SI</parteRel>';
                }
            }
           
            print  '<fechaRegistro>'.$this->idfecha($x['fecharegistro']).'</fechaRegistro>';
            print  '<establecimiento>'.$x['establecimiento'].'</establecimiento>';
            print  '<puntoEmision>'.$x['puntoemision'].'</puntoEmision>';
            print  '<secuencial>'.$x['secuencial'].'</secuencial>';
            print  '<fechaEmision>'.$this->idfecha($x['fechaemision']).'</fechaEmision>';
            print  '<autorizacion>'.trim($x['autorizacion']).'</autorizacion>';
            print  '<baseNoGraIva>'. trim(str_replace(',','.',$x['basenograiva'])). '</baseNoGraIva>';
            print  '<baseImponible>'. trim(str_replace(',','.',$x['baseimponible'])). '</baseImponible>';
            print  '<baseImpGrav>'.trim(str_replace(',','.',$x['baseimpgrav'])). '</baseImpGrav>';
            print  '<baseImpExe>0.00</baseImpExe>';
            print  '<montoIce>'.trim(str_replace(',','.',$x['montoice'])).'</montoIce>';
            print  '<montoIva>'.trim(str_replace(',','.',$x['montoiva'])).'</montoIva>';
            print  '<valRetBien10>'.trim(str_replace(',','.',$x['valorbienes10'])).'</valRetBien10>';
            print  '<valRetServ20>'.trim(str_replace(',','.',$x['valorretservicios20'])).'</valRetServ20>';
            print  '<valorRetBienes>'. trim(str_replace(',','.',$x['valorretbienes'])).'</valorRetBienes>';
            print  '<valRetServ50>'.'0.00'.'</valRetServ50>';
            print  '<valorRetServicios>'. trim(str_replace(',','.',$x['valorretservicios'])).'</valorRetServicios>';
            print  '<valRetServ100>'. trim(str_replace(',','.',$x['valretserv100'])).'</valRetServ100>';
            print  '<totbasesImpReemb>0.00</totbasesImpReemb>';
            
            print  '<pagoExterior>';
            $p = str_pad(trim($x['pagoLocExt']),2,'01');
            print  '<pagoLocExt>'.$p.'</pagoLocExt>';
            if ($p <> '01') {
                print  '<tipoRegi>01</tipoRegi>';
                print  '<paisEfecPagoGen>'.str_pad(trim($x['paisefecpago']),2,'NA').'</paisEfecPagoGen>';
            }
            print  '<paisEfecPago>'.str_pad(trim($x['paisefecpago']),2,'NA').'</paisEfecPago>';
            print  '<aplicConvDobTrib>'.str_pad(trim($x['faplicconvdobtrib']),2,'NA').'</aplicConvDobTrib>';
            print  '<pagExtSujRetNorLeg>'.str_pad(trim($x['fpagextsujretnorleg']),2,'NA').'</pagExtSujRetNorLeg>';
            print  '</pagoExterior>';
    
            // FORMA DE PAGO
            if ( ($x['basenograiva'] + $x['baseimponible'] + $x['baseimpgrav'] + $x['montoiva'] >= 1000) && $x['tipocomprobante'] == '01'  ){
                print  '<formasDePago>';
                print  '<formaPago>'.str_pad(trim($x['formadepago']),2,'01').'</formaPago>';
                print  '</formasDePago>';
            }
          
            $exiteFuente =  $this->retencion(  $x['id_compras']  );
         
            IF ($exiteFuente  > 0)  {
                print  '<air>';
               
                $stmt_fuente = $this->genera_retencion(  $x['id_compras']  );
               
                while ($zz=$this->bd->obtener_fila($stmt_fuente))  {
                    
                    // codretair, baseimpair,porcentajeair, valretair
                   
                    $porcentaje = $zz['porcentajeair'];
                    $valretair  = $zz['valretair'];
                    $codRetAir  = trim($zz['codretair']);
                    
                    if ($zz['codretair'] == '332'){
                        $porcentaje = 0;
                        $valretair  = 0;
                    }
                    
                    if ($codRetAir == '341'){
                        $codRetAir =  '344';
                    }
                    print  '<detalleAir>';
                    print  '<codRetAir>'.trim($codRetAir).'</codRetAir>';
                    print  '<baseImpAir>'. trim(str_replace(',','.',$zz['baseimpair'])).'</baseImpAir>';
                    print  '<porcentajeAir>'.trim($porcentaje).'</porcentajeAir>';
                    print  '<valRetAir>'. trim(str_replace(',','.',$valretair)).'</valRetAir>';
                    print  '</detalleAir>';
                    
                  
                }   
                print  '</air>';
            }
  
            
            if (strlen($x['secretencion1'] > 8) ){
                print  '<estabRetencion1>'.trim($x['estabretencion1']).'</estabRetencion1>';
                print  '<ptoEmiRetencion1>'.trim($x['ptoemiretencion1']).'</ptoEmiRetencion1>';
                print  '<secRetencion1>'.trim($x['secretencion1']).'</secRetencion1>';
                print  '<autRetencion1>'.trim($x['autretencion1']).'</autRetencion1>';
                print  '<fechaEmiRet1>'.$this->idfecha($x['fechaemiret1']).'</fechaEmiRet1>';
            }

            // NOTAS DE CREDITO -> datos de documento moficiado
            if ( $tipo == '04'  ){
                print  '<docModificado>'.trim($x['docmodificado']).'</docModificado>';
                print  '<estabModificado>'.trim(substr($x['estabmodificado'],0,3)).'</estabModificado>';
                print  '<ptoEmiModificado>'.trim(substr($x['estabmodificado'],3,3)).'</ptoEmiModificado>';
                print  '<secModificado>'.trim($x['secmodificado']).'</secModificado>';
                print  '<autModificado>'.trim($x['autmodificado']).'</autModificado>';
            }
            print  '</detalleCompras>';
          
        }
        
        print  '</compras>';
        
      
       
        if ( $ventas_existe > 0 ) {
           
            print  '<ventas>';
            
            while ($x=$this->bd->obtener_fila($stmt_ventas))  {
                
                $tpIdCliente = $x['tpidcliente'];
                $RUCCED      = trim( $x['idcliente'] );
                $tpIdCliente =  $this->idruc_Vta ( $RUCCED  );
                
                print  '<detalleVentas>';
                print  '<tpIdCliente>'.trim($tpIdCliente).'</tpIdCliente>';
                print  '<idCliente>'.trim($RUCCED).'</idCliente>';
                
                if ($tpIdCliente <> '07'){
                    print  ' <parteRelVtas>NO</parteRelVtas>';
                }
                
                if ($tpIdCliente == '06'){
                    print  '<tipoCliente>02</tipoCliente>';
                    print  '<denoCli>SN</denoCli>';
                }
                print  '<tipoComprobante>'.trim($x['tipocomprobante']).'</tipoComprobante>';
                
                if ( $x['basenograiva'] > 0 ){
                    print  '<tipoEmision>'.'F'.'</tipoEmision>';
                }else  {
                    print  '<tipoEmision>'.'E'.'</tipoEmision>';
                }
                
                print  '<numeroComprobantes>'.trim(trim($x['numerocomprobantes'])).'</numeroComprobantes>';
                
                $monto = $x['basenograiva'] ;
                $var = number_format(abs($monto), 2, '.', '');
                print  '<baseNoGraIva>'.trim(str_replace(',','.',$var)).'</baseNoGraIva>';
                // ojo baseImpGrav
                $monto = $x['baseimponible'] ;
                $var = number_format(abs($monto), 2, '.', '');
                print  '<baseImponible>'.trim(str_replace(',','.',$var)).'</baseImponible>';
                
                $valor = abs($x['baseimpgrav']);
                $data2 = number_format(abs($valor), 2, '.', '');
                
                print  '<baseImpGrav>'.trim(str_replace(',','.',$data2)).'</baseImpGrav>';
                
                $monto_iva = $x['baseimpgrav'] * (12/100);
                $var = number_format(abs($monto_iva), 2, '.', '');
                
                print  '<montoIva>'.trim(str_replace(',','.',$var)).'</montoIva>';
                
                print  '<montoIce>0.00</montoIce>';
                // nuevo
               
                print  '<valorRetIva>'.trim(str_replace(',','.',$x['riva'])).'</valorRetIva>';
                print  '<valorRetRenta>'.trim(str_replace(',','.',$x['renta'])).'</valorRetRenta>';
 
                
                if ( trim($x['tipocomprobante']) == '18'){
                    if ($anio >  2016  ){
                        print  '<formasDePago>';
                        print  '<formaPago>'.trim($x['formapago']).'</formaPago>';
                        print  '</formasDePago>';
                    }
                    else
                    {
                        if ($anio ==  2016  ){
                            if ($mes >='06' ){
                                print  '<formasDePago>';
                                print  '<formaPago>'.trim($x['formapago']).'</formaPago>';
                                print  '</formasDePago>';
                            }
                        }
                    }
                }
                
                print  '</detalleVentas>';
            }
            print  '</ventas>';
 
            $stmt_ventasEstablecimiento   = $this->genera_ventas_resumen(  $anio, $mes);
            
            print  '<ventasEstablecimiento>';
            $i= 1;
            while ($x=$this->bd->obtener_fila($stmt_ventasEstablecimiento))  {
                print '<ventaEst>';
                print '<codEstab>'.$datos['estab'].'</codEstab>';
                print '<ventasEstab>'.str_replace(',','.',$x['total']).'</ventasEstab>';
                print '<ivaComp>0.00</ivaComp>';
                print '</ventaEst>';
                $i++;
            }
            if ( $i == 1 ) {
                print '<ventaEst>';
                print '<codEstab>'.$datos['estab'].'</codEstab>';
                print  '<ventasEstab>0</ventasEstab>';
                print '<ivaComp>0.00</ivaComp>';
                print '</ventaEst>';
            }
             
            print  '</ventasEstablecimiento>';
        }
       
        if ( $anulado_existe > 0 ){
            
            print  '<anulados>';
            
            while ($x=$this->bd->obtener_fila($stmt_anulado))  {
                
                print '<detalleAnulados>';
                print  '<tipoComprobante>'.trim($x['tipocomprobante']).'</tipoComprobante>';
                print  '<establecimiento>'.trim($x['establecimiento']).'</establecimiento>';
                print  '<puntoEmision>'.trim($x['puntoemision']).'</puntoEmision>';
                print  '<secuencialInicio>'.trim($x['secuencialinicio']).'</secuencialInicio>';
                print  '<secuencialFin>'.trim($x['secuencialfin']).'</secuencialFin>';
                print  '<autorizacion>'.trim($x['autorizacion']).'</autorizacion>';
                 print '</detalleAnulados>';
 
            }
            
            print  '</anulados>';
        }
        
        
        
        print '</iva>';
}
    //--------------------------------------------------------------------------------
    function _ventas($anio,$mes){
            
        $datos_ventas = array();
        
        $sql = "SELECT   sum(basenograiva) + sum(baseimponible) + sum(baseimpgrav) as total
            FROM view_anexos_ventas
            WHERE   mes         = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                    registro    = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                    anio        = ".$this->bd->sqlvalue_inyeccion($anio,true);
        
        $resultado = $this->bd->ejecutar($sql);
        $datos_ve  = $this->bd->obtener_array( $resultado);
        
        if ($datos_ve['total']	> 0 ) {
            
            $datos_ventas['siventa']	= 1 ;
        }
        else{
            $datos_ventas['siventa']	= 0;
        }
        
        
        //------------------------------------------------------------------------------------
        $sql = "SELECT   sum(basenograiva) + sum(baseimponible) + sum(baseimpgrav) as total  
            FROM view_anexos_ventas
            WHERE   mes         = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                    registro    = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                    tipoemision = ".$this->bd->sqlvalue_inyeccion( 'F' ,true)." and
                    anio        = ".$this->bd->sqlvalue_inyeccion($anio,true);
        
        $resultado = $this->bd->ejecutar($sql);
        $datos_tt  = $this->bd->obtener_array( $resultado);
         
        
        if ($datos_tt['total']	> 0 ) {
            
            $datos_ventas['total']	= 	$datos_tt['total']	 ;
        }
        else{
            $datos_ventas['total']	= 0.00 ;
        }
        
 
        return $datos_ventas;
        
    }
    //--------------------------------------------------------------------------------
    function genera_ventas_resumen( $anio, $mes ){
        
        
        $sql = "SELECT  codestab, sum(basenograiva) + sum(baseimponible) + sum(baseimpgrav) as total 
                FROM view_anexos_ventas
                WHERE   mes         = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                        registro    = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                        tipoemision = ".$this->bd->sqlvalue_inyeccion( 'F' ,true)." and
                        anio        = ".$this->bd->sqlvalue_inyeccion($anio,true)." 
                group by    codestab";
        
        
         $stmt_ventas1 = $this->bd->ejecutar($sql);
         
         return   $stmt_ventas1;
    }
    //----------------------------------------------------
    function generaxml( $anio,$mes ){
     
        $archivo = 'AT'.$mes.$anio.'.xml';
           
        return  $archivo;
    }
    //--------------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    function genera_ventas( $anio,$mes){
        
        $sql = " SELECT   A.tpidcliente,
    		  A.idcliente,
               A.tipocomprobante ,
               sum(A.numerocomprobantes) numerocomprobantes ,
               sum(COALESCE(A.basenograiva,0)) basenograiva,
               sum(COALESCE(A.baseimponible,0)) baseimponible,
               sum(COALESCE(A.baseimpgrav,0))  baseimpgrav,
               sum(COALESCE(A.montoiva,0)) montoiva,
               sum(COALESCE(A.valorretbienes,0))  + sum(COALESCE(A.valorretservicios,0) ) as riva,
                sum(COALESCE(A.valorretrenta,0)) AS renta,
    	        	MAX(tipoemision) AS tipoemision,
				   MAX(formapago)AS formapago,
				   'N' AS tipocompe,
				   SUM(COALESCE(montoice,0)) AS monto
            FROM view_anexos_ventas A
            WHERE A.mes = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                  A.registro = ".$this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                  A.anio =".$this->bd->sqlvalue_inyeccion($anio,true)."
            group by  A.tpidcliente, A.idcliente,   A.tipocomprobante ";
        
        $stmt_ventas = $this->bd->ejecutar($sql);
        
         
        return   $stmt_ventas;
        
    }
    //-- genera anulados
    function genera_anulados( $anio,$mes){
        
        
 
        $sql = "SELECT    tipocomprobante, comprobante, establecimiento,
        puntoemision, secuencialinicio, secuencialfin, autorizacion
            FROM view_anexos_anulado 
            WHERE  mes = ".$this->bd->sqlvalue_inyeccion($mes,true)." and
                   registro = ".$this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                   anio =".$this->bd->sqlvalue_inyeccion($anio,true) ;
        
        $stmt_anulado = $this->bd->ejecutar($sql);
        
        
        return   $stmt_anulado;
        
    }
    //---------------
    function _anulados( $anio,$mes){
        
        
        $datos = $this->bd->query_array('view_anexos_anulado',
                                        'count(*) as nn', 
                                        'mes='.$this->bd->sqlvalue_inyeccion($mes,true).' and 
                                        anio='.$this->bd->sqlvalue_inyeccion($anio,true)
            );
        
 
        
        
        return   $datos['nn'];
        
    }
    //--------------------------------------------------------------------------------
    function idsus ( $ruc,$codsustento  ){
        
        $ruc = trim($ruc);
        
        $lon = strlen($ruc);
        
        
        $tipo = $codsustento;
        
        
        if($lon == 10){
            if ($tipo == '01'){
                $tipo = '02';
            }
        }
        elseif($lon > 13){
            if ($tipo == '01'){
                $tipo = '02';
            }
        }
        elseif($lon < 10){
            if ($tipo == '01'){
                $tipo = '02';
            }
        }
        
        return $tipo;
    }
    //------------------------
    function idtipo ( $ruc,$tipodoc  ){
        
        $ruc = trim($ruc);
        
        $lon = strlen($ruc);
        
        
        $tipo = $tipodoc;
        
        
        if($lon == 10){
            if ($tipo == '01'){
                $tipo = '03';
            }
        }
        elseif($lon > 13){
            if ($tipo == '01'){
                $tipo = '03';
            }
        }
        elseif($lon < 10){
            if ($tipo == '01'){
                $tipo = '03';
            }
        }
        
        return $tipo;
    }
 //------------------
    function idfecha( $fecha  ){
        
        $afecha = explode('-', $fecha);
        
        $anio   = $afecha[0];
        $mes    = $afecha[1];
        $dia    = $afecha[2];
        
        return $dia.'/'.$mes.'/'.$anio;
        
        
    }
//---------------------------
    function idruc ( $ruc  ){
        
        $ruc = trim($ruc);
        
        $lon = strlen($ruc);
        
        if ($lon == 13){
            return '01';
        }
        elseif($lon == 10){
            return '02';
        }
        elseif($lon > 13){
            return '03';
        }
        elseif($lon < 10){
            return '03';
        }
        
        $vali = substr($ruc, 0,1);
        
        if ( $vali >= 3 ){
            return '03';
        }
        
        return '03';
    }
    //--------------------------------------------------------------------------
    function retencion(   $id     ){
        
        $ARetencion = $this->bd->query_array('co_compras_f',
            'count(*) as tt',
            'id_compras='.$this->bd->sqlvalue_inyeccion($id,true));
        
        
        return $ARetencion['tt'];
    }
    //-------------------------
    function genera_retencion( $id ){
        
        
        $sql = "SELECT codretair, baseimpair,porcentajeair, valretair
            FROM co_compras_f
            where id_compras=".$this->bd->sqlvalue_inyeccion($id,true);
        
        
        $stmt_fuente = $this->bd->ejecutar($sql);
        
        
        return   $stmt_fuente;
    }
 //--------------------
    function idruc_Vta ( $ruc  ){
        
        $ruc = trim($ruc);
        
        // 99999999999
        
        
        $lon = strlen($ruc);
        
        
        if ($lon == 13){
            
            $str = substr($ruc, $lon-3, 3);
            
            if ( $str <> '001' ){
                return '06';
            }
            
        }
        
        
        if ($lon == 13){
            return '04';
        }
        elseif($lon == 10){
            return '05';
        }
        elseif($lon > 13){
            return '04';
        }
        elseif($lon < 10){
            return '06';
        }
        
        if ($ruc == '9999999999'){
            return '07';
        }
        
        if ($ruc == '9999999999999'){
            return '07';
        }
        
        if ($ruc == '99999999999'){
            return '06';
        }
        
        
        return '06';
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
$gestion        = 	new proceso;
$anio           =  $_GET['ANIO'];
$mes            =  $_GET['MES'];
$downloadfile   =  $gestion->generaxml($anio,$mes);
header("Content-Type: application/force-download");
header("Content-type: MIME");
header('Content-type: text/html; charset=utf-8');
header("Content-type: application/octet-stream");
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=".$downloadfile);
header('Content-Transfer-Encoding: binary');
header("Expires: 0"); 
$gestion->consultaId($anio,$mes);
 
?> 