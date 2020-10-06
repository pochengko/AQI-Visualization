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
        text: site + '：' + data['newAQI'].O3 + ', ' + data['newAQI'].PublishTime,
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
          {gt: 0, lte: 60, color: '#2FC737'},
          {gt: 60, lte: 125, color: '#E6E600'},
          {gt: 125, lte: 164, color: '#FF7C19'},
          {gt: 164, lte: 204, color: '#F33515'},
          {gt: 204, lte: 404, color: '#BC1049'},
          {gt: 404, color: '#800000'}
        ],
        outOfRange: {
          color: '#999'
        }
      },
      series: [{
        name: site + ' O3',
        type: 'line',
        data: data['airquality'].map(function(item) {
          return item.O3
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
            yAxis: 60
          }, {
            yAxis: 125
          }, {
            yAxis: 164
          }, {
            yAxis: 204
          }, {
            yAxis: 404
          }]
        }
      }]
    });
  }
</script>

<!--<h1 class="container-fluid text-center">O3 Map</h1>-->
<div id="map" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<div id="legend"></div>
<script type="text/javascript">
  var map;
  var legend = document.getElementById('legend');
  var div = document.createElement('div');
  div.innerHTML = '<img src="/img/o3level.png"> ';
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
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.latitude, item.longitude),
              label: {
                text: item.O3
              },
            icon: {
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByO3(item.O3),
              fillOpacity: 0.7,
              strokeColor: changeByO3(item.O3),
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
              fillColor: changeByO3_over(item.O3),
              fillOpacity: 0.7,
              strokeColor: changeByO3_over(item.O3),
              strokeWeight: 0,
              scale: 15
            });
          });

          marker.addListener('mouseout', function() {
            this.setIcon({
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByO3(item.O3),
              fillOpacity: 0.7,
              strokeColor: changeByO3(item.O3),
              strokeWeight: 0,
              scale: 15
            });
          });
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

  function changeByO3(o3) {
    if (o3 <= 60) {
      return '#2FC737';
    } else if (o3 > 60 && o3 <= 125) {
      return '#FFFF00';
    } else if (o3 > 125 && o3 <= 164) {
      return '#FF7C19';
    } else if (o3 > 164 && o3 <= 204) {
      return '#F33515';
    } else if (o3 > 204 && o3 <= 404) {
      return '#BC1049';
    } else {
      return '#800000';
    }
  }

  function changeByO3_over(o3) {
    if (o3 <= 60) {
      return '#0B610B';
    } else if (o3 > 60 && o3 <= 125) {
      return '#E1D319';
    } else if (o3 > 125 && o3 <= 164) {
      return '#DF7401';
    } else if (o3 > 164 && o3 <= 204) {
      return '#DF0101';
    } else if (o3 > 204 && o3 <= 404) {
      return '#BC1049';
    } else {
      return '#FF3333';
    }
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAH5_XNxD6PTKNE4jVKvPDQEuONSIaqZms&callback=myMap"></script>
