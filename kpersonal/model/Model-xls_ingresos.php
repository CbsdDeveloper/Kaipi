<?php 
session_start( );  
require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php';  

$bd	     =	new Db ;
$obj     = 	new objects;
$ruc     =  $_SESSION['ruc_registro'];

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$id_rol = $_SESSION['id_rol'] ;
$tipo   = $bd->retorna_tipo();
$datos  = array();

?>

<form action='Model-xls_ingresos.php' method='post' enctype="multipart/form-data">
 <p>
<?php 	  

     $resultado = $bd->ejecutar("select id_rol as codigo, novedad as nombre
                								from nom_rol_pago
                								where estado=". $bd->sqlvalue_inyeccion('N', true)."  and
								                      registro=". $bd->sqlvalue_inyeccion($ruc, true).'
                                           order by 1 desc ' );
 
         
    $obj->list->listadb($resultado,$tipo,'Periodo','id_rol1',$datos,'required','','div-0-3');
    
    
    $resultado1 = $bd->ejecutar("select 0 as codigo,' ( 0. Seleccione Detalle  ) ' as nombre   union  
                                    SELECT id_config as codigo, ' (' ||tipo ||') ' || nombre  as nombre
                                        FROM  nom_config
                                        where tipo <> 'X'   and estado = 'S'
                                        order by 2" );
    
    if(isset($_POST['submit']))
    {
        $datos['codigo1'] = $_POST['codigo1'];
    }

    $obj->list->listadb($resultado1,$tipo,'Tipo','codigo1',$datos,'required','','div-0-3');
    
    
?>
</p>	  
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
 
	  <input type='submit' name='submit' value='Cargar'>  
      <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
      <input name="valida" type="hidden" value="S" /> 
	  
  </form>

<?php 
 
if(isset($_POST['submit']))
{
  
    $id_rol = $_POST['id_rol1'];
    $codigo1= $_POST['codigo1'];
    
    
    $sql = "SELECT id_periodo, mes, anio, registro
	 	       FROM nom_rol_pago
			   WHERE id_rol = ".$bd->sqlvalue_inyeccion($id_rol ,true);
    
    $resultado1 = $bd->ejecutar($sql);
    
    $rol = $bd->obtener_array( $resultado1);
    
    $id_periodo =    $rol["id_periodo"];
    $mes        =    $rol["mes"];
    $anio       =    $rol["anio"];
    $total      =    0;
    
     $fname = $_FILES['sel_file']['name'];

    echo 'Cargando nombre del archivo: '.$fname.' <br>';
    
   
    //----ruc;nombre;direccion;telefono;correo;modulo
    
        //si es correcto, entonces damos permisos de lectura para subir
        
        $filename = $_FILES['sel_file']['tmp_name'];
        echo 'Cargando nombre del archivo: '.$filename.' <br>';

        $handle = fopen($filename, "r");
        
        $i = 0;

        echo ($handle);

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            
            
            $ruc         =   trim($data[0]) ;
            $valor       =   trim($data[1]) ;
            echo ($ruc);
 
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
                    
                  
                    _guarda_rol_ingreso($bd, $id,$id_rol,$valor,$id_periodo,$anio,$mes,$codigo1);
                    
                    $total = $total + $valor;
              
                }
             }
             
             $i = 1 + $i;
         
        }

        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        
        fclose($handle);
        
        echo "<h4><b>Importacion exitosa! Registros: ".$i.' </b></h4>';
        
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
    
 //-----------------------
    function _busca_funcionario($bd	,$id){
        
        $AResultado = $bd->query_array(
            'view_nomina_rol',
            'id_departamento,id_cargo,regimen,fecha,sueldo,programa',
            'idprov='.$bd->sqlvalue_inyeccion(trim($id),true)
            );
        
       
        
        return  $AResultado;
        
    }
    
    //-----------------------
    function _busca_configuracion($bd	,$id_config, $personal){
        
        $AResultado = $bd->query_array(
            'nom_config_regimen',
            'id_config_reg,tipo_config',
            'id_config='.$bd->sqlvalue_inyeccion($id_config,true) .' and 
               regimen='.$bd->sqlvalue_inyeccion(trim($personal['regimen']),true) .' and 
               programa='.$bd->sqlvalue_inyeccion(trim($personal['programa']),true) 
            );
        
 
       
                   
         return  $AResultado;
                   
    }
    
//---------------------
    function _guarda_rol_ingreso($bd, $idprov,$id_rol,$sueldo,$id_periodo,$anio,$mes,$idconfig){
        
 
        $x1    = _busca_funcionario($bd ,$idprov);
        
        $arol  = _busca_configuracion($bd ,$idconfig, $x1);
        
        $id_config_reg = $arol['id_config_reg'];
        $tipo_config   = $arol['tipo_config'];

        $ruc           =  trim($_SESSION['ruc_registro']);
        
        $sql_valida    = "select count(*) as numero
							 from nom_rol_pagod
							 where id_rol="		.$bd->sqlvalue_inyeccion($id_rol ,true)." and
								   id_periodo= ".$bd->sqlvalue_inyeccion($id_periodo ,true)." and
								   idprov= "	.$bd->sqlvalue_inyeccion(trim($idprov),true)." and
								   id_config ="	.$bd->sqlvalue_inyeccion($id_config_reg ,true);
        
        $resultado2 = $bd->ejecutar($sql_valida);

        
        $rol_valida = $bd->obtener_array( $resultado2);
        
        
        
        $ingreso = str_replace(",",".",$sueldo); 
     
        
          if ($rol_valida["numero"] == 0){
                       
                        
              if ( $id_config_reg > 0 ) {
                            
                          
                            
                            if ( $tipo_config == 'E' ){
                                $montoi = '0';
                                $montoe = $ingreso;
                            }else{
                                $montoi = $ingreso;
                                $montoe = '0';
                            }
                        
                        
                                $sql = "INSERT INTO nom_rol_pagod(
                                					id_rol, id_periodo, idprov, id_config, ingreso, descuento, registro, anio, mes,
                                                    sueldo, id_departamento, id_cargo, regimen,programa,fecha)
                                				VALUES (".
                                				$bd->sqlvalue_inyeccion($id_rol , true).",".
                                				$bd->sqlvalue_inyeccion($id_periodo, true).",".
                                				$bd->sqlvalue_inyeccion(trim($idprov), true).",".
                                				$bd->sqlvalue_inyeccion($id_config_reg, true).",".
                                				$bd->sqlvalue_inyeccion($montoi, true).",".
                                				$bd->sqlvalue_inyeccion($montoe, true).",".
                                				$bd->sqlvalue_inyeccion($ruc, true).",".
                                				$bd->sqlvalue_inyeccion($anio, true).",".
                                				$bd->sqlvalue_inyeccion($mes, true).",".
                                				$bd->sqlvalue_inyeccion($x1['sueldo'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['id_departamento'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['id_cargo'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['regimen'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['programa'], true).",".
                                				$bd->sqlvalue_inyeccion($x1['fecha'], true).")";
                                	
                                			 
                                	 
                                				    if ( $ingreso > 0 ) {
                                				            $bd->ejecutar($sql);
                                				    }
                                	 
                    				
                          }
                     }
      
         
    }
    
    
 
?>
  
  