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
        
       
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        $this->ruc       =  $_SESSION['ruc_registro'];
        
 
    }
    
    function conexion_server( ){
        
        
        $this->bdFactura	   =	new Db;
        
        $dataServer = $this->bdFactura->conectar_sesion();
        
         
        return $dataServer;
        
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
        
         $filename = 'http://www.s2i.com.ec/kaipi/archivos/datas_registro.csv';
        // $filename = '../../archivos/datas_registro.csv';
        
        
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            $ADatos['razon'] = $data[0];
            $ADatos ['contacto'] = $data[1];
            $ADatos ['correo'] = $data[2];
            $ADatos ['direccion'] = $data[3];
            $ADatos ['felectronica'] = $data[4];
            $ADatos ['estab'] = $data[5];
          }
         
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
        
        
        $totalsinimpuestos =    $this->ArrayTotal['basenograiva'] +   
                                $this->ArrayTotal['baseimponible'] +   
                                $this->ArrayTotal['baseimpgrav']  ;
        
     
        
       $importetotal =  $totalsinimpuestos +  $this->ArrayTotal['montoiva'];
        
     
        
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
        
       
        $this->_10_Cabecera_Adicional( $cab_codigo,$this->Array_Cabecera['correo'],$id);
        
        $this->_12_ActualizaGad( $cab_codigo );
        
        
        return $cab_codigo;
        
    }
    
    //---------------------------------------
    function _08_Cabecera_FacturaElectronica_Impuesto( $codFac , $id, $idprov ){
        
        
        
        $retencion_iva  = (double)$this->ArrayTotal['valorretbienes'] +
        (double)$this->ArrayTotal['valorretservicios'] +
        (double)$this->ArrayTotal['valretserv100'];
        
        $baseimponible  = (double)$this->ArrayTotal['montoiva'];
        
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
            ///---------------------------------------------------------------------
            
             $filename = 'http://www.s2i.com.ec/kaipi/archivos/datas_fuente.csv';
            //$filename = '../../archivos/datas_fuente.csv';
             
            $handle = fopen($filename, "r");
             while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
            {
                
                $Array_Fuente['codretair'] = $data[0];
                $Array_Fuente['baseimpair'] = $data[1];
                $Array_Fuente['porcentajeair'] = $data[2];
                $Array_Fuente['valretair'] = $data[3];
            }
            fclose($handle);
            //------------------------------------------------------------
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
        
      
 
        if(!empty(trim($this->Array_Cabecera ['detalle']))){
            $detalle =  trim($this->Array_Cabecera ['detalle']);
        }else{
            $detalle = 'Pago a proveedor por servicios varios';
        }
        
        $﻿ATablaRef[1][valor]  =  'Detalle';
        $﻿ATablaRef[2][valor]  =  $detalle;
        
        $this->bdFactura->_InsertSQL('spo_informacion_adicional',$﻿ATablaRef,'spo_detalle_det_codigo_seq');
        
        
    }
    
    //---------------------------------------
    
    //----------------------------------------------
    function _03_Cabecera_Factura($id,$idprov){
        
        
     //   $filename = 'https://g-kaipi.com/kaipi/archivos/datas.csv';
     
     $filename = 'http://www.s2i.com.ec/kaipi/archivos/datas.csv';
        
     //    $filename = '../../archivos/datas.csv';
          
        
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            $this->Array_Cabecera ['anio'] = $data[0];
            $this->Array_Cabecera ['mes'] = $data[1]; 
            $this->Array_Cabecera ['idprov'] = $data[2];
            $this->Array_Cabecera ['razon'] = $data[3];
            $this->Array_Cabecera ['id_compras'] = $data[4];
            $this->Array_Cabecera ['fecharegistro'] = $data[5];
            $this->Array_Cabecera ['establecimiento'] = $data[6];
            $this->Array_Cabecera ['puntoemision'] = $data[7];
            $this->Array_Cabecera ['secuencial'] = $data[8];
            $this->Array_Cabecera ['fechaemision'] = $data[9];
            $this->Array_Cabecera ['autorizacion'] = $data[10];
            
             
            $this->Array_Cabecera ['basenograiva']  = $data[10];
            $this->Array_Cabecera ['baseimponible'] =$data[11];
            $this->Array_Cabecera ['baseimpgrav'] =  $data[12];
            $this->Array_Cabecera ['montoice'] =  $data[13];
            $this->Array_Cabecera ['montoiva'] =  $data[14];
            $this->Array_Cabecera ['valorretbienes'] =  $data[15];
            $this->Array_Cabecera ['valorretservicios'] = $data[16];
            $this->Array_Cabecera ['valretserv100'] = $data[17];
            
            
            $this->Array_Cabecera ['registro'] = $data[19];
            $this->Array_Cabecera ['comprobante'] = $data[20];
            $this->Array_Cabecera ['direccion'] = $data[21];
            $this->Array_Cabecera ['correo'] = $data[22];
            $this->Array_Cabecera ['detalle'] = $data[23];
            $this->Array_Cabecera ['comprobante_retencion'] = $data[24];
            $this->Array_Cabecera ['id_asiento'] = $data[25];
            
             
        }
        
       
        
        fclose($handle);
        
        $this->ruc       =   trim($this->Array_Cabecera ['registro']) ; 
        
        
        return $this->Array_Cabecera ['comprobante_retencion'];
        
        
        
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
    function _02_CodigoAutorizacion( $referencia ,$idasiento, $bandera){
        
        if ( $bandera == 1) {
            $filtro =   'emi01codi   ='.$this->bdFactura->sqlvalue_inyeccion($idasiento,true). " and coddoc = '07' " ;
        }else{
            $filtro =   'cab_codigo   ='.$this->bdFactura->sqlvalue_inyeccion($referencia,true) . " and coddoc = '07' " ;
        }
        
        
        $this->ArrayAutorizacion = $this->bdFactura->query_array(
            'spo_cabecera',
            'cab_estado_comprobante,cab_autorizacion,cab_codigo,cab_observacion,secuencial',
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
          
        $filename = 'http://www.s2i.com.ec/kaipi/archivos/datas_detalle.csv';
        //$filename = '../../archivos/datas_detalle.csv';
         
        $handle = fopen($filename, "r");
        $i=0;
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
              
            $this->ArrayTotal['basenograiva'] = $data[0];
            $this->ArrayTotal['baseimponible'] = $data[1];
            $this->ArrayTotal['baseimpgrav'] = $data[2];
            $this->ArrayTotal['montoice'] = $data[3];
            $this->ArrayTotal['montoiva'] = $data[4];
            $this->ArrayTotal['valorretbienes'] = $data[5];
            $this->ArrayTotal['valorretservicios'] = $data[6];
            $this->ArrayTotal['valretserv100'] = $data[7];
            $this->ArrayTotal['porcentaje_iva'] = $data[8];
            $this->ArrayTotal['baseimpair'] = $data[9];
            
            $this->ArrayTotal['id_compras'] = $data[10];
            $this->ArrayTotal['fecharegistro'] = $data[11];
            $this->ArrayTotal['fechaemision'] = $data[12];
            $this->ArrayTotal['anio'] = $data[13];
            $i = $i + 1;
        }
        
        
        fclose($handle);
        
 
        
    }
    //-----------------------------------------
    function _GetCabecera( $variable ){
        
        return  $this->Array_Cabecera[$variable];
        
    }
    
    //-----------------------------------------
    function _11_ActualizaMovimiento( $id_asiento,$idprov ){
        
        //     $id ,$idprov , $Autorizacion,$ComprobanteRetencion
        
        //$filename = 'http://www.s2i.com.ec/kaipi/archivos/datas_detalle.csv';
        
        $filename = 'https://g-kaipi.com/kaipi/archivos/datas_clave.csv';
        
        //$filename = '../../archivos/datas_clave.csv';
        
            
        
        $handle = fopen($filename, "r");
        $i=0;
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            
            $datos['cab_estado_comprobante'] = $data[0];
            $datos['cab_autorizacion'] = $data[1];
            $datos['cab_codigo'] = $data[2];
            $datos['cab_observacion'] = $data[3];
            $datos['secuencial'] = $data[4]; 
            $datos['id_asiento'] = $data[5]; 
         }
        
 
            $sql = "UPDATE co_asiento_aux
        						   SET 	autorizacion=".$this->bd->sqlvalue_inyeccion( $datos['cab_autorizacion'], true).",
                                        cab_codigo=".$this->bd->sqlvalue_inyeccion( $datos['cab_codigo'], true).",
                                        retencion=".$this->bd->sqlvalue_inyeccion($datos['secuencial'], true)."
         						 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id_asiento, true) . 'and
                                       idprov='.$this->bd->sqlvalue_inyeccion($idprov, true);
      
            if (trim($datos['id_asiento']) == trim($id_asiento) )  {
                
                $this->bd->ejecutar($sql);
                
            }
        
            return $datos['cab_autorizacion'];
        
        
    }
    
    //-------
    function _11_ActualizaMovimientoSec( $id_asiento,$idprov ){
        
       
        
        $filename = 'https://g-kaipi.com/kaipi/archivos/datas_clave.csv';
        
            
        $handle = fopen($filename, "r");
        $i=0;
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            
            $datos['cab_estado_comprobante'] = $data[0];
            $datos['cab_autorizacion'] = $data[1];
            $datos['cab_codigo'] = $data[2];
            $datos['cab_observacion'] = $data[3];
            $datos['secuencial'] = $data[4];
            $datos['id_asiento'] = $data[5];
        }
        
           
        return $datos['secuencial'];
        
        
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
            " count(retencion) + 1 as secuencia",
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
    //-------------------------------------function _archivo( $id  ){
     //--------------------------------------------------------------
    function _archivo( $id_asiento,$idprov  ){
        
        
             $ComprobanteRetencion = $this->_comprobante_retencion();
        
             $csv_end = " ";
             $csv_sep = ";";
             $csv_file = "../../archivos/datas.csv";
             $csv="";
             
             $sql = "SELECT   anio, mes, idprov, razon, id_compras,     fecharegistro,
                              establecimiento, puntoemision, secuencial, fechaemision, autorizacion, basenograiva, baseimponible,
                              baseimpgrav, montoice, montoiva, valorretbienes, valorretservicios, valretserv100, registro,
                              comprobante,direccion,correo,detalle,id_asiento
                    FROM  view_anexos_compras
                    where id_asiento   = ".$this->bd->sqlvalue_inyeccion( $id_asiento ,true).' and   
                          idprov='.$this->bd->sqlvalue_inyeccion($idprov,true);
             
             
             $stmt = $this->bd->ejecutar($sql);
             
             while ($row=$this->bd->obtener_fila($stmt)){
                 
                 $csv.=$row['anio'].$csv_sep.
                 $row['mes'].$csv_sep.
                 $row['idprov'].$csv_sep. 
                 $row['razon'].$csv_sep.
                 $row['id_compras'].$csv_sep.
                 $row['fecharegistro'].$csv_sep.
                 $row['establecimiento'].$csv_sep.
                 $row['puntoemision'].$csv_sep.
                 $row['secuencial'].$csv_sep.
                 $row['fechaemision'].$csv_sep.
                 $row['autorizacion'].$csv_sep.
                 $row['basenograiva'].$csv_sep.
                 $row['baseimponible'].$csv_sep.
                 $row['baseimpgrav'].$csv_sep.
                 $row['montoice'].$csv_sep.
                 $row['montoiva'].$csv_sep.
                 $row['valorretbienes'].$csv_sep.
                 $row['valorretservicios'].$csv_sep.
                 $row['valretserv100'].$csv_sep.
                 $row['registro'].$csv_sep.
                 $row['comprobante'].$csv_sep.
                 $row['direccion'].$csv_sep.
                 $row['correo'].$csv_sep.
                 $row['detalle'].$csv_sep.
                 $ComprobanteRetencion.$csv_sep.
                 $row['id_asiento'].$csv_end;
                 
                 $id_compras = $row['id_compras'];
             }
               
             //Generamos el csv de todos los datos
             if (!$handle = fopen($csv_file, "w")) {
                 echo "Cannot open file";
                 exit;
             }
             if (fwrite($handle, utf8_decode($csv)) === FALSE) {
                 echo "Cannot write to file";
                 exit;
             }
             fclose($handle);
             
             //-----------------------------------------------------------------------------------------------------
             $csv_end = " ";
             $csv_sep = ";";
             $csv_file = "../../archivos/datas_detalle.csv";
             $csv="";
             
             $csalto =" \n ";
              
             
             $sql_det = 'SELECT basenograiva, baseimponible, baseimpgrav, montoice, montoiva, valorretbienes,
                                valorretservicios, valretserv100, porcentaje_iva, baseimpair ,id_compras,fecharegistro,fechaemision
                         FROM  view_anexos_compras
                         where id_asiento ='.$this->bd->sqlvalue_inyeccion($id_asiento,true). ' and   
                               idprov='.$this->bd->sqlvalue_inyeccion($idprov,true);
             
             
             $stmt1 = $this->bd->ejecutar($sql_det);
             
             while ($row=$this->bd->obtener_fila($stmt1)){
                 
                 $csv.=$row['basenograiva'].$csv_sep.
                 $row['baseimponible'].$csv_sep.
                 $row['baseimpgrav'].$csv_sep. 
                 $row['montoice'].$csv_sep.
                 $row['montoiva'].$csv_sep.
                 $row['valorretbienes'].$csv_sep.
                 $row['valorretservicios'].$csv_sep.
                 $row['valretserv100'].$csv_sep.
                 $row['porcentaje_iva'].$csv_sep.
                 $row['baseimpair'].$csv_sep.
                 $row['id_compras'].$csv_sep.
                 $row['fecharegistro'].$csv_sep.
                 $row['fechaemision'].$csv_end;
              }
             
             
             //Generamos el csv de todos los datos
             if (!$handle = fopen($csv_file, "w")) {
                 echo "Cannot open file";
                 exit;
             }
             if (fwrite($handle, utf8_decode($csv)) === FALSE) {
                 echo "Cannot write to file";
                 exit;
             }
             fclose($handle);
             
             
             //-------------------------------------------------------------------
             
             $csv_end = " ";
             $csv_sep = ";";
             $csv_file1 = "../../archivos/datas_fuente.csv";
             $csv="";
             $csalto =" \n ";
 
             $sql1 = 'SELECT codretair, baseimpair, coalesce(porcentajeair,0) as porcentajeair, coalesce(valretair,0) as valretair
                         FROM  view_anexos_fuente
                         where id_asiento ='.$this->bd->sqlvalue_inyeccion($id_asiento,true). ' and
                               id_compras='.$this->bd->sqlvalue_inyeccion($id_compras,true);
             
           
             // .$this->bd->sqlvalue_inyeccion( $this->ruc ,true)
             
             $stmt1 = $this->bd->ejecutar($sql1);
             
             while ($row=$this->bd->obtener_fila($stmt1)){
                 
                 $csv.=$row['codretair'].$csv_sep.
                 trim($row['baseimpair']).$csv_sep. 
                 trim($row['porcentajeair']).$csv_sep.
                 trim($row['valretair']).$csv_end  ;
                   
             }
             
             
             //Generamos el csv de todos los datos
             if (!$handle = fopen($csv_file1, "w")) {
                 echo "Cannot open file";
                 exit;
             }
             if (fwrite($handle, utf8_decode($csv)) === FALSE) {
                 echo "Cannot write to file";
                 exit;
             }
             
             fclose($handle);
             ///----------------------------------------------------------
             
             //-------------------------------------------------------------------
             
             $csv_end = " ";
             $csv_sep = ";";
             $csv_file1 = "../../archivos/datas_registro.csv";
             $csv="";
         
             
             $sql1 = 'SELECT razon, contacto, correo,direccion,felectronica,estab
                         FROM  web_registro
                         where ruc_registro ='.$this->bd->sqlvalue_inyeccion($this->ruc,true) ;
             
             
             // .$this->bd->sqlvalue_inyeccion( $this->ruc ,true)
             
             $stmt1 = $this->bd->ejecutar($sql1);
             
             while ($row=$this->bd->obtener_fila($stmt1)){
                 
                 $csv.=$row['razon'].$csv_sep.
                 trim($row['contacto']).$csv_sep.
                 trim($row['correo']).$csv_sep.
                 trim($row['direccion']).$csv_sep.
                 trim($row['felectronica']).$csv_sep.
                 trim($row['estab']).$csv_end;  
                 
             }
             
             
             //Generamos el csv de todos los datos
             if (!$handle = fopen($csv_file1, "w")) {
                 echo "Cannot open file";
                 exit;
             }
             if (fwrite($handle, utf8_decode($csv)) === FALSE) {
                 echo "Cannot write to file";
                 exit;
             }
             
             fclose($handle);
             ///----------------------------------------------------------
   
            
            return  'Informacion Generada...';
 
        }
   ///-------------------
        function _archivo_valor( $id_asiento,$estado  ){
            
               //-------------------------------------------------------------------
            
            $csv_end = " ";
            $csv_sep = ";";
            $csv_file1 = "../../archivos/datas_clave.csv";
            $csv="";
            
                  
            $csv.=$this->ArrayAutorizacion ['cab_estado_comprobante'].$csv_sep.
            trim($this->ArrayAutorizacion ['cab_autorizacion']).$csv_sep.
            trim($this->ArrayAutorizacion ['cab_codigo']).$csv_sep.
            trim($this->ArrayAutorizacion ['cab_observacion']).$csv_sep.
            trim($this->ArrayAutorizacion ['secuencial']).$csv_sep.
            trim($id_asiento).$csv_end;
                
            
            
            //Generamos el csv de todos los datos
            if (!$handle = fopen($csv_file1, "w")) {
                echo "Cannot open file";
                exit;
            }
            if (fwrite($handle, utf8_decode($csv)) === FALSE) {
                echo "Cannot write to file";
                exit;
            }
            
            fclose($handle);
            ///----------------------------------------------------------
            
            
            return  'Actualice la informacion ...'.trim($this->ArrayAutorizacion ['cab_autorizacion']);
            
        }
}
//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------

