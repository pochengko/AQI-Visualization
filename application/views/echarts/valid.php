<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例
	var myChart = echarts.init(document.getElementById('main'));
	var dataAllMap = new Map();
  var i = 0;
	$(document).ready(function() {
		$.ajax({
			url: "echarts/getvalidcar",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
				//data.splice(0,6);
        console.log(data);
				getsensordata(data);
			}
		});
	});

	function getsensordata(Cdata) {
		$.ajax({
			url: "echarts/getvalidsensor",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
        console.log(data);
				showChart(Cdata, data);
			}
		});
	}

	function showChart(Cdata, Sdata) {

		var colors = ['#f0c3c1', '#8dacbf', '#99bbff', '#e68a00', '#944dff','#c23531', '#2f4554'];
		//0:Pne淺 1:EV淺 2:ILI 3:PM2.5 4:AQI 5:Pne深 6:EV深

		myChart.setOption(option = {
			title: {//4    3     2    0          1
				//text: 'AQI,PM2.5 ILI, Pneumonia, EV',
				textStyle: {
          fontSize: 15
        }
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
				x2: 200,//160
				y: '10%',
				y2: '12%'
			},
			toolbox: {
				feature: {
					dataView: {
						show: true,
						readOnly: true
					},
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
			visualMap: {
        top: 35,
        right: -100,
        pieces: [
          {gt: 0, lte: 15.4, color: '#2FC737'},
          {gt: 15.4, lte: 35.4, color: '#E6E600'},
          {gt: 35.4, lte: 54.4, color: '#FF7C19'},
          {gt: 54.4, lte: 150.4, color: '#F33515'},
          {gt: 150.4, lte: 250.4, color: '#BC1049'},
          {gt: 250.4, color: '#800000'}
        ],
        outOfRange: {
          color: '#999'
        }
      },
			legend: {
				type: 'scroll',
				data: ['Car', 'Sensor'],
				selected: {
					'Car': true,
					'Sensor': true,
				}
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: Cdata.reverse().map(function(item) {
					return item.PublishTime
				})
			}],
			yAxis: [{
					type: 'value',
					nameTextStyle: {
						//color: colors[0]
					},
					name: 'PM2.5',
					min: 0,
					max: 150,
					position: 'right',
					axisLine: {
						lineStyle: {
							color: colors[5]
						}
					},
					axisLabel: {
						formatter: '{value} ppm'
					}
				},
				{
					type: 'value',
					name: 'PM2.5',
					min: 0,
					max: 150,
					position: 'left',
					axisLine: {
						lineStyle: {
							color: colors[6]
						}
					},
					axisLabel: {
						formatter: '{value} ppm'
					}
				}
			],
			series: [{
				name: 'Car',
				type: 'line',
				data: Cdata.map(function(item) {
					return item.PM25;
				}),
				markPoint: {
					data: [{
							label: {
								normal: {
									textStyle: {
										color: '#000'
									}
								}
							},
							type: 'max',
							name: '最大值',
							symbolSize: 70
						},
						{
							label: {
								normal: {
									textStyle: {
										color: '#000'
									}
								}
							},
							type: 'min',
							name: '最小值',
							symbolSize: 70
						}
					]
				}
			},{
				name: 'Sensor',
				type: 'bar',
				yAxisIndex: 1,
				data: Sdata.reverse().map(function(item) {
					if ((item.PM25 > 0) && (item.PM25 < 501)) {
						return item.PM25;
					} else {
						return '-';
					}
					//return item.PM25;
				}),
				/*
				if ((item.PM25 > 0) && (item.PM25 < 501)) {
					return item.PM25;
				} else {
					return '-';
				}
				*/
				markPoint: {
					data: [{
							label: {
								normal: {
									textStyle: {
										//color: '#000'
									}
								}
							},
							type: 'max',
							name: '最大值',
							symbolSize: 70
						},
						{
							label: {
								normal: {
									textStyle: {
										//color: '#000'
									}
								}
							},
							type: 'min',
							name: '最小值',
							symbolSize: 70
						}
					]
				}
			}]
		});
		window.onresize = function() {
			myChart.resize();
		};

	}
</script>
