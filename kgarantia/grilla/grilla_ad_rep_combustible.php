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
    public function BusquedaGrilla($inicio,$fin){
      
        
        $sql = 'select id_bien,detalle,status,tipo_comb,max(u_km) recorrido, sum(cantidad) galones,sum(total_consumo) costo
                from adm.view_comb_vehi
                where uso =  '.$this->bd->sqlvalue_inyeccion('S',true).' and 
                    fecha between '.$this->bd->sqlvalue_inyeccion(trim($inicio),true).' and '.$this->bd->sqlvalue_inyeccion(trim($fin),true).' 
                    group by id_bien,tipo_comb,detalle,status';
        
        
         
        $resultado  = $this->bd->ejecutar($sql);
        
         
     
        while ($fetch=$this->bd->obtener_fila($resultado)){
 
       
           
            $output[] = array ( 
                $fetch['id_bien'],
                $fetch['detalle'],
                $fetch['status'] ,
                $fetch['recorrido'],
                $fetch['tipo_comb'] ,
                round($fetch['costo'],4) ,
                round($fetch['galones'],4)
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

 
   
    $gestion->BusquedaGrilla( $_GET['qinicial'],$_GET['qfinal']);
    
    
 




?>
 
  