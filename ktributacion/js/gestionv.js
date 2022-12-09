 var options = {
                    chart: {
                        renderTo: 'div_grafico',
                        type: 'line'
                    },
                    title: {
                        text: ' ',
                        //x: -20 //center
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
                            text: 'Ventas'
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
				
                $.getJSON("../grilla/grafico_ventas.php", function(json) {
                    options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
                    options.series[0] = json[1];
                    options.series[1] = json[2];
                    options.series[2] = json[3];
                    chart = new Highcharts.Chart(options);
                });
            
            
 
 