<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
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

					var DLArray = new Array();
					var XTArray = new Array();
					var SLArray = new Array();
					var ZMArray = new Array();
					var FYArray = new Array();
					data.map(function(item) {
						var temp= new Array;
						var date= item["Date"];
					//console.log(date.split("-")[2]);

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
						//temp.push("良好");
						if(item["SiteName"]=="大里"){
							DLArray.push(temp);
						}else if(item["SiteName"]=="西屯"){
							XTArray.push(temp);
						}else if(item["SiteName"]=="沙鹿"){
							SLArray.push(temp);
						}else if(item["SiteName"]=="忠明"){
							ZMArray.push(temp);
						}else if(item["SiteName"]=="豐原"){
							FYArray.push(temp);
						}
						});
						//console.log(DLArray);
						//console.log(JSON.stringify(DLArray));
						dohihi(DLArray, XTArray, SLArray, ZMArray, FYArray, month, year);
			}
		//});
		});
	}

	function dohihi(DL, XT, SL, ZM, FY, month, year) {
		///
		// Schema:
		// date,AQIindex,SO2,CO,O3,PM10,NO2,等級
		//大里 西屯 沙鹿 忠明 豐原

    var schema = [
        {name: 'date', index: 0, text: '日'},
        {name: 'AQI', index: 1, text: 'AQI指數'},
        {name: 'SO2', index: 2, text: 'SO2'},
        {name: 'CO', index: 3, text: 'CO'},
        {name: 'O3', index: 4, text: 'O3'},
        {name: 'PM10', index: 5, text: 'PM10'},
        {name: 'NO2', index: 6, text: 'NO2'},
        {name: '等級', index: 7, text: '等級'}
    ];
		var schema = [{
				name: 'date',
				index: 0,
				text: '臺中' + year + '年' + month + '月'
			},
			{
				name: 'AQIindex',
				index: 1,
				text: 'AQI'
			},
			{
				name: 'SO2',
				index: 2,
				text: 'SO2'
			},
			{
				name: 'CO',
				index: 3,
				text: ' CO'
			},
			{
				name: 'O3',
				index: 4,
				text: 'O3'
			},
			{
				name: 'PM2.5',
				index: 5,
				text: 'PM2.5'
			},
			{
				name: 'NO2',
				index: 6,
				text: 'NO2'
			},
			{
				name: '等级',
				index: 7,
				text: '等级'
			}
		];

		var lineStyle = {
			normal: {
				width: 1,
				opacity: 0.5
			}
		};
		var colors = ['#c23531','#ca8622', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
		myChart.setOption(option = {
			color: colors,
			backgroundColor: '#333',
			legend: {
				bottom: 30,
				data: ['大里', '西屯', '沙鹿', '忠明', '豐原'],
				itemGap: 20,
				textStyle: {
					color: '#fff',
					fontSize: 14
				}
			},
			tooltip: {
				padding: 10,
				backgroundColor: '#222',
				borderColor: '#777',
				borderWidth: 1,
				formatter: function(obj) {
					var value = obj[0].value;
					return '<div style="border-bottom: 1px solid rgba(255,255,255,.3); font-size: 18px;padding-bottom: 7px;margin-bottom: 7px">' +
						obj[0].seriesName + ' ' + value[0] + '日期：' +
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
			// dataZoom: {
			//     show: true,
			//     orient: 'vertical',
			//     parallelAxisIndex: [0]
			// },
			parallelAxis: [{
					dim: 0,
					name: schema[0].text,
					inverse: true,
					max: 31,
					nameLocation: 'start'
				},
				{
					dim: 1,
					name: schema[1].text
				},
				{
					dim: 2,
					name: schema[2].text
				},
				{
					dim: 3,
					name: schema[3].text
				},
				{
					dim: 4,
					name: schema[4].text
				},
				{
					dim: 5,
					name: schema[5].text
				},
				{
					dim: 6,
					name: schema[6].text
				},
				{
					dim: 7,
					name: schema[7].text,
					type: 'category',
					data: ['良好', '普通', '對敏感族群不良', '對所有族群不良', '非常不良有害', '有害']
				}
			],
			visualMap: {
				show: false,
				min: 0,
				max: 150,
				dimension: 3,
				inRange: {
					//color: ['#d94e5d', '#eac736', '#50a3ba'].reverse(),
					// colorAlpha: [0, 1]
				}
			},
			parallel: {
				left: '5%',
				right: '18%',
				bottom: 100,
				parallelAxisDefault: {
					type: 'value',
					name: 'AQI指數',
					nameLocation: 'end',
					nameGap: 20,
					nameTextStyle: {
						color: '#fff',
						fontSize: 12
					},
					axisLine: {
						lineStyle: {
							color: '#aaa'
						}
					},
					axisTick: {
						lineStyle: {
							color: '#777'
						}
					},
					splitLine: {
						show: false
					},
					axisLabel: {
						textStyle: {
							color: '#fff'
						}
					}
				}
			},
			series: [{
					name: '大里',
					type: 'parallel',
					lineStyle: lineStyle,
					data: DL
				},
				{
					name: '西屯',
					type: 'parallel',
					lineStyle: lineStyle,
					data: XT
				},
				{
					name: '沙鹿',
					type: 'parallel',
					lineStyle: lineStyle,
					data: SL
				},
				{
					name: '忠明',
					type: 'parallel',
					lineStyle: lineStyle,
					data: ZM
				},
				{
					name: '豐原',
					type: 'parallel',
					lineStyle: lineStyle,
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
