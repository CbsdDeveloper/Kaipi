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
    function ProcesoNombre($id,$accion){
        
        $flujo = $this->bd->query_array('presupuesto.pre_tramite',
            'estado,fecha,anio, mes,sesion',
            'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
       
     
        
        
        if ( $accion == 1) {
           
            if ( $flujo['estado'] == 4 ){
                 $porce = 100;
            }elseif ($flujo['estado'] == 3 ){
                 $porce = 75;
            }elseif ($flujo['estado'] == 2 ){
                 $porce = 50;
            }elseif ($flujo['estado'] == 1 ){
                 $porce = 25;
            }
            
            $ViewAvance= '<div  class="progress-bar
                                progress-bar-striped active"
                                role="progressbar"
                                aria-valuenow="40"
                                aria-valuemin="0"
                                aria-valuemax="100" style="width:'.$porce.'%">'.$porce.' % </div>
                         <p>'.$flujo['sesion'].'</p>';
            
            
            echo $ViewAvance;
        }
        else   {
            
            
            if ( $flujo['estado'] == 4 ){
                
                $sql = "SELECT  fcompromiso - fecha::date as dias
                        FROM  presupuesto.pre_tramite
                        where id_tramite=   ".$this->bd->sqlvalue_inyeccion($id,true);
                
               
            }else{
                
                $sql = "SELECT  current_date - fecha::date as dias
                        FROM  presupuesto.pre_tramite
                        where id_tramite=   ".$this->bd->sqlvalue_inyeccion($id,true);
            }
            
            
            
            $resultado_cab = $this->bd->ejecutar($sql);
            
            $flujo = $this->bd->obtener_array( $resultado_cab);
               
            $ViewAvancedias=  '<b><h6> '.$flujo['dias'].' dias trascurridos ( '.$flujo['sesion'].' )</h6></b>' ; 
            
            
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
if (isset($_GET['idtramite']))	{
    
    
    $id                 = $_GET['idtramite'];
    $accion             = $_GET['accion'];
    
    $gestion->ProcesoNombre($id,$accion);
    
}

 

?>
 
  