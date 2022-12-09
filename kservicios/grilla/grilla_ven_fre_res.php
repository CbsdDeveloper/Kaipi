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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($idprov,$fecha2){
        
        
        $output =array();
        
        
        $sql = "SELECT  fecha,
                        hora,
                        ruta_ori || '/' || ruta_des as ruta, 
                        num_carro, hora_llegada, sesion,
                        cajero,id_fre_mov 
                FROM rentas.view_frec_resu
                where idprov = ".$this->bd->sqlvalue_inyeccion( $idprov,true)."  and fecha is null
                union 
                SELECT   fecha,
                        hora,
                        ruta_ori || '/' || ruta_des as ruta, 
                        num_carro, hora_llegada, sesion, 
                        cajero,id_fre_mov 
                FROM rentas.view_frec_resu
                where idprov = ".$this->bd->sqlvalue_inyeccion( $idprov,true)."  and fecha = ".$this->bd->sqlvalue_inyeccion( $fecha2,true) ;

               
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
     
          
             
             
            $output[] = array (
                $fetch['hora'],
                $fetch['ruta'],
                $fetch['num_carro'],
                $fetch['hora_llegada'],
                $fetch['cajero']
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
if (isset($_GET['idprov']))	{
    
     
    $idprov= $_GET['idprov'];
    
     
    $fecha2= $_GET['fecha2'];
    
 
    
    $gestion->BusquedaGrilla($idprov,$fecha2);
    
}




?>
 
  