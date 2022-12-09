<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 $obj   = 	new objects;

 $bd	   =	new Db;

     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
     $Q_IDUNIDAD  = $_GET['Q_IDUNIDAD'];  
     
     $Q_IDPERIODO = $_GET['Q_IDPERIODO'];  
 
   
     
     $sql_nivel1 = ' select 1 as seq,  idestrategia_matriz as idp,idestrategia_padre as id
                        FROM planificacion.view_oe_oo
                        where id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and anio='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                        group by idestrategia_matriz  ,idestrategia_padre 
                        union 
                         SELECT 2 as seq, idestrategia_padre as idp, idestrategia as id
                        FROM planificacion.view_oe_oo
                        where id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and anio='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                        group by idestrategia_padre,idestrategia
                        union 
                         SELECT 3 as seq, idestrategia as idp, idobjetivo as id
                        FROM planificacion.view_oe_oo
                        where id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and anio='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                        group by  idestrategia, idobjetivo 
                        order by 1';
 
     $stmt_nivel1 = $bd->ejecutar($sql_nivel1);
     
     
     $sql1 = ' select 1 as seq,  a.idestrategia_matriz as idp, b.objetivoe as nombre
            FROM planificacion.view_oe_oo a, planificacion.pyestrategia b
            where a.id_departamento ='.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and a.anio='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' and a.idestrategia_matriz = b.idestrategia 
            group by a.idestrategia_matriz,b.objetivoe
            union 
            select 2 as seq,  a.idestrategia_padre as idp, b.objetivoe as nombre
            FROM planificacion.view_oe_oo a, planificacion.pyestrategia b
            where a.id_departamento ='.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and a.anio= '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' and   a.idestrategia_padre = b.idestrategia 
            group by a.idestrategia_padre,b.objetivoe
            union 
             select 3 as seq,  a.idestrategia as idp, b.objetivoe as nombre
            FROM planificacion.view_oe_oo a, planificacion.pyestrategia b
            where a.id_departamento ='.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and a.anio= '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' and   a.idestrategia = b.idestrategia 
            group by a.idestrategia,b.objetivoe
            union
             select 4 as seq,  idobjetivo as idp, objetivo as nombre
            FROM planificacion.view_oe_oo
            where id_departamento ='.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and anio='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
            group by idobjetivo,objetivo';
 
     $stmt_nivel2 = $bd->ejecutar($sql1);
     
     echo "<script>
                var chart = Highcharts.chart('container', {
               chart: {
                height: 500,
                inverted: false
              },
               title: {
                text: 'Articulación de Objetivos Estrategicos'
              },
               plotOptions: {
                series: {
                  nodeWidth: '20%'
                }
              },
               series: [{
                type: 'organization',
                name: 'Highsoft',
                keys: ['from', 'to'],
                data: [";
     
     while ($x=$bd->obtener_fila($stmt_nivel1)){
          $idp  			= 'P_'.$x['idp'];
         $seq  			=  $x['seq'];
         $codigo  		= 'P_'.$x['id'];
         if ( $seq == 3 ){
             $codigo  		= 'O_'.$x['id'];
         }
           echo "["."'". $idp."'" .","."'".$codigo."'"."],";
     }
     echo  " ],levels: [{
      level: 0,
      color: '#fcc657',
      borderLine: 10,
      dataLabels: {
        color: 'black'  
      }
    }, {
      level: 1,
      color: '#46b8da',
      dataLabels: {
        color: 'black'
      },
      height: 20
    }, {
      level: 2,
      color: '#DEDDCF',
      dataLabels: {
        color: 'black'
      },
    }, {
      level: 3,
      dataLabels: {
        color: 'black'
      },
    }],

    nodes: [";
     while ($xx=$bd->obtener_fila($stmt_nivel2)){
         
         $idp  			= 'P_'.$xx['idp'];
         $seq  			=  $xx['seq'];
         $nombre  		= trim($xx['nombre']);
         
         if ( $seq == 4 ){
             $idp  		= 'O_'.$xx['idp'];
         }
         
         echo "{
              id: '". $idp  ."',
              title: null,
              name:  '". $nombre  ."',
              info:  '". $nombre  ."'
             }, "; 
      }
  echo " ],
    colorByPoint: false,
    borderColor: 'white'
  }],
   tooltip: {
    outside: true,
    formatter: function() {
      return this.point.info;
    }
  },

  exporting: {
    allowHTML: true,
    sourceWidth: 800,
    sourceHeight: 600
  }
}); </script>";


