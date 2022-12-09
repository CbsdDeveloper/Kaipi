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
     
               $this->evento_form = '../model/Model-proceso.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
        $this->set->_formulario( $this->evento_form,'inicio' ); 
    
                $this->BarraHerramientas();

                $tipo       = $this->bd->retorna_tipo();

                $datos      = array();
                     
                $MATRIZ_B = array(
                  '01'        => '01',
                  '02'        => '02',
                  '03'      => '03',
                  '04'      => '04',
                  '05'        => '05',
                  '06'      => '06',
                  '07'      => '07',
                  '08'      => '08',
                  '09'      => '09',
                  '10'        => '10',
                  '11'        => '11',
                  '12'        => '12'
                );

                $MATRIZA = array(
                  '-'             => '-- Seleccionar Modulo -- ',
                  'requerimiento' => 'PROCESO DE CONTRATACIÓN',
                  'tareas'       => 'SEGUIMIENTO DE ACTIVIDADES SIN RECURSOS',
                  'viaticos'        => 'GESTIÓN DE CONTROL DE VIÁTICOS',
                  'nomina'      => 'GESTIÓN DE PAGOS DE NÓMINA E INGRESOS COMPLEMENTARIOS',
                  'caja'      => 'GESTIÓN DE OTROS GASTOS PLANIFICADOS (sin contratación)',
                );
 
           

                $MATRIZB = array(
                  'Sistema'             => 'sistema'
                 );

              $MATRIZ =  $this->obj->array->catalogo_activo(); ///lista de estados
  
              
              $evento = '';
              
              $this->set->div_panel8('<b> Información de procesos </b>');



              $this->obj->text->text_blue('Codigo',"number" ,'idproc' ,80,80, $datos ,'required','readonly','div-2-4') ;


              $this->obj->list->listae('Estado',$MATRIZ ,'estado',$datos,'required','',$evento,'div-2-4') ;



              $this->obj->list->listae('<b>Módulo</b>',$MATRIZA ,'tipo',$datos,'required','',$evento,'div-2-10') ;
              
              
              $this->obj->list->listae('Subproceso',$MATRIZB ,'modulo',$datos,'required','',$evento,'div-2-10') ;


         
 
              $this->obj->text->text_yellow('Proceso',"texto" ,'proceso' ,80,80, $datos ,'required','','div-2-10') ;



              $resultado = $this->bd->ejecutar("SELECT 0 as codigo , '  --  00. Unidad Responsable  -- ' as nombre union
              SELECT id_departamento AS codigo,  nombre
               FROM nom_departamento  where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc ,true)."
                      ORDER BY 2"   );



                $this->obj->list->listadb($resultado,$tipo,'Unidad Ejecuta','id_departamento',$datos,'required','','div-2-10');
  
                $this->obj->list->listae('Secuencia',$MATRIZ_B ,'secuencia',$datos,'required','',$evento,'div-2-4') ;

            
                $this->obj->text->text_yellow('% Evaluacion',"number" ,'valor' ,80,80, $datos ,'required','','div-2-10') ;
                   

            $this->set->div_panel8('fin');
                          
         $this->obj->text->texto_oculto("action",$datos);  
         
         // campo obligatorio que guarda estados de agregar,editar, eliminar y varios parametros para sql
         
         $this->set->_formulario('-','fin'); 
   
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
  
    $eventoi = "javascript:GenerarRuc()";
    
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',            evento =>'', grafico => 'icon-white icon-plus' ,             type=>"add"),
                array( boton => 'Guardar Registros',        evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' , type=>"submit") );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   
 
  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>