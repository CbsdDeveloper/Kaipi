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
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
                  jQuery('#result').html('<div class="alert alert-info">'+ data.resultado + '</div>');
             	  
				  jQuery( "#result" ).fadeOut( 1600 );
				  
			 	  jQuery("#result").fadeIn("slow");

			 	  jQuery("#action").val(data.accion); 
			 	  
			 	  jQuery("#idren_local").val(data.id );
            
			}
        })        
        return false;
    }); 
 })
</script>	
<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php';  
  
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
    
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =     date("Y-m-d");
        
                
               $this->formulario = 'Model-ren_arriendo.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        
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
      
 
        $this->set->_formulario( $this->evento_form,'inicio' );  
 
 
        $datos = array();


        $MATRIZL = array(
            'Local Comercial'    => 'Local Comercial',
            'Baterias Sanitarias'    => 'Baterias Sanitarias',
            'Oficina'    => 'Oficina',
            'Cooperativas de Trasporte'   => 'Cooperativas de Trasporte',
            'Boleteria'    => 'Boleteria',
            'Kiosko Isla' => 'Kiosko Isla',
            'Espacio' => 'Espacio Publicitario'
        );
    
                $this->BarraHerramientas();
                
                $this->set->div_panel('<b> INFORMACION DEL ARRENDATARIO </b>');
                
                $this->obj->text->text_blue('Referencia',"number" ,'idren_local' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->textautocomplete('Arrendatario',"texto",'razon',40,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                 
                $this->obj->text->editor('Servicio','servicio',4,45,300,$datos,'required','','div-2-8') ;
                
                
                $this->set->div_panel('fin');
         
               
                $this->set->div_panel('<b> INFORMACION DEL SERVICIO </b>');
                
                
                $this->obj->text->text('Nro.Contrato',"texto" ,'contrato' ,80,80, $datos ,'required','','div-2-4') ;
                

                 
                $this->obj->text->text('Nro.Local',"texto" ,'numero' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->text('Fecha Inicio',"date" ,'fecha_inicio' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Fecha Termino',"date" ,'fecha_fin' ,80,80, $datos ,'required','','div-2-4') ;
                
             
                
                $evento = '';
                $this->obj->list->listae('Tipo Arriendo ',$MATRIZA,'tipo',$datos,'','',$evento,'div-2-10');
                
                $this->obj->text->editor('Ubicacion','ubicacion',2,45,300,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('<b>ARRIENDO($)</b>',"number" ,'arriendo' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                $this->set->div_panel('fin');
                
                $this->set->div_panel('<b> INFORMACION FINANCIERA </b>');
                
                
                $this->obj->text->editor('Novedad','novedad',2,45,300,$datos,'required','','div-2-10') ;
                
                $MATRIZ = array(
                    'M'    => 'Mensual',
                    'A'    => 'Anual',
                    'S'    => 'Semestral',
                );
                
                $this->obj->list->listae('Periodo',$MATRIZ,'periodo',$datos,'','',$evento,'div-2-4');
                
                $MATRIZ = array(
                    'N'    => 'NO',
                    'S'    => 'SI'
                );
                
                $this->obj->list->listae('Factura Mensual?',$MATRIZ,'factura',$datos,'','',$evento,'div-2-4');
                
                
                $MATRIZ = array(
                    'N'    => 'NO',
                    'S'    => 'SI'
                );
                
                $this->obj->list->listae('Finalizado',$MATRIZ,'finalizado',$datos,'','',$evento,'div-2-4');
                
                
                 
                $this->set->div_panel('fin');
         
        
         $this->obj->text->texto_oculto("id_par_ciu",$datos); 
                
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       $formulario_impresion = '../view/cliente';
       $eventoc = 'javascript:openView('."'".$formulario_impresion."')";
    
   
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Cliente - Beneficiario ', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button")
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
											url:   '../model/AutoCompleteIDCiuID.php',
											type:  'GET' ,
											dataType: "json",
 											success:  function (response) {
												$("#idprov").val(response.a);   
												$("#id_par_ciu").val(response.c);  	  
											} 
									});
	 
    });
 
  
  
  
  
</script>  
  