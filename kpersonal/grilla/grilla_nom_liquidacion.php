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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($fanio,  $festado ){
        
 
 
        
        $qquery = array(
            array( campo => 'id_liqcab',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'anio',   valor => $fanio,  filtro => 'S',   visor => 'S'),
            array( campo => 'estado',   valor =>  $festado,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'regimen',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'unidad_li',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'motivo',   valor => '-',  filtro => 'N',   visor => 'S') ,
            array( campo => 'tingreso',   valor => '-',  filtro => 'N',   visor => 'S') ,
            array( campo => 'tdescuento',   valor => '-',  filtro => 'N',   visor => 'S') ,
            array( campo => 'tpago',   valor => '-',  filtro => 'N',   visor => 'S') ,
            array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S') ,
        );
        
       
         
        $resultado = $this->bd->JqueryCursorVisor('view_liq_cab',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array ($fetch['id_liqcab'],
                               $fetch['fecha'],
                               $fetch['comprobante'],
                               $fetch['razon'],
                               $fetch['idprov'],
                                $fetch['regimen'],
                                $fetch['unidad_li'],
                                $fetch['motivo'] ,
                                $fetch['tpago'] ,
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
if (isset($_GET['fanio']))	{
    
    $fanio    = $_GET['fanio'];
     $festado  = $_GET['festado'];
  
    
    $gestion->BusquedaGrilla($fanio,   $festado );
    
}



?>