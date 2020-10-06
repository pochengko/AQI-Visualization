<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<!--<div id="main" class="container-fluid text-center" style="max-width: 100%;height:720px;"></div>-->
<style>
@media only screen and (min-width: 768px) {
    .myDiv {
      width: 615px;
      height: 450px;
    }
  }

  @media only screen and (max-width: 767px) {
    .myDiv {
      width: 650px;
      height: 450px;
    }
  }

  @media only screen and (max-width: 480px) {
    .myDiv {
      width: 265px;
      height: 250px;
    }
  }

</style>
<!--<h1 class="container-fluid text-center">AQI Map</h1>-->
<div id="mapp" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>

<script type="text/javascript">
	// 基于准备好的dom，初始化echarts实例
var myChart;
var dataAllMap;
function showChart(area) {
  myChart = echarts.init(document.getElementById('main'));
  dataAllMap = new Map();
      $.ajax({
          url: "echarts/getiliaqiarea",
          type: "GET",
          data: {
            Area: area
          },
          dataType: "json",
          cache: false,
          success: function(data) {
            //console.log(data);
            data.map(function(item) {
            })
            dohihi(data, area);
          }
      });
	}

  function dohihi(data, area) {
    myChart.setOption(option = {
      title : {
        text: area + ' Dist.'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['ILI','AQI']
    },
    toolbox: {
        show : true,
        feature : {
            //dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data : data.map(function(item) {
              return item.Year
            })
        }
    ],
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
            color: '#000'
          }
        },

        axisLabel: {
          formatter: '{value}'
        }
      }
    ],
    series : [
        {
            name:'ILI',
            type:'bar',
            yAxisIndex: 1,
            data: data.map(function(item) {
              return item.ILI
            }),
            markPoint : {
                data : [
                    {type : 'max', name: '最大值',symbolSize: 70},
                    {type : 'min', name: '最小值',symbolSize: 70}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name: '平均值'}
                ]
            }
        },
        {
            name:'AQI',
            type:'bar',
            data: data.map(function(item) {
              return item.AQI
            }),
            markPoint : {
                data : [
                    {type : 'max', name: '最大值',symbolSize: 70},
                    {type : 'min', name: '最小值',symbolSize: 70}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name : '平均值'}
                ]
            }
        }
    ]
		});

  }
