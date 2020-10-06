<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" class="container-fluid text-center" style="width: 1000px;height:720px;"></div>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例
	var myChart = echarts.init(document.getElementById('main'));

	var dataAllMap = new Map();
	$(document).ready(function() {
		$.ajax({
			url: "getdata",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
				data.map(function(item) {
					//console.log(item)
				});
				dohihi(data);
				/*var PM25Array = new Array();
				var PM10Array = new Array();
				var PSIArray = new Array();
				var dateArray = new Array();
				$.each(data, function(key, value) {
				    if (value['name'] == "西屯") {
				        PM25Array.push(value['PM25']);
				        PM10Array.push(value['PM10']);
				        PSIArray.push(value['PSI']);
				        dateArray.push(value['mon'] + "/" + value['day'] + " " + value['hour'] + "時");
				    }
				});
				showData(dateArray, PM25Array, PM10Array, PSIArray);*/
			}
		});
	})

	//
	function dohihi(data) {
		myChart.setOption(option = {
			title: {
				text: '西屯 AQI'
			},
			tooltip: {
				trigger: 'axis',
				axisPointer: {
            type: 'cross'
        }
			},
			xAxis: {
				data: data.map(function(item) {
					return item.PublishTime
				})
			},
			yAxis: {
				splitLine: {
					show: false
				}
			},
			toolbox: {
				left: 'center',
				feature: {
					dataZoom: {
						yAxisIndex: 'none'
					},
					dataView: {
						show: true,
						readOnly: false
					},
					restore: {},
					saveAsImage: {}
				}

			},
			dataZoom: [{
				startValue: '2017-01-08'
			}, {
				type: 'inside'
			}],
			visualMap: {
				top: 10,
				right: 10,
				pieces: [{
					gt: 0,
					lte: 50,
					color: '#096'
				}, {
					gt: 50,
					lte: 100,
					color: '#ffde33'
				}, {
					gt: 100,
					lte: 150,
					color: '#ff9933'
				}, {
					gt: 150,
					lte: 200,
					color: '#cc0033'
				}, {
					gt: 200,
					lte: 300,
					color: '#660099'
				}, {
					gt: 300,
					color: '#7e0023'
				}],
				outOfRange: {
					color: '#999'
				}
			},
			series: [
				{
					name: '西屯 AQI',
					type: 'line',
					data: data.map(function(item) {
						return item.AQI;
					}),
					markPoint: {
						data : [
							{type : 'max', name : '最大值'},
							{type : 'min', name : '最小值'},
						],
						clickable: true,
					},
					markLine: {
						silent: true,
						data: [{
							yAxis: 50
						}, {
							yAxis: 100
						}, {
							yAxis: 150
						}, {
							yAxis: 200
						}, {
							yAxis: 300
						}]
					}/*,
					{
						name: 'PM25',
						type: 'line',
						data: data.map(function(item) {
							return item.AQI;
						}),
						yAxisIndex: 1
					}*/
				}
			]

		});
		window.onresize = function() {
			myChart.resize({
				width: window.innerWidth,
				height: window.innerHeight
			});
		};
	}

	//myChart.setOption(option);
</script>
