<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例

var myChart = echarts.init(document.getElementById('main'));
var dataAllMap = new Map();
	$(document).ready(function(){
    $.ajax({
        url: "echarts/getiliaqi",
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
		var colors = ['#ebafad', '#becfda', '#bdd7db', '#e9bfaf', '#bbddcd', '#c3d5c9',
									'#c23531', '#2f4554', '#61a0a8', '#d48265', '#448868', '#749f83'];
    myChart.setOption(option = {
			title: {
				text: 'AQI, ILI'
			},
			color: colors,
			tooltip: {
				trigger: 'axis',
				axisPointer: {
					type: 'cross'
				}
			},
      grid: {
        x: 35,
        x2: 30,
        y: '10%',
        y2: '12%'
      },
			toolbox: {
				feature: {
					dataView: {
						show: false,
						readOnly: true
					},
					/*restore: {
						show: true
					},*/
					saveAsImage: {
						show: false
					}
				}
			},
			dataZoom: [{
				startValue: '201601'
			}, {
				type: 'inside'
			}],
			legend: {
				type: 'scroll',
				data: ['AQI_Taipei', 'AQI_North', 'AQI_Central', 'AQI_South', 'AQI_Kaoping', 'AQI_East', 'ILI_Taipei', 'ILI_North', 'ILI_Central', 'ILI_South', 'ILI_Kaoping', 'ILI_East']
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: data.map(function(item) {
					return item.Period + '周'
				})
			}],
			yAxis: [{
					type: 'value',
					name: 'ILI',
					min: 0,
					max: 30,
					position: 'right',
					axisLine: {
						lineStyle: {
							color: colors[0]
						}
					},
					axisLabel: {
						formatter: '{value}'
					}
				},
				{
					type: 'value',
					nameTextStyle: {
						color: '#000'
					},
					name: 'AQI',
					min: 0,
					max: 180,
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
					name: 'AQI_Taipei',
					type: 'bar',
					yAxisIndex:1,
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
					yAxisIndex: 1,
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
					yAxisIndex: 1,
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
					yAxisIndex: 1,
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
					yAxisIndex: 1,
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
					yAxisIndex: 1,
					data: data.map(function(item) {
						return item.AQI_East
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 70},
							{type: 'min', name: '最小值', symbolSize: 70}
						]
					}
				},{
						name: 'ILI_Taipei',
						type: 'line',
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
	  				type: 'line',
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
	  				type: 'line',
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
	  				type: 'line',
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
	  				type: 'line',
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
	  				type: 'line',
	  				data: data.map(function(item) {
							return item.ILI_East;
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
