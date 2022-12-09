 <script >// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
            	  jQuery('#result').html(data.resultado);
            	  
 				  jQuery( "#result" ).fadeOut( 1600 );
 				  
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  
 			 	  jQuery("#id_bien_dep").val(data.id );

 			 	 jQuery("#estado").val(data.estado); 
 			 	 
 			 	 // BusquedaGrillaCustodio(oTable_doc);
            
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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ac_bienes_depre.php'; 
   
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
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
        $datos = array();
    
                $this->BarraHerramientas();
           
                $tipo = $this->bd->retorna_tipo();
                
                $this->set->div_panel('<b> PROCESO DE DEPRECIACION</b>');
                
                
                $this->obj->text->text('Referencia',"number",'id_bien_dep',40,45,$datos,'required','readonly','div-2-4') ;
                
                $MATRIZ = $this->obj->array->catalogo_anio();
                $this->obj->list->lista('Periodo',$MATRIZ,'anio',$datos,'','','div-2-4');
                  
                $this->obj->text->text('Autorizado','texto','estado',10,10,$datos ,'','readonly','div-2-4') ;
           
                $resultado =  $this->sql(1);
                
                $this->obj->list->listadb($resultado,$tipo,'Responsable','idprov',$datos,'','','div-2-4');
                
                $evento ='';
                
                $sql = "SELECT    cuenta as codigo, cuenta || ' ' || nombre_cuenta as nombre
                            FROM activo.view_bienes
                            where tipo_bien = 'BLD'
                            group by cuenta,  nombre_cuenta 
                            order by 1";
                
                $resultado = $this->bd->ejecutar("select '-' as codigo, '-  0. Seleccione Grupo  - ' as nombre union ". $sql);
                $this->obj->list->listadbe($resultado,$tipo,'Cuenta Contable','cuenta',$datos,'','',$evento,'div-2-10');
                
                
                $this->obj->text->editor('Detalle','detalle',3,70,100,$datos,'','','div-2-10');
                
                $MATRIZ = array(
                    'A'    => 'Anual',
                    'M'    => 'Mensual'
                );
                $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'','','div-2-10');
                
                $this->obj->text->text_blue('Inicio',"date",'fecha',15,15,$datos,'required','','div-2-4');
                $this->obj->text->text_yellow('Fin',"date",'fecha2',15,15,$datos,'required','','div-2-4');
                
             
                
                
                
                
                $this->obj->text->texto_oculto("action",$datos); 
                $this->obj->text->texto_oculto("mes",$datos); 
         
             $this->set->div_panel('fin');
         
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
       $eventopa = 'javascript:AutorizarTramite()';
       
       $eventope = 'javascript:EliminarTramite()';
       
       $eventoee = 'javascript:AnularTramite()';
       
       $formulario_impresion = '../reportes/fichaActivoDepre';
       $eventoi = 'javascript:url_ficha('."'".$formulario_impresion."')";
       
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
                array( boton => 'Generar proceso de depreciacion', evento =>$eventopa,  grafico => 'glyphicon glyphicon glyphicon-ok' ,  type=>"button_danger"),
                array( boton => 'Eliminar datos de depreciacion', evento =>$eventoee,  grafico => 'glyphicon glyphicon glyphicon-remove' ,  type=>"button_primary"),
                array( boton => 'Eliminar datos bienes a depreciacion', evento =>$eventope,  grafico => 'glyphicon glyphicon glyphicon-trash' ,  type=>"button_default"),
                array( boton => 'Generar reporte de depreciacion', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") 
        
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function sql($titulo){
      
      if  ($titulo == 1){
          
          $sqlb = "Select '-' as codigo, '[01. Seleccione responsable ]' as nombre
                    union
                    SELECT  idprov as codigo, razon || ' (' || unidad || ')' as nombre
                    FROM  view_nomina_rol
                    where responsable = 'S' order by 2";
          
      }
      
      
      
      
      $resultado = $this->bd->ejecutar($sqlb);
      
      
      return  $resultado;
      
  }  
///------------------------------------------------------------------------
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>
  