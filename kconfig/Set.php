<?php


/* Clase encargada de gestionar las conexiones a la base de datos */
class ItemsController  {
     
 
//---------------- titulo modal header
function header_titulo($titulo) {	
	
	$hoy = date("l jS \of F Y h:i:s A");//date("Y-m-d");   
?>
  <!--  <style type="text/css">
          .modal-header
                 {
         	color:#fff;
            padding:12px 15px;
            border-bottom:1px solid #eee;
            background-color: #B9D0E1;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-top-right-radius: 5px;
            -moz-border-radius-topleft: 5px;
            -moz-border-radius-topright: 5px;
             border-top-left-radius: 5px;
             border-top-right-radius: 5px;
             }
    </style> -->
        <div class="modal-header">
            <button type="button" class="close widget-refresh" data-dismiss="modal" onClick="window.location.reload()" title="Refrescar">
            <i class="icon-refresh"></i></button>
            <h6 class="modal-title">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img  src="../../kimages/home_ventana.png" title="Modulo Personal"/></a> &nbsp;
              
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img  src="../../kimages/tiempo.png" title="Hoy es  <?php echo date("F j, Y");  ?>"> </a> &nbsp;
              
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img  src="../../kimages/avatar.png" /></a> &nbsp;&nbsp;
              
              <a href="inicio" class="nav-link" target="miFrame"><small>INICIO</small>
              </a>  <img src="../../kimages/tab.png"/> &nbsp;
              
              <a href="<?php echo $url; ?>" class="nav-link" target="miFrame">
              <small><?php echo strtoupper($_SESSION['login']) ?></small></a>  
              
              <img src="../../kimages/tab.png"/> &nbsp; 
              <small><?php  echo $titulo; ?></small>
     		</h6>
          </div>
         
<?php
	}
   
function modal_header($titulo,$url,$tab3){  
?>
<style type="text/css">

  .modal-header
         {
 	color:#fff;
    padding:12px 15px;
    border-bottom:1px solid #eee;
    background-color: #428bca;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
         }
</style>      

<div class="modal-header">
        <button type="button" class="close widget-refresh" data-dismiss="modal" onClick="window.location.reload()" title="Refrescar">
        <i class="icon-refresh"></i></button>
        <h4 class="modal-title">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
          <img  src="../kimages/home_ventana.png" title="Plataforma de gestión Cabildo"/></a> &nbsp;
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
          <img  src="../kimages/tiempo.png"/ title="Hoy es  <?php echo date("F j, Y");  ?>"> </a> &nbsp;
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
          <img  src="../kimages/avatar.png" /></a> &nbsp;&nbsp;
          <a href="inicio" target="miFrame">
          <small><strong><font color="white">INICIO </font></strong></small>
          </a>  <img src="../kimages/tab.png"/> &nbsp;
          <a href="<?php echo $url; ?>" target="miFrame">
          <small><strong><font color="white"><?php echo $titulo; ?></font></strong></small></a>  
          <img src="../kimages/tab.png"/> &nbsp; 
          <font color="white"><?php  echo $tab3; ?></font>
 		</h4>
      </div>
 <?php  
    }
  function box_tabs($tab1,$tab2,$tab3,$tab4){
	$tab11 = '';
	$tab22 = '';
	$tab33 = '';
	$tab44 = '';
	
	if(!empty($tab1))
		$tab11 = '<li class="active"><a href="#tab1" data-toggle="tab"></a></li>';
    if(!empty($tab2))
		$tab22 = '<li><a href="#tab2" data-toggle="tab"></a></li>';	
	if(!empty($tab3))
		$tab33 = '<li><a href="#tab3" data-toggle="tab"></a></li>';
    if(!empty($tab4))
		$tab44 = '<li><a href="#tab4" data-toggle="tab"></a></li>';	
	
    
   ?> 	
   <div class="tabbable tabbable-custom">	
    <div class="tabbable box-tabs">
	<ul class="nav nav-tabs"> <?php echo $tab11.$tab22.$tab33.$tab44 ?></ul> 	
   	<div class="tab-content">
 <?php 	
 
	return true;
   }
     function box_tabsn($tab1,$nombre1,$tab2,$nombre2,$tab3,$nombre3,$tab4,$nombre4){
	$tab11 = '';
	$tab22 = '';
	$tab33 = '';
	$tab44 = '';
	
	if(!empty($tab1))
		$tab11 = '<li class="active"><a href="#tab1" data-toggle="tab">'.$nombre1.'</a></li>';
    if(!empty($tab2))
		$tab22 = '<li><a href="#tab2" data-toggle="tab">Tab2</a></li>';	
	if(!empty($tab3))
		$tab33 = '<li><a href="#tab3" data-toggle="tab">Tab2</a></li>';
    if(!empty($tab4))
		$tab44 = '<li><a href="#tab4" data-toggle="tab">Tab2</a></li>';	
			
	$a = '<div class="tabbable box-tabs">
	       <ul class="nav nav-tabs">'.$tab11.$tab22.$tab33.$tab44.'</ul> 	
   	     <div class="tab-content">';
	
	echo $a;
	return true;
   }
   // tab adicionales
   function nav_tabs($tab1,$m1,$tab2,$m2,$tab3,$m3,$tab4,$m4){
	$tab11 = '';
	$tab22 = '';
	$tab33 = '';
	$tab44 = '';
	
	if(!empty($tab1))
	    $tab11 = '<li class="active"><a href="#tab_1_1" data-toggle="tab">'.utf8_encode($m1).'</a></li>';
    if(!empty($tab2))
		$tab22 = '<li><a href="#tab_1_2" data-toggle="tab">'.$m2.'</a></li>';	
	if(!empty($tab3))
		$tab33 = '<li><a href="#tab_1_3" data-toggle="tab">'.$m3.'</a></li>';
    if(!empty($tab4))
		$tab44 = '<li><a href="#tab_1_4" data-toggle="tab">'.$m4.'</a></li>';	

    if(!empty($tab5))
		$tab55 = '<li><a href="#tab_1_5" data-toggle="tab">'.$m5.'</a></li>';	

	
 	$a = '<div class="tabbable tabbable-custom">
	       <ul class="nav nav-tabs">'.$tab11.$tab22.$tab33.$tab44.$tab55.'</ul> 	
   	     <div class="tab-content">';
	
	echo $a;
	 
   }  
    //tab para informacion
  function tab_panel($tab1){
     if ($tab1 == 'tab1'){
 ?>
    <div class="tab-pane active" id="<?php echo $tab1  ?>">
    <div class="well">
    <div class="modal-dialog" style="left: 0; width: 100%; padding-top: 0; padding-bottom: 10px; margin: 0;">
    <div class="modal-content">
 <?php
   }else{
 ?>   
 	<div class="tab-pane" id="<?php echo $tab1?>">
    <div class="well">
    <div class="modal-dialog" style="left: 0; width: 100%; padding-top: 0; padding-bottom: 10px; margin: 0;">
    <div class="modal-content">
 <?php
   }  
	return true;
}  

