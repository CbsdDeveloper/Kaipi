<script >// <![CDATA[

   jQuery.noConflict(); 
	
	   // InjQueryerceptamos el evento submit
	    jQuery('#fo5').submit(function() {
	  		// Enviamos el formulario usando AJAX
	        jQuery.ajax({
	            type: 'POST',
	            url: jQuery(this).attr('action'),
	            data: jQuery(this).serialize(),
	            // Mostramos un mensaje con la respuesta de PHP
	            success: function(data) {
	               
	           	   jQuery('#guardarpartidas').html('<div class="alert alert-info">'+ data + '</div>');
	               jQuery( "#guardarpartidas" ).fadeOut( 1600 );
	               jQuery("#guardarpartidas").fadeIn("slow");
	            
				}
	        })        
	        return false;
	    }); 

   
</script>	
<?php 
session_start( );   
  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
class Controller_tarea_edicion{
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $POST;
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
       function Controller_tarea_edicion( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->anio       =  $_SESSION['anio'];
             
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
       function Formulario( ){

           
           $datos = array();
           
           $evento =' ';
           
           $tipo = $this->bd->retorna_tipo();
           
           $this->obj->text->texto_oculto("idtarea",$datos); 
           
           $this->obj->text->editor('Tarea','tarea',3,250,250,$datos,'','readonly','div-2-10');
 
           
           $resultado =  $this->sql('FUNCIONARIO');
           $this->obj->list->listadb($resultado,$tipo,'Responsable','responsable',$datos,'required','','div-2-4');
           
           
           $MATRIZ = array(
               ''  => 'Seleccionar  ',
               'S'    => 'SI',
               'N'    => 'NO'
           );
           $this->obj->list->listae('Recurso?',$MATRIZ,'recurso',$datos,'required','readonly',$evento,'div-2-4');
            
           
        
           
           $resultado =  $this->sql('CLASIFICADOR');
           $this->obj->list->listadb($resultado,$tipo,'Gasto','clasificador',$datos,'required','','div-2-10');
           
         
           $this->set->div_label(12,'Enlace Modulos Adminstrativo');	 
           
           
           $resultado =  $this->sql('PAC');
           $evento    = "Onchange='PonePac()'";
           $this->obj->list->listadbe($resultado,$tipo,'Matriz PAC','enlace_pac',$datos,'required','',$evento,'div-2-10');
           
           
           $this->obj->text->editor('Detalle','tareapac',3,250,250,$datos,'','readonly','div-2-10');
           
                    
           $MATRIZA = array(
               '-'             => '-- Seleccionar Modulo -- ',
               'requerimiento' => 'PROCESO DE CONTRATACIÓN ACCIONES ESTRATEGICAS',
               'tareas'       => 'SEGUIMIENTO DE ACTIVIDADES SIN RECURSOS',
               'viaticos'        => 'GESTIÓN DE CONTROL DE VIÁTICOS',
               'nomina'      => 'GESTIÓN DE PAGOS DE NÓMINA E INGRESOS COMPLEMENTARIOS',
               'caja'      => 'GESTIÓN DE OTROS GASTOS PLANIFICADOS (sin contratación)',
           );
           
           
           $this->obj->list->listae('<b>Módulo</b>',$MATRIZA ,'modulo',$datos,'required','',$evento,'div-2-10') ;
           
  
      
   }
    
  
  //----------------------------------------------
  function sql($titulo){
  	
   
  	if ( $titulo == 'CLASIFICADOR'){
  		
  	    $sqlb = "SELECT  '-' as codigo, '[ 0. No aplica ]'  AS nombre  union
               SELECT  codigo, (codigo || ' ' || detalle) as nombre
              	FROM presupuesto.pre_catalogo
              	where tipo = 'arbol' and subcategoria = 'gasto' and nivel = 5 and pac = 'S' order by 1 ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  		
  	}
  	
  	
  	
  	if ( $titulo == 'IDACTIVIDAD1'){
  	    $sqlb = "SELECT  0 as codigo, '[ 0. Matriz Actividades ]'  AS nombre  ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  	}
  	
  	if ( $titulo == 'FUNCIONARIO'){

  	    $sqlb = "SELECT  ' ' as codigo, '- 0. Matriz Funcionarios -'  AS nombre  union
           	    SELECT idprov as codigo ,razon as nombre 
          	    FROM view_nomina_user 
          	       order by 2";
         
 
              	    
  	    $resultado = $this->bd->ejecutar($sqlb);
 	}
  	
 
 	
 	if ( $titulo == 'PAC'){
 	    
 	    $sqlb = "SELECT  0 as codigo, '- 0. Matriz PAC -'  AS nombre  ";
 	    
 	    
 	    
 	    $resultado = $this->bd->ejecutar($sqlb);
 	}
 	
  	return $resultado;		
  	
 
  }
  
 
  }
  
  
  $gestion   = 	new Controller_tarea_edicion;
  
  $gestion->Formulario( );
  
 ?>
 

  