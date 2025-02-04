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
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'admin_empresa.php'; 
   
               $this->evento_form = '../model/Model-admin_empresa.php';        // eventos para ejecucion de editar eliminar y agregar 
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
      
         $datos = array();
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab('INICIO','inicio');
 
    
                $this->BarraHerramientas();
                
                
                $path_imagen = '<a href="'."javascript:open_pop('../../upload/upload?file=3','-',650,300)".'">';
                
                
                
                echo '<div class="col-md-6" style="padding-bottom:5px; padding-top:5px">'.$path_imagen.'
                    			<img id="ImagenUsuario" width="100" height="100"></a>
                    		</div>';
                
                $this->set->div_label(12,'<h6>Informacion Principal</h6>');
                
                   
                    $this->obj->text->text_blue('Identificaci�n',"texto",'ruc_registro',20,15,$datos,'required','','div-2-10') ; 
                    
		            $this->obj->text->text_yellow('Razon Social',"texto",'razon',100,100,$datos,'required','','div-2-10');
 		            
		            $this->obj->text->text('Nombre Comercial',"texto",'comercial',100,100,$datos,'required','','div-2-10');
 		            
		            
		            $this->obj->text->text('Contacto',"texto",'contacto',100,100,$datos,'required','','div-2-10');
          
		            $this->obj->text->text('Email',"email",'correo',100,100,$datos,'required','','div-2-4');
		
		            $this->obj->text->text('Sitio Web',"texto",'web',100,100,$datos,'required','','div-2-4') ; 
 		         
		 
		 			$resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre 
                								from par_catalogo 
                								where tipo = 'canton' and publica = 'S' order by nombre ");
                	$tipo = $this->bd->retorna_tipo();
                	
                	$this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-10');
                    
                	$this->obj->text->text('Domicilio',"texto",'direccion',100,100,$datos,'required','','div-2-10');
		 
 		 
                    $MATRIZ =  $this->obj->array->catalogo_activo();
                    $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('Telefono',"texto",'telefono',100,100,$datos,'required','','div-2-4');
 		 
 					$MATRIZ = $this->obj->array->catalogo_empresa_principal();
					$this->obj->list->lista('Referencia',$MATRIZ,'tipo',$datos,'required','','div-2-4');
		 
		 
		 
		 			
		 			$this->set->div_label(12,'<h6>Informacion Institucional</h6>');

		 			
		 			$this->obj->text->editor('Mision','mision',4,75,500,$datos,'required','','div-2-4') ;
		 
		 			$this->obj->text->editor('Vision','vision',4,75,500,$datos,'required','','div-2-4') ;
 
                    
                    $this->obj->text->texto_oculto("url",$datos); 
                    
              
                  
                    $this->set->div_label(12,'<h6>Informacion Notificacion</h6>');
                    
                    $this->obj->text->text('Notificaciones',"email",'email',40,45,$datos,'','','div-2-4');
                    $this->obj->text->text('Host SMTP',"texto",'smtp',40,45,$datos,'','','div-2-4');
                    $this->obj->text->text('AccesoWeb',"password",'puerto',40,45,$datos,'','','div-2-4');
                    $this->obj->text->text('Enlace Sistema',"texto",'enlace',100,100,$datos,'required','','div-2-4') ; 
                    
                    
                    
                  
                    $this->set->div_label(12,'<h6>Factura Electronica</center>');
                    
                    $MATRIZ =  $this->obj->array->catalogo_sino();
               
                    $this->obj->list->lista('FacturaElectronica',$MATRIZ,'felectronica',$datos,'required','','div-2-4');
                    $this->obj->text->text('Obligado',"texto",'obligado',2,2,$datos,'','','div-2-4');
                    $this->obj->text->text('Ambiente',"texto",'ambiente',2,2,$datos,'required','','div-2-4');
                    $this->obj->text->text('Carpeta',"texto",'carpeta',100,100,$datos,'','','div-2-4');
                    $this->obj->text->text('Archivo',"texto",'firma',100,100,$datos,'','','div-2-4');
                    $this->obj->text->text('Clave acceso',"password",'acceso',40,45,$datos,'','','div-2-4');
                    $this->obj->text->text('Establecimiento',"texto",'estab',3,3,$datos,'','','div-2-4');
                    $this->obj->text->text('Nro.Factura',"number",'factura',40,45,$datos,'required','','div-2-4');
                    $this->obj->text->text('Nro.Comprobante',"number",'retencion',40,45,$datos,'required','','div-2-4');
                
                 /*
                        $this->obj->text->texto_oculto("email",$datos);
                        $this->obj->text->texto_oculto("smtp",$datos);
                        $this->obj->text->texto_oculto("puerto",$datos);
                        $this->obj->text->texto_oculto("password",$datos);
                    
                   
                    
                   
                    
                    $this->obj->text->texto_oculto("felectronica",$datos);
                    $this->obj->text->texto_oculto("obligado",$datos);
                    $this->obj->text->texto_oculto("ambiente",$datos);
                    $this->obj->text->texto_oculto("carpeta",$datos);
                    $this->obj->text->texto_oculto("firma",$datos);
                    $this->obj->text->texto_oculto("password",$datos);
               
                    $this->obj->text->texto_oculto("estab",$datos);
                    $this->obj->text->texto_oculto("factura",$datos);
                    $this->obj->text->texto_oculto("retencion",$datos);  
                     */
                      
         $this->obj->text->texto_oculto("action",$datos); 
         $this->obj->text->texto_oculto("fondo",$datos);
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
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
   function combodb(){
    
        $datos = array();
       
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
       
       $datos = array();
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
      
   $gestion->Formulario( );

 ?>


 
  