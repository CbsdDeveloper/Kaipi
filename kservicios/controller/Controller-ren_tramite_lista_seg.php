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
         
        
        
        $unidad = $this->bd->__user($this->sesion) ;
        
        
        $iddepartamento  = $unidad['id_departamento'];
        

        $sql = " SELECT *
        FROM rentas.view_ren_tramite_seg where leido= 'N'";


        $stmt1 = $this->bd->ejecutar($sql);

 
        echo '<div class="col-md-12">';
 
          

            
        while ($fila=$this->bd->obtener_fila($stmt1)){
            
             
 
            $mensaje = '<b>'.trim($fila['novedad_seg']) .'</b><br>'.trim($fila['accion_seg']).'<br>'.trim($fila['fecha_seg']) .'<br>'.trim($fila['completo']).'<br>Tramite: '.($fila['id_ren_tramite'])  ;
            
            $id_rubro = $fila['id_rubro'];

            
 
       
            $xx = $this->bd->query_array('rentas.ren_rubros',    
            'detalle',                   
            'id_rubro='.$this->bd->sqlvalue_inyeccion(   $id_rubro ,true) // CONDICION
            );
 
          $evento= 'onclick="AsignaMovimiento('.$id_rubro.','."'".trim($xx['detalle'])."'".",". "'".trim($fila['idprov'])."'".",".$fila['id_tramite_seg'].')" ';
 
              
          echo ' <div class="media">
                 <div class="media-body">
                    <h4 class="media-heading">'. trim($fila['razon']).'</h4>
                    <p> <a href="#" '. $evento.' >'.$mensaje.'</a></p>
                </div>
                </div>
                <hr>';

             
        }
        
 
        echo '  </div>';
 

    
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  