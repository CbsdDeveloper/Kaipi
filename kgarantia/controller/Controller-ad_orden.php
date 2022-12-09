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
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $anio;
      
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
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ad_orden.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
      
         $titulo = '';
         
         $datos = array();
         
 
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
        $tipo = $this->bd->retorna_tipo();
    
         
                $this->BarraHerramientas();
          
                
                $this->set->div_panel6('<b> INFORMACION ORDEN MOVILIZACION </b>');
                 
                
                        $this->obj->text->text('Id_orden',"number" ,'id_orden' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                        $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        $evento='';
                        $MATRIZ = array(
                            'solicitado'  => 'Solicitado',
                            'autorizado'  => 'Autorizado' 
                        );
                        $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'','',$evento,'div-2-10');
                        
                        $this->obj->text->text('Fecha Salida',"date" ,'fecha_orden' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        $this->obj->text->text('Hora Salida',"time" ,'hora_salida' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        $this->obj->text->editor('Motivo','motivo_traslado',4,45,550,$datos,'required','','div-2-10') ;
                        
                         
                        $this->obj->text->text_yellow('Origen',"texto" ,'origen' ,80,80, $datos ,'required','','div-2-10') ;
                        
                        $this->obj->text->text_yellow('Destino',"texto" ,'destino' ,80,80, $datos ,'required','','div-2-10') ;
                        
                $this->set->div_panel6('fin');
                
                
                $this->set->div_panel6('<b> INFORMACION DE UNIDAD SOLICITANTE</b>');
                
                    $resultado = $this->bd->ejecutar("select '-' as codigo , '  [  0. - Asignar Responsable - ]' as nombre union
                                                       SELECT cedula AS codigo, completo  as nombre
    													FROM par_usuario
                                                        where estado = ".$this->bd->sqlvalue_inyeccion('S',true)." AND
                                                              responsable = ".$this->bd->sqlvalue_inyeccion('S',true)."
                                                              ORDER BY 2 ");
                    
                    $evento = 'OnChange="Departamento_visor(this.value)"';
                    
                    $this->obj->list->listadbe($resultado,$tipo,'Solicita','id_prov_solicita',$datos,'required','',$evento,'div-2-10');
                    
                    $this->obj->text->text('Unidad','texto','unidad',10,10,$datos ,'','readonly','div-2-10') ;
             
                    $this->obj->text->text_yellow('Nro.Ocupantes',"number" ,'nro_ocupantes' ,80,80, $datos ,'required','','div-2-10') ;
                    
                  
                    $resultado = $this->bd->ejecutar("select '0' as codigo , '  [  0. - Asignar Vehiculo  -]' as nombre union
                                                       SELECT id_bien AS codigo, placa_ve || ' '  || descripcion  as nombre
    													FROM adm.view_bien_vehiculo
                                                        where estado <> ".$this->bd->sqlvalue_inyeccion('Baja',true)."  
                                                              ORDER BY 2 ");
                    
                    
                    $evento = 'OnChange="Vehiculo_visor(this.value)"';
                    
                    $this->obj->list->listadbe($resultado,$tipo,'Vehiculo','id_bien',$datos,'required','',$evento,'div-2-10');
                    
                    $this->obj->text->text('Nro.Placa','texto','placa',10,10,$datos ,'','readonly','div-2-10') ;
                    
                    $resultado = $this->bd->ejecutar("select '-' as codigo , '  [  Asignar Conductor ]' as nombre union
                                                       SELECT idprov AS codigo, razon  as nombre
    													FROM adm.view_adm_chofer
                                                        where estado = ".$this->bd->sqlvalue_inyeccion('S',true)."
                                                              ORDER BY 2 ");
                    
                   
                    
                    $this->obj->list->listadb($resultado,$tipo,'Conductor','id_prov_chofer',$datos,'required','','div-2-10');
                    
                    
                    $this->obj->text->text_yellow('Km.Salida',"number" ,'sale_km' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->set->div_panel6('fin');
                
                $this->set->div_label(12,' ');	 
         
                $this->set->div_panel6('<b> INFORMACION DE UNIDAD ADMINISTRATIVA</b>');
                
                     $this->obj->text->text_blue('Fecha Llegada',"date" ,'fecha_llegada' ,80,80, $datos ,'required','','div-2-4') ;
                     
                     $this->obj->text->text_blue('Hora LLegada',"time" ,'hora_llegada' ,80,80, $datos ,'required','','div-2-4') ;
                     
                
                     $this->obj->text->text_blue('Km.Llegada',"number" ,'llega_km' ,80,80, $datos ,'required','','div-2-10') ;
                
                     $this->obj->text->editor('Novedad','novedad',4,45,550,$datos,'required','','div-2-10') ;
                     
                
                     $resultado = $this->bd->ejecutar("select '0' as codigo , '  [  Enlazar Orden de Combustible ]' as nombre");
                     
                     
                     
                     $this->obj->list->listadb($resultado,$tipo,'No.Combustible','id_combus',$datos,'required','','div-2-10');
                     
                     
                $this->set->div_panel6('fin');
               
                       
               $this->obj->text->texto_oculto("action",$datos); 
         
               $this->obj->text->texto_oculto("id_tramite",$datos);
               
         
      
               
          
         
         $this->set->evento_formulario('-','fin'); 
 
  
 
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 function K_ejecuta_detalle($div){
    
  echo '<script type="text/javascript"> goToPrecio(); </script>';
 
 
  } 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
       $formulario_reporte = '../reportes/orden_movilizacion';
       
       $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
       
       
       $eventoe = "javascript:anular_orden()";
       
       
       $ToolArray = array(
           array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
           array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
           array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
           array( boton => 'Anular Orden', evento =>$eventoe,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger")
       );
       
       $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    //----------------------------------------------
     
 
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
 
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
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
												$("#idprov").val('...');
											},
											success:  function (response) {
												$("#idprov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
 
  
</script>
 
  