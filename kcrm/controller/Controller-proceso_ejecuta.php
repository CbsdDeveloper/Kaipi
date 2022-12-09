<script>
$(function(){
    
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
	
});
</script>
<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
	$obj     = 	new objects;
             
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $datos = array();
    
    $MATRIZ = array(
        '1' => 'Mis Procesos Asignados',
        '3' => 'Procesos de la Unidad'
    );
    
    $evento = 'onChange="'."goToURLProceso($('#festado').val(), this.value)".'"';
   // $obj->list->listae('',$MATRIZ,'ftipo',$datos,'','',$evento,'div-0-12');
    
   
    $obj->text->texto_oculto("festado",$datos); 
    
 
 

?>
