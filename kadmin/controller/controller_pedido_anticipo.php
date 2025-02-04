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
               
              jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');
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
      private $anio;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-pedido_anticipo.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;       
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
     
      //---------------------------------------
      
     function Formulario( ){
      
  
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
                $datos = array();
    
                $this->BarraHerramientas();

               
                $datos = $this->bd->query_array('view_nomina_user',   // TABLA
	                                '*',                        // CAMPOS
	                                'sesion_corporativo='.$this->bd->sqlvalue_inyeccion(  $this->sesion,true) // CONDICION
	           );

 
               $MATRIZ = array(
                '1'    => '1 Mes',
                '2'    => '2 Meses',
                '3'    => '3 Meses',
                '4'    => '4 Mes',
                '5'    => '5 Meses',
                '6'    => '6 Meses',
                '7'    => '7 Mes',
                '8'    => '8 Meses',
                '9'    => '9 Meses',
                '10'    => '10 Meses',
                '11'    => '11 Meses'
               );

 
               $mes             = intval(  date("m") ) ;

               for ($x =    $mes; $x <= 12; $x++) {

                  $mes = $this->bd->_mes($x);

                  $MATRIZ_D[$x]  = $mes; 
   
                }

 
         
               $datos['fecha']  =  date("Y-m-d");
               $datos['rige']   =  $mes;
               

               $evento = 'Onchange="calculaMes(this.value)"';
     
               $this->set->div_panel6('<b>Información Solicitante</b>');
                
                         
                        $this->obj->text->text_blue('<b>Funcionario</b>',"texto",'razon',40,45,$datos,'required','readonly','div-2-10');
                        
                        $this->obj->text->text_blue('<b>Identificacion</b>','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;

                        $this->obj->text->text_blue('<b>Unidad</b>',"texto",'unidad',40,45,$datos,'required','readonly','div-2-10');

                        $this->obj->text->text_blue('<b>Cargo</b>',"texto",'cargo',40,45,$datos,'required','readonly','div-2-4');

                        $this->obj->text->text_blue('<b>Remuneracion</b>','number','sueldo',10,10,$datos ,'','readonly','div-2-4') ;
                        
                        $this->obj->text->text('Estado','texto','estado',10,10,$datos ,'','readonly','div-2-4') ;

                        $this->obj->text->text('Documento','texto','documento',10,10,$datos ,'','readonly','div-2-4') ;
                      
                $this->set->div_panel6('fin');
                
               
                $this->set->div_panel6('<b>Información Financiera</b>');
             
                $this->obj->text->text_blue('Codigo','number','id_anticipo',10,10,$datos ,'','readonly','div-2-4') ;
                    
                $this->obj->text->text_blue('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
                    
                $this->obj->text->editor('Motivo','detalle',4,75,500,$datos,'required','','div-2-10') ;
                    
                $this->obj->text->text_yellow('Anticipo de',"number" ,'solicita' ,80,80, $datos ,'required','','div-2-4') ;
            
                $this->obj->list->listae('Plazo',$MATRIZ,'plazo',$datos,'required','',$evento,'div-2-4');
                
                $this->obj->text->text_blue('Cuota',"number" ,'mensual' ,80,80, $datos ,'required','readonly','div-2-4') ;

                $this->obj->list->lista('Rige',$MATRIZ_D,'rige',$datos,'required','disabled','div-2-4');


                $this->set->div_panel6('fin');

  
                
                $this->set->div_panel6('<b>Selección de Garante</b>');
      
                                            
                        $this->obj->text->textautocomplete('Garante',"texto",'razon_g',40,45,$datos,'required','','div-2-10');
                                    
                        $this->obj->text->text('Identificacion','texto','idprov_ga',10,10,$datos ,'','readonly','div-2-10') ;

                        $this->obj->text->text_blue('Unidad',"texto",'unidad_g',40,45,$datos,'required','readonly','div-2-10');

                        $this->obj->text->text_blue('Cargo',"texto",'cargo_g',40,45,$datos,'required','readonly','div-2-4');

                        $this->obj->text->text_blue('Remuneracion','number','sueldo_g',10,10,$datos ,'','readonly','div-2-4') ;
                 
                 
               $this->set->div_panel6('fin'); 
                 


               $this->set->div_panel6('<b>Observaciones/Novedades</b>');
      
               echo '<h4>Cumplido los pasos anteriores el formulario debe ser ENVIADO a la Dirección de Administración de Recursos Humanos para ';
               echo 'su registro y posterior a la Dirección Financiera para su autorización y contabilización.</h4>';

               $this->obj->text->editor('Comentario','novedad',6,75,500,$datos,'required','readonly','div-2-10') ;
        
              $this->set->div_panel6('fin'); 
             
                      
              $this->obj->text->texto_oculto("action",$datos); 
         
          
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
  
 
   
    $formulario_reporte = '../../reportes/SolicitudAnticipo';
   
    $eventoi = "openFile('".$formulario_reporte."')";

    $eventop = "enviar_notificacion()";
     
    $array   =$this->bd->__user( $this->sesion 	) ;

    
     $ToolArray = array( 
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                 array( boton => 'NOTIFICAR SOLICITUD', evento =>$eventop, grafico => 'glyphicon glyphicon glyphicon-send' ,  type=>"button_danger") 
                 );
                   
    $this->obj->boton->ToolMenuDiv($ToolArray); 

 
  }  
  
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>

<script type="text/javascript">

 jQuery.noConflict(); 
 
 jQuery('#razon_g').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU_a.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#razon_g").focusout(function(){
	 
	 var itemVariable = $("#razon_g").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIUNom_accion.php',
											type:  'GET' ,
											dataType: "json",
											success:  function (response) {
												
													 $("#idprov_ga").val( response.a );  
													 
													 $("#unidad_g").val( response.b );  

                                                     $("#cargo_g").val( response.c );  

                                                     $("#sueldo_g").val( response.d );  
     
													    
											} 
									});
	 
    });
 
 
</script>
  