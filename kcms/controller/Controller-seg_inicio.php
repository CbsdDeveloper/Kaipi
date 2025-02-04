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
        
                
               $this->formulario = 'Model-seg_inicio.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
    
                $this->BarraHerramientas();
              
                $this->set->nav_tab("#tab_1_1",'Informacion Documento',
                    "#tab_1_2",'Unidad de gestion',
                    "#tab_1_3",'Documentos Complementarios',
                    "",'',
                    "",''
                    );
                
                
                $this->K_tab_1_1('Detalle del Gasto');
                
                $this->K_tab_1_2('Valores Factura');
                
                $this->K_tab_1_3('Montos Retencion');
                
              
                $this->set->nav_tab('/');
           
         $this->obj->text->texto_oculto("estado",$datos); 
                
                        
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //---------------------------------------------
   function K_tab_1_1($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       $this->set->nav_tabs_inicio("tab_1_1",'active');
       
     
       
       $this->obj->text->text('Id','number','id_seg_proceso',10,10, $datos ,'','readonly','div-2-4') ;
       
       $MATRIZ = array(
           '2018'    => '2018',
           '2017'    => '2017',
           '2016'    => '2016' ,
           '2015'    => '2015' ,
           '2014'    => '2014',
           '2013'    => '2013',
           '2012'    => '2012'
       );
       
       $this->obj->list->lista('Periodo',$MATRIZ,'anio_perido',$datos,'required','','div-2-4');
       
       
       $MATRIZ = array(
           'Examen Especial'    => 'Examen Especial',
           'Auditoria Financiera'    => 'Auditoria Financiera',
           'Auditoria Gestion'    => 'Auditoria Gestion' ,
           'Auditoria Ambiental'    => 'Auditoria Ambiental' ,
           'Auditoria Obra Civil'    => 'Auditoria Obra Civil',
           'Cumplimiento Recomendaciones'    => 'Cumplimiento Recomendaciones'
       );
       
       $this->obj->list->lista('Tipo examen',$MATRIZ,'tipo_examen',$datos,'required','','div-2-4');
       
       
       $this->obj->text->text('Nro Documento','texto','nro_informe',35,35, $datos ,'required','','div-2-4') ;
       
       $this->obj->text->text('Periodo Analizado','texto','periodo',55,55, $datos ,'required','','div-2-10') ;
       
       $this->obj->text->text('Fecha Documento','date','fecha_apertura',10,10, $datos ,'required','','div-2-4') ;
       
       
       $this->obj->text->text('Fecha Entrega','date','fecha_cierre',10,10, $datos ,'','readonly','div-2-4') ;
       
       $this->obj->text->editor('Nombre Examen','nombre_examen',2,350,350,$datos,'','','div-2-10');
       
       $this->obj->text->editor('Recomendacion','tema_recomendacion',3,350,350,$datos,'','','div-2-10');
       
      
   
      
     
       
       $this->set->nav_tabs_cierre();
   }
   
   //-------------------------------
   
   function K_tab_1_2($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       
       $this->set->nav_tabs_inicio("tab_1_2",'');
       
     
       $MATRIZ = array(
           'No aplica'    => 'No aplica' ,
           'Cumplimiento Parcial'    => 'Cumplimiento Parcial',
           'Cumplimiento Total'    => 'Cumplimiento Total',
           'No cumplimiento'    => 'No cumplimiento' ,
           'Cumplimiento en proceso'    => 'Cumplimiento en proceso'
           
       );
       
       
       $this->obj->text->text('Cumplimiento','texto','cumplimiento',255,250, $datos ,'','readonly','div-2-4') ;
       
       
       $MATRIZ = array(
           'D'    => 'Digitado por enviar' ,
           'E'    => 'Enviar documento',
           'P'    => 'Proceso en ejecucion',
           'F'    => 'Finalizado' ,
           'A'    => 'Anulado'
           
       );
       
       $this->obj->text->text('Estado','texto','estado_tramite',15,15, $datos ,'','readonly','div-2-4') ;
       
       
       $evento =  ' onChange="javascript:FiltraPersonal(this.value)" ';
       
       $this->listaValores('Unidad Asignada','id_departamento',$evento);
       
       $evento ='';
       $this->listaValores('Responsable','idusuario_asignado',$evento);
       
       
       $this->obj->text->editor('Marco legal','marco_legal',3,350,300,$datos,'','','div-2-10');
       
       $this->obj->text->editor('Observacion','observacion',3,350,300,$datos,'','','div-2-10');
       
       
       $this->set->nav_tabs_cierre();
   }
   //-----------------------
   function K_tab_1_3($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       
       $this->set->nav_tabs_inicio("tab_1_3",'');
       
       $evento = '<a href="seg_file?idfile=1" rel="pop-up" class="btn btn-default btn-sm" title="Cargar Archivo">
	                              <span class="glyphicon glyphicon-folder-open"></span>  </a> ';
       
      
       $this->obj->text->text($evento,'texto','documento_respaldo',180,180, $datos ,'','readonly','div-2-10') ;
       
       
       echo '<p>&nbsp;</p>';
       
        
       $evento = '<a href="seg_file?idfile=2" rel="pop-up" class="btn btn-default btn-sm" title="Cargar Archivo">
	                              <span class="glyphicon glyphicon-folder-open"></span>  </a> ';
       
       $this->obj->text->text($evento,'texto','documento_digital',180,180, $datos ,'','readonly','div-2-10') ;
   
       
       $this->set->nav_tabs_cierre();
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
//----------------
  //----------------------------------------------
  function listaValores($titulo,$campo,$evento){
      
      $tipo = $this->bd->retorna_tipo();
      
      
      if  ($titulo == 'Unidad Asignada'){
          $sqlb = "select '0' as codigo, '[ Seleccione Unidad ]' as nombre 
                   union 
                   SELECT  id_departamento as codigo,   nombre
							                FROM nom_departamento
							                WHERE id_departamento <> -1
							                order by 2";
 
          
      }
      
      if  ($titulo == 'Responsable'){
          $sqlb = "select '0' as codigo, '[ Seleccione Responsable ]' as nombre ";
          
          
          
      }
      
      $resultado = $this->bd->ejecutar($sqlb);
     
      
      $this->obj->list->listadbe($resultado,$tipo,$titulo,$campo,$datos,'required','',$evento,'div-2-10');
      
      
       
  }  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>
 <script>
		var posicion_x; 
		var posicion_y; 
			posicion_x=(screen.width/2)-(450/2); 
			posicion_y=(screen.height/2)-(200/2); 

	    	$( document ).ready( function() {
				$("a[rel='pop-up']").click(function () {
					var caracteristicas = "height=220,width=550,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			 });
			 
			posicion_x=(screen.width/2)-(550/2); 
			posicion_y=(screen.height/2)-(350/2); 
			
			 $("a[rel='pop-upo']").click(function () {
					var caracteristicas = "height=350,width=550,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			 });
		});
</script>    

 
  