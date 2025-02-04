<?php
session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        
        echo '<script type="text/javascript">';
        
        echo  '$("#action").val("'.$accion.'");';
        
        echo  '$("#idproducto").val("'.$id.'");';
        
        echo '</script>';
        
        
        
        if ($tipo == 0){
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                if ($accion == 'del')
                    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                    
        }
        
        if ($tipo == 1){
            
            
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
            
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
            array( campo => 'idproducto',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idbodega',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idcategoria',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idmarca',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'referencia',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'activo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'facturacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tributo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cuenta_ing',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cuenta_inv',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'partida',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'url',   valor => '-',  filtro => 'N',   visor => 'S') ,
            array( campo => 'tipourl',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        
        $datos = $this->bd->JqueryArrayVisor('web_producto',$qquery );
        
        
        $imagen = $this->pathFile($datos['tipourl']).$datos['url'];
        
        echo '<script type="text/javascript">'.
            'imagenfoto("'.$imagen.'");
						  goToPrecio(); '.
						  'VisorPartida( '."'".trim($datos['cuenta_ing'])."',"."'".trim($datos['partida'])."'".' );'.
						  '</script>';
        
        
        
        $result =  $this->div_resultado($accion,$id,0);
        
        echo  $result;
    }
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar( );
            
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
    function agregar(   ){
        
        $cuenta1 = @$_POST["cuenta_ing"];
        $cuenta2 = @$_POST["cuenta_inv"];
        $partida = @$_POST["partida"];
        
        
        
        $InsertQuery = array(
            array( campo => 'producto',   valor => @$_POST["producto"]),
            array( campo => 'referencia',   valor => @$_POST["referencia"]),
            array( campo => 'tipo',   valor => 'S'),
            array( campo => 'idcategoria',   valor => @$_POST["idcategoria"]),
            array( campo => 'estado',   valor => @$_POST["estado"]),
            array( campo => 'activo',   valor => @$_POST["activo"]),
            array( campo => 'url',   valor => @$_POST["url"]),
            array( campo => 'idmarca',  0),
            array( campo => 'unidad',   valor => 'Unidad'),
            array( campo => 'facturacion',   valor => 'S'),
            array( campo => 'idbodega',   valor =>0 ),
            array( campo => 'cuenta_ing',   valor => trim($cuenta1)),
            array( campo => 'cuenta_inv',   valor => trim($cuenta2)),
            array( campo => 'partida',   valor => trim($partida)),
            array( campo => 'tributo',   valor => 'I'),
            array( campo => 'registro',   valor => $this->ruc),
            array( campo => 'costo',   valor => @$_POST["costo"]),
            array( campo => 'codigob',   valor => '-'),
            array( campo => 'tipourl',       valor => '1',  filtro => 'N')
        );
        
        
        
        $idD = $this->bd->JqueryInsertSQL('web_producto',$InsertQuery);
        
        //------------ seleccion de periodo
        
        $result = $this->div_resultado('editar',$idD,1);
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        
        $cuenta1 = @$_POST["cuenta_ing"];
        $cuenta2 = @$_POST["cuenta_inv"];
        $partida = @$_POST["partida"];
        
        
        
        $UpdateQuery = array(
            array( campo => 'idproducto',   valor => $id ,  filtro => 'S'),
            array( campo => 'referencia',   valor => @$_POST["referencia"],  filtro => 'N'),
            array( campo => 'producto',      valor => @$_POST["producto"],    filtro => 'N'),
            array( campo => 'activo',      valor => @$_POST["activo"],    filtro => 'N'),
            array( campo => 'idcategoria', valor => @$_POST["idcategoria"],    filtro => 'N'),
            array( campo => 'estado',      valor => @$_POST["estado"],    filtro => 'N'),
            array( campo => 'tributo',      valor => @$_POST["tributo"],    filtro => 'N'),
            array( campo => 'url',       valor => @$_POST["url"],  filtro => 'N') ,
            array( campo => 'cuenta_ing',       valor => trim($cuenta1),  filtro => 'N') ,
            array( campo => 'cuenta_inv',       valor => trim($cuenta2),  filtro => 'N') ,
            array( campo => 'partida',       valor => trim($partida),  filtro => 'N') ,
            array( campo => 'costo',       valor => @$_POST["costo"],  filtro => 'N')  ,
            array( campo => 'tipourl',       valor => '1',  filtro => 'N')
        );
        
        
        
        $this->bd->JqueryUpdateSQL('web_producto',$UpdateQuery);
        
        $result = $this->div_resultado('editar',$id,1);
        
        
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
        $sql = "SELECT count(*) as nro_registros
	       FROM inv_movimiento_det
           where idproducto = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos_valida = $this->bd->obtener_array( $resultado);
        
        if ($datos_valida['nro_registros'] == 0){
            
            $this->bd->JqueryDeleteSQL('web_producto',
                'idproducto='.$this->bd->sqlvalue_inyeccion($id, true));
            
            
        }
        
        
        $result = $this->div_limpiar();
        
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function pathFile($id ){
        
        
        $ACarpeta = $this->bd->query_array('wk_config',
            'carpeta',
            'tipo='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $carpeta = trim($ACarpeta['carpeta']);
        
        return $carpeta;
        
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
    
    $id =     @$_POST["idproducto"];
    
    $gestion->xcrud(trim($action),$id );
    
}



?>
 
  