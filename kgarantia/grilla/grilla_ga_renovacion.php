<?php
session_start( );

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
    public function BusquedaGrilla($tiddepartamento1){
        
        // Soporte Tecnico
        
          
     
        
        if ( $tiddepartamento1 >  '0'){
            $where = '  iddepartamento = '.$tiddepartamento1." and  ( dias_falta between  1 and 16 ) and estado in ('E','A','V','C')";
         }else {
            $where = "  ( dias_falta between  1 and 16 ) and estado in ('E','A','V','C') ";
        }
            
 
        
        $sql = 'SELECT *
                from garantias.contratos_garantia  
                where '. $where. ' order by fecha_fin ';
        
        
 
        
        $resultado  = $this->bd->ejecutar($sql);
        
         
        while ($fetch=$this->bd->obtener_fila($resultado)){
 
  
            $output[] = array ( 
                $fetch['idcontrato'],
                $fetch['razon'],
                $fetch['nro_contrato'] ,
                $fetch['detalle_contrato'],
                $fetch['fecha_inicio'] ,
                $fetch['fecha_fin'] ,
                $fetch['dias_vigencia'] ,
                $fetch['dias_falta']
                
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
 
    
     $tiddepartamento1  = $_GET['tiddepartamento1'];
     
 
    
    $gestion->BusquedaGrilla( $tiddepartamento1);
    
 



?>
 
  