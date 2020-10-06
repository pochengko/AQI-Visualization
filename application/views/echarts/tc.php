
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
      width: 650px;
      height: 400px;
    }
    #legend img {
          width: 450px;
          height: 50px;
        }
    #controls div {
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
        }
  }

  @media only screen and (max-width: 1440px) {
    .myDiv {
      width: 455px;
      height: 275px;
    }
    #legend img {
          width: 315px;
          height: 35px;
        }
    #controls div {
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
        }
  }

  @media only screen and (max-width: 767px) {
    .myDiv {
      width: 390px;
      height: 270px;
    }
    #legend img {
          width: 270px;
          height: 35px;
        }
    #controls div {
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
        }
  }

  @media only screen and (max-width: 480px) {
    .myDiv {
      width: 260px;
      height: 215px;
    }
    #legend img  {
          width: 200px;
          height: 30px;
        }
    #controls div {
          width: 130px;
          height: 110px;/*120 110*/
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
    }
  }
</style>
<!--<h1 class="container-fluid text-center">AQI Map</h1>-->
<div id="mapp" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<div id="legend"></div>
<div id="controls"></div>

<script type="text/javascript">
  // 基于准备好的dom，初始化echarts实例
  var myChart;
  var myVOCsChart;
  var myAirBoxChart;
  var myLoRaChart;
  var dataAllMap;
  var today = new Date();
  var date = today.getFullYear()+'-'+'0'+(today.getMonth())+'-01';

  function showVOCsChart(stId) {
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
        text: 'VOCS '+stId + '：' + data['newVOC'].PM25 + ', ' + data['newVOC'].PublishTime,
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
        name: 'VOCS '+stId + ' PM2.5',
        type: 'line',
        data: data['voc'].map(function(item) {
          return item.PM25
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

  function showAirBoxChart(device) {
    myAirBoxChart = echarts.init(document.getElementById('main'));
    dataAllMap = new Map();
    $.ajax({
      url: "echarts/getairbox",
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
        text: device + '：' + data['newAirBox'].PM25 + ', ' + data['newAirBox'].t,
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
        data: data['airbox'].map(function(item) {
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
        data: data['airbox'].map(function(item) {
          return item.PM25
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
        text: 'LoRa_'+ sensor + '：' + data['newlora'].PM25 + ', ' + data['newlora'].timestamp,
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
        name: 'LoRa_' + sensor + ' PM2.5',
        type: 'line',
        data: data['lora'].map(function(item) {
          if ((item.PM25 > 0) && (item.PM25 < 501)) {
            return item.PM25;
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

  /*function showChart(town) {
    myChart = echarts.init(document.getElementById('main'));
    dataAllMap = new Map();
    $.ajax({
        url: "echarts/getiliaqiarea",
        type: "GET",
        data: {
          Town: town
        },
        dataType: "json",
        cache: false,
        success: function(data) {
          //console.log(data);
          data.map(function(item) {
          })
          dohihi(data, town);
        }
    });
  }*/

  /*function dohihi(data, town) {
    myChart.setOption(option = {
      title: {
        text: town + ' Dist.'
      },
      tooltip: {
        trigger: 'axis'
      },
      legend: {
        data: ['ILI', 'AQI']
      },
      toolbox: {
        show: true,
        feature: {
          //dataView : {show: true, readOnly: true},
          //magicType : {show: true, type: ['line', 'bar']},
          saveAsImage: {
            show: true
          }
        }
      },
      calculable: true,
      xAxis: [{
        type: 'category',
        data: data.map(function(item) {
          return item.Year
        })
      }],
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
      series: [{
          name: 'ILI',
          type: 'bar',
          yAxisIndex: 1,
          data: data.map(function(item) {
            return item.ILI
          }),
          markPoint: {
            data: [{
                type: 'max',
                name: '最大值',
                symbolSize: 70
              },
              {
                type: 'min',
                name: '最小值',
                symbolSize: 70
              }
            ]
          },
          markLine: {
            data: [{
              type: 'average',
              name: '平均值'
            }]
          }
        },
        {
          name: 'AQI',
          type: 'bar',
          data: data.map(function(item) {
            return item.AQI
          }),
          markPoint: {
            data: [{
                type: 'max',
                name: '最大值',
                symbolSize: 70
              },
              {
                type: 'min',
                name: '最小值',
                symbolSize: 70
              }
            ]
          },
          markLine: {
            data: [{
              type: 'average',
              name: '平均值'
            }]
          }
        }
      ]
    });
  }*/

</script>
<script type="text/javascript">
  var map;
  var legend = document.getElementById('legend');
  var controls = document.getElementById('controls');
  var div1 = document.createElement('div');
  //var div2 = document.createElement('div');
  div1.innerHTML = '<img src="/img/pm25level.png"> ';
  //div2.innerHTML = '<input id="my_checkbox" type="checkbox" onclick="getValue()" checked/><label>&nbsp;Taichung boundary</label><br>';
                    /*<input id="my_checkbox" type="checkbox" onclick="getLoRa()" checked/><label>&nbsp;LoRa Node</label><br>\
                    <input id="my_checkbox" type="checkbox" onclick="getVOCS()" checked/><label>&nbsp;VOCS</label><br>\
                    <input id="my_checkbox" type="checkbox" onclick="getAirBox()" checked/><label>&nbsp;AirBox</label>';*/
  legend.appendChild(div1);

  function myMap() {
    var mapOptions = {
      center: new google.maps.LatLng(24.176976, 120.642433),
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
    var infowindow = new google.maps.InfoWindow({
      content: contentString,
    });

    $.getJSON("/public/map.topojson", function(data){
        geoJsonObject = topojson.feature(data, data.objects.collection)
        map.data.addGeoJson(geoJsonObject);
      });

    /*map.data.loadGeoJson(
      'https://raw.githubusercontent.com/g0v/twgeojson/master/json/twTown1982.geo.json');
      //https://raw.githubusercontent.com/g0v/twgeojson/master/json/twTown1982.topo.json*/

    // Color each letter gray. Change the color when the isColorful property
    // is set to true.
    $.blockUI({
      message: '<img src="/img/ajax-loader.gif" />'
    });
    map.data.setStyle(function(feature) {
      var color;
      var name = feature.getProperty('Id');
      //console.log(name);
      /*if (name == '0') {
        color = 'white'; //1
      } else if (feature.getProperty('name') == '台中市/大甲區') {
        color = '#005ce6'; //2
      } else if (feature.getProperty('name') == '台中市/清水區' || feature.getProperty('name') == '台中市/清水鎮(海區') {
        color = '#005ce6'; //3 清水
      } else if (feature.getProperty('name') == '台中市/大雅區') {
        color = 'gold'; //4
      } else if (feature.getProperty('name') == '台中市/中區') {
        color = 'gold'; //5
      } else if (feature.getProperty('name') == '台中市/西區') {
        color = 'gold'; //6
      } else if (feature.getProperty('name') == '台中市/新社區') {
        color = '#009933'; //7-
      } else if (feature.getProperty('name') == '台中市/梧棲區' || feature.getProperty('name') == '台中市/梧棲鎮(海區') {
        color = '#005ce6'; //8 梧棲
      } else if (feature.getProperty('name') == '台中市/大里區') {
        color = '#009933'; //9-
      } else if (feature.getProperty('name') == '台中市/后里區') {
        color = 'gold'; //10
      } else if (feature.getProperty('name') == '台中市/南屯區') {
        color = 'gold'; //11
      } else if (feature.getProperty('name') == '台中市/霧峰區') {
        color = '#009933'; //12-
      } else if (feature.getProperty('name') == '台中市/東勢區') {
        color = '#009933'; //13-
      } else if (feature.getProperty('name') == '台中市/外埔區') {
        color = '#005ce6'; //14
      } else if (feature.getProperty('name') == '台中市/北區') {
        color = 'gold'; //15
      } else if (feature.getProperty('name') == '台中市/太平區') {
        color = '#009933'; //16-
      } else if (feature.getProperty('name') == '台中市/石岡區') {
        color = '#009933'; //17-
      } else if (feature.getProperty('name') == '台中市/南區') {
        color = 'gold'; //18
      } else if (feature.getProperty('name') == '台中市/神岡區') {
        color = 'gold'; //19
      } else if (feature.getProperty('name') == '台中市/大肚區') {
        color = 'gold'; //20
      } else if (feature.getProperty('name') == '台中市/東區') {
        color = 'gold'; //21
      } else if (feature.getProperty('name') == '台中市/潭子區') {
        color = 'gold'; //22-
      } else if (feature.getProperty('name') == '台中市/龍井區') {
        color = 'gold'; //23
      } else if (feature.getProperty('name') == '台中市/烏日區') {
        color = 'gold'; //24
      } else if (feature.getProperty('name') == '台中市/大安區') {
        color = '#005ce6'; //25
      } else if (feature.getProperty('name') == '台中市/豐原區') {
        color = 'gold'; //26-
      } else if (feature.getProperty('name') == '台中市/西屯區') {
        color = 'gold'; //27
      } else if (feature.getProperty('name') == '台中市/北屯區') {
        color = '#009933'; //28-
      } else if (feature.getProperty('name') == '台中市/和平區') {
        color = '#009933'; //29-
      } else {
        color = 'gray';
      }*/
      $.unblockUI();

      return /** @type {google.maps.Data.StyleOptions} */  ({
        fillColor: color,
        strokeColor: color,
        strokeWeight: 2
      });
    });

    // When the user clicks, set 'isColorful', changing the color of the letters.
    /*map.data.addListener('click', function(event) {
      var anchor = new google.maps.MVCObject();
      var town;

      //event.feature.setProperty('isColorful', true);
      if (event.feature.getProperty('Id') == 0) {
        town = 'Shalu';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == 0) {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/大甲區') {
        town = 'Dajia';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/大甲區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/清水區' || event.feature.getProperty('name') == '台中市/清水鎮(海區') {
        town = 'Qingshui';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/清水區' || event.feature.getProperty('name') == '台中市/清水鎮(海區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/大雅區') {
        town = 'Daya';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/大雅區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/中區') {
        town = 'Central';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/中區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/西區') {
        town = 'West';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/西區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/新社區') {
        town = 'Xinshe';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/新社區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/梧棲區' || event.feature.getProperty('name') == '台中市/梧棲鎮(海區') {
        town = 'Wuqi';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/梧棲區' || event.feature.getProperty('name') == '台中市/梧棲鎮(海區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/大里區') {
        town = 'Dali';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/大里區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/后里區') {
        town = 'Houli';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/后里區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/南屯區') {
        town = 'Nantun';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/南屯區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/霧峰區') {
        town = 'Wufeng';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/霧峰區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/東勢區') {
        town = 'Dongshih';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/東勢區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/外埔區') {
        town = 'Waipu';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/外埔區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/北區') {
        town = 'North';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/北區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/太平區') {
        town = 'Taiping';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/太平區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/石岡區') {
        town = 'Shihgang';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/石岡區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/南區') {
        town = 'South';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/南區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/神岡區') {
        town = 'Shengang';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/神岡區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/大肚區') {
        town = 'Dadu';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/大肚區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/東區') {
        town = 'East';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/東區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/潭子區') {
        town = 'Tanzih';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/潭子區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/龍井區') {
        town = 'Longjing';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/龍井區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/烏日區') {
        town = 'Wurih';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/烏日區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/大安區') {
        town = 'Da’an';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/大安區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/豐原區') {
        town = 'Fongyuan';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/豐原區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/西屯區') {
        town = 'Xitun';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/西屯區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/北屯區') {
        town = 'Beitun';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/北屯區') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('name') == '台中市/和平區') {
        town = 'Hepin';
        map.data.forEach(function(feature) {
          if (feature.getProperty('name') == '台中市/和平區') {
            feature.setProperty('isColorful', true);
          }
        });
      }
      anchor.set("position", event.latLng);
      infowindow.open(map, anchor);
      showChart(town);
    });*/

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
              text: item.PM25
						},
            icon: {
              path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
              fillColor: changeByPM25(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25(item.PM25),
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
              fillColor: changeByPM25_over(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25_over(item.PM25),
              strokeWeight: 0,
              scale: 8
            });
          });

          marker.addListener('mouseout', function() {
            this.setIcon({
              path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
              fillColor: changeByPM25(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25(item.PM25),
              strokeWeight: 0,
              scale: 8
            });
          });
        });
      }
    });


    $.ajax({
      url: "echarts/getairboxobservation",
      type: "POST",
      dataType: "json",
      cache: false,
      success: function(data) {
        data.map(function(item) {
					//console.log(item);
          var square = {
            path: 'M -2,-2 2,-2 2,2 -2,2 z', // 'M -2,0 0,-2 2,0 0,2 z',
            fillColor: changeByPM25(item.PM25),
            fillOpacity: 0.7,
            //strokeColor: changeByPM25(item.PM25),
            strokeWeight: 0.5,
            scale: 6.5
          };
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.latitude, item.longitude),
            label: {
              text: item.PM25
						},
            icon: square,
            title: item.observationName,
            map: map
          });
          marker.addListener('click', function() {
            infowindow.open(map, marker);
            showAirBoxChart(item.observationName);
          });

          marker.addListener('mouseover', function() {
            //this.setIcon({
            //  path: google.maps.SymbolPath.CIRCLE,
            //  fillColor: changeByPM25_over(item.PM25),
            //  fillOpacity: 0.7,
            //  strokeColor: changeByPM25_over(item.PM25),
            //  strokeWeight: 0,
            //  scale: 15
            //});
          });

          marker.addListener('mouseout', function() {
            //this.setIcon({
            //  path: google.maps.SymbolPath.CIRCLE,
            //  fillColor: changeByPM25(item.PM25),
            //  fillOpacity: 0.7,
            //  strokeColor: changeByPM25(item.PM25),
            //  strokeWeight: 0,
            //  scale: 15
            //});
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

        data.splice(0,1); //A
        data.splice(0,1); //B
        //data.splice(1,1);

        data.map(function(item) {
					//console.log(item);
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.latitude, item.longitude),
            label: {
              text: item.PM25
						},
            icon: {
              path: google.maps.SymbolPath.BACKWARD_OPEN_ARROW,
              fillColor: changeByPM25(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25(item.PM25),
              strokeWeight: 0,
              scale: 8,
            },
            title: 'LoRa_'+item.observationName,
            animation: google.maps.Animation.DROP,
            map: map
          });
          marker.addListener('click', function() {
            infowindow.open(map, marker);
            showLoRaChart(item.observationName);
          });

          marker.addListener('mouseover', function() {
            this.setIcon({
              path: google.maps.SymbolPath.BACKWARD_OPEN_ARROW,
              fillColor: changeByPM25_over(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25_over(item.PM25),
              strokeWeight: 0,
              scale: 8
            });
          });

          marker.addListener('mouseout', function() {
            this.setIcon({
              path: google.maps.SymbolPath.BACKWARD_OPEN_ARROW,
              fillColor: changeByPM25(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25(item.PM25),
              strokeWeight: 0,
              scale: 8
            });
          });
        });
      }
    });*/

    google.maps.event.addDomListener(window, "resize", function() {
      var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
    });
    //google.maps.event.addDomListener(window, 'load', myMap);
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
    //map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controls);

  }

  function getValue() {
   var isChecked = document.getElementById('my_checkbox').checked;
   var the_value = isChecked ? 1 : 0;
   //do something with that value
   if (the_value == 1) {
     map.data.setStyle(function(feature) {
       var color;
       var name = feature.getProperty('name');
       if (feature.getProperty('name') == '台中市/沙鹿區') {
         color = 'gold'; //1
       } else if (feature.getProperty('name') == '台中市/大甲區') {
         color = '#005ce6'; //2
       } else if (feature.getProperty('name') == '台中市/清水區' || feature.getProperty('name') == '台中市/清水鎮(海區') {
         color = '#005ce6'; //3 清水
       } else if (feature.getProperty('name') == '台中市/大雅區') {
         color = 'gold'; //4
       } else if (feature.getProperty('name') == '台中市/中區') {
         color = 'gold'; //5
       } else if (feature.getProperty('name') == '台中市/西區') {
         color = 'gold'; //6
       } else if (feature.getProperty('name') == '台中市/新社區') {
         color = '#009933'; //7-
       } else if (feature.getProperty('name') == '台中市/梧棲區' || feature.getProperty('name') == '台中市/梧棲鎮(海區') {
         color = '#005ce6'; //8 梧棲
       } else if (feature.getProperty('name') == '台中市/大里區') {
         color = '#009933'; //9-
       } else if (feature.getProperty('name') == '台中市/后里區') {
         color = 'gold'; //10
       } else if (feature.getProperty('name') == '台中市/南屯區') {
         color = 'gold'; //11
       } else if (feature.getProperty('name') == '台中市/霧峰區') {
         color = '#009933'; //12-
       } else if (feature.getProperty('name') == '台中市/東勢區') {
         color = '#009933'; //13-
       } else if (feature.getProperty('name') == '台中市/外埔區') {
         color = '#005ce6'; //14
       } else if (feature.getProperty('name') == '台中市/北區') {
         color = 'gold'; //15
       } else if (feature.getProperty('name') == '台中市/太平區') {
         color = '#009933'; //16-
       } else if (feature.getProperty('name') == '台中市/石岡區') {
         color = '#009933'; //17-
       } else if (feature.getProperty('name') == '台中市/南區') {
         color = 'gold'; //18
       } else if (feature.getProperty('name') == '台中市/神岡區') {
         color = 'gold'; //19
       } else if (feature.getProperty('name') == '台中市/大肚區') {
         color = 'gold'; //20
       } else if (feature.getProperty('name') == '台中市/東區') {
         color = 'gold'; //21
       } else if (feature.getProperty('name') == '台中市/潭子區') {
         color = 'gold'; //22-
       } else if (feature.getProperty('name') == '台中市/龍井區') {
         color = 'gold'; //23
       } else if (feature.getProperty('name') == '台中市/烏日區') {
         color = 'gold'; //24
       } else if (feature.getProperty('name') == '台中市/大安區') {
         color = '#005ce6'; //25
       } else if (feature.getProperty('name') == '台中市/豐原區') {
         color = 'gold'; //26-
       } else if (feature.getProperty('name') == '台中市/西屯區') {
         color = 'gold'; //27
       } else if (feature.getProperty('name') == '台中市/北屯區') {
         color = '#009933'; //28-
       } else if (feature.getProperty('name') == '台中市/和平區') {
         color = '#009933'; //29-
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
   } else {
     map.data.setStyle({visible: false});
   }
}

function getLoRa() {
 var isChecked = document.getElementById('my_checkbox').checked;
 var the_value = isChecked ? 1 : 0;
 //do something with that value
 if (the_value == 1) {


 } else {
   marker.setVisible(null);

 }
}

function getVOCS() {
 var isChecked = document.getElementById('my_checkbox').checked;
 var the_value = isChecked ? 1 : 0;
 //do something with that value
 if (the_value == 1) {

 } else {
   map.data.setStyle({visible: false});
 }
}

function getAirBox() {
 var isChecked = document.getElementById('my_checkbox').checked;
 var the_value = isChecked ? 1 : 0;
 //do something with that value
 if (the_value == 1) {

 } else {
   map.data.setStyle({visible: false});
 }
}



  function changeByPM25(pm25) {
    if (pm25 <= 15.4) {
      return '#2FC737';
    } else if (pm25 > 15.4 && pm25 <= 35.4) {
      return '#FFFF00';
    } else if (pm25 > 35.4 && pm25 <= 54.4) {
      return '#FF7C19';
    } else if (pm25 > 54.4 && pm25 <= 150.4) {
      return '#F33515';
    } else if (pm25 > 150.4 && pm25 <= 250.4) {
      return '#BC1049';
    } else {
      return '#800000';
    }
  }

  function changeByPM25_over(pm25) {
    if (pm25 <= 15.4) {
      return '#0B610B';
    } else if (pm25 > 15.4 && pm25 <= 35.4) {
      return '#E1D319';
    } else if (pm25 > 35.4 && pm25 <= 54.4) {
      return '#DF7401';
    } else if (pm25 > 54.4 && pm25 <= 150.4) {
      return '#DF0101';
    } else if (pm25 > 150.4 && pm25 <= 250.4) {
      return '#BC1049';
    } else {
      return '#FF3333';
    }
  }


</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAH5_XNxD6PTKNE4jVKvPDQEuONSIaqZms&callback=myMap"></script>
