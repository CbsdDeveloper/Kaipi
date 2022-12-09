<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


class componente{
    
    
    public $obj;
    public $bd;
    public $bdFactura;
    public $set;
    
    private $formulario;
    private $evento_form;
    
    
    public $Array_Cabecera;
    public $ArrayTotal;
    public $ArrayAutorizacion;
    
    public $codigo_electronico;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function componente( ){
        
        $this->obj     = 	new objects;
        $this->set     = 	new ItemsController;
        $this->bd	   =	new Db;
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        
        //-----------------------------
        $this->bdFactura	   =	new Db;
        $this->bdFactura->conectar_sesion();
        
        
        
    }
    //-----------------------------------------
    function _keyFactura(){
        
        $ADatos = $this->bd->query_array(
            'web_registro',
            'felectronica',
            'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
            );
        
        if ($ADatos['felectronica'] == 'S' ){
            return 1;
        }else{
            return 0;
        }
    }
    //---------------------------------------
    function _05_Cabecera_FacturaElectronica( $id,$idprov,$ComprobanteRetencion){
        
        
        $ADatos = $this->bd->query_array(
            'web_registro',
            'razon, contacto, correo,direccion,felectronica,estab',
            'ruc_registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
            );
        
        
        $DIRECCION   = trim($ADatos['direccion'] );
        $razonSocial = trim($ADatos['contacto'] ) ;
        $comercial   = trim($ADatos['razon'] ) ;
        $estab       = trim($ADatos['estab'] ) ;
        
        $idprov = trim( $this->Array_Cabecera['idprov'] );
        
        $ncontador = strlen(trim($idprov));  // 01-RUC 05-cedula 06-pasaporte 07-consumidor final 08-identificacion exterior 09-placa
        
        $tipoidentificacioncomprador = '06';
        
        $identificacioncomprador = trim($this->Array_Cabecera['idprov']);
        
        if ($ncontador == 10){
            $tipoidentificacioncomprador = '05';
        }
        
        if ($ncontador == 13){
            $tipoidentificacioncomprador = '04';
        }
        
        if ($this->Array_Cabecera['idprov']== '9999999999999'){
            
            $tipoidentificacioncomprador = '07';
        }
        
        if ($this->Array_Cabecera['idprov']== '9999999999'){
            
            $tipoidentificacioncomprador = '07';
            
            $identificacioncomprador = '9999999999999';
        }
        
 
        $totalsinimpuestos =  $this->ArrayTotal['basenograiva'] +   $this->ArrayTotal['baseimponible'] +   $this->ArrayTotal['baseimpgrav']  ;
        
        
        $importetotal =  $totalsinimpuestos + $this->ArrayTotal['montoiva'];
        
 
               
        $﻿ATabla = array(
            array( campo => 'cab_codigo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'coddoc',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '07',   filtro => 'N',   key => 'N'),
            array( campo => 'estab',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => $estab,   filtro => 'N',   key => 'N'),
            array( campo => 'ptoemi',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '001',   filtro => 'N',   key => 'N'),
            array( campo => 'secuencial',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $ComprobanteRetencion,   filtro => 'N',   key => 'N'),
            array( campo => 'fechaemision',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'S',   valor =>$this->Array_Cabecera['fecharegistro'],   filtro => 'N',   key => 'N'),
            array( campo => 'direstablecimiento',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor =>$DIRECCION,   filtro => 'N',   key => 'N'),
            array( campo => 'tipoidentificacioncomprador',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => $tipoidentificacioncomprador,   filtro => 'N',   key => 'N'),
            array( campo => 'razonsocialcomprador',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor =>$this->Array_Cabecera['razon'],   filtro => 'N',   key => 'N'),
            array( campo => 'totalsinimpuestos',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'S',   valor => $totalsinimpuestos,   filtro => 'N',   key => 'N'),
            array( campo => 'totaldescuento',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'importetotal',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $importetotal,   filtro => 'N',   key => 'N'),
            array( campo => 'moneda',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => 'DOLAR',   filtro => 'N',   key => 'N'),
            array( campo => 'descuentoadicional',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'identificacioncomprador',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor =>$identificacioncomprador,   filtro => 'N',   key => 'N'),
            array( campo => 'emi01codi',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => $id,   filtro => 'N',   key => 'N'),
            array( campo => 'gad',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'S',   valor => '00',   filtro => 'N',   key => 'N'),
            array( campo => 'ruc',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'S',   valor =>  $this->ruc,   filtro => 'N',   key => 'N'),
            array( campo => 'direccioncomprador',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $this->Array_Cabecera['direccion'],   filtro => 'N',   key => 'N'),
            array( campo => 'razonsocial',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => $razonSocial,   filtro => 'N',   key => 'N'),
            array( campo => 'nombrecomercial',   tipo => 'VARCHAR2',   id => '20',  add => 'S',   edit => 'S',   valor => $comercial,   filtro => 'N',   key => 'N'),
            array( campo => 'dirmatriz',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'S',   valor =>$DIRECCION,   filtro => 'N',   key => 'N')
        );
        
        
        
        $cab_codigo = $this->bdFactura->_InsertSQL('spo_cabecera',$﻿ATabla,'spo_cabecera_cab_codigo_seq');
        
        
        $this->_08_Cabecera_FacturaElectronica_Impuesto( $cab_codigo, $id,$idprov );
        
      //  $this->_09_Cabecera_FormaPago( $cab_codigo );
        
        $this->_10_Cabecera_Adicional( $cab_codigo,$this->Array_Cabecera['correo'],$id);
        
        $this->_12_ActualizaGad( $cab_codigo );
        
        
        return $cab_codigo;
        
    }
    
    //---------------------------------------
    function _08_Cabecera_FacturaElectronica_Impuesto( $codFac , $id, $idprov ){
        
      
        
        $retencion_iva  = $this->ArrayTotal['valorretbienes'] +  
                          $this->ArrayTotal['valorretservicios'] +  
                          $this->ArrayTotal['valretserv100'];
     
        $baseimponible  = $this->ArrayTotal['montoiva'];
        
        $numdocsustento = $this->Array_Cabecera['establecimiento'].$this->Array_Cabecera['puntoemision'].$this->Array_Cabecera['secuencial'];
      
        $id_compras = $this->Array_Cabecera['id_compras'] ;
        
        $porcentajeretencion = '0';
 
        $codigoporcentaje = $this->ArrayTotal['porcentaje_iva'];
        
        if ($this->ArrayTotal['porcentaje_iva'] == '1')
            $porcentajeretencion = '30';
        elseif($this->ArrayTotal['porcentaje_iva'] == '2')
            $porcentajeretencion = '70';
        elseif($this->ArrayTotal['porcentaje_iva'] == '3')
            $porcentajeretencion = '100';
       elseif($this->ArrayTotal['porcentaje_iva'] == '4')
            $porcentajeretencion = '10';
       elseif($this->ArrayTotal['porcentaje_iva'] == '5')
            $porcentajeretencion = '20';
            
            
            $porcentaje_iva =    $ArrayTotal['porcentaje_iva']  ;
            
        
        if ($retencion_iva > 0)    {
                
            $﻿ATablaRefTarifa = array(
                array( campo => 'ica_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
                array( campo => 'codigo',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => '2',   filtro => 'N',   key => 'N'),
                array( campo => 'codigoporcentaje',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => $codigoporcentaje,   filtro => 'N',   key => 'N'),
                array( campo => 'descuentoadicional',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
                array( campo => 'baseimponible',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $baseimponible,   filtro => 'N',   key => 'N'),
                array( campo => 'tarifa',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
                array( campo => 'valor',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $retencion_iva,   filtro => 'N',   key => 'N'),
                array( campo => 'porcentajeretencion',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => $porcentajeretencion,   filtro => 'N',   key => 'N'),
                array( campo => 'coddocsustento',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '01',   filtro => 'N',   key => 'N'),
                array( campo => 'numdocsustento',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $numdocsustento,   filtro => 'N',   key => 'N'),
                array( campo => 'fechaemisiondocsustento',   tipo => 'DATE',   id => '10',  add => 'S',   edit => 'S',   valor => $this->ArrayTotal['fechaemision'],   filtro => 'N',   key => 'N')
            );
            
             $ica_codigo = $this->bdFactura->_InsertSQL('spo_impuesto_cabecera',$﻿ATablaRefTarifa,'spo_impuesto_cabecera_ica_codigo_seq');
            
        }
        
        
        $Array_Fuente = $this->bd->query_array(
            'view_anexos_fuente',
            'codretair, baseimpair, coalesce(porcentajeair,0) as porcentajeair, coalesce(valretair,0) as valretair',
            'id_asiento ='.$this->bd->sqlvalue_inyeccion($id,true).' and
             id_compras='.$this->bd->sqlvalue_inyeccion($id_compras,true)
            );
        
        
        $codretair =   trim( $Array_Fuente['codretair'] );
   
        $porcentajeair =  intval ( $Array_Fuente['porcentajeair'] ) ;
        
        if ( $Array_Fuente['baseimpair'] > 0 ){
            
            if(empty($porcentajeair)){
                $porcentajeair = '0';
            }
            
            
            
            $﻿ATablaRefTarifa = array(
                array( campo => 'ica_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
                array( campo => 'codigo',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
                array( campo => 'codigoporcentaje',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => $codretair,   filtro => 'N',   key => 'N'),
                array( campo => 'descuentoadicional',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
                array( campo => 'baseimponible',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $Array_Fuente['baseimpair'],   filtro => 'N',   key => 'N'),
                array( campo => 'tarifa',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
                array( campo => 'valor',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $Array_Fuente['valretair'],   filtro => 'N',   key => 'N'),
                array( campo => 'porcentajeretencion',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => $porcentajeair,   filtro => 'N',   key => 'N'),
                array( campo => 'coddocsustento',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '01',   filtro => 'N',   key => 'N'),
                array( campo => 'numdocsustento',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $numdocsustento,   filtro => 'N',   key => 'N'),
                array( campo => 'fechaemisiondocsustento',   tipo => 'DATE',   id => '10',  add => 'S',   edit => 'S',   valor => $this->ArrayTotal['fechaemision'],   filtro => 'N',   key => 'N')
            );
            
            $ica_codigo = $this->bdFactura->_InsertSQL('spo_impuesto_cabecera',$﻿ATablaRefTarifa,'spo_impuesto_cabecera_ica_codigo_seq');
            
            
            
        }
 
        
    }
    //------------------------------------------
    function _09_Cabecera_FormaPago( $codFac){
        
    /*    
        $valor            =   $this->ArrayTotal['total'];
        
        $﻿ATablaRef = array(
            array( campo => 'fpa_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
            array( campo => 'formapago',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '01',   filtro => 'N',   key => 'N'),
            array( campo => 'total',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $valor,   filtro => 'N',   key => 'N'),
            array( campo => 'plazo',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'unidadtiempo',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => 'dias',   filtro => 'N',   key => 'N')
        );
        
        
        $this->bdFactura->_InsertSQL('spo_forma_pago',$﻿ATablaRef,'spo_detalle_det_codigo_seq');
        */
        
    }
    //------------------------------------------
    function _10_Cabecera_Adicional( $codFac,$correoUsuario,$id){
        

        
        $﻿ATablaRef = array(
            array( campo => 'iad_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
            array( campo => 'ida_nombre',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => 'E-Mail',   filtro => 'N',   key => 'N'),
            array( campo => 'ida_valor',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => $correoUsuario,   filtro => 'N',   key => 'N')
        );
        
        
        $this->bdFactura->_InsertSQL('spo_informacion_adicional',$﻿ATablaRef,'spo_detalle_det_codigo_seq');
        
        
        $ArrayAsiento = $this->bd->query_array(
            'view_asientos',
            'detalle',
            'id_asiento ='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        if(!empty( $ArrayAsiento['detalle'])){
            $detalle =  $ArrayAsiento['detalle'];
        }else{
            $detalle = 'Pago a proveedor por servicios varios';
        }
        
        $﻿ATablaRef[1][valor]  =  'Detalle';
        $﻿ATablaRef[2][valor]  =  $ArrayAsiento['detalle'];
        
        $this->bdFactura->_InsertSQL('spo_informacion_adicional',$﻿ATablaRef,'spo_detalle_det_codigo_seq');
       
        
    }
    
    //---------------------------------------
    
    //----------------------------------------------
    function _03_Cabecera_Factura($id,$idprov){
        
        $this->Array_Cabecera = $this->bd->query_array(
            'view_anexos_compras',
            'anio, mes, idprov, razon, id_compras,   codsustento, tpidprov, tipocomprobante, fecharegistro,
              establecimiento, puntoemision, secuencial, fechaemision, autorizacion, basenograiva, baseimponible,
              baseimpgrav, montoice, montoiva, valorretbienes, valorretservicios, valretserv100, registro,
              porcentaje_iva, baseimpair, pagolocext, paisefecpago, faplicconvdobtrib, formadepago, fechaemiret1,
              serie1, secretencion1, autretencion1, docmodificado, secmodificado, estabmodificado,
               autmodificado, fpagextsujretnorleg, serie, comprobante,direccion,correo',
            'id_asiento ='.$this->bd->sqlvalue_inyeccion($id,true).' and   idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)
            );
       
    }
   
    //-----------------------------------------
    function _CodigoTransaccion( $identificacioncomprador,$secuencial,$emi01codi  ){
        
        $APeriodo = $this->bdFactura->query_array(
            'spo_cabecera',
            'cab_codigo',
            'ruc                      ='.$this->bdFactura->sqlvalue_inyeccion($this->ruc,true). ' AND
 			   identificacioncomprador  ='.$this->bdFactura->sqlvalue_inyeccion(trim($identificacioncomprador),true). ' AND
               secuencial               ='.$this->bdFactura->sqlvalue_inyeccion(trim($secuencial),true) .' AND
               emi01codi                ='.$this->bdFactura->sqlvalue_inyeccion($emi01codi,true)
            );
        
        return $APeriodo['cab_codigo'];
        
    }
    //-----------------------
    function _02_CodigoAutorizacion( $referencia ,$id, $bandera){
        
        if ( $bandera == 1) {
            $filtro =   'emi01codi   ='.$this->bdFactura->sqlvalue_inyeccion($id,true). " and coddoc = '07' " ;
        }else{
            $filtro =   'cab_codigo   ='.$this->bdFactura->sqlvalue_inyeccion($referencia,true) . " and coddoc = '07' " ;
        }
        
        
        $this->ArrayAutorizacion = $this->bdFactura->query_array(
            'spo_cabecera',
            'cab_estado_comprobante,cab_autorizacion,cab_codigo,cab_observacion,cab_codigo',
            $filtro
            );
        
        return $this->ArrayAutorizacion ['cab_estado_comprobante'];
        
    }
    
    //------------------------
    //-----------------------
    function _Autorizacion( ){
        
        if (empty($this->ArrayAutorizacion ['cab_autorizacion'])){
            return 'enviada';
        }
        else {
            return $this->ArrayAutorizacion ['cab_autorizacion'];
        }
    
    }
    //-------------------------------
    function _codigoCab( ){
        
        return  $this->codigo_electronico;
        
    }
    //-----------------------
    function __eliminar( $codigo ){
        
        $sql1 ="SELECT eliminarcabeceraporcodigo(". $this->bd->sqlvalue_inyeccion($codigo,true).")";
        
        $this->bdFactura->ejecutar($sql1);
        
        
        return $codigo ;
        
    }
    
    //-----------------------
    function _cab_codigo( ){
        
        
        return $this->ArrayAutorizacion ['cab_codigo'];
        
    }
    
    
    //-----------------------------------------
    function _04_TotalFactura( $id ,$idprov){
        
        
        $this->ArrayTotal = $this->bd->query_array(
            'view_anexos_compras',
            'basenograiva, baseimponible, baseimpgrav, montoice, montoiva, valorretbienes,
             valorretservicios, valretserv100, porcentaje_iva, baseimpair ,id_compras,fecharegistro,fechaemision',
            'id_asiento ='.$this->bd->sqlvalue_inyeccion($id,true). ' and   idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)
            );
        
        
       
        
    }
    //-----------------------------------------
    function _GetCabecera( $variable ){
        
        return  $this->Array_Cabecera[$variable];
        
    }
    
    //-----------------------------------------
    function _11_ActualizaMovimiento( $id,$idprov, $Autorizacion,$ComprobanteRetencion,$cab_codigo ){
        
   //     $id ,$idprov , $Autorizacion,$ComprobanteRetencion
        
        if ($cab_codigo == 0){
                $sql = "UPDATE co_asiento_aux
        						   SET 	autorizacion=".$this->bd->sqlvalue_inyeccion($Autorizacion, true).",
                                        retencion=".$this->bd->sqlvalue_inyeccion($ComprobanteRetencion, true)."
         						 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id, true). 'and 
                                       idprov='.$this->bd->sqlvalue_inyeccion($idprov, true). 'and 
                                       tipo='.$this->bd->sqlvalue_inyeccion('P', true);
        }else{
            $sql = "UPDATE co_asiento_aux
        						   SET 	autorizacion=".$this->bd->sqlvalue_inyeccion($Autorizacion, true).",
                                        cab_codigo=".$this->bd->sqlvalue_inyeccion($cab_codigo, true).",
                                        retencion=".$this->bd->sqlvalue_inyeccion($ComprobanteRetencion, true)."
         						 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id, true). 'and
                                       idprov='.$this->bd->sqlvalue_inyeccion($idprov, true). 'and
                                       tipo='.$this->bd->sqlvalue_inyeccion('P', true);
        }
        
        
        $this->bd->ejecutar($sql);
 
        
    }
    //-----------------------------------------
    function _12_ActualizaGad( $id ){
        
        $sql = "UPDATE spo_cabecera
						   SET 	gad=".$this->bd->sqlvalue_inyeccion('05', true)."
 						 WHERE cab_codigo=".$this->bd->sqlvalue_inyeccion($id, true);
        
        
        
        $this->bdFactura->ejecutar($sql);
        
    }
    //-----------------------------------------
    function _ActualizaAutorizacion(  $id ,$idprov , $Autorizacion,$ComprobanteRetencion ){
        
        
        $lon = strlen(trim($Autorizacion) ) ;
        
        if ($lon >  10 ){
            
            $Autorizacion = trim($Autorizacion) ;
            
        }else{
            
            $Autorizacion ='enviada';
            
        }
        
        $lon1 = strlen(trim($ComprobanteRetencion) ) ;
        
        if ($lon >  10 ){
        
            if ($lon1 >  5 ){
                $sql = "UPDATE co_asiento_aux
						   SET 	autorizacion=".$this->bd->sqlvalue_inyeccion($Autorizacion, true)."
 						 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id, true). 'and
                               idprov='.$this->bd->sqlvalue_inyeccion($idprov, true). 'and
                               tipo='.$this->bd->sqlvalue_inyeccion('P', true);
            }
        }else{
            
            $sql = "UPDATE co_asiento_aux
						   SET 	autorizacion=".$this->bd->sqlvalue_inyeccion($Autorizacion, true).",
                                retencion=".$this->bd->sqlvalue_inyeccion($ComprobanteRetencion, true)."
 						 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id, true). 'and
                               idprov='.$this->bd->sqlvalue_inyeccion($idprov, true). 'and
                               tipo='.$this->bd->sqlvalue_inyeccion('P', true);
        }
        
      
        
        $this->bd->ejecutar($sql);
        
        
        return $Autorizacion;
        
    }
    //-----------------------------------------
    function _01_Verifica_estado( $id,$idprov ){
      
       
            
        $ArrayVer = $this->bd->query_array(
            'co_asiento_aux',
            "autorizacion,cab_codigo",
            "id_asiento = ".$this->bd->sqlvalue_inyeccion($id,true)." and 
             tipo = 'P' and 
             registro=".$this->bd->sqlvalue_inyeccion($this->ruc,true)
            );
        
        
        $estado = trim($ArrayVer['autorizacion']);
        
        
        $lon = strlen($estado) ;
        
        $this->codigo_electronico = $ArrayVer['cab_codigo'];
        
        if ($lon >  5){
            
            if ($estado == 'enviada'){
                return 'E';
            }else {
                return 'S';
            }
         }else{
            
            return 'N';
            
        }
        
  
    }
    //---------------
    function _comprobante_retencion(    ){
        
                  $ADatos = $this->bd->query_array(
                    'co_asiento_aux',
                     " MAX(retencion)::int + 1 as secuencia",
                       'registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true).' and 
                        tipo='.$this->bd->sqlvalue_inyeccion( 'P',true)  
                    );
                
                $contador = $ADatos['secuencia'] ;
                
                $comprobante =str_pad($contador, 9, "0", STR_PAD_LEFT);
        
          
        return $comprobante ;
        
    }
    //---------------
    function _comprobante_prove(   $id_asiento,  $idprov){
        
        
        
        $ADatos = $this->bd->query_array(
            'co_asiento_aux',
            "retencion",
            'registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true).' and
             tipo='.$this->bd->sqlvalue_inyeccion( 'P',true).' and 
             id_asiento ='.$this->bd->sqlvalue_inyeccion( $id_asiento,true).' and 
             idprov ='.$this->bd->sqlvalue_inyeccion( $idprov,true)
            );
        
 
 
        
         return  $ADatos['retencion'] ;
        
    }
    
}
//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------

$gestion   = 	new componente;

 

$id_asiento               = $_GET['id_asiento'];
$secuencial               = $_GET['secuencial'];
$idprov                   = $_GET['idprov'];

   $key       =  $gestion->_keyFactura();
       
     
        
        
        if ($key == 1) {
            
            $verifica = $gestion->_01_Verifica_estado( $id_asiento,$idprov );
            
            if (trim($verifica) == 'N'){
                
                $ComprobanteRetencion = $gestion->_comprobante_retencion();
                
                $gestion->_03_Cabecera_Factura($id_asiento,$idprov);  // datos de la factura
                
                $gestion->_04_TotalFactura( $id_asiento,$idprov ); // sumatoria de valores
                
                $codFac = $gestion->_05_Cabecera_FacturaElectronica( $id_asiento,$idprov,$ComprobanteRetencion ); // cabecera transaccion
                
                $gestion->_11_ActualizaMovimiento( $id_asiento ,$idprov , 'enviada',$ComprobanteRetencion,$codFac);
                
                $estado = $gestion->_02_CodigoAutorizacion( $codFac,$id_asiento,0 );
                
                $Autorizacion = 'enviada';
                
                $data = '01 Factura generando autorizacion....  '.$codFac.' Estado '. $estado. ' '.$Autorizacion;
                   
               
            }
            //----------------------------------------------------
            if (trim($verifica) == 'E'){
                
                $codFac = $gestion->_codigoCab();
                
                $estado = $gestion->_02_CodigoAutorizacion( $codFac,$id_asiento,0 );
                
                $Autorizacion = $gestion->_Autorizacion();
                
                $ComprobanteRetencion = $gestion->_comprobante_prove(   $id_asiento,  $idprov);
                
                
                $gestion->_11_ActualizaMovimiento( $id_asiento ,$idprov , $Autorizacion,$ComprobanteRetencion,0);
                
                   
                if ($estado == 'DEVUELTA' ){
                    
                    $gestion->_11_ActualizaMovimiento( $id_asiento ,$idprov , '','',0);
                    
                    $this->__eliminar($codFac);
                    
                    // vuelve a enviar
                    $gestion->_03_Cabecera_Factura($id_asiento,$idprov);  // datos de la factura
                    
                    $gestion->_04_TotalFactura( $id_asiento,$idprov ); // sumatoria de valores
                    
                    $codFac = $gestion->_05_Cabecera_FacturaElectronica( $id_asiento,$idprov,$ComprobanteRetencion ); // cabecera transaccion
                    
                    $gestion->_11_ActualizaMovimiento( $id_asiento ,$idprov , 'enviada',$ComprobanteRetencion,$codFac);
                    
                 }
                   
                 $data = '02 facturacion actualizada ' .$idprov. ' codigo '.$codFac;
                
            }
            
            if (trim($verifica) == 'S'){
                
                
                $codFac = $gestion->_codigoCab();
                
                $estado = $gestion->_02_CodigoAutorizacion( $codFac,$id_asiento,0 );
                 
                $Autorizacion = $gestion->_Autorizacion();
                
                $ComprobanteRetencion = $gestion->_comprobante_prove(   $id_asiento,  $idprov);
                
                $data = '03 facturacion emitida ' .$idprov. ' codigo '.$codFac;
            }
            
            $fechap = date("Y-m-d") ;
            
            echo '<script>ComprobanteActualiza('."'".$ComprobanteRetencion."'".","."'".$Autorizacion."'".","."'".$fechap."'".');</script> ';
            
            $data = '<h6><b>'.$data.'</b></h6>';
            
        }else {
            $data = 'Solicite al administrador la parametrizacion para envio de la facturacion electronica ' .$idprov;
        }
          
        
 
        
        echo  $data;
        
 



?>
 
 
  