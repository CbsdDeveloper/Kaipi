<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;
 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

        $tipo = $bd->retorna_tipo();

        $where = K_where($bd,$_GET["id_rol"],$_GET["id_config"],$_GET["id_departamento"]);
 
    

        if (!empty($where)){
        
                $sql = 'SELECT a.id_rold as "Id",b.fecha as "Fecha Ingreso", a.idprov as "Identificacion",
            			 		 		b.razon as "Nombre",b.unidad as "Departamento", b.cargo as "Cargo",  
                                        a.descuento as "Monto"
            			   		FROM    nom_rol_pagod a, view_nomina_rol b
            					WHERE '. $where. ' order by 5 asc';
              
                $resultado = $bd->ejecutar($sql);
                 
                
                $obj->grid->KP_sumatoria(8,"Monto","", "",'');
                
                $obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'Id', $variables,'S','visor','','del' );
      
       }	


$ViewProceso = '-';

echo $ViewProceso;

//------------------------------------------------------------------------------------
function K_where( $bd,$var1 ,$var2, $var3  ){
 
    $cadena = '';
    $cadena1 = '';
    $cadena2 = '';
    $cadena3 = '';
    $cadena4 = '';
    $cadena5 = '';
    
    $ruc = trim($_SESSION['ruc_registro']);
    
    
    $cadena = '( b.registro='.$bd->sqlvalue_inyeccion( $ruc ,true).') and ';
    
    
    $cadena1 = '( a.idprov=b.idprov) and ';
    
    if (  ($var1) >= 1){
    
        $cadena2 = '( a.id_rol ='.$bd->sqlvalue_inyeccion(trim($var1),true).") and ";
    
    }
    
   
    
        $cadena3 = '( a.id_config ='.$bd->sqlvalue_inyeccion(trim($var2),true).") and ";
 
    
    if (  ($var3) >= 1){
        if ( $var3 == 9999){
            $cadena4 = "";
        }else {
            $cadena4 = '( a.id_departamento ='.$bd->sqlvalue_inyeccion(trim($var3),true).") and ";
        }
      
        
    }
    
      
    $where    =  $cadena.$cadena1.$cadena2.$cadena3.$cadena4;
    $longitud = strlen($where);
    $where    = substr( $where,0,$longitud - 5);
    
    return   $where;
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
function K_procesa($bd,$obj,$id_rol,$id_config,$id_departamento){
    
    // date("Y-m-d");  
    
    $sesion 	 = $_SESSION['email'];
    $hoy 		 = $bd->hoy();
    $ruc 		 = $_SESSION['ruc_registro'];
    
    //------------------------ tipo de parametro
    $sql1 = "SELECT estructura, formula, monto, variable ,tipoformula
	 		    FROM nom_config
				where id_config = ".$bd->sqlvalue_inyeccion($id_config ,true);
    
    $resultado2 = $bd->ejecutar($sql1);
    
    $variable_formula = $bd->obtener_array( $resultado2);
    
    $estructura_sistema =  trim($variable_formula["estructura"] );
     
    $tipoformula        =  trim($variable_formula["tipoformula"] );
    
    
    //---------------------------------------------------
    $sql = "SELECT id_periodo, mes, anio, registro
	 	       FROM nom_rol_pago
			   WHERE id_rol = ".$bd->sqlvalue_inyeccion($id_rol ,true);
    
    $resultado1 = $bd->ejecutar($sql);
    
    $rol = $bd->obtener_array( $resultado1);
    
    if ( $id_departamento == 9999){
        
        $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo
     	       FROM view_nomina_rol
			   where   registro='.$bd->sqlvalue_inyeccion( $ruc ,true);
        
    }else {
       
        $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo
     	       FROM view_nomina_rol
			   where id_departamento='.$bd->sqlvalue_inyeccion($id_departamento ,true). ' and
                     registro='.$bd->sqlvalue_inyeccion( $ruc ,true);
        
    }
   
    
    $stmt = $bd->ejecutar($sql);
    
  
    //---------------------------------------------------
    
    $i = 1;
    
    while ($x=$bd->obtener_fila($stmt)){
        
        $sql_valida = "select count(*) as numero
							 from nom_rol_pagod
							 where id_rol="		.$bd->sqlvalue_inyeccion($id_rol ,true)." and
								   id_periodo= ".$bd->sqlvalue_inyeccion($rol["id_periodo"] ,true)." and
								   idprov= "	.$bd->sqlvalue_inyeccion(trim($x['idprov']),true)." and
								   id_config ="	.$bd->sqlvalue_inyeccion($id_config ,true);
        
        
        $resultado2 = $bd->ejecutar($sql_valida);
        
        $rol_valida = $bd->obtener_array( $resultado2);
 
        $descuento = 0;
        
        if ($rol_valida["numero"] == 0){
            
            
            if ($estructura_sistema == 'Sistema'){
                
                if ( $tipoformula == 'AP'){
                    $descuento = Aporte_personal_IESS( $bd, $id_rol, $rol["id_periodo"], trim($x['idprov']) );
                }
                
                 
                
                if ( $tipoformula == 'FR'){
                    
                    $descuento =   FondosReserva( $bd ,$rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
         
                }
                
                
            }
             
            if ( $id_config > 0 ) {
            
                    $sql = "INSERT INTO nom_rol_pagod(
        					id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes, 
                            sueldo, id_departamento, id_cargo, regimen,fecha)
        				VALUES (".
        				$bd->sqlvalue_inyeccion($id_rol , true).",".
        				$bd->sqlvalue_inyeccion($rol["id_periodo"], true).",".
        				$bd->sqlvalue_inyeccion(trim($x['idprov']), true).",".
        				$bd->sqlvalue_inyeccion($id_config, true).",".
        				$bd->sqlvalue_inyeccion(0, true).",".
        				$bd->sqlvalue_inyeccion($descuento, true).",".
        				$bd->sqlvalue_inyeccion($ruc, true).",".
        				$bd->sqlvalue_inyeccion($rol["anio"], true).",".
        				$bd->sqlvalue_inyeccion($rol["mes"], true).",".
        				$bd->sqlvalue_inyeccion($x['sueldo'], true).",".
        				$bd->sqlvalue_inyeccion($x['id_departamento'], true).",".
        				$bd->sqlvalue_inyeccion($x['id_cargo'], true).",".
        				$bd->sqlvalue_inyeccion($x['regimen'], true).",".
        				$bd->sqlvalue_inyeccion($x['fecha'], true).")";
        				
        				$resultado = $bd->ejecutar($sql);
            }
        }
    }
   
}
///-----------------------------------------------------------------------------------
function FondosReserva( $bd ,$id_periodo, $id_rol,$idprov ,$anio,$mes ){
    
    
    $Fondo = $bd->query_array('view_nomina_rol',
        'sifondo,fecha',
        'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true) 
        );
    
 
    
    $User = $bd->query_array('view_nom_rol_formula',
        'sum(ingreso) as suma',
        'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 id_periodo='.$bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
                 formula='.$bd->sqlvalue_inyeccion( 'I',true)
        );
    
    
    $valor_parcial = 0;
    
    if ( $Fondo['sifondo'] == 'S' ){
        
            if (!empty($User['suma'])){
                
                
                $valor_hora = ( $User['suma'] * (8.33 / 100) );
                
                $valor_parcial =  $valor_hora    ;
                
                
            }
    }
    
    
    return $valor_parcial;
}
//---------------------------------------
function horas_suplementarias( $bd ,$id_periodo, $id_rol,$idprov ,$anio,$mes ){
    
    
    $User = $bd->query_array('nom_rol_horas',
        'id_rolhora, sueldo,dias, horasextras, horassuple, atrasos',
        'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 id_periodo='.$bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
                 anio='.$bd->sqlvalue_inyeccion($anio,true).' and
                 mes='.$bd->sqlvalue_inyeccion($mes,true)
        );
    
    $valor_parcial = 0;
    
    if (!empty($User['horassuple'])){
        
        
        $valor_hora = ( $User['sueldo'] / 240);
        
        $valor_suple =  $valor_hora * 1.5;
        
        $valor_hora = $valor_suple  ; /// 60 ;
        
        $valor_parcial =  round($valor_hora,2) * $User['horassuple']   ;
        
        
        
        
    }
    
    
    return $valor_parcial;
}
///--------
function Aporte_personal_IESS($bd,$id_rol,$id_periodo,$empleado ){
    
    $User = $bd->query_array('view_nom_rol_formula',
        'sum(ingreso) as suma',
        'idprov='.$bd->sqlvalue_inyeccion(trim($empleado),true).' and
                 id_periodo='.$bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
                 formula='.$bd->sqlvalue_inyeccion( 'I',true)
        );
    
    
    $valor_parcial = 0;
    
    if (!empty($User['suma'])){
        
        
        $valor_hora = ( $User['suma'] * (9.45 / 100) );
        
        $valor_parcial =  $valor_hora    ;
        
    }
    
    return  $valor_parcial;
}   
?>
<script>

   jQuery.noConflict(); 

   jQuery(document).ready(function() {

	   jQuery('#jsontable').DataTable( {
    	        "paging":   true,
    	        "ordering": false,
    	        "info":     false
    	    } );
        
    } ); 
</script> 
  