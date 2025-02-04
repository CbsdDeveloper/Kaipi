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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
       }
     //---------------------------------------
       function Formulario( $GET ){
            
        $id_emision =  $GET['id_emision'];
 
 
       
        $qcabecera = array(
            array(etiqueta => 'id_ren_movimiento',campo => 'id_ren_movimiento',ancho => '0%', filtro => 'S', valor => $id_emision, indice => 'S', visor => 'N'),
            array(etiqueta => 'Codigo',campo => 'id_ren_movimientod',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Detalle',campo => 'servicio',ancho => '40%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Valor',campo => 'costo',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Interes',campo => 'interes',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Descuento',campo => 'descuento',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Recargo',campo => 'recargo',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
            array(etiqueta => 'Total',campo => 'total',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S') 
        );
        
        $acciones = '';
        $funcion  = '';
        
        $this->bd->JqueryArrayTable('rentas.view_ren_detalles',$qcabecera,$acciones,$funcion,'tabla_aux' );
        
         
 
   }
 //----------------------------------------------
    
  //----------------------------------------------
 }    
 
 
   $gestion   = 	new componente;
   
 
   $gestion->Formulario( $_GET );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>