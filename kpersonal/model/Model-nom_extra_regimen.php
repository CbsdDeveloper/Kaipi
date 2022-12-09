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
    private $variable_valor;
    
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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
       
        $this->anio       =  $_SESSION['anio'];

        $this->formula     = 	new Formula_rol(  $this->obj,  $this->bd);
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _tabla_ingresos($where,$id_rol,$id_config,$id_departamento){
         
        $cadena = " || ' ' ";
        
        $sql = 'SELECT a.id_rold as "id",
                       a.programa '.$cadena.' as "Programa",
                       b.fecha as "Ingreso", 
                       a.dias '.$cadena.' as "No.Dias",
                       a.idprov as "identificacion",
            		   b.razon as "Nombre",
                       b.unidad as "Departamento", 
                       b.cargo as "Cargo",  
                       a.ingreso as "Monto"
               FROM    nom_rol_pagod a, view_nomina_rol b
              WHERE '. $where. ' order by 6 asc';
        
        
         
        
        $resultado = $this->bd->ejecutar($sql);
        
        
        $tipo = $this->bd->retorna_tipo();
        
 
        $variables  = 'id_rol='.$id_rol.'&id_config='.$id_config.'&id_departamento='.$id_departamento;
        
        $this->obj->grid->KP_sumatoria(10,"Monto","", "",'');
        
        $this->obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'S','visor','','del' );
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _procesa_rol( $id_rol,$id_config,$regimen  ){
 
        //---------------------------------------------------------------------------
        
        $rol = $this->bd->query_array('nom_rol_pago',
            'id_periodo, mes, anio, registro,tipo',
            'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true));
        //---------------------------------------------------------------------------
        $anio = $rol["anio"];

        $mes  = $rol["mes"];
        
    
        $sql = 'SELECT idprov, id_departamento, id_cargo, regimen,  fecha, sueldo,
                           fondo,vivienda,salud, alimentacion,educacion,vestimenta,
                           sifondo,sidecimo,sicuarto,sihoras,sisubrogacion,programa,fecha_salida
     	       FROM view_nomina_rol
			   where    regimen='.$this->bd->sqlvalue_inyeccion($regimen ,true). ' and
                           msale = '.$this->bd->sqlvalue_inyeccion('-1' ,true) ;
        
          
        $stmt = $this->bd->ejecutar($sql);


        // $comprobante =  $this->saldos->_aprobacion($id);

        //---------------------------------------------------------------------------
        while ($x=$this->bd->obtener_fila($stmt)){
            

            $x_id_config_reg = $this->bd->query_array(
                'nom_config_regimen',
                'id_config_reg,tipo_config',
                'id_config='.$this->bd->sqlvalue_inyeccion($id_config,true) .' and 
                   regimen='.$this->bd->sqlvalue_inyeccion(trim($x['regimen']),true) .' and 
                   programa='.$this->bd->sqlvalue_inyeccion(trim($x['programa']),true) 
                );
        
                
                $this->formula->tipo_rubro($x_id_config_reg['id_config_reg']);

             //------------------------ tipo de parametro id_config1
                $variable_formula = $this->bd->query_array('view_nomina_rol_reg',
                'estructura, 
                formula, 
                monto, 
                variable ,
                tipoformula', 
                'id_config_reg='.$this->bd->sqlvalue_inyeccion($x_id_config_reg['id_config_reg'],true)
                );
            
            $estructura_sistema    =  trim($variable_formula["estructura"] );
            $tipoformula           =  trim($variable_formula["tipoformula"] );       


            $id_config_reg = $x_id_config_reg['id_config_reg'];

            if (  $id_config_reg  > 0 ){ 

                                $sql_valida = "select count(*) as numero
                                                from nom_rol_pagod
                                                where id_rol="		.$this->bd->sqlvalue_inyeccion($id_rol ,true)." and
                                                    id_periodo= ".$this->bd->sqlvalue_inyeccion($rol["id_periodo"] ,true)." and
                                                    idprov= "	.$this->bd->sqlvalue_inyeccion(trim($x['idprov']),true)." and
                                                    id_config ="	.$this->bd->sqlvalue_inyeccion($id_config_reg ,true);
                                
                                

                                // verifica los datos para no duplica la generacoin
                                $resultado2 = $this->bd->ejecutar($sql_valida);

                                $rol_valida = $this->bd->obtener_array( $resultado2);

                                $ingreso    = 0;
                                $dias       = 0;
                                $programa   = trim($x['programa']);

                                
                                if ($rol_valida["numero"] == 0){
                                    
                                    $dias         = $this->formula->_n_sueldo_dias($x['fecha'],$rol["mes"],$rol["anio"], $x['fecha_salida'] );
                                    
                                    $fecha_salida = $x['fecha_salida'];

                    
                                    $nbandera = 0;
                            
                                    
                                    if ($estructura_sistema == 'Sistema'){
                                        
                                        if ( $tipoformula == 'RS'){
                                            
                                            $ingreso =  $this->formula->_n_sueldo_mes( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"],$x['sueldo'],$x['fecha'],$fecha_salida);
                                        
                                        }
                                        
                                        if ( $tipoformula == 'FR'){
                                            
                                            $ingreso  = $this->formula->_n_fondos_reserva($rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                            
                                        }
                                        
                                        
                                        if ( $tipoformula == 'AC'){
                                            
                                            $ingreso = $this->formula->_n_carga_familiar($rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                            
                                        }
                                        
                            
                                        if ( $tipoformula == 'HS'){
                                            $ingreso = $this->formula->_n_horas_suplementarias( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                        }
                                        
                                        if ( $tipoformula == 'HE'){
                                            $ingreso = $this->formula->_n_horas_extras( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                        }
                                        
                                        if ( $tipoformula == 'AT'){
                                            $ingreso = $this->formula->_n_antiguedad( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                        }
                                        
                                        //---------- decimo tercero

                                    
                    
                                        if ( $tipoformula == 'DT'){
                                            if ( $rol["tipo"] == 2 ){
                                                $ingreso = $this->formula->_n_decimo_tercero( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                            }
                                            if ( $rol["tipo"] == 0 ){
                                                $ingreso =$this->formula->_n_decimo_tercero_acumula( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                            }
                                            
                                            
                                        }
                                        
                                    
                                        
                                        if ( $tipoformula == 'DC'){
                                            if ( $rol["tipo"] == 1 ){
                                                $ingreso = $this->formula->_n_decimo_cuarto_acumulado( $rol["id_periodo"], $id_rol, trim($x['idprov']) ,$rol["anio"], $rol["mes"] );
                                            }
                                            if ( $rol["tipo"] == 0 ){
                                                $ingreso = $this->formula->_n_decimo_cuarto( $rol["id_periodo"], $id_rol,trim($x['idprov']) ,$rol["anio"],$rol["mes"]);
                                            }
                                        }
                    
                    
                                        if ( $ingreso > 0 ){
                                            
                                            $nbandera = 1;
                                        }
                                        
                                    }else{
                                        
                                        $nbandera = 1;
                                    }
                                        
                                    
                                    if ( $id_config_reg > 0 ) {
                                
                                        $sql = "INSERT INTO nom_rol_pagod(
                                                id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes,
                                                sueldo, id_departamento, id_cargo, regimen,dias,programa,fecha)
                                            VALUES (".
                                            $this->bd->sqlvalue_inyeccion($id_rol , true).",".
                                            $this->bd->sqlvalue_inyeccion($rol["id_periodo"], true).",".
                                            $this->bd->sqlvalue_inyeccion(trim($x['idprov']), true).",".
                                            $this->bd->sqlvalue_inyeccion($id_config_reg, true).",".
                                            $this->bd->sqlvalue_inyeccion($ingreso, true).",".
                                            $this->bd->sqlvalue_inyeccion(0, true).",".
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
        
        echo '  <b>DATOS PROCESADOS .... VERIFIQUE LA INFORMACION POR REGIMEN Y PROGRAMA</b>';
   
        
    }

    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId( $id_rol,$id_config,$regimen ){
        
        
   
         
             
                 
                $this->_procesa_rol(  $id_rol,$id_config,$regimen);
                
             
          
            
       
         
         
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
    $id_config          = $_GET['rubro_total'];
     $regimen            = $_GET['regimen'];
     
     
    $gestion->consultaId($id_rol,$id_config,$regimen);
 
  



?>
 