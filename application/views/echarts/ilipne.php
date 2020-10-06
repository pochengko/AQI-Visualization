<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例
	var myChart = echarts.init(document.getElementById('main'));
	var dataAllMap = new Map();
	$(document).ready(function() {
		$.ajax({
			url: "echarts/getili",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
				//data.splice(0,6);
				getpnedata(data);
			}
		});
	});

	function getpnedata(Idata) {
		$.ajax({
			url: "echarts/getpnefludeath",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
				data.unshift("0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
			               "0","0","0","0","0","0","0","0","0");
				getenterodata(Idata, data);
			}
		});
	}

	function getenterodata(Idata, Pdata) {
		$.ajax({
			url: "echarts/getenterovirus",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
				getaqidata(Idata, Pdata, data);
			}
		});
	}

	function getaqidata(Idata, Pdata, Edata) {
		$.ajax({
			url: "echarts/getaqi",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
				data.unshift("0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
			               "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0",
									   "0","0","0","0","0","0","0");
				getpm25data(Idata, Pdata, Edata, data);
			}
		});
	}

	function getpm25data(Idata, Pdata, Edata, Adata) {
		$.ajax({
			url: "echarts/getpm25",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
				showChart(Idata, Pdata, Edata, Adata, data);
			}
		});
	}

	function showChart(Idata, Pdata, Edata, Adata, PMdata) {

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
						show: false,
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
			legend: {
				type: 'scroll',
				data: ['AQI', 'PM2.5', 'ILI', 'Pneumonia', 'Enterovirus'],
				selected: {
					'PM2.5': true,
					'ILI': true,
					'AQI': false,
					'Pneumonia': false,
					'Enterovirus': false,
				}
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: Idata.map(function(item) {
					return 'Y'+item.Year+'W'+item.Week
				})
			}],
			yAxis: [{
					type: 'value',
					nameTextStyle: {
						//color: colors[0]
					},
					name: 'Pneumonia',
					min: 0,
					max: 600,
					position: 'right',
					axisLine: {
						lineStyle: {
							color: colors[5]
						}
					},
					axisLabel: {
						formatter: '{value} cases'
					}
				},
				{
					type: 'value',
					nameTextStyle: {
						//color: colors[1]
					},
					name: 'EV',
					min: 0,
					max: 30,
					position: 'right',
					offset: 70,
					axisLine: {
						lineStyle: {
							color: colors[6]
						}
					},
					axisLabel: {
						formatter: '{value} ‰'
					}
				},
				{
					type: 'value',
					nameTextStyle: {
						//color: colors[2]
					},
					name: 'ILI',
					min: 0,
					max: 30,
					position: 'right',
					offset: 120,
					axisLine: {
						lineStyle: {
							//color: colors[2]
						}
					},
					axisLabel: {
						formatter: '{value} %'
					}
				},
				{
					type: 'value',
					nameTextStyle: {
						//color: colors[2]
					},
					name: 'PM2.5',
					min: 0,
					max: 60,
					position: 'right',
					offset: 170,
					axisLine: {
						lineStyle: {
							color: colors[3]
						}
					},
					axisLabel: {
						formatter: '{value} '
					}
				},
				{
					type: 'value',
					name: 'AQI',
					min: 0,
					max: 150,
					position: 'left',
					axisLine: {
						lineStyle: {
							color: colors[4]
						}
					},
					axisLabel: {
						formatter: '{value} '
					}
				}
			],
			series: [{
				name: 'Pneumonia',
				type: 'bar',
				data: Pdata.map(function(item) {
					return item.Death;
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
			}, {
				name: 'Enterovirus',
				type: 'bar',
				yAxisIndex: 1,
				data: Edata.map(function(item) {
					return item.Enterovirus;
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
			}, {
				name: 'ILI',
				type: 'bar',
				yAxisIndex: 2,
				data: Idata.map(function(item) {
					return item.Whole;
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
			}, {
				name: 'PM2.5',
				type: 'line',
				yAxisIndex: 3,
				data: PMdata.map(function(item) {
					return item.PM25_Whole;
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
				name: 'AQI',
				type: 'line',
				yAxisIndex: 4,
				data: Adata.map(function(item) {
					return item.AQI;
				}),
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
