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
      private $codigoTarea;
      
      
      public $PERIODO;
      public $NOMBRE_PERIODO;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $year = date('Y');
                
                $Aquery = $this->bd->query_array('planificacion.view_periodo',
                								 'idperiodo, detalle as nombre', 
                								 'anio='.$this->bd->sqlvalue_inyeccion($year,true));
                
                
                $this->PERIODO			= $Aquery['idperiodo'];
                $this->NOMBRE_PERIODO	= $Aquery['nombre'];
                
   
 
      }
		/*
		*/
	function FiltroFormulariouni(){

        $tipo  = $this->bd->retorna_tipo();
        
        $datos = array();
          
        $resultado =  $this->PerfilSqlPeriodo();
        
        $this->obj->list->listadb($resultado,$tipo,'Periodo','Q_IDPERIODO',$datos,'required','','div-0-3');
        
  
       
        $resultado = $this->PerfilSqlUsuarioUni();
      	
       	
      	$this->obj->list->listadb($resultado,$tipo,'Unidad','Q_IDUNIDADPADRE',$datos,'required','','div-0-6');
      	  	
       	
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){

        $tipo  = $this->bd->retorna_tipo();
        
        $datos = array();
          
        $resultado =  $this->PerfilSqlPeriodo();
        
        $this->obj->list->listadb($resultado,$tipo,'Periodo','Q_IDPERIODO',$datos,'required','','div-0-3');
        
  
       
        $resultado = $this->PerfilSqlUsuario();
      	
       	
      	$this->obj->list->listadb($resultado,$tipo,'Unidad','Q_IDUNIDADPADRE',$datos,'required','','div-0-6');
      	  	
       	
 
      }
		
		
	 function FiltroFormularioProceso(){

        $tipo  = $this->bd->retorna_tipo();
        
        $datos = array();
          
        $resultado =  $this->PerfilSqlPeriodo();
        
        $this->obj->list->listadb($resultado,$tipo,'Periodo','Q_IDPERIODO',$datos,'required','','div-0-3');
        
  
       
      
      	  	
       	
 
      }


      function FiltroFormularioSeg(){

        $tipo  = $this->bd->retorna_tipo();
        
        $datos = array();
        
        $evento = '';
          
        $resultado =  $this->PerfilSqlPeriodo();
        
        $this->obj->list->listadb($resultado,$tipo,'Periodo','Q_IDPERIODO',$datos,'required','','div-0-3');
        
  
       
        $resultado = $this->PerfilSqlUsuario();
      	
       	
      	$this->obj->list->listadb($resultado,$tipo,'Unidad','Q_IDUNIDADPADRE',$datos,'required','','div-0-4');
      	  	

          $MATRIZ = array(
            'S'    => 'Actividades - Tareas Autorizadas',
            'N'    => 'Actividades - Tareas Desvinculadas'
        );
        $this->obj->list->listae('',$MATRIZ,'estado1',$datos,'','',$evento,'div-0-3');
       	

 
      }

      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormularioGestion(){
      	
      	$sql =  $this->PerfilSqlPeriodo();
      	
      	$evento = '';
      	
      	$this->bd->listadbe($sql,'Periodo','Q_IDPERIODO','required','',$evento,'div-1-5') ;
      	
 
      }
      //-----------------------------------------------------------------------------------------------------------
      function GrillaFinancieroPOA(){
      	
      	$sql = 'SELECT UNIDAD as "UNIDAD",
                   	sum(VIGENTE) AS "VIGENTE ($)",
			      	sum(DEVENGADO) as "EJECUTADO  ($)",
			      	ROUND(((sum( DEVENGADO) / sum( VIGENTE))) * 100,2) AS "% EJECUCION",
			      	ROUND(((sum( DEVENGADO) / sum( VIGENTE))) * 100,2)   AS "Indicador"
				FROM VIEW_POA_FINANCIERO
				where VIGENTE > 0 AND 
					  IDPERIODO =  '. $this->bd->sqlvalue_inyeccion(  $this->PERIODO,true).'
				group by  IDUNIDAD, IDPERIODO, UNIDAD
				order by 1';
      	
 
      	
      	
      	$resultado =  $this->bd->ejecutar($sql);
      	$tipo	      =  $this->bd->retorna_tipo();
      	$indicador = 5;
      	
      	$this->obj->grid->KP_GRID_WEB_P($resultado,$tipo,'Id', $indicador,'N','','','','100%');
      	
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
      function GrillaTareaPOA(){
      	
      	$sql = 'SELECT NOMBRE as "UNIDAD",
                   	 (TOTALTAREA) AS "TAREAS PLANIFICADAS",
			      	 (TAREAEJECUTADO) as "TAREAS EJECUTADOS",
			      	ROUND((( ( TAREAEJECUTADO) /  ( TOTALTAREA))) * 100,2) AS "% EJECUCION",
			      	ROUND((( ( TAREAEJECUTADO) /  ( TOTALTAREA))) * 100,2)   AS "Indicador"
				FROM VIEW_TAREA_EJECUTA
				where TOTALTAREA > 0 AND
					  IDPERIODO =  '. $this->bd->sqlvalue_inyeccion(  $this->PERIODO,true).'
				order by 1';
      	
      	
     
      	
      	$resultado =  $this->bd->ejecutar($sql);
      	$tipo	      =  $this->bd->retorna_tipo();
      	$indicador = 5;
      	
      	$this->obj->grid->KP_GRID_WEB_P($resultado,$tipo,'Id', $indicador,'N','','','','100%');
      	
      }
      //-----------------------------------------------------------------------------------------------------------
      function PerfilSqlPeriodo(){
      	
          
          $resultado =  $this->bd->ejecutarLista( 'anio,detalle',
              'presupuesto.view_periodo',
              "tipo  <>".$this->bd->sqlvalue_inyeccion('cierre',true). " and
             estado <>".$this->bd->sqlvalue_inyeccion('cierre',true),
              'order by 1,2');
          
          return $resultado;
      	
      	
      }
		
		/*
		*/
		
		  function TareasMes(){
 

				  $anio = date('Y');
			      $mes  = intval(date('m'));
				  
				   $x =  $this->bd->query_array('planificacion.view_tarea_poa',
					  'count(*) as nn',
					  'mes <='. $this->bd->sqlvalue_inyeccion(  $mes,true).' and 
					  anio='. $this->bd->sqlvalue_inyeccion(  $anio,true)."and 
					  cumplimiento<>  'S'  " 
					  ) ;
          
          
			  echo '<div class="alert alert-danger">
					  <strong>ADEVERTENCIA!</strong> Tiene  '. $x['nn'].' Pendientes por notificar y/o ejecutar
					</div>';
        
      	
      }
		
	/*
	
	*/
 function PerfilSqlUsuarioUni(){
      	
          
          $x =  $this->bd->query_array('par_usuario',
              '*',
              'email='. $this->bd->sqlvalue_inyeccion( $this->sesion,true)
              ) ;
          
          
          $WHERE = "id_departamento = ".$this->bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
          
          
         
          
          $resultado1 =  $this->bd->ejecutarLista( 'id_departamento,nombre',
              'nom_departamento',
              $WHERE,
              'order by  2');
              
              return $resultado1;
      	
      	
      }	
      //-----------------------------------------------------------------------------------------------------------
      function PerfilSqlUsuario(){
      	
          
          $x =  $this->bd->query_array('par_usuario',
              '*',
              'email='. $this->bd->sqlvalue_inyeccion( $this->sesion,true)
              ) ;
          
          
          $WHERE = "id_departamento = ".$this->bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
          
          
          
          
          if (trim($x['responsable']) == 'S'){
              $WHERE = "nivel = 0  and id_departamento = ".$this->bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
          }
          
          
          if (  trim($x['tipo']) == 'admin'  ){
              $WHERE = "nivel >= 0";
          }
          if (  trim($x['tipo']) == 'planificacion'  ){
              $WHERE = "nivel >= 0";
          }
          
          if (  trim($x['tipo']) == 'autorizador'  ){
              $WHERE = "nivel >= 0";
          }
          
          $resultado1 =  $this->bd->ejecutarLista( 'id_departamento,nombre',
              'nom_departamento',
              $WHERE,
              'order by  2');
              
              return $resultado1;
      	
      	
      }	
		
 		  
		
       ///------------------------------------------------------------------------
      function __id($idtarea){
          
       
          $array = explode("d", $idtarea);
          
          $temp  = $array[1];
          
          $parametro = explode("a", $temp);
     
          $this->codigoTarea = $parametro[0];
          
         
      }
      ///------------------------------------------------------------------------
      function _tarea(){
          
          $idcodigo = $this->codigoTarea ;
          
          $ViewVisorArbol 		.=  '<div class="panel panel-default"> <div class="panel-heading"><h4>TAREA PLANIFICADO</h4></div> <div class="panel-body">';
       
          
          $AResultado = $this->bd->query_array(
              'VIEW_TAREA_ACTIVIDAD',
              'OBJETIVO, ACTIVIDAD,   RESPONSABLE,   CODIFICADO, CERTIFICADO, DEVENGADO, DISPONIBLE, CLASIFICADOR, 
               PARTIDA, PRODUCTO, TAREA , TIPO_GESTION,  APORTE, DESTINO,  FECHA, FECHAV,  CUMPLIMIENTO ',
              'IDTAREA='.$this->bd->sqlvalue_inyeccion($idcodigo,true));
          
          
          $ViewVisorArbol .= '<h5>Objetivo: <b>'.$AResultado['OBJETIVO'].'</b></h5>';
          $ViewVisorArbol .= '<h6>Actividad: '.$AResultado['ACTIVIDAD'].'</h6>';
          $ViewVisorArbol .= '<h6>Tarea: '.$AResultado['TAREA'].'</h6><hr>';
          
          $ViewVisorArbol .= 'Responsable: '.$AResultado['RESPONSABLE'].'<br>';
          $ViewVisorArbol .= 'Producto a entregar: '.$AResultado['PRODUCTO'].'<br>';
          $ViewVisorArbol .= 'Aporte: '.$AResultado['APORTE'].'<br>';
          $ViewVisorArbol .= 'Fecha Inicio: '.$AResultado['FECHA'].' Fecha Final: '.$AResultado['FECHAV'].'<hr>';
       
          $ViewVisorArbol .= 'Monto Vigente: '.number_format($AResultado['CODIFICADO'],2,",",".").'<br>';
          $ViewVisorArbol .= 'Monto Certificado: '.number_format($AResultado['CERTIFICADO'],2,",",".").'<br>';
          $ViewVisorArbol .= 'Monto Devengado: '.number_format($AResultado['DEVENGADO'],2,",",".").'<br>';
          $ViewVisorArbol .= 'Monto Disponible: '.number_format($AResultado['DISPONIBLE'],2,",",".").'<br>';
          
          $ViewVisorArbol .= '<br></div> </div>';
          
          echo $ViewVisorArbol;
          
      }
      
      
 }   
	
 
 ?>


 
  