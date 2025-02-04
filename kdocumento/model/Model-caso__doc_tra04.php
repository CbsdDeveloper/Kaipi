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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    
    //---------------------------------------------------------
    public function BusquedaDoc( $idcaso){
 
        
        $qquery = array(
            array( campo => 'idcasodoc',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idcaso',valor    => $idcaso,filtro => 'S', visor => 'S'),
            array( campo => 'asunto',valor    => '-',filtro => 'N', visor => 'S'),
            array( campo => 'envia',valor     => '0',filtro => 'S', visor => 'S'),
            array( campo => 'sesion',valor    => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor     => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipodoc',valor   => '-',filtro => 'N', visor => 'S'),
            array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('flow.wk_proceso_casodoc',$qquery );
        
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';


        echo '<table id="jsontable_Doc" style="font-size: 10px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th  width="10%" '. $estilo. '> Fecha </th>
                <th  width="30%" '. $estilo. '> Documento </th>
                <th  width="50%" '. $estilo. '> Asunto </th>
                <th  width="10%" '. $estilo. '> Acciones</th>
                </thead> </tr>';
        
        
        $url =  $this->bd->_carpeta_archivo('4',1); // path archivos


        $usuario_solicita = $this->bd->__user($this->sesion );


        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['idcasodoc'] ;
            
            $sesion =  trim($fetch['sesion']) ;
            
            $boton1 = ' ';
            $boton2 = ' ';
            $boton3 = ' ';
            $boton4 = ' ';
            
            
            if ( trim($this->sesion) == trim($sesion)) {
         
                if ( $fetch['envia']  == 0 ){
                    
                   $boton1 = '<button class="btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocdelUser('.$idproducto.","."'".$idcaso."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
                   
                }  
 
            }

            if ( $usuario_solicita['responsable'] == 'S') {
         
                if ( $fetch['envia']  == 0 ){
                    
                   $boton1 = '<button class="btn btn-xs btn-danger"
                              title="EDITAR DOCUMENTO"
                              onClick="goToURLDocEditar('.$idproducto.","."'".$idcaso."'".')">
                             <i class="glyphicon glyphicon-pencil"></i></button>&nbsp;';
                   
                }  
 
            }

            if ( $fetch['envia']  == 1 ){
            
                    $archivo = $url.trim($fetch['documento']).'.pdf';

                    $evento1 = ' onClick="formato_doc_visor('."'".$archivo."'" .');" ';
                    
                    $boton2 = '<button  '.$evento1.'  class="btn btn-xs btn-success">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>&nbsp;';
            
              }
      
            
            echo ' <tr>';
            
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['documento'].'</td>';
            echo ' <td>'.$fetch['asunto'].'</td>';
            echo ' <td>'.$boton2.$boton3.$boton1.$boton4.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
    }
    //-------------
    function ElimanaDoc( $id, $idcaso ){
        //inicializamos la clase para conectarnos a la bd
        
        $Aexiste = $this->bd->query_array('flow.wk_proceso_casodoc',
            '*',
            'idcaso       ='.$this->bd->sqlvalue_inyeccion($idcaso,true).' and
                                 idcasodoc='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        if ($Aexiste["envia"] == 0 ){
                $sql = "DELETE  FROM flow.wk_proceso_casodoc
                         where idcasodoc = ".$this->bd->sqlvalue_inyeccion($id,true);
                
                $this->bd->ejecutar($sql);
                
                
                $this->BusquedaDoc( $idcaso);
        }
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
 
  