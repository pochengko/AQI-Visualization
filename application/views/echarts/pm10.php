<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<!--<div id="main" class="container-fluid text-center" style="max-width: 100%;height:720px;"></div>-->
<style>
  /*@media only screen and (max-width: 342px) {
	 .myDiv{
		width:180px;
		height:250px;
	 }
}*/

#legend {
    font-family: Arial, sans-serif;
    position: absolute;
}

@media only screen and (min-width: 768px) {
.myDiv {
      width: 650px;
      height: 400px;
    }
#legend img  {
      width: 450px;
      height: 50px;
    }
  }

  @media only screen and (max-width: 767px) {
.myDiv {
      width: 650px;
      height: 450px;
    }
#legend img {
      width: 400px;
      height: 60px;
    }
  }

  @media only screen and (max-width: 480px) {
.myDiv {
      width: 265px;
      height: 250px;
    }
#legend img  {
      width: 200px;
      height: 30px;
    }
  }
</style>
<script type="text/javascript">
  // 基于准备好的dom，初始化echarts实例

  var myChart;
  var dataAllMap;
  var myVOCsChart;
  var myLoRaChart;
  var today = new Date();
  var date = today.getFullYear()+'-'+'0'+(today.getMonth())+'-01';

  function showChart(site) {
    myChart = echarts.init(document.getElementById('main'));
    dataAllMap = new Map();
    $.ajax({
      url: "echarts/getdata",
      type: "POST",
      data: {
        siteName: site
      },
      dataType: "json",
      cache: false,
      success: function(data) {
        dohihi(data, site);
      }
    });
  }

  function dohihi(data, site) {
    myChart.setOption(option = {
      title: {
        text: site + '：' + data['newAQI'].PM10 + ', ' + data['newAQI'].PublishTime,
        textStyle: {
          fontSize: 18
        }
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'cross'
        },
      },
      xAxis: {
        data: data['airquality'].map(function(item) {
          return item.PublishTime
        })
      },
      yAxis: {
        splitLine: {
          show: false
        }
      },
      toolbox: {
        left: 'right',
        feature: {
          dataView: {
            show: true,
            readOnly: true
          },
          //restore: {},
          //saveAsImage: {}
        }
      },
      dataZoom: [{
        startValue: date+' 00:00'
        //startValue: '2017-12-01 00:00'
      }, {
        type: 'inside'
      }],
      visualMap: {
        top: 35,
        right: -100,
        pieces: [
          {gt: 0, lte: 54, color: '#2FC737'},
          {gt: 54, lte: 125, color: '#E6E600'},
          {gt: 125, lte: 254, color: '#FF7C19'},
          {gt: 254, lte: 354, color: '#F33515'},
          {gt: 354, lte: 424, color: '#BC1049'},
          {gt: 424, color: '#800000'}
        ],
        outOfRange: {
          color: '#999'
        }
      },
      series: [{
        name: site + ' PM10',
        type: 'line',
        data: data['airquality'].map(function(item) {
          return item.PM10
        }),
        markPoint: {
          data: [{
              type: 'max',
              name: '最大值'
            },
            {
              type: 'min',
              name: '最小值'
            },
          ],
          clickable: true,
        },
        markLine: {
          silent: true,
          data: [{
            yAxis: 54
          }, {
            yAxis: 125
          }, {
            yAxis: 254
          }, {
            yAxis: 354
          }, {
            yAxis: 424
          }]
        }
      }]
    });
  }


  /*function showVOCsChart(stId) {
		myVOCsChart = echarts.init(document.getElementById('main'));
		$.ajax({
			url: "echarts/getvoc",
			type: "POST",
			data: {
				siteName: stId
			},
			dataType: "json",
			cache: false,
			success: function(data) {
				//console.log(data);
				showData(data, stId);
			}
		});
	}

  function showData(data, stId) {
    myVOCsChart.setOption(option = {
      title: {
        text: 'VOCS '+stId + '：' + data['newVOC'].PM10 + ', ' + data['newVOC'].PublishTime,
        textStyle: {
          fontSize: 18
        }
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'cross'
        },
      },
      xAxis: {
        data: data['voc'].map(function(item) {
          return item.PublishTime
        })
      },
      yAxis: {
        splitLine: {
          show: false
        }
      },
      toolbox: {
        left: 'right',
        feature: {
          dataView: {
            show: true,
            readOnly: true
          },
          //saveAsImage: {}
        }
      },
      dataZoom: [{
        startValue: date+' 00:00:00'
      }, {
        type: 'inside'
      }],
      visualMap: {
        top: 35,
        right: -100,
        pieces: [
          {gt: 0, lte: 54, color: '#2FC737'},
          {gt: 54, lte: 125, color: '#E6E600'},
          {gt: 125, lte: 254, color: '#FF7C19'},
          {gt: 254, lte: 354, color: '#F33515'},
          {gt: 354, lte: 424, color: '#BC1049'},
          {gt: 424, color: '#800000'}
        ],
        outOfRange: {
          color: '#999'
        }
      },
      series: [{
        name: 'VOCS '+stId + ' PM10',
        type: 'line',
        data: data['voc'].map(function(item) {
          return item.PM10
        }),
        markPoint: {
          data: [{
              type: 'max',
              name: '最大值'
            },
            {
              type: 'min',
              name: '最小值'
            },
          ],
          clickable: true,
        },
        markLine: {
          silent: true,
          data: [{
            yAxis: 54
          }, {
            yAxis: 125
          }, {
            yAxis: 254
          }, {
            yAxis: 354
          }, {
            yAxis: 424
          }]
        }
      }]
    });
  }*/

  function showLoRaChart(sensor) {
    myLoRaChart = echarts.init(document.getElementById('main'));
    dataAllMap = new Map();
    $.ajax({
      url: "echarts/getlora",
      type: "POST",
      data: {
        siteName: sensor
      },
      dataType: "json",
      cache: false,
      success: function(data) {
        //console.log(data);
        showLoRaData(data, sensor);
      }
    });
  }

  function showLoRaData(data, sensor) {
    myLoRaChart.setOption(option = {
      title: {
        text: 'LoRa_'+ sensor + '：' + data['newlora'].PM10 + ', ' + data['newlora'].timestamp,
        textStyle: {
          fontSize: 18
        }
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'cross'
        },
      },
      xAxis: {
        data: data['lora'].map(function(item) {
          return item.timestamp
        })
      },
      yAxis: {
        splitLine: {
          show: false
        }
      },
      toolbox: {
        left: 'right',
        feature: {
          dataView: {
            show: true,
            readOnly: true
          },
          //saveAsImage: {}
        }
      },
      dataZoom: [{
        startValue: '2018/01/09 14:43:00'
      }, {
        type: 'inside'
      }],
      visualMap: {
        top: 35,
        right: -100,
        pieces: [
          {gt: 0, lte: 54, color: '#2FC737'},
          {gt: 54, lte: 125, color: '#E6E600'},
          {gt: 125, lte: 254, color: '#FF7C19'},
          {gt: 254, lte: 354, color: '#F33515'},
          {gt: 354, lte: 424, color: '#BC1049'},
          {gt: 424, color: '#800000'}
        ],
        outOfRange: {
          color: '#999'
        }
      },
      series: [{
        name: 'LoRa_' + sensor + ' PM10',
        type: 'line',
        data: data['lora'].map(function(item) {
          if ((item.PM10 > 0) && (item.PM10 < 424)) {
            return item.PM10;
          } else {
            return '-';
          }
        }),
        markPoint: {
          data: [{
              type: 'max',
              name: '最大值'
            },
            {
              type: 'min',
              name: '最小值'
            },
          ],
          clickable: true,
        },
        markLine: {
          silent: true,
          data: [{
            yAxis: 54
          }, {
            yAxis: 125
          }, {
            yAxis: 254
          }, {
            yAxis: 354
          }, {
            yAxis: 424
          }]
        }
      }]
    });
  }
