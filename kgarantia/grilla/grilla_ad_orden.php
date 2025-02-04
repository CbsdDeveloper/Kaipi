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
    public function BusquedaGrilla($estado,$inicio,$fin){
        
        // Soporte Tecnico
 
             
 
        $qquery = array(
            array( campo => 'estado',   valor => $estado,  filtro => 'S',   visor => 'S'),
            array( campo => 'id_orden',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_salida',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'motivo_traslado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'placa',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'chofer',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sale_km',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'llega_km',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'periodo',valor => '-',filtro => 'N', visor => 'S'),
           );
      
        $this->bd->__between('fecha',$inicio,$fin);
        
        $resultado = $this->bd->JqueryCursorVisor('adm.view_adm_orden',$qquery  );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
 
            
            $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" width="24" height="24" align="absmiddle" />';
            
            if ( trim($fetch['estado']) == 'finalizado' ) {
                $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" width="24" height="24" align="absmiddle" />';
            }
            if ( trim($fetch['autorizado']) == 'Libre' ) {
                $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" width="24" height="24" align="absmiddle" />';
            }
          
            if ( trim($fetch['estado']) == 'solicitado' ) {
                $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" width="24" height="24" align="absmiddle" />';
            }
  
             
              $carro =   trim($fetch['descripcion']) .' '.trim($fetch['placa']);
              
            $output[] = array ( 
                $fetch['id_orden'],
                $fetch['fecha'],
                $fetch['hora_salida'] ,
                $fetch['razon'],
                $fetch['motivo_traslado'] ,
                $fetch['chofer'] ,
                $imagen.' '.$carro ,
                $fetch['sale_km'],
                $fetch['llega_km']
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
if (isset($_GET['accion']))	{
    
   
 
    $gestion->BusquedaGrilla($_GET['qestado'],$_GET['qinicial'],$_GET['qfinal']);
    
    
}




?>
 
  