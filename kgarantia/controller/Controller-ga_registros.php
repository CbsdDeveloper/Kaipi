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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ga_registros.php'; 
   
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
          
                
                $this->obj->text->text('Codigo',"number" ,'idcontrato' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                $this->obj->text->text_yellow('Nro Contrato',"texto" ,'nro_contrato' ,80,80, $datos ,'required','readonly','div-2-4') ;
                 
                $evento='';
                $MATRIZ = array(
                    'Bien'  => 'Bien',
                    'Servicios'  => 'Servicios',
                    'Obra Publica'  => 'Obra Publica'
                );
                $this->obj->list->listae('Tipo',$MATRIZ,'tipo_contratacion',$datos,'','disabled',$evento,'div-2-10');
                
                  
                $MATRIZ = $this->obj->array->catalogo_compras();
                $this->obj->list->listae('Proceso',$MATRIZ,'forma_contratacion',$datos,'','disabled',$evento,'div-2-10');
                
                
                $this->obj->text->editor('Objeto','detalle_contrato',3,45,550,$datos,'required','readonly','div-2-10') ;
                
                $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                
                $this->set->div_label(12,'<b>Informacion Adicional</b>');	
                
           
                $this->obj->text->textautocomplete('Proveedor/Contratista',"texto",'razon',40,45,$datos,'required','readonly','div-2-4');
                
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                
                $this->obj->text->text_blue('Monto Contrato',"number" ,'monto_contrato' ,80,80, $datos ,'required','readonly','div-2-4') ;
                $this->obj->text->text('Plazo(dias)',"number" ,'dias_vigencia' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                
                $this->obj->text->text('Fecha Inicio',"date" ,'fecha_inicio' ,80,80, $datos ,'required','readonly','div-2-4') ;
                $this->obj->text->text('Fecha Fin',"date" ,'fecha_fin' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                
                $this->obj->text->editor('Forma Pago','canticipo',3,45,550,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text_yellow('Monto Anticipo',"number" ,'monto_anticipo' ,80,80, $datos ,'required','','div-2-4') ;
                 
              
                
                $this->set->div_label(12,'<b>Informacion Unidad requirente</b>');	
                 
                
                $resultado = $this->bd->ejecutar("select 0 as codigo , '  [  Unidad Responsable ]' as nombre union
                                                   SELECT id_departamento AS codigo,  nombre
													FROM nom_departamento
                                                    where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc ,true) ."
                                                     ORDER BY 2");
                
      
               $this->obj->list->listadb($resultado,$tipo,'Unidad','iddepartamento',$datos,'required','disabled','div-2-4');
                
 
               $resultado = $this->bd->ejecutar("select '-' as codigo , '  [  Asignar Responsable ]' as nombre union
                                                   SELECT email AS codigo, completo  as nombre
													FROM par_usuario
                                                    where estado = ".$this->bd->sqlvalue_inyeccion('S',true)." AND
                                                          responsable = ".$this->bd->sqlvalue_inyeccion('S',true)." 
                                                          ORDER BY 2 ");
               
               $this->obj->list->listadb($resultado,$tipo,'Responsable','sesion_responsable',$datos,'required','disabled','div-2-4');
                
                
               $this->set->div_label(12,'<b>Informacion Seguimiento Contrato</b>');	
               
                
               $MATRIZ = array(
                   'E'  => 'Ejecucion',
                   'S'  => 'Suspendido',
                   'C'  => 'Cancelado',
                   'V'  => 'Vencido',
                   'A'  => 'Ampliacion',
                   'F'  => 'Finalizado'
               );
               
               $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','disabled','div-2-4');
               
            
               $this->obj->text->text_yellow('Fecha Finalizacion',"date" ,'fecha_acta' ,80,80, $datos ,'required','','div-2-4') ;
              
               
               $this->obj->text->editor('Novedad','novedad',3,45,550,$datos,'required','','div-2-10') ;
               
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
          
         
      
         
          
         
         $this->set->evento_formulario('-','fin'); 
 
  
 
      
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
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
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
 
  