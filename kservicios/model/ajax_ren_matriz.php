<?php
session_start( );

 
require '../../kconfig/Db.class.php';  // Clase para conexion y funciones

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
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    
    //---------------------------------------------------------
    public function BusquedaDoc( $id_rubro){
        
 
        $qquery = array(
            array( campo => 'id_rubro_matriz',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_rubro',valor => $id_rubro,filtro => 'S', visor => 'S'),
            array( campo => 'producto',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idproducto_ser',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'modulo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tributo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'msesion',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_matriz_rubro',$qquery );
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Codigo </th>
                <th> Detalle </th>
                <th> Modulo </th>
                <th> Estado </th>
                <th> Tributo </th>
                <th> Costo </th>
                <th> Sesion </th>
                <th> Acciones</th></thead> </tr>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_rubro_matriz'] ;
            
            
            $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLDocdel('.$idproducto.')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
       
            $boton2 = '<button class="btn btn-xs"
                            data-toggle="modal"
                            data-target="#myModalServicios"
                            title="Editar enlace"
                            onClick="javascript:PoneDoc(' .$idproducto . ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
            
            echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['idproducto_ser'].'</td>';
            echo ' <td>'.$fetch['producto'].'</td>';
            echo ' <td>'.$fetch['modulo'].'</td>';
            echo ' <td>'.$fetch['estado'].'</td>';
            echo ' <td>'.$fetch['tributo'].'</td>';
            echo ' <td>'.$fetch['costo'].'</td>';
            echo ' <td>'.$fetch['msesion'].'</td>';
            echo ' <td>'.$boton2.$boton1.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
    //-------------
    function elimina_dato(  $id , $id_rubro_matriz){
     
        

        $x_tramite = $this->bd->query_array('rentas.view_emision',   // TABLA
        'count(*) as nn',                        // CAMPOS
        'id_rubro_matriz='.$this->bd->sqlvalue_inyeccion($id_rubro_matriz,true)  . ' and  
        id_rubro='.$this->bd->sqlvalue_inyeccion($id,true)
        );

       
      if (       $x_tramite['nn'] > 0  ) {

       }else {

            $sql = "DELETE  FROM rentas.ren_rubros_matriz
                    where id_rubro_matriz = ".$this->bd->sqlvalue_inyeccion($id_rubro_matriz,true);
            
            $this->bd->ejecutar($sql);
        
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
    
    $accion 			=     $_GET["accion"];
    $id 				=     $_GET["id"];
    
    if ( $accion == 'visor'){
        
        $gestion->BusquedaDoc(   trim($id)  );
        
    }
  

    if ( $accion == 'elimina'){
        
        $id_rubro_matriz =     $_GET["id_rubro_matriz"];

        $gestion->elimina_dato(  $id , $id_rubro_matriz);

        $gestion->BusquedaDoc(   trim($id)  );
        
    }


 
 
 
    
}




?>
 
  