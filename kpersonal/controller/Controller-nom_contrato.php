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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");   
        
                $this->anio       =  $_SESSION['anio'];
              
   
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
      
         
         $datos = array();
 
        $this->set->div_panel12('<h6> Detalle Control de contratos <h6>');
        
        $tipo = $this->bd->retorna_tipo();
        
         
        $this->obj->text->text('Rige',"date" ,'fecha_rige' ,80,80, $datos ,'required','','div-2-4') ;
          
        
        $MATRIZ = array(
            'TRASLADO'    => 'TRASLADO',
            'SUBROGACION'    => 'SUBROGACION',
            'ENCARGO'    => 'ENCARGO',
            'RENUNCIA'    => 'RENUNCIA',
            'REINGRESO'    => 'REINGRESO',
            'SALIDA'    => 'SALIDA',
            'OTRO'    => 'OTRO'
        );
        
       
        
        $this->obj->list->lista('Motivo',$MATRIZ,'motivo_c',$datos,'required','','div-2-4');
        
        $this->obj->text->editor('Detalle','novedad_c',4,175,500,$datos,'required','','div-2-10') ;
        
        $this->set->div_label(12,'Situacion laboral');
        
        $resultado =  $this->combo_lista("nom_regimen");
        $this->obj->list->listadb($resultado,$tipo,'Regimen laboral','p_regimen',$datos,'required','','div-2-4');
        
        $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
        $this->obj->list->listadb($resultado,$tipo,'Programa','p_programa',$datos,'required','','div-2-4');
        
        $resultado =  $this->combo_lista("nom_departamento");
        $this->obj->list->listadb($resultado,$tipo,'Unidad','p_id_departamento',$datos,'required','','div-2-4');
        
        $resultado =  $this->combo_lista("nom_cargo");
        $this->obj->list->listadb($resultado,$tipo,'Cargo','p_id_cargo',$datos,'required','','div-2-4');
        
        $this->obj->text->text_yellow('Sueldo',"number" ,'p_sueldo' ,80,80, $datos ,'required','','div-2-4') ;
    
        
        $this->set->div_panel12('fin');
        
       
 
  
      
   }
 
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
   
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 ///------------------------------------------------------------------------
 
}
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 