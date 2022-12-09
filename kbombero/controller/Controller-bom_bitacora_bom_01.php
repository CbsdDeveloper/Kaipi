<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo2' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarDocumento').html( data  );

               jQuery( "#guardarDocumento" ).fadeOut( 1600 );

               jQuery("#guardarDocumento").fadeIn("slow");

               jQuery("#action_01").val("editar");

               GrillaPersonal(-1);

         
         }
     })        
     return false;
 }); 
})
</script>	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
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
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');
        
                
        
   
             
      }
      
      //---------------------------------------
      
     function Formulario( ){
      
         
         $datos_usuario = $this->bd->__user($this->sesion);
         
         $id_departamento = $datos_usuario['id_departamento'];
         

        $tipo       = $this->bd->retorna_tipo();


        $sql = "SELECT '-' as codigo, ' --  0. USUARIO GUARDIA  --  ' as nombre UNION
        SELECT  idprov as codigo, upper(completo) as nombre
        FROM view_nomina_user
        where estado ='S' and
              tipo_cargo = 'B' and
              id_departamento = ".$this->bd->sqlvalue_inyeccion($id_departamento,true)."
        order by 2 " ;
        
        
        $sql = "SELECT '-' as codigo, ' --  0. USUARIO GUARDIA  --  ' as nombre UNION
        SELECT  idprov as codigo, upper(completo) as nombre
        FROM view_nomina_user
        where estado ='S' and
              tipo_cargo = 'B'  
        order by 2 " ;
        
 
        $resultado  =  $this->bd->ejecutar($sql);

 

        $datos      = array();
 
         

        $MATRIZ_S = array(
            'OFICIAL'    => 'OFICIAL',
            'JEFE DE GUARDIA'    => 'JEFE DE GUARDIA',
            'ENCARGADO DE ESTACION'    => 'ENCARGADO DE ESTACION',
            'RESPONSABLE AL MANDO PELOTON'    => 'RESPONSABLE AL MANDO PELOTON',
            'SUBALTERNO DE GUARDIA'    => 'SUBALTERNO DE GUARDIA',
            'SUBALTERNOS'    => 'SUBALTERNOS',
            'OPERATIVOS'    => 'OPERATIVOS',
            'OPERADORES'    => 'OPERADORES',
            'BROS'    => 'BROS' 
        );
  
         
 

                $this->set->div_label(12,'<B>  INFORMACION DEL PERSONAL</B>');	 


                $this->obj->text->text_yellow('Codigo',"number" ,'id_bom_bita' ,80,80, $datos ,'required','readonly','div-2-10') ;

                $this->obj->list->listadb($resultado,$tipo,'<b>Bomberos</b>','idprov',$datos,'required','','div-2-10');	

                $this->obj->list->lista('Denominacion',$MATRIZ_S,'denominacion',$datos,'required','','div-2-10'); 
  
                $this->obj->text->editor('Novedad','actividad',3,250,250,$datos,'','','div-2-10');

 
                $this->obj->text->texto_oculto("action_01",$datos); 

                $this->obj->text->texto_oculto("id_bita_bom_01",$datos); 
         
        
 
  
      
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
  