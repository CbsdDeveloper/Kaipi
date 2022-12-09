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
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->tabla 	  	  = 'ven_registro';
        
        $this->secuencia 	   = '-';
        
         
        $this->ATabla = array(  
            array( campo => 'idven_registro',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
             array( campo => 'web',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'telefono',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'email',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'smtp',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'puerto',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'acceso',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'mapagoogle',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'facebook',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'client_id',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'client',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'twiter',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'directorio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'email1',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'smtp1',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'puerto1',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'acceso1',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N')
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
            array( campo => 'idven_registro',   valor => $id,  filtro => 'S',   visor => 'S'),
             array( campo => 'web',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'telefono',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'email',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'smtp',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'puerto',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'acceso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'email1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'smtp1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'puerto1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'acceso1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'mapagoogle',valor => '-',filtro => 'N', visor => 'S'),
           array( campo => 'facebook',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'client_id',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'client',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'twiter',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'directorio',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
        
        $datos = $this->bd->JqueryArrayVisorDato('ven_registro',$qquery  );
        
        echo '<script type="text/javascript">';
        
        echo  '$("#web").val('."'".$datos['web']."'".');';
        
        echo  '$("#directorio").val('."'".$datos['directorio']."'".');';
        
        
        echo  '$("#telefono").val('."'".$datos['telefono']."'".');';
        
        echo  '$("#email").val('."'".$datos['email']."'".');';
        
        echo  '$("#smtp").val('."'".$datos['smtp']."'".');';
        
       echo  '$("#puerto").val('."'".$datos['puerto']."'".');';
        
       echo  '$("#acceso").val('."'".base64_decode(trim($datos['acceso']))."'".');';
      
        
        echo  '$("#email1").val('."'".$datos['email1']."'".');';
        
        echo  '$("#smtp1").val('."'".$datos['smtp1']."'".');';
        
        echo  '$("#puerto1").val('."'".$datos['puerto1']."'".');';
        
        echo  '$("#acceso1").val('."'".base64_decode(trim($datos['acceso1']))."'".');';
      
        
         echo  '$("#mapagoogle").html('."'".$datos['mapagoogle']."'".');';
        
        echo  '$("#twiter").val('."'".$datos['twiter']."'".');';
        
        echo  '$("#facebook").html('."'".$datos['facebook']."'".')';
        
         echo '</script>';
        
   
        
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
        
        
       /*   //$provincia = @$_POST["provincia"];
          //$this->ATabla[10][valor] =  strtoupper(trim($canton))	 ;
        
         
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        
        //------------ seleccion de periodo
        */
        $result = $this->div_resultado('editar',$id,1);
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
      
          
        $acceso =     @$_POST["acceso"];
        $acceso1 =     @$_POST["acceso1"];
      
        $this->ATabla[6][valor]  = base64_encode(trim($acceso)) ;
        $this->ATabla[16][valor] = base64_encode(trim($acceso1)) ;
        
 
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
    
    $id 			= $_POST["idven_registro"];
    
    $gestion->xcrud(trim($action),$id );
    
}



?>
 
  