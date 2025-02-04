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
                
    
               $this->evento_form = '../model/Model-ad_combustible_estacion.php' ;       
      }
  
      //---------------------------------------
      
     function Formulario( ){
      
         $titulo = '';
         $tipo   = $this->bd->retorna_tipo();
         $datos  = array();

         $MATRIZ = array(
            'E'  => 'Uso Estacion - Control Interno'
          );

          $resultado = $this->bd->ejecutar("select '-' as codigo , '  --  0. Asignar Conductor  -- ' as nombre union
          SELECT idprov AS codigo, razon  as nombre
           FROM adm.view_adm_chofer
           where estado = ".$this->bd->sqlvalue_inyeccion('S',true)."
                 ORDER BY 2 ");

         $evento1     ='Onchange="monto_combustible(this.value)"';
         
         $resultado1 = $this->bd->ejecutar_catalogo('COMBUSTIBLE','texto');
 
         $evento = 'Onchange="HabilitaCampo_dato(this.value)"';
 
         
         $this->set->_formulario( $this->evento_form,'inicio' ); 
 
                $this->BarraHerramientas();
                
                $this->set->div_panel9('<b> CONTROL DE COMBUSTIBLE </b>');
                
                        
                        $this->obj->list->listae('Uso',$MATRIZ,'uso',$datos,'','',$evento,'div-2-10');
                
                        $this->obj->text->text_yellow('<b>Nro.Orden</b>','number','referencia',10,10,$datos ,'required','','div-2-4') ;

                        $this->obj->text->text_blue('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        $this->obj->list->listadb($resultado,$tipo,'Conductor','id_prov',$datos,'required','','div-2-10');
                        
                     
              $this->set->div_label(12,'Control de Kilometraje');
                        
                        $this->obj->text->text_blue('<b>Km. Anterior</b>',"number" ,'u_km_inicio' ,80,80, $datos ,'required','','div-2-4') ;

                        $this->obj->text->text_yellow('<b>Km. Abastecido</b>',"number" ,'u_km_fin' ,80,80, $datos ,'required','','div-2-4') ;


               $this->set->div_label(12,'Control de Estacion');

                        $this->obj->text->textautocomplete('Proveedor',"texto",'razon',40,45,$datos,'required','','div-2-10');

                        $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                         
                        $this->obj->list->listadbe($resultado1,$tipo,'Combustible','tipo_comb',$datos,'required','',$evento1,'div-2-4');
                        
                        $this->obj->text->text('Costo',"float" ,'costo' ,80,80, $datos ,'required','','div-2-4') ;
                         
                        $this->obj->text->text_yellow('Galones(*)',"float" ,'cantidad' ,80,80, $datos ,'required','','div-2-4') ;

                        $this->obj->text->text('TotalGalones',"float" ,'total_consumo' ,80,80, $datos ,'','readonly','div-2-4') ;

                    
                $this->set->div_panel9('fin');
                

                $datos['ubicacion_salida'] = 'CONTROL DE ESTACION DE GASOLINA - DESPACHO BOMBEROS';

                $datos['hora_in'] = '06:00';

                $this->obj->text->texto_oculto("ubicacion_salida",$datos); 

                $this->obj->text->texto_oculto("hora_in",$datos); 
                
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

 