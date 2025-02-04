<?php
session_start();

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
        
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($qestado){
        
        
        $output = array();
 
        if(empty($qestado)){
            $qestado = 'S';
        }
        
        $qquery = array(
            array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'anio_trascurrido',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'regimen',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => $qestado ,  filtro => 'S',   visor => 'N') 
         );
        
        
        
        $resultado = $this->bd->JqueryCursorVisor('adm.view_adm_chofer',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $x = $this->bd->query_array('adm.view_adm_chofer_doc',   // TABLA
                'count(*) as nn',                        // CAMPOS
                'idprov='.$this->bd->sqlvalue_inyeccion($fetch['idprov'],true) ." and modulo = 'C'"
                );
            
            
            $xx = $this->bd->query_array('adm.view_adm_chofer_doc',   // TABLA
                'count(*) as nn',                        // CAMPOS
                'tiempo_dia < 30 and idprov='.$this->bd->sqlvalue_inyeccion($fetch['idprov'],true) ." and modulo = 'C'"
                );
            
            $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" width="24" height="24" align="absmiddle" />';
            
            if ( $xx['nn'] > 0 ) {
                $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" width="24" height="24" align="absmiddle" />';
            }
          
            $xy = $this->bd->query_array('adm.view_bien_vehiculo',   // TABLA
                "clase_ve || '' || placa_ve || ' ' || color_ve as nn",                        // CAMPOS
                'idprov_chofer='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov']),true) 
                );
            
            
            $carro = trim($xy['nn']);
            
            
            $output[] = array (
                trim($fetch['idprov']),
                trim($fetch['razon']),
                $imagen.' '.$fetch['cargo'],
                $fetch['correo'],
                $carro,
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




//------ consulta grilla de informacion
if (isset($_GET['qestado']))	{
    
    $qestado  = $_GET['qestado'];
 
    
    $gestion->BusquedaGrilla($qestado );
    
}


?>
 
  