</script>

<!--<h1 class="container-fluid text-center">AQI Map</h1>-->
<div id="map" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<div id="legend"></div>
<script type="text/javascript">
  var map;
  var legend = document.getElementById('legend');
  var div = document.createElement('div');
  div.innerHTML = '<img src="/img/pm10level.png"> ';
  legend.appendChild(div);

  function myMap() {
    var mapOptions = {
      center: new google.maps.LatLng(23.968842, 120.967903),
      zoom: 8,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      gestureHandling: 'greedy',
      zoomControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER
          },
      streetViewControlOptions: {
              position: google.maps.ControlPosition.LEFT_TOP
          }
    };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    var contentString = '<div id="main" class="myDiv container text-center"></div>';
    var currentInfoWindow;

    /*$.ajax({
      url: "echarts/getvocobservation",
      type: "POST",
      dataType: "json",
      cache: false,
      success: function(data) {
        data.map(function(item) {
					//console.log(item);
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.latitude, item.longitude),
            label: {
              text: item.PM10
						},
            icon: {
              path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
              fillColor: changeByPM10(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10(item.PM10),
              strokeWeight: 0,
              scale: 8
            },
            title: 'VOCS '+item.observationName,
            animation: google.maps.Animation.DROP,
            map: map
          });
          marker.addListener('click', function() {
            infowindow.open(map, marker);
            showVOCsChart(item.observationName);
          });

          marker.addListener('mouseover', function() {
            this.setIcon({
              path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
              fillColor: changeByPM10_over(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10_over(item.PM10),
              strokeWeight: 0,
              scale: 8
            });
          });

          marker.addListener('mouseout', function() {
            this.setIcon({
              path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
              fillColor: changeByPM10(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10(item.PM10),
              strokeWeight: 0,
              scale: 8
            });
          });
        });
      }
    });*/


    $.ajax({
      url: "echarts/getobservation",
      type: "POST",
      dataType: "json",
      cache: false,
      success: function(data) {
        /*
        data.splice(82,1);
        data.splice(87,1);
        */
        data.map(function(item) {
					//console.log(item);
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.latitude, item.longitude),
            label: {
              text: item.PM10
						},
            icon: {
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByPM10(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10(item.PM10),
              strokeWeight: 0,
              scale: 15,
            },

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

          marker.addListener('mouseover', function() {
            this.setIcon({
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByPM10_over(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10_over(item.PM10),
              strokeWeight: 0,
              scale: 15
            });
          });

          marker.addListener('mouseout', function() {
            this.setIcon({
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByPM10(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10(item.PM10),
              strokeWeight: 0,
              scale: 15
            });
          });
        });
      }
    });

    $.ajax({
      url: "echarts/getloraobservation",
      type: "POST",
      dataType: "json",
      cache: false,
      success: function(data) {


        //data.splice(1,1); //B
        //data.splice(1,1);

        data.map(function(item) {
					//console.log(item);
          var triangle = {
            path: 'M0 -5 L-3 2 L3 2 z', // 'M -2,0 0,-2 2,0 0,2 z'
            fillColor: changeByPM10(item.PM10),
            fillOpacity: 0.7,
            //strokeColor: changeByPM25(item.PM25),
            strokeWeight: 0,
            scale: 5.5
          };
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.latitude, item.longitude),
            label: {
              text: item.PM10
						},
            icon: triangle/*{
              path: google.maps.SymbolPath.FORWARD_OPEN_ARROW,
              fillColor: changeByPM10(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10(item.PM10),
              strokeWeight: 0,
              scale: 8
            }*/,
            title: 'LoRa_'+item.observationName,
            animation: google.maps.Animation.DROP,
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
              showLoRaChart(item.observationName);
            });
            currentInfoWindow = tmp_infowindow;
          });

          /*marker.addListener('mouseover', function() {
            this.setIcon({
              path: google.maps.SymbolPath.FORWARD_OPEN_ARROW,
              fillColor: changeByPM10_over(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10_over(item.PM10),
              strokeWeight: 0,
              scale: 8
            });
          });*/

          /*marker.addListener('mouseout', function() {
            this.setIcon({
              path: google.maps.SymbolPath.FORWARD_OPEN_ARROW,
              fillColor: changeByPM10(item.PM10),
              fillOpacity: 0.7,
              strokeColor: changeByPM10(item.PM10),
              strokeWeight: 0,
              scale: 8
            });
          });*/
        });
      }
    });


    google.maps.event.addDomListener(window, "resize", function() {
      var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
    });
    //google.maps.event.addDomListener(window, 'load', myMap);
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);


  }

  function changeByPM10(pm10) {
    if (pm10 <= 54) {
      return '#2FC737';
    } else if (pm10 > 54 && pm10 <= 125) {
      return '#FFFF00';
    } else if (pm10 > 125 && pm10 <= 254) {
      return '#FF7C19';
    } else if (pm10 > 254 && pm10 <= 354) {
      return '#F33515';
    } else if (pm10 > 354 && pm10 <= 424) {
      return '#BC1049';
    } else {
      return '#800000';
    }
  }

  function changeByPM10_over(pm10) {
    if (pm10 <= 54) {
      return '#0B610B';
    } else if (pm10 > 54 && pm10 <= 125) {
      return '#E1D319';
    } else if (pm10 > 125 && pm10 <= 254) {
      return '#DF7401';
    } else if (pm10 > 254 && pm10 <= 354) {
      return '#DF0101';
    } else if (pm10 > 354 && pm10 <= 424) {
      return '#BC1049';
    } else {
      return '#FF3333';
    }
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAH5_XNxD6PTKNE4jVKvPDQEuONSIaqZms&callback=myMap"></script>
