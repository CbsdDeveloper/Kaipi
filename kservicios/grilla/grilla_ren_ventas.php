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
    public function BusquedaGrilla($fecha1,$fecha2,$cajero){
        
 
        
        $output = array();
        
        $sql = 'SELECT  id_ren_tramite, fecha_inicio ,  idprov, razon,  nombre_rubro,
                        estado_proceso ,
                        coalesce(total,0 ) as pago,id_par_ciu
        FROM  rentas.view_tramite_estados
        where  fecha_inicio between '.$this->bd->sqlvalue_inyeccion( $fecha1,true).' and '.$this->bd->sqlvalue_inyeccion($fecha2,true).' and 
               sesion = '.$this->bd->sqlvalue_inyeccion( $cajero,true).'
        order by id_ren_tramite desc ';
        
 
            
        
        $resultado  = $this->bd->ejecutar($sql);
        

        // filtro para fechas
         
         
        while ($fetch=$this->bd->obtener_fila($resultado)){
                
            
            $output[] = array (
                trim($fetch['id_ren_tramite']),
                $fetch['fecha_inicio'],
                $fetch['idprov'],
                $fetch['razon'],
                $fetch['nombre_rubro'],
                $fetch['estado_proceso'],
                $fetch['pago'] 
             );
        }
        
        
        $_SESSION['sql_activo'] = $sql;
        
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
if (isset($_GET['fecha1']))	{
    
 
    
    $fecha1= $_GET['fecha1'];
 
    $fecha2 = $_GET['fecha2'];
    
    $cajero = $_GET['cajero'];
    
    $gestion->BusquedaGrilla( $fecha1,$fecha2,$cajero);
    
}




?>
 
  