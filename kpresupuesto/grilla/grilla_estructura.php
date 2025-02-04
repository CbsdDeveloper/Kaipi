<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{

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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($festado,$ftipo,$fanio){
        
        
 
        
        $qquery = array( 
            array( campo => 'idpre_estructura',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'catalogo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'orden',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'esigef',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',     valor => $festado,    filtro => 'S', visor => 'S'),
            array( campo => 'tipo',  valor => $ftipo, filtro => 'S', visor => 'S'),
            array( campo => 'anio',valor => $fanio, filtro => 'S', visor => 'S') 
        );
        
 
        
        
        $resultado = $this->bd->JqueryCursorVisor('presupuesto.pre_estructura',$qquery );
        
           
        
        $output = array();
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array (
                $fetch['idpre_estructura'],
                $fetch['catalogo'],
                $fetch['tipo'],
                $fetch['orden'],
                trim($fetch['esigef']) ,  trim($fetch['estado']) 
            );
            
        }
        
        
        pg_free_result($resultado);
        
        echo json_encode($output);
        
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ consulta grilla de informacion
if (isset($_GET['festado']))	{
    
    $festado            = $_GET['festado'];
    $ftipo              = $_GET['ftipo'];
    $fanio              = $_GET['fanio'];
 
 
    $gestion->BusquedaGrilla($festado,$ftipo,$fanio);
    
     
    
}



?>
 
  