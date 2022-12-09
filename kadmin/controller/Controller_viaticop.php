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
  
    class Controller_viatico{
 
  
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
      function Controller_viatico( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
                
				$this->formulario = 'Model_viaticop.ph'; 
				
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
         
        $array = $this->bd->__user(  $this->sesion 	);
         
            
        $datos = array();
        
        $datos['idprov'] = trim($array['cedula']);
        $datos['razon']  = trim($array['completo']);
        $datos['cargo']  = trim($array['cargo']);
        $datos['unidad']  = trim($array['unidad']);
        $datos['id_departamento'] = $array['id_departamento'];
        $datos['fecha'] =  date("Y-m-d");
        
       
        
        $MATRIZ_TRAS = array(
            'Aereo'    => 'Aereo',
            'Terrestre'    => 'Terrestre',
            'Otros'    => 'Otros',
        );
        
        
        $MATRIZ_NOM = array(
            'Particular'    => 'Particular',
            'Privado'    => 'Privado',
            'Publico'    => 'Publico',
            'Otros'    => 'Otros',
        );
        
        $MATRIZ_BAN = array(
            'Ahorro'    => 'Ahorro',
            'Corriente'    => 'Corriente'
        );
         
        
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
  		
        $this->BarraHerramientas();
        
        
        $this->set->div_panel12('<b> SOLICITUD DE VIATICOS COMISION  </b>');
        
                $this->obj->text->text('Nro.Viatico','number','id_viatico',10,10,$datos ,'','readonly','div-2-4') ;
                $this->obj->text->text('Estado','texto','estado',10,10,$datos ,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Documento',"texto" ,'documento' ,80,80, $datos ,'required','readonly','div-2-4') ;
        
        $this->set->div_panel12('fin');
        
        
        $this->set->div_panel6('<b> DATOS GENERALES  </b>');
        
                $this->obj->text->text_blue('Solicita',"texto",'razon',40,45,$datos,'required','readonly','div-2-10');
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;
                $this->obj->text->text('Unidad','texto','unidad',10,10,$datos ,'','readonly','div-2-6') ;
                $this->obj->text->text('Cargo','texto','cargo',10,10,$datos ,'','readonly','div-0-4') ;
                
        $this->set->div_panel6('fin');
        
        $this->set->div_panel6('<b> CIUDAD - PROVINCIA DE LA COMISION </b>');
        
        $this->obj->text->text_yellow('<b>Ciudad Comision</b>',"texto" ,'ciudad_comision' ,120,120, $datos ,'required','','div-2-10','S') ;
              
              $this->obj->text->text_yellow('Fecha salida',"date" ,'fecha_salida' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text_yellow('Hora salida',"texto" ,'hora_salida' ,80,80, $datos ,'required','','div-2-4') ;
              
              $this->obj->text->text_blue('Fecha llegada',"date" ,'fecha_llegada' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text_blue('Hora llegada',"texto" ,'hora_llegada' ,80,80, $datos ,'required','','div-2-4') ;
              
        
        $this->set->div_panel6('fin');
        
        
        $this->set->div_panel6('<b> SERVIDORES QUE INTEGRAN LA COMISION  </b>');
        
             $this->obj->text->editor('Servidores','servidores',4,105,500,$datos,'required','','div-2-10','S') ;
        
        $this->set->div_panel6('fin');
        
        $this->set->div_panel6('<b> DESCRIPCION DE LAS ACTIVIDADES A EJECUTARSE: </b>');
        
              $this->obj->text->editor('Descripcion','motivo',4,105,500,$datos,'required','','div-2-10','S') ;
        
        $this->set->div_panel6('fin');
        
        
        
        $this->set->div_panel6('<b> DATOS DE MOVILIZACIÓN IDA </b>');
        
         
                $this->obj->list->lista('Tipo Trasporte',$MATRIZ_TRAS,'tipo_tras1',$datos,'required','','div-3-9');
                $this->obj->list->lista('Nombre Trasporte',$MATRIZ_NOM,'nombre_tras1',$datos,'required','','div-3-9');
                $this->obj->text->text_yellow('Ruta',"texto" ,'ruta1' ,150,150, $datos ,'required','','div-3-9','S') ;

                $this->obj->text->text_yellow('Fecha Salida',"date" ,'fecha_sa1' ,80,80, $datos ,'required','','div-3-6') ;
                $this->obj->text->text_yellow('Hora',"texto" ,'hora_sa1' ,80,80, $datos ,'required','','div-0-3') ;
            
                $this->obj->text->text_yellow('Fecha Llegada',"date" ,'fecha_sa11' ,80,80, $datos ,'required','','div-3-6') ;
                $this->obj->text->text_yellow('Hora',"texto" ,'hora_sa11' ,80,80, $datos ,'required','','div-0-3') ;
            
         
        $this->set->div_panel6('fin');
        
        
        
        $this->set->div_panel6('<b> DATOS DE MOVILIZACIÓN VUELTA </b>');
        
                $this->obj->list->lista('Tipo Trasporte',$MATRIZ_TRAS,'tipo_tras2',$datos,'required','','div-3-9');
                $this->obj->list->lista('Nombre Trasporte',$MATRIZ_NOM,'nombre_tras2',$datos,'required','','div-3-9');
                $this->obj->text->text_blue('Ruta',"texto" ,'ruta2' ,150,150, $datos ,'required','','div-3-9','','S') ;
                
                $this->obj->text->text_blue('Fecha Salida',"date" ,'fecha_sa2' ,80,80, $datos ,'required','','div-3-6') ;
                $this->obj->text->text_blue('Hora',"texto" ,'hora_sa2' ,80,80, $datos ,'required','','div-0-3') ;
                
                $this->obj->text->text_blue('Fecha Llegada',"date" ,'fecha_sa22' ,80,80, $datos ,'required','','div-3-6') ;
                $this->obj->text->text_blue('Hora',"texto" ,'hora_sa22' ,80,80, $datos ,'required','','div-0-3') ;
        
        $this->set->div_panel6('fin');
        

        
        $this->set->div_label(12,'<b>(*) DATOS PARA TRANSFERENCIA</b> ');
        
        $this->set->div_panel6('<b>INFORMACION FINANCIERA </b>');
        
              $this->obj->list->lista('Tipo Cuenta',$MATRIZ_BAN,'tipo_cuenta',$datos,'','','div-3-9');
              $this->obj->text->text('Nro.Cuenta',"texto" ,'nro_cuenta' ,80,80, $datos ,'','','div-3-9') ;
              $this->obj->text->text_yellow('Banco',"texto" ,'banco' ,80,80, $datos ,'','','div-3-9','S') ;
        
        $this->set->div_panel6('fin');
        
        
      
        $this->set->div_panel6('<b>INFORMACION AUTORIZACIÓN </b>');
     
       
        $this->obj->text->textautocomplete('Responsable Unidad',"texto",'revisado',40,45,$datos,'required','','div-3-9');
        $this->obj->text->textautocomplete('Maxima Autoridad',"texto",'autorizado',40,45,$datos,'required','','div-3-9');
                
        echo '<div class="col-md-12" style="padding: 8px" align="center" > 
                <h4> Seleccionar el rol de autorización de la solicitud </h4>
            </div>';
         
        $this->set->div_panel6('fin');
        
        
        
        
        $this->set->div_label(12,'<b>(*) FORMULARIO PARA INFORME DE ACTIVIDADES Y PRODUCTOS ALCANZADOS</b> ');
        
      echo '<div class="col-md-12" >
              <div class="alert alert-info"><div class="container">';
        
         
                     
                    $this->obj->text->editor('COMENTARIO','comentario',5,500,500,$datos,'','','div-2-10','S') ;
                    
                    
                    $this->obj->text->text('Nro.Cur',"texto" ,'cur' ,80,80, $datos ,'','','div-2-10') ;
                     
                     
               //     $this->obj->text->editor('RESUMEN PRODUCTOS','productos',5,500,500,$datos,'','readonly','div-2-4','S') ;
                    
                     
         
        echo '</div></div></div>';
      
        
        $this->set->div_panel6('<b>INFORMACION PLANIFICACION </b>');
        
        
        $tipo       = $this->bd->retorna_tipo();
        
        $anio = date('Y');
        
        //-------------------------------------
      
        
    
        
        
        
        $resultado = $this->bd->ejecutar("SELECT 0 as codigo , '  --  00. Tarea Planificada  -- ' as nombre union
              SELECT idtarea AS codigo, tarea as nombre
               FROM planificacion.view_tarea_poa  
              where modulo = 'viaticos' and 
                    estado = 'S' and cumplimiento = 'N' and 
                    id_departamento = ".$this->bd->sqlvalue_inyeccion($datos['id_departamento'] ,true)." and
                    anio=".$this->bd->sqlvalue_inyeccion($anio,true). "ORDER BY 2"   );
        
        
        $evento = "Onchange=PoneTarea(this.value)";
        $this->obj->list->listadbe($resultado,$tipo, '<b>Actividad/Tarea</b>','id_tarea',$datos,'required','',$evento,'div-2-10');
        
     
        $this->obj->text->text('<b>Asignado</b>',"texto" ,'codificado' ,80,80, $datos ,'','readonly','div-2-10') ;
        
        $this->obj->text->text('<b>Solicitado</b>',"texto" ,'certificacion' ,80,80, $datos ,'','readonly','div-2-10') ;
        
        $this->obj->text->text_blue('<b>Disponible</b>',"texto" ,'disponible' ,80,80, $datos ,'','readonly','div-2-10') ;
        
       
         
        $this->set->div_panel6('fin');
        
        
        
		 $this->obj->text->texto_oculto("action",$datos); 
		 
		 $this->set->_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
     $evento = 'javascript:aprobacion()';
     
     $formulario_impresion = '../../reportes/viatico_solicitud.php';
     $eventoi = 'url_comprobante('."'".$formulario_impresion."')";
     
     $formulario_impresion = '../../reportes/viatico_informe.php';
     $eventop = 'url_comprobante('."'".$formulario_impresion."')";
       
     
     $ToolArray = array(
          array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
         array( boton => 'Solicitud de Viaticos', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_info") ,
         array( boton => 'Informe de Viaticos', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
         array( boton => 'Contabilizar Solicitud de Viaticos',  evento =>$evento,  grafico => 'glyphicon glyphicon-transfer' ,  type=>"button_danger"),
       
      );
   
    
    $this->obj->boton->ToolMenuDiv($ToolArray); 
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  //----------------------------------------------
 }    
   $gestion   = 	new Controller_viatico;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>


<script type="text/javascript">

 jQuery.noConflict(); 
 
 jQuery('#revisado').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU_a.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery('#autorizado').typeahead({
	    source:  function (query, process) {
     return $.get('../model/AutoCompleteCIU_a.php', { query: query }, function (data) {
     		console.log(data);
     		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 
</script>
  