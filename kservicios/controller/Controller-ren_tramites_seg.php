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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');
     
               $this->evento_form = '../model/Model-ren_frecuencias.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
     
 
 
                $datos              = array();

                $datos['fecha_seg'] =  date("Y-m-d");

                $datos['hora'] =  date("H:s");

                

                $tipo               = $this->bd->retorna_tipo();

                $resultado = $this->bd->ejecutar("SELECT '-' as codigo , '  -- 00 Seleccionar Responsable  -- ' as nombre union
                            SELECT email AS codigo,  completo as nombre
                            FROM par_usuario  where estado = 'S' and tarea = 'S' 
                            ORDER BY 2"   );

                
             $this->set->div_panel12('<b> REGISTRO DE INFORMACION  </b>');
                 
 

                  $this->obj->text->texto_oculto("id_tramite_seg",$datos);   // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql

                  
                  $this->obj->text->texte('Fecha','date','fecha_seg',30,30,$datos ,'required','','','div-2-4') ;

                  $this->obj->text->text('Hora',"time" ,'hora' ,80,80, $datos ,'required','','div-2-4') ;

                 
                  $this->obj->list->listadb($resultado,$tipo,'Responsable','responsable_seg',$datos,'required','','div-2-10');


                  $this->obj->text->editor('Novedad','novedad_seg',3,45,300,$datos,'required','','div-2-10') ;

                  $this->obj->text->editor('Accion Ejecutada','accion_seg',3,45,300,$datos,'required','','div-2-10') ;
                
  
            

                
              $this->set->div_panel12('fin');

    
      
   }
  
   
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>