<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
    private $ATabla_custodio ;
    
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
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =     trim($_SESSION['email']);
        
        $this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'idcontrato',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'idprov',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'nro_contrato',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'forma_contratacion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo_contratacion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'detalle_contrato',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'monto_contrato',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'monto_asegurado',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_inicio',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_fin',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'iddepartamento',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idprov_responsable',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'dias_vigencia',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
        );
        
     
        
        $this->tabla 	  	  = 'garantias.contrato';
        
        $this->secuencia 	     = 'c.contrato_idcontrato_seq';
        
        
  
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado,$comprobante){
        //inicializamos la clase para conectarnos a la bd
        $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
        
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
        
        
        
        $datos = array(
            'resultado' => $resultado,
            'id' => $id,
            'accion' => $accion
        );
        
        
        return $datos;
        
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
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
        
        
        $datos =   $this->bd->JqueryArrayVisorDato('activo.view_bienes',$qquery );
        
        header('Content-Type: application/json');
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
        
    }
    
    
    
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
 
              $this->ATabla_custodio[1][valor] =  $id;
              
              $this->bd->_InsertSQL('activo.ac_bienes_custodio',$this->ATabla_custodio, 'activo.ac_bienes_custodio_id_bien_custodio_seq');
           
              
              $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
                
              header('Content-Type: application/json');
        
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        
        $valida = $this->BuscaCustodio($id);
       
        
        if ( $valida == 0 ) {
            
            $this->ATabla_custodio[1][valor] =  $id;
            
            $this->bd->_InsertSQL('activo.ac_bienes_custodio',$this->ATabla_custodio, 'activo.ac_bienes_custodio_id_bien_custodio_seq');
          
        }
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
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
            
            $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
            
            
        }
        
        
        
        echo $result;
        
        
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
    //-------------
    
    //--------------------------------------------
    //----------------------------
    function verifica_costos($id ){
        
        
        $sql = "update inv_movimiento_det
                    set ingreso = ".$this->bd->sqlvalue_inyeccion('0', true).",
                        monto_iva = ".$this->bd->sqlvalue_inyeccion('0', true).",
                        baseiva = ".$this->bd->sqlvalue_inyeccion('0', true)."
                        where id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
        
        $sql_det = 'SELECT costo, total ,id,codigo ,cantidad
                	FROM public.view_movimiento_det
                	where costo = 0';
        
        
        
        $stmt1 = $this->bd->ejecutar($sql_det);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            $cantidad                 = $x['cantidad'];
            $costo                    = $x['total'] / $cantidad;
            $id_movimientod           = $x['id'];
            
            
            $sql = "update inv_movimiento_det
                    set costo = ".$this->bd->sqlvalue_inyeccion($costo, true)."
                        where id_movimientod=".$this->bd->sqlvalue_inyeccion($id_movimientod, true);
            
            $this->bd->ejecutar($sql);
            
        }
        
        
    }
    //------------------------------
    function K_comprobante($tipo ){
        
        
        $sql = "SELECT count(comprobante) as secuencia
			      FROM inv_movimiento
			      where tipo =".$this->bd->sqlvalue_inyeccion($tipo ,true);
        
        $parametros 			= $this->bd->ejecutar($sql);
        
        $secuencia 				= $this->bd->obtener_array($parametros);
        
        
        $contador = $secuencia['secuencia'] + 1;
        
        $input = str_pad($contador, 8, "0", STR_PAD_LEFT);
        
        return $input ;
    }
    //------------------------------
    function BuscaCustodio($id){
        
      
        
      
        $x = $this->bd->query_array('activo.ac_bienes_custodio',
                                    'count(*) as nn', 
                                   'id_bien='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
         
        
        return $x['nn'];
        
         
    }
    //--------------------
    function DetalleMov($id){
        
        $sql = " UPDATE inv_movimiento_det
    			   SET 	id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true)."
     			 WHERE id_movimiento is null and sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion) , true);
        
        
        $this->bd->ejecutar($sql);
        
        
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
if (isset($_GET['accion']))	{
    
    $accion    = $_GET['accion'];
    
    $id        = $_GET['id'];
    
    $gestion->consultaId($accion,$id);
 
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["idcontrato"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  