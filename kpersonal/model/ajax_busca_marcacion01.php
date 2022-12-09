<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj     =  new objects;
$bd    =    new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$codigo_prov        = trim($_GET['idprov']);   // VARIABLE DE ENTRADA CODIGO DE BITACORA

$accion             = trim($_GET['accion']);   

$fecha              = $_GET['fecha'];

$id_temp_marcacion  = $_GET['id_temp_marcacion'];

$tipo               = $bd->retorna_tipo(); // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES


$valida = strlen($codigo_prov);

 if ( $valida == 9 ){
    $codigo_prov = '0'.$codigo_prov;
 }
 

if ( $accion  == 'visor_del'){

         $sql = 'delete from nom_marcacion_temp
                    where estado = '.$bd->sqlvalue_inyeccion('N' ,true).'   and 
                    id_temp_marcacion = '.$bd->sqlvalue_inyeccion($id_temp_marcacion ,true);

         $bd->ejecutar($sql);                    

         $sql = "select  id_temp_marcacion , nombre,tiempo, fecha, hora, tipo
            from nom_marcacion_temp
            where estado = 'N' and  identificacion= ".$bd->sqlvalue_inyeccion($codigo_prov,true)." 
            order by fecha,hora";
  
            $resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
            $evento   = "goToURL_marca2-0";  // nombre funcion javascript-columna de codigo primario
            $edita    = '';
            $del      = 'del';

 

          

            $cabecera =  "Codigo, Funcionario, Tiempo,Fecha,Hora,Tipo"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
             
 
            $obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);

            $DetalleRequisitos= 'ok';

            echo $DetalleRequisitos;
    
 }    

 



if ( $accion  == 'visor'){

            $sql = "select  identificacion, nombre,   dispositivo,    fecha,   registro_marcacion
            from view_nom_marcacion_fecha
            where identificacion= ".$bd->sqlvalue_inyeccion($codigo_prov,true)." 
            order by fecha";
  
            $resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
            $evento   = "goToURL_marca1-3";  // nombre funcion javascript-columna de codigo primario
            $edita    = 'editar';
            $del      = '';

             

            $cabecera =  "Identificacion, Funcionario,Dispositivo,Fecha, Nro.Marcaciones"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
             
 

            $obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);

            $DetalleRequisitos= 'ok';

            echo $DetalleRequisitos;

 }

if ( $accion  == 'visor_hora'){  
    
            $sql = "select  id_temp_marcacion , nombre,tiempo, fecha, hora, tipo
            from nom_marcacion_temp
            where estado = 'N' and
                  fecha = ".$bd->sqlvalue_inyeccion($fecha,true)." and 
                  identificacion= ".$bd->sqlvalue_inyeccion($codigo_prov,true)." 
            order by fecha,hora";
  
            $resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
            $evento   = "goToURL_marca2-0";  // nombre funcion javascript-columna de codigo primario
            $edita    = '';
            $del      = 'del';

          

            $cabecera =  "Codigo, Funcionario, Tiempo,Fecha,Hora,Tipo"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
             
 
            $obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera);

            $DetalleRequisitos= 'ok';

            echo $DetalleRequisitos;

 }
?>