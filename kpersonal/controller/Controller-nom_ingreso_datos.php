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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-nom_ingreso.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
      
 
         $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
         $datos = array();
 
                
                $this->BarraHerramientas();
                
                $tipo = $this->bd->retorna_tipo();
              
                $MATRIZ = array(
                    '02'    => 'Cedula',
                    '01'    => 'RUC',
                    '03'    => 'Pasaporte'
                );

 
                
                $resultado =  $this->combo_lista("nom_departamento");
                $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'required','disabled','div-2-4');
                
                
                $evento = ' ';
                $this->obj->text->texte('<b>Identificacion</b>',"texto",'idprov',20,15,$datos,'required','readonly',$evento,'div-2-4') ; 
                
         
                $this->obj->text->text_yellow('<b>Apellido</b>',"texto",'apellido',40,45,$datos,'required','readonly','div-2-4');
                
                $this->obj->text->text_yellow('<b>Nombre</b>',"texto",'nombre',40,45,$datos,'required','readonly','div-2-4');
                
                  
                $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
                $this->obj->list->listadb($resultado,$tipo,'Programa','programa',$datos,'required','disabled','div-2-4');
                 
                
                $resultado =  $this->combo_lista("nom_cargo");
                $this->obj->list->listadb($resultado,$tipo,'Cargo','id_cargo',$datos,'required','disabled','div-2-4');
                
              
                $MATRIZ =  $this->obj->array->catalogo_anio();
                
                $evento =  '';
                
                $this->obj->list->listae('<b>Seleccionar Periodo</b>',$MATRIZ,'banio',$datos,'required','',$evento,'div-8-4');
                
                
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("razon",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
     
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
   $formulario_reporte = '../../reportes/ficha_empleado?';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
  
    
    $ToolArray = array( 
                 array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
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
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>


 
  