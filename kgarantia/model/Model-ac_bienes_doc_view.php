<?php
session_start( );

require '../../kconfig/Db.class.php';

require '../../kconfig/Obj.conf.php'; 


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
    function eliminar_doc( $id,$id_bien_grafico ){
        
        
  
 
        
        $sql = "delete from  activo.ac_bienes_imagen 
                 where id_bien_grafico =". $this->bd->sqlvalue_inyeccion($id_bien_grafico, true);

            
            $this->bd->ejecutar($sql);
            
            
            
            $this->BusquedaDoc( $id ) ;
            
    }
    //---------------------------------------------------------
    public function BusquedaDoc( $id){
        
        
        
        $qquery = array(
            array( campo => 'id_bien_grafico',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_bien',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'creacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('activo.ac_bienes_imagen',$qquery );
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Fecha </th>
                <th> Detalle Documento </th>
                <th> Sesion </th>
                <th> Tipo Archivo </th>
                <th> Acciones</th></thead> </tr>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_bien_grafico'] ;
            
            
            $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLDocdel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
            $boton2 = '<button class="btn btn-xs"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="javascript:PoneDoc('. "'" .trim($fetch['archivo']) ."'". ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
            
            echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['creacion'].'</td>';
            echo ' <td>'.$fetch['detalle'].'</td>';
            echo ' <td>'.$fetch['sesion'].'</td>';
            echo ' <td>'.$fetch['tipo'].'</td>';
            echo ' <td>'.$boton2.$boton1.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
    //---------------
   
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

if (isset($_GET["accion"]))	{
    
    $accion 			=     $_GET["accion"];
    
    $id 				=     $_GET["id"];
    
    if ( $accion == 'visor'){
        
        $gestion->BusquedaDoc( $id  );
        
    }
    
    if ( $accion == 'del'){
        
        $id_bien_grafico 				=     $_GET["id_bien_grafico"];
        
        $gestion->eliminar_doc( $id,$id_bien_grafico  );
        
    }
    
    
    
    
    
}


?>
 
  