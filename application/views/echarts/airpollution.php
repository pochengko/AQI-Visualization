<html>
    <head>
      <base href="<?php echo base_url();?>"/>
        <title><?php echo $title ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="/img/icon.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/public/js/jquery.blockUI.js"></script>
        <!--<script type="text/javascript" src="/public/js/echarts.min.js" ></script>-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts.min.js" ></script>


   </head>
   <body>
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
       var myVOCsChart;
       var myAirBoxChart;
       var myLoRaChart;
       var dataAllMap;
       var today = new Date();
       var date = today.getFullYear()+'-'+'0'+(today.getMonth())+'-01';

       var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();


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
             //console.log(date);
             dohihi(data, site);
           }
         });
       }

       function dohihi(data, site) {
         myChart.setOption(option = {
           title: {
             text: site + '：' + data['newAQI'].PM25 + ', ' + data['newAQI'].PublishTime,
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
             name: site + ' PM2.5',
             type: 'line',
             data: data['airquality'].map(function(item) {
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
             /*if (data['newVOC']['id'] == '4') {
               data['newVOC']['PM25'] = 'NA';
               data['newVOC']['PublishTime'] = thisdate;
             }*/
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

             /*if (data['newlora']['id'] == '3' || data['newlora']['id'] == '1') {
               data['newlora']['PM25'] = 'NA';
               data['newlora']['timestamp'] = thisdate;
             }*/

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
       windy.appendChild(div2);

       function myMap() {
         $.blockUI({ message: '<img src="/img/ajax-loader.gif" />' });
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
         var infowindow = new google.maps.InfoWindow({
           content: contentString
         });

         $.ajax({
           url: "echarts/getvocobservation",
           type: "POST",
           dataType: "json",
           cache: false,
           success: function(data) {
             //data[1]['PM25'] = 'NA';//407_30002
             data.splice(1,1);
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
               //$.unblockUI();
     					//console.log(item);
               var marker = new google.maps.Marker({
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
             $.unblockUI();
     					//console.log(item);
               var square = {
                 path: 'M -2,-2 2,-2 2,2 -2,2 z', // 'M -2,0 0,-2 2,0 0,2 z',
                 fillColor: changeByPM25(item.PM25),
                 fillOpacity: 0.7,
                 //strokeColor: changeByPM25(item.PM25),
                 strokeWeight: 0,
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

             //data[2]['PM25'] = 'NA';//C

             data.splice(0,3); //A

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
         });


         google.maps.event.addDomListener(window, "resize", function() {
           var center = map.getCenter();
           google.maps.event.trigger(map, "resize");
           map.setCenter(center);
         });
         //google.maps.event.addDomListener(window, 'load', myMap);
         map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
         map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(windy);

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
     <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAH5_XNxD6PTKNE4jVKvPDQEuONSIaqZms&callback=myMap"></script>

</body>
</html>
