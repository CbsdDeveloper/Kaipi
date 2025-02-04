<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla( $anio ){
        
        
        $output = array();
        
        $qquery = array(
            array( campo => 'ejercicio',   valor => $anio,  filtro => 'S',   visor => 'S'),
            array( campo => 'no_cur',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'no_original',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'clase_registro',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'descripcion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'pagado_total',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fec_aprobado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'nombre_beneficiario',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'actividad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'renglon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fuente',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'monto_presupuesto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_tramite',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_asiento',   valor => '-',  filtro => 'N',   visor => 'S') 
        );
        
        $resultado = $this->bd->JqueryCursorVisor('presupuesto.matriz_sigef_dato',$qquery );
        
 
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
             
            $output[] = array (  
                $fetch['ejercicio'],
                $fetch['no_cur'],
                $fetch['no_original'],
                $fetch['clase_registro'] ,
                $fetch['descripcion'] ,
                $fetch['pagado_total'],
                $fetch['fec_aprobado'] ,
                $fetch['nombre_beneficiario'] ,
                $fetch['actividad'],
                $fetch['renglon'] ,
                $fetch['fuente'] ,
                $fetch['monto_presupuesto']  ,
                $fetch['id_tramite'] ,
                $fetch['id_asiento']  
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
if (isset($_GET['anio']))	{
    
    $anio  = $_GET['anio'];
    
    
    $gestion->BusquedaGrilla($anio);
    
    
}

 




?>
 
  