</script>
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

    $.getJSON("https://raw.githubusercontent.com/g0v/twgeojson/master/json/twCounty2010.topo.json", function(data){
        geoJsonObject = topojson.feature(data, data.objects.layer1)
        map.data.addGeoJson(geoJsonObject);
      });

    //map.data.loadGeoJson('https://raw.githubusercontent.com/g0v/twgeojson/master/json/twCounty2010.geo.json');



    // Color each letter gray. Change the color when the isColorful property
    // is set to true.
    $.blockUI({ message: '<img src="/img/ajax-loader.gif" />' });
    map.data.setStyle(function(feature) {
      var color;
      var countysn = feature.getProperty('COUNTYNAME');
      if (feature.getProperty('COUNTYNAME') == '台北縣'||
        feature.getProperty('COUNTYNAME') == '台北市'||
        feature.getProperty('COUNTYNAME') == '宜蘭縣' ||
        feature.getProperty('COUNTYNAME') == '連江縣' ||
        feature.getProperty('COUNTYNAME') == '金門縣' ||
        feature.getProperty('COUNTYNAME') == '基隆市') {
        color = 'yellow'; //Taipei
      } else if (feature.getProperty('COUNTYNAME') == '桃園縣' ||
        feature.getProperty('COUNTYNAME') == '新竹縣' ||
        feature.getProperty('COUNTYNAME') == '新竹市' ||
        feature.getProperty('COUNTYNAME') == '苗栗縣') {
        color = 'red'; //North
      } else if (feature.getProperty('COUNTYNAME') == '花蓮縣' ||
        feature.getProperty('COUNTYNAME') == '台東縣') {
        color = 'blue'; //East
      } else if (feature.getProperty('COUNTYNAME') == '高雄市' ||
        feature.getProperty('COUNTYNAME') == '高雄縣' ||
        feature.getProperty('COUNTYNAME') == '屏東縣' ||
        feature.getProperty('COUNTYNAME') == '澎湖縣') {
        color = 'green'; //Kaoping
      } else if (feature.getProperty('COUNTYNAME') == '雲林縣' ||
        feature.getProperty('COUNTYNAME') == '嘉義縣' ||
        feature.getProperty('COUNTYNAME') == '嘉義市' ||
        feature.getProperty('COUNTYNAME') == '台南市' ||
        feature.getProperty('COUNTYNAME') == '台南縣') {
        color = 'purple'; //South
      } else if (feature.getProperty('COUNTYNAME') == '台中市' ||
        feature.getProperty('COUNTYNAME') == '台中縣' ||
        feature.getProperty('COUNTYNAME') == '彰化縣' ||
        feature.getProperty('COUNTYNAME') == '南投縣') {
        color = 'orange'; //Central
      } else {
        color = 'gray';
      }
      $.unblockUI();

      return /** @type {google.maps.Data.StyleOptions} */ ({
        fillColor: color,
        strokeColor: color,
        strokeWeight: 2
      });
    });


    // When the user clicks, set 'isColorful', changing the color of the letters.
    map.data.addListener('click', function(event) {
      var anchor = new google.maps.MVCObject();
      var county ;

      //event.feature.setProperty('isColorful', true);
      if (event.feature.getProperty('COUNTYNAME') == '台北縣' || event.feature.getProperty('COUNTYNAME') == '台北市' ||
          event.feature.getProperty('COUNTYNAME') == '宜蘭縣' || event.feature.getProperty('COUNTYNAME') == '連江縣' ||
          event.feature.getProperty('COUNTYNAME') == '金門縣' || event.feature.getProperty('COUNTYNAME') == '基隆市') {
            county = 'Taipei';
            map.data.forEach(function(feature) {
              if (feature.getProperty('COUNTYNAME') == '台北縣' || feature.getProperty('COUNTYNAME') == '台北市' ||
                  feature.getProperty('COUNTYNAME') == '宜蘭縣' || feature.getProperty('COUNTYNAME') == '連江縣' ||
                  feature.getProperty('COUNTYNAME') == '金門縣' || feature.getProperty('COUNTYNAME') == '基隆市') {
                    feature.setProperty('isColorful', true);
              }
            });
      } else if (event.feature.getProperty('COUNTYNAME') == '桃園縣' || event.feature.getProperty('COUNTYNAME') == '新竹縣' ||
                 event.feature.getProperty('COUNTYNAME') == '新竹市' || event.feature.getProperty('COUNTYNAME') == '苗栗縣') {
                   county = 'North';
                   map.data.forEach(function(feature) {
                     if (feature.getProperty('COUNTYNAME') == '桃園縣' || feature.getProperty('COUNTYNAME') == '新竹縣' ||
                         feature.getProperty('COUNTYNAME') == '新竹市' || feature.getProperty('COUNTYNAME') == '苗栗縣') {
                           feature.setProperty('isColorful', true);
                     }
                   });
      } else if (event.feature.getProperty('COUNTYNAME') == '台中市' || event.feature.getProperty('COUNTYNAME') == '台中縣' ||
                 event.feature.getProperty('COUNTYNAME') == '彰化縣' || event.feature.getProperty('COUNTYNAME') == '南投縣') {
                   county = 'Central';
                   map.data.forEach(function(feature) {
                     if (feature.getProperty('COUNTYNAME') == '台中市' || feature.getProperty('COUNTYNAME') == '台中縣' ||
                         feature.getProperty('COUNTYNAME') == '彰化縣' || feature.getProperty('COUNTYNAME') == '南投縣') {
                           feature.setProperty('isColorful', true);
                     }
                   });
      } else if (event.feature.getProperty('COUNTYNAME') == '雲林縣' || event.feature.getProperty('COUNTYNAME') == '嘉義縣' ||
                 event.feature.getProperty('COUNTYNAME') == '嘉義市' || event.feature.getProperty('COUNTYNAME') == '台南市' ||
                 event.feature.getProperty('COUNTYNAME') == '台南縣') {
                   county = 'South';
                   map.data.forEach(function(feature) {
                     if (feature.getProperty('COUNTYNAME') == '雲林縣' || feature.getProperty('COUNTYNAME') == '嘉義縣' ||
                         feature.getProperty('COUNTYNAME') == '嘉義市' || feature.getProperty('COUNTYNAME') == '台南市' ||
                         feature.getProperty('COUNTYNAME') == '台南縣') {
                           feature.setProperty('isColorful', true);
                     }
                   });
      } else if (event.feature.getProperty('COUNTYNAME') == '高雄市' || event.feature.getProperty('COUNTYNAME') == '高雄縣' ||
                 event.feature.getProperty('COUNTYNAME') == '屏東縣' || event.feature.getProperty('COUNTYNAME') == '澎湖縣') {
                   county = 'Kaoping';
                   map.data.forEach(function(feature) {
                     if (feature.getProperty('COUNTYNAME') == '高雄市' || feature.getProperty('COUNTYNAME') == '高雄縣' ||
                         feature.getProperty('COUNTYNAME') == '屏東縣' || feature.getProperty('COUNTYNAME') == '澎湖縣') {
                           feature.setProperty('isColorful', true);
                     }
                   });
      } else if (event.feature.getProperty('COUNTYNAME') == '花蓮縣' || event.feature.getProperty('COUNTYNAME') == '台東縣') {
                   county = 'East';
                   map.data.forEach(function(feature) {
                     if (feature.getProperty('COUNTYNAME') == '花蓮縣' || feature.getProperty('COUNTYNAME') == '台東縣') {
                           feature.setProperty('isColorful', true);
                     }
                   });
      }
      anchor.set("position", event.latLng);
      if(currentInfoWindow!=null)
        currentInfoWindow.close();
      var tmp_infowindow = new google.maps.InfoWindow({
        content: contentString
      });
      tmp_infowindow.open(map, anchor);
      google.maps.event.addListener(tmp_infowindow, 'domready', function(){
        showChart(county);
      });
      currentInfoWindow = tmp_infowindow;

    });

    // When the user hovers, tempt them to click by outlining the letters.
    // Call revertStyle() to remove all overrides. This will use the style rules
    // defined in the function passed to setStyle()
    map.data.addListener('mouseover', function(event) {
      map.data.revertStyle();
      map.data.overrideStyle(event.feature, {
        strokeWeight: 4
      });
    });

    map.data.addListener('mouseout', function(event) {
      map.data.revertStyle();
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
