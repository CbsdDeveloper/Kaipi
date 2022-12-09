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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-admin_prod-servicio.php'; 
   
               $this->evento_form = '../model/Model-admin_prod-servicio.php';        // eventos para ejecucion de editar eliminar y agregar 
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
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                     
                //       idproducto, tipo ,idbodega   ,idcategoria,idmarca,unidad,producto,referencia,estado,facturacion
               //costo,tributo,  cuenta_ing,cuenta_inv,url
                
                        $this->obj->text->text('Id',"number",'idproducto',0,10,$datos,'','readonly','div-2-4') ; 
                    
                        $MATRIZ =  $this->obj->array->catalogo_pro_ser();	
                        $this->obj->list->lista('Naturaleza',$MATRIZ,'tipo',$datos,'required','','div-2-4'); 
    
                 
                        $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre 
								from inv_bodega 
								where activo <> 'N' order by 1");
	
                        $tipo = $this->bd->retorna_tipo();
	                    $this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega',$datos,'required','','div-2-4');
    
    
                        $resultado = $this->bd->ejecutar("select idcategoria as codigo, nombre from web_categoria ");
                    	$tipo = $this->bd->retorna_tipo();
                    	    
                    	$cadena = 'javascript:open_spop('."'".'admin_categoria'."','".''."',".'680,350)';
                    	$cboton = '<a href="'.$cadena.'"><img src="../../kimages/cnew.png"/></a>';
                    	
                        $this->obj->list->listadb($resultado,$tipo,'Categoria'.$cboton,'idcategoria',$datos,'required','','div-2-4');
    
                    
                        $resultado = $this->bd->ejecutar("select idmarca as codigo, nombre 	from web_marca ");
                    	$tipo = $this->bd->retorna_tipo();
                    		
                    	$cadena = 'javascript:open_spop('."'".'admin_marca'."','".''."',".'680,350)';
                    	$cboton = '<a href="'.$cadena.'"><img src="../../kimages/cnew.png"/></a>';
                    	
                        $this->obj->list->listadb($resultado,$tipo,' Marca'.$cboton,'idmarca',$datos,'required','','div-2-4');
                        
                        
                        $MATRIZ =  $this->obj->array->catalogo_unidades();	
                        $this->obj->list->lista('Medicion',$MATRIZ,'unidad',$datos,'required','','div-2-4');
    
                        $this->obj->text->text('Nombre',"texto",'producto',50,50,$datos,'required','','div-2-10') ;  
    
                        $this->obj->text->editor('Referencia','referencia',3,45,350,$datos,'required','','div-2-10') ;
    
                        $MATRIZ =  $this->obj->array->catalogo_activo();	
                	    $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                	
                        $MATRIZ =  $this->obj->array->catalogo_sino();	
                	    $this->obj->list->lista('Para la venta',$MATRIZ,'facturacion',$datos,'required','','div-2-4');
    
    
                        $this->obj->text->text('Costo',"number",'costo',0,15,$datos,'required','','div-2-4') ;
                       
                        $MATRIZ =  $this->obj->array->catalogo_tributa();	
                        $this->obj->list->lista('Tributa',$MATRIZ,'tributo',$datos,'required','','div-2-4');
                       
                        $resultado = $this->bd->ejecutar("select trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
								from co_plan_ctas where univel = 'S' and tipo_cuenta in ('F','V')");
                       
                        $tipo = $this->bd->retorna_tipo();
                        $this->obj->list->listadb($resultado,$tipo,'Cuenta de Ventas','cuenta_ing',$datos,'required','','div-2-4');	
                    
                        $resultado = $this->bd->ejecutar("select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								from co_plan_ctas where univel = 'S' and tipo_cuenta in ('F','V')");
                                                    
                        $tipo = $this->bd->retorna_tipo();
                        $this->obj->list->listadb($resultado,$tipo,'Cuenta de Inventarios','cuenta_inv',$datos,'required','','div-2-4');	  
   
                        $this->obj->text->text('Path Imagen',"texto",'url',50,50,$datos,'','readonly','div-2-4') ;   
      
                        
                        
                        $path_imagen = '<a href="'."javascript:open_pop('../../upload/upload','',650,300)".'">';
                        
                        echo '<div class="col-md-2"></div>
							<div class="col-md-4" style="padding-bottom:5px; padding-top:5px">'.$path_imagen.'
                    			<img id="ImagenUsuario" width="100" height="100"></a>
                    		</div>';
                        
                        
                        $cadena = 'javascript:open_precio('."'".'View-inv_precios'."','".''."',".'740,470)';
                        
                        $urlImagen =   '<a href="'.$cadena.'"><img src="../../kimages/cnew.png"/></a> ';
                        
                        $this->set->div_label(12,'<h6>'.$urlImagen.' Lista de Precios asignado al producto<h6>');
                         
                   
                        
   
                    echo '<div div class="col-md-12" id="precio_grilla"></div>';
                    
                   
     
                      
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
 
 
   $evento = 'javascript:open_editor();';
   
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
   function combodbA(){
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  