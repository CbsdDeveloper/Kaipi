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
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($tipo){
        
        // Soporte Tecnico
        
        
        $output = array();
        
        $qquery = array(
            array( campo => 'idcatalogo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor =>$tipo,  filtro => 'S',   visor => 'S'),
            array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codigo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'publica',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('par_catalogo',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array (  $fetch['idcatalogo'],$fetch['tipo'],$fetch['nombre'],$fetch['codigo'],$fetch['publica'] 		);
            
        }
        
        echo json_encode($output);
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

$tipo= $_GET['tipo_catalogo'];


$gestion->BusquedaGrilla($tipo);





?>
 
  