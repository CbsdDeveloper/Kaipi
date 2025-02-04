<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $datos;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    function archivo_xml($archivo , $id){
        
        
        $filename = '../../archivos/'. $archivo ;
        
        
        if ( trim($archivo)  <> 'error') {
            
            $handle = fopen($filename, "r");
            
            $i = 0;
            
            //ITEM	CANT	CODIGO	DETALLE	PARTIDA	Factor	FactorSalvaguardia	FOB
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
            {
                
                
                $producto     = strtoupper(utf8_encode(trim($data[1])));
                
                $referencia   = strtoupper(utf8_encode(trim($data[2])));
                
                $detalle   = strtoupper(utf8_encode(trim($data[3])));
                
                $partida   = strtoupper(utf8_encode(trim($data[4])));
                
                $c1     =  (trim($data[5]));
                $c2     =  (trim($data[6]));
                $c3     =  (trim($data[7]));
                
                $factor      = str_replace(',','.', $c1);
                $salva         = str_replace(',','.', $c2);
                $fob         = str_replace(',','.', $c3);
                
                if ( $i > 0 ) {
                    if (!empty($detalle)){
                        $this->nuevo($producto,$referencia,$detalle,$partida,$factor,$salva,$fob);
                    }
                }
                
                
                $i++;
            }
            
        }
        $procesado = 'Procesado '.$i;
        
        echo $procesado;
        
        
    }
    //--------------------------------------------------------
    function nuevo($producto,$referencia,$detalle,$partida,$factor,$salva,$fob){
        
        //---------------------------------------------------
        $id =  $this->secuencia();
        
        $ATabla = array(
            array( campo => 'item',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'S',   valor => $id,   filtro => 'N',   key => 'N'),
            array( campo => 'marca',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor =>$producto, key => 'N'),
            array( campo => 'codigo',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $referencia, key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $detalle, key => 'N'),
            array( campo => 'partida',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $partida, key => 'N'),
            array( campo => 'factor',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor =>$factor, key => 'N'),
            array( campo => 'salvaguardia',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => $salva, key => 'N'),
            array( campo => 'fob',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => $fob, key => 'N'),
        );
        
        $a = $this->existe_asiento($producto,$referencia ) ;
        
        if (     $a == 0 ){
            
            if ( $id > 0 ) {
                $this->bd->_InsertSQL('temp_cotiza',$ATabla, 'NO' );
            }
        }
        
    }
    //---------------------------------------------------------
    function existe_asiento($producto,$referencia ){
        
        
        
        $Aprove = $this->bd->query_array('temp_cotiza',
            'count(*) as nn',
            'marca='.$this->bd->sqlvalue_inyeccion(trim($producto),true).' and
             codigo='.$this->bd->sqlvalue_inyeccion(trim($referencia),true)
            );
        
        
        if ( $Aprove['nn'] == 0 ) {
            return 0;
        }else {
            return 1;
        }
        
    }
    
    //---------------------------------------------------------
    function secuencia(){
        
        
        
        $Aprove = $this->bd->query_array('temp_cotiza',
            'count(*) as nn',
            '1='.$this->bd->sqlvalue_inyeccion(1,true)
            );
        
        
        if ( $Aprove['nn'] == 0 ) {
            return 1;
        }else {
            return  $Aprove['nn']  + 1;
        }
        
    }
    //---------------------------------------------------------
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ grud de datos insercion
if (isset($_GET["archivo"]))	{
    
    
    $archivo =     $_GET["archivo"];
    
    $id 	 =     $_GET["id"];
    
    
    
    $gestion->archivo_xml( $archivo ,$id);
    
    
    
}



?>