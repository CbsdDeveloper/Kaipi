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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date('Y-m-d');
     
               $this->evento_form = '../model/Model-ren_frecuencias.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
        $this->set->_formulario( $this->evento_form,'inicio' ); 
    
                $this->BarraHerramientas();

                $tipo       = $this->bd->retorna_tipo();

                $datos      = array();

                $resultado2 = $this->bd->ejecutar("SELECT 0 as codigo , '  [ Ciudades ]' as nombre union
                     SELECT idcatalogo AS codigo,  nombre
                  FROM par_catalogo  where tipo='canton'    ORDER BY 1"   );

                $resultado3 = $this->bd->ejecutar("SELECT 0 as codigo , '  [ Ciudades ]' as nombre union
                     SELECT idcatalogo AS codigo,  nombre
                  FROM par_catalogo  where tipo='canton'    ORDER BY 1"   );
  

                  $resultado = $this->bd->ejecutar("SELECT '-' as codigo , '  -- 00 Seleccionar Cooperativa  -- ' as nombre union
                  SELECT idprov AS codigo,  razon as nombre
                FROM par_ciu  where estado = 'S' and serie = 'C' 
                ORDER BY 2"   );


               
             $this->set->div_panel10('<b> INFORMACION DE  LA FRECUENCIA  </b>');
                 
 

                  $this->obj->text->texto_oculto("id_fre",$datos);   // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql

                 
                  $this->obj->list->listadb($resultado,$tipo,'Cooperativa','idprov',$datos,'required','','div-2-10');
 
                  $this->obj->list->listadb($resultado2,$tipo,'Ubicacion Origen','id_ciu_ori',$datos,'required','','div-2-10');

 
                  $this->obj->text->text_yellow('Origen',"texto" ,'ruta_ori' ,80,80, $datos ,'required','','div-2-4') ;

                  $this->obj->text->text('Destino',"texto" ,'ruta_des' ,80,80, $datos ,'required','','div-2-4') ;


                  $this->obj->text->texto_oculto("num_carro",$datos); 
                  $this->obj->text->texto_oculto("num_placa",$datos); 

                  $this->obj->text->texto_oculto("id_ciu_des",$datos); 
                  $this->obj->text->texto_oculto("chofer",$datos); 
                  $this->obj->text->texto_oculto("hora_min",$datos); 
                   
 
  
 
                  $this->obj->text->text('Hora Salida',"time" ,'hora' ,80,80, $datos ,'required','','div-2-4') ;

 
                  $this->obj->text->texto_oculto("action",$datos);   // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql

                
              $this->set->div_panel12('fin');

       $this->set->_formulario('-','fin'); 
   
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
  
     
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',            evento =>'', grafico => 'icon-white icon-plus' ,             type=>"add"),
                array( boton => 'Guardar Registros',        evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' , type=>"submit") 
                
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>