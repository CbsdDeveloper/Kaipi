<?php session_start( );  ?>

<div style="padding-top: 5px;font-size: 12px;font-family: Arial, Calibri"> 

<h4>CARGAR IDENTIFICACION/CODIGO BIOMETRICO - PERSONAL</h4>
<p>
1.- DESCARGAR FORMATO DE PERSONAL PARA COLOCAR CODIGO BIOMETRICO <br>
identificacion,Nombre,Codigo Biometrico  <a href="../../reportes/excel_ciu" target="_blank">DESCARGAR AQUI</a> <br><br>
2.- IMPORTAR INFORMACION EN FORMATO csv separador , (coma) <br>

  <form action='ajax_importar_codigo.php' method='post' enctype="multipart/form-data">
 
   Importar Archivo : <input type='file' name='sel_file' size='800' accept=".csv">
     <input type='submit' name='submit' value='Cargar Informacion'>
     <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
     <input name="valida" type="hidden" value="S" /> 
     <p>
     
	</p>
  </form>
        </div>
<?php 
require '../../kconfig/Db.class.php';  
 
$bd	     =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

 if(isset($_POST['submit']))
{
     $fname                   = $_FILES['sel_file']['name'];
  
    
    echo 'Cargando nombre del archivo: '.$fname.' <br>';

 
        
        $filename = $_FILES['sel_file']['tmp_name'];
        
        if (!empty($filename)){
        
                    $handle = fopen($filename, "r");
                    
                    $i = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                    {
                        $idprov     =   trim($data[0]) ;
                        $nombre     =   strtoupper(utf8_encode(trim($data[1])));
                        $codigo     =   strtoupper(utf8_encode(trim($data[2])));
                      
                       
                     
                        if ( $i > 0 ){
                            
             
                                $valida = _busca_periodo($bd,$idprov);
                                
                                if ( $valida > 0 ){
                                      
                                    guarda_tiempo($bd,$idprov,$codigo);
                                }
                         
                        }
                       
                        $i++;
                    
                          
                    }
                   
                    
                    echo  ' registros: '.$i.' - '. $mes;
                    
                    //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
                    fclose($handle);
                    
        }
    }
    
 
//-----------------------------------
//-----------------------------------

function _busca_periodo($bd,$idprov){
     

     $longitud = strlen(trim($idprov));

     if (  $longitud  == 9 ){
            $idprov = '0'.trim($idprov);
     }
        
              $AResultado = $bd->query_array(
                'par_ciu',
                'count(*) as nn',
                  'idprov='.$bd->sqlvalue_inyeccion($idprov,true)
                );
            
            $dato = $AResultado['nn'];
              
            return $dato;
        
        
    }
     
 
//---------------------
    function guarda_tiempo($bd,$idprov,$codigo){
                                    
     
        
        $longitud = strlen($idprov);
        
        if ( $longitud== 9){
            $cad_idprov  = '0'.trim($idprov);
        }else{
            $cad_idprov  = trim($idprov);
        }
           
     $sql_existe = "update   par_ciu
            set actividad = ". $bd->sqlvalue_inyeccion($codigo ,true)."
            where idprov="    .$bd->sqlvalue_inyeccion($idprov ,true) ;

            $bd->ejecutar($sql_existe);
             
 
            return 1;
        
    }
      
   
 
?>