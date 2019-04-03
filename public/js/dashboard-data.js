var graph_data = [];
$.ajax({
	type: 'GET',
	url: '/get_graph_reports',
	data: {
		_token: '{!! csrf_token() !!}'
   },
	success: function(response) {
		//console.log(response);
		graph_data = JSON.parse(response);
		var dom = document.getElementById("e_chart_1");
		var myChart = echarts.init(dom);
		var app = {};
		option = null;
		var posList = [
			'left', 'right', 'top', 'bottom',
			'inside',
			'insideTop', 'insideLeft', 'insideRight', 'insideBottom',
			'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
		];
		
		
		app.configParameters = {
			rotate: {
				min: -90,
				max: 90
			},
			align: {
				options: {
					left: 'left',
					center: 'center',
					right: 'right'
				}
			},
			verticalAlign: {
				options: {
					top: 'top',
					middle: 'middle',
					bottom: 'bottom'
				}
			},
			position: {
				options: echarts.util.reduce(posList, function (map, pos) {
					map[pos] = pos;
					return map;
				}, {})
			},
			distance: {
				min: 0,
				max: 100
			}
		};
		
		app.config = {
			rotate: 90,
			align: 'left',
			verticalAlign: 'middle',
			position: 'insideBottom',
			distance: 15,
			onChange: function () {
				var labelOption = {
					normal: {
						rotate: app.config.rotate,
						align: app.config.align,
						verticalAlign: app.config.verticalAlign,
						position: app.config.position,
						distance: app.config.distance
					}
				};
				myChart.setOption({
					series: [{
						label: labelOption
					}, {
						label: labelOption
					}, {
						label: labelOption
					}, {
						label: labelOption
					}]
				});
			}
		};
		
		
		var labelOption = {
			normal: {
				show: true,
				position: app.config.position,
				distance: app.config.distance,
				align: app.config.align,
				verticalAlign: app.config.verticalAlign,
				rotate: app.config.rotate,
				formatter: '{c} ',
				//formatter: '{c}  {name{a}}',
				fontSize: 10,
				rich: {
					name: {
						textBorderColor: '#fff',
		
					}
				}
			}
		};
		
		
		
		
		option = {
			color: ['#143b79', '#606060', '#fbd439', '#bdbdbd', '#282828'],
			tooltip: {
				trigger: 'axis',
				backgroundColor: 'rgba(33,33,33,1)',
				borderRadius: 0,
				padding: 5,
				axisPointer: {
					type: 'cross',
					label: {
						backgroundColor: 'rgba(33,33,33,1)'
					}
				},
				textStyle: {
					color: '#fff',
					fontStyle: 'normal',
					fontWeight: 'normal',
					fontFamily: "'Roboto', sans-serif",
					fontSize: 12
				}
			},
			legend: {
				data: ['Same Day Delivery', 'Over Night Delivery', 'Next Day Delivery', 'Over Land Delivery']
			},
			toolbox: {
				show: false,
				orient: 'vertical',
				left: 'right',
				padding: 0,
				margin: 0,
				top: 'center',
				feature: {
					mark: {
						show: true
					},
					dataView: {
						show: true,
						readOnly: true
					},
					magicType: {
						show: true,
						type: ['line', 'bar', 'stack', 'tiled']
					},
					restore: {
						show: true
					},
					saveAsImage: {
						show: false
					}
				}
			},
			grid: {
				left: '0',
				right: '0',
				top: '35px',
				bottom: '0',
				containLabel: true
			},
			calculable: true,
			type: 'value',
			axisLine: {
				show: true
			},
			xAxis: [{
					type: 'category',
					axisTick: {
						show: true
					},
					data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
					axisLine: {
						show: true
					},
					axisLabel: {
						textStyle: {
							color: '#a0a0a0'
						}
					},
				}
		
			],
		
			yAxis: [{
				type: 'value',
				axisLine: {
					show: true
				},
				axisLabel: {
					textStyle: {
						color: '#a0a0a0'
					}
				},
				splitLine: {
					show: true,
				}
			}],
			series: [{
				name: 'Same Day Delivery',
				type: 'bar',
				barGap: 0,
				label: labelOption,
				data: [graph_data.type1Monday, graph_data.type1Tuesday, graph_data.type1Wednesday, graph_data.type1Thursday, graph_data.type1Friday, graph_data.type1Saturday, graph_data.type1Sunday]
			}, {
				name: 'Over Night Delivery',
				type: 'bar',
				label: labelOption,
				data: [graph_data.type2Monday, graph_data.type2Tuesday, graph_data.type2Wednesday, graph_data.type2Thursday, graph_data.type2Friday, graph_data.type2Saturday, graph_data.type2Sunday]
			}, {
				name: 'Next Day Delivery',
				type: 'bar',
				label: labelOption,
				data: [graph_data.type3Monday, graph_data.type3Tuesday, graph_data.type3Wednesday, graph_data.type3Thursday, graph_data.type3Friday,graph_data.type3Saturday, graph_data.type3Sunday]
			}, {
				name: 'Over Land Delivery',
				type: 'bar',
				label: labelOption,
				data: [graph_data.type4Monday, graph_data.type4Tuesday, graph_data.type4Wednesday, graph_data.type4Thursday, graph_data.type4Friday, graph_data.type4Saturday, graph_data.type4Sunday]
			}]
		};
		if (option && typeof option === "object") {
			myChart.setOption(option, true);
		}
	}
});


