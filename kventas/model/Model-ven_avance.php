<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
    }
    
    
    //--------------------------------------------------------------------------------
    function ProcesoNombre($id,$idvengestion,$accion){
        
        $flujo = $this->bd->query_array('ven_cliente_seg',
            'porcentaje,sesion,estado',
            'idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion,true)
            );
        
        
        $user = $this->bd->query_array('par_usuario',
            'completo,telefono',
            'email='.$this->bd->sqlvalue_inyeccion($flujo['sesion'],true)
            );
        
        
        if ( $accion == 1) {
           
            if ( $flujo['estado'] == 12 ){
                $porce = 100;
            }else{
                $porce = $flujo['porcentaje'];
            }
                
            $ViewAvance= '<div  class="progress-bar
                                progress-bar-striped active"
                                role="progressbar"
                                aria-valuenow="40"
                                aria-valuemin="0"
                                aria-valuemax="100" style="width:'.$porce.'%">'.$porce.' % </div>
                         <p>'.$user['completo'].'</p>';
            
            
            echo $ViewAvance;
        }
        else   {
            
            
            if ( $flujo['estado'] == 12 ){
                $sql = "SELECT   b.fecha - a.fecha::date as dias
                        FROM  ven_cliente a
                        join ven_cliente_seg b on b.idprov = a.idprov and
                             idvengestion=   ".$this->bd->sqlvalue_inyeccion($idvengestion,true);
            }else{
                $sql = "SELECT  current_date - a.fecha::date as dias
                        FROM  ven_cliente a
                        join ven_cliente_seg b on b.idprov = a.idprov and
                             idvengestion=   ".$this->bd->sqlvalue_inyeccion($idvengestion,true);
            }
            
            
            
            $resultado_cab = $this->bd->ejecutar($sql);
            
            $flujo = $this->bd->obtener_array( $resultado_cab);
               
            $ViewAvancedias=  '<b><h6> '.$flujo['dias'].' dias trascurridos ( '.$user['completo'].' )</h6></b>' ; 
            
            
            echo $ViewAvancedias;
            
        }
        
        
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
if (isset($_GET['idcliente']))	{
    
    
    $id                 = $_GET['idcliente'];
    $idvengestion       = $_GET['idvengestion'];
    $accion      = $_GET['accion'];
    
    $gestion->ProcesoNombre($id,$idvengestion,$accion);
    
}

 

?>
 
  