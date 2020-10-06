<!DOCTYPE html>
<html>
<head>
  <base href="<?php echo base_url();?>"/>
    <title><?php echo $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/img/icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts.min.js" ></script>
</head>
<body>

<!--<div id="main" class="container-fluid text-center" style="max-width: 100%;height:720px;"></div>-->

<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div class="container-fluid text-center">
  <div class="row content">
    <div id="main" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main2" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main3" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main4" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main5" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main6" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main7" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main8" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main9" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main10" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <div id="main11" class="col-xs-12 col-sm-3" style="height:260px;"></div>
    <script type="text/javascript">
    	// 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    var myChart2 = echarts.init(document.getElementById('main2'));
    var myChart3 = echarts.init(document.getElementById('main3'));
    var myChart4 = echarts.init(document.getElementById('main4'));
    var myChart5 = echarts.init(document.getElementById('main5'));
    var myChart6 = echarts.init(document.getElementById('main6'));
    var myChart7 = echarts.init(document.getElementById('main7'));
    var myChart8 = echarts.init(document.getElementById('main8'));
    var myChart9 = echarts.init(document.getElementById('main9'));
    var myChart10 = echarts.init(document.getElementById('main10'));
    var myChart11 = echarts.init(document.getElementById('main11'));
    var dataAllMap = new Map();
    	$(document).ready(function(){
        $.ajax({
            url: "echarts/getloraobservation",
            type: "POST",
            dataType: "json",
            cache: false,
            success: function(data) {
              console.log(data);
    					getobserve(data);
            }
        });
    	});

      function getobserve(Ldata) {
        $.ajax({
          url: "echarts/getobservation",
          type: "POST",
          dataType: "json",
          cache: false,
          success: function(data) {
            console.log(data);
            getTHU(Ldata, data);
          }
        });
      }

      function getTHU(Ldata, Tdata) {
        $.ajax({
          url: "echarts/getabtcobservation",
          type: "POST",
          dataType: "json",
          cache: false,
          success: function(data) {
            console.log(data);
            showChart(Ldata, Tdata, data);
          }
        });
      }

    function showChart(Ldata, Tdata, data) {
        myChart.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '科技大樓4樓',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[0].PM25, name: '科技大樓4樓'}]
            }
          ]
        });

        myChart2.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '科技大樓3樓',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[1].PM25, name: '科技大樓3樓'}]
            }
          ]
        });

        myChart3.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '相思林(開關箱)',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[2].PM25, name: '相思林(開關箱)'}]
            }
          ]
        });

        myChart4.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '景觀系館2樓',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[3].PM25, name: '景觀系館2樓'}]
            }
          ]
        });
        myChart5.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '人文科技館',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[4].PM25, name: '人文科技館'}]
            }
          ]
        });
        myChart6.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '基科館6樓',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[5].PM25, name: '基科館6樓'}]
            }
          ]
        });
        myChart7.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '科技大樓7樓',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[6].PM25, name: '科技大樓7樓'}]
            }
          ]
        });
        myChart8.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '新景觀系館',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Ldata[7].PM25, name: '新景觀系館'}]
            }
          ]
        });
        myChart9.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: Tdata[86].observationName,
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Tdata[86].PM25, name: Tdata[86].observationName}]
            }
          ]
        });
        myChart10.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: Tdata[88].observationName,
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: Tdata[88].PM25, name: Tdata[88].observationName}]
            }
          ]
        });

        myChart11.setOption(option = {
          tooltip : {
            formatter: "{a} <br/>PM2.5 : {c}"
          },
          series: [
            {
              name: '電算中心',
              type: 'gauge',
              min:0,
              max:250,
              radius: '100%',
              axisLine: {
                lineStyle: {
                  color: [[0.06, '#27a52d'],[0.14, '#ecec00'],[0.22, '#FF7C19'],[0.6, '#f22f0d'],[1, '#BC1049']],
                  width: 10
                }
              },
              axisTick: {
                length: 15,
                lineStyle: { color: 'auto' }
              },
              splitLine: {
                length: 20,
                lineStyle: { color: 'auto' }
              },
              detail: {formatter:'{value}'},
              title : {
                fontWeight: 'bolder',
                fontSize: 25
              },
              data: [{value: data[44].pm25, name: '電算中心'}]
            }
          ]
        });


    		window.onresize = function() {
          myChart.resize();
          myChart2.resize();
          myChart3.resize();
          myChart4.resize();
          myChart5.resize();
          myChart6.resize();
          myChart7.resize();
          myChart8.resize();
          myChart9.resize();
          myChart10.resize();
          myChart11.resize();
        };
    	}
    </script>
  </div>
</div>

</body>
</html>
