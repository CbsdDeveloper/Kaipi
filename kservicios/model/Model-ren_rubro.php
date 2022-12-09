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
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date('Y-m-d');
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
      
        echo '<script type="text/javascript">';
        
        echo  '$("#action").val("'.$accion.'");';
        
        echo  '$("#id_rubro").val("'.$id.'");';
        
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
            array( campo => 'id_rubro',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'acceso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'resolucion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'reporte',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'modulo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'periodo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sigla',valor => '-',filtro => 'N', visor => 'S')
         );
        
      
        
          $this->bd->JqueryArrayVisor('rentas.ren_rubros',$qquery );
        
 
        
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
 
   
        
        $InsertQuery = array(
            array( campo => 'estado',   valor => @$_POST["estado"]),
            array( campo => 'detalle',   valor => @$_POST["detalle"]),
            array( campo => 'resolucion',   valor =>  @$_POST["resolucion"]),
            array( campo => 'sigla',   valor =>  @$_POST["sigla"]),
            array( campo => 'reporte',   valor =>  @$_POST["reporte"]),
            array( campo => 'modulo',   valor => @$_POST["modulo"]),
            array( campo => 'id_departamento',   valor => @$_POST["id_departamento"]),
            array( campo => 'acceso',   valor => @$_POST["acceso"]),
            array( campo => 'sesion',   valor => $this->sesion),
            array( campo => 'msesion',   valor => $this->sesion),
            array( campo => 'creacion',   valor => $this->hoy 	),
            array( campo => 'modificacion',   valor => $this->hoy 	),
            array( campo => 'periodo',   valor =>  @$_POST["periodo"]),
        );
        
        
     
 
        $this->bd->pideSq(0);
        
        $idD = $this->bd->JqueryInsertSQL('rentas.ren_rubros',$InsertQuery,'rentas.ren_rubros_id_rubro_seq');
        
        //------------ seleccion de periodo
        
        $result = $this->div_resultado('editar',$idD,1);
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
      
        
        
        $UpdateQuery = array(
            array( campo => 'id_rubro',  valor => $id ,  filtro => 'S'),
            array( campo => 'detalle',  valor => @$_POST["detalle"],  filtro => 'N'),
            array( campo => 'resolucion',    valor => @$_POST["resolucion"],    filtro => 'N'),
            array( campo => 'sigla',    valor => @$_POST["sigla"],    filtro => 'N'),
            array( campo => 'modulo',      valor => @$_POST["modulo"],    filtro => 'N'),
            array( campo => 'reporte',      valor => @$_POST["reporte"],    filtro => 'N'),
            array( campo => 'acceso',      valor => @$_POST["acceso"],    filtro => 'N'),
            array( campo => 'id_departamento',      valor => @$_POST["id_departamento"],    filtro => 'N'),
            array( campo => 'estado',      valor => @$_POST["estado"],    filtro => 'N'),
            array( campo => 'msesion', valor => $this->sesion,    filtro => 'N'),
            array( campo => 'modificacion', valor => $this->hoy ,    filtro => 'N'),
            array( campo => 'periodo',      valor => $_POST["periodo"],    filtro => 'N'),
          );
 
       
        
        $this->bd->JqueryUpdateSQL('rentas.ren_rubros',$UpdateQuery);
        
        $result = $this->div_resultado('editar',$id,1);
        
        
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
        $sql = "SELECT count(*) as nro_registros
	       FROM rentas.ren_rubros_matriz
           where id_rubro = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos_valida = $this->bd->obtener_array( $resultado);
        
        if ($datos_valida['nro_registros'] == 0){
            
            $this->bd->JqueryDeleteSQL('rentas.ren_rubros',
                'id_rubro='.$this->bd->sqlvalue_inyeccion($id, true));
            
            
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
    
    $id =     @$_POST["id_rubro"];
    
    $gestion->xcrud(trim($action),$id );
    
}



?>
 
  