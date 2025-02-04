<script type="text/javascript" src="formulario_result.js"></script> 	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
      private $obj;
      private $bd;
      private $set;
      
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
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
    
               $this->evento_form = '../model/Model-ad_combustible_in.php' ;       
      }
  
      //---------------------------------------
      
     function Formulario( ){
      
         $titulo = '';
         $tipo   = $this->bd->retorna_tipo();
         $datos  = array();
         $MATRIZ = array(
            'N'  => 'Uso Interno - Control Interno'
          );
         
         
         $this->set->_formulario( $this->evento_form,'inicio' ); 
 
                $this->BarraHerramientas();
                      
                
                
                $this->set->div_panel9('<b> CONTROL DE COMBUSTIBLE </b>');
                
                        $this->obj->text->text_yellow('<b>Comprobante</b>','texto','referencia',10,10,$datos ,'required','','div-2-10') ;
                    
                        $evento = 'Onchange="HabilitaCampo_dato(this.value)"';
                        
                        $this->obj->list->listae('Uso',$MATRIZ,'uso',$datos,'','',$evento,'div-2-10');
                
               
                
                        $this->obj->text->text_blue('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                        $this->obj->text->text('Hora',"time" ,'hora_in' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        $this->obj->text->text('Motivo',"texto" ,'ubicacion_salida' ,250,250, $datos ,'required','','div-2-10') ;
                        
                
                         
                        $evento     ='Onchange="monto_combustible(this.value)"';
                        $resultado = $this->bd->ejecutar_catalogo('COMBUSTIBLE','texto');
                       
                        
                        $this->obj->list->listadbe($resultado,$tipo,'Combustible','tipo_comb',$datos,'required','',$evento,'div-2-4');
                        
                        $this->obj->text->text_yellow('Costo',"float" ,'costo' ,80,80, $datos ,'required','','div-2-4') ;
                         
                        $this->obj->text->text_yellow('Galones(*)',"float" ,'cantidad' ,80,80, $datos ,'required','','div-2-4') ;

                        $this->obj->text->text_yellow('TotalGalones',"float" ,'total_consumo' ,80,80, $datos ,'','readonly','div-2-4') ;

                    
                $this->set->div_panel9('fin');
                
                
                $this->obj->text->texto_oculto("id_combus",$datos); 
                       
               $this->obj->text->texto_oculto("action",$datos); 
         
          
               $this->set->_formulario('-','fin'); 
  
 
      
   }
  
   //----------------------------------------------
   function BarraHerramientas(){
 
       
       $formulario_reporte = '../reportes/orden_combustible_in';
       
       $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
       
       
       $ToolArray = array(
           array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
           array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
           array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
       );
       
       $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  

}

///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
  <script type="text/javascript" src="formulario_ciu.js"></script> 