<div style="padding-top: 5px;font-size: 14px;font-family: Arial, Calibri"> 
	
<h4>Importando archivo CSV</h4>
  <form action='sube.php' method='post' enctype="multipart/form-data">
  
  
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
   <input type='submit' name='submit' value='Cargar Informacion'>
    <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
     <input name="valida" type="hidden" value="S" /> 
     
  </form>
</div>
<?php 
session_start( );  
 

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
  /*Creamos la instancia del objeto. Ya estamos conectados*/



$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
		$ruc       =  $_SESSION['ruc_registro'];
		
		$sesion 	 =  trim($_SESSION['email']);
 		
		$hoy 	     =  date("Y-m-d");    	


if(isset($_POST['submit']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname = $_FILES['sel_file']['name'];
	
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
	
    $chk_ext = explode(".",$fname);
    
 
        
        $filename = $_FILES['sel_file']['tmp_name'];
        
        $handle = fopen($filename, "r");
        
        $i = 0;
        while (($Row = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            
			
							$anio 			= trim($Row[0]);
							$partida 		= trim($Row[1]);
							$partida 		= str_replace(".","",$partida );
							$cpc 			= trim($Row[2]);
							$tipo 			= strtoupper(trim($Row[3]));
							$regimen 		= strtoupper(trim($Row[17]));
							$detalle 		= strtoupper(trim($Row[4]));

							$cantidad 		= trim($Row[5]);
							$bid			= trim($Row[16]);
							$tipo_proyecto  = strtoupper(trim($Row[18]));
							$tipo_producto  = strtoupper(trim($Row[11]));
							$catalogo_e		= strtoupper(trim($Row[12]));
							$procedimiento  = strtoupper(trim($Row[13]));
							$medida			= strtoupper(trim($Row[6]));

							$costo 			= trim($Row[7]);
							$total			= $costo * $cantidad;
			
             
            
            if ( $i > 0 ){
                         
				$ATabla1 = array( array( campo  => 'referencia',    tipo  => 'NUMBER',id  => '0',add  => 'S',edit => 'S',valor =>  $i ,key  => 'N'),
										array( campo  => 'partida',       tipo  => 'VARCHAR2',id  => '1',add  => 'S',edit => 'S',valor => $partida ,key  => 'N'),
										array( campo  => 'cpc',           tipo  => 'VARCHAR2',id  => '2',add  => 'S',edit => 'S',valor => $cpc,key  => 'N'),
										array( campo  => 'tipo',          tipo  => 'VARCHAR2',id  => '3',add  => 'S',edit => 'S',valor =>$tipo,key  => 'N'),
										array( campo  => 'regimen',       tipo  => 'VARCHAR2',id  => '4',add  => 'S',edit => 'S',valor => $regimen,key  => 'N'),
										array( campo  => 'bid',           tipo  => 'VARCHAR2',id  => '5',add  => 'S',edit => 'S',valor => $bid,key  => 'N'),
										array( campo  => 'tipo_proyecto' ,tipo  => 'VARCHAR2',id  => '6',add  => 'S',edit => 'S',valor => $tipo_proyecto,key  => 'N'),
										array( campo  => 'tipo_producto', tipo  => 'VARCHAR2',id  => '7',add  => 'S',edit => 'S',valor => $tipo_producto,key  => 'N'),
										array( campo  => 'catalogo_e',    tipo  => 'VARCHAR2',id  => '8',add  => 'S',edit => 'S',valor => $catalogo_e,key  => 'N'),
										array( campo  => 'procedimiento', tipo  => 'VARCHAR2',id  => '9',add  => 'S',edit => 'S',valor => $procedimiento,key  => 'N'),
										array( campo  => 'detalle',       tipo  => 'VARCHAR2',id  => '10',add  => 'S',edit => 'S',valor => $detalle ,key  => 'N'),
										array( campo  => 'cantidad',      tipo  => 'NUMBER',id  => '11',  add  => 'S',edit => 'S',valor => $cantidad,key  => 'N'),
										array( campo  => 'medida',        tipo  => 'VARCHAR2',id  => '12',add  => 'S',edit => 'S',valor => $medida,key  => 'N'),
										array( campo  => 'costo',          tipo  => 'NUMBER',id  => '13',add  => 'S',edit => 'S',valor => $costo,key  => 'N'),
										array( campo  => 'total',          tipo  => 'NUMBER',id  => '14',add  => 'S',edit => 'S',valor => $total	,key  => 'N'),
										array( campo  => 'periodo',        tipo  => 'VARCHAR2',id  => '15',add  => 'S',edit => 'S',valor => 'S',key  => 'N'),
										array( campo  => 'estado',         tipo  => 'VARCHAR2',id  => '16',add  => 'S',edit => 'S',valor => 'S',key  => 'N'),
										array( campo  => 'sesion',         tipo  => 'VARCHAR2',id  => '17',add  => 'S',edit => 'S',valor => $sesion ,key  => 'N'),
										array( campo  => 'fecha',          tipo  => 'DATE',id  => '18',   add  => 'S',edit => 'S',valor =>$hoy ,key  => 'N'),
										array( campo  => 'fecha_ejecuta',  tipo  => 'DATE',id  => '19',   add  => 'S',edit => 'S',valor => $hoy,key  => 'N'),
										array( campo  => 'fecha_final',    tipo  => 'DATE',id  => '20',   add  => 'N',edit => 'S',valor => '-',key  => 'N'),
										array( campo  => 'id_departamento',tipo  => 'NUMBER',id  => '21', add  => 'S',edit => 'S',valor => '0',key  => 'N'),
										array( campo  => 'id_pac',         tipo  => 'NUMBER',id  => '22',add  => 'N',edit => 'N',valor => '-',key  => 'S'),
										array( campo  => 'programa',       tipo  => 'VARCHAR2',id  => '23',add  => 'N',edit => 'S',valor => '-',key  => 'N'),
										array( campo  => 'clasificador',   tipo  => 'VARCHAR2',id  => '24',add  => 'N',edit => 'S',valor => '-',key  => 'N'),
										array( campo  => 'anio',           tipo  => 'VARCHAR2',id  => '25',add  => 'S',edit => 'N',valor => $anio,key  => 'N'),
										array( campo  => 'partida_fin',    tipo  => 'VARCHAR2',id  => '26',add  => 'N',edit => 'N',valor => '-',key  => 'N'),
										array( campo  => 'avance',         tipo  => 'NUMBER',id  => '27',add  => 'N',edit => 'S',valor => '-',key  => 'N')

							 ); 

							$tabla 	  		    = 'adm.adm_pac';
							$secuencia 	        = 'adm.adm_pac_id_pac_seq';

							$bd->_InsertSQL($tabla,$ATabla1,$secuencia);
 
              }
              
              $i = 1 + $i;
                   
        }
        
        
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);
        echo "Importacion exitosa! Registros: ".$i.' '.$valida_total;
        
    }
     
 //-----------------------------------
    function _busca_producto($bd	,$id, $ruc_registro){
     
        
           
        $AResultado = $bd->query_array(
            'web_producto',
            'idproducto',
            'producto='.$bd->sqlvalue_inyeccion(trim($id),true). ' and
                 registro ='.$bd->sqlvalue_inyeccion(trim($ruc_registro),true)
            );
        
        $dato = $AResultado['idproducto'];
            
             
            return $dato;
        
        
    }
    //----------------------------
    
    
    
 
?>
  
  