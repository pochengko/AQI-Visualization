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
  @media only screen and (min-width: 1441px) {
    .myDiv {
          width: 615px;
          height: 400px;
        }
    .iDiv {
          width: 390px;
          height: 270px;
        }
    #legend img  {
          width: 450px;
          height: 50px;
        }
    #windy iframe  {
          width: 1560px;
          height: 1080px;
          position:absolute;
          top:-200px;
          left:-600px;
        }
    /*#controls div {
          width: 180px;
          height: 140px;
          position: absolute;
          bottom: 10px;
          right: 10px;
          font-family: 'arial', 'sans-serif';
          font-size: 14px;
          text-align: left;
          background-color: white;
          border: 1px solid black;
          padding: 10px 10px 0px 10px;
        }*/
  }

  @media only screen and (max-width: 1440px) {
    .myDiv {
          width: 455px;
          height: 275px;
        }
    .iDiv {
          width: 270px;
          height: 180px;
        }
    #legend img {
          width: 315px;
          height: 35px;
        }
    #windy iframe  {
          width: 1560px;
          height: 1080px;
          position:absolute;
          top:-250px;
          left:-650px;
        }
    /*#controls div {
          width: 180px;
          height: 140px;
          position: absolute;
          bottom: 10px;
          right: 10px;
          font-family: 'arial', 'sans-serif';
          font-size: 14px;
          text-align: left;
          background-color: white;
          border: 1px solid black;
          padding: 10px 10px 0px 10px;
        }*/
  }

  @media only screen and (max-width: 767px) {
    .myDiv {
          width: 390px;
          height: 270px;
        }
    .iDiv {
          width: 195px;
          height: 135px;
        }
    #legend img {
          width: 270px;
          height: 36px;
        }
    #windy iframe  {
         width: 1560px;
         height: 1080px;
         position:absolute;
         top:-280px;
         left:-680px;
        }
    /*#controls div {
          width: 105px;
          height: 95px;
          position: absolute;
          bottom: 10px;
          right: 10px;
          font-family: 'arial', 'sans-serif';
          font-size: 14px;
          text-align: left;
          background-color: white;
          border: 1px solid black;
          padding: 10px 10px 0px 10px;
        }*/
  }

  @media only screen and (max-width: 480px) {
    .myDiv {
          width: 260px;
          height: 215px;/*235 215*/
        }
    .iDiv {
          width: 185px;
          height: 110px;
        }
    #legend img  {
          width: 200px;
          height: 30px;
        }
    #windy iframe  {
          width: 1560px;
          height: 1080px;
          position:absolute;
          top:-300px;
          left:-700px;
        }
    /*#controls div {
          width: 130px;
          height: 110px;//120 110
          position: absolute;
          bottom: 10px;
          right: 10px;
          font-family: 'arial', 'sans-serif';
          font-size: 10px;
          text-align: left;
          background-color: white;
          border: 1px solid black;
          padding: 10px 10px 0px 10px;
        }
    #controls input[type="checkbox"] {
      width: 10px;
      height: 10px;
    }*/
  }
</style>
<!--<h1 class="container-fluid text-center">AQI Map</h1>-->
<div id="mapp" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<div id="legend"></div>
<div id="windy"></div>
<div id="controls"></div>

