<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    private $saldos;
    
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
        
        $this->ATabla = array(
            array( campo => 'id_anulados',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'establecimiento',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'puntoemision',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'secuencialinicio',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'secuencialfin',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $this->ruc , key => 'N'),
            array( campo => 'mes',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'anio',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
        $this->tabla 	  	  = 'co_anulados';
        
        $this->secuencia 	     = '-';
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado){
         
        return  $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
    }
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = 'REGISTRO ELIMINADO ';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        $qqueryCompras = array(
            array( campo => 'id_anulados',valor => $id,filtro => 'S', visor => 'S'),
             array( campo => 'tipocomprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'establecimiento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'puntoemision',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencialinicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencialfin',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'mes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autorizacion',valor => '-',filtro => 'N', visor => 'S') 
        );
 
        
         $this->bd->JqueryArrayVisor('view_anexos_anulado',$qqueryCompras );
        
        $result =  $this->div_resultado($accion,$id,0,'');
        
        echo  $result;
    }
     //--------------------------------------------------------------------------------
     function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id);
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
     //--------------------------------------------------------------------------------
     
    //----------------------------------------------------
    function agregar( ){
        
 
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        
 
        
        $result = $this->div_resultado('editar',$id,1,'S');
        
        echo $result;
        
										        
    }
    //--------------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------------
    function edicion($id){
        
 
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
   
        
        $result = $this->div_resultado('editar',$id,1,'N');
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
   
            $sql = 'delete from co_anulados  where id_anulados='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
          
            $result = $this->div_limpiar();
 
           
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
    
    $accion    		    = $_GET['accion'];
    $id            		= $_GET['id'];
    
    $gestion->consultaId($accion,$id);
    
    
    
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
    
    $action 		=     @$_POST["action"];
    
    $id 			=     @$_POST["id_anulados"];
    
    
    $gestion->xcrud(trim($action) ,  $id  );
    
    
}



?>
 
  