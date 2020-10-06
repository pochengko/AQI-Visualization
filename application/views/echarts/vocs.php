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
			url: "echarts/getvocs",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
        /*var st1Array = new Array();
        var st2Array = new Array();
        var st3Array = new Array();
        var st4Array = new Array();*/
				var HumidityArray = new Array();
				var IlluminanceArray = new Array();
				var PM1Array = new Array();
				var PM10Array = new Array();
				var PM25Array = new Array();
				var TemperatureArray = new Array()
				var VOCArray = new Array();
        var dateArray = new Array();
				data.map(function(item) {
          //console.log(data);
          /*var temp = new Array;
          dateArray.push(item["PublishTime"]);
          temp.push(item["Humidity"]);
          temp.push(item["Illuminance"]);
          temp.push(item["PM1"]);
          temp.push(item["PM10"]);
          temp.push(item["PM25"]);
          temp.push(item["Temperature"]);
          temp.push(item["VOC"]);*/
          if (item["SiteName"] == "407_30001") {
            HumidityArray.push(item['Humidity']);
						IlluminanceArray.push(item['Illuminance']/100);
						PM1Array.push(item['PM1']);
						PM10Array.push(item['PM10']);
						PM25Array.push(item['PM25']);
						TemperatureArray.push(item['Temperature']);
						VOCArray.push(item['VOC']/100);
						dateArray.push(item['PublishTime']);
          }
					/*else if (item["SiteName"] == "407_30002") {
            st2Array.push(temp);
          } else if (item["SiteName"] == "407_30003") {
            st2Array.push(temp);
          } else if (item["SiteName"] == "407_30004") {
            st2Array.push(temp);
          }*/
          //console.log(st1Array);
				});
				showChart(HumidityArray, IlluminanceArray, PM1Array, PM10Array, PM25Array, TemperatureArray, VOCArray, dateArray);
			}
    });
	});

function showChart(Humidity, Illuminance, PM1, PM10, PM25, Temperature, VOC, date) {
    myChart.setOption(option = {
			title: {
				text: '東海407_30001'
			},
			//color: colors,
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
				data: ['Humidity', 'Illuminance/100', 'PM1', 'PM10', 'PM2.5', 'Temperature', 'VOC/100']
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: date
			}],
			yAxis: {
					type: 'value',
				},
			series: [{
						name: 'Humidity',
						type: 'line',
						data: Humidity,
						markPoint: {
							data: [
								{type: 'max', name: '最大值', symbolSize: 70},
								{type: 'min', name: '最小值', symbolSize: 70}
							]
						}
					},
	        {
	  				name: 'Illuminance/100',
	  				type: 'line',
	  				data: Illuminance,
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},
	        {
	  				name: 'PM1',
	  				type: 'line',
	  				data: PM1,
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'PM10',
	  				type: 'line',
	  				data: PM10,
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'PM2.5',
	  				type: 'line',
	  				data: PM25,
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'Temperature',
	  				type: 'line',
	  				data: Temperature,
	  				markPoint: {
	  					data: [
	  						{type: 'max', name: '最大值', symbolSize: 70},
	  						{type: 'min', name: '最小值', symbolSize: 70}
	  					]
	  				}
	  			},{
	  				name: 'VOC/100',
	  				type: 'line',
	  				data: VOC,
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
