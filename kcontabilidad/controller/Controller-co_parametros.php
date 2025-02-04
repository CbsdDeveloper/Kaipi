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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-co_parametros.php'; 
   
               $this->evento_form = '../model/Model-co_parametros.php';        // eventos para ejecucion de editar eliminar y agregar 
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
                     
                $this->obj->text->text('Secuencia',"number",'secuencia',40,45,$datos,'required','readonly','div-2-4') ;
                
                $this->obj->text->text('Tipo catalogo',"texto",'tipo',70,70,$datos,'required','','div-2-4') ;
                
                $this->obj->text->text('Codigo Referencia',"texto",'codigo',30,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text('Valor calculo',"number",'valor1',40,45,$datos,'required','','div-2-4') ;
                
                
                $MATRIZ =  $this->obj->array->catalogo_activo();
                
                $this->obj->list->lista('Estado',$MATRIZ,'activo',$datos,'required','','div-2-10');
                
                $this->obj->text->editor('Detalle','detalle',2,70,100,$datos,'','','div-2-10');
                
                
                
                $this->obj->text->editor('Detalle parametro1','parametro1',2,70,100,$datos,'required','','div-2-10');
                $this->obj->text->editor('Detalle parametro2','parametro2',2,70,100,$datos,'required','','div-2-10');
                $this->obj->text->editor('Detalle parametro3','parametro3',2,70,100,$datos,'required','','div-2-10');
                
                
                $id = $_SESSION['ruc_registro'];
                
                $resultado =  $this->bd->ejecutar("select '-' as codigo, ' [ No Aplica ]' as nombre
        								 union
        							     select cuenta as codigo, trim(detalle)  || ' ( '|| cuenta || ' ) ' as nombre
        								 from co_plan_ctas
        								 where tipo_cuenta in ('I','R','F','X') and 
                                               univel = 'S' and 
                                               registro =". $this->bd->sqlvalue_inyeccion($id ,true)." order by 1 desc ");
                
                
                $tipo =  $this->bd->retorna_tipo();
                
                $this->obj->list->listadb($resultado,$tipo,'Cuenta Contable','cuenta',$datos,'','','div-2-10');	 
                
                 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
              //  array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
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
 
  