  //tab para informacion
  function tab_panel_main($tab1,$inicio){
	if ($inicio == 'inicio') {  
    	 if ($tab1 == 'tab1'){
            ?>
    	      	<div class="tab-pane active" id="<?php echo $tab1 ?>">
            <?php
 		 }else{
            ?>   
 			    <div class="tab-pane" id="<?php echo $tab1 ?>">
 		    <?php
         }
	 }	 
	 else
	 {
	 		echo '</div></div>';
	 } 	 
  
	return true;
}  
//------------------------------------
//---------------- titulo modal header
function tab_body($titulo) {	
	
	$hoy = date("l jS \of F Y h:i:s A");//date("Y-m-d");   
?>
     <script type="text/javascript">
            document.oncontextmenu = function(){return false;}
     </script>
        <style type="text/css">
          .modal-header
                 {
         	color:#fff;
            padding:12px 15px;
            border-bottom:1px solid #eee;
            background-color: #f1f1f1;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-top-right-radius: 5px;
            -moz-border-radius-topleft: 5px;
            -moz-border-radius-topright: 5px;
             border-top-left-radius: 5px;
             border-top-right-radius: 5px;
             }
    </style>      
     <div class="modal-header">
            <button type="button" class="close widget-refresh" data-dismiss="modal" onClick="window.location.reload()" title="Refrescar">
            <i class="icon-refresh"></i></button>
            <h5 class="modal-title">
              <a href="inicio" class="dropdown-toggle" data-toggle="dropdown"> 
              <img  src="../../kimages/home_ventana.png" title="Modulo Personal"/></a> &nbsp;
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img  src="../../kimages/tiempo.png" / title="Hoy es  <?php echo date("F j, Y");  ?>"> </a> &nbsp;
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img  src="../../kimages/avatar.png" /></a> &nbsp;&nbsp;
              <a href="inicio">  <small>  INICIO   </small>
              </a>  <img src="../../kimages/tab.png"/> &nbsp;
              <a href="<?php echo $url; ?>" >
              <small>  <?php echo $_SESSION['login'] ?>  </small></a>  
              <img src="../../kimages/tab.png"/> &nbsp; 
               <span style="font-size: 11px"><?php  echo strtoupper ($titulo) ; ?>   </span>
     		</h5>
          </div>
          <div class="modal-body">
         
<?php
	}

//------------------------------------
//---------------- titulo modal header
function tab_body_tab($titulo,$inicio) {	
	$hoy = date("l jS \of F Y h:i:s A");//date("Y-m-d");   
	if ($inicio == 'inicio'){
     ?>
     		<div class="modal-body">
    <?php
    }else{
	?>	
	   </div>
   			</div>
  				<div class="modal-footer">
	<?php
	}
}	

//------------------------------------
//---------------- titulo modal header
function body_tab($titulo,$inicio) {	
	 
	if ($inicio == 'inicio'){
     ?>
     		<div class="modal-body">
     <?php
    }else{
		 if ($inicio == 'fin'){
	?>	
			</div>
  				<div class="modal-footer">
	<?php
		}else{
			echo '</div>';
	}
  }	
}	
	// titulo modal header
	//--------------------------------------------------------
function tab_body_web($titulo) {	
	
?>		 
  <div class="modal-header"> 
	<button type="button" class="close widget-refresh" data-dismiss="modal" onClick="window.location.reload()" title="Refrescar informacion">
	 <i class="icon-refresh"></i></button> 
	 <h4 class="modal-title"><?php echo $titulo ?></h4>    
	  </div> 
       <div class="modal-body"> 
<?php
 		return true;
	}	
	
