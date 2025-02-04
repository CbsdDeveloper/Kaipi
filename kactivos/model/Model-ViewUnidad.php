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
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId( ){
        
        
        $sql = "select unidad_ubica,count(*) as bienes 
			from activo.view_custodios
			group by unidad_ubica"   ;
        
 
        
        /*Ejecutamos la query*/
        $resultado= $this->bd->ejecutar($sql);
        
        
        $ViewGrupo.= '<div style="width:100%; height:360px; overflow: auto;padding: 5px" >
  <div class="list-group">';
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
         
            
            $nombre = $fetch['unidad_ubica'];
            
            
            $ViewGrupo.= '<a href="#" class="list-group-item">'.trim($nombre).' [ '.$fetch['bienes'].' ]'.'</a>';
            
            
            
        }
        
        
        $ViewGrupo.='</div></div>';
        
        echo $ViewGrupo;
        
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

$gestion->consultaId( );



?>
 
  