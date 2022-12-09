<?php session_start( );  ?>
<div style="padding-top: 5px;font-size: 14px;font-family: Arial, Calibri"> 
<h4>Importando archivo CSV para gastos personales</h4>
  <form action='ajax_gasto_excel.php' method='post' enctype="multipart/form-data">
 
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
     <input type='submit' name='submit' value='Cargar Informacion'>
     <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
     <input name="valida" type="hidden" value="S" /> 
     <p>
     
	</p>
  </form>
        </div>
<?php  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

/*Creamos la instancia del objeto. Ya estamos conectados*/

$bd	     =	new Db ;
 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 if(isset($_POST['submit']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname                   = $_FILES['sel_file']['name'];
 
    
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
 //   $chk_ext = explode(".",$fname);
    
    // CEDULA;VIVIENDA;EDUCACION;SALUD;VESTIMENTA;ALIMENTACION;TURISMO
        //si es correcto, entonces damos permisos de lectura para subir
        
        $filename = $_FILES['sel_file']['tmp_name'];
        
        if (!empty($filename)){
        
                    $handle = fopen($filename, "r");
                    
                    $i = 0;
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
                    {
                        $cedula        =   trim($data[0]) ;
                        $viv           =  (trim($data[1]));
                        $edu           =  (trim($data[2]));
                        $sal           =  (trim($data[3]));
                        $vest          =  (trim($data[4]));
                        $alim          =  (trim($data[5]));
                        $tur           =  (trim($data[6]));
                         
                          
                        $viv      = str_replace(',','.', $viv);
                        $edu         = str_replace(',','.', $edu);
                        $sal    = str_replace(',','.', $sal);
                        $vest      = str_replace(',','.', $vest);
                        $alim         = str_replace(',','.', $alim);
                        $tur    = str_replace(',','.', $tur);
                        
                                
                        $lon = strlen($cedula); 
                        
                        
                        if ( $i > 0 ){
                                  if ($lon  > 5 ) {
                                      _guarda_detalle($bd, $cedula ,$viv, $edu ,$sal,$vest,$alim,$tur);
                                                            $resultado = "Importacion exitosa! Registros: ";
                                                }
                           }
                          
                           $i = 1 + $i;
                           echo  ' <br> registros: '.$i.' PROD '. $cedula ;
                     }
                    echo $resultado.' registros: '.$i ;
                     //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
                    fclose($handle);
                    
        }
    }
     
      
    //--------------------------
    function _guarda_detalle($bd, $cedula ,$viv, $edu ,$sal,$vest,$alim,$tur){
        
 
        if ( empty($viv)){
            $viv = '0.00';
        }
        
        if ( empty($sal)){
            $sal = '0.00';
        }
        
        if ( empty($edu)){
            $edu = '0.00';
        }
        if ( empty($alim)){
            $alim = '0.00';
        }
        
        if ( empty($vest)){
            $vest = '0.00';
        }
        
        if ( empty($tur)){
            $tur = '0.00';
        }
        
        $sql = "update par_ciu
				  set 
                    vivienda=".$bd->sqlvalue_inyeccion($viv,true).",
                    salud=".$bd->sqlvalue_inyeccion($sal,true).",
                    educacion=".$bd->sqlvalue_inyeccion($edu,true).",
                    alimentacion=".$bd->sqlvalue_inyeccion($alim,true).",
                    vestimenta=".$bd->sqlvalue_inyeccion($vest,true).",
                    turismo=".$bd->sqlvalue_inyeccion($tur,true)." 
				  where idprov =".$bd->sqlvalue_inyeccion(trim($cedula),true)  ;
        
        $bd->ejecutar($sql);
        
         
         
 
 
        
    }
  //----------------------------------------
  
    
    
 
?>
  
  