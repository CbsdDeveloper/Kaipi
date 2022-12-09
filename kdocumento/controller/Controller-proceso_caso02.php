<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	   =	new Db;	
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
     

    $AUsuario = $bd->query_array('par_usuario',
                                       'login, email,    cedula,    tarea, completo,   id_departamento', 
                                       'idusuario='.$bd->sqlvalue_inyeccion($_SESSION['usuario'],true)
                );
    
 
    $id_departamento = $AUsuario['id_departamento'];
    $email           = trim($AUsuario['email']);
 
    
    //--------------------------------------------------------
 
        $sqlunidad = "SELECT  idproceso as codigo, proceso as nombre,ambito
                        FROM  flow.view_proceso_inicio
                       where   ambito_proceso = 'publico' and ambito = 'Interno' ";
 
        $sqlunidad = $sqlunidad." union SELECT  idproceso as codigo, proceso as nombre,ambito
                        FROM  flow.view_proceso_inicio
                       where   ambito_proceso = 'privado' and ambito = 'Interno' and idunidad =".$id_departamento.' order by 2';
 
 
    $resultado = $bd->ejecutar($sqlunidad);
    
    echo '<button type="button" onclick="closeNav_proceso()" class="btn btn-success btn-block">Cerrar</button>' ;
    
    echo '<hr> <div class="list-group" > <a href="#" class="list-group-item active">INTERNOS</a>';
    
    while ($x=$bd->obtener_fila($resultado)){
        
        $codigo  = $x['codigo'];
        
        $casos = $bd->query_array('flow.wk_proceso_caso',
            'count(*) as nn',
            'sesion='.$bd->sqlvalue_inyeccion($email,true).' and idproceso ='.$bd->sqlvalue_inyeccion($codigo,true)
            );
        
        $numero = $casos['nn'];
        
         
        $novedad = trim($x['nombre']);
        
        $cadena =  '';
        if ( $numero > 0){
            $cadena = ' <span class="badge">'.$numero.'</span>';
        }
            
         
        $evento  = ' onClick="goToURL('.$codigo.","."'".strtoupper($novedad)."'".')" ';
        
        echo  '<a href="#" '.$evento.' class="list-group-item">'.$novedad.$cadena.'</a>';
       
    }
    echo ' </div>';
    
    
    //--------------------------------------------------------
    
    $sqlunidad = "SELECT  idproceso as codigo, proceso as nombre,ambito
                        FROM  flow.view_proceso_inicio
                       where  ambito_proceso = 'publico' and ambito = 'Externo' ";
    
    $sqlunidad = $sqlunidad." union SELECT  idproceso as codigo, proceso as nombre,ambito
                        FROM  flow.view_proceso_inicio
                       where   ambito_proceso = 'privado' and ambito = 'Externo' and idunidad =".$id_departamento.' order by 2';
    
    
 
    
    $resultado = $bd->ejecutar($sqlunidad);
    
    echo ' <div class="list-group" > <a href="#" class="list-group-item active">EXTERNOS</a>';
    
    while ($x=$bd->obtener_fila($resultado)){
        
        $novedad = trim($x['nombre']);
        
        $codigo  = $x['codigo'];
        
        $casos = $bd->query_array('flow.wk_proceso_caso',
            'count(*) as nn',
            'sesion='.$bd->sqlvalue_inyeccion($email,true).' and idproceso ='.$bd->sqlvalue_inyeccion($codigo,true)
            );
        
        $numero = $casos['nn'];
        
        $cadena =  '';
        if ( $numero > 0){
            $cadena = ' <span class="badge">'.$numero.'</span>';
        }
        
        $evento  = ' onClick="goToURL('.$codigo.","."'".strtoupper($novedad)."'".')" ';
        
        echo  '<a href="#" '.$evento.' class="list-group-item">'.$novedad.$cadena.'</a>';
        
    }
    echo ' </div>';
 
?>