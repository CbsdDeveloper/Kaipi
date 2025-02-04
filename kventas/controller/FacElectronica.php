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
        
        $detalleF  = trim($this->Array_Cabecera['detalle']);
        $contactoF = $this->Array_Cabecera['contacto'];
        $sesionF   = $this->Array_Cabecera['sesion'];
        
        
        $ADatos  =  $this->_03_Cabecera_datos($id);
         
        
         
        $DIRECCION   = trim($ADatos['direccion'] );
        $razonSocial = trim($ADatos['razon'] ) ;
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
                array( campo => 'ruc',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'S',   valor => trim($this->Array_Cabecera['registro']),   filtro => 'N',   key => 'N'),
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
        
     /*   $sql_det = 'SELECT id, codigo, producto, unidad,
                             cantidad, costo, total, tipo, monto_iva,
                             tarifa_cero, tributo, baseiva, sesion, id_movimiento
                      FROM  view_factura_detalle
                     where id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        */
        
        
        $filename = 'http://www.s2i.com.ec/kaipi/kventas/controller/datas_detalle.csv';
         
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            $x['id'] = $data[0];
            $x['codigo'] =  trim($data[1]);
            $x['producto'] = trim($data[2]);
            $x['unidad'] = $data[3];
            $x['cantidad'] = $data[4];
            $x['costo'] = $data[5];
            $x['total'] = $data[6];
            $x['tipo'] = $data[7];
            $x['monto_iva'] = $data[8];
            $x['tarifa_cero'] = $data[9];
            $x['tributo'] = $data[10];
            $x['baseiva'] = $data[11];
            
   
       
        
   //     while ($x=$this->bd->obtener_fila($stmt1)){
            
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
            
            $totalsiniva = $x['baseiva'] + $x['tarifa_cero'] ;
            
            $costo = round($costo,2);
            
            $ATablaDet = array(
                array( campo => 'det_cabecera',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => $codFac,   filtro => 'N',   key => 'N'),
                array( campo => 'codigoprincipal',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => 'Ref-'.$x['id'],   filtro => 'N',   key => 'N'),
                array( campo => 'codigoauxiliar',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor =>  'Ref-'.$x['id'],   filtro => 'N',   key => 'N'),
                array( campo => 'descripcion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $x['producto'],   filtro => 'N',   key => 'N'),
                array( campo => 'cantidad',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor =>  $x['cantidad'],   filtro => 'N',   key => 'N'),
                array( campo => 'preciounitario',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor =>$costo,   filtro => 'N',   key => 'N'),
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
        
 
       fclose($handle);
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
        $valor            = '0';
        
        if( trim($tributa) == 'T' ){
            $codigoporcentaje = '0';
            $baseimponible = $tarifa_cero;
            $valor  = '0';
            $tarifa = '0';
        }
        
        if( trim($tributa) ==  'I' ){
            $codigoporcentaje = '2';
            $baseimponible = $baseiva;
            $valor  = $monto_iva/$cantidad;
            $tarifa = '12';
        }
        
        $valor = round($valor,2);
        
        $ATablaRefDetalle = array(
            array( campo => 'ide_detalle',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => $iddet_codigo,   filtro => 'N',   key => 'N'),
            array( campo => 'codigo',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => '2',   filtro => 'N',   key => 'N'),
            array( campo => 'codigoporcentaje',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $codigoporcentaje,   filtro => 'N',   key => 'N'),
            array( campo => 'descuentoadicional',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'baseimponible',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $baseimponible,   filtro => 'N',   key => 'N'),
            array( campo => 'tarifa',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $tarifa,   filtro => 'N',   key => 'N'),
            array( campo => 'valor',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $valor,   filtro => 'N',   key => 'N')
        );
        
        
        $this->bdFactura->_InsertSQL('spo_impuesto_detalle',$ATablaRefDetalle,'spo_impuesto_detalle_ide_codigo_seq');
        
        
    }
    //----------------------------------------------
    function _03_Cabecera_Factura($id){
             
        $filename = 'http://www.s2i.com.ec/kaipi/kventas/controller/datas.csv';
    
   
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            $this->Array_Cabecera['id_movimiento'] = $data[0];
            $this->Array_Cabecera['registro'] = $data[1];
            $this->Array_Cabecera['idprov'] = $data[2];
            $this->Array_Cabecera['fecha'] = $data[3];
            $this->Array_Cabecera['detalle'] = $data[4];
            $this->Array_Cabecera['comprobante'] = $data[5];
            $this->Array_Cabecera['tipo'] = $data[6];
            $this->Array_Cabecera['proveedor'] = $data[7];
            $this->Array_Cabecera['razon'] = $data[8];
            $this->Array_Cabecera['direccion'] = $data[9];
            $this->Array_Cabecera['transaccion'] = $data[10];
            $this->Array_Cabecera['autorizacion'] = $data[11];
            $this->Array_Cabecera['envio'] = $data[12];
            $this->Array_Cabecera['carga'] = $data[13];
           
            
        }
        
        
        $this->ruc       =  $this->Array_Cabecera['registro'];
        
        fclose($handle);
 
        
    }
    //-------------
    function _03_Cabecera_datos($id){
          
        $filename = 'http://www.s2i.com.ec/kaipi/kventas/controller/datas_cab.csv';
   
       
       
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            $ADatos['razon'] = $data[0];
            $ADatos['contacto'] = $data[1];
            $ADatos['correo'] = $data[2];
            $ADatos['direccion'] = $data[3];
            $ADatos['felectronica'] = $data[4];
            $ADatos['ruc_registro'] = $data[5];
            $ADatos['estab'] = $data[6];
            $this->ruc       =  $data[5];;
        }
        
        $this->ruc       =  trim($ADatos['ruc_registro']);
        
        fclose($handle);
        
        return $ADatos;
        
    }
   //-------------------
    function _03_Cabecera_detalle($id){
 
        $filename = 'http://www.s2i.com.ec/kaipi/kventas/controller/datas_detalle.csv';
        
       
        
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            $ADatos['id'] = $data[0];
            $ADatos['codigo'] = $data[1];
            $ADatos['producto'] = $data[2];
            $ADatos['unidad'] = $data[3];
            $ADatos['cantidad'] = $data[4];
            $ADatos['costo'] = $data[5];
            $ADatos['total'] = $data[6];
            $ADatos['tipo'] = $data[7];
            $ADatos['monto_iva'] = $data[8];
            $ADatos['tarifa_cero'] = $data[9];
            $ADatos['tributo'] = $data[10];
            $ADatos['baseiva'] = $data[11];
            
        }
        
        fclose($handle);
        
        return $ADatos;
        
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
        
        return $this->ArrayAutorizacion['cab_estado_comprobante'];
        
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
        
    /*    $csv.=$row['id'].$csv_sep.
        $row['codigo'].$csv_sep.
        $row['producto'].$csv_sep.
        $row['unidad'].$csv_sep.
        $row['cantidad'].$csv_sep.
        $row['costo'].$csv_sep.
        $row['total'].$csv_sep.
        $row['tipo'].$csv_sep.
        $row['monto_iva'].$csv_sep.
        $row['tarifa_cero'].$csv_sep.
        $row['tributo'].$csv_sep.
        $row['baseiva'].$csv_end;
        */
        
        $filename = 'http://www.s2i.com.ec/kaipi/kventas/controller/datas_detalle.csv';
        
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            $this->ArrayTotal['baseiva']     =  $this->ArrayTotal['baseiva']      +  $data[11];
            $this->ArrayTotal['monto_iva']   =  $this->ArrayTotal['monto_iva']    +  $data[8];
            $this->ArrayTotal['tarifa_cero'] =  $this->ArrayTotal['tarifa_cero'] +  $data[9];
            $this->ArrayTotal['total']       =  $this->ArrayTotal['total'] +  $data[6];
             
        }
        
        fclose($handle);
        
        return $this->ArrayTotal;
        
                
 
    }
    //-----------------------------------------
    function _GetCabecera( $variable ){
        
        return  $this->Array_Cabecera[$variable];
        
    }
    
    //-----------------------------------------
    function _11_ActualizaMovimiento( $id,$tipo_dato,$codFac ){
        
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
                                monto_iva = 0 and total <> tarifa_cero  and
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
            
            if ($ATotal['t1'] > 0) {
                $sqlEdit = "update inv_movimiento
        				           set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                                  base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                                  base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                                  total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
         				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
            }else {
                $sqlEdit = "update inv_movimiento
        				           set  estado = ".$this->bd->sqlvalue_inyeccion('anulado',true)."
          				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
               
            }
            
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
    function _lote_factura(  $id  ){
        
        
        $dataServer = $this->conexion_server( );
        
        $mes = date("m");
        
        
                   $estado = 'Factura enviada para autorizacion '.$verifica;
               
                   $datos =  $this->_03_Cabecera_datos($id);
                   
                    
                   $estado = $this->_02_CodigoAutorizacion( $codFac,$id,1 );
                   
                   $autorizacion = $this->_Autorizacion( );
                   
                   $codFac       =  $this->_cab_codigo();
                    
                   if (empty(trim($estado))){
                 
                       if ($dataServer <> 0) {
                        
                         $codFac = $this->_05_Cabecera_FacturaElectronica( $id ); // cabecera transaccion
                         
                         $estado = $this->_02_CodigoAutorizacion( $codFac,$id,1 );
                         
                         
                       }
                   }else{
                       
                       $this->_archivo_final( $estado,$codFac,$autorizacion ,$id);
                       
                   }
          
                   
 
    }
    //--------------------------------------------------------------
    function _archivo( $id  ){
        

        $csv_end = " ";
        $csv_sep = ";";
        $csv_file = "datas.csv";
        $csv="";
        
        $sql = "SELECT id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo,
              id_periodo, documento, idprov, id_asiento_ref, proveedor, razon, direccion,
              telefono, correo, contacto, fechaa, anio, mes, transaccion, carga,autorizacion,envio
            FROM  view_inv_movimiento
            where id_movimiento   = ".$this->bd->sqlvalue_inyeccion( $id ,true) ;
        
          
        $stmt = $this->bd->ejecutar($sql);
         
        while ($row=$this->bd->obtener_fila($stmt)){
            
            $csv.=$row['id_movimiento'].$csv_sep.
                  $row['registro'].$csv_sep.
                  $row['idprov'].$csv_sep.
                  $row['fecha'].$csv_sep.
                  $row['detalle'].$csv_sep.
                  $row['comprobante'].$csv_sep.
                  $row['tipo'].$csv_sep.
                  $row['proveedor'].$csv_sep.
                  $row['razon'].$csv_sep.
                  $row['direccion'].$csv_sep.
                  $row['transaccion'].$csv_sep.
                  $row['autorizacion'].$csv_sep.
                  $row['envio'].$csv_sep.
                  $row['carga'].$csv_end;
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
        
        //-------------------------
        $csv_end = " ";
        $csv_sep = ";";
        $csv_file = "datas_detalle.csv";
        $csv="";
        
        $csalto =" \n ";
        
        $sql_det = 'SELECT id, codigo, producto, unidad,
                             cantidad, costo, total, tipo, monto_iva,
                             tarifa_cero, tributo, baseiva    
                      FROM  view_factura_detalle
                     where id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        
        $stmt1 = $this->bd->ejecutar($sql_det);
        
        while ($row=$this->bd->obtener_fila($stmt1)){
            
            $csv.=$row['id'].$csv_sep.
            $row['codigo'].$csv_sep.
            $row['producto'].$csv_sep.
            $row['unidad'].$csv_sep.
            $row['cantidad'].$csv_sep.
            $row['costo'].$csv_sep.
            $row['total'].$csv_sep.
            $row['tipo'].$csv_sep.
            $row['monto_iva'].$csv_sep.
            $row['tarifa_cero'].$csv_sep.
            $row['tributo'].$csv_sep.
            $row['baseiva'].$csalto;
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
        
        ///----------------------------------
           
        //--------------------------
        
        $csv_end = " ";
        $csv_sep = ";";
        $csv_file1 = "datas_cab.csv";
        $csv="";
        
        $sql1 = "SELECT razon, contacto, correo,direccion,felectronica,ruc_registro,estab
            FROM  web_registro ";
        
       // .$this->bd->sqlvalue_inyeccion( $this->ruc ,true) 
        
        $stmt1 = $this->bd->ejecutar($sql1);
        
        while ($row=$this->bd->obtener_fila($stmt1)){
            
            $csv.=$row['razon'].$csv_sep.
                trim($row['contacto']).$csv_sep.
                trim($row['correo']).$csv_sep.
                trim($row['direccion']).$csv_sep.
                trim($row['felectronica']).$csv_sep.
                trim($row['ruc_registro']).$csv_sep.
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
        
        return $csv.' Informacion Generada...';
        
        
        $sql = "UPDATE inv_movimiento
						   SET 	envio=".$this->bd->sqlvalue_inyeccion('S', true)."
 						 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
        
    }
     //------------------------------------------------------------
   
    function _archivo_final($estado,$codFac,$autorizacion ,$id ){
        
        
         
        $csv_end = " ";
        $csv_sep = ";";
        $csv_file1 = "datas_val.csv";
        $csv="";
        
     
        $csv.=$estado.$csv_sep.$autorizacion.$csv_sep.$codFac.$csv_sep.$id.$csv_end;
        
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
        
    
    }
    //------------------------------------------------------------
 
    
}
//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------

$gestion   = 	new componente;


        $id                = $_GET['id'];
        
        $tipo                = $_GET['tipo'];

  
        if ($tipo == 1){
            
            $gestion->_Verifica_facturas();
            
            $gestion->_Verifica_suma_facturas();
            
            $gestion->_Verifica_suma_facturas_Total();
            
            
            $data = $gestion->_archivo( $id  );
            
            
            echo   $data;
            
        }else {
            
            
            $data = $gestion->_lote_factura($id);
         
            echo '<script> setTimeout("self.close();", 1000); </script> ';
            
        }
    




?>


 
  