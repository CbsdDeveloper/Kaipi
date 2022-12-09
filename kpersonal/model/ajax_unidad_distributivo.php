<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   

 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =	    new Db ;

    $obj   = 	    new objects;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    $id        = trim($_GET['id']);
 
    $tipo      = $bd->retorna_tipo();

    $variables = '';

    $sql = "select  cargo as denominacion,
                    count(*) || ' ' as funcionarios,
                    sum(sueldo) as remuneracion
            from view_nomina_rol
            where id_departamento = ".$bd->sqlvalue_inyeccion( $id  ,true).' 
            group by cargo order by cargo';

     $resultado = $bd->ejecutar($sql);

     $obj->grid->KP_sumatoria(4,"remuneracion","", "","");

     $obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'N','','','' );

 




    $sql1 = 'SELECT  *
		   FROM view_nomina_rol
						where id_departamento = '.$bd->sqlvalue_inyeccion( $id  ,true).' order by responsable desc,razon asc' ;

    $stmt1 = $bd->ejecutar($sql1);

    echo '<ul class="list-group">';
 
 
    while ($fila=$bd->obtener_fila($stmt1)){
    
        $responsable = '';

        if ( trim($fila['responsable'] == 'S')){
                $responsable =  '<span class="badge">Responsable</span>';
        }

      
        $sueldo = ' <span class="label label-warning">'.$fila['sueldo'].'</span>';

        echo ' <li class="list-group-item">  <a href="#" data-toggle="modal" data-target="#myModal">'.trim($fila['razon']).'</a> <span class="label label-success">'.trim($fila['cargo']).'</span>  '. $sueldo.$responsable .'</li>';

        

    
}

echo '</ul>';
     
 ?>