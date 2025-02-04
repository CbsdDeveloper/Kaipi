<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      private $obj;
      private $bd;
      private $set;
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
                   
                $this->bd	   =	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date('Y-m-d');
     
               $this->evento_form = '../model/Model-nom_imp_renta.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
              $this->set->_formulario( $this->evento_form,'inicio' ); 
    
              $this->BarraHerramientas();
                     

              $this->set->div_panel7('<b> Información de impuesto a la renta </b>');
                       
              $this->obj->text->text_blue('Codigo',"number" ,'id' ,80,80, $datos ,'required','readonly','div-2-4');

              $this->obj->text->text_yellow('Periodo',"number" ,'anio' ,80,80, $datos ,'required','','div-2-4');

              $this->obj->text->text('Tipo',"text" ,'tipo' ,80,80, $datos ,'required','readonly','div-2-4');

              $this->obj->text->text('Fracccion basica',"number" ,'fracbasica' ,80,80, $datos ,'required','','div-2-4');

              $this->obj->text->text('Excedente ',"number" ,'excehasta' ,80,80, $datos ,'required','','div-2-4');

              $this->obj->text->text('Base imponible',"number" ,'impubasico' ,80,80, $datos ,'required','','div-2-4');

              $this->obj->text->text('Impuesto excedente',"number" ,'impuexcedente' ,80,80, $datos ,'required','','div-2-4');

              $this->set->div_panel7('fin');


                          
         $this->obj->text->texto_oculto("action",$datos);   // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql
         
         $this->set->_formulario('-','fin'); 
   
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
  
    $eventoi = "javascript:GenerarRuc()";
    
    $ToolArray = array( 
              array( boton => 'Nuevo Regitros',evento =>'', grafico => 'icon-white icon-plus' , type=>"add"),
              
              array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' , type=>"submit") ,
                
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>