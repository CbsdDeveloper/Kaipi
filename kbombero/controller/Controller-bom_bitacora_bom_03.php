<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo4' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarCarro').html( data  );

               jQuery( "#guardarCarro" ).fadeOut( 1600 );

               jQuery("#guardarCarro").fadeIn("slow");

               jQuery("#action_03").val("editar");

               
               
               GrillaCarro(-1);

         
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
      
         
       
        $datos      = array();
 
        $tipo = $this->bd->retorna_tipo();
        
        $array = $this->bd->__user($this->sesion);
         
        $id_departamento = $array['id_departamento'];
         
        $sqlb = "Select 0 as codigo, '[ 01. Seleccione vehiculo ]' as nombre
                    union
                    SELECT  id_bien as codigo ,codigo_veh || '-' || trim(descripcion) as nombre
                    FROM  adm.view_bien_vehiculo
                    where id_departamento =".$this->bd->sqlvalue_inyeccion(  $id_departamento, true).' order by 2';
        
        
        $sqlb = "Select 0 as codigo, '[ 01. Seleccione vehiculo ]' as nombre
                    union
                    SELECT  id_bien as codigo ,codigo_veh || '-' || trim(descripcion) as nombre
                    FROM  adm.view_bien_vehiculo  order by 2";
         
        
        $resultado = $this->bd->ejecutar($sqlb);

                $this->set->div_label(12,'<B>  ACTIVIDADES REALIZADAS</B>');	 


                $this->obj->text->text_yellow('Codigo',"number" ,'id_bom_carro' ,80,80, $datos ,'required','readonly','div-2-10') ;
 
                
                
                $MATRIZ_S = array(
                    'EMERGENCIA'    => 'EMERGENCIA',
                    'USO ADMINISTRATIVO'    => 'USO ADMINISTRATIVO'
                );
                
              
                $MATRIZ_A = array(
                    '2/4'    => '2/4',
                    '3/4'    => '3/4',
                    '4/4'    => '4/4'
                );
                
                
                
                $this->obj->list->lista('Despliegue',$MATRIZ_S,'carro_tipo',$datos,'required','','div-2-10'); 
                
  
                $evento    = '';
                $this->obj->list->listadbe($resultado,$tipo,'<b>Vehiculo</b>','idbien',$datos,'required','',$evento,'div-2-10');
                
                $this->obj->text->editor('Actividad realizada','actividad_c',3,250,250,$datos,'','','div-2-10');

          
                $this->obj->text->text_yellow('Km Actual',"number" ,'km' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->list->lista('Comb',$MATRIZ_A,'comb',$datos,'required','','div-2-4'); 
                
                
                $this->set->div_label(12,'<B>  CONTROL DE CAMBIO DE ACEITE (*)</B>');	
             
                $this->obj->text->text_yellow('Actual',"number" ,'aceite_a' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text_blue('Proximo Cambio',"number" ,'aceite_c' ,80,80, $datos ,'required','','div-2-4') ;
                
           
                
                
                $this->obj->text->texto_oculto("action_03",$datos); 

                $this->obj->text->texto_oculto("id_bita_bom_03",$datos); 
         
        
               
                
  
      
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
  