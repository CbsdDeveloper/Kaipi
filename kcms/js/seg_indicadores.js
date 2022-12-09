$(document).ready(function() {
	
	
	  "use strict";
		
	 
	     
	     _pie('../model/Model-seg_grafico.php?tipo=1' , 'ganio', '' );
	     
	     
	     _pie('../model/Model-seg_grafico.php?tipo=2' , 'gestado_tramite', '' );
	   
	     
	     _pie('../model/Model-seg_grafico.php?tipo=4' , 'gcumplimiento', '  ' );
	     
	     
	     
	     _pie('../model/Model-seg_grafico.php?tipo=6' , 'gexamen', '  ' );
	     
	     
	     
	     
	     _barra('../model/Model-seg_grafico.php?tipo=7', 'gunidad_tramite'  , '   ' ) 
	     
	     
	           
	     _grilla('../model/Model-seg_grafico.php', 5 ,'#gunidadBarras', 'Gestion por Unidad' ); 
	     
	     
	   
	     
});

function _pie(jsondato,div_grafico, titulo_grafico )  {
	 
	 var options = {
			 colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
			        return {
			            radialGradient: {
			                cx: 0.5,
			                cy: 0.3,
			                r: 0.7
			            },
			            stops: [
			                [0, color],
			                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
			            ]
			        };
			    }),
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
                     font: 'normal 11px Verdana, sans-serif',
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
                         enabled: true
                     },
                     showInLegend: false,
                },
                style: {
                    font: 'normal 8px Verdana, sans-serif',
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
//----------------------------
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
	
 
	var options1 = {
            chart: {
                renderTo: div_grafico,
                type: 'bar'
            },
            title: {
                text: ' ',
                x: -10 ,//center
                style: {
                    font: 'normal 11px Verdana, sans-serif',
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
                 y: 80,
                 floating: true,
                 borderWidth: 1,
                 backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                 shadow: true
            },
            series: []
        };
 

		  $.getJSON(url_json, function(json) {
		       options1.xAxis.categories = json[0]['data'];
			   options1.series[0] = json[1];
			    options1.series[1] = json[2];
	            options1.series[2] = json[3];
	            options1.series[3] = json[4];
	          chart = new Highcharts.Chart(options1);
    });
 
}

 

//----------   _grilla('../model/model_grafico02.php?tipo=1.' , 'tipo1', ' 1. Tipo de vivienda' ); 

function _grilla( urlEnvio,tipo,vjquery,nombre )
{
   	
	"use strict";
 
   var parametros = {
			'tipo' : tipo,
			'nombre':nombre
	};
   
	$.ajax({
				data:  parametros,
				url:   urlEnvio,
				type:  'GET' ,
					beforeSend: function () { 
							$(vjquery).html('Procesando');
					},
				success:  function (data) {
						 $(vjquery).html(data);   
					     
					} 
		}); 

 
	
}
