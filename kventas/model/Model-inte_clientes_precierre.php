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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
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
            array( campo => 'idbodega',   tipo => 'NUMBER',   id => '20',  add => 'S',   edit => 'N',   valor => 'servicio',   filtro => 'N',   key => 'N')
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
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId( $id,$idvengestion ){
        
          
        $qquery = array(
            array( campo => 'idvencliente',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',   valor => $id,  filtro => 'S',   visor => 'N'),
             array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'contacto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'provincia',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'canton',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'web',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'actualizado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'identificacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idmovimiento',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
       
        
        $datos = $this->bd->JqueryArray('ven_cliente',$qquery );
        
        $identificacion = trim($datos['identificacion']);
        
        $dato = '<b>El estado del tramite debe estar en prefactura '.$identificacion.'</b>';
        
        if ( $datos['actualizado'] == 'S'){
            
            $Aestado = $this->bd->query_array('ven_cliente_seg',
                                                 'estado,novedad', 
                                                 'idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion,true)
                                                );
            
           
            
            if ($Aestado['estado']  == 11){
                
                
                if ( $datos['idmovimiento'] == 0  ){
                           //----------------------------------------------- 
                    $dato = '<b>Debe generar Pre Factura de '.$identificacion.' Nro Transaccion: '.$idvengestion.'  </b>';
                        
                }else{
                    
                    $sqlEdit = "update ven_cliente
                               set proceso  =".$this->bd->sqlvalue_inyeccion( 'Proceso Finalizado',true).",
                                   estado  =".$this->bd->sqlvalue_inyeccion( '12',true)."
                             where trim(identificacion) = ".$this->bd->sqlvalue_inyeccion(trim($identificacion),true)  ;
                    
                    $this->bd->ejecutar($sqlEdit);
                    
                    $sqlEdit = "update ven_cliente_seg
                               set estado  =".$this->bd->sqlvalue_inyeccion( '12',true)."
                             where idvengestion = ".$this->bd->sqlvalue_inyeccion($idvengestion,true)  ;
                    
                    $this->bd->ejecutar($sqlEdit);
                    
                    //-----------------------------------------------
                    $dato = '<b>Proceso Finalizado identificacion: '.$identificacion.' Nro Transaccion: '.$id_movimiento.'  </b>';
               
                }
 
            }
 
        }else{
            $dato = '<b>Cliente  NO esta actualizada la informacion '.$identificacion.'</b>';
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
    function agregar($datos,$identificacion,$idvengestion,$novedad){
   
        $fecha =   $this->hoy;
        $idperiodo = $this->periodo($fecha);
        $idprov    =  $identificacion;
         
        $this->ATabla[9][valor]  =  $idperiodo;
        $this->ATabla[11][valor] =  trim($idprov);
        $this->ATabla[3][valor]  =  trim($novedad);
        $this->ATabla[6][valor]  =  '-';
        $this->ATabla[10][valor] = 'CRM-'.$idvengestion;
        
              
        $AResultado = $this->bd->query_array('ven_cliente_prod',
                                             'max(idbodega) as  idbodega', 
                                             'idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion,true).' and 
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
        $IVA         = 12/100;
        $IVADesglose = 1 + $IVA;
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
        $saldo = $AProducto['saldo'];
        
        
        $ingreso = 0;
        $egreso = 1;
        
        $nbandera = 1;
        
        
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
            array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $cantidad,   filtro => 'N',   key => 'N'),
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
 
  