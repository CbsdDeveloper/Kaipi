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
      private $ATabla;
      private $tabla ;
      private $secuencia;
      private $anio;

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
 
                
                $this->anio 	     =    $_SESSION['anio'];
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'presupuesto.pre_tramite_det';
                
                $this->secuencia 	     = 'presupuesto.pre_tramite_det_id_tramite_det_seq';
                
                $this->ATabla = array(
                    array( campo => 'id_tramite_det',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'id_tramite',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'partida',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'saldo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'base',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'certificado',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'compromiso',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'devengado',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'fsesion',tipo => 'DATE',id => '10',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor =>  $this->anio, key => 'N')
                 );
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo,$visor){
            //inicializamos la clase para conectarnos a la bd
      
        
          echo '<script type="text/javascript">accion_producto('."'". $id."'". ','. "'".$accion."',". $visor.')</script>';
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                  if ($accion == 'del')    
                      $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                      
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
                 
             }
             
              
            return $resultado;   
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_limpiar( ){
            //inicializamos la clase para conectarnos a la bd
       
             $resultado = '';
             echo '<script type="text/javascript">';
              
             echo  'LimpiarPantalla();';               
   
             echo '</script>';
 
            return $resultado;   
 
      }     
   
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
 	 	
     $qquery = array( 
         array( campo => 'id_tramite_det',   valor => $id,  filtro => 'S',   visor => 'S'),
         array( campo => 'partida',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'saldo',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'fuente',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'iva',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'actividad',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'base',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'grupo',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'certificado',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'compromiso',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'devengado',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S')
            );
     

        $datos = $this->bd->JqueryArrayVisor('presupuesto.view_certificacionesd',$qquery );           
          
 

           
       echo "<script> $('#partida').append('<option value=".'"'.trim($datos["partida"]).'"'." selected=".'"selected"'.">".trim($datos["detalle"])."</option>');</script>";   
          
       $guardarProducto =  $this->div_resultado($accion,$id,0,1);
     
     
      echo  $guardarProducto;
}	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function xcrud($action,$id){
          
 
                 // ------------------  agregar
                 if ($action == 'add'){
                    
                     $this->agregar( );
                 
                 }  
                 // ------------------  editar
                 if ($action == 'editar'){
        
                     $this->edicion($id );
     
                 }  
                 // ------------------  eliminar
                  if ($action == 'del'){
        
                     $this->eliminar($id );
     
                 }  
 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
     	
     	
           $id_tramite_prod = $_POST["id_tramite_prod"];
           
           $saldo       = $_POST["saldo"];
           
           $certificado = $_POST["certificado"];
           
           $this->ATabla[1][valor] =  $id_tramite_prod;
           
         
           
           if ( $certificado <= $saldo ){
               
               $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
               $result = $this->div_resultado('editar',$id,1,0).'['. $id.']';
               
           }else{
               
               $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>MONTO SOLICITADO EXCEDE AL DISPONIBLE ?</b>';
           }
          
          
            echo $result;
          
     }	
      //---------------------------------------------------
     
     ///--------------------------------------------------------
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           $id_tramite_prod = $_POST["id_tramite_prod"];
           
           $saldo       = $_POST["saldo"];
           
           
           $certificado = $_POST["certificado"];
           
           $this->ATabla[1][valor] =  $id_tramite_prod;
           
          
           
           if ( $certificado <= $saldo ){
               
               $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
               
               $result = $this->div_resultado('editar',$id,1,0).'['. $id.']';
               
           }else{
               $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>MONTO SOLICITADO EXCEDE AL DISPONIBLE ?</b>';
           }
           
           
                 
     
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
 
         $x = $this->bd->query_array('presupuesto.pre_tramite_det',
                                     '(certificado + compromiso + devengado) as tt, id_tramite ', 
                                     'id_tramite_det='.$this->bd->sqlvalue_inyeccion($id,true));
         
         
         
         $total         = $x['tt'];
         $id_tramite    = $x['id_tramite'];
         $result        =' No se puede eliminar ....';
         
         if ( $total == 0 ){
             
             $sql1 = 'DELETE
                  FROM  presupuesto.pre_tramite_det
                  where id_tramite_det = '.$this->bd->sqlvalue_inyeccion( $id, true)  ;
             
             $this->bd->ejecutar($sql1);
             
             $result ='Registro eliminado....';
             
         }else{
             
             $y = $this->bd->query_array('presupuesto.pre_tramite',
                 'count(*) as nn ',
                 'id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true)." and estado in ('0','2','3')"
                 );
             
             if ( $y['nn'] > 0  ){

                 $sql1 = 'DELETE
                  FROM  presupuesto.pre_tramite_det
                  where id_tramite_det = '.$this->bd->sqlvalue_inyeccion( $id, true)  ;
                 
                 $this->bd->ejecutar($sql1);
                 
                 $result ='Registro eliminado....';
             }
         }
                  
           
     	
  
       echo $result;
      
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id_tramite_det'];
            
            
            
            if ( $accion == 'del'){
                
                $gestion->eliminar($id);
                
            }else{
                
                $gestion->consultaId($accion,$id);
                
            }
            
            
            
            
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["actionProducto"]))	{
        
            $action 	    = $_POST["actionProducto"];
        
            $id 			= $_POST["id_tramite_det"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
   
 ?>
 
  