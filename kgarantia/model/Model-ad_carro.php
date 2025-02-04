<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
     
    private $tabla ;
    private $secuencia;
    
    private $estado_periodo;
    private $ATabla_custodio ;
    
    private $ATabla_carro ;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =     trim($_SESSION['email']);
        
        $this->hoy 	     =     date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_bien',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',    key => 'S'),
            array( campo => 'idbodega',  tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'N',   valor => '0', key => 'N'),
            array( campo => 'tipo_bien',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',        id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'forma_ingreso',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'identificador',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'descripcion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'origen_ingreso',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'Compra', key => 'N'),
            array( campo => 'tipo_documento',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => 'Factura', key => 'N'),
            array( campo => 'clase_documento',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'tipo_comprobante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha_comprobante',tipo => 'DATE',id => '11',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'codigo_actual',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'costo_adquisicion',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'depreciacion',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'serie',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_modelo',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_marca',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'clasificador',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'cuenta',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'valor_residual',tipo => 'NUMBER',id => '21',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'anio_depre',tipo => 'NUMBER',id => '22',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'cantidad',tipo => 'NUMBER',id => '23',add => 'S', edit => 'N', valor => '1', key => 'N'),
            array( campo => 'vida_util',tipo => 'NUMBER',id => '24',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'color',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'dimension',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'uso',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'N', valor => 'Libre', key => 'N'),
            array( campo => 'fecha_adquisicion',tipo => 'DATE',id => '28',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'clase',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'N', valor =>  $this->sesion 	, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '31',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '32',add => 'S', edit => 'S', valor =>  $this->sesion 	, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '33',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'material',tipo => 'VARCHAR2',id => '34',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '35',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'detalle_ubica',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idsede',tipo => 'NUMBER',id => '37',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'idproveedor',tipo => 'VARCHAR2',id => '38',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'factura',tipo => 'NUMBER',id => '39',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '40',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'tiempo_garantia',tipo => 'VARCHAR2',id => '41',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'garantia',tipo => 'VARCHAR2',id => '42',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '43',add => 'S', edit => 'N', valor => 'BIENES', key => 'N')
        );
        
        
        
        
        
        $this->tabla 	  	  = 'activo.ac_bienes';
        
        $this->secuencia 	     = 'activo.ac_bienes_id_bien_seq';
        
      
        
     
        
        
        $this->ATabla_carro = array(
            array( campo => 'id_bien_vehiculo',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'clase_ve',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'motor_ve',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'chasis_ve',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'placa_ve',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'anio_ve',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'color_ve',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>  $this->sesion 	, key => 'N'),
            array( campo => 'status',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo_vehiculo',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'codigo_veh',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'u_km',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'umatricula',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado,$comprobante){
        //inicializamos la clase para conectarnos a la bd
        $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
        
        echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
        
        
        
        if ($tipo == 1){
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
        }
        
        if ($tipo == 0){
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ? ( '.$id.' )</b>';
           if ($accion == 'del')
                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?( '.$id.' )</b>';
        }
        
        if ($tipo == -1){
            $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>VERIFIQUE LA INFORMACION DEL PROVEEDOR/RESPONSABLE</b>';
        }
        
        if ($tipo == -2){
            $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>DEBE APERTURAR EL PERIODO EN CONTABILIDAD</b>';
        }
        
        if ($tipo == 2){
            $resultado ='<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO ['.$id.']</b>';
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
    function consultaId($accion,$id ){
        
        
        
        $qquery = array(
            array( campo => 'id_bien',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idbodega',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_bien',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'forma_ingreso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'identificador',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cantidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'origen_ingreso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'clase_documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_comprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_comprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'codigo_actual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'depreciacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_modelo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_marca',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'clasificador',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor_residual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio_depre',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'vida_util',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'color',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'dimension',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'uso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'clase',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'material',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_ubicacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'clase_esigef',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idsede',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle_ubica',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta_parametro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idproveedor',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'proveedor',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'garantia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tiempo_garantia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_tramite',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
       
       $datos_b= $this->bd->JqueryArrayVisor('activo.view_bienes',$qquery );
        
        $qquery = array(
            array( campo => 'id_bien',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'clase_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'motor_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'chasis_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'placa_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'color_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_vehiculo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'status',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'u_km',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'codigo_veh',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'umatricula',valor => '-',filtro => 'N', visor => 'S')
         );
        
        
        
        $datos1 =   $this->bd->JqueryArrayVisor('activo.ac_bienes_vehiculo',$qquery );
        
        $activo =   trim($datos1["id_bien"]);
        
        if ( $activo > 0  ){
            $datos["clase_ve"]  = $datos1["clase_ve"] ;
            $datos["motor_ve"]  = $datos1["motor_ve"] ;
            $datos["chasis_ve"] = $datos1["chasis_ve"] ;
            $datos["placa_ve"]  = $datos1["placa_ve"] ;
            $datos["anio_ve"]   = $datos1["anio_ve"] ;
            $datos["color_ve"]  = $datos1["color_ve"] ;
            $datos["umatricula"]  = $datos1["umatricula"] ;
            
            
            
            $datos["carro"] = 1;
        }else{
            $datos["carro"] = 0;
        }
        
        echo '<script>ListaModeloAsignado('.$datos_b["id_marca"].','.$datos_b["id_modelo"].') ;</script>';

        $datos = $this->div_resultado($accion,$id, 0,'digitado','0') ;
        
        echo $datos;
        
        
        
    }
//-------------------
  
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id );
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( ){
        
        
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
          
        
        $this->vehiculos($id);
        
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
         
        
        echo $datos;
        
        
    }
    
    function vehiculos($idbien){
        
        
        $Ac = $this->bd->query_array('activo.ac_bienes_vehiculo',
            'id_bien_vehiculo',
            'id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true)
            );
        
        $id_bien_vehiculo = $Ac['id_bien_vehiculo'] ;
        
        
        
        if ( $id_bien_vehiculo > 0 ) {
            
            $this->bd->_UpdateSQL('activo.ac_bienes_vehiculo',$this->ATabla_carro,$id_bien_vehiculo);
            
        }else{
            $this->bd->_InsertSQL('activo.ac_bienes_vehiculo',$this->ATabla_carro, 'activo.ac_bienes_vehiculo_id_bien_vehiculo_seq');
        }
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        
  
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $this->vehiculos($id);
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
        echo $datos;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
      /*  
        $estado =  $_POST["estado"];
        
        if (trim($estado) == 'digitado') {
            
            $sql = 'delete from inv_movimiento  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from inv_movimiento_det  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            $result = $this->div_limpiar();
            
        }else {
            
            $sql = 'update inv_movimiento
                       set estado = '.$this->bd->sqlvalue_inyeccion('anulado', true).'
                    where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            
            $this->bd->ejecutar($sql);
            
           
            
        }
        */
        
        $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
        
        echo $result;
        
        
    }
    //---------------------------------------
  
 
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
    
    $accion    = $_GET['accion'];
    
    $id        = $_GET['id'];
    
    $gestion->consultaId($accion,$id);
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_bien"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  