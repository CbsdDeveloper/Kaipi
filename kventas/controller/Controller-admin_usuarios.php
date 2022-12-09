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
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-admin_usuarios.php'; 
   
               $this->evento_form = '../model/Model-admin_usuarios.php';        // eventos para ejecucion de editar eliminar y agregar 
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
                
             
                    // idusuario, login, estado, email, cedula , nombre, apellido, idciudad, direccion
                    // telefono, movil, tipo, clave, nomina, caja, supervisor,noticia,tarea ,url
                   
 
                    $this->obj->text->text('Id',"number",'idusuario',0,10,$datos,'','readonly','div-2-4') ; 
                    
                    $this->obj->text->text('Login',"texto",'login',20,15,$datos,'required','','div-2-4') ; 
                    
                    $MATRIZ =  $this->obj->array->catalogo_activo();
              	    
                    $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                    
                    $resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre 
                								from par_catalogo 
                								where tipo = 'canton' and publica = 'S' order by nombre ");
                	$tipo = $this->bd->retorna_tipo();
                	
                	$this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
                    
                                  
                    $this->obj->text->text('Email',"email",'email',30,45,$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('Identificación',"texto",'cedula',20,15,$datos,'required','','div-2-4') ; 
                  
                    $this->obj->text->text('Nombre',"texto",'nombre',40,45,$datos,'required','','div-2-4');
                   
                    $this->obj->text->text('Apellido',"texto",'apellido',40,45,$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('Domicilio',"texto",'direccion',40,45,$datos,'required','','div-2-10');
                    
                   
                    $this->obj->text->text('Teléfono',"texto",'telefono',40,45,$datos,'required','','div-2-4');
                   
                    $this->obj->text->text('Móvil',"texto",'movil',40,45,$datos,'required','','div-2-4');

                    $MATRIZ =  $this->obj->array->catalogo_perfil();
                    
                	$this->obj->list->lista('Perfil',$MATRIZ,'tipo',$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('Contraseña',"password",'clave',40,45,$datos,'required','','div-2-4');
                    
                    
                    $MATRIZ =  $this->obj->array->catalogo_sino();
                	$this->obj->list->lista('Nomina?',$MATRIZ,'nomina',$datos,'required','','div-2-4');
                    
                 	$MATRIZ =  $this->obj->array->catalogo_sino();
                	$this->obj->list->lista('Es cajero?',$MATRIZ,'caja',$datos,'required','','div-2-4');
                	
                    $MATRIZ =  $this->obj->array->catalogo_sino();
                	$this->obj->list->lista('Supervisor?',$MATRIZ,'supervisor',$datos,'required','','div-2-4');
                    
                    $MATRIZ =  $this->obj->array->catalogo_sino();
                	$this->obj->list->lista('Noticia?',$MATRIZ,'noticia',$datos,'required','','div-2-4');
                	 
                    $MATRIZ =  $this->obj->array->catalogo_sino();
                	$this->obj->list->lista('Tarea?',$MATRIZ,'tarea',$datos,'required','','div-2-4');
                    
                    $this->obj->text->text('path archivo',"texto",'url',40,45,$datos,'required','readonly','div-2-4');
                 
                    
                  $path_imagen = '<a href="'."javascript:open_pop('../../upload/upload','',650,300)".'">';
                    
                     
                    echo '<div class="col-md-2"></div>
							<div class="col-md-10" style="padding-bottom:5px; padding-top:5px">'.$path_imagen.'
                    			<img id="ImagenUsuario" width="100" height="100"></a>
                    		</div>';
                    
          
                      
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
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
   //----------------------------------------------
   function combodb(){
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>


 
  