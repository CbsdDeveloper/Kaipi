<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_micombustible{
 
  
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
      function Controller_micombustible( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
           
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){

         
         $year = date('Y');

        $x = $this->bd->query_array('view_nomina_user',   // TABLA
        'completo ,cargo ,unidad ,regimen,idprov',                        // CAMPOS
        'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true) .' or 
        sesion_corporativo='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
        );


        $datos = $this->bd->query_array('view_nomina_rol',   // TABLA
        '*',                        // CAMPOS
        'idprov='.$this->bd->sqlvalue_inyeccion( trim($x['idprov']),true));
         


        $this->set->div_label(12,' Información del Funcionario');
       
      
 
        echo '<h4>';
        echo  '<b>'.$x['completo'].'</b><br>'.$x['regimen'].'<br>'.$x['unidad'].'<br>'.$x['cargo'];
        echo '</h4>';

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion


        $this->obj->text->texto_oculto("idprov",$datos); 

        $this->obj->text->texto_oculto("razon",$datos); 
 

  
        
   }




   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new Controller_micombustible;
  
   
  $gestion->Formulario( );
  
 ?>
 
  