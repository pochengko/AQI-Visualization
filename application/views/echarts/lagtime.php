<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例

var myChart = echarts.init(document.getElementById('main'));
var dataAllMap = new Map();
	$(document).ready(function(){
    $.ajax({
        url: "echarts/getlagtime",
        type: "POST",
        dataType: "json",
        cache: false,
        success: function(data) {
					data.map(function(item) {
						//console.log(item);
					});
					showChart(data);
        }
    });
	});

function showChart(data) {
    myChart.setOption(option = {
			title: {
				text: 'Pollutant Lag Time'
			},
			tooltip: {
				trigger: 'axis',
				axisPointer: {
					type: 'cross'
				}
			},
      grid: {
        x: '3%',
        x2: 30,
        y: '10%',
        y2: '10%'
      },
			toolbox: {
				feature: {
					dataView: {
						show: true,
						readOnly: true
					}
				}
			},
			dataZoom: [{
				startValue: '1'
			}, {
				type: 'inside'
			}],
			legend: {
				data: ['SO2','CO','O3','PM10','PM25','NO2','NOx','NO']
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: data.map(function(item) {
					return item.lag_week + '周'
				})
			}],
			yAxis: [{
				  type: 'value',
				  nameTextStyle: {
				  	color: '#000'
				  },
				  name: 'P-Value',
				  min: 0.00,
				  max: 1.00,
				  position: 'left',
				  axisLine: {
				  	lineStyle: {
				  		color: '#000'
				  	}
				  },
				  axisLabel: {
				  	formatter: '{value} '
				  }
			  }
			],
			series: [{
					name: 'SO2',
					type: 'line',
					data: data.map(function(item) {
						return item.SO2
					}),
          markLine: {
            silent: true,
            data: [{
              yAxis: 0.05,
              color: '#000'
            }]
          }
				},{
				name: 'CO',
					type: 'line',
					data: data.map(function(item) {
						return item.CO
					}),
					markLine: {
            silent: true,
            data: [{
              yAxis: 0.05,
              color: '#000'
            }]
          }
				},{
					name: 'O3',
					type: 'line',
					data: data.map(function(item) {
						return item.O3
					}),
					markLine: {
            silent: true,
            data: [{
              yAxis: 0.05,
              color: '#000'
            }]
          }
				},{
					name: 'PM10',
					type: 'line',
					data: data.map(function(item) {
						return item.PM10
					}),
					markLine: {
            silent: true,
            data: [{
              yAxis: 0.05,
              color: '#000'
            }]
          }
				},{
					name: 'PM25',
					type: 'line',
					data: data.map(function(item) {
						return item.PM25
					}),
				},{
					name: 'NO2',
					type: 'line',
					data: data.map(function(item) {
						return item.NO2
					}),
					markLine: {
            silent: true,
            data: [{
              yAxis: 0.05,
              color: '#000'
            }]
          }
				},{
					name: 'NOx',
					type: 'line',
					data: data.map(function(item) {
						return item.NOx
					}),
				},{
					name: 'NO',
					type: 'line',
					data: data.map(function(item) {
						return item.NO
					}),
					markLine: {
            silent: true,
            data: [{
              yAxis: 0.05,
              color: '#000'
            }]
          }
				}
			]
		});
		window.onresize = function() {
			myChart.resize();
		};

	}
</script>
