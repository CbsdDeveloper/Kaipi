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
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($idvengestion ){
        
        
        $output = array();
        
        $qquery = array(
            array( campo => 'partida',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fuente',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'certificado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'compromiso',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'devengado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_tramite_det',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_tramite',   valor => $idvengestion,  filtro => 'S',   visor => 'N')
        );
        
 
        
        
        $resultado = $this->bd->JqueryCursorVisor('presupuesto.view_certificacionesd',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
             
            $output[] = array (  
                $fetch['partida'],
                $fetch['detalle'],
                $fetch['fuente'],
                $fetch['certificado'] ,
                $fetch['compromiso'] ,
                $fetch['devengado'] ,
                $fetch['id_tramite_det'] 
                
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


if (isset($_GET['id']))	{
    
    
    $idvengestion      = $_GET['id'];
    
    $gestion->BusquedaGrilla($idvengestion);
    
}





?>
 
  