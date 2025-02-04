<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $anio;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------

    function proceso( ){
        
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->anio       =  $_SESSION['anio'];
        
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($tipo,$tiddepartamento1,$estado1,$anio1 ){
        
       
        $filtro1 = 'S';
        $filtro2 = 'S';
          
        if ( $tiddepartamento1 == '0'){
            $filtro1 = 'N';
        }
        
        if ( $estado1 == '-'){
            $filtro2 = 'N';
        }
 
        $qquery = array(
            array( campo => 'idcontrato',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'nro_contrato',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle_contrato',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo_contratacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'monto_contrato',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha_inicio',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha_fin',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'dias_vigencia',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'anio_inio',   valor => $anio1 ,  filtro => 'S',   visor => 'S'),
            array( campo => 'dias_falta',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'tipo_contratacion',   valor => $tipo ,             filtro => 'S',   visor => 'N'),
            array( campo => 'estado',               valor => $estado1 ,          filtro => $filtro2,   visor => 'N'),
            array( campo => 'iddepartamento',       valor => $tiddepartamento1,  filtro => $filtro1,   visor => 'N') 
         );
      
         
        
        $resultado = $this->bd->JqueryCursorVisor('garantias.contratos_garantia',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
 
  
            $output[] = array ( 
                $fetch['idcontrato'],
                $fetch['razon'],
                $fetch['nro_contrato'] ,
                $fetch['detalle_contrato'],
                $fetch['fecha_inicio'] ,
                $fetch['fecha_fin'] ,
                $fetch['dias_vigencia'] ,
                $fetch['dias_falta']
                
            );
        }
        
        echo json_encode($output);
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ consulta grilla de informacion

if (isset($_GET['tipo1']))	{
    
    $tipo              = $_GET['tipo1'];
    $tiddepartamento1  = $_GET['tiddepartamento1'];
    $estado1           = $_GET['estado1'];
    $anio1             = $_GET['anio1'];
     
    $gestion->BusquedaGrilla($tipo,$tiddepartamento1,$estado1,$anio1 );
    
}

?>