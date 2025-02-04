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
    public function BusquedaGrilla($idbien){
        
        // Soporte Tecnico
 
        $anio = date ("Y");
        
        
        
        $sql = "SELECT mes , sum(total_consumo)  as consumo
			  FROM adm.view_comb_vehi
			  WHERE anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and
                    id_bien=".$this->bd->sqlvalue_inyeccion($idbien ,true). "
			 group by mes 
             ORDER BY 1";
        
        
   
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $bln = array();
        
        $bln['name'] = 'Mes';
        $rows['name'] = 'Monto';
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $bln['data'][]  = $r['mes'];
            $rows['data'][] = (int) $r['consumo'];
            
        }
        
        
        $rslt = array();
        array_push($rslt, $bln);
        array_push($rslt, $rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
        
        
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
if (isset($_GET['idbien']))	{
    
   
    
    $gestion->BusquedaGrilla($_GET['idbien']);
    
}




?>
 
  