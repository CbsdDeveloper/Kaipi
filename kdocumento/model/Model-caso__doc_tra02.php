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
    public function BusquedaDoc( $idcaso){
 
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';


        $qquery = array(
            array( campo => 'idcasodoc',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idcaso',valor => trim($idcaso),filtro => 'S', visor => 'S'),
            array( campo => 'asunto',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'envia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'de',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipodoc',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('flow.wk_proceso_casodoc',$qquery  );
         
        echo '<table id="jsontable_Doc" style="font-size: 10px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
        <thead> <tr>
              <th width="10%" '. $estilo. '> Fecha </th>
              <th width="25%" '. $estilo. '> Documento </th>
              <th width="30%" '. $estilo. '> Asunto </th>
              <th width="15%" '. $estilo. '> Creado </th>
              <th width="20%" '. $estilo. '> Acciones</th></thead> </tr>';
      
           
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
          
            $idproducto =  $fetch['idcasodoc'] ;
            $sesion     =  trim($fetch['sesion']) ;
              
            $boton1 = ' ';
            $boton2 = ' ';
            $boton3 = ' ';
            $boton4 = ' ';

            $AexisteDe           =  $this->bd->__user( $sesion );
            $unidad0             =  $AexisteDe['id_departamento'];
            
            $AexisteDe           =  $this->bd->__user( $this->sesion );
            $unidad1             =  $AexisteDe['id_departamento'];
            $responsable         =  $AexisteDe['responsable'];
            
            $bandera = 0;

            if ( $unidad0 == $unidad1) {
                $bandera = 1;
            }

  
             
            if ( $this->sesion == $sesion) {
                 
                if ( $fetch['envia']  == 0 ){

                        $boton1 = '<button class="btn btn-xs btn-info"
                                      title="Editar Registro"
                                      onClick="openFileedit('.$idproducto.","."'../view/cli_editor_caso_seg',1350,620".')">
                                      <i class="glyphicon glyphicon-edit"></i></button>
                                     <button class="btn btn-xs btn-danger"
                                      title="Eliminar Registro"
                                      onClick="goToURLDocdelUser('.$idproducto.","."'".$idcaso."'".')">
                                     <i class="glyphicon glyphicon-remove"></i></button>';

                      $boton1 = '<button class="btn btn-xs btn-danger"
                                     title="Eliminar Registro"
                                     onClick="goToURLDocdelUser('.$idproducto.","."'".$idcaso."'".')">
                                    <i class="glyphicon glyphicon-remove"></i></button>';                                     
                        
                        $boton4 = '';
                        
                        $boton3 = '&nbsp;<button class="btn btn-xs btn-danger"
                              title="Bloquear y generar Documento"
                              onClick="goToURLDocBloqueaUser('.$idproducto.","."'".$idcaso."'".')">
                             <i class="fa fa-unlock"></i></button>&nbsp;';
                }else{
                    
                    $boton3 = '&nbsp;<button class="btn btn-xs btn-success"
                              title="Documento Generado">
                             <i class="fa fa-lock"></i></button>&nbsp;';
                    
                    $evento1 = ' onClick="formato_doc_firmado('.$idproducto.');" ';
                    
                    $boton4 = '&nbsp;<button '.$evento1.' class="btn btn-xs btn-warning"
                              title="Descargar Documento Firmado">
                             <i class="glyphicon glyphicon-download-alt"></i></button>&nbsp;';
                }
              
                
                $evento1 = ' onClick="formato_doc_visor('.$idproducto.');" ';
                
                $boton2 = '<button  '.$evento1.'  class="btn btn-xs btn-primary">
                                     <i class="glyphicon glyphicon-download-alt"></i>
                                </button>&nbsp;';
                                $boton2 ='';
                                                 
            }
            
             
 
                
                if ( $responsable == 'S'){

                    if ( $fetch['envia']  == 0 ){
                            $boton1 = '
                                    <button class="btn btn-xs btn-danger"
                                          title="Eliminar Registro"
                                          onClick="goToURLDocdelUser('.$idproducto.","."'".$idcaso."'".')">
                                         <i class="glyphicon glyphicon-remove"></i></button>';
                            
                            $boton4 = '';
                            
                            $boton3 = '&nbsp;<button class="btn btn-xs btn-danger"
                                  title="Bloquear y generar Documento"
                                  onClick="goToURLDocBloqueaUser('.$idproducto.","."'".$idcaso."'".')">
                                 <i class="fa fa-unlock"></i></button>&nbsp;';
                            
                    }else{
                        
                        $boton3 = '&nbsp;<button class="btn btn-xs btn-success"
                                  title="Documento Generado">
                                 <i class="fa fa-lock"></i></button>&nbsp;';
                        
                        $evento1 = ' onClick="formato_doc_firmado('.$idproducto.');" ';
                        
                        $boton4 = '&nbsp;<button '.$evento1.' class="btn btn-xs btn-primary"
                                  title="Descargar Documento Firmado">
                                 <i class="glyphicon glyphicon-download-alt"></i></button>&nbsp;';
                        
                     }
       
                
                $evento1 = ' onClick="formato_doc_visor('.$idproducto.');" ';
                
                $boton2 = '<button  '.$evento1.'  class="btn btn-xs btn-primary">
                                     <i class="glyphicon glyphicon-search"></i>
                                </button>';

                                $boton2 ='';
                           
              }
            
        
            
            echo ' <tr>';
            
            if ( $bandera == 1) {

                echo ' <td>'.$fetch['fecha'].'</td>';
                echo ' <td>'.trim($fetch['documento']).'</td>';
                echo ' <td>'.trim($fetch['asunto']).'</td>';
                echo ' <td>'.trim($fetch['sesion']).'</td>';
                echo ' <td>'.$boton2.$boton3.$boton1.$boton4.'</td>';



            }
          
            
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
 
  