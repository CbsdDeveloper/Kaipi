<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery('#form, #fat, #fo3').submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
                      
            jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');
            jQuery( "#result" ).fadeOut( 1600 );
            jQuery("#result").fadeIn("slow");
           
          
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
       
             $this->obj     = 	new objects;
             
             $this->set     = 	new ItemsController;
                
             $this->bd	   =	     	new Db ;
          
             $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
   
             $this->ruc       =  $_SESSION['ruc_registro'];
             
             $this->sesion 	 =  $_SESSION['email'];
             
             $this->hoy 	     =  $this->bd->hoy();
     
             
            $this->formulario = 'Model-nom_distributivo_bom.php'; 

            $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
   }
    //-----------------------------------------------------------------------------------------------------------
   //Constructor de la clase
   //-----------------------------------------------------------------------------------------------------------
   
   
  function Formulario( ){
   

 
     $datos = array();

     $tipo 		= $this->bd->retorna_tipo();

     $anio = date('Y');

     $sql = "select  id_departamento as codigo, unidad as nombre 
              from view_nomina_user
              where orden like 'GGG%' and unidad is not null
              group by id_departamento, unidad
              order by 2 ";


            
 

             $this->set->div_panel12('<h6> PASO 1.- DISTRIBUIR PERSONAL<h6>');


                             echo '<h5>FUNCIONARIO:<b><div id="nombress"></div></b></h5>';

                              $resultado = $this->bd->ejecutar("select '0' as codigo , '  ---  00. Seleccionar Unidad a  --- ' as nombre union ".$sql);

                              $this->obj->list->listadb($resultado,$tipo,'Distribuir a','cambiar_a',$datos,'required','','div-4-8');
                                

                              $MATRIZ = array(
                                '-'          => 'No Aplica',
                                 'ESTACION'    => 'RESPONSABLE DE ESTACION',
                                 'GRUPO 1'    => 'GRUPO 1',
                                 'GRUPO 2'    => 'GRUPO 2', 
                                 'GRUPO 3'    => 'GRUPO 3' ,
                                 'ESCUELA DE FORMACION Y ESPECIALIZACION' => 'ESCUELA DE FORMACION Y ESPECIALIZACION' 
                            );
                         
                            
                          $this->obj->list->listae('Pertenece a ',$MATRIZ,'grupo_a',$datos,'required','',$evento,'div-4-8');

                                
                          $MATRIZ = array(
                            'Encargado de Estacion'    => 'Encargado de Estacion',
                            'Responsable de Grupo'    => 'Responsable de Grupo' ,
                            'ECU-911 Consola de Despacho'    => 'ECU-911 Consola de Despacho' ,
                            'Encargado de Escuela Formacion Seguridad'    => 'Encargado de Escuela Formacion Seguridad',
                            'Operador'    => 'Operador' ,
                            'Apoyo de Emergencia'    => 'Apoyo de Emergencia' ,
                            'Apoyo de Encargado Estacion'    => 'Apoyo de Encargado Estacion' ,
                            'Apoyo Unidad de Operaciones'    => 'Apoyo Unidad de Operaciones' ,
                            'Apoyo a Subjefatura'    => 'Apoyo a Subjefatura' ,
                            'Apoyo de Escuela Formacion Seguridad'    => 'Apoyo de Escuela Formacion Seguridad' ,
                            'Apoyo Delegado Prevencion'  => 'Apoyo Delegado Prevencion' 
                           );
                          
                             
                            $this->obj->list->listae('Funcion Estación',$MATRIZ,'funcion_a',$datos,'required','',$evento,'div-4-8');


                            $MATRIZ = array(
                              'N'    => 'NO',
                              'S'    => 'SI' 
                             );
                            
                               
                              $this->obj->list->listae('Responsable Estación',$MATRIZ,'responsable_a',$datos,'required','',$evento,'div-4-8');
 

                              $this->set->div_label(12,'Unidades de Apoyo');	 
 
                              $sql = "select 0 as codigo, ' -- 0. No aplica -- ' as nombre union
                                      select id_departamento as codigo ,nombre
                                        from nom_departamento where orden like 'G%' and nivel <=2
                              order by 2";
                              $resultado1 = $this->bd->ejecutar($sql);

                              $this->obj->list->listadb($resultado1,$tipo,'Unidad Apoyo','unidad_apoyo',$datos,'required','','div-4-8');

                            
                 $this->set->div_panel12('fin');


 

       
 

   
}
   

///------------------------------------------------------------------------
///------------------------------------------------------------------------
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------


$gestion   = 	new componente;


$gestion->Formulario( );

?>

