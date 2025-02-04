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
    public function BusquedaGrilla( $estado1,$qcodigo,$qunidad ){
        
        // Soporte Tecnico
 
        $filtro_cod = 'N';
        $filtro_uni = 'N';
        $filtro_est = 'S';
 
        $len = strlen($qcodigo);
        
        if ( $len > 2 ){
            $filtro_cod = 'S';
            $filtro_est = 'N';
        }
 
        
        if ( $qunidad > 0 ){
            $filtro_uni = 'S';
            $filtro_est = 'N';
        }
        
        
        $qquery = array(
            array( campo => 'id_bien',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'marca',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'descripcion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'placa_ve',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'anio_ve',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'color_ve',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'chasis_ve',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha_adquisicion',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'vida_util',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'status',   valor => $estado1,  filtro => $filtro_est,   visor => 'S'),
            array( campo => 'chofer_actual',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'u_km',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codigo_veh',   valor =>$qcodigo,  filtro => $filtro_cod,   visor => 'S'),
            array( campo => 'id_departamento',   valor =>$qunidad,  filtro => $filtro_uni,   visor => 'S')
           );
      
        
        $resultado = $this->bd->JqueryCursorVisor('adm.view_bien_vehiculo',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
 
            
            $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" width="24" height="24" align="absmiddle" />';
            
            
            
            if ( trim($fetch['status']) == 'Asignado' ) {
                $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" width="24" height="24" align="absmiddle" />';
            }
            if ( trim($fetch['status']) == 'Libre' ) {
                $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" width="24" height="24" align="absmiddle" />';
            }
            if ( trim($fetch['status']) == 'En Taller' ) {
                $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" width="24" height="24" align="absmiddle" />';
            }
            if ( trim($fetch['status']) == 'Fuera de Servicio' ) {
                $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" width="24" height="24" align="absmiddle" />';
            }
 
            
            $xx = $this->bd->query_array('adm.ad_vehiculo_comb',   
                'sum(cantidad) as galones',                        
                "uso = 'S' and id_bien=".$this->bd->sqlvalue_inyeccion($fetch['id_bien'],true) 
                );
            
            
            $xxx = $this->bd->query_array('adm.ad_vehiculo_comb',
                'count(*) as nn',
                "uso = 'S' and estado = 'enviado' and id_bien=".$this->bd->sqlvalue_inyeccion($fetch['id_bien'],true)
                );
            
            
            if ( trim($xxx['nn']) > 0 ) {
                $imagen1 = ' <img src="../../kimages/if_bullet_red_35785.png" width="24" height="24" align="absmiddle" />';
            }else {
                $imagen1= ' <img src="../../kimages/iconfinder_bullet_white_35789.png" width="24" height="24" align="absmiddle" />';
            }
            
            
            
            
            
            $codigo_carro =  '<b>'.trim($fetch['codigo_veh']).'</b>';
            
            
            $output[] = array ( 
                $imagen.' '. $codigo_carro.' '.trim($fetch['descripcion']) ,
                $fetch['placa_ve'] ,
                $imagen1.' '.$fetch['chofer_actual'],
                $fetch['u_km'] ,
                $xx['galones'] ,
                $fetch['id_bien'],
                
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
 
    $estado1           = $_GET['qestado'];
    
    $qcodigo           = trim($_GET['qcodigo']);
    $qunidad           = $_GET['qunidad'];
  
    
    $gestion->BusquedaGrilla($estado1,$qcodigo,$qunidad);
    
}






?>
 
  