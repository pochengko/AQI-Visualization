<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例

var myChart = echarts.init(document.getElementById('main'));
var dataAllMap = new Map();
	$(document).ready(function(){
    var area = 'all';
    $.ajax({
        url: "echarts/getiliaqiarea",
        type: "GET",
        data: {
          Area: area
        },
        dataType: "json",
        cache: false,
        success: function(data) {
					data.map(function(item) {
						//console.log(item);
					});
					showChart(data, area);
        }
    });
	});

function showChart(data, area) {
		var colors = ['#ebafad', '#becfda', '#bdd7db', '#e9bfaf', '#bbddcd', '#c3d5c9',
									'#c23531', '#2f4554', '#61a0a8', '#d48265', '#448868', '#749f83'];
    myChart.setOption(option = {
			title: {
				text: 'ILI, AQI'
			},
			color: colors,
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
					},
					/*restore: {
						show: true
					},*/
					saveAsImage: {
						show: true
					}
				}
			},
			dataZoom: [{
				startValue: '201601'
			}, {
				type: 'inside'
			}],
			legend: {
				data: ['ILI_Taipei', 'ILI_North', 'ILI_Central', 'ILI_South', 'ILI_Kaoping', 'ILI_East', 'AQI_Taipei', 'AQI_North', 'AQI_Central', 'AQI_South', 'AQI_Kaoping', 'AQI_East']
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: data.map(function(item) {
					return item.Year
				})
			}],
			yAxis: [{
				  type: 'value',
				  nameTextStyle: {
				  	color: '#000'
				  },
				  name: 'AQI',
				  min: 0,
				  max: 180,
				  position: 'right',
				  axisLine: {
				  	lineStyle: {
				  		color: '#000'
				  	}
				  },
				  axisLabel: {
				  	formatter: '{value} '
				  }
			  },
				{
					type: 'value',
					name: 'ILI',
					min: 0,
					max: 30,
					position: 'left',
					axisLine: {
						lineStyle: {
							color: colors[6]
						}
					},
					axisLabel: {
						formatter: '{value}'
					}
				}
			],
			series: [{
					name: 'ILI_Taipei',
					type: 'bar',
					yAxisIndex: 1,
					data: data.map(function(item) {
						return item.ILI_Taipei;
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				},
        {
  				name: 'ILI_North',
  				type: 'bar',
					yAxisIndex: 1,
  				data: data.map(function(item) {
						return item.ILI_North;
					}),
  				markPoint: {
  					data: [
  						{type: 'max', name: '最大值', symbolSize: 70},
  						{type: 'min', name: '最小值', symbolSize: 70}
  					]
  				}
  			},
        {
  				name: 'ILI_Central',
  				type: 'bar',
					yAxisIndex: 1,
  				data: data.map(function(item) {
						return item.ILI_Central;
					}),
  				markPoint: {
  					data: [
  						{type: 'max', name: '最大值', symbolSize: 70},
  						{type: 'min', name: '最小值', symbolSize: 70}
  					]
  				}
  			},{
  				name: 'ILI_South',
  				type: 'bar',
					yAxisIndex: 1,
  				data: data.map(function(item) {
						return item.ILI_South;
					}),
  				markPoint: {
  					data: [
  						{type: 'max', name: '最大值', symbolSize: 70},
  						{type: 'min', name: '最小值', symbolSize: 70}
  					]
  				}
  			},{
  				name: 'ILI_Kaoping',
  				type: 'bar',
					yAxisIndex: 1,
  				data: data.map(function(item) {
						return item.ILI_Kaoping;
					}),
  				markPoint: {
  					data: [
  						{type: 'max', name: '最大值', symbolSize: 70},
  						{type: 'min', name: '最小值', symbolSize: 70}
  					]
  				}
  			},{
  				name: 'ILI_East',
  				type: 'bar',
					yAxisIndex: 1,
  				data: data.map(function(item) {
						return item.ILI_East;
					}),
  				markPoint: {
  					data: [
  						{type: 'max', name: '最大值', symbolSize: 70},
  						{type: 'min', name: '最小值', symbolSize: 70}
  					]
  				}
  			},{
					name: 'AQI_Taipei',
					type: 'bar',
					data: data.map(function(item) {
						return item.AQI_Taipei
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				},{
				name: 'AQI_North',
					type: 'bar',
					data: data.map(function(item) {
						return item.AQI_North
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				},{
					name: 'AQI_Central',
					type: 'bar',
					data: data.map(function(item) {
						return item.AQI_Central
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				},{
					name: 'AQI_South',
					type: 'bar',
					data: data.map(function(item) {
						return item.AQI_South
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				},{
					name: 'AQI_Kaoping',
					type: 'bar',
					data: data.map(function(item) {
						return item.AQI_Kaoping
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				},{
					name: 'AQI_East',
					type: 'bar',
					data: data.map(function(item) {
						return item.AQI_East
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				}
			]
		});
		window.onresize = function() {
			myChart.resize();
		};

	}
</script>
