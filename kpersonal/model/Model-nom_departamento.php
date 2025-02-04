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
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =     trim($_SESSION['email']);
        
        $this->hoy 	     =     date("Y-m-d");     
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'ruc_registro',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => trim(  $this->ruc ),   filtro => 'N',   key => 'N'),
            array( campo => 'id_departamento',   tipo => 'NUMBER',   id => '1',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'id_departamentos',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'atribuciones',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'competencias',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'ubicacion',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'nivel',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'univel',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'ambito',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'siglas',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'programa',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'secuencia',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'oficio',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'memo',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'notificacion',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'circular',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'informe',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'orden',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N')
         );
        
      
       
        $this->tabla 	  	  = 'nom_departamento';
        
        $this->secuencia 	     = 'id_nom_departamento';
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        if ($tipo == 0){
            
            echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                
                if ($accion == 'del')
                    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                    
        }
        
        if ($tipo == 1){
            
            echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
            
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
            array( campo => 'id_departamento',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'id_departamentos',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'atribuciones',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'competencias',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'ubicacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'nivel',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'univel',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'ambito',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'siglas',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'programa',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'secuencia',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'oficio',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'memo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'notificacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'circular',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'informe',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'orden',   valor => '-',  filtro => 'N',   visor => 'S'),
        );
        
      
        
        $this->bd->JqueryArrayVisor('nom_departamento',$qquery );
        
        $result =  $this->div_resultado($accion,$id,0);
        
        echo  $result;
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
        
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia  );
        
        $result = $this->div_resultado('editar',$id,1);
        
         
        
        echo $result;
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id  ){
        
        $nivel            =  $_POST["nivel"];
        $id_departamentos =  $_POST["id_departamentos"];
        $orden            =  trim($_POST["orden"]);


        $x = $this->bd->query_array('nom_departamento',   
        '*',                      
        'id_departamento='.$this->bd->sqlvalue_inyeccion($id_departamentos,true)  
        );

  
        if (  $nivel  == '1'){
            
            $orden =    trim($x['orden']);
            
        }else  {
            if ( $orden == '-'){
                $punto =    substr(trim($x['orden']),0,1);
                $ordenp =   $punto.trim($x['orden']);
                 $this->ATabla[19][edit]  =  'S';
                $this->ATabla[19][valor] =  $ordenp;
            }else  {
               
                
             }
        }
         
        
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
        $result =$this->div_resultado('editar',$id,1);
        
        
        
        echo $result  ;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
 
        $x = $this->bd->query_array('nom_personal','count(*) as registros', 'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true));
         
        $y = $this->bd->query_array('inv_movimiento','count(*) as registros', 'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true));
        
        $z = $this->bd->query_array('presupuesto.pre_tramite','count(*) as registros', 'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true));
        
        
        $registros = $x['registros']  +  $y['registros'] + $z['registros'];
         
         if ($registros == 0){
         
                 $sql = 'delete from nom_departamento  where id_departamento='.$this->bd->sqlvalue_inyeccion($id, true);
                 $this->bd->ejecutar($sql);
         
         
         }
         
         $result = $this->div_limpiar();
         
         echo $result;
      
        
    }
    //---------------------------------------
    
    //------------------------------
    
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
    
    $id =     @$_POST["id_departamento"];
    
    $gestion->xcrud(trim($action),$id);
    
}



?>
 
  