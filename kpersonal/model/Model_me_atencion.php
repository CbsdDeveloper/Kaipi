<?php 
session_start( );   
  
require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  
  
class Model_me_atencion{
 
  
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function Model_me_atencion( ){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	     = 'medico.ate_medica';
                
                $this->secuencia 	     = 'medico.ate_medica_id_atencion_seq';
                
             
                
                $this->ATabla = array(
                    array( campo => 'id_atencion',   tipo => 'NUMBER',      id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'id_prov',       tipo => 'VARCHAR2',    id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha',         tipo => 'DATE',        id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fatencion',     tipo => 'DATE',        id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora',          tipo => 'VARCHAR2',    id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'motivo',        tipo => 'VARCHAR2',    id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sintomas',      tipo => 'VARCHAR2',    id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'revision_organos', tipo => 'VARCHAR2', id => '7',add => 'S', edit => 'S', valor => 'NO APLICA', key => 'N'),
                    array( campo => 'diagnostico',tipo => 'VARCHAR2',       id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'examen_fisico',tipo => 'VARCHAR2',     id => '9',add => 'S', edit => 'S', valor => 'NO APLICA', key => 'N'),
                    array( campo => 'comentario',tipo => 'VARCHAR2',        id => '10',add => 'S', edit => 'S', valor => 'NO APLICA', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',            id => '11',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                    array( campo => 'fcreacion',tipo => 'DATE',             id => '12',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
                    array( campo => 'msesion',tipo => 'VARCHAR2',           id => '13',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'fmodifica',tipo => 'DATE',             id => '14',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
                    array( campo => 'pago',tipo => 'VARCHAR2',              id => '15',add => 'S', edit => 'N', valor => 'N', key => 'N'),
                    array( campo => 'especialidad',tipo => 'VARCHAR2',      id => '16',add => 'S', edit => 'N', valor => 'MEDICINA GENERAL', key => 'N'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',              id => '17',add => 'S', edit => 'N', valor => 'interno', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',            id => '18',add => 'S', edit => 'N', valor => 'solicitado', key => 'N') 
                    
                  );
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo,$mensaje='ACTUALIZACION',$estado='solicitado'){
       
        $resultado = $this->bd->resultadoCRUD($mensaje='ACTUALIZACION',
        $accion,
        $id,
        $tipo,
        $estado='X');

       return $resultado;   
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_limpiar( ){
        
             $resultado = '';
             echo '<script type="text/javascript">';
              
             echo  'LimpiarPantalla();';               
   
             echo '</script>';
 
            return $resultado;   
 
      }     
   
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
 	
  	
     $qquery = array( 
                 array( campo => 'id_atencion',   valor => trim($id),  filtro => 'S',   visor => 'S'),
                 array( campo => 'id_prov',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fatencion',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'hora',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'motivo',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'sintomas',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'revision_organos',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'diagnostico',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'examen_fisico',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'comentario',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'especialidad',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'nombre_funcionario',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'edad',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'tsangre',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'peso',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'estatura',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'arterial',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'cardio',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'respiratorio',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'temperatura',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'so2',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'imc',valor => '-',filtro => 'N', visor => 'S')
           );
     
        
           $this->bd->JqueryArrayVisor('medico.view_ate_medica',$qquery );           
 
   
        /*  echo '<script type="text/javascript">';
         
          echo  'imagenfoto("'.$url.$datos['foto'].'");';
           
          echo '</script>';
*/
          $result =  $this->div_resultado($accion,$id,0);
     
        echo  $result;
        
      }	
  
      
      //---retorna el valor del campo para impresion de pantalla  
      //--------------------------------------------------------------------------------        
 
     function xcrud($action,$id){
          
 
                 // ------------------  agregar
                 if ($action == 'add'){
                    
                     $this->agregar( );
                 
                 }  
                 // ------------------  editar
                 if ($action == 'editar'){
        
                     $this->edicion($id );
     
                 }  
                 // ------------------  eliminar
                  if ($action == 'del'){
        
                     $this->eliminar($id );
     
                 }  
 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
     	
 
         $id_prov       =  trim($_POST["id_prov"]);
         
         $lon = strlen($id_prov);
         
         if ($lon > 5 ){
             
             $id =    $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
             
             $result = $this->div_resultado('editar',$id,1).'['. $id.']';
         }else{
             $result= 'INGRESE LA INFORMACION DEL PACIENTE...'.$id   ;
         }
             
          
   
            echo $result;

     }	
      //---------------------------------------------------
     function k_situacion_actual($id ){
          
         
         $sql_movimiento = "SELECT count(*) as movimiento FROM nom_personal  where idprov =".$this->bd->sqlvalue_inyeccion($id ,true);
         
         $resultado_mov         = $this->bd->ejecutar($sql_movimiento);
         
         $datos_movimiento      = $this->bd->obtener_array( $resultado_mov);
         
         $fecha			        = $this->bd->fecha($_POST["fecha"]);
         



                 
 
         
         
         if  ($datos_movimiento["movimiento"] == 0){
             
             $sql = "INSERT INTO nom_personal( idprov, id_departamento, id_cargo, responsable, regimen, fecha, 
                contrato, registro,genero,foto,sidecimo,sicuarto,sihoras,sisubrogacion,discapacidad,motivo,sueldo)
    				VALUES (".
    				$this->bd->sqlvalue_inyeccion( $_POST["idprov"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",".
    				$fecha.",".
    				$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",".
    				$this->bd->sqlvalue_inyeccion(  $this->ruc , true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["genero"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["foto"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sidecimo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sicuarto"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sihoras"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sisubrogacion"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["discapacidad"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["motivo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true).")";
				

    				
    				$this->bd->ejecutar($sql);
         }
         else {
             
             $sql = "UPDATE nom_personal
    			     SET  id_departamento  =".$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",
    			   		id_cargo         =".$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",
    					responsable      =".$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",
	                    registro         =".$this->bd->sqlvalue_inyeccion(  $this->ruc , true).",
    					regimen          =".$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",
                        sidecimo          =".$this->bd->sqlvalue_inyeccion( $_POST["sidecimo"], true).",
                        sicuarto          =".$this->bd->sqlvalue_inyeccion( $_POST["sicuarto"], true).",
                        sihoras          =".$this->bd->sqlvalue_inyeccion( $_POST["sihoras"], true).",
                        sisubrogacion          =".$this->bd->sqlvalue_inyeccion( $_POST["sisubrogacion"], true).",
                        foto          =".$this->bd->sqlvalue_inyeccion( $_POST["foto"], true).",
    					fecha            =".$fecha.",
    					contrato         =".$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",
                        discapacidad         =".$this->bd->sqlvalue_inyeccion( $_POST["discapacidad"], true).",
                        motivo         =".$this->bd->sqlvalue_inyeccion( $_POST["motivo"], true).",
                        genero         =".$this->bd->sqlvalue_inyeccion( $_POST["genero"], true).",
    					sueldo           =".$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true)."
     			 WHERE idprov            =".$this->bd->sqlvalue_inyeccion($id, true);
             

             
             $this->bd->ejecutar($sql);
         }
         
         return  $datos_movimiento["movimiento"];
     }
     ///--------------------------------------------------------
     function signos( $id,$GET ){
        
 
             $sql = "UPDATE medico.ate_medica
			   SET  peso=".$this->bd->sqlvalue_inyeccion($GET["peso"], true).",
			   		estatura       =".$this->bd->sqlvalue_inyeccion($GET["estatura"], true).",
					arterial      =".$this->bd->sqlvalue_inyeccion($GET["arterial"], true).",
					cardio     =".$this->bd->sqlvalue_inyeccion($GET["cardio"], true).",
					respiratorio     =".$this->bd->sqlvalue_inyeccion($GET["respiratorio"], true).",
                    comentario     =".$this->bd->sqlvalue_inyeccion($GET["comentario"], true).",
                    examen_fisico     =".$this->bd->sqlvalue_inyeccion($GET["examen_fisico"], true).",
                    revision_organos     =".$this->bd->sqlvalue_inyeccion($GET["revision_organos"], true).",
                    temperatura     =".$this->bd->sqlvalue_inyeccion($GET["temperatura"], true).",
                     imc     =".$this->bd->sqlvalue_inyeccion($GET["imc"], true).",
                    so2     =".$this->bd->sqlvalue_inyeccion($GET["so2"], true)."
             WHERE id_atencion       =".$this->bd->sqlvalue_inyeccion($id, true);
             
    
             
             $this->bd->ejecutar($sql);
             
             
             $result = 'DATOS ACTUALIZADOS CON EXITO ['. $id.']';
        
         
             echo $result;
     }
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
 
           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           
            
        	
           $result = $this->div_resultado('editar',$id,1).'['. $id.']';
  
           echo $result;
          
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
        
         /*
         $x = $this->bd->query_array('nom_rol_pagod', 'count(*) as nn', 'idprov='.$this->bd->sqlvalue_inyeccion($id,true));
         
         $y = $this->bd->query_array('co_asiento_aux', 'count(*) as nn', 'idprov='.$this->bd->sqlvalue_inyeccion($id,true));
         
         $z = $this->bd->query_array('inv_movimiento', 'count(*) as nn', 'idprov='.$this->bd->sqlvalue_inyeccion($id,true));
         
         $valida = $x['nn'] +  $y['nn'] +  $z['nn'];
         
         
         if ( $valida > 0  ){
             
             $result ='<b>NO SE PUEDE ELIMINAR ... TIENE REGISTROS GENERADOS EN CONTABILIDAD - ROLES - INVENTARIOS</b>';
             
         }else{
             
             $this->bd->JqueryDeleteSQL('par_ciu','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
             
             $this->bd->JqueryDeleteSQL('nom_personal','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
             
             $this->bd->JqueryDeleteSQL('nom_adicional','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
             
             $this->bd->JqueryDeleteSQL('nom_laboral','idprov='.$this->bd->sqlvalue_inyeccion(trim($id), true));
          
             $result ='REGISTRO ELIMINADO CON EXITO ('.$valida.') Referencia: '. $id;
         }
         */
   
       echo $result;
      
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new Model_me_atencion;
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = trim($_GET['id']);
            
            if ( $accion == 'del'){
                
                $gestion->eliminar($id);
                
            }
            elseif ( $accion == 'signos'){
                
                $gestion->signos($id,$_GET);
                
            }
            else {
                
                $gestion->consultaId($accion,$id);
                
            }
       
            
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= trim($_POST["id_atencion"]);
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  