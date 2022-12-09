<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
         
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
    }
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function Analisis_actividad( $periodo,$idunidad ){
        
 
        $sqlO1= 'SELECT idactividad, idobjetivo, id_departamento, idperiodo, avance, finalizada
								   FROM planificacion.view_actividad_poa
				 				  WHERE id_departamento = '.$this->bd->sqlvalue_inyeccion($idunidad,true). ' and 
                                        anio= '.$this->bd->sqlvalue_inyeccion($periodo,true) ;
        
 
        
        $stmt_ac = $this->bd->ejecutar($sqlO1);
 
 
        
        
        while ($x=$this->bd->obtener_fila($stmt_ac)){
            
            $idactividad = $x['idactividad'];
            
            $z = $this->bd->query_array('planificacion.view_tarea_poa',
                                        'count(*) as numero, sum(avance) as avance', 
                                        'idactividad='.$this->bd->sqlvalue_inyeccion($idactividad,true));
            
           
            
            $total_actividad = $z['numero'] * 100;
            
            $total_parcial = $z['avance'];
            
            if ( $total_parcial >  0){
                $total_actual =  round(($total_parcial / $total_actividad ),2) * 100;
            }else {
                $total_actual = 0;
            }
            
                 
            
            
            $sql = "UPDATE planificacion.siactividad
					   SET 	avance=".$this->bd->sqlvalue_inyeccion($total_actual, true)."
					 WHERE idactividad=".$this->bd->sqlvalue_inyeccion($idactividad, true);
            
            $this->bd->ejecutar($sql);
            
            
             
        }
     }
  //---------------------------------------------  ------------------
     function Analisis_unidad_tarea( $periodo,$idunidad ){
         
         
         $z = $this->bd->query_array('planificacion.view_actividad_poa',
             'count(*) as numero, sum(avance) as avance',
             ' id_departamento = '.$this->bd->sqlvalue_inyeccion($idunidad,true). ' and
                                        anio= '.$this->bd->sqlvalue_inyeccion($periodo,true) );
         
         
       
             
             $total_actividad = $z['numero'] * 100;
             
             $total_parcial = $z['avance'];
             
             if ( $total_parcial >  0){
                 $total_actual =  round(($total_parcial / $total_actividad ),2) * 100;
             }else {
                 $total_actual = 0;
             }
             
         
         
             return  $total_actual;
         
     }
 //----------------------------------------------
     function FiltroFormulario(){
         
         $tipo  = $this->bd->retorna_tipo();
         
         $datos = array();
         
         $resultado =  $this->PerfilSqlPeriodo();
         
         $this->obj->list->listadb($resultado,$tipo,'Periodo','Q_IDPERIODO',$datos,'required','','div-0-3');
         
         
         
         
         $resultado = $this->PerfilSqlUsuario();
         
         
         $this->obj->list->listadb($resultado,$tipo,'Unidad','Q_IDUNIDADPADRE',$datos,'required','','div-0-6');
         
         
         
     }
 //----------------
     function FiltroFormularioGestion(){
         
         $sql =  $this->PerfilSqlPeriodo();
         
         $evento = '';
         
         $this->bd->listadbe($sql,'Periodo','Q_IDPERIODO','required','',$evento,'div-1-5') ;
         
         
     }
  //-----------------------
     //-----------------------------------------------------------------------------------------------------------
     function PerfilSqlPeriodo(){
         
         
         $sql = "SELECT anio as codigo, detalle as  nombre
				FROM planificacion.view_periodo
				WHERE estado = 'ejecucion' ";
         
         $resultado =$this->bd->ejecutar( $sql );
         
         return $resultado;
         
         
     }
     //-----------------------------------------------------------------------------------------------------------
     function _Periodo(){
         
         $x =  $this->bd->query_array('planificacion.view_periodo',
             'max(anio) as anio',
             'estado='. $this->bd->sqlvalue_inyeccion('ejecucion',true)
             ) ;
         
 
         
         return $x['anio']  ;
         
         
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
             $WHERE = " nivel >= 1   ";
         }
         
         
         $resultado1 =  $this->bd->ejecutarLista( 'id_departamento,nombre',
             'nom_departamento',
             $WHERE,
             'order by  2');
             
             return $resultado1;
             
             
     }	
     //----------------------------------------------------------
     function ArbolUnidad(){
         
         $sql_nivel1 = 'SELECT id_departamento,id_departamentos, nivel,nombre,univel
										 FROM nom_departamento
										 WHERE nivel = 1
										 ORDER BY id_departamento,id_departamentos';
         
         
         $stmt_nivel1 = $this->bd->ejecutar($sql_nivel1);
         
         echo '<li>';
         
         while ($x=$this->bd->obtener_fila($stmt_nivel1)){
             
             $nombre 				= trim($x['nombre']);
             $id_unidad  			= trim($x['id_departamento']);
             
             echo '<a href="#">'.$nombre.'</a>';
             
             $mas_niveles = $this->_niveles($id_unidad  );
             
             $nivel = 2;
             
             if ( $mas_niveles >= 1){
                 
                 $this->Subnivel($id_unidad,$nivel);
                 
             }
             
             
         }
         
         echo '</li>';
         
         
     }
  //---------------------------------------------------------
     function _niveles($id_unidad ){
         
         $AResultado = $this->bd->query_array('nom_departamento',
             'count(*) as numero',
             'id_departamentos='.$this->bd->sqlvalue_inyeccion($id_unidad,true));
         
         return $AResultado['numero'] ;
     }
     
     //--------------------------------------------------------
   function Subnivel($id_unidad,$nivel){
         
         
         $nivel = $nivel + 1;
         
         $anio =  $this->_Periodo();
          
         $sql1 ="SELECT id_departamento,id_departamentos, nivel,nombre,univel
                   FROM nom_departamento
                   WHERE id_departamentos =" .$this->bd->sqlvalue_inyeccion($id_unidad,true); ;
                         
         
         $stmt_nivel2 = $this->bd->ejecutar($sql1);
         
         echo '<ul>';
         
         while ($y=$this->bd->obtener_fila($stmt_nivel2)){
             
          
             $id_departamento_nivel2     =  ($y['id_departamento']);
         
             $p1 = $this->Analisis_unidad_tarea( $anio,$id_departamento_nivel2 );
             
             $imagen = ' <img src="../../kimages/m_advertencia.png" align="absmiddle" >';
             
             if (( $p1 >  0) && ($p1 < 15)){
                 $imagen = ' <img src="../../kimages/m_advertencia.png" align="absmiddle" >';
             }
             
             if (( $p1 >  15) && ($p1 < 85)){
                 $imagen = ' <img src="../../kimages/m_rojo.png" align="absmiddle" >';
             }
             
             if (( $p1 >  85) && ($p1 < 95)){
                 $imagen = ' <img src="../../kimages/m_amarillo.png" align="absmiddle" >';
             }
             
             if (( $p1 >  95) && ($p1 < 195)){
                 $imagen = ' <img src="../../kimages/m_verde.png" align="absmiddle" >';
             }
             
 
             
             $titulo_nivel2 			 = $imagen.' '.trim($y['nombre']).' '.$p1.'%';
             
             echo  '<li> <a href="#">'.$titulo_nivel2.'</a>';
             
             $mas_niveles = $this->_niveles($id_departamento_nivel2  );
             
             if ( $mas_niveles >= 1){
                 
                 $this->Subnivel($id_departamento_nivel2,$nivel);
                 
             }
             
             
             
             echo '</li>';
             
         }
         echo '</ul>';
         
         
     }   
     
   //-----------------------------------------------------------------------------
   
     function FiltroUnidadDato(){
         
         $anio =  $this->_Periodo();
         
         
         $y =  $this->bd->query_array('planificacion.view_unidad_resumen',
             'sum(codificado) as total',
             'anio='. $this->bd->sqlvalue_inyeccion($anio,true)
             ) ;
         
         
         $sql_nivel1 = 'SELECT id_departamento, idperiodo, anio, nombre, programa, objetivos, inicial, codificado, certificacion, ejecutado
                          FROM planificacion.view_unidad_resumen WHERE anio='.$this->bd->sqlvalue_inyeccion($anio,true);
         
         $stmt_nivel1 = $this->bd->ejecutar($sql_nivel1);
         
          
         
         
         while ($x=$this->bd->obtener_fila($stmt_nivel1) ){
             
              $datos1 =  $x['nombre'];
              $datos2 =  $x['inicial'];
              
              $p1 =   round(( $datos2 /  $y['total']),2) * 100;
           
              $colorValue = 1;
        
              if (( $p1 > 0 )  && ( $p1 <=10  )){
                  $colorValue = 1;
              }elseif(( $p1 > 10 )  && ( $p1 <= 25  )){
                  $colorValue = 2;
              }elseif(( $p1 > 25 )  && ( $p1 <= 35  )){
                  $colorValue = 3;
              }elseif(( $p1 > 35 )  && ( $p1 <= 45  )){
                  $colorValue = 4;
              }elseif(( $p1 > 45 )  && ( $p1 <= 65  )){
                  $colorValue = 5;
              }elseif(( $p1 > 65 )  && ( $p1 <= 85  )){
                  $colorValue = 6;
              }elseif(( $p1 > 85 )  && ( $p1 <= 101  )){
                  $colorValue = 7;
              }
                
 
                  
             echo "{
                        name: '".trim($datos1)."',
                        value: ".$p1.",
                        colorValue: ".$colorValue." 
                    },";
             
             
             
         }
         
      
         
         
     }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------


 



?>
 
  