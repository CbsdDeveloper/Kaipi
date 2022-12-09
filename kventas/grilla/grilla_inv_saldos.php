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
    public function BusquedaGrilla($anio,$mes,$idproducto,$idcategoria){
        
        
      
        
        $qquery = array(
            array( campo => 'fechaa',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
            array( campo => 'idcategoria',   valor => $idcategoria,  filtro => 'S',   visor => 'N'),
            array( campo => 'idproducto',   valor => $idproducto,  filtro => 'S',   visor => 'N'),
            array( campo => 'mes',   valor => $mes ,  filtro => 'S',   visor => 'N'),
            array( campo => 'anio',   valor => $anio ,  filtro => 'S',   visor => 'N'),
            array( campo => 'estado',   valor =>"aprobado",  filtro => 'S',   visor => 'N')
        );
        
        $output = array();
        
        $resultado = $this->bd->JqueryCursorVisor('view_mov_aprobado',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $x = $this->bd->query_array('inv_movimiento_var',
                                        'valor_variable', 
                                        'id_movimiento='.$this->bd->sqlvalue_inyeccion($fetch['id_movimiento'],true).' and 
                                         idcategoriavar = 1'
                );
           
         
 
            
            $output[] = array (
                $fetch['id_movimiento'],
                $fetch['fechaa'],
                trim($fetch['idprov']),
                $fetch['razon'],
                $fetch['comprobante'],
                trim($x['valor_variable']),
                $fetch['detalle'],
                $fetch['total']
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
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ consulta grilla de informacion
if (isset($_GET['anio']))	{
    
    $anio            = $_GET['anio'];
    $idproducto      = $_GET['idproducto'];
    $mes             = $_GET['mes'];
    $idcategoria     = $_GET['idcategoria'];
     
    
    
    $gestion->BusquedaGrilla($anio,$mes,$idproducto,$idcategoria);
    
}

 

?>
 
  