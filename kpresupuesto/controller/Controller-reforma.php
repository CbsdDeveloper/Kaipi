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
session_start();   
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
        
                
               $this->formulario = 'Model-reforma.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
      
        $titulo = '';
        $datos  = array();
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                   
         
                $this->obj->text->text('Reforma Nro.',"number",'id_reforma',0,10,$datos,'','readonly','div-1-3') ;
                
               
                $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-1-3') ;
                 
                
                $MATRIZ = array(
                    'I'    => 'Ingreso',
                    'G'    => 'Gasto'
                );
                
                $this->obj->list->lista('<b>PRESUPUESTO</b>',$MATRIZ,'tipo',$datos,'','','div-1-3');
                
                $this->set->div_label(12,'Informacion del tramite');	 
                
                $this->obj->text->text('Comprobante',"texto" ,'comprobante' ,80,80, $datos ,'','readonly','div-2-4') ;
              
                $this->obj->text->text('Estado',"texto" ,'estado' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;
                
                
                $MATRIZ = array(
                    'Traspaso'    => 'Traspaso',
                    'Suplemento'    => 'Suplemento',
                    'Reduccion'    => 'Reduccion'
                );
                
                $this->obj->list->lista('Tipo Reforma',$MATRIZ,'tipo_reforma',$datos,'','','div-2-10');
                
                
                
                $this->obj->text->text('Documento',"texto" ,'documento' ,80,80, $datos ,'required','','div-2-4') ;
                
                
             
                $tipo = $this->bd->retorna_tipo();
                 
                $resultado = $this->bd->ejecutar("select 0 as codigo , '  [  Unidad Responsable ]' as nombre union
                                                   SELECT id_departamento AS codigo,  nombre
													FROM nom_departamento
                                                    where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc ,true)."
                                                           ORDER BY 2");
                
                $this->obj->list->listadb($resultado,$tipo,'Solicita','id_departamento',$datos,'required','','div-2-4');
                
                $cadena1 = 'onClick="PonePartida();"';
                $cboton1 = '<a href="#" '.$cadena1.'><img title= "Seleccionar Partidas" src="../../kimages/1p.png"/></a>&nbsp;&nbsp; ';

                $cadena1 = 'onClick="AbrePartida();"';
                $cboton2 = ' &nbsp;<a href="#" '.$cadena1.'><img title="Importar archivo excel reforma" src="../../kimages/01_.png"/></a>&nbsp;&nbsp;';
                
                
                $cadena1 = 'onClick="CalculaSaldos();"';
                $cboton3 = ' &nbsp;<a href="#" '.$cadena1.'><img title="Verificar Saldos Disponibles a la fecha" src="../../kimages/02_.png"/></a>';
         
                
                
                $this->set->div_labelmin(12,'<h6> Detalle de Reforma<h6>'.$cboton1.$cboton2. $cboton3 );
                
                echo '<div class="col-md-12">
                             	<div class="alert al1ert-info fade in">
                                		<div id="DivAsientosTareas"></div>
                                         <div id="taumento"></div>
                                         <div id="tdisminuye"></div>
                                        <div id="SaldoTotal" align="right">Saldo</div>
                                      

                                 </div>
                       </div>';
               
          
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'javascript:aprobacion('."'".$this->formulario.'?action=aprobacion'."'".')';
   	
   	$formulario_impresion = '../reportes/ficherocomprobante?a=';
   	
   	$eventop = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   
   	$eventoe = "javascript:ExportarExcel()";
   	
   	$evento1 = "javascript:Saldos()";
   	
   	$evento_a = "javascript:Revierte()";
   	
   	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		    array( boton => 'Aprobar Reforma',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
     	     	array( boton => 'Informe Reforma autorizada', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
                array( boton => 'Exportar a excel', evento =>$eventoe,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button_default") ,
                array( boton => 'Actualizar Saldos Presupuestarios',  evento =>$evento1,  grafico => 'icon-white icon-ambulance' ,  type=>"button_primary"),
                array( boton => 'Revierte Tramite',  evento =>$evento_a,  grafico => 'icon-white icon-warning-sign' ,  type=>"button_default")
    		
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