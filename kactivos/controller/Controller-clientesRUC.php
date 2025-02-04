<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class Controller_unidades{
    
    //creamos la variable donde se instanciar? la clase "mysql"
    
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
    function Controller_unidades( ){
        
        $this->obj     = 	new objects;
        $this->set     = 	new ItemsController;
        $this->bd	   =	new Db;
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
    }
    //---------------------------------------
    function Formulario( ){
        
        
        
        $sql = "select *
                    from nom_departamento
            order by nombre";
        
        
        echo '  <div class="list-group">
             <a href="#"  class="list-group-item active">Unidades Administrativas</a>';
        
        ///--- desplaza la informacion de la gestion
        $resultado  = $this->bd->ejecutar($sql);
        
        while($row=pg_fetch_assoc($resultado)) {
            
            
            echo ' <a href="#" onclick="goToURLPersonal('.$row['id_departamento'].')" class="list-group-item">'.trim($row['nombre']).'</a>';
            
            
        }
        
        echo ' </div>';
        
    }
    
    //----------------------------------------------
    
    
    
    //----------------------------------------------
}
$gestion   = 	new Controller_unidades;

$gestion->Formulario( );
?>

