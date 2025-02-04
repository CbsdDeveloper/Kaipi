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
     
               $this->evento_form = '../model/Model-par_reporte.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
       /*
      //Construye la pantalla de ingreso de datos
      */
      
     function Formulario( ){


        $tipo   = $this->bd->retorna_tipo();
  
        $datos      = array();


           $this->set->_formulario( $this->evento_form,'inicio' ); 

    
                $this->BarraHerramientas();
              
                $this->set->div_panel7('<b> Información del reporte </b>');

                $this->obj->text->text_blue('Id',"number",'idreporte_sis',100,100,$datos,'required','readonly','div-2-10');
               
                $this->obj->text->text_yellow('Nombre',"texto",'nombre',100,100,$datos,'required','','div-2-10');
 
                $resultado =$this->bd->ejecutar("SELECT '' as codigo, '-- 00.Todos los modulos --' as  nombre   union 
                                                 SELECT modulo as codigo, modulo from par_modulos  where fid_par_modulo=0  order by 2 ");

                $this->obj->list->listadb($resultado,$tipo,'Modulo','modulo',$datos,'required','','div-2-10');
                          
                $this->obj->text->text('Referencia',"texto",'referencia',6,6,$datos,'required','','div-2-10');

                $this->obj->text->text('Archivo',"texto",'archivo',100,100,$datos,'required','','div-2-10');
                
                $this->obj->text->text('Ruta',"texto",'ruta',40,45,$datos,'required','','div-2-10');                
                
               

                $this->obj->text->texto_oculto("action",$datos); 

                $this->set->div_panel7('fin');
                
            
                $this->set->div_panel5('<b> Indicaciones </b>');

                echo 'Esta seccion permite tener un catalogo de reportes de la plataforma por modulos, adicional permite configurar las firmas y pie de firmas de los reportes';

                echo '<br><br>VARIABLES<br>';

                echo '#CEDULA      = cedula del funcionario<br>';
                echo '#FUNCIONARIO = nombre del funcionario<br>';

              
                $this->set->div_panel5('fin');
                 
                 
                 $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
   
       
    $ToolArray = array( 
                
               array( boton => 'Nuevo Regitros',            evento =>'', grafico => 'icon-white icon-plus' ,             type=>"add"),
                array( boton => 'Guardar Registros',        evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' , type=>"submit") ,
                
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   

  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  