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
    public function BusquedaGrilla($mes){
      
        
        $sql = 'select id_combus,  fecha, hora_in,referencia,ubicacion_salida,tipo_comb,cantidad, costo,total_consumo
                from adm.view_comb_vehi_in
                where   periodo= '.$this->bd->sqlvalue_inyeccion(trim($mes),true) ;
        
        
 
        $resultado  = $this->bd->ejecutar($sql);
        
         
     
        while ($fetch=$this->bd->obtener_fila($resultado)){
 
       
           
            $output[] = array ( 
                $fetch['id_combus'],
                $fetch['fecha'],
                $fetch['hora_in'] ,
                $fetch['referencia'],
                $fetch['ubicacion_salida'] ,
                $fetch['tipo_comb'] ,
                round($fetch['cantidad'],4) ,
                round($fetch['costo'],4) ,
                round($fetch['total_consumo'],4)
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

 
   
    $gestion->BusquedaGrilla( $_GET['qestado']);
    
    
 




?>
 
  