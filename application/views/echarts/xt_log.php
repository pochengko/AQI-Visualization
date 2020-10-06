<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例
var today = new Date();
var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+(today.getDate()-10);
var myChart = echarts.init(document.getElementById('main'));
var dataAllMap = new Map();
	$(document).ready(function(){
    $.ajax({
        url: "echarts/gethourlyxt",
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
		var colors = ['#00b300', '#0080ff', '#9999ff', '#e9bfaf', '#669999', '#bf4040',
									'#ff8000', '#b3b300', '#ff80ff'];
    myChart.setOption(option = {
			title: {
				text: '西屯'
			},
			color: colors,
			tooltip: {
				trigger: 'axis',
				axisPointer: {
					type: 'cross'
				}
			},
      grid: {
        x: '4%',
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
					},
					saveAsImage: {
						show: true
					}*/
				}
			},
			dataZoom: [{
				//startValue: date+' 00:00'
        startValue: '2017-12-01 00:00'
			}, {
				type: 'inside'
			}],
			legend: {
				data: ['AQI(log)', 'SO2(log)', 'CO(log)', 'O3(log)', 'PM10(log)', 'PM2.5(log)', 'NO2(log)', 'NOx(log)', 'NO(log)']
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: data.map(function(item) {
					return item.PublishTime
				})
			}],
			yAxis: [{
					type: 'value',
					name: 'Value (log)',
					min: -3,
					max: 6,
					position: 'left',
					axisLine: {
						lineStyle: {
							color: '#000'
						}
					},
					axisLabel: {
						formatter: '{value}'
					}
				},
				/*{
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
				}*/
			],
      // data: ['AQI', 'SO2', 'CO', 'O3', 'PM10', 'PM25', 'NO2', 'NOx', 'NO']
			series: [{
						name: 'AQI(log)',
						type: 'line',
						data: data.map(function(item) {
							if (Math.log(item.AQI).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.AQI).toFixed(2);
							}
							//return formatFloat(Math.log(item.AQI),2);
							//return Math.log(item.AQI).toFixed(2);
						}),
						markPoint: {
							data: [
								{type: 'max', name: '最大值', symbolSize: 70},
								{type: 'min', name: '最小值', symbolSize: 70}
							]
						}
					},
	        {
	  				name: 'SO2(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.SO2).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.SO2).toFixed(2);
							}
							//return Math.log(item.SO2).toFixed(2);
						}),
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},
	        {
	  				name: 'CO(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.CO).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.CO).toFixed(2);
							}
							//return Math.log(item.CO).toFixed(2);
						}),
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'O3(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.O3).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.O3).toFixed(2);
							}
							//return Math.log(item.O3).toFixed(2);
						}),
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'PM10(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.PM10).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.PM10).toFixed(2);
							}
							//return Math.log(item.PM10).toFixed(2);
						}),
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'PM2.5(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.PM25).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.PM25).toFixed(2);
							}
							//return Math.log(item.PM25).toFixed(2);
						}),
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'NO2(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.NO2).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.NO2).toFixed(2);
							}
							//return Math.log(item.NO2).toFixed(2);
						}),
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'NOx(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.NOx).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.NOx).toFixed(2);
							}
							//return Math.log(item.NOx).toFixed(2);
						}),
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'NO(log)',
	  				type: 'line',
	  				data: data.map(function(item) {
							if (Math.log(item.NO).toFixed(2)=='-Infinity') {
								return '-';
							}
							else {
								return Math.log(item.NO).toFixed(2);
							}
							//return Math.log(item.NO).toFixed(2);
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
