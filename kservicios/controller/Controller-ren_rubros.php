<script type="text/javascript" src="formulario_result.js"></script> 	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_ren_rubros {
   
      private $obj;
      private $bd;
      private $set;
      
     private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function Controller_ren_rubros( ){
  
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
    
               $this->evento_form = '../model/Model-ren_rubro.php';
      }
      /**
       Funcion para desplegar la barra de herramientas guardar, nuevo, edicion y procesos en el formulario
       @return
       **/ 
     function Formulario( ){
      
          
         $datos  = array();
         $tipo   = $this->bd->retorna_tipo();

         
         $MATRIZ =  $this->obj->array->catalogo_activo();
         
         $MATRIZ_A = array(
             'N'    => 'No Tributarios',
             'S'    => 'Tributarios'
         );
         
         $MATRIZ_P = array(
             'mensual'    => 'mensual',
             'anual'    => 'anual',
             'unico'    => 'unico'
         );
 
         $MATRIZ_M = array(
             'proceso'    => 'proceso',
             'unico'    => 'unico',
             'modulo'    => 'modulo'
         );
         
         
         $this->set->_formulario( $this->evento_form,'inicio' ); 
  
         
                $this->BarraHerramientas();
          
                $this->obj->text->text_blue('Id',"number",'id_rubro',0,10,$datos,'','readonly','div-2-4') ; 
                
               
                $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                $this->obj->text->text_yellow('Detalle',"texto" ,'detalle' ,80,80, $datos ,'required','','div-2-10') ;
                $this->obj->text->editor('Resolucion','resolucion',3,45,350,$datos,'required','','div-2-10') ;
         
                
                $this->obj->list->lista('Tipo',$MATRIZ_A,'modulo',$datos,'','','div-2-4');
                $this->obj->list->lista('Periodo',$MATRIZ_P,'periodo',$datos,'','','div-2-4');
                $this->obj->list->lista('Acceso',$MATRIZ_M,'acceso',$datos,'','','div-2-4');
                
                
                $resultado = $this->bd->ejecutar("select 0 as codigo , '  [  No aplica ]' as nombre union
                                                   SELECT id_departamento AS codigo,  nombre
													FROM nom_departamento
                                                    where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc ,true)."
                                                           ORDER BY 2");
                
                
                $this->obj->list->listadb($resultado,$tipo,'Inicia en','id_departamento',$datos,'required','','div-2-4');
                

                $this->obj->text->text_blue('Reporte',"texto" ,'reporte' ,80,80, $datos ,'required','','div-2-4') ;

                $this->obj->text->text_blue('Sigla',"texto" ,'sigla' ,20,20, $datos ,'required','','div-2-4') ;
                        
                $this->obj->text->texto_oculto("action",$datos); 
           
  
                $this->set->div_label(12,'<b>Parametros de cobro</b>');	 
      
         
              $this->set->_formulario('-','fin'); 
         
  
  
 
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 function K_ejecuta_detalle($div){
    
  echo '<script type="text/javascript"> goToPrecio(); </script>';
 
 
  } 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
  
   }
 
   
   //------------------------------------------------------------------------
   // Llama de la clase para creacion de formulario de busqueda
   //------------------------------------------------------------------------
   
   
  
   $gestion   = 	new Controller_ren_rubros;
  
   
  $gestion->Formulario( );
  
 ?>
 
  