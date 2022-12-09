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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-admin_usuarios.php'; 
   
               $this->evento_form = '../model/Model-admin_usuarios.php';       
        
     }        

       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
 
      function Formulario( ){
      
 
        $this->set->_formulario( $this->evento_form,'inicio' );  
        
        $datos = array();
        
        $tipo = $this->bd->retorna_tipo();

        $MATRIZ    =  $this->obj->array->catalogo_activo();

        $MATRIZP   =  $this->obj->array->catalogo_perfil();

 
        $MATRIZ_C = array(
            '1'    => '1',
            '5'    => '5',
             '500'    => 'ControlMedio',
            '1500'    => 'ControlAlto',
            '9999'    => 'Ilimitada',
         );

         $MATRIZ_P = array(
            '0'    => 'Normal',
            '2'    => 'Financiero Empresa Publica',
            '3'    => 'Usuario Operativo',
            '5'    => 'Responsable Causas',
            '6'    => 'Responsable Planificacion Unidad',
            '9'    => 'Caja - Servicios',
         );

         $MATRIZ_SINO = array(
          'S'    => 'SI',
          'N'    => 'NO'
        );

        $resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre 
                        from par_catalogo 
                        where tipo = 'canton' and publica = 'S' order by nombre ");

        $resultado_depa = $this->bd->ejecutar("select id_departamento as codigo, nombre
                        from nom_departamento
                        where estado = 'S' order by 1 ");

        $resultado_re = $this->bd->ejecutar("SELECT ruc_registro as codigo, razon   as nombre
                                                    FROM web_registro
                                                    where estado = 'S'
                                                    order by 1");

     
                $this->BarraHerramientas();
       
                $this->set->div_panel12('<b> DATOS DE USUARIO </b>');
                
                 $this->set->div_label(12,'Buscar funcionario de nomina para creacion de usuario de sistema');  
                
                            $this->obj->text->textautocomplete('<b>Nombre Funcionario</b>',"texto",'brazon',40,45,$datos,'','','div-2-10');


                 $this->set->div_label(12,'Informacion Personal ');                              
                
                            $this->obj->text->text('Id',"number",'idusuario',0,10,$datos,'','readonly','div-2-4') ; 
                    
                            $this->obj->text->text('Login',"texto",'login',20,15,$datos,'required','','div-2-4') ; 
                    
                            $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                	
                	          $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
                     
                            $this->obj->text->text('Email',"email",'email',30,45,$datos,'required','','div-2-4');
                            
                            $this->obj->text->text('Identificación',"texto",'cedula',20,15,$datos,'required','','div-2-4') ; 
                            
                            $this->obj->text->text_yellow('Nombre',"texto",'nombre',40,45,$datos,'required','','div-2-4');
                            
                            $this->obj->text->text_yellow('Apellido',"texto",'apellido',40,45,$datos,'required','','div-2-4');
                            
                            $this->obj->text->text('Domicilio',"texto",'direccion',40,45,$datos,'required','','div-2-10');
                        
                            $this->obj->text->text('Teléfono',"texto",'telefono',40,45,$datos,'required','','div-2-4');
                        
                            $this->obj->text->text('Móvil',"texto",'movil',40,45,$datos,'required','','div-2-4');

                    $this->set->div_panel12('fin');
                    
                    
                    $this->set->div_panel12('<b> UNIDAD DE GESTION  </b>');
                    
                	        $this->obj->list->lista('Perfil',$MATRIZP,'tipo',$datos,'required','','div-2-4');
                 	   	
                	        $this->obj->list->listadb($resultado_depa,$tipo,'Unidad','id_departamento',$datos,'required','','div-2-4');
                	
                            $this->obj->list->lista('Conexion permitida',$MATRIZ_C,'enlace',$datos,'required','','div-2-4');
                	
                	        $this->set->div_label(12,'<h5><b> DATOS DE GESTION </b></h5>');
                	
                                            $this->obj->list->lista('Nomina?',$MATRIZ_SINO,'nomina',$datos,'required','','div-2-4');
                                    
                                            $this->obj->list->lista('Archivo',$MATRIZ_SINO,'noticia',$datos,'required','','div-2-4');
                                    
                                            $this->obj->list->lista('Tarea?',$MATRIZ_SINO,'tarea',$datos,'required','','div-2-4');
                                    
                                            $this->obj->list->lista('Responsable?',$MATRIZ_SINO,'responsable',$datos,'required','','div-2-4');
                                    
                                            $this->obj->text->text('Contraseña',"password",'clave',40,45,$datos,'required','','div-2-4');
                                    
                                            $this->obj->text->text('path archivo',"texto",'url',40,45,$datos,'required','readonly','div-2-4');
                     
                                            $file           = "javascript:openFile('../../upload/upload?file=2',650,300)";
                                            $path_imagen    = '<a href="#" onClick="'.$file.'">';
                                    
                                            echo '<div class="col-md-2"></div>
                                                    <div class="col-md-10" style="padding-bottom:5px; padding-top:5px">'.$path_imagen.'
                                                        <img id="ImagenUsuario" width="100" height="100"></a>
                                                    </div>';
                    
                    $this->set->div_panel12('fin');
                              
                                $datos['establecimiento']='001';
                                $this->obj->text->texto_oculto("establecimiento",$datos); 
                    
               
                    $this->set->div_panel12('<b> USUARIOS CAJEROS -RECAUDACION </b>');
                    
                                    $this->obj->list->lista('Es cajero?',$MATRIZ_SINO,'caja',$datos,'required','','div-2-4');
                                    
                                    $this->obj->list->lista('Supervisor?',$MATRIZ_SINO,'supervisor',$datos,'required','','div-2-4');
                                    
                                    $this->obj->text->text('Establecimiento',"texto",'establecimiento',3,3,$datos,'','','div-2-4');

                                    $this->obj->list->lista('Es Director?',$MATRIZ_SINO,'director',$datos,'required','','div-2-4');
                        
                
                            $this->set->div_label(12,'<h5><b> ACCESO ADICIONAL </b></h5>');
                      
                                     $this->obj->list->listadb($resultado_re,$tipo,'Acceso a','empresas',$datos,'required','','div-2-4');


                                     $this->obj->list->lista('Rol adicional ',$MATRIZ_P,'rol',$datos,'required','','div-2-4');
                    
                    
                    $this->set->div_panel12('fin');
                    
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 //  $evento = 'javascript:open_editor();';
   
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
       
       $datos = array();
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
    
       $datos = array();
       
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
<script type="text/javascript">

 jQuery.noConflict(); 
 
 jQuery('#brazon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

 // nombre,, cedula,email
 
 jQuery("#brazon").focusout(function(){
	 
	 var itemVariable = $("#brazon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDMultiple.php',
											type:  'GET' ,
											  dataType: 'json',  
											beforeSend: function () {
												$("#cedula").val('...');
											},
											success:  function (response) {
												$("#cedula").val(response.a);   
												$("#apellido").val(response.b);  
												$("#nombre").val(response.c);  
												$("#email").val(response.d);  
												$("#nomina").val('S');  

												$("#login").val(response.e);  
												$("#idciudad").val(response.f);  
												$("#direccion").val(response.g);  
												$("#telefono").val(response.h);  
												$("#movil").val(response.i);  
												$("#id_departamento").val(response.j); 
 												
											} 
									});
 			  	 
					                          
					                          
									 
    });
 
 //----------------------------------------------
  
  
  
</script>
  