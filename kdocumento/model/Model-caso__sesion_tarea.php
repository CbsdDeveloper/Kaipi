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

        
        $tiempo = date("H:i:s");
        
        $this->tabla 	  	  = 'flow.wk_doc_user';
        $this->secuencia 	  = 'flow.wk_doc_user_id_user_doc_seq';
        
        $this->ATabla = array(
            array( campo => 'id_user_doc',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idcaso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => 'R', key => 'N'),
            array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'hora_in',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'inicio',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>'N', key => 'N')
        );
        
        
        
    }
    /*
    
    */
    public function agregarcc(    $sesion_siguiente  ,  $idcaso,$tipo ,$vestado){
        
        if ( $idcaso > 0  ){
        }else {
            $idcaso = -1;
         }
     
        $this->ATabla[1][valor]  =  $idcaso;
        $this->ATabla[3][valor]  =  'C';
        $this->ATabla[4][valor]  =  trim($sesion_siguiente);
        $this->ATabla[7][valor]  =  'S';

           $x = $this->bd->query_array('flow.wk_doc_user',   // TABLA
           'count(*) as nn',                        // CAMPOS
           'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and 
            inicio='.$this->bd->sqlvalue_inyeccion('S',true) .' and 
            sesion_actual='.$this->bd->sqlvalue_inyeccion(trim($sesion_siguiente),true)  
           );

       
        
        if ( $x['nn'] > 0  ){
            
        }else {
            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
        }
        
    
            
        $this->BusquedaDoc( $idcaso,$vestado,"S");
        
    }
    
    //--- calcula libro diario
    public function agregar(    $sesion_siguiente  ,  $idcaso,$tipo ,$vestado){
        
        
        $this->ATabla[1][valor]  =  $idcaso;
        $this->ATabla[3][valor]  =  'N';
        $this->ATabla[4][valor]  =  trim($sesion_siguiente);

 
           $this->ATabla[7][valor]  =  'N';

           $x = $this->bd->query_array('flow.wk_doc_user',   // TABLA
           'count(*) as nn',                        // CAMPOS
           'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and 
            inicio='.$this->bd->sqlvalue_inyeccion('N',true) .' and 
            bandera='.$this->bd->sqlvalue_inyeccion('0',true) .' and 
            sesion_actual='.$this->bd->sqlvalue_inyeccion(trim($sesion_siguiente),true) 
           );

        

        
        if ( $x['nn'] > 0  ){
            
        }else {
            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
        }
        
    
            
        $this->BusquedaDoc( $idcaso,$vestado);
        
    }
    
    //---------------------------------------------------------
    public function BusquedaDoc( $idcaso,$vestado="1",$valor="N"){
 

      
       

        $qquery = array(
            array( campo => 'idcaso',valor => trim($idcaso),filtro => 'S', visor => 'S'),
            array(campo => 'inicio',valor => $valor,filtro => 'S', visor => 'S'),
            array(campo => 'id_user_doc',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => '-', visor => 'S'),
            array( campo => 'bandera',valor => '0',filtro => 'S', visor => 'S'),
            array( campo => 'sesion_actual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_in',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'sesion',valor => $this->sesion,filtro => 'N', visor => 'S'),
            array( campo => 'cedula',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'funcionario',valor => '-',filtro => 'N', visor => 'S')
        );

        $this->bd->_order_by('tipo desc');
        
        $resultado = $this->bd->JqueryCursorVisor('flow.view_proceso_doc_user',$qquery  );
        
        
        echo '<table id="jsontableDocUser" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_user_doc'] ;
             
            $boton1 = '<button class=" btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocUserdel('.$idproducto.","."'".$idcaso."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
           
  
            $idprov =  $fetch['cedula'] ;
            
            $x = $this->bd->query_array('view_nomina_user',   // TABLA
                'cargo',                        // CAMPOS
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) // CONDICION
                );
            
            $tipo  =  trim($fetch['tipo']) ;
            $cargo =  $x['cargo'] ;
            
            if (   $tipo == 'S'){
                $ambito = 'PARA';
            }else{
                $ambito = 'C.COPIA';
            }
            
            
            
            echo ' <tr>';
            
            echo '<td>'.$ambito.'</td>';
            echo '<td><b>'.trim($fetch['funcionario']).'</b> / '.$cargo.'</td>';
            echo '<td>'.$boton1.'</td>';
             
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
    }
    //-------------
    //-------------
    function ElimanaDoc( $id, $idcaso ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql = "DELETE  FROM flow.wk_doc_user
                 where id_user_doc = ".$this->bd->sqlvalue_inyeccion($id,true);
        
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
          $sesion_siguiente	  =     trim($_GET["sesion_siguiente"]);
          $idcaso 			  =     $_GET["idcaso"];
          $tipo 			  =     $_GET["tipo"];
          $vestado =     trim($_GET["vestado"]);
           
          if ( $accion == 'add' ){
              $gestion->agregar(    $sesion_siguiente  ,  $idcaso, $tipo,$vestado  );
          }
          elseif($accion == 'del' ){
              $id 			  =     $_GET["id"];
              $gestion->ElimanaDoc( $id,  $idcaso );
          }
          elseif($accion == 'addCc' ){
            $gestion->agregarcc(    $sesion_siguiente  ,  $idcaso, $tipo,$vestado  );
          }
          else{
              $gestion->BusquedaDoc(  $idcaso );
          }
          
          
          
          
      }




?>
 
  