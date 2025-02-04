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

              jQuery('#guardarAux').html( data  );

              jQuery( "#guardarAux" ).fadeOut( 1600 );

              jQuery("#guardarAux").fadeIn("slow");

             
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
        
        
      }
   
     function Formulario( ){
      
         $tipo = $this->bd->retorna_tipo();
         
         $datos = array();
          
         $sqlb            = "SELECT  codigo, nombre  FROM flow.view_variables";

         $sql_vistas      = "SELECT  codigo, nombre  FROM par_catalogo where tipo = 'WKFLOW VISTAS'
                             order by nombre asc";

        $sql_enlace       = "SELECT  codigo, nombre  FROM par_catalogo where tipo = 'WKFLOW FORMULARIOS'
                            order by nombre asc";

         $resultado       = $this->bd->ejecutar($sqlb);
        
         $resultado_vistas= $this->bd->ejecutar($sql_vistas);
        
         $resultado_enlace= $this->bd->ejecutar($sql_enlace);

         $evento          = 'onChange="AsignaVariableG(this.value);"';

         $evento_variable = 'onchange="valida()"';

         $MATRIZ = array(
             ''    => 'Seleccione tipo',
             'caracter'    => 'caracter',
             'numerico'    => 'numerico',
             'editor'    => 'editor',
             'email'    => 'email',
             'date'    => 'date',
             'condicion'    => 'condicion',
             'lista'    => 'lista',
             'check'    => 'check',
             'time'    => 'time',
             'listaDB'    => 'listaDB',
             'vinculo'    => 'vinculo'
        );

        $MATRIZ_SI = array(
          'S'    => 'SI',
          'N'    => 'NO',
        );
          

        $MATRIZ2 = array(
          '1'    => 'Columna 1',
          '2'    => 'Columna 2',
       );
       
         
                $this->obj->list->listadbe($resultado,$tipo,'Variables Definidas','variableSistema',$datos,'','',$evento,'div-3-9');
         
         
     		$this->set->div_label(12,'<h6> Definicion de variables<h6>');
     	        
                 $this->obj->text->text_yellow('Grupo Etiqueta',"texto",'etiqueta',50,50,$datos,'required','','div-2-10') ;


                 $this->obj->text->text_yellow('Variable',"texto",'variable',120,120,$datos,'required','','div-2-4') ;
                 
                 $this->obj->list->listae('Tipo Variable',$MATRIZ,'tipo_var',$datos,'required','',$evento_variable,'div-2-4');

                 $this->obj->text->text('Orden',"number",'orden',40,45,$datos,'required','','div-2-4') ;
                
                 $this->obj->list->listae('Activo',$MATRIZ_SI,'estado_var',$datos,'required','','','div-2-4');

                 $this->obj->list->lista('Columna',$MATRIZ2,'columna',$datos,'required','','div-2-4');
                 
        $this->set->div_label(12,'<h6> Variable enlace DB<h6>');
                           
                
                $this->obj->list->listadbe($resultado_vistas,$tipo,'ListaDB','tabla',$datos,'','','disabled','div-3-9');

                $this->obj->text->editor('Lista Separar con [ , ]','lista',2,70,250,$datos,'required','disabled','div-3-9');
                 

        $this->set->div_label(12,'<h6> Variable enlace Formularios<h6>');

                 
                
                $this->obj->text->text_yellow('Enlace vinculo (*)',"texto",'enlace_url',120,120,$datos,'','','div-3-9');
                
                 
                
	         $this->obj->text->texto_oculto("action",$datos); 
	                
	         $this->obj->text->texto_oculto("idproceso",$datos); 
	         
	         $this->obj->text->texto_oculto("sistema",$datos); 
	         
	         $this->obj->text->texto_oculto("idproceso_var",$datos); 
	         
 	         
 
   }
 
 
     
  }
  ///------------------------------------------------------------------------
    
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  