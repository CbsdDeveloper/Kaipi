<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class componente{
    
 
    
    private $obj;
    private $bd;
    private $set;
    
    private $formulario;
    private $evento_form;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function componente( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->set     = 	new ItemsController;
        
        $this->bd	   =	new  Db ;
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase   bnaturaleza,bidciudad
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
         
        
     /*   
        $unidad = $this->bd->__user($this->sesion) ;
        
        
        $iddepartamento  = $unidad['id_departamento'];
        
         */
         
        
        
        $sql = "select idproducto_ser,producto,costo
                    	from rentas.ren_servicios
                        where  estado = 'S' and tipo= 'E' 
                        order by 2";
        
        $stmt1 = $this->bd->ejecutar($sql);
        
        
        echo '<div class="col-md-12">';
 
        echo ' <div class="list-group"">';
        
        echo ' <a href="#" class="list-group-item"  style="background-color: #337ab7;color:#fff">Especies</a>';
        
        while ($fila=$this->bd->obtener_fila($stmt1)){
            
            $detalle = "'". strtoupper(trim($fila['producto'])) ."'";
            
            $evento = '"AsignaMovimiento('.$fila['idproducto_ser'].','.$detalle.','.$fila['costo'].')"';
            
            echo '<a href="#" class="list-group-item" onClick='.$evento.'>'.strtoupper(trim($fila['producto'])).'</a>';

             
        }
        
 
        echo ' </div></div>';
 
 
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  