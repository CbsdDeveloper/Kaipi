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
    private $ATabla_parametros;
    private $tabla ;
    private $secuencia;
    
    private $estado_periodo;
    private $anio;
    
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
        
        $this->anio       =  $_SESSION['anio'];
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
         
        $this->ATabla_parametros = array(
            array( campo => 'id_spi_para',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'fecha_pago',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'mes_pago',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor =>'-', key => 'N'),
            array( campo => 'referencia_pago',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N') 
        );
        
        
        
        
        
        
        $this->ATabla = array(
            array( campo => 'id_spi',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_envio',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => 'digitado', key => 'N'),
            array( campo => 'referencia',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '7',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor =>$this->anio, key => 'N'),
            array( campo => 'cuenta',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'beneficiario',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N')
        );
        
        
        
        
        $this->tabla 	  	     = 'tesoreria.spi_mov';
        
        $this->secuencia 	     = 'tesoreria.spi_mov_id_spi_seq';
        
 
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado,$comprobante){
        //inicializamos la clase para conectarnos a la bd
        
        //$datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
        
        
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
            $resultado ='<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>TRANSACCION AUTORIZADA CON EXITO ['.$id.']</b>';
        }
        
        if ($tipo == -5){
            $resultado = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>TRANSACCION ELIMINADA CON EXITO</b>';
        }
        
        
        $datos = array(
            'resultado' => $resultado,
            'id' => $id,
            'accion' => $accion,
            'estado' => $estado,
            'comprobante' => $comprobante
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
            array( campo => 'id_spi',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_envio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'codigo_control',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'validacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'referencia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'beneficiario',valor => '-',filtro => 'N', visor => 'S')
        );
       
        
        
        
        $datos =   $this->bd->JqueryArrayVisorDato('tesoreria.spi_mov',$qquery );
        
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
        
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
        header('Content-Type: application/json');
        
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        
        $afecha    =  $_POST["fecha"];
        $fecha     = explode('-', $afecha);
        $idperiodo = $fecha[1].'/'.$fecha[0];
        
        $this->ATabla_parametros[1][valor] =  $afecha;
        $this->ATabla_parametros[2][valor] =  $idperiodo;
        $this->ATabla_parametros[3][valor] =  $_POST["referencia"];
        
        
        $this->bd->_UpdateSQL('tesoreria.te_spi_para',$this->ATabla_parametros,1);
        
        ///--------------------------------------------------------------
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
         
 
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        $x = $this->bd->query_array('tesoreria.spi_mov_det',   // TABLA
            'COUNT(*) AS nn',                                  // CAMPOS
            'id_spi='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        $estado =  $_POST["estado"];
        
        if (trim($estado) == 'digitado') {
            
            if ( $x["nn"] > 0 ) {
                
            }else{
                
                $sql = 'delete from tesoreria.spi_mov  
                         where id_spi='.$this->bd->sqlvalue_inyeccion($id, true);
                
                $this->bd->ejecutar($sql);
                
                 
                 
            }
 
        }else {
            
            $sql = 'update tesoreria.spi_mov
                       set estado = '.$this->bd->sqlvalue_inyeccion('anulado', true).'
                    where id_spi='.$this->bd->sqlvalue_inyeccion($id, true);
            
            
            $this->bd->ejecutar($sql);
            
             
            
        }
        
        $datos = $this->div_resultado('del',$id,-5,'eliminado','0') ;
        
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
        
    }
    //---------------------------------------
 
    function aprobacion($id,$estado){
        
        
   
        
        if ( $estado == 'digitado'){
            
           
            $sql = " UPDATE tesoreria.spi_mov
						   SET 	estado=".$this->bd->sqlvalue_inyeccion('aprobado', true).",
								fecha_envio= ".$this->bd->sqlvalue_inyeccion( $this->hoy, true)."
						 WHERE id_spi=".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
        }

        $datos = $this->div_resultado('aprobado',$id, 2,'aprobado','0') ;
        
 
        
        header('Content-Type: application/json');
        
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
        
      
        
        
        
    }
    //--------------------------------------------
 
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
  
    if ( $accion == 'aprobado'){
        $gestion->aprobacion($id,$_GET['estado']);
    }else{
        $gestion->consultaId($accion,$id);
    }
   
        
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action = @$_POST["action"];
    
    $id =     @$_POST["id_spi"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  