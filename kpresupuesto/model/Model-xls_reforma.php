<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';
require '../../kconfig/Set.php';

$bd	     =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 
?>
<form action='Model-xls_reforma.php' method='post' enctype="multipart/form-data">
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
 
	  <input type='submit' name='submit' value='Cargar'>  
      <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
      <input name="valida" type="hidden" value="S" /> 
	  
  </form>

<?php 
 
if(isset($_POST['submit']))
{
  
    $ruc        =  $_SESSION['ruc_registro'];
    $id_reforma =  $_SESSION['id_reforma'];
    
  
    
    //Aquí es donde seleccionamos nuestro csv
    $fname = $_FILES['sel_file']['name'];
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
    
    //----ruc;nombre;direccion;telefono;correo;modulo
    
        //si es correcto, entonces damos permisos de lectura para subir
        
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        
        $i = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            
            $programa    =   trim($data[0]) ;
            $grupo       =   trim($data[1]) ;
            $item        =   trim($data[2]) ;
            $id          =   trim($data[3]) ;
            
            $disponible          =  $data[6]  ;
            $aumento            =   $data[7]  ;
            $disminuye          =   $data[8]  ;
         
            if (empty($aumento)){
                $aumento = 0;
            }
            
            if (empty($disminuye)){
                $disminuye = 0;
            }
            
            if (empty($disponible)){
                $disponible = 0;
            }
            //$cantidad      = str_replace(',','.', $cantidad);
            
                
            $val1 = _busca_partida($bd,$id);
                     
            if ( $i > 0 ){
 
                if ( $val1 == '0' ) {
                    $resultado = ' ';
                }
                else {
                    
                    $valida = $aumento + $disminuye;
                    
                    if ( $valida > 0 ){
                        _guarda_partida($bd, $val1,$programa,$grupo,$item,$disponible,$aumento,$disminuye,$ruc,$id_reforma);
                    }
                    
                }
                
                
             }
             
             $i = 1 + $i;
         
        }
        
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        
        fclose($handle);
        
        echo "<h4><b>Importacion exitosa! Registros: ".$i.$resultado.' '.'</b></h4>';
       
    } 


 //-----------------------------------
    function _busca_partida($bd	,$id){
        
        
        $anio = $_SESSION['anio'];
 
        $partida_final = explode('-', $id);
        
        $partida = trim($partida_final[1])  ;
        
              $AResultado = $bd->query_array(
                'presupuesto.pre_gestion',
                'count(*) as nn',
                  'partida ='.$bd->sqlvalue_inyeccion($partida,true). ' and 
                      anio ='.$bd->sqlvalue_inyeccion($anio,true)
                );
            
            $dato = $AResultado['nn'];
            
            if ( $dato > 0 ){
                return $partida;
            }else{
                return '0';
            }
            
             
          
        
        
    }
    
 //-----------------------
      
    
//---------------------
    function _guarda_partida($bd, $partida,$programa,$grupo,$item,$disponible,$aumento,$disminuye,$ruc,$id_reforma){
        
  
        $sesion 	 =  trim($_SESSION['email']);
 
        
        $hoy 	     =  $bd->hoy();
        $anio        =  $_SESSION['anio'];
        
        $sql = "INSERT INTO presupuesto.pre_reforma_det (fsesion,id_reforma, registro, partida, tipo, saldo, aumento, sesion,
                                                          anio, disminuye)
										        VALUES (".$hoy.",".
										        $bd->sqlvalue_inyeccion($id_reforma, true).",".
										        $bd->sqlvalue_inyeccion($ruc, true).",".
										        $bd->sqlvalue_inyeccion($partida, true).",".
										        $bd->sqlvalue_inyeccion('G', true).",".
										        $bd->sqlvalue_inyeccion($disponible, true).",".
										        $bd->sqlvalue_inyeccion($aumento, true).",".
										        $bd->sqlvalue_inyeccion($sesion, true).",".
										        $bd->sqlvalue_inyeccion($anio, true).",".
										        $bd->sqlvalue_inyeccion($disminuye, true).")";
										        
 										        $bd->ejecutar($sql);
										        
      
         
    }
    
    
 
?>
  
  