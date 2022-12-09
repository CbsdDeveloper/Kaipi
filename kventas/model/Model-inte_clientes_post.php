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
        
        $this->tabla 	  	  = 'par_ciu';
        
        $this->secuencia 	     = '-';
        
        $this->ATabla = array(  
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
             array( campo => 'razon',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'direccion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'telefono',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'correo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'movil',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'contacto',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
           );
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
    function consultaId($accion,$id ){
        
        
        
        $qquery = array(
            array( campo => 'idprov',   valor => $id,  filtro => 'S',   visor => 'N'),
            array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'contacto',   valor => '-',  filtro => 'N',   visor => 'S')
         );
        
      
        
        $datos = $this->bd->JqueryArrayVisor('par_ciu',$qquery );
        
        $guardarCliente=  $this->div_resultado($accion,$id,0);
        
        echo  $guardarCliente;
    } 
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
    
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id );
            
        }
     
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $guardarCliente = $this->div_resultado('editar',$id,1);
         
        echo $guardarCliente;
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
    
    $id        = $_GET['idcliente'];
    
    $gestion->consultaId($accion,$id);
}

//------ grud de datos insercion
if (isset($_POST["actionCiu"]))	{
    
    $action 	= $_POST["actionCiu"];
    
    $id 		= $_POST["idprov"];
    
    $gestion->xcrud(trim($action),$id );
    
}

 


?>
 
  