	// titulo modal header
	function brefrescar() {	
 					echo '<button type="button" class="close" data-dismiss="modal" onClick="window.location.reload()" title="Refrescar informacion">
						 <i class="icon-cog"></i></button>';    
   					return true;
	} 	
	// titulo modal header
	function tab_footer( ) {
?>	   
 	</div>
   </div>
   
   <div class="modal-footer">
<?php
	return true;
	}   
	// titulo modal header
	/*function tab_footer_end( ) {	
 			$a = '</div></div>';
 			echo $a;
	return true;
	}  	*/
	// titulo modal header
	function frame_fin( ) {	
	?>   
 		</table>
    <?php    
 	return true;
	} 	
	// titulo modal header
	function table_fin( ) {	
	?>    
 	  </tr></table><hr>
    <?php      
 	return true;
	} 	
	// titulo modal header
	function form_buscar($formulario ) {	
   ?>   
 		 <form action="<?php echo $formulario.'?filter=1' ?>" method="post" name="fsearch" id="fsearch" accept-charset="UTF-8" > 
   <?php  
 	return true;
	} 	
	// titulo modal header
	function forma_buscar($formulario,$inicio ) {
		if ($inicio == 'inicio')	{
   ?>   
 		 <form action="<?php echo $formulario.'?filter=1' ?>" method="post" name="fsearch" id="fsearch" accept-charset="UTF-8" > 
   <?php  
   		 }
		 else
		 {
			 if ($formulario == '/'){
			 	echo '</div></form>';
			  }
			 else
			 {
		 		echo '</form>';
		 	 }
		 }
 	return true;
	} 
    	// titulo modal header
	function form_buscar_ajax($formulario ) {	
	?> 
 		 <form action="<?php echo $formulario.'?filter=1' ?>" method="post" name="fat" id="fat" accept-charset="UTF-8" > 
    <?php  
 	return true;
	} 		
	// titulo modal header
	function form_buscar_tab($formulario ) {	
	?> 
 		 <form action="<?php echo $formulario.'?filter=1' ?>" method="post" name="qquery" id="qquery" accept-charset="UTF-8" > 
    <?php  
 	return true;
	} 
	// titulo modal header
	function form_evento($evento_form ) {	
 		  echo ' <form method="post" action="'.$evento_form.'" id="fo3" name="fo3" >';
 	return true;
	} 	
	// titulo modal header
	function evento_formulario($evento_form,$inicio ) {	
	  
		//enctype="multipart/form-data" accept-charset="UTF-8"
	  if ($inicio == 'inicio')
 		  echo ' <form action="'.$evento_form.'" method="POST"  id="fo3" name="fo3" enctype="multipart/form-data" accept-charset="UTF-8" >';
	  else
	     if ($evento_form == '/')
		   echo '</div></form>';
		 else
	  	  echo '</div></form>';
		  
 	 return true;
	} 	
	//------------------
	function _formulario($evento_form,$inicio ) {
	    
	    //enctype="multipart/form-data" accept-charset="UTF-8"
	        if ($inicio == 'inicio')
	                echo ' <form action="'.$evento_form.'" method="POST"  id="fo3" name="fo3" enctype="multipart/form-data" accept-charset="UTF-8" >';
	        else
 	                echo '</form>';
	                    
	      return true;
	} 	
	//----------------------
	function _formulario_id($evento_form,$inicio,$id ) {
	    
	    //enctype="multipart/form-data" accept-charset="UTF-8"
	    if ($inicio == 'inicio')
	           echo ' <form action="'.$evento_form.'" method="POST"  id="'.$id.'" name="'.$id.'" enctype="multipart/form-data" accept-charset="UTF-8" >';
	        else
                echo '</form>';
	                    
	     return true;
	} 	
	//------------------
	function evento_formulario_id($evento_form,$inicio,$id ) {
	    
	    //enctype="multipart/form-data" accept-charset="UTF-8"
	    if ($inicio == 'inicio')
	        echo ' <form action="'.$evento_form.'" method="POST"  id="'.$id.'" name="'.$id.'" enctype="multipart/form-data" accept-charset="UTF-8" >';
	    else
	            if ($evento_form == '/')
	                echo '</div></form>';
	                else
	                    echo '</form>';
	                    
	                    return true;
	} 	
  
	
 	// titulo modal header
	function evento_modal($evento_form,$inicio,$name ) {	
	  
	  if ($inicio == 'inicio')
 		  echo ' <form method="post" action="'.$evento_form.'" id="'.$name.'" name="'.$name.'" >';
	  else
	     if ($evento_form == '/')
		   echo '</div></form>';
		 else
	  	  echo '</form>';
		  
 	 return true;
	}    
	function evento_simple($evento_form,$inicio ) {	
	  
	  if ($inicio == 'inicio')
 		  echo ' <form method="post" action="'.$evento_form.'" id="fo311" name="fo311" >';
	  else
	     if ($evento_form == '/')
		   echo '</div></form>';
		 else
	  	  echo '</form>';
		  
 	 return true;
	} 	
	// titulo modal header
	function form_evento_popup($evento_form ) {	
 		  echo ' <form method="post" action="'.$evento_form.'" id="popup" name="popup" accept-charset="utf-8" >';
 	return true;
	} 	
 	
