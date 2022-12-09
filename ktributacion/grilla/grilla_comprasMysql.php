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
        $this->hoy 	     =  $this->bd->hoy();
         
        $this->bd->conectar_Mysql();
        $this->bd->DBtipo('mysql');
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($anio,$mes){
        
        // Soporte Tecnico
        
        $this->bd->DBtipo('mysql');
        
        $lon = strlen($mes);
        
        if ($lon == 1){
            $mes = '0'.$mes ;
        }
        
        
        $qquery = array(
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'numtrami',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'egreso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'nompro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
            array( campo => 'mes',valor => $mes,filtro => 'S', visor => 'N'),
            array( campo => 'COALESCE(k1,0)',valor => '0',filtro => 'S', visor => 'N')
        );
        
         
        
         $resultado = $this->bd->JqueryCursorVisor('anetran_emapa.view_ane',$qquery );
        
 
        
        while ($fetch=$this->bd->obtener_fila_mysql($resultado)){
            
            $total =  $fetch['baseimpgrav'] + $fetch['montoIva'] + $fetch['baseimponible'] ;
            
            $output[] = array (
                $fetch['fecha'],
                $fetch['numtrami'],
                $fetch['egreso'],
                $fetch['nompro'],
                $total
                
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


 
if (isset($_GET['anio']))	{
    
    $anio  = $_GET['anio'];
    $mes   = $_GET['mes'];
    
    $gestion->BusquedaGrilla($anio,$mes );
    
}

 

?>
 
  