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
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    
    //---------------------------------------------------------
    public function BusquedaDoc( $idprov){
        
        // Soporte Tecnico
        
        
        
        $qquery = array(
            array( campo => 'id_accion',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',valor => trim($idprov),filtro => 'S', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'motivo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_rige',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
         );
        
        $this->bd->_order_by('id_accion desc');
        
        $resultado = $this->bd->JqueryCursorVisor('nom_accion',$qquery );
 
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Tramite </th>
                <th> Tipo </th>
                <th> Fecha </th>
                <th> Motivo </th>
                <th> Novedad </th>
                <th> Rige </th>
                <th> Sesion </th>
               </thead> </tr>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_accion'] ;
            
 
            
            echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['tipo'].'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['motivo'].'</td>';
            echo ' <td>'.$fetch['novedad'].'</td>';
            echo ' <td>'.$fetch['fecha_rige'].'</td>';
            echo ' <td>'.$fetch['sesion'].'</td>';
             
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
 //-------------
    function ElimanaDoc( $id, $idprov ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql = "DELETE  FROM nom_doc 
                 where id_nom_doc = ".$this->bd->sqlvalue_inyeccion($id,true);
        
         $this->bd->ejecutar($sql);
        
        
         $this->BusquedaDoc( $idprov);
        
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
if (isset($_GET["idprov"]))	{
    
      
    $id 				=     $_GET["idprov"];
    
 
    
    $gestion->BusquedaDoc(   trim($id)  );
    
    
}

//------ grud de datos insercion
if (isset($_GET["idcodigo"]))	{
    
    
    $id 				=     $_GET["idcodigo"];
    
    $idprov 			=     $_GET["prov"];
    
    $gestion->ElimanaDoc(    ($id) ,  trim($idprov)   );
    
    
}




?>
 
  