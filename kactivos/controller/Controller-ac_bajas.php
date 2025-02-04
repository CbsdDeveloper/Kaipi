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
 			 	  
 			 	  jQuery("#id_acta").val(data.id );

 			 	  jQuery("#documento").val(data.documento ); 

 			 	  
            
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
        
                
               $this->formulario = 'Model-ac_bajas.php'; 
   
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
           
                $this->set->div_panel('<b> ACTA DE BAJA DE BIENES</b>');
                
              
 		                
                            $this->tab_1_datos_bienes( );
                   
         	              $this->obj->text->texto_oculto("action",$datos); 
         
 
         

         
             $this->set->div_panel('fin');
         
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
    $eventopa = 'AutorizarBaja()';
    
    
     $eventoe = 'editor_ficha()';

     $eventoi = 'url_ficha()';
       
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  ,
                array( boton => 'ADVERTENCIA... Autorizar Acta de Baja', evento =>$eventopa,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                 array( boton => 'Editor de Acta de Baja', evento =>$eventoe,  grafico => 'glyphicon glyphicon-text-width' ,  type=>"button_success"),
                 array( boton => 'Impresion de Acta de Baja', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default"),
        
                 );


                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function tab_1_datos_bienes( ){
      
 
      $datos = array();
  
      $tipo = $this->bd->retorna_tipo();
      
      
      $resultado = $this->bd->ejecutar("select idsede as codigo, nombre
                                            from activo.view_sede_user
                                            where  sesion=". $this->bd->sqlvalue_inyeccion( $this->sesion,true).' order by 2'
          );
      
      
      
      $this->obj->list->listadb($resultado,$tipo,'','idsede',$datos,'','','div-2-10');
      
      
      
      $this->obj->text->text('Id.Acta',"number",'id_acta',40,45,$datos,'required','readonly','div-2-4') ;
      
      
      $this->obj->text->text_yellow('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
      
       
   
      
      $MATRIZ = array(
          'Acta Baja de Bienes'    => 'Acta Baja de Bienes'
      );
      $this->obj->list->lista('Clase Documento',$MATRIZ,'clase_documento',$datos,'required','','div-2-4');
      
      
      $this->obj->text->text_blue('Nro.Acta','texto','documento',10,10,$datos ,'','readonly','div-2-4') ;
      
      
      $this->obj->text->editor('Detalle','detalle',3,70,100,$datos,'','','div-2-10');
      
      $this->obj->text->editor('Resolucion','resolucion',3,70,100,$datos,'','','div-2-10');
      
      $resultado =  $this->sql(1);
      
      $this->obj->list->listadb($resultado,$tipo,'Responsable','idprov',$datos,'','','div-2-4');
      
      $MATRIZ = array(
          'N'    => 'No',
          'S'    => 'SI',
      );
      $this->obj->list->lista('Autorizado',$MATRIZ,'estado',$datos,'','disabled','div-2-4');
      
      
      $datos['tipo'] = 'B';
       
      $this->obj->text->texto_oculto("tipo",$datos);
      
      $this->set->div_label(12,'<b>Referencia de activos</b>');
      
  
   
      
      
  }  
 //-----------------------------

 
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
///------------------------------------------------------------------------
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>
  