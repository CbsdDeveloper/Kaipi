
$(document).ready(function() {
	
 
    	
        _barra('../grilla/grafico_inicio.php?tipo=1' , 'ViewUnidad', '  ' );
        
           
       /*	   _pie('../grilla/grafico_inicio?tipo=4&anio='+anio , 'div_grafico_gasto_4', '  ' );   */
});
//------------------------------------------------------------------
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
                font: 'normal 7px Verdana, sans-serif',
                color : '#A0A0A0'
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
                showInLegend: true
           },
           style: {
               font: 'normal 7px Verdana, sans-serif',
               color : '#A0A0A0'

           }
       },
       legend: {
         	   itemStyle: {
        		   fontSize:'8px',
                   font: '8pt Trebuchet MS, Verdana, sans-serif',
                   color: '#A0A0A0'
                },
               shadow: false
            },
       series: []
   };

 
	Highcharts.setOptions({
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
	    })
	});

 $.getJSON(jsondato, function(json) {
       options.series = json;
       chart = new Highcharts.Chart(options);
   });
}
//------------------------------------------------------------------
function _pie2(jsondato,div_grafico, titulo_grafico )  {

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
	                font: 'normal 7px Verdana, sans-serif',
	                color : '#A0A0A0'
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
	                showInLegend: true
	           },
	           style: {
	               font: 'normal 7px Verdana, sans-serif',
	               color : '#A0A0A0'

	           }
	       },
	       legend: {
	         	   itemStyle: {
	        		   fontSize:'8px',
	                   font: '8pt Trebuchet MS, Verdana, sans-serif',
	                   color: '#A0A0A0'
	                },
	               shadow: false
	            },
	       series: []
	   };

	 	

	 $.getJSON(jsondato, function(json) {
	       options.series = json;
	       chart = new Highcharts.Chart(options);
	   });
	 
	 
	  
	}
//------------------------------------------------------------------
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
		 chart = new Highcharts.Chart(options);
});
 
}
//------------------------------------------------------------------
function _barra(url_json, div_grafico  , titulo_tipo  )  {

var options = {
       chart: {
           renderTo: div_grafico,
           type: 'bar'
       },
       title: {
           text: titulo_tipo,
           x: -5 ,//center
           style: {
               font: 'normal 9px Verdana, sans-serif',
               color : '#A0A0A0'
           }
       },
       subtitle: {
         /*  text: ' xx ',*/
           x: -20
       },
       xAxis: {
           categories: [],
           labels: {
   			style: {
   				fontSize: '8px',
   				color: '#A0A0A0'
   			}
   		   }
        },
       yAxis: {
           title: {
               text: ' '
           },
           labels: {
      			style: {
      				fontSize: '8px',
      				color: '#A0A0A0'
      			}
      		   },
            plotLines: [{
                   value: 0,
                   width: 1,
                   color: '#A0A0A0' 
               }]
       },
       tooltip: {
           headerFormat: '<span style="font-size:9px">{series.name}</span><br>',
           pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> total<br/>'
       },
       plotOptions: {
            bar: {
               dataLabels: {
                    enabled: true,
				   	style: {
				    	fontSize:'8px'
				    }
               }   
             } ,
             series: {
            	 pointPadding: 0, 
                 groupPadding: 0.01 ,
                 pointWidth: 10
             }
              
        },
       credits: {
           enabled: false
       },
       legend: {
       /*    layout: 'vertical',
           align: 'right',
           verticalAlign: 'top',
           x: -40,
           y: 50,
           floating: true,
           borderWidth: 0,
           backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),*/
    	   itemStyle: {
    		   fontSize:'8px',
               font: '8pt Trebuchet MS, Verdana, sans-serif',
               color: '#A0A0A0'
            },
           shadow: false
        },
       series: []
   };


	  $.getJSON(url_json, function(json) {
	       options.xAxis.categories = json[0]['data'];
		   options.series[0] = json[1];
           chart = new Highcharts.Chart(options);
});
 
}
