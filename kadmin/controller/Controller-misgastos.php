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

        $this->set->div_label(12,' Información del Funcionario');

      
        $x = $this->bd->query_array('view_nomina_user',   // TABLA
        'completo ,cargo ,unidad ,regimen,idprov',                        // CAMPOS
        'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true) .' or 
        sesion_corporativo='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
);
 
        echo '<h4>';
        echo  '<b>'.$x['completo'].'</b><br>'.$x['regimen'].'<br>'.$x['unidad'].'<br>'.$x['cargo'];
        echo '</h4>';


        $datos = $this->bd->query_array('view_nomina_rol',   // TABLA
        '*',                        // CAMPOS
        'idprov='.$this->bd->sqlvalue_inyeccion( trim($x['idprov']),true));
         


        $this->obj->text->texto_oculto("idprov",$datos); 

        $this->obj->text->texto_oculto("razon",$datos); 


        $this->set->div_label(12,' Deducibles Impuesto a la Renta');
       
        $this->obj->text->text('Vivienda',"number",'vivienda',40,45,$datos,'required','','div-2-4') ;
        
        $this->obj->text->text('Salud',"number",'salud',40,45,$datos,'required','','div-2-4') ;
        
        $this->obj->text->text('Alimentacion',"number",'alimentacion',40,45,$datos,'required','','div-2-4') ;
        
        $this->obj->text->text('Vestimenta',"number",'vestimenta',40,45,$datos,'required','','div-2-4') ;
        
        $this->obj->text->text('Educacion',"number",'educacion',40,45,$datos,'required','','div-2-4') ;
        
        $this->obj->text->text('Turismo',"number",'turismo',40,45,$datos,'required','','div-2-4') ;
      

        $this->set->div_label(12,' Verifique la informacion antes de actualizar la información');
   }
   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  