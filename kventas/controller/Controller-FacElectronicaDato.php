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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        
        //-----------------------------
        
        
    }
    //-------------------
    function conexion_server( ){
        
        
        $this->bdFactura	   =	new Db;
        
        $dataServer = $this->bdFactura->conectar_sesion();
        
        //    $dataServer = 0;
        
        
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
    function _05_Cabecera_FacturaElectronica( $id){
        
        
        
        $this->_03_Cabecera_Factura($id);  // datos de la factura
        
        $this->_04_TotalFactura( $id ); // sumatoria de valores
        
        
        $secuencial = $this->Array_Cabecera['comprobante'];
        
        
        $detalleF = trim($this->Array_Cabecera['detalle']);
        $contactoF = $this->Array_Cabecera['contacto'];
        $sesionF = $this->Array_Cabecera['sesion'];
        
        
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
        
        $totalsinimpuestos =  $this->ArrayTotal['baseiva'] +   $this->ArrayTotal['tarifa_cero'] ;
        
        $importetotal =  $this->ArrayTotal['total'];
        
        
        if (!empty($secuencial)) {
        
                $ATabla = array(
                    array( campo => 'cab_codigo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'coddoc',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '01',   filtro => 'N',   key => 'N'),
                    array( campo => 'estab',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => $estab,   filtro => 'N',   key => 'N'),
                    array( campo => 'ptoemi',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '001',   filtro => 'N',   key => 'N'),
                    array( campo => 'secuencial',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->Array_Cabecera['comprobante'],   filtro => 'N',   key => 'N'),
                    array( campo => 'fechaemision',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'S',   valor =>$this->Array_Cabecera['fecha'],   filtro => 'N',   key => 'N'),
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
                
                
                
                $cab_codigo = $this->bdFactura->_InsertSQL('spo_cabecera',$ATabla,'spo_cabecera_cab_codigo_seq');
                
                $this->_06_Detalle_FacturaElectronica( $id,$cab_codigo);
                
                $this->_08_Cabecera_FacturaElectronica_Impuesto( $cab_codigo );
                
                $this->_09_Cabecera_FormaPago( $cab_codigo );
                
                $this->_10_Cabecera_Adicional( $cab_codigo, 'E-Mail', $this->Array_Cabecera['correo']);
                $this->_10_Cabecera_Adicional( $cab_codigo, 'Detalle', $detalleF);
                $this->_10_Cabecera_Adicional( $cab_codigo, 'Contacto', $contactoF);
                $this->_10_Cabecera_Adicional( $cab_codigo, 'Elaborado',$sesionF);
                
                $this->_12_ActualizaGad( $cab_codigo );
        
        
                  return $cab_codigo;
        }
        else {
            
            return 0;
            
          }
        
    }
    
    //---------------------------------------
    function _08_Cabecera_FacturaElectronica_Impuesto( $codFac){
        
        
        if ( $this->ArrayTotal['tarifa_cero'] > 0 ){
            
            $codigoporcentaje = '0';
            $baseimponible    = $this->ArrayTotal['tarifa_cero'];
            $valor            = '0';
            $tarifa = '0';
            
            $ATablaRefTarifa = array(
                array( campo => 'ica_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
                array( campo => 'codigo',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => '2',   filtro => 'N',   key => 'N'),
                array( campo => 'codigoporcentaje',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $codigoporcentaje,   filtro => 'N',   key => 'N'),
                array( campo => 'descuentoadicional',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
                array( campo => 'baseimponible',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $baseimponible,   filtro => 'N',   key => 'N'),
                array( campo => 'tarifa',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $tarifa,   filtro => 'N',   key => 'N'),
                array( campo => 'valor',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $valor,   filtro => 'N',   key => 'N')
            );
            
            
            $ica_codigo = $this->bdFactura->_InsertSQL('spo_impuesto_cabecera',$ATablaRefTarifa,'spo_impuesto_cabecera_ica_codigo_seq');
            
            
        }
        
        
        if ( $this->ArrayTotal['monto_iva'] > 0 ){
            
            $codigoporcentaje =  '2';
            $baseimponible    = $this->ArrayTotal['baseiva'];
            $valor            = $this->ArrayTotal['monto_iva'];
            $tarifa = '12';
            
            $ATablaRefIVA = array(
                array( campo => 'ica_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
                array( campo => 'codigo',         tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => '2',   filtro => 'N',   key => 'N'),
                array( campo => 'codigoporcentaje',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $codigoporcentaje,   filtro => 'N',   key => 'N'),
                array( campo => 'descuentoadicional',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
                array( campo => 'baseimponible',        tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $baseimponible,   filtro => 'N',   key => 'N'),
                array( campo => 'tarifa',               tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $tarifa,   filtro => 'N',   key => 'N'),
                array( campo => 'valor',                tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $valor,   filtro => 'N',   key => 'N')
            );
            
            $ica_codigo = $this->bdFactura->_InsertSQL('spo_impuesto_cabecera',$ATablaRefIVA,'spo_impuesto_cabecera_ica_codigo_seq');
            
        }
        
        
    }
    //------------------------------------------
    function _09_Cabecera_FormaPago( $codFac){
        
        
        $valor            =   $this->ArrayTotal['total'];
        
        $ATablaRef = array(
            array( campo => 'fpa_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
            array( campo => 'formapago',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '20',   filtro => 'N',   key => 'N'),
            array( campo => 'total',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $valor,   filtro => 'N',   key => 'N'),
            array( campo => 'plazo',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'unidadtiempo',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => 'dias',   filtro => 'N',   key => 'N')
        );
        
        
        $this->bdFactura->_InsertSQL('spo_forma_pago',$ATablaRef,'spo_detalle_det_codigo_seq');
        
        
    }
    //------------------------------------------
    function _10_Cabecera_Adicional( $codFac,$titulo,$correoUsuario){
        
        
        $ATablaRef = array(
            array( campo => 'iad_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor =>$codFac,   filtro => 'N',   key => 'N'),
            array( campo => 'ida_nombre',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => $titulo,   filtro => 'N',   key => 'N'),
            array( campo => 'ida_valor',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => $correoUsuario,   filtro => 'N',   key => 'N')
        );
        
        
        $this->bdFactura->_InsertSQL('spo_informacion_adicional',$ATablaRef,'spo_detalle_det_codigo_seq');
        
        
        
    }
    
    //---------------------------------------
    function _06_Detalle_FacturaElectronica( $id,$codFac){
        
        $sql_det = 'SELECT id, codigo, producto, unidad,
                             cantidad, costo, total, tipo, monto_iva,
                             tarifa_cero, tributo, baseiva, sesion, id_movimiento
                      FROM  view_factura_detalle
                     where id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        
        $stmt1 = $this->bd->ejecutar($sql_det);
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            if ( trim($x['tributo']) == 'I'){
                
                $costo = $x['baseiva'] / $x['cantidad'];
            }
            
            if ( trim($x['tributo']) == 'T'){
                
                
                $costo = $x['tarifa_cero'] / $x['cantidad'];
            }
            
            if ( trim($x['tributo']) == '-'){
                
                if ($x['tarifa_cero']  > 0 ) {
                    $costo = $x['tarifa_cero'] / $x['cantidad'];
                }
            }
            
            $costo = round($costo,2);
            
            $totalsiniva = $x['baseiva'] + $x['tarifa_cero'] ;
            
            
            $ATablaDet = array(
                array( campo => 'det_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => $codFac,   filtro => 'N',   key => 'N'),
                array( campo => 'codigoprincipal',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => 'Ref-'.$x['id'],   filtro => 'N',   key => 'N'),
                array( campo => 'codigoauxiliar',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor =>  'Ref-'.$x['id'],   filtro => 'N',   key => 'N'),
                array( campo => 'descripcion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $x['producto'],   filtro => 'N',   key => 'N'),
                array( campo => 'cantidad',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor =>  $x['cantidad'],   filtro => 'N',   key => 'N'),
                array( campo => 'preciounitario',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $costo ,   filtro => 'N',   key => 'N'),
                array( campo => 'descuento',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor =>'0',   filtro => 'N',   key => 'N'),
                array( campo => 'preciototalsinimpuesto',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $totalsiniva,   filtro => 'N',   key => 'N')
            );
            
            $iddet_codigo =  $this->bdFactura->_InsertSQL('spo_detalle',$ATablaDet,'spo_detalle_det_codigo_seq');
            
            $this->_07_Detalle_FacturaElectronicaImpuesto(
                $iddet_codigo,
                'Ref-'.$x['id'] ,
                $codFac,
                $x['tributo'] ,
                $x['baseiva'] ,
                $x['tarifa_cero']  ,
                $x['monto_iva']   ,
                $x['total'],
                $x['cantidad'] );
            
        }
        
    }
    
    //---------------------------------------
    function _07_Detalle_FacturaElectronicaImpuesto(  $iddet_codigo,
        $idReferencia,
        $codFac,
        $tributa,
        $baseiva,
        $tarifa_cero,
        $monto_iva,
        $total,
        $cantidad)
    {
        
        $codigoporcentaje = '0';
        $baseimponible    = '0';
        $valor1            = '0';
        
        if( trim($tributa) == 'T' ){
            $codigoporcentaje = '0';
            $baseimponible = $tarifa_cero;
            $valor1  = '0';
            $tarifa = '0';
        }
        
        if( trim($tributa) ==  'I' ){
            $codigoporcentaje = '2';
            $baseimponible = $baseiva;
            $valor1  = $monto_iva/$cantidad;
            $tarifa = '12';
        }
        
      //  $valor1  = round($valor ,2);
        
        $ATablaRefDetalle = array(
            array( campo => 'ide_detalle',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => $iddet_codigo,   filtro => 'N',   key => 'N'),
            array( campo => 'codigo',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => '2',   filtro => 'N',   key => 'N'),
            array( campo => 'codigoporcentaje',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $codigoporcentaje,   filtro => 'N',   key => 'N'),
            array( campo => 'descuentoadicional',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'baseimponible',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $baseimponible,   filtro => 'N',   key => 'N'),
            array( campo => 'tarifa',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $tarifa,   filtro => 'N',   key => 'N'),
            array( campo => 'valor',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $valor1,   filtro => 'N',   key => 'N')
        );
        
        
        $this->bdFactura->_InsertSQL('spo_impuesto_detalle',$ATablaRefDetalle,'spo_impuesto_detalle_ide_codigo_seq');
        
        
    }
    //----------------------------------------------
    function _03_Cabecera_Factura($id){
        
        $this->Array_Cabecera = $this->bd->query_array(
            'view_inv_movimiento',
            'id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo,
              id_periodo, documento, idprov, id_asiento_ref, proveedor, razon, direccion,
              telefono, correo, contacto, fechaa, anio, mes, transaccion, carga',
            'id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
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
            
            $filtro =   'emi01codi   ='.$this->bdFactura->sqlvalue_inyeccion($id,true).' and
                         coddoc = '.$this->bdFactura->sqlvalue_inyeccion('01',true).' and
                         ruc='.$this->bdFactura->sqlvalue_inyeccion($this->ruc ,true) ;
            
        }else{
            
            $filtro =   'cab_codigo   ='.$this->bdFactura->sqlvalue_inyeccion($referencia,true).' and
                         coddoc = '.$this->bdFactura->sqlvalue_inyeccion('01',true).' and
                         ruc='.$this->bdFactura->sqlvalue_inyeccion($this->ruc ,true) ;
            
        }
        
        
        $this->ArrayAutorizacion = $this->bdFactura->query_array(
            'spo_cabecera',
            'cab_estado_comprobante,cab_autorizacion,cab_codigo',
            $filtro
            );
        
        return $this->ArrayAutorizacion ['cab_estado_comprobante'];
        
    }
    
    //------------------------
    //-----------------------
    function _Autorizacion( ){
        
        
        return $this->ArrayAutorizacion ['cab_autorizacion'];
        
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
    function _04_TotalFactura( $id ){
        
        
        $this->ArrayTotal = $this->bd->query_array(
            'view_ventas_idresumen',
            'baseiva, monto_iva, tarifa_cero, total',
            'id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        
    }
    //-----------------------------------------
    function _GetCabecera( $variable ){
        
        return  $this->Array_Cabecera[$variable];
        
    }
    
    //-----------------------------------------
    function _11_ActualizaMovimiento( $id,$tipo_dato ,$codFac){
        
        $sql = "UPDATE inv_movimiento
						   SET 	envio=".$this->bd->sqlvalue_inyeccion($tipo_dato, true).",
                                cab_codigo=".$this->bd->sqlvalue_inyeccion($codFac, true)."
 						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
        
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
    function _ActualizaAutorizacion( $id,$tipo_dato ){
        
        $sql = "UPDATE inv_movimiento
						   SET 	autorizacion=".$this->bd->sqlvalue_inyeccion($tipo_dato, true)."
 						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
    }
    //-----------------------------------------
    function _01_Verifica_estado( $id ){
        
        $ArrayVer = $this->bd->query_array(
            'inv_movimiento',
            "coalesce(envio,'N') AS envio,coalesce(cab_codigo,0) AS cab_codigo ",
            ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        
        if ($ArrayVer['cab_codigo'] > 0){
            
            return 'S';
            
        }else {
            
            return 'N';
            
        }
        
    }
    //---------------
    function _Verifica_facturas(   ){
        
        $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 , tarifa_cero = total / cantidad , baseiva = 0 ,costo = total / cantidad "."
 				 		 WHERE  tarifa_cero is null and
                                cantidad > 0 and
                                monto_iva is null and
                                tipo=".$this->bd->sqlvalue_inyeccion('T', true);
        
        $this->bd->ejecutar($sqlEdit);
        
        
        
        $sql = "update inv_movimiento_det
                        set tipo = ".$this->bd->sqlvalue_inyeccion('T', true)."
                        where   cantidad > 0 and monto_iva = 0 and tipo is null" ;
        
        $this->bd->ejecutar($sql);
        
        
        $sql = "update inv_movimiento_det
                     set tarifa_cero = costo * cantidad,
                         total       = costo * cantidad
                   where  tipo = ".$this->bd->sqlvalue_inyeccion('T', true)." and
                          (monto_iva + tarifa_cero + baseiva) <> total" ;
        
        $this->bd->ejecutar($sql);
        
        
        //----------------
        $sqlEdit = "update inv_movimiento_det
				      set tarifa_cero = total / cantidad , baseiva = 0 ,costo = total / cantidad "."
 				 		 WHERE  cantidad = 1 and
                                monto_iva = 0 and
                                tipo=".$this->bd->sqlvalue_inyeccion('T', true);
        
        $this->bd->ejecutar($sqlEdit);
        
    }
    //---------------
    function _Verifica_suma_facturas(   ){
        
        
        $sql_det1 = "SELECT id_movimiento,    iva, base0, base12, total
                        FROM inv_movimiento
                        where base0 is null and  estado = 'aprobado' ";
        
        
        
        $stmt1 = $this->bd->ejecutar($sql_det1);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            $id = $x['id_movimiento'];
            
            $ATotal = $this->bd->query_array(
                'inv_movimiento_det',
                'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
                ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
                );
            
            $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
            
            $this->bd->ejecutar($sqlEdit);
            
            
        }
        
    }
    //----------------------------------------------
    //---------------
    function _Verifica_suma_facturas_Total(   ){
        
        
        $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where ( iva + base0 + base12) <> total and    estado = 'aprobado'";
        
        
        
        $stmt1 = $this->bd->ejecutar($sql_det1);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            $id = $x['id_movimiento'];
            
            $ATotal = $this->bd->query_array(
                'inv_movimiento_det',
                'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
                ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
                );
            
            $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
            
            $this->bd->ejecutar($sqlEdit);
            
            
        }
        
    }
    //-----------------------------------------------------
    function _lote_factura(    ){
        
        
        $dataServer = $this->conexion_server( );
        
        $mes = date("m");
        
        $dia = date("Y-m-d"); 
        
        $dia2 =  date('Y-m-d', strtotime("-5 days"));
        
        $sql_det1 = "SELECT id_movimiento ,correo
                        FROM view_inv_movimiento
                        where registro =". $this->bd->sqlvalue_inyeccion( $this->ruc,true). " and 
                              correo is not null and 
                              autorizacion is null and 
                              estado = 'aprobado' and
                              fecha between ".$this->bd->sqlvalue_inyeccion($dia2,true). ' and '.$this->bd->sqlvalue_inyeccion($dia,true) ;
        
         
        $stmt1 = $this->bd->ejecutar($sql_det1);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            
            $id = $x['id_movimiento'] ;
            
 
            $longitud = strlen( trim($x['correo']) ) ;
            
            $idenvio =  $x['id_movimiento'] ;
            
            
            if ($longitud > 5  ) {
            
                          $verifica = $this->_01_Verifica_estado( $id );
              
            
                            if (trim($verifica) == 'S'){
                                
                                if ($dataServer <> 0){
                                    
                                    $estado    =  $this->_02_CodigoAutorizacion( 0,$id,1 );
                                    
                                    $codFac    =  $this->_cab_codigo();
                                    
                                    $autoriza  =  $this->_Autorizacion();
                                    
                                    //-------- ---------------------------------------------
                                    if (trim($estado) == 'AUTORIZADO'){
                                        
                                        $this->_ActualizaAutorizacion( $id ,$autoriza );
                                        
                                    }
                                    //-------------------------------------------------
                                    //-------------------------------------------------
                                    if (trim($estado) == 'DEVUELTA'){
                                        
                                        $this->_11_ActualizaMovimiento( $id ,'N',0);
                                        
                                        $this->__eliminar($codFac);
                                        
                                    }
                                    //-------------------------------------------------
                                    if (trim($estado) == 'NO AUTORIZADO'){
                                        
                                        $this->_11_ActualizaMovimiento( $id ,'N',0);
                                        
                                        $this->__eliminar($codFac);
                                        
                                    }
                                }
                            }
                            //------------------------------------------------------------
                             if (trim($verifica) == 'N'){
                                
                                if ($dataServer <> 0) {
                                       
                                    $codFac = $this->_05_Cabecera_FacturaElectronica( $id ); // cabecera transaccion
                                    
                                    if ( $codFac <> 0 )  {
                                        
                                        $estado = $this->_02_CodigoAutorizacion( $codFac,$id,0 );
                                        
                                        $this->_11_ActualizaMovimiento( $id ,'S',$codFac);
                                        
                                        $estado = $this->_02_CodigoAutorizacion( $codFac,$id,0 );
                                        
                                        //----------------------------------------------
                                        if (trim($estado) == 'AUTORIZADO'){
                                            
                                            $this->_ActualizaAutorizacion( $id ,$this->_Autorizacion());
                                            
                                        }
                                    }
                                }
                                
                            }
            } 
            
            
        }
        return $estado  ;
    }
    //--------------------------------------------------------------
}
//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------

$gestion   = 	new componente;

 
 

$key       =  $gestion->_keyFactura();

$data = 'Solicite al administrador la parametrizacion para envio de la facturacion electronica ' ;

if ($key == 1) {
    
    $data = $gestion->_lote_factura( );
    
}


echo   $data;




?>
 
 
  