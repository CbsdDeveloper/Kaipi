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
            array( campo => 'id_plantilla',   valor =>'-',  filtro => 'N',   visor => 'S'),
            array( campo => 'titulo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'publicar',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'ambito',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'variable',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => $PK_codigo,  filtro => 'S',   visor => 'N')
        );
 
     
        
        $resultado = $this->bd->JqueryCursorVisor('ven_plantilla',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array ($fetch['id_plantilla'],
                               $fetch['titulo'],
                                $fetch['publicar'],
                                $fetch['ambito'],
                               $fetch['variable'] 
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
if (isset($_GET['qtipo']))	{
    
    $PKcodigo  = $_GET['qtipo'];
    
    $gestion->BusquedaGrilla($PKcodigo );
    
}



?>
 
  