<script type="text/javascript">
  // 基于准备好的dom，初始化echarts实例
  var geoJsonObject;
  var thejson;
  var myChart;
  var myVOCsChart;
  var myAirBoxChart;
  var myLoRaChart;
  var dataAllMap;
  var today = new Date();
  var date = today.getFullYear()+'-'+'0'+(today.getMonth())+'-01';


  function showAirBoxChart(device) {
    myAirBoxChart = echarts.init(document.getElementById('main'));
    dataAllMap = new Map();
    $.ajax({
      url: "echarts/getabtc",
      type: "POST",
      data: {
        siteName: device
      },
      dataType: "json",
      cache: false,
      success: function(data) {
        //console.log(data);
        showAirBoxData(data, device);
      }
    });
  }

  function showAirBoxData(data, device) {
    myAirBoxChart.setOption(option = {
      title: {
        text: device + '：' + data['newabtc'].pm25 + ', ' + data['newabtc'].t,
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
        data: data['abtc'].reverse().map(function(item) {
          return item.t
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
      series: [{
        name: device + ' PM2.5',
        type: 'line',
        data: data['abtc'].map(function(item) {
          return item.pm25
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
            yAxis: 15.4
          }, {
            yAxis: 35.4
          }, {
            yAxis: 54.4
          }, {
            yAxis: 150.4
          }, {
            yAxis: 250.4
          }]
        }
      }]
    });
  }


</script>
<script type="text/javascript">

  var map;
  var legend = document.getElementById('legend');
  var windy = document.getElementById('windy');
  var controls = document.getElementById('controls');
  var div1 = document.createElement('div');
  var div2 = document.createElement('div');
  div1.innerHTML = '<img src="/img/pm25level.png"> ';
  //div2.innerHTML = '<input id="my_checkbox" type="checkbox" onclick="getValue()" checked/><label>&nbsp;Taichung boundary</label><br>';
                    /*<input id="my_checkbox" type="checkbox" onclick="getLoRa()" checked/><label>&nbsp;LoRa Node</label><br>\
                    <input id="my_checkbox" type="checkbox" onclick="getVOCS()" checked/><label>&nbsp;VOCS</label><br>\
                    <input id="my_checkbox" type="checkbox" onclick="getAirBox()" checked/><label>&nbsp;AirBox</label>';*/
  div2.innerHTML = '<iframe src="https://www.airvisual.com/earth" scrolling="NO" frameborder="0" ></iframe>';
  div2.innerHTML = '<div id="radiodiv" class="iDiv" style="overflow:hidden; position:relative"><iframe src="https://www.airvisual.com/earth" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe></div>';
  legend.appendChild(div1);
  windy.appendChild(div2);

  function myMap() {
    var mapOptions = {
      center: new google.maps.LatLng(24.211736, 120.642433),
      zoom: 11,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      gestureHandling: 'greedy',
      zoomControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER
          },
      streetViewControlOptions: {
              position: google.maps.ControlPosition.LEFT_TOP
          }
    };
    map = new google.maps.Map(document.getElementById("mapp"), mapOptions);

    var contentString = '<div id="main" class="myDiv container text-center"></div>';
    var currentInfoWindow;

    // Color each letter gray. Change the color when the isColorful property
    // is set to true.
    //$.blockUI({
    //  message: '<img src="/img/ajax-loader.gif" />'
    //});

    $.ajax({
      url: "echarts/getabtcobservation",
      type: "POST",
      dataType: "json",
      cache: false,
      success: function(data) {
        data.map(function(item) {

					//console.log(item);

          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.lat, item.lon),
            icon: 'data:image/svg+xml;charset=utf-8,%09<svg%20width%3D"35"%20height%3D"35"%20viewBox%3D"-55%20-55%2090%2090"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg">%09%09%09%09<rect%20x%3D"-35"%20y%3D"-35"%20width%3D"90"%20height%3D"90"%20fill%3D"%23'+changeByPM25(item.pm25)+'"%20%2F>%09%09%09<text%20x%3D"0"%20y%3D"13"%09%09%09fill%3D"%23000000"%20text-anchor%3D"middle"%20%09%09%09style%3D"font-size%3A35px%3B%20font-weight%3A%20800%3B%20">%09%09'+item.pm25+'%09%09<%2Ftext>%09<%2Fsvg>',
            title: item.device_id,
            map: map
          });
          //$.unblockUI();
          marker.addListener('click', function() {
            if(currentInfoWindow!=null)
              currentInfoWindow.close();
            var tmp_infowindow = new google.maps.InfoWindow({
              content: contentString
            });
            tmp_infowindow.open(map, marker);
            google.maps.event.addListener(tmp_infowindow, 'domready', function(){
              showAirBoxChart(item.device_id);
            });
            currentInfoWindow = tmp_infowindow;
          });
        });
      }
    });


    google.maps.event.addDomListener(window, "resize", function() {
      var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
    });
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(windy);

  }


  function changeByPM25(pm25) {
    if (pm25 <= 15.4) {
      return '2FC737';
    } else if (pm25 > 15.4 && pm25 <= 35.4) {
      return 'FFFF00';
    } else if (pm25 > 35.4 && pm25 <= 54.4) {
      return 'FF7C19';
    } else if (pm25 > 54.4 && pm25 <= 150.4) {
      return 'F33515';
    } else if (pm25 > 150.4 && pm25 <= 250.4) {
      return 'BC1049';
    } else {
      return '800000';
    }
  }


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAH5_XNxD6PTKNE4jVKvPDQEuONSIaqZms&callback=myMap"></script>
