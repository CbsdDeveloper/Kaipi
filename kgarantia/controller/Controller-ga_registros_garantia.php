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
                
               $this->formulario = 'Model-ga_poliza.php'; 
   
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
      
     function Formulario( $id ){
      
          
         $datos = array();
         
          
         $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
    
        $x = $this->bd->query_array('garantias.contratos_garantia',   // TABLA
            '*',                        
            'idcontrato='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        
         
        echo '<h5><b>Nro.Contrato: '.$x['nro_contrato'].'<br>';
        echo 'Objeto: '.$x['detalle_contrato'].'</b></h5>';
        
        $datos['idcontrato']  = $x['idcontrato'];
        $datos['fechainicio'] = $x['fecha_inicio'];
        $datos['fechafin']    = $x['fecha_fin'];
        $datos['vigencia']    = $x['vigencia'];
        
        $this->obj->text->texto_oculto("idcontrato",$datos); 
        
        $this->set->div_label(12,'<b>Registro y actualizacion de Poliza/Garantia</b>');	
       
        
                $this->BarraHerramientas();
          
                $this->obj->text->text('Poliza',"number" ,'idpoliza' ,80,80, $datos ,'','readonly','div-2-4') ;
                $this->obj->text->text_yellow('Nro Poliza',"texto" ,'nro_poliza' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->text('Documento',"texto" ,'documento' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                $MATRIZ = array(
                    'vigente'  => 'vigente',
                    'renovada'  => 'renovada',
                    'anulada'  => 'anulada'
                );
                $evento = '';
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'','',$evento,'div-2-4');
                
                
                
                $MATRIZ = array(
                    'Garantia de Fiel Cumplimiento'  => 'Garantia de Fiel Cumplimiento',
                    'Garantia de Buen uso de anticipo'  => 'Garantia de Buen uso de anticipo',
                    'Garantia Tecnica'  => 'Garantia Tecnica'
                );
                $evento = '';
                $this->obj->list->listae('Tipo Poliza',$MATRIZ,'tipo_poliza',$datos,'','',$evento,'div-2-10');
                
                 
                
             
                
                $this->obj->text->text_blue('Monto Asegurado',"number" ,'monto' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                $this->obj->text->text_blue('Monto Anticipo',"number" ,'anticipo' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                $this->obj->text->textautocomplete('Aseguradora',"texto",'razon',40,45,$datos,'required','','div-2-10');
                
                
                $this->obj->text->text('Sucursal','texto','sucursal',120,120,$datos ,'','','div-2-10') ;
                
                $this->obj->text->text('Identificacion','texto','idprov_aseguradora',10,10,$datos ,'','readonly','div-2-4') ;
                
                  
                
                $this->set->div_label(12,'<b>Periodos de gestion</b>');
                
              
                
                $this->obj->text->text_yellow('Fecha Inicio',"date" ,'fechainicio' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->text_yellow('Fecha Fin',"date" ,'fechafin' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                $this->obj->text->text_yellow('Vigencia(Dias)',"number" ,'vigencia' ,80,80, $datos ,'required','','div-2-4') ;
 
                 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
          
         
      
         $this->set->_formulario('-','fin'); 
 
  
 
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 function K_ejecuta_detalle($div){
    
  echo '<script type="text/javascript"> goToPrecio(); </script>';
 
 
  } 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
    
   $eventoi = "javascript:Salir_ventana()";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Regresar a la ventana anterior', evento =>$eventoi,  grafico => 'glyphicon glyphicon-chevron-right' ,  type=>"button_danger")
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
  
  
  if (isset($_GET['id']))	{
      
       
      $id        = $_GET['id'];
      
      $gestion->Formulario($id );
      
      
      
  }
  
   
  
  
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
												$("#idprov_aseguradora").val('...');
											},
											success:  function (response) {
												$("#idprov_aseguradora").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
 
  
</script>
 
  