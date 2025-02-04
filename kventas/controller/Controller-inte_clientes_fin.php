<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#forma').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
                 jQuery('#guardarCliente').html(data);
            
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
        
                
               $this->formulario = 'Model-inte_clientes_fin.php'; 
   
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
      
 
      $this->set->evento_formulario_id( $this->evento_form,'inicio','forma' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
      
                $this->BarraHerramientas();
                     
                $tipo = $this->bd->retorna_tipo();
                
                echo '<h6> &nbsp; </h6>';
                
                
 
                $this->obj->text->text('Codigo',"texto",'idprov',90,95,$datos,'','readonly','div-2-4') ;
                
                
                $this->obj->text->text('<b>IDENTIFICACION</b>',"texto",'identificacion',90,95,$datos,'required','','div-2-4') ;
                
                $this->obj->text->text('Nombre ',"texto",'razon',90,95,$datos,'required','','div-2-10') ;
                   
                $this->obj->text->text('Direccion',"texto",'direccion',80,95,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text('Email',"email",'correo',60,75,$datos,'required','','div-2-10') ;
                
                
                $reg ="\d{2}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                $this->obj->text->textMask('Telefono',"tel",'telefono',18,20,$datos,'required','','',$reg,'div-2-4');
                
                $reg ="\d{3}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                
                $this->obj->text->textMask('Movil',"tel",'movil',18,20,$datos,'required','','',$reg,'div-2-4');
                
                   
                  
                $this->obj->text->text('Contacto ',"texto",'contacto',90,95,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text('web ',"texto",'web',40,45,$datos,'required','','div-2-10') ;
                
        
                $this->obj->text->text('Actualizado ',"texto",'actualizado',40,45,$datos,'','readonly','div-2-4') ;
                    
                      
                $this->obj->text->texto_oculto("idvencliente",$datos); 
                
                $this->obj->text->texto_oculto("canton",$datos); 
                
                $this->obj->text->texto_oculto("estado",$datos); 
                
                
                $this->obj->text->texto_oculto("provincia",$datos); 
                
         $this->obj->text->texto_oculto("actionCiu",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
    $ToolArray = array( 
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 );
                  
    $this->obj->boton->ToolMenuDivId($ToolArray,'guardarCliente'); 
 
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
 
  