<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      private $obj;
      private $bd;
      private $set;
      private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
  
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date('Y-m-d');
     
               $this->evento_form = '../model/Model-pre_sireprogramacion.php';        // eventos para ejecucion de editar eliminar y agregar 
      }

/*
//Obtiene la fecha actual
*/
      function fecha( ){
          $todayh =  getdate();

          $d = $todayh[mday];

          $m = $todayh[mon];

          $y = $todayh[year];

          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //---------------------------------------


      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){


            $titulo = '';

            $datos      = array();

            $tipo       = $this->bd->retorna_tipo();

            $MATRIZ = array(
                'Tiempo'              => 'Tiempo',
                'Traslado'            => 'Traslado',
                'Nuevas actividades'  => 'Nuevas actividades' 

                     );
       

            $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
       
            $this->set->body_tab($titulo,'inicio');
        
            $this->BarraHerramientas();

                            
            $this->obj->text->text('Id de reprogramacion',"number" ,'id_sireprogra' ,80,80, $datos ,'required','readonly','div-2-4') ;

            $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-1-3') ;

            $this->set->div_label(12,'Informacion del tramite'); 

            $this->obj->text->text('Comprobante',"texto" ,'comprobante' ,80,80, $datos ,'required','readonly','div-2-4') ;

            $this->obj->text->text('Estado',"texto" ,'estado' ,80,80, $datos ,'required','readonly','div-2-4') ;

            $this->obj->text->editor('Detalle','detalle',2,45,300, $datos ,'required','','div-2-10') ;

            $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'','','div-2-10');
                
            $this->obj->text->text('Documento',"texto" ,'documento' ,80,80, $datos ,'required','','div-2-4') ;

            $resultado = $this->bd->ejecutar("select 0 as codigo , '  [  Unidad Responsable ]' as nombre union
                                                   SELECT id_departamento AS codigo,  nombre
                                                   FROM nom_departamento ORDER BY 1");

            $this->obj->list->listadb($resultado,$tipo,'Solicita','id_departamento',$datos,'required','','div-2-4');
                
           $cadena1 = 'onClick="PonePartida();"'; 

           $cboton1 = '<a href="#" '.$cadena1.'><img title= "Seleccionar Partidas" src="../../kimages/if_wishlist_add_64997.png"/></a>&nbsp; ';

            $cadena1 = 'onClick="AbrePartida();"';

            $cboton2 = ' &nbsp;<a href="#" '.$cadena1.'><img title="Importar archivo excel reforma" src="../../kimages/wdocumentos.png"/></a>';
                
               
            $this->set->div_labelmin(12,'<h6> Detalle de Reforma<h6>'.$cboton1.$cboton2);

                 echo '<div class="col-md-12">
                              <div class="alert al1ert-info fade in">
                                    <div id="DivAsientosTareas"></div>
                                         <div id="taumento"></div>
                                         <div id="tdisminuye"></div>
                                        <div id="SaldoTotal" align="right">Saldo</div>
                                      

                                 </div>
                       </div>';

            $this->obj->text->texto_oculto("action",$datos);   // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql
         
            $this->set->evento_formulario('-','fin'); 
   
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
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
    
  function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
  } 
   
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>