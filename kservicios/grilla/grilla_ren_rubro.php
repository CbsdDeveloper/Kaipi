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
        
        $this->anio       =  $_SESSION['anio'];
        
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($tipo ){
        
        // Soporte Tecnico
        $filtro = 'S';
        
        if ($tipo == '-'){
            $filtro = 'N';
        }
        
        
           
        $qquery = array( 
            array( campo => 'id_rubro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'resolucion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'acceso',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'msesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'creacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'modificacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'modulo',valor => trim($tipo), filtro => $filtro, visor => 'S') 
        );
      
 
        
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.ren_rubros',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
      
            $x = $this->bd->query_array('rentas.ren_rubros_matriz',   // TABLA
                'count(*) as nn',                        // CAMPOS
                'id_rubro='.$this->bd->sqlvalue_inyeccion($fetch["id_rubro"],true)  
                );
            
                
            $output[] = array ( 
                $fetch['id_rubro'],
                $fetch['modulo'],
                $fetch['detalle'],
                $fetch['resolucion'],
                $fetch['estado'],
                $fetch['acceso'],
                $x['nn']
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



 
    
    $tipo     = $_GET['vmodulo'];
     
      
    $gestion->BusquedaGrilla(trim($tipo));
    
 
     




?>
 
  