	// titulo modal header
	function tab_end($form ) {	
	   
	  $b = '';
	  if ($form == '</form>'){
		$b = $form;
	  } 
 ?>	
        </div><?php echo $b ?>
       </div>
     </div>
    </div>
  </div>
 <?php
 	   return true;
 	} 	
	
    	// titulo modal header
	function tab_endb( ) {	
 	  echo '</form>';
	} 
    
	// titulo modal header
	function tab_end_body($form ) {	
	  $a = '';
	  $b = '';
	
      if ($form == '</form>'){
		$b = $form;
	  } 
 	
      echo '</div>'.$b.'</div></div></div>';
 	   
	   return true;
 	} 					
	// titulo modal header
	function frame_inicio( ) {	
	?>   
 		<table class="table table-condensed table-hover" width="100%">
         <tr> 
 	<?php	 
			return true;
 	}
	// titulo modal header
	function contenedor($inicio ) {	
	   if ($inicio == 'inicio'){
	?>   
     <style type="text/css">
          table.borderless td,table.borderless th{
    		 border: none !important;
		  }
		}
    </style> 
        
       <table class='table borderless'>
         <tr> 
 	<?php	 
	   }else {
	     echo '</table>';
	    }		
			return true;
 	}	
		// titulo modal header
	function frame_inicio_web( ) {
	?>   
 	  <table class="table table-striped table-hover">
      <tr> 
    <?php
			return true;
 	}
	// titulo modal header
	function table_inicio($ancho ) {	
    ?>   
 	
     <table class="table table-striped table-hover">
      <tr> 

    <?php
 			return true;
 }	
	  /*   SUBTITULO PARA LA OPCION DE LOS FORMULARIOS
	---------------------------------------------------------------------*/
	function titulo($cadena,$columna,$salto){			 	
			echo '<td colspan="'.$columna.'" align="left" valign="middle" bgcolor="#FFFFFF"><b>'.$cadena.'</b></td>';
 			if ($salto == '/'){
					echo '</tr><tr>';
			} 
			return true;
 	}	
	
	function subtitulo($cadena,$columna,$salto){			 	
		
			echo '<td colspan="'.$columna.'" align="left" valign="middle">'.utf8_encode($cadena).'</td>';
 		
			if ($salto == '/'){
					echo '</tr><tr>';
			} 
			
			 if ($salto == '-'){
					echo '</tr>';
			}
			return true;
 	}	
	//--- tab contenedor
	function nav_tabs_contenedor($columna,$tab1,$m1,$tab2,$m2,$tab3,$m3,$tab4,$m4,$tab5,$m5){			 	
	?>	
	  <td colspan=" <?php echo $columna; ?>	" align="left" valign="middle">
 	
     <?php	
		$tab11 = '';
		$tab22 = '';
		$tab33 = '';
		$tab44 = '';
		
		if(!empty($tab1))
			$tab11 = '<li class="active"><a href="#tab_1_1" data-toggle="tab">'.utf8_decode(utf8_encode($m1)).'</a></li>';
		if(!empty($tab2))
			$tab22 = '<li><a href="#tab_1_2" data-toggle="tab">'.utf8_decode(utf8_encode($m2)).'</a></li>';	
		if(!empty($tab3))
			$tab33 = '<li><a href="#tab_1_3" data-toggle="tab">'.utf8_decode(utf8_encode($m3)).'</a></li>';
		if(!empty($tab4))
			$tab44 = '<li><a href="#tab_1_4" data-toggle="tab">'.utf8_decode(utf8_encode($m4)).'</a></li>';	
 		if(!empty($tab5))
			$tab55 = '<li><a href="#tab_1_5" data-toggle="tab">'.utf8_decode(utf8_encode($m5)).'</a></li>';	
	     	
		?>	
		<div class="tabbable tabbable-custom">
		  <ul class="nav nav-tabs"><?php echo $tab11.$tab22.$tab33.$tab44.$tab55 ?></ul> 	
			 <div class="tab-content"> 	
	  <?php	
			 
			return true;
 	}	
		//--- tab contenedor
	function nav_tab($tab1= '',$m1= '',$tab2= '',$m2= '',$tab3= '',$m3= '',$tab4= '',$m4= '',$tab5= '',$m5= ''){			 	
 
		$tab11 = '';
		$tab22 = '';
		$tab33 = '';
		$tab44 = '';
		
		if ($tab1 == '/') {	
			echo '</div></div></div>';
		}
		else
		{	
			if(!empty($tab1))
			    $tab11 = '<li class="active"><a href="#tab_1_1" data-toggle="tab">'.utf8_encode( $m1 ).'</a></li>';
			if(!empty($tab2))
				$tab22 = '<li><a href="#tab_1_2" data-toggle="tab">'. (utf8_encode($m2)).'</a></li>';	
			if(!empty($tab3))
				$tab33 = '<li><a href="#tab_1_3" data-toggle="tab">'. (utf8_encode($m3)).'</a></li>';
			if(!empty($tab4))
				$tab44 = '<li><a href="#tab_1_4" data-toggle="tab">'. (utf8_encode($m4)).'</a></li>';	
			if(!empty($tab5))
				$tab55 = '<li><a href="#tab_1_5" data-toggle="tab">'. (utf8_encode($m5)).'</a></li>';	
				
			?>	
             <div class="col-md-12">     
            <h5>&nbsp;</h5>
			<div class="tabbable tabbable-custom">
			  <ul class="nav nav-tabs"><?php echo $tab11.$tab22.$tab33.$tab44.$tab55 ?></ul> 	
				 <div class="tab-content"> 	
		  <?php	
		}	 
			return true;
 	}	
 	function nav_tab6($tab1= '',$m1= '',
 	                  $tab2= '',$m2= '',
 	                  $tab3= '',$m3= '',
 	                  $tab4= '',$m4= '',
 	                  $tab5= '',$m5= '',
 	                  $tab6= '',$m6= ''){
 	    
 	    $tab11 = '';
 	    $tab22 = '';
 	    $tab33 = '';
 	    $tab44 = '';
 	    
 	    if ($tab1 == '/') {
 	        echo '</div></div>';
 	    }
 	    else
 	    {
 	        if(!empty($tab1))
 	            $tab11 = '<li class="active"><a href="#tab_1_1" data-toggle="tab"><b>'.utf8_encode( $m1 ).'</b></a></li>';
 	            if(!empty($tab2))
 	                $tab22 = '<li><a href="#tab_1_2" data-toggle="tab"><b>'. (utf8_encode($m2)).'</b></a></li>';
 	                if(!empty($tab3))
 	                    $tab33 = '<li><a href="#tab_1_3" data-toggle="tab"><b>'. (utf8_encode($m3)).'</b></a></li>';
 	                    if(!empty($tab4))
 	                        $tab44 = '<li><a href="#tab_1_4" data-toggle="tab"><b>'. (utf8_encode($m4)).'</b></a></li>';
 	                        if(!empty($tab5))
 	                            $tab55 = '<li><a href="#tab_1_5" data-toggle="tab"><b>'. (utf8_encode($m5)).'</b></a></li>';
 	                            if(!empty($tab6))
 	                                $tab66 = '<li><a href="#tab_1_6" data-toggle="tab"><b>'. (utf8_encode($m6)).'</b></a></li>';
 	                            
 	                            ?>
            
			<div class="tabbable tabbable-custom">
			  <ul class="nav nav-pills"><?php echo $tab11.$tab22.$tab33.$tab44.$tab55.$tab66 ?></ul> 	
				 <div class="tab-content"> 	
		  <?php	
		}	 
			return true;
 	}	
	//--- tab contenedor
	function nav_tabs_contenedor_six($columna,$tab1,$m1,$tab2,$m2,$tab3,$m3,$tab4,$m4,$tab5,$m5,$tab6,$m6){			 	
		
		//$titulo = utf8_encode($titulo); 
		  
		echo '<td colspan="'.$columna.'" align="left" valign="middle">';
 		
		$tab11 = '';
		$tab22 = '';
		$tab33 = '';
		$tab44 = '';
		
		if(!empty($tab1))
			$tab11 = '<li class="active"><a href="#tab_1_1" data-toggle="tab">'.utf8_encode($m1).'</a></li>';
		if(!empty($tab2))
			$tab22 = '<li><a href="#tab_1_2" data-toggle="tab">'.utf8_encode($m2).'</a></li>';	
		if(!empty($tab3))
			$tab33 = '<li><a href="#tab_1_3" data-toggle="tab">'.utf8_encode($m3).'</a></li>';
		if(!empty($tab4))
			$tab44 = '<li><a href="#tab_1_4" data-toggle="tab">'.utf8_encode($m4).'</a></li>';	
 		if(!empty($tab5))
			$tab55 = '<li><a href="#tab_1_5" data-toggle="tab">'.utf8_encode($m5).'</a></li>';	
	    if(!empty($tab6))
			$tab66 = '<li><a href="#tab_1_6" data-toggle="tab">'.utf8_encode($m6).'</a></li>';	
		
		$a = '<div class="tabbable tabbable-custom">
			   <ul class="nav nav-tabs">'.$tab11.$tab22.$tab33.$tab44.$tab55.$tab66.'</ul> 	
			 <div class="tab-content">';
		
		echo $a;
			 
			return true;
 	}
	
	function subtitulo_col2($msg1,$cadena1,$msg2,$cadena2,$salto){			 	
			$columna = 2;
			
			echo '<td align="right" valign="middle">'.$msg1.'</td>';
			
			echo '<td align="left" valign="middle">'.$cadena1.'</td>';
			
			echo '<td align="right" valign="middle">'.$msg2.'</td>';
			
			echo '<td align="left" valign="middle">'.$cadena2.'</td>';
			
			 
 			if ($salto == '/'){
					echo '</tr><tr>';
			} 

 			if ($salto == '-'){
					echo '</tr>';
			}
						
			return true;
 	}	
  	
      function colspan_8($columna,$msg1,$msg2,$salto){			 	
			$columna = 2;
			
			echo '<td colspan="'.$columna.'"  align="right" valign="middle">'.$msg1.'</td>';
			
			echo '<td  align="right" valign="middle">'.$msg2.'</td>';
			
		  	 
 			if ($salto == '/'){
					echo '</tr><tr>';
			} 

 			if ($salto == '-'){
					echo '</tr>';
			}
					 
			return true;
 	}	  
 
		// titulo modal header
	function tab_footer_end( ) {
?>
    </div></div>
<?php    
	return true;
	}  
		// titulo modal header del sub tab
	function nav_tabs_inicio($tab,$activo ) {	
 			$a = '<div class="tab-pane '.$activo .'" id="'.$tab.'"> <br>';
 			echo $a;
	return true;
	}  	
	function nav_tabs_cierre()
	 {	
 			$a = '</div>';
 			echo $a;
	return true;
	} 	
	function nav_tabs_close()
	 {	
 			$a = '</div></div>';
 			echo $a;
	return true;
	} 	
	
	function nav_tabs_close_contenedor($salto)
	 {	
 	
		if ($salto = '/'){	
		  $s = '</tr>';
		}
		else{
		 $s = '';	
		}
			$a = '</div></div></td>'.$s;
 	
			echo $a;
			
	return true;
	} 	

  //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 function carga_grilla($div,$url,$tipo ){
  
  $variable ='';  
  $ejecuta = ''; 
   
   if ($tipo == 1){ 
    // $variable = "  window.document.getElementById('action').value = 'query';  ";
     $variable = "?query=1";
   
     $ejecuta = '  var query = 1;
     
                   var parametros = {
					"query" : query 
			         }; ';
   } 
    
    
  echo '<script type="text/javascript">';
  echo "  $.ajax({
                
                url:   ' controller/INVAD05_query.php',
                type:  'POST',".'
                beforeSend: function () {
                        $("#GRILLA_QUERY").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        $("#GRILLA_QUERY").html(response);
                }'."
        });";
  echo '</script>'; 
 
  } 
   //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_row($inicio_fin)
	 {	
 	   
       if ($inicio_fin == 'inicio')
        echo '<div class="row">';
       else 
        echo '</div>'; 
			
	return true;
	} 
  //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_row3($inicio_fin)
	 {	
 	   
       if ($inicio_fin == 'inicio')
        echo '<div class="col-md-3"> ';
       else 
        echo '</div>'; 
			
	return true;
	}  
	  //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_label($columna,$titulo)
	 {	
 
        echo '<div class="col-md-'.$columna.'"  
                style="border-bottom: 3px solid #a6cbd6;  
                       margin-top: 10px; ;color:#337ab7;
                       margin-bottom: 20px;font-size: 12px" >'.strtoupper( $titulo).'</div>'; 
 
        //<div class="col-md-12" style=" border-bottom: 1px solid #8197e6;" > saludos  </div>  
        
        
	return true;
	}      
	function div_htitulo($columna,$titulo,$negrita="N")
	{
	   if ( $negrita == 'N')  	{
	    echo '<h'.$columna.">".$titulo.'</h'.$columna.'>';
	  }else    
	  {
	    echo '<h'.$columna."><b>".$titulo.'</b></h'.$columna.'>';
	  }
	    return true;
	}  
