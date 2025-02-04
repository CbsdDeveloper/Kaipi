<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


 
 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 $idprov =  trim($_GET['id']);
 $accion =  trim($_GET['accion']);
 

 $sesion 	 =  trim($_SESSION['email']);

 $Aunidad           = $bd->query_array('view_nomina_user',  'id_departamento,idprov', 'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)   );
   
 $iddepartamento     =  $Aunidad['id_departamento'];
  
 $idprovjefe         =  trim($Aunidad['idprov']);

 

if (  $accion  == 'visor') {


            $sql1 = "select *  
            from view_tele_jefe_fun 
            where estado = 'SI' and 
            idprov_jefe = ".$bd->sqlvalue_inyeccion($idprov,true).' order by completo';
        
        
        
        $stmt1 = $bd->ejecutar($sql1);

   
            echo   '<div class="col-md-7" >
                        <div class="list-group">
                    <a href="#" class="list-group-item active">Lista de Funcionarios Asignados</a>';
                
                    
                    $tableroasignado ='';	
                
                    while ($x=$bd->obtener_fila($stmt1)){
                
                    $id_teleasigna    = trim($x['id_teleasigna']);
                    $completo         = trim($x['completo']);
                    $cargo            = trim($x['cargo']);
                    $unidad           = trim($x['unidad']);
                    $idprov           = trim($x['idprov']);



                    $xx = $bd->query_array('nom_tele_trabajo',   // TABLA
                    'count(*) as nn',                        // CAMPOS
                    'id_teleasigna='.$bd->sqlvalue_inyeccion($id_teleasigna,true) . ' and 
                            estado=' .$bd->sqlvalue_inyeccion('S',true).' and 
                            idprov='.$bd->sqlvalue_inyeccion( $idprov,true)
                    );

            
                
                    $titulo =  '<b>'.$completo .'</b>'.' / '.  $cargo  .' / '. $unidad;
                    
                    $mensaje = "goToURL(". "'". $completo."','". $cargo."','". $unidad."','".  $idprov ."',".$id_teleasigna .")";
                    
                    echo ' <a href="#" onClick="'. $mensaje.'" class="list-group-item">'.  $titulo.' <span class="badge">'.$xx['nn'].'</span></a> ';
                
                    }
            
                    echo   '</div></div>';
            
                }


                if (  $accion  == 'gerencial') {

                    $sql1 = "select *  
                    from view_tele_jefe_fun 
                    where estado = 'SI' and 
                    idprov_jefe = ".$bd->sqlvalue_inyeccion($idprovjefe,true).' order by completo';
                
                
                
                $stmt1 = $bd->ejecutar($sql1);
        

                    while ($x=$bd->obtener_fila($stmt1)){
                
                        $id_teleasigna    = trim($x['id_teleasigna']);
                        $completo         = trim($x['completo']);
                        $cargo            = trim($x['cargo']);
                        $unidad           = trim($x['unidad']);
                        $idprov           = trim($x['idprov']);
    

                      echo  '<div class="col-md-3" > 
						 
                      <div class="media-body">
                        <h4 class="media-heading">'.$completo .'</h4>
                        <p>'.  $cargo .'<br>'.$unidad .'</p>
                        </div>
                   
                        </div>';

    /*
    
                        $xx = $bd->query_array('nom_tele_trabajo',   // TABLA
                        'count(*) as nn',                        // CAMPOS
                        'id_teleasigna='.$bd->sqlvalue_inyeccion($id_teleasigna,true) . ' and 
                                estado=' .$bd->sqlvalue_inyeccion('S',true).' and 
                                idprov='.$bd->sqlvalue_inyeccion( $idprov,true)
                        );
    
                
    
    
                    
                        $titulo =  '<b>'.$completo .'</b>'.' / '.  $cargo  .' / '. $unidad;
                        
                        $mensaje = "goToURL(". "'". $completo."','". $cargo."','". $unidad."','".  $idprov ."',".$id_teleasigna .")";
                        
                        echo ' <a href="#" onClick="'. $mensaje.'" class="list-group-item">'.  $titulo.' <span class="badge">'.$xx['nn'].'</span></a> ';
                    

                        */
                        }
               
 


                }
 
  ?> 
								
 
 
 