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
        
                $this->formulario = 'Model-variables_sistema.php';
                
                $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
                
      }
   
     function Formulario( ){
      
         
         $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
         
         $this->set->body_tab($titulo,'inicio');
         
         
         $this->BarraHerramientas();
         
     		$this->set->div_label(12,'<h6> Definicion de variables<h6>');
     	
     	
             
                
                $this->obj->text->text('Variable',"texto",'variable',70,70,$datos,'required','','div-3-9') ;
                
                
                 $evento = 'onchange="javascript:valida()"';
                 $MATRIZ = array(
                 		''    => 'Seleccione tipo',
                		'caracter'    => 'caracter',
                		'numerico'    => 'numerico',
                 		'email'    => 'email',
                        'date'    => 'date',
                 		'condicion'    => 'condicion',
                		'lista'    => 'lista',
                		'listaDB'    => 'listaDB',
                 		'vinculo'    => 'vinculo'
                		
                );
                
                $this->obj->list->listae('Tipo Variable',$MATRIZ,'tipo',$datos,'required','',$evento,'div-3-9');
                
                $evento = '';
                $MATRIZ = array(
                		'S'    => 'SI',
                		'N'    => 'NO',
                );
                
                $this->obj->text->text('Orden',"number",'orden',40,45,$datos,'required','','div-3-9') ;
                
                $this->obj->list->listae('Activo',$MATRIZ,'estado',$datos,'required','',$evento,'div-3-9');
 
                
                $this->set->div_label(12,'<h6> Variable enlace DB<h6>');
                           
                $evento = '';
                
                $MATRIZ = array(
                		'-'    => '-',
                		'view_proveedor'    => 'Proveedor',
                		'view_cliente'    => 'Clientes',
                		'view_personal'    => 'Funcionario',
                		'view_usuario'    => 'Usuarios',
                		'view_unidad' => 'Departamentos',
                		'view_producto' => 'Productos'
                		
                		
                );
                
                $this->obj->list->listae('ListaDB',$MATRIZ,'tabla',$datos,'required','disabled',$evento,'div-3-9');
              
                
                $this->obj->text->text('Lista Separar con [ , ]',"texto",'lista',70,70,$datos,'required','readonly','div-3-9') ;
               
                 
                
	         $this->obj->text->texto_oculto("action",$datos); 
	                
 	         
	         $this->obj->text->texto_oculto("idvariable",$datos); 
	         
 	         
	         $this->set->evento_formulario('-','fin'); 
	      
	         
 
   }
 
   //----------------------------------------------
  //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
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
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  