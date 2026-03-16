import ApexCharts from 'apexcharts'
/* Apexcharts (#bar) */
export function indexbar(myVarVal, hexToRgba) {
	var optionsBar = {
		chart: {
			height: 249,
			responsive: 'true',
			type: 'bar',
			toolbar: {
				show: false,
			},
			fontFamily: 'Nunito, sans-serif',
		},
		colors: [myVarVal, '#f93a5a', '#f7a556'],
		plotOptions: {
			bar: {
				dataLabels: {
					enabled: false
				},
				columnWidth: '42%',
				endingShape: 'rounded',
			}
		},
		dataLabels: {
			enabled: false
		},
		grid: {
			show: true,
			borderColor: '#f3f3f3',
		},
		stroke: {
			show: true,
			width: 2,
			endingShape: 'rounded',
			colors: ['transparent'],
		},
		responsive: [{
			enable: 'true',
			breakpoint: 576,
			options: {
				stroke: {
					show: true,
					width: 1,
					endingShape: 'rounded',
					colors: ['transparent'],
				},
			},

		}],
		series: [{
			name: 'Impressions',
			data: [74, 85, 57, 56, 76, 35, 61, 98, 36, 50, 48, 29]
		}, {
			name: 'Turnover',
			data: [46, 35, 101, 98, 44, 55, 57, 56, 55, 34, 79, 46]
		}, {
			name: 'In progress',
			data: [26, 35, 41, 78, 34, 65, 27, 46, 37, 65, 49, 23]
		}],
		xaxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		},
		fill: {
			opacity: 1
		},
		legend: {
			show: false,
			floating: true,
			position: 'top',
			horizontalAlign: 'left',


		},

		tooltip: {
			y: {
				formatter: function (val) {
					return "$ " + val + " thousands"
				}
			}
		}
	}
	document.querySelector('#bar').innerHTML = ""
	new ApexCharts(document.querySelector('#bar'), optionsBar).render();
}
/*closed Apex charts(#bar)*/

/*--- Map ---*/
export function vectormap(myVarVal, hexToRgba) {

	document.querySelector('#vmap12').innerHTML = ""
	$('#vmap12').vectorMap({
		map: 'usa_en',
		showTooltip: true,
		backgroundColor: '#fff',
		color: myVarVal,
		colors: {
			mo: 'rgba(247,165,86,1)',
			fl: hexToRgba(myVarVal,0.6),
			or: 'rgba(249,58,90,1)',
			ca: hexToRgba(myVarVal,0.5),
			tx: 'rgba(247,165,86,1)',
			wy: hexToRgba(myVarVal,0.4),
			ny: 'rgba(249,58,90,1)',
		},
		hoverColor: '#222',
		enableZoom: false,
		borderWidth: 1,
		borderColor: '#fff',
		hoverOpacity: .85
	});
}
/*--- Map closed ---*/

/*--- Apex (#chart) ---*/
export function indexchart(myVarVal, hexToRgba){

	var options = {
		chart: {
			width: 200,
			height: 205,
			responsive: 'true',
			reset: 'true',
			type: 'radialBar',
			offsetX: 0,
			offsetY: 0,
		},
		plotOptions: {
			radialBar: {
				responsive: 'true',
				startAngle: -135,
				endAngle: 135,
				size: 120,
				imageWidth: 50,
				imageHeight: 50,

				track: {
					strokeWidth: "80%",
					background: '#ecf0fa',
				},
				dropShadow: {
					enabled: false,
					top: 0,
					left: 0,
					bottom: 0,
					blur: 3,
					opacity: 0.5
				},
				dataLabels: {
					name: {
						fontSize: '16px',
						color: undefined,
						offsetY: 30,
					},
					hollow: {
						size: "60%"
					},
					value: {
						offsetY: -10,
						fontSize: '22px',
						color: undefined,
						formatter: function (val) {
							return val + "%";
						}
					}
				}
			}
		},
		colors: ['#0db2de'],
		fill: {
			type: "gradient",
			gradient: {
				shade: "dark",
				type: "horizontal",
				shadeIntensity: .5,
				gradientToColors: [myVarVal],
				inverseColors: !0,
				opacityFrom: 1,
				opacityTo: 1,
				stops: [0, 100]
			}
		},
		stroke: {
			dashArray: 4
		},
		series: [83],
		labels: [""]
	};

	document.querySelector('#chart').innerHTML = ""
	var chart = new ApexCharts(document.querySelector("#chart"), options);
	chart.render();
}
/*--- Apex (#chart)closed ---*/