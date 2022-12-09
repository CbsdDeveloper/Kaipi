 var options = {
                    chart: {
                        renderTo: 'div_gasto',
                        type: 'line'
                    },
                    title: {
                        text: 'Resumen de Disponibilidad por Periodo',
                        x: -20 //center
                    },
               /*     subtitle: {
                        text: 'Source: WorldClimate.com',
                        x: -20
                    },*/
                    xAxis: {
                        categories: [],
                        title: {
                            text: 'Mes'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Gasto'
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
				
              $.getJSON("../grilla/gasto.php", function(json) {

                    options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}

                    options.series[0] = json[1];

                    options.series[1] = json[2];

 
                    chart = new Highcharts.Chart(options);

                });
            
 
 