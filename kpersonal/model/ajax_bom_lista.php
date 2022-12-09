<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   

 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =   new Db ;
    $obj   =   new objects;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

    $id_asigna_dis    = $_GET['id_asigna_dis'];
    $accion           = $_GET['accion'];
    $unidad           = $_GET['unidad'];
    
    
     

    if ( trim($accion) == 'unidades') {

           agregar(  $bd,  $id_asigna_dis );

           unidades_visor(  $bd,  $obj, $id_asigna_dis );

    }


    if ( trim($accion) == 'actualiza') {

            $id_asigna_bom    = $_GET['id_asigna_bom'];
      
            visor_asignacion(  $bd,    $id_asigna_bom );

    }



    if ( trim($accion) == 'lista') {

 
        unidades_visor(  $bd,  $obj, $id_asigna_dis );

 }

    if ( trim($accion) == 'visor') {
  
        unidades_visor(  $bd,  $obj, $id_asigna_dis );

   }

   if ( trim($accion) == 'seleccion') {
  
         unidades_fun(  $bd,  $obj, $id_asigna_dis, $unidad  );

  }

  if ( trim($accion) == 'del') {
  
    $id_asigna_bom    = $_GET['id_asigna_bom'];
    eliminar_dato(  $bd,  $id_asigna_bom );

  }


  if ( trim($accion) == 'cambio') {

    $id_asigna_dis    = $_GET['id_asigna_dis'];
    $id_asigna_bom    = $_GET['id_asigna_bom'];
    $cambiar_a        = $_GET['cambiar_a'];
    $responsable_a    = $_GET['responsable_a'];

    $grupo_a       = $_GET['grupo_a'];
    $funcion_a     = $_GET['funcion_a'];
    $unidad_apoyo  = $_GET['unidad_apoyo'];
			 
     
    editar_cambio(  $bd,  $id_asigna_bom, $id_asigna_dis, $cambiar_a,  $responsable_a ,$grupo_a , $funcion_a , $unidad_apoyo   );

}

/*
visor de unidades
*/
    function unidades_visor(  $bd, $obj, $id_asigna_dis ){

        $tipo 		= $bd->retorna_tipo();

        $sql = "SELECT id_departamento || ' ' as id , unidad, count(*) || ' ' as funcionario 
                FROM bomberos.view_dis_bom_lista
                where id_asigna_dis= ".$bd->sqlvalue_inyeccion(   $id_asigna_dis , true)."
                group by id_departamento, unidad";
         
    
        $stmt1  = $bd->ejecutar($sql);
    
            
            while ($fila=$bd->obtener_fila($stmt1)){
                
                
                echo '<div class="div_s"><a href="#" onClick="asigna('."'".'seleccion'."',".trim($fila['id']).')">';
                echo '<h5><b>'.$fila['unidad'].'</b></h5>';
                echo 'Nro.Personal '.$fila['funcionario'].'<br><br></a>';
                  echo '</div>';
                
 
            }
            
           
               

    }

 /*
 grupo
 */   

