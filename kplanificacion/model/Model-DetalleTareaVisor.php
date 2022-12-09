<?php   
    session_start(); 
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
 
    $bd	   =	     	new Db ;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
   
    if (isset($_GET['id']))	{
        
        $id = $_GET['id'];
        
        $sql =  "SELECT idtarea, idactividad, estado, tarea, recurso, inicial, codificado, certificacion,
                           ejecutado, disponible, aumentoreformas, disminuyereforma, cumplimiento, reprogramacion,
                           responsable, nombre_funcionario, correo, movil, fechainicial, fechafinal, sesion,
                           creacion, sesionm, modificacion, programa, clasificador, item_presupuestario, pac, actividad,
                           fuente, producto, monto1, monto2, monto3, actividad_poa, beneficiario, producto_actividad,
                           aportaen, id_departamento, anio, idperiodo, idobjetivo, idobjetivoindicador, fecha_termino, inicio,
                           dias_trascurrido_inicio, anio_trascurrido_inicio, dias_trascurrido_fin,avance
               FROM planificacion.view_tarea_poa
              WHERE  idtarea =".$bd->sqlvalue_inyeccion($id, true);
        
        
        $stmt_nivel1 = $bd->ejecutar($sql);
        
    
        
        while ($x=$bd->obtener_fila($stmt_nivel1)){
            
            echo '<h4>Actividad:<br> <b>'.trim($x['actividad_poa']).'</b></h4><br>';
            
            if ($x['cumplimiento'] == 'N'){
                $texto = 'NO INICIADO';
                $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" align="absmiddle">';
            }elseif ($x['cumplimiento'] == 'A'){
                $texto = 'INICIADO';
                $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" align="absmiddle">';
            }elseif ($x['cumplimiento'] == 'B'){
                $texto = 'EN PROCESO';
                $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" align="absmiddle">';
            }elseif ($x['cumplimiento'] == 'C'){
                $texto = 'VERIFICADO';
                $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" align="absmiddle">';
            }elseif ($x['cumplimiento'] == 'S'){
                $texto = 'FINALIZADO';
                $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" align="absmiddle">';
            }
            
            $imagenc= ' <img src="../../kimages/if_8_avatar_2754583.png" align="absmiddle">';
            
            echo '<h5>Tarea: <br><b>'.$imagen.' '.trim($x['tarea']).'</b><br><br>';
            echo 'Responsable: <br>'.$imagenc.' '.trim($x['nombre_funcionario']).'<br><br>';
            echo 'Producto: <br>'.trim($x['producto_actividad']).'<br><br>';
            echo 'Inicio: <br>'.($x['fechainicial']).'<br><br>';
            echo 'Monto asignado: <br>'.($x['codificado']).'<br><br>';
            echo 'Monto Ejecutado: <br>'.($x['ejecutado']).'<br><br>';
            echo 'Monto Disponible: <br>'.($x['disponible']).'<br><br>';
            
           
            
             
            $avance = $x['avance'] ;
                
            echo '<div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$avance.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$avance.'%">
                      '.$avance.'% '.$texto.' 
                    </div>
                  </div>';
      
        }
            
        echo '</h5>';
        
	  }
 ?>