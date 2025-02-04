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
     
               $this->evento_form = '../model/Model-cli_ingreso.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
        $this->set->_formulario( $this->evento_form,'inicio' ); 
    
                $this->BarraHerramientas();

                $tipo       = $this->bd->retorna_tipo();
                     
                $MATRIZ     =  $this->obj->array->catalogo_tpIdProv();

                $MATRIZ_P   =  $this->obj->array->catalogo_naturaleza();
                
                $MATRIZ_E   =  $this->obj->array->catalogo_activo();
               
                $MATRIZ_M = array(
                    'C'    => 'Cliente',
                    'P'    => 'Proveedor',
                    'N'    => 'Nomina'
                );

                $MATRIZ_S = array(
                  '-'    => 'Normal',
                  'C'    => 'Cooperativa',
                  'A'    => 'Aseguradora'
              );



                $resultado = $this->bd->ejecutar_catalogo('canton'); // funcion que retorna la informacion del catalogo general de la tabla par_catalogo


                        $this->obj->list->listae('identificacion',$MATRIZ,'tpidprov',$datos,'required','',$evento,'div-2-4');
                        
                        $this->obj->text->text_yellow('Nro.Identificacion',"texto",'idprov',13,13,$datos,'required','','div-2-4') ;
                        
                        $this->obj->list->listae('Naturaleza',$MATRIZ_P,'naturaleza',$datos,'required','',$evento,'div-2-4');
                        
                        $this->obj->list->listae('Estado',$MATRIZ_E,'estado',$datos,'required','',$evento,'div-2-4');
                        
                        $this->obj->list->listae('Tipo',$MATRIZ_M,'modulo',$datos,'','',$evento,'div-2-4');
                    
                        
                        $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
                        
                        
                        $this->obj->text->text_blue('Razon Social',"texto",'razon',100,100,$datos,'required','','div-2-10') ;
                        
                        $this->obj->text->text('Direccion',"texto",'direccion',180,180,$datos,'required','','div-2-10') ;
                        
                        $this->obj->text->text('Email',"email",'correo',40,45,$datos,'required','','div-2-4') ;

                        $this->obj->text->text('Telefono',"texto",'telefono',180,180,$datos,'required','','div-2-4') ;

                        $this->obj->text->text('Movil',"texto",'movil',180,180,$datos,'required','','div-2-4') ;
                    

                $this->set->div_label(12,'INFORMACION DEL CONTACTO'); // etiqueta  para un nuevo bloque de informacion
            
                
                        $this->obj->text->text('Contacto ',"texto",'contacto',40,45,$datos,'required','','div-2-4') ;
                        
                        $this->obj->text->text('Email',"email",'ccorreo',40,45,$datos,'required','','div-2-4') ;
                        
                        $this->obj->text->text('Telefono',"texto",'ctelefono',180,180,$datos,'required','','div-2-4') ;

                        $this->obj->text->text('Movil',"texto",'cmovil',180,180,$datos,'required','','div-2-4') ;

                
                $this->set->div_label(12,'CLASIFICACION DE CONTRIBUYENTE/CLIENTE'); // etiqueta  para un nuevo bloque de informacion


                $this->obj->list->listae('Categoria',$MATRIZ_S,'serie',$datos,'required','',$evento,'div-2-4');


                $this->obj->text->text('Foto',"texto",'grafico',180,180,$datos,'required','','div-2-4') ;


                          
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
                array( boton => 'Guardar Registros',        evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' , type=>"submit") ,
                array( boton => 'Actualizar  a proveedor ', evento =>$eventoi,  grafico => 'glyphicon glyphicon-user' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>