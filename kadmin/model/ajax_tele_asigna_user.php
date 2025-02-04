<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


 
 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

  $accion =  trim($_GET['accion']);
 

 $sesion 	 =  trim($_SESSION['email']);

 $Aunidad           = $bd->query_array('view_nomina_user',  'id_departamento,idprov', 'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)   );
   
 $iddepartamento     =  $Aunidad['id_departamento'];
  
 $idprov         =  trim($Aunidad['idprov']);

 
 $hoy = date('Y-m-d');

 
 

if (  $accion  == 'gerencial') {


            $sql1 = "SELECT id_teletrabajo, idprov_jefe, fecha, anio, mes, estado, actividades, sesion, id_teleasigna, fecha_inicio, fecha_fin, idprov, 
            cumplida, responsable, cargo, unidad, funcionario, cargo_fun, unidad_fun, email, sesion_corporativo 
            FROM  view_tele_actividad_funcionario
            where estado = 'S' and 
                  ".$bd->sqlvalue_inyeccion($hoy,true) ." between fecha_inicio and fecha_fin and 
                  sesion_corporativo =   ".$bd->sqlvalue_inyeccion($sesion,true)  ;
        
        
        
        $stmt1 = $bd->ejecutar($sql1);

   
            echo   '<div class="col-md-5" >
                        <div class="list-group">
                    <a href="#" class="list-group-item active">Actividades Asignadas</a>';
                
                    
                    $tableroasignado ='';	
                
                    while ($x=$bd->obtener_fila($stmt1)){
                
                    $id_teletrabajo         = trim($x['id_teletrabajo']);
                    $completo               = trim($x['actividades']);
                    $responsable            = trim($x['responsable']);
                    $unidad           = trim($x['unidad']);
                    $idprov           = trim($x['idprov']);

                    $semana           = trim($x['fecha_inicio']).' hasta '. trim($x['fecha_fin']);



                    $xx = $bd->query_array('nom_tele_trabajo',   // TABLA
                    'count(*) as nn',                        // CAMPOS
                    'id_teleasigna='.$bd->sqlvalue_inyeccion($id_teleasigna,true) . ' and 
                            estado=' .$bd->sqlvalue_inyeccion('S',true).' and 
                            idprov='.$bd->sqlvalue_inyeccion( $idprov,true)
                    );

            
                
                    $titulo =  '<b>'.$completo .'</b>'.' <br>'.  $responsable  .' / '. $unidad.' <br>'. $semana ;
                    
                 //   $mensaje = "goToURL(". "'". $completo."','". $cargo."','". $unidad."','".  $idprov ."',".$id_teleasigna .")";
                    
                    echo ' <a href="#" onClick="'. $mensaje.'" class="list-group-item">'.  $titulo.' <span class="badge">'.$xx['nn'].'</span></a> ';
                
                    }
            
                    echo   '</div></div>';


                    
            echo   '<div class="col-md-7" >
                          <div class="list-group">
                               <a href="#" class="list-group-item active">Ultimas Tareas Registradas</a>';


                 echo   '</div></div>';


                }
 
 
  ?> 
								
 
 
 