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
    private $tabla ;
    private $secuencia;
    
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
            array( campo => 'idcaso',valor => trim($idcaso),filtro => 'S', visor => 'S'),
            array(campo => 'id_user_doc',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion_actual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_in',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cedula',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'funcionario',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('flow.view_proceso_doc_user',$qquery );
        
        
        echo '<table id="jsontableDocUser" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
             
           
  
            $idprov =  $fetch['cedula'] ;
            
            $x = $this->bd->query_array('view_nomina_user',   // TABLA
                'cargo',                        // CAMPOS
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) // CONDICION
                );
            
            $tipo  =  $fetch['tipo'] ;
            $cargo =  $x['cargo'] ;
            
            if (   $tipo == 'S'){
                $ambito = 'Para';
            }else{
                $ambito = 'CC';
            }
            
            echo ' <tr>';
            
            echo ' <td>'.$ambito.'</td>';
            echo ' <td><b>'.$fetch['funcionario'].' / '.$cargo.'</b></td>';
             
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
    }
    //-------------
   
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ grud de datos insercion

      $idcaso 			=     $_GET["idcaso"];
 
      $gestion->BusquedaDoc($idcaso  );
        
 
 




?>
 
  