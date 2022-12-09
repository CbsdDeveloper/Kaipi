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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date('Y-m-d');
     
               $this->evento_form = '../model/Model-co_asiento_val.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
        $this->set->_formulario( $this->evento_form,'inicio' ); 
    
                $this->BarraHerramientas();

                $tipo       = $this->bd->retorna_tipo();

                $datos      = array();
                     
                $MATRIZ =  $this->obj->array->catalogo_activo(); ///lista de estados

                $MATRIZ_A = array(
                    '1'                     => 'Activo',
                    '0'                     => 'Inactivo');
               
               $MATRIZ_B = array(
                     'D'                     => 'Debe',
                     'H'                     => 'Haber');

              $this->set->div_label(12,'INFORMACION'); // etiqueta  para un nuevo bloque de informacion
            
                  $this->obj->text->text_blue('Codigo',"number" ,'id_val' ,80,80, $datos ,'required','readonly','div-2-4') ;

                  $this->obj->list->listae('Activo',$MATRIZ_A ,'activo' ,$datos,'required','',$evento,'div-2-4') ;

 

                  $this->obj->text->editor('Validación','texto',3,45,300,$datos,'required','','div-2-10') ;

              $this->set->div_label(12,'CUENTA 1'); // etiqueta  para un nuevo bloque de informacion

                  $this->obj->text->text_yellow('Cuenta',"texto" ,'cuenta1' ,80,80, $datos ,'required','','div-2-4');

                  $this->obj->list->listae('Tipo',$MATRIZ_B,'tipo1' ,$datos,'required','',$evento,'div-2-4');

                  $this->obj->text->text('Grupo',"texto" ,'grupo1' ,80,80, $datos ,'required','','div-2-4') ;

                  $this->obj->text->text('Subgrupo',"texto" ,'subgrupo1' ,80,80, $datos ,'required','','div-2-4') ;

                  $this->obj->text->text('Condicion',"texto" ,'sql1' ,80,80, $datos ,'required','','div-2-4') ;

                  $this->set->div_label(12,'CUENTA 2'); // etiqueta  para un nuevo bloque de informacion
 
                  $this->obj->text->text_yellow('Cuenta',"texto" ,'cuenta2' ,80,80, $datos ,'required','','div-2-4') ;

                  $this->obj->list->listae('Tipo',$MATRIZ_B,'tipo2',$datos,'required','',$evento,'div-2-4') ;

                  $this->obj->text->text('Grupo',"texto" ,'grupo2' ,80,80, $datos ,'required','','div-2-4') ;

                  $this->obj->text->text('Subgrupo',"texto" ,'subgrupo2' ,80,80, $datos ,'required','','div-2-4') ; 

                 $this->obj->text->text('Condicion',"texto" ,'sql2' ,80,80, $datos ,'required','','div-2-4') ;

                    
         $this->obj->text->texto_oculto("action",$datos);   // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql
         
         $this->set->_formulario('-','fin'); 
   
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
  
    $eventoi = "javascript:GenerarRuc()";
    
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',            evento =>'', grafico => 'icon-white icon-plus' ,             type=>"add"),
                array( boton => 'Guardar Registros',        evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' , type=>"submit") 
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>