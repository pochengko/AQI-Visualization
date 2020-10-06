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
  }
</style>
<script type="text/javascript">
  // 基于准备好的dom，初始化echarts实例

  var myChart;

  var dataAllMap;
  var today = new Date();
  var date = today.getFullYear()+'-'+'0'+(today.getMonth())+'-01';
  var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

  function showChart(site) {
    myChart = echarts.init(document.getElementById('main'));
    dataAllMap = new Map();
    $.ajax({
      url: "echarts/getdata2",
      type: "POST",
      data: {
        siteName: site
      },
      dataType: "json",
      cache: false,
      success: function(data) {
        //console.log(data['airquality']);
        getpredict(data, site);
      }
    });
  }

  function getpredict(Hdata, site) {
    $.ajax({
      url: "echarts/getpredict",
      type: "POST",
      data: {
        siteName: site
      },
      dataType: "json",
      cache: false,
      success: function(data) {
        console.log(data);
        dohihi(Hdata, site, data);
      }
    });
  }

  function dohihi(Hdata, site, Predictdata) {
    myChart.setOption(option = {
      title: {
        text: site,
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
      legend: {
				type: 'scroll',
				data: ['Forecast', 'Actual']
			},
      xAxis: {
        data: Predictdata.reverse().map(function(item) {
          return item.Time;
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

      series: [{
        name: 'Forecast',//site + 'Predict PM2.5',
        type: 'line',
        smooth: true,
        data: Predictdata.map(function(item) {
          return Math.round(item.PM25_pred*10)/10;
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
        }
      },{
        name: 'Actual',//site + ' PM2.5',
        type: 'line',
        smooth: true,
        data: Hdata['airquality'].reverse().map(function(item) {
          return item.PM25;
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

<!--<h1 class="container-fluid text-center">AQI Map</h1>-->
<div id="map" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>
<div id="legend"></div>
<div id="windy"></div>
<script type="text/javascript">
  var map;
  var legend = document.getElementById('legend');
  var windy = document.getElementById('windy');
  var div1 = document.createElement('div');
  var div2 = document.createElement('div');

  div1.innerHTML = '<img src="/img/pm25level.png"> ';
  //div2.innerHTML = '<iframe src="https://embed.windy.com/embed2.html?lat=22.918&lon=122.256&zoom=5&level=surface&overlay=wind&menu=true&message=&marker=&forecast=12&calendar=now&location=coordinates&type=map&actualGrid=&metricWind=kt&metricTemp=%C2%B0C" frameborder="0"></iframe>';
  //div2.innerHTML = '<iframe src="https://earth.nullschool.net/#current/particulates/surface/level/overlay=pm2.5/orthographic=-239.07,22.58,2274" scrolling="NO" frameborder="0"></iframe>';
  div2.innerHTML = '<iframe src="https://www.airvisual.com/earth" scrolling="NO" frameborder="0" ></iframe>';
  div2.innerHTML = '<div id="radiodiv" class="iDiv" style="overflow:hidden; position:relative"><iframe src="https://www.airvisual.com/earth" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe></div>';
  legend.appendChild(div1);
  //windy.appendChild(div2);

  function myMap() {
    $.blockUI({ message: '<img src="/img/ajax-loader.gif" />' });
    var mapOptions = {
      center: new google.maps.LatLng(24.195494, 121.008184),
      zoom: 9,
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

    $.getJSON("/public/tc33.topojson", function(data){
        geoJsonObject = topojson.feature(data, data.objects.layer1)
        map.data.addGeoJson(geoJsonObject);
      });


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
        data.splice(0,18);
        data.splice(5,53);
        data.splice(11,1);
        data.splice(16,1);
        data.map(function(item) {
          $.unblockUI();
					//console.log(data);
          /*var marker = new google.maps.Marker({
            position: new google.maps.LatLng(item.latitude, item.longitude),
            label: {
              text: item.PM25
						},
            icon: {
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByPM25(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25(item.PM25),
              strokeWeight: 0,
              scale: 15,
            },
            title: item.county + item.siteName + item.observationName,
            map: map
          });
          marker.addListener('click', function() {
            infowindow.open(map, marker);
            showChart(item.observationName);
          });

          marker.addListener('mouseover', function() {
            this.setIcon({
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByPM25_over(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25_over(item.PM25),
              strokeWeight: 0,
              scale: 15
            });
          });

          marker.addListener('mouseout', function() {
            this.setIcon({
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: changeByPM25(item.PM25),
              fillOpacity: 0.7,
              strokeColor: changeByPM25(item.PM25),
              strokeWeight: 0,
              scale: 15
            });
          });*/

          map.data.setStyle(function(feature) {
            var color;
            var station;
            var value;
            var Id = feature.getProperty('Id');
            if (feature.getProperty('Id') == '15') {
              value = data[8].PM25;
              station = '霧峰';
            } else if (feature.getProperty('Id') == '21') {
              //color = '#FFFF00'; //2
              value = data[9].PM25;
              station = '烏日';
            } else if (feature.getProperty('Id') == '33') {
              value = data[4].PM25;
              station = '大里';
              //color = '#2FC737'; //4
            } else if (feature.getProperty('Id') == '52') {
              value = data[6].PM25;
              station = '太平';
              //color = '#2FC737'; //5
            } else if (feature.getProperty('Id') == '64') {
              value = data[13].PM25;
              station = '大肚';
              //color = '#2FC737'; //5
            } else if (feature.getProperty('Id') == '48') {
              value = data[10].PM25;
              station = '文山';
              //color = '#2FC737'; //6
            } else if (feature.getProperty('Id') == '66') {
              value = data[0].PM25;
              station = '西屯';
              //color = '#FFFF00'; //7-
            } else if (feature.getProperty('Id') == '67') {
              value = data[1].PM25;
              station = '忠明';
              //color = '#2FC737'; //8 梧棲
            } else if (feature.getProperty('Id') == '88') {
              value = data[14].PM25;
              station = '東大';
              //color = '#2FC737'; //9-
            } else if (feature.getProperty('Id') == '84') {
              value = data[15].PM25;
              station = '龍井';
              //color = '#2FC737'; //10
            } else if (feature.getProperty('Id') == '111') {
              value = data[3].PM25;
              station = '沙鹿';
              //color = '#2FC737'; //11
            } else if (feature.getProperty('Id') == '140') {
              value = data[11].PM25;
              station = '梧棲';
              //color = '#FFFF00'; //12-
            } else if (feature.getProperty('Id') == '172') {
              value = data[12].PM25;
              station = '清水';
              //color = '#FFFF00'; //13-
            } else if (feature.getProperty('Id') == '264') {
              value = data[7].PM25;
              station = '大甲';
              //color = '#2FC737'; //14
            } else if (feature.getProperty('Id') == '146') {
              //color = '#FFFF00'; //15
              value = data[2].PM25;
              station = '豐原';
            } else if (feature.getProperty('Id') == '207') {
              value = data[5].PM25;
              station = '后里';
              //color = '#FFFF00'; //16-
            }  else {
              value = 'gray';
            }

            return /** @type {google.maps.Data.StyleOptions} */  ({
              fillColor: changeByPM25(value),
              strokeColor: changeByPM25(value),
              fillOpacity: 0.6,
              strokeWeight: 2
            });
          });


          // When the user clicks, set 'isColorful', changing the color of the letters.
          map.data.addListener('click', function(event) {
            var anchor = new google.maps.MVCObject();
            var town;

            //event.feature.setProperty('isColorful', true);
            if (event.feature.getProperty('Id') == '15') {
              town = '霧峰';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '15') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '21') {
              town = '烏日';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '21') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '33') {
              town = '大里';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '33') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '52') {
              town = '太平';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '52') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '64') {
              town = '大肚';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '64') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '48') {
              town = '文山';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '48') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '66') {
              town = '西屯';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '66') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '67') {
              town = '忠明';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '67') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '88') {
              town = '東大';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '88') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '84') {
              town = '龍井';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '84') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '111') {
              town = '沙鹿';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '111') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '140') {
              town = '梧棲';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '140') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '172') {
              town = '清水';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '172') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '264') {
              town = '大甲';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '264') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '207') {
              town = '后里';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '207') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else if (event.feature.getProperty('Id') == '146') {
              town = '豐原';
              map.data.forEach(function(feature) {
                if (feature.getProperty('Id') == '146') {
                  feature.setProperty('isColorful', true);
                }
              });
            } else {
              town = 'Hepin';
              map.data.forEach(function(feature) {
                  feature.setProperty('isColorful', true);
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
              showChart(town);
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
        });
      }
    });

    /*map.data.setStyle(function(feature) {
      var color;
      var Id = feature.getProperty('Id');
      if (feature.getProperty('Id') == '15') {
        color = '#2FC737'; //1
      } else if (feature.getProperty('Id') == '21') {
        color = '#FFFF00'; //2
      } else if (feature.getProperty('Id') == '33') {
        color = '#2FC737'; //4
      } else if (feature.getProperty('Id') == '52') {
        color = '#2FC737'; //5
      } else if (feature.getProperty('Id') == '64') {
        color = '#2FC737'; //5
      } else if (feature.getProperty('Id') == '48') {
        color = '#2FC737'; //6
      } else if (feature.getProperty('Id') == '66') {
        color = '#FFFF00'; //7-
      } else if (feature.getProperty('Id') == '67') {
        color = '#2FC737'; //8 梧棲
      } else if (feature.getProperty('Id') == '88') {
        color = '#2FC737'; //9-
      } else if (feature.getProperty('Id') == '84') {
        color = '#2FC737'; //10
      } else if (feature.getProperty('Id') == '111') {
        color = '#2FC737'; //11
      } else if (feature.getProperty('Id') == '140') {
        color = '#FFFF00'; //12-
      } else if (feature.getProperty('Id') == '172') {
        color = '#FFFF00'; //13-
      } else if (feature.getProperty('Id') == '264') {
        color = '#2FC737'; //14
      } else if (feature.getProperty('Id') == '146') {
        color = '#FFFF00'; //15
      } else if (feature.getProperty('Id') == '207') {
        color = '#FFFF00'; //16-
      }  else {
        color = 'gray';
      }

      return /** @type {google.maps.Data.StyleOptions}   ({
        fillColor: color,
        strokeColor: color,
        strokeWeight: 2
      });
    });*/


    // When the user clicks, set 'isColorful', changing the color of the letters.
    /*map.data.addListener('click', function(event) {
      var anchor = new google.maps.MVCObject();
      var town;

      //event.feature.setProperty('isColorful', true);
      if (event.feature.getProperty('Id') == '15') {
        town = '霧峰';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '15') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '21') {
        town = '烏日';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '21') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '33') {
        town = '大里';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '33') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '52') {
        town = '太平';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '52') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '64') {
        town = '大肚';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '64') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '48') {
        town = '文山';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '48') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '66') {
        town = '西屯';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '66') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '67') {
        town = '忠明';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '67') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '88') {
        town = '東大';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '88') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '84') {
        town = '龍井';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '84') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '111') {
        town = '沙鹿';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '111') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '140') {
        town = '梧棲';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '140') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '172') {
        town = '清水';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '172') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '264') {
        town = '大甲';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '264') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '207') {
        town = '后里';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '207') {
            feature.setProperty('isColorful', true);
          }
        });
      } else if (event.feature.getProperty('Id') == '146') {
        town = '豐原';
        map.data.forEach(function(feature) {
          if (feature.getProperty('Id') == '146') {
            feature.setProperty('isColorful', true);
          }
        });
      } else {
        town = 'Hepin';
        map.data.forEach(function(feature) {

            feature.setProperty('isColorful', true);

        });
      }
      anchor.set("position", event.latLng);
      infowindow.open(map, anchor);
      showChart(town);
    });*/

    // When the user hovers, tempt them to click by outlining the letters.
    // Call revertStyle() to remove all overrides. This will use the style rules
    // defined in the function passed to setStyle()
    /*map.data.addListener('mouseover', function(event) {
      map.data.revertStyle();
      map.data.overrideStyle(event.feature, {
        strokeWeight: 4
      });
    });

    map.data.addListener('mouseout', function(event) {
      map.data.revertStyle();
    });*/


    google.maps.event.addDomListener(window, "resize", function() {
      var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
    });
    //google.maps.event.addDomListener(window, 'load', myMap);
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
    //map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(windy);

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
      return 'gray';
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAH5_XNxD6PTKNE4jVKvPDQEuONSIaqZms&callback=myMap"></script>
