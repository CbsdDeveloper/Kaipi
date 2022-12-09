<?php session_start( );  ?>
<div style="padding-top: 5px;font-size: 13px;font-family: Arial, Calibri"> 
<h4>Importando archivo CSV</h4>
<p>
FORMATO 1.- Registro de marcaciones <br><br>

<b>Número Identificacion | Nombre | Tiempo | Estado | Dispositivos | Tipo de Registro </b><br><br>

Formato fecha: DD/MM/AAAA Ejemplo:  07/01/2022<br><br>

Separador de campo coma ( <b>,</b> ) <br>


 </p>
  <form action='ajax_importar_marcacion01.php' method='post' enctype="multipart/form-data">
 


   Importar Archivo : <input type='file' name='sel_file' size='1800' accept=".csv">
     <input type='submit' name='submit' value='Cargar Informacion'>
     <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
     <input name="valida" type="hidden" value="S" /> 
     <p>
     
	</p>
  </form>
        </div>
<?php 
 
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 

$bd	     =	new Db ;
 


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

 if(isset($_POST['submit']))
{
     $fname                   = $_FILES['sel_file']['name'];
  
    //


$anio = '2022';
$mes = '10';

 _borra_periodo($bd,$anio,$mes);

    echo 'Cargando nombre del archivo: '.$fname.' <br>';
     
     
        // Número,Nombre,Tiempo,Estado,Dispositivos, 
        
        $filename = $_FILES['sel_file']['tmp_name'];
        
        if (!empty($filename)){
        
                    $handle = fopen($filename, "r");
                    
                    $i = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                    {
                        $idprov    =   trim($data[0]) ;
                        $nombre     = strtoupper(utf8_encode(trim($data[1])));
                        $tiempo   = strtoupper(utf8_encode(trim($data[2])));
                        $estado    = strtoupper(utf8_encode(trim($data[3])));
                        $dispositivo       = utf8_encode(trim($data[4]));
                         
                        
                        $fecha_matriz =  explode(" ",$tiempo);
                        
                        $fecha = $fecha_matriz[0] ;
                        $hora  = $fecha_matriz[1] ;
                      
                        //01/01/2022 8:06:02
                        $periodo =  explode("/",$fecha);
                        $mes     =  $periodo[1] ;
                        $anio    =  $periodo[2] ;
                        
                
                     
                        if ( $i > 0 ){
                            
             
                                $valida_prov = _busca_ciu($bd,$idprov);

                                $longitud = strlen($valida_prov);

                                 if ( $longitud > 9 ){
                                     
                                     

                                    guarda_tiempo($bd,$valida_prov ,
                                        $nombre,$tiempo,$estado,
                                        $dispositivo ,$fecha,$hora,
                                        $mes,$anio);
                                }
                         
                        }
                      
                        $i++;
                    
                          
                    }
                    
                  
                    
                    echo  ' registros: '.$i.' - '. $mes;
                    
                     fclose($handle);
                    
        }
    }
     
 //-----------------------------------
    function _busca_ciu($bd,$codigo){
     
    
        
              $AResultado = $bd->query_array(
                'par_ciu',
                'idprov',
                  'actividad='.$bd->sqlvalue_inyeccion(trim($codigo),true)
                );
            
            $dato = $AResultado['idprov'];
              
            return $dato;
        
        
    }
     
 //-----------------------
    function _borra_periodo($bd,$anio,$mes){
        
        
        $sql ='delete from nom_marcacion_temp 
               where estado =' .$bd->sqlvalue_inyeccion('N',true).' and 
                     mes ='.$bd->sqlvalue_inyeccion($mes,true).' and 
                     anio ='.$bd->sqlvalue_inyeccion($anio,true) ;


       $sql ='delete from nom_marcacion_temp 
               where estado =' .$bd->sqlvalue_inyeccion('N',true) ;                     
            
        $bd->ejecutar($sql);
      
    }
//---------------------
    function guarda_tiempo($bd,$idprov ,
                                    $nombre,$tiempo,$estado,
                                    $dispositivo,  $fecha,$hora,
                                    $mes,$anio){
                                    
     
        
        $longitud = strlen($idprov);
        
        if ( $longitud== 9){
            $cad_idprov  = '0'.trim($idprov);
        }else{
            $cad_idprov  = trim($idprov);
        }
           
        //26/07/2019 7:34:59
        $periodo =  explode("/",$fecha);
        $dia    =  $periodo[0] ;
        $mes     =  $periodo[1] ;
        $anio    =  $periodo[2] ;
        
        $fecha_dato =  $anio.'-'.$mes.'-'. $dia ;
     
        $InsertQuery = array(
            array( campo => 'identificacion',   valor => $cad_idprov),
            array( campo => 'nombre',   valor => $nombre ),
            array( campo => 'tiempo',   valor => $tiempo),
            array( campo => 'tipo',   valor => $estado),
            array( campo => 'estado',   valor => 'N'),
            array( campo => 'dispositivo',   valor => $dispositivo),
            array( campo => 'registro',      valor => $registro),
            array( campo => 'fecha',  valor => $fecha_dato),
            array( campo => 'hora',        valor => $hora),
            array( campo => 'sesion',        valor => 'migra'),
            array( campo => 'anio',   valor => $anio),
            array( campo => 'mes',      valor => $mes) 
        );
        
        
        if ( $longitud > 6 ){
 
            $bd->pideSq(0);
            $bd->JqueryInsertSQL('nom_marcacion_temp',$InsertQuery);
            
        }
            return 1;
        
    }
  
    
    
 
?>
  
  