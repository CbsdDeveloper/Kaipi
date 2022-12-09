<h4>Importando archivo CSV</h4>
  <form action='moduloxlsCliente.php' method='post' enctype="multipart/form-data">
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
   <input type='submit' name='submit' value='Cargar Informacion'>
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


if(isset($_POST['submit']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname = $_FILES['sel_file']['name'];
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
    //$chk_ext = explode(".",$fname);
    
    //----ruc;nombre;direccion;telefono;correo;modulo
    
        //si es correcto, entonces damos permisos de lectura para subir
        
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        
        $i = 0;
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            $ruc       =   trim($data[0]) ;
            $nombre    = strtoupper(utf8_encode(trim($data[1])));
            $direccion = strtoupper(utf8_encode(trim($data[2])));
            $telefono  = utf8_encode(trim($data[3]));
            $correo    = utf8_encode(trim($data[4]));
            $modulo     = strtoupper(utf8_encode(trim($data[5])));
           
            $id =  trim($ruc);
            
            if (strlen(trim($ruc)) == 9){
                $id = '0'.$ruc;
            }
            if (strlen(trim($ruc)) == 12){
                $id = '0'.$ruc;
            }
            
            $longo = strlen($id) ;
               
            $val1 = _busca_ruc($bd,$id);
              
            //$val3 = _busca_nombre($bd,$nombre);
            
         
            if ( $longo <= 13)   {
                    if ( $i > 0 ){
         
                        if ( $val1  ==  0 ) {
                            
                         $id =  trim($ruc);
                         
                         if (strlen(trim($ruc)) == 9){
                             $id = '0'.$ruc;
                         }
                         if (strlen(trim($ruc)) == 12){
                             $id = '0'.$ruc;
                         }
                           
                         _guarda_cliente($bd	, trim($id),trim($nombre),trim($direccion),$telefono,trim($correo),trim($modulo));
                            
                        }
                     }
            }
             $i = 1 + $i;
        }
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);
        echo "Importacion exitosa! Registros: ".$i;
        
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
    function _busca_email($bd	,$id){
        
        $longi = strlen(trim($id));
        
        if ( $longi > 5) {
            
            $AResultado = $bd->query_array(
                'par_ciu',
                'count(*) as nn',
                'correo='.$bd->sqlvalue_inyeccion(trim($id),true)
                );
            
            return  $AResultado['nn'];
        }
        else {
            
            return  0;
            
        }
        
    }
 //-----------------------
    function _busca_nombre($bd	,$id){
        
        $AResultado = $bd->query_array(
            'par_ciu',
            'count(*) as nn',
            'razon='.$bd->sqlvalue_inyeccion(trim($id),true)
            );
        
        return  $AResultado['nn'];
        
    }
//---------------------
    function _guarda_cliente($bd, $ruc,$nombre,$direccion,$telefono,$correo,$modulo){
        
        
        $tabla 	  	 = 'par_ciu';
        $sesion 	 =  $_SESSION['email'];
        $hoy 	     =  date("Y-m-d");
         
        $AResultado = $bd->query_array(
            'par_ciu',
            'count(*) as nn',
            'idprov='.$bd->sqlvalue_inyeccion(trim($ruc),true)
            );
        
        $dato = $AResultado['nn'];
        
        $contanto = substr($nombre, 0,80);
        
        $nombre = substr($nombre, 0,120);
        
        $ATabla = array(
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $ruc,   filtro => 'N',   key => 'S'),
            array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor => $nombre,   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => 'E',   filtro => 'N',   key => 'N'),
            array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $direccion,   filtro => 'N',   key => 'N'),
            array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $telefono,   filtro => 'N',   key => 'N'),
            array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => $correo,   filtro => 'N',   key => 'N'),
            array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => $telefono,   filtro => 'N',   key => 'N'),
            array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '18',   filtro => 'N',   key => 'N'),
            array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => $contanto,   filtro => 'N',   key => 'N'),
            array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor =>$telefono,   filtro => 'N',   key => 'N'),
            array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => $correo,   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '01',   filtro => 'N',   key => 'N'),
            array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor =>$modulo,   filtro => 'N',   key => 'N'),
            array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'NN',   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor => $hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'S',   edit => 'S',   valor => $hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
            array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => $telefono,   filtro => 'N',   key => 'N')
        );
        
        if ($dato == 0 ){
            $bd->_InsertSQL($tabla,$ATabla,$ruc);
        }
 
        
    }
    
    
 
?>
  
  