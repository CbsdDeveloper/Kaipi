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
    public function BusquedaGrilla($id_rubro,$id ){
        
        // Soporte Tecnico
 
         
        $qquery = array( 
            array( campo => 'idrubro',valor => $id_rubro,filtro => 'S', visor => 'S'),
            array( campo => 'id_matriz_var',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'valor',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_matriz_cat',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor2',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'basico',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'excendente',valor => '-',filtro => 'N', visor => 'S')
         );
      
 
        
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.ren_servicios_cat',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
      
                
            $output[] = array ( 
                $fetch['id_matriz_cat'],
                $fetch['valor'],
                $fetch['valor1'],
                $fetch['valor2'],
                $fetch['basico'],
                $fetch['excendente']
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

 
    
    if (isset($_GET['id_rubro']))	{
        
        
        $id_rubro= $_GET['id_rubro'];
        
        $id= $_GET['id'];
        
        
        $gestion->BusquedaGrilla($id_rubro,$id);
        
    }
    



?>
 
  