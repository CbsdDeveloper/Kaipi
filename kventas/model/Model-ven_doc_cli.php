<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
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
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");     
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
 
        
        echo '<script type="text/javascript">BusquedaProd(oTable,'.$id.' );</script>';
        
        if ($tipo == 0){
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b>';
                if ($accion == 'del')
                    $resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b>';
                    
        }
        
        if ($tipo == 1){
             
            $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b>';
            
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
        
        if (strlen(trim($id)) == 9){
            $id = '0'.$id;
        }
        if (strlen(trim($id)) == 12){
            $id = '0'.$id;
        }
        
        $qquery = array(
            array( campo => 'idprov',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'contacto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'ctelefono',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'ccorreo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tpidprov',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'naturaleza',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cmovil',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'nacimiento',   valor => '-',  filtro => 'N',   visor => 'S')
            
        );
        
        $datos = $this->bd->JqueryArrayVisor('par_ciu',$qquery );
        
        $result =  $this->div_resultado($accion,$id,0);
        
        echo  $result;
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
 
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
   
 
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        $guardarProducto = '';
        
            
            $sql = 'delete from ven_cliente_doc  where idven_doc='.$this->bd->sqlvalue_inyeccion($id, true);
           
            $this->bd->ejecutar($sql);
        
        
            echo $guardarProducto;
        
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

if (isset($_GET["accion"]))	{
    
    $action = $_GET["accion"];
    
    $id     = $_GET["id"];
    
    $gestion->xcrud(trim($action),$id );
    
}


?>
 
  