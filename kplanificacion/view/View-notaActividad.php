<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
				   // InjQueryerceptamos el evento submit
				    jQuery('#form_actividad').submit(function() {
				  		// Enviamos el formulario usando AJAX
				  		 
				  		 var data = jQuery(this).serialize(); 
				  		 
				        jQuery.ajax({
				            type: 'POST',
				            url: jQuery(this).attr('action'),
				            data: data,
				            // Mostramos un mensaje con la respuesta de PHP
				            success: function(data) {
				  				
				                jQuery('#resultado_notas').html(data);
				            
							}
				        })        
				        return false;
				    }); 
					//---------------------
				  	jQuery('#CargaFileActividad').on('click',function(){
				 		 
							  	 var actividad  = jQuery("#actividad").val(); 
			
							     var file_data = jQuery('#file').prop('files')[0];   
							     
							     var form_data = new FormData();                  

							     form_data.append('file', file_data);

 
							     $.ajax({
							                 url: '../model/Model-file-actividad.php'  ,  
							                 dataType: 'text',  // what to expect back from the PHP script, if anything
							                 cache: false,
							                 contentType: false,
							                 processData: false,
							                 data: form_data,                         
							                 type: 'post',
							                 success: function(php_script_response){
							                	   jQuery('#resultado_notas').html(php_script_response);
							                 }
							      });
				        
						});
								   
				    
 });
  	    
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
                
                $this->sesion 	 =  $_SESSION['login'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
     function Formulario( ){
      
 
        $this->set->body_tab($titulo,'inicio');
 
		 
		 
		 $AResultado = $this->bd->query_array('VIEW_USUARIOS',
											  'ACTIVIDAD,IDUNIDAD', 
											  'USUARIO='.$this->bd->sqlvalue_inyeccion($this->sesion ,true)
											 ); 
 
      
		 if ( $AResultado['ACTIVIDAD'] == 'S'){
			  
		   $sql = "SELECT IDUNIDAD AS CODIGO, UNIDAD AS NOMBRE
					FROM VIEW_USUARIOS
					GROUP BY IDUNIDAD, UNIDAD ";
		 }else{
			  
		  $sql = "SELECT IDUNIDAD AS CODIGO, UNIDAD AS NOMBRE
					FROM VIEW_USUARIOS
					WHERE USUARIO =".$this->bd->sqlvalue_inyeccion($this->sesion ,true)." 
					GROUP BY IDUNIDAD, UNIDAD ";
		 }
		 
		
        
        $this->bd->listadbe($sql,'Asignar a','actividad','required','',$evento,'div-2-10') ;
		 
	    $this->obj->text->text('Fecha','date','fecha','required','','div-2-10') ;
		 
		$this->obj->text->text('Vencimiento','date','vencimiento','required','','div-2-10') ; 
 
  
	     $MATRIZ = array(
        		'Actividad'    => 'Actividad',
        		'Recordatorio'    => ' Recordatorio '
        );
        
		$this->obj->list->listae('Tipo',$MATRIZ,'ambito','required','',$evento,'div-2-10');
 
		$this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;
		 
 
	 
         $this->obj->text->texto_oculto("action_modal_nota",$datos); 
         
 
  
      
   }
 
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
 
 ?>
  
  <script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>
   	
 <div class="container">
    <!-- Modal -->
  <div class="modal fade" id="myModalActividadNota" role="dialog">
      
       <div class="modal-dialog" id="mdialTamanio">
    
    <form action="../model/Model-nota-actividad"   method="post" enctype="multipart/form-data" name="form_actividad" id="form_actividad">
      <!-- Modal content-->
    
      <div class="modal-content">
    
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Nueva Actividad</h4>
        </div>
        <div class="modal-body">
   
        <?php 
          			$gestion   = 	new componente;
         		    $gestion->Formulario( );
        ?>
      		  <div class="col-md-2" style="padding-bottom:5px; padding-top:5px"> &nbsp;   </div>
                                 
             <div class="col-md-10" style="padding-bottom:5px; padding-top:5px">
                 
                <input type="file" id = 'file' name="file" class="filestyle" data-icon="true" accept="*/*" data-inputsize="medium">
                 
                 
                 <input name="adjunto" type="hidden" id="adjunto" value="-"> 
                  
                 
			 </div>
  						   
               <div id="resultado_notas"></div>       
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="CargaFileActividad">Adjuntar</button>
          <button type='submit' class="btn btn-default"  >Enviar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
        </div>
      </div>
         </form> 
    </div>
  </div>
  
</div>
  