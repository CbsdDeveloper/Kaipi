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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-inv_importaciones.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
                 
                echo '<h6> &nbsp;  </h6>';
               
                $this->set->div_panel6('<b> DATOS DE LA GUIA </b>');
                
                    $this->obj->text->text('Movimiento','number','cab_codigo',10,10,$datos ,'','readonly','div-2-4') ;
                     
                    $this->obj->text->text('Secuencial',"texto" ,'secuencial' ,80,80, $datos ,'','readonly','div-2-4') ;
                    
                    $this->obj->text->text('Establecimiento',"texto" ,'estab' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->text('PtoEmision',"texto" ,'ptoemi' ,80,80, $datos ,'required','','div-2-4') ;
                
                    $this->obj->text->text('Autorizacion',"texto" ,'cab_autorizacion' ,80,80, $datos ,'','readonly','div-2-10') ;
                    
                    $this->obj->text->text('Nro.Guia',"texto" ,'guiaremision' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    
                    $this->obj->text->text('Estado',"texto" ,'estado' ,80,80, $datos ,'','readonly','div-2-4') ;
               
                    $this->set->div_panel6('fin');
                    
                 $this->set->div_panel6('<b> DATOS CHOFER VEHICULO </b>');
              
                     $this->obj->text->text('Identificacion',"texto" ,'identificacioncomprador' ,80,80, $datos ,'required','','div-2-10') ;
                    
                     $this->obj->text->text('Chofer',"texto" ,'razonsocialcomprador' ,80,80, $datos ,'required','','div-2-10') ;
                     
                     $this->obj->text->text('Placa',"texto" ,'placa' ,80,80, $datos ,'required','','div-2-4') ;
                    
                     $this->obj->text->text('Marca',"texto" ,'marca' ,80,80, $datos ,'required','','div-2-4') ;
                    
                     $this->obj->text->text('Modelo ',"texto" ,'modelo' ,80,80, $datos ,'required','','div-2-4') ;
                    
                     $this->obj->text->text('Color',"texto" ,'color' ,80,80, $datos ,'required','','div-2-4') ;
                    
                  $this->set->div_panel6('fin');
                  
                  $this->set->div_panel6('<b> DATOS DE LA FACTURA </b>');
                  
                  
                  $this->obj->text->text('<b>Lugar Partida</b>',"texto" ,'dirpartida' ,80,80, $datos ,'required','','div-2-10') ;
                  
                  $this->obj->text->text('Fecha Emision',"date" ,'fechaemision' ,80,80, $datos ,'required','','div-2-10') ;
                  
                   
                  
                  $tipo = $this->bd->retorna_tipo();
                  
                  $anio = date("Y"); 
                  $mes = date("m"); 
                  
                  $resultado =$this->bd->ejecutar("select '999999999' as codigo, 'Seleccione el numero de factura' as nombre union
                                    select comprobante as codigo, (trim(comprobante) || ' ' ||  trim(razon)) as nombre
            			                     from view_inv_movimiento
            								where anio = ".$this->bd->sqlvalue_inyeccion($anio ,true) ." and 
                                                  mes =".$this->bd->sqlvalue_inyeccion($mes ,true)."  and 
                                                  tipo = 'F' and 
                                                  estado = 'aprobado' and 
                                                  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc  ,true) ." 
                                                  order by 1 desc");
                  
             
                  $this->obj->list->listadb($resultado,$tipo,'Nro Factura','factura',$datos,'required','','div-2-10');
                  
                      
                  $this->obj->text->text('Codigo',"texto" ,'numdocsustento' ,80,80, $datos ,'','readonly','div-2-10') ;
                  $this->obj->text->text('Autorizacion',"texto" ,'numautdocsustento' ,80,80, $datos ,'','readonly','div-2-10') ;
                  $this->obj->text->text('Fecha',"date" ,'fechaemisiondocsustento' ,80,80, $datos ,'','readonly','div-2-4') ;
                  $this->obj->text->text('CodigoSustento',"texto" ,'coddocsustento' ,80,80, $datos ,'','readonly','div-2-4') ;
                  
                  
                  $this->obj->text->text('Novedad',"texto" ,'cab_observacion' ,80,80, $datos ,'','readonly','div-2-10') ;
                  
               
                  
                  $this->set->div_panel6('fin');
                  
                  
                    
                  $this->set->div_panel6('<b> DATOS TRASLADO Y DESTINATARIO </b>');
 
                    
            
                     $this->obj->text->text('Fecha LLegada',"date" ,'fechafintransporte' ,80,80, $datos ,'required','','div-2-10') ;
                
                     $this->obj->text->text('Identificacion',"texto" ,'identificaciondestinatario' ,80,80, $datos ,'required','','div-2-10') ;
                     
                     $this->obj->text->text('Destinatario',"texto" ,'razonsocialdestinatario' ,80,80, $datos ,'required','','div-2-10') ;
                    
                     $this->obj->text->text('Direccion',"texto" ,'dirdestinatario' ,80,80, $datos ,'required','','div-2-10') ;
                     
                     $this->obj->text->text('Motivo',"texto" ,'motivotraslado' ,80,80, $datos ,'required','','div-2-10') ;
                     
                     $this->obj->text->text('Ruta',"texto" ,'ruta' ,80,80, $datos ,'required','','div-2-10') ;
                    
                  $this->set->div_panel6('fin');
                       
                  
                      
                   
                   $this->set->div_panel6('<b> DETALLE DE LA FACTURA </b>');
                   
                   echo ' <button type="button" class="btn btn-info" onClick="PoneDato();" >Ver factura</button>  ';
                   
                   echo '<div id="det_factura"> </div>  ';
                   
                   $this->set->div_panel6('fin');
                 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("des_codigo",$datos); 
         
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   $eventof = "javascript:ElectronicoTool()";
   
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Emitir Factura Electronica', evento =>$eventof,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button"),
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
 
  