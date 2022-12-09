 <script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery(' #fat').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
 				    jQuery('#guardarAux').html(data);
            
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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
   
     function Formulario( ){
      
         $tipo = $this->bd->retorna_tipo();
         
         $datos = array();
     
          
         $sqlb = " SELECT  codigo, nombre
									  FROM flow.view_variables";
          
          $resultado = $this->bd->ejecutar($sqlb);
         
          $evento = 'onChange="AsignaVariableG(this.value);"';
          
          $this->obj->list->listadbe($resultado,$tipo,'Variables Definidas','variableSistema',$datos,'','',$evento,'div-3-9');
         
         
     		$this->set->div_label(12,'<h6> Definicion de variables<h6>');
     	        
                $this->obj->text->text_yellow('Variable',"texto",'variable',120,120,$datos,'required','','div-2-4') ;
                 
                 $evento = 'onchange="javascript:valida()"';
                 
                 $MATRIZ = array(
                 		''    => 'Seleccione tipo',
                		'caracter'    => 'caracter',
                		'numerico'    => 'numerico',
                        'editor'    => 'editor',
                 		'email'    => 'email',
                        'date'    => 'date',
                 		'condicion'    => 'condicion',
                		'lista'    => 'lista',
                		'listaDB'    => 'listaDB',
                 		'vinculo'    => 'vinculo'
                		
                );
                
                $this->obj->list->listae('Tipo Variable',$MATRIZ,'tipo_var',$datos,'required','',$evento,'div-2-4');
                
                $evento = '';
                $MATRIZ = array(
                		'S'    => 'SI',
                		'N'    => 'NO',
                );

                $this->obj->text->text('Orden',"number",'orden',40,45,$datos,'required','','div-2-4') ;
                
                $this->obj->list->listae('Activo',$MATRIZ,'estado_var',$datos,'required','',$evento,'div-2-4');
                 
                $this->set->div_label(12,'<h6> Variable enlace DB<h6>');
                           
                $evento = '';
                
                $MATRIZ = array(
                		'-'    => '-',
                		'view_proveedor'    => 'Proveedor',
                		'view_cliente'    => 'Clientes',
                		'view_personal'    => 'Funcionario',
                		'view_usuario'    => 'Usuarios',
                		'view_unidad' => 'Departamentos',
                		'view_producto' => 'Productos',
                        'view_cargo' => 'Cargos'
                		
                		
                );
                
                $this->obj->list->listae('ListaDB',$MATRIZ,'tabla',$datos,'required','disabled',$evento,'div-3-9');
              
                
                $this->obj->text->editor('Lista Separar con [ , ]','lista',2,70,250,$datos,'required','disabled','div-3-9');
                
                
                //$this->obj->text->text('Lista Separar con [ , ]',"texto",'lista',250,250,$datos,'required','readonly','div-3-9') ;
               
                 
                
	         $this->obj->text->texto_oculto("action",$datos); 
	                
	         $this->obj->text->texto_oculto("idproceso",$datos); 
	         
	         $this->obj->text->texto_oculto("sistema",$datos); 
	         
	         $this->obj->text->texto_oculto("idproceso_var",$datos); 
	         
	         //$this->obj->text->text('Secuencia',"number",'idproceso_var',40,45,$datos,'','readonly','div-3-9') ;
	         
 
   }
 
   //----------------------------------------------
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
 
  