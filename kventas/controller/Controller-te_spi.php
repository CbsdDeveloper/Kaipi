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
			 			
          	      jQuery('#result').html(data.resultado);
        	  
				  jQuery( "#result" ).fadeOut( 1600 );
				  
			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 

 			 	  if ( data.id > 0 )  {
 	 			 	  
     			 	  jQuery("#id_spi").val(data.id );
    
     			 	  jQuery("#estado").val(data.estado);

 			 	}
			}
        })        
        return false;
    }); 
 })
</script>	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    
 	
 	
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
                
               $this->formulario = 'Model-te_spi.php'; 
   
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
      
 
         
         $datos = array();
         
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
  
    
                $tipo = $this->bd->retorna_tipo();
        
                $this->BarraHerramientas();
          
                
                        $this->obj->text->text('Transaccion',"number",'id_spi',0,10,$datos,'','readonly','div-1-3') ; 
                    
                        $MATRIZ = array(
                            'digitado'    => 'digitado',
                            'enviado'    => 'enviado',
                            'aprobado'    => 'aprobado',
                            'anulado'    => 'anulado'
                        );
                        
                        $evento = 'onChange="valida_estado(this.value)"';
                        $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'required','disabled',$evento,'div-1-3');
                        
                        $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-1-3') ;
 
                        $this->obj->text->editor('Detalle','detalle',2,45,350,$datos,'required','','div-1-7') ;
                        
                        $this->obj->text->text('Envio',"date" ,'fecha_envio' ,80,80, $datos ,'required','readonly','div-1-3') ;
                     
                       
                
                        $MATRIZ = array(
                            'proveedores'    => 'proveedores',
                            'nomina'    => 'nomina',
                            'varios'    => 'varios'
                        );
                      
                        
                        $this->set->div_label(12,'Detalle  Transaccion');
                        
                        
                        
                        $resultado = $this->bd->ejecutar("select '' as codigo, '[ Seleccione Cuenta - Bancos ]' as nombre  union
                                                    select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								        from co_plan_ctas
                                                           where univel = 'S' and
                                                                  anio = " . $this->bd->sqlvalue_inyeccion( $this->anio  ,true)." and
                                                                  registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc     ,true)." and
                                                                  tipo_cuenta = 'B' order by 1"
                            );
                        
                        
                        $this->obj->list->listadb($resultado,$tipo,'Banco','cuenta',$datos,'required','','div-2-4');	
                        
                        
                        $this->obj->list->lista('Beneficiarios',$MATRIZ,'beneficiario',$datos,'required','','div-2-4');
                        
                        
                        $this->obj->text->text('Codigo Control',"texto" ,'codigo_control' ,120,120, $datos ,'','readonly','div-2-4') ;
                        
                        $this->obj->text->text('Validacion',"texto" ,'validacion' ,120,120, $datos ,'','readonly','div-2-4') ;
 
                        
                        $this->obj->text->text_yellow('Referencia',"texto" ,'referencia' ,15,15, $datos ,'required','','div-2-4') ;
                        
                    
         $this->obj->text->texto_oculto("action",$datos); 
 
         
         $this->set->_formulario('-','fin'); 
 
   }
  
  //----------------------------------------------------......................-------------------------------------------------------------
    function BarraHerramientas(){
 
 
 
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   $eventom= "javascript:parametros_generales()";
   
   $eventop= "javascript:aprobacion_spi()";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Datos Generales', evento =>$eventom,  grafico => 'glyphicon glyphicon-file' ,  type=>"button_danger"),
                array( boton => 'Autorizar Envio aprobado', evento =>$eventop,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_info")
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
 
  