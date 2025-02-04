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
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    
    //---------------------------------------------------------
    public function BusquedaDoc( $id){
        
        $qquery = array(
            array( campo => 'id_nom_doc',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codigo',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'modulo',valor => 'garantias',filtro => 'N', visor => 'S')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('pdoc.doc_modulo',$qquery );
        
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Fecha </th>
                <th> Detalle </th>
                <th> Sesion </th>
                <th> Acciones</th></thead> </tr>';
        
        // carpeta virtual -------------------------------
        //-----------------------------------------------
        $folder = $this->bd->_carpeta_archivo(5,1);
        //-----------------------------------------------
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_nom_doc'] ;
            
            $archivo = $folder.trim($fetch['archivo']);
            
            $boton1 = '';
            
            if ( $this->sesion  == trim($fetch['sesion'] )){
                
                $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLDocdel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
                
            }
            
            
            $boton2 = '<button class="btn btn-xs"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="javascript:PoneDoc('. "'" .$archivo ."'". ')">
                           <i class="glyphicon glyphicon-search"></i></button>&nbsp;&nbsp;&nbsp;';
            
            echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['detalle'].'</td>';
            echo ' <td>'.$fetch['sesion'].'</td>';
            echo ' <td>'.$boton2.$boton1.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
        
     }
    //-------------
     function ElimanaDoc( $id, $idcaso ){
        //inicializamos la clase para conectarnos a la bd
        
         
 
        $sql = "DELETE  FROM pdoc.doc_modulo
                 where id_nom_doc = ".$this->bd->sqlvalue_inyeccion($id,true);
        
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
if (isset($_GET["id"]))	{
    
    
    $id 				=     $_GET["id"];
    
    
    
    $gestion->BusquedaDoc(   trim($id)  );
    
    
}

//------ grud de datos insercion
if (isset($_GET["idcodigo"]))	{
    
    
    $id 				=     $_GET["idcodigo"];
    
    $idcaso 			=     $_GET["idcaso"];
    
    $gestion->ElimanaDoc(    $id ,  $idcaso);
    

    
}




?>
 
  