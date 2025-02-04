<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    /*Incluimos el fichero de la clase Db*/
  	
    require '../../kconfig/Obj.conf.php';    /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php';         /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
      private $obj;
      private $bd;
      private $set;
      
      private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $anio;
      /**
       Clase contenedora para la creacion del formulario de visualizacion
       @return
       **/
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
    
       }

      /**
       Clase contenedora para la creacion del formulario de visualizacion
       @return
       **/
     function Formulario( ){
      
     
    
        $datos              = array();

        $datos['fecha'] =  date("Y-m-d");
        $datos['fecha_recepcion'] =  date("Y-m-d");

 
        

        $tipo               = $this->bd->retorna_tipo();

        $resultado = $this->bd->ejecutar("SELECT '-' as codigo , '  -- 00 Seleccionar Responsable  -- ' as nombre union
                    SELECT email AS codigo,  completo as nombre
                    FROM par_usuario  where estado = 'S' and tarea = 'S' 
                    ORDER BY 2"   );

        
     $this->set->div_panel12('<b> REGISTRO DE INFORMACION  </b>');
         


          $this->obj->text->texto_oculto("id_especied",$datos);    

          
          $this->obj->text->texte('Fecha','date','fecha',30,30,$datos ,'required','readonly','','div-2-4') ;

          $this->obj->text->texte('Fecha Emision','date','fecha_recepcion',30,30,$datos ,'required','','','div-2-4') ;

         
          $this->obj->list->listadb($resultado,$tipo,'Responsable','sesiona',$datos,'required','','div-2-10');


          $this->obj->text->editor('Observacion','observacion',3,45,300,$datos,'required','','div-2-10') ;

          $this->obj->text->text('Referencia','texto','referencia_dato',120,120,$datos ,'required','','div-2-10') ;


          $this->obj->text->text_yellow('Nro.Inicio',"number" ,'inicio' ,80,80, $datos ,'required','','div-2-4') ;

          $this->obj->text->text_blue('Nro.Final',"number" ,'fin' ,80,80, $datos ,'required','','div-2-4') ;

          $this->obj->text->text_blue('Actual',"number" ,'actual' ,80,80, $datos ,'required','','div-2-4') ;

        

        
      $this->set->div_panel12('fin');
       
 
   }
  
    
  
 }
 
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
 
  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>
 