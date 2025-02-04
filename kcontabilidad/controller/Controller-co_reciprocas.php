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
                 $this->obj     = 	   new objects;
                 $this->set     = 		    new ItemsController;
                 $this->bd	    =	     	new Db ;
                 
                 $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                 
                 $this->ruc       =  $_SESSION['ruc_registro'];
                 
                 $this->sesion 	  =  trim($_SESSION['email']);
                 
                 $this->hoy 	  =  $this->bd->hoy();
      }
      
      function Formulario($codigo){
    

        $datos    = $this->bd->query_array('co_reciprocas',
        '*',
        'id_reciproco='.$this->bd->sqlvalue_inyeccion($codigo,true) );

         
        $this->obj->text->text_blue('Grupo',"texto" ,'cuenta_1' ,3,3, $datos ,'required','','div-1-3') ;
        $this->obj->text->text('Nivel1',"texto" ,'nivel_11' ,2,2, $datos ,'required','','div-1-3') ;
        $this->obj->text->text('Nivel2',"texto" ,'nivel_12' ,2,2, $datos ,'required','','div-1-3') ;

        $this->obj->text->text_yellow('Deudor',"number" ,'deudor_1' ,80,80, $datos ,'required','','div-1-3') ;
        $this->obj->text->text_yellow('Acreedor',"number" ,'acreedor_1' ,80,80, $datos ,'required','','div-1-3') ;

        $this->set->div_label(12,'Identificacion');	 
        
        $this->obj->text->text('Ruc',"texto" ,'ruc1' ,13,13, $datos ,'required','','div-1-3') ;
        $this->obj->text->text('Nombre',"texto" ,'nombre' ,180,180, $datos ,'required','','div-1-5') ;

        $this->set->div_label(12,'Informacion Presupuestario');	 

        $this->obj->text->text_blue('Grupo',"texto" ,'grupo' ,2,2, $datos ,'required','','div-1-3') ;
        $this->obj->text->text('Subgrupo',"texto" ,'subgrupo' ,2,2, $datos ,'required','','div-1-3') ;
        $this->obj->text->text('Item',"texto" ,'item' ,2,2, $datos ,'required','','div-1-3') ;
        
        $this->set->div_label(12,'Informacion Contracuenta');	 
        $this->obj->text->text_blue('Cuenta',"texto" ,'cuenta_2' ,80,80, $datos ,'required','','div-1-3') ;
        $this->obj->text->text('Nivel1',"texto" ,'nivel_21' ,80,80, $datos ,'required','','div-1-3') ;
        $this->obj->text->text('Nivel2',"texto" ,'nivel_22' ,80,80, $datos ,'required','','div-1-3') ;
        $this->obj->text->text_yellow('Deudor',"number" ,'deudor_2' ,80,80, $datos ,'required','','div-1-3') ;
        $this->obj->text->text_yellow('Acreedor',"number" ,'acreedor_2' ,80,80, $datos ,'required','','div-1-3') ;
        
        $this->set->div_label(12,'Informacion Asientos Contables');	 

        $this->obj->text->text_blue('Asiento',"texto" ,'asiento' ,80,80, $datos ,'required','','div-1-3') ;
        $this->obj->text->text_yellow('AsientoP',"texto" ,'id_asiento_ref' ,80,80, $datos ,'required','','div-1-3') ;

         $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-1-3') ;
         $this->obj->text->text('Fecha_pago',"date" ,'fecha_pago' ,80,80, $datos ,'required','','div-1-3') ;
      
      

      
         $this->obj->text->texto_oculto("id_reciproco",$datos); 

       
                
  		  
       
                 
    }
  
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
 ?> 
   <!-- pantalla de gestion -->
   <div class="row">
 	 <div class="col-md-12">
 	<?php	 	 
 	
 	      $codigo         = $_GET['codigo'] ;
      
      

 		   $gestion   = 	new componente;
   
 		   $gestion->Formulario($codigo );
  
     ?>			 						  
  	 </div>
   </div>
   