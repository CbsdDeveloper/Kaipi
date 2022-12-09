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
    public function BusquedaGrilla($vprovincia,$canton ){
        
        // Soporte Tecnico
        
        $qquery = array(
            array( campo => 'idvencliente',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'provincia',   valor => $vprovincia,  filtro => 'S',   visor => 'N'),
            array( campo => 'canton',   valor => $canton,  filtro => 'S',   visor => 'N')
        );
        
        
        
        $resultado = $this->bd->JqueryCursorVisor('ven_cliente',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array (  $fetch['idvencliente'],
                $fetch['idprov'],
                $fetch['razon']	,
                 $fetch['correo']
                
            );
            
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


if (isset($_GET['vprovincia']))	{
    
    
    $vprovincia     = $_GET['vprovincia'];
    $canton         = $_GET['vcanton'];
    
    $gestion->BusquedaGrilla($vprovincia,$canton);
    
}





?>
 
  