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
    private $ATabla;
    private $tabla ;
    private $secuencia;
    
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
        
        $this->tabla 	  	  = 'ven_campana';
        
        $this->secuencia 	   = 'ven_campana_id_campana_seq';
 
         
        $this->ATabla = array(  
            array( campo => 'id_campana',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
             array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_cierre',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'medio',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'publica',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idresponsable',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idvengrupo',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'titulo',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
    } 
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
         
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
            array( campo => 'id_campana',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_cierre',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'medio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'publica',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idresponsable',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idvengrupo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'titulo',valor => '-',filtro => 'N', visor => 'S'),
        );
        
        
        $datos = $this->bd->JqueryArrayVisor('ven_campana',$qquery );
        
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
        
        
          //$provincia = @$_POST["provincia"];
          //$this->ATabla[10][valor] =  strtoupper(trim($canton))	 ;
        
         
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        
        //------------ seleccion de periodo
        
        $result = $this->div_resultado('editar',$id,1);
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
      
         
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $result = $this->div_resultado('editar',$id,1);
        
        
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        $result ='No se puede eliminar el registro';
        
        echo $result;
        
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
    
    $action 	= $_POST["action"];
    
    $id 			= $_POST["id_campana"];
    
    $gestion->xcrud(trim($action),$id );
    
}



?>
 
  