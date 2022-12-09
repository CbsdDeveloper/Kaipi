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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion    =  $_SESSION['email'];
                
                $this->hoy       =  date('Y-m-d');
     
               $this->evento_form = '../model/Model-par_modulos.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
       /*
      //Construye la pantalla de ingreso de datos
      */
     
     function Formulario( ){

        $this->set->_formulario( $this->evento_form,'inicio' ); 
    
                $this->BarraHerramientas();
                     
               
                $MATRIZ =  $this->obj->array->catalogo_activo();

                $tipo   = $this->bd->retorna_tipo();

    
                $resultado =$this->bd->
                 ejecutar("SELECT 0 as codigo, '-- 00.Todos los modulos --' as  nombre   union SELECT fid_par_modulo as codigo, modulo from par_modulos  where fid_par_modulo=0  order by 2 ");

            
                    $MATRIZ_B = array(
                  'S'                     => 'Si',
                  'N'                     => 'No',
                  'O'                     => 'No Aplica'    
                    );
             
                $this->set->div_panel8('<b> Información del módulo  </b>');
                        
                $this->obj->text->text_blue('Id_par_modulo',"number",'id_par_modulo',13,13,$datos,'required','','div-2-4');

                $this->obj->list->listadb($resultado,$tipo,'Fid_par_modulo','fid_par_modulo',$datos,'required','','div-2-4'); // lista dinamica con busqueda de modulos
                                     
                $this->obj->text->text_yellow('Modulo',"text",'modulo',18,20,$datos,'required','','div-2-4');
                    
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-4');
                       
                $this->obj->text->text('Vinculo',"text",'vinculo',100,100,$datos,'required','','div-2-4');

                $this->obj->list->listae('Publica',$MATRIZ_B,'publica',$datos,'required','',$evento,'div-2-4');
                        
                $this->obj->text->text('Script',"text",'script',100,100,$datos,'required','','div-2-4') ;   

                $this->obj->text->text('Tipo',"text",'tipo',40,45,$datos,'required','','div-2-4') ;
                        
                $this->obj->text->text('Ruta',"text",'ruta',18,20,$datos,'required','','div-2-4') ;
             
                $informacion =$this->bd->ejecutar("SELECT '' as codigo, '-- 00.Todos los modulos --' as  nombre   union SELECT modulo as codigo, modulo from par_modulos  where fid_par_modulo=0  order by 2 ");

                $this->obj->list->listadb($informacion,$tipo,'Accion','accion',$datos,'required','','div-2-4'); // lista dinamica con busqueda de modulos
                        
                $this->obj->text->text_yellow('Detalle ',"text",'detalle',40,45,$datos,'required','','div-2-4') ;
                        
                $this->obj->text->text('Logo',"text",'logo',40,45,$datos,'required','','div-2-4') ;
                                 
                $this->obj->text->texto_oculto("action",$datos); // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql

                $this->set->div_panel8('fin');
                 
        $this->set->evento_formulario('-','fin'); 
 
  
      
   }
/*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:GenerarRuc()";
    
   
    $ToolArray = array( 

                array( boton => 'Nuevo Regitros',            evento =>'', grafico => 'icon-white icon-plus' ,             type=>"add"),               
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") 
                
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
     
    
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  