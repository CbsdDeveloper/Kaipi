 <script >// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
                  jQuery('#result').html('<div class="alert alert-info">'+data.resultado + '</div>');
            	  
 				  jQuery( "#result" ).fadeOut( 1600 );
 				  
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  
 			 	  jQuery("#id_acta").val(data.id );

 			 	  jQuery("#documento").val(data.documento ); 

 			 	  if ( data.id > 0){
 	 			 	  
 			 		 BusquedaGrillaCustodio(oTable_doc);

 			 		DetalleActivosNoAsignados( );
 			 	  }	  

 			   
            
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
           
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date('Y-m-d');
        
                
               $this->formulario = 'Model-ac_trasf.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        
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
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
        $datos = array();
    
                $this->BarraHerramientas();
                 

                
                $this->set->div_panel('<b> ACTA DE TRASFERENCIAS DE BIENES</b>');
        	                
                            $this->tab_1_datos_bienes( );
               
                $this->set->div_panel('fin');
             
                
             $this->set->div_panel6('<b> CUSTODIO ENTREGA</b> <img src="../../kimages/_next1.png"  align="absmiddle" /><img src="../../kimages/user_menos.png"  align="absmiddle" />');
             
                            $this->custodio_actual();
             
             $this->set->div_panel6('fin');
             
             
             $this->set->div_panel6('<b> CUSTODIO RECIBE</b> <img src="../../kimages/_next2.png"  align="absmiddle" /><img src="../../kimages/user_mas.png"  align="absmiddle" />');
             
                        $this->custodio_nuevo();
             
             $this->set->div_panel6('fin');
         
         
             $this->obj->text->texto_oculto("action",$datos); 
             
             
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
    $eventop = 'javascript:impresion()';
       
    $evento= "javascript:confirmar_envio(event)";
    
    
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>$evento, grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  ,
                array( boton => 'Reporte diario contable', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default")  ,
                  );
                  
    $this->obj->boton->ToolMenuDivSet($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function tab_1_datos_bienes( ){
      
 
      $datos = array();
  
 
      $this->obj->text->text('Id.Acta',"number",'id_acta',40,45,$datos,'required','readonly','div-2-4') ;
       
 
      
      
      $this->obj->text->text_dia('Fecha','365','fecha',15,15,$datos,'required','','div-2-4');
        
       
       
      // 'Acta Trasferencia de Bienes'    => 'Acta Trasferencia de Bienes',
     // 'Acta Baja de Bienes'    => 'Acta Baja de Bienes'
      
      $MATRIZ = array(
          'Acta Trasferencia de Bienes'    => 'Acta Trasferencia de Bienes'
      );
      $this->obj->list->lista('Clase Documento',$MATRIZ,'clase_documento',$datos,'required','','div-2-4');
       
      $this->obj->text->text('Nro.Acta','texto','documento',10,10,$datos ,'','readonly','div-2-4') ;
       
      $this->obj->text->editor('Detalle','detalle',2,250,250,$datos,'','','div-2-10');
      
 
      
      
  }  
 //-----------------------------
  function custodio_actual( ){
      
      $datos = array();
      
      $this->obj->text->text_yellow('Custodio',"texto",'razon',40,45,$datos,'','readonly','div-2-10');
      
      $this->obj->text->text_yellow('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;
      
   
   
      
  }
  //------------------------------
  function custodio_nuevo( ){
      
      $datos = array();
      
      $this->obj->text->text_blue('Custodio',"texto",'razon_nuevo',40,45,$datos,'','','div-2-10');
      
      $this->obj->text->text_blue('Identificacion','texto','idprov_nuevo',10,10,$datos ,'','readonly','div-2-10') ;
      
    
      $MATRIZ = array(
          'N'    => 'No',
          'S'    => 'SI',
      );
      
      $this->obj->list->lista('Autorizado',$MATRIZ,'estado',$datos,'','disabled','div-2-4');
      
  }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>
<script type="text/javascript">

jQuery.noConflict(); 

jQuery(document).ready(function() {


	jQuery('#razon_nuevo').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteNomina.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#razon_nuevo").focusout(function(){
	 
	 var itemVariable = $("#razon_nuevo").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											beforeSend: function () {
												$("#idprov_nuevo").val('...');
											},
											success:  function (response) {
												$("#idprov_nuevo").val(response);  
													  
											} 
									});
	 
    });
 
}); 
</script>
   