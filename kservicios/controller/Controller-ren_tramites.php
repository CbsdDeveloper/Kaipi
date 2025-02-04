<script type="text/javascript" src="formulario_result.js"></script> 
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
                
    
               $this->evento_form = '../model/Model-ren_tramites.php';         
      }

      /**
       Clase contenedora para la creacion del formulario de visualizacion
       @return
       **/
     function Formulario( ){
      
     
         $MATRIZ_C =  $this->obj->array->catalogo_sino();
         $datos    = array();
  
         $this->set->_formulario( $this->evento_form,'inicio' ); 
  
  
       
                $this->BarraHerramientas();
                
                $this->set->div_panel6('<b>1. INFORMACION PRINCIPAL </b>');
                
                        $this->obj->text->text_yellow('<b>Servicios</b>',"texto" ,'referencia' ,85,85, $datos ,'required','readonly','div-2-10') ;
                        
                        $this->obj->text->text_blue('Nro.Transaccion',"number",'id_ren_tramite',0,10,$datos,'','readonly','div-2-10') ;

                        $this->obj->text->text_yellow('Nro.Comprobante',"texto",'comprobante',0,10,$datos,'','readonly','div-2-10') ;
                        
                        $this->obj->text->text_blue('Estado',"texto" ,'estado' ,5,5, $datos ,'required','readonly','div-2-4') ;
                        
                        $this->obj->text->text('Fecha Inicio',"date" ,'fecha_inicio' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        $this->obj->text->text('Fecha Emision',"date" ,'fecha_cierre' ,80,80, $datos ,'','readonly','div-2-4') ;

                        $this->obj->text->text('Año Pago',"number" ,'apago' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                $this->set->div_panel6('fin');
                
                $this->set->div_panel6('<b>2. SOLICITA SERVICIO </b>');
                
                        $this->obj->text->textautocomplete('<b>Identificacion</b>','texto','idprov',13,13,$datos ,'required',' ','div-2-4') ;
                        
                        $this->obj->text->text('CIU',"number" ,'id_par_ciu' ,80,80, $datos ,'required','readonly','div-2-4') ;
                        
                        $cboton2 = '<a href="#" onClick="Actualiza_ciu()" title="Actualizar informacion contribuyente"><b>Razon Social</b></a>';
                        
                        
                        $this->obj->text->textautocomplete($cboton2,"texto",'razon',40,45,$datos,'required','','div-2-10');
                        
                        
                        $this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','','div-2-10') ;
                        
                        $this->obj->text->text('Correo Electronico','texto','correo',120,120,$datos ,'required','','div-3-9') ;

                        $this->obj->text->text('Contacto/Representante Legal','texto','contacto',120,120,$datos ,'required','','div-3-9') ;
                
                $this->set->div_panel6('fin');
                
                
                $this->obj->text->texto_oculto("id_rubro",$datos);


                $this->set->div_panel6('<b>3. MONTOS COMPLEMENTARIOS </b>');
                
                $this->obj->text->text('Monto',"number" ,'base' ,80,80, $datos ,'required','','div-2-4') ;
                 
                $this->obj->list->lista('Aplica Multa',$MATRIZ_C,'multa',$datos,'required','','div-2-4');
                

                $this->obj->text->text('Fecha Pago',"date" ,'fecha_pago' ,80,80, $datos ,'','readonly','div-2-4') ;

            
                
                $this->set->div_panel6('fin');

                
                 
                $this->set->div_panel6('<b>4. INFORMACION DEL SERVICIO </b>');
                
                        $this->obj->text->editor('Detalle','detalle',2,45,350,$datos,'required','','div-2-10') ;
                        
                        $this->obj->text->editor('Resolucion','resolucion',2,45,350,$datos,'required','','div-2-10') ;
                        
                $this->set->div_panel6('fin');
                
                

                
                
           
               echo '<div class="col-md-12"><div id="ViewFormDetalle"> </div></div>';
                
                 
         $this->obj->text->texto_oculto("action",$datos); 
 
         
         $this->set->_formulario('-','fin'); 
 
   }
  
   /**
    Clase contenedora para la creacion del formulario de visualizacion
    @return
    **/
  
  function BarraHerramientas(){
 
   $formulario_reporte   = '../reportes/requerimiento';
   $eventoi              = "imprimir_informe('".$formulario_reporte."')";

   $formulario_impresion = '../view/cliente';
   $eventoc              = 'javascript:openView('."'".$formulario_impresion."')";
   

   $formulario_reporte1   = '../reportes/requerimientopdf';

   $eventop1    = "imprimir_informe('".$formulario_reporte1."')";


    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Descargar Informe', evento =>$eventop1,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button_info"),
                array( boton => 'Crear Contibuyentes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
  
 }
 
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
 
  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>
 <script type="text/javascript" src="formulario_ciu.js"></script> 