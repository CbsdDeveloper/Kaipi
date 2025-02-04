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
     
               $this->evento_form = '../model/Model-adm_pac.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
      /*
      //Construye la pantalla de ingreso de datos
      */
      function Formulario( ){
      
        $this->set->_formulario( $this->evento_form,'inicio' ); 
    
                $this->BarraHerramientas();

                $tipo   = $this->bd->retorna_tipo();

                $datos      = array();
            
            $this->set->div_panel12('<b> Información de PAC </b>');

                $this->set->div_label(12,'Información Principal');

                                $this->obj->text->text_blue('Nro.PAC',"number" ,'id_pac' ,80,80, $datos ,'required','readonly','div-2-4') ;

                                $this->obj->text->text('Referencia',"number" ,'referencia' ,80,80, $datos ,'required','','div-2-4') ;

                                $this->obj->text->text_yellow('Partida',"texto" ,'partida' ,80,80, $datos ,'required','','div-2-4') ;

                                $this->obj->text->text('CPC',"texto" ,'cpc' ,80,80, $datos ,'required','','div-2-4') ;

                                $MATRIZ_A = array(
                                    '-'                 => 'No Aplica',
                                    'BIEN'              => 'BIEN',
                                    'OBRAS'              => 'OBRAS',
                                    'CONSULTORIA'       => 'CONSULTORIA',
                                    'SERVICIO'          => 'SERVICIO'    
                                );


                                $this->obj->list->listae('Tipo',$MATRIZ_A,'tipo',$datos,'required','',$evento,'div-2-4');

                                
                                $MATRIZ_B = array(
                                    '-'                 => 'No Aplica',
                                    'COMUN'             => 'COMUN',
                                    'ESPECIAL'          => 'ESPECIAL'   
                                );

                                $this->obj->list->listae('Regimen',$MATRIZ_B,'regimen',$datos,'required','',$evento,'div-2-4');

                                

                                $MATRIZ_C = array(
                                    '-'                     => 'No Aplica',
                                    'GASTO CORRIENTE'       => 'GASTO CORRIENTE',
                                    'PROYECTO DE INVERSION' => 'PROYECTO DE INVERSION'   
                                );

                                $this->obj->list->listae('Tipo proyecto',$MATRIZ_C,'tipo_proyecto',$datos,'required','',$evento,'div-2-10');
                                
                                    $MATRIZ_D = array(
                                    '-'        => 'No Aplica',
                                    'NORMALIZADO'      => 'NORMALIZADO',
                                    'NO NORMALIZADO'   => 'NO NORMALIZADO'   
                                );


                                $this->obj->list->listae('Tipo producto',$MATRIZ_D,'tipo_producto',$datos,'required','',$evento,'div-2-4');

                                $MATRIZ_E = array(
                                    'NO'        => 'NO',
                                    'SI'        => 'SI'
                                        
                                );
                
                                $this->obj->list->listae('Catalogo Electronico',$MATRIZ_E,'catalogo_e',$datos,'required','',$evento,'div-2-4');

                                $resultado = $this->bd->catalogo_compras() ;
                                $this->obj->list->listadbe($resultado,$tipo,Procedimiento,'procedimiento',$datos,'required','',$evento,'div-2-4');


 
                 $this->set->div_label(12,'Detalle del Objeto de Contratación');

                                $this->obj->text->editor('Detalle','detalle',3,150,500,$datos,'required','','div-2-10') ;

                                $this->obj->text->text('Cantidad',"number" ,'cantidad' ,80,80, $datos ,'required','','div-2-4') ;

                                $MATRIZ_G= $this->obj->array->catalogo_unidades_pac();

                                $this->obj->list->listae('Medida',$MATRIZ_G,'medida',$datos,'required','',$evento,'div-2-4');

                                $this->obj->text->text_yellow('Costo',"number" ,'costo' ,80,80, $datos ,'required','','div-2-4') ;

                                $this->obj->text->text_yellow('Total',"number" ,'total' ,80,80, $datos ,'required','','div-2-4') ;

                                   

                                $MATRIZ_H= $this->obj->array->catalogo_activo();

                                $this->obj->list->listae('Estado',$MATRIZ_H,'estado',$datos,'required','',$evento,'div-2-4');

                 $this->set->div_label(12,'Informacion Planificación');

                        $resultado = $this->bd->ejecutar_unidad();     // funcion que trae la informacion de las unidades de la institucion
                        $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'required','','div-2-10');

                        $resultado =  $this->sql('CLASIFICADOR');
                        $this->obj->list->listadb($resultado,$tipo,'Gasto','clasificador',$datos,'required','','div-2-10');
   
                        
 
                        $this->obj->text->text_dia('Fecha ejecución',120,'fecha_ejecuta' ,80,80, $datos ,'required','','div-2-4') ;

                        $this->obj->text->text_dia('Fecha Hastas',120, 'fecha_final' ,80,80, $datos ,'required','','div-2-4') ;

   
               
  
 
                 $this->obj->text->text('Avance',"texto" ,'avance' ,80,80, $datos ,'','readonly','div-2-4') ;

 
            $this->set->div_panel12('fin');


            $this->obj->text->texto_oculto("action",$datos);  
            $this->obj->text->texto_oculto("partida_fin",$datos); 

            $this->obj->text->texto_oculto("programa",$datos); 
            $this->obj->text->texto_oculto("anio",$datos);  
            $this->obj->text->texto_oculto("bid",$datos);  
            $this->obj->text->texto_oculto("periodo",$datos);  
          
          
         $this->set->_formulario('-','fin'); 
   
      
   }
 /*
 Barra de herramientas para agregar, guardar y varios procesos
 */
   function BarraHerramientas(){
  
    $evento = " GenerarRuc()";
    
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',            evento =>'', grafico => 'icon-white icon-plus' ,             type=>"add"),
                array( boton => 'Guardar Registros',        evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' , type=>"submit") ,
               
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
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
    
     
    
    return $resultado;		
    

}

  }
  //-------------------------------------------------
  //-------------------------------------------------

  $gestion   = 	new componente;
  
   
  $gestion->Formulario();
  
 ?>