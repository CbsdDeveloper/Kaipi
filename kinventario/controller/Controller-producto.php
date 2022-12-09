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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
                    
                 
                $this->anio       =  $_SESSION['anio'];
        
                
               $this->formulario = 'Model-producto.php'; 
   
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
      
        $titulo = 'Facturacion';
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
        $datos = array();
    
                $this->BarraHerramientas();
         
                
                $tipo = $this->bd->retorna_tipo();
                
                $MATRIZ = array(
                    'B'    => 'Bien/Producto'
                );
                $this->obj->list->lista('Naturaleza',$MATRIZ,'tipo',$datos,'required','','div-2-10'); 
                
                
                       $this->obj->text->text('Id',"number",'idproducto',0,10,$datos,'','readonly','div-2-4') ; 
                    
                       
                        $resultado = $this->bd->query_sql('view_bodega_permiso',
                                                          'idbodega,nombre',
                                                          '1=1',
                                                          '2 asc');
                        
	                    $this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega',$datos,'required','','div-2-4');
    
	                    
	                    $this->obj->text->text('<b>Codigo </b>',"texto",'codigo',50,50,$datos,'required','','div-2-4') ;  
	                    
	                    $resultado = $this->bd->query_sql('web_categoria',
	                        'idcategoria,nombre',
	                        '0=0',
	                        '2 asc');
                     	    
                        $this->obj->list->listadb($resultado,$tipo,'Categoria','idcategoria',$datos,'required','','div-2-4');
                        
                    	 
                    	$cboton = '';
                    	
                    	$this->obj->text->text_yellow('Nombre',"texto",'producto',150,150,$datos,'required','','div-2-10') ;
                    	
                    	$this->obj->text->editor('Referencia','referencia',2,45,350,$datos,'required','','div-2-10') ;
                 
           
                        $resultado = $this->bd->query_sql('web_marca',
                            'idmarca,nombre',
                            '',
                            '2 asc');
                        
                        $this->obj->list->listadb($resultado,$tipo,' Marca'.$cboton,'idmarca',$datos,'required','','div-2-4');
                        
                          
             
                        $this->obj->text->text_decimal('Costo',"number",'costo',0,15,$datos,'required','','div-2-4') ;
                       
                        $MATRIZ =  $this->obj->array->catalogo_tributa();	
                        $this->obj->list->lista('Tributa',$MATRIZ,'tributo',$datos,'required','','div-2-4');
                       
                      
                        
                        $this->obj->text->text('Codigo Barra',"texto",'codigob',50,50,$datos,'required','','div-2-4') ;  
                        
                        
                        $this->obj->text->text_yellow('StockMinimo',"number",'minimo',50,50,$datos,'required','','div-2-4') ;  
                        
                   
                        $this->set->div_label(12,'INFORMACION ENLACE FINANCIERO');
                        
                        $union = "Select '-' as codigo, ' [ No aplica ] ' as nombre union" ;
                        
                        
                        $resultado = $this->bd->ejecutar($union." select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								from co_plan_ctas
                                                    where univel = 'S' and
                                                          anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                                                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                          tipo_cuenta in ('V') ORDER BY 1");
                        
                        $this->obj->list->listadb($resultado,$tipo,'Cuenta de Inventarios','cuenta_inv',$datos,'','','div-2-4');
                        
                        
                        $resultado = $this->bd->ejecutar($union." select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								         from co_plan_ctas
                                                             where univel = 'S' and
                                                                   anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                                                                   registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                                   tipo_cuenta in ('V') ORDER BY 1" );
                        
                        $this->obj->list->listadb($resultado,$tipo,'Cuenta Costo','cuenta_gas',$datos,'','','div-2-4');
              
                          
                         $datos["unidad"] = 'Unidad';
                         $datos["facturacion"] = 'N';
                         $datos["estado"] = 'S';
                         
                         $datos["precio"] = '0.00';
                         
                         $datos["controlserie"] = 'N';
                         

                         
                         
                         $this->obj->text->texto_oculto("controlserie",$datos);
                         
                          $this->obj->text->texto_oculto("precio",$datos);
                          
                         $this->obj->text->texto_oculto("estado",$datos);
                         $this->obj->text->texto_oculto("unidad",$datos);
                         $this->obj->text->texto_oculto("facturacion",$datos); 
                         
                         $this->obj->text->texto_oculto("url",$datos); 
                         $this->obj->text->texto_oculto("action",$datos); 
                          
                         $this->obj->text->texto_oculto("cuenta_ing",$datos); 
          
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 function K_ejecuta_detalle($div){
    
  echo '<script type="text/javascript"> goToPrecio(); </script>';
 
 
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
    //----------------------------------------------
    
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  