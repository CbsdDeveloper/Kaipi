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
      private $anio;
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
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-pedido_permiso.php'; 
   
               $this->evento_form = '../model/Model-pedido_permiso.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
     
      //---------------------------------------
      
     function Formulario( ){
      
  
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
                $datos = array();
    
                $this->BarraHerramientas();

                $MATRIZ_P       =  $this->obj->array->catalogo_tipoPermiso();
                $MATRIZ_M       =  $this->obj->array->catalogo_motivoPermiso();
                
                $datos = $this->bd->query_array('view_nomina_user',   // TABLA
	                                '*',                        // CAMPOS
	                                'sesion_corporativo='.$this->bd->sqlvalue_inyeccion(  trim($this->sesion),true) // CONDICION
	           );


               $hora = $this->bd->query_array('nom_cvacaciones',  
               '(horas_dias + dias_tomados   ) as total,dias_pendientes, (saldo_anterior  + dias_derecho ) as derecho',                       
               'idprov='.$this->bd->sqlvalue_inyeccion(  trim( $datos['idprov']),true).' and 
                periodo=' .$this->bd->sqlvalue_inyeccion(    $this->anio  ,true) 
               );

              
               
               $MATRIZ_ESTADO= array(
                '1'    => 'Solicitado',
                '2'    => 'Autorizado',
                '3'    => 'Anulado',
                '4'    => 'Enviado' 
              );
               
               
               $datos['hora_tomados']     = '0.00';
               $datos['dia_tomados']      = '0.00';
               $datos['dia_acumula']      = $hora['total'];
               $datos['derecho']      = $hora['derecho'];
               
               $datos['fecha']     =  date("Y-m-d");
               $datos['fecha_out'] =  date("Y-m-d");
               $datos['fecha_in']  =  date("Y-m-d");


               

               $DateAndTime = date('h:i', time());  

               $datos['hora_out'] =  $DateAndTime ;
               $datos['hora_in']  =  $DateAndTime ;

 
     
                $this->set->div_panel6('<h6> PASO 1.- INFORMACION DEL SOLICITANTE<h6>');
                
          

                        $this->obj->text->text_blue('Codigo','number','id_vacacion',10,10,$datos ,'','readonly','div-2-10') ;
                
 
                       $this->obj->text->text_dia('Fecha',"3",'fecha',70,70,$datos,'required','readonly','div-2-10') ;
                        
                        $this->obj->text->text_blue('Unidad',"texto",'unidad',40,45,$datos,'required','readonly','div-2-10');

                        $this->obj->text->text_blue('Cargo',"texto",'cargo',40,45,$datos,'required','readonly','div-2-10');

                        $this->obj->text->text_blue('Funcionario',"texto",'razon',40,45,$datos,'required','readonly','div-2-10');
                        
                        $this->obj->text->text_blue('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;
                        
                
                      
                $this->set->div_panel6('fin');
                
                $this->set->div_panel6('<h6> PASO 2.- INFORMACION DE LA SOLICITUD <h6>');


                $evento = ' Onchange="valida_tipo(1,this.value)"';
             
                                 $this->obj->list->listae('Tipo',$MATRIZ_P,'tipo',$datos,'required','',$evento,'div-2-10');
    
                                $this->obj->list->lista('Motivo',$MATRIZ_M,'motivo',$datos,'required','','div-2-10');
                              

                                $evento = ' Onchange="valida_tipo(2,this.value)"';

                                $evento1 = ' Onchange="valida_tipo_fecha()"';
                        
                                $this->obj->text->text_dia('Fecha Salida',"2",'fecha_out',70,70,$datos,'required','','div-2-4', $evento ) ;
                                $this->obj->text->text_dia('Fecha Entrada',"2",'fecha_in',70,70,$datos,'required','','div-2-4',   $evento1) ;
 
                                $this->obj->text->texto_oculto("fecha_vaca",$datos); 
                                $this->obj->text->texto_oculto("bandera_vaca",$datos); 
                                $this->obj->text->texto_oculto("derecho",$datos); 
                              
                             
                                $this->obj->text->text_yellow('Hora Salida',"time" ,'hora_out' ,80,80, $datos ,'required','','div-2-4') ;
                                $this->obj->text->text_yellow('Hora Entrada',"time" ,'hora_in' ,80,80, $datos ,'required','','div-2-4') ;
                                
                                
                                $this->obj->text->editor('Motivo','novedad',4,75,500,$datos,'required','','div-2-10') ;
                
                $this->set->div_panel6('fin');
                
                $this->set->div_panel6('<b>Parametro de validacion</b>');
      
             
                                    
                                echo '<h3><b>UD. TIENE '. $hora['dias_pendientes'].' DIA(S) PENDIENTES</h3></b>';
                                
                                 $this->obj->text->text_yellow('Nro.Dias Tomados',"number" ,'dia_acumula' ,80,80, $datos ,'required','readonly','div-3-9') ;

                                 $this->obj->text->text_blue('Nro.dia(s)',"number" ,'dia_tomados' ,80,80, $datos ,'required','readonly','div-3-9') ;
                              
                                 $this->obj->text->text_blue('Fracción dia/hora',"number" ,'hora_tomados' ,80,80, $datos ,'required','readonly','div-3-9') ;
                 
                                 $this->obj->list->lista('Estado',$MATRIZ_ESTADO,'estado',$datos,'required','readonly','div-3-9');

                                 $datos['dia_valida']      = $hora['dias_pendientes'];
                                 
                                 $this->obj->text->texto_oculto("dia_valida",$datos); 
                 
               $this->set->div_panel6('fin');


               $this->set->div_panel6('<b>Indicaciones Generales</b>');
                
                echo '<h4>Cumplido los pasos anteriores el formulario debe ser ENVIADO a la Dirección de Administración de Recursos Humanos para ';
                echo 'su registro y legalización una vez que haya sido llenado y autorizado por el jefe de Area</h4>';


                echo '<h4>Nota: Permiso por dias minimo entre 1 a 3 dias<br>Vacaciones mínimo de 7 días y puede salir 15 dias despues de lo solicitado.</h4>';


                echo 'Art. 29.- Vacaciones y permisos.- Toda servidora o servidor publico tendrÃ¡ derecho a disfrutar de
                treinta días de vacaciones anuales pagadas despues de once meses de servicio continuo. Este
                derecho no podra ser compensado en dinero, salvo en el caso de cesación de funciones en que se
                liquidarón las vacaciones no gozadas de acuerdo al valor percibido o que debia percibir por su Ultima
                vacación. Las vacaciones podran ser acumuladas hasta por sesenta días. ';

               $this->set->div_panel6('fin');



          

               $this->obj->text->texto_oculto("cargoa",$datos); 
                      
              $this->obj->text->texto_oculto("action",$datos); 
         
          
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
  
 
    $formulario_reporte = '../../reportes/Permiso';
   
    $eventoi = "openFile('".$formulario_reporte."')";

    $eventop = "notificar_permiso();";
     

    
     $ToolArray = array( 
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                  array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                  array( boton => 'NOTIFICAR SOLICITUD', evento =>$eventop, grafico => 'glyphicon glyphicon glyphicon-send' ,  type=>"button_success")  
                 );
                   
    $this->obj->boton->ToolMenuDiv($ToolArray); 

 
  }  
  
/*
Llamada del formulario
*/
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>