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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase   bnaturaleza,bidciudad
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
         
       $anio = date('Y');
        
        
        

 
        
        echo '<div class="col-md-12">';
        
        echo '<div class="list-group">';
        
        
        $sql = "select id_rubro as codigo, servicio as nombre
                from rentas.view_ren_tramite_rubro
                where estado = 'enviado' and 
                      anio = ".$this->bd->sqlvalue_inyeccion($anio, true)."
                group by id_rubro ,servicio order by 2";
                        
        
        $stmt1 = $this->bd->ejecutar($sql);
        
 
     
        
        echo ' <a href="#" class="list-group-item"  style="background-color: #337ab7;color:#fff">Servicios</a>';
        
        while ($fila=$this->bd->obtener_fila($stmt1)){
             
            $x = $this->bd->query_array('rentas.ren_tramites',   // TABLA
                'count(*) as nn',                        // CAMPOS
                'id_rubro='.$this->bd->sqlvalue_inyeccion($fila['codigo'],true) . " and estado = 'enviado'"
                );
            
            
            if ( $x['nn'] > 0 ){
                $cadena  =  ' <span class="badge">'.$x['nn'].'</span>';
            }else {
                $cadena  =  ' ';
            }
            
             
            $detalle = "'". strtoupper(trim($fila['nombre'])) ."'";
            
            $evento = '"AsignaMovimiento('.$fila['codigo'].','.$detalle.')"';
            
            echo '<a href="#" class="list-group-item" onClick='.$evento.'>'.strtoupper(trim($fila['nombre'])).$cadena.'</a>';

             
        }
   
        echo ' </div></div>';
 
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  