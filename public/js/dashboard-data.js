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
		show: true,
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
		right: '7%',
		top: '40px',
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
			data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
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
		data: [320, 332, 301, 334, 390, 330, 320]
	}, {
		name: 'Over Night Delivery',
		type: 'bar',
		label: labelOption,
		data: [120, 132, 101, 134, 90, 230, 210]
	}, {
		name: 'Next Day Delivery',
		type: 'bar',
		label: labelOption,
		data: [220, 182, 191, 234, 290, 330, 310]
	}, {
		name: 'Over Land Delivery',
		type: 'bar',
		label: labelOption,
		data: [120, 182, 75, 104, 190, 230, 220]
	}, {
		name: 'Revenue',
		type: 'line',
		label: labelOption,
		data: [50, 142, 130, 155, 90, 180, 200]
	}]
};;
if (option && typeof option === "object") {
	myChart.setOption(option, true);
}

