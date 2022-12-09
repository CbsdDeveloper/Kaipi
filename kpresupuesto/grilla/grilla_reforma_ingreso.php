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
    private $anio;
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
        
        $this->anio       =  $_SESSION['anio'];
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla(  ){
        
        
        $output = array();
        
        $qquery = array(
            array( campo => 'partida',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'actividad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'item',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fuente',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codificado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'aumento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'disminuye',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'coalesce(inicial,0) as inicial',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'coalesce(disponible,0) as disponible',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => 'I',  filtro => 'S',   visor => 'N'),
            array( campo => 'anio',   valor =>  $this->anio  ,  filtro => 'S',   visor => 'N')
            
        );
        
        $resultado = $this->bd->JqueryCursorVisor('presupuesto.pre_gestion',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $saldo =  $fetch['aumento'] -  $fetch['disminuye'];
            
            $output[] = array (
                $fetch['partida'],
                $fetch['detalle'],
                $fetch['item'] ,
                $fetch['fuente'] ,
                $fetch['inicial'],
                $fetch['codificado'],
                $saldo,
                $fetch['disponible']
                
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


 
    $gestion->BusquedaGrilla();
 




?>
 
  