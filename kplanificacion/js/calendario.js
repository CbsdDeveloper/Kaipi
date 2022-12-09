
var jq = $.noConflict();
 

jq(document).ready(function() {
		
	jq('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'listDay,agendaDay,listWeek'
		},
		views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		},
 		defaultView: 'listWeek',
		//defaultDate: '2017-10-12',
		editable: false,
		navLinks: true, // can click day/week names to navigate views
		eventLimit: true, // allow "more" link when too many events
		events: {
			url: '../model/get-events.php',
			error: function() {
				$('#script-warning').show();
			}
		},
		loading: function(bool) {
			$('#script-warning').toggle(bool);
		}
	});
	
	
	 
		
	});