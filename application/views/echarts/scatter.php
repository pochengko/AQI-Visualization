<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<style>
  .demo.button input {
    margin-right: 2px;
  }

  .demo.button .ui-button-text {
    padding: .4em .6em;
    line-height: 0.8;
  }
</style>

<link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="/public/css/MonthPicker.min.css" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdn.rawgit.com/digitalBush/jquery.maskedinput/1.4.1/dist/jquery.maskedinput.min.js"></script>

<script src="/public/js/MonthPicker.min.js"></script>
<div class="container-fluid" style="background-color:#404a59;">
  <p class="demo">
    <h5 style="color:white">Choose a Month:
    <input id="IconDemo" class='Default' type="text" hidden/>
  </h5>
  </p>
</div>
<div id="main" class="container-fluid text-center" style="max-width: 100%;height:100%;"></div>

<script type="text/javascript">
  // 基于准备好的dom，初始化echarts实例

  var myChart;

  $(document).ready(function() {
    myChart = echarts.init(document.getElementById('main'));
    var dataAllMap = new Map();
    var today = new Date();
    var thismonth = (today.getMonth()+1);
    var thisyear = today.getFullYear();

    $('.Default').MonthPicker({
      OnAfterChooseMonth: function() {
        getData($(this).val().split("/")[0], $(this).val().split("/")[1]);
      }
    });
    console.log(thismonth);
    getData(thismonth, thisyear);
  });

  function getData(month, year) {
    $.ajax({
      url: "echarts/getdailydatatc",
      type: "POST",
      data: {
        selectMonth: month,
        selectYear: year
      },
      dataType: "json",
      cache: false,
      success: function(data) {
        //console.log(data);
        if (data != "") {
          var DLArray = new Array();
          var XTArray = new Array();
          var SLArray = new Array();
          var ZMArray = new Array();
          var FYArray = new Array();

          data.map(function(item) {
            var temp = new Array;
            var date = item["Date"];
            temp.push(date.split("-")[2]);
            temp.push(item["AQI"]);
            temp.push(item["SO2"]);
            temp.push(item["CO"]);
            temp.push(item["O3"]);
            temp.push(item["PM25"]);
            temp.push(item["NO2"]);
            if (item["AQI"] <= 50) {
              temp.push("良好");
            } else if (item["AQI"] > 50 && item["AQI"] <= 100) {
              temp.push("普通");
            } else if (item["AQI"] > 100 && item["AQI"] <= 150) {
              temp.push("對敏感族群不良");
            } else if (item["AQI"] > 150 && item["AQI"] <= 200) {
              temp.push("對所有族群不良");
            } else if (item["AQI"] > 200 && item["AQI"] <= 300) {
              temp.push("非常不良有害");
            } else if (item["AQI"] > 300) {
              temp.push("有害");
            }

            if (item["SiteName"] == "大里") {
              DLArray.push(temp);
            } else if (item["SiteName"] == "西屯") {
              XTArray.push(temp);
            } else if (item["SiteName"] == "沙鹿") {
              SLArray.push(temp);
            } else if (item["SiteName"] == "忠明") {
              ZMArray.push(temp);
            } else if (item["SiteName"] == "豐原") {
              FYArray.push(temp);
            }
          });
          dohihi(DLArray, XTArray, SLArray, ZMArray, FYArray, month, year);
        } else {
          alert("There's no data.");
        }
      }
    });
  }

  function dohihi(DL, XT, SL, ZM, FY, month, year) {
    ///
    // Schema:
    // date,AQIindex,SO2,CO,O3,PM10,NO2,等級
    //大里 西屯 沙鹿 忠明 豐原

    var schema = [{
        name: 'date',
        index: 0,
        text: '日'
      },
      {
        name: 'AQI',
        index: 1,
        text: 'AQI指數'
      },
      {
        name: 'SO2',
        index: 2,
        text: 'SO2'
      },
      {
        name: 'CO',
        index: 3,
        text: 'CO'
      },
      {
        name: 'O3',
        index: 4,
        text: 'O3'
      },
      {
        name: 'PM25',
        index: 5,
        text: 'PM2.5'
      },
      {
        name: 'NO2',
        index: 6,
        text: 'NO2'
      },
      {
        name: '等級',
        index: 7,
        text: '等級'
      }
    ];
    var itemStyle = {
      normal: {
        opacity: 0.8,
        shadowBlur: 10,
        shadowOffsetX: 0,
        shadowOffsetY: 0,
        shadowColor: 'rgba(0, 0, 0, 0.5)'
      }
    };
    var colors = ['#c23531', '#ca8622', '#61a0a8', '#d48265', '#91c7ae', '#749f83', '#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3'];
    myChart.setOption(option = {
      title: {
        text: '臺中' + year + '年' + month + '月',
        textStyle: {
          color: '#FFF'
        }
      },
      color: colors,
      backgroundColor: '#404a59',

      legend: {
        y: 'top',
        data: ['大里', '西屯', '沙鹿', '忠明', '豐原'],
        textStyle: {
          color: '#fff',
          fontSize: 16
        }
      },
      grid: {
        x: '10%',
        x2: 150,
        y: '18%',
        y2: '10%'
      },
      dataZoom: [{
        type: 'inside'
      }],
      tooltip: {
        padding: 10,
        backgroundColor: '#222',
        borderColor: '#777',
        borderWidth: 1,
        formatter: function(obj) {
          var value = obj.value;
          return '<div style="border-bottom: 1px solid rgba(255,255,255,.3); font-size: 18px;padding-bottom: 7px;margin-bottom: 7px">' +
            obj.seriesName + ' ' + value[0] + '日：' +
            value[7] +
            '</div>' +
            schema[1].text + '：' + value[1] + '<br>' +
            schema[2].text + '：' + value[2] + '<br>' +
            schema[3].text + '：' + value[3] + '<br>' +
            schema[4].text + '：' + value[4] + '<br>' +
            schema[5].text + '：' + value[5] + '<br>' +
            schema[6].text + '：' + value[6] + '<br>';
        }
      },
      xAxis: {
        type: 'value',
        name: '日期',
        nameGap: 16,
        nameTextStyle: {
          color: '#fff',
          fontSize: 14
        },
        max: 31,
        splitLine: {
          show: false
        },
        axisLine: {
          lineStyle: {
            color: '#eee'
          }
        }
      },
      yAxis: {
        type: 'value',
        name: 'AQI指數',
        nameLocation: 'end',
        nameGap: 20,
        nameTextStyle: {
          color: '#fff',
          fontSize: 16
        },
        axisLine: {
          lineStyle: {
            color: '#eee'
          }
        },
        splitLine: {
          show: false
        }
      },
      visualMap: [{
          left: 'right',
          top: '10%',
          dimension: 5,
          min: 0,
          max: 60,
          itemWidth: 30,
          itemHeight: 120,
          calculable: true,
          precision: 0.1,
          text: ['圓形大小：PM2.5'],
          textGap: 30,
          textStyle: {
            color: '#fff'
          },
          inRange: {
            symbolSize: [10, 100]
          },
          outOfRange: {
            symbolSize: [10, 100],
            color: ['rgba(255,255,255,.2)']
          },
          controller: {
            inRange: {
              color: ['#c23531']
            },
            outOfRange: {
              color: ['#444']
            }
          }
        },
        {
          left: 'right',
          bottom: '5%',
          dimension: 2,
          min: 0,
          max: 10,
          itemHeight: 120,
          calculable: true,
          precision: 0.1,
          text: ['明暗：O3'],
          textGap: 30,
          textStyle: {
            color: '#fff'
          },
          inRange: {
            colorLightness: [1, 0.3]
          },
          outOfRange: {
            color: ['rgba(255,255,255,.2)']
          },
          controller: {
            inRange: {
              color: ['#c23531']
            },
            outOfRange: {
              color: ['#444']
            }
          }
        }
      ],
      series: [{
          name: '大里',
          type: 'scatter',
          itemStyle: itemStyle,
          data: DL
        },
        {
          name: '西屯',
          type: 'scatter',
          itemStyle: itemStyle,
          data: XT
        },
        {
          name: '沙鹿',
          type: 'scatter',
          itemStyle: itemStyle,
          data: SL
        },
        {
          name: '忠明',
          type: 'scatter',
          itemStyle: itemStyle,
          data: ZM
        },
        {
          name: '豐原',
          type: 'scatter',
          itemStyle: itemStyle,
          data: FY
        }
      ]

    });
    window.onresize = function() {
      myChart.resize();
    };
    ///
  }
</script>
