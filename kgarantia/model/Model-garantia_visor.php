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
        
        // Soporte Tecnico
        
     
        
        $qquery = array(
            array( campo => 'idcontrato',valor => $id,filtro => 'S', visor => 'S'),
            array( campo => 'idprov_aseguradora',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idpoliza',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'nro_poliza',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_poliza',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'monto',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechainicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechafin',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'vigencia',valor => '-',filtro => 'N', visor => 'S'),
        );
        
        $resultado = $this->bd->JqueryCursorVisor('garantias.poliza',$qquery );
        
      
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Poliza </th>
                <th> Tipo </th>
                <th> Documento </th>
                <th> Estado </th>
                <th> Monto </th>
                <th> Fecha Inicio </th>
                <th> Fecha Fin</th>
                <th> Vigencia(Dias) </th>
                <th> Acciones</th></thead> </tr>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['idpoliza'] ;
            
            
            $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLDocdelG('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
        
            
            $boton2 = '<button class="btn btn-xs"
                              title="Anular Poliza/Garantia"
                              onClick="javascript:goToAnula('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;';
            
            
            
            $boton3 = '<button class="btn btn-xs"
                              title="Generar Documento Renovacion"
                              onClick="javascript:goToRenova('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-duplicate"></i></button>&nbsp;&nbsp;';
            
            
             echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['nro_poliza'].'</td>';
            echo ' <td>'.$fetch['tipo_poliza'].'</td>';
            echo ' <td>'.$fetch['documento'].'</td>';
            echo ' <td>'.$fetch['estado'].'</td>';
            echo ' <td>'.$fetch['monto'].'</td>';
            echo ' <td>'.$fetch['fechainicio'].'</td>';
            echo ' <td>'.$fetch['fechafin'].'</td>';
            echo ' <td>'.$fetch['vigencia'].'</td>';
            echo ' <td>'.$boton2.$boton3.$boton1.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
    //-------------
    function ElimanaDoc( $id, $idcaso ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql = "DELETE  FROM garantias.poliza
                 where idpoliza = ".$this->bd->sqlvalue_inyeccion($id,true);
        
        $this->bd->ejecutar($sql);
        
        
        $this->BusquedaDoc( $idcaso);
        
    }
    
    
    //---------------
    
    function AnulaDoc( $id, $idcaso ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql = "update garantias.poliza set estado = 'anulada'
                 where idpoliza = ".$this->bd->sqlvalue_inyeccion($id,true);
        
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
    
    $idcaso  			=     $_GET["idcaso"];
    
    $accion  			=     $_GET["accion"];
    
    if ( $accion == 'anula'){
        $gestion->AnulaDoc(    $id , $idcaso   );
    }else {
        $gestion->ElimanaDoc(    $id , $idcaso   );
    }
    
    
    
}

 



?>
 
  