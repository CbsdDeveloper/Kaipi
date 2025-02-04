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
      private $ATabla;
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
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =     date("Y-m-d");    
                $anio 	     =     date("Y");    
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'presupuesto.pre_tramite_det';
                
                $this->secuencia 	     = 'presupuesto.pre_tramite_det_id_tramite_det_seq';
                
                $this->ATabla = array(
                    array( campo => 'id_tramite_det',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'certificado',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'compromiso',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                    array( campo => 'fsesion',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => $anio, key => 'N')
                 );
                
      }
       
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           $flujo = $this->bd->query_array('presupuesto.pre_tramite_det',
               'certificado,compromiso',
               'id_tramite_det='.$this->bd->sqlvalue_inyeccion($id,true)
               );
 
           
                 $this->ATabla[2][valor] =  $flujo['certificado'];
           
 
               
               $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
               
           
               $result = '' ;
     
 
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
     if (isset($_GET['id_tramite_det']))	{
            
             
            $id        = $_GET['id_tramite_det'];
            
 
                $gestion->edicion($id);
                
                 
            
     }  
  
  
  
   
 ?>
 
  