//
	function div_labelmin($columna,$titulo)
	{
	    
	    echo '<div class="col-md-'.$columna.'"
                style="border-bottom: 3px solid #a6cbd6;
                       margin-top: 10px; ;color:#337ab7;
                       margin-bottom: 20px;font-size: 12px" >'.trim( $titulo).'</div>';
	    
	    //<div class="col-md-12" style=" border-bottom: 1px solid #8197e6;" > saludos  </div>
	    
	    
	    return true;
	}  
	//----------------
	
	function div_panel($titulo)
	{
	  
	    if ($titulo  <>  'fin'){
	        echo '<div class="panel panel-info">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div>';
	    } 
	     
	    return true;
	}   
//------------------------	
	function div_panel6($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-6"><div class="panel panel-info">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	//----
	function div_panel3($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-3"><div class="panel panel-info">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	//---
	function div_panel9($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-9"><div class="panel panel-info">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	function div_panel7($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-7"><div class="panel panel-info">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	 
	function div_panel5($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-5"><div class="panel panel-info">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	
	function div_panel4($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-4"><div class="panel panel-info">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	
	function div_panel8($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-8"><div class="panel panel-default">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	
	function div_panel10($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-10"><div class="panel panel-default">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	
	function div_panel12($titulo)
	{
	    
	    if ($titulo  <>  'fin'){
	        echo '<div class="col-md-12"><div class="panel panel-default">  <div class="panel-heading">'.$titulo.'</div> <div class="panel-body">';
	    }else {
	        echo '</div></div></div>';
	    }
	    
	    return true;
	}
	
   //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_row9($inicio_fin)
	 {	
 	   
       if ($inicio_fin == 'inicio')
        echo '<div class="col-md-9">';
       else 
        echo '</div>'; 
			
	return true;
	}   
    function div_row12($inicio_fin)
	 {	
 	   
       if ($inicio_fin == 'inicio')
        echo '<div class="col-md-12">';
       else 
        echo '</div>'; 
			
	return true;
	}  
    //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_row6($inicio_fin)
	 {	
 	   
       if ($inicio_fin == 'inicio')
        echo '<div class="col-md-6">';
       else 
        echo '</div>'; 
			
	return true;
	}      

   //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_lateral($inicio_fin,$titulo)
	 {	
 	   
       if ($inicio_fin == 'inicio'){
	   ?>
        	<div class="col-md-3">
            	<div class="box box-solid">
                    <div class="box-header with-border">
                      <h5 class="box-title">  <?php echo $titulo  ?></h5>
                    </div> 
                    <div class="box-body no-padding">
                      <ul class="nav nav-pills nav-stacked">
       <?php
	    }
       else {
	    ?>
        			 </ul> 
            	</div><!-- /.box-body --> 
        	 </div><!-- /. box -->
           </div><!-- /.col -->
		 <?php
         }	
	return true;
	} 
  //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_lateralscroll($inicio_fin,$titulo,$alto)
	 {	
 	   
       if ($inicio_fin == 'inicio'){
	   ?>
		<style type="text/css">
        div.scroll_vertical {
            height: 36s0px;
            width: 100%;
            overflow: auto;
            border: 0px solid #666;
        }
        </style>

        	<div class="col-md-3">
              
            	  <div class="box box-solid">
                   <div class="box-header with-border">
                      <h5 class="box-title">  <?php echo $titulo  ?></h5>
                    </div> 
                   
                    <div class="box-body no-padding">
                     <div class="scroll_vertical">
                      <ul class = "nav nav-pills">
       <?php
	    }
       else {
	    ?>
        			 </ul> 
                   </div><!-- /.box-body  <ul class="nav nav-pills nav-stacked">   
                   <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205"> <ul class="nav nav-pills nav-stacked"> -->   
               </div>
            	
                </div><!-- /.box-body --> 
        	 </div><!-- /. box -->
           
		 <?php
         }	
	return true;
	} 	
     //-----------------------------------------------------------------------------------------
   // titulo div para posicion lateral de la pantalla
   //-----------------------------------------------------------------------------------------
	function div_contenedor9($inicio_fin,$titulo)
	 {	
	 
	 // <div class="table-responsive mailbox-messages"> </div>
 	   
       if ($inicio_fin == 'inicio')
        echo '<div class="col-md-9">
              <div class="box box-primary">
			    <div class="box-header with-border">
                  <h5 class="box-title">'.$titulo.'</h5>
                </div><!-- /.box-header -->
                 
			    <div class="box-body no-padding"> ';
       else 
	   
        echo ' 
                  </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->'; 
			
	return true;
	}     

	// titulo modal header
	function form_evento_ajax($evento_form ) {	
 		  echo ' <form method="post" action="'.$evento_form.'" id="fat" name="fat" >';
 	return true;
	} 
	
// titulo modal header
	function table_fin_evento( $form ) {	
	   
      $a = '';
	  if ($form == '</form>'){
		$a = $form;
	  } 
      
      	echo '</tr></table><hr>'.$a ;
 	 
 	return true;
	} 		
	
}		
?>