 
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    
    if(dd < 10){
        dd='0'+ dd
    } 
    if(mm < 10){
        mm='0'+ mm
    } 
  
    var fecha = yyyy + '-' + mm + '-' + dd;
 
     var cadena = '';
 
 	
 	 var initialLocaleCode = 'es';
	 
	 			$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay,listMonth'
					},
					defaultDate: fecha,
					  navLinks: true, // can click day/week names to navigate views
				      businessHours: true, // display business hours
				      editable: false,
				      defaultView: 'agendaDay',
					events: {
						url: '../model/calendario_seg.php',
						error: function() {
							$('#warning_c').show();
						}
					},
				 	   eventClick: function(event) {
				 		 
				 		   cadena =  '<h5><b>' + event.title +'</b><br><br>' + 
				 		  		    'Evento: ' + event.evento + '<br>' + 
				 		  		    'Producto: ' + event.producto + '<br>' + 
				 		  		    'Fecha: ' + event.start.format("DD-MM-YYYY hh:mm")
				 		  		    + '</h5>';
				 		   
				 		    $('#e_actividad').html(cadena);    
				 	 
			                
			                $('#myModalEmail').modal('show');
				 	 	 
 				        return false;
				      } 
				});
 
 
//-----------------------------------------

/*
function Calendario_seguimientoFull() {
	
	 
	var fecha = fecha_hoy();
	
	 			$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay,listMonth'
					},
					defaultDate: fecha,
					navLinks: true, // can click day/week names to navigate views
					selectHelper: true,
					defaultView: 'agendaWeek',
 					editable: false,
					selectable: true,
					weekNumbers: true,
 					eventLimit: true, // allow "more" link when too many events
					events: {
						url: '../model/calendario_seg.php',
						error: function() {
							$('#script-warning').show();
						}
					},
					loading: function(bool) {
						$('#script-warning').toggle(bool);
					},
				 	   eventClick: function(event) {
				        // opens events in a popup window
				          window.open(event.url, 'gcalevent', 'width=700,height=600');
 				        return false;
				      } 
				});
	
}
*/