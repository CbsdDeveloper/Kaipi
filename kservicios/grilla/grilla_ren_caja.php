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
    public function BusquedaGrilla($estado,$cajero,$fecha1,$fecha2){
        
 
        
        $output = array();
        
        $qquery = array(
            array( campo => 'id_renpago',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha_pago',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'formapago',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'login',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'monto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_par_ciu',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'sesion',   valor => $cajero,  filtro => 'S',   visor => 'N'),
            array( campo => 'reverso',   valor => 'N',  filtro => 'S',   visor => 'N'),
             array( campo => 'cierre',     valor => $estado,  filtro => 'S',   visor => 'N'),
         );
        
        
    
        // filtro para fechas
        $this->bd->__between('fecha_pago',$fecha1,$fecha2);
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_caja_usuario',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
                
            
            $output[] = array (
                $fetch['id_renpago'],
                $fetch['fecha_pago'],
                trim($fetch['idprov']),
                trim($fetch['razon']),
                trim($fetch['formapago']),
                trim($fetch['login']),
                $fetch['monto'], 
                $fetch['id_par_ciu']
             );
        }
        
        pg_free_result($resultado);
        
        echo json_encode($output);
        
    }
    //---------------
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ consulta grilla de informacion
if (isset($_GET['estado']))	{
    
    $estado= $_GET['estado'];
    
    $cajero= $_GET['cajero'];
    
    $fecha1= $_GET['fecha1'];
    
    $fecha2= $_GET['fecha2'];
    
     
    
    $gestion->BusquedaGrilla($estado,$cajero,$fecha1,$fecha2);
    
}




?>
 
  