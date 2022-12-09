  <script type="text/javascript" src="formulario_result.js"></script> 
<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
     
               $this->evento_form = '../model/Model-web_auditoria.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
       /*
      //Construye la pantalla de ingreso de datos
      */
      
     function Formulario( ){
           $this->set->_formulario( $this->evento_form,'inicio' ); 
    
            $this->BarraHerramientas();
                     
               
                
              $MATRIZ_A = array(
          '-'  => 'No Aplica',
          'AGREGA'                     => 'AGREGA',
          'APROBACION'                 => 'APROBACIÓN',
          'EDICION'                    => 'EDICION',
          'ACTUALIZACION'              => 'ACTUALIZACION',
          'DIGITADO'                   => 'DIGITADO',
          'ANULADO'                    => 'ANULADO'
          
        
      );
        $MATRIZ_B = array(
          '-'  => 'No Aplica',
          'PRESUPUESTO'               => 'PRESUPUESTO',
          'CONTROL'                   => 'CONTROL',
          'TESORERIA'                 => 'TESORERIA',
          'NOMINA-PRESUPUESTO'        => 'NOMINA-PRESUPUESTO'
          
            
      );
            
              $this->set->div_panel7('<b> Información de auditoría </b>');

              $this->obj->text->text('Id ',"texto",'id_audita',100,100,$datos,'required','readonly','div-2-4') ;
                 
              $this->obj->text->text('Transaccion',"number",'transaccion',100,100,$datos,'required','','div-2-4') ;

              $this->obj->list->listae('Accion',$MATRIZ_A,'accion',$datos,'required','',$evento,'div-2-4') ;
            
              $this->obj->list->listae('Modulo',$MATRIZ_B,'modulo',$datos,'required','',$evento,'div-2-4') ;
               
              $this->obj->text->text_dia('Fecha',"texto",'fecha',100,100,$datos,'required','','div-2-4') ;

              $this->obj->text->text('Texto',"texto",'texto',100,100,$datos,'required','','div-2-4') ;

              $this->obj->text->text('Sesion',"texto",'sesion',100,100,$datos,'required','','div-2-4') ;
                       
              $this->obj->text->text('Hora',"texto",'hora',100,100,$datos,'required','','div-2-4') ;
                
              $this->obj->text->text('Tabla',"texto",'tabla',100,100,$datos,'required','','div-2-4') ;

              $this->obj->text->text_dia('Fecha modificacion',"texto",'fmodificacion',100,100,$datos,'required','','div-2-4') ;     

               $this->set->div_panel7('fin');
            
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
      
    $ToolArray = array( 
                
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  

  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  