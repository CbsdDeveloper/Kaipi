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
          
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-cli_unidad.php'; 
   
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
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); 
   
        $datos = array();
        
    
                $this->BarraHerramientas();
                
                $tipo = $this->bd->retorna_tipo();
                
                 
                $sql ="SELECT 0 as codigo,'Matriz Origen' as nombre union 
                        SELECT id_departamento as codigo, nombre
                            FROM  nom_departamento
                            WHERE ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and univel = 'N' 
                        order by 1"   ;
                
                
                $evento ='';
                
                $resultado = $this->bd->ejecutar($sql);
                
                $this->obj->list->listadbe($resultado,$tipo,'Origen','id_departamentos',$datos,'','',$evento,'div-2-10');
                
                
                
                $this->obj->text->text('Id',"number",'id_departamento',0,10,$datos,'','readonly','div-2-4') ; 
                
                $MATRIZ =  $this->obj->array->catalogo_sino();
                
                                $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','disabled','div-2-4');
                            
                                $this->obj->text->text_yellow('Unidad',"texto",'nombre',50,50,$datos,'required','','div-2-10') ;  
                            
                                $this->obj->text->texto_oculto("competencias",$datos); 
                                $this->obj->text->texto_oculto("atribuciones",$datos); 
                                $this->obj->text->texto_oculto("ubicacion",$datos); 
                                
                                 

                 
                $this->set->div_labelmin(12,'<b>Parametros para secuencia de documentos</b>');
                                
                                
                                $this->obj->text->text('Secuencia',"number",'secuencia',10,10,$datos,'required','','div-2-4') ;  
                                $this->obj->text->text('Oficio',"number",'oficio',10,10,$datos,'required','','div-2-4') ;  
                                $this->obj->text->text('Memo',"number",'memo',10,10,$datos,'required','','div-2-4') ;  
                                $this->obj->text->text('Notificacion',"number",'notificacion',10,10,$datos,'required','','div-2-4') ;  
                                $this->obj->text->text('Circular',"number",'circular',10,10,$datos,'required','','div-2-4') ;  
                                $this->obj->text->text('Informe',"number",'informe',10,10,$datos,'required','','div-2-4') ;  
                
                
                $this->set->div_labelmin(12,'Parametros para modulo de gestion de presupuesto - procesos');
                
                
                                $this->obj->text->text_blue('Siglas',"texto",'siglas',25,25,$datos,'required','','div-2-4') ;  

                                $this->obj->text->text_blue('Orden',"texto",'orden',5,5,$datos,'required','','div-2-4') ;  
                                
                                $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
                                $this->obj->list->listadb($resultado,$tipo,'Programa','programa',$datos,'required','','div-2-4');
                
  
                $this->set->div_labelmin(12,'Parametros nivel de organizacion');
                
                                    $MATRIZ = array(
                                        'GOBERNANENTE'    => 'GOBERNANENTE',
                                        'ASESORIA'   => 'ASESORIA',
                                        'APOYO'    => 'APOYO',
                                        'AGREGADORA DE VALOR'    => 'AGREGADORA DE VALOR'
                                    );
                                    
                                    $this->obj->list->lista('Ambito',$MATRIZ,'ambito',$datos,'required','','div-2-10');
                                    
                                    $MATRIZ = array(
                                        '0'    => 'Nivel Matriz',
                                        '1'    => 'Nivel 1',
                                        '2'    => 'Nivel 2',
                                        '3'    => 'Nivel 3',
                                        '4'    => 'Nivel 4',
                                        '5'    => 'Nivel 5',
                                    );
                                    
                                    $this->obj->list->lista('Nivel',$MATRIZ,'nivel',$datos,'','','div-2-4');
                                    
                                    $MATRIZ =  $this->obj->array->catalogo_sino();
                                    
                                    $this->obj->list->lista('Ultimo Nivel',$MATRIZ,'univel',$datos,'required','','div-2-4');
              
                
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
   $formulario_reporte = '../../reportes/excel_unidad';
   
   $eventoi = "javascript:exportar_excel('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
               // array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    //----------------------------------------------
  function combo_lista($tabla ){
      
      if  ($tabla == 'presupuesto.pre_catalogo'){
          
          $sql ="SELECT ' - ' as codigo,' [ Sin Programa ]' as nombre union
                        SELECT codigo as codigo, detalle as nombre
                            FROM  presupuesto.pre_catalogo
                            WHERE estado = 'S' and  categoria = ".$this->bd->sqlvalue_inyeccion('programa'  ,true)."
                        order by 1"   ;
          
          
          
          $resultado = $this->bd->ejecutar($sql);
          
          
          
      }
      
      if  ($tabla == 'nom_departamento'){
          
          $resultado =  $this->bd->ejecutarLista("id_departamento,nombre",
              $tabla,
              "ruc_registro = ".$this->bd->sqlvalue_inyeccion( trim($this->ruc ) ,true),
              "order by 2");
              
      }
      
      if  ($tabla == 'nom_cargo'){
          
          $resultado =  $this->bd->ejecutarLista("id_cargo,nombre",
              $tabla,
              "-",
              "order by 2");
              
      }
      
      
      if  ($tabla == 'nom_regimen'){
          
          $resultado =  $this->bd->ejecutarLista("regimen,regimen",
              $tabla,
              "activo = ".$this->bd->sqlvalue_inyeccion('S' ,true),
              "order by 2");
              
      }
      
      
      
      
      return $resultado;
      
      
  }   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  