$gestion   = 	new componente;



$id_asiento               = $_GET['id_asiento'];
$secuencial               = $_GET['secuencial'];
$idprov                   = $_GET['idprov'];
$archivo                  = $_GET['archivo'];

$key       =  $gestion->_keyFactura();

 
        
        if ($archivo == 1){
            
            
            $data = $gestion->_archivo( $id_asiento,$idprov  );
 
            echo   $data;
            
        }
        
        
        if ($archivo == 2){
            
            
            $dataServer = $gestion->conexion_server( );
            
            
            $ComprobanteRetencion = $gestion->_03_Cabecera_Factura($id_asiento,$idprov);  // datos de la factura
            
            $estado = $gestion->_02_CodigoAutorizacion( 0 ,$id_asiento, 1);
            
            if ( empty($estado)) {
            
                $gestion->_04_TotalFactura( $id_asiento,$idprov ); // sumatoria de valores
                $codFac = $gestion->_05_Cabecera_FacturaElectronica( $id_asiento,$idprov,$ComprobanteRetencion ); // cabecera transaccion
                $data = 'Factura generando enviada....  '.$codFac.   ' '.$Autorizacion ;
            }else{
                $data = ' Estado: '.$estado ;
            }
            
            echo   $data;
            
        }

        if ($archivo == 3){
            
            $dataServer = $gestion->conexion_server( );
            
            $estado = $gestion->_02_CodigoAutorizacion( 0 ,$id_asiento, 1);
            
            $data = $gestion->_archivo_valor( $id_asiento,$estado  );
            
            echo   $data;
            
        }
        
        if ($archivo == 4){
            
            $estado = $gestion->_11_ActualizaMovimiento( $id_asiento,$idprov );
            
            echo   $estado;
            
        }
     
        if ($archivo == 5){
            
            $estado = $gestion->_11_ActualizaMovimientoSec( $id_asiento,$idprov );
            
            echo   $estado;
            
        }




?>
 
 
  