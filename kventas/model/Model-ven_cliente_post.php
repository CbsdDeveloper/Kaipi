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
        $this->hoy 	     =    date("Y-m-d"); 
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'idven_gestion',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'razon',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '1', key => 'N'),
            array( campo => 'medio',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => 'email', key => 'N'),
            array( campo => 'canal',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => 'Base Datos', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
            array( campo => 'producto',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => 'Cotizacion', key => 'N'),
            array( campo => 'porcentaje',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '10', key => 'N'),
            array( campo => 'factura',tipo => 'VARCHAR2',id => '11',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'vendedor',tipo => 'VARCHAR2',id => '12',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor =>$this->ruc , key => 'N'),
            array( campo => 'modulo',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => 'CO', key => 'N') 
        );
 
        
        $this->tabla 	  	  = 'ven_cliente_gestion';
        
        $this->secuencia 	     = 'ven_cliente_gestion_idven_gestion_seq';
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
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function agregar($id  ){
        
        $qquery = array(
            array( campo => 'idprov',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        $datos = $this->bd->JqueryArray('par_ciu',$qquery );
        
        echo $datos['idprov'];
        
        $this->ATabla[1][valor] =  $datos['idprov']	 ;
        $this->ATabla[2][valor] =  $datos['razon']	 ;
        
        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,  $this->secuencia );
        
        return $id;
         
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
    
    $ref = $gestion->agregar($id);
    
    $data = 'Transaccion generada '. $ref;
    
    echo $data;
}

 
 


?>
 
  