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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($PK_codigo){
        
        // Soporte Tecnico
        
        $qquery = array(
            array( campo => 'idvengrupo',   valor => $PK_codigo,  filtro => 'S',   visor => 'S'),
            array( campo => 'completo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'email',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idusuario',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
     
        
        $resultado = $this->bd->JqueryCursorVisor('view_ventas_grupo',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array ($fetch['idvengrupo'],
                               $fetch['completo'],
                               $fetch['email'],
                               $fetch['idusuario'] 
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



//------ consulta grilla de informacion
if (isset($_GET['qzona']))	{
    
    $PKcodigo  = $_GET['qzona'];
    
    $gestion->BusquedaGrilla($PKcodigo );
    
}



?>
 
  