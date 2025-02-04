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
    public function BusquedaGrilla($PK_codigo){
        
 
        
        $qquery = array(
            array( campo => 'id_rol',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'anio',   valor => $PK_codigo,  filtro => 'S',   visor => 'S'),
            array( campo => 'novedad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'sesion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'registro',   valor => $this->ruc,  filtro => 'S',   visor => 'N')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('nom_rol_pago',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $estado = 'NO';
            if ( $fetch['estado'] == 'S'){
                $estado = 'SI';
            }
            $output[] = array (
                $fetch['id_rol'],
                $fetch['anio'],
                '<b>'.$fetch['novedad'].'</b>',
                $estado ,
                $fetch['sesion']);
            
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
if (isset($_GET['fanio']))	{
    
    $PKcodigo  = $_GET['fanio'];
    
    $gestion->BusquedaGrilla($PKcodigo );
    
}



?>
 
  