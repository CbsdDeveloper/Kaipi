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
    private $datos;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    
    //---------------------------------------------------------
    public function BusquedaDoc(   $idcaso){
        
       
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
         
        $qquery = array(
            array( campo => 'id_proc_doc',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idcaso',valor => $idcaso,filtro => 'S', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'inicio',valor => 'S',filtro => 'S', visor => 'S'),
            array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $resultado_doc = $this->bd->JqueryCursorVisor('flow.proceso_doc',$qquery );
        
        echo '<table id="jsontableDocUserVisor" style="font-size: 10px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%"> ';
        
         
        while ($fetch_doc=$this->bd->obtener_fila($resultado_doc)){
            
               $idproducto =  $fetch_doc['id_proc_doc'] ;
            
         
                $boton1 = '<button class="btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocdelvi('.$idproducto.","."'".$idcaso."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
          
            echo ' <tr>';
            echo ' <td>'.$fetch_doc['detalle'].'</td>';
            echo ' <td>'.$boton1.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado_doc);
        
    }
    //-------------
    function ElimanaDoc( $id, $idcaso ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql = "DELETE  FROM flow.proceso_doc
                 where id_proc_doc = ".$this->bd->sqlvalue_inyeccion($id,true);
        
        $this->bd->ejecutar($sql);
        
        
        $this->BusquedaDoc( $idcaso);
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;
 
    
//------ grud de datos insercion
if (isset($_GET["accion"]))	{
    
    $accion             =     $_GET["accion"];
    
    $id 				=     $_GET["idcodigo"];
    
    $idcaso 			=     $_GET["idcaso"];
    
    if ( $accion == 'del' ){  

        $gestion->ElimanaDoc(    $id  ,  $idcaso);

    }
    else{ 

        $gestion->BusquedaDoc(  $idcaso );

    }
    
    
 
 
}




?>
 
  