function unidades_fun_detalle(  $bd, $obj, $id_asigna_dis, $unidad ,$grupo){

    $tipo 		= $bd->retorna_tipo();


 

    $sql = "SELECT id_asigna_bom || ' ' as id,
                   funcion,
                   funcionario || '( ' || responsable || ' )' as funcionario
            FROM bomberos.view_dis_bom_lista
            where id_asigna_dis= ".$bd->sqlvalue_inyeccion(   $id_asigna_dis , true)." and 
                  id_departamento = ".$bd->sqlvalue_inyeccion(   $unidad , true)." and 
                  grupo = ".$bd->sqlvalue_inyeccion(   $grupo , true)."
                  order by responsable desc, funcionario";
    
    
     

            $resultado  = $bd->ejecutar($sql);

            $cabecera =  "Código, Funcion,Personal";

            $obj->table->table_basic_js($resultado, // resultado de la consulta
            $tipo,      // tipo de conexoin
            'editar',         // icono de edicion = 'editar' - seleccion
            'del',			// icono de eliminar = 'del'
            'verifica-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
            $cabecera , // nombre de cabecera de grill basica,
            '11px',      // tamaño de letra
            'idfuncion',        
            'S'       // pone fila
            );

           

}


 /*
visor de unidades
*/
function unidades_fun(  $bd, $obj, $id_asigna_dis, $unidad ){

   


    $Array = $bd->query_array('nom_departamento',
    'nombre', 
    'id_departamento='.$bd->sqlvalue_inyeccion ( $unidad ,true) 
);


 echo '<h5><b> '.  $Array['nombre'] .'</b> </h5>  ';

    $sql = "SELECT grupo
            FROM bomberos.view_dis_bom_lista
            where id_asigna_dis= ".$bd->sqlvalue_inyeccion(   $id_asigna_dis , true)." and 
                  id_departamento = ".$bd->sqlvalue_inyeccion(   $unidad , true)."
                  group by grupo
                  order by grupo";
    

                  $stmt1 = $bd->ejecutar($sql);

 
                  while ($fila=$bd->obtener_fila($stmt1)){
                      
                      echo ' <div class="col-md-6"> ';
    
                        echo '<h6><b>'.trim($fila['grupo']).'</b></h6>';
             
                              unidades_fun_detalle(  $bd, $obj, $id_asigna_dis, $unidad ,trim($fila['grupo']));
                              
                              echo ' </div> ';
                    }

            

}
//--------------------------------------
function agregar(  $bd,  $id_asigna_dis ){
     	

    $sql = "select idprov ,completo ,cargo, responsable ,id_departamento
            from view_nomina_user
            where orden like 'GGG%' AND estado = 'S'
            order by id_departamento,completo";


            $sesion 	 =  trim($_SESSION['email']);
            $hoy 	     =  date("Y-m-d");    


    $stmt1 = $bd->ejecutar($sql);

    $tabla 	  	     = 'bomberos.asignacion_bom';
    $secuencia 	     = 'bomberos.asignacion_bom_id_asigna_bom_seq';

  
    while ($fila=$bd->obtener_fila($stmt1)){


        $Array = $bd->query_array('bomberos.asignacion_bom',
                                        'count(*) as nn', 
                                        'idprov='.$bd->sqlvalue_inyeccion(trim($fila['idprov']),true).' and 
                                         id_asigna_dis=' .$bd->sqlvalue_inyeccion($id_asigna_dis,true)
                                    );
     
        $ATabla = array(
            array( campo => 'id_asigna_bom',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_asigna_dis',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor =>$id_asigna_dis, key => 'N'),
            array( campo => 'id_departamento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => $fila['id_departamento'], key => 'N'),
            array( campo => 'responsable',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => trim($fila['responsable']), key => 'N'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => trim($fila['idprov']), key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>  $sesion , key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => $hoy , key => 'N'),
            );


            if (  $Array['nn']  > 0 ){
            }else {
                  $bd->_InsertSQL($tabla,$ATabla, $secuencia);
            }      
        
    }
}

/*
*/

function editar_cambio(  $bd,  $id_asigna_bom, $id_asigna_dis, $cambiar_a,  $responsable_a ,$grupo, $funcion_a ,  $unidad_apoyo  ){

  

    $sql = "UPDATE bomberos.asignacion_bom 
               SET 	id_departamento=".$bd->sqlvalue_inyeccion($cambiar_a, true).",
                    responsable=".$bd->sqlvalue_inyeccion(trim($responsable_a), true).",
                    unidad_apoyo=".$bd->sqlvalue_inyeccion(trim($unidad_apoyo), true).",
                    funcion=".$bd->sqlvalue_inyeccion(trim($funcion_a), true).",
                    grupo = ".$bd->sqlvalue_inyeccion(trim($grupo), true)."
            WHERE id_asigna_bom=".$bd->sqlvalue_inyeccion($id_asigna_bom, true);

  $bd->ejecutar($sql);
 


  echo 'Datos Actualizados...';
}   

/*
Eliminar bombero seleccionado
*/
function eliminar_dato(  $bd,  $id_asigna_bom  ){



    $sql = "DELETE FROM bomberos.asignacion_bom 
            WHERE id_asigna_bom=".$bd->sqlvalue_inyeccion($id_asigna_bom, true);

  $bd->ejecutar($sql);
 


  echo      ' Datos Actualizados...';
}   


/*
Eliminar bombero seleccionado
*/
function visor_asignacion(  $bd,  $id_asigna_bom  ){

    $Abombe_firma = $bd->query_array('bomberos.asignacion_bom',
    ' id_asigna_dis, id_departamento, responsable, idprov, sesion, fecha, grupo, funcion, unidad_apoyo',
    'id_asigna_bom='.$bd->sqlvalue_inyeccion($id_asigna_bom ,true)
     
    );
 
  echo ' <script>';

  echo "$('#cambiar_a').val('".$Abombe_firma['id_departamento']."');" ;

  echo "$('#responsable_a').val('".trim($Abombe_firma['responsable'])."');" ;

  echo "$('#unidad_apoyo').val('".trim($Abombe_firma['unidad_apoyo'])."');" ;

  echo "$('#grupo_a').val('".trim($Abombe_firma['grupo'])."');" ;
  
  echo "$('#funcion_a').val('".trim($Abombe_firma['funcion'])."');" ;

 
  echo ' </script>';

     

  echo      ' Datos Actualizados...';


}   




 ?>