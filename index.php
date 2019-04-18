<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Server load stats</title>
		<script src="smoothie.js"></script>
		<script src="microajax.minified.js"></script>
		<style>body { font-family: corbel; margin: 0px; padding: 0px; overflow: hidden; } div#info { position: absolute; top: 10px; left: 10px; background: rgba(255, 255, 255, 0.25); padding: 10px;} h1 { color: white; font-family: Corbel; } }</style>
	</head>
	<body>
		<div id="info">
			<h1>Server load stats</h1>
			<legend>
				<span style="color: lime;">RAM usage</span><br>
				<span style="color: red;">CPU usage</span><br>
				<span style="color: cyan;">System load (CPU + IO)</span>
			</legend>
		</div>
		<canvas id="load_chart" width="400" height="100"></canvas>
		<script>
var smoothie = new SmoothieChart({millisPerPixel: 50});
smoothie.streamTo(document.getElementById("load_chart"), 1000 /*delay*/); 
		
// Data
var memory = new TimeSeries();
var cpu = new TimeSeries();
var load = new TimeSeries();
var full = new TimeSeries();
var ull = new TimeSeries();

setInterval(function() {
	microAjax("get_server_load.php", function (res) {
		if (res != "") {
		cpu_load = res.split(';')[0];
		memory_usage = res.split(';')[1];
		load_average = res.split(';')[2];
		cpu.append(new Date().getTime(), parseFloat(cpu_load));
		memory.append(new Date().getTime(), parseFloat(memory_usage));
		load.append(new Date().getTime(), parseFloat(load_average));
		full.append(new Date().getTime(), 100);
		ull.append(new Date().getTime(), 0);
		} else alert("Connection lost1");
	});
}, 1000);

// Add to SmoothieChart
smoothie.addTimeSeries(memory, 
{ strokeStyle:'rgb(0, 255, 0)', fillStyle:'rgba(0, 255, 0, 0.4)', lineWidth:3 });
smoothie.addTimeSeries(cpu,
{ strokeStyle:'rgb(255, 0, 0)', fillStyle:'rgba(0, 0, 0, 0.4)', lineWidth:3 });
smoothie.addTimeSeries(load,
{ strokeStyle:'rgb(0, 255, 255)', fillStyle:'rgba(0, 0, 0, 0.4)', lineWidth:3 });
smoothie.addTimeSeries(full,
{ strokeStyle:'rgba(0, 0, 0, 0)', fillStyle:'rgba(0, 0, 0, 0.0)', lineWidth:0 });
smoothie.addTimeSeries(ull,
{ strokeStyle:'rgba(0, 0, 0, 0)', fillStyle:'rgba(0, 0, 0, 0.0)', lineWidth:0 });


var canvas = document.getElementById("load_chart");
 
/* Rresize the canvas to occupy the full page, 
   by getting the widow width and height and setting it to canvas*/
 
canvas.width  = window.innerWidth;
canvas.height = window.innerHeight;
window.onresize = function() {
canvas.width  = window.innerWidth;
canvas.height = window.innerHeight;
}
		</script>
	</body>
</html>