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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-nom_ingreso.php'; 
   
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
      
 
         $this->set->_formulario( $this->evento_form,'inicio' );  
  
        $datos = array();
    
                $this->BarraHerramientas();
                
                $tipo = $this->bd->retorna_tipo();
                
                
                
               /*  
                $this->set->div_label(12,   '</h5>BUSCAR INFORMACION PERSONAL</h5>');
                
                $this->obj->text->text_yellow('Ingresar Identificacion ',"texto",'cedulaa',40,45,$datos,'','','div-2-4');
                */
                
                $this->set->div_label(12,   '</h5>REGISTRO DE  INFORMACION PERSONAL</h5>');
              
                $MATRIZ = array(
                    '02'    => 'Cedula',
                    '01'    => 'RUC',
                    '03'    => 'Pasaporte'
                );
                
                $this->obj->list->lista('Tipo',$MATRIZ,'tpidprov',C,'required','','div-2-4');
                
                $evento = 'onBlur="javascript:validarCiu()"';
                
                $this->obj->text->texte('Identificacion',"texto",'idprov',20,15,$datos,'required','',$evento,'div-2-4') ; 
                
         
                $this->obj->text->text_yellow('Nombre',"texto",'nombre',40,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text_yellow('Apellido',"texto",'apellido',40,45,$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Direccion',"texto",'direccion',40,45,$datos,'required','','div-2-10');
            
 
                
                $resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre
                								from par_catalogo
                								where tipo = 'canton' and publica = 'S' order by nombre ");
                
                
                $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-10');
                
                
                
                $this->obj->text->text('Email',"email",'correo',30,45,$datos,'required','','div-2-4');
                
                
                $MATRIZ =  $this->obj->array->catalogo_activo();
                
                $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Telefono',"texto",'telefono',40,45,$datos,'required','','div-2-4');
                
                $this->obj->text->text('Movil',"texto",'movil',40,45,$datos,'required','','div-2-4');
                
                $this->set->div_label(12,'<h5><b> DATOS ADICIONALES </b></h5>');
                
                  
               
                $resultado = $this->bd->ejecutar("select id_departamento as codigo, nombre
                						from nom_departamento
                                        where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc  ,true)."
                                         order by nombre ");
                
                
                $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'required','','div-2-4');
                
                
                $MATRIZ =  $this->obj->array->catalogo_sino();
                
                $this->obj->list->lista('Responsable?',$MATRIZ,'responsable',$datos,'required','','div-2-4');
                
                
                $resultado = $this->bd->ejecutar("select id_cargo as codigo, nombre
                								from nom_cargo  order by nombre ");
                
                
                $this->obj->list->listadb($resultado,$tipo,'Cargo','id_cargo',$datos,'required','','div-2-4');
                
                
                
                
                 
                 
                
                $this->obj->text->text('Fecha ingreso',"date",'fecha',15,15,$datos,'required','','div-2-4');
                
                
                $datos['contrato']='SN';
                $this->obj->text->texto_oculto("contrato",$datos); 
                $datos['sueldo']='0';
                $this->obj->text->texto_oculto("sueldo",$datos); 
                
                $datos['regimen']='NOMBRAMIENTO';
                $this->obj->text->texto_oculto("regimen",$datos); 

           
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("razon",$datos); 
         
         $this->set->_formulario('-','fin'); 
  
      
   }
   //-------------
   function K_tab_1_1($titulo,$tipo){
       
       
      
       
       $this->set->nav_tabs_inicio("tab_1_1",'active');
           
       echo '<h5>&nbsp;</h5>';
       
        
       
       
       
           
       
       echo '<h5>&nbsp;</h5>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_2($titulo,$tipo){
       
       
       $datos = array();
       
       $this->set->nav_tabs_inicio("tab_1_2",'');
       
       echo '<h5>&nbsp;</h5>';
       
       
       $this->obj->text->text('Nacimiento',"date",'fechan',15,15,$datos,'required','','div-2-4');
       
       
       $MATRIZ =  $this->obj->array->catalogo_ecivil();
       
       $this->obj->list->lista('Estado Civil',$MATRIZ,'ecivil',$datos,'required','','div-2-4');
       
       
       
       $MATRIZ =  $this->obj->array->catalogo_nacionalidad();
       
       $this->obj->list->lista('Nacionalidad',$MATRIZ,'nacionalidad',$datos,'required','','div-2-4');
       
     
       $MATRIZ =  $this->obj->array->catalogo_etnia();
       
       $this->obj->list->lista('Etnia',$MATRIZ,'etnia',$datos,'required','','div-2-4');
       
 
       
       $MATRIZ =  $this->obj->array->catalogo_vivecon();
       
       $this->obj->list->lista('Vive con',$MATRIZ,'vivecon',$datos,'required','','div-2-4');
 
       
     
           $MATRIZ = array(
               '0'    => 'No Aplica',
               '1'    => '1 Persona',
               '2'    => '2 Personas',
               '3'    => '3 Personas',
               '4'    => '4 Personas',
               '5'    => '5 Personas',
               '6'    => '6 Personas'
           );
      
    
       
       $this->obj->list->lista('Cargas Familiares',$MATRIZ,'cargas',$datos,'required','','div-2-4');
       
       
       $MATRIZ =  $this->obj->array->catalogo_tipo_sangre();
       
       $this->obj->list->lista('Tipo de Sangre',$MATRIZ,'tsangre',$datos,'required','','div-2-4');
       
          
       echo '<h5>&nbsp;</h5>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_3($titulo,$tipo){
         
       
        
       $this->set->nav_tabs_inicio("tab_1_3",'');
       
       echo '<h5>&nbsp;</h5>';
     
       
       
        
        
       $cboton = 'Historia Laboral';
       
       $this->set->div_label(12,   $cboton.'</h5>');
       
          
       echo '<h5>&nbsp;</h5>
                 <div class="col-md-12">
           
                         <div id="DivLaboral"></div>
           
             </div>';
        
       echo '<h5>&nbsp;</h5>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_4($titulo,$tipo){
       
       
        
       $datos = array();
       $this->set->nav_tabs_inicio("tab_1_4",'');
       
       echo '<h5>&nbsp;</h5>';
       
       $resultado = $this->bd->ejecutar("SELECT idcatalogo as codigo, nombre FROM par_catalogo where tipo = 'bancos' ");
       
       
       $this->obj->list->listadb($resultado,$tipo,'Entidad Bancaria','id_banco',$datos,'required','','div-2-10');
       
       
       $MATRIZ =  $this->obj->array->nom_tipo_banco();
       
       $this->obj->list->lista('Tipo Cuenta',$MATRIZ,'tipo_cta',$datos,'required','','div-2-10');
       
 
       $this->obj->text->text('Nro.Cuenta',"texto",'cta_banco',30,30,$datos,'required','','div-2-4');
       
      
       
       echo '<h5>&nbsp;</h5>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-------------
   function K_tab_1_5($titulo,$tipo){
       
       $datos = array();
       
       $this->set->nav_tabs_inicio("tab_1_5",'');
 
       
       
       $MATRIZ =  $this->obj->array->catalogo_sino();
       
       $this->obj->list->lista('Fondos Reserva?',$MATRIZ,'sifondo',$datos,'required','','div-2-4');
       
 
       $this->obj->text->text('Vivienda',"number",'vivienda',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Salud',"number",'salud',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Alimentaci�n',"number",'alimentacion',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Vestimenta',"number",'vestimenta',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Educacion',"number",'educacion',40,45,$datos,'required','','div-2-4') ;
       
           
       echo '<h5>&nbsp;</h5>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
   $eventoi = "javascript:TraerDato()";
 
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Buscar Persona Enlace WEB', evento =>$eventoi,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
   //----------------------------------------------
   function combodb(){
    
 
 
  }   
    //----------------------------------------------
   function combodbA(){
 
 
 
  }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>


 
  