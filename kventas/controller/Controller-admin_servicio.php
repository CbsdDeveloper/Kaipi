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
                
               $this->formulario = 'Model-admin_servicio.php'; 
   
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
          
                
                        $this->obj->text->text('Id',"number",'idproducto',0,10,$datos,'','readonly','div-2-4') ; 
                    
    
                        $resultado = $this->bd->ejecutar("select idcategoria as codigo, nombre 
                                                         from web_categoria where tipo_categoria ='S'  ");
                     
                    	
                        $this->obj->list->listadb($resultado,$tipo,'Categoria','idcategoria',$datos,'required','','div-2-4');
     
    
                        $this->obj->text->text('Nombre',"texto",'producto',130,130,$datos,'required','','div-2-10') ;  
    
                        $this->obj->text->editor('Referencia','referencia',3,45,350,$datos,'required','','div-2-10') ;
    
                        $MATRIZ =  $this->obj->array->catalogo_activo();	
                	    $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
    
                        $this->obj->text->text('Costo',"number",'costo',0,15,$datos,'required','','div-2-4') ;
                       
                      
                        $MATRIZ =  $this->obj->array->catalogo_tributa();
                        $this->obj->list->lista('Tributa',$MATRIZ,'tributo',$datos,'required','','div-2-4');
                        
                        
                        $MATRIZ =  $this->obj->array->catalogo_sino();
                        $this->obj->list->lista('Edita precio?',$MATRIZ,'activo',$datos,'required','','div-2-4');
                        
                        
                        
                        $this->set->div_label(12,'<b>Enlace Financiero</b>');	 
                        
                               
                    
                        $resultado = $this->bd->ejecutar("select  '-' as codigo, 'Enlace partida' as nombre  ");
                        
                         
                        
                        
                            
                            
                        $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' [ 0. Enlace partida ]' as nombre union
                                                          SELECT partida as codigo,  trim(partida) || '. ' || detalle as  nombre
                                                           FROM presupuesto.pre_gestion
                                                           WHERE tipo = 'I' and 
                                                                 anio=". $this->bd->sqlvalue_inyeccion( $this->anio ,true).
                                                          " ORDER BY 2 ");
 
                        $evento = 'onChange="PonePartida(this.value)"';
                        
                        $this->obj->list->listadbe($resultado,$tipo,'Presupuesto','partida',$datos,'','',$evento,'div-2-4');
                        
                        
                        $evento = 'onChange="PoneCuenta(this.value)"';
            
                        $this->obj->list->listadbe($resultado,$tipo,'Ingreso','cuenta_ing',$datos,'','',$evento,'div-2-4');
                        
                        
                        
                        $resultado = $this->bd->ejecutar("select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								        from co_plan_ctas
                                                           where univel = 'S' and 
                                                                   anio = ". $this->bd->sqlvalue_inyeccion( $this->anio ,true)." and 
                                                                   registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and
                                                                   tipo_cuenta in ('C')");
                        
                        $this->obj->list->listadb($resultado,$tipo,'Cuenta x Cobrar','cuenta_inv',$datos,'','','div-2-4');	
                        
                
                        
                        
                        $this->set->div_label(12,'<b>Opcional Grafico Servicio</b>');	 
                        
                        $this->obj->text->text('Path Imagen',"texto",'url',90,90,$datos,'','readonly','div-2-4') ;  
      
                        
                        
                        $file = "javascript:openFile('../../upload/upload?file=1',650,300)";
                        
                        $path_imagen = '<a href="#" onClick="'.$file.'">';
                        
                        
                   
                        
                        
                        echo '<div class="col-md-2"></div>
							<div class="col-md-4" style="padding-bottom:5px; padding-top:5px">'.$path_imagen.'
                    			<img id="ImagenUsuario" width="100" height="100"></a>
                    		</div>';
                        
                        
                        $cadena = 'javascript:open_precio('."'".'View-inv_precios'."','".''."',".'740,470)';
                        
                        $urlImagen =   '<a href="'.$cadena.'" ><img src="../../kimages/cnew.png"/></a> ';
                        
                        $this->set->div_labelmin(12,$urlImagen.' Lista de Precios asignado al servicio');
                         
                   
                        
   
                    echo '<div div class="col-md-12" id="precio_grilla"></div>';
                    
   
                    
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("tipo",$datos); 
         
         $this->obj->text->texto_oculto("idmarca",$datos); 
         
         $this->obj->text->texto_oculto("idbodega",$datos); 
         
         $this->obj->text->texto_oculto("unidad",$datos); 
         
         $this->obj->text->texto_oculto("facturacion",$datos); 
         
         $this->obj->text->texto_oculto("codigob",$datos); 
         
         $this->obj->text->texto_oculto("minimo",$datos); 
         
      
         
          
         
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
     
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  