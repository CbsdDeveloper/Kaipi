<script >

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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-dependencia.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
      //---------------------------------------
      
     function Formulario( ){
      
   
        $titulo ='';
        
        $datos = array();
        
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                   
                $this->set->div_panel('<b> INFORMACION PERSONAL </b>');
                
                    $this->obj->text->text('Nro.Anexo','number','id_redep',10,10, $datos ,'','readonly','div-2-4') ;
                    
                    
                    $MATRIZ = $this->obj->array->catalogo_anio();
                    $evento = '';
                    $this->obj->list->listae('Periodo',$MATRIZ,'anio',$datos,'required','',$evento,'div-2-4');
                
                    $this->obj->text->texto_oculto("bengalpg",$datos); 
                    $this->obj->text->texto_oculto("estab",$datos); 
                    $this->obj->text->texto_oculto("paisresidencia",$datos); 
                    $this->obj->text->texto_oculto("aplicaconvenio",$datos); 
                    
                     
                    $MATRIZ = $this->obj->array->catalogo_si();
                    $this->obj->list->listae('Enfermedad Catrastrofica',$MATRIZ,'enfcatastro',$datos,'required','',$evento,'div-2-4');
                    
                    
                    
                    $MATRIZ = $this->obj->array->catalogo_Residencia();
                    $this->obj->list->listae('Residencia',$MATRIZ,'residenciatrab',$datos,'required','',$evento,'div-2-4');
                    
                     
                    $MATRIZ = $this->obj->array->catalogo_tpPersonal();
                    $this->obj->list->listae('Tipo Identificacion',$MATRIZ,'tipidret',$datos,'required','',$evento,'div-2-4');
                    
                    $this->obj->text->text('Identificacion',"texto" ,'idret' ,13,13, $datos ,'required','','div-2-4') ;
                    
                    $evento = 'onchange="javascript:validarCiu()"';
                    $this->obj->text->texte('Apellido',"texto" ,'apellidotrab' ,80,80, $datos ,'required','',$evento,'div-2-4') ;
                    $this->obj->text->text('Nombre',"texto" ,'nombretrab' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->texto_oculto("tipotrabajdiscap",$datos);
                    $this->obj->text->texto_oculto("porcentajediscap",$datos);
                    $this->obj->text->texto_oculto("tipiddiscap",$datos);
                    $this->obj->text->texto_oculto("iddiscap",$datos); 
                  
                    $evento = '';
                 $this->set->div_panel('fin');
             
                 
                 
                 $this->set->div_panel('<b> INGRESOS PERSONAL </b>');
                
                 
                 $this->obj->text->text_yellow('Sueldos y Salarios',"number" ,'suelsal' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_yellow('Sobresueldos y otros',"number" ,'sobsuelcomremu' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_yellow('Participacion util',"number" ,'partutil' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_yellow('Ingresos gravados generados con otros empleadores',"number" ,'intgrabgen' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_yellow('Impuesto a la renta asumido por este empleador',"number" ,'imprentempl' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Decimo tercer sueldo',"number" ,'decimter' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Decimo cuarto sueldo',"number" ,'decimcuar' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Fondo reserva',"number" ,'fondoreserva' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text('Salario digno',"number" ,'salariodigno' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text('Otros ingresos en relacion de dependencia',"number" ,'otrosingrengrav' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text('Ingresos gravadas con este empleador',"number" ,'inggravconesteempl' ,80,80, $datos ,'required','','div-6-6') ;
                 
               
              
                 $this->set->div_panel('fin');
                
               
                 $this->set->div_panel('<b> GASTOS, DEDUCCIONES Y EXONERACIONES </b>');
                 
                 $MATRIZ = $this->obj->array->catalogo_SalarioNeto();
                 $this->obj->list->listae('Sistema de salario neto',$MATRIZ,'sissalnet',$datos,'required','',$evento,'div-6-6') ;
                 
                 $this->obj->text->text('Aporte personal IESS con este empleador',"number" ,'apoperiess' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text('Aporte personal IESS con otros empleadores',"number" ,'aporperiessconotrosempls' ,80,80, $datos ,'required','','div-6-6') ;
             
                 $this->set->div_label(12,'DEDUCCIONES GASTOS PERSONALES ');	 
                 
                 $this->obj->text->text_blue('Vivienda',"number" ,'deducvivienda' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Salud',"number" ,'deducsalud' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Educacion',"number" ,'deduceducartcult' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Alimentacion',"number" ,'deducaliement' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Vestimenta',"number" ,'deducvestim' ,80,80, $datos ,'required','','div-6-6') ;
                 $this->obj->text->text_blue('Turismo',"number" ,'deduturismo' ,80,80, $datos ,'required','','div-6-6') ;

                 

               
                $this->set->div_label(12,'EXONERACIONES ');	 
                
                $this->obj->text->text('Discapacidad',"number" ,'exodiscap' ,80,80, $datos ,'required','','div-6-6') ;
                $this->obj->text->text('Tercera Edad',"number" ,'exotered' ,80,80, $datos ,'required','','div-6-6') ;
               
                $this->set->div_label(12,'RESUMEN IMPOSITIVO ');	 
                
                $this->obj->text->text_yellow('Base Imponible',"number" ,'basimp' ,80,80, $datos ,'required','','div-6-6') ;

                $this->obj->text->text_blue('Rebaja Gastos Personales',"number" ,'rebajagapersona' ,80,80, $datos ,'required','','div-6-6') ;
                $this->obj->text->text_blue('Impuesto Rebaja Gastos Personales',"number" ,'imprebajagapersona' ,80,80, $datos ,'required','','div-6-6') ;

 

                $this->obj->text->text('Impuesto a la renta causado',"number" ,'imprentcaus' ,80,80, $datos ,'required','','div-6-6') ;
                $this->obj->text->text('Impuesto retenido y asumido por otros empleadores',"number" ,'valretasuotrosempls' ,80,80, $datos ,'required','','div-6-6') ;
                $this->obj->text->text('Impuesto asumido por este empleador',"number" ,'valimpasuesteempl' ,80,80, $datos ,'required','','div-6-6') ;
                $this->obj->text->text('Impuesto retenido al trabajador',"number" ,'valret' ,80,80, $datos ,'required','','div-6-6') ;
                
                
                $this->set->div_panel('fin');
              
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 //-------------
   
   
   //-------------------------------
   
     //----------------------------------------------
   function BarraHerramientas(){
 
       $eventof = "javascript:Imprime107()";
       
       $eventoe = "javascript:goToURLCalculo(1)";
       $eventoa = "javascript:goToURLCalculo(2)";
       $eventob = "javascript:goToURLCalculo(3)";
   	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Ficha 107', evento =>$eventof,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Calcular Base Impuesto a la renta', evento =>$eventoe,  grafico => 'glyphicon glyphicon-pencil' ,  type=>"button_default"),
                array( boton => 'Enlace Base Impuesto a la renta', evento =>$eventoa,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button_danger"),
                array( boton => 'Calcular Base Rebaja de Gastos', evento =>$eventob,  grafico => 'glyphicon glyphicon-retweet' ,  type=>"button_info"),
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
   
  $gestion->Formulario( );
  
 ?>
 <script type="text/javascript">

 jQuery.noConflict(); 
 
  
//--------------------------
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        	//	console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#razon").focusout(function(){
	 
	 var itemVariable = $("#razon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											beforeSend: function () {
												$("#idcliente").val('...');
											},
											success:  function (response) {
												$("#idcliente").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
	       
</script>
  