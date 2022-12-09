<?php
session_start();
require '../../kconfig/Db.class.php';   
require '../../kconfig/Obj.conf.php'; 

/*Incluimos el fichero de la clase Db*/

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
    public function BusquedaDoc( $idcaso){
 
        
        $qquery = array(
            array( campo => 'idcaso',valor => trim($idcaso),filtro => 'S', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S')
           );
        
        $resultado = $this->bd->JqueryCursorVisor('flow.view_archivo',$qquery );
        
 
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';


        echo '<table id="jsontable_Doc" style="font-size: 12px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th  width="20%" '. $estilo. '> Fecha </th>
                <th  width="70%" '. $estilo. '> Documento </th>
                <th  width="10%" '. $estilo. '> Acciones</th>
                </thead> </tr>';
        
        
        $url =  $this->bd->_carpeta_archivo('4',1); // path archivos
 
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
 
 
                    $archivo = $url.trim($fetch['archivo']);

                    $evento1 = ' onClick="formato_doc_visor('."'".$archivo."'" .');" ';
                    
                    $boton2 = '<button  '.$evento1.'  class="btn btn-xs btn-success">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>&nbsp;';
            
             
            
            echo ' <tr>';
            
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['detalle'].'</td>';
            echo ' <td>'.$boton2.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
    }
  
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;
 
    
 
     $idcaso 			=     $_GET["idcaso"];
    
     $gestion->BusquedaDoc(  $idcaso );
   
 



?>
 
  