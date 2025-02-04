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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-compromiso.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
        
        $tipo = $this->bd->retorna_tipo();
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
   
                
                $this->set->div_label(12,'TRAMITE DE PEDIDO DE CERTIFICACION PRESUPUESTARIA');
                
                
                $this->obj->text->text('<b>TRAMITE</b>',"number" ,'id_tramite' ,80,80, $datos ,'','readonly','div-2-4') ;
                $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                
                $MATRIZ = array(
                    'S'  => 'SI',
                    'N'  => 'NO',
                    'X'  => 'REFORMA'
                );
                $evento='';
                $this->obj->list->listae('Planificado?',$MATRIZ,'planificado',$datos,'','',$evento,'div-2-4');
                
          //      $this->obj->text->text('Comprobante',"texto" ,'comprobante' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                
                $this->obj->text->text_yellow('Documento',"texto" ,'documento' ,80,80, $datos ,'required','','div-2-4') ;
                 
                  
                $this->obj->text->editor('Detalle','detalle',4,45,550,$datos,'required','','div-2-10') ;
                
                $MATRIZ = $this->obj->array->catalogo_compras();
                $evento='';
                $this->obj->list->listae('Proceso Contratacion',$MATRIZ,'tipocp',$datos,'','',$evento,'div-2-10');
                
                
                $this->set->div_label(12,'ASIGNACION RESPONSABLES TRAMITE');
                
                
                
                
                $resultado = $this->bd->ejecutar("select 0 as codigo , '  [  Unidad Responsable ]' as nombre union
                                                   SELECT id_departamento AS codigo,  nombre
													FROM nom_departamento
                                                    where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc ,true)."
                                                           ORDER BY 2");
                
                $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'required','','div-2-4');
                
                
                $resultado = $this->bd->ejecutar("select '-' as codigo , '  [  Solicita Tramite ]' as nombre union
                                                   SELECT email AS codigo, completo  as nombre
													FROM par_usuario
                                                    where estado = ".$this->bd->sqlvalue_inyeccion('S',true)." AND
                                                          tarea = ".$this->bd->sqlvalue_inyeccion('S',true)."
                                                           ORDER BY 2 ");
                
                $this->obj->list->listadb($resultado,$tipo,'Solicitado','solicita',$datos,'required','','div-2-4');
                
                
                $resultado = $this->bd->ejecutar("select '-' as codigo , '  [  Asignar Responsable ]' as nombre union
                                                   SELECT email AS codigo, completo  as nombre
													FROM par_usuario
                                                    where estado = ".$this->bd->sqlvalue_inyeccion('S',true)." AND 
                                                          tarea = ".$this->bd->sqlvalue_inyeccion('S',true)."
                                                           ORDER BY 2 ");
                
                $this->obj->list->listadb($resultado,$tipo,'Asignar a','sesion_asigna',$datos,'required','','div-2-10');
                
          
                $this->set->div_label(12,'DEFINIR PROCESO TRAMITE');
   
                $MATRIZ = array(
                    '1'  => '1. Requerimiento Solicitado',
                    '2'  => '2. Tramite Autorizado',
                    '3'  => '3. (*) Emitir Certificacion',
                    '5'  => '5. Compromiso Presupuestario',
                    '6'  => '6. Tramites Devengado',
                    '0'  => 'Anulada transaccion'
                );
                
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'','disabled',$evento,'div-2-4');
                
      	        $this->obj->text->texto_oculto("action",$datos); 
      	 
             
          $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    $evento1 = "javascript:AnularTramite()";
       
       
    $ToolArray = array( 
        array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
        array( boton => 'Enviar informacion', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  ,
        array( boton => 'Anular Tramite',  evento =>$evento1,  grafico => 'glyphicon glyphicon-remove' ,  type=>"button_danger")
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
    
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 