<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';

require 'Formulas-roles_nomina.php';

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

    private $formula;


    
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


        $this->formula     = 	new Formula_rol(  $this->obj,  $this->bd);
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _tabla_ingresos($where,$id_rol,$id_config,$id_departamento){
        
        $cadena = " || ' ' ";
        
        $sql = 'SELECT a.id_rold as "id",
                       b.fecha as "Ingreso",
                       a.programa '.$cadena.' as "Programa",
                       a.dias '.$cadena.' as "No.Dias",
                       a.idprov as "identificacion",
            		   b.razon as "Nombre",
                       b.unidad as "Departamento",
                       b.cargo as "Cargo",
                       a.descuento as "Monto"
               FROM    nom_rol_pagod a, view_nomina_rol b
              WHERE '. $where. ' order by b.razon asc';
        
        
        $resultado = $this->bd->ejecutar($sql);
        
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $variables  = 'id_rol='.$id_rol;
        
        $this->obj->grid->KP_sumatoria(10,"Monto","", "",'');
        
        $this->obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'S','visor','edit','del',$this->bd );
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _procesa_rol($id_rol, $id_config, $id_departamento,$regimen,$programa  ){
        
        
        //------------------------ tipo de parametro id_config1
        
        $variable_formula = $this->bd->query_array('view_nomina_rol_reg',
            'estructura, formula, monto, variable ,tipoformula',
            'id_config_reg='.$this->bd->sqlvalue_inyeccion($id_config,true));
        
        
        $estructura_sistema =  trim($variable_formula["estructura"] );
        
        $tipoformula        =  trim($variable_formula["tipoformula"] );
        
        $valor_pone_rol     =  $variable_formula["monto"] ;
         

        if (  $tipoformula   == 'AP'){
                $this->formula->_monto_Aporte_IESS(  $variable_formula["monto"]  );
         }
       
        
        //---------------------------------------------------------------------------
        
        $rol = $this->bd->query_array('nom_rol_pago',
            'id_periodo, mes, anio, registro',
            'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true));
        
        //---------------------------------------------------------------------------
        
        $anio = $rol["anio"];
        $mes  = $rol["mes"];
        
        if ( $id_departamento <> '-' ){
            
            $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
                           fondo,vivienda,salud, alimentacion,educacion,vestimenta,
                           sifondo,sidecimo,sicuarto,sihoras,sisubrogacion,programa,fecha_salida
     	       FROM view_nomina_rol
			   where id_departamento='.$this->bd->sqlvalue_inyeccion($id_departamento ,true). ' and
                     regimen='.$this->bd->sqlvalue_inyeccion(trim($regimen) ,true). ' and
                     programa='.$this->bd->sqlvalue_inyeccion(trim($programa) ,true). ' and
                     msale = '.$this->bd->sqlvalue_inyeccion('-1' ,true) ;
            
        }else {
            
            
            $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
            fondo,vivienda,salud, alimentacion,educacion,vestimenta,
            sifondo,sidecimo,sicuarto,sihoras,sisubrogacion,programa,fecha_salida
 FROM view_nomina_rol
where    fecha_salida is NULL and regimen='.$this->bd->sqlvalue_inyeccion($regimen ,true). ' and
          programa='.$this->bd->sqlvalue_inyeccion(trim($programa) ,true). ' and
          (msale  = '.$this->bd->sqlvalue_inyeccion( '-1' ,true). ' or msale = '.  $this->bd->sqlvalue_inyeccion(  $mes ,true) .')' ;

            $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
            fondo,vivienda,salud, alimentacion,educacion,vestimenta,
            sifondo,sidecimo,sicuarto,sihoras,sisubrogacion,programa,fecha_salida
            FROM view_nomina_rol
            where    fecha_salida is NULL and regimen='.$this->bd->sqlvalue_inyeccion($regimen ,true). ' and
            programa='.$this->bd->sqlvalue_inyeccion(trim($programa) ,true);
            
            
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
            
            $fecha_salida = $x['fecha_salida'];
            $valida_anio  = explode('-',$fecha_salida);
            
            $anio_salida =  $valida_anio[0];
            
            if (empty( $fecha_salida )){
                
            }else{
                if ( $valida_anio == $rol["anio"]){
                } else{
                    $rol_valida["numero"] == 1;
                }
            }
            
            if ($rol_valida["numero"] == 0){
                
                  
                $dias         =  $this->formula->_n_sueldo_dias($x['fecha'],$rol["mes"],$rol["anio"], $x['fecha_salida'] );
                
                $fecha_salida = $x['fecha_salida'];
                
                $nbandera     = 0;
                
                if ($estructura_sistema == 'Sistema'){
                    
                    if ( $tipoformula == 'AP'){
                        
                        $ingreso =  $this->formula->_n_Aporte_personal_IESS( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"],$x['sueldo'],$x['fecha']);
                        
                        
                        
                    }
                    
                    if ( $tipoformula == 'FR'){
                        
                        $ingreso = $this->formula->_n_fondos_reserva($rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                        
                    }
                    
                    if ( $tipoformula == 'RR'){
                        
                     
                        $ingreso =$this->formula->_n_impuesto_renta($rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"],'S');
                        
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
                            sueldo, id_departamento, id_cargo, regimen,dias,programa,fecha)
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
        				$this->bd->sqlvalue_inyeccion($programa, true).",".
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
        
        if ( trim($accion) == 'add'){
            
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
        
       
        $cadena1 = "(  a.idprov=b.idprov ) and ";
        
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
        
      
            
            $cadena5 = '( a.programa ='.$this->bd->sqlvalue_inyeccion(trim($programa),true).") and ";
            
 
        
        $where    =  $cadena1.$cadena6.$cadena2.$cadena3.$cadena4.$cadena5;
        
        $longitud = strlen($where);
        
        $where    = substr( $where,0,$longitud - 5);
        
        return   $where;
        
        
    }
    
   
    ///---------------

   
 
    
     
    
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
  