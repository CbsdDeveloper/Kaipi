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
  
                $this->obj     =    new objects;
                
                $this->set     =    new ItemsController;
                   
                $this->bd      =    new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion    =  $_SESSION['email'];
                
                $this->hoy       =  date('Y-m-d');
     
               $this->evento_form = '../model/Model-co_secuencias.php';        // eventos para ejecucion de editar eliminar y agregar 
      }

 /*
 Nombre:        Formulario
 Detalle:       Construye la pantalla de ingreso de datos
 Datos entrada: -------
 Datos salida:  ------- 
*/
      
     function Formulario( ){
      
         $this->set->_formulario( $this->evento_form,'inicio' ); 
        
                $this->BarraHerramientas();

                $MATRIZ =  $this->obj->array->catalogo_activo(); ///lista de estados

                $this->set->div_panel6('<b> Información de la secuencia </b>');

                                $this->obj->text->text_blue('Referencia',"number",'idsecuencias',13,13,$datos,'required','readonly','div-3-9') ;

                                $this->obj->text->text('Detalle',"texto",'detalle',30,30,$datos,'required','','div-3-9') ;
                                    
                                $this->obj->text->text_yellow('Secuencia',"number",'secuencia',18,20,$datos,'required','','div-3-9') ;
                            
                                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'required','',$evento,'div-3-9');
                              
                                $this->obj->text->text('Periodo',"number",'anio',100,100,$datos,'required','readonly','div-3-9') ;

                                $this->obj->text->text('Tipo',"texto",'tipo',100,100,$datos,'required','readonly','div-3-9') ;
                                
                                
                                
                $this->obj->text->texto_oculto("action",$datos); 

                $this->obj->text->texto_oculto("tanio",$datos); 

                $this->set->div_panel6('fin');

               
               $this->set->evento_formulario('-','fin'); 
 
  
      
   }

  /*
 Nombre:        BarraHerramientas
 Detalle:       Barra de herramientas con botones agregar,guardar y varios procesos
 Datos entrada: -------
 Datos salida:  -------
*/

   function BarraHerramientas(){
 
 
   
   $eventoi = "GenerarPeriodo()";
    
   
    $ToolArray = array( 
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Copiar parametros año actual', evento =>$eventoi,  grafico => 'glyphicon glyphicon-paste' ,  type=>"button_danger") 
                
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
     
    
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  