<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';

class proceso{
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    private $anio;
    
    private $monto_iess;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  trim($_SESSION['ruc_registro']);
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _tabla_ingresos($where,$id_rol,$id_config,$id_departamento){
        
        $cadena = " || ' ' ";
        
        $sql = 'SELECT a.id_rold as "id",
                       b.fecha as "Fecha Ingreso",
                       b.programa '.$cadena.' as "Programa",
                       a.dias '.$cadena.' as "No.Dias",
                       a.idprov as "identificacion",
            		   b.razon as "Nombre",
                       b.unidad as "Departamento",
                       b.cargo as "Cargo",
                       a.descuento as "Monto"
               FROM    nom_rol_pagod a, view_nomina_rol b
              WHERE '. $where. ' order by 5 asc';
        
        
        $resultado = $this->bd->ejecutar($sql);
        
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $variables  = 'id_rol='.$id_rol.'&id_config='.$id_config.'&id_departamento='.$id_departamento;
        
        $this->obj->grid->KP_sumatoria(10,"Monto","", "",'');
        
        $this->obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'S','visor','edit','del' );
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _procesa_rol($id_rol, $id_config, $id_departamento,$regimen,$programa  ){
        
        
        //------------------------ tipo de parametro id_config1
        
        $variable_formula = $this->bd->query_array('view_nomina_rol_reg',
            'estructura, formula, monto, variable ,tipoformula',
            'id_config_reg='.$this->bd->sqlvalue_inyeccion($id_config,true));
        
        
        
        //------------------------ tipo de parametro iess
        // $codigo_iess = " id_config=31 and ";
        
        
        $this->monto_iess =  11.45 ;
        
        if (trim($regimen) == 'NOMBRAMIENTOS CODIGO TRABAJO'){
            // $codigo_iess = " id_config=4 and ";
            $this->monto_iess =  9.45 ;
        }
        if (trim($regimen) == 'CONTRATOS CODIGO DE TRABAJO'){
            //$codigo_iess = " id_config=4 and ";
            $this->monto_iess =  9.45 ;
        }
        
        if (trim($regimen) == 'PERSONAL DE PROYECTOS'){
            //   $codigo_iess = " id_config=4 and ";
            $this->monto_iess =  9.45 ;
        }
        
        
        
        /*
         $variable_iess = $this->bd->query_array('view_nomina_rol_reg',
         'monto',
         $codigo_iess.'  programa ='.$this->bd->sqlvalue_inyeccion(trim($programa),true).' and
         regimen='.$this->bd->sqlvalue_inyeccion(trim($regimen),true)
         );
         
         */
        
        
        $estructura_sistema =  trim($variable_formula["estructura"] );
        
        $tipoformula        =  trim($variable_formula["tipoformula"] );
        
        $valor_pone_rol     = $variable_formula["monto"] ;
        
        //---------------------------------------------------------------------------
        
        $rol = $this->bd->query_array('nom_rol_pago',
            'id_periodo, mes, anio, registro',
            'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true));
        
        //---------------------------------------------------------------------------
        
        if ( $id_departamento <> '-' ){
            
            $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
                           fondo,vivienda,salud, alimentacion,educacion,vestimenta,
                           sifondo,sidecimo,sicuarto,sihoras,sisubrogacion
     	       FROM view_nomina_rol
			   where id_departamento='.$this->bd->sqlvalue_inyeccion($id_departamento ,true). ' and
                     regimen='.$this->bd->sqlvalue_inyeccion($regimen ,true). ' and
                     estado='.$this->bd->sqlvalue_inyeccion(trim('S') ,true). ' and
                     anio_salida <> '.$this->bd->sqlvalue_inyeccion($this->anio ,true). ' and
                     programa='.$this->bd->sqlvalue_inyeccion(trim($programa) ,true) ;
            
        }else {
            
            
            
            $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
                           fondo,vivienda,salud, alimentacion,educacion,vestimenta,
                           sifondo,sidecimo,sicuarto,sihoras,sisubrogacion
     	       FROM view_nomina_rol
			   where    regimen='.$this->bd->sqlvalue_inyeccion($regimen ,true). ' and
                        estado='.$this->bd->sqlvalue_inyeccion(trim('S') ,true). ' and
                        anio_salida <> '.$this->bd->sqlvalue_inyeccion($this->anio ,true). ' and
                        programa='.$this->bd->sqlvalue_inyeccion(trim($programa) ,true) ;
            
            
        }
        
        
        
        
        $stmt = $this->bd->ejecutar($sql);
        
        
        //---------------------------------------------------------------------------
        
        
        while ($x=$this->bd->obtener_fila($stmt)){
            
            $sql_valida = "select count(*) as numero
							 from nom_rol_pagod
							 where id_rol="		.$this->bd->sqlvalue_inyeccion($id_rol ,true)." and
								   id_periodo= ".$this->bd->sqlvalue_inyeccion($rol["id_periodo"] ,true)." and
								   idprov= "	.$this->bd->sqlvalue_inyeccion(trim($x['idprov']),true)." and
								   id_config ="	.$this->bd->sqlvalue_inyeccion($id_config ,true);
            
            
            
            
            
            $resultado2 = $this->bd->ejecutar($sql_valida);
            
            $rol_valida = $this->bd->obtener_array( $resultado2);
            
            $ingreso = 0;
            $dias    = 0;
            
            if ($rol_valida["numero"] == 0){
                
                
                $dias = $this->_n_sueldo_dias($x['fecha'],$rol["mes"],$rol["anio"]  );
                
                
                $nbandera = 0;
                
                if ($estructura_sistema == 'Sistema'){
                    
                    if ( $tipoformula == 'AP'){
                        
                        $ingreso =  $this->_n_Aporte_personal_IESS( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"],$x['sueldo'],$x['fecha']);
                        
                        
                        
                    }
                    
                    if ( $tipoformula == 'FR'){
                        
                        $ingreso = $this->_n_fondos_reserva($rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                        
                    }
                    
                    if ( $tipoformula == 'RR'){
                        
                        
                        $ingreso = $this->_n_impuesto_renta($rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                        
                    }
                    
                    if ( $ingreso > 0 ){
                        
                        $nbandera = 1;
                    }
                    
                }else{
                    
                    if ( trim($estructura_sistema) == 'Constante'){
                        
                        $ingreso = $valor_pone_rol;
                        
                        $nbandera = 1;
                        
                    }else {
                        $nbandera = 1;
                    }
                    
                    
                }
                
                if ( $id_config > 0 ) {
                    
                    $sql = "INSERT INTO nom_rol_pagod(
        					id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes,
                            sueldo, id_departamento, id_cargo, regimen,dias,fecha)
        				VALUES (".
        				$this->bd->sqlvalue_inyeccion($id_rol , true).",".
        				$this->bd->sqlvalue_inyeccion($rol["id_periodo"], true).",".
        				$this->bd->sqlvalue_inyeccion(trim($x['idprov']), true).",".
        				$this->bd->sqlvalue_inyeccion($id_config, true).",".
        				$this->bd->sqlvalue_inyeccion(0, true).",".
        				$this->bd->sqlvalue_inyeccion($ingreso, true).",".
        				$this->bd->sqlvalue_inyeccion( $this->ruc , true).",".
        				$this->bd->sqlvalue_inyeccion($rol["anio"], true).",".
        				$this->bd->sqlvalue_inyeccion($rol["mes"], true).",".
        				$this->bd->sqlvalue_inyeccion($x['sueldo'], true).",".
        				$this->bd->sqlvalue_inyeccion($x['id_departamento'], true).",".
        				$this->bd->sqlvalue_inyeccion($x['id_cargo'], true).",".
        				$this->bd->sqlvalue_inyeccion($x['regimen'], true).",".
        				$this->bd->sqlvalue_inyeccion($dias, true).",".
        				$this->bd->sqlvalue_inyeccion($x['fecha'], true).")";
        				
        				if ( $nbandera == 1 )  {
        				    $this->bd->ejecutar($sql);
        				}
                }
            }
        }
        
        
        
    }
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($id_rol,$id_config,$id_departamento,$regimen,$programa,$accion ){
        
        
        $_SESSION['id_config'] = $id_config;
        
        $where = $this->_where($id_rol,$id_config,$id_departamento,$regimen,$programa);
        
        if ( $accion == 'add'){
            
            if ( $id_config <> '-'){
                
                $this->_procesa_rol($id_rol, $id_config, $id_departamento ,$regimen,$programa);
            }
            
            
            
        }
        
        if ( $id_config <> '-'){
            
            $this->_tabla_ingresos($where,$id_rol,$id_config,$id_departamento);
            
        }
        
        
        
        
        
        
    }
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function _where($id_rol,$id_config,$id_departamento,$regimen,$programa){
        
        
        $cadena1 = '';
        $cadena2 = '';
        $cadena3 = '';
        $cadena4 = '';
        $cadena5 = '';
        $cadena6 = '';
        
        $cadena1 = "(  b.anio_salida <> ".$this->anio ." and a.idprov=b.idprov and b.estado = 'S') and ";
        
        $cadena6 = '( a.regimen ='.$this->bd->sqlvalue_inyeccion(trim($regimen),true).") and ";
        
        if (  ($id_rol) >= 1){
            
            $cadena2 = '( a.id_rol ='.$this->bd->sqlvalue_inyeccion(trim($id_rol),true).") and ";
            
        }
        
        if (  ($id_config) >= 1){
            
            $cadena3 = '( a.id_config ='.$this->bd->sqlvalue_inyeccion(trim($id_config),true).") and ";
            
        }
        
        if (  ($id_departamento) <> '-' ){
            
            $cadena4 = '( a.id_departamento ='.$this->bd->sqlvalue_inyeccion(trim($id_departamento),true).") and ";
            
        }
        
        
        
        $cadena5 = '( b.programa ='.$this->bd->sqlvalue_inyeccion(trim($programa),true).") and ";
        
        
        
        $where    =  $cadena1.$cadena6.$cadena2.$cadena3.$cadena4.$cadena5;
        
        $longitud = strlen($where);
        
        $where    = substr( $where,0,$longitud - 5);
        
        return   $where;
        
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function _n_fondos_reserva(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
        
        $xxx = $this->bd->query_array('view_nomina_rol','sifondo,fondo, sidecimo, sicuarto, sihoras, sisubrogacion', 'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true));
        
        
        $User = $this->bd->query_array('view_nom_rol_formula',
            'sum(ingreso) as suma',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                                         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                                         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true)." and
                                         tipoformula in ('RS','OO')  and
                                         formula=".$this->bd->sqlvalue_inyeccion( 'I',true)
            );
        
        
        
        $valor_parcial = 0;
        
        
        if ( $xxx['fondo']  == 'S') {
            
            if ( $xxx['sifondo']  == 'S') {
                
                if (!empty($User['suma'])){
                    
                    $valor_hora = ( $User['suma'] * (8.33 / 100) );
                    
                    $valor_parcial =  $valor_hora    ;
                    
                }
                
            }
        }
        
        return $valor_parcial;
        
        
    }
    //-
    function _n_impuesto_renta(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
        
        $this->monto_iess =  11.45 ;
        
        $actual = $this->bd->query_array('view_nom_rol_formula',
            ' coalesce(sum(sueldo),0) promedio',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 tipoformula =' .$this->bd->sqlvalue_inyeccion( 'RS',true) .' AND
                  mes  =  '.$this->bd->sqlvalue_inyeccion($mes,true).' and
                  anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                  formula='.$this->bd->sqlvalue_inyeccion( 'I',true)
            );
        
        $promedio   = round($actual['promedio'],2);
        
        echo 'sueldo '.$promedio.'<br>';
        
        $xxx = $this->bd->query_array('view_nomina_rol',
            'fecha,sueldo,
             coalesce(vivienda,0) + coalesce(vestimenta,0) +coalesce(salud,0) + coalesce(educacion,0)  + coalesce(turismo,0) +coalesce(alimentacion,0) as saldo',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true));
        
        
        $iess_parcial            =  $this->_n_Aporte_personal_IESS_renta( $id_periodo, $id_rol,$idprov ,$anio,$mes,$xxx['sueldo']  );
        
        echo 'iess '.$iess_parcial.'<br>';
        
        echo 'gastos anual '.$xxx['saldo'] .'<br>';
        
         
        $gastos_deducibles       =  round($xxx['saldo'] / 12,2) ;
        
        echo 'gastos mes '.$gastos_deducibles .'<br>';
        
        $base_imponible          =  ( $promedio   -  ( $iess_parcial + $gastos_deducibles))  ;
        
        echo 'base anual '.$base_imponible .'<br>';
         
        $IR =  $this->_monto_impuesto_renta(  $base_imponible ,$anio  );
        
 
        
        $valor_mensual = round($IR,2) ; 
        
        echo 'ir  '.$valor_mensual .'<br>';
        
        return $valor_mensual;
        
        
    }
    ///---------------
    function _monto_impuesto_renta(  $base_imponible ,$anio  ){
        
        $renta = $this->bd->query_array('nom_imp_renta','anio, tipo, fracbasica, excehasta, impubasico, impuexcedente',
            'anio = '.$this->bd->sqlvalue_inyeccion($anio,true).'
            and ( '.$base_imponible.'  between fracbasica/12 and excehasta/12 )'
            );
        
        
        $excedente      = 0;
        $valor_obtenido = 0;
        $IR             = 0 ;
        
        $excedente      = $base_imponible - ( $renta['fracbasica'] /12);
        
        $valor_obtenido = $excedente * ( $renta['impuexcedente'] / 100 );
        
        $IR = ( $valor_obtenido +  ($renta['impubasico'] /12) )      ;
        
        $valor_mensual = round($IR,2);
        
        
        RETURN  $valor_mensual;
    }
    
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function _n_sueldo_dias($fecha,$mes,$anio  ){
        
        
        
        $bandera = 0;
        
        $dia     = 30;
        
        $periodo = explode('-', $fecha);
        
        if ( $anio == $periodo[0] ){
            $bandera = 1;
        }
        
        //--------------------------------------------------------------
        
        if ( $bandera == 1){
            
            if ( $mes == $periodo[1] ){
                
                $bandera = 2;
                
            }
            
        }
        
        //--------------------------------------------------------------
        
        if ( $bandera == 2){
            
            $ndia = $periodo[2] - 1;
            $dia = 30 - $ndia;
            
        }
        
        
        
        
        return $dia ;
        
    }
    //-------------------------
    function _n_Aporte_personal_IESS( $id_periodo, $id_rol,$idprov ,$anio,$mes ){
        
        
        
        $User = $this->bd->query_array('view_nom_rol_formula',
            'sum(ingreso) as suma',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim(trim($idprov)),true).' and
                 id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                 formula='.$this->bd->sqlvalue_inyeccion( 'I',true) ." and tipoformula not in ('FR', 'DT','DC') "
            );
        
        
        
        
        $valor_parcial = 0;
        
        if (!empty($User['suma'])){
            
            $valor_hora = ( $User['suma'] * ($this->monto_iess  / 100) );
            
            $valor_parcial =  $valor_hora    ;
            
        }
        
        
        
        return $valor_parcial;
    }
    //-------------------------
    function _n_Aporte_personal_IESS_renta( $id_periodo, $id_rol,$idprov ,$anio,$mes ,$sueldo){
        
        
        /*
         $User = $this->bd->query_array('view_nom_rol_formula',
         'sum(ingreso) as suma',
         'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
         registro='.$this->bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
         formula='.$this->bd->sqlvalue_inyeccion( 'I',true) ." and tipoformula not in ( 'DT','DC','RS') "
         );
         
         */
        
        
        
        if ($sueldo > 0 ){
            
            $valor_hora = ( $sueldo * ($this->monto_iess  / 100) );
            
            $valor_parcial =  $valor_hora    ;
            
        }
        
        
        return $valor_parcial;
    }
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function _n_sueldo_mes( $id_periodo, $id_rol,$idprov ,$anio,$mes,$sueldo,$fecha ){
        
        $valor_parcial = $sueldo;
        
        /*
         $User = $this->bd->query_array('nom_rol_horas',
         'id_rolhora, sueldo,dias, horasextras, horassuple, atrasos',
         'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
         anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
         mes='.$this->bd->sqlvalue_inyeccion($mes,true)
         );
         */
        
        $nro_dias = $this->_n_sueldo_dias($fecha,$mes,$anio);
        
        
        if ( $nro_dias == 30 ){
            
            $valor_parcial = $sueldo;
            
        }else {
            
            $valor_parcial = ( $nro_dias * $sueldo ) / 30;
            
        }
        
        
        return $valor_parcial;
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



$idprov             = $_GET['id'];
 
 
$gestion->_n_impuesto_renta(  $id_periodo, 20,$idprov ,2023,1);

?>
 
  