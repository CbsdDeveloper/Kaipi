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
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->anio       =  $_SESSION['anio'];
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
       
        $tipo = $this->bd->retorna_tipo();
      	
        $datos['fanio']	= $this->anio;
       	
      	$this->obj->text->text('',"number",'fanio',2000,2020,$datos,'required','','div-0-2') ;
      	 
      	$evento = '';
      
      	$MATRIZ = array(
      	    '01'  => 'Enero',
      	    '02'  => 'Febrero',
      	    '03'  => 'Marzo',
      	    '04'  => 'Abril',
      	    '05'  => 'Mayo',
      	    '06'  => 'Junio',
      	    '07'  => 'Julio',
      	    '08'  => 'Agosto',
      	    '09'  => 'Septiembre',
      	    '10'  => 'Octubre',
      	    '11'  => 'Noviembre',
      	    '12'  => 'Diciembre'
      	);
      	 
      	$this->obj->list->listae('',$MATRIZ,'cmesi',$datos,'','',$evento,'div-0-2');
      	
      	
      	$MATRIZ = array(
      	    '-'  => 'Ejecucion '.$datos['fanio']	,
      	    '01'  => 'Enero',
      	    '02'  => 'Febrero',
      	    '03'  => 'Marzo',
      	    '04'  => 'Abril',
      	    '05'  => 'Mayo',
      	    '06'  => 'Junio',
      	    '07'  => 'Julio',
      	    '08'  => 'Agosto',
      	    '09'  => 'Septiembre',
      	    '10'  => 'Octubre',
      	    '11'  => 'Noviembre',
      	    '12'  => 'Diciembre'
      	);
      	$this->obj->list->listae('',$MATRIZ,'cmes',$datos,'','',$evento,'div-0-2');
      	
  
      	
      	$sql ="select '-' as codigo, 'Fuente de Financiamiento' as nombre union 
                SELECT  codigo, 	codigo || ' '  || detalle as nombre
                FROM presupuesto.pre_catalogo
                where categoria = 'fuente' and estado = 'S'"   ;
      	
      	$resultado = $this->bd->ejecutar($sql);
      	
      	$this->obj->list->listadbe($resultado,$tipo,'','vfuente',$datos,'','',$evento,'div-0-3');
      	
      	
      	$sql ="select '-' as codigo, 'Grupo Presupuestario' as nombre union
               SELECT a.grupo as codigo,  a.grupo || ' '  || b.detalle as nombre
                FROM presupuesto.view_grupo_ingreso a, presupuesto.pre_catalogo b
                where  a.anio =  ". $this->bd->sqlvalue_inyeccion($datos['fanio'],true)." and  
                       b.nivel = 2 and 
                       b.subcategoria = 'ingreso' and 
                       a.grupo = b.codigo"   ;
      	
      	$resultado = $this->bd->ejecutar($sql);
      	
      	$this->obj->list->listadbe($resultado,$tipo,'','vgrupo',$datos,'','',$evento,'div-0-3');
      	
      	
      	$this->obj->text->text_place('Buscar x clasificador',"texto" ,'clasificadori' ,80,80, $datos ,'','','div-0-2') ;
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  