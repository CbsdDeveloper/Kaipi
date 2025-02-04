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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
  
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date('Y-m-d');
     
                $this->anio       =  $_SESSION['anio'];

               $this->evento_form = '../model/Model-ac_matriz_esigef.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
        $this->set->_formulario( $this->evento_form,'inicio' ); 
    
        $this->BarraHerramientas();

        $tipo       = $this->bd->retorna_tipo();

        $datos      = array();

               
        $this->set->div_label(12,'INFORMACION DE LA MATRIZ'); // etiqueta  para un nuevo bloque de informacion
                
              $this->obj->text->text('Matriz',"number" ,'id_matriz_esigef' ,80,80, $datos ,'required','readonly','div-2-4') ; 

              $this->obj->text->text_yellow('Identificador',"texto" ,'identificador' ,80,80, $datos ,'required','','div-2-4') ;
           
              $evento = 'onChange="selecciona_cuenta(this.value)"';
      
              $resultado = $this->sql(1);
              $this->obj->list->listadbe($resultado,$tipo,'<b>Enlace Contable</b>','cuenta',$datos,'required','',$evento,'div-2-10');
 
              $this->obj->text->text('Item',"texto" ,'item' ,80,80, $datos ,'required','','div-2-4') ;

 
              $this->set->div_label(12,'DETALLE CLASE Y NOMBRE ENLACE MATRIZ  BIENES'); // etiqueta  para un nuevo bloque de informacion


              $this->obj->text->text('Clase',"texto" ,'clase' ,80,80, $datos ,'required','','div-2-10') ;

              $this->obj->text->text_blue('Detalle',"texto" ,'detalle' ,80,80, $datos ,'required','','div-2-10') ;
            


                          
         $this->obj->text->texto_oculto("action",$datos);   // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql
         
         $this->set->_formulario('-','fin'); 
   
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
  
     
    $ToolArray = array( 
               
        array( boton => 'Nuevo Regitros',evento =>'', grafico => 'icon-white icon-plus' ,type=>"add"),

        array( boton => 'Guardar Registros',evento =>'', grafico =>'glyphicon glyphicon-floppy-saved',type=>"submit"),
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   
  /*
  */
  function sql($titulo){
      
    if  ($titulo == 1){ 
      
        $sqlb = "Select '-' as codigo, '[01. Seleccione cuenta contable ]' as nombre   
                  union
                  SELECT  cuenta as codigo, (cuenta || '.'||  detalle) as nombre
                  FROM  co_plan_ctas
                  where tipo_cuenta = 'A' and nivel > 4 and
                        anio =".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
                        estado =".$this->bd->sqlvalue_inyeccion('S', true).' order by 1';
         
  }
  
  
  
  $resultado = $this->bd->ejecutar($sqlb);
  
  
  return  $resultado;
  
}  
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>