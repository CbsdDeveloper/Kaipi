<?php
session_start();

 
    
 echo '<div class="list-group">
 <a href="#" class="list-group-item active">Tipos de Documentos habilitados</a>
 <a href="#"  onClick="HistorialDoc('."'Memo'".')"  class="list-group-item">Memorandum</a>
 <a href="#"  onClick="HistorialDoc('."'Circular'".')" class="list-group-item">Memorandum Circular</a>
 <a href="#"  onClick="HistorialDoc('."'Informe'".')" class="list-group-item">Oficio</a>
 <a href="#"  onClick="HistorialDoc('."'Notificacion'".')" class="list-group-item">Informe</a>
</div>';
 
     
?>
 