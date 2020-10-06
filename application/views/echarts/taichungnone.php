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
        <script src="https://d3js.org/topojson.v1.min.js"></script>
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

       function showEPAIoTChart(device_id) {
         myEPAIoTChart = echarts.init(document.getElementById('main'));
         dataAllMap = new Map();
         $.ajax({
           url: "echarts/getepaiot",
           type: "POST",
           data: {
             siteName: device_id
           },
           dataType: "json",
           cache: false,
           success: function(data) {
             //console.log(data);
             showEPAIoTData(data, device_id);
           }
         });
       }

       function showEPAIoTData(data, device_id) {
         myEPAIoTChart.setOption(option = {
           title: {
             text: device_id + '：' + data['newepaiot'].PM25 + ', ' + data['newepaiot'].t,
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
             data: data['epaiot'].reverse().map(function(item) {
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
             name: device_id + ' PM2.5',
             type: 'line',
             data: data['epaiot'].map(function(item) {
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
             data: data['lora'].reverse().map(function(item) {
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
     <script type="text/javascript">

       var map;
       var legend = document.getElementById('legend');
       var windy = document.getElementById('windy');
       var controls = document.getElementById('controls');
       var div1 = document.createElement('div');
       var div2 = document.createElement('div');
       div1.innerHTML = '<img src="/img/pm25level.png"> ';
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


         /*$.getJSON("/public/taichung2.json", function(data){
             geoJsonObject = topojson.feature(data, data.objects.layer1)
             map.data.addGeoJson(geoJsonObject);
           });*/

         /*
         map.data.loadGeoJson(
           'https://raw.githubusercontent.com/g0v/twgeojson/master/json/twTown1982.geo.json');
           //https://raw.githubusercontent.com/g0v/twgeojson/master/json/twTown1982.topo.json
           */


         // Color each letter gray. Change the color when the isColorful property
         // is set to true.
         $.blockUI({
           message: '<img src="/img/ajax-loader.gif" />'
         });
         /*map.data.setStyle(function(feature) {
           var color;
           var TOWNNAME = feature.getProperty('TOWNNAME');
           if (feature.getProperty('TOWNNAME') == '沙鹿鎮') {
             color = '#cca300'; //1
           } else if (feature.getProperty('TOWNNAME') == '大甲鎮') {
             color = '#005ce6'; //2
           } else if (feature.getProperty('TOWNNAME') == '清水鎮' || feature.getProperty('TOWNNAME') == '清水鎮(海)') {
             color = '#005ce6'; //3 清水
           } else if (feature.getProperty('TOWNNAME') == '大雅鄉') {
             color = '#cca300'; //4
           } else if (feature.getProperty('TOWNNAME') == '中區') {
             color = '#cca300'; //5
           } else if (feature.getProperty('TOWNNAME') == '西區') {
             color = '#cca300'; //6
           } else if (feature.getProperty('TOWNNAME') == '新社鄉') {
             color = '#009933'; //7-
           } else if (feature.getProperty('TOWNNAME') == '梧棲鎮' || feature.getProperty('TOWNNAME') == '梧棲鎮(海)') {
             color = '#005ce6'; //8 梧棲
           } else if (feature.getProperty('TOWNNAME') == '大里市') {
             color = '#009933'; //9-
           } else if (feature.getProperty('TOWNNAME') == '后里鄉') {
             color = '#cca300'; //10
           } else if (feature.getProperty('TOWNNAME') == '南屯區') {
             color = '#cca300'; //11
           } else if (feature.getProperty('TOWNNAME') == '霧峰鄉') {
             color = '#009933'; //12-
           } else if (feature.getProperty('TOWNNAME') == '東勢鎮') {
             color = '#009933'; //13-
           } else if (feature.getProperty('TOWNNAME') == '外埔鄉') {
             color = '#005ce6'; //14
           } else if (feature.getProperty('TOWNNAME') == '北區') {
             color = '#cca300'; //15
           } else if (feature.getProperty('TOWNNAME') == '太平市') {
             color = '#009933'; //16-
           } else if (feature.getProperty('TOWNNAME') == '石岡鄉') {
             color = '#009933'; //17-
           } else if (feature.getProperty('TOWNNAME') == '南區') {
             color = '#cca300'; //18
           } else if (feature.getProperty('TOWNNAME') == '神岡鄉') {
             color = '#cca300'; //19
           } else if (feature.getProperty('TOWNNAME') == '大肚鄉') {
             color = '#cca300'; //20
           } else if (feature.getProperty('TOWNNAME') == '東區') {
             color = '#cca300'; //21
           } else if (feature.getProperty('TOWNNAME') == '潭子鄉') {
             color = '#cca300'; //22-
           } else if (feature.getProperty('TOWNNAME') == '龍井鄉') {
             color = '#005ce6'; //23
           } else if (feature.getProperty('TOWNNAME') == '烏日鄉') {
             color = '#cca300'; //24
           } else if (feature.getProperty('TOWNNAME') == '大安鄉') {
             color = '#005ce6'; //25
           } else if (feature.getProperty('TOWNNAME') == '豐原市') {
             color = '#cca300'; //26-
           } else if (feature.getProperty('TOWNNAME') == '西屯區') {
             color = '#cca300'; //27
           } else if (feature.getProperty('TOWNNAME') == '北屯區') {
             color = '#009933'; //28-
           } else if (feature.getProperty('TOWNNAME') == '和平鄉') {
             color = '#009933'; //29-
           } else {
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
           if (event.feature.getProperty('TOWNNAME') == '沙鹿鎮') {
             town = 'Shalu';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '沙鹿鎮') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '大甲鎮') {
             town = 'Dajia';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '大甲鎮') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '清水鎮' || event.feature.getProperty('TOWNNAME') == '清水鎮(海)') {
             town = 'Qingshui';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '清水鎮' || event.feature.getProperty('TOWNNAME') == '清水鎮(海)') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '大雅鄉') {
             town = 'Daya';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '大雅鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '中區') {
             town = 'Central';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '中區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '西區') {
             town = 'West';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '西區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '新社鄉') {
             town = 'Xinshe';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '新社鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '梧棲鎮' || event.feature.getProperty('TOWNNAME') == '梧棲鎮(海)') {
             town = 'Wuqi';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '梧棲鎮' || event.feature.getProperty('TOWNNAME') == '梧棲鎮(海)') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '大里市') {
             town = 'Dali';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '大里市') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '后里鄉') {
             town = 'Houli';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '后里鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '南屯區') {
             town = 'Nantun';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '南屯區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '霧峰鄉') {
             town = 'Wufeng';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '霧峰鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '東勢鎮') {
             town = 'Dongshih';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '東勢鎮') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '外埔鄉') {
             town = 'Waipu';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '外埔鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '北區') {
             town = 'North';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '北區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '太平市') {
             town = 'Taiping';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '太平市') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '石岡鄉') {
             town = 'Shihgang';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '石岡鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '南區') {
             town = 'South';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '南區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '神岡鄉') {
             town = 'Shengang';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '神岡鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '大肚鄉') {
             town = 'Dadu';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '大肚鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '東區') {
             town = 'East';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '東區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '潭子鄉') {
             town = 'Tanzih';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '潭子鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '龍井鄉') {
             town = 'Longjing';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '龍井鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '烏日鄉') {
             town = 'Wurih';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '烏日鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '大安鄉') {
             town = 'Da’an';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '大安鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '豐原市') {
             town = 'Fongyuan';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '豐原市') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '西屯區') {
             town = 'Xitun';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '西屯區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '北屯區') {
             town = 'Beitun';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '北屯區') {
                 feature.setProperty('isColorful', true);
               }
             });
           } else if (event.feature.getProperty('TOWNNAME') == '和平鄉') {
             town = 'Hepin';
             map.data.forEach(function(feature) {
               if (feature.getProperty('TOWNNAME') == '和平鄉') {
                 feature.setProperty('isColorful', true);
               }
             });
           }
           //anchor.set("position", event.latLng);
           //infowindow.open(map, anchor);
           //showChart(town);
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


         $.ajax({
           url: "echarts/getobservation",
           type: "POST",
           dataType: "json",
           cache: false,
           success: function(data) {
             //console.log(data);

             data.splice(0,18);
             data.splice(5,53);


             data.map(function(item) {
     					//console.log(item);
               var marker = new google.maps.Marker({
                 position: new google.maps.LatLng(item.latitude, item.longitude),
                 /*label: {
                   text: item.PM25
     						},
                 icon: {
                   path: google.maps.SymbolPath.CIRCLE,
                   fillColor: changeByPM25(item.PM25),
                   fillOpacity: 0.7,
                   strokeColor: changeByPM25(item.PM25),
                   strokeWeight: 0,
                   scale: 15,
                 },*/
                 icon: 'data:image/svg+xml;charset=utf-8,%09<svg%20width%3D"35"%20height%3D"35"%20viewBox%3D"-55%20-55%2090%2090"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg">%09%09%09%09<circle%20r%3D"35"%20fill%3D"%23'+changeByPM25(item.PM25)+'"%20%2F>%09%09%09<text%20x%3D"0"%20y%3D"13"%09%09%09fill%3D"%23000000"%20text-anchor%3D"middle"%20%09%09%09style%3D"font-size%3A35px%3B%20font-weight%3A%20800%3B%20">%09%09'+item.PM25+'%09%09<%2Ftext>%09<%2Fsvg>',
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


               /*marker.addListener('mouseover', function() {
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
             });
           }
         });



         /*$.ajax({
           url: "echarts/getvocobservation",
           type: "POST",
           dataType: "json",
           cache: false,
           success: function(data) {
             data.splice(1,1); //B
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
                 if(currentInfoWindow!=null)
                   currentInfoWindow.close();
                 var tmp_infowindow = new google.maps.InfoWindow({
                   content: contentString
                 });
                 tmp_infowindow.open(map, marker);
                 google.maps.event.addListener(tmp_infowindow, 'domready', function(){
                   showVOCsChart(item.observationName);
                 });
                 currentInfoWindow = tmp_infowindow;
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
         });*/


         /*$.ajax({
           url: "echarts/getairboxobservation",
           type: "POST",
           dataType: "json",
           cache: false,
           success: function(data) {
             data.map(function(item) {
               data.splice(77,1);
     					//console.log(item);
               var square = {
                 path: 'M -2,-2 2,-2 2,2 -2,2 z', // 'M -2,0 0,-2 2,0 0,2 z' M -2,-2 2,-2 2,2 -2,2 z,M6 0 L3 8 L9 8 z
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
                 title: item.device_id,
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
                   showAirBoxChart(item.device_id);
                 });
                 currentInfoWindow = tmp_infowindow;
               });
             });
           }
         });*/

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

         $.ajax({
           url: "echarts/getloraobservation",
           type: "POST",
           dataType: "json",
           cache: false,
           success: function(data) {

             //data.splice(0,1); //A
             //data.splice(0,3); //B

             data.map(function(item) {
     					//console.log(item);
               /*var triangle = {
                 path: 'M0 -5 L-3 2 L3 2 z', // 'M -2,0 0,-2 2,0 0,2 z'
                 fillColor: changeByPM25(item.PM25),
                 fillOpacity: 0.7,
                 //strokeColor: changeByPM25(item.PM25),
                 strokeWeight: 0,
                 scale: 5.5
               };*/
               var marker = new google.maps.Marker({
                 position: new google.maps.LatLng(item.latitude, item.longitude),
                 /*label: {
                   text: item.PM25
     						},
                 icon: triangle,*/
                 icon: 'data:image/svg+xml;charset=utf-8,%09<svg%20width%3D"35"%20height%3D"35"%20viewBox%3D"-55%20-55%20100%20100"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg">%09%09%09%09<polygon%20points%3D"45%2C50%200%2C-45%20-45%2C50"%20fill%3D"%23'+changeByPM25(item.PM25)+'"%20%2F>%09%09%09<text%20x%3D"0"%20y%3D"25"%09%09%09fill%3D"%23000000"%20text-anchor%3D"middle"%20%09%09%09style%3D"font-size%3A40px%3B%20font-weight%3A%20800%3B%20">%09%09'+item.PM25+'%09%09<%2Ftext>%09<%2Fsvg>',
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
                   fillColor: changeByPM25_over(item.PM25),
                   fillOpacity: 0.7,
                   strokeColor: changeByPM25_over(item.PM25),
                   strokeWeight: 0,
                   scale: 8
                 });
               });*/

               /*marker.addListener('mouseout', function() {
                 this.setIcon({
                   path: google.maps.SymbolPath.FORWARD_OPEN_ARROW,
                   fillColor: changeByPM25(item.PM25),
                   fillOpacity: 0.7,
                   strokeColor: changeByPM25(item.PM25),
                   strokeWeight: 0,
                   scale: 8
                 });
               });*/
             });
           }
         });


         $.ajax({
           url: "echarts/getepaiotobservation",
           type: "POST",
           dataType: "json",
           cache: false,
           success: function(data) {
             data.map(function(item) {
               //data.splice(77,1);
               //console.log(item);
               /*var square = {
                 path: 'M -2,-2 2,-2 2,2 -2,2 z', // 'M -2,0 0,-2 2,0 0,2 z' M -2,-2 2,-2 2,2 -2,2 z,M6 0 L3 8 L9 8 z
                 fillColor: changeByPM25(item.PM25),
                 fillOpacity: 0.7,
                 strokeColor: changeByPM25(item.PM25),
                 strokeWeight: 0,
                 scale: 6.5
               };*/
               var marker = new google.maps.Marker({
                 position: new google.maps.LatLng(item.lat, item.lon),
                 /*label: {
                   text: item.PM25
                 },
                 icon: square,*/
                 icon: 'data:image/svg+xml;charset=utf-8,%09<svg%20width%3D"35"%20height%3D"35"%20viewBox%3D"-55%20-55%2090%2090"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg">%09%09%09%09<rect%20x%3D"-35"%20y%3D"-35"%20width%3D"90"%20height%3D"90"%20fill%3D"%23'+changeByPM25(item.PM25)+'"%20%2F>%09%09%09<text%20x%3D"0"%20y%3D"13"%09%09%09fill%3D"%23000000"%20text-anchor%3D"middle"%20%09%09%09style%3D"font-size%3A35px%3B%20font-weight%3A%20800%3B%20">%09%09'+item.PM25+'%09%09<%2Ftext>%09<%2Fsvg>',
                 title: item.device_id,
                 map: map
               });
               $.unblockUI();
               marker.addListener('click', function() {
                 if(currentInfoWindow!=null)
                   currentInfoWindow.close();
                 var tmp_infowindow = new google.maps.InfoWindow({
                   content: contentString
                 });
                 tmp_infowindow.open(map, marker);
                 google.maps.event.addListener(tmp_infowindow, 'domready', function(){
                   showEPAIoTChart(item.device_id);
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


</body>
</html>
