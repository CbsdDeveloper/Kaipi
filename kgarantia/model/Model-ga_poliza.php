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
            array( campo => 'idpoliza',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'idcontrato',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'idprov_aseguradora',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'nro_poliza',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo_poliza',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'documento',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'monto',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fechainicio',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fechafin',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'vigencia',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'contabilizado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'sucursal',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'anticipo',tipo => 'NUMBER',id => '13',add => 'S', edit => 'N', valor => '-', key => 'N')
        );
        
         
  
        $this->tabla 	  	  = 'garantias.poliza';
        
        $this->secuencia 	     = 'garantias.poliza_idpoliza_seq';
        
     
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
            array( campo => 'idcontrato',   valor => $id,  filtro => 'S',   visor => 'S'),
             array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'nro_contrato',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'forma_contratacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_contratacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle_contrato',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'monto_contrato',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'monto_asegurado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_fin',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'iddepartamento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'dias_vigencia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion_responsable',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sucursal',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anticipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
       
        
        $this->bd->JqueryArrayVisor('garantias.contratos_garantia',$qquery );
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
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
          
        
        
        $fecha      =   $_POST["fechafin"];
        $idcontrato =   $_POST["idcontrato"];
        
 
            
            $sql = 'update garantias.contrato 
                       set fecha_fin = '.$this->bd->sqlvalue_inyeccion($fecha, true).',
                           fecha_ampliacion = '.$this->bd->sqlvalue_inyeccion($fecha, true).'
                    where idcontrato='.$this->bd->sqlvalue_inyeccion($idcontrato, true);
            
            
            $this->bd->ejecutar($sql);
            
        
        $datos = $this->div_resultado('editar',$id, 1,'digitado','0') ;
        
         
        
        echo $datos;
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        
  
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
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
    
    $id =     @$_POST["idpoliza"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  