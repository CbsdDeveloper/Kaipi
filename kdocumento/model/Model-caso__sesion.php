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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

        
        $tiempo = date("H:i:s");
        
        $this->tabla 	  	     = 'flow.wk_doc_user';
        $this->secuencia 	     = 'flow.wk_doc_user_id_user_doc_seq';
        
        $this->ATabla = array(
            array( campo => 'id_user_doc',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'idcaso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'hora_in',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->sesion, key => 'N')
        );
        
        
        
    }
    
    //--- calcula libro diario
    public function agregar(    $sesion_siguiente  ,  $idcaso, $tipo){
        
        
        $this->ATabla[1][valor]  =  $idcaso;
        $this->ATabla[3][valor]  =  $tipo;
        $this->ATabla[4][valor]  =  trim($sesion_siguiente);
         
    
      
       if ( $idcaso > 0 )   {   

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

         }else {   

                        $idcaso = -1;

                        $this->ATabla[1][valor]  =  $idcaso; 

                        $x = $this->bd->query_array('flow.wk_doc_user',   // TABLA
                        'count(*) as nn',                        // CAMPOS
                        'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and 
                        inicio='.$this->bd->sqlvalue_inyeccion('S',true) .' and 
                        sesion_actual='.$this->bd->sqlvalue_inyeccion(trim($sesion_siguiente),true) 
                        );

                    

            
                        if ( $x['nn'] > 0  ){
                            
                        }else {
                            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia  );
                        }

         }
    
     
            
        $this->BusquedaDoc( $idcaso);

        
    }
    /*
    */
    public function agregar_dir(    $sesion_siguiente  ,  $idcaso, $tipo){
        

        $sesion 	 =  trim($_SESSION['email']);

        $sql1 = "SELECT   *
        FROM  par_usuario
       where estado = 'S' and 
              email <> ".$this->bd->sqlvalue_inyeccion( $sesion,true)." and
             director =".$this->bd->sqlvalue_inyeccion( 'S' ,true).' 
             order by completo '   ;

        $stmt1 = $this->bd->ejecutar($sql1);
                
                
        while ($fila=$this->bd->obtener_fila($stmt1)){

            $sesion_siguiente = $fila['email'];
        
            $this->ATabla[1][valor]  =  $idcaso;
            $this->ATabla[3][valor]  =  $tipo;
            $this->ATabla[4][valor]  =  trim($sesion_siguiente);
         
       
                    if ( $idcaso > 0 )   {   

                            $x = $this->bd->query_array('flow.wk_doc_user',   // TABLA
                            'count(*) as nn',                        // CAMPOS
                            'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and 
                            tipo='.$this->bd->sqlvalue_inyeccion($tipo,true) .' and 
                            inicio='.$this->bd->sqlvalue_inyeccion('S',true) .' and 
                            sesion_actual='.$this->bd->sqlvalue_inyeccion(trim($sesion_siguiente),true)
                            );

                
                            if ( $x['nn'] > 0  ){
                                
                            }else {
                                $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
                            }

                        }else {   

                            $idcaso = -1;

                            $this->ATabla[1][valor]  =  $idcaso; 

                            $x = $this->bd->query_array('flow.wk_doc_user',   // TABLA
                            'count(*) as nn',                        // CAMPOS
                            'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and 
                            tipo='.$this->bd->sqlvalue_inyeccion($tipo,true) .' and 
                            inicio='.$this->bd->sqlvalue_inyeccion('S',true) .' and 
                            sesion='.$this->bd->sqlvalue_inyeccion(trim($sesion_siguiente),true)
                            );

                
                            if ( $x['nn'] > 0  ){
                                
                            }else {
                                $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
                            }

                        }
          }
     
            
        $this->BusquedaDoc( $idcaso);

        
    }
    /*
    */
   
    public function agregar_uni(    $sesion_siguiente  ,  $idcaso, $tipo){
        

        $sesion 	 =  trim($_SESSION['email']);
        $datos       =  $this->bd->__user($sesion);
        $longitud    =  strlen($datos['orden']);
        $orden       = trim($datos['orden']);
        
         if (  $longitud > 1 ){
                    $orden = substr( $orden ,0,1);
        }
       
       $sql1 = 'SELECT email, completo ,cargo
                            FROM view_nomina_user
                            where orden like '.$this->bd->sqlvalue_inyeccion($orden .'%',true) . " and 
                                  cargo is not null and
                                  estado = 'S' and 
                                  email <> ".$this->bd->sqlvalue_inyeccion( $sesion,true)."
                            order by responsable desc,completo" ;
  

        $stmt1 = $this->bd->ejecutar($sql1);
                
                
        while ($fila=$this->bd->obtener_fila($stmt1)){

            $sesion_siguiente = $fila['email'];
        
            $this->ATabla[1][valor]  =  $idcaso;
            $this->ATabla[3][valor]  =  $tipo;
            $this->ATabla[4][valor]  =  trim($sesion_siguiente);
         
       
                    if ( $idcaso > 0 )   {   

                            $x = $this->bd->query_array('flow.wk_doc_user',   // TABLA
                            'count(*) as nn',                        // CAMPOS
                            'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and 
                            tipo='.$this->bd->sqlvalue_inyeccion($tipo,true) .' and 
                            inicio='.$this->bd->sqlvalue_inyeccion('S',true) .' and 
                            sesion_actual='.$this->bd->sqlvalue_inyeccion(trim($sesion_siguiente),true)
                            );

                
                            if ( $x['nn'] > 0  ){
                                
                            }else {
                                $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
                            }

                        }else {   

                            $idcaso = -1;

                            $this->ATabla[1][valor]  =  $idcaso; 

                            $x = $this->bd->query_array('flow.wk_doc_user',   // TABLA
                            'count(*) as nn',                        // CAMPOS
                            'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and 
                            tipo='.$this->bd->sqlvalue_inyeccion($tipo,true) .' and 
                            inicio='.$this->bd->sqlvalue_inyeccion('S',true) .' and 
                            sesion='.$this->bd->sqlvalue_inyeccion(trim($sesion_siguiente),true)
                            );

                
                            if ( $x['nn'] > 0  ){
                                
                            }else {
                                $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
                            }

                        }
          }
     
            
        $this->BusquedaDoc( $idcaso);

        
    }
    //-----------------------  $gestion->BusquedaDoc_seg( $id,  $idcaso ,  $doc_user);

    public function BusquedaDoc_seg(  $idcaso ,  $doc_user ){
 
        
        $qquery = array(
            array( campo => 'idcaso',valor => trim($idcaso),filtro => 'S', visor => 'S'),
            array(campo => 'id_user_doc',valor =>  '-' ,filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion_actual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_in',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'bandera',valor => '0',filtro => 'S', visor => 'S'),
            array( campo => 'inicio',valor => 'N',filtro => 'S', visor => 'S'),
            array( campo => 'cedula',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'funcionario',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $resultado = $this->bd->JqueryCursorVisor('flow.view_proceso_doc_user',$qquery );
        
        
        echo '<table id="jsontableDocUser" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead>';
        
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_user_doc'] ;
             
            $boton1 = '<button class=" btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocUserdel('.$idproducto.","."'".$idcaso."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
           
  
            $idprov =  trim($fetch['cedula']) ;
            
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
            
            echo ' <td><b>'.$ambito.'</b></td>';
            echo ' <td>'.trim($fetch['funcionario']).' / '.$cargo.'</td>';
            
            echo ' <td>'.$boton1.'</td>';
             
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
    }
    //---------------------------------------------------------
    public function BusquedaDoc( $idcaso){
 
        $filtro = 'N';

        if ($idcaso == -1) {
             $filtro = 'S';
        }

        $qquery = array(
            array( campo => 'idcaso',valor => trim($idcaso),filtro => 'S', visor => 'S'),
            array(campo => 'inicio',valor => 'S',filtro => 'S', visor => 'S'),
            array(campo => 'id_user_doc',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'bandera',valor => '0',filtro => 'S', visor => 'S'),
            array( campo => 'sesion_actual',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_in',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor => $this->sesion,filtro => $filtro, visor => 'S'),
            array( campo => 'cedula',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'funcionario',valor => '-',filtro => 'N', visor => 'S')
        );
        
        $this->bd->_order_by('tipo desc');
        $resultado = $this->bd->JqueryCursorVisor('flow.view_proceso_doc_user',$qquery );
        
        
        echo '<table id="jsontableDocUser" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead>';
         
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_user_doc'] ;
             
            $boton1 = '<button class=" btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocUserdel('.$idproducto.","."'".$idcaso."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
           
  
            $idprov =  trim($fetch['cedula']) ;
            
            $x = $this->bd->query_array('view_nomina_user',   // TABLA
                'cargo',                        // CAMPOS
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true) // CONDICION
                );
            
            $tipo  =  $fetch['tipo'] ;
            $cargo =  $x['cargo'] ;
            
            if (   $tipo == 'S'){
                $ambito = 'PARA';
            }else{
                $ambito = 'C.COPIA';
            }
            
            echo ' <tr>';
                 echo '<td><b>'.$ambito.'</b></td>';
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
          
          $accion             =     trim($_GET["accion"]);

          $sesion_siguiente	  =     trim($_GET["sesion_siguiente"]);

          $idcaso 			  =     $_GET["idcaso"];

          $tipo 			  =     $_GET["tipo"];

          $unidad_destino     =    $_GET["unidad_destino"];
          
        

          if ( $accion == 'add' ){
              
            if (  $unidad_destino   == -1){
                        $gestion->agregar_dir(    $sesion_siguiente  ,  $idcaso, $tipo);
            }else {

                if (  ( $unidad_destino   == -2) && ( $sesion_siguiente =='-') ) {
                     $gestion->agregar_uni(    $sesion_siguiente  ,  $idcaso, $tipo);
                }else{
                      $gestion->agregar(    $sesion_siguiente  ,  $idcaso, $tipo);
                }
            }

          }
          elseif($accion == 'del' ){
              $id 			  =     $_GET["id"];
              $gestion->ElimanaDoc( $id,  $idcaso );
          }
          elseif($accion == 'seg_visor' ){
            $doc_user  	  =     $_GET["doc_user"];
            $gestion->BusquedaDoc_seg(   $idcaso ,  $doc_user);
         }
           else{
              $gestion->BusquedaDoc(  $idcaso );
          }
          
          
          
          
      }




?>
 
  