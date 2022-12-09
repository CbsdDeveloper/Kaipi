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
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
               
            	  jQuery('#result').html(data.resultado);
 				  jQuery( "#result" ).fadeOut( 1600 );
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  jQuery("#idpre_catologo").val(data.id );
              	            
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
        
                
               $this->formulario = 'Model-catalogo.php'; 
   
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
      
        $datos  = array();
         
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
    
    
                $this->BarraHerramientas();
                
                
                $this->obj->text->text('Id',"number" ,'idpre_catologo' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                  
                $MATRIZ = array(
                    'S'    => 'Si',
                    'N'    => 'No'
                );
                $this->obj->list->lista('Activo',$MATRIZ,'estado',$datos,'','','div-2-4');
                
                
                
                $MATRIZ = array(
                    'catalogo'    => 'Catalogo Lista',
                    'arbol'    => 'Catalogo Arbol'
                );
                $this->obj->list->lista('Estructura',$MATRIZ,'tipo',$datos,'','','div-2-4');
                
                
                
                $MATRIZ = array(
                    'S'    => 'Si',
                    'N'    => 'No'
                );
                
                $this->obj->list->lista('Transaccion',$MATRIZ,'transaccion',$datos,'','','div-2-4');
                
                
                $MATRIZ = array(
                    'programa'     => 'Programa',
                    'actividad'    => 'Actividad',
                    'proyecto'    => 'proyecto',
                    'competencia'  => 'competencia',
                    'orientador'    => 'Orientador de gastos',
                    'clasificador'    => 'Clasificador',
                    'fuente'    => 'Fuente',
                 );
                
                $this->obj->list->lista('Categoria',$MATRIZ,'categoria',$datos,'','','div-2-4');
                
                
                $MATRIZ = array(
                    '-'    => 'No Aplica',
                    'gasto'    => 'Gasto',
                    'ingreso'    => 'Ingreso'
                );
                
                $this->obj->list->lista('SubCategoria',$MATRIZ,'subcategoria',$datos,'','','div-2-4');
                
                
                
                $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('Codigo',"texto" ,'codigo' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                
                $MATRIZ = array(
                    '0'    => 'No Aplica',
                    '1'    => 'Nivel 1',
                    '2'    => 'Nivel 2',
                    '3'    => 'Nivel 3',
                    '4'    => 'Nivel 4',
                    '5'    => 'Nivel 5',
                );
                
                
                $this->obj->list->lista('Nivel',$MATRIZ,'nivel',$datos,'','','div-2-4');
          
                $this->set->div_label(12,' Gestion parametrizacion clasificadores ');	 
                
             
                $MATRIZ = array(
                    'N'    => 'No Aplica',
                    'S'    => 'PAC'
                );
                
                
                $this->obj->list->lista('Aplica PAC',$MATRIZ,'pac',$datos,'','','div-2-4');
                
                $MATRIZ = array(
                    'N'    => 'No Aplica',
                    'B'    => 'Bienes Larga Duracion',
                    'E'    => 'Existencias' 
                );
                
                
                $this->obj->list->lista('Modulo',$MATRIZ,'modulo',$datos,'','','div-2-4');
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
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
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
 ///------------------------------------------------------------------------
 ///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
   
  $gestion->Formulario( );
  
 ?>