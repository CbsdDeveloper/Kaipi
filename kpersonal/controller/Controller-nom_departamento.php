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
          
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                 
               $this->formulario = 'Model-nom_departamento.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
                            WHERE  univel = 'N' 
                        order by 1"   ;
                
                $evento ='';

                $MATRIZ =  $this->obj->array->catalogo_sino();

                $MATRIZ_D = array(
                    'GOBERNANENTE'    => 'GOBERNANENTE',
                    'ASESORIA'   => 'ASESORIA',
                    'APOYO'    => 'APOYO',
                    'AGREGADORA DE VALOR'    => 'AGREGADORA DE VALOR',
                    'PROYECTOS'    => 'PROYECTOS'
                );

                $MATRIZ_N = array(
                    '0'    => 'Nivel Matriz',
                    '1'    => 'Nivel 1',
                    '2'    => 'Nivel 2',
                    '3'    => 'Nivel 3',
                    '4'    => 'Nivel 4',
                    '5'    => 'Nivel 5',
               );
                
                $resultado   = $this->bd->ejecutar($sql);

                $resultado_p =  $this->combo_lista("presupuesto.pre_catalogo");
                
                                    $this->obj->list->listadbe($resultado,$tipo,'Origen','id_departamentos',$datos,'','',$evento,'div-2-10');
                                    
                                    $this->obj->text->text('Id',"number",'id_departamento',0,10,$datos,'','readonly','div-2-4') ;              
                                    
                                    $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                        
                                    $this->obj->text->text_yellow('Unidad',"texto",'nombre',50,50,$datos,'required','','div-2-10') ;  
                            
                                    $this->obj->list->lista('Ambito',$MATRIZ_D,'ambito',$datos,'required','','div-2-10');
                            
                                    $this->obj->text->editor('Competencias','competencias',3,45,350,$datos,'required','','div-2-10') ;
                                    
                                    $this->obj->text->editor('Productos','atribuciones',3,45,350,$datos,'required','','div-2-10') ;
                                    
                                    $this->obj->text->editor('Ubicación','ubicacion',3,45,350,$datos,'required','','div-2-10') ;
                            
                                    $this->obj->list->lista('Nivel',$MATRIZ_N,'nivel',$datos,'','','div-2-4');
                            
                                    $this->obj->list->lista('Ultimo Nivel',$MATRIZ,'univel',$datos,'required','','div-2-4');
                
                
                        $this->set->div_labelmin(12,'Parametros para modulo de gestion de presupuesto - procesos');
                
             
                                    $this->obj->list->listadb($resultado_p,$tipo,'Programa','programa',$datos,'required','','div-2-4');
                                    
                                    $this->obj->text->text_yellow('Siglas',"texto",'siglas',35,35,$datos,'required','','div-2-4') ;  
                                    
                                    $this->obj->text->text_blue('Estructura',"texto",'orden',50,50,$datos,'required','readonly','div-2-4') ;  


                       $this->set->div_labelmin(12,'Parametros para secuencia de documentos');
                
                 
                                    $this->obj->text->text('Secuencia',"number",'secuencia',10,10,$datos,'required','','div-2-4') ;  
                                    $this->obj->text->text('Oficio',"number",'oficio',10,10,$datos,'required','','div-2-4') ;  
                                    $this->obj->text->text('Memo',"number",'memo',10,10,$datos,'required','','div-2-4') ;  
                                    $this->obj->text->text('Notificacion',"number",'notificacion',10,10,$datos,'required','','div-2-4') ;  
                                    $this->obj->text->text('Circular',"number",'circular',10,10,$datos,'required','','div-2-4') ;  
                                    $this->obj->text->text('Informe',"number",'informe',10,10,$datos,'required','','div-2-4') ;  
                
                
 
                      
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
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
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
 
  