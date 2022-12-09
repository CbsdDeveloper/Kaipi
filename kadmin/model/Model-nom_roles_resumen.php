<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;
 
/*
'id_rol' 		  : id_rol1,
'id_departamento': id_departamento1,
'regimen' 		  : regimen,
'accion'		  : 'visor'
    */

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

        $tipo = $bd->retorna_tipo();

        $id_rol = $_GET['id_rol'] ;
        
        $regimen = $_GET['regimen'] ;
        
       echo'<div class="col-md-12">
        <div class="col-md-6">
        <div class="panel panel-default">
        <div class="panel-heading">UNIDADES ADMINISTRATIVAS</div>
          <div class="panel-body"><div style="width:100%; height:280px;">';
       _unidad($bd,$obj,$tipo,$id_rol,$regimen);
       echo '</div></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="panel panel-default">
        <div class="panel-heading">RESUMEN ROL DE PAGO POR REGIMEN</div>
        <div class="panel-body"><div style="width:100%; height:280px;">';
        _presupuesto($bd,$obj,$tipo,$id_rol,$regimen);
        echo '</div></div>
        </div>
        </div>
        </div>';
      
        
        echo'<div class="col-md-12">
        <div class="col-md-6">
        <div class="panel panel-default">
        <div class="panel-heading">INGRESOS</div>
        <div class="panel-body">';
        _ingresos($bd,$obj,$tipo,$id_rol,$regimen);
        echo '</div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="panel panel-default">
        <div class="panel-heading">DESCUENTOS</div>
        <div class="panel-body">';
        _descuentos($bd,$obj,$tipo,$id_rol,$regimen);
        echo '</div>
        </div>
        </div>
        </div>';

        //    
        $sesion = trim($_SESSION['email']);
        
        $array  = $bd->__user($sesion);
         
        $certificacion = valida_tramite(  $bd, $id_rol ,$regimen);
        
        
        $evento  = ' ';
      //  $eventoc = ' ';
        
        if ( trim($array['tipo']) == 'financiero') {
            $evento  = ' onClick="EmiteCertificacion()" ' ;
       //     $eventoc = ' onClick="irCompromiso('.$certificacion.')" ';
        }
            
        if ( trim($array['tipo']) == 'admin') {
            $evento  = ' onClick="EmiteCertificacion()" ' ;
        //    $eventoc = ' onClick="irCompromiso('.$certificacion.')" ';
        }
        
 
      
      
        echo'<div class="col-md-12">
        <div class="col-md-6">
        <div class="panel panel-default">
        <div class="panel-heading">RESUMEN APORTE PATRONAL</div>
        <div class="panel-body">';
        _patronal( $bd,$obj,$tipo,$id_rol ,$regimen);
        echo '</div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="panel panel-default">
        <div class="panel-heading">GENERAR PROCESO :: ENLACE PRESUPUESTARIO CONTABLE</div>
        <div class="panel-body">';
        
        $datos = array();
        
        $resultado = $bd->ejecutar("select '-' as codigo , '  [  Asignar Responsable ]' as nombre union
                                                   SELECT email AS codigo, completo  as nombre
													FROM par_usuario
                                                    where estado = ".$bd->sqlvalue_inyeccion('S',true)." AND
                                                          tarea = ".$bd->sqlvalue_inyeccion('S',true)." AND
                                                          tipo in ('financiero','admin')
                                                           ORDER BY 2 ");
        
        $obj->list->listadb($resultado,$tipo,'Asignar a','sesion_asigna',$datos,'required','','div-2-10');
        
        echo '<div class="col-md-12"  style="padding: 10px;">
                <button type="button"  '.$evento.' class="btn btn-primary">Solicitud de Certificacion</button>
                <button type="button"  onClick="ImprimirActa('.$certificacion.')" class="btn btn-success">Imprimir Solicitud Certificacion</button>
              </div>';
        
        echo '<div class="col-md-12"  style="padding: 10px;">
        <div id="VisorEnlacePresupuesto"> </div>
        </div>';
        
        echo '</div>
        </div>
        </div>
        </div>';
        
        
      
       
        $ViewResumen='ok';
        
        echo $ViewResumen;
        
        

//------------------------------------------------------------------------------------
        function _ingresos( $bd,$obj,$tipo,$id_rol,$regimen ){
 
    $cadena = " || ' '" ;
 
    $sql = 'SELECT nombre as "Ingreso",
                   programa '.$cadena.' as programa,
                  clasificador '.$cadena.' as "Clasificador",sum(ingreso) as "Total"
                  FROM view_rol
                  where id_rol='.$bd->sqlvalue_inyeccion($id_rol, true)." and 
                        tipo = 'Ingresos' and regimen =".$bd->sqlvalue_inyeccion($regimen, true)."
                group by programa,clasificador,nombre order by nombre desc,programa,clasificador";
    
 
    $resultado = $bd->ejecutar($sql);
 
  
    $obj->grid->KP_sumatoria(4,"Total","", "","");
    
    $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');  
 
 
}
//------------------------------------------------------------------------------------
function _presupuesto( $bd,$obj,$tipo,$id_rol,$regimen ){
    
         
        $sql = 'SELECT nombre as "INGRESOS",sum(ingreso)    as "MONTO"
                FROM view_rol_impresion
                where regimen='.$bd->sqlvalue_inyeccion($regimen, true)." and 
                       id_rol =".$bd->sqlvalue_inyeccion($id_rol, true)."  and tipo = 'Ingresos'
                    group by nombre
                    order by 2 desc";


          
        $resultado = $bd->ejecutar($sql);
        
        
        $obj->grid->KP_sumatoria(2,"Monto","", "","");
        
        $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');
        
    
        $sqlD = 'SELECT nombre as "DESCUENTOS",sum(descuento) as "MONTO"
                FROM view_rol_impresion
                where regimen='.$bd->sqlvalue_inyeccion($regimen, true)." and
                       id_rol =".$bd->sqlvalue_inyeccion($id_rol, true)."  and tipo = 'Descuentos'
                    group by nombre
                    order by 2 desc";
        
        
        
        $resultado = $bd->ejecutar($sqlD);
        
        
        $obj->grid->KP_sumatoria(2,"Monto","", "","");
        
        $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');
        
 
            
            
    /*
         
         $anio = $_SESSION['anio'];
    
    
    $cadena = " || ' '" ;
    
    $sql = 'SELECT funcion '.$cadena.' as programa,clasificador '.$cadena.' as clasificador,detalle as "Detalle", disponible as "Disponible"
                  FROM presupuesto.pre_gestion '." 
                  where grupo in ('51','71') and tipo = 'G' AND 
                        anio =".$bd->sqlvalue_inyeccion($anio, true)."
                order by funcion,clasificador";
    
 
        
    $resultado = $bd->ejecutar($sql);
    
    
    $obj->grid->KP_sumatoria(4,"Disponible","", "","");
    
    $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');
    
    */
    
    
}
//------------------------------------------------------------------------------------
function _descuentos( $bd,$obj,$tipo,$id_rol,$regimen ){
    
    
    $cadena = " || ' '" ;
    
    $sql = 'SELECT nombre as "Descuento",programa '.$cadena.' as programa,clasificador '.$cadena.' as "Clasificador",sum(descuento) as "Total"
                  FROM view_rol
                  where id_rol='.$bd->sqlvalue_inyeccion($id_rol, true)." and
                        tipo = 'Descuentos' and regimen =".$bd->sqlvalue_inyeccion($regimen, true)."
                group by programa,clasificador,nombre order by nombre desc,programa,clasificador";
    
    $resultado = $bd->ejecutar($sql);
    
    
 
    
    $obj->grid->KP_sumatoria(4,"Total","", "","");
    
    $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');  
    
    
}
//------------------------------------------------------------------------------------
function _unidad( $bd,$obj,$tipo,$id_rol,$regimen ){
    
    $sql = 'SELECT unidad as "Unidades Administrativas", sum(ingreso) as "Ingreso",
                      sum(descuento) as "Descuento",
                      sum(ingreso) - sum(descuento) as "Pagar"
              FROM view_rol_impresion
              where  id_rol= '.$bd->sqlvalue_inyeccion($id_rol, true)." and
                      regimen =".$bd->sqlvalue_inyeccion($regimen, true)."
              group by unidad order by 1";
 
    
    $resultado = $bd->ejecutar($sql);
    
    
    $obj->grid->KP_sumatoria(2,"Ingreso","Descuento", "Pagar","");
    
    $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');
    
    
}
//---------------------------------
function _patronal( $bd,$obj,$tipo,$id_rol ,$regimen){
    
 
    
    $ab = $bd->query_array('nom_config',
        'monto',
        'id_config='.$bd->sqlvalue_inyeccion(99,true).' and
                                tipo ='.$bd->sqlvalue_inyeccion('X',true).' and
                                tipoformula ='.$bd->sqlvalue_inyeccion('PP',true)
        );
    
    
    
    
    $sql = 'SELECT ingreso, sueldo, id_config,   tipo, idprov, id_rol,     aplica_formula
                FROM public.view_rol_impresion
                where  id_rol='.$bd->sqlvalue_inyeccion($id_rol, true).' and
                       regimen = '.$bd->sqlvalue_inyeccion($regimen, true).' and
                       tipoformula='.$bd->sqlvalue_inyeccion('RS', true) ;
    
    
    
    
    
    $stmt = $bd->ejecutar($sql);
    
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $idprov = trim($x['idprov']);
        
        $aporte = $x['ingreso'] * $ab['monto']/100;
        
        $sql = 'UPDATE nom_rol_pagod
                SET  patronal='.$bd->sqlvalue_inyeccion($aporte, true). '
                WHERE idprov='.$bd->sqlvalue_inyeccion($idprov, true). ' and
                      id_rol = '.$bd->sqlvalue_inyeccion($id_rol, true);
        
        $bd->ejecutar($sql);
        
    }
    
 
    
    $cadena    = " || ' '" ;
    
    //-----------------------------------------------------------
    $sql = "SELECT programa ".$cadena." as programa, 'Aporte Patronal' as ". '"Concepto"'." , sum(patronal) as ".'"Monto"'."
                FROM  view_rol_impresion
                where id_rol= ".$bd->sqlvalue_inyeccion($id_rol, true)." and tipoformula = 'RS' and 
                      regimen =".$bd->sqlvalue_inyeccion($regimen, true)." 
                group by programa";
    
    $resultado1 = $bd->ejecutar($sql);
    
    $obj->grid->KP_sumatoria(0,"","", "","");
    $obj->grid->KP_GRID_visor($resultado1,$tipo,'50%');
    
    
    
}
//-----------------------------------------------------------------------------------
function valida_tramite(  $bd, $id_rol1 ,$regimen){
    
    
    
    $AResultado = $bd->query_array('nom_rol_pagod',
        ' max(id_tramite) as idtramite',
        'id_rol='.$bd->sqlvalue_inyeccion($id_rol1, true). ' and
                      regimen = '.$bd->sqlvalue_inyeccion($regimen, true)
        );
    
    $id_tramite = 0;
    
    if ( $AResultado['idtramite'] > 1 ) {
        
        $id_tramite = $AResultado['idtramite'];
        
    }
    
    return $id_tramite;
    
}
//-----------------------------------------------------------------------------------
?>