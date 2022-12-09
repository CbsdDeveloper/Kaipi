<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	
    $obj   = 	new objects;
 
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $accion = $_POST['accion'];
    $fecha2 = $_POST['brfecha2'];
    
    if (empty($fecha2)){
        $fecha2 = date('Y-m-d');
    }
    
    
    $fecha = explode('-',$fecha2);
    
    
    $sql  = "SELECT idnota || ' ' as ref_nota, tipo_nota, asunto_nota, notas, sesion_creacion 
            FROM presupuesto.matriz_nota
            where anio =". $bd->sqlvalue_inyeccion($fecha[0],true).' and
                  mes =  '. $bd->sqlvalue_inyeccion($fecha[1],true).'
            order by anio, mes';
             
    $tipo      = $bd->retorna_tipo();
    
    $resultado = $bd->ejecutar($sql);
     
 
    if ( $accion == 'add')	{
        
        $accion = 'hola' ;
        
    }
    
    
    $obj->table->table_basic_js($resultado, // resultado de la consulta
        $tipo,      // tipo de conexoin
        '',         // icono de edicion = 'editar'
        '',			// icono de eliminar = 'del'
        '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
        "Referencia, Tipo, Asunto, Nota, creado" , // nombre de cabecera de grill basica,
        '11px',      // tamaño de letra
        'idArchivo'         // id
        );
     
        
 	 
?>