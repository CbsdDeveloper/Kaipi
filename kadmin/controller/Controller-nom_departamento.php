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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-nom_departamento.php'; 
   
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
        $tipo  = $this->bd->retorna_tipo();

       $sql ="SELECT 0 as codigo,'-- 0. Matriz Origen --' as nombre union 
        SELECT id_departamento as codigo, nombre
            FROM  nom_departamento
            WHERE ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and 
                  univel = 'N' 
        order by 1"   ;

        $resultado = $this->bd->ejecutar($sql);

        $evento ='';

        $MATRIZ =  $this->obj->array->catalogo_sino();

        $MATRIZG = array(
            'GOBERNANENTE'    => 'GOBERNANENTE',
            'ASESORIA'   => 'ASESORIA',
            'APOYO'    => 'APOYO',
            'AGREGADORA DE VALOR'    => 'AGREGADORA DE VALOR'
        );

        $MATRIZN = array(
            '0'    => 'Nivel Matriz',
          '1'    => 'Nivel 1',
          '2'    => 'Nivel 2',
            '3'    => 'Nivel 3',
            '4'    => 'Nivel 4',
            '5'    => 'Nivel 5',
      );
      
        $MATRIZSN =  $this->obj->array->catalogo_sino();

        $resultado_lista =  $this->combo_lista("presupuesto.pre_catalogo");

                
       $this->BarraHerramientas();
        
                
                            $this->obj->list->listadbe($resultado,$tipo,'Origen','id_departamentos',$datos,'','',$evento,'div-2-10');
                            
                            $this->obj->text->text('Id',"number",'id_departamento',0,10,$datos,'','readonly','div-2-4') ; 
                            
                            
                            $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                        
                            $this->obj->text->text_yellow('Unidad',"texto",'nombre',50,50,$datos,'required','','div-2-10') ;  
                        
                            $this->obj->list->lista('Ambito',$MATRIZG,'ambito',$datos,'required','','div-2-10');
                            
                            $this->obj->text->editor('Competencias','competencias',3,45,350,$datos,'required','','div-2-4') ;
                            
                            $this->obj->text->editor('Productos','atribuciones',3,45,350,$datos,'required','','div-2-4') ;
                            
                            $this->obj->text->editor('Ubicación','ubicacion',3,45,350,$datos,'required','','div-2-10') ;
                            
                $this->set->div_labelmin(12,'Parametros para modulo de gestion de presupuesto - procesos');
                
            
                            $this->obj->list->listadb($resultado_lista,$tipo,'Programa','programa',$datos,'required','','div-2-4');
                 
                            $this->obj->text->text_blue('Siglas',"texto",'siglas',30,30,$datos,'required','','div-2-4') ;  
                 
                            $this->obj->text->text('Secuencia',"number",'secuencia',10,10,$datos,'required','','div-2-4') ;  

                            $this->obj->list->lista('Ultimo Nivel',$MATRIZSN,'univel',$datos,'required','','div-2-4');
                           
                 $this->set->div_labelmin(12,'Orden de parametros de busqueda');            

                            $this->obj->list->lista('Nivel',$MATRIZN,'nivel',$datos,'','','div-2-4');

                            $this->obj->text->text_yellow('Orden',"texto",'orden',10,10,$datos,'required','','div-2-4') ;  

                            echo '<div class="col-md-2" align="right">Estructura<br>Organizacion</div><div class="col-md-10" style="font-size: 14px;padding: 20px"> ';
                            echo '<b>A</b>  1. Nivel<br>';
                            echo '<b>AA</b>  2. Nivel<br>';
                            echo '<b>AAA</b>  3. Nivel<br>';
                            echo '<b>AAAA</b>  4. Nivel<br>';
                            echo '</div>';
                      
                          
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
 
  