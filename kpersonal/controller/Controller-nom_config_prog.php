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
  
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
              
                $this->anio       =  $_SESSION['anio'];
                
                
    
       }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
    
      
     function Formulario( ){
      
 
  
                $datos = array();
    
                 
                $tipo = $this->bd->retorna_tipo();
                
         
                
                
                 
                 $resultadop =  $this->combo_lista("presupuesto.pre_catalogo");
 
                   $texto  = '<a href="#" title="Copiar programa configuracion para regimen seleccionado" onClick="'.$evento1.'"><b>Programa (+)</b></a>';

 

                $this->set->div_label(12,'<h5><b>PARAMETRIZACION DE PROGRAMA</b></h5>');

                $this->obj->list->listadb($resultadop,$tipo,$texto,'programap',$datos,'','','div-2-4');

             
 
  
      
   }
   
     
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
   //----------------------------------------------
   function combodb(){
    
        $datos = array();
        
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
       
        $datos = array();
       
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
///------------------------------------------------------------------------
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
      
      if  ($tabla == 'items'){

   

        $sql_alimentacion = " union SELECT  trim(cuenta_item) as codigo, ( cuenta_item || ' ' ||  detalle_partida)  as nombre
                                    FROM presupuesto.view_enlace_conta_gasto
                                    where cuenta_item in ('730303','530303') and anio = '2021'
                                    group by cuenta_item, detalle_partida 
                                    order by 1";
          
          $sql ="SELECT ' - ' as codigo,' [ 0. Sin Clasificador ]' as nombre union
                         SELECT trim(clasificador) as codigo, ( clasificador || ' ' ||  detalle)  as nombre
                            FROM presupuesto.view_gasto_nomina_grupo
                            group by clasificador, detalle " . $sql_alimentacion  ;
          
          
          
          $resultado = $this->bd->ejecutar($sql);
          
          
          
      }
      
      //--------------------------------
      
      
      
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
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

?>