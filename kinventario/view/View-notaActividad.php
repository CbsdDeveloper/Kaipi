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
							                 url: '../model/Model-file-actividad.php?actividad=' +  actividad ,  
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
      private $idsesion;
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
        
                $this->idsesion 	 =  $_SESSION['usuario'];
 
 
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
      
 
        $this->set->body_tab($titulo,'inicio');
 
      
        $resultado = $this->bd->ejecutar("select actividad as codigo, actividad as nombre
																	from par_rol_actividad
																	where idusuario  = ".  $this->idsesion  );
        
        $tipo = $this->bd->retorna_tipo();
        
        $this->obj->list->listadb($resultado,$tipo,'Tablero','actividad',$datos,'required','','div-2-10');
        
 
        
        $datos['fecha'] =  date("Y-m-d");   
        $mod_date = strtotime($datos['fecha'] ."+5 days");
        $datos['vencimiento'] =  date("Y-m-d",$mod_date);
        
         $this->obj->text->text('Fecha','date','fecha',10,10, $datos ,'required','','div-2-4') ;
        				
        $this->obj->text->text('Vencimiento','date','vencimiento',10,10, $datos ,'required','','div-2-4') ;
        						
        $MATRIZ = array(
        		'Publico'    => 'Publico',
        		'Tablero'    => 'Tablero ',
        		'Privado'    => ' Privado '
        );
        
        $this->obj->list->lista('Compartir',$MATRIZ,'ambito',$datos,'required','','div-2-10'); 
 
        $this->obj->text->editor('Actividad','detalle',3,45,350,$datos,'required','','div-2-10') ;
 
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
    <div class="modal-dialog">
    
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
  