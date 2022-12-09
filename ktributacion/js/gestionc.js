 var optionsv = {
                    chart: {
                        renderTo: 'div_compras',
                        type: 'line'
                    },
                    title: {
                        text: ' ',
                       // x: -20 //center
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
                            text: 'Compras'
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
				
                $.getJSON("../grilla/grafico_compras.php", function(json) {
                	optionsv.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
                	optionsv.series[0] = json[1];
                	optionsv.series[1] = json[2];
                	optionsv.series[2] = json[3];
                    chart = new Highcharts.Chart(optionsv);
                });
            
            
 
 