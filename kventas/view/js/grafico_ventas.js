$(document).ready(function() {

	
	  $('#loadGrafico').on('click',function(){
		   
		 
 
		  
		  _pie('../grilla/grafico_reporteVentas?tipo=1' , 'div_grafico_caja', '  ' );
		  
		  _pie('../grilla/grafico_reporteVentas?tipo=2' , 'div_grafico_productos', '  ' );
		
		  
		  
		  _barra('../grilla/grafico_reporteVentas.php?tipo=3','div_grafico_mensual', ' ');
		  
		  
		  _pie('../grilla/grafico_reporteVentas?tipo=4' , 'div_grafico_cliente', '  ' );
			
		  
		  
		  	
	});
 
    
});

function _pie(jsondato,div_grafico, titulo_grafico )  {

var options = {
       chart: {
           renderTo: div_grafico,
           plotBackgroundColor: null,
           plotBorderWidth: null,
           plotShadow: false,
           type: 'pie'
       },
       title: {
           text: titulo_grafico,
           style: {
                font: 'normal 10px Verdana, sans-serif',
                color : 'black'
            }
       },
       tooltip: {
           pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled: false
        },
       plotOptions: {
           pie: {
          	  allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: false,
                style: {
                    font: 'normal 10px Verdana, sans-serif',
                    color : 'black'

                }
           },
          
            style: {
               font: 'normal 10px Verdana, sans-serif',
               color : 'black'

           }
       },
       series: []
   };

 $.getJSON(jsondato, function(json) {
       options.series = json;
       chart = new Highcharts.Chart(options);
   });
}

function _linea(url_json, div_grafico  , titulo_tipo  )  {

var options = {
        chart: {
            renderTo: div_grafico,
            type: 'line'
        },
        title: {
            text: titulo_tipo,
            x: -10 ,//center
            style: {
                font: 'normal 12px Verdana, sans-serif',
                color : 'black'
            }
        },
   /*     subtitle: {
            text: 'Source: WorldClimate.com',
            x: -20
        },*/
        xAxis: {
            categories: [],
            title: {
                text: 'Referencia'
            }
        },
        yAxis: {
            title: {
                text: 'Nro'
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
        },
        credits: {
            enabled: false
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: []
    };



	  $.getJSON(url_json, function(json) {
	       options.xAxis.categories = json[0]['data'];
		   options.series[0] = json[1];
		   options.series[1] = json[2];
		   options.series[2] = json[3];
         chart = new Highcharts.Chart(options);
});
	


}
//-----
function _barra(url_json, div_grafico  , titulo_tipo  )  {

var options = {
       chart: {
           renderTo: div_grafico,
           type: 'bar'
       },
       title: {
           text: titulo_tipo,
           x: -10 ,//center
           style: {
               font: 'normal 12px Verdana, sans-serif',
               color : 'black'
           }
       },
       subtitle: {
           text: '  ',
           x: -20
       },
       xAxis: {
           categories: []
       },
       yAxis: {
           title: {
               text: ' '
           },
           plotLines: [{
                   value: 0,
                   width: 1,
                   color: '#808080'
               }]
       },
       tooltip: {
           headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
           pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> of total<br/>'
       },
       plotOptions: {
           bar: {
               dataLabels: {
                   enabled: false
               }
           }
       },
       credits: {
           enabled: false
       },
       legend: {
           layout: 'vertical',
           align: 'right',
           verticalAlign: 'top',
           x: -40,
           y: 50,
           floating: true,
           borderWidth: 1,
           backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
           shadow: false
       },
       series: []
   };


	  $.getJSON(url_json, function(json) {
	       options.xAxis.categories = json[0]['data'];
		   options.series[0] = json[1];
		   options.series[1] = json[2];
		   options.series[2] = json[3];
         chart = new Highcharts.Chart(options);
});
	


}

  