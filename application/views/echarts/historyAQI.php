<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<!--<div id="main" class="container-fluid text-center" style="max-width: 100%;height:720px;"></div>-->
<style>
@media only screen and (min-width: 768px){
.myDiv{
 width:615px;
 height:450px;
}
}
 @media only screen and (max-width: 767px) {
.myDiv{
	width:650px;
	height:450px;
}
}
 @media only screen and (max-width: 480px) {
	 .myDiv{
	 	width:265px;
	 	height:250px;
	 }
}
 /*@media only screen and (max-width: 342px) {
	 .myDiv{
		width:180px;
		height:250px;
	 }
}*/

</style>
<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例

	var myChart;
	var dataAllMap;
	/*$(document).ready(function(){
		showChart();
	});*/

	function showChart(site) {
		myChart = echarts.init(document.getElementById('main'));
		getWeatherData(site, getAQIData);
	}

	function getWeatherData(site, callback) {
		$.ajax({
			url: "echarts/getdailydataitem",
			type: "POST",
			data: {
				siteName: site
			},
			dataType: "json",
			cache: false,
			success: function(data) {
				callback(data, site, sendData);
			}
		});
	}

	function getAQIData(Wdata, site, callback) {
		$.ajax({
			url: "echarts/getdailydataaqi",
			type: "POST",
			data: {
				siteName: site
			},
			dataType: "json",
			cache: false,
			success: function(data) {
				callback(Wdata, data, site, dohihi);
			}
		});
	}

	function sendData(Wdata, Adata, site, callback) {
		callback(Wdata, Adata, site);
	}

	function dohihi(Wdata, Adata, site) {
		///
		var colors = ['#0000ff', '#d14a61', '#99ff99'];
		myChart.setOption(option = {
			title: {
				text: site
			},
			color: colors,
			tooltip: {
				trigger: 'axis',
				axisPointer: {
					type: 'cross'
				}
			},
			grid: {
				right: '15%'
			},
			toolbox: {
				feature: {
					dataView: {
						show: true,
						readOnly: true
					},
					restore: {
						show: true
					},
					saveAsImage: {
						show: true
					}
				}
			},
			dataZoom: [{
				startValue: '2017-01-01'
			}, {
				type: 'inside'
			}],
			legend: {
				data: ['相對濕度', '溫度', 'AQI']
			},
			xAxis: [{
				type: 'category',
				axisTick: {
					alignWithLabel: true
				},
				data: Adata.map(function(item) {
					return item.date
				})
			}],
			yAxis: [{
					type: 'value',
					name: '相對濕度',
					min: 40,
					max: 100,
					position: 'right',
					axisLine: {
						lineStyle: {
							color: colors[0]
						}
					},
					axisLabel: {
						formatter: '{value} %'
					}
				},
				{
					type: 'value',
					name: '溫度',
					min: 5,
					max: 40,
					position: 'right',
					offset: 50,
					axisLine: {
						lineStyle: {
							color: colors[1]
						}
					},
					axisLabel: {
						formatter: '{value} °C'
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
					name: site + '相對濕度',
					type: 'line',
					data: Wdata.map(function(item) {
						return item.RH;
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 60},
							{type: 'min', name: '最小值', symbolSize: 60}
						]
					}
				},
				{
					name: site + '溫度',
					type: 'line',
					yAxisIndex: 1,
					data: Wdata.map(function(item) {
						return (item.AMB_TEMP);
					}),
					markPoint: {
						data: [
							{type: 'max', name: '最大值', symbolSize: 60},
							{type: 'min', name: '最小值', symbolSize: 60}
						]
					}
				},
				{
					name: site + 'AQI',
					type: 'bar',
					yAxisIndex: 2,
					data: Adata.map(function(item) {
						return (item.AQI);
					})
				}
			]
		});
		window.onresize = function() {
			myChart.resize();
		};
		///
	}
</script>

<div id="mapp" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>

<script type="text/javascript">
	var map;
	function myMap() {
		var mapOptions = {
			center: new google.maps.LatLng(23.968842, 120.967903),
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
      gestureHandling: 'greedy'
		};
		map = new google.maps.Map(document.getElementById("mapp"), mapOptions);
		var contentString = '<div id="main" class="myDiv container text-center"></div>';
		var currentInfoWindow;

		var iconBase = 'https://maps.google.com/mapfiles/kml/pushpin/';
    //http://kml4earth.appspot.com/icons.html
		var icons = {
			parking: {
				icon: iconBase + 'parking_lot_maps.png'
			},
			library: {
				icon: iconBase + 'library_maps.png'
			},
			info: {
				icon: iconBase + 'ylw-pushpin_maps.png'
			}
		};
		$.ajax({
			url: "echarts/getobservation",
			type: "POST",
			dataType: "json",
			cache: false,
			success: function(data) {
        data.splice(75,13);
				data.map(function(item) {
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(item.latitude, item.longitude),
						icon: icons["info"].icon,
						title: item.county + item.siteName + item.observationName,
						map: map

					});
          marker.addListener('click', function() {
            if(currentInfoWindow!=null)
              currentInfoWindow.close();
            var tmp_infowindow = new google.maps.InfoWindow({
              content: contentString
            });
            tmp_infowindow.open(map, marker);
            google.maps.event.addListener(tmp_infowindow, 'domready', function(){
              showChart(item.observationName);
            });
            currentInfoWindow = tmp_infowindow;
          });
					//var marker = new MarkerClusterer(map, marker, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
				});
			}
		});

		google.maps.event.addDomListener(window, "resize", function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center);
		});
		//google.maps.event.addDomListener(window, 'load', myMap);

	}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAH5_XNxD6PTKNE4jVKvPDQEuONSIaqZms&callback=myMap"></script>
