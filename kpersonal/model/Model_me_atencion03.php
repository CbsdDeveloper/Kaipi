<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class Model_me_atencion03{
    
    
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
    function Model_me_atencion03( ){
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  date('Y-m-d');
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->tabla 	  	  = 'medico.ate_medica_familia';
          
        $this->secuencia 	     = 'medico.ate_medica_familia_id_atencion_fami_seq';
        
 
        $this->ATabla = array(
            array( campo => 'id_atencion_fami',   tipo => 'NUMBER',     id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_atencion',        tipo => 'NUMBER',     id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fa_parentesto',      tipo => 'VARCHAR2',   id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fa_detalle',         tipo => 'VARCHAR2',   id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',             tipo => 'VARCHAR2',   id => '4',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
            array( campo => 'fcreacion',          tipo => 'DATE',       id => '5',add => 'S', edit => 'S', valor => $this->hoy , key => 'N')
        );
        
 
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        
        
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
            array( campo => 'id_atencion_fami',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fa_parentesto',      valor => '-', filtro => 'N', visor => 'S'),
            array( campo => 'fa_detalle',         valor => '-', filtro => 'N', visor => 'S'),
        );
 
        
        $this->bd->JqueryArrayVisor('medico.ate_medica_familia',$qquery );
        
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
        
        
        $id     = $_POST["id_atencion_02"];
        
        
        $this->ATabla[1][valor] =  $id ;
        
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia  );
        
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
        
        $this->bd->JqueryDeleteSQL($this->tabla,'id_atencion_fami='.$this->bd->sqlvalue_inyeccion($id, true));
        
        $result ='<b>DATO ELIMINADO CORRECTAMENTE....</b>';
        
        echo $result;
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_me_atencion03;

      //------ poner informacion en los campos del sistema
            
            if (isset($_GET['accion']))	{
                
                $accion    = $_GET['accion'];
                
                $id        = $_GET['id'];
                
                $gestion->consultaId($accion,$id);
            }
            
            
            //------ grud de datos insercion
            
            if (isset($_POST["action_02"]))	{
                
                $action = $_POST["action_02"];
                
                $id     = $_POST["id_atencion_fami"];
                
                $gestion->xcrud(trim($action),$id );
                
}

 

?>