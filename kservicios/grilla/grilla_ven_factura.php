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
    public function BusquedaGrilla($estado,$cajero,$fecha1,$fecha2,$tipofacturaf){
        
        
        $output =array();
        
     
        $qquery = array(
            array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_ren_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cierre',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'sesion',   valor => $cajero,  filtro => 'S',   visor => 'N'),
            array( campo => 'estado',     valor => $estado,  filtro => 'S',   visor => 'N')
        );
        
        
        // filtro para fechas
        $this->bd->__between('fecha',$fecha1,$fecha2);
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_ren_caja_punto',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
     
          
            $xx = $this->bd->query_array('rentas.ren_fre_mov',   // TABLA
            '*',                        // CAMPOS
            'id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion(  $fetch['id_ren_movimiento'] ,true));
             
            if ( $xx['id_ren_movimiento'] > 0  )  {   
                $cadena = 'Unidad: '. trim($xx['num_carro']);
            } else    { 
                $cadena = '';
            }

            $output[] = array (
                $fetch['id_ren_movimiento'],
                $fetch['fecha'],
                trim($fetch['comprobante']),
                trim($fetch['razon']).' '. $cadena ,
                $fetch['total'],
                $fetch['cierre'],
                trim($fetch['idprov']), 
                $fetch['id_par_ciu']
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
if (isset($_GET['estado']))	{
    
    $estado= $_GET['estado'];
    
    $cajero= $_GET['cajero'];
    
    $fecha1= $_GET['fecha1'];
    
    $fecha2= $_GET['fecha2'];
    
    $tipofacturaf = $_GET['tipofacturaf'];
    
    
    $gestion->BusquedaGrilla($estado,$cajero,$fecha1,$fecha2,$tipofacturaf);
    
}




?>
 
  