<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class _personal_paciente{
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function _personal_paciente( ){
   
                $this->obj     = 	new objects;

                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                 
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =  date("Y-m-d");  
				
                 
      }
     //---------------------------------------
     function visor_personal(  $id  ){
      
       
        $datos['idprov'] = '0000000000';
        $datos['edad'] = '0';

        echo '<div class="alert alert-success"> <div class="row">';

        $this->obj->text->text_yellow('Cedula',"texto",'idprov',10,10,$datos,'required','','div-1-2') ;

        $this->obj->text->text('Nombres Completos',"texto",'nombres',70,70,$datos,'required','','div-2-4') ;
		      
        $this->obj->text->text('Edad Aprox.',"number",'edad',70,70,$datos,'required','','div-1-2') ;
        
        
                $MATRIZ = array(
                    'herido'    => 'Herido',
                    'fallecido'    => 'Fallecido'
             );
            
            $evento = '';
            
            $this->obj->list->listae('Motivo',$MATRIZ,'tipo',$datos,'','',$evento,'div-1-2');
            
            $this->obj->text->text('Signos/Diagnostico',"texto",'signos',170,170,$datos,'required','','div-2-4') ;
            
 
     echo '</div></div>';

    
    
    
      
   }

   /*
   agregar 
   */
   function add_personal( $id, $idprov, $nombres ,$edad , $tipo,$signos){
  
    $tabla           = 'bomberos.bombero_emer_pac';
     
    $secuencia 	     = 'bomberos.bombero_emer_pac_id_bom_pac_seq';
 

    $xx = $this->bd->query_array( $tabla ,
	                                'count(*) as nn ',       
	                                'idprov='.$this->bd->sqlvalue_inyeccion( trim($idprov),true) . ' and 
                                    id_caso='.$this->bd->sqlvalue_inyeccion(   $id ,true)
	        );
 

    $len1 = strlen($nombres);      

 
    $ATabla = array(
        array( campo => 'id_bom_pac',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $idprov, key => 'N'),
        array( campo => 'id_caso',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>$id, key => 'N'),
        array( campo => 'edad',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$edad, key => 'N'),
        array( campo => 'tipo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>$tipo, key => 'N'),
        array( campo => 'nombres',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>strtoupper($nombres), key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
        array( campo => 'signos',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor =>strtoupper($signos), key => 'N'),
        );
    

        if ( $xx['nn'] > 0  )  {
        
        }else {
        
          if (  $len1  > 10 ) {

            $this->bd->_InsertSQL($tabla,$ATabla,$secuencia );
       
         }else {
            echo 'ADVERTENCIA FALTA INFORMACION... REGISTRE INFORMACION PACIENTE';
         } 
        } 

   


} 
/*
*/
function eliminar_personal(  $id ,     $id_emer_vehiculo){
  
    $tabla 	  	  = 'bomberos.bombero_emer_pac';
     
    $sql = 'delete from '.    $tabla.'  where id_bom_pac='.$this->bd->sqlvalue_inyeccion($id_emer_vehiculo, true);

    $this->bd->ejecutar($sql);

 
 


} 
  //----------------------------------------------
  function visor_emer_vehiculos(  $id  ){
      
       

    
    $sql1 = "SELECT id_bom_pac, idprov, nombres, edad, signos,tipo
              FROM bomberos.bombero_emer_pac 
                where id_caso=".$this->bd->sqlvalue_inyeccion($id  ,true);
      
 
        $resultado =  $this->bd->ejecutar($sql1);

        $tipo =  $this->bd->retorna_tipo();
        
        echo ' <div class="col-md-10" style="padding: 15px">';

        $cabecera =  "Referencia,Identificacion,Nombre,Edad,Signos/Diagnostico,Motivo";

        $evento   = "deltramite-0";

        $this->obj->table->table_basic_seleccion($resultado,$tipo,'','del',$evento ,$cabecera);

  
     echo ' </div>';

}




 }    
   $gestion   = 	new _personal_paciente;
   
   
   
   if (isset($_GET['accion']))	{

    $accion        = trim($_GET['accion']);

    $id            = $_GET['id'];
    
    $idprov        = trim($_GET['idprov']);
 
  
    

            if ($accion == 'visor_personal'){

                $gestion->visor_personal( $id );      
                
            } 
   
            if ($accion == 'add'){
                $nombres        = trim($_GET['nombres']);
                $edad        = trim($_GET['edad']);
                $tipo        = trim($_GET['tipo']);
                $signos        = trim($_GET['signos']);
 
    
                $gestion->add_personal( $id ,     $idprov, $nombres ,$edad , $tipo,$signos );
                
            } 
   
            if ($accion == 'del'){

                $idcodigo =$_GET['idcodigo'];

                $gestion->eliminar_personal( $id ,     $idcodigo);
                
            } 

            if ($accion == 'visor'){
              $gestion->visor_emer_vehiculos( $id );   
            } 

          
            
}  

 


?>

