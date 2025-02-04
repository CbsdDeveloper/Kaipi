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
          
         $APeriodo = $this->bd->query_array('presupuesto.view_periodo',
         									'anio,detalle', 
                                            "tipo =".$this->bd->sqlvalue_inyeccion('elaboracion',true). " and 
                                            estado <>".$this->bd->sqlvalue_inyeccion('cierre',true)
         		      );
         
         
         
         
         $this->set->div_label(12,'<h6>'.$APeriodo['detalle'].'</h6>');
      	
         $resultado =    $this->PerfilSqlUsuario();
      	
      
      	$this->obj->list->listadb($resultado,$tipo,'Unidad Ejecutora','Q_IDUNIDAD',$datos,'required','','div-2-10');
      	
      	
      	echo '<label  style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>';
      	
      	echo '<div   style="padding-top: 5px;" class="col-md-10">
			  <button type="button" class="btn btn-sm btn-primary" onClick="busquedaArticulado()">
				<i class="icon-white icon-search"></i> Buscar
			 </button>
 			 <button type="button" class="btn btn-sm btn-primary" onClick="LimpiarPantallaIndicador()" data-toggle="modal" data-target="#myModalIndicador" title="Indicadores">
                <i class="icon-white icon-bolt"></i>&nbsp;
             </button>

			  </div> &nbsp;&nbsp;';
      	
      
       
      }
      //-----------------------------------------------------------------------------------------------------------
      function PerfilSqlUsuario(){
      	
          $x =  $this->bd->query_array('par_usuario',
              'tipo,id_departamento',
              'email='. $this->bd->sqlvalue_inyeccion( $this->sesion,true)
              ) ;
          
          
          $WHERE = "id_departamento = ".$this->bd->sqlvalue_inyeccion( $x['id_departamento'] ,true);
          
          
          
          if (  trim($x['tipo']) == 'admin'  ){
              $WHERE = " nivel >= 1   ";
          }
          
          if (  trim($x['tipo']) == 'planificacion'  ){
              $WHERE = " nivel >= 1  ";
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