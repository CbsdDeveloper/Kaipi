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
        
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($mes,$qproveedor){
      
        
        $sql = 'select *
                from adm.view_comb_vehi_estacion
                where   periodo= '.$this->bd->sqlvalue_inyeccion(trim($mes),true) .' and idprov='.$this->bd->sqlvalue_inyeccion(trim($qproveedor),true);
        
 
  
        $resultado  = $this->bd->ejecutar($sql);
        
         
     
        while ($fetch=$this->bd->obtener_fila($resultado)){
 
       
           
            $output[] = array ( 
                $fetch['id_combus'],
                $fetch['fecha'],
                $fetch['referencia'],
                $fetch['u_km_inicio'] ,
                 $fetch['u_km_fin'] ,
                $fetch['tipo_comb'] ,
                round($fetch['cantidad'],4) ,
                round($fetch['costo'],4) ,
                round($fetch['total_consumo'],4),
                $fetch['conductor'] ,
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

 
   
    $gestion->BusquedaGrilla( $_GET['qestado'],$_GET['qproveedor']);
    
    
 




?>
 
  