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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ven_inicio.php'; 
   
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
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                     
                $tipo = $this->bd->retorna_tipo();
                
                $this->set->div_panel6('<b> DATOS DE GESTION POTENCIAL CLIENTE </b>');
                 
     
                 
                $this->obj->text->text('Sector ',"texto",'canton',90,95,$datos,'','readonly','div-2-10') ;
                
                 $this->obj->text->text('Nro.Identificacion',"texto",'idprov',13,13,$datos,'','','div-2-10') ;
          
                $this->obj->text->text('<b>Razon Social</b>',"texto",'razon',80,95,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('Direccion',"texto",'direccion',80,95,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text('Email',"email",'correo',60,75,$datos,'','','div-2-10') ;
                
                
                $reg ="\d{2}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                $this->obj->text->textMask('Telefono',"tel",'telefono',18,20,$datos,'','','',$reg,'div-2-10');
                
                $reg ="\d{3}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                
                $this->obj->text->textMask('Movil',"tel",'movil',18,20,$datos,'','','',$reg,'div-2-10');
                
                
                $this->obj->text->text('Contacto ',"texto",'contacto',90,95,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('web ',"texto",'web',40,45,$datos,'required','','div-2-10') ;
              
                $this->set->div_panel6('fin');
           
   
                $this->set->div_panel6('<b> DATOS DE GESTION </b>');
                
                $MATRIZ = array(
                    '0'    => 'por gestionar',
                    '1'    => 'Por Verificar',
                    '2'    => 'Verificado',
                    '3'    => 'Muestra Interes',
                    '9'    => 'No existe Informacion disponible'
                );
                $this->obj->list->listae('<b> ESTADO </b>',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-10');
                
               
                
                $this->set->div_label(12,'<h5><b>2. Actividad desarrollada para actualizacion de datos</b> </h5>');
                
                
                echo ' 
                <div class="col-md-12"> 
                <h5><b></b></h5>
                       <strong>Advertencia!</strong> Debe Actualizar la informacion del potencial cliente <br>
                      <div class="alert alert-warning">
                        <div class="row">';
               
                        $this->obj->text->editor('Novedad','detalle',4,45,300,$datos,'required','','div-2-10') ;
                
                        $MATRIZ = array(
                            'Banco de Datos'    => 'Banco de Datos',
                            'Publicidad Web'    => 'Publicidad Web',
                            'Impulsadora'       => 'Impulsadora',
                            'Medios Comunicacion'       => 'Medios Comunicacion',
                            'Otros'       => 'Otros',
                        );
                        $this->obj->list->listae('Origen Informacion',$MATRIZ,'acceso',$datos,'required','',$evento,'div-2-4');
                        
                        
              echo '</div>
                    </div>
                  </div>';
        
              $cboton = '<a href="https://declaraciones.sri.gob.ec/sri-en-linea/#/SriRucWeb/ConsultaRuc/Consultas/consultaRuc" 
                                class="btn btn-success btn-sm" 
                                target="_blank"
                                role="button"> 3. Consulta de RUC </a>  &nbsp; ';
            
              $cboton1 = '<a href="http://appscvs.supercias.gob.ec/portaldeinformacion/consulta_cia_param.zul" 
                             class="btn btn-success btn-sm" 
                             target="_blank"
                             role="button"> 4. SuperIntendencia Cia</a>  &nbsp;';
   
        
              
              $cboton2 = '<a href="#" onClick="abrirGoogle()"
                             class="btn btn-success btn-sm"
                              role="button"> 5. Consulta Google </a> &nbsp;';
              
              
              $cboton3 = '<a href="http://www.micnt.com.ec/cntapp/guia104/php/guia_cntat.php?hflagsubmit=0&cmbcriterio=2"
                             class="btn btn-success btn-sm"
                             target="_blank"
                             role="button"> 6. Consulta CNT </a>  &nbsp;';
              
              
              
              $this->set->div_label(12,'<h6>'.$cboton.$cboton1.$cboton2.$cboton3.' </h6>');
              
              $this->set->div_panel6('fin');
              
            
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("idvencliente",$datos); 
         
         $this->obj->text->texto_oculto("idcampana_1",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
         
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
 
  