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
    public function BusquedaGrilla($fanio, $fmes, $festado,$fmotivo,$ffin){
        
 
        $filtro  =  'S';
        $filtro3 =  'S';
        
       
       $filtro= 'N';
       
        $filtro1= 'S';
        if ($festado == '-'){
            $filtro1= 'N';
        }
        
 
       

        if ( $fmes == '-'){
            $filtro3= 'N';
        }
        
        $qquery = array(
            array( campo => 'id_delega',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'anio',   valor => $fanio,  filtro => 'S',   visor => 'S'),
            array( campo => 'mes',   valor =>$fmes,  filtro => $filtro3,   visor => 'S'),
            array( campo => 'estado',   valor => $festado,  filtro => $filtro1,   visor => 'S'),
            array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'motivo',   valor =>$fmotivo,  filtro =>$filtro,   visor => 'S'),
            array( campo => 'fecha_rige',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'novedad',   valor => '-',  filtro => 'N',   visor => 'S') ,
            array( campo => 'ffinalizacion',   valor => '-',  filtro => 'N',   visor => 'S') ,
            array( campo => 'finalizado',   valor => $ffin,  filtro =>'N',   visor => 'S') 
        );
        
        
    
         
        $resultado = $this->bd->JqueryCursorVisor('view_nom_delegacion',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array ($fetch['id_delega'],
                               $fetch['fecha'],
                               $fetch['razon'],
                               $fetch['tipo'],
                                $fetch['motivo'],
                                $fetch['fecha_rige'],
                                $fetch['novedad'] 
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
    $fmes     = $_GET['fmes'];
    $festado  = $_GET['festado'];
    $fmotivo  = $_GET['fmotivo'];
   
    $ffin  = $_GET['ffin'];
    
    
    
    
    $gestion->BusquedaGrilla($fanio, $fmes, $festado,$fmotivo,$ffin);
    
}



?>
 
  