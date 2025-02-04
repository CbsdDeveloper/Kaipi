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
        
                
               $this->formulario = 'Model-perfil_usuarios.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
    
    
      //---------------------------------------
      
     function Formulario( ){
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                
                $datos = $this->consultaId();
             
         
                $url = $this->pathFile(2);
                     
                 
                $imagen = $url.trim($datos['url']);
                
                echo '<div class="col-md-2" style="padding: 2px">';
                
                    $file = "openFile('../../upload/upload?file=2',650,300)";
                    
                    $path_imagen = '<a href="#" onClick="'.$file.'">';
                    
                   
                    
                    
                    echo '<div class="col-md-10" style="padding-bottom:5px; padding-top:5px">'.$path_imagen.'
                        			<img id="ImagenUsuario" src="'.$imagen.'" width="100" height="100"></a>
                        		</div>';
              
                 echo '</div>
                        <div class="col-md-10" style="padding: 2px">';
 
                     
                    $this->obj->text->text('Login',"texto",'login',20,15,$datos,'','readonly','div-2-10') ; 
                    
                    $this->obj->text->text('Email',"email",'email',30,45,$datos,'','readonly','div-2-10');
                    
                    $this->obj->text->text('Identificación',"texto",'cedula',20,15,$datos,'','readonly','div-2-10') ; 
                  
                    $this->set->div_label(12,'<h5><b> CAMBIO DE CLAVE </b></h5>');
                    
                    
                    $evento = 'onBlur="valida(this.value)"';
                    
                    $this->obj->text->texte('Clave Anterior',"password",'anterior',40,45,$datos,'','',$evento,'div-2-4');
                     
                    $this->obj->text->texte('Clave Actual',"password",'clave',40,45,$datos,'','',$evento,'div-2-4');
                	
              
                    echo '</div>';
                 
                    
                 
                    
                    
                    
         $this->obj->text->texto_oculto("idusuario",$datos); 
               
         $this->obj->text->texto_oculto("url",$datos); 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
    
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
     
    $ToolArray = array( 
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function pathFile($id ){
      
      
      $ACarpeta = $this->bd->query_array('wk_config',
          'carpetasub',
          'tipo='.$this->bd->sqlvalue_inyeccion($id,true)
          );
      
      $carpeta = trim($ACarpeta['carpetasub']);
      
      return $carpeta;
      
  }
  //----------------------------------------------
  function consultaId(  ){
      
      
      
      $qquery = array(
          array( campo => 'idusuario',   valor =>'-' ,  filtro => 'N',   visor => 'S'),
          array( campo => 'login',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'email',   valor => $this->sesion,  filtro => 'S',   visor => 'S'),
          array( campo => 'cedula',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'idusuario',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'url',   valor => '-',  filtro => 'N',   visor => 'S')
      );
      
      
      $datos = $this->bd->JqueryArrayVisorDato('par_usuario',$qquery );
      
       return $datos;
  }	
  //-------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 
   
 ?>


 
  