<?php 
session_start( );   

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
  /*Creamos la instancia del objeto. Ya estamos conectados*/

$bd	   =	new Db ;
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
            
            $ruc       = utf8_encode(trim('0'));
            $nombre    = strtoupper ( (trim($_GET['text'])));
            $direccion = strtoupper ( (trim('S/N')));
            $telefono  = utf8_encode(trim($_GET['phone']));
            $correo    = utf8_encode(trim($_GET['email']));
            $movil     = utf8_encode(trim($_GET['phone']));
            $zona      = utf8_encode(trim('QUITO'));

             
            $val1 = _busca_ruc($bd,$ruc);
            
            $val2 = _busca_email($bd,$correo);
            
            $val3 = _busca_nombre($bd,$nombre);
            
            $val4 = _busca_telefono($bd,$telefono);
            
         //   $valida_total = $val1 + $val2 + $val3 + $val4;
            
            $valida_total =   $val3 ;
            
      
            if ($valida_total  == '0' ) {
                    
                if ( strlen($nombre) > 5  ) {
                        _guarda_cliente($bd	, $ruc,$nombre,$direccion,$telefono,$correo,$movil,$zona);
                 }
              }
       
              $output =  "Importacion exitosa! ";
      
        
 
     
 //-----------------------------------
   function _busca_telefono($bd	,$id){
        
        
        $longi = strlen(trim($id));
        
        if ( $longi > 5) {
            
            $AResultado = $bd->query_array(
                'ven_cliente',
                'count(*) as nn',
                'movil='.$bd->sqlvalue_inyeccion(trim($id),true)
                );
            
            return  $AResultado['nn'];
        }
        else {
            
            return  0;
            
        }
        
    }
    //-----------------------------------
    function _busca_ruc($bd	,$id){
        
        
        $longi = strlen(trim($id));
        
        if ( $longi > 5) {
            
            $AResultado = $bd->query_array(
                'ven_cliente',
                'count(*) as nn',
                'idprov='.$bd->sqlvalue_inyeccion(trim($id),true)
                );
            
            return  $AResultado['nn'];
        }
        else {
            
            return  0;
            
        }
        
    }
    //----------------------------
    function _busca_email($bd	,$id){
        
        $longi = strlen(trim($id));
        
        if ( $longi > 5) {
            
            $AResultado = $bd->query_array(
                'ven_cliente',
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
            'ven_cliente',
            'count(*) as nn',
            'razon='.$bd->sqlvalue_inyeccion(trim($id),true)
            );
        
        return  $AResultado['nn'];
        
    }
//---------------------
    function _guarda_cliente($bd	,$ruc,$nombre,$direccion,$telefono,$correo,$movil,$zona){
        
        
        $tabla 	  	  = 'ven_cliente';
        $sesion 	 =  $_SESSION['email'];
         
        $ATabla = array(
            array( campo => 'idvencliente',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => trim($ruc), key => 'N'),
            array( campo => 'razon',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => trim($nombre), key => 'N'),
            array( campo => 'direccion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $direccion, key => 'N'),
            array( campo => 'telefono',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $telefono, key => 'N'),
            array( campo => 'correo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => trim($correo), key => 'N'),
            array( campo => 'web',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => 'www', key => 'N'),
            array( campo => 'movil',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => trim($movil), key => 'N'),
            array( campo => 'contacto',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => trim($nombre), key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'canton',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'N', valor => $zona, key => 'N'),
            array( campo => 'id_campana',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'medio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => 'Redes Sociales', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $sesion, key => 'N')
            
        );
        
        
         $bd->_InsertSQL($tabla,$ATabla,'ven_cliente_idvencliente_seq');
        
    }
?>
  
  