echo ' <div id="container"></div>';

     /*
     $sql_nivel1 = 'SELECT  idestrategia_matriz
					FROM planificacion.view_oe_oo
					WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' AND 
                          anio ='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).
                    ' group by idestrategia_matriz';
     
     $stmt_nivel1 = $bd->ejecutar($sql_nivel1);
     
    
     echo ' <div class="col-md-12">
                <div class="panel panel-default">
                 <div class="panel-heading"> <h5><b>Articulacion objetivos institucionales</b></h5>  </div>
                    <div class="panel-body">      
         			    <div class="tree_a"> 
                			<ul> 
                			 <li>
                			  <a href="#">ESTRATEGIA INSTITUCIONAL</a>
                			  <ul><li>';
     

     echo '</li></ul>
		</li>
	</ul>
</div></div> </div> </div> 

     
     */

echo '<div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading"> <h5><b>Indicadores por Objetivo</b></h5>  </div>
        <div class="panel-body">';
    
          Indicadores($Q_IDUNIDAD,$Q_IDPERIODO,$bd,$obj,$sesion);
    
     $UnidadArticula = ' </div></div></div>';
         
     echo $UnidadArticula;

//-----------------------------------------------------------
//--------------------------------------------------------
     function Subnivel($bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo){
     	
         $sql1 = 'SELECT  idestrategia_padre
					FROM planificacion.view_oe_oo
					WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
                          idestrategia_matriz ='.$bd->sqlvalue_inyeccion($codigo,true).' and 
                          anio ='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).
                          ' group by idestrategia_padre';
       
        
     	$stmt_nivel2 = $bd->ejecutar($sql1);
     	
        echo '<ul>';
 				       
		while ($y=$bd->obtener_fila($stmt_nivel2)){
				     		
		           $codigo  		= trim($y['idestrategia_padre']);
				   $nombre 		    = Estrategia($bd,$codigo);
				       	
				   echo  '<li> <a href="#"><b>'.$nombre.'</b></a>';
				         Subnivel2($bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo);
 				   echo '</li>';
				     		
		 }
		echo '</ul>';
     
     	
     }
   //-------------------------------------
  function Subnivel2( $bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo ){
         
      
      $sql1 = 'SELECT  idestrategia 
					FROM planificacion.view_oe_oo
					WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
                          idestrategia_padre ='.$bd->sqlvalue_inyeccion($codigo,true).' and
                          anio ='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).
                          ' group by idestrategia';
      
      
      $stmt_nivel2 = $bd->ejecutar($sql1);
      
      echo '<ul>';
      
      while ($y=$bd->obtener_fila($stmt_nivel2)){
          
          $codigo  		= trim($y['idestrategia']);
          $nombre 		    = Estrategia($bd,$codigo);
          
          echo  '<li> <a href="#"><b>'.$nombre.'</b></a>';
             Subnivel3($bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo);
          echo '</li>';
          
      }
      echo '</ul>';
      
         
     }
     //-------------------------------------
     function Subnivel3( $bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo ){
         
         
         $sql1 = 'SELECT  idobjetivo,objetivo
					FROM planificacion.view_oe_oo
					WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
                          idestrategia ='.$bd->sqlvalue_inyeccion($codigo,true).' and
                          anio ='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true) ;
         
 
         
         $stmt_nivel2 = $bd->ejecutar($sql1);
         
         echo '<ul>';
         
         $imageno = '<img  align="absmiddle" src="../../kimages/oo.png"/> ';
         
         while ($y=$bd->obtener_fila($stmt_nivel2)){
             
             $codigo  		    = trim($y['idobjetivo']);
             $nombre 		    =  $imageno .trim($y['objetivo']);
              echo  '<li> <a href="#"><b>'.$nombre.'</b></a></li>';
              
         }
         echo '</ul>';
         
         
     }
     //-----------------------------------------------------------
     //--------------------------------------------------------
     function Estrategia($bd,$id_estrategia){
     	
         $Array = $bd->query_array('planificacion.pyestrategia',
                                   'objetivoe', 
                                   'idestrategia='.$bd->sqlvalue_inyeccion($id_estrategia,true)
             );
         
         
         return $Array['objetivoe'];
 
     }
    
     //-----------------------------------------------------------
     //--------------------------------------------------------
     function Indicadores($id_unidad,$Q_IDPERIODO,$bd,$obj,$sesion){
   
 
         
     	$sqlOO= 'SELECT   objetivo,   numero,idobjetivo
				FROM planificacion.view_indicadores_oo_res
				WHERE anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND 
					  id_departamento = '.$bd->sqlvalue_inyeccion($id_unidad,true);

      	
     	$stmt_oo = $bd->ejecutar($sqlOO);
     	
     	echo ' <table class="table table-bordered table-hover">
       		 <thead>
              <tr>
                <th width="25%" >Objetivo</th>
                <th width="20%">Indicador</th>
                <th width="10%">Meta</th>
				<th width="10%">Periodo</th>
                <th width="10%">Formula</th>
                <th width="20%">Medio Verificacion</th>
				<th width="5%"> </th>
            </tr><tbody>';
      
     	while ($y=$bd->obtener_fila($stmt_oo)){
     		Indicadores_detalle($id_unidad,$Q_IDPERIODO,$bd,$obj,$sesion,$y['numero'],$y['idobjetivo']);
     	}
     	echo  ' </tbody></table>';
     	
    
     
     }
     //--------------------------------------------------
     function Indicadores_detalle($id_unidad,$Q_IDPERIODO,$bd,$obj,$sesion,$nro,$IDOBJETIVO){
     	
     	$sqlOODetalle= 'SELECT    objetivo, indicador,  meta, formula,medio,   periodo,idobjetivoindicador
				FROM planificacion.view_indicadores_oo
				WHERE anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND
					  estado = '.$bd->sqlvalue_inyeccion('S',true).' AND
					  idobjetivo = '.$bd->sqlvalue_inyeccion($IDOBJETIVO,true);
     	
     	
     	
     	
     	$stmtDetalle = $bd->ejecutar($sqlOODetalle);
     	
        $i = 0;
        
     	while ($x=$bd->obtener_fila($stmtDetalle)){
     		
     		$boton ='<button class="btn btn-xs" 
						onClick="javascript:goToIndicador('.$x['idobjetivoindicador'].')" data-toggle="modal" data-target="#myModalIndicador" >
					<i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
     				
     		
     		$imagen = '<img  align="absmiddle" src="../../kimages/indicadores.png"/> ';
     		
     		$imageno = '<img  align="absmiddle" src="../../kimages/oo.png"/> ';
     		
     		if ($nro == 1){ 
     			 echo '<tr>
		                <td>'.$imageno.$x['objetivo'].'</td>
		                <td>'.$imagen.$x['indicador'].'</td>
		                <td>'.$x['meta'].'</td>
		                <td>'.$x['periodo'].'</td>
                         <td>'.$x['formula'].'</td>
                         <td>'.$x['medio'].'</td>
						<td>'.$boton.'</td>
          		      </tr>';
     		}else {
     			if ($i == 0){
     				echo '<tr>
		     				<td rowspan="'.$nro.'">'.$imageno.$x['objetivo'].'</td>
		     				<td>'.$imagen.$x['indicador'].'</td>
		     				<td>'.$x['meta'].'</td>
		     				<td>'.$x['periodo'].'</td>
                            <td>'.$x['formula'].'</td>
                            <td>'.$x['medio'].'</td>
							<td>'.$boton.'</td>
	     				</tr>';
     			}else{
     				echo '<tr>
				                  <td>'.$imagen.$x['indicador'].'</td>
				                  <td>'.$x['meta'].'</td>
				                  <td>'.$x['periodo'].'</td>
                                  <td>'.$x['formula'].'</td>
                                  <td>'.$x['medio'].'</td>
								  <td>'.$boton.'</td>
				            </tr>';
     			}
     		}
     		$i++; 
     	}
      
 
     	
     }
 ?>					 
 
 
 