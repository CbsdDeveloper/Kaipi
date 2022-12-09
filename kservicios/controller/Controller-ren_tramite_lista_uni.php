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
         
        
        
        $unidad = $this->bd->__user($this->sesion) ;
        
        
        $iddepartamento  = $unidad['id_departamento'];

        $permiso  = trim($unidad['tipo']);
        
         
        
        
        $tipo = $this->bd->retorna_tipo();
        
        $sql = " select  0 as codigo , ' -- 0. Seleccionar mas servicios --  ' as nombre union
                 select  id_rubro as codigo, detalle as nombre
                  from   rentas.ren_rubros
                  where  estado = 'S' and acceso= 'proceso' and 
                         id_departamento=".$this->bd->sqlvalue_inyeccion($iddepartamento,true)."
                  order by 2";

        if (  trim($permiso) == 'admin')       {   

            $sql = " select  0 as codigo , ' -- 0. Seleccionar mas servicios --  ' as nombre union
            select  id_rubro as codigo, detalle as nombre
             from   rentas.ren_rubros
             where  estado = 'S' and acceso= 'proceso'  
             order by 2";
        }
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos = array();
        
        echo '<div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px">';
        
        $evento = 'onchange="AsignaRubro(this.value)"';
        
        $this->obj->list->listadbe($resultado,$tipo,'','midrubro',$datos,'required','',$evento,'div-0-12');
        
        echo ' </div>';
        
        
        $sql = "select  id_rubro as codigo, detalle as nombre
                    	from rentas.ren_rubros
                        where  estado = 'S' and acceso= 'proceso' and 
                               id_departamento=".$this->bd->sqlvalue_inyeccion($iddepartamento,true)."
                        order by 2";

         if (  trim($permiso) == 'admin')       {   

            $sql = "select  id_rubro as codigo, detalle as nombre
            from rentas.ren_rubros
            where  estado = 'S' and acceso= 'proceso'  
            order by 2";
          }                        
        
        $stmt1 = $this->bd->ejecutar($sql);
        
        
        echo '<div class="col-md-12">';
 
        echo ' <div class="list-group"">';
        
        echo ' <a href="#" class="list-group-item"  style="background-color: #337ab7;color:#fff">Servicios</a>';
        
        while ($fila=$this->bd->obtener_fila($stmt1)){
            
            $detalle = "'". strtoupper(trim($fila['nombre'])) ."'";
            
            $evento = '"AsignaMovimiento('.$fila['codigo'].','.$detalle.')"';
            
            echo '<a href="#" class="list-group-item" onClick='.$evento.'>'.strtoupper(trim($fila['nombre'])).'</a>';

             
        }
        
 
        echo ' </div></div>';
 
 
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  