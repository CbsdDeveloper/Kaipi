 var options = {
                    chart: {
                        renderTo: 'div_grafico',
                        type: 'line'
                    },
                    title: {
                        text: 'Compras Mensuales',
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
				
                $.getJSON("../grilla/compra_inv_mensual.php", function(json) {
                    options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
                    options.series[0] = json[1];
                    chart = new Highcharts.Chart(options);
                });
            
            
 
 