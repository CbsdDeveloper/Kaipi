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
        
        $this->hoy 	     =     date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'idren_local',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
             array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'servicio',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'contrato',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>  $this->sesion, key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_inicio',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_fin',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'factura',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'finalizado',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'periodo',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'ubicacion',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'numero',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N') ,
            array( campo => 'arriendo',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
 
        $this->tabla 	  	  = 'rentas.ren_arre_local';
        
        $this->secuencia 	     = 'rentas.ren_arre_local_idren_local_seq';
        
      
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
            array( campo => 'idren_local',   valor => $id,  filtro => 'S',   visor => 'S'),
             array( campo => 'id_par_ciu',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'servicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'contrato',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_fin',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'finalizado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'periodo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tiempo_ingreso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'dias_trascurrido',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio_trascurrido',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ubicacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'numero',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'correo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'direccion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'telefono',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'movil',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'arriendo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'luz',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'agua',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
       
        
        $datos =   $this->bd->JqueryArrayVisorDato('rentas.view_ren_arren_local',$qquery );
        
        $this->_Verifica_suma_facturas_Total( $datos['idprov'] );
        
        header('Content-Type: application/json');
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
        
    }
//-------------------
    function _Verifica_suma_facturas_Total( $idprov  ){
        
        
        $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where idprov = ".$this->bd->sqlvalue_inyeccion(trim($idprov),true)."  and    estado = 'digitado'";
        
        
        
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
          
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
        header('Content-Type: application/json');
        
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        
  
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
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
    
    $id =     @$_POST["idren_local"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  