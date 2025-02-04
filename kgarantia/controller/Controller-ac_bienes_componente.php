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
				
            	  jQuery('#result').html(data.resultado);
            	  
 				  jQuery( "#result" ).fadeOut( 1600 );
 				  
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  
 			 	  jQuery("#id_bien_componente").val(data.id );

  			 	 var parametros = {
                           'id'      : data.idbien,
   		   				   'accion' : 'visor'
  		   	    };
  	 		     
  			 	  $.ajax({
                       data:  parametros,
                        url:   '../model/Model-ac_bienes_componente.php',
                       type:  'GET' ,
                       cache: false,
                       success:  function (data) {

                                opener.$("#ViewFormComponentes").html(data);  
        
                           
                           } 
               });
 			 	  
            
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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
          
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ac_bienes_componente.php'; 
   
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
      
      function Formulario( $idbien,$ref ){
      
          $datos = array();
          
          
      if ( $ref > 0 ){
          
          $datos = $this->consultaId('editar', $ref );
          
          $datos["id_bien_componente"] = $ref;
          
          $datos["action"] = 'editar';
          
      } 
           
 
        $this->set->_formulario( $this->evento_form,'inicio' ); 
        
       
    
                $this->BarraHerramientas();
                
                $datos["id_bien"] = $idbien;
                
                $this->obj->text->text('Bien',"number" ,'id_bien' ,80,80, $datos ,'required','readonly','div-2-4') ;
           
                $this->obj->text->text('Componente',"number" ,'id_bien_componente' ,80,80, $datos ,'','readonly','div-2-4') ;
                 
                $this->obj->text->editor('Detalle','detalle_componente',2,170,170,$datos,'','','div-2-10');
                
                
                $this->obj->text->textautocomplete('Marca',"texto",'marca',40,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text('Codigo',"texto" ,'id_marca_componente' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                
                $evento ='';
                
                $MATRIZ = array(
                    'S'    => 'Activo',
                    'N'    => 'Inactivo'
                );
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'','',$evento,'div-2-4');
                
                
                $MATRIZ1 = array(
                    'Nuevo'    => 'Nuevo',
                    'Cambio'   => 'Cambio',
                    'Adicional'    => 'Adicional',
                    'Reparacion'    => 'Reparacion',
                    'Mantenimiento'    => 'Mantenimiento'
                );
                
                $this->obj->list->listae('Evento',$MATRIZ1,'evento',$datos,'','',$evento,'div-2-4');
                
                
                
                
                
                
                 $this->set->div_label(12,'Costo y afectacion del componente');	 
                 
                 $this->obj->text->text('Costo componente $',"number" ,'costo_componente' ,80,80, $datos ,'required','','div-7-5') ;
                
                 $MATRIZ = array(
                     'S'    => 'SI',
                     'N'    => 'NO'
                 );
                 
                 $this->obj->list->listae('Afecta Costo Bien',$MATRIZ,'relacionado',$datos,'','',$evento,'div-7-5');
             /*   
                 $this->obj->text->text('Proveedor',"texto" ,'proveedor' ,100,100, $datos ,'','','div-7-5') ;
                 
                 $this->obj->text->text('Factura Compra',"texto" ,'factura' ,80,80, $datos ,'','','div-7-5') ;
                 */
                 
                $this->obj->text->texto_oculto("action",$datos); 
         
 
          
 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  
  function consultaId($accion,$id ){
      
      
      
      $qquery = array(
          array( campo => 'id_bien_componente',   valor => $id,  filtro => 'S',   visor => 'S'),
          array( campo => 'id_marca_componente',valor => '-',filtro => 'N', visor => 'S'),
          array( campo => 'detalle_componente',valor => '-',filtro => 'N', visor => 'S'),
          array( campo => 'costo_componente',valor => '-',filtro => 'N', visor => 'S'),
          array( campo => 'relacionado',valor => '-',filtro => 'N', visor => 'S'),
          array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
          array( campo => 'id_bien_relacionado',valor => '-',filtro => 'N', visor => 'S'),
          array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
       );
      
       
      $datos =   $this->bd->JqueryArrayVisorDato('activo.view_bienes_componente',$qquery );
      
       
       
      return $datos;
      
  }
   
  function consultaBien($id ){
 
      
      $qquery = array(
          array( campo => 'id_bien',   valor => $id,  filtro => 'S',   visor => 'S'),
          array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
          array( campo => 'proveedor',valor => '-',filtro => 'N', visor => 'S')
 
      );
      
      
      $datos =   $this->bd->JqueryArrayVisorDato('activo.view_bienes',$qquery );
      
      
      
      return $datos;
      
  }
///------------------------------------------------------------------------
}
 
?>
<script type="text/javascript">

jQuery.noConflict(); 

jQuery(document).ready(function() {


  

 jQuery('#marca').typeahead(
		 {
	    minLength : 2,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/Model-ac_busca_marca.php', { query: query  }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 //-----------------------------------------
 
 //-----------------------------------------
 $("#marca").focusout(function(){
	 
        var referencia = $("#marca").val();  
        var idmarca    = 0;  
        
		var parametros = {
									"referencia" : referencia 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/Model_ac_auto_marca.php',
									dataType: "json",
									success:  function (response) {
 											 $("#id_marca_componente").val( response.a );  
											  
 											   
									} 
							});
       //-------------------------------------------------------------------
 				
    });
 
});
</script>
   
  