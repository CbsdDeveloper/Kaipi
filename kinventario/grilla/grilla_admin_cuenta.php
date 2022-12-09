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
    public function BusquedaGrilla( ){
        
        
        $month = date('m');
        $year = date('Y');
        
        
        $sql = "SELECT a.idproducto, a.producto, a.referencia, a.activo, b.fechaa
        FROM web_producto a, view_mov_aprobado b
        where   a.cuenta_ing = '-' and
                a.registro = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)."  and
                a.idproducto = b.idproducto and 
                b.mes= ".$this->bd->sqlvalue_inyeccion($month,true)." and 
                b.anio=".$this->bd->sqlvalue_inyeccion($year,true)  ;
         
      
        $resultado  = $this->bd->ejecutar($sql);
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array ( 
                $fetch['idproducto'],
                $fetch['producto'],
                $fetch['referencia'],
                $fetch['estado']
                
            );
        }
        
        
        pg_free_result($resultado);
        
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


 
    $gestion->BusquedaGrilla( );
    
 




?>
 
  