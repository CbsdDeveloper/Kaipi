<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){

        $tipo       = $this->bd->retorna_tipo();
        $datos      = array();
          
        $resultado =  $this->PerfilSqlPeriodo(); 
      	$this->obj->list->listadb($resultado,$tipo,'Periodo','Q_IDPERIODO',$datos,'required','','div-1-3');
      	
      	 
      
      	$resultado1 = $this->PerfilSqlUsuario();
      	$this->obj->list->listadb($resultado1,$tipo,'Unidad','Q_IDUNIDADPADRE',$datos,'required','','div-1-3');
      	
 
      	
 
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
               $WHERE = "nivel = 0";
           }
           if (  trim($x['tipo']) == 'planificacion'  ){
               $WHERE = "nivel = 0";
           }
           
           if (  trim($x['tipo']) == 'autorizador'  ){
               $WHERE = "nivel = 0";
           }
           
          $resultado1 =  $this->bd->ejecutarLista( 'id_departamento,nombre',
              'nom_departamento',
              $WHERE,
              'order by  2');
 
          return $resultado1;
          
 }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  