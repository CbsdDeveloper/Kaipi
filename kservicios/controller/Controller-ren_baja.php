<script type="text/javascript" src="formulario_result.js"></script> 	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    
 	
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
      private $anio;
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
        
                $this->anio       =  $_SESSION['anio'];
     
               $this->evento_form = '../model/Model-ren_tramites.php';         
      }
  
      //---------------------------------------
      
     function Formulario( ){
    
         
         $datos = array();
         
         $MATRIZ =  $this->obj->array->catalogo_TipoBaja();
 
         $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
  
    
 
       
                $this->BarraHerramientas();
                
                
                $this->set->div_panel6('<b>1. SOLICITA BAJA DE TITULOS </b>');
                
                        $this->obj->text->textautocomplete('<b>Identificacion</b>','texto','idprov',13,13,$datos ,'required',' ','div-2-4') ;
                        
                        $cboton2 = '<b>Contribuyente</b>';
                        
                        $this->obj->text->text_blue('CIU',"number" ,'id_par_ciu' ,80,80, $datos ,'required','readonly','div-2-4') ;
                        
                        
                        $this->obj->text->textautocomplete($cboton2,"texto",'razon',40,45,$datos,'required','','div-2-10');
                        
                        
                        $this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','','div-2-10') ;
                        
                        $this->obj->text->text('Email','texto','correo',120,120,$datos ,'required','','div-2-10') ;
                
                $this->set->div_panel6('fin');
                
                
                $this->obj->text->texto_oculto("id_rubro",$datos);
        
                
                $this->set->div_panel6('<b>2. INFORMACION DEL SERVICIO </b>');
                
                        $this->obj->text->text_yellow('Fecha Baja',"date" ,'fechab' ,80,80, $datos ,'required','','div-2-10') ;
                         
                        $this->obj->list->lista('Motivo',$MATRIZ,'tipo',$datos,'required','','div-2-10');
                        
                        $this->obj->text->editor('Resolucion','resolucion',4,45,350,$datos,'required','','div-2-10') ;
                
                $this->set->div_panel6('fin');
                
                 
                
                $this->set->div_label(12,'Detalle de Titulos de Credito');
                
                
                echo ' <div class="col-md-12" style="padding: 1px">
              <div class="btn-group">
                <button type="button" onClick="BuscarTitulos()" class="btn btn-danger">Buscar Titulos de Credito</button>
               </div>
                        
                <div class="col-md-12" style="padding: 1px">
                        <div id="DetalleActivosNoAsignado">Para visualizar los bienes pendientes de asignar debe agregar para crear el acta</div>
                </div>
                        
             </div>
            <div id="GuardaDato"></div>';
                
                  
         $this->obj->text->texto_oculto("action",$datos); 
 
         $this->obj->text->texto_oculto("id_ren_baja",$datos); 
         
         
         
         $this->set->_formulario('-','fin'); 
 
   }
  
  //----------------------------------------------------......................-------------------------------------------------------------
    function BarraHerramientas(){
 
   
   $formulario_reporte  = '../reportes/informebaja';
   $eventoi             = "imprimir_informe('".$formulario_reporte."')";
   $eventop             = "aprobacion_tramite()";
   
   $ToolArray           = array( 
         array( boton => 'Nuevo tramite de baja',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
         array( boton => 'Autorizar Envio aprobado', evento =>$eventop,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
         array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  

}
///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
  <script type="text/javascript" src="formulario_ciu.js"></script>   