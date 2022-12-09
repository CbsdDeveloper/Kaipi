<form action='Model-xls_ingresos.php' method='post' enctype="multipart/form-data">
	  
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
 
	  <input type='submit' name='submit' value='Cargar'>  
      <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
      <input name="valida" type="hidden" value="S" /> 
	  
  </form>
<?php 
session_start( );  

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
  /*Creamos la instancia del objeto. Ya estamos conectados*/

$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$id_rol = $_SESSION['id_rol'] ;

$sql = "SELECT id_periodo, mes, anio, registro
	 	       FROM nom_rol_pago
			   WHERE id_rol = ".$bd->sqlvalue_inyeccion($id_rol ,true);

$resultado1 = $bd->ejecutar($sql);

$rol = $bd->obtener_array( $resultado1);

$id_periodo = $rol["id_periodo"];
$mes  =    $rol["mes"];
$anio =    $rol["anio"];
 
if(isset($_POST['submit']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname = $_FILES['sel_file']['name'];
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
    $chk_ext = explode(".",$fname);
    
    //----ruc;nombre;direccion;telefono;correo;modulo
    
        //si es correcto, entonces damos permisos de lectura para subir
        
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        
        $i = 0;
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            
            $ruc       =   trim($data[0]) ;
            $sueldo  =   trim($data[1]) ;
            $fondo_reserva  =   trim($data[2]) ;
            $decimo13  =   trim($data[3]) ;
            $decimo14  =   trim($data[4]) ;
            $personal_IESS  =   trim($data[5]) ;
            $anticipo  =   trim($data[6]) ;
            $quirografario  =   trim($data[7]) ;
            $hipotecario  =   trim($data[8]) ;
            $multas  =   trim($data[9]) ;
            $otros_descuentos  =   trim($data[10]) ;
            
          
           
            $id =  trim($ruc);
            
            if (strlen(trim($ruc)) == 9){
                $id = '0'.$ruc;
            }
            if (strlen(trim($ruc)) == 12){
                $id = '0'.$ruc;
            }
            
               
            $val1 = _busca_ruc($bd,$id);
                     
            if ( $i > 0 ){
 
                if ( $val1  > 0 ) {
                    
                    _guarda_rol_ingreso($bd	, trim($id),$id_rol,$sueldo,$id_periodo,$anio,$mes,1);
                    
                    _guarda_rol_ingreso($bd	, trim($id),$id_rol,$fondo_reserva,$id_periodo,$anio,$mes,2);
                     
                    _guarda_rol_ingreso($bd	, trim($id),$id_rol,$decimo13,$id_periodo,$anio,$mes,3);
                    
                    _guarda_rol_ingreso($bd	, trim($id),$id_rol,$decimo14,$id_periodo,$anio,$mes,8);
                    
                    //------------------------------------------------------------------------------
                    _guarda_rol_descuento($bd	, trim($id),$id_rol,$personal_IESS,$id_periodo,$anio,$mes,4);
                    
                    _guarda_rol_descuento($bd	, trim($id),$id_rol,$anticipo,$id_periodo,$anio,$mes,5);
                    
                    _guarda_rol_descuento($bd	, trim($id),$id_rol,$quirografario,$id_periodo,$anio,$mes,13);
                    
                    _guarda_rol_descuento($bd	, trim($id),$id_rol,$hipotecario,$id_periodo,$anio,$mes,14);
                    
                    _guarda_rol_descuento($bd	, trim($id),$id_rol,$otros_descuentos,$id_periodo,$anio,$mes,12);
                    
                }
             }
             
             $i = 1 + $i;
        }
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);
        
       
        echo "Importacion exitosa! Registros: ".$i.' '.$valida_total;
        
    } 


 //-----------------------------------
    function _busca_ruc($bd	,$id){
        
              $AResultado = $bd->query_array(
                'par_ciu',
                'count(*) as nn',
                'idprov='.$bd->sqlvalue_inyeccion(trim($id),true)
                );
            
            $dato = $AResultado['nn'];
            
             
            return $dato;
        
        
    }
    //----------------------------
    function _guarda_rol_descuento($bd, $idprov,$id_rol,$sueldo,$id_periodo,$anio,$mes,$idconfig){
        
        
        $tabla 	  	 = 'par_ciu';
        $sesion 	 =  $_SESSION['email'];
        $hoy 	     =  date("Y-m-d");
        $ruc         =  $_SESSION['ruc_registro'];
        
        $sql_valida = "select count(*) as numero
							 from nom_rol_pagod
							 where id_rol="		.$bd->sqlvalue_inyeccion($id_rol ,true)." and
								   id_periodo= ".$bd->sqlvalue_inyeccion($id_periodo ,true)." and
								   idprov= "	.$bd->sqlvalue_inyeccion(trim($idprov),true)." and
								   id_config ="	.$bd->sqlvalue_inyeccion($idconfig ,true);
        
        $resultado2 = $bd->ejecutar($sql_valida);
        $rol_valida = $bd->obtener_array( $resultado2);
        
        $ingreso = str_replace(",",".",$sueldo); 
        
        
        if ($rol_valida["numero"] == 0){
            
            $x1 = _busca_funcionario($bd	,$idprov);
            
            $sql = "INSERT INTO nom_rol_pagod(
                                					id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes,
                                                    sueldo, id_departamento, id_cargo, regimen,fecha)
                                				VALUES (".
                                				$bd->sqlvalue_inyeccion($id_rol , true).",".
                                				$bd->sqlvalue_inyeccion($id_periodo, true).",".
                                				$bd->sqlvalue_inyeccion(trim($idprov), true).",".
                                				$bd->sqlvalue_inyeccion($idconfig, true).",".
                                				$bd->sqlvalue_inyeccion(0, true).",".
                                				$bd->sqlvalue_inyeccion($ingreso, true).",".
                                				$bd->sqlvalue_inyeccion($ruc, true).",".
                                				$bd->sqlvalue_inyeccion($anio, true).",".
                                				$bd->sqlvalue_inyeccion($mes, true).",".
                                				$bd->sqlvalue_inyeccion($x1['sueldo'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['id_departamento'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['id_cargo'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['regimen'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['fecha'], true).")";
                                				
                                				if ( $idconfig > 0 ) {
                                				    if ( $ingreso > 0 ) {
                                				        $resultado = $bd->ejecutar($sql);
                                				    }
                                				}
                                				
        }
        else {
            
            $sql_valida = "update nom_rol_pagod
							 set descuento="		.$bd->sqlvalue_inyeccion($ingreso ,true)."
							 where id_rol="		.$bd->sqlvalue_inyeccion($id_rol ,true)." and
								   id_periodo= ".$bd->sqlvalue_inyeccion($id_periodo ,true)." and
								   idprov= "	.$bd->sqlvalue_inyeccion(trim($idprov),true)." and
								   id_config ="	.$bd->sqlvalue_inyeccion($idconfig ,true);
            
            if ( $idconfig > 0 ) {
                if ( $ingreso > 0 ) {
                    $resultado = $bd->ejecutar($sql_valida);
                }
            }
            
        }
       //------------------------------------------ 
        
    }
 //-----------------------
    function _busca_funcionario($bd	,$id){
        
        $AResultado = $bd->query_array(
            'view_nomina_rol',
            'id_departamento,id_cargo,regimen,fecha,sueldo',
            'idprov='.$bd->sqlvalue_inyeccion(trim($id),true)
            );
        
       
        
        return  $AResultado;
        
    }
//---------------------
    function _guarda_rol_ingreso($bd, $idprov,$id_rol,$sueldo,$id_periodo,$anio,$mes,$idconfig){
        
        
        $tabla 	  	 = 'par_ciu';
        $sesion 	 =  $_SESSION['email'];
        $hoy 	     =  date("Y-m-d");
        $ruc         =  $_SESSION['ruc_registro'];
        
        $sql_valida = "select count(*) as numero
							 from nom_rol_pagod
							 where id_rol="		.$bd->sqlvalue_inyeccion($id_rol ,true)." and
								   id_periodo= ".$bd->sqlvalue_inyeccion($id_periodo ,true)." and
								   idprov= "	.$bd->sqlvalue_inyeccion(trim($idprov),true)." and
								   id_config ="	.$bd->sqlvalue_inyeccion($idconfig ,true);
        
        $resultado2 = $bd->ejecutar($sql_valida);
        $rol_valida = $bd->obtener_array( $resultado2);
        
        $ingreso = str_replace(",",".",$sueldo); 
        
                    if ($rol_valida["numero"] == 0){
            
                        $x1 = _busca_funcionario($bd	,$idprov);
                        
                                $sql = "INSERT INTO nom_rol_pagod(
                                					id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes,
                                                    sueldo, id_departamento, id_cargo, regimen,fecha)
                                				VALUES (".
                                				$bd->sqlvalue_inyeccion($id_rol , true).",".
                                				$bd->sqlvalue_inyeccion($id_periodo, true).",".
                                				$bd->sqlvalue_inyeccion(trim($idprov), true).",".
                                				$bd->sqlvalue_inyeccion($idconfig, true).",".
                                				$bd->sqlvalue_inyeccion($ingreso, true).",".
                                				$bd->sqlvalue_inyeccion(0, true).",".
                                				$bd->sqlvalue_inyeccion($ruc, true).",".
                                				$bd->sqlvalue_inyeccion($anio, true).",".
                                				$bd->sqlvalue_inyeccion($mes, true).",".
                                				$bd->sqlvalue_inyeccion($x1['sueldo'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['id_departamento'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['id_cargo'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['regimen'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['fecha'], true).")";
                                				
                                				if ( $idconfig > 0 ) {
                                				    if ( $ingreso > 0 ) {
                                				            $resultado = $bd->ejecutar($sql);
                                				    }
                                				}
                    				
                        }
                        else {
                            
                            $sql_valida = "update nom_rol_pagod
							 set ingreso="		.$bd->sqlvalue_inyeccion($ingreso ,true)."
							 where id_rol="		.$bd->sqlvalue_inyeccion($id_rol ,true)." and
								   id_periodo= ".$bd->sqlvalue_inyeccion($id_periodo ,true)." and
								   idprov= "	.$bd->sqlvalue_inyeccion(trim($idprov),true)." and
								   id_config ="	.$bd->sqlvalue_inyeccion($idconfig ,true);
                            
                            if ( $idconfig > 0 ) {
                                if ( $ingreso > 0 ) {
                                    $resultado = $bd->ejecutar($sql_valida);
                                }
                            }
                            
                        }
                        //---------------------------------------------------  
                           
     
         
    }
    
    
 
?>
  
  