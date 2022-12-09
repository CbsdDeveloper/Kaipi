<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =	new Db ;
    $obj   = 	new objects;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    $anio = date('Y');

    $tipo = $bd->retorna_tipo();
 
    $sql = "SELECT id_accion,fecha,motivo, idprov, razon,p_cargo ,sueldo,p_sueldo 
    FROM public.view_nom_accion
    where estado = 'S' and 
          finalizado = 'N' and 
          motivo in ('ENCARGO','SUBROGACION') and 
          anio= ".$bd->sqlvalue_inyeccion($anio, true)."
    order by motivo,razon" ;
     

    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Accion,Fecha,Motivo,Identificacion,Funcionario,Cargo,Sueldo A, Sueldo B";
 
    $evento   = "veraccion-3";
    $obj->table->table_basic_seleccion($resultado,$tipo,'seleccion','',$evento ,$cabecera);

 ?>