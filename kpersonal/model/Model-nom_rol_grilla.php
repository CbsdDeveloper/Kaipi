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
        
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _tabla_ingresos($where,$id_rol,$id_config,$id_departamento){
        
        $tipo = $this->bd->retorna_tipo();
        
        
   
        $sqlEliminar = 'DELETE FROM  nom_rol_pagod
                 WHERE ingreso <= '.$this->bd->sqlvalue_inyeccion(0, true). ' and
                      descuento <= '.$this->bd->sqlvalue_inyeccion(0, true);
        
        $this->bd->ejecutar($sqlEliminar);
 
        
        $sql = 'SELECT  a.programa as "Programa",
                        a.idprov as "identificacion", 
                        b.razon as "Nombre",
                        b.cargo as "Cargo",
                        b.fecha as "Fecha Ingreso",
	                    sum(a.ingreso) as "Ingreso",
                        sum(a.descuento) as "Descuento",
                        sum(a.ingreso) - sum(descuento) as "Pagar"
                     FROM nom_rol_pagod a, view_nomina_rol b
                    where'. $where. ' group by 1,2,3,4,5 order by a.programa,b.razon';
 

        $resultado = $this->bd->ejecutar($sql);
        
        $variables  = 'id_rol='.$id_rol;
        
        $this->obj->grid->KP_sumatoria(7,"Ingreso","Descuento", "Pagar","");
        
        $this->obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'S','visor','pdf','elimina' ,$this->bd  );
        
        
 
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
   
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($id_rol,$id_config,$id_departamento,$regimen,$programa,$accion ){
        
        
        $_SESSION['id_config'] = $id_config;
        
        $where = $this->_where($id_rol,$id_config,$id_departamento,$regimen,$programa);
        
 
        
        $this->_tabla_ingresos($where,$id_rol,$id_config,$id_departamento);
        
        
        
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
        
        $cadena1 = '( a.idprov=b.idprov ) and ';
        
        $cadena6 = '( trim(a.regimen) ='.$this->bd->sqlvalue_inyeccion(trim($regimen),true).") and ";
        
        if (  ($id_rol) >= 1){
            
            $cadena2 = '( a.id_rol ='.$this->bd->sqlvalue_inyeccion(trim($id_rol),true).") and ";
            
        }
        
        if (  ($id_config) >= 1){
            
            $cadena3 = '( a.id_config ='.$this->bd->sqlvalue_inyeccion(trim($id_config),true).") and ";
            
        }
        
        if (  ($id_departamento) <> '-' ){
            
            $cadena4 = '( a.id_departamento ='.$this->bd->sqlvalue_inyeccion(trim($id_departamento),true).") and ";
            
        }
        
        if (  ($programa) <> '-' ){
            
            $cadena5 = '( a.programa ='.$this->bd->sqlvalue_inyeccion(trim($programa),true).") and ";
            
        }
        
       
        
        
        $where    =  $cadena1.$cadena6.$cadena2.$cadena3.$cadena4.$cadena5;
        
        $longitud = strlen($where);
        
        $where    = substr( $where,0,$longitud - 5);
        
        return   $where;
        
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function _n_fondos_reserva(  $id_periodo, $id_rol,$idprov ,$anio,$mes  ){
        
        
        $User = $this->bd->query_array('view_nom_rol_formula',
            'sum(ingreso) as suma',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                                         id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                                         id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                                         formula='.$this->bd->sqlvalue_inyeccion( 'I',true)
            );
        
        
        $valor_parcial = 0;
        
        if (!empty($User['suma'])){
            
            $valor_hora = ( $User['suma'] * (8.33 / 100) );
            
            $valor_parcial =  $valor_hora    ;
            
        }
        
        
        
        return $valor_parcial;
        
        
    }
    //---------------------------------------------------
    function k_situacion_actual($id ){
        
        
        $sql_movimiento = "SELECT count(*) as movimiento FROM nom_personal  where idprov =".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado_mov         = $this->bd->ejecutar($sql_movimiento);
        
        $datos_movimiento      = $this->bd->obtener_array( $resultado_mov);
        
        $fecha			        = $this->bd->fecha($_POST["fecha"]);
        
        
        
        if  ($datos_movimiento["movimiento"] == 0){
            
            $sql = "INSERT INTO nom_personal( idprov, id_departamento, id_cargo, responsable, regimen, fecha,
                contrato, registro,genero,foto,sueldo)
    				VALUES (".
    				$this->bd->sqlvalue_inyeccion( $_POST["idprov"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",".
    				$fecha.",".
    				$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",".
    				$this->bd->sqlvalue_inyeccion(  $this->ruc , true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["genero"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["foto"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true).")";
    				
    				$this->bd->ejecutar($sql);
        }
        else {
            
            $sql = "UPDATE nom_personal
    			   SET  id_departamento  =".$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",
    			   		id_cargo         =".$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",
    					responsable      =".$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",
	                    registro         =".$this->bd->sqlvalue_inyeccion(  $this->ruc , true).",
    					regimen          =".$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",
                        foto          =".$this->bd->sqlvalue_inyeccion( $_POST["foto"], true).",
    					fecha            =".$fecha.",
    					contrato         =".$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",
                        genero         =".$this->bd->sqlvalue_inyeccion( $_POST["genero"], true).",
    					sueldo           =".$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true)."
     			 WHERE idprov            =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
        }
        
        return  $datos_movimiento["movimiento"];
    }
    ///--------------------------------------------------------
    function k_nom_adicional($id ){
        
        
        $sql_movimiento1 = "SELECT count(*) as movimiento FROM nom_adicional  where idprov =".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado_mov1     = $this->bd->ejecutar($sql_movimiento1);
        
        $datos_movimiento1  = $this->bd->obtener_array( $resultado_mov1);
        
        $fecha			    = $this->bd->fecha(@$_POST["fechan"]);
        
        if  ($datos_movimiento1["movimiento"] == 0){
            
            $sql = "INSERT INTO nom_adicional( idprov,  nacionalidad, etnia, ecivil, vivecon,fechan, tsangre,
                estudios ,recorrido, tiempo ,emaile,carrera,titulo,cargas)
				VALUES (".
				$this->bd->sqlvalue_inyeccion(@$_POST["idprov"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["nacionalidad"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["etnia"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["ecivil"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["vivecon"], true).",".
				$fecha.",".
				$this->bd->sqlvalue_inyeccion(@$_POST["tsangre"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["estudios"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["recorrido"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["tiempo"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["emaile"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["carrera"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["titulo"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["cargas"], true).")";
				
				
				$this->bd->ejecutar($sql);
        }
        else {
            
            $sql = "UPDATE nom_adicional
			   SET  nacionalidad=".$this->bd->sqlvalue_inyeccion(@$_POST["nacionalidad"], true).",
			   		etnia       =".$this->bd->sqlvalue_inyeccion(@$_POST["etnia"], true).",
					ecivil      =".$this->bd->sqlvalue_inyeccion(@$_POST["ecivil"], true).",
					vivecon     =".$this->bd->sqlvalue_inyeccion(@$_POST["vivecon"], true).",
					fechan      =".$fecha.",
					tsangre     =".$this->bd->sqlvalue_inyeccion(@$_POST["tsangre"], true).",
                    estudios     =".$this->bd->sqlvalue_inyeccion(@$_POST["estudios"], true).",
                    recorrido     =".$this->bd->sqlvalue_inyeccion(@$_POST["recorrido"], true).",
                    tiempo     =".$this->bd->sqlvalue_inyeccion(@$_POST["tiempo"], true).",
                    emaile     =".$this->bd->sqlvalue_inyeccion(@$_POST["emaile"], true).",
                    carrera     =".$this->bd->sqlvalue_inyeccion(@$_POST["carrera"], true).",
                    titulo     =".$this->bd->sqlvalue_inyeccion(@$_POST["titulo"], true).",
					cargas      =".$this->bd->sqlvalue_inyeccion(@$_POST["cargas"], true)."
 			 WHERE idprov       =".$this->bd->sqlvalue_inyeccion($id, true);
            
            
            
            $this->bd->ejecutar($sql);
            
        }
        
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
    function _n_horas_extras( $id_periodo, $id_rol,$idprov ,$anio,$mes ){
        
        
        $User = $this->bd->query_array('nom_rol_horas',
            'id_rolhora, sueldo,dias, horasextras, horassuple, atrasos',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$this->bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
                 anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                 mes='.$this->bd->sqlvalue_inyeccion($mes,true)
            );
        
        $valor_parcial = 0;
        
        if (!empty($User['horasextras'])){
            
            
            $valor_hora = ( $User['sueldo'] / 240);
            
            $valor_suple =  $valor_hora * 2;
            
            $valor_hora = $valor_suple;  /// 60 ;
            
            $valor_parcial =  round($valor_hora,2) * $User['horasextras']   ;
            
        }
        
        
        return $valor_parcial;
    }
    //-------------------------
    function _n_horas_suplementarias( $id_periodo, $id_rol,$idprov ,$anio,$mes ){
        
        
        $User = $this->bd->query_array('nom_rol_horas',
            'id_rolhora, sueldo, dias, horasextras, horassuple, atrasos',
            'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true).' and
                 id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$this->bd->sqlvalue_inyeccion( trim($_SESSION['ruc_registro']) ,true).' and
                 anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                 mes='.$this->bd->sqlvalue_inyeccion($mes,true)
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



$id_rol             = $_GET['id_rol'];
$id_config          = $_GET['id_config'];
$id_departamento    = $_GET['id_departamento'];
$regimen            = $_GET['regimen'];
$programa           = $_GET['programa'];

$accion             = $_GET['accion'];

$gestion->consultaId($id_rol,$id_config,$id_departamento,$regimen,$programa,$accion);



?>
<script>

   jQuery.noConflict(); 

   jQuery(document).ready(function() {

	   jQuery('#jsontable').DataTable( {
    	        "paging":   true,
    	        "ordering": false,
    	        "info":     true
    	    } );
        
    } ); 
</script>  
  