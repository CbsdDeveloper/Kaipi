<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   

 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =	    new Db ;

    $obj   = 	    new objects;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 

    $id        = trim($_GET['id_rol']);
 
    $tipo      = $bd->retorna_tipo();
  
    $sql = "select idprov,empleado,regimen,programa || ' ' as programa,
                   unidad,sum(ingreso) as ingreso,sum(descuento) as descuento,sum(ingreso)-sum(descuento) as saldo
    from  view_rol_impresion
    where id_rol = ".$bd->sqlvalue_inyeccion( $id  ,true)."
    group by idprov,regimen,empleado,programa,unidad
    having sum(ingreso)-sum(descuento) < 0
    order by empleado";
 
     $resultado = $bd->ejecutar($sql);

     $obj->table->table_basic_js($resultado, // resultado de la consulta
     $tipo,      // tipo de conexoin
     '',         // icono de edicion = 'editar' - seleccion
     '',			// icono de eliminar = 'del'
     '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
     "Identificacion,Empleado,Regimen,Programa,Unidad, Ingreso,Descuento, saldo",  // nombre de cabecera de grill basica,
     '12px',      // tamaño de letra
     'id'         // id
    );
 
 
     
 ?>