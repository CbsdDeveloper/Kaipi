<?php
session_start( );

require '../../kconfig/Db.class.php';   


require '../../kconfig/Obj.conf.php';  


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
    public function BusquedaGrilla($ftipo,$ffinalizado){
        
        
        
        
        
        $qquery = array(
            array( campo => 'idren_local',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'servicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => $ftipo,filtro => 'S', visor => 'S'),
            array( campo => 'contrato',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'dias_trascurrido',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_fin',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'numero',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'finalizado',valor => $ffinalizado,filtro => 'S', visor => 'S'),
            array( campo => 'periodo',valor => '-',filtro => 'N', visor => 'S')
        );
        
 
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_ren_arren_local',$qquery );
 
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            
            $x = $this->bd->query_array('inv_movimiento',
                                        'count(*) as ntotal', 
                                        'modulo='.$this->bd->sqlvalue_inyeccion('arriendo',true).' and 
                                         estado<>'.$this->bd->sqlvalue_inyeccion('anulado',true).' and
                                         idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov']),true)
                );
            
            $y = $this->bd->query_array('inv_movimiento',
                                        'count(*) as ntotal',
                                        'modulo='.$this->bd->sqlvalue_inyeccion('arriendo',true).' and
                                         estado='.$this->bd->sqlvalue_inyeccion('aprobado',true).' and
                                         idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov']),true)
                );
            
            $facturas =  $y['ntotal'].' / '. $x['ntotal'];
                
            $output[] = array (
                 $fetch['fecha_inicio'],
                $fetch['contrato'],
                $fetch['numero'],
                $fetch['idprov'],
                $fetch['razon'],
                $fetch['servicio'],
                $fetch['dias_trascurrido'],
                $facturas,
                $fetch['idren_local']
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
if (isset($_GET['ftipo']))	{
    
    $ftipo             = $_GET['ftipo'];
    $ffinalizado      = $_GET['ffinalizado'];
   
    
 
    $gestion->BusquedaGrilla($ftipo,$ffinalizado);
    
}










?>
 
  