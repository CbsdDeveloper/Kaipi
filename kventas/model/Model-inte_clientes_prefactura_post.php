<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
   
    private $tabla ;
    private $secuencia;
    private $estado_periodo;
   
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");    	
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
        $this->ATabla = array(
            array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
            array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
            array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
            array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '00000',   filtro => 'N',   key => 'N'),
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'cierre',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
            array( campo => 'base12',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'iva',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'base0',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'total',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'novedad',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'N',   valor => 'servicio',   filtro => 'N',   key => 'N'),
            array( campo => 'idbodega',   tipo => 'NUMBER',   id => '20',  add => 'S',   edit => 'N',   valor => 'servicio',   filtro => 'N',   key => 'N'),
            array( campo => 'comision',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => 'servicio',   filtro => 'N',   key => 'N')
        );
        
        $this->tabla 	  	  = 'inv_movimiento';
        
        $this->secuencia 	     = '-';
         
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        
       
        
        if ($tipo == 0){
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
                if ($accion == 'del')
                    $resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>';
                    
        }
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b><br>';
            
        }
        
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = '';
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    //---------------------- tipo de venta
   
    function tipo_venta($idvengestion,$idprov ){
       
        $qquery = array(
            array( campo => 'idvengestion',   valor => $idvengestion,  filtro => 'S',   visor => 'N'),
            array( campo => 'idprov',   valor => $idprov,  filtro => 'S',   visor => 'S'),
            array( campo => 'condicion_comercial',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_cotizacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'modulo',   valor => 'ordenp',  filtro => 'S',   visor => 'S'),
            array( campo => 'registro',   valor => $this->ruc,  filtro => 'S'  ,   visor => 'S')
        );
        
        
        
        $datos = $this->bd->JqueryArray('ven_cotizacion',$qquery );
        
      
     
        
        return $datos['condicion_comercial'] ; 
        
    }
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId( $id,$idvengestion ){
        
          
        $qquery = array(
            array( campo => 'idven_gestion',   valor => $idvengestion,  filtro => 'S',   visor => 'N'),
             array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'vendedor',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'novedad',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'idmovimiento',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        
        
        $datos = $this->bd->JqueryArray('ven_cliente_gestion',$qquery );
        
        $estado         =  $datos['estado'] ;
        $idmovimiento   =  $datos['idmovimiento'];
        $identificacion =  $datos['idprov'];
        $comision       = $datos['vendedor'];
        $novedad        = $datos['novedad'];
        
        $dato = '<b>El estado del tramite debe estar en Orden de Servicio/Bien  '.$identificacion.'</b>';
        
        
        if ( $estado  == '3'){
            
            if ( $idmovimiento == 0  ){
                
                // factura
                //acumula 
                //ingreso 
                //ingresoacumula 
                
                $valida_dato = $this->tipo_venta($idvengestion,$identificacion );
            
                
                // genera para factura 
                
                if ( $valida_dato == 'factura') {
                    
                    $id_movimiento =  $this->agregar($datos,$identificacion,$idvengestion,$novedad,$comision);
                    
                    if ( $id_movimiento == 0){
                        
                        $dato = '<b>No se pudo emitir el comprobante de '.$identificacion.' - '.$id_movimiento.'!!! </b>';
                        
                    }else{
                        
                        $sql = "SELECT  idproducto, idbodega,  producto, detalle,   cantidad,precio_descuento,iva,subtotal,total, tipo
                                FROM  ven_cliente_prod
                                where estado = 1 and
                                      idvengestion = ".$this->bd->sqlvalue_inyeccion($idvengestion,true)." and
                                      registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true) ;
                        
                        $stmt = $this->bd->ejecutar($sql);
                        // inserta detalle
                        while ($fila=$this->bd->obtener_fila($stmt)){
                            
                            $this->nuevo_detalle($id_movimiento,$fila );
                            
                        }
                        ///--------------------
                        $sqlEdit = "update ven_cliente_gestion
                               set factura  =".$this->bd->sqlvalue_inyeccion( 'S',true).",
                                   idmovimiento  =".$this->bd->sqlvalue_inyeccion( $id_movimiento,true)."
                             where idven_gestion = ".$this->bd->sqlvalue_inyeccion($idvengestion,true)  ;
                        
                        $this->bd->ejecutar($sqlEdit);
                        //-----------------------------------------------
                        $dato = '<b>Pre Factura emitida '.$identificacion.' Nro Transaccion: '.$id_movimiento.'  </b>';
                    }
                      
                }
                //------------------------------------------------------------------------------------------------------
                if ( $valida_dato == 'ingreso') {
                    
                    $id_movimiento =  $this->agregar_ingreso($datos,$identificacion,$idvengestion,$novedad,$comision);
                    
                    if ( $id_movimiento == 0){
                        
                        $dato = '<b>No se pudo emitir el comprobante de '.$identificacion.' - '.$id_movimiento.'!!! </b>';
                        
                    }else{
                        
                        $sql = "SELECT  idproducto, idbodega,  producto, detalle,   cantidad,precio_descuento,iva,subtotal,total, tipo
                                FROM  ven_cliente_prod
                                where estado = 1 and
                                      idvengestion = ".$this->bd->sqlvalue_inyeccion($idvengestion,true)." and
                                      registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true) ;
                        
                        $stmt = $this->bd->ejecutar($sql);
                        // inserta detalle
                        while ($fila=$this->bd->obtener_fila($stmt)){
                            
                            $this->nuevo_detalle($id_movimiento,$fila );
                            
                        }
                        ///--------------------
                        $sqlEdit = "update ven_cliente_gestion
                               set factura  =".$this->bd->sqlvalue_inyeccion( 'S',true).",
                                   idmovimiento  =".$this->bd->sqlvalue_inyeccion( $id_movimiento,true)."
                             where idven_gestion = ".$this->bd->sqlvalue_inyeccion($idvengestion,true)  ;
                        
                        $this->bd->ejecutar($sqlEdit);
                        //-----------------------------------------------
                        $dato = '<b>Pre Factura emitida '.$identificacion.' Nro Transaccion: '.$id_movimiento.'  </b>';
                    }
                    
                }
                //------------------------------------------------------------------------------
                if ( $valida_dato == 'acumula') {
                    
                    $id_movimiento = -1;
                    
                    $sqlEdit = "update ven_cliente_gestion
                               set factura  =".$this->bd->sqlvalue_inyeccion( 'S',true).",
                                   idmovimiento  =".$this->bd->sqlvalue_inyeccion( $id_movimiento,true)."
                             where idven_gestion = ".$this->bd->sqlvalue_inyeccion($idvengestion,true)  ;
                    
                    $this->bd->ejecutar($sqlEdit);
                    //-----------------------------------------------
                    $dato = '<b>Pre Factura Acumulada '.$identificacion.' Nro Transaccion: por verificar </b>';
                    
                }
            }else{
                $dato = '<b>Tramite ya facturado con la transaccion:  '.$idmovimiento.'</b>';
            }
        }
        else{
            return  $dato;
        }
        
 
        return  $dato;
        
    } 
    //--------------------
    function _busca_ruc( $id){
        
        
        $longi = strlen(trim($id));
        
     
        $AResultado = $this->bd->query_array(
                'par_ciu',
                'count(*) as nn',
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)
                );
            
            return  $AResultado['nn'];
       
        
    }
    
 
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function agregar($datos,$identificacion,$idvengestion,$novedad,$comision){
   
        $fecha =   $this->hoy;
        $idperiodo = $this->periodo($fecha);
        $idprov    =  $identificacion;
         
        $this->ATabla[9][valor]  =  $idperiodo;
        $this->ATabla[11][valor] =  trim($idprov);
        $this->ATabla[3][valor]  =  trim($novedad);
        $this->ATabla[6][valor]  =  '-';
        $this->ATabla[10][valor] = 'CRM-'.$idvengestion;
       
        $this->ATabla[21][valor] = $comision;
              
        
        $AResultado = $this->bd->query_array('ven_cliente_prod',
                                             'max(idbodega) as  idbodega', 
                                             'estado = 1 and idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion,true).' and 
                                             registro='.$this->bd->sqlvalue_inyeccion( $this->ruc ,true)
            );
        
        $idbodega                = $AResultado['idbodega'];
        $this->ATabla[20][valor] = $idbodega;
        
 
            
            if (!empty($identificacion)){
                
                $idmovimiento = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
 
                return $idmovimiento;
                
             }
             
            return 0; 
 
    
    }
  //
    function agregar_ingreso($datos,$identificacion,$idvengestion,$novedad,$comision){
        
        $fecha =   $this->hoy;
        $idperiodo = $this->periodo($fecha);
        $idprov    =  $identificacion;
        
        $this->ATabla[9][valor]  =  $idperiodo;
        $this->ATabla[11][valor] =  trim($idprov);
        $this->ATabla[3][valor]  =  trim($novedad).' Ref.'.$idvengestion;
        $this->ATabla[6][valor]  =  '-';
        $this->ATabla[10][valor] = 'EGRESO';
       
        $this->ATabla[21][valor] = $comision;
        
        
        $AResultado = $this->bd->query_array('ven_cliente_prod',
            'max(idbodega) as  idbodega',
            'estado = 1 and idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion,true).' and
                                             registro='.$this->bd->sqlvalue_inyeccion( $this->ruc ,true)
            );
        
        $idbodega                = $AResultado['idbodega'];
        $this->ATabla[20][valor] = $idbodega;
        
        
        
        if (!empty($identificacion)){
            
            $idmovimiento = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
            
            return $idmovimiento;
            
        }
        
        return 0;
        
        
    }
  //---------------------------------------
    function periodo($fecha ){
        
        $anio = substr($fecha, 0, 4);
        $mes  = substr($fecha, 5, 2);
        
        $APeriodo = $this->bd->query_array('co_periodo',
            'id_periodo, estado',
            'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true). ' AND
											  mes = '.$this->bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$this->bd->sqlvalue_inyeccion($anio,true)
            );
        
        
        $this->estado_periodo = trim($APeriodo['estado']);
        
        return $APeriodo['id_periodo'];
        
    }
 ///------------------------------------
    function nuevo_detalle($id_movimiento,$fila ){
        
        /*
         * 
         idproducto, idbodega,  producto, detalle,    cantidad,precio_descuento,iva,subtotal,total, tipo
                                
         */
        //---------------------------------------------------
       /* $IVA         = 12/100;
        $IVADesglose = 1 + $IVA;*/
        $sesion 	       =    $_SESSION['email'];
          //----------------------------------------------------
   
        $venta      = $fila['precio_descuento'];
        $idproducto = $fila['idproducto'];
        
        
        //------------------------------------------------------
        $AProducto = $this->bd->query_array( 'web_producto',
            'costo,tributo,saldo',
            'idproducto='.$this->bd->sqlvalue_inyeccion($idproducto,true)
            );
        
        //----------------------------------------------------
 //       $saldo = $AProducto['saldo'];
        
        
        $cantidad  = $fila['cantidad'];
        $egreso    = $cantidad;
        $costo_pvp = $fila['precio_descuento'];
  //      $nbandera = 1; 
        
        
        //----------------------------------------------------
        if ($venta > 0){
            $costo_pvp = $venta;
        }else{
            $costo_pvp = $AProducto['costo'];
        }
        
        
        if (trim($fila['tipo']) == 'I'){
            $total       =  $fila['total'];
            $baseiva     =  $fila['subtotal'];
            $tarifa_cero = 0;
            $monto_iva   = $fila['iva'];
            
        }else{
            $total       =  $fila['total'];
            $monto_iva   = 0;
            $tarifa_cero = $fila['total'];
            $baseiva = 0;
        }
        
        
        $cantidad  =  $fila['cantidad'];
         
          
        
        $ATabla = array(
            array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
            array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $cantidad,   filtro => 'N',   key => 'N'),
            array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
            array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $venta,   filtro => 'N',   key => 'N'),
            array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
            array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
            array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $fila['tipo'],   filtro => 'N',   key => 'N'),
            array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => 0,   filtro => 'N',   key => 'N'),
            array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
            array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
            
        );
        
  
        $this->bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
      
        
          
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['idcliente']))	{
    
    
    
    $id              = $_GET['idcliente'];
    
    $idvengestion    = $_GET['idvengestion'];
    
    $mensaje_factura =   $gestion->consultaId($id,$idvengestion);
    
    echo $mensaje_factura;
}
 


?>
 
  