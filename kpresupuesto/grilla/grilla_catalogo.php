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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($festado,$ftipo,$fcategoria,$fsubcategoria,$fgrupo){
        
        
        if ( $fgrupo == '-'){
            $filtro = 'N';
            $valor = '-';
        }else{
            $filtro = 'S';
            $valor =  'LIKE.'.$fgrupo.'%';
        }
        
        $qquery = array( 
            array( campo => 'idpre_catologo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'codigo',valor => $valor,filtro => $filtro, visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor =>$ftipo,  filtro => 'S', visor => 'S'),
            array( campo => 'nivel',    valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'transaccion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',     valor => $festado,    filtro => 'S', visor => 'S'),
            array( campo => 'categoria',  valor => $fcategoria, filtro => 'S', visor => 'S'),
            array( campo => 'subcategoria',valor => $fsubcategoria, filtro => 'S', visor => 'S') 
        );
        
        
        $resultado = $this->bd->JqueryCursorVisor('presupuesto.pre_catalogo',$qquery );
        
           
        
        $output = array();
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array (
                $fetch['idpre_catologo'],
                $fetch['codigo'],
                $fetch['detalle'],
                $fetch['nivel'],
                trim($fetch['transaccion']) 
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
    $fcategoria         = $_GET['fcategoria'];
    $fsubcategoria      = $_GET['fsubcategoria'];
    
    $fgrupo      = $_GET['fgrupo'];
    
    
    
    
    $gestion->BusquedaGrilla($festado,$ftipo,$fcategoria,$fsubcategoria,$fgrupo);
    
     
    
}



?>
 
  