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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla( $idseguimiento_cliente ){
        
        //idvengestion
        
     
           $sql = 'SELECT fecha, asunto, estado
                  FROM  ven_cliente_email
                  where sesion = '.$this->bd->sqlvalue_inyeccion( $this->sesion, true).' and idvengestion ='.$this->bd->sqlvalue_inyeccion( $idseguimiento_cliente, true).
                  ' order by fecha desc LIMIT 8';
     
 
        
        $i = 0;
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $lista_enviados= ' <div class="list-group">';
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
       
            
          // $evento = ' onClick="VerActividad('.$idprov.','.$nombre.','.$idvengestion.')" ';
          
            $imagen = '<img src="../../kimages/vistof.png" width="20" height="8"/> ';
            
                
            $cadena =  trim($fetch['fecha']).$imagen.trim($fetch['asunto']) ;
            
            $lista_enviados .= ' <a href="#" class="list-group-item">'.$cadena.'</a>';
                  
            $i ++;
            
        }
        
       
 
        
        $lista_enviados .= '</div>' ;
        
        
        echo $lista_enviados;
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['seguimiento_cliente']))	{
    
    $idseguimiento_cliente   = $_GET[ 'seguimiento_cliente'];
    
    $gestion->BusquedaGrilla( $idseguimiento_cliente );
 
}









?>
 
  