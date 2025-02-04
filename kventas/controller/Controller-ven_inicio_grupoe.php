<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fat, #fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
              jQuery('#result').html(data);

           	 jQuery( "#result" ).fadeOut( 1600 );

           	 jQuery("#result").fadeIn("slow");
            
			}
        })        
        return false;
    }); 
 })
</script>	
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");    	
        
                
               $this->formulario = 'Model-ven_inicio.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //--------------------------
      function _diaMes() {
          $month = date('m');
          $year = date('Y');
          return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
      }
      //---------------------------------------
      
      function Formulario( $id ){
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
        $datos["acceso"] = 'Banco de Datos';
        $datos["detalle"] = 'Envio de informacion';
        $datos["fecha_email"] = $this->hoy 	;
        
        
        $Campana = $this->bd->query_array(
            'ven_campana',
            'envio_email, tipo_envio, plantilla, fecha_email, contactos, estado, asunto', 
            'id_campana='.$this->bd->sqlvalue_inyeccion($id,true));
 
 
        $datos["envio_email"] = $Campana["envio_email"] ;
        $datos["plantilla"] = $Campana["plantilla"] ;
        $datos["asunto"] = $Campana["asunto"] ;
        $datos["tipo_envio"] = $Campana["tipo_envio"] ;
        
        $datos["fecha_email"] = $Campana["fecha_email"] ;
       
        
                $this->BarraHerramientas();
                     
                $tipo = $this->bd->retorna_tipo();
            
   
                $this->set->div_panel6('<b> DATOS DE GESTION </b>');
                
                  $this->set->div_label(12,'<h5><b>1. Configuracion Envio</b> </h5>');
                
                
                echo ' 
                <div class="col-md-12"> 
                <h5><b></b></h5>
                       <div class="alert alert-warning">
                        <div class="row">';
               
               
                        $MATRIZ = array(
                            '2'    => '2 destinatarios',
                            '4'    => '4 destinatarios',
                            '8'    => '8 destinatarios'
                         );
                        $this->obj->list->listae('Enviar x min ',$MATRIZ,'envio_email',$datos,'required','',$evento,'div-2-10');
                 
                        
                        $resultado =$this->bd->ejecutar("SELECT id_plantilla as codigo, titulo as nombre
                                                            FROM  ven_plantilla
                                                            where publicar = 'S' and tipo in (1,2) order by 1" );
                        
                        $evento = '';
                        
                        
                        $this->obj->list->listadbe($resultado,$tipo,'Plantilla','plantilla',$datos,'','',$evento,'div-2-10');
                        
                        
                        $this->obj->text->editor('<b>ASUNTO </b>','asunto',2,45,300,$datos,'required','','div-2-10') ;
                        
                        
                        
                        $MATRIZ = array(
                            'Personal'    => 'Personal',
                            'Empresa'    => 'Empresa',
                            'Gmail'    => 'Personal Gmail',
                            'Administrador'    => 'Administrador' 
                        );
                        $this->obj->list->listae('SMTP Envio',$MATRIZ,'tipo_envio',$datos,'required','',$evento,'div-2-10');
                        
                        
                        $this->obj->text->text_date('Fecha Inicio',$this->_diaMes()  ,'fecha_email' ,80,80, $datos ,'required','','div-2-10') ;
                        
              echo '</div>
                    </div>
                  </div>';
        
             
              
              $cboton = '<a href="#" onClick="CrearCampanaEmail()"
                             class="btn btn-success btn-sm"
                              role="button"> Generar informacion </a> &nbsp;

                       <a href="#" onClick="IniciarCampanaEmail()"
                             class="btn btn-default btn-sm"
                              role="button"> Iniciar Envio </a>';
              
       
              echo  '<h4 align="center"><b>'.'Estado actual: '.strtoupper($Campana["estado"]) .'</b></h4>';
              
              
              $this->set->div_label(12,'<h6>'.$cboton.' </h6>');
              
              $this->set->div_panel6('fin');
              
              
              $this->set->div_panel6('<b> EDICION DE GESTION POTENCIAL CLIENTE </b>');
              
              
              
              $this->obj->text->text('Sector ',"texto",'canton',90,95,$datos,'','readonly','div-2-10') ;
              
              $this->obj->text->text('Nro.Identificacion',"texto",'idprov',13,13,$datos,'','','div-2-10') ;
              
              $this->obj->text->text('<b>Razon Social</b>',"texto",'razon',80,95,$datos,'required','','div-2-10') ;
              
              $this->obj->text->text('Direccion',"texto",'direccion',80,95,$datos,'required','','div-2-10') ;
              
              
              $this->obj->text->text('Email',"email",'correo',60,75,$datos,'','','div-2-10') ;
              
              
              $reg ="\d{2}[\-]\d{4}[\-]\d{3}";
              $reg ="";
              $this->obj->text->textMask('Telefono',"tel",'telefono',18,20,$datos,'','','',$reg,'div-2-10');
              
              $reg ="\d{3}[\-]\d{4}[\-]\d{3}";
              $reg ="";
              
              $this->obj->text->textMask('Movil',"tel",'movil',18,20,$datos,'','','',$reg,'div-2-10');
              
              
              $this->obj->text->text('Contacto ',"texto",'contacto',90,95,$datos,'required','','div-2-10') ;
              
              $this->obj->text->text('web ',"texto",'web',40,45,$datos,'required','','div-2-10') ;
              
              $this->set->div_panel6('fin');
            
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("idvencliente",$datos); 
         
         $this->obj->text->texto_oculto("idcampana_1",$datos); 
         
         $this->obj->text->texto_oculto("estado",$datos); 
         
       
         
         $this->obj->text->texto_oculto("acceso",$datos);
         
         $this->obj->text->texto_oculto("detalle",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
         
         
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
         
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
  if (isset($_GET['id']))	{
      
 
      $id        = $_GET['id'];
      
 
      $gestion->Formulario($id );
  }
   
 
